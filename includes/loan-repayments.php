<?php
/**
 * Loan Repayment Management System
 * Handles loan schedules, payments, and delinquency tracking
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate loan repayment schedule upon disbursement
 */
function daystar_generate_loan_schedule($loan_id) {
    global $wpdb;
    
    $loan = daystar_get_loan_by_id($loan_id);
    if (!$loan) {
        return false;
    }
    
    // Clear any existing schedule
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $wpdb->delete($schedules_table, array('loan_id' => $loan_id));
    
    $principal = $loan->amount;
    $annual_rate = $loan->interest_rate / 100;
    $monthly_rate = $annual_rate / 12;
    $term_months = $loan->term_months;
    $monthly_payment = $loan->monthly_payment;
    
    $remaining_balance = $principal;
    $start_date = $loan->disbursed_date ? $loan->disbursed_date : $loan->loan_date;
    
    for ($i = 1; $i <= $term_months; $i++) {
        // Calculate due date (first payment due one month after disbursement)
        $due_date = date('Y-m-d', strtotime($start_date . " +{$i} months"));
        
        // Calculate interest for this period
        $interest_payment = $remaining_balance * $monthly_rate;
        
        // Calculate principal payment
        $principal_payment = $monthly_payment - $interest_payment;
        
        // Ensure we don't overpay on the last installment
        if ($i == $term_months) {
            $principal_payment = $remaining_balance;
            $total_payment = $principal_payment + $interest_payment;
        } else {
            $total_payment = $monthly_payment;
        }
        
        // Insert schedule entry
        $wpdb->insert(
            $schedules_table,
            array(
                'loan_id' => $loan_id,
                'installment_number' => $i,
                'due_date' => $due_date,
                'expected_principal' => round($principal_payment, 2),
                'expected_interest' => round($interest_payment, 2),
                'expected_total' => round($total_payment, 2),
                'status' => 'due'
            ),
            array('%d', '%d', '%s', '%f', '%f', '%f', '%s')
        );
        
        // Update remaining balance
        $remaining_balance -= $principal_payment;
        
        // Prevent negative balance due to rounding
        if ($remaining_balance < 0.01) {
            $remaining_balance = 0;
        }
    }
    
    return true;
}

/**
 * Process loan payment and update schedule
 */
function daystar_process_loan_payment($loan_id, $amount, $payment_method = 'bank_transfer', $reference_number = '', $notes = '', $is_payroll = false) {
    global $wpdb;
    
    $loan = daystar_get_loan_by_id($loan_id);
    if (!$loan || $loan->status !== 'active') {
        return array('success' => false, 'message' => 'Invalid or inactive loan');
    }
    
    if ($amount <= 0) {
        return array('success' => false, 'message' => 'Invalid payment amount');
    }
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Start transaction
    $wpdb->query('START TRANSACTION');
    
    try {
        // Get unpaid/partially paid installments in order
        $unpaid_installments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$schedules_table} 
             WHERE loan_id = %d AND status IN ('due', 'overdue', 'partially_paid') 
             ORDER BY installment_number ASC",
            $loan_id
        ));
        
        if (empty($unpaid_installments)) {
            throw new Exception('No outstanding installments found');
        }
        
        $remaining_payment = $amount;
        $total_principal_paid = 0;
        $total_interest_paid = 0;
        $installments_updated = array();
        
        foreach ($unpaid_installments as $installment) {
            if ($remaining_payment <= 0) {
                break;
            }
            
            $outstanding_amount = $installment->expected_total - $installment->amount_paid;
            $payment_for_installment = min($remaining_payment, $outstanding_amount);
            
            // Calculate principal and interest portions
            $outstanding_principal = $installment->expected_principal - ($installment->amount_paid * ($installment->expected_principal / $installment->expected_total));
            $outstanding_interest = $installment->expected_interest - ($installment->amount_paid * ($installment->expected_interest / $installment->expected_total));
            
            $principal_portion = min($payment_for_installment * ($installment->expected_principal / $installment->expected_total), $outstanding_principal);
            $interest_portion = $payment_for_installment - $principal_portion;
            
            $new_amount_paid = $installment->amount_paid + $payment_for_installment;
            $new_status = ($new_amount_paid >= $installment->expected_total) ? 'paid' : 'partially_paid';
            
            // Update installment
            $wpdb->update(
                $schedules_table,
                array(
                    'amount_paid' => $new_amount_paid,
                    'status' => $new_status,
                    'payment_date' => current_time('mysql'),
                    'days_overdue' => 0
                ),
                array('schedule_id' => $installment->schedule_id),
                array('%f', '%s', '%s', '%d'),
                array('%d')
            );
            
            $total_principal_paid += $principal_portion;
            $total_interest_paid += $interest_portion;
            $remaining_payment -= $payment_for_installment;
            
            $installments_updated[] = array(
                'installment_number' => $installment->installment_number,
                'amount_paid' => $payment_for_installment,
                'new_status' => $new_status
            );
        }
        
        // Handle overpayment (early payment scenario)
        if ($remaining_payment > 0) {
            // Apply to future installments or adjust loan balance
            daystar_handle_overpayment($loan_id, $remaining_payment);
        }
        
        // Record payment in payments table
        $receipt_path = null;
        if (!$is_payroll) {
            $receipt_path = daystar_generate_payment_receipt($loan_id, $amount, $payment_method, $reference_number);
        }
        
        $payment_id = $wpdb->insert(
            $payments_table,
            array(
                'loan_id' => $loan_id,
                'user_id' => $loan->user_id,
                'amount' => $amount,
                'principal_amount' => $total_principal_paid,
                'interest_amount' => $total_interest_paid,
                'payment_date' => current_time('mysql'),
                'payment_method' => $payment_method,
                'reference_number' => $reference_number,
                'status' => 'completed',
                'notes' => $notes,
                'receipt_path' => $receipt_path,
                'is_payroll_deduction' => $is_payroll ? 1 : 0
            ),
            array('%d', '%d', '%f', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%d')
        );
        
        // Update loan balance
        $new_balance = max(0, $loan->balance - $total_principal_paid);
        $wpdb->update(
            $loans_table,
            array('balance' => $new_balance),
            array('id' => $loan_id),
            array('%f'),
            array('%d')
        );
        
        // Check if loan is fully paid
        if ($new_balance <= 0.01) {
            $wpdb->update(
                $loans_table,
                array('status' => 'completed'),
                array('id' => $loan_id),
                array('%s'),
                array('%d')
            );
            
            // Mark all remaining installments as paid
            $wpdb->update(
                $schedules_table,
                array('status' => 'paid', 'payment_date' => current_time('mysql')),
                array('loan_id' => $loan_id, 'status' => 'due'),
                array('%s', '%s'),
                array('%d', '%s')
            );
        }
        
        // Record credit history
        daystar_record_credit_event(
            $loan->user_id,
            $loan_id,
            'payment_made',
            $amount,
            "Payment of KES " . number_format($amount, 2) . " received",
            5 // Positive credit impact
        );
        
        // Send notification
        daystar_send_payment_notification($loan->user_id, $loan_id, $amount, $installments_updated);
        
        $wpdb->query('COMMIT');
        
        return array(
            'success' => true,
            'message' => 'Payment processed successfully',
            'payment_id' => $payment_id,
            'receipt_path' => $receipt_path,
            'installments_updated' => $installments_updated,
            'new_loan_balance' => $new_balance
        );
        
    } catch (Exception $e) {
        $wpdb->query('ROLLBACK');
        return array('success' => false, 'message' => $e->getMessage());
    }
}

/**
 * Handle overpayment scenarios
 */
function daystar_handle_overpayment($loan_id, $overpayment_amount) {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    // Get future unpaid installments
    $future_installments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$schedules_table} 
         WHERE loan_id = %d AND status = 'due' 
         ORDER BY installment_number ASC",
        $loan_id
    ));
    
    $remaining_overpayment = $overpayment_amount;
    
    foreach ($future_installments as $installment) {
        if ($remaining_overpayment <= 0) {
            break;
        }
        
        $payment_for_installment = min($remaining_overpayment, $installment->expected_total);
        
        // Calculate principal and interest portions
        $principal_portion = $payment_for_installment * ($installment->expected_principal / $installment->expected_total);
        $interest_portion = $payment_for_installment - $principal_portion;
        
        $new_status = ($payment_for_installment >= $installment->expected_total) ? 'paid' : 'partially_paid';
        
        // Update installment
        $wpdb->update(
            $schedules_table,
            array(
                'amount_paid' => $payment_for_installment,
                'status' => $new_status,
                'payment_date' => current_time('mysql')
            ),
            array('schedule_id' => $installment->schedule_id),
            array('%f', '%s', '%s'),
            array('%d')
        );
        
        $remaining_overpayment -= $payment_for_installment;
    }
    
    // If there's still overpayment, it could be applied to reduce future interest
    // This would require recalculating the entire schedule
    if ($remaining_overpayment > 0) {
        daystar_recalculate_loan_schedule($loan_id, $remaining_overpayment);
    }
}

/**
 * Recalculate loan schedule for early payments
 */
function daystar_recalculate_loan_schedule($loan_id, $extra_principal = 0) {
    global $wpdb;
    
    $loan = daystar_get_loan_by_id($loan_id);
    if (!$loan) {
        return false;
    }
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    // Get current loan balance
    $current_balance = $loan->balance - $extra_principal;
    
    if ($current_balance <= 0) {
        // Loan is fully paid, mark all future installments as paid
        $wpdb->update(
            $schedules_table,
            array('status' => 'paid', 'payment_date' => current_time('mysql')),
            array('loan_id' => $loan_id, 'status' => 'due'),
            array('%s', '%s'),
            array('%d', '%s')
        );
        return true;
    }
    
    // Get unpaid installments
    $unpaid_installments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$schedules_table} 
         WHERE loan_id = %d AND status = 'due' 
         ORDER BY installment_number ASC",
        $loan_id
    ));
    
    if (empty($unpaid_installments)) {
        return true;
    }
    
    $monthly_rate = ($loan->interest_rate / 100) / 12;
    $remaining_terms = count($unpaid_installments);
    
    // Recalculate monthly payment for remaining balance
    if ($remaining_terms > 1) {
        $new_monthly_payment = $current_balance * $monthly_rate * pow(1 + $monthly_rate, $remaining_terms) / (pow(1 + $monthly_rate, $remaining_terms) - 1);
    } else {
        $new_monthly_payment = $current_balance * (1 + $monthly_rate);
    }
    
    $remaining_balance = $current_balance;
    
    foreach ($unpaid_installments as $installment) {
        $interest_payment = $remaining_balance * $monthly_rate;
        $principal_payment = $new_monthly_payment - $interest_payment;
        
        // Ensure we don't overpay on the last installment
        if ($installment->installment_number == end($unpaid_installments)->installment_number) {
            $principal_payment = $remaining_balance;
            $total_payment = $principal_payment + $interest_payment;
        } else {
            $total_payment = $new_monthly_payment;
        }
        
        // Update installment
        $wpdb->update(
            $schedules_table,
            array(
                'expected_principal' => round($principal_payment, 2),
                'expected_interest' => round($interest_payment, 2),
                'expected_total' => round($total_payment, 2)
            ),
            array('schedule_id' => $installment->schedule_id),
            array('%f', '%f', '%f'),
            array('%d')
        );
        
        $remaining_balance -= $principal_payment;
        
        if ($remaining_balance < 0.01) {
            $remaining_balance = 0;
            break;
        }
    }
    
    return true;
}

/**
 * Update overdue status for all loans
 */
function daystar_update_overdue_status() {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $today = date('Y-m-d');
    
    // Update days overdue for unpaid installments
    $wpdb->query($wpdb->prepare(
        "UPDATE {$schedules_table} 
         SET days_overdue = DATEDIFF(%s, due_date),
             status = CASE 
                 WHEN DATEDIFF(%s, due_date) > 0 AND status IN ('due', 'overdue') THEN 'overdue'
                 ELSE status 
             END
         WHERE status IN ('due', 'overdue', 'partially_paid') 
         AND due_date <= %s",
        $today, $today, $today
    ));
    
    // Check for willful failure (loans overdue by more than 90 days)
    $willful_failure_loans = $wpdb->get_results($wpdb->prepare(
        "SELECT DISTINCT s.loan_id, l.user_id 
         FROM {$schedules_table} s
         JOIN {$loans_table} l ON s.loan_id = l.id
         WHERE s.days_overdue > 90 
         AND s.status = 'overdue'
         AND l.is_willful_failure = 0
         AND l.status = 'active'"
    ));
    
    foreach ($willful_failure_loans as $loan_info) {
        daystar_flag_willful_failure($loan_info->loan_id, $loan_info->user_id);
    }
    
    return true;
}

/**
 * Flag loan as willful failure
 */
function daystar_flag_willful_failure($loan_id, $user_id, $notes = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $default_notes = $notes ?: 'Loan overdue by more than 90 days - flagged for disciplinary action';
    
    $result = $wpdb->update(
        $loans_table,
        array(
            'is_willful_failure' => 1,
            'willful_failure_date' => current_time('mysql'),
            'willful_failure_notes' => $default_notes
        ),
        array('id' => $loan_id),
        array('%d', '%s', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        // Record credit history event
        daystar_record_credit_event(
            $user_id,
            $loan_id,
            'willful_failure',
            0,
            'Loan flagged for willful failure to repay',
            -50 // Severe negative credit impact
        );
        
        // Send notification to member and admin
        daystar_send_willful_failure_notification($user_id, $loan_id);
        
        return true;
    }
    
    return false;
}

/**
 * Generate payment receipt PDF
 */
function daystar_generate_payment_receipt($loan_id, $amount, $payment_method, $reference_number) {
    // Check if FPDF is available
    if (!class_exists('FPDF')) {
        // For now, return a placeholder path
        // In production, implement PDF generation using FPDF or similar library
        return 'receipts/receipt_' . $loan_id . '_' . time() . '.pdf';
    }
    
    // Implementation would go here using FPDF
    // This is a placeholder for the actual PDF generation
    $receipt_filename = 'receipt_' . $loan_id . '_' . time() . '.pdf';
    $receipt_path = 'receipts/' . $receipt_filename;
    
    // Create receipts directory if it doesn't exist
    $upload_dir = wp_upload_dir();
    $receipts_dir = $upload_dir['basedir'] . '/receipts/';
    
    if (!file_exists($receipts_dir)) {
        wp_mkdir_p($receipts_dir);
    }
    
    // Generate receipt content (simplified version)
    $loan = daystar_get_loan_by_id($loan_id);
    $user = get_user_by('ID', $loan->user_id);
    
    $receipt_content = "DAYSTAR SACCO PAYMENT RECEIPT\n\n";
    $receipt_content .= "Receipt No: " . strtoupper($reference_number) . "\n";
    $receipt_content .= "Date: " . date('Y-m-d H:i:s') . "\n";
    $receipt_content .= "Member: " . $user->first_name . " " . $user->last_name . "\n";
    $receipt_content .= "Loan ID: " . $loan_id . "\n";
    $receipt_content .= "Amount Paid: KES " . number_format($amount, 2) . "\n";
    $receipt_content .= "Payment Method: " . ucwords(str_replace('_', ' ', $payment_method)) . "\n";
    $receipt_content .= "Reference: " . $reference_number . "\n\n";
    $receipt_content .= "Thank you for your payment.\n";
    $receipt_content .= "Daystar SACCO Ltd.";
    
    // Save as text file for now (in production, use PDF library)
    file_put_contents($receipts_dir . $receipt_filename . '.txt', $receipt_content);
    
    return $receipt_path;
}

/**
 * Get loan repayment schedule
 */
function daystar_get_loan_schedule($loan_id) {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$schedules_table} 
         WHERE loan_id = %d 
         ORDER BY installment_number ASC",
        $loan_id
    ));
}

/**
 * Get member's payment history
 */
function daystar_get_member_payment_history($user_id, $loan_id = null, $limit = 20) {
    global $wpdb;
    
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    $where_clause = "WHERE user_id = %d";
    $params = array($user_id);
    
    if ($loan_id) {
        $where_clause .= " AND loan_id = %d";
        $params[] = $loan_id;
    }
    
    $params[] = $limit;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$payments_table} 
         {$where_clause} 
         ORDER BY payment_date DESC 
         LIMIT %d",
        ...$params
    ));
}

/**
 * Get overdue loans summary
 */
function daystar_get_overdue_loans_summary() {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_results(
        "SELECT 
            l.id as loan_id,
            l.user_id,
            l.loan_type,
            l.amount,
            l.balance,
            COUNT(s.schedule_id) as overdue_installments,
            SUM(s.expected_total - s.amount_paid) as total_overdue_amount,
            MAX(s.days_overdue) as max_days_overdue,
            MIN(s.due_date) as earliest_overdue_date
         FROM {$loans_table} l
         JOIN {$schedules_table} s ON l.id = s.loan_id
         WHERE s.status = 'overdue' AND l.status = 'active'
         GROUP BY l.id
         ORDER BY max_days_overdue DESC, total_overdue_amount DESC"
    );
}

/**
 * Send payment notification
 */
function daystar_send_payment_notification($user_id, $loan_id, $amount, $installments_updated) {
    $user = get_user_by('ID', $user_id);
    $loan = daystar_get_loan_by_id($loan_id);
    
    if (!$user || !$loan) {
        return;
    }
    
    $title = 'Payment Received';
    $message = "Your payment of KES " . number_format($amount, 2) . " has been received for loan #{$loan_id}.";
    
    if (count($installments_updated) == 1 && $installments_updated[0]['new_status'] == 'paid') {
        $message .= " Installment #{$installments_updated[0]['installment_number']} is now fully paid.";
    } else {
        $message .= " " . count($installments_updated) . " installment(s) updated.";
    }
    
    // Create in-app notification
    daystar_create_notification($user_id, $title, $message, 'payment');
    
    // Send email notification
    $subject = 'Payment Confirmation - Daystar SACCO';
    $email_body = "Dear {$user->first_name},\n\n";
    $email_body .= "We have received your payment of KES " . number_format($amount, 2) . " for your loan.\n\n";
    $email_body .= "Loan Details:\n";
    $email_body .= "Loan ID: {$loan_id}\n";
    $email_body .= "Remaining Balance: KES " . number_format($loan->balance, 2) . "\n\n";
    $email_body .= "Thank you for your payment.\n\n";
    $email_body .= "Best regards,\nDaystar SACCO";
    
    wp_mail($user->user_email, $subject, $email_body);
}

/**
 * Send willful failure notification
 */
function daystar_send_willful_failure_notification($user_id, $loan_id) {
    $user = get_user_by('ID', $user_id);
    $loan = daystar_get_loan_by_id($loan_id);
    
    if (!$user || !$loan) {
        return;
    }
    
    // Notification to member
    $title = 'Urgent: Loan Delinquency Notice';
    $message = "Your loan #{$loan_id} has been flagged for willful failure to repay. Please contact our office immediately to avoid disciplinary action.";
    
    daystar_create_notification($user_id, $title, $message, 'urgent');
    
    // Email to member
    $subject = 'URGENT: Loan Delinquency Notice - Daystar SACCO';
    $email_body = "Dear {$user->first_name},\n\n";
    $email_body .= "This is to notify you that your loan (ID: {$loan_id}) has been flagged for willful failure to repay.\n\n";
    $email_body .= "Your loan has been overdue for more than 90 days, which constitutes a violation of our loan agreement.\n\n";
    $email_body .= "IMMEDIATE ACTION REQUIRED:\n";
    $email_body .= "Please contact our office within 7 days to discuss repayment arrangements.\n";
    $email_body .= "Failure to respond may result in disciplinary action as per society by-laws.\n\n";
    $email_body .= "Contact: info@daystar-sacco.com | +254-XXX-XXXX\n\n";
    $email_body .= "Daystar SACCO Credit Department";
    
    wp_mail($user->user_email, $subject, $email_body);
    
    // Notification to admin
    $admin_users = get_users(array('role' => 'administrator'));
    foreach ($admin_users as $admin) {
        daystar_create_notification(
            $admin->ID,
            'Willful Failure Alert',
            "Member {$user->first_name} {$user->last_name} (ID: {$user_id}) has been flagged for willful failure on loan #{$loan_id}.",
            'admin_alert'
        );
    }
}

/**
 * Get delinquency report
 */
function daystar_get_delinquency_report() {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $report = array(
        'current' => 0,
        '1_30_days' => 0,
        '31_60_days' => 0,
        '61_90_days' => 0,
        'over_90_days' => 0,
        'willful_failure' => 0
    );
    
    // Get delinquency breakdown
    $results = $wpdb->get_results(
        "SELECT 
            CASE 
                WHEN s.days_overdue = 0 THEN 'current'
                WHEN s.days_overdue BETWEEN 1 AND 30 THEN '1_30_days'
                WHEN s.days_overdue BETWEEN 31 AND 60 THEN '31_60_days'
                WHEN s.days_overdue BETWEEN 61 AND 90 THEN '61_90_days'
                WHEN s.days_overdue > 90 THEN 'over_90_days'
            END as category,
            COUNT(DISTINCT l.id) as loan_count,
            SUM(s.expected_total - s.amount_paid) as total_amount
         FROM {$loans_table} l
         JOIN {$schedules_table} s ON l.id = s.loan_id
         WHERE l.status = 'active' AND s.status IN ('due', 'overdue', 'partially_paid')
         GROUP BY category"
    );
    
    foreach ($results as $result) {
        if (isset($report[$result->category])) {
            $report[$result->category] = array(
                'count' => $result->loan_count,
                'amount' => $result->total_amount
            );
        }
    }
    
    // Get willful failure count
    $willful_failure_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM {$loans_table} WHERE is_willful_failure = 1 AND status = 'active'"
    );
    
    $report['willful_failure'] = array(
        'count' => $willful_failure_count,
        'amount' => 0 // Could be calculated if needed
    );
    
    return $report;
}

/**
 * Schedule daily overdue status update
 */
function daystar_schedule_overdue_updates() {
    if (!wp_next_scheduled('daystar_daily_overdue_update')) {
        wp_schedule_event(time(), 'daily', 'daystar_daily_overdue_update');
    }
}

// Hook for daily overdue status update
add_action('daystar_daily_overdue_update', 'daystar_update_overdue_status');

// Initialize scheduling on theme activation
add_action('after_switch_theme', 'daystar_schedule_overdue_updates');