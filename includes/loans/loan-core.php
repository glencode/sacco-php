<?php
/**
 * Loan System Core Functions
 * Consolidated loan functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Loan Type Configurations
 */
function daystar_get_loan_types_config() {
    return array(
        'development' => array(
            'name' => 'Development Loan',
            'interest_rate' => 12,
            'min_amount' => 50000,
            'max_amount' => 2000000,
            'terms' => array(12, 18, 24, 36, 48),
            'processing_fee' => 0.02,
            'deadline_restricted' => true,
            'requirements' => array(
                'Business plan or project proposal',
                'Proof of land ownership (if applicable)',
                'Construction estimates (if applicable)'
            )
        ),
        'emergency' => array(
            'name' => 'Emergency Loan',
            'interest_rate' => 10,
            'min_amount' => 10000,
            'max_amount' => 500000,
            'terms' => array(3, 6, 9, 12),
            'processing_fee' => 0.01,
            'deadline_restricted' => false,
            'requirements' => array(
                'Medical bills (for medical emergencies)',
                'Police report (for accident/theft)',
                'Supporting evidence of emergency'
            )
        ),
        'school_fees' => array(
            'name' => 'School Fees Loan',
            'interest_rate' => 8,
            'min_amount' => 20000,
            'max_amount' => 1000000,
            'terms' => array(6, 9, 12),
            'processing_fee' => 0.01,
            'deadline_restricted' => false,
            'requirements' => array(
                'School fee structure',
                'Student admission letter',
                'Academic transcripts'
            )
        ),
        'business' => array(
            'name' => 'Business Loan',
            'interest_rate' => 14,
            'min_amount' => 100000,
            'max_amount' => 2500000,
            'terms' => array(12, 18, 24, 36, 48, 60),
            'processing_fee' => 0.025,
            'deadline_restricted' => false,
            'requirements' => array(
                'Business registration certificate',
                'Business plan',
                'Financial projections',
                'Market analysis'
            )
        ),
        'asset_financing' => array(
            'name' => 'Asset Financing',
            'interest_rate' => 13,
            'min_amount' => 200000,
            'max_amount' => 5000000,
            'terms' => array(24, 36, 48, 60, 72),
            'processing_fee' => 0.02,
            'deadline_restricted' => false,
            'requirements' => array(
                'Asset quotation/proforma invoice',
                'Asset insurance quote',
                'Supplier information'
            )
        )
    );
}

/**
 * Get specific loan type configuration
 */
function daystar_get_loan_type_config($loan_type) {
    $configs = daystar_get_loan_types_config();
    return isset($configs[$loan_type]) ? $configs[$loan_type] : null;
}

/**
 * Calculate monthly loan payment
 */
function daystar_calculate_monthly_payment($principal, $annual_interest_rate, $term_months) {
    if ($principal <= 0 || $annual_interest_rate <= 0 || $term_months <= 0) {
        return 0;
    }
    
    // Convert annual interest rate to monthly
    $monthly_interest_rate = ($annual_interest_rate / 100) / 12;
    
    // Calculate monthly payment using the formula: P * r * (1+r)^n / ((1+r)^n - 1)
    $monthly_payment = $principal * $monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months) / (pow(1 + $monthly_interest_rate, $term_months) - 1);
    
    return round($monthly_payment, 2);
}

/**
 * Calculate loan summary
 */
function daystar_calculate_loan_summary($loan_type, $amount, $term) {
    $config = daystar_get_loan_type_config($loan_type);
    if (!$config) {
        return false;
    }
    
    $monthly_payment = daystar_calculate_monthly_payment($amount, $config['interest_rate'], $term);
    $total_payment = $monthly_payment * $term;
    $total_interest = $total_payment - $amount;
    $processing_fee = $amount * $config['processing_fee'];
    
    return array(
        'monthly_payment' => $monthly_payment,
        'total_payment' => $total_payment,
        'total_interest' => $total_interest,
        'processing_fee' => $processing_fee,
        'interest_rate' => $config['interest_rate']
    );
}

/**
 * Generate unique waiting number
 */
function daystar_generate_waiting_number() {
    $prefix = 'WN';
    $year = date('Y');
    $month = date('m');
    
    // Get the next sequence number for this month
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $last_number = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(CAST(SUBSTRING(application_waiting_number, -4) AS UNSIGNED)) 
         FROM {$loans_table} 
         WHERE application_waiting_number LIKE %s",
        $prefix . $year . $month . '%'
    ));
    
    $sequence = str_pad(($last_number + 1), 4, '0', STR_PAD_LEFT);
    
    return $prefix . $year . $month . $sequence;
}

/**
 * Check submission deadline for restricted loan types
 */
function daystar_check_submission_deadline($loan_type) {
    $config = daystar_get_loan_type_config($loan_type);
    
    if (!$config || !$config['deadline_restricted']) {
        return array('allowed' => true);
    }
    
    $current_day = date('j');
    $current_month = date('F Y');
    $next_month = date('F Y', strtotime('first day of next month'));
    
    if ($current_day > 30) {
        return array(
            'allowed' => false,
            'force_next_cycle' => true,
            'next_cycle' => $next_month,
            'message' => 'Application submitted after deadline. Will be processed in ' . $next_month . '.'
        );
    }
    
    return array('allowed' => true);
}

/**
 * Get member's active loans
 */
function daystar_get_member_active_loans($user_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$loans_table} 
         WHERE user_id = %d AND status IN ('active', 'approved', 'disbursed') 
         ORDER BY loan_date DESC",
        $user_id
    ));
}

/**
 * Get member's loan history
 */
function daystar_get_member_loan_history($user_id, $limit = 10) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$loans_table} 
         WHERE user_id = %d 
         ORDER BY created_at DESC 
         LIMIT %d",
        $user_id,
        $limit
    ));
}

/**
 * Get loan by ID
 */
function daystar_get_loan_by_id($loan_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
}

/**
 * Get loan by waiting number
 */
function daystar_get_loan_by_waiting_number($waiting_number) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE application_waiting_number = %s",
        $waiting_number
    ));
}

/**
 * Update loan status
 */
function daystar_update_loan_status($loan_id, $status, $admin_user_id = null, $notes = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $update_data = array(
        'status' => $status,
        'updated_at' => current_time('mysql')
    );
    
    if ($admin_user_id) {
        $update_data['approved_by'] = $admin_user_id;
        $update_data['approved_date'] = current_time('mysql');
    }
    
    if ($notes) {
        if ($status === 'rejected') {
            $update_data['rejection_reason'] = $notes;
        } else {
            $update_data['application_notes'] = $notes;
        }
    }
    
    $result = $wpdb->update(
        $loans_table,
        $update_data,
        array('id' => $loan_id),
        array('%s', '%s', '%d', '%s', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        // Get loan details for notifications
        $loan = daystar_get_loan_by_id($loan_id);
        
        if ($loan) {
            // Generate repayment schedule when loan is disbursed
            if ($status === 'disbursed' && function_exists('daystar_generate_loan_schedule')) {
                daystar_generate_loan_schedule($loan_id);
            }
            
            // Record credit history event
            $event_description = ucfirst($status) . ' loan application';
            if ($notes) {
                $event_description .= ': ' . $notes;
            }
            
            $credit_impact = 0;
            switch ($status) {
                case 'approved':
                    $credit_impact = 10;
                    break;
                case 'rejected':
                    $credit_impact = -5;
                    break;
                case 'disbursed':
                    $credit_impact = 15;
                    break;
            }
            
            daystar_record_credit_event(
                $loan->user_id,
                $loan_id,
                'loan_' . $status,
                $loan->amount,
                $event_description,
                $credit_impact
            );
            
            // Send notification
            daystar_send_loan_status_notification($loan, $status, $notes);
        }
    }
    
    return $result !== false;
}

/**
 * Check if member can apply for multiple loans
 */
function daystar_check_multiple_loan_eligibility($user_id, $new_loan_type) {
    $active_loans = daystar_get_member_active_loans($user_id);
    
    // Check if member has any active loans
    if (empty($active_loans)) {
        return true;
    }
    
    // Emergency loans are always allowed
    if ($new_loan_type === 'emergency') {
        return true;
    }
    
    // Check if member has good repayment history
    $good_repayment_history = daystar_check_repayment_history($user_id);
    if (!$good_repayment_history) {
        return false;
    }
    
    // Check if member has sufficient contribution balance
    $total_contributions = daystar_get_member_total_contributions($user_id);
    
    // Calculate total outstanding loan balance
    $total_outstanding = 0;
    foreach ($active_loans as $loan) {
        $total_outstanding += $loan->balance;
    }
    
    // According to policy, total loans should not exceed 3 times contributions
    $max_allowed = $total_contributions * 3;
    
    // Check loan type restrictions
    foreach ($active_loans as $loan) {
        // If member already has a development loan, they can't get another one
        if ($loan->loan_type === 'development' && $new_loan_type === 'development') {
            return false;
        }
        
        // If member already has a business loan, they can't get another one
        if ($loan->loan_type === 'business' && $new_loan_type === 'business') {
            return false;
        }
    }
    
    return $total_outstanding < $max_allowed;
}

/**
 * Check member's loan repayment history
 */
function daystar_check_repayment_history($user_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    // Get member's loan history
    $loans = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$loans_table} 
         WHERE user_id = %d AND status IN ('completed', 'active') 
         ORDER BY loan_date DESC",
        $user_id
    ));
    
    if (empty($loans)) {
        return true; // No history means good standing
    }
    
    $total_loans = count($loans);
    $late_payments = 0;
    $defaults = 0;
    
    foreach ($loans as $loan) {
        // Check for defaults
        if ($loan->status === 'defaulted') {
            $defaults++;
        }
        
        // Check payment history for late payments
        $payments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$payments_table} 
             WHERE loan_id = %d 
             ORDER BY payment_date ASC",
            $loan->id
        ));
        
        // Simple late payment check (can be enhanced)
        foreach ($payments as $payment) {
            $expected_date = date('Y-m-d', strtotime($loan->loan_date . ' +1 month'));
            if ($payment->payment_date > $expected_date) {
                $late_payments++;
            }
        }
    }
    
    // Good history if less than 20% late payments and no defaults
    $late_payment_ratio = $total_loans > 0 ? ($late_payments / $total_loans) : 0;
    
    return $defaults === 0 && $late_payment_ratio < 0.2;
}

/**
 * Get member's total contributions (backward compatibility)
 */
function daystar_get_member_total_contributions($user_id) {
    $share_capital = daystar_get_member_share_capital($user_id);
    $regular_contributions = daystar_get_member_regular_contributions($user_id);
    
    return $share_capital + $regular_contributions;
}

/**
 * Calculate basic loan eligibility (backward compatibility)
 */
function daystar_calculate_loan_eligibility($user_id, $loan_type = '', $requested_amount = 0) {
    // Use the comprehensive eligibility system if available
    if (function_exists('daystar_comprehensive_loan_eligibility')) {
        $eligibility = daystar_comprehensive_loan_eligibility($user_id, $loan_type, $requested_amount);
        return $eligibility['max_loan_amount'];
    }
    
    // Fallback to basic calculation
    $total_contributions = daystar_get_member_total_contributions($user_id);
    $max_loan_amount = $total_contributions * 3;
    
    // Cap the maximum loan amount based on policy
    $absolute_max = 1000000; // 1 million KES
    if ($max_loan_amount > $absolute_max) {
        $max_loan_amount = $absolute_max;
    }
    
    return $max_loan_amount;
}

/**
 * Send loan status notification
 */
function daystar_send_loan_status_notification($loan, $status, $notes = '') {
    $user = get_user_by('ID', $loan->user_id);
    
    if (!$user) {
        return;
    }
    
    $loan_type_name = '';
    $config = daystar_get_loan_type_config($loan->loan_type);
    if ($config) {
        $loan_type_name = $config['name'];
    }
    
    switch ($status) {
        case 'approved':
            $subject = 'Loan Application Approved - ' . $loan->application_waiting_number;
            $message = "Dear {$user->first_name},\n\n";
            $message .= "Congratulations! Your loan application has been approved.\n\n";
            $message .= "Application Details:\n";
            $message .= "Waiting Number: {$loan->application_waiting_number}\n";
            $message .= "Loan Type: {$loan_type_name}\n";
            $message .= "Amount: KES " . number_format($loan->amount, 2) . "\n";
            $message .= "Term: {$loan->term_months} months\n";
            $message .= "Monthly Payment: KES " . number_format($loan->monthly_payment, 2) . "\n\n";
            $message .= "Your loan will be disbursed to your registered account within 2-3 working days.\n\n";
            $message .= "Thank you for choosing Daystar SACCO.\n\n";
            $message .= "Best regards,\nDaystar SACCO Credit Department";
            
            // Create in-app notification
            daystar_create_notification(
                $loan->user_id,
                'Loan Application Approved',
                "Your loan application ({$loan->application_waiting_number}) has been approved. Disbursement will be processed within 2-3 working days.",
                'loan'
            );
            break;
            
        case 'rejected':
            $subject = 'Loan Application Status - ' . $loan->application_waiting_number;
            $message = "Dear {$user->first_name},\n\n";
            $message .= "We regret to inform you that your loan application has not been approved at this time.\n\n";
            $message .= "Application Details:\n";
            $message .= "Waiting Number: {$loan->application_waiting_number}\n";
            $message .= "Loan Type: {$loan_type_name}\n";
            $message .= "Amount: KES " . number_format($loan->amount, 2) . "\n\n";
            if ($notes) {
                $message .= "Reason: {$notes}\n\n";
            }
            $message .= "You may reapply after addressing the issues mentioned above.\n";
            $message .= "For more information, please contact our credit department.\n\n";
            $message .= "Thank you for your interest in Daystar SACCO.\n\n";
            $message .= "Best regards,\nDaystar SACCO Credit Department";
            
            // Create in-app notification
            daystar_create_notification(
                $loan->user_id,
                'Loan Application Update',
                "Your loan application ({$loan->application_waiting_number}) requires attention. Please check your email for details.",
                'loan'
            );
            break;
            
        case 'disbursed':
            $subject = 'Loan Disbursed - ' . $loan->application_waiting_number;
            $message = "Dear {$user->first_name},\n\n";
            $message .= "Your loan has been successfully disbursed.\n\n";
            $message .= "Loan Details:\n";
            $message .= "Waiting Number: {$loan->application_waiting_number}\n";
            $message .= "Amount: KES " . number_format($loan->amount, 2) . "\n";
            $message .= "Monthly Payment: KES " . number_format($loan->monthly_payment, 2) . "\n";
            $message .= "First Payment Due: " . date('F j, Y', strtotime('+1 month')) . "\n\n";
            $message .= "Please ensure timely repayments to maintain your good credit standing.\n\n";
            $message .= "Thank you for choosing Daystar SACCO.\n\n";
            $message .= "Best regards,\nDaystar SACCO Credit Department";
            
            // Create in-app notification
            daystar_create_notification(
                $loan->user_id,
                'Loan Disbursed',
                "Your loan ({$loan->application_waiting_number}) has been disbursed. First payment due: " . date('F j, Y', strtotime('+1 month')),
                'loan'
            );
            break;
    }
    
    // Send email
    wp_mail($user->user_email, $subject, $message);
    
    // Send SMS if phone number is available
    $phone = get_user_meta($loan->user_id, 'phone_number', true);
    if ($phone) {
        $sms_message = "Daystar SACCO: Your loan application {$loan->application_waiting_number} has been {$status}.";
        if ($status === 'approved') {
            $sms_message .= " Disbursement in 2-3 days.";
        }
        // daystar_send_sms($phone, $sms_message); // Implement SMS service
    }
}