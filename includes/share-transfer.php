<?php
/**
 * Share Transfer Management Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Request a share transfer
 * 
 * @param int $from_user_id User ID transferring shares
 * @param int $to_user_id User ID receiving shares
 * @param float $share_amount Amount of shares to transfer
 * @param string $reason Reason for transfer
 * @return array Result with success status and message
 */
function daystar_request_share_transfer($from_user_id, $to_user_id, $share_amount, $reason = '') {
    global $wpdb;
    
    // Validate users exist and are active members
    $from_user = get_user_by('ID', $from_user_id);
    $to_user = get_user_by('ID', $to_user_id);
    
    if (!$from_user || !$to_user) {
        return array(
            'success' => false,
            'message' => 'Invalid user(s) specified for transfer.'
        );
    }
    
    // Check if both users are active members
    $from_status = get_user_meta($from_user_id, 'member_status', true);
    $to_status = get_user_meta($to_user_id, 'member_status', true);
    
    if ($from_status !== 'active') {
        return array(
            'success' => false,
            'message' => 'Transfer initiator must be an active member.'
        );
    }
    
    if ($to_status !== 'active') {
        return array(
            'success' => false,
            'message' => 'Transfer recipient must be an active member.'
        );
    }
    
    // Check if from_user has sufficient share capital
    $available_shares = daystar_get_member_share_capital($from_user_id);
    
    if ($share_amount > $available_shares) {
        return array(
            'success' => false,
            'message' => 'Insufficient share capital for transfer. Available: KES ' . number_format($available_shares, 2)
        );
    }
    
    // Validate minimum transfer amount
    if ($share_amount < 1000) {
        return array(
            'success' => false,
            'message' => 'Minimum transfer amount is KES 1,000.'
        );
    }
    
    // Insert transfer request
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    $result = $wpdb->insert(
        $share_transfers_table,
        array(
            'from_user_id' => $from_user_id,
            'to_user_id' => $to_user_id,
            'share_amount' => $share_amount,
            'transfer_reason' => $reason,
            'status' => 'pending',
            'requested_date' => current_time('mysql')
        ),
        array('%d', '%d', '%f', '%s', '%s', '%s')
    );
    
    if ($result === false) {
        return array(
            'success' => false,
            'message' => 'Failed to create transfer request. Please try again.'
        );
    }
    
    $transfer_id = $wpdb->insert_id;
    
    // Send notification to admin
    daystar_notify_admin_share_transfer($transfer_id);
    
    // Send notification to both users
    daystar_add_notification(
        $from_user_id,
        'Share Transfer Request Submitted',
        "Your request to transfer KES " . number_format($share_amount, 2) . " in shares has been submitted for approval.",
        'share_transfer'
    );
    
    daystar_add_notification(
        $to_user_id,
        'Share Transfer Request Received',
        "A request to transfer KES " . number_format($share_amount, 2) . " in shares to your account is pending approval.",
        'share_transfer'
    );
    
    return array(
        'success' => true,
        'message' => 'Share transfer request submitted successfully.',
        'transfer_id' => $transfer_id
    );
}

/**
 * Get share transfer requests for a user
 * 
 * @param int $user_id User ID
 * @param string $type 'sent', 'received', or 'all'
 * @return array Transfer requests
 */
function daystar_get_user_share_transfers($user_id, $type = 'all') {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    $where_clause = '';
    switch ($type) {
        case 'sent':
            $where_clause = "WHERE from_user_id = %d";
            break;
        case 'received':
            $where_clause = "WHERE to_user_id = %d";
            break;
        default:
            $where_clause = "WHERE (from_user_id = %d OR to_user_id = %d)";
            break;
    }
    
    $query = "SELECT * FROM {$share_transfers_table} {$where_clause} ORDER BY requested_date DESC";
    
    if ($type === 'all') {
        return $wpdb->get_results($wpdb->prepare($query, $user_id, $user_id));
    } else {
        return $wpdb->get_results($wpdb->prepare($query, $user_id));
    }
}

/**
 * Approve a share transfer (admin function)
 * 
 * @param int $transfer_id Transfer ID
 * @param int $admin_user_id Admin user ID
 * @param string $notes Admin notes
 * @return array Result with success status and message
 */
function daystar_approve_share_transfer($transfer_id, $admin_user_id, $notes = '') {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    // Get transfer details
    $transfer = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$share_transfers_table} WHERE id = %d AND status = 'pending'",
        $transfer_id
    ));
    
    if (!$transfer) {
        return array(
            'success' => false,
            'message' => 'Transfer request not found or already processed.'
        );
    }
    
    // Start transaction
    $wpdb->query('START TRANSACTION');
    
    try {
        // Verify from_user still has sufficient shares
        $available_shares = daystar_get_member_share_capital($transfer->from_user_id);
        
        if ($transfer->share_amount > $available_shares) {
            throw new Exception('Insufficient share capital for transfer.');
        }
        
        // Create debit entry for from_user (negative share capital contribution)
        $debit_result = $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $transfer->from_user_id,
                'amount' => -$transfer->share_amount,
                'contribution_type' => 'share_transfer_out',
                'is_share_capital' => 1,
                'status' => 'completed',
                'payment_method' => 'share_transfer',
                'reference_number' => 'ST_OUT_' . $transfer_id,
                'notes' => 'Share transfer to member #' . get_user_meta($transfer->to_user_id, 'member_number', true) . '. ' . $notes
            )
        );
        
        if ($debit_result === false) {
            throw new Exception('Failed to process share debit.');
        }
        
        // Create credit entry for to_user (positive share capital contribution)
        $credit_result = $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $transfer->to_user_id,
                'amount' => $transfer->share_amount,
                'contribution_type' => 'share_transfer_in',
                'is_share_capital' => 1,
                'status' => 'completed',
                'payment_method' => 'share_transfer',
                'reference_number' => 'ST_IN_' . $transfer_id,
                'notes' => 'Share transfer from member #' . get_user_meta($transfer->from_user_id, 'member_number', true) . '. ' . $notes
            )
        );
        
        if ($credit_result === false) {
            throw new Exception('Failed to process share credit.');
        }
        
        // Update transfer status
        $update_result = $wpdb->update(
            $share_transfers_table,
            array(
                'status' => 'approved',
                'approved_by' => $admin_user_id,
                'approved_date' => current_time('mysql'),
                'processed_date' => current_time('mysql'),
                'notes' => $notes
            ),
            array('id' => $transfer_id),
            array('%s', '%d', '%s', '%s', '%s'),
            array('%d')
        );
        
        if ($update_result === false) {
            throw new Exception('Failed to update transfer status.');
        }
        
        // Commit transaction
        $wpdb->query('COMMIT');
        
        // Send notifications
        daystar_add_notification(
            $transfer->from_user_id,
            'Share Transfer Approved',
            "Your share transfer of KES " . number_format($transfer->share_amount, 2) . " has been approved and processed.",
            'share_transfer'
        );
        
        daystar_add_notification(
            $transfer->to_user_id,
            'Share Transfer Received',
            "You have received KES " . number_format($transfer->share_amount, 2) . " in share capital transfer.",
            'share_transfer'
        );
        
        return array(
            'success' => true,
            'message' => 'Share transfer approved and processed successfully.'
        );
        
    } catch (Exception $e) {
        // Rollback transaction
        $wpdb->query('ROLLBACK');
        
        return array(
            'success' => false,
            'message' => 'Transfer approval failed: ' . $e->getMessage()
        );
    }
}

/**
 * Reject a share transfer (admin function)
 * 
 * @param int $transfer_id Transfer ID
 * @param int $admin_user_id Admin user ID
 * @param string $reason Rejection reason
 * @return array Result with success status and message
 */
function daystar_reject_share_transfer($transfer_id, $admin_user_id, $reason = '') {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    // Get transfer details
    $transfer = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$share_transfers_table} WHERE id = %d AND status = 'pending'",
        $transfer_id
    ));
    
    if (!$transfer) {
        return array(
            'success' => false,
            'message' => 'Transfer request not found or already processed.'
        );
    }
    
    // Update transfer status
    $result = $wpdb->update(
        $share_transfers_table,
        array(
            'status' => 'rejected',
            'approved_by' => $admin_user_id,
            'approved_date' => current_time('mysql'),
            'notes' => $reason
        ),
        array('id' => $transfer_id),
        array('%s', '%d', '%s', '%s'),
        array('%d')
    );
    
    if ($result === false) {
        return array(
            'success' => false,
            'message' => 'Failed to reject transfer request.'
        );
    }
    
    // Send notifications
    daystar_add_notification(
        $transfer->from_user_id,
        'Share Transfer Rejected',
        "Your share transfer request has been rejected. Reason: " . $reason,
        'share_transfer'
    );
    
    daystar_add_notification(
        $transfer->to_user_id,
        'Share Transfer Request Rejected',
        "A share transfer request intended for your account has been rejected.",
        'share_transfer'
    );
    
    return array(
        'success' => true,
        'message' => 'Share transfer rejected successfully.'
    );
}

/**
 * Get all pending share transfers (admin function)
 * 
 * @return array Pending transfers
 */
function daystar_get_pending_share_transfers() {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    return $wpdb->get_results(
        "SELECT st.*, 
                fu.display_name as from_user_name,
                tu.display_name as to_user_name,
                fum.meta_value as from_member_number,
                tum.meta_value as to_member_number
         FROM {$share_transfers_table} st
         LEFT JOIN {$wpdb->users} fu ON st.from_user_id = fu.ID
         LEFT JOIN {$wpdb->users} tu ON st.to_user_id = tu.ID
         LEFT JOIN {$wpdb->usermeta} fum ON st.from_user_id = fum.user_id AND fum.meta_key = 'member_number'
         LEFT JOIN {$wpdb->usermeta} tum ON st.to_user_id = tum.user_id AND tum.meta_key = 'member_number'
         WHERE st.status = 'pending'
         ORDER BY st.requested_date ASC"
    );
}

/**
 * Notify admin about new share transfer request
 * 
 * @param int $transfer_id Transfer ID
 */
function daystar_notify_admin_share_transfer($transfer_id) {
    // Get admin users
    $admin_users = get_users(array('role' => 'administrator'));
    
    foreach ($admin_users as $admin) {
        daystar_add_notification(
            $admin->ID,
            'New Share Transfer Request',
            "A new share transfer request (#$transfer_id) requires your review and approval.",
            'admin_alert'
        );
    }
}

/**
 * Get share transfer statistics
 * 
 * @param string $period 'month', 'quarter', 'year'
 * @return array Statistics
 */
function daystar_get_share_transfer_stats($period = 'month') {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    // Calculate date range
    switch ($period) {
        case 'quarter':
            $start_date = date('Y-m-d', strtotime('-3 months'));
            break;
        case 'year':
            $start_date = date('Y-m-d', strtotime('-1 year'));
            break;
        default:
            $start_date = date('Y-m-d', strtotime('-1 month'));
            break;
    }
    
    $stats = $wpdb->get_row($wpdb->prepare(
        "SELECT 
            COUNT(*) as total_requests,
            COUNT(CASE WHEN status = 'approved' THEN 1 END) as approved_count,
            COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected_count,
            COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
            SUM(CASE WHEN status = 'approved' THEN share_amount ELSE 0 END) as total_approved_amount
         FROM {$share_transfers_table}
         WHERE requested_date >= %s",
        $start_date
    ));
    
    return array(
        'period' => $period,
        'total_requests' => (int)$stats->total_requests,
        'approved_count' => (int)$stats->approved_count,
        'rejected_count' => (int)$stats->rejected_count,
        'pending_count' => (int)$stats->pending_count,
        'total_approved_amount' => (float)$stats->total_approved_amount,
        'approval_rate' => $stats->total_requests > 0 ? ($stats->approved_count / $stats->total_requests) * 100 : 0
    );
}