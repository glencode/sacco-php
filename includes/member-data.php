<?php
/**
 * Member Data Management Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get member's contribution history
 */
function daystar_get_member_contributions($user_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_contributions';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE user_id = %d ORDER BY contribution_date DESC",
        $user_id
    ));
}

/**
 * Get member's loan information
 */
function daystar_get_member_loans($user_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE user_id = %d ORDER BY loan_date DESC",
        $user_id
    ));
}

/**
 * Get member's account balance
 */
function daystar_get_member_balance($user_id) {
    global $wpdb;
    $contributions_table = $wpdb->prefix . 'daystar_contributions';

    // Calculate total contributions
    $total_contributions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT SUM(amount) FROM {$contributions_table} WHERE user_id = %d AND status = 'completed'",
            $user_id
        )
    );

    // Net balance is based on total completed contributions
    $balance = (float)($total_contributions ? $total_contributions : 0);

    return $balance;
}

/**
 * Get member's share capital balance
 */
function daystar_get_member_share_capital($user_id) {
    global $wpdb;
    $contributions_table = $wpdb->prefix . 'daystar_contributions';

    // Calculate total share capital contributions
    $share_capital = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT SUM(amount) FROM {$contributions_table} WHERE user_id = %d AND status = 'completed' AND is_share_capital = 1",
            $user_id
        )
    );

    return (float)($share_capital ? $share_capital : 0);
}

/**
 * Get member's regular contributions (excluding share capital)
 */
function daystar_get_member_regular_contributions($user_id) {
    global $wpdb;
    $contributions_table = $wpdb->prefix . 'daystar_contributions';

    // Calculate total regular contributions
    $regular_contributions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT SUM(amount) FROM {$contributions_table} WHERE user_id = %d AND status = 'completed' AND is_share_capital = 0",
            $user_id
        )
    );

    return (float)($regular_contributions ? $regular_contributions : 0);
}

/**
 * Verify consistent contributions over a specified period
 * 
 * @param int $user_id User ID
 * @param int $period_months Number of months to check
 * @param float $min_amount_per_month Minimum amount required per month
 * @return array Array with verification status and details
 */
function daystar_verify_consistent_contributions($user_id, $period_months = 6, $min_amount_per_month = 2000) {
    global $wpdb;
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    // Calculate the start date for the period
    $start_date = date('Y-m-d H:i:s', strtotime("-{$period_months} months"));
    
    // Get contributions for the specified period (excluding share capital)
    $contributions = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                DATE_FORMAT(contribution_date, '%%Y-%%m') as month_year,
                SUM(amount) as monthly_total
            FROM {$contributions_table} 
            WHERE user_id = %d 
                AND status = 'completed' 
                AND is_share_capital = 0
                AND contribution_date >= %s
            GROUP BY DATE_FORMAT(contribution_date, '%%Y-%%m')
            ORDER BY month_year ASC",
            $user_id,
            $start_date
        )
    );
    
    // Create array of expected months
    $expected_months = array();
    for ($i = $period_months - 1; $i >= 0; $i--) {
        $expected_months[] = date('Y-m', strtotime("-{$i} months"));
    }
    
    // Check each month
    $months_met = 0;
    $total_contributed = 0;
    $monthly_details = array();
    
    foreach ($expected_months as $expected_month) {
        $month_contribution = 0;
        
        // Find contribution for this month
        foreach ($contributions as $contribution) {
            if ($contribution->month_year === $expected_month) {
                $month_contribution = (float)$contribution->monthly_total;
                break;
            }
        }
        
        $meets_requirement = $month_contribution >= $min_amount_per_month;
        if ($meets_requirement) {
            $months_met++;
        }
        
        $total_contributed += $month_contribution;
        
        $monthly_details[] = array(
            'month' => $expected_month,
            'amount' => $month_contribution,
            'required' => $min_amount_per_month,
            'meets_requirement' => $meets_requirement
        );
    }
    
    $total_required = $period_months * $min_amount_per_month;
    $is_consistent = $months_met >= $period_months && $total_contributed >= $total_required;
    
    return array(
        'is_consistent' => $is_consistent,
        'months_met' => $months_met,
        'total_months' => $period_months,
        'total_contributed' => $total_contributed,
        'total_required' => $total_required,
        'monthly_details' => $monthly_details,
        'compliance_percentage' => ($months_met / $period_months) * 100
    );
}


/**
 * Get member's notifications
 */
function daystar_get_member_notifications($user_id, $limit = 10) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_notifications';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE user_id = %d ORDER BY created_at DESC LIMIT %d",
        $user_id,
        $limit
    ));
}

/**
 * Get unread notifications count
 */
function daystar_get_unread_notifications_count($user_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_notifications';
    
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$table_name} WHERE user_id = %d AND is_read = 0",
        $user_id
    ));
}

// Notification functions are handled in includes/dashboard-notifications.php
// - daystar_mark_notification_read()
// - daystar_mark_all_notifications_read()
// - daystar_add_notification()