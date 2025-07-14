<?php
/**
 * Loan Recovery Utilities
 * 
 * Helper functions and utilities for loan recovery operations
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate sample recovery data for testing
 */
function generate_sample_recovery_data() {
    global $wpdb;
    
    // Add sample employer and department data to existing users
    $users = get_users(array(
        'meta_key' => 'member_number',
        'meta_compare' => 'EXISTS',
        'number' => 10
    ));
    
    $employers = array(
        'Daystar University',
        'Kenya Airways',
        'Safaricom Ltd',
        'KCB Bank',
        'Ministry of Education'
    );
    
    $departments = array(
        'Human Resources',
        'Finance',
        'IT Department',
        'Marketing',
        'Operations',
        'Administration'
    );
    
    foreach ($users as $user) {
        // Add employer information
        update_user_meta($user->ID, 'employer', $employers[array_rand($employers)]);
        update_user_meta($user->ID, 'department', $departments[array_rand($departments)]);
        update_user_meta($user->ID, 'employee_number', 'EMP' . str_pad($user->ID, 4, '0', STR_PAD_LEFT));
        update_user_meta($user->ID, 'payroll_number', 'PR' . str_pad($user->ID, 6, '0', STR_PAD_LEFT));
    }
    
    return count($users) . ' users updated with employer information';
}

/**
 * Create sample overdue payments for testing
 */
function create_sample_overdue_payments() {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    // Update some schedules to be overdue
    $wpdb->query("
        UPDATE $schedules_table 
        SET status = 'overdue', 
            due_date = DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 60 + 1) DAY)
        WHERE status = 'due' 
        AND RAND() < 0.3
        LIMIT 10
    ");
    
    return 'Sample overdue payments created';
}

/**
 * Generate sample anomalies for testing
 */
function generate_sample_anomalies() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $anomalies_table = $wpdb->prefix . 'daystar_loan_anomalies';
    
    // Get some loans for creating anomalies
    $loans = $wpdb->get_results("
        SELECT l.*, u.display_name 
        FROM $loans_table l 
        INNER JOIN {$wpdb->users} u ON l.user_id = u.ID 
        LIMIT 5
    ");
    
    $anomaly_types = array(
        array(
            'type' => 'application_incomplete',
            'severity' => 'medium',
            'description' => 'Incomplete loan application detected',
            'details' => 'Missing required documentation',
            'suggested_action' => 'Submit missing documents'
        ),
        array(
            'type' => 'payment_overdue',
            'severity' => 'high',
            'description' => 'Multiple overdue payments detected',
            'details' => 'Payment is 45 days overdue',
            'suggested_action' => 'Make immediate payment to avoid penalties'
        ),
        array(
            'type' => 'balance_inconsistency',
            'severity' => 'critical',
            'description' => 'Loan balance inconsistency detected',
            'details' => 'Calculated balance does not match recorded balance',
            'suggested_action' => 'Contact SACCO for balance reconciliation'
        )
    );
    
    foreach ($loans as $loan) {
        $anomaly = $anomaly_types[array_rand($anomaly_types)];
        
        $wpdb->insert($anomalies_table, array(
            'loan_id' => $loan->id,
            'user_id' => $loan->user_id,
            'type' => $anomaly['type'],
            'severity' => $anomaly['severity'],
            'description' => $anomaly['description'],
            'details' => $anomaly['details'],
            'suggested_action' => $anomaly['suggested_action'],
            'status' => 'open',
            'created_at' => current_time('mysql')
        ));
    }
    
    return count($loans) . ' sample anomalies created';
}

/**
 * Clean up test data
 */
function cleanup_recovery_test_data() {
    global $wpdb;
    
    $anomalies_table = $wpdb->prefix . 'daystar_loan_anomalies';
    $deduction_lists_table = $wpdb->prefix . 'daystar_deduction_lists';
    $reconciliation_table = $wpdb->prefix . 'daystar_reconciliation_reports';
    
    // Delete test anomalies
    $wpdb->query("DELETE FROM $anomalies_table WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    
    // Delete test deduction lists
    $wpdb->query("DELETE FROM $deduction_lists_table WHERE generated_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    
    // Delete test reconciliation reports
    $wpdb->query("DELETE FROM $reconciliation_table WHERE generated_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    
    return 'Test data cleaned up';
}

/**
 * Validate recovery system setup
 */
function validate_recovery_system() {
    global $wpdb;
    
    $validation_results = array();
    
    // Check if required tables exist
    $required_tables = array(
        'daystar_deduction_lists',
        'daystar_reconciliation_reports',
        'daystar_loan_anomalies'
    );
    
    foreach ($required_tables as $table) {
        $table_name = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
        $validation_results['tables'][$table] = $exists ? 'EXISTS' : 'MISSING';
    }
    
    // Check if scheduled tasks are set up
    $validation_results['scheduled_tasks']['monthly_reconciliation'] = wp_next_scheduled('daystar_monthly_reconciliation') ? 'SCHEDULED' : 'NOT_SCHEDULED';
    $validation_results['scheduled_tasks']['anomaly_detection'] = wp_next_scheduled('daystar_anomaly_detection') ? 'SCHEDULED' : 'NOT_SCHEDULED';
    
    // Check if sample data exists
    $loans_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans");
    $schedules_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_schedules");
    $users_with_employer = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->usermeta} WHERE meta_key = 'employer'");
    
    $validation_results['data']['loans'] = $loans_count;
    $validation_results['data']['schedules'] = $schedules_count;
    $validation_results['data']['users_with_employer'] = $users_with_employer;
    
    return $validation_results;
}

/**
 * Test deduction list generation
 */
function test_deduction_list_generation() {
    require_once get_template_directory() . '/includes/loan-recovery.php';
    
    $period_start = date('Y-m-01');
    $period_end = date('Y-m-t');
    
    $result = LoanRecoveryHandler::generate_deduction_list($period_start, $period_end);
    
    return $result;
}

/**
 * Test reconciliation process
 */
function test_reconciliation_process() {
    require_once get_template_directory() . '/includes/loan-recovery.php';
    
    $period_start = date('Y-m-01', strtotime('last month'));
    $period_end = date('Y-m-t', strtotime('last month'));
    
    $result = LoanRecoveryHandler::run_reconciliation($period_start, $period_end);
    
    return $result;
}

/**
 * Test anomaly detection
 */
function test_anomaly_detection() {
    require_once get_template_directory() . '/includes/loan-recovery.php';
    
    $anomalies = LoanRecoveryHandler::run_anomaly_detection();
    
    return array(
        'anomalies_detected' => count($anomalies),
        'anomalies' => $anomalies
    );
}

/**
 * Get recovery system status
 */
function get_recovery_system_status() {
    global $wpdb;
    
    $status = array();
    
    // Get counts
    $status['deduction_lists'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_deduction_lists");
    $status['reconciliation_reports'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_reconciliation_reports");
    $status['open_anomalies'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_anomalies WHERE status = 'open'");
    $status['resolved_anomalies'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_anomalies WHERE status = 'resolved'");
    
    // Get recent activity
    $status['last_deduction_list'] = $wpdb->get_var("SELECT generated_at FROM {$wpdb->prefix}daystar_deduction_lists ORDER BY generated_at DESC LIMIT 1");
    $status['last_reconciliation'] = $wpdb->get_var("SELECT generated_at FROM {$wpdb->prefix}daystar_reconciliation_reports ORDER BY generated_at DESC LIMIT 1");
    $status['last_anomaly'] = $wpdb->get_var("SELECT created_at FROM {$wpdb->prefix}daystar_loan_anomalies ORDER BY created_at DESC LIMIT 1");
    
    return $status;
}

// Add admin page for testing utilities (only for development)
if (defined('WP_DEBUG') && WP_DEBUG) {
    add_action('admin_menu', function() {
        add_submenu_page(
            'daystar-admin-dashboard',
            'Recovery Testing',
            'Recovery Testing',
            'manage_options',
            'daystar-recovery-testing',
            'daystar_recovery_testing_page'
        );
    });
    
    function daystar_recovery_testing_page() {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $result = '';
            
            switch ($action) {
                case 'generate_sample_data':
                    $result = generate_sample_recovery_data();
                    break;
                case 'create_overdue_payments':
                    $result = create_sample_overdue_payments();
                    break;
                case 'generate_anomalies':
                    $result = generate_sample_anomalies();
                    break;
                case 'test_deduction_list':
                    $result = test_deduction_list_generation();
                    break;
                case 'test_reconciliation':
                    $result = test_reconciliation_process();
                    break;
                case 'test_anomaly_detection':
                    $result = test_anomaly_detection();
                    break;
                case 'validate_system':
                    $result = validate_recovery_system();
                    break;
                case 'cleanup_test_data':
                    $result = cleanup_recovery_test_data();
                    break;
            }
            
            echo '<div class="notice notice-success"><p>Result: ' . (is_array($result) ? json_encode($result, JSON_PRETTY_PRINT) : $result) . '</p></div>';
        }
        
        $status = get_recovery_system_status();
        
        ?>
        <div class="wrap">
            <h1>Loan Recovery Testing Utilities</h1>
            <p><strong>Note:</strong> This page is only available in debug mode for testing purposes.</p>
            
            <div class="card" style="max-width: none;">
                <h2>System Status</h2>
                <table class="wp-list-table widefat fixed striped">
                    <tr><th>Deduction Lists Generated</th><td><?php echo $status['deduction_lists']; ?></td></tr>
                    <tr><th>Reconciliation Reports</th><td><?php echo $status['reconciliation_reports']; ?></td></tr>
                    <tr><th>Open Anomalies</th><td><?php echo $status['open_anomalies']; ?></td></tr>
                    <tr><th>Resolved Anomalies</th><td><?php echo $status['resolved_anomalies']; ?></td></tr>
                    <tr><th>Last Deduction List</th><td><?php echo $status['last_deduction_list'] ?: 'Never'; ?></td></tr>
                    <tr><th>Last Reconciliation</th><td><?php echo $status['last_reconciliation'] ?: 'Never'; ?></td></tr>
                    <tr><th>Last Anomaly</th><td><?php echo $status['last_anomaly'] ?: 'Never'; ?></td></tr>
                </table>
            </div>
            
            <div class="card" style="max-width: none;">
                <h2>Test Data Generation</h2>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="generate_sample_data">
                    <button type="submit" class="button">Generate Sample Employer Data</button>
                </form>
                
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="create_overdue_payments">
                    <button type="submit" class="button">Create Sample Overdue Payments</button>
                </form>
                
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="generate_anomalies">
                    <button type="submit" class="button">Generate Sample Anomalies</button>
                </form>
            </div>
            
            <div class="card" style="max-width: none;">
                <h2>Function Testing</h2>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="test_deduction_list">
                    <button type="submit" class="button button-primary">Test Deduction List Generation</button>
                </form>
                
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="test_reconciliation">
                    <button type="submit" class="button button-primary">Test Reconciliation Process</button>
                </form>
                
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="test_anomaly_detection">
                    <button type="submit" class="button button-primary">Test Anomaly Detection</button>
                </form>
            </div>
            
            <div class="card" style="max-width: none;">
                <h2>System Validation</h2>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="validate_system">
                    <button type="submit" class="button">Validate System Setup</button>
                </form>
                
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="cleanup_test_data">
                    <button type="submit" class="button button-secondary">Cleanup Test Data</button>
                </form>
            </div>
        </div>
        <?php
    }
}