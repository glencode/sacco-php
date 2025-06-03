<?php
/**
 * Daystar Dashboard Notifications Functions
 *
 * Handles in-app notifications and alerts for the member dashboard
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register notification types
 */
function daystar_register_notification_types() {
    return array(
        'account' => array(
            'label' => 'Account',
            'icon' => 'user',
            'color' => '#3498db'
        ),
        'loan' => array(
            'label' => 'Loan',
            'icon' => 'money-bill',
            'color' => '#2ecc71'
        ),
        'payment' => array(
            'label' => 'Payment',
            'icon' => 'credit-card',
            'color' => '#f39c12'
        ),
        'system' => array(
            'label' => 'System',
            'icon' => 'bell',
            'color' => '#e74c3c'
        )
    );
}

/**
 * Add a notification for a user
 *
 * @param int $user_id User ID to add notification for
 * @param string $type Notification type (account, loan, payment, system)
 * @param string $title Notification title
 * @param string $message Notification message
 * @param string $link Optional link to redirect to when clicked
 * @return bool True if notification was added successfully, false otherwise
 */
function daystar_add_notification($user_id, $type, $title, $message, $link = '') {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        $notifications = array();
    }
    
    // Create new notification
    $notification = array(
        'id' => uniqid('notif_'),
        'type' => $type,
        'title' => $title,
        'message' => $message,
        'link' => $link,
        'date' => current_time('mysql'),
        'read' => false
    );
    
    // Add to beginning of array (newest first)
    array_unshift($notifications, $notification);
    
    // Limit to 50 notifications
    if (count($notifications) > 50) {
        $notifications = array_slice($notifications, 0, 50);
    }
    
    // Update user meta
    return update_user_meta($user_id, 'daystar_notifications', $notifications);
}

/**
 * Get notifications for a user
 *
 * @param int $user_id User ID to get notifications for
 * @param bool $unread_only Whether to get only unread notifications
 * @param int $limit Maximum number of notifications to return
 * @return array Array of notifications
 */
function daystar_get_notifications($user_id, $unread_only = false, $limit = 10) {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        return array();
    }
    
    // Filter unread if needed
    if ($unread_only) {
        $notifications = array_filter($notifications, function($notification) {
            return !$notification['read'];
        });
    }
    
    // Limit results
    if ($limit > 0 && count($notifications) > $limit) {
        $notifications = array_slice($notifications, 0, $limit);
    }
    
    return $notifications;
}

/**
 * Get unread notification count for a user
 *
 * @param int $user_id User ID to get count for
 * @return int Number of unread notifications
 */
function daystar_get_unread_notification_count($user_id) {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        return 0;
    }
    
    // Count unread
    $unread = 0;
    foreach ($notifications as $notification) {
        if (!$notification['read']) {
            $unread++;
        }
    }
    
    return $unread;
}

/**
 * Mark a notification as read
 *
 * @param int $user_id User ID the notification belongs to
 * @param string $notification_id ID of the notification to mark as read
 * @return bool True if notification was marked as read, false otherwise
 */
function daystar_mark_notification_read($user_id, $notification_id) {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        return false;
    }
    
    // Find and update notification
    $updated = false;
    foreach ($notifications as $key => $notification) {
        if ($notification['id'] === $notification_id) {
            $notifications[$key]['read'] = true;
            $updated = true;
            break;
        }
    }
    
    if ($updated) {
        // Update user meta
        return update_user_meta($user_id, 'daystar_notifications', $notifications);
    }
    
    return false;
}

/**
 * Mark all notifications as read for a user
 *
 * @param int $user_id User ID to mark all notifications as read for
 * @return bool True if notifications were marked as read, false otherwise
 */
function daystar_mark_all_notifications_read($user_id) {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        return false;
    }
    
    // Mark all as read
    foreach ($notifications as $key => $notification) {
        $notifications[$key]['read'] = true;
    }
    
    // Update user meta
    return update_user_meta($user_id, 'daystar_notifications', $notifications);
}

/**
 * Delete a notification
 *
 * @param int $user_id User ID the notification belongs to
 * @param string $notification_id ID of the notification to delete
 * @return bool True if notification was deleted, false otherwise
 */
function daystar_delete_notification($user_id, $notification_id) {
    // Get existing notifications
    $notifications = get_user_meta($user_id, 'daystar_notifications', true);
    if (!is_array($notifications)) {
        return false;
    }
    
    // Find and remove notification
    $updated = false;
    foreach ($notifications as $key => $notification) {
        if ($notification['id'] === $notification_id) {
            unset($notifications[$key]);
            $updated = true;
            break;
        }
    }
    
    if ($updated) {
        // Reindex array
        $notifications = array_values($notifications);
        
        // Update user meta
        return update_user_meta($user_id, 'daystar_notifications', $notifications);
    }
    
    return false;
}

/**
 * Clear all notifications for a user
 *
 * @param int $user_id User ID to clear notifications for
 * @return bool True if notifications were cleared, false otherwise
 */
function daystar_clear_all_notifications($user_id) {
    return update_user_meta($user_id, 'daystar_notifications', array());
}

/**
 * Add notification for membership approval
 */
function daystar_add_membership_approved_notification($user_id) {
    $member_number = get_user_meta($user_id, 'member_number', true);
    
    return daystar_add_notification(
        $user_id,
        'account',
        'Membership Approved',
        'Your membership application has been approved! Your member number is ' . $member_number . '.',
        home_url('/member-dashboard/')
    );
}

/**
 * Add notification for loan application submission
 */
function daystar_add_loan_application_notification($user_id, $application_id) {
    return daystar_add_notification(
        $user_id,
        'loan',
        'Loan Application Submitted',
        'Your loan application (' . $application_id . ') has been submitted and is under review.',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for loan approval
 */
function daystar_add_loan_approved_notification($user_id, $application_id, $amount) {
    return daystar_add_notification(
        $user_id,
        'loan',
        'Loan Approved',
        'Your loan application (' . $application_id . ') for KES ' . number_format($amount, 2) . ' has been approved!',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for loan rejection
 */
function daystar_add_loan_rejected_notification($user_id, $application_id) {
    return daystar_add_notification(
        $user_id,
        'loan',
        'Loan Application Update',
        'Your loan application (' . $application_id . ') could not be approved at this time.',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for loan disbursement
 */
function daystar_add_loan_disbursed_notification($user_id, $application_id, $amount) {
    return daystar_add_notification(
        $user_id,
        'loan',
        'Loan Disbursed',
        'Your approved loan (' . $application_id . ') of KES ' . number_format($amount, 2) . ' has been disbursed to your bank account.',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for payment received
 */
function daystar_add_payment_received_notification($user_id, $payment_reference, $amount, $purpose) {
    return daystar_add_notification(
        $user_id,
        'payment',
        'Payment Received',
        'Your payment of KES ' . number_format($amount, 2) . ' for ' . ucfirst(str_replace('_', ' ', $purpose)) . ' has been received and processed.',
        home_url('/member-dashboard/?tab=contributions')
    );
}

/**
 * Add notification for upcoming loan payment
 */
function daystar_add_upcoming_payment_notification($user_id, $loan_id, $amount, $due_date) {
    return daystar_add_notification(
        $user_id,
        'payment',
        'Upcoming Loan Payment',
        'Your loan payment of KES ' . number_format($amount, 2) . ' is due on ' . date('F j, Y', strtotime($due_date)) . '.',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for overdue loan payment
 */
function daystar_add_overdue_payment_notification($user_id, $loan_id, $amount, $due_date) {
    return daystar_add_notification(
        $user_id,
        'payment',
        'Overdue Loan Payment',
        'Your loan payment of KES ' . number_format($amount, 2) . ' was due on ' . date('F j, Y', strtotime($due_date)) . ' and is now overdue.',
        home_url('/member-dashboard/?tab=loans')
    );
}

/**
 * Add notification for system maintenance
 */
function daystar_add_system_maintenance_notification($user_id, $start_time, $end_time) {
    return daystar_add_notification(
        $user_id,
        'system',
        'Scheduled Maintenance',
        'The system will be undergoing maintenance from ' . date('F j, Y, g:i a', strtotime($start_time)) . ' to ' . date('F j, Y, g:i a', strtotime($end_time)) . '. Some services may be unavailable during this time.',
        ''
    );
}

/**
 * Add notification for new feature
 */
function daystar_add_new_feature_notification($user_id, $feature_name, $feature_description) {
    return daystar_add_notification(
        $user_id,
        'system',
        'New Feature: ' . $feature_name,
        $feature_description,
        home_url('/member-dashboard/')
    );
}

/**
 * AJAX handler for marking notification as read
 */
function daystar_ajax_mark_notification_read() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to perform this action.');
        exit;
    }
    
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_notification_nonce')) {
        wp_send_json_error('Security check failed.');
        exit;
    }
    
    // Get notification ID
    $notification_id = isset($_POST['notification_id']) ? sanitize_text_field($_POST['notification_id']) : '';
    if (empty($notification_id)) {
        wp_send_json_error('Notification ID is required.');
        exit;
    }
    
    // Mark notification as read
    $user_id = get_current_user_id();
    $result = daystar_mark_notification_read($user_id, $notification_id);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'Notification marked as read.',
            'unread_count' => daystar_get_unread_notification_count($user_id)
        ));
    } else {
        wp_send_json_error('Failed to mark notification as read.');
    }
    exit;
}
add_action('wp_ajax_daystar_mark_notification_read', 'daystar_ajax_mark_notification_read');

/**
 * AJAX handler for marking all notifications as read
 */
function daystar_ajax_mark_all_notifications_read() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to perform this action.');
        exit;
    }
    
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_notification_nonce')) {
        wp_send_json_error('Security check failed.');
        exit;
    }
    
    // Mark all notifications as read
    $user_id = get_current_user_id();
    $result = daystar_mark_all_notifications_read($user_id);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'All notifications marked as read.',
            'unread_count' => 0
        ));
    } else {
        wp_send_json_error('Failed to mark notifications as read.');
    }
    exit;
}
add_action('wp_ajax_daystar_mark_all_notifications_read', 'daystar_ajax_mark_all_notifications_read');

/**
 * AJAX handler for deleting a notification
 */
function daystar_ajax_delete_notification() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to perform this action.');
        exit;
    }
    
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_notification_nonce')) {
        wp_send_json_error('Security check failed.');
        exit;
    }
    
    // Get notification ID
    $notification_id = isset($_POST['notification_id']) ? sanitize_text_field($_POST['notification_id']) : '';
    if (empty($notification_id)) {
        wp_send_json_error('Notification ID is required.');
        exit;
    }
    
    // Delete notification
    $user_id = get_current_user_id();
    $result = daystar_delete_notification($user_id, $notification_id);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'Notification deleted.',
            'unread_count' => daystar_get_unread_notification_count($user_id)
        ));
    } else {
        wp_send_json_error('Failed to delete notification.');
    }
    exit;
}
add_action('wp_ajax_daystar_delete_notification', 'daystar_ajax_delete_notification');

/**
 * AJAX handler for clearing all notifications
 */
function daystar_ajax_clear_all_notifications() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to perform this action.');
        exit;
    }
    
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_notification_nonce')) {
        wp_send_json_error('Security check failed.');
        exit;
    }
    
    // Clear all notifications
    $user_id = get_current_user_id();
    $result = daystar_clear_all_notifications($user_id);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'All notifications cleared.',
            'unread_count' => 0
        ));
    } else {
        wp_send_json_error('Failed to clear notifications.');
    }
    exit;
}
add_action('wp_ajax_daystar_clear_all_notifications', 'daystar_ajax_clear_all_notifications');

/**
 * Render notifications dropdown for member dashboard
 */
function daystar_render_notifications_dropdown() {
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $notifications = daystar_get_notifications($user_id, false, 5);
    $unread_count = daystar_get_unread_notification_count($user_id);
    $notification_types = daystar_register_notification_types();
    
    ?>
    <div class="notifications-dropdown">
        <a href="#" class="notifications-toggle" id="notifications-toggle">
            <i class="fas fa-bell"></i>
            <?php if ($unread_count > 0) : ?>
                <span class="notifications-badge"><?php echo esc_html($unread_count); ?></span>
            <?php endif; ?>
        </a>
        
        <div class="notifications-panel" id="notifications-panel" style="display: none;">
            <div class="notifications-header">
                <h3>Notifications</h3>
                <?php if ($unread_count > 0) : ?>
                    <a href="#" class="mark-all-read" id="mark-all-read">Mark all as read</a>
                <?php endif; ?>
            </div>
            
            <div class="notifications-list">
                <?php if (!empty($notifications)) : ?>
                    <?php foreach ($notifications as $notification) : ?>
                        <div class="notification-item <?php echo $notification['read'] ? '' : 'unread'; ?>" data-id="<?php echo esc_attr($notification['id']); ?>">
                            <div class="notification-icon" style="background-color: <?php echo esc_attr($notification_types[$notification['type']]['color']); ?>">
                                <i class="fas fa-<?php echo esc_attr($notification_types[$notification['type']]['icon']); ?>"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title"><?php echo esc_html($notification['title']); ?></div>
                                <div class="notification-message"><?php echo esc_html($notification['message']); ?></div>
                                <div class="notification-time"><?php echo human_time_diff(strtotime($notification['date']), current_time('timestamp')) . ' ago'; ?></div>
                            </div>
                            <div class="notification-actions">
                                <a href="#" class="notification-mark-read" title="Mark as read"><i class="fas fa-check"></i></a>
                                <a href="#" class="notification-delete" title="Delete"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="notification-empty">
                        <p>No notifications to display.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="notifications-footer">
                <a href="<?php echo home_url('/member-dashboard/?tab=notifications'); ?>">View all notifications</a>
                <?php if (!empty($notifications)) : ?>
                    <a href="#" id="clear-all-notifications">Clear all</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Toggle notifications panel
        $('#notifications-toggle').on('click', function(e) {
            e.preventDefault();
            $('#notifications-panel').toggle();
        });
        
        // Close panel when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.notifications-dropdown').length) {
                $('#notifications-panel').hide();
            }
        });
        
        // Mark notification as read
        $('.notification-mark-read').on('click', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.notification-item');
            var notificationId = $item.data('id');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_mark_notification_read',
                    notification_id: notificationId,
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $item.removeClass('unread');
                        updateNotificationBadge(response.data.unread_count);
                    }
                }
            });
        });
        
        // Mark all notifications as read
        $('#mark-all-read').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_mark_all_notifications_read',
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $('.notification-item').removeClass('unread');
                        updateNotificationBadge(0);
                        $('#mark-all-read').hide();
                    }
                }
            });
        });
        
        // Delete notification
        $('.notification-delete').on('click', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.notification-item');
            var notificationId = $item.data('id');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_delete_notification',
                    notification_id: notificationId,
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            
                            if ($('.notification-item').length === 0) {
                                $('.notifications-list').html('<div class="notification-empty"><p>No notifications to display.</p></div>');
                                $('#clear-all-notifications').hide();
                            }
                            
                            updateNotificationBadge(response.data.unread_count);
                        });
                    }
                }
            });
        });
        
        // Clear all notifications
        $('#clear-all-notifications').on('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to clear all notifications?')) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'daystar_clear_all_notifications',
                        nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.notifications-list').html('<div class="notification-empty"><p>No notifications to display.</p></div>');
                            updateNotificationBadge(0);
                            $('#mark-all-read').hide();
                            $('#clear-all-notifications').hide();
                        }
                    }
                });
            }
        });
        
        // Update notification badge
        function updateNotificationBadge(count) {
            if (count > 0) {
                if ($('.notifications-badge').length) {
                    $('.notifications-badge').text(count);
                } else {
                    $('#notifications-toggle').append('<span class="notifications-badge">' + count + '</span>');
                }
            } else {
                $('.notifications-badge').remove();
            }
        }
        
        // Open notification link when clicking on notification content
        $('.notification-content').on('click', function() {
            var $item = $(this).closest('.notification-item');
            var notificationId = $item.data('id');
            var link = '<?php echo home_url('/member-dashboard/?tab=notifications'); ?>';
            
            // Mark as read first
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_mark_notification_read',
                    notification_id: notificationId,
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = link;
                    }
                }
            });
        });
    });
    </script>
    
    <style>
        .notifications-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .notifications-toggle {
            position: relative;
            display: inline-block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }
        
        .notifications-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            line-height: 1;
        }
        
        .notifications-panel {
            position: absolute;
            top: 100%;
            right: 0;
            width: 350px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        
        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .notifications-header h3 {
            margin: 0;
            font-size: 16px;
        }
        
        .mark-all-read {
            font-size: 12px;
            color: #3498db;
            text-decoration: none;
        }
        
        .notifications-list {
            max-height: 350px;
            overflow-y: auto;
        }
        
        .notification-item {
            display: flex;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        
        .notification-item.unread {
            background-color: #f0f8ff;
        }
        
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
        }
        
        .notification-content {
            flex: 1;
            cursor: pointer;
        }
        
        .notification-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .notification-message {
            font-size: 13px;
            color: #666;
            margin-bottom: 3px;
        }
        
        .notification-time {
            font-size: 11px;
            color: #999;
        }
        
        .notification-actions {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .notification-item:hover .notification-actions {
            opacity: 1;
        }
        
        .notification-actions a {
            color: #999;
            font-size: 12px;
            padding: 3px;
        }
        
        .notification-actions a:hover {
            color: #333;
        }
        
        .notification-empty {
            padding: 20px;
            text-align: center;
            color: #999;
        }
        
        .notifications-footer {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-top: 1px solid #eee;
            font-size: 12px;
        }
        
        .notifications-footer a {
            color: #3498db;
            text-decoration: none;
        }
        
        @media (max-width: 480px) {
            .notifications-panel {
                width: 300px;
                right: -100px;
            }
        }
    </style>
    <?php
}

/**
 * Render notifications page for member dashboard
 */
function daystar_render_notifications_page() {
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $notifications = daystar_get_notifications($user_id);
    $notification_types = daystar_register_notification_types();
    
    ?>
    <div class="notifications-page">
        <div class="notifications-header">
            <h2>Notifications</h2>
            <div class="notifications-actions">
                <?php if (!empty($notifications)) : ?>
                    <button id="mark-all-read-btn" class="btn btn-sm btn-outline-primary">Mark All as Read</button>
                    <button id="clear-all-btn" class="btn btn-sm btn-outline-danger">Clear All</button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="notifications-filters">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" data-filter="all">All</button>
                <button type="button" class="btn btn-outline-secondary" data-filter="unread">Unread</button>
                <?php foreach ($notification_types as $type => $data) : ?>
                    <button type="button" class="btn btn-outline-secondary" data-filter="<?php echo esc_attr($type); ?>"><?php echo esc_html($data['label']); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="notifications-list-container">
            <?php if (!empty($notifications)) : ?>
                <div class="notifications-list">
                    <?php foreach ($notifications as $notification) : ?>
                        <div class="notification-item <?php echo $notification['read'] ? '' : 'unread'; ?>" data-id="<?php echo esc_attr($notification['id']); ?>" data-type="<?php echo esc_attr($notification['type']); ?>">
                            <div class="notification-icon" style="background-color: <?php echo esc_attr($notification_types[$notification['type']]['color']); ?>">
                                <i class="fas fa-<?php echo esc_attr($notification_types[$notification['type']]['icon']); ?>"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title"><?php echo esc_html($notification['title']); ?></div>
                                <div class="notification-message"><?php echo esc_html($notification['message']); ?></div>
                                <div class="notification-time"><?php echo human_time_diff(strtotime($notification['date']), current_time('timestamp')) . ' ago'; ?></div>
                            </div>
                            <div class="notification-actions">
                                <?php if (!$notification['read']) : ?>
                                    <button class="btn btn-sm btn-outline-primary notification-mark-read">Mark as Read</button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-danger notification-delete">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="notification-empty">
                    <p>You have no notifications.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Filter notifications
        $('.notifications-filters button').on('click', function() {
            var filter = $(this).data('filter');
            
            // Update active button
            $('.notifications-filters button').removeClass('active');
            $(this).addClass('active');
            
            // Filter items
            if (filter === 'all') {
                $('.notification-item').show();
            } else if (filter === 'unread') {
                $('.notification-item').hide();
                $('.notification-item.unread').show();
            } else {
                $('.notification-item').hide();
                $('.notification-item[data-type="' + filter + '"]').show();
            }
            
            // Show empty message if no items visible
            if ($('.notification-item:visible').length === 0) {
                if ($('.notification-empty').length === 0) {
                    $('.notifications-list').append('<div class="notification-empty"><p>No notifications match the selected filter.</p></div>');
                } else {
                    $('.notification-empty').show();
                }
            } else {
                $('.notification-empty').hide();
            }
        });
        
        // Mark notification as read
        $('.notification-mark-read').on('click', function() {
            var $item = $(this).closest('.notification-item');
            var notificationId = $item.data('id');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_mark_notification_read',
                    notification_id: notificationId,
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $item.removeClass('unread');
                        $item.find('.notification-mark-read').remove();
                    }
                }
            });
        });
        
        // Delete notification
        $('.notification-delete').on('click', function() {
            var $item = $(this).closest('.notification-item');
            var notificationId = $item.data('id');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_delete_notification',
                    notification_id: notificationId,
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            
                            if ($('.notification-item').length === 0) {
                                $('.notifications-list').html('<div class="notification-empty"><p>You have no notifications.</p></div>');
                                $('#mark-all-read-btn, #clear-all-btn').hide();
                            }
                        });
                    }
                }
            });
        });
        
        // Mark all as read
        $('#mark-all-read-btn').on('click', function() {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'daystar_mark_all_notifications_read',
                    nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $('.notification-item').removeClass('unread');
                        $('.notification-mark-read').remove();
                    }
                }
            });
        });
        
        // Clear all notifications
        $('#clear-all-btn').on('click', function() {
            if (confirm('Are you sure you want to clear all notifications?')) {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'daystar_clear_all_notifications',
                        nonce: '<?php echo wp_create_nonce('daystar_notification_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.notifications-list').html('<div class="notification-empty"><p>You have no notifications.</p></div>');
                            $('#mark-all-read-btn, #clear-all-btn').hide();
                        }
                    }
                });
            }
        });
    });
    </script>
    
    <style>
        .notifications-page {
            margin-bottom: 30px;
        }
        
        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .notifications-filters {
            margin-bottom: 20px;
        }
        
        .notifications-list-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .notification-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        
        .notification-item.unread {
            background-color: #f0f8ff;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .notification-message {
            color: #666;
            margin-bottom: 5px;
        }
        
        .notification-time {
            font-size: 12px;
            color: #999;
        }
        
        .notification-actions {
            display: flex;
            gap: 10px;
        }
        
        .notification-empty {
            padding: 30px;
            text-align: center;
            color: #999;
        }
        
        @media (max-width: 768px) {
            .notifications-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .notifications-actions {
                margin-top: 10px;
            }
            
            .notifications-filters .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .notification-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .notification-icon {
                margin-bottom: 10px;
            }
            
            .notification-actions {
                margin-top: 10px;
                align-self: flex-end;
            }
        }
    </style>
    <?php
}
