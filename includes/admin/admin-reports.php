<?php
/**
 * Admin Reports Interface
 * Comprehensive reporting dashboard for Daystar SACCO
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include the reporting class
require_once get_template_directory() . '/includes/reporting.php';

/**
 * Enqueue admin reports scripts and styles
 */
function daystar_enqueue_admin_reports_scripts($hook) {
    // Only load on our reports pages
    if (strpos($hook, 'daystar-reports') === false && 
        strpos($hook, 'daystar-loan-reports') === false && 
        strpos($hook, 'daystar-member-reports') === false && 
        strpos($hook, 'daystar-financial-reports') === false) {
        return;
    }
    
    // Chart.js
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js', array(), '3.9.1', true);
    
    // DataTables for better table functionality
    wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', array('jquery'), '1.13.1', true);
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css', array(), '1.13.1');
    
    // Admin reports script
    wp_enqueue_script('daystar-admin-reports', get_template_directory_uri() . '/assets/js/admin-reports.js', array('jquery', 'chart-js'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'daystar_enqueue_admin_reports_scripts');

/**
 * Add reports menu to admin
 */
function daystar_add_reports_menu() {
    add_menu_page(
        'SACCO Reports',
        'Reports',
        'manage_options',
        'daystar-reports',
        'daystar_reports_dashboard',
        'dashicons-chart-bar',
        30
    );
    
    // Add submenus for different report types
    add_submenu_page(
        'daystar-reports',
        'Loan Reports',
        'Loan Reports',
        'manage_options',
        'daystar-loan-reports',
        'daystar_loan_reports_page'
    );
    
    add_submenu_page(
        'daystar-reports',
        'Member Reports',
        'Member Reports',
        'manage_options',
        'daystar-member-reports',
        'daystar_member_reports_page'
    );
    
    add_submenu_page(
        'daystar-reports',
        'Financial Reports',
        'Financial Reports',
        'manage_options',
        'daystar-financial-reports',
        'daystar_financial_reports_page'
    );
}
add_action('admin_menu', 'daystar_add_reports_menu');

/**
 * Main reports dashboard
 */
function daystar_reports_dashboard() {
    // Handle export requests
    if (isset($_POST['export_report']) && wp_verify_nonce($_POST['_wpnonce'], 'daystar_export_report')) {
        daystar_handle_report_export();
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>SACCO Reports Dashboard</h1>
        
        <div class="daystar-reports-grid">
            <!-- Quick Stats Cards -->
            <div class="reports-stats-row">
                <?php daystar_render_quick_stats(); ?>
            </div>
            
            <!-- Available Reports -->
            <div class="reports-categories">
                <h2>Available Reports</h2>
                
                <div class="report-category">
                    <h3>Loan Reports</h3>
                    <div class="report-links">
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-reports&report=application_status'); ?>" class="button">
                            Loan Application Status
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-reports&report=disbursements'); ?>" class="button">
                            Loan Disbursements
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-reports&report=repayments'); ?>" class="button">
                            Loan Repayments
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=daystar-loan-reports&report=delinquency'); ?>" class="button">
                            Delinquency Report
                        </a>
                    </div>
                </div>
                
                <div class="report-category">
                    <h3>Member Reports</h3>
                    <div class="report-links">
                        <a href="<?php echo admin_url('admin.php?page=daystar-member-reports&report=loan_history'); ?>" class="button">
                            Member Loan History
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=daystar-member-reports&report=contributions'); ?>" class="button">
                            Member Contributions
                        </a>
                    </div>
                </div>
                
                <div class="report-category">
                    <h3>Financial Reports</h3>
                    <div class="report-links">
                        <a href="<?php echo admin_url('admin.php?page=daystar-financial-reports&report=summary'); ?>" class="button">
                            Financial Summary
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .daystar-reports-grid {
        max-width: 1200px;
    }
    
    .reports-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 14px;
        text-transform: uppercase;
    }
    
    .stat-card .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #0073aa;
        margin-bottom: 5px;
    }
    
    .stat-card .stat-label {
        font-size: 12px;
        color: #666;
    }
    
    .report-category {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .report-category h3 {
        margin-top: 0;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .report-links {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
    
    .report-links .button {
        margin: 0;
    }
    </style>
    <?php
}

/**
 * Render quick statistics cards
 */
function daystar_render_quick_stats() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    // Get quick stats
    $total_loans = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table}");
    $active_loans = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'active'");
    $total_disbursed = $wpdb->get_var("SELECT SUM(amount) FROM {$loans_table} WHERE status IN ('active', 'completed')") ?: 0;
    $total_outstanding = $wpdb->get_var("SELECT SUM(balance) FROM {$loans_table} WHERE status = 'active'") ?: 0;
    $delinquent_loans = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE status = 'active' AND delinquency_status != 'current'");
    $total_contributions = $wpdb->get_var("SELECT SUM(amount) FROM {$contributions_table}") ?: 0;
    
    $stats = array(
        array(
            'title' => 'Total Loans',
            'value' => number_format($total_loans),
            'label' => 'All time'
        ),
        array(
            'title' => 'Active Loans',
            'value' => number_format($active_loans),
            'label' => 'Currently active'
        ),
        array(
            'title' => 'Total Disbursed',
            'value' => 'KES ' . number_format($total_disbursed, 2),
            'label' => 'All time'
        ),
        array(
            'title' => 'Outstanding Balance',
            'value' => 'KES ' . number_format($total_outstanding, 2),
            'label' => 'Current'
        ),
        array(
            'title' => 'Delinquent Loans',
            'value' => number_format($delinquent_loans),
            'label' => 'Overdue'
        ),
        array(
            'title' => 'Total Contributions',
            'value' => 'KES ' . number_format($total_contributions, 2),
            'label' => 'All time'
        )
    );
    
    foreach ($stats as $stat) {
        ?>
        <div class="stat-card">
            <h3><?php echo esc_html($stat['title']); ?></h3>
            <div class="stat-value"><?php echo esc_html($stat['value']); ?></div>
            <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
        </div>
        <?php
    }
}

/**
 * Loan reports page
 */
function daystar_loan_reports_page() {
    $report_type = isset($_GET['report']) ? sanitize_text_field($_GET['report']) : 'application_status';
    
    // Handle export requests
    if (isset($_POST['export_report']) && wp_verify_nonce($_POST['_wpnonce'], 'daystar_export_report')) {
        daystar_handle_report_export();
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>Loan Reports</h1>
        
        <!-- Report Type Tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-loan-reports&report=application_status" 
               class="nav-tab <?php echo $report_type === 'application_status' ? 'nav-tab-active' : ''; ?>">
                Application Status
            </a>
            <a href="?page=daystar-loan-reports&report=disbursements" 
               class="nav-tab <?php echo $report_type === 'disbursements' ? 'nav-tab-active' : ''; ?>">
                Disbursements
            </a>
            <a href="?page=daystar-loan-reports&report=repayments" 
               class="nav-tab <?php echo $report_type === 'repayments' ? 'nav-tab-active' : ''; ?>">
                Repayments
            </a>
            <a href="?page=daystar-loan-reports&report=delinquency" 
               class="nav-tab <?php echo $report_type === 'delinquency' ? 'nav-tab-active' : ''; ?>">
                Delinquency
            </a>
        </nav>
        
        <?php
        switch ($report_type) {
            case 'application_status':
                daystar_render_application_status_report();
                break;
            case 'disbursements':
                daystar_render_disbursements_report();
                break;
            case 'repayments':
                daystar_render_repayments_report();
                break;
            case 'delinquency':
                daystar_render_delinquency_report();
                break;
            default:
                daystar_render_application_status_report();
        }
        ?>
    </div>
    <?php
}

/**
 * Member reports page
 */
function daystar_member_reports_page() {
    $report_type = isset($_GET['report']) ? sanitize_text_field($_GET['report']) : 'loan_history';
    
    // Handle export requests
    if (isset($_POST['export_report']) && wp_verify_nonce($_POST['_wpnonce'], 'daystar_export_report')) {
        daystar_handle_report_export();
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>Member Reports</h1>
        
        <!-- Report Type Tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-member-reports&report=loan_history" 
               class="nav-tab <?php echo $report_type === 'loan_history' ? 'nav-tab-active' : ''; ?>">
                Loan History
            </a>
            <a href="?page=daystar-member-reports&report=contributions" 
               class="nav-tab <?php echo $report_type === 'contributions' ? 'nav-tab-active' : ''; ?>">
                Contributions
            </a>
        </nav>
        
        <?php
        switch ($report_type) {
            case 'loan_history':
                daystar_render_member_loan_history_report();
                break;
            case 'contributions':
                daystar_render_member_contributions_report();
                break;
            default:
                daystar_render_member_loan_history_report();
        }
        ?>
    </div>
    <?php
}

/**
 * Financial reports page
 */
function daystar_financial_reports_page() {
    $report_type = isset($_GET['report']) ? sanitize_text_field($_GET['report']) : 'summary';
    
    // Handle export requests
    if (isset($_POST['export_report']) && wp_verify_nonce($_POST['_wpnonce'], 'daystar_export_report')) {
        daystar_handle_report_export();
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>Financial Reports</h1>
        
        <?php
        switch ($report_type) {
            case 'summary':
                daystar_render_financial_summary_report();
                break;
            default:
                daystar_render_financial_summary_report();
        }
        ?>
    </div>
    <?php
}

/**
 * Render application status report
 */
function daystar_render_application_status_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $filters['date_from'] = sanitize_text_field($_GET['date_from']);
    }
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $filters['date_to'] = sanitize_text_field($_GET['date_to']);
    }
    if (isset($_GET['status']) && !empty($_GET['status'])) {
        $filters['status'] = sanitize_text_field($_GET['status']);
    }
    if (isset($_GET['loan_type']) && !empty($_GET['loan_type'])) {
        $filters['loan_type'] = sanitize_text_field($_GET['loan_type']);
    }
    
    $report_data = DaystarReporting::get_loan_application_status_report($filters);
    $loan_types = DaystarReporting::get_loan_types();
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-loan-reports">
            <input type="hidden" name="report" value="application_status">
            
            <div class="filter-row">
                <label>Date From:</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($filters['date_from'] ?? ''); ?>">
                
                <label>Date To:</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($filters['date_to'] ?? ''); ?>">
                
                <label>Status:</label>
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php selected($filters['status'] ?? '', 'pending'); ?>>Pending</option>
                    <option value="approved" <?php selected($filters['status'] ?? '', 'approved'); ?>>Approved</option>
                    <option value="declined" <?php selected($filters['status'] ?? '', 'declined'); ?>>Declined</option>
                    <option value="active" <?php selected($filters['status'] ?? '', 'active'); ?>>Active</option>
                    <option value="completed" <?php selected($filters['status'] ?? '', 'completed'); ?>>Completed</option>
                </select>
                
                <label>Loan Type:</label>
                <select name="loan_type">
                    <option value="">All Types</option>
                    <?php foreach ($loan_types as $type): ?>
                        <option value="<?php echo esc_attr($type); ?>" <?php selected($filters['loan_type'] ?? '', $type); ?>>
                            <?php echo esc_html($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Total Applications</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_applications']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Pending</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['pending']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Approved</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['approved']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Declined</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['declined']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Avg Processing Days</h4>
                <span class="summary-value"><?php echo $report_data['summary']['avg_processing_days']; ?></span>
            </div>
            <div class="summary-card">
                <h4>Total Amount Applied</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount_applied'], 2); ?></span>
            </div>
        </div>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="application_status">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Data Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Application Date</th>
                    <th>Processing Days</th>
                    <th>Waiting Number</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report_data['data'])): ?>
                    <?php foreach ($report_data['data'] as $loan): ?>
                        <tr>
                            <td>
                                <?php echo esc_html($loan['display_name']); ?>
                                <br><small><?php echo esc_html($loan['member_number']); ?></small>
                            </td>
                            <td><?php echo esc_html($loan['loan_type']); ?></td>
                            <td>KES <?php echo number_format($loan['amount'], 2); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($loan['status']); ?>">
                                    <?php echo esc_html(ucfirst($loan['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($loan['loan_date'])); ?></td>
                            <td><?php echo $loan['processing_days']; ?> days</td>
                            <td><?php echo esc_html($loan['application_waiting_number']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No data found for the selected criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render disbursements report
 */
function daystar_render_disbursements_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $filters['date_from'] = sanitize_text_field($_GET['date_from']);
    }
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $filters['date_to'] = sanitize_text_field($_GET['date_to']);
    }
    if (isset($_GET['loan_type']) && !empty($_GET['loan_type'])) {
        $filters['loan_type'] = sanitize_text_field($_GET['loan_type']);
    }
    
    $report_data = DaystarReporting::get_loan_disbursement_report($filters);
    $loan_types = DaystarReporting::get_loan_types();
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-loan-reports">
            <input type="hidden" name="report" value="disbursements">
            
            <div class="filter-row">
                <label>Date From:</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($filters['date_from'] ?? ''); ?>">
                
                <label>Date To:</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($filters['date_to'] ?? ''); ?>">
                
                <label>Loan Type:</label>
                <select name="loan_type">
                    <option value="">All Types</option>
                    <?php foreach ($loan_types as $type): ?>
                        <option value="<?php echo esc_attr($type); ?>" <?php selected($filters['loan_type'] ?? '', $type); ?>>
                            <?php echo esc_html($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Total Disbursements</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_disbursements']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Total Amount</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount_disbursed'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Confirmed</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['confirmed_disbursements']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Pending Confirmation</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['pending_confirmation']); ?></span>
            </div>
        </div>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="disbursements">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Data Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Disbursement Date</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report_data['data'])): ?>
                    <?php foreach ($report_data['data'] as $disbursement): ?>
                        <tr>
                            <td>
                                <?php echo esc_html($disbursement['display_name']); ?>
                                <br><small><?php echo esc_html($disbursement['member_number']); ?></small>
                            </td>
                            <td><?php echo esc_html($disbursement['loan_type']); ?></td>
                            <td>KES <?php echo number_format($disbursement['amount'], 2); ?></td>
                            <td><?php echo date('M j, Y', strtotime($disbursement['disbursed_date'])); ?></td>
                            <td><?php echo esc_html($disbursement['disbursement_method'] ?: 'N/A'); ?></td>
                            <td><?php echo esc_html($disbursement['disbursement_reference'] ?: 'N/A'); ?></td>
                            <td>
                                <?php if ($disbursement['recipient_confirmation']): ?>
                                    <span class="status-badge status-confirmed">Confirmed</span>
                                <?php else: ?>
                                    <span class="status-badge status-pending">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No data found for the selected criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render repayments report
 */
function daystar_render_repayments_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $filters['date_from'] = sanitize_text_field($_GET['date_from']);
    }
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $filters['date_to'] = sanitize_text_field($_GET['date_to']);
    }
    if (isset($_GET['loan_type']) && !empty($_GET['loan_type'])) {
        $filters['loan_type'] = sanitize_text_field($_GET['loan_type']);
    }
    
    $report_data = DaystarReporting::get_loan_repayment_report($filters);
    $loan_types = DaystarReporting::get_loan_types();
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-loan-reports">
            <input type="hidden" name="report" value="repayments">
            
            <div class="filter-row">
                <label>Date From:</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($filters['date_from'] ?? ''); ?>">
                
                <label>Date To:</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($filters['date_to'] ?? ''); ?>">
                
                <label>Loan Type:</label>
                <select name="loan_type">
                    <option value="">All Types</option>
                    <?php foreach ($loan_types as $type): ?>
                        <option value="<?php echo esc_attr($type); ?>" <?php selected($filters['loan_type'] ?? '', $type); ?>>
                            <?php echo esc_html($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Total Payments</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_payments']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Amount Collected</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount_paid'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Expected Amount</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['expected_total'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Collection Rate</h4>
                <span class="summary-value"><?php echo $report_data['summary']['collection_rate']; ?>%</span>
            </div>
        </div>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="repayments">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Data Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Payment Amount</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Payment Date</th>
                    <th>Method</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report_data['data'])): ?>
                    <?php foreach ($report_data['data'] as $payment): ?>
                        <tr>
                            <td>
                                <?php echo esc_html($payment['display_name']); ?>
                                <br><small><?php echo esc_html($payment['member_number']); ?></small>
                            </td>
                            <td><?php echo esc_html($payment['loan_type']); ?></td>
                            <td>KES <?php echo number_format($payment['payment_amount'], 2); ?></td>
                            <td>KES <?php echo number_format($payment['principal_amount'], 2); ?></td>
                            <td>KES <?php echo number_format($payment['interest_amount'], 2); ?></td>
                            <td><?php echo date('M j, Y', strtotime($payment['payment_date'])); ?></td>
                            <td><?php echo esc_html($payment['payment_method']); ?></td>
                            <td>
                                <?php if ($payment['is_payroll_deduction']): ?>
                                    <span class="status-badge status-payroll">Payroll</span>
                                <?php else: ?>
                                    <span class="status-badge status-manual">Manual</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No data found for the selected criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render delinquency report
 */
function daystar_render_delinquency_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['delinquency_status']) && !empty($_GET['delinquency_status'])) {
        $filters['delinquency_status'] = sanitize_text_field($_GET['delinquency_status']);
    }
    if (isset($_GET['min_days_overdue']) && !empty($_GET['min_days_overdue'])) {
        $filters['min_days_overdue'] = intval($_GET['min_days_overdue']);
    }
    if (isset($_GET['loan_type']) && !empty($_GET['loan_type'])) {
        $filters['loan_type'] = sanitize_text_field($_GET['loan_type']);
    }
    
    $report_data = DaystarReporting::get_loan_delinquency_report($filters);
    $loan_types = DaystarReporting::get_loan_types();
    $delinquency_statuses = DaystarReporting::get_delinquency_statuses();
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-loan-reports">
            <input type="hidden" name="report" value="delinquency">
            
            <div class="filter-row">
                <label>Delinquency Status:</label>
                <select name="delinquency_status">
                    <option value="">All Statuses</option>
                    <?php foreach ($delinquency_statuses as $key => $label): ?>
                        <?php if ($key !== 'current'): ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php selected($filters['delinquency_status'] ?? '', $key); ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                
                <label>Min Days Overdue:</label>
                <input type="number" name="min_days_overdue" value="<?php echo esc_attr($filters['min_days_overdue'] ?? ''); ?>" min="1">
                
                <label>Loan Type:</label>
                <select name="loan_type">
                    <option value="">All Types</option>
                    <?php foreach ($loan_types as $type): ?>
                        <option value="<?php echo esc_attr($type); ?>" <?php selected($filters['loan_type'] ?? '', $type); ?>>
                            <?php echo esc_html($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Delinquent Loans</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_delinquent_loans']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Overdue Amount</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_overdue_amount'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Outstanding Balance</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_outstanding_balance'], 2); ?></span>
            </div>
        </div>
        
        <!-- Category Breakdown -->
        <div class="delinquency-breakdown">
            <div style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="flex: 1;">
                    <h3>Delinquency by Category</h3>
                    <table class="wp-list-table widefat">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Count</th>
                                <th>Overdue Amount</th>
                                <th>Outstanding Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($report_data['summary']['by_category'] as $category => $data): ?>
                                <tr>
                                    <td><?php echo esc_html($category); ?></td>
                                    <td><?php echo number_format($data['count']); ?></td>
                                    <td>KES <?php echo number_format($data['amount'], 2); ?></td>
                                    <td>KES <?php echo number_format($data['balance'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div style="flex: 0 0 400px;">
                    <div class="report-chart-section">
                        <h4>Delinquency Distribution</h4>
                        <div class="chart-container">
                            <canvas id="delinquencyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        window.delinquencyData = <?php echo json_encode($report_data['summary']['by_category']); ?>;
        </script>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="delinquency">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Data Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Outstanding Balance</th>
                    <th>Overdue Amount</th>
                    <th>Days Overdue</th>
                    <th>Status</th>
                    <th>Last Check</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report_data['data'])): ?>
                    <?php foreach ($report_data['data'] as $loan): ?>
                        <tr>
                            <td>
                                <?php echo esc_html($loan['display_name']); ?>
                                <br><small><?php echo esc_html($loan['member_number']); ?></small>
                            </td>
                            <td><?php echo esc_html($loan['loan_type']); ?></td>
                            <td>KES <?php echo number_format($loan['outstanding_balance'], 2); ?></td>
                            <td>KES <?php echo number_format($loan['overdue_amount'] ?: 0, 2); ?></td>
                            <td><?php echo $loan['days_overdue']; ?> days</td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($loan['delinquency_status']); ?>">
                                    <?php echo esc_html(ucfirst(str_replace('-', ' ', $loan['delinquency_status']))); ?>
                                </span>
                            </td>
                            <td><?php echo $loan['last_delinquency_check'] ? date('M j, Y', strtotime($loan['last_delinquency_check'])) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No delinquent loans found for the selected criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render member loan history report
 */
function daystar_render_member_loan_history_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['member_number']) && !empty($_GET['member_number'])) {
        $filters['member_number'] = sanitize_text_field($_GET['member_number']);
    }
    if (isset($_GET['loan_type']) && !empty($_GET['loan_type'])) {
        $filters['loan_type'] = sanitize_text_field($_GET['loan_type']);
    }
    
    $report_data = DaystarReporting::get_member_loan_history_report($filters);
    $loan_types = DaystarReporting::get_loan_types();
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-member-reports">
            <input type="hidden" name="report" value="loan_history">
            
            <div class="filter-row">
                <label>Member Number:</label>
                <input type="text" name="member_number" value="<?php echo esc_attr($filters['member_number'] ?? ''); ?>" placeholder="Enter member number">
                
                <label>Loan Type:</label>
                <select name="loan_type">
                    <option value="">All Types</option>
                    <?php foreach ($loan_types as $type): ?>
                        <option value="<?php echo esc_attr($type); ?>" <?php selected($filters['loan_type'] ?? '', $type); ?>>
                            <?php echo esc_html($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Total Members</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_members']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Total Loans</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_loans']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Amount Borrowed</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount_borrowed'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Amount Paid</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount_paid'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Outstanding</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_outstanding'], 2); ?></span>
            </div>
        </div>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="member_loan_history">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Member Data -->
        <?php if (!empty($report_data['data'])): ?>
            <?php foreach ($report_data['data'] as $member_data): ?>
                <div class="member-section">
                    <h3>
                        <?php echo esc_html($member_data['member_info']['display_name']); ?>
                        <small>(<?php echo esc_html($member_data['member_info']['member_number']); ?>)</small>
                    </h3>
                    
                    <div class="member-summary">
                        <span>Total Loans: <?php echo $member_data['summary']['total_loans']; ?></span>
                        <span>Total Borrowed: KES <?php echo number_format($member_data['summary']['total_borrowed'], 2); ?></span>
                        <span>Total Paid: KES <?php echo number_format($member_data['summary']['total_paid'], 2); ?></span>
                        <span>Current Balance: KES <?php echo number_format($member_data['summary']['current_balance'], 2); ?></span>
                        <span>Active Loans: <?php echo $member_data['summary']['active_loans']; ?></span>
                    </div>
                    
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>Loan Type</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Application Date</th>
                                <th>Total Paid</th>
                                <th>Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($member_data['loans'] as $loan): ?>
                                <tr>
                                    <td><?php echo esc_html($loan['loan_type']); ?></td>
                                    <td>KES <?php echo number_format($loan['amount'], 2); ?></td>
                                    <td>KES <?php echo number_format($loan['balance'], 2); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo esc_attr($loan['status']); ?>">
                                            <?php echo esc_html(ucfirst($loan['status'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($loan['loan_date'])); ?></td>
                                    <td>KES <?php echo number_format($loan['total_paid'] ?: 0, 2); ?></td>
                                    <td><?php echo $loan['payment_count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No loan history found for the selected criteria.</p>
        <?php endif; ?>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render member contributions report
 */
function daystar_render_member_contributions_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $filters['date_from'] = sanitize_text_field($_GET['date_from']);
    }
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $filters['date_to'] = sanitize_text_field($_GET['date_to']);
    }
    if (isset($_GET['contribution_type']) && !empty($_GET['contribution_type'])) {
        $filters['contribution_type'] = sanitize_text_field($_GET['contribution_type']);
    }
    if (isset($_GET['is_share_capital'])) {
        $filters['is_share_capital'] = intval($_GET['is_share_capital']);
    }
    
    $report_data = DaystarReporting::get_member_contribution_report($filters);
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-member-reports">
            <input type="hidden" name="report" value="contributions">
            
            <div class="filter-row">
                <label>Date From:</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($filters['date_from'] ?? ''); ?>">
                
                <label>Date To:</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($filters['date_to'] ?? ''); ?>">
                
                <label>Contribution Type:</label>
                <select name="contribution_type">
                    <option value="">All Types</option>
                    <option value="monthly" <?php selected($filters['contribution_type'] ?? '', 'monthly'); ?>>Monthly</option>
                    <option value="share_capital" <?php selected($filters['contribution_type'] ?? '', 'share_capital'); ?>>Share Capital</option>
                    <option value="special" <?php selected($filters['contribution_type'] ?? '', 'special'); ?>>Special</option>
                </select>
                
                <label>Share Capital:</label>
                <select name="is_share_capital">
                    <option value="">All</option>
                    <option value="1" <?php selected($filters['is_share_capital'] ?? '', 1); ?>>Share Capital Only</option>
                    <option value="0" <?php selected($filters['is_share_capital'] ?? '', 0); ?>>Savings Only</option>
                </select>
                
                <button type="submit" class="button button-primary">Filter</button>
            </div>
        </form>
        
        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="summary-card">
                <h4>Total Contributions</h4>
                <span class="summary-value"><?php echo number_format($report_data['summary']['total_contributions']); ?></span>
            </div>
            <div class="summary-card">
                <h4>Total Amount</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['total_amount'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Share Capital</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['share_capital_total'], 2); ?></span>
            </div>
            <div class="summary-card">
                <h4>Savings</h4>
                <span class="summary-value">KES <?php echo number_format($report_data['summary']['savings_total'], 2); ?></span>
            </div>
        </div>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="member_contributions">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
        
        <!-- Data Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Reference</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report_data['data'])): ?>
                    <?php foreach ($report_data['data'] as $contribution): ?>
                        <tr>
                            <td>
                                <?php echo esc_html($contribution['display_name']); ?>
                                <br><small><?php echo esc_html($contribution['member_number']); ?></small>
                            </td>
                            <td>KES <?php echo number_format($contribution['amount'], 2); ?></td>
                            <td><?php echo esc_html($contribution['contribution_type']); ?></td>
                            <td>
                                <?php if ($contribution['is_share_capital']): ?>
                                    <span class="status-badge status-share-capital">Share Capital</span>
                                <?php else: ?>
                                    <span class="status-badge status-savings">Savings</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($contribution['contribution_date'])); ?></td>
                            <td><?php echo esc_html($contribution['payment_method']); ?></td>
                            <td><?php echo esc_html($contribution['reference_number']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($contribution['status']); ?>">
                                    <?php echo esc_html(ucfirst($contribution['status'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No contributions found for the selected criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Render financial summary report
 */
function daystar_render_financial_summary_report() {
    // Get filters
    $filters = array();
    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $filters['date_from'] = sanitize_text_field($_GET['date_from']);
    } else {
        $filters['date_from'] = date('Y-01-01');
    }
    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $filters['date_to'] = sanitize_text_field($_GET['date_to']);
    } else {
        $filters['date_to'] = date('Y-12-31');
    }
    
    $report_data = DaystarReporting::get_financial_summary_report($filters);
    
    ?>
    <div class="report-container">
        <!-- Filters -->
        <form method="get" class="report-filters">
            <input type="hidden" name="page" value="daystar-financial-reports">
            <input type="hidden" name="report" value="summary">
            
            <div class="filter-row">
                <label>Date From:</label>
                <input type="date" name="date_from" value="<?php echo esc_attr($filters['date_from']); ?>">
                
                <label>Date To:</label>
                <input type="date" name="date_to" value="<?php echo esc_attr($filters['date_to']); ?>">
                
                <button type="submit" class="button button-primary">Update Report</button>
            </div>
        </form>
        
        <h3>Financial Summary Report (<?php echo date('M j, Y', strtotime($filters['date_from'])); ?> - <?php echo date('M j, Y', strtotime($filters['date_to'])); ?>)</h3>
        
        <!-- Loan Portfolio Summary -->
        <div class="financial-section">
            <h4>Loan Portfolio</h4>
            <div class="report-summary">
                <div class="summary-card">
                    <h4>Total Loans</h4>
                    <span class="summary-value"><?php echo number_format($report_data['loan_portfolio']['total_loans']); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Active Loans</h4>
                    <span class="summary-value"><?php echo number_format($report_data['loan_portfolio']['active_loans']); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Total Disbursed</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['loan_portfolio']['total_disbursed'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Outstanding Balance</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['loan_portfolio']['total_outstanding'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Delinquent Balance</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['loan_portfolio']['delinquent_balance'], 2); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Repayment Summary -->
        <div class="financial-section">
            <h4>Repayments</h4>
            <div class="report-summary">
                <div class="summary-card">
                    <h4>Total Payments</h4>
                    <span class="summary-value"><?php echo number_format($report_data['repayment_summary']['total_payments']); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Total Collected</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['repayment_summary']['total_collected'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Principal Collected</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['repayment_summary']['principal_collected'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Interest Collected</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['repayment_summary']['interest_collected'], 2); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Contribution Summary -->
        <div class="financial-section">
            <h4>Member Contributions</h4>
            <div class="report-summary">
                <div class="summary-card">
                    <h4>Total Contributions</h4>
                    <span class="summary-value"><?php echo number_format($report_data['contribution_summary']['total_contributions']); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Total Amount</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['contribution_summary']['total_amount'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Share Capital</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['contribution_summary']['share_capital'], 2); ?></span>
                </div>
                <div class="summary-card">
                    <h4>Savings</h4>
                    <span class="summary-value">KES <?php echo number_format($report_data['contribution_summary']['savings'], 2); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Portfolio Quality -->
        <div class="financial-section">
            <h4>Portfolio Quality Indicators</h4>
            <div class="report-summary">
                <div class="summary-card">
                    <h4>Delinquency Rate</h4>
                    <span class="summary-value"><?php echo $report_data['portfolio_quality']['delinquency_rate']; ?>%</span>
                </div>
                <div class="summary-card">
                    <h4>Collection Rate</h4>
                    <span class="summary-value"><?php echo $report_data['portfolio_quality']['collection_rate']; ?>%</span>
                </div>
            </div>
        </div>
        
        <!-- Monthly Trends -->
        <?php if (!empty($report_data['monthly_trends'])): ?>
            <div class="financial-section">
                <h4>Monthly Disbursement Trends</h4>
                
                <div class="report-chart-section">
                    <div class="chart-container">
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
                
                <table class="wp-list-table widefat">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Loans Disbursed</th>
                            <th>Amount Disbursed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report_data['monthly_trends'] as $trend): ?>
                            <tr>
                                <td><?php echo date('M Y', strtotime($trend['month'] . '-01')); ?></td>
                                <td><?php echo number_format($trend['loans_disbursed']); ?></td>
                                <td>KES <?php echo number_format($trend['amount_disbursed'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <script>
            window.monthlyTrendsData = <?php echo json_encode($report_data['monthly_trends']); ?>;
            </script>
        <?php endif; ?>
        
        <!-- Export Button -->
        <form method="post" style="margin: 20px 0;">
            <?php wp_nonce_field('daystar_export_report'); ?>
            <input type="hidden" name="export_type" value="financial_summary">
            <input type="hidden" name="filters" value="<?php echo esc_attr(json_encode($filters)); ?>">
            <button type="submit" name="export_report" class="button">Export to CSV</button>
        </form>
    </div>
    
    <?php daystar_render_report_styles(); ?>
    <?php
}

/**
 * Handle report export requests
 */
function daystar_handle_report_export() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    $export_type = sanitize_text_field($_POST['export_type']);
    $filters = json_decode(stripslashes($_POST['filters']), true);
    
    switch ($export_type) {
        case 'application_status':
            $report_data = DaystarReporting::get_loan_application_status_report($filters);
            $filename = 'loan_application_status_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Loan Type', 'Amount', 'Status', 'Application Date', 'Processing Days', 'Waiting Number');
            
            $export_data = array();
            foreach ($report_data['data'] as $loan) {
                $export_data[] = array(
                    $loan['display_name'],
                    $loan['member_number'],
                    $loan['loan_type'],
                    $loan['amount'],
                    $loan['status'],
                    $loan['loan_date'],
                    $loan['processing_days'],
                    $loan['application_waiting_number']
                );
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'disbursements':
            $report_data = DaystarReporting::get_loan_disbursement_report($filters);
            $filename = 'loan_disbursements_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Loan Type', 'Amount', 'Disbursement Date', 'Method', 'Reference', 'Confirmed');
            
            $export_data = array();
            foreach ($report_data['data'] as $disbursement) {
                $export_data[] = array(
                    $disbursement['display_name'],
                    $disbursement['member_number'],
                    $disbursement['loan_type'],
                    $disbursement['amount'],
                    $disbursement['disbursed_date'],
                    $disbursement['disbursement_method'],
                    $disbursement['disbursement_reference'],
                    $disbursement['recipient_confirmation'] ? 'Yes' : 'No'
                );
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'repayments':
            $report_data = DaystarReporting::get_loan_repayment_report($filters);
            $filename = 'loan_repayments_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Loan Type', 'Payment Amount', 'Principal', 'Interest', 'Payment Date', 'Method', 'Payroll Deduction');
            
            $export_data = array();
            foreach ($report_data['data'] as $payment) {
                $export_data[] = array(
                    $payment['display_name'],
                    $payment['member_number'],
                    $payment['loan_type'],
                    $payment['payment_amount'],
                    $payment['principal_amount'],
                    $payment['interest_amount'],
                    $payment['payment_date'],
                    $payment['payment_method'],
                    $payment['is_payroll_deduction'] ? 'Yes' : 'No'
                );
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'delinquency':
            $report_data = DaystarReporting::get_loan_delinquency_report($filters);
            $filename = 'loan_delinquency_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Loan Type', 'Outstanding Balance', 'Overdue Amount', 'Days Overdue', 'Status');
            
            $export_data = array();
            foreach ($report_data['data'] as $loan) {
                $export_data[] = array(
                    $loan['display_name'],
                    $loan['member_number'],
                    $loan['loan_type'],
                    $loan['outstanding_balance'],
                    $loan['overdue_amount'],
                    $loan['days_overdue'],
                    $loan['delinquency_status']
                );
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'member_loan_history':
            $report_data = DaystarReporting::get_member_loan_history_report($filters);
            $filename = 'member_loan_history_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Loan Type', 'Amount', 'Balance', 'Status', 'Application Date', 'Total Paid', 'Payment Count');
            
            $export_data = array();
            foreach ($report_data['data'] as $member_data) {
                foreach ($member_data['loans'] as $loan) {
                    $export_data[] = array(
                        $member_data['member_info']['display_name'],
                        $member_data['member_info']['member_number'],
                        $loan['loan_type'],
                        $loan['amount'],
                        $loan['balance'],
                        $loan['status'],
                        $loan['loan_date'],
                        $loan['total_paid'],
                        $loan['payment_count']
                    );
                }
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'member_contributions':
            $report_data = DaystarReporting::get_member_contribution_report($filters);
            $filename = 'member_contributions_' . date('Y-m-d') . '.csv';
            $headers = array('Member Name', 'Member Number', 'Amount', 'Type', 'Share Capital', 'Date', 'Payment Method', 'Reference', 'Status');
            
            $export_data = array();
            foreach ($report_data['data'] as $contribution) {
                $export_data[] = array(
                    $contribution['display_name'],
                    $contribution['member_number'],
                    $contribution['amount'],
                    $contribution['contribution_type'],
                    $contribution['is_share_capital'] ? 'Yes' : 'No',
                    $contribution['contribution_date'],
                    $contribution['payment_method'],
                    $contribution['reference_number'],
                    $contribution['status']
                );
            }
            
            DaystarReporting::export_to_csv($export_data, $filename, $headers);
            break;
            
        case 'financial_summary':
            $report_data = DaystarReporting::get_financial_summary_report($filters);
            $filename = 'financial_summary_' . date('Y-m-d') . '.csv';
            
            // Create summary data for export
            $export_data = array(
                array('Metric', 'Value'),
                array('Total Loans', $report_data['loan_portfolio']['total_loans']),
                array('Active Loans', $report_data['loan_portfolio']['active_loans']),
                array('Total Disbursed', $report_data['loan_portfolio']['total_disbursed']),
                array('Outstanding Balance', $report_data['loan_portfolio']['total_outstanding']),
                array('Delinquent Balance', $report_data['loan_portfolio']['delinquent_balance']),
                array('Total Payments', $report_data['repayment_summary']['total_payments']),
                array('Total Collected', $report_data['repayment_summary']['total_collected']),
                array('Principal Collected', $report_data['repayment_summary']['principal_collected']),
                array('Interest Collected', $report_data['repayment_summary']['interest_collected']),
                array('Total Contributions', $report_data['contribution_summary']['total_contributions']),
                array('Contribution Amount', $report_data['contribution_summary']['total_amount']),
                array('Share Capital', $report_data['contribution_summary']['share_capital']),
                array('Savings', $report_data['contribution_summary']['savings']),
                array('Delinquency Rate (%)', $report_data['portfolio_quality']['delinquency_rate']),
                array('Collection Rate (%)', $report_data['portfolio_quality']['collection_rate'])
            );
            
            DaystarReporting::export_to_csv($export_data, $filename);
            break;
    }
}

/**
 * Render common report styles
 */
function daystar_render_report_styles() {
    ?>
    <style>
    .report-container {
        max-width: 1200px;
    }
    
    .report-filters {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .filter-row {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .filter-row label {
        font-weight: 600;
        margin: 0;
    }
    
    .filter-row input,
    .filter-row select {
        margin: 0;
    }
    
    .report-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .summary-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .summary-card h4 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .summary-card .summary-value {
        font-size: 18px;
        font-weight: bold;
        color: #0073aa;
    }
    
    .status-badge {
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-declined { background: #f8d7da; color: #721c24; }
    .status-active { background: #d1ecf1; color: #0c5460; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-payroll { background: #e2e3e5; color: #383d41; }
    .status-manual { background: #fff3cd; color: #856404; }
    .status-share-capital { background: #cce5ff; color: #004085; }
    .status-savings { background: #e7f3ff; color: #0056b3; }
    .status-1-30 { background: #fff3cd; color: #856404; }
    .status-31-60 { background: #ffeaa7; color: #b8860b; }
    .status-61-90 { background: #fab1a0; color: #d63031; }
    .status-90 { background: #ff7675; color: #fff; }
    
    .financial-section {
        margin-bottom: 40px;
    }
    
    .financial-section h4 {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0073aa;
        color: #333;
    }
    
    .member-section {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .member-section h3 {
        margin-top: 0;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .member-summary {
        display: flex;
        gap: 20px;
        margin: 15px 0;
        flex-wrap: wrap;
    }
    
    .member-summary span {
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .delinquency-breakdown {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .delinquency-breakdown h3 {
        margin-top: 0;
        color: #333;
    }
    </style>
    <?php
}