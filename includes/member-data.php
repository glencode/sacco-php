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