<?php
/**
 * Member Auto-Approval System
 * Automatically approves pending members and sets up their accounts
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Auto-approve all pending members
 */
function daystar_auto_approve_pending_members() {
    global $wpdb;
    
    // Get all pending members
    $pending_members = get_users(array(
        'meta_key' => 'member_status',
        'meta_value' => 'pending',
        'fields' => 'all'
    ));
    
    $approved_count = 0;
    $results = array();
    
    foreach ($pending_members as $member) {
        $result = daystar_auto_approve_single_member($member->ID);
        if ($result['success']) {
            $approved_count++;
        }
        $results[] = $result;
    }
    
    return array(
        'success' => true,
        'approved_count' => $approved_count,
        'total_pending' => count($pending_members),
        'details' => $results
    );
}

/**
 * Approve a specific member (auto-approval version)
 */
function daystar_auto_approve_single_member($user_id) {
    global $wpdb;
    
    $user = get_user_by('ID', $user_id);
    if (!$user) {
        return array(
            'success' => false,
            'message' => 'User not found',
            'user_id' => $user_id
        );
    }
    
    $current_status = get_user_meta($user_id, 'member_status', true);
    if ($current_status !== 'pending') {
        return array(
            'success' => false,
            'message' => 'Member is not pending approval',
            'user_id' => $user_id,
            'current_status' => $current_status
        );
    }
    
    // Update member status to active
    update_user_meta($user_id, 'member_status', 'active');
    
    // Set approval date
    update_user_meta($user_id, 'approval_date', current_time('mysql'));
    
    // Set approved by (current user or admin)
    $approved_by = get_current_user_id() ?: 1;
    update_user_meta($user_id, 'approved_by', $approved_by);
    
    // Generate member number if not exists
    $member_number = get_user_meta($user_id, 'member_number', true);
    if (empty($member_number)) {
        $member_number = daystar_generate_member_number();
        update_user_meta($user_id, 'member_number', $member_number);
    }
    
    // Set default member role if not set
    $sacco_role = get_user_meta($user_id, 'sacco_role', true);
    if (empty($sacco_role)) {
        update_user_meta($user_id, 'sacco_role', 'member');
    }
    
    // Set registration date if not set
    $registration_date = get_user_meta($user_id, 'registration_date', true);
    if (empty($registration_date)) {
        update_user_meta($user_id, 'registration_date', current_time('Y-m-d'));
    }
    
    // Create initial share capital contribution if required
    daystar_create_initial_share_capital($user_id);
    
    // Send approval notification
    daystar_send_approval_notification($user_id);
    
    // Log the approval
    daystar_log_member_approval($user_id, $approved_by);
    
    return array(
        'success' => true,
        'message' => 'Member approved successfully',
        'user_id' => $user_id,
        'member_number' => $member_number,
        'user_name' => $user->display_name
    );
}

/**
 * Generate a unique member number
 */
function daystar_generate_member_number() {
    global $wpdb;
    
    // Get the highest existing member number
    $highest_number = $wpdb->get_var(
        "SELECT MAX(CAST(SUBSTRING(meta_value, 3) AS UNSIGNED)) 
         FROM {$wpdb->usermeta} 
         WHERE meta_key = 'member_number' 
         AND meta_value REGEXP '^DS[0-9]+$'"
    );
    
    $next_number = ($highest_number ? $highest_number : 0) + 1;
    
    return 'DS' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
}

/**
 * Create initial share capital contribution for new member
 */
function daystar_create_initial_share_capital($user_id) {
    global $wpdb;
    
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    // Check if member already has share capital
    $existing_share_capital = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$contributions_table} 
         WHERE user_id = %d AND is_share_capital = 1",
        $user_id
    ));
    
    if ($existing_share_capital > 0) {
        return; // Already has share capital
    }
    
    // Create minimum share capital contribution
    $share_capital_amount = 5000; // Minimum required
    
    $wpdb->insert(
        $contributions_table,
        array(
            'user_id' => $user_id,
            'amount' => $share_capital_amount,
            'contribution_type' => 'share_capital',
            'is_share_capital' => 1,
            'contribution_date' => current_time('mysql'),
            'status' => 'completed',
            'payment_method' => 'bank_transfer',
            'reference_number' => 'SC' . $user_id . time(),
            'notes' => 'Initial share capital contribution upon approval'
        )
    );
}

/**
 * Send approval notification to member
 */
function daystar_send_approval_notification($user_id) {
    global $wpdb;
    
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    $member_number = get_user_meta($user_id, 'member_number', true);
    
    $wpdb->insert(
        $notifications_table,
        array(
            'user_id' => $user_id,
            'title' => 'Membership Approved',
            'message' => "Congratulations! Your SACCO membership has been approved. Your member number is {$member_number}. You can now access all member services and apply for loans.",
            'type' => 'approval',
            'is_read' => 0,
            'created_at' => current_time('mysql')
        )
    );
}

/**
 * Log member approval for audit trail
 */
function daystar_log_member_approval($user_id, $approved_by) {
    global $wpdb;
    
    // Check if audit log table exists
    $audit_table = $wpdb->prefix . 'daystar_audit_log';
    if ($wpdb->get_var("SHOW TABLES LIKE '$audit_table'") != $audit_table) {
        return; // Table doesn't exist, skip logging
    }
    
    $user = get_user_by('ID', $user_id);
    $approver = get_user_by('ID', $approved_by);
    
    $wpdb->insert(
        $audit_table,
        array(
            'user_id' => $approved_by,
            'action' => 'member_approval',
            'description' => "Approved membership for {$user->display_name} (ID: {$user_id})",
            'affected_user_id' => $user_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'created_at' => current_time('mysql')
        )
    );
}

/**
 * Bulk approve members by IDs
 */
function daystar_bulk_approve_members($user_ids) {
    $results = array();
    $approved_count = 0;
    
    foreach ($user_ids as $user_id) {
        $result = daystar_auto_approve_single_member($user_id);
        if ($result['success']) {
            $approved_count++;
        }
        $results[] = $result;
    }
    
    return array(
        'success' => true,
        'approved_count' => $approved_count,
        'total_processed' => count($user_ids),
        'details' => $results
    );
}

/**
 * Get pending members list
 */
function daystar_get_pending_members() {
    $pending_members = get_users(array(
        'meta_key' => 'member_status',
        'meta_value' => 'pending',
        'fields' => 'all'
    ));
    
    $members_data = array();
    
    foreach ($pending_members as $member) {
        $members_data[] = array(
            'ID' => $member->ID,
            'display_name' => $member->display_name,
            'email' => $member->user_email,
            'registration_date' => get_user_meta($member->ID, 'registration_date', true),
            'phone' => get_user_meta($member->ID, 'phone', true),
            'id_number' => get_user_meta($member->ID, 'id_number', true),
            'employment_status' => get_user_meta($member->ID, 'employment_status', true)
        );
    }
    
    return $members_data;
}

/**
 * AJAX handler for auto-approving pending members
 */
function daystar_ajax_auto_approve_members() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_auto_approve_nonce')) {
        wp_die('Security check failed');
    }
    
    $result = daystar_auto_approve_pending_members();
    
    wp_send_json_success($result);
}
add_action('wp_ajax_auto_approve_members', 'daystar_ajax_auto_approve_members');

/**
 * AJAX handler for getting pending members
 */
function daystar_ajax_get_pending_members() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_auto_approve_nonce')) {
        wp_die('Security check failed');
    }
    
    $pending_members = daystar_get_pending_members();
    
    wp_send_json_success($pending_members);
}
add_action('wp_ajax_get_pending_members', 'daystar_ajax_get_pending_members');

/**
 * AJAX handler for bulk approving specific members
 */
function daystar_ajax_bulk_approve_members() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_auto_approve_nonce')) {
        wp_die('Security check failed');
    }
    
    $user_ids = isset($_POST['user_ids']) ? array_map('intval', $_POST['user_ids']) : array();
    
    if (empty($user_ids)) {
        wp_send_json_error('No members selected');
        return;
    }
    
    $result = daystar_bulk_approve_members($user_ids);
    
    wp_send_json_success($result);
}
add_action('wp_ajax_bulk_approve_members', 'daystar_ajax_bulk_approve_members');

/**
 * Add admin menu for member approval
 */
function daystar_add_member_approval_admin_menu() {
    add_submenu_page(
        'users.php',
        'Member Approval',
        'Member Approval',
        'manage_options',
        'daystar-member-approval',
        'daystar_member_approval_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_member_approval_admin_menu');

/**
 * Admin page for member approval
 */
function daystar_member_approval_admin_page() {
    ?>
    <div class="wrap">
        <h1>Member Approval System</h1>
        <p>Manage pending member approvals and auto-approve members for demonstration purposes.</p>
        
        <div class="card">
            <h2>Auto-Approve All Pending Members</h2>
            <p>This will automatically approve all pending members and set up their accounts with:</p>
            <ul>
                <li>Active member status</li>
                <li>Unique member number</li>
                <li>Initial share capital contribution</li>
                <li>Welcome notification</li>
                <li>Audit trail logging</li>
            </ul>
            
            <p class="submit">
                <button type="button" class="button button-primary" id="auto-approve-btn">
                    Auto-Approve All Pending Members
                </button>
                <span class="spinner" id="auto-approve-spinner"></span>
            </p>
            
            <div id="auto-approve-result" style="display: none;"></div>
        </div>
        
        <div class="card">
            <h2>Pending Members</h2>
            <p>Review and selectively approve pending members.</p>
            
            <p class="submit">
                <button type="button" class="button" id="refresh-pending-btn">
                    Refresh Pending Members
                </button>
                <button type="button" class="button button-secondary" id="bulk-approve-btn" style="display: none;">
                    Approve Selected
                </button>
                <span class="spinner" id="pending-spinner"></span>
            </p>
            
            <div id="pending-members-list"></div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var nonce = '<?php echo wp_create_nonce('daystar_auto_approve_nonce'); ?>';
        
        // Auto-approve all pending members
        $('#auto-approve-btn').on('click', function() {
            var $btn = $(this);
            var $spinner = $('#auto-approve-spinner');
            var $result = $('#auto-approve-result');
            
            $btn.prop('disabled', true);
            $spinner.addClass('is-active');
            $result.hide();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'auto_approve_members',
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        var html = '<div class="notice notice-success"><p><strong>Success!</strong> Approved ' + data.approved_count + ' out of ' + data.total_pending + ' pending members.</p></div>';
                        
                        if (data.details && data.details.length > 0) {
                            html += '<h3>Details:</h3><ul>';
                            data.details.forEach(function(detail) {
                                var status = detail.success ? 'success' : 'error';
                                html += '<li class="' + status + '">' + detail.message + ' (User ID: ' + detail.user_id + ')';
                                if (detail.member_number) {
                                    html += ' - Member Number: ' + detail.member_number;
                                }
                                html += '</li>';
                            });
                            html += '</ul>';
                        }
                        
                        $result.html(html).show();
                        
                        // Refresh pending members list
                        $('#refresh-pending-btn').click();
                    } else {
                        $result.html('<div class="notice notice-error"><p><strong>Error:</strong> ' + response.data + '</p></div>').show();
                    }
                },
                error: function() {
                    $result.html('<div class="notice notice-error"><p><strong>Error:</strong> Failed to approve members.</p></div>').show();
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.removeClass('is-active');
                }
            });
        });
        
        // Refresh pending members
        $('#refresh-pending-btn').on('click', function() {
            var $btn = $(this);
            var $spinner = $('#pending-spinner');
            var $list = $('#pending-members-list');
            
            $btn.prop('disabled', true);
            $spinner.addClass('is-active');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_pending_members',
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        var members = response.data;
                        var html = '';
                        
                        if (members.length === 0) {
                            html = '<p>No pending members found.</p>';
                            $('#bulk-approve-btn').hide();
                        } else {
                            html = '<table class="wp-list-table widefat fixed striped">';
                            html += '<thead><tr>';
                            html += '<td class="manage-column column-cb check-column"><input type="checkbox" id="select-all-members"></td>';
                            html += '<th>Name</th><th>Email</th><th>Phone</th><th>ID Number</th><th>Employment</th><th>Registration Date</th>';
                            html += '</tr></thead><tbody>';
                            
                            members.forEach(function(member) {
                                html += '<tr>';
                                html += '<th class="check-column"><input type="checkbox" name="member_ids[]" value="' + member.ID + '"></th>';
                                html += '<td>' + member.display_name + '</td>';
                                html += '<td>' + member.email + '</td>';
                                html += '<td>' + (member.phone || '-') + '</td>';
                                html += '<td>' + (member.id_number || '-') + '</td>';
                                html += '<td>' + (member.employment_status || '-') + '</td>';
                                html += '<td>' + (member.registration_date || '-') + '</td>';
                                html += '</tr>';
                            });
                            
                            html += '</tbody></table>';
                            $('#bulk-approve-btn').show();
                        }
                        
                        $list.html(html);
                        
                        // Handle select all
                        $('#select-all-members').on('change', function() {
                            $('input[name="member_ids[]"]').prop('checked', this.checked);
                        });
                        
                    } else {
                        $list.html('<div class="notice notice-error"><p>Error loading pending members.</p></div>');
                    }
                },
                error: function() {
                    $list.html('<div class="notice notice-error"><p>Error loading pending members.</p></div>');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.removeClass('is-active');
                }
            });
        });
        
        // Bulk approve selected members
        $('#bulk-approve-btn').on('click', function() {
            var selectedIds = [];
            $('input[name="member_ids[]"]:checked').each(function() {
                selectedIds.push($(this).val());
            });
            
            if (selectedIds.length === 0) {
                alert('Please select at least one member to approve.');
                return;
            }
            
            var $btn = $(this);
            var $spinner = $('#pending-spinner');
            
            $btn.prop('disabled', true);
            $spinner.addClass('is-active');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bulk_approve_members',
                    nonce: nonce,
                    user_ids: selectedIds
                },
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        alert('Successfully approved ' + data.approved_count + ' out of ' + data.total_processed + ' selected members.');
                        $('#refresh-pending-btn').click();
                    } else {
                        alert('Error: ' + response.data);
                    }
                },
                error: function() {
                    alert('Error approving selected members.');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.removeClass('is-active');
                }
            });
        });
        
        // Load pending members on page load
        $('#refresh-pending-btn').click();
    });
    </script>
    
    <style>
    .success { color: green; }
    .error { color: red; }
    .card { margin-bottom: 20px; }
    </style>
    <?php
}