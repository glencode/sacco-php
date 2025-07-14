<?php
/**
 * Loan Recovery Procedure
 * 
 * Handles the complete loan recovery process including:
 * - Automated deduction list generation for payroll
 * - Reconciliation of expected vs actual recoveries
 * - Anomaly detection and member notifications
 * - Recovery tracking and reporting
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/notifications.php';

/**
 * Loan Recovery Handler Class
 */
class LoanRecoveryHandler {
    
    /**
     * Initialize recovery hooks
     */
    public static function init() {
        add_action('wp_ajax_generate_deduction_list', array(__CLASS__, 'ajax_generate_deduction_list'));
        add_action('wp_ajax_run_reconciliation', array(__CLASS__, 'ajax_run_reconciliation'));
        add_action('wp_ajax_resolve_anomaly', array(__CLASS__, 'ajax_resolve_anomaly'));
        add_action('wp_ajax_export_deduction_list', array(__CLASS__, 'ajax_export_deduction_list'));
        
        // Schedule automated tasks
        add_action('daystar_monthly_reconciliation', array(__CLASS__, 'run_monthly_reconciliation'));
        add_action('daystar_anomaly_detection', array(__CLASS__, 'run_anomaly_detection'));
        
        // Schedule hooks if not already scheduled
        if (!wp_next_scheduled('daystar_monthly_reconciliation')) {
            wp_schedule_event(time(), 'monthly', 'daystar_monthly_reconciliation');
        }
        
        if (!wp_next_scheduled('daystar_anomaly_detection')) {
            wp_schedule_event(time(), 'daily', 'daystar_anomaly_detection');
        }
    }
    
    /**
     * Generate deduction list for payroll
     */
    public static function generate_deduction_list($period_start, $period_end, $filters = array()) {
        global $wpdb;
        
        try {
            $loans_table = $wpdb->prefix . 'daystar_loans';
            $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
            $users_table = $wpdb->users;
            $usermeta_table = $wpdb->usermeta;
            
            // Build WHERE clause based on filters
            $where_conditions = array("l.status = 'disbursed'");
            $where_params = array();
            
            if (!empty($filters['employer'])) {
                $where_conditions[] = "um_employer.meta_value = %s";
                $where_params[] = $filters['employer'];
            }
            
            if (!empty($filters['loan_type'])) {
                $where_conditions[] = "l.loan_type = %s";
                $where_params[] = $filters['loan_type'];
            }
            
            if (!empty($filters['department'])) {
                $where_conditions[] = "um_department.meta_value = %s";
                $where_params[] = $filters['department'];
            }
            
            $where_clause = implode(' AND ', $where_conditions);
            
            // Query to get deduction list
            $query = "
                SELECT DISTINCT
                    l.id as loan_id,
                    l.user_id,
                    u.display_name,
                    um_member.meta_value as member_number,
                    um_employee.meta_value as employee_number,
                    um_employer.meta_value as employer,
                    um_department.meta_value as department,
                    um_payroll.meta_value as payroll_number,
                    l.loan_type,
                    l.amount as loan_amount,
                    l.balance as outstanding_balance,
                    l.monthly_payment,
                    ls.expected_total as next_deduction_amount,
                    ls.due_date as next_due_date,
                    ls.installment_number,
                    CASE 
                        WHEN ls.status = 'overdue' THEN 'OVERDUE'
                        WHEN ls.due_date <= %s THEN 'DUE'
                        ELSE 'UPCOMING'
                    END as payment_status
                FROM $loans_table l
                INNER JOIN $users_table u ON l.user_id = u.ID
                LEFT JOIN $usermeta_table um_member ON (u.ID = um_member.user_id AND um_member.meta_key = 'member_number')
                LEFT JOIN $usermeta_table um_employee ON (u.ID = um_employee.user_id AND um_employee.meta_key = 'employee_number')
                LEFT JOIN $usermeta_table um_employer ON (u.ID = um_employer.user_id AND um_employer.meta_key = 'employer')
                LEFT JOIN $usermeta_table um_department ON (u.ID = um_department.user_id AND um_department.meta_key = 'department')
                LEFT JOIN $usermeta_table um_payroll ON (u.ID = um_payroll.user_id AND um_payroll.meta_key = 'payroll_number')
                LEFT JOIN $schedules_table ls ON (l.id = ls.loan_id AND ls.due_date BETWEEN %s AND %s AND ls.status IN ('due', 'overdue'))
                WHERE $where_clause
                ORDER BY um_employer.meta_value, um_department.meta_value, u.display_name
            ";
            
            $params = array_merge(array($period_end, $period_start, $period_end), $where_params);
            $results = $wpdb->get_results($wpdb->prepare($query, $params));
            
            // Process results and calculate totals
            $deduction_list = array();
            $summary = array(
                'total_members' => 0,
                'total_deductions' => 0,
                'total_amount' => 0,
                'by_employer' => array(),
                'by_status' => array('DUE' => 0, 'OVERDUE' => 0, 'UPCOMING' => 0)
            );
            
            foreach ($results as $row) {
                $deduction_amount = $row->next_deduction_amount ?: $row->monthly_payment;
                
                $deduction_list[] = array(
                    'loan_id' => $row->loan_id,
                    'member_number' => $row->member_number,
                    'employee_number' => $row->employee_number,
                    'member_name' => $row->display_name,
                    'employer' => $row->employer,
                    'department' => $row->department,
                    'payroll_number' => $row->payroll_number,
                    'loan_type' => $row->loan_type,
                    'loan_amount' => $row->loan_amount,
                    'outstanding_balance' => $row->outstanding_balance,
                    'deduction_amount' => $deduction_amount,
                    'due_date' => $row->next_due_date,
                    'installment_number' => $row->installment_number,
                    'payment_status' => $row->payment_status
                );
                
                // Update summary
                $summary['total_members']++;
                $summary['total_amount'] += $deduction_amount;
                $summary['by_status'][$row->payment_status]++;
                
                if (!isset($summary['by_employer'][$row->employer])) {
                    $summary['by_employer'][$row->employer] = array(
                        'count' => 0,
                        'amount' => 0
                    );
                }
                $summary['by_employer'][$row->employer]['count']++;
                $summary['by_employer'][$row->employer]['amount'] += $deduction_amount;
            }
            
            $summary['total_deductions'] = count($deduction_list);
            
            // Store deduction list for later export
            self::store_deduction_list($deduction_list, $period_start, $period_end, $filters);
            
            return array(
                'success' => true,
                'deduction_list' => $deduction_list,
                'summary' => $summary,
                'period_start' => $period_start,
                'period_end' => $period_end
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Run reconciliation between expected and actual recoveries
     */
    public static function run_reconciliation($period_start, $period_end) {
        global $wpdb;
        
        try {
            $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
            $payments_table = $wpdb->prefix . 'daystar_loan_payments';
            $loans_table = $wpdb->prefix . 'daystar_loans';
            $users_table = $wpdb->users;
            $usermeta_table = $wpdb->usermeta;
            
            // Query to get expected vs actual payments
            $query = "
                SELECT 
                    ls.loan_id,
                    l.user_id,
                    u.display_name,
                    um.meta_value as member_number,
                    l.loan_type,
                    ls.installment_number,
                    ls.due_date,
                    ls.expected_total as expected_amount,
                    COALESCE(SUM(lp.amount), 0) as actual_amount,
                    ls.status as schedule_status,
                    CASE 
                        WHEN COALESCE(SUM(lp.amount), 0) = 0 THEN 'MISSING'
                        WHEN COALESCE(SUM(lp.amount), 0) < ls.expected_total THEN 'UNDERPAID'
                        WHEN COALESCE(SUM(lp.amount), 0) > ls.expected_total THEN 'OVERPAID'
                        ELSE 'MATCHED'
                    END as reconciliation_status,
                    (ls.expected_total - COALESCE(SUM(lp.amount), 0)) as variance
                FROM $schedules_table ls
                INNER JOIN $loans_table l ON ls.loan_id = l.id
                INNER JOIN $users_table u ON l.user_id = u.ID
                LEFT JOIN $usermeta_table um ON (u.ID = um.user_id AND um.meta_key = 'member_number')
                LEFT JOIN $payments_table lp ON (ls.loan_id = lp.loan_id AND DATE(lp.payment_date) BETWEEN %s AND %s)
                WHERE ls.due_date BETWEEN %s AND %s
                GROUP BY ls.loan_id, ls.installment_number
                ORDER BY ls.due_date, u.display_name
            ";
            
            $results = $wpdb->get_results($wpdb->prepare($query, $period_start, $period_end, $period_start, $period_end));
            
            // Process reconciliation results
            $reconciliation_data = array();
            $summary = array(
                'total_expected' => 0,
                'total_actual' => 0,
                'total_variance' => 0,
                'counts' => array(
                    'MATCHED' => 0,
                    'MISSING' => 0,
                    'UNDERPAID' => 0,
                    'OVERPAID' => 0
                ),
                'amounts' => array(
                    'MATCHED' => 0,
                    'MISSING' => 0,
                    'UNDERPAID' => 0,
                    'OVERPAID' => 0
                )
            );
            
            foreach ($results as $row) {
                $reconciliation_data[] = array(
                    'loan_id' => $row->loan_id,
                    'member_number' => $row->member_number,
                    'member_name' => $row->display_name,
                    'loan_type' => $row->loan_type,
                    'installment_number' => $row->installment_number,
                    'due_date' => $row->due_date,
                    'expected_amount' => $row->expected_amount,
                    'actual_amount' => $row->actual_amount,
                    'variance' => $row->variance,
                    'status' => $row->reconciliation_status
                );
                
                // Update summary
                $summary['total_expected'] += $row->expected_amount;
                $summary['total_actual'] += $row->actual_amount;
                $summary['total_variance'] += $row->variance;
                $summary['counts'][$row->reconciliation_status]++;
                $summary['amounts'][$row->reconciliation_status] += abs($row->variance);
            }
            
            // Store reconciliation results
            self::store_reconciliation_results($reconciliation_data, $summary, $period_start, $period_end);
            
            // Trigger anomaly notifications for significant discrepancies
            self::process_reconciliation_anomalies($reconciliation_data);
            
            return array(
                'success' => true,
                'reconciliation_data' => $reconciliation_data,
                'summary' => $summary,
                'period_start' => $period_start,
                'period_end' => $period_end
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Detect and manage anomalies
     */
    public static function run_anomaly_detection() {
        global $wpdb;
        
        $anomalies = array();
        
        // 1. Application Anomalies
        $application_anomalies = self::detect_application_anomalies();
        $anomalies = array_merge($anomalies, $application_anomalies);
        
        // 2. Repayment Discrepancies
        $repayment_anomalies = self::detect_repayment_anomalies();
        $anomalies = array_merge($anomalies, $repayment_anomalies);
        
        // 3. System Anomalies
        $system_anomalies = self::detect_system_anomalies();
        $anomalies = array_merge($anomalies, $system_anomalies);
        
        // Store anomalies and trigger notifications
        foreach ($anomalies as $anomaly) {
            self::store_anomaly($anomaly);
            self::notify_member_of_anomaly($anomaly);
        }
        
        return $anomalies;
    }
    
    /**
     * Detect application anomalies
     */
    private static function detect_application_anomalies() {
        global $wpdb;
        
        $anomalies = array();
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $users_table = $wpdb->users;
        $usermeta_table = $wpdb->usermeta;
        
        // Check for incomplete applications
        $query = "
            SELECT l.id, l.user_id, u.display_name, l.loan_type, l.status
            FROM $loans_table l
            INNER JOIN $users_table u ON l.user_id = u.ID
            WHERE l.status IN ('pending', 'under_review')
            AND (
                l.purpose IS NULL OR l.purpose = '' OR
                l.monthly_payment IS NULL OR l.monthly_payment = 0 OR
                l.term_months IS NULL OR l.term_months = 0
            )
        ";
        
        $incomplete_applications = $wpdb->get_results($query);
        
        foreach ($incomplete_applications as $app) {
            $anomalies[] = array(
                'type' => 'application_incomplete',
                'severity' => 'medium',
                'loan_id' => $app->id,
                'user_id' => $app->user_id,
                'member_name' => $app->display_name,
                'description' => 'Incomplete loan application detected',
                'details' => 'Loan application is missing required information',
                'suggested_action' => 'Complete missing application details',
                'detected_at' => current_time('mysql')
            );
        }
        
        // Check for missing guarantors
        $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
        $query = "
            SELECT l.id, l.user_id, u.display_name, l.loan_type, COUNT(g.id) as guarantor_count
            FROM $loans_table l
            INNER JOIN $users_table u ON l.user_id = u.ID
            LEFT JOIN $guarantors_table g ON l.id = g.loan_id
            WHERE l.status IN ('pending', 'under_review')
            AND l.amount > 50000
            GROUP BY l.id
            HAVING guarantor_count < 2
        ";
        
        $missing_guarantors = $wpdb->get_results($query);
        
        foreach ($missing_guarantors as $loan) {
            $anomalies[] = array(
                'type' => 'missing_guarantors',
                'severity' => 'high',
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'member_name' => $loan->display_name,
                'description' => 'Insufficient guarantors for loan amount',
                'details' => "Only {$loan->guarantor_count} guarantor(s) provided for loan requiring 2",
                'suggested_action' => 'Provide additional guarantors',
                'detected_at' => current_time('mysql')
            );
        }
        
        return $anomalies;
    }
    
    /**
     * Detect repayment anomalies
     */
    private static function detect_repayment_anomalies() {
        global $wpdb;
        
        $anomalies = array();
        $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
        $payments_table = $wpdb->prefix . 'daystar_loan_payments';
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $users_table = $wpdb->users;
        
        // Check for overdue payments
        $query = "
            SELECT ls.loan_id, l.user_id, u.display_name, l.loan_type,
                   COUNT(*) as overdue_count,
                   SUM(ls.expected_total) as overdue_amount,
                   MIN(ls.due_date) as first_overdue_date
            FROM $schedules_table ls
            INNER JOIN $loans_table l ON ls.loan_id = l.id
            INNER JOIN $users_table u ON l.user_id = u.ID
            WHERE ls.status = 'overdue'
            AND ls.due_date < CURDATE()
            GROUP BY ls.loan_id
            HAVING overdue_count >= 2
        ";
        
        $overdue_payments = $wpdb->get_results($query);
        
        foreach ($overdue_payments as $overdue) {
            $days_overdue = (strtotime('now') - strtotime($overdue->first_overdue_date)) / (60 * 60 * 24);
            
            $anomalies[] = array(
                'type' => 'payment_overdue',
                'severity' => $days_overdue > 90 ? 'critical' : ($days_overdue > 30 ? 'high' : 'medium'),
                'loan_id' => $overdue->loan_id,
                'user_id' => $overdue->user_id,
                'member_name' => $overdue->display_name,
                'description' => 'Multiple overdue payments detected',
                'details' => "{$overdue->overdue_count} payments overdue totaling KES " . number_format($overdue->overdue_amount, 2),
                'suggested_action' => 'Contact member to arrange payment',
                'detected_at' => current_time('mysql')
            );
        }
        
        // Check for irregular payment patterns
        $query = "
            SELECT lp.loan_id, l.user_id, u.display_name, l.loan_type,
                   COUNT(*) as payment_count,
                   AVG(lp.amount) as avg_payment,
                   STDDEV(lp.amount) as payment_variance
            FROM $payments_table lp
            INNER JOIN $loans_table l ON lp.loan_id = l.id
            INNER JOIN $users_table u ON l.user_id = u.ID
            WHERE lp.payment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY lp.loan_id
            HAVING payment_count >= 3 AND payment_variance > (avg_payment * 0.5)
        ";
        
        $irregular_payments = $wpdb->get_results($query);
        
        foreach ($irregular_payments as $irregular) {
            $anomalies[] = array(
                'type' => 'irregular_payments',
                'severity' => 'low',
                'loan_id' => $irregular->loan_id,
                'user_id' => $irregular->user_id,
                'member_name' => $irregular->display_name,
                'description' => 'Irregular payment pattern detected',
                'details' => 'Payment amounts vary significantly from expected schedule',
                'suggested_action' => 'Review payment schedule with member',
                'detected_at' => current_time('mysql')
            );
        }
        
        return $anomalies;
    }
    
    /**
     * Detect system anomalies
     */
    private static function detect_system_anomalies() {
        global $wpdb;
        
        $anomalies = array();
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
        $users_table = $wpdb->users;
        
        // Check for loans without schedules
        $query = "
            SELECT l.id, l.user_id, u.display_name, l.loan_type, l.status
            FROM $loans_table l
            INNER JOIN $users_table u ON l.user_id = u.ID
            LEFT JOIN $schedules_table ls ON l.id = ls.loan_id
            WHERE l.status = 'disbursed'
            AND ls.loan_id IS NULL
        ";
        
        $loans_without_schedules = $wpdb->get_results($query);
        
        foreach ($loans_without_schedules as $loan) {
            $anomalies[] = array(
                'type' => 'missing_schedule',
                'severity' => 'critical',
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'member_name' => $loan->display_name,
                'description' => 'Disbursed loan missing repayment schedule',
                'details' => 'System error: No repayment schedule generated for disbursed loan',
                'suggested_action' => 'Generate repayment schedule immediately',
                'detected_at' => current_time('mysql')
            );
        }
        
        // Check for balance inconsistencies
        $query = "
            SELECT l.id, l.user_id, u.display_name, l.loan_type,
                   l.amount as original_amount,
                   l.balance as current_balance,
                   COALESCE(SUM(lp.amount), 0) as total_payments
            FROM $loans_table l
            INNER JOIN $users_table u ON l.user_id = u.ID
            LEFT JOIN {$wpdb->prefix}daystar_loan_payments lp ON l.id = lp.loan_id
            WHERE l.status IN ('disbursed', 'active')
            GROUP BY l.id
            HAVING ABS((original_amount - total_payments) - current_balance) > 1
        ";
        
        $balance_inconsistencies = $wpdb->get_results($query);
        
        foreach ($balance_inconsistencies as $loan) {
            $expected_balance = $loan->original_amount - $loan->total_payments;
            $variance = abs($expected_balance - $loan->current_balance);
            
            $anomalies[] = array(
                'type' => 'balance_inconsistency',
                'severity' => 'high',
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'member_name' => $loan->display_name,
                'description' => 'Loan balance inconsistency detected',
                'details' => "Balance variance of KES " . number_format($variance, 2),
                'suggested_action' => 'Recalculate and correct loan balance',
                'detected_at' => current_time('mysql')
            );
        }
        
        return $anomalies;
    }
    
    /**
     * Store deduction list for export
     */
    private static function store_deduction_list($deduction_list, $period_start, $period_end, $filters) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_deduction_lists';
        self::create_deduction_lists_table();
        
        $list_id = 'DL' . date('YmdHis');
        
        $data = array(
            'list_id' => $list_id,
            'period_start' => $period_start,
            'period_end' => $period_end,
            'filters' => json_encode($filters),
            'deduction_data' => json_encode($deduction_list),
            'generated_by' => get_current_user_id(),
            'generated_at' => current_time('mysql')
        );
        
        $wpdb->insert($table_name, $data);
        
        return $list_id;
    }
    
    /**
     * Store reconciliation results
     */
    private static function store_reconciliation_results($reconciliation_data, $summary, $period_start, $period_end) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_reconciliation_reports';
        self::create_reconciliation_table();
        
        $report_id = 'RR' . date('YmdHis');
        
        $data = array(
            'report_id' => $report_id,
            'period_start' => $period_start,
            'period_end' => $period_end,
            'reconciliation_data' => json_encode($reconciliation_data),
            'summary_data' => json_encode($summary),
            'generated_by' => get_current_user_id(),
            'generated_at' => current_time('mysql')
        );
        
        $wpdb->insert($table_name, $data);
        
        return $report_id;
    }
    
    /**
     * Store anomaly
     */
    private static function store_anomaly($anomaly) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_loan_anomalies';
        self::create_anomalies_table();
        
        // Check if similar anomaly already exists
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name 
             WHERE loan_id = %d AND type = %s AND status = 'open' 
             AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)",
            $anomaly['loan_id'],
            $anomaly['type']
        ));
        
        if (!$existing) {
            $wpdb->insert($table_name, array(
                'loan_id' => $anomaly['loan_id'],
                'user_id' => $anomaly['user_id'],
                'type' => $anomaly['type'],
                'severity' => $anomaly['severity'],
                'description' => $anomaly['description'],
                'details' => $anomaly['details'],
                'suggested_action' => $anomaly['suggested_action'],
                'status' => 'open',
                'created_at' => $anomaly['detected_at']
            ));
        }
    }
    
    /**
     * Notify member of anomaly
     */
    private static function notify_member_of_anomaly($anomaly) {
        $user = get_user_by('id', $anomaly['user_id']);
        if (!$user) return;
        
        $subject = 'Action Required: ' . $anomaly['description'];
        
        $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
        $message .= '<p>We have detected an issue with your loan account that requires your attention:</p>';
        
        $message .= '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        $message .= '<h3 style="margin-top: 0; color: #dc3545;">Issue Details</h3>';
        $message .= '<p><strong>Type:</strong> ' . esc_html($anomaly['description']) . '</p>';
        $message .= '<p><strong>Details:</strong> ' . esc_html($anomaly['details']) . '</p>';
        $message .= '<p><strong>Recommended Action:</strong> ' . esc_html($anomaly['suggested_action']) . '</p>';
        $message .= '</div>';
        
        if ($anomaly['type'] === 'payment_overdue') {
            $message .= '<div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">';
            $message .= '<h4 style="margin-top: 0; color: #856404;">Payment Options</h4>';
            $message .= '<p>You can make your payment through:</p>';
            $message .= '<ul>';
            $message .= '<li>M-Pesa: Pay Bill 123456, Account: Your Member Number</li>';
            $message .= '<li>Bank Transfer: Account details in your member portal</li>';
            $message .= '<li>Visit any of our branch offices</li>';
            $message .= '</ul>';
            $message .= '</div>';
        }
        
        $message .= '<p>If you have any questions or need assistance resolving this issue, please contact us:</p>';
        $message .= '<ul>';
        $message .= '<li>Phone: +254 123 456 789</li>';
        $message .= '<li>Email: support@daystar.co.ke</li>';
        $message .= '<li>Visit: Any Daystar SACCO branch</li>';
        $message .= '</ul>';
        
        $message .= '<p>Thank you for your prompt attention to this matter.</p>';
        $message .= '<p>Best regards,<br>The Daystar Team</p>';
        
        daystar_send_email($user->user_email, $subject, $message);
        
        // Also create in-app notification
        global $wpdb;
        $notifications_table = $wpdb->prefix . 'daystar_notifications';
        
        $wpdb->insert($notifications_table, array(
            'user_id' => $anomaly['user_id'],
            'title' => $anomaly['description'],
            'message' => $anomaly['details'] . ' - ' . $anomaly['suggested_action'],
            'type' => 'anomaly_' . $anomaly['type'],
            'is_read' => 0,
            'created_at' => current_time('mysql')
        ));
    }
    
    /**
     * Process reconciliation anomalies
     */
    private static function process_reconciliation_anomalies($reconciliation_data) {
        foreach ($reconciliation_data as $item) {
            if ($item['status'] !== 'MATCHED' && abs($item['variance']) > 100) {
                $anomaly = array(
                    'type' => 'reconciliation_variance',
                    'severity' => abs($item['variance']) > 1000 ? 'high' : 'medium',
                    'loan_id' => $item['loan_id'],
                    'user_id' => self::get_user_id_by_loan($item['loan_id']),
                    'member_name' => $item['member_name'],
                    'description' => 'Payment reconciliation variance detected',
                    'details' => "Expected: KES " . number_format($item['expected_amount'], 2) . 
                               ", Actual: KES " . number_format($item['actual_amount'], 2) . 
                               ", Variance: KES " . number_format($item['variance'], 2),
                    'suggested_action' => $item['status'] === 'MISSING' ? 'Make overdue payment' : 'Contact SACCO for payment adjustment',
                    'detected_at' => current_time('mysql')
                );
                
                self::store_anomaly($anomaly);
                
                // Only notify for significant variances
                if (abs($item['variance']) > 500) {
                    self::notify_member_of_anomaly($anomaly);
                }
            }
        }
    }
    
    /**
     * Get user ID by loan ID
     */
    private static function get_user_id_by_loan($loan_id) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        return $wpdb->get_var($wpdb->prepare(
            "SELECT user_id FROM $loans_table WHERE id = %d",
            $loan_id
        ));
    }
    
    /**
     * Export deduction list to CSV
     */
    public static function export_deduction_list_csv($list_id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_deduction_lists';
        $list_data = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE list_id = %s",
            $list_id
        ));
        
        if (!$list_data) {
            return false;
        }
        
        $deduction_list = json_decode($list_data->deduction_data, true);
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="deduction_list_' . $list_id . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, array(
            'Member Number',
            'Employee Number',
            'Member Name',
            'Employer',
            'Department',
            'Payroll Number',
            'Loan Type',
            'Loan Amount',
            'Outstanding Balance',
            'Deduction Amount',
            'Due Date',
            'Installment Number',
            'Payment Status'
        ));
        
        // CSV data
        foreach ($deduction_list as $item) {
            fputcsv($output, array(
                $item['member_number'],
                $item['employee_number'],
                $item['member_name'],
                $item['employer'],
                $item['department'],
                $item['payroll_number'],
                $item['loan_type'],
                $item['loan_amount'],
                $item['outstanding_balance'],
                $item['deduction_amount'],
                $item['due_date'],
                $item['installment_number'],
                $item['payment_status']
            ));
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Create required database tables
     */
    private static function create_deduction_lists_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_deduction_lists';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            list_id varchar(50) NOT NULL,
            period_start date NOT NULL,
            period_end date NOT NULL,
            filters longtext,
            deduction_data longtext,
            generated_by bigint(20) NOT NULL,
            generated_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY list_id (list_id),
            KEY period_start (period_start),
            KEY generated_by (generated_by)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    private static function create_reconciliation_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_reconciliation_reports';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            report_id varchar(50) NOT NULL,
            period_start date NOT NULL,
            period_end date NOT NULL,
            reconciliation_data longtext,
            summary_data longtext,
            generated_by bigint(20) NOT NULL,
            generated_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY report_id (report_id),
            KEY period_start (period_start),
            KEY generated_by (generated_by)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    private static function create_anomalies_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_loan_anomalies';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            loan_id mediumint(9) NOT NULL,
            user_id bigint(20) NOT NULL,
            type varchar(50) NOT NULL,
            severity varchar(20) DEFAULT 'medium',
            description text NOT NULL,
            details text,
            suggested_action text,
            status varchar(20) DEFAULT 'open',
            resolved_by bigint(20) NULL,
            resolved_at datetime NULL,
            resolution_notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY loan_id (loan_id),
            KEY user_id (user_id),
            KEY type (type),
            KEY severity (severity),
            KEY status (status),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * AJAX handlers
     */
    public static function ajax_generate_deduction_list() {
        if (!wp_verify_nonce($_POST['nonce'], 'loan_recovery_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $period_start = sanitize_text_field($_POST['period_start']);
        $period_end = sanitize_text_field($_POST['period_end']);
        $filters = array();
        
        if (isset($_POST['employer'])) {
            $filters['employer'] = sanitize_text_field($_POST['employer']);
        }
        if (isset($_POST['loan_type'])) {
            $filters['loan_type'] = sanitize_text_field($_POST['loan_type']);
        }
        if (isset($_POST['department'])) {
            $filters['department'] = sanitize_text_field($_POST['department']);
        }
        
        $result = self::generate_deduction_list($period_start, $period_end, $filters);
        wp_send_json($result);
    }
    
    public static function ajax_run_reconciliation() {
        if (!wp_verify_nonce($_POST['nonce'], 'loan_recovery_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $period_start = sanitize_text_field($_POST['period_start']);
        $period_end = sanitize_text_field($_POST['period_end']);
        
        $result = self::run_reconciliation($period_start, $period_end);
        wp_send_json($result);
    }
    
    public static function ajax_resolve_anomaly() {
        if (!wp_verify_nonce($_POST['nonce'], 'loan_recovery_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        global $wpdb;
        
        $anomaly_id = intval($_POST['anomaly_id']);
        $resolution_notes = sanitize_textarea_field($_POST['resolution_notes']);
        
        $table_name = $wpdb->prefix . 'daystar_loan_anomalies';
        
        $updated = $wpdb->update(
            $table_name,
            array(
                'status' => 'resolved',
                'resolved_by' => get_current_user_id(),
                'resolved_at' => current_time('mysql'),
                'resolution_notes' => $resolution_notes
            ),
            array('id' => $anomaly_id),
            array('%s', '%d', '%s', '%s'),
            array('%d')
        );
        
        wp_send_json(array(
            'success' => $updated !== false,
            'message' => $updated ? 'Anomaly resolved successfully' : 'Failed to resolve anomaly'
        ));
    }
    
    public static function ajax_export_deduction_list() {
        if (!wp_verify_nonce($_GET['nonce'], 'loan_recovery_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $list_id = sanitize_text_field($_GET['list_id']);
        self::export_deduction_list_csv($list_id);
    }
    
    /**
     * Scheduled task handlers
     */
    public static function run_monthly_reconciliation() {
        $last_month_start = date('Y-m-01', strtotime('last month'));
        $last_month_end = date('Y-m-t', strtotime('last month'));
        
        self::run_reconciliation($last_month_start, $last_month_end);
    }
}

// Initialize the recovery handler
LoanRecoveryHandler::init();

/**
 * Helper functions
 */

/**
 * Get available employers for filtering
 */
function get_available_employers() {
    global $wpdb;
    
    $usermeta_table = $wpdb->usermeta;
    
    $employers = $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM $usermeta_table 
        WHERE meta_key = 'employer' 
        AND meta_value != '' 
        ORDER BY meta_value
    ");
    
    return $employers;
}

/**
 * Get available departments for filtering
 */
function get_available_departments() {
    global $wpdb;
    
    $usermeta_table = $wpdb->usermeta;
    
    $departments = $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM $usermeta_table 
        WHERE meta_key = 'department' 
        AND meta_value != '' 
        ORDER BY meta_value
    ");
    
    return $departments;
}

/**
 * Get loan recovery statistics
 */
function get_loan_recovery_statistics($period_start = null, $period_end = null) {
    global $wpdb;
    
    if (!$period_start) {
        $period_start = date('Y-m-01');
    }
    if (!$period_end) {
        $period_end = date('Y-m-t');
    }
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    $stats = $wpdb->get_row($wpdb->prepare("
        SELECT 
            COUNT(DISTINCT ls.loan_id) as total_loans,
            SUM(ls.expected_total) as total_expected,
            COALESCE(SUM(lp.amount), 0) as total_collected,
            (SUM(ls.expected_total) - COALESCE(SUM(lp.amount), 0)) as total_variance,
            COUNT(CASE WHEN ls.status = 'overdue' THEN 1 END) as overdue_count
        FROM $schedules_table ls
        LEFT JOIN $payments_table lp ON (ls.loan_id = lp.loan_id AND DATE(lp.payment_date) BETWEEN %s AND %s)
        WHERE ls.due_date BETWEEN %s AND %s
    ", $period_start, $period_end, $period_start, $period_end));
    
    return $stats;
}