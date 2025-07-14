<?php
/**
 * Loan Delinquency Management System
 * Handles automated delinquency calculation, categorization, and blacklisting
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Delinquency status constants
 */
define('DAYSTAR_DELINQUENCY_CURRENT', 'current');
define('DAYSTAR_DELINQUENCY_0_30', '0-30_days_overdue');
define('DAYSTAR_DELINQUENCY_31_60', '31-60_days_overdue');
define('DAYSTAR_DELINQUENCY_61_90', '61-90_days_overdue');
define('DAYSTAR_DELINQUENCY_90_PLUS', '90+_days_overdue');
define('DAYSTAR_DELINQUENCY_BLACKLISTED', 'blacklisted');

/**
 * Blacklist status constants
 */
define('DAYSTAR_BLACKLIST_ACTIVE', 'active');
define('DAYSTAR_BLACKLIST_INACTIVE', 'inactive');

/**
 * Main function to calculate and update loan delinquency status
 * This should be called by a scheduled cron job
 */
function daystar_calculate_loan_delinquency() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    // Get all active loans
    $active_loans = $wpdb->get_results("
        SELECT id, user_id, amount, balance, delinquency_status, days_overdue 
        FROM $loans_table 
        WHERE status IN ('active', 'disbursed') 
        AND delinquency_status != 'blacklisted'
    ");
    
    $updated_loans = 0;
    $notifications_sent = 0;
    $blacklisted_members = 0;
    
    foreach ($active_loans as $loan) {
        $delinquency_data = daystar_calculate_loan_delinquency_status($loan->id);
        
        if ($delinquency_data) {
            $old_status = $loan->delinquency_status;
            $old_days_overdue = $loan->days_overdue;
            
            // Update loan delinquency status
            $wpdb->update(
                $loans_table,
                array(
                    'delinquency_status' => $delinquency_data['status'],
                    'days_overdue' => $delinquency_data['days_overdue'],
                    'last_delinquency_check' => current_time('mysql')
                ),
                array('id' => $loan->id)
            );
            
            $updated_loans++;
            
            // Check if status changed and send notifications
            if ($old_status !== $delinquency_data['status'] || $old_days_overdue !== $delinquency_data['days_overdue']) {
                daystar_send_delinquency_notification($loan->user_id, $loan->id, $delinquency_data);
                $notifications_sent++;
                
                // Log the status change
                daystar_log_delinquency_change($loan->id, $old_status, $delinquency_data['status'], $delinquency_data['days_overdue']);
            }
            
            // Check for blacklisting criteria
            if (daystar_should_blacklist_member($loan->user_id, $loan->id, $delinquency_data)) {
                daystar_blacklist_member($loan->user_id, $loan->id, 'Automatic blacklisting due to persistent delinquency');
                $blacklisted_members++;
            }
        }
    }
    
    // Update loan schedules overdue status
    daystar_update_schedule_overdue_status();
    
    // Log the delinquency check results
    error_log("Daystar Delinquency Check: Updated $updated_loans loans, sent $notifications_sent notifications, blacklisted $blacklisted_members members");
    
    return array(
        'updated_loans' => $updated_loans,
        'notifications_sent' => $notifications_sent,
        'blacklisted_members' => $blacklisted_members
    );
}

/**
 * Calculate delinquency status for a specific loan
 */
function daystar_calculate_loan_delinquency_status($loan_id) {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    // Get all overdue installments for this loan
    $overdue_installments = $wpdb->get_results($wpdb->prepare("
        SELECT schedule_id, installment_number, due_date, expected_total, amount_paid, status,
               DATEDIFF(CURDATE(), due_date) as days_past_due
        FROM $schedules_table 
        WHERE loan_id = %d 
        AND due_date < CURDATE() 
        AND status != 'paid'
        ORDER BY due_date ASC
    ", $loan_id));
    
    if (empty($overdue_installments)) {
        return array(
            'status' => DAYSTAR_DELINQUENCY_CURRENT,
            'days_overdue' => 0,
            'overdue_amount' => 0,
            'overdue_installments' => 0
        );
    }
    
    // Calculate total overdue amount and find earliest overdue date
    $total_overdue_amount = 0;
    $earliest_overdue_days = 0;
    
    foreach ($overdue_installments as $installment) {
        $outstanding_amount = $installment->expected_total - $installment->amount_paid;
        if ($outstanding_amount > 0) {
            $total_overdue_amount += $outstanding_amount;
            if ($earliest_overdue_days === 0 || $installment->days_past_due > $earliest_overdue_days) {
                $earliest_overdue_days = $installment->days_past_due;
            }
        }
    }
    
    // Determine delinquency status based on days overdue
    $status = daystar_get_delinquency_status_by_days($earliest_overdue_days);
    
    return array(
        'status' => $status,
        'days_overdue' => $earliest_overdue_days,
        'overdue_amount' => $total_overdue_amount,
        'overdue_installments' => count($overdue_installments)
    );
}

/**
 * Get delinquency status based on days overdue
 */
function daystar_get_delinquency_status_by_days($days_overdue) {
    if ($days_overdue <= 0) {
        return DAYSTAR_DELINQUENCY_CURRENT;
    } elseif ($days_overdue <= 30) {
        return DAYSTAR_DELINQUENCY_0_30;
    } elseif ($days_overdue <= 60) {
        return DAYSTAR_DELINQUENCY_31_60;
    } elseif ($days_overdue <= 90) {
        return DAYSTAR_DELINQUENCY_61_90;
    } else {
        return DAYSTAR_DELINQUENCY_90_PLUS;
    }
}

/**
 * Update loan schedule overdue status
 */
function daystar_update_schedule_overdue_status() {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    // Update overdue days for all schedules
    $wpdb->query("
        UPDATE $schedules_table 
        SET days_overdue = GREATEST(0, DATEDIFF(CURDATE(), due_date))
        WHERE due_date <= CURDATE()
    ");
    
    // Update status for overdue unpaid installments
    $wpdb->query("
        UPDATE $schedules_table 
        SET status = 'overdue' 
        WHERE due_date < CURDATE() 
        AND status = 'due' 
        AND amount_paid < expected_total
    ");
}

/**
 * Check if a member should be blacklisted
 */
function daystar_should_blacklist_member($user_id, $loan_id, $delinquency_data) {
    global $wpdb;
    
    // Don't blacklist if already blacklisted
    if (daystar_is_member_blacklisted($user_id)) {
        return false;
    }
    
    // Blacklist criteria: 90+ days overdue for more than 30 days
    if ($delinquency_data['status'] === DAYSTAR_DELINQUENCY_90_PLUS) {
        $loans_table = $wpdb->prefix . 'daystar_loans';
        
        // Check how long the loan has been in 90+ days overdue status
        $loan_history = $wpdb->get_var($wpdb->prepare("
            SELECT last_delinquency_check 
            FROM $loans_table 
            WHERE id = %d 
            AND delinquency_status = %s
        ", $loan_id, DAYSTAR_DELINQUENCY_90_PLUS));
        
        if ($loan_history) {
            $days_in_90_plus = (time() - strtotime($loan_history)) / (24 * 60 * 60);
            if ($days_in_90_plus >= 30) {
                return true;
            }
        }
    }
    
    // Additional criteria: Multiple loans in delinquency
    $delinquent_loans_count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM {$wpdb->prefix}daystar_loans 
        WHERE user_id = %d 
        AND delinquency_status IN (%s, %s, %s, %s)
        AND status IN ('active', 'disbursed')
    ", $user_id, DAYSTAR_DELINQUENCY_0_30, DAYSTAR_DELINQUENCY_31_60, DAYSTAR_DELINQUENCY_61_90, DAYSTAR_DELINQUENCY_90_PLUS));
    
    if ($delinquent_loans_count >= 2) {
        return true;
    }
    
    return false;
}

/**
 * Blacklist a member
 */
function daystar_blacklist_member($user_id, $loan_id, $reason, $blacklisted_by = null) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Check if already blacklisted
    if (daystar_is_member_blacklisted($user_id)) {
        return false;
    }
    
    // Add to blacklist
    $result = $wpdb->insert(
        $blacklist_table,
        array(
            'user_id' => $user_id,
            'reason' => $reason,
            'blacklist_date' => current_time('mysql'),
            'status' => DAYSTAR_BLACKLIST_ACTIVE,
            'blacklisted_by' => $blacklisted_by,
            'automatic_blacklist' => $blacklisted_by ? 0 : 1,
            'loan_id' => $loan_id,
            'notes' => 'Automatically blacklisted due to loan delinquency'
        )
    );
    
    if ($result) {
        // Update all active loans for this user to blacklisted status
        $wpdb->update(
            $loans_table,
            array('delinquency_status' => DAYSTAR_DELINQUENCY_BLACKLISTED),
            array('user_id' => $user_id, 'status' => 'active')
        );
        
        // Send blacklist notification
        daystar_send_blacklist_notification($user_id, $reason);
        
        // Log the blacklisting
        daystar_log_member_blacklisted($user_id, $loan_id, $reason);
        
        return true;
    }
    
    return false;
}

/**
 * Remove member from blacklist
 */
function daystar_unblacklist_member($user_id, $reason, $unblacklisted_by) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Update blacklist record
    $result = $wpdb->update(
        $blacklist_table,
        array(
            'status' => DAYSTAR_BLACKLIST_INACTIVE,
            'unblacklist_date' => current_time('mysql'),
            'unblacklisted_by' => $unblacklisted_by,
            'notes' => $reason
        ),
        array('user_id' => $user_id, 'status' => DAYSTAR_BLACKLIST_ACTIVE)
    );
    
    if ($result) {
        // Recalculate delinquency status for all loans
        $user_loans = $wpdb->get_col($wpdb->prepare("
            SELECT id FROM $loans_table 
            WHERE user_id = %d 
            AND status IN ('active', 'disbursed')
        ", $user_id));
        
        foreach ($user_loans as $loan_id) {
            $delinquency_data = daystar_calculate_loan_delinquency_status($loan_id);
            if ($delinquency_data) {
                $wpdb->update(
                    $loans_table,
                    array(
                        'delinquency_status' => $delinquency_data['status'],
                        'days_overdue' => $delinquency_data['days_overdue']
                    ),
                    array('id' => $loan_id)
                );
            }
        }
        
        // Send unblacklist notification
        daystar_send_unblacklist_notification($user_id, $reason);
        
        return true;
    }
    
    return false;
}

/**
 * Check if a member is blacklisted
 */
function daystar_is_member_blacklisted($user_id) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    
    $count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*) 
        FROM $blacklist_table 
        WHERE user_id = %d 
        AND status = %s
    ", $user_id, DAYSTAR_BLACKLIST_ACTIVE));
    
    return intval($count) > 0;
}

/**
 * Get blacklist information for a member
 */
function daystar_get_member_blacklist_info($user_id) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    
    return $wpdb->get_row($wpdb->prepare("
        SELECT * 
        FROM $blacklist_table 
        WHERE user_id = %d 
        AND status = %s
        ORDER BY blacklist_date DESC 
        LIMIT 1
    ", $user_id, DAYSTAR_BLACKLIST_ACTIVE));
}

/**
 * Get delinquent loans by category
 */
function daystar_get_delinquent_loans_by_category($category = null, $limit = null, $offset = 0) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $users_table = $wpdb->users;
    
    $where_clause = "WHERE l.status IN ('active', 'disbursed')";
    
    if ($category) {
        $where_clause .= $wpdb->prepare(" AND l.delinquency_status = %s", $category);
    } else {
        $where_clause .= " AND l.delinquency_status != 'current'";
    }
    
    $limit_clause = '';
    if ($limit) {
        $limit_clause = $wpdb->prepare(" LIMIT %d OFFSET %d", $limit, $offset);
    }
    
    $sql = "
        SELECT l.*, u.display_name, u.user_email,
               um1.meta_value as member_number,
               um2.meta_value as phone_number
        FROM $loans_table l
        LEFT JOIN $users_table u ON l.user_id = u.ID
        LEFT JOIN {$wpdb->usermeta} um1 ON (l.user_id = um1.user_id AND um1.meta_key = 'member_number')
        LEFT JOIN {$wpdb->usermeta} um2 ON (l.user_id = um2.user_id AND um2.meta_key = 'phone_number')
        $where_clause
        ORDER BY l.days_overdue DESC, l.delinquency_status DESC
        $limit_clause
    ";
    
    return $wpdb->get_results($sql);
}

/**
 * Get delinquency statistics
 */
function daystar_get_delinquency_statistics() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $stats = $wpdb->get_results("
        SELECT 
            delinquency_status,
            COUNT(*) as loan_count,
            SUM(balance) as total_balance,
            AVG(days_overdue) as avg_days_overdue
        FROM $loans_table 
        WHERE status IN ('active', 'disbursed')
        GROUP BY delinquency_status
    ");
    
    $formatted_stats = array();
    foreach ($stats as $stat) {
        $formatted_stats[$stat->delinquency_status] = array(
            'loan_count' => intval($stat->loan_count),
            'total_balance' => floatval($stat->total_balance),
            'avg_days_overdue' => floatval($stat->avg_days_overdue)
        );
    }
    
    return $formatted_stats;
}

/**
 * Get blacklisted members
 */
function daystar_get_blacklisted_members($limit = null, $offset = 0) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    $users_table = $wpdb->users;
    
    $limit_clause = '';
    if ($limit) {
        $limit_clause = $wpdb->prepare(" LIMIT %d OFFSET %d", $limit, $offset);
    }
    
    $sql = "
        SELECT b.*, u.display_name, u.user_email,
               um1.meta_value as member_number,
               um2.meta_value as phone_number,
               blacklisted_user.display_name as blacklisted_by_name
        FROM $blacklist_table b
        LEFT JOIN $users_table u ON b.user_id = u.ID
        LEFT JOIN $users_table blacklisted_user ON b.blacklisted_by = blacklisted_user.ID
        LEFT JOIN {$wpdb->usermeta} um1 ON (b.user_id = um1.user_id AND um1.meta_key = 'member_number')
        LEFT JOIN {$wpdb->usermeta} um2 ON (b.user_id = um2.user_id AND um2.meta_key = 'phone_number')
        WHERE b.status = %s
        ORDER BY b.blacklist_date DESC
        $limit_clause
    ";
    
    return $wpdb->get_results($wpdb->prepare($sql, DAYSTAR_BLACKLIST_ACTIVE));
}

/**
 * Send delinquency notification
 */
function daystar_send_delinquency_notification($user_id, $loan_id, $delinquency_data) {
    $user = get_user_by('ID', $user_id);
    if (!$user) return false;
    
    $member_number = get_user_meta($user_id, 'member_number', true);
    $phone_number = get_user_meta($user_id, 'phone_number', true);
    
    // Prepare notification message based on delinquency status
    $messages = array(
        DAYSTAR_DELINQUENCY_0_30 => "Your loan payment is overdue by {$delinquency_data['days_overdue']} days. Please make payment to avoid penalties.",
        DAYSTAR_DELINQUENCY_31_60 => "URGENT: Your loan is {$delinquency_data['days_overdue']} days overdue. Immediate payment required to avoid further action.",
        DAYSTAR_DELINQUENCY_61_90 => "FINAL NOTICE: Your loan is {$delinquency_data['days_overdue']} days overdue. Risk of blacklisting if not resolved immediately.",
        DAYSTAR_DELINQUENCY_90_PLUS => "CRITICAL: Your loan is {$delinquency_data['days_overdue']} days overdue. Account may be blacklisted soon."
    );
    
    $message = isset($messages[$delinquency_data['status']]) ? $messages[$delinquency_data['status']] : '';
    
    if ($message) {
        // Create notification record
        daystar_create_notification($user_id, 'Loan Payment Overdue', $message, 'delinquency');
        
        // Send email if available
        if ($user->user_email) {
            daystar_send_delinquency_email($user, $loan_id, $delinquency_data, $message);
        }
        
        // Send SMS if phone number available
        if ($phone_number) {
            daystar_send_delinquency_sms($phone_number, $message);
        }
    }
}

/**
 * Send blacklist notification
 */
function daystar_send_blacklist_notification($user_id, $reason) {
    $user = get_user_by('ID', $user_id);
    if (!$user) return false;
    
    $message = "Your account has been blacklisted due to: $reason. Please contact the office immediately.";
    
    // Create notification record
    daystar_create_notification($user_id, 'Account Blacklisted', $message, 'blacklist');
    
    // Send email
    if ($user->user_email) {
        wp_mail(
            $user->user_email,
            'Daystar Co-op: Account Blacklisted',
            $message,
            array('Content-Type: text/html; charset=UTF-8')
        );
    }
    
    // Send SMS
    $phone_number = get_user_meta($user_id, 'phone_number', true);
    if ($phone_number) {
        daystar_send_delinquency_sms($phone_number, $message);
    }
}

/**
 * Send unblacklist notification
 */
function daystar_send_unblacklist_notification($user_id, $reason) {
    $user = get_user_by('ID', $user_id);
    if (!$user) return false;
    
    $message = "Your account blacklist has been removed. Reason: $reason. You can now apply for new loans.";
    
    // Create notification record
    daystar_create_notification($user_id, 'Blacklist Removed', $message, 'unblacklist');
    
    // Send email
    if ($user->user_email) {
        wp_mail(
            $user->user_email,
            'Daystar Co-op: Blacklist Removed',
            $message,
            array('Content-Type: text/html; charset=UTF-8')
        );
    }
}

/**
 * Create notification record
 */
function daystar_create_notification($user_id, $title, $message, $type) {
    global $wpdb;
    
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    return $wpdb->insert(
        $notifications_table,
        array(
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'created_at' => current_time('mysql')
        )
    );
}

/**
 * Send delinquency email
 */
function daystar_send_delinquency_email($user, $loan_id, $delinquency_data, $message) {
    $subject = 'Daystar Co-op: Loan Payment Overdue Notice';
    
    $email_body = "
    <h2>Loan Payment Overdue Notice</h2>
    <p>Dear {$user->display_name},</p>
    <p>$message</p>
    <p><strong>Loan Details:</strong></p>
    <ul>
        <li>Loan ID: $loan_id</li>
        <li>Days Overdue: {$delinquency_data['days_overdue']}</li>
        <li>Overdue Amount: KSh " . number_format($delinquency_data['overdue_amount'], 2) . "</li>
    </ul>
    <p>Please contact our office immediately to resolve this matter.</p>
    <p>Thank you,<br>Daystar Multi-Purpose Co-operative Society Ltd.</p>
    ";
    
    wp_mail(
        $user->user_email,
        $subject,
        $email_body,
        array('Content-Type: text/html; charset=UTF-8')
    );
}

/**
 * Send SMS notification (placeholder - integrate with SMS provider)
 */
function daystar_send_delinquency_sms($phone_number, $message) {
    // This is a placeholder function
    // Integrate with your SMS provider (e.g., Africa's Talking, Twilio, etc.)
    
    // Log SMS for now
    error_log("SMS to $phone_number: $message");
    
    // Example integration with Africa's Talking
    /*
    $sms_data = array(
        'to' => $phone_number,
        'message' => $message,
        'from' => 'DAYSTAR'
    );
    
    // Send SMS via your provider's API
    */
}

/**
 * Log delinquency status change
 */
function daystar_log_delinquency_change($loan_id, $old_status, $new_status, $days_overdue) {
    global $wpdb;
    
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    $wpdb->insert(
        $credit_history_table,
        array(
            'user_id' => $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->prefix}daystar_loans WHERE id = %d", $loan_id)),
            'loan_id' => $loan_id,
            'event_type' => 'delinquency_change',
            'event_date' => current_time('mysql'),
            'description' => "Delinquency status changed from '$old_status' to '$new_status' ($days_overdue days overdue)",
            'credit_score_impact' => daystar_get_delinquency_credit_impact($new_status)
        )
    );
}

/**
 * Log member blacklisting
 */
function daystar_log_member_blacklisted($user_id, $loan_id, $reason) {
    global $wpdb;
    
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    $wpdb->insert(
        $credit_history_table,
        array(
            'user_id' => $user_id,
            'loan_id' => $loan_id,
            'event_type' => 'blacklisted',
            'event_date' => current_time('mysql'),
            'description' => "Member blacklisted: $reason",
            'credit_score_impact' => -100
        )
    );
}

/**
 * Get credit score impact for delinquency status
 */
function daystar_get_delinquency_credit_impact($status) {
    $impacts = array(
        DAYSTAR_DELINQUENCY_CURRENT => 0,
        DAYSTAR_DELINQUENCY_0_30 => -5,
        DAYSTAR_DELINQUENCY_31_60 => -15,
        DAYSTAR_DELINQUENCY_61_90 => -30,
        DAYSTAR_DELINQUENCY_90_PLUS => -50,
        DAYSTAR_DELINQUENCY_BLACKLISTED => -100
    );
    
    return isset($impacts[$status]) ? $impacts[$status] : 0;
}

/**
 * Schedule delinquency check cron job
 */
function daystar_schedule_delinquency_check() {
    if (!wp_next_scheduled('daystar_daily_delinquency_check')) {
        wp_schedule_event(time(), 'daily', 'daystar_daily_delinquency_check');
    }
}

/**
 * Unschedule delinquency check cron job
 */
function daystar_unschedule_delinquency_check() {
    wp_clear_scheduled_hook('daystar_daily_delinquency_check');
}

/**
 * Get member's loan delinquency status for dashboard
 */
function daystar_get_member_delinquency_status($user_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Check if member is blacklisted
    $is_blacklisted = daystar_is_member_blacklisted($user_id);
    
    // Get member's active loans with delinquency status
    $loans = $wpdb->get_results($wpdb->prepare("
        SELECT id, loan_type, amount, balance, delinquency_status, days_overdue
        FROM $loans_table 
        WHERE user_id = %d 
        AND status IN ('active', 'disbursed')
        ORDER BY days_overdue DESC
    ", $user_id));
    
    $delinquent_loans = array();
    $total_overdue_amount = 0;
    $worst_status = DAYSTAR_DELINQUENCY_CURRENT;
    $max_days_overdue = 0;
    
    foreach ($loans as $loan) {
        if ($loan->delinquency_status !== DAYSTAR_DELINQUENCY_CURRENT) {
            $delinquent_loans[] = $loan;
            
            // Calculate overdue amount (simplified - would need schedule data for accuracy)
            if ($loan->days_overdue > 0) {
                $total_overdue_amount += ($loan->balance * 0.1); // Rough estimate
            }
            
            // Track worst status
            if (daystar_get_delinquency_severity($loan->delinquency_status) > daystar_get_delinquency_severity($worst_status)) {
                $worst_status = $loan->delinquency_status;
            }
            
            if ($loan->days_overdue > $max_days_overdue) {
                $max_days_overdue = $loan->days_overdue;
            }
        }
    }
    
    return array(
        'is_blacklisted' => $is_blacklisted,
        'blacklist_info' => $is_blacklisted ? daystar_get_member_blacklist_info($user_id) : null,
        'total_loans' => count($loans),
        'delinquent_loans' => $delinquent_loans,
        'delinquent_count' => count($delinquent_loans),
        'worst_status' => $worst_status,
        'max_days_overdue' => $max_days_overdue,
        'estimated_overdue_amount' => $total_overdue_amount
    );
}

/**
 * Get delinquency severity for comparison
 */
function daystar_get_delinquency_severity($status) {
    $severity = array(
        DAYSTAR_DELINQUENCY_CURRENT => 0,
        DAYSTAR_DELINQUENCY_0_30 => 1,
        DAYSTAR_DELINQUENCY_31_60 => 2,
        DAYSTAR_DELINQUENCY_61_90 => 3,
        DAYSTAR_DELINQUENCY_90_PLUS => 4,
        DAYSTAR_DELINQUENCY_BLACKLISTED => 5
    );
    
    return isset($severity[$status]) ? $severity[$status] : 0;
}

/**
 * Get user-friendly delinquency status message
 */
function daystar_get_delinquency_status_message($status, $days_overdue = 0) {
    $messages = array(
        DAYSTAR_DELINQUENCY_CURRENT => 'All payments are up to date',
        DAYSTAR_DELINQUENCY_0_30 => "Payment overdue by $days_overdue days",
        DAYSTAR_DELINQUENCY_31_60 => "Payment seriously overdue by $days_overdue days",
        DAYSTAR_DELINQUENCY_61_90 => "Payment critically overdue by $days_overdue days",
        DAYSTAR_DELINQUENCY_90_PLUS => "Payment severely overdue by $days_overdue days - Risk of blacklisting",
        DAYSTAR_DELINQUENCY_BLACKLISTED => 'Account is blacklisted'
    );
    
    return isset($messages[$status]) ? $messages[$status] : 'Unknown status';
}

/**
 * Get delinquency status CSS class for styling
 */
function daystar_get_delinquency_status_class($status) {
    $classes = array(
        DAYSTAR_DELINQUENCY_CURRENT => 'status-current',
        DAYSTAR_DELINQUENCY_0_30 => 'status-warning',
        DAYSTAR_DELINQUENCY_31_60 => 'status-danger',
        DAYSTAR_DELINQUENCY_61_90 => 'status-critical',
        DAYSTAR_DELINQUENCY_90_PLUS => 'status-severe',
        DAYSTAR_DELINQUENCY_BLACKLISTED => 'status-blacklisted'
    );
    
    return isset($classes[$status]) ? $classes[$status] : 'status-unknown';
}

// Hook the cron job
add_action('daystar_daily_delinquency_check', 'daystar_calculate_loan_delinquency');

// Schedule the cron job on theme activation
add_action('after_switch_theme', 'daystar_schedule_delinquency_check');

// Unschedule on theme deactivation
add_action('switch_theme', 'daystar_unschedule_delinquency_check');