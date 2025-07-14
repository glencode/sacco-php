<?php
/**
 * Consolidated Loan Administration Interface
 * Handles all loan admin functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add comprehensive Credit Committee and Loan Management menus
 */
function daystar_add_loan_admin_menu() {
    // Credit Committee Menu (Primary)
    add_menu_page(
        'Credit Committee',
        'Credit Committee',
        'manage_options',
        'daystar-credit-committee',
        'daystar_credit_committee_dashboard',
        'dashicons-groups',
        25
    );
    
    add_submenu_page(
        'daystar-credit-committee',
        'Loan Applications',
        'Loan Applications',
        'manage_options',
        'daystar-credit-committee',
        'daystar_credit_committee_dashboard'
    );
    
    add_submenu_page(
        'daystar-credit-committee',
        'Prioritization Settings',
        'Prioritization Settings',
        'manage_options',
        'daystar-loan-prioritization',
        'daystar_loan_prioritization_settings'
    );
    
    add_submenu_page(
        'daystar-credit-committee',
        'Decision Templates',
        'Decision Templates',
        'manage_options',
        'daystar-decision-templates',
        'daystar_decision_templates_page'
    );
    
    // Loan Management Menu (Secondary)
    add_menu_page(
        'Loan Management',
        'Loan Management',
        'manage_options',
        'daystar-loan-management',
        'daystar_loan_management_page',
        'dashicons-money-alt',
        30
    );
    
    add_submenu_page(
        'daystar-loan-management',
        'All Applications',
        'All Applications',
        'manage_options',
        'daystar-loan-management',
        'daystar_loan_management_page'
    );
    
    add_submenu_page(
        'daystar-loan-management',
        'Pending Applications',
        'Pending Applications',
        'manage_options',
        'daystar-pending-loans',
        'daystar_pending_loans_page'
    );
    
    add_submenu_page(
        'daystar-loan-management',
        'Active Loans',
        'Active Loans',
        'manage_options',
        'daystar-active-loans',
        'daystar_active_loans_page'
    );
    
    add_submenu_page(
        'daystar-loan-management',
        'Loan Repayments',
        'Loan Repayments',
        'manage_options',
        'daystar-loan-repayments',
        'daystar_loan_repayments_page'
    );
    
    add_submenu_page(
        'daystar-loan-management',
        'Loan Statistics',
        'Loan Statistics',
        'manage_options',
        'daystar-loan-statistics',
        'daystar_loan_statistics_page'
    );
}
add_action('admin_menu', 'daystar_add_loan_admin_menu');

/**
 * Credit Committee Dashboard - Comprehensive loan review interface
 */
function daystar_credit_committee_dashboard() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_credit_committee_action();
    }
    
    $filter_status = $_GET['status'] ?? 'pending';
    $filter_priority = $_GET['priority'] ?? 'all';
    $search_term = $_GET['search'] ?? '';
    
    $applications = daystar_get_credit_committee_applications($filter_status, $filter_priority, $search_term);
    $stats = daystar_get_credit_committee_stats();
    $available_funds = daystar_get_available_loan_funds();
    
    ?>
    <div class="wrap">
        <h1>Credit Committee Dashboard</h1>
        
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
        
        <!-- Credit Committee Statistics -->
        <div class="credit-stats-dashboard" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #f59e0b;">Pending Review</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #f59e0b;"><?php echo $stats['pending_review']; ?></div>
                <small>Applications awaiting decision</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #dc2626;">High Priority</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc2626;"><?php echo $stats['high_priority']; ?></div>
                <small>Urgent applications</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #059669;">Available Funds</h3>
                <div style="font-size: 1.5rem; font-weight: bold; color: #059669;">KES <?php echo number_format($available_funds, 2); ?></div>
                <small>For loan disbursement</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #1d4ed8;">Approval Rate</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #1d4ed8;"><?php echo number_format($stats['approval_rate'], 1); ?>%</div>
                <small>This month</small>
            </div>
        </div>
        
        <!-- Filters and Actions -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" style="display: inline-flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="page" value="daystar-credit-committee">
                    
                    <select name="status">
                        <option value="pending" <?php selected($filter_status, 'pending'); ?>>Pending Review</option>
                        <option value="under_review" <?php selected($filter_status, 'under_review'); ?>>Under Review</option>
                        <option value="approved" <?php selected($filter_status, 'approved'); ?>>Approved</option>
                        <option value="rejected" <?php selected($filter_status, 'rejected'); ?>>Rejected</option>
                        <option value="all" <?php selected($filter_status, 'all'); ?>>All Statuses</option>
                    </select>
                    
                    <select name="priority">
                        <option value="all" <?php selected($filter_priority, 'all'); ?>>All Priorities</option>
                        <option value="high" <?php selected($filter_priority, 'high'); ?>>High Priority</option>
                        <option value="medium" <?php selected($filter_priority, 'medium'); ?>>Medium Priority</option>
                        <option value="low" <?php selected($filter_priority, 'low'); ?>>Low Priority</option>
                    </select>
                    
                    <input type="text" name="search" placeholder="Search by member name or number" 
                           value="<?php echo esc_attr($search_term); ?>" style="width: 250px;">
                    
                    <input type="submit" class="button" value="Filter">
                    
                    <?php if ($filter_status !== 'pending' || $filter_priority !== 'all' || $search_term) : ?>
                        <a href="<?php echo admin_url('admin.php?page=daystar-credit-committee'); ?>" class="button">Clear Filters</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="alignright actions">
                <button type="button" class="button button-primary" onclick="bulkApproveLoans()">Bulk Approve</button>
                <button type="button" class="button" onclick="exportApplications()">Export</button>
            </div>
        </div>
        
        <!-- Applications Table -->
        <table class="wp-list-table widefat fixed striped credit-committee-table">
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all"></th>
                    <th style="width: 80px;">Priority</th>
                    <th style="width: 120px;">Application #</th>
                    <th>Member Details</th>
                    <th>Loan Information</th>
                    <th>5 Cs Assessment</th>
                    <th>Risk & Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applications)) : ?>
                    <?php foreach ($applications as $application) : ?>
                        <?php 
                        $member_data = daystar_get_member_comprehensive_data($application->user_id);
                        $eligibility_data = daystar_comprehensive_loan_eligibility($application->user_id, $application->loan_type, $application->amount);
                        $priority_data = daystar_calculate_loan_priority($application);
                        ?>
                        <tr class="application-row" data-application-id="<?php echo $application->id; ?>">
                            <td><input type="checkbox" name="selected_applications[]" value="<?php echo $application->id; ?>"></td>
                            <td>
                                <span class="priority-badge priority-<?php echo $priority_data['level']; ?>">
                                    <?php echo strtoupper($priority_data['level']); ?>
                                </span>
                                <br><small>Score: <?php echo $priority_data['score']; ?></small>
                            </td>
                            <td>
                                <strong><?php echo esc_html($application->application_waiting_number ?: 'APP-' . $application->id); ?></strong>
                                <br><small><?php echo date('M j, Y', strtotime($application->created_at)); ?></small>
                                <?php if ($application->deadline_note) : ?>
                                    <br><small style="color: #d63638;"><?php echo esc_html($application->deadline_note); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo esc_html($member_data['display_name']); ?></strong>
                                <br>Member #<?php echo esc_html($member_data['member_number']); ?>
                                <br><small>Joined: <?php echo date('M Y', strtotime($member_data['registration_date'])); ?></small>
                                <br><small>Status: <?php echo esc_html($member_data['member_status']); ?></small>
                            </td>
                            <td>
                                <strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $application->loan_type))); ?></strong>
                                <br>Amount: <strong>KES <?php echo number_format($application->amount, 2); ?></strong>
                                <br>Term: <?php echo $application->term_months; ?> months
                                <br>Rate: <?php echo $application->interest_rate; ?>% p.a.
                                <br><small>Monthly: KES <?php echo number_format($application->monthly_payment, 2); ?></small>
                            </td>
                            <td>
                                <?php $five_cs = daystar_assess_five_cs($application->user_id, $eligibility_data); ?>
                                <div class="five-cs-summary">
                                    <div class="cs-item">
                                        <span class="cs-label">Character:</span>
                                        <span class="cs-score cs-<?php echo $five_cs['character']['level']; ?>"><?php echo $five_cs['character']['score']; ?>/10</span>
                                    </div>
                                    <div class="cs-item">
                                        <span class="cs-label">Capacity:</span>
                                        <span class="cs-score cs-<?php echo $five_cs['capacity']['level']; ?>"><?php echo $five_cs['capacity']['score']; ?>/10</span>
                                    </div>
                                    <div class="cs-item">
                                        <span class="cs-label">Capital:</span>
                                        <span class="cs-score cs-<?php echo $five_cs['capital']['level']; ?>"><?php echo $five_cs['capital']['score']; ?>/10</span>
                                    </div>
                                    <div class="cs-item">
                                        <span class="cs-label">Collateral:</span>
                                        <span class="cs-score cs-<?php echo $five_cs['collateral']['level']; ?>"><?php echo $five_cs['collateral']['score']; ?>/10</span>
                                    </div>
                                    <div class="cs-item">
                                        <span class="cs-label">Purpose:</span>
                                        <span class="cs-score cs-<?php echo $five_cs['purpose']['level']; ?>"><?php echo $five_cs['purpose']['score']; ?>/10</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="risk-assessment">
                                    <span class="risk-badge risk-<?php echo $eligibility_data['risk_assessment']; ?>">
                                        <?php echo strtoupper($eligibility_data['risk_assessment']); ?> RISK
                                    </span>
                                    <br>Score: <strong><?php echo $eligibility_data['eligibility_score']; ?>/100</strong>
                                    <br>Max: KES <?php echo number_format($eligibility_data['max_loan_amount'], 2); ?>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="button button-primary button-small" 
                                        onclick="reviewApplication(<?php echo $application->id; ?>)">
                                    Detailed Review
                                </button>
                                
                                <?php if ($application->status === 'pending') : ?>
                                    <br><br>
                                    <div class="quick-actions">
                                        <button type="button" class="button button-small approve-btn" 
                                                onclick="quickApprove(<?php echo $application->id; ?>)">
                                            ✓ Approve
                                        </button>
                                        <button type="button" class="button button-small reject-btn" 
                                                onclick="quickReject(<?php echo $application->id; ?>)">
                                            ✗ Reject
                                        </button>
                                        <button type="button" class="button button-small info-btn" 
                                                onclick="requestMoreInfo(<?php echo $application->id; ?>)">
                                            ? More Info
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No loan applications found for the selected criteria.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Enhanced CSS for Credit Committee Dashboard -->
    <style>
    .credit-committee-table th,
    .credit-committee-table td {
        vertical-align: top;
        padding: 12px 8px;
    }
    
    .priority-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        text-align: center;
        display: inline-block;
        min-width: 60px;
    }
    
    .priority-high { background: #fef2f2; color: #dc2626; }
    .priority-medium { background: #fef3c7; color: #d97706; }
    .priority-low { background: #f0fdf4; color: #059669; }
    
    .five-cs-summary {
        font-size: 0.85rem;
    }
    
    .cs-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    
    .cs-label {
        font-weight: 500;
    }
    
    .cs-score {
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    
    .cs-excellent { background: #d1fae5; color: #065f46; }
    .cs-good { background: #dbeafe; color: #1e40af; }
    .cs-fair { background: #fef3c7; color: #92400e; }
    .cs-poor { background: #fef2f2; color: #dc2626; }
    
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
    
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .approve-btn { background: #059669 !important; color: white !important; border-color: #059669 !important; }
    .reject-btn { background: #dc2626 !important; color: white !important; border-color: #dc2626 !important; }
    .info-btn { background: #1d4ed8 !important; color: white !important; border-color: #1d4ed8 !important; }
    </style>
    
    <script>
    // Select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_applications[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    function reviewApplication(applicationId) {
        // This will be implemented with detailed review modal
        alert('Detailed review for application ' + applicationId + ' - Feature coming soon!');
    }
    
    function quickApprove(applicationId) {
        if (confirm('Are you sure you want to approve this loan application?')) {
            // AJAX call to approve
            processLoanDecision(applicationId, 'approve');
        }
    }
    
    function quickReject(applicationId) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason) {
            processLoanDecision(applicationId, 'reject', reason);
        }
    }
    
    function requestMoreInfo(applicationId) {
        const info = prompt('What additional information is required?');
        if (info) {
            processLoanDecision(applicationId, 'more_info', info);
        }
    }
    
    function processLoanDecision(applicationId, decision, notes = '') {
        const formData = new FormData();
        formData.append('action', 'process_credit_committee_decision');
        formData.append('application_id', applicationId);
        formData.append('decision', decision);
        formData.append('notes', notes);
        formData.append('nonce', '<?php echo wp_create_nonce('credit_committee_decision'); ?>');
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.data);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    
    function bulkApproveLoans() {
        const selected = document.querySelectorAll('input[name="selected_applications[]"]:checked');
        if (selected.length === 0) {
            alert('Please select at least one application.');
            return;
        }
        
        if (confirm(`Are you sure you want to approve ${selected.length} loan application(s)?`)) {
            const applicationIds = Array.from(selected).map(cb => cb.value);
            
            const formData = new FormData();
            formData.append('action', 'bulk_approve_loans');
            formData.append('application_ids', JSON.stringify(applicationIds));
            formData.append('nonce', '<?php echo wp_create_nonce('bulk_approve_loans'); ?>');
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.data);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }
    }
    
    function exportApplications() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'csv');
        window.location.href = '?' + params.toString();
    }
    </script>
    <?php
}

/**
 * Main loan management page
 */
function daystar_loan_management_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_loan_admin_action();
    }
    
    $filter_status = $_GET['status'] ?? 'all';
    $filter_type = $_GET['type'] ?? 'all';
    $search_term = $_GET['search'] ?? '';
    
    $applications = daystar_get_all_loan_applications($filter_status, $filter_type, $search_term);
    $stats = daystar_get_loan_management_stats();
    
    ?>
    <div class="wrap">
        <h1>Loan Management</h1>
        
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
        
        <!-- Statistics Dashboard -->
        <div class="loan-stats-dashboard" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #1d4ed8;">Total Applications</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #1d4ed8;"><?php echo $stats['total_applications']; ?></div>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #f59e0b;">Pending Review</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #f59e0b;"><?php echo $stats['pending']; ?></div>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #059669;">Active Loans</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #059669;"><?php echo $stats['active']; ?></div>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #dc2626;">Total Portfolio</h3>
                <div style="font-size: 1.5rem; font-weight: bold; color: #dc2626;">KES <?php echo number_format($stats['total_portfolio'], 2); ?></div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" style="display: inline-flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="page" value="daystar-loan-management">
                    
                    <select name="status">
                        <option value="all" <?php selected($filter_status, 'all'); ?>>All Statuses</option>
                        <option value="pending" <?php selected($filter_status, 'pending'); ?>>Pending</option>
                        <option value="under_review" <?php selected($filter_status, 'under_review'); ?>>Under Review</option>
                        <option value="approved" <?php selected($filter_status, 'approved'); ?>>Approved</option>
                        <option value="rejected" <?php selected($filter_status, 'rejected'); ?>>Rejected</option>
                        <option value="disbursed" <?php selected($filter_status, 'disbursed'); ?>>Disbursed</option>
                        <option value="active" <?php selected($filter_status, 'active'); ?>>Active</option>
                        <option value="completed" <?php selected($filter_status, 'completed'); ?>>Completed</option>
                    </select>
                    
                    <select name="type">
                        <option value="all" <?php selected($filter_type, 'all'); ?>>All Types</option>
                        <option value="development" <?php selected($filter_type, 'development'); ?>>Development</option>
                                                <option value="emergency" <?php selected($filter_type, 'emergency'); ?>>Emergency</option>
                        <option value="school_fees" <?php selected($filter_type, 'school_fees'); ?>>School Fees</option>
                        <option value="business" <?php selected($filter_type, 'business'); ?>>Business</option>
                        <option value="asset_financing" <?php selected($filter_type, 'asset_financing'); ?>>Asset Financing</option>
                    </select>
                    
                    <input type="text" name="search" placeholder="Search by waiting number or member name" 
                           value="<?php echo esc_attr($search_term); ?>" style="width: 250px;">
                    
                    <input type="submit" class="button" value="Filter">
                    
                    <?php if ($filter_status !== 'all' || $filter_type !== 'all' || $search_term) : ?>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-management'); ?>" class="button">Clear Filters</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="alignright actions">
                <a href="#" class="button button-primary" onclick="exportLoans()">Export to CSV</a>
            </div>
        </div>
        
        <!-- Applications Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 120px;">Waiting Number</th>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Term</th>
                    <th>Submitted Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applications)) : ?>
                    <?php foreach ($applications as $application) : ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html($application->application_waiting_number ?: 'N/A'); ?></strong>
                                <?php if ($application->deadline_note) : ?>
                                    <br><small style="color: #d63638;"><?php echo esc_html($application->deadline_note); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $user = get_user_by('ID', $application->user_id);
                                echo esc_html($user->display_name);
                                ?>
                                <br><small>Member #<?php echo esc_html(get_user_meta($application->user_id, 'member_number', true)); ?></small>
                            </td>
                            <td>
                                <?php echo esc_html(ucfirst(str_replace('_', ' ', $application->loan_type))); ?>
                                <br><small><?php echo esc_html($application->interest_rate); ?>% p.a.</small>
                            </td>
                            <td>
                                <strong>KES <?php echo number_format($application->amount, 2); ?></strong>
                                <?php if ($application->status === 'active' && $application->balance != $application->amount) : ?>
                                    <br><small>Balance: KES <?php echo number_format($application->balance, 2); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html($application->term_months); ?> months</td>
                            <td>
                                <?php echo date('M j, Y', strtotime($application->created_at)); ?>
                                <br><small><?php echo date('g:i A', strtotime($application->created_at)); ?></small>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($application->status); ?>">
                                    <?php echo esc_html(ucfirst(str_replace('_', ' ', $application->status))); ?>
                                </span>
                                <?php if (isset($application->eligibility_score)) : ?>
                                    <br><small>Score: <?php echo $application->eligibility_score; ?>/100</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="button button-primary button-small" 
                                        onclick="viewLoanApplication(<?php echo $application->id; ?>)">
                                    View
                                </button>
                                
                                <?php if ($application->status === 'pending') : ?>
                                    <br><br>
                                    <button type="button" class="button button-small" style="background: #059669; color: white;" 
                                            onclick="updateLoanStatus(<?php echo $application->id; ?>, 'approved')">
                                        Approve
                                    </button>
                                    <button type="button" class="button button-small" style="background: #dc2626; color: white;" 
                                            onclick="updateLoanStatus(<?php echo $application->id; ?>, 'rejected')">
                                        Reject
                                    </button>
                                <?php endif; ?>
                                
                                <?php if ($application->status === 'approved') : ?>
                                    <br><br>
                                    <button type="button" class="button button-small" style="background: #1d4ed8; color: white;" 
                                            onclick="updateLoanStatus(<?php echo $application->id; ?>, 'disbursed')">
                                        Disburse
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No loan applications found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Loan Application Review Modal -->
    <div id="loan-review-modal" style="display: none;">
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100000;">
            <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 1200px; width: 95%; max-height: 90vh; overflow-y: auto;">
                <h2>Loan Application Review</h2>
                <div id="loan-details"></div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="button" onclick="closeLoanModal()">Close</button>
                    <button type="button" class="button button-primary" onclick="printLoan()">Print</button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: bold;
    }
    
    .status-pending { background: #e0e7ff; color: #3730a3; }
    .status-under_review { background: #fef3c7; color: #92400e; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }
    .status-disbursed { background: #dbeafe; color: #1e40af; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-completed { background: #f3f4f6; color: #374151; }
    
    .modal-content {
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .loan-section {
        margin-bottom: 30px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .loan-section h3 {
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
    }
    
    .info-value {
        color: #6b7280;
    }
    </style>
    
    <script>
    const loansData = <?php echo json_encode($applications); ?>;
    
    function viewLoanApplication(loanId) {
        const loan = loansData.find(l => l.id == loanId);
        
        if (!loan) return;
        
        // Build loan details HTML
        let html = '';
        
        // Basic Information
        html += '<div class="loan-section">';
        html += '<h3>Application Information</h3>';
        html += '<div class="info-grid">';
        html += `<div class="info-item"><div class="info-label">Waiting Number</div><div class="info-value">${loan.application_waiting_number || 'N/A'}</div></div>`;
        html += `<div class="info-item"><div class="info-label">Application Date</div><div class="info-value">${new Date(loan.created_at).toLocaleDateString()}</div></div>`;
        html += `<div class="info-item"><div class="info-label">Status</div><div class="info-value"><span class="status-badge status-${loan.status}">${loan.status.replace('_', ' ').toUpperCase()}</span></div></div>`;
        if (loan.eligibility_score) {
            html += `<div class="info-item"><div class="info-label">Eligibility Score</div><div class="info-value">${loan.eligibility_score}/100</div></div>`;
        }
        html += '</div>';
        html += '</div>';
        
        // Loan Details
        html += '<div class="loan-section">';
        html += '<h3>Loan Details</h3>';
        html += '<div class="info-grid">';
        html += `<div class="info-item"><div class="info-label">Loan Type</div><div class="info-value">${loan.loan_type.replace('_', ' ').toUpperCase()}</div></div>`;
        html += `<div class="info-item"><div class="info-label">Amount</div><div class="info-value">KES ${parseFloat(loan.amount).toLocaleString()}</div></div>`;
        html += `<div class="info-item"><div class="info-label">Term</div><div class="info-value">${loan.term_months} months</div></div>`;
        html += `<div class="info-item"><div class="info-label">Interest Rate</div><div class="info-value">${loan.interest_rate}% p.a.</div></div>`;
        html += `<div class="info-item"><div class="info-label">Monthly Payment</div><div class="info-value">KES ${parseFloat(loan.monthly_payment || 0).toLocaleString()}</div></div>`;
        if (loan.processing_fee) {
            html += `<div class="info-item"><div class="info-label">Processing Fee</div><div class="info-value">KES ${parseFloat(loan.processing_fee).toLocaleString()}</div></div>`;
        }
        html += '</div>';
        html += `<div style="margin-top: 15px;"><div class="info-label">Purpose</div><div class="info-value">${loan.purpose}</div></div>`;
        html += '</div>';
        
        // Member Information
        html += '<div class="loan-section">';
        html += '<h3>Member Information</h3>';
        html += '<div class="info-grid">';
        html += `<div class="info-item"><div class="info-label">Member Name</div><div class="info-value">${loan.member_name || 'Loading...'}</div></div>`;
        if (loan.employment_status) {
            html += `<div class="info-item"><div class="info-label">Employment Status</div><div class="info-value">${loan.employment_status}</div></div>`;
        }
        if (loan.employer_name) {
            html += `<div class="info-item"><div class="info-label">Employer</div><div class="info-value">${loan.employer_name}</div></div>`;
        }
        if (loan.monthly_income) {
            html += `<div class="info-item"><div class="info-label">Monthly Income</div><div class="info-value">KES ${parseFloat(loan.monthly_income).toLocaleString()}</div></div>`;
        }
        html += '</div>';
        html += '</div>';
        
        // Status and Notes
        if (loan.application_notes || loan.rejection_reason) {
            html += '<div class="loan-section">';
            html += '<h3>Notes and Comments</h3>';
            if (loan.application_notes) {
                html += `<div style="margin-bottom: 15px;"><div class="info-label">Application Notes</div><div class="info-value">${loan.application_notes}</div></div>`;
            }
            if (loan.rejection_reason) {
                html += `<div><div class="info-label">Rejection Reason</div><div class="info-value" style="color: #dc2626;">${loan.rejection_reason}</div></div>`;
            }
            html += '</div>';
        }
        
        document.getElementById('loan-details').innerHTML = html;
        document.getElementById('loan-review-modal').style.display = 'block';
    }
    
    function closeLoanModal() {
        document.getElementById('loan-review-modal').style.display = 'none';
    }
    
    function updateLoanStatus(loanId, newStatus) {
        let reason = '';
        if (newStatus === 'rejected') {
            reason = prompt('Please provide a reason for rejection:');
            if (!reason) return;
        }
        
        if (confirm(`Are you sure you want to ${newStatus.replace('_', ' ')} this loan application?`)) {
            // AJAX call to update status
            const formData = new FormData();
            formData.append('action', 'update_loan_status');
            formData.append('loan_id', loanId);
            formData.append('status', newStatus);
            formData.append('reason', reason);
            formData.append('nonce', '<?php echo wp_create_nonce('update_loan_status'); ?>');
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.data);
                }
            })
            .catch(error => {
                alert('Error updating status: ' + error);
            });
        }
    }
    
    function printLoan() {
        window.print();
    }
    
    function exportLoans() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'csv');
        window.location.href = '?' + params.toString();
    }
    
    // Close modal when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeLoanModal();
        }
    });
    </script>
    <?php
}

/**
 * Pending loans page
 */
function daystar_pending_loans_page() {
    $pending_loans = daystar_get_all_loan_applications('pending');
    
    ?>
    <div class="wrap">
        <h1>Pending Loan Applications</h1>
        
        <p>Applications requiring immediate attention:</p>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Waiting Number</th>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Submitted</th>
                    <th>Days Pending</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pending_loans)) : ?>
                    <?php foreach ($pending_loans as $loan) : ?>
                        <?php 
                        $days_pending = floor((time() - strtotime($loan->created_at)) / (24 * 60 * 60));
                        $urgency_class = $days_pending > 7 ? 'urgent' : ($days_pending > 3 ? 'warning' : 'normal');
                        ?>
                        <tr class="<?php echo $urgency_class; ?>">
                            <td><strong><?php echo esc_html($loan->application_waiting_number ?: 'N/A'); ?></strong></td>
                            <td>
                                <?php 
                                $user = get_user_by('ID', $loan->user_id);
                                echo esc_html($user->display_name);
                                ?>
                            </td>
                            <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $loan->loan_type))); ?></td>
                            <td>KES <?php echo number_format($loan->amount, 2); ?></td>
                            <td><?php echo date('M j, Y', strtotime($loan->created_at)); ?></td>
                            <td>
                                <span class="days-pending <?php echo $urgency_class; ?>">
                                    <?php echo $days_pending; ?> days
                                </span>
                            </td>
                            <td>
                                <button type="button" class="button button-primary button-small" 
                                        onclick="viewLoanApplication(<?php echo $loan->id; ?>)">
                                    Review
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No pending loan applications.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <style>
    .urgent { background-color: #fef2f2; }
    .warning { background-color: #fffbeb; }
    .normal { background-color: #f0fdf4; }
    
    .days-pending.urgent { color: #dc2626; font-weight: bold; }
    .days-pending.warning { color: #d97706; font-weight: bold; }
    .days-pending.normal { color: #059669; }
    </style>
    <?php
}

/**
 * Active loans page
 */
function daystar_active_loans_page() {
    $active_loans = daystar_get_all_loan_applications('active');
    
    ?>
    <div class="wrap">
        <h1>Active Loans</h1>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Loan ID</th>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Original Amount</th>
                    <th>Current Balance</th>
                    <th>Monthly Payment</th>
                    <th>Next Payment Due</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($active_loans)) : ?>
                    <?php foreach ($active_loans as $loan) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($loan->application_waiting_number ?: $loan->id); ?></strong></td>
                            <td>
                                <?php 
                                $user = get_user_by('ID', $loan->user_id);
                                echo esc_html($user->display_name);
                                ?>
                            </td>
                            <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $loan->loan_type))); ?></td>
                            <td>KES <?php echo number_format($loan->amount, 2); ?></td>
                            <td>KES <?php echo number_format($loan->balance, 2); ?></td>
                            <td>KES <?php echo number_format($loan->monthly_payment, 2); ?></td>
                            <td>
                                <?php 
                                $next_payment = date('M j, Y', strtotime($loan->loan_date . ' +1 month'));
                                echo $next_payment;
                                ?>
                            </td>
                            <td>
                                <button type="button" class="button button-small" 
                                        onclick="viewLoanApplication(<?php echo $loan->id; ?>)">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No active loans found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Loan repayments management page
 */
function daystar_loan_repayments_page() {
    // Handle payment processing
    if (isset($_POST['action']) && $_POST['action'] === 'process_payment') {
        daystar_handle_payment_processing();
    }
    
    $filter_status = $_GET['status'] ?? 'all';
    $search_term = $_GET['search'] ?? '';
    
    $active_loans = daystar_get_active_loans_for_repayment($filter_status, $search_term);
    $delinquency_report = function_exists('daystar_get_delinquency_report') ? daystar_get_delinquency_report() : array();
    $overdue_summary = function_exists('daystar_get_overdue_loans_summary') ? daystar_get_overdue_loans_summary() : array();
    
    ?>
    <div class="wrap">
        <h1>Loan Repayments Management</h1>
        
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
        
        <!-- Delinquency Dashboard -->
        <div class="delinquency-dashboard" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #059669;">Current Loans</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #059669;">
                    <?php echo isset($delinquency_report['current']['count']) ? $delinquency_report['current']['count'] : 0; ?>
                </div>
                <small>Up to date payments</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #f59e0b;">1-30 Days</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #f59e0b;">
                    <?php echo isset($delinquency_report['1_30_days']['count']) ? $delinquency_report['1_30_days']['count'] : 0; ?>
                </div>
                <small>Early delinquency</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #dc2626;">31-90 Days</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc2626;">
                    <?php 
                    $count_31_60 = isset($delinquency_report['31_60_days']['count']) ? $delinquency_report['31_60_days']['count'] : 0;
                    $count_61_90 = isset($delinquency_report['61_90_days']['count']) ? $delinquency_report['61_90_days']['count'] : 0;
                    echo $count_31_60 + $count_61_90;
                    ?>
                </div>
                <small>Serious delinquency</small>
            </div>
            <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #7c2d12;">Willful Failure</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #7c2d12;">
                    <?php echo isset($delinquency_report['willful_failure']['count']) ? $delinquency_report['willful_failure']['count'] : 0; ?>
                </div>
                <small>Disciplinary action required</small>
            </div>
        </div>
        
        <!-- Quick Payment Entry -->
        <div class="payment-entry-section" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
            <h3>Record Payment</h3>
            <form method="post" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <input type="hidden" name="action" value="process_payment">
                <?php wp_nonce_field('process_payment', 'payment_nonce'); ?>
                
                <div>
                    <label for="loan_id">Loan ID/Waiting Number:</label>
                    <input type="text" id="loan_id" name="loan_id" required placeholder="Enter loan ID or waiting number" style="width: 100%;">
                </div>
                
                <div>
                    <label for="amount">Payment Amount (KES):</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0.01" required style="width: 100%;">
                </div>
                
                <div>
                    <label for="payment_method">Payment Method:</label>
                    <select id="payment_method" name="payment_method" required style="width: 100%;">
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="mpesa">M-Pesa</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="payroll_deduction">Payroll Deduction</option>
                    </select>
                </div>
                
                <div>
                    <label for="reference_number">Reference Number:</label>
                    <input type="text" id="reference_number" name="reference_number" placeholder="Transaction reference" style="width: 100%;">
                </div>
                
                <div>
                    <label for="notes">Notes (Optional):</label>
                    <input type="text" id="notes" name="notes" placeholder="Additional notes" style="width: 100%;">
                </div>
                
                <div>
                    <input type="submit" class="button button-primary" value="Process Payment" style="width: 100%;">
                </div>
            </form>
        </div>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" style="display: inline-flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="page" value="daystar-loan-repayments">
                    
                    <select name="status">
                        <option value="all" <?php selected($filter_status, 'all'); ?>>All Loans</option>
                        <option value="current" <?php selected($filter_status, 'current'); ?>>Current</option>
                        <option value="overdue" <?php selected($filter_status, 'overdue'); ?>>Overdue</option>
                        <option value="willful_failure" <?php selected($filter_status, 'willful_failure'); ?>>Willful Failure</option>
                    </select>
                    
                    <input type="text" name="search" placeholder="Search by member name or loan ID" 
                           value="<?php echo esc_attr($search_term); ?>" style="width: 250px;">
                    
                    <input type="submit" class="button" value="Filter">
                    
                    <?php if ($filter_status !== 'all' || $search_term) : ?>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-repayments'); ?>" class="button">Clear Filters</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="alignright actions">
                <button type="button" class="button" onclick="updateOverdueStatus()">Update Overdue Status</button>
                <button type="button" class="button button-primary" onclick="exportRepaymentReport()">Export Report</button>
            </div>
        </div>
        
        <!-- Active Loans Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 120px;">Loan ID</th>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Balance</th>
                    <th>Monthly Payment</th>
                    <th>Next Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($active_loans)) : ?>
                    <?php foreach ($active_loans as $loan) : ?>
                        <?php 
                        $user = get_user_by('ID', $loan->user_id);
                        $next_due_date = 'N/A';
                        $status_class = 'current';
                        $days_overdue = 0;
                        
                        // Get next due date from schedule if available
                        if (function_exists('daystar_get_loan_schedule')) {
                            $schedule = daystar_get_loan_schedule($loan->id);
                            foreach ($schedule as $installment) {
                                if ($installment->status === 'due' || $installment->status === 'overdue') {
                                    $next_due_date = date('M j, Y', strtotime($installment->due_date));
                                    $days_overdue = $installment->days_overdue;
                                    if ($days_overdue > 0) {
                                        $status_class = 'overdue';
                                    }
                                    break;
                                }
                            }
                        }
                        
                        if ($loan->is_willful_failure) {
                            $status_class = 'willful_failure';
                        }
                        ?>
                        <tr class="loan-row-<?php echo $status_class; ?>">
                            <td>
                                <strong><?php echo esc_html($loan->application_waiting_number ?: $loan->id); ?></strong>
                                <?php if ($loan->is_willful_failure) : ?>
                                    <br><span style="color: #dc2626; font-weight: bold;">⚠ WILLFUL FAILURE</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo esc_html($user->display_name); ?></strong>
                                <br><small>Member #<?php echo esc_html(get_user_meta($loan->user_id, 'member_number', true)); ?></small>
                            </td>
                            <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $loan->loan_type))); ?></td>
                            <td>
                                <strong>KES <?php echo number_format($loan->balance, 2); ?></strong>
                                <br><small>of KES <?php echo number_format($loan->amount, 2); ?></small>
                            </td>
                            <td>KES <?php echo number_format($loan->monthly_payment, 2); ?></td>
                            <td>
                                <?php echo $next_due_date; ?>
                                <?php if ($days_overdue > 0) : ?>
                                    <br><span style="color: #dc2626; font-weight: bold;"><?php echo $days_overdue; ?> days overdue</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $status_class; ?>">
                                    <?php 
                                    if ($loan->is_willful_failure) {
                                        echo 'WILLFUL FAILURE';
                                    } elseif ($days_overdue > 0) {
                                        echo 'OVERDUE';
                                    } else {
                                        echo 'CURRENT';
                                    }
                                    ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="button button-small" 
                                        onclick="viewLoanSchedule(<?php echo $loan->id; ?>)">
                                    View Schedule
                                </button>
                                <br><br>
                                <button type="button" class="button button-small" 
                                        onclick="recordPayment(<?php echo $loan->id; ?>)">
                                    Record Payment
                                </button>
                                
                                <?php if ($days_overdue > 90 && !$loan->is_willful_failure) : ?>
                                    <br><br>
                                    <button type="button" class="button button-small" style="background: #dc2626; color: white;" 
                                            onclick="flagWillfulFailure(<?php echo $loan->id; ?>)">
                                        Flag Willful Failure
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No active loans found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Overdue Loans Summary -->
        <?php if (!empty($overdue_summary)) : ?>
            <div style="margin-top: 30px;">
                <h3>Overdue Loans Summary</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Member</th>
                            <th>Overdue Installments</th>
                            <th>Total Overdue Amount</th>
                            <th>Max Days Overdue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdue_summary as $overdue_loan) : ?>
                            <?php $user = get_user_by('ID', $overdue_loan->user_id); ?>
                            <tr>
                                <td><strong><?php echo esc_html($overdue_loan->loan_id); ?></strong></td>
                                <td><?php echo esc_html($user->display_name); ?></td>
                                <td><?php echo $overdue_loan->overdue_installments; ?></td>
                                <td><strong>KES <?php echo number_format($overdue_loan->total_overdue_amount, 2); ?></strong></td>
                                <td>
                                    <span style="color: #dc2626; font-weight: bold;">
                                        <?php echo $overdue_loan->max_days_overdue; ?> days
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="button button-small" 
                                            onclick="contactMember(<?php echo $overdue_loan->user_id; ?>)">
                                        Contact Member
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
    .loan-row-current { background-color: #f0fdf4; }
    .loan-row-overdue { background-color: #fef2f2; }
    .loan-row-willful_failure { background-color: #7c2d12; color: white; }
    
    .status-current { background: #d1fae5; color: #065f46; }
    .status-overdue { background: #fef2f2; color: #dc2626; }
    .status-willful_failure { background: #7c2d12; color: white; }
    </style>
    
    <script>
    function viewLoanSchedule(loanId) {
        // This would open a modal or redirect to schedule view
        window.open('<?php echo admin_url('admin.php?page=daystar-loan-schedule&loan_id='); ?>' + loanId, '_blank');
    }
    
    function recordPayment(loanId) {
        document.getElementById('loan_id').value = loanId;
        document.getElementById('loan_id').scrollIntoView();
    }
    
    function flagWillfulFailure(loanId) {
        const reason = prompt('Please provide a reason for flagging this loan as willful failure:');
        if (reason) {
            if (confirm('Are you sure you want to flag this loan for willful failure? This action will trigger disciplinary procedures.')) {
                // AJAX call to flag willful failure
                const formData = new FormData();
                formData.append('action', 'flag_willful_failure');
                formData.append('loan_id', loanId);
                formData.append('reason', reason);
                formData.append('nonce', '<?php echo wp_create_nonce('flag_willful_failure'); ?>');
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.data);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            }
        }
    }
    
    function contactMember(userId) {
        // This would open contact interface
        alert('Contact member feature - to be implemented');
    }
    
    function updateOverdueStatus() {
        if (confirm('This will update the overdue status for all loans. Continue?')) {
            const formData = new FormData();
            formData.append('action', 'update_overdue_status');
            formData.append('nonce', '<?php echo wp_create_nonce('update_overdue_status'); ?>');
            
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Overdue status updated successfully');
                    location.reload();
                } else {
                    alert('Error: ' + data.data);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }
    }
    
    function exportRepaymentReport() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'csv');
        window.location.href = '?' + params.toString();
    }
    </script>
    <?php
}

/**
 * Loan statistics page
 */
function daystar_loan_statistics_page() {
    $stats = daystar_get_comprehensive_loan_statistics();
    
    ?>
    <div class="wrap">
        <h1>Loan Statistics</h1>
        
        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0;">
            <!-- Portfolio Overview -->
            <div class="stat-section">
                <h3>Portfolio Overview</h3>
                <table class="widefat">
                    <tr><td>Total Portfolio Value</td><td><strong>KES <?php echo number_format($stats['total_portfolio'], 2); ?></strong></td></tr>
                    <tr><td>Number of Active Loans</td><td><strong><?php echo $stats['active_loans']; ?></strong></td></tr>
                    <tr><td>Average Loan Size</td><td><strong>KES <?php echo number_format($stats['avg_loan_size'], 2); ?></strong></td></tr>
                    <tr><td>Portfolio at Risk</td><td><strong><?php echo number_format($stats['portfolio_at_risk'], 2); ?>%</strong></td></tr>
                </table>
            </div>
            
            <!-- Application Statistics -->
            <div class="stat-section">
                <h3>Application Statistics</h3>
                <table class="widefat">
                    <tr><td>Total Applications</td><td><strong><?php echo $stats['total_applications']; ?></strong></td></tr>
                    <tr><td>Approval Rate</td><td><strong><?php echo number_format($stats['approval_rate'], 1); ?>%</strong></td></tr>
                    <tr><td>Average Processing Time</td><td><strong><?php echo $stats['avg_processing_days']; ?> days</strong></td></tr>
                    <tr><td>Applications This Month</td><td><strong><?php echo $stats['applications_this_month']; ?></strong></td></tr>
                </table>
            </div>
            
            <!-- Loan Type Distribution -->
            <div class="stat-section">
                <h3>Loan Type Distribution</h3>
                <table class="widefat">
                    <?php foreach ($stats['loan_type_distribution'] as $type => $data) : ?>
                        <tr>
                            <td><?php echo ucfirst(str_replace('_', ' ', $type)); ?></td>
                            <td><strong><?php echo $data['count']; ?> (<?php echo number_format($data['percentage'], 1); ?>%)</strong></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    
    <style>
    .stat-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-section h3 {
        margin-top: 0;
        color: #1d4ed8;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
    
    .stat-section table {
        margin-top: 15px;
    }
    
    .stat-section table td {
        padding: 8px 12px;
        border-bottom: 1px solid #f3f4f6;
    }
    </style>
    <?php
}

/**
 * Handle loan admin actions
 */
function daystar_handle_loan_admin_action() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $action = sanitize_text_field($_POST['action']);
    $loan_id = intval($_POST['loan_id']);
    $admin_user_id = get_current_user_id();
    
    $redirect_url = admin_url('admin.php?page=daystar-loan-management');
    
    switch ($action) {
        case 'approve_loan':
            $notes = sanitize_textarea_field($_POST['notes'] ?? '');
            $result = daystar_update_loan_status($loan_id, 'approved', $admin_user_id, $notes);
            
            if ($result) {
                $redirect_url = add_query_arg('message', urlencode('Loan approved successfully.'), $redirect_url);
            } else {
                $redirect_url = add_query_arg('error', urlencode('Failed to approve loan.'), $redirect_url);
            }
            break;
            
        case 'reject_loan':
            $reason = sanitize_textarea_field($_POST['rejection_reason'] ?? '');
            $result = daystar_update_loan_status($loan_id, 'rejected', $admin_user_id, $reason);
            
            if ($result) {
                $redirect_url = add_query_arg('message', urlencode('Loan rejected.'), $redirect_url);
            } else {
                $redirect_url = add_query_arg('error', urlencode('Failed to reject loan.'), $redirect_url);
            }
            break;
            
        case 'disburse_loan':
            $result = daystar_update_loan_status($loan_id, 'disbursed', $admin_user_id);
            
            if ($result) {
                $redirect_url = add_query_arg('message', urlencode('Loan disbursed successfully.'), $redirect_url);
            } else {
                $redirect_url = add_query_arg('error', urlencode('Failed to disburse loan.'), $redirect_url);
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
 * Get all loan applications with filters
 */
function daystar_get_all_loan_applications($status = 'all', $type = 'all', $search = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $where_conditions = array("1=1");
    $where_values = array();
    
    if ($status !== 'all') {
        $where_conditions[] = "status = %s";
        $where_values[] = $status;
    }
    
    if ($type !== 'all') {
        $where_conditions[] = "loan_type = %s";
        $where_values[] = $type;
    }
    
    if ($search) {
        $where_conditions[] = "(application_waiting_number LIKE %s OR user_id IN (SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s))";
        $where_values[] = '%' . $search . '%';
        $where_values[] = '%' . $search . '%';
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "SELECT * FROM {$loans_table} WHERE {$where_clause} ORDER BY created_at DESC";
    
    if (!empty($where_values)) {
        $query = $wpdb->prepare($query, $where_values);
    }
    
    return $wpdb->get_results($query);
}

/**
 * Get loan management statistics
 */
function daystar_get_loan_management_stats() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $stats = array();
    
    // Total applications
    $stats['total_applications'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table}");
    
    // Pending applications
    $stats['pending'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'pending'");
    
    // Active loans
    $stats['active'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'active'");
    
    // Total portfolio value
    $stats['total_portfolio'] = $wpdb->get_var("SELECT SUM(balance) FROM {$loans_table} WHERE status IN ('active', 'disbursed')") ?: 0;
    
    return $stats;
}

/**
 * Get comprehensive loan statistics
 */
function daystar_get_comprehensive_loan_statistics() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $stats = array();
    
    // Portfolio overview
    $stats['total_portfolio'] = $wpdb->get_var("SELECT SUM(balance) FROM {$loans_table} WHERE status IN ('active', 'disbursed')") ?: 0;
    $stats['active_loans'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'active'");
    $stats['avg_loan_size'] = $stats['active_loans'] > 0 ? ($stats['total_portfolio'] / $stats['active_loans']) : 0;
    $stats['portfolio_at_risk'] = 5.2; // This would be calculated based on overdue loans
    
    // Application statistics
    $stats['total_applications'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table}");
    $approved_count = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status IN ('approved', 'disbursed', 'active')");
    $stats['approval_rate'] = $stats['total_applications'] > 0 ? (($approved_count / $stats['total_applications']) * 100) : 0;
    $stats['avg_processing_days'] = 8; // This would be calculated from actual processing times
    $stats['applications_this_month'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    
    // Loan type distribution
    $loan_types = $wpdb->get_results("SELECT loan_type, COUNT(*) as count FROM {$loans_table} GROUP BY loan_type");
    $stats['loan_type_distribution'] = array();
    
    foreach ($loan_types as $type) {
        $percentage = ($type->count / $stats['total_applications']) * 100;
        $stats['loan_type_distribution'][$type->loan_type] = array(
            'count' => $type->count,
            'percentage' => $percentage
        );
    }
    
    return $stats;
}

/**
 * AJAX handler for updating loan status
 */
function daystar_ajax_update_loan_status() {
    if (!wp_verify_nonce($_POST['nonce'], 'update_loan_status')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    $loan_id = intval($_POST['loan_id']);
    $status = sanitize_text_field($_POST['status']);
    $reason = sanitize_textarea_field($_POST['reason'] ?? '');
    $admin_user_id = get_current_user_id();
    
    $result = daystar_update_loan_status($loan_id, $status, $admin_user_id, $reason);
    
    if ($result) {
        wp_send_json_success('Loan status updated successfully');
    } else {
        wp_send_json_error('Failed to update loan status');
    }
}
add_action('wp_ajax_update_loan_status', 'daystar_ajax_update_loan_status');

/**
 * Get Credit Committee statistics
 */
function daystar_get_credit_committee_stats() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $stats = array();
    
    // Pending review
    $stats['pending_review'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status IN ('pending', 'under_review')");
    
    // High priority applications (assuming priority_score field exists)
    $stats['high_priority'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'pending' AND (priority_score >= 80 OR DATEDIFF(NOW(), created_at) > 7)");
    
    // Approval rate this month
    $total_this_month = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    $approved_this_month = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE MONTH(approved_date) = MONTH(CURRENT_DATE()) AND YEAR(approved_date) = YEAR(CURRENT_DATE()) AND status IN ('approved', 'disbursed', 'active')");
    
    $stats['approval_rate'] = $total_this_month > 0 ? (($approved_this_month / $total_this_month) * 100) : 0;
    
    return $stats;
}

/**
 * Get available loan funds
 */
function daystar_get_available_loan_funds() {
    // This would be calculated based on SACCO's liquidity
    // For now, return a sample amount based on total contributions
    global $wpdb;
    
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Get total contributions
    $total_contributions = $wpdb->get_var("SELECT SUM(amount) FROM {$contributions_table} WHERE status = 'completed'");
    
    // Get total outstanding loans
    $total_outstanding = $wpdb->get_var("SELECT SUM(balance) FROM {$loans_table} WHERE status IN ('active', 'disbursed')");
    
    // Calculate available funds (simplified calculation)
    $available_funds = ($total_contributions * 0.8) - $total_outstanding; // 80% of contributions minus outstanding
    
    return max(0, $available_funds ?: 5000000); // Minimum KES 5,000,000
}

/**
 * Get applications for Credit Committee review
 */
function daystar_get_credit_committee_applications($status = 'pending', $priority = 'all', $search = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $where_conditions = array("1=1");
    $where_values = array();
    
    if ($status !== 'all') {
        if ($status === 'pending') {
            $where_conditions[] = "status IN ('pending', 'under_review')";
        } else {
            $where_conditions[] = "status = %s";
            $where_values[] = $status;
        }
    }
    
    if ($search) {
        $where_conditions[] = "(application_waiting_number LIKE %s OR user_id IN (SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s))";
        $where_values[] = '%' . $search . '%';
        $where_values[] = '%' . $search . '%';
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "SELECT * FROM {$loans_table} WHERE {$where_clause} ORDER BY created_at ASC";
    
    if (!empty($where_values)) {
        $query = $wpdb->prepare($query, $where_values);
    }
    
    $applications = $wpdb->get_results($query);
    
    // Calculate priority scores for applications that don't have them
    foreach ($applications as $application) {
        if (!isset($application->priority_score) || !$application->priority_score) {
            $priority_data = daystar_calculate_loan_priority($application);
            $wpdb->update(
                $loans_table,
                array('priority_score' => $priority_data['score']),
                array('id' => $application->id)
            );
            $application->priority_score = $priority_data['score'];
        }
    }
    
    // Sort by priority score (highest first)
    usort($applications, function($a, $b) {
        return ($b->priority_score ?? 0) - ($a->priority_score ?? 0);
    });
    
    // Filter by priority if specified
    if ($priority !== 'all') {
        $applications = array_filter($applications, function($app) use ($priority) {
            $priority_data = daystar_calculate_loan_priority($app);
            return $priority_data['level'] === $priority;
        });
    }
    
    return $applications;
}

/**
 * Get comprehensive member data for Credit Committee review
 */
function daystar_get_member_comprehensive_data($user_id) {
    $user = get_user_by('ID', $user_id);
    
    if (!$user) {
        return array(
            'display_name' => 'Unknown Member',
            'member_number' => 'N/A',
            'registration_date' => '',
            'member_status' => 'inactive'
        );
    }
    
    return array(
        'display_name' => $user->display_name,
        'member_number' => get_user_meta($user_id, 'member_number', true) ?: 'N/A',
        'registration_date' => get_user_meta($user_id, 'registration_date', true) ?: $user->user_registered,
        'member_status' => get_user_meta($user_id, 'member_status', true) ?: 'active',
        'employment_status' => get_user_meta($user_id, 'employment_status', true),
        'employer_name' => get_user_meta($user_id, 'employer_name', true),
        'phone_number' => get_user_meta($user_id, 'phone_number', true),
        'id_number' => get_user_meta($user_id, 'id_number', true),
        'share_capital' => daystar_get_member_share_capital($user_id),
        'total_contributions' => daystar_get_member_total_contributions($user_id),
        'active_loans' => daystar_get_member_active_loans_count($user_id),
        'credit_score' => daystar_get_member_credit_score($user_id)
    );
}

/**
 * Calculate loan priority based on PRD requirements
 */
function daystar_calculate_loan_priority($application) {
    $priority_score = 50; // Base score
    $factors = array();
    
    // Factor 1: Nature of the need (Emergency gets highest priority)
    if (strpos(strtolower($application->loan_type), 'emergency') !== false) {
        $priority_score += 30;
        $factors[] = 'Emergency loan (+30)';
    } elseif (strpos(strtolower($application->loan_type), 'school') !== false) {
        $priority_score += 20;
        $factors[] = 'School fees (+20)';
    } elseif (strpos(strtolower($application->loan_type), 'development') !== false) {
        $priority_score += 15;
        $factors[] = 'Development loan (+15)';
    }
    
    // Factor 2: New members who have qualified
    $member_data = daystar_get_member_comprehensive_data($application->user_id);
    $registration_date = strtotime($member_data['registration_date']);
    $months_as_member = floor((time() - $registration_date) / (30 * 24 * 60 * 60));
    
    if ($months_as_member <= 12) {
        $priority_score += 15;
        $factors[] = 'New member (+15)';
    }
    
    // Factor 3: Members who have never had loans
    if (daystar_get_member_loan_history_count($application->user_id) == 0) {
        $priority_score += 20;
        $factors[] = 'First-time borrower (+20)';
    }
    
    // Factor 4: Members who cleared their first loans
    if (daystar_has_cleared_previous_loans($application->user_id)) {
        $priority_score += 10;
        $factors[] = 'Good repayment history (+10)';
    }
    
    // Factor 5: Application age (older applications get higher priority)
    $days_pending = floor((time() - strtotime($application->created_at)) / (24 * 60 * 60));
    if ($days_pending > 14) {
        $priority_score += 15;
        $factors[] = 'Long pending (' . $days_pending . ' days) (+15)';
    } elseif ($days_pending > 7) {
        $priority_score += 10;
        $factors[] = 'Pending over a week (+10)';
    }
    
    // Factor 6: Loan amount (smaller loans get slight priority for quick processing)
    if ($application->amount <= 50000) {
        $priority_score += 5;
        $factors[] = 'Small loan amount (+5)';
    }
    
    // Determine priority level
    $level = 'low';
    if ($priority_score >= 80) {
        $level = 'high';
    } elseif ($priority_score >= 65) {
        $level = 'medium';
    }
    
    return array(
        'score' => min(100, $priority_score),
        'level' => $level,
        'factors' => $factors
    );
}

/**
 * Assess the Five Cs for loan evaluation
 */
function daystar_assess_five_cs($user_id, $eligibility_data) {
    $five_cs = array();
    
    // Character Assessment (Credit History & Membership Behavior)
    $character_score = 5; // Base score
    if (isset($eligibility_data['criteria_results']['credit_history'])) {
        $credit_score = $eligibility_data['criteria_results']['credit_history']['credit_score'];
        if ($credit_score >= 90) $character_score = 10;
        elseif ($credit_score >= 80) $character_score = 8;
        elseif ($credit_score >= 70) $character_score = 7;
        elseif ($credit_score >= 60) $character_score = 6;
        else $character_score = 3;
    }
    
    $five_cs['character'] = array(
        'score' => $character_score,
        'level' => $character_score >= 8 ? 'excellent' : ($character_score >= 6 ? 'good' : ($character_score >= 4 ? 'fair' : 'poor')),
        'details' => 'Based on credit history and membership behavior'
    );
    
    // Capacity Assessment (Income & Debt-to-Income Ratio)
    $capacity_score = 5;
    if (isset($eligibility_data['criteria_results']['economic_income']) && $eligibility_data['criteria_results']['economic_income']['met']) {
        $income = $eligibility_data['criteria_results']['economic_income']['income_amount'];
        if ($income >= 100000) $capacity_score = 10;
        elseif ($income >= 75000) $capacity_score = 8;
        elseif ($income >= 50000) $capacity_score = 7;
        elseif ($income >= 30000) $capacity_score = 6;
        else $capacity_score = 4;
    }
    
    $five_cs['capacity'] = array(
        'score' => $capacity_score,
        'level' => $capacity_score >= 8 ? 'excellent' : ($capacity_score >= 6 ? 'good' : ($capacity_score >= 4 ? 'fair' : 'poor')),
        'details' => 'Based on income verification and debt-to-income ratio'
    );
    
    // Capital Assessment (Share Capital & Contributions)
    $capital_score = 5;
    if (isset($eligibility_data['criteria_results']['share_capital'])) {
        $share_capital = $eligibility_data['criteria_results']['share_capital']['current_amount'];
        if ($share_capital >= 50000) $capital_score = 10;
        elseif ($share_capital >= 25000) $capital_score = 8;
        elseif ($share_capital >= 15000) $capital_score = 7;
        elseif ($share_capital >= 10000) $capital_score = 6;
        elseif ($share_capital >= 5000) $capital_score = 5;
        else $capital_score = 3;
    }
    
    $five_cs['capital'] = array(
        'score' => $capital_score,
        'level' => $capital_score >= 8 ? 'excellent' : ($capital_score >= 6 ? 'good' : ($capital_score >= 4 ? 'fair' : 'poor')),
        'details' => 'Based on share capital and contribution history'
    );
    
    // Collateral Assessment
    $collateral_score = 5;
    if (isset($eligibility_data['criteria_results']['collateral'])) {
        if (!$eligibility_data['criteria_results']['collateral']['required']) {
            $collateral_score = 8; // No collateral required
        } elseif ($eligibility_data['criteria_results']['collateral']['met']) {
            $collateral_score = 10; // Adequate collateral provided
        } else {
            $collateral_score = 3; // Insufficient collateral
        }
    }
    
    $five_cs['collateral'] = array(
        'score' => $collateral_score,
        'level' => $collateral_score >= 8 ? 'excellent' : ($collateral_score >= 6 ? 'good' : ($collateral_score >= 4 ? 'fair' : 'poor')),
        'details' => 'Based on collateral requirements and provision'
    );
    
    // Purpose Assessment (Loan Purpose & Viability)
    $purpose_score = 7; // Default good score for most purposes
    // This could be enhanced with more sophisticated purpose analysis
    
    $five_cs['purpose'] = array(
        'score' => $purpose_score,
        'level' => $purpose_score >= 8 ? 'excellent' : ($purpose_score >= 6 ? 'good' : ($purpose_score >= 4 ? 'fair' : 'poor')),
        'details' => 'Based on loan purpose and viability assessment'
    );
    
    return $five_cs;
}

/**
 * Handle Credit Committee actions
 */
function daystar_handle_credit_committee_action() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $action = sanitize_text_field($_POST['action']);
    $redirect_url = admin_url('admin.php?page=daystar-credit-committee');
    
    // Handle different actions here
    // This will be expanded with specific action handlers
    
    wp_redirect($redirect_url);
    exit;
}

/**
 * Helper functions for member data
 */
function daystar_get_member_loan_history_count($user_id) {
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$loans_table} WHERE user_id = %d AND status IN ('completed', 'active', 'disbursed')",
        $user_id
    ));
}

function daystar_has_cleared_previous_loans($user_id) {
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $completed_loans = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$loans_table} WHERE user_id = %d AND status = 'completed'",
        $user_id
    ));
    
    return $completed_loans > 0;
}

function daystar_get_member_active_loans_count($user_id) {
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    return $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$loans_table} WHERE user_id = %d AND status = 'active'",
        $user_id
    ));
}

function daystar_get_member_credit_score($user_id) {
    // This would be calculated based on payment history, defaults, etc.
    // For now, return a sample score
    return rand(60, 95);
}

/**
 * AJAX handler for Credit Committee decisions
 */
function daystar_ajax_process_credit_committee_decision() {
    if (!wp_verify_nonce($_POST['nonce'], 'credit_committee_decision')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    $application_id = intval($_POST['application_id']);
    $decision = sanitize_text_field($_POST['decision']);
    $notes = sanitize_textarea_field($_POST['notes'] ?? '');
    $admin_user_id = get_current_user_id();
    
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $update_data = array();
    $new_status = '';
    
    switch ($decision) {
        case 'approve':
            $new_status = 'approved';
            $update_data = array(
                'status' => 'approved',
                'approved_by' => $admin_user_id,
                'approved_date' => current_time('mysql'),
                'application_notes' => $notes
            );
            break;
            
        case 'reject':
            $new_status = 'rejected';
            $update_data = array(
                'status' => 'rejected',
                'rejection_reason' => $notes,
                'approved_by' => $admin_user_id,
                'approved_date' => current_time('mysql')
            );
            break;
            
        case 'more_info':
            $new_status = 'under_review';
            $update_data = array(
                'status' => 'under_review',
                'application_notes' => 'Additional information requested: ' . $notes
            );
            break;
            
        default:
            wp_send_json_error('Invalid decision type');
            return;
    }
    
    $result = $wpdb->update(
        $loans_table,
        $update_data,
        array('id' => $application_id),
        array('%s', '%d', '%s', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        // Send notification to member
        daystar_send_loan_decision_notification($application_id, $decision, $notes);
        
        wp_send_json_success('Decision processed successfully');
    } else {
        wp_send_json_error('Failed to update loan status');
    }
}
add_action('wp_ajax_process_credit_committee_decision', 'daystar_ajax_process_credit_committee_decision');

/**
 * Send loan decision notification to member
 */
function daystar_send_loan_decision_notification($loan_id, $decision, $notes) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan) return;
    
    $title = '';
    $message = '';
    $type = 'loan';
    
    switch ($decision) {
        case 'approve':
            $title = 'Loan Application Approved';
            $message = "Congratulations! Your loan application for KES " . number_format($loan->amount, 2) . " has been approved. ";
            $message .= "The loan will be processed for disbursement shortly.";
            if ($notes) {
                $message .= " Notes: " . $notes;
            }
            break;
            
        case 'reject':
            $title = 'Loan Application Declined';
            $message = "We regret to inform you that your loan application for KES " . number_format($loan->amount, 2) . " has been declined. ";
            $message .= "Reason: " . $notes;
            $message .= " Please contact the SACCO office for more information on how to improve your application.";
            break;
            
        case 'more_info':
            $title = 'Additional Information Required';
            $message = "Your loan application is under review. We require additional information: " . $notes;
            $message .= " Please provide the requested information as soon as possible.";
            break;
    }
    
    // Insert notification
    $wpdb->insert(
        $notifications_table,
        array(
            'user_id' => $loan->user_id,
            'title' => $title,
            'message' => $message,
            'type' => $type
        )
    );
    
    // Here you would also integrate with SMS/Email gateway
    // daystar_send_sms_notification($loan->user_id, $message);
    // daystar_send_email_notification($loan->user_id, $title, $message);
}

/**
 * Add admin notices for pending loans
 */
function daystar_loan_admin_notices() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages
    if (!in_array($screen->id, ['dashboard', 'toplevel_page_daystar-loan-management', 'toplevel_page_daystar-credit-committee'])) {
        return;
    }
    
    $stats = daystar_get_credit_committee_stats();
    
    if ($stats['pending_review'] > 0) {
        $url = admin_url('admin.php?page=daystar-credit-committee');
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Credit Committee:</strong> ';
        echo sprintf(
            'You have <a href="%s">%d loan application%s</a> requiring review.',
            $url,
            $stats['pending_review'],
            $stats['pending_review'] === 1 ? '' : 's'
        );
        echo '</p>';
        echo '</div>';
    }
    
    if ($stats['high_priority'] > 0) {
        $url = admin_url('admin.php?page=daystar-credit-committee&priority=high');
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p><strong>Urgent:</strong> ';
        echo sprintf(
            'You have <a href="%s">%d high priority loan application%s</a> requiring immediate attention.',
            $url,
            $stats['high_priority'],
            $stats['high_priority'] === 1 ? '' : 's'
        );
        echo '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'daystar_loan_admin_notices');

// Include loan prioritization functions
require_once get_template_directory() . '/includes/loan-prioritization.php';

/**
 * Handle payment processing from admin interface
 */
function daystar_handle_payment_processing() {
    if (!wp_verify_nonce($_POST['payment_nonce'], 'process_payment')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $loan_identifier = sanitize_text_field($_POST['loan_id']);
    $amount = floatval($_POST['amount']);
    $payment_method = sanitize_text_field($_POST['payment_method']);
    $reference_number = sanitize_text_field($_POST['reference_number']);
    $notes = sanitize_textarea_field($_POST['notes']);
    
    // Find loan by ID or waiting number
    $loan = null;
    if (is_numeric($loan_identifier)) {
        $loan = daystar_get_loan_by_id($loan_identifier);
    } else {
        $loan = daystar_get_loan_by_waiting_number($loan_identifier);
    }
    
    if (!$loan) {
        $redirect_url = add_query_arg('error', urlencode('Loan not found.'), admin_url('admin.php?page=daystar-loan-repayments'));
        wp_redirect($redirect_url);
        exit;
    }
    
    // Process payment using the repayment system
    if (function_exists('daystar_process_loan_payment')) {
        $is_payroll = ($payment_method === 'payroll_deduction');
        $result = daystar_process_loan_payment($loan->id, $amount, $payment_method, $reference_number, $notes, $is_payroll);
        
        if ($result['success']) {
            $message = 'Payment of KES ' . number_format($amount, 2) . ' processed successfully.';
            if ($result['receipt_path']) {
                $message .= ' Receipt generated.';
            }
            $redirect_url = add_query_arg('message', urlencode($message), admin_url('admin.php?page=daystar-loan-repayments'));
        } else {
            $redirect_url = add_query_arg('error', urlencode($result['message']), admin_url('admin.php?page=daystar-loan-repayments'));
        }
    } else {
        $redirect_url = add_query_arg('error', urlencode('Repayment system not available.'), admin_url('admin.php?page=daystar-loan-repayments'));
    }
    
    wp_redirect($redirect_url);
    exit;
}

/**
 * Get active loans for repayment management
 */
function daystar_get_active_loans_for_repayment($status_filter = 'all', $search = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $where_conditions = array("status = 'active'");
    $where_values = array();
    
    if ($status_filter === 'willful_failure') {
        $where_conditions[] = "is_willful_failure = 1";
    } elseif ($status_filter === 'overdue') {
        // This would need to join with schedules table to check for overdue installments
        // For now, we'll handle this in the display logic
    }
    
    if ($search) {
        $where_conditions[] = "(application_waiting_number LIKE %s OR user_id IN (SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s))";
        $where_values[] = '%' . $search . '%';
        $where_values[] = '%' . $search . '%';
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "SELECT * FROM {$loans_table} WHERE {$where_clause} ORDER BY created_at DESC";
    
    if (!empty($where_values)) {
        $query = $wpdb->prepare($query, $where_values);
    }
    
    return $wpdb->get_results($query);
}

/**
 * AJAX handler for flagging willful failure
 */
function daystar_ajax_flag_willful_failure() {
    if (!wp_verify_nonce($_POST['nonce'], 'flag_willful_failure')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    $loan_id = intval($_POST['loan_id']);
    $reason = sanitize_textarea_field($_POST['reason']);
    
    $loan = daystar_get_loan_by_id($loan_id);
    if (!$loan) {
        wp_send_json_error('Loan not found');
        return;
    }
    
    if (function_exists('daystar_flag_willful_failure')) {
        $result = daystar_flag_willful_failure($loan_id, $loan->user_id, $reason);
        
        if ($result) {
            wp_send_json_success('Loan flagged for willful failure');
        } else {
            wp_send_json_error('Failed to flag loan');
        }
    } else {
        wp_send_json_error('Willful failure system not available');
    }
}
add_action('wp_ajax_flag_willful_failure', 'daystar_ajax_flag_willful_failure');

/**
 * AJAX handler for updating overdue status
 */
function daystar_ajax_update_overdue_status() {
    if (!wp_verify_nonce($_POST['nonce'], 'update_overdue_status')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized access');
        return;
    }
    
    if (function_exists('daystar_update_overdue_status')) {
        $result = daystar_update_overdue_status();
        
        if ($result) {
            wp_send_json_success('Overdue status updated successfully');
        } else {
            wp_send_json_error('Failed to update overdue status');
        }
    } else {
        wp_send_json_error('Overdue update system not available');
    }
}
add_action('wp_ajax_update_overdue_status', 'daystar_ajax_update_overdue_status');

// Include loan appeals admin functions
require_once get_template_directory() . '/includes/admin/admin-loan-appeals.php';