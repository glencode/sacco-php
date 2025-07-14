<?php
/**
 * Admin Payslip Verification Interface
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for payslip verification
 */
function daystar_add_payslip_verification_admin_menu() {
    add_submenu_page(
        'users.php',
        'Payslip Verification',
        'Payslip Verification',
        'manage_options',
        'daystar-payslip-verification',
        'daystar_payslip_verification_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_payslip_verification_admin_menu');

/**
 * Payslip verification admin page
 */
function daystar_payslip_verification_admin_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_payslip_verification_action();
    }
    
    $pending_payslips = daystar_get_pending_payslips();
    $verified_payslips = daystar_get_recent_verified_payslips();
    
    ?>
    <div class="wrap">
        <h1>Payslip Verification</h1>
        
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
        
        <!-- Pending Payslips -->
        <div class="card" style="margin-top: 20px;">
            <h2 class="title" style="padding: 20px 20px 0;">Pending Payslip Verifications</h2>
            
            <?php if (empty($pending_payslips)) : ?>
                <div style="padding: 20px;">
                    <p>No pending payslip verifications.</p>
                </div>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Payslip Period</th>
                            <th>Gross Salary</th>
                            <th>Net Salary</th>
                            <th>Allowances</th>
                            <th>Submitted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_payslips as $payslip) : ?>
                            <tr>
                                <td>
                                    <?php 
                                    $user = get_user_by('ID', $payslip->user_id);
                                    echo esc_html($user->display_name);
                                    ?>
                                    <br><small>Member #<?php echo esc_html(get_user_meta($payslip->user_id, 'member_number', true)); ?></small>
                                </td>
                                <td><?php echo esc_html($payslip->payslip_month . '/' . $payslip->payslip_year); ?></td>
                                <td>KES <?php echo number_format($payslip->gross_salary, 2); ?></td>
                                <td>KES <?php echo number_format($payslip->net_salary, 2); ?></td>
                                <td>
                                    <?php 
                                    $total_allowances = $payslip->responsibility_allowance + 
                                                       $payslip->telephone_allowance + 
                                                       $payslip->hod_allowance + 
                                                       $payslip->other_allowances;
                                    echo 'KES ' . number_format($total_allowances, 2);
                                    ?>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($payslip->created_at)); ?></td>
                                <td>
                                    <button type="button" class="button button-primary" onclick="showPayslipDetails(<?php echo $payslip->id; ?>)">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Recent Verified Payslips -->
        <div class="card" style="margin-top: 20px;">
            <h2 class="title" style="padding: 20px 20px 0;">Recently Verified Payslips</h2>
            
            <?php if (empty($verified_payslips)) : ?>
                <div style="padding: 20px;">
                    <p>No recently verified payslips.</p>
                </div>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Payslip Period</th>
                            <th>Net Salary</th>
                            <th>Verified By</th>
                            <th>Verified Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($verified_payslips as $payslip) : ?>
                            <tr>
                                <td>
                                    <?php 
                                    $user = get_user_by('ID', $payslip->user_id);
                                    echo esc_html($user->display_name);
                                    ?>
                                </td>
                                <td><?php echo esc_html($payslip->payslip_month . '/' . $payslip->payslip_year); ?></td>
                                <td>KES <?php echo number_format($payslip->net_salary, 2); ?></td>
                                <td>
                                    <?php 
                                    $verifier = get_user_by('ID', $payslip->verified_by_user_id);
                                    echo esc_html($verifier ? $verifier->display_name : 'System');
                                    ?>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($payslip->verified_date)); ?></td>
                                <td>
                                    <button type="button" class="button" onclick="showPayslipDetails(<?php echo $payslip->id; ?>)">
                                        View
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Payslip Review Modal -->
    <div id="payslip-review-modal" style="display: none;">
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100000;">
            <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 800px; width: 90%; max-height: 90vh; overflow-y: auto;">
                <h2>Payslip Verification</h2>
                <div id="payslip-details"></div>
                
                <form method="post" style="margin-top: 20px;" id="verification-form">
                    <input type="hidden" name="payslip_id" id="modal-payslip-id">
                    
                    <div style="margin-bottom: 15px;">
                        <label for="verification-notes"><strong>Verification Notes:</strong></label>
                        <textarea name="verification_notes" id="verification-notes" rows="3" style="width: 100%; margin-top: 5px;"></textarea>
                    </div>
                    
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="button" onclick="closePayslipModal()">Cancel</button>
                        <button type="submit" name="action" value="reject_payslip" class="button" style="background: #d63638; color: white; border-color: #d63638;">
                            Reject
                        </button>
                        <button type="submit" name="action" value="verify_payslip" class="button button-primary">
                            Verify & Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    const payslipsData = <?php echo json_encode($pending_payslips); ?>;
    const verifiedPayslipsData = <?php echo json_encode($verified_payslips); ?>;
    const allPayslips = [...payslipsData, ...verifiedPayslipsData];
    
    function showPayslipDetails(payslipId) {
        const payslip = allPayslips.find(p => p.id == payslipId);
        
        if (!payslip) return;
        
        document.getElementById('modal-payslip-id').value = payslipId;
        
        const detailsHtml = `
            <div style="background: #f9f9f9; padding: 15px; border-radius: 4px; margin-bottom: 15px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h4>Member Information</h4>
                        <p><strong>Member:</strong> ${payslip.member_name || 'Loading...'}</p>
                        <p><strong>Payslip Period:</strong> ${payslip.payslip_month}/${payslip.payslip_year}</p>
                        <p><strong>Submitted:</strong> ${new Date(payslip.created_at).toLocaleDateString()}</p>
                    </div>
                    <div>
                        <h4>Salary Information</h4>
                        <p><strong>Gross Salary:</strong> KES ${parseFloat(payslip.gross_salary).toLocaleString()}</p>
                        <p><strong>Net Salary:</strong> KES ${parseFloat(payslip.net_salary).toLocaleString()}</p>
                        <p><strong>Basic Salary:</strong> KES ${parseFloat(payslip.basic_salary || 0).toLocaleString()}</p>
                    </div>
                </div>
                
                <div style="margin-top: 15px;">
                    <h4>Allowances</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                        <p><strong>Responsibility:</strong> KES ${parseFloat(payslip.responsibility_allowance || 0).toLocaleString()}</p>
                        <p><strong>Telephone:</strong> KES ${parseFloat(payslip.telephone_allowance || 0).toLocaleString()}</p>
                        <p><strong>H.O.D:</strong> KES ${parseFloat(payslip.hod_allowance || 0).toLocaleString()}</p>
                    </div>
                    <p><strong>Other Allowances:</strong> KES ${parseFloat(payslip.other_allowances || 0).toLocaleString()}</p>
                    <p><strong>Total Deductions:</strong> KES ${parseFloat(payslip.total_deductions || 0).toLocaleString()}</p>
                </div>
                
                ${payslip.document_path ? `
                    <div style="margin-top: 15px;">
                        <h4>Supporting Document</h4>
                        <p><a href="${payslip.document_path}" target="_blank" class="button">View Payslip Document</a></p>
                    </div>
                ` : ''}
                
                ${payslip.verification_status === 'verified' ? `
                    <div style="margin-top: 15px; padding: 10px; background: #d4edda; border-radius: 4px;">
                        <h4 style="color: #155724;">Verification Status: Verified</h4>
                        <p><strong>Verified Date:</strong> ${new Date(payslip.verified_date).toLocaleDateString()}</p>
                        ${payslip.verification_notes ? `<p><strong>Notes:</strong> ${payslip.verification_notes}</p>` : ''}
                    </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('payslip-details').innerHTML = detailsHtml;
        
        // Hide form if already verified
        if (payslip.verification_status === 'verified') {
            document.getElementById('verification-form').style.display = 'none';
        } else {
            document.getElementById('verification-form').style.display = 'block';
        }
        
        document.getElementById('payslip-review-modal').style.display = 'block';
    }
    
    function closePayslipModal() {
        document.getElementById('payslip-review-modal').style.display = 'none';
    }
    
    // Close modal when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closePayslipModal();
        }
    });
    </script>
    
    <style>
    .modal-content {
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .card {
        background: white;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .title {
        margin: 0;
        font-size: 1.3em;
        font-weight: 600;
    }
    </style>
    <?php
}

/**
 * Handle payslip verification actions
 */
function daystar_handle_payslip_verification_action() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $action = sanitize_text_field($_POST['action']);
    $payslip_id = intval($_POST['payslip_id']);
    $verification_notes = sanitize_textarea_field($_POST['verification_notes'] ?? '');
    $admin_user_id = get_current_user_id();
    
    $redirect_url = admin_url('users.php?page=daystar-payslip-verification');
    
    switch ($action) {
        case 'verify_payslip':
            $result = daystar_verify_payslip_data($payslip_id, $admin_user_id, $verification_notes);
            
            if ($result !== false) {
                $redirect_url = add_query_arg('message', urlencode('Payslip verified successfully.'), $redirect_url);
            } else {
                $redirect_url = add_query_arg('error', urlencode('Failed to verify payslip.'), $redirect_url);
            }
            break;
            
        case 'reject_payslip':
            $result = daystar_reject_payslip_data($payslip_id, $admin_user_id, $verification_notes);
            
            if ($result !== false) {
                $redirect_url = add_query_arg('message', urlencode('Payslip rejected.'), $redirect_url);
            } else {
                $redirect_url = add_query_arg('error', urlencode('Failed to reject payslip.'), $redirect_url);
            }
            break;
            
        default:
            $redirect_url = add_query_arg('error', urlencode('Invalid action.'), $redirect_url);
            break;
    }
    
    wp_redirect($redirect_url);
    exit;
}

/**
 * Get pending payslips for verification
 */
function daystar_get_pending_payslips() {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    return $wpdb->get_results(
        "SELECT * FROM {$payslip_table} 
         WHERE verification_status = 'pending' 
         ORDER BY created_at ASC"
    );
}

/**
 * Get recently verified payslips
 */
function daystar_get_recent_verified_payslips() {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    return $wpdb->get_results(
        "SELECT * FROM {$payslip_table} 
         WHERE verification_status = 'verified' 
         ORDER BY verified_date DESC 
         LIMIT 20"
    );
}

/**
 * Reject payslip data
 */
function daystar_reject_payslip_data($payslip_id, $admin_user_id, $rejection_reason = '') {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    return $wpdb->update(
        $payslip_table,
        array(
            'verification_status' => 'rejected',
            'verified_by_user_id' => $admin_user_id,
            'verified_date' => current_time('mysql'),
            'verification_notes' => $rejection_reason
        ),
        array('id' => $payslip_id),
        array('%s', '%d', '%s', '%s'),
        array('%d')
    );
}

/**
 * Add admin notices for pending payslips
 */
function daystar_payslip_verification_admin_notices() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages
    if (!in_array($screen->id, ['dashboard', 'users_page_daystar-payslip-verification'])) {
        return;
    }
    
    $pending_count = count(daystar_get_pending_payslips());
    
    if ($pending_count > 0) {
        $url = admin_url('users.php?page=daystar-payslip-verification');
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Payslip Verification:</strong> ';
        echo sprintf(
            'You have <a href="%s">%d pending payslip verification%s</a> that require your attention.',
            $url,
            $pending_count,
            $pending_count === 1 ? '' : 's'
        );
        echo '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'daystar_payslip_verification_admin_notices');