<?php
/**
 * Admin Loan Recovery Interface
 * 
 * Provides admin interface for managing loan recovery including:
 * - Deduction list generation for payroll
 * - Reconciliation reports and management
 * - Anomaly detection and resolution
 * - Recovery statistics and analytics
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/loan-recovery.php';

/**
 * Admin Loan Recovery Page
 */
function daystar_admin_loan_recovery_page() {
    global $wpdb;
    
    // Get current view
    $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'deduction_lists';
    
    ?>
    <div class="wrap">
        <h1>Loan Recovery Management</h1>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
        
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-admin-recovery&view=deduction_lists" 
               class="nav-tab <?php echo $view === 'deduction_lists' ? 'nav-tab-active' : ''; ?>">
                Deduction Lists
            </a>
            <a href="?page=daystar-admin-recovery&view=reconciliation" 
               class="nav-tab <?php echo $view === 'reconciliation' ? 'nav-tab-active' : ''; ?>">
                Reconciliation
            </a>
            <a href="?page=daystar-admin-recovery&view=anomalies" 
               class="nav-tab <?php echo $view === 'anomalies' ? 'nav-tab-active' : ''; ?>">
                Anomalies
            </a>
            <a href="?page=daystar-admin-recovery&view=statistics" 
               class="nav-tab <?php echo $view === 'statistics' ? 'nav-tab-active' : ''; ?>">
                Statistics
            </a>
        </nav>
        
        <div class="tab-content">
            <?php
            switch ($view) {
                case 'deduction_lists':
                    display_deduction_lists_tab();
                    break;
                case 'reconciliation':
                    display_reconciliation_tab();
                    break;
                case 'anomalies':
                    display_anomalies_tab();
                    break;
                case 'statistics':
                    display_statistics_tab();
                    break;
                default:
                    display_deduction_lists_tab();
            }
            ?>
        </div>
    </div>
    
    <style>
    .recovery-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .recovery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .recovery-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #2271b1;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
    }
    
    .anomaly-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
    }
    
    .anomaly-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .severity-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .severity-low { background: #d1ecf1; color: #0c5460; }
    .severity-medium { background: #fff3cd; color: #856404; }
    .severity-high { background: #f8d7da; color: #721c24; }
    .severity-critical { background: #f5c6cb; color: #491217; }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-open { background: #fff3cd; color: #856404; }
    .status-resolved { background: #d4edda; color: #155724; }
    .status-in-progress { background: #cce5ff; color: #004085; }
    
    .deduction-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .deduction-table th,
    .deduction-table td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .deduction-table th {
        background: #f8f9fa;
        font-weight: bold;
    }
    
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
    }
    
    .export-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Generate deduction list
        $('#generate-deduction-list').on('click', function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'generate_deduction_list',
                nonce: '<?php echo wp_create_nonce('loan_recovery_nonce'); ?>',
                period_start: $('#period_start').val(),
                period_end: $('#period_end').val(),
                employer: $('#employer_filter').val(),
                loan_type: $('#loan_type_filter').val(),
                department: $('#department_filter').val()
            };
            
            $('#deduction-results').html('<div class="loading-spinner"><span class="spinner is-active"></span> Generating deduction list...</div>');
            
            $.post(ajaxurl, formData, function(response) {
                if (response.success) {
                    displayDeductionResults(response);
                } else {
                    $('#deduction-results').html('<div class="notice notice-error"><p>' + response.message + '</p></div>');
                }
            });
        });
        
        // Run reconciliation
        $('#run-reconciliation').on('click', function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'run_reconciliation',
                nonce: '<?php echo wp_create_nonce('loan_recovery_nonce'); ?>',
                period_start: $('#recon_period_start').val(),
                period_end: $('#recon_period_end').val()
            };
            
            $('#reconciliation-results').html('<div class="loading-spinner"><span class="spinner is-active"></span> Running reconciliation...</div>');
            
            $.post(ajaxurl, formData, function(response) {
                if (response.success) {
                    displayReconciliationResults(response);
                } else {
                    $('#reconciliation-results').html('<div class="notice notice-error"><p>' + response.message + '</p></div>');
                }
            });
        });
        
        // Resolve anomaly
        $('.resolve-anomaly').on('click', function(e) {
            e.preventDefault();
            
            var anomalyId = $(this).data('anomaly-id');
            var notes = prompt('Enter resolution notes:');
            
            if (notes) {
                var formData = {
                    action: 'resolve_anomaly',
                    nonce: '<?php echo wp_create_nonce('loan_recovery_nonce'); ?>',
                    anomaly_id: anomalyId,
                    resolution_notes: notes
                };
                
                $.post(ajaxurl, formData, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to resolve anomaly: ' + response.message);
                    }
                });
            }
        });
        
        function displayDeductionResults(response) {
            var html = '<div class="recovery-card">';
            html += '<h3>Deduction List Generated</h3>';
            
            // Summary
            html += '<div class="summary-stats">';
            html += '<div class="stat-card"><div class="stat-value">' + response.summary.total_members + '</div><div class="stat-label">Total Members</div></div>';
            html += '<div class="stat-card"><div class="stat-value">' + response.summary.total_deductions + '</div><div class="stat-label">Total Deductions</div></div>';
            html += '<div class="stat-card"><div class="stat-value">KES ' + numberFormat(response.summary.total_amount) + '</div><div class="stat-label">Total Amount</div></div>';
            html += '</div>';
            
            // Table
            html += '<table class="deduction-table">';
            html += '<thead><tr>';
            html += '<th>Member</th><th>Employee #</th><th>Employer</th><th>Loan Type</th><th>Deduction Amount</th><th>Due Date</th><th>Status</th>';
            html += '</tr></thead><tbody>';
            
            response.deduction_list.forEach(function(item) {
                html += '<tr>';
                html += '<td>' + item.member_name + '<br><small>' + item.member_number + '</small></td>';
                html += '<td>' + (item.employee_number || 'N/A') + '</td>';
                html += '<td>' + (item.employer || 'N/A') + '</td>';
                html += '<td>' + item.loan_type + '</td>';
                html += '<td>KES ' + numberFormat(item.deduction_amount) + '</td>';
                html += '<td>' + item.due_date + '</td>';
                html += '<td><span class="status-badge status-' + item.payment_status.toLowerCase() + '">' + item.payment_status + '</span></td>';
                html += '</tr>';
            });
            
            html += '</tbody></table>';
            
            // Export actions
            html += '<div class="export-actions">';
            html += '<button class="button button-primary" onclick="exportDeductionList()">Export to CSV</button>';
            html += '</div>';
            
            html += '</div>';
            
            $('#deduction-results').html(html);
        }
        
        function displayReconciliationResults(response) {
            var html = '<div class="recovery-card">';
            html += '<h3>Reconciliation Report</h3>';
            
            // Summary
            html += '<div class="summary-stats">';
            html += '<div class="stat-card"><div class="stat-value">KES ' + numberFormat(response.summary.total_expected) + '</div><div class="stat-label">Expected</div></div>';
            html += '<div class="stat-card"><div class="stat-value">KES ' + numberFormat(response.summary.total_actual) + '</div><div class="stat-label">Actual</div></div>';
            html += '<div class="stat-card"><div class="stat-value">KES ' + numberFormat(Math.abs(response.summary.total_variance)) + '</div><div class="stat-label">Variance</div></div>';
            html += '<div class="stat-card"><div class="stat-value">' + response.summary.counts.MISSING + '</div><div class="stat-label">Missing Payments</div></div>';
            html += '</div>';
            
            // Table
            html += '<table class="deduction-table">';
            html += '<thead><tr>';
            html += '<th>Member</th><th>Loan Type</th><th>Expected</th><th>Actual</th><th>Variance</th><th>Status</th>';
            html += '</tr></thead><tbody>';
            
            response.reconciliation_data.forEach(function(item) {
                if (item.status !== 'MATCHED') {
                    html += '<tr>';
                    html += '<td>' + item.member_name + '<br><small>' + item.member_number + '</small></td>';
                    html += '<td>' + item.loan_type + '</td>';
                    html += '<td>KES ' + numberFormat(item.expected_amount) + '</td>';
                    html += '<td>KES ' + numberFormat(item.actual_amount) + '</td>';
                    html += '<td>KES ' + numberFormat(item.variance) + '</td>';
                    html += '<td><span class="status-badge status-' + item.status.toLowerCase() + '">' + item.status + '</span></td>';
                    html += '</tr>';
                }
            });
            
            html += '</tbody></table>';
            html += '</div>';
            
            $('#reconciliation-results').html(html);
        }
        
        function numberFormat(num) {
            return parseFloat(num).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    });
    
    function exportDeductionList() {
        // This would trigger the export functionality
        alert('Export functionality would be implemented here');
    }
    </script>
    <?php
}

/**
 * Display deduction lists tab
 */
function display_deduction_lists_tab() {
    $employers = get_available_employers();
    $departments = get_available_departments();
    
    ?>
    <div class="recovery-card">
        <div class="recovery-header">
            <h3>Generate Payroll Deduction List</h3>
        </div>
        
        <div class="recovery-form">
            <h4>Deduction Period</h4>
            <div class="form-row">
                <div>
                    <label for="period_start">Period Start Date</label>
                    <input type="date" id="period_start" class="regular-text" value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div>
                    <label for="period_end">Period End Date</label>
                    <input type="date" id="period_end" class="regular-text" value="<?php echo date('Y-m-t'); ?>">
                </div>
            </div>
            
            <h4>Filters (Optional)</h4>
            <div class="form-row">
                <div>
                    <label for="employer_filter">Employer</label>
                    <select id="employer_filter" class="regular-text">
                        <option value="">All Employers</option>
                        <?php foreach ($employers as $employer): ?>
                            <option value="<?php echo esc_attr($employer); ?>"><?php echo esc_html($employer); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="loan_type_filter">Loan Type</label>
                    <select id="loan_type_filter" class="regular-text">
                        <option value="">All Loan Types</option>
                        <option value="Development Loan">Development Loan</option>
                        <option value="Emergency Loan">Emergency Loan</option>
                        <option value="School Fees Loan">School Fees Loan</option>
                        <option value="Special Loan">Special Loan</option>
                    </select>
                </div>
                <div>
                    <label for="department_filter">Department</label>
                    <select id="department_filter" class="regular-text">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo esc_attr($department); ?>"><?php echo esc_html($department); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <button id="generate-deduction-list" class="button button-primary">Generate Deduction List</button>
        </div>
        
        <div id="deduction-results"></div>
    </div>
    
    <?php
    // Display recent deduction lists
    display_recent_deduction_lists();
}

/**
 * Display reconciliation tab
 */
function display_reconciliation_tab() {
    ?>
    <div class="recovery-card">
        <div class="recovery-header">
            <h3>Loan Recovery Reconciliation</h3>
        </div>
        
        <div class="recovery-form">
            <h4>Reconciliation Period</h4>
            <div class="form-row">
                <div>
                    <label for="recon_period_start">Period Start Date</label>
                    <input type="date" id="recon_period_start" class="regular-text" value="<?php echo date('Y-m-01', strtotime('last month')); ?>">
                </div>
                <div>
                    <label for="recon_period_end">Period End Date</label>
                    <input type="date" id="recon_period_end" class="regular-text" value="<?php echo date('Y-m-t', strtotime('last month')); ?>">
                </div>
            </div>
            
            <button id="run-reconciliation" class="button button-primary">Run Reconciliation</button>
        </div>
        
        <div id="reconciliation-results"></div>
    </div>
    
    <?php
    // Display recent reconciliation reports
    display_recent_reconciliation_reports();
}

/**
 * Display anomalies tab
 */
function display_anomalies_tab() {
    global $wpdb;
    
    $anomalies_table = $wpdb->prefix . 'daystar_loan_anomalies';
    
    // Get anomaly statistics
    $stats = $wpdb->get_row("
        SELECT 
            COUNT(*) as total_anomalies,
            COUNT(CASE WHEN status = 'open' THEN 1 END) as open_anomalies,
            COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_anomalies,
            COUNT(CASE WHEN severity = 'high' THEN 1 END) as high_anomalies
        FROM $anomalies_table
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    
    ?>
    <div class="recovery-card">
        <div class="recovery-header">
            <h3>Anomaly Management Dashboard</h3>
            <button class="button" onclick="location.reload()">Refresh</button>
        </div>
        
        <div class="summary-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats->total_anomalies; ?></div>
                <div class="stat-label">Total Anomalies (30 days)</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats->open_anomalies; ?></div>
                <div class="stat-label">Open Anomalies</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats->critical_anomalies; ?></div>
                <div class="stat-label">Critical</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats->high_anomalies; ?></div>
                <div class="stat-label">High Priority</div>
            </div>
        </div>
    </div>
    
    <?php
    // Display anomalies list
    display_anomalies_list();
}

/**
 * Display statistics tab
 */
function display_statistics_tab() {
    $current_month_stats = get_loan_recovery_statistics();
    $last_month_stats = get_loan_recovery_statistics(
        date('Y-m-01', strtotime('last month')),
        date('Y-m-t', strtotime('last month'))
    );
    
    ?>
    <div class="recovery-card">
        <div class="recovery-header">
            <h3>Loan Recovery Statistics</h3>
        </div>
        
        <h4>Current Month (<?php echo date('F Y'); ?>)</h4>
        <div class="summary-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo $current_month_stats->total_loans; ?></div>
                <div class="stat-label">Active Loans</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">KES <?php echo number_format($current_month_stats->total_expected, 2); ?></div>
                <div class="stat-label">Expected Recovery</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">KES <?php echo number_format($current_month_stats->total_collected, 2); ?></div>
                <div class="stat-label">Actual Recovery</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $current_month_stats->total_expected > 0 ? round(($current_month_stats->total_collected / $current_month_stats->total_expected) * 100, 1) : 0; ?>%</div>
                <div class="stat-label">Recovery Rate</div>
            </div>
        </div>
        
        <h4>Last Month (<?php echo date('F Y', strtotime('last month')); ?>)</h4>
        <div class="summary-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo $last_month_stats->total_loans; ?></div>
                <div class="stat-label">Active Loans</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">KES <?php echo number_format($last_month_stats->total_expected, 2); ?></div>
                <div class="stat-label">Expected Recovery</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">KES <?php echo number_format($last_month_stats->total_collected, 2); ?></div>
                <div class="stat-label">Actual Recovery</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo $last_month_stats->total_expected > 0 ? round(($last_month_stats->total_collected / $last_month_stats->total_expected) * 100, 1) : 0; ?>%</div>
                <div class="stat-label">Recovery Rate</div>
            </div>
        </div>
    </div>
    
    <?php
    // Display additional charts and analytics
    display_recovery_analytics();
}

/**
 * Display recent deduction lists
 */
function display_recent_deduction_lists() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_deduction_lists';
    
    $recent_lists = $wpdb->get_results("
        SELECT dl.*, u.display_name as generated_by_name
        FROM $table_name dl
        LEFT JOIN {$wpdb->users} u ON dl.generated_by = u.ID
        ORDER BY dl.generated_at DESC
        LIMIT 10
    ");
    
    if (empty($recent_lists)) {
        echo '<div class="recovery-card"><p>No deduction lists generated yet.</p></div>';
        return;
    }
    
    ?>
    <div class="recovery-card">
        <h3>Recent Deduction Lists</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>List ID</th>
                    <th>Period</th>
                    <th>Generated By</th>
                    <th>Generated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_lists as $list): ?>
                <tr>
                    <td><?php echo esc_html($list->list_id); ?></td>
                    <td><?php echo date('M j', strtotime($list->period_start)) . ' - ' . date('M j, Y', strtotime($list->period_end)); ?></td>
                    <td><?php echo esc_html($list->generated_by_name); ?></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($list->generated_at)); ?></td>
                    <td>
                        <a href="?page=daystar-admin-recovery&action=export&list_id=<?php echo esc_attr($list->list_id); ?>&nonce=<?php echo wp_create_nonce('loan_recovery_nonce'); ?>" 
                           class="button button-small">Export CSV</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Display recent reconciliation reports
 */
function display_recent_reconciliation_reports() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_reconciliation_reports';
    
    $recent_reports = $wpdb->get_results("
        SELECT rr.*, u.display_name as generated_by_name
        FROM $table_name rr
        LEFT JOIN {$wpdb->users} u ON rr.generated_by = u.ID
        ORDER BY rr.generated_at DESC
        LIMIT 10
    ");
    
    if (empty($recent_reports)) {
        echo '<div class="recovery-card"><p>No reconciliation reports generated yet.</p></div>';
        return;
    }
    
    ?>
    <div class="recovery-card">
        <h3>Recent Reconciliation Reports</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Period</th>
                    <th>Generated By</th>
                    <th>Generated At</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_reports as $report): 
                    $summary = json_decode($report->summary_data, true);
                ?>
                <tr>
                    <td><?php echo esc_html($report->report_id); ?></td>
                    <td><?php echo date('M j', strtotime($report->period_start)) . ' - ' . date('M j, Y', strtotime($report->period_end)); ?></td>
                    <td><?php echo esc_html($report->generated_by_name); ?></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($report->generated_at)); ?></td>
                    <td>
                        Expected: KES <?php echo number_format($summary['total_expected'], 2); ?><br>
                        Actual: KES <?php echo number_format($summary['total_actual'], 2); ?><br>
                        <small><?php echo $summary['counts']['MISSING']; ?> missing, <?php echo $summary['counts']['UNDERPAID']; ?> underpaid</small>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Display anomalies list
 */
function display_anomalies_list() {
    global $wpdb;
    
    $anomalies_table = $wpdb->prefix . 'daystar_loan_anomalies';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $users_table = $wpdb->users;
    
    $anomalies = $wpdb->get_results("
        SELECT a.*, u.display_name, l.loan_type,
               um.meta_value as member_number
        FROM $anomalies_table a
        INNER JOIN $users_table u ON a.user_id = u.ID
        LEFT JOIN $loans_table l ON a.loan_id = l.id
        LEFT JOIN {$wpdb->usermeta} um ON (u.ID = um.user_id AND um.meta_key = 'member_number')
        WHERE a.status = 'open'
        ORDER BY 
            CASE a.severity 
                WHEN 'critical' THEN 1 
                WHEN 'high' THEN 2 
                WHEN 'medium' THEN 3 
                ELSE 4 
            END,
            a.created_at DESC
        LIMIT 50
    ");
    
    if (empty($anomalies)) {
        echo '<div class="recovery-card"><p>No open anomalies found.</p></div>';
        return;
    }
    
    ?>
    <div class="recovery-card">
        <h3>Open Anomalies</h3>
        
        <?php foreach ($anomalies as $anomaly): ?>
        <div class="anomaly-item">
            <div class="anomaly-header">
                <div>
                    <strong><?php echo esc_html($anomaly->description); ?></strong>
                    <span class="severity-badge severity-<?php echo esc_attr($anomaly->severity); ?>">
                        <?php echo esc_html(strtoupper($anomaly->severity)); ?>
                    </span>
                </div>
                <div>
                    <button class="button button-small resolve-anomaly" data-anomaly-id="<?php echo $anomaly->id; ?>">
                        Resolve
                    </button>
                </div>
            </div>
            
            <div class="anomaly-details">
                <p><strong>Member:</strong> <?php echo esc_html($anomaly->display_name); ?> (<?php echo esc_html($anomaly->member_number); ?>)</p>
                <?php if ($anomaly->loan_type): ?>
                    <p><strong>Loan Type:</strong> <?php echo esc_html($anomaly->loan_type); ?></p>
                <?php endif; ?>
                <p><strong>Details:</strong> <?php echo esc_html($anomaly->details); ?></p>
                <p><strong>Suggested Action:</strong> <?php echo esc_html($anomaly->suggested_action); ?></p>
                <p><strong>Detected:</strong> <?php echo date('M j, Y g:i A', strtotime($anomaly->created_at)); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Display recovery analytics
 */
function display_recovery_analytics() {
    global $wpdb;
    
    // Get monthly recovery trends for the last 6 months
    $monthly_trends = array();
    for ($i = 5; $i >= 0; $i--) {
        $month_start = date('Y-m-01', strtotime("-$i months"));
        $month_end = date('Y-m-t', strtotime("-$i months"));
        $stats = get_loan_recovery_statistics($month_start, $month_end);
        
        $monthly_trends[] = array(
            'month' => date('M Y', strtotime($month_start)),
            'expected' => $stats->total_expected,
            'collected' => $stats->total_collected,
            'rate' => $stats->total_expected > 0 ? ($stats->total_collected / $stats->total_expected) * 100 : 0
        );
    }
    
    ?>
    <div class="recovery-card">
        <h3>Recovery Trends (Last 6 Months)</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Expected</th>
                    <th>Collected</th>
                    <th>Recovery Rate</th>
                    <th>Variance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_trends as $trend): ?>
                <tr>
                    <td><?php echo esc_html($trend['month']); ?></td>
                    <td>KES <?php echo number_format($trend['expected'], 2); ?></td>
                    <td>KES <?php echo number_format($trend['collected'], 2); ?></td>
                    <td><?php echo round($trend['rate'], 1); ?>%</td>
                    <td>KES <?php echo number_format($trend['expected'] - $trend['collected'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}