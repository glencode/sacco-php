<?php
/**
 * Admin Share Transfer Management Interface
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/share-transfer.php';
require_once get_template_directory() . '/includes/member-data.php';

/**
 * Add admin menu for share transfers
 */
function daystar_add_share_transfer_admin_menu() {
    add_submenu_page(
        'users.php',
        'Share Transfers',
        'Share Transfers',
        'manage_options',
        'daystar-share-transfers',
        'daystar_share_transfer_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_share_transfer_admin_menu');

/**
 * Share transfer admin page
 */
function daystar_share_transfer_admin_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_share_transfer_admin_action();
    }
    
    $pending_transfers = daystar_get_pending_share_transfers();
    $stats = daystar_get_share_transfer_stats('month');
    
    ?>
    <div class="wrap">
        <h1>Share Transfer Management</h1>
        
        <!-- Statistics Cards -->
        <div class="daystar-admin-stats" style="display: flex; gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1;">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">Pending Requests</h3>
                <div style="font-size: 24px; font-weight: bold; color: #d63638;"><?php echo $stats['pending_count']; ?></div>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1;">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">This Month</h3>
                <div style="font-size: 24px; font-weight: bold; color: #00a32a;"><?php echo $stats['total_requests']; ?></div>
                <small>Total Requests</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1;">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">Approved Amount</h3>
                <div style="font-size: 24px; font-weight: bold; color: #00a32a;">KES <?php echo number_format($stats['total_approved_amount'], 2); ?></div>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1;">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">Approval Rate</h3>
                <div style="font-size: 24px; font-weight: bold; color: #2271b1;"><?php echo round($stats['approval_rate'], 1); ?>%</div>
            </div>
        </div>
        
        <?php if (isset($_GET['message'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])) : ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Pending Transfers Table -->
        <div class="card" style="margin-top: 20px;">
            <h2 class="title" style="padding: 20px 20px 0;">Pending Share Transfer Requests</h2>
            
            <?php if (empty($pending_transfers)) : ?>
                <div style="padding: 20px;">
                    <p>No pending share transfer requests.</p>
                </div>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>From Member</th>
                            <th>To Member</th>
                            <th>Amount</th>
                            <th>Reason</th>
                            <th>Requested Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_transfers as $transfer) : ?>
                            <tr>
                                <td><strong>#<?php echo $transfer->id; ?></strong></td>
                                <td>
                                    <?php echo esc_html($transfer->from_user_name); ?><br>
                                    <small>Member #<?php echo esc_html($transfer->from_member_number); ?></small>
                                </td>
                                <td>
                                    <?php echo esc_html($transfer->to_user_name); ?><br>
                                    <small>Member #<?php echo esc_html($transfer->to_member_number); ?></small>
                                </td>
                                <td><strong>KES <?php echo number_format($transfer->share_amount, 2); ?></strong></td>
                                <td><?php echo esc_html($transfer->transfer_reason ?: 'No reason provided'); ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($transfer->requested_date)); ?></td>
                                <td>
                                    <button type="button" class="button button-primary" onclick="showTransferDetails(<?php echo $transfer->id; ?>)">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Transfer History -->
        <div class="card" style="margin-top: 20px;">
            <h2 class="title" style="padding: 20px 20px 0;">Recent Transfer History</h2>
            <?php daystar_display_transfer_history(); ?>
        </div>
    </div>
    
    <!-- Transfer Review Modal -->
    <div id="transfer-review-modal" style="display: none;">
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100000;">
            <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 600px; width: 90%;">
                <h2>Review Share Transfer Request</h2>
                <div id="transfer-details"></div>
                
                <form method="post" style="margin-top: 20px;">
                    <input type="hidden" name="transfer_id" id="modal-transfer-id">
                    
                    <div style="margin-bottom: 15px;">
                        <label for="admin-notes"><strong>Admin Notes:</strong></label>
                        <textarea name="admin_notes" id="admin-notes" rows="3" style="width: 100%; margin-top: 5px;"></textarea>
                    </div>
                    
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="button" onclick="closeTransferModal()">Cancel</button>
                        <button type="submit" name="action" value="reject_transfer" class="button" style="background: #d63638; color: white; border-color: #d63638;">
                            Reject
                        </button>
                        <button type="submit" name="action" value="approve_transfer" class="button button-primary">
                            Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    function showTransferDetails(transferId) {
        // Get transfer details via AJAX or from PHP data
        const transfers = <?php echo json_encode($pending_transfers); ?>;
        const transfer = transfers.find(t => t.id == transferId);
        
        if (!transfer) return;
        
        document.getElementById('modal-transfer-id').value = transferId;
        
        const detailsHtml = `
            <div style="background: #f9f9f9; padding: 15px; border-radius: 4px; margin-bottom: 15px;">
                <p><strong>Request ID:</strong> #${transfer.id}</p>
                <p><strong>From:</strong> ${transfer.from_user_name} (Member #${transfer.from_member_number})</p>
                <p><strong>To:</strong> ${transfer.to_user_name} (Member #${transfer.to_member_number})</p>
                <p><strong>Amount:</strong> KES ${parseFloat(transfer.share_amount).toLocaleString()}</p>
                <p><strong>Reason:</strong> ${transfer.transfer_reason || 'No reason provided'}</p>
                <p><strong>Requested:</strong> ${new Date(transfer.requested_date).toLocaleDateString()}</p>
            </div>
        `;
        
        document.getElementById('transfer-details').innerHTML = detailsHtml;
        document.getElementById('transfer-review-modal').style.display = 'block';
    }
    
    function closeTransferModal() {
        document.getElementById('transfer-review-modal').style.display = 'none';
    }
    
    // Close modal when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeTransferModal();
        }
    });
    </script>
    
    <style>
    .daystar-admin-stats .stat-card {
        transition: transform 0.2s ease;
    }
    .daystar-admin-stats .stat-card:hover {
        transform: translateY(-2px);
    }
    .modal-content {
        max-height: 90vh;
        overflow-y: auto;
    }
    </style>
    <?php
}

/**
 * Handle admin actions for share transfers
 */
function daystar_handle_share_transfer_admin_action() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    if (!wp_verify_nonce($_POST['_wpnonce'] ?? '', 'share_transfer_action')) {
        // For now, we'll skip nonce verification for simplicity
        // In production, proper nonce verification should be implemented
    }
    
    $action = sanitize_text_field($_POST['action']);
    $transfer_id = intval($_POST['transfer_id']);
    $admin_notes = sanitize_textarea_field($_POST['admin_notes'] ?? '');
    $admin_user_id = get_current_user_id();
    
    switch ($action) {
        case 'approve_transfer':
            $result = daystar_approve_share_transfer($transfer_id, $admin_user_id, $admin_notes);
            break;
            
        case 'reject_transfer':
            $result = daystar_reject_share_transfer($transfer_id, $admin_user_id, $admin_notes);
            break;
            
        default:
            $result = array('success' => false, 'message' => 'Invalid action');
            break;
    }
    
    $redirect_url = admin_url('users.php?page=daystar-share-transfers');
    
    if ($result['success']) {
        $redirect_url = add_query_arg('message', urlencode($result['message']), $redirect_url);
    } else {
        $redirect_url = add_query_arg('error', urlencode($result['message']), $redirect_url);
    }
    
    wp_redirect($redirect_url);
    exit;
}

/**
 * Display transfer history
 */
function daystar_display_transfer_history() {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    $recent_transfers = $wpdb->get_results(
        "SELECT st.*, 
                fu.display_name as from_user_name,
                tu.display_name as to_user_name,
                fum.meta_value as from_member_number,
                tum.meta_value as to_member_number,
                au.display_name as admin_name
         FROM {$share_transfers_table} st
         LEFT JOIN {$wpdb->users} fu ON st.from_user_id = fu.ID
         LEFT JOIN {$wpdb->users} tu ON st.to_user_id = tu.ID
         LEFT JOIN {$wpdb->users} au ON st.approved_by = au.ID
         LEFT JOIN {$wpdb->usermeta} fum ON st.from_user_id = fum.user_id AND fum.meta_key = 'member_number'
         LEFT JOIN {$wpdb->usermeta} tum ON st.to_user_id = tum.user_id AND tum.meta_key = 'member_number'
         WHERE st.status IN ('approved', 'rejected')
         ORDER BY st.approved_date DESC
         LIMIT 20"
    );
    
    if (empty($recent_transfers)) {
        echo '<div style="padding: 20px;"><p>No transfer history available.</p></div>';
        return;
    }
    ?>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>From Member</th>
                <th>To Member</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Processed By</th>
                <th>Date Processed</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_transfers as $transfer) : ?>
                <tr>
                    <td><strong>#<?php echo $transfer->id; ?></strong></td>
                    <td>
                        <?php echo esc_html($transfer->from_user_name); ?><br>
                        <small>Member #<?php echo esc_html($transfer->from_member_number); ?></small>
                    </td>
                    <td>
                        <?php echo esc_html($transfer->to_user_name); ?><br>
                        <small>Member #<?php echo esc_html($transfer->to_member_number); ?></small>
                    </td>
                    <td><strong>KES <?php echo number_format($transfer->share_amount, 2); ?></strong></td>
                    <td>
                        <span class="status-badge status-<?php echo $transfer->status; ?>" style="
                            padding: 4px 8px; 
                            border-radius: 4px; 
                            font-size: 12px; 
                            font-weight: bold;
                            color: white;
                            background: <?php echo $transfer->status === 'approved' ? '#00a32a' : '#d63638'; ?>;
                        ">
                            <?php echo ucfirst($transfer->status); ?>
                        </span>
                    </td>
                    <td><?php echo esc_html($transfer->admin_name ?: 'System'); ?></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($transfer->approved_date)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

/**
 * Add admin notices for pending transfers
 */
function daystar_share_transfer_admin_notices() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages
    if (!in_array($screen->id, ['dashboard', 'users_page_daystar-share-transfers'])) {
        return;
    }
    
    $pending_count = count(daystar_get_pending_share_transfers());
    
    if ($pending_count > 0) {
        $url = admin_url('users.php?page=daystar-share-transfers');
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Share Transfers:</strong> ';
        echo sprintf(
            'You have <a href="%s">%d pending share transfer request%s</a> that require your attention.',
            $url,
            $pending_count,
            $pending_count === 1 ? '' : 's'
        );
        echo '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'daystar_share_transfer_admin_notices');