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