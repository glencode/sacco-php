<?php
/**
 * Reporting System
 * Comprehensive reporting functionality for Daystar SACCO
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling all reporting functionality
 */
class DaystarReporting {
    
    /**
     * Get loan application status report
     */
    public static function get_loan_application_status_report($filters = array()) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause based on filters
        $where_conditions = array('1=1');
        $params = array();
        
        if (!empty($filters['date_from'])) {
            $where_conditions[] = "l.loan_date >= %s";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $where_conditions[] = "l.loan_date <= %s";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        if (!empty($filters['status'])) {
            $where_conditions[] = "l.status = %s";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['loan_type'])) {
            $where_conditions[] = "l.loan_type = %s";
            $params[] = $filters['loan_type'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                l.id,
                l.user_id,
                u.display_name,
                um.meta_value as member_number,
                l.loan_type,
                l.amount,
                l.status,
                l.loan_date,
                l.approved_date,
                l.disbursed_date,
                l.rejection_reason,
                l.application_waiting_number,
                DATEDIFF(COALESCE(l.approved_date, l.disbursed_date, NOW()), l.loan_date) as processing_days
            FROM {$loans_table} l
            LEFT JOIN {$users_table} u ON l.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            WHERE {$where_clause}
            ORDER BY l.loan_date DESC
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Calculate summary statistics
        $summary = array(
            'total_applications' => count($results),
            'pending' => 0,
            'approved' => 0,
            'declined' => 0,
            'active' => 0,
            'completed' => 0,
            'appealed' => 0,
            'avg_processing_days' => 0,
            'total_amount_applied' => 0,
            'total_amount_approved' => 0
        );
        
        $processing_days_sum = 0;
        $processing_days_count = 0;
        
        foreach ($results as $loan) {
            $summary['total_amount_applied'] += $loan['amount'];
            
            switch ($loan['status']) {
                case 'pending':
                    $summary['pending']++;
                    break;
                case 'approved':
                    $summary['approved']++;
                    $summary['total_amount_approved'] += $loan['amount'];
                    break;
                case 'declined':
                    $summary['declined']++;
                    break;
                case 'active':
                    $summary['active']++;
                    $summary['total_amount_approved'] += $loan['amount'];
                    break;
                case 'completed':
                    $summary['completed']++;
                    $summary['total_amount_approved'] += $loan['amount'];
                    break;
                case 'appealed':
                    $summary['appealed']++;
                    break;
            }
            
            if ($loan['processing_days'] > 0) {
                $processing_days_sum += $loan['processing_days'];
                $processing_days_count++;
            }
        }
        
        if ($processing_days_count > 0) {
            $summary['avg_processing_days'] = round($processing_days_sum / $processing_days_count, 1);
        }
        
        return array(
            'data' => $results,
            'summary' => $summary
        );
    }
    
    /**
     * Get loan disbursement report
     */
    public static function get_loan_disbursement_report($filters = array()) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause
        $where_conditions = array("l.status IN ('active', 'completed')", "l.disbursed_date IS NOT NULL");
        $params = array();
        
        if (!empty($filters['date_from'])) {
            $where_conditions[] = "l.disbursed_date >= %s";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $where_conditions[] = "l.disbursed_date <= %s";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        if (!empty($filters['loan_type'])) {
            $where_conditions[] = "l.loan_type = %s";
            $params[] = $filters['loan_type'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                l.id,
                l.user_id,
                u.display_name,
                um.meta_value as member_number,
                l.loan_type,
                l.amount,
                l.disbursed_date,
                d.disbursement_method,
                d.disbursement_reference,
                d.status as disbursement_status,
                d.disbursed_by,
                d.recipient_confirmation
            FROM {$loans_table} l
            LEFT JOIN {$users_table} u ON l.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            LEFT JOIN {$disbursements_table} d ON l.id = d.loan_id
            WHERE {$where_clause}
            ORDER BY l.disbursed_date DESC
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Calculate summary
        $summary = array(
            'total_disbursements' => count($results),
            'total_amount_disbursed' => 0,
            'by_method' => array(),
            'by_loan_type' => array(),
            'confirmed_disbursements' => 0,
            'pending_confirmation' => 0
        );
        
        foreach ($results as $disbursement) {
            $summary['total_amount_disbursed'] += $disbursement['amount'];
            
            // Group by disbursement method
            $method = $disbursement['disbursement_method'] ?: 'Unknown';
            if (!isset($summary['by_method'][$method])) {
                $summary['by_method'][$method] = array('count' => 0, 'amount' => 0);
            }
            $summary['by_method'][$method]['count']++;
            $summary['by_method'][$method]['amount'] += $disbursement['amount'];
            
            // Group by loan type
            $type = $disbursement['loan_type'];
            if (!isset($summary['by_loan_type'][$type])) {
                $summary['by_loan_type'][$type] = array('count' => 0, 'amount' => 0);
            }
            $summary['by_loan_type'][$type]['count']++;
            $summary['by_loan_type'][$type]['amount'] += $disbursement['amount'];
            
            // Confirmation status
            if ($disbursement['recipient_confirmation']) {
                $summary['confirmed_disbursements']++;
            } else {
                $summary['pending_confirmation']++;
            }
        }
        
        return array(
            'data' => $results,
            'summary' => $summary
        );
    }
    
    /**
     * Get loan repayment report
     */
    public static function get_loan_repayment_report($filters = array()) {
        global $wpdb;
        
        $payments_table = $wpdb->prefix . 'daystar_loan_payments';
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause
        $where_conditions = array('1=1');
        $params = array();
        
        if (!empty($filters['date_from'])) {
            $where_conditions[] = "p.payment_date >= %s";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $where_conditions[] = "p.payment_date <= %s";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        if (!empty($filters['loan_type'])) {
            $where_conditions[] = "l.loan_type = %s";
            $params[] = $filters['loan_type'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                p.id,
                p.loan_id,
                p.user_id,
                u.display_name,
                um.meta_value as member_number,
                l.loan_type,
                l.amount as loan_amount,
                p.amount as payment_amount,
                p.principal_amount,
                p.interest_amount,
                p.payment_date,
                p.payment_method,
                p.reference_number,
                p.is_payroll_deduction
            FROM {$payments_table} p
            LEFT JOIN {$loans_table} l ON p.loan_id = l.id
            LEFT JOIN {$users_table} u ON p.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            WHERE {$where_clause}
            ORDER BY p.payment_date DESC
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Get expected vs actual summary
        $expected_query = "
            SELECT 
                SUM(s.expected_total) as total_expected,
                SUM(s.expected_principal) as expected_principal,
                SUM(s.expected_interest) as expected_interest,
                COUNT(*) as total_installments
            FROM {$schedules_table} s
            LEFT JOIN {$loans_table} l ON s.loan_id = l.id
            WHERE s.due_date BETWEEN %s AND %s
        ";
        
        $date_from = !empty($filters['date_from']) ? $filters['date_from'] : date('Y-m-01');
        $date_to = !empty($filters['date_to']) ? $filters['date_to'] : date('Y-m-t');
        
        $expected_data = $wpdb->get_row($wpdb->prepare($expected_query, $date_from, $date_to), ARRAY_A);
        
        // Calculate summary
        $summary = array(
            'total_payments' => count($results),
            'total_amount_paid' => 0,
            'total_principal_paid' => 0,
            'total_interest_paid' => 0,
            'expected_total' => $expected_data['total_expected'] ?: 0,
            'expected_principal' => $expected_data['expected_principal'] ?: 0,
            'expected_interest' => $expected_data['expected_interest'] ?: 0,
            'collection_rate' => 0,
            'by_payment_method' => array(),
            'payroll_deductions' => 0,
            'manual_payments' => 0
        );
        
        foreach ($results as $payment) {
            $summary['total_amount_paid'] += $payment['payment_amount'];
            $summary['total_principal_paid'] += $payment['principal_amount'];
            $summary['total_interest_paid'] += $payment['interest_amount'];
            
            // Group by payment method
            $method = $payment['payment_method'];
            if (!isset($summary['by_payment_method'][$method])) {
                $summary['by_payment_method'][$method] = array('count' => 0, 'amount' => 0);
            }
            $summary['by_payment_method'][$method]['count']++;
            $summary['by_payment_method'][$method]['amount'] += $payment['payment_amount'];
            
            // Payroll vs manual
            if ($payment['is_payroll_deduction']) {
                $summary['payroll_deductions']++;
            } else {
                $summary['manual_payments']++;
            }
        }
        
        // Calculate collection rate
        if ($summary['expected_total'] > 0) {
            $summary['collection_rate'] = round(($summary['total_amount_paid'] / $summary['expected_total']) * 100, 2);
        }
        
        return array(
            'data' => $results,
            'summary' => $summary
        );
    }
    
    /**
     * Get loan delinquency report
     */
    public static function get_loan_delinquency_report($filters = array()) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause
        $where_conditions = array("l.status = 'active'", "l.delinquency_status != 'current'");
        $params = array();
        
        if (!empty($filters['delinquency_status'])) {
            $where_conditions[] = "l.delinquency_status = %s";
            $params[] = $filters['delinquency_status'];
        }
        
        if (!empty($filters['min_days_overdue'])) {
            $where_conditions[] = "l.days_overdue >= %d";
            $params[] = $filters['min_days_overdue'];
        }
        
        if (!empty($filters['loan_type'])) {
            $where_conditions[] = "l.loan_type = %s";
            $params[] = $filters['loan_type'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                l.id,
                l.user_id,
                u.display_name,
                um.meta_value as member_number,
                l.loan_type,
                l.amount as loan_amount,
                l.balance as outstanding_balance,
                l.delinquency_status,
                l.days_overdue,
                l.monthly_payment,
                l.last_delinquency_check,
                (SELECT SUM(s.expected_total - s.amount_paid) 
                 FROM {$schedules_table} s 
                 WHERE s.loan_id = l.id AND s.due_date < CURDATE() AND s.status != 'paid') as overdue_amount
            FROM {$loans_table} l
            LEFT JOIN {$users_table} u ON l.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            WHERE {$where_clause}
            ORDER BY l.days_overdue DESC, l.delinquency_status
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Calculate summary by delinquency categories
        $summary = array(
            'total_delinquent_loans' => count($results),
            'total_overdue_amount' => 0,
            'total_outstanding_balance' => 0,
            'by_category' => array(
                '1-30 days' => array('count' => 0, 'amount' => 0, 'balance' => 0),
                '31-60 days' => array('count' => 0, 'amount' => 0, 'balance' => 0),
                '61-90 days' => array('count' => 0, 'amount' => 0, 'balance' => 0),
                '90+ days' => array('count' => 0, 'amount' => 0, 'balance' => 0)
            ),
            'by_loan_type' => array()
        );
        
        foreach ($results as $loan) {
            $overdue_amount = $loan['overdue_amount'] ?: 0;
            $outstanding_balance = $loan['outstanding_balance'];
            
            $summary['total_overdue_amount'] += $overdue_amount;
            $summary['total_outstanding_balance'] += $outstanding_balance;
            
            // Categorize by days overdue
            $days_overdue = $loan['days_overdue'];
            if ($days_overdue <= 30) {
                $category = '1-30 days';
            } elseif ($days_overdue <= 60) {
                $category = '31-60 days';
            } elseif ($days_overdue <= 90) {
                $category = '61-90 days';
            } else {
                $category = '90+ days';
            }
            
            $summary['by_category'][$category]['count']++;
            $summary['by_category'][$category]['amount'] += $overdue_amount;
            $summary['by_category'][$category]['balance'] += $outstanding_balance;
            
            // Group by loan type
            $type = $loan['loan_type'];
            if (!isset($summary['by_loan_type'][$type])) {
                $summary['by_loan_type'][$type] = array('count' => 0, 'amount' => 0, 'balance' => 0);
            }
            $summary['by_loan_type'][$type]['count']++;
            $summary['by_loan_type'][$type]['amount'] += $overdue_amount;
            $summary['by_loan_type'][$type]['balance'] += $outstanding_balance;
        }
        
        return array(
            'data' => $results,
            'summary' => $summary
        );
    }
    
    /**
     * Get member loan history report
     */
    public static function get_member_loan_history_report($filters = array()) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $payments_table = $wpdb->prefix . 'daystar_loan_payments';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause
        $where_conditions = array('1=1');
        $params = array();
        
        if (!empty($filters['user_id'])) {
            $where_conditions[] = "l.user_id = %d";
            $params[] = $filters['user_id'];
        }
        
        if (!empty($filters['member_number'])) {
            $where_conditions[] = "um.meta_value = %s";
            $params[] = $filters['member_number'];
        }
        
        if (!empty($filters['loan_type'])) {
            $where_conditions[] = "l.loan_type = %s";
            $params[] = $filters['loan_type'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                l.id,
                l.user_id,
                u.display_name,
                um.meta_value as member_number,
                l.loan_type,
                l.amount,
                l.balance,
                l.interest_rate,
                l.term_months,
                l.monthly_payment,
                l.loan_date,
                l.status,
                l.approved_date,
                l.disbursed_date,
                (SELECT SUM(p.amount) FROM {$payments_table} p WHERE p.loan_id = l.id) as total_paid,
                (SELECT COUNT(*) FROM {$payments_table} p WHERE p.loan_id = l.id) as payment_count
            FROM {$loans_table} l
            LEFT JOIN {$users_table} u ON l.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            WHERE {$where_clause}
            ORDER BY l.user_id, l.loan_date DESC
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Group by member and calculate summary
        $grouped_data = array();
        $summary = array(
            'total_members' => 0,
            'total_loans' => count($results),
            'total_amount_borrowed' => 0,
            'total_amount_paid' => 0,
            'total_outstanding' => 0,
            'active_loans' => 0,
            'completed_loans' => 0
        );
        
        foreach ($results as $loan) {
            $user_id = $loan['user_id'];
            
            if (!isset($grouped_data[$user_id])) {
                $grouped_data[$user_id] = array(
                    'member_info' => array(
                        'user_id' => $user_id,
                        'display_name' => $loan['display_name'],
                        'member_number' => $loan['member_number']
                    ),
                    'loans' => array(),
                    'summary' => array(
                        'total_loans' => 0,
                        'total_borrowed' => 0,
                        'total_paid' => 0,
                        'current_balance' => 0,
                        'active_loans' => 0
                    )
                );
                $summary['total_members']++;
            }
            
            $grouped_data[$user_id]['loans'][] = $loan;
            $grouped_data[$user_id]['summary']['total_loans']++;
            $grouped_data[$user_id]['summary']['total_borrowed'] += $loan['amount'];
            $grouped_data[$user_id]['summary']['total_paid'] += $loan['total_paid'] ?: 0;
            
            if ($loan['status'] === 'active') {
                $grouped_data[$user_id]['summary']['current_balance'] += $loan['balance'];
                $grouped_data[$user_id]['summary']['active_loans']++;
                $summary['active_loans']++;
            } elseif ($loan['status'] === 'completed') {
                $summary['completed_loans']++;
            }
            
            $summary['total_amount_borrowed'] += $loan['amount'];
            $summary['total_amount_paid'] += $loan['total_paid'] ?: 0;
            $summary['total_outstanding'] += $loan['balance'];
        }
        
        return array(
            'data' => $grouped_data,
            'summary' => $summary
        );
    }
    
    /**
     * Get member contribution report
     */
    public static function get_member_contribution_report($filters = array()) {
        global $wpdb;
        
        $contributions_table = $wpdb->prefix . 'daystar_contributions';
        $users_table = $wpdb->prefix . 'users';
        $usermeta_table = $wpdb->prefix . 'usermeta';
        
        // Build WHERE clause
        $where_conditions = array('1=1');
        $params = array();
        
        if (!empty($filters['date_from'])) {
            $where_conditions[] = "c.contribution_date >= %s";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $where_conditions[] = "c.contribution_date <= %s";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        if (!empty($filters['contribution_type'])) {
            $where_conditions[] = "c.contribution_type = %s";
            $params[] = $filters['contribution_type'];
        }
        
        if (isset($filters['is_share_capital'])) {
            $where_conditions[] = "c.is_share_capital = %d";
            $params[] = $filters['is_share_capital'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $query = "
            SELECT 
                c.id,
                c.user_id,
                u.display_name,
                um.meta_value as member_number,
                c.amount,
                c.contribution_type,
                c.is_share_capital,
                c.contribution_date,
                c.payment_method,
                c.reference_number,
                c.status
            FROM {$contributions_table} c
            LEFT JOIN {$users_table} u ON c.user_id = u.ID
            LEFT JOIN {$usermeta_table} um ON u.ID = um.user_id AND um.meta_key = 'member_number'
            WHERE {$where_clause}
            ORDER BY c.contribution_date DESC
        ";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $results = $wpdb->get_results($query, ARRAY_A);
        
        // Calculate summary
        $summary = array(
            'total_contributions' => count($results),
            'total_amount' => 0,
            'share_capital_total' => 0,
            'savings_total' => 0,
            'by_type' => array(),
            'by_payment_method' => array(),
            'monthly_breakdown' => array()
        );
        
        foreach ($results as $contribution) {
            $summary['total_amount'] += $contribution['amount'];
            
            if ($contribution['is_share_capital']) {
                $summary['share_capital_total'] += $contribution['amount'];
            } else {
                $summary['savings_total'] += $contribution['amount'];
            }
            
            // Group by contribution type
            $type = $contribution['contribution_type'];
            if (!isset($summary['by_type'][$type])) {
                $summary['by_type'][$type] = array('count' => 0, 'amount' => 0);
            }
            $summary['by_type'][$type]['count']++;
            $summary['by_type'][$type]['amount'] += $contribution['amount'];
            
            // Group by payment method
            $method = $contribution['payment_method'];
            if (!isset($summary['by_payment_method'][$method])) {
                $summary['by_payment_method'][$method] = array('count' => 0, 'amount' => 0);
            }
            $summary['by_payment_method'][$method]['count']++;
            $summary['by_payment_method'][$method]['amount'] += $contribution['amount'];
            
            // Monthly breakdown
            $month = date('Y-m', strtotime($contribution['contribution_date']));
            if (!isset($summary['monthly_breakdown'][$month])) {
                $summary['monthly_breakdown'][$month] = array('count' => 0, 'amount' => 0);
            }
            $summary['monthly_breakdown'][$month]['count']++;
            $summary['monthly_breakdown'][$month]['amount'] += $contribution['amount'];
        }
        
        return array(
            'data' => $results,
            'summary' => $summary
        );
    }
    
    /**
     * Get financial summary report
     */
    public static function get_financial_summary_report($filters = array()) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $payments_table = $wpdb->prefix . 'daystar_loan_payments';
        $contributions_table = $wpdb->prefix . 'daystar_contributions';
        
        $date_from = !empty($filters['date_from']) ? $filters['date_from'] : date('Y-01-01');
        $date_to = !empty($filters['date_to']) ? $filters['date_to'] : date('Y-12-31');
        
        // Loan portfolio summary
        $loan_portfolio = $wpdb->get_row($wpdb->prepare("
            SELECT 
                COUNT(*) as total_loans,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_loans,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_loans,
                SUM(amount) as total_disbursed,
                SUM(CASE WHEN status = 'active' THEN balance ELSE 0 END) as total_outstanding,
                SUM(CASE WHEN status = 'active' AND delinquency_status != 'current' THEN balance ELSE 0 END) as delinquent_balance
            FROM {$loans_table}
            WHERE disbursed_date BETWEEN %s AND %s
        ", $date_from, $date_to . ' 23:59:59'), ARRAY_A);
        
        // Repayment summary
        $repayment_summary = $wpdb->get_row($wpdb->prepare("
            SELECT 
                COUNT(*) as total_payments,
                SUM(amount) as total_collected,
                SUM(principal_amount) as principal_collected,
                SUM(interest_amount) as interest_collected
            FROM {$payments_table}
            WHERE payment_date BETWEEN %s AND %s
        ", $date_from, $date_to . ' 23:59:59'), ARRAY_A);
        
        // Contribution summary
        $contribution_summary = $wpdb->get_row($wpdb->prepare("
            SELECT 
                COUNT(*) as total_contributions,
                SUM(amount) as total_amount,
                SUM(CASE WHEN is_share_capital = 1 THEN amount ELSE 0 END) as share_capital,
                SUM(CASE WHEN is_share_capital = 0 THEN amount ELSE 0 END) as savings
            FROM {$contributions_table}
            WHERE contribution_date BETWEEN %s AND %s
        ", $date_from, $date_to . ' 23:59:59'), ARRAY_A);
        
        // Monthly trends
        $monthly_trends = $wpdb->get_results($wpdb->prepare("
            SELECT 
                DATE_FORMAT(disbursed_date, '%%Y-%%m') as month,
                COUNT(*) as loans_disbursed,
                SUM(amount) as amount_disbursed
            FROM {$loans_table}
            WHERE disbursed_date BETWEEN %s AND %s
            GROUP BY DATE_FORMAT(disbursed_date, '%%Y-%%m')
            ORDER BY month
        ", $date_from, $date_to . ' 23:59:59'), ARRAY_A);
        
        // Portfolio quality indicators
        $portfolio_quality = array();
        if ($loan_portfolio['total_outstanding'] > 0) {
            $portfolio_quality['delinquency_rate'] = round(($loan_portfolio['delinquent_balance'] / $loan_portfolio['total_outstanding']) * 100, 2);
        } else {
            $portfolio_quality['delinquency_rate'] = 0;
        }
        
        if ($loan_portfolio['total_disbursed'] > 0) {
            $portfolio_quality['collection_rate'] = round(($repayment_summary['total_collected'] / $loan_portfolio['total_disbursed']) * 100, 2);
        } else {
            $portfolio_quality['collection_rate'] = 0;
        }
        
        return array(
            'loan_portfolio' => $loan_portfolio,
            'repayment_summary' => $repayment_summary,
            'contribution_summary' => $contribution_summary,
            'monthly_trends' => $monthly_trends,
            'portfolio_quality' => $portfolio_quality,
            'period' => array(
                'from' => $date_from,
                'to' => $date_to
            )
        );
    }
    
    /**
     * Export report data to CSV
     */
    public static function export_to_csv($data, $filename, $headers = array()) {
        if (empty($data)) {
            return false;
        }
        
        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
        // Write headers
        if (!empty($headers)) {
            fputcsv($output, $headers);
        } else {
            // Use first row keys as headers
            fputcsv($output, array_keys($data[0]));
        }
        
        // Write data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Get available loan types for filtering
     */
    public static function get_loan_types() {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        
        $results = $wpdb->get_col("
            SELECT DISTINCT loan_type 
            FROM {$loans_table} 
            WHERE loan_type IS NOT NULL AND loan_type != ''
            ORDER BY loan_type
        ");
        
        return $results;
    }
    
    /**
     * Get available delinquency statuses
     */
    public static function get_delinquency_statuses() {
        return array(
            'current' => 'Current',
            '1-30' => '1-30 Days Overdue',
            '31-60' => '31-60 Days Overdue', 
            '61-90' => '61-90 Days Overdue',
            '90+' => '90+ Days Overdue'
        );
    }
}