<?php
/**
 * Admin Loan Appeals Management
 * Implements PRD Section 5 - Admin Interface for Appeal Resolution
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include loan appeals functions
require_once get_template_directory() . '/includes/loan-appeals.php';

/**
 * Add Loan Appeals admin menu
 */
function daystar_add_loan_appeals_admin_menu() {
    add_submenu_page(
        'daystar-credit-committee',
        'Loan Appeals',
        'Loan Appeals',
        'manage_options',
        'daystar-loan-appeals',
        'daystar_loan_appeals_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_loan_appeals_admin_menu');

/**
 * Main loan appeals admin page
 */
function daystar_loan_appeals_admin_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_appeal_admin_action();
    }
    
    $filter_status = $_GET['status'] ?? 'all';
    $search_term = $_GET['search'] ?? '';
    
    $appeals = daystar_get_all_appeals($filter_status, $search_term);
    $stats = daystar_get_appeal_statistics();
    
    ?>
    <div class="wrap">
        <h1>Loan Appeals Management</h1>
        
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
        
        <!-- Appeals Statistics -->
        <div class="appeals-stats-dashboard" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #f59e0b;">Pending Appeals</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #f59e0b;"><?php echo $stats['pending_appeals']; ?></div>
                <small>Awaiting review</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #1d4ed8;">Under Review</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #1d4ed8;"><?php echo $stats['under_review']; ?></div>
                <small>Committee review</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #dc2626;">Overdue</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc2626;"><?php echo $stats['overdue_appeals']; ?></div>
                <small>Over 30 days</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #059669;">Success Rate</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #059669;"><?php echo number_format($stats['success_rate'], 1); ?>%</div>
                <small>Appeals approved</small>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" style="display: inline-flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="page" value="daystar-loan-appeals">
                    
                    <select name="status">
                        <option value="all" <?php selected($filter_status, 'all'); ?>>All Statuses</option>
                        <option value="pending" <?php selected($filter_status, 'pending'); ?>>Pending</option>
                        <option value="under_review" <?php selected($filter_status, 'under_review'); ?>>Under Review</option>
                        <option value="approved" <?php selected($filter_status, 'approved'); ?>>Approved</option>
                        <option value="rejected" <?php selected($filter_status, 'rejected'); ?>>Rejected</option>
                    </select>
                    
                    <input type="text" name="search" placeholder="Search by member name or application number" 
                           value="<?php echo esc_attr($search_term); ?>" style="width: 300px;">
                    
                    <input type="submit" class="button" value="Filter">
                    
                    <?php if ($filter_status !== 'all' || $search_term) : ?>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-appeals'); ?>" class="button">Clear Filters</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="alignright actions">
                <button type="button" class="button" onclick="exportAppeals()">Export Appeals</button>
            </div>
        </div>
        
        <!-- Appeals Table -->
        <table class="wp-list-table widefat fixed striped appeals-table">
            <thead>
                <tr>
                    <th style="width: 120px;">Appeal Date</th>
                    <th>Member & Loan</th>
                    <th>Original Decision</th>
                    <th>Appeal Reason</th>
                    <th>Status</th>
                    <th>Days Pending</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($appeals)) : ?>
                    <?php foreach ($appeals as $appeal) : ?>
                        <?php 
                        $days_pending = floor((time() - strtotime($appeal->appeal_date)) / (24 * 60 * 60));
                        $urgency_class = $days_pending > 30 ? 'urgent' : ($days_pending > 14 ? 'warning' : 'normal');
                        ?>
                        <tr class="appeal-row <?php echo $urgency_class; ?>" data-appeal-id="<?php echo $appeal->id; ?>">
                            <td>
                                <strong><?php echo date('M j, Y', strtotime($appeal->appeal_date)); ?></strong>
                                <br><small><?php echo date('g:i A', strtotime($appeal->appeal_date)); ?></small>
                            </td>
                            <td>
                                <strong><?php echo esc_html($appeal->member_name); ?></strong>
                                <br>App #: <?php echo esc_html($appeal->application_waiting_number ?: 'APP-' . $appeal->loan_id); ?>
                                <br><?php echo esc_html(ucfirst(str_replace('_', ' ', $appeal->loan_type))); ?>
                                <br><strong>KES <?php echo number_format($appeal->amount, 2); ?></strong>
                            </td>
                            <td>
                                <div class="rejection-info">
                                    <span class="status-badge status-rejected">REJECTED</span>
                                    <?php if ($appeal->original_rejection_reason) : ?>
                                        <br><small class="rejection-reason">
                                            <?php echo esc_html(substr($appeal->original_rejection_reason, 0, 100)); ?>
                                            <?php if (strlen($appeal->original_rejection_reason) > 100) echo '...'; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="appeal-reason">
                                    <?php echo esc_html(substr($appeal->reason_for_appeal, 0, 150)); ?>
                                    <?php if (strlen($appeal->reason_for_appeal) > 150) echo '...'; ?>
                                </div>
                                <button type="button" class="button button-small" 
                                        onclick="viewFullReason(<?php echo $appeal->id; ?>)">
                                    Read Full
                                </button>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $appeal->status; ?>">
                                    <?php echo strtoupper(str_replace('_', ' ', $appeal->status)); ?>
                                </span>
                                <?php if ($appeal->committee_hearing_date) : ?>
                                    <br><small>Hearing: <?php echo date('M j, Y', strtotime($appeal->committee_hearing_date)); ?></small>
                                <?php endif; ?>
                                <?php if ($appeal->resolved_date) : ?>
                                    <br><small>Resolved: <?php echo date('M j, Y', strtotime($appeal->resolved_date)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="days-pending <?php echo $urgency_class; ?>">
                                    <?php echo $days_pending; ?> days
                                </span>
                                <?php if ($days_pending > 30) : ?>
                                    <br><small style="color: #dc2626; font-weight: bold;">OVERDUE</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="button button-primary button-small" 
                                        onclick="reviewAppeal(<?php echo $appeal->id; ?>)">
                                    Review
                                </button>
                                
                                <?php if ($appeal->status === 'pending') : ?>
                                    <br><br>
                                    <div class="quick-actions">
                                        <button type="button" class="button button-small schedule-btn" 
                                                onclick="scheduleHearing(<?php echo $appeal->id; ?>)">
                                            Schedule Hearing
                                        </button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (in_array($appeal->status, ['pending', 'under_review'])) : ?>
                                    <br>
                                    <div class="quick-actions">
                                        <button type="button" class="button button-small approve-btn" 
                                                onclick="resolveAppeal(<?php echo $appeal->id; ?>, 'approved')">
                                            Approve
                                        </button>
                                        <button type="button" class="button button-small reject-btn" 
                                                onclick="resolveAppeal(<?php echo $appeal->id; ?>, 'rejected')">
                                            Reject
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No loan appeals found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Appeal Review Modal -->
    <div id="appeal-review-modal" style="display: none;">
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 100000;">
            <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 0; border-radius: 12px; max-width: 1200px; width: 95%; max-height: 95vh; overflow: hidden;">
                <div class="modal-header" style="padding: 20px 30px; background: #1d4ed8; color: white; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="margin: 0; color: white;">Appeal Review</h2>
                    <button type="button" class="modal-close" onclick="closeAppealReview()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
                <div class="modal-body" style="padding: 0; max-height: calc(95vh - 140px); overflow-y: auto;">
                    <div id="appeal-review-content"></div>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="button" onclick="closeAppealReview()">Close</button>
                    <button type="button" class="button button-primary" onclick="printAppealReview()">Print</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Resolution Modal -->
    <div id="resolution-modal" style="display: none;">
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100001;">
            <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 600px; width: 90%;">
                <h3 id="resolution-title">Resolve Appeal</h3>
                <div id="resolution-form">
                    <!-- Resolution form content will be populated by JavaScript -->
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="button" onclick="closeResolutionModal()">Cancel</button>
                    <button type="button" class="button button-primary" onclick="submitResolution()">Submit Resolution</button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .appeals-table th,
    .appeals-table td {
        vertical-align: top;
        padding: 12px 8px;
    }
    
    .appeal-row.urgent {
        background-color: #fef2f2;
    }
    
    .appeal-row.warning {
        background-color: #fffbeb;
    }
    
    .appeal-row.normal {
        background-color: #f0fdf4;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
    }
    
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-under_review { background: #dbeafe; color: #1e40af; }
    .status-approved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fef2f2; color: #dc2626; }
    
    .days-pending.urgent { color: #dc2626; font-weight: bold; }
    .days-pending.warning { color: #d97706; font-weight: bold; }
    .days-pending.normal { color: #059669; }
    
    .rejection-reason {
        color: #6b7280;
        font-style: italic;
        margin-top: 5px;
        line-height: 1.3;
    }
    
    .appeal-reason {
        line-height: 1.4;
        margin-bottom: 10px;
    }
    
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .approve-btn { background: #059669 !important; color: white !important; border-color: #059669 !important; }
    .reject-btn { background: #dc2626 !important; color: white !important; border-color: #dc2626 !important; }
    .schedule-btn { background: #1d4ed8 !important; color: white !important; border-color: #1d4ed8 !important; }
    
    .modal-content {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .review-section {
        margin-bottom: 30px;
        padding: 25px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 4px solid #1d4ed8;
    }
    
    .review-section h3 {
        margin-top: 0;
        color: #1d4ed8;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-weight: bold;
        color: #374151;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .info-value {
        color: #6b7280;
        font-size: 0.95rem;
    }
    </style>
    
    <script>
    let currentAppealId = null;
    let currentResolutionType = null;
    
    function reviewAppeal(appealId) {
        currentAppealId = appealId;
        
        // Show loading
        document.getElementById('appeal-review-content').innerHTML = '<div style="text-align: center; padding: 40px;"><div class="spinner is-active"></div><p>Loading appeal review...</p></div>';
        document.getElementById('appeal-review-modal').style.display = 'block';
        
        // Fetch detailed appeal data
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_detailed_appeal_review',
                appeal_id: appealId,
                nonce: '<?php echo wp_create_nonce('detailed_appeal_review'); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('appeal-review-content').innerHTML = data.data.html;
            } else {
                document.getElementById('appeal-review-content').innerHTML = '<div style="text-align: center; padding: 40px; color: #dc2626;">Error loading appeal data: ' + data.data + '</div>';
            }
        })
        .catch(error => {
            document.getElementById('appeal-review-content').innerHTML = '<div style="text-align: center; padding: 40px; color: #dc2626;">Error: ' + error.message + '</div>';
        });
    }
    
    function closeAppealReview() {
        document.getElementById('appeal-review-modal').style.display = 'none';
        currentAppealId = null;
    }
    
    function scheduleHearing(appealId) {
        const hearingDate = prompt('Enter hearing date and time (YYYY-MM-DD HH:MM):');
        if (hearingDate) {
            updateAppealStatus(appealId, 'under_review', '', hearingDate);
        }
    }
    
    function resolveAppeal(appealId, resolution) {
        currentAppealId = appealId;
        currentResolutionType = resolution;
        showResolutionModal(resolution);
    }
    
    function showResolutionModal(resolution) {
        const title = resolution === 'approved' ? 'Approve Appeal' : 'Reject Appeal';
        document.getElementById('resolution-title').textContent = title;
        
        let formHtml = '';
        
        if (resolution === 'approved') {
            formHtml = `
                <div style="margin-bottom: 15px;">
                    <label for="resolution-details" style="display: block; font-weight: bold; margin-bottom: 5px;">Resolution Details:</label>
                    <textarea id="resolution-details" rows="4" style="width: 100%;" placeholder="Explain why the appeal was approved and any conditions..."></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="new-loan-conditions" style="display: block; font-weight: bold; margin-bottom: 5px;">New Loan Conditions (Optional):</label>
                    <textarea id="new-loan-conditions" rows="3" style="width: 100%;" placeholder="Any special conditions for the approved loan..."></textarea>
                </div>
            `;
        } else {
            formHtml = `
                <div style="margin-bottom: 15px;">
                    <label for="resolution-details" style="display: block; font-weight: bold; margin-bottom: 5px;">Reason for Rejection:</label>
                    <textarea id="resolution-details" rows="4" style="width: 100%;" placeholder="Explain why the appeal was rejected..." required></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="improvement-suggestions" style="display: block; font-weight: bold; margin-bottom: 5px;">Suggestions for Future Applications:</label>
                    <textarea id="improvement-suggestions" rows="3" style="width: 100%;" placeholder="What can the member do to improve future applications..."></textarea>
                </div>
            `;
        }
        
        document.getElementById('resolution-form').innerHTML = formHtml;
        document.getElementById('resolution-modal').style.display = 'block';
    }
    
    function closeResolutionModal() {
        document.getElementById('resolution-modal').style.display = 'none';
        currentAppealId = null;
        currentResolutionType = null;
    }
    
    function submitResolution() {
        if (!currentAppealId || !currentResolutionType) return;
        
        const resolutionDetails = document.getElementById('resolution-details').value;
        if (!resolutionDetails.trim()) {
            alert('Please provide resolution details.');
            return;
        }
        
        let additionalData = {};
        if (currentResolutionType === 'approved') {
            additionalData.new_loan_conditions = document.getElementById('new-loan-conditions').value;
        } else {
            additionalData.improvement_suggestions = document.getElementById('improvement-suggestions').value;
        }
        
        updateAppealStatus(currentAppealId, currentResolutionType, resolutionDetails, null, additionalData);
    }
    
    function updateAppealStatus(appealId, status, resolutionDetails = '', hearingDate = null, additionalData = {}) {
        const formData = new FormData();
        formData.append('action', 'update_appeal_status');
        formData.append('appeal_id', appealId);
        formData.append('status', status);
        formData.append('resolution_details', resolutionDetails);
        if (hearingDate) {
            formData.append('hearing_date', hearingDate);
        }
        formData.append('additional_data', JSON.stringify(additionalData));
        formData.append('nonce', '<?php echo wp_create_nonce('update_appeal_status'); ?>');
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeResolutionModal();
                closeAppealReview();
                location.reload();
            } else {
                alert('Error: ' + data.data);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    
    function viewFullReason(appealId) {
        // Show full appeal reason in a popup or modal
        alert('Full reason view - to be implemented');
    }
    
    function printAppealReview() {
        window.print();
    }
    
    function exportAppeals() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'csv');
        window.location.href = '?' + params.toString();
    }
    
    // Close modals when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            if (e.target.closest('#appeal-review-modal')) {
                closeAppealReview();
            } else if (e.target.closest('#resolution-modal')) {
                closeResolutionModal();
            }
        }
    });
    </script>
    <?php
}

/**
 * Handle appeal admin actions
 */
function daystar_handle_appeal_admin_action() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $action = sanitize_text_field($_POST['action']);
    $redirect_url = admin_url('admin.php?page=daystar-loan-appeals');
    
    // Handle different actions here
    // This will be expanded with specific action handlers
    
    wp_redirect($redirect_url);
    exit;
}

/**
 * AJAX handler for updating appeal status
 */
function daystar_ajax_update_appeal_status() {
    if (!wp_verify_nonce($_POST['nonce'], 'update_appeal_status')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    $appeal_id = intval($_POST['appeal_id']);
    $status = sanitize_text_field($_POST['status']);
    $resolution_details = sanitize_textarea_field($_POST['resolution_details'] ?? '');
    $hearing_date = sanitize_text_field($_POST['hearing_date'] ?? '');
    $admin_user_id = get_current_user_id();
    
    if ($hearing_date) {
        $result = daystar_schedule_appeal_hearing($appeal_id, $hearing_date, $admin_user_id);
    } else {
        $result = daystar_update_appeal_status($appeal_id, $status, $resolution_details, $admin_user_id);
    }
    
    if ($result) {
        wp_send_json_success('Appeal status updated successfully');
    } else {
        wp_send_json_error('Failed to update appeal status');
    }
}
add_action('wp_ajax_update_appeal_status', 'daystar_ajax_update_appeal_status');

/**
 * AJAX handler for detailed appeal review
 */
function daystar_ajax_get_detailed_appeal_review() {
    if (!wp_verify_nonce($_POST['nonce'], 'detailed_appeal_review')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    $appeal_id = intval($_POST['appeal_id']);
    $appeal = daystar_get_appeal_details($appeal_id);
    
    if (!$appeal) {
        wp_send_json_error('Appeal not found');
        return;
    }
    
    // Get additional data
    $member_data = daystar_get_member_comprehensive_data($appeal->user_id);
    $eligibility_data = daystar_comprehensive_loan_eligibility($appeal->user_id, $appeal->loan_type, $appeal->amount);
    
    ob_start();
    ?>
    <div class="appeal-review-content">
        <!-- Appeal Information -->
        <div class="review-section">
            <h3>Appeal Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Appeal Date</div>
                    <div class="info-value"><?php echo date('F j, Y \a\t g:i A', strtotime($appeal->appeal_date)); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Days Pending</div>
                    <div class="info-value"><?php echo floor((time() - strtotime($appeal->appeal_date)) / (24 * 60 * 60)); ?> days</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Appeal Deadline</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($appeal->appeal_deadline)); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Current Status</div>
                    <div class="info-value">
                        <span class="status-badge status-<?php echo $appeal->status; ?>">
                            <?php echo strtoupper(str_replace('_', ' ', $appeal->status)); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Member Information -->
        <div class="review-section">
            <h3>Member Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Member Name</div>
                    <div class="info-value"><?php echo esc_html($appeal->member_name); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Member Number</div>
                    <div class="info-value"><?php echo esc_html($member_data['member_number']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo esc_html($appeal->member_email); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Member Since</div>
                    <div class="info-value"><?php echo date('F Y', strtotime($member_data['registration_date'])); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Original Loan Application -->
        <div class="review-section">
            <h3>Original Loan Application</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Application Number</div>
                    <div class="info-value"><?php echo esc_html($appeal->application_waiting_number ?: 'APP-' . $appeal->loan_id); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Loan Type</div>
                    <div class="info-value"><?php echo esc_html(ucfirst(str_replace('_', ' ', $appeal->loan_type))); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Amount Requested</div>
                    <div class="info-value">KES <?php echo number_format($appeal->amount, 2); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Term</div>
                    <div class="info-value"><?php echo $appeal->term_months; ?> months</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Interest Rate</div>
                    <div class="info-value"><?php echo $appeal->interest_rate; ?>% p.a.</div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <div class="info-label">Loan Purpose</div>
                <div class="info-value"><?php echo esc_html($appeal->purpose); ?></div>
            </div>
        </div>
        
        <!-- Original Rejection -->
        <div class="review-section">
            <h3>Original Rejection Details</h3>
            <div class="info-item">
                <div class="info-label">Rejection Reason</div>
                <div class="info-value"><?php echo esc_html($appeal->original_rejection_reason ?: 'No specific reason provided'); ?></div>
            </div>
        </div>
        
        <!-- Appeal Details -->
        <div class="review-section">
            <h3>Appeal Submission</h3>
            <div class="info-item">
                <div class="info-label">Member's Reason for Appeal</div>
                <div class="info-value" style="white-space: pre-wrap; line-height: 1.6;">
                    <?php echo esc_html($appeal->reason_for_appeal); ?>
                </div>
            </div>
            <?php if ($appeal->supporting_documents) : ?>
                <div class="info-item" style="margin-top: 15px;">
                    <div class="info-label">Supporting Documents</div>
                    <div class="info-value"><?php echo esc_html($appeal->supporting_documents); ?></div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Current Eligibility Assessment -->
        <div class="review-section">
            <h3>Current Eligibility Assessment</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Eligibility Score</div>
                    <div class="info-value"><strong><?php echo $eligibility_data['eligibility_score']; ?>/100</strong></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Risk Assessment</div>
                    <div class="info-value">
                        <span class="risk-badge risk-<?php echo $eligibility_data['risk_assessment']; ?>">
                            <?php echo strtoupper($eligibility_data['risk_assessment']); ?> RISK
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Max Loan Amount</div>
                    <div class="info-value">KES <?php echo number_format($eligibility_data['max_loan_amount'], 2); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Share Capital</div>
                    <div class="info-value">KES <?php echo number_format($member_data['share_capital'], 2); ?></div>
                </div>
            </div>
        </div>
        
        <?php if ($appeal->committee_hearing_date) : ?>
            <!-- Committee Hearing -->
            <div class="review-section">
                <h3>Committee Hearing</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Hearing Date</div>
                        <div class="info-value"><?php echo date('F j, Y \a\t g:i A', strtotime($appeal->committee_hearing_date)); ?></div>
                    </div>
                </div>
                <?php if ($appeal->committee_notes) : ?>
                    <div style="margin-top: 15px;">
                        <div class="info-label">Committee Notes</div>
                        <div class="info-value"><?php echo esc_html($appeal->committee_notes); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($appeal->resolution_details) : ?>
            <!-- Resolution -->
            <div class="review-section">
                <h3>Appeal Resolution</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Resolution Date</div>
                        <div class="info-value"><?php echo date('F j, Y', strtotime($appeal->resolved_date)); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Resolved By</div>
                        <div class="info-value"><?php echo esc_html($appeal->resolved_by_name ?: 'System'); ?></div>
                    </div>
                </div>
                <div style="margin-top: 15px;">
                    <div class="info-label">Resolution Details</div>
                    <div class="info-value"><?php echo esc_html($appeal->resolution_details); ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
    .risk-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
    }
    
    .risk-low { background: #d1fae5; color: #065f46; }
    .risk-medium { background: #fef3c7; color: #92400e; }
    .risk-high { background: #fef2f2; color: #dc2626; }
    </style>
    <?php
    
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_get_detailed_appeal_review', 'daystar_ajax_get_detailed_appeal_review');