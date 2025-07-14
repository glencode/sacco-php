<?php
/**
 * Sample Reports Data Generator
 * Generates sample data for testing the reporting system
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate sample loan data for testing reports
 */
function daystar_generate_sample_loan_data() {
    global $wpdb;
    
    // Check if we already have sample data
    $existing_loans = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans");
    if ($existing_loans > 10) {
        return; // Already have data
    }
    
    // Get sample users
    $users = get_users(array('number' => 20));
    if (empty($users)) {
        return; // No users to work with
    }
    
    $loan_types = array('Development Loan', 'School Fees Loan', 'Emergency Loan', 'Special Loan', 'Salary Advance');
    $statuses = array('pending', 'approved', 'active', 'completed', 'declined');
    $delinquency_statuses = array('current', '1-30', '31-60', '61-90', '90+');
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $payments_table = $wpdb->prefix . 'daystar_loan_payments';
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    // Generate sample loans
    for ($i = 0; $i < 50; $i++) {
        $user = $users[array_rand($users)];
        $loan_type = $loan_types[array_rand($loan_types)];
        $status = $statuses[array_rand($statuses)];
        $amount = rand(10000, 500000);
        $balance = $status === 'active' ? $amount * (rand(20, 80) / 100) : 0;
        $interest_rate = 12.00;
        $term_months = rand(6, 36);
        $monthly_payment = ($amount * ($interest_rate / 100 / 12)) / (1 - pow(1 + ($interest_rate / 100 / 12), -$term_months));
        
        // Random dates within the last 2 years
        $loan_date = date('Y-m-d H:i:s', strtotime('-' . rand(1, 730) . ' days'));
        $approved_date = $status !== 'pending' ? date('Y-m-d H:i:s', strtotime($loan_date . ' +' . rand(1, 30) . ' days')) : null;
        $disbursed_date = in_array($status, ['active', 'completed']) ? $approved_date : null;
        
        // Delinquency status for active loans
        $delinquency_status = 'current';
        $days_overdue = 0;
        if ($status === 'active' && rand(1, 100) <= 25) { // 25% chance of delinquency
            $delinquency_status = $delinquency_statuses[array_rand(array_slice($delinquency_statuses, 1))];
            $days_overdue = rand(1, 120);
        }
        
        $wpdb->insert($loans_table, array(
            'user_id' => $user->ID,
            'loan_type' => $loan_type,
            'amount' => $amount,
            'balance' => $balance,
            'interest_rate' => $interest_rate,
            'term_months' => $term_months,
            'monthly_payment' => $monthly_payment,
            'loan_date' => $loan_date,
            'due_date' => date('Y-m-d', strtotime($loan_date . ' +' . $term_months . ' months')),
            'status' => $status,
            'purpose' => 'Sample loan for testing',
            'approved_date' => $approved_date,
            'disbursed_date' => $disbursed_date,
            'delinquency_status' => $delinquency_status,
            'days_overdue' => $days_overdue,
            'eligibility_score' => rand(60, 100),
            'priority_score' => rand(50, 90),
            'application_waiting_number' => 'APP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT)
        ));
        
        $loan_id = $wpdb->insert_id;
        
        // Generate sample payments for active/completed loans
        if (in_array($status, ['active', 'completed'])) {
            $payments_made = rand(1, $term_months);
            for ($j = 0; $j < $payments_made; $j++) {
                $payment_date = date('Y-m-d H:i:s', strtotime($disbursed_date . ' +' . ($j + 1) . ' months'));
                $principal_amount = $monthly_payment * 0.7; // Rough estimate
                $interest_amount = $monthly_payment * 0.3;
                
                $wpdb->insert($payments_table, array(
                    'loan_id' => $loan_id,
                    'user_id' => $user->ID,
                    'amount' => $monthly_payment,
                    'principal_amount' => $principal_amount,
                    'interest_amount' => $interest_amount,
                    'payment_date' => $payment_date,
                    'payment_method' => rand(1, 2) === 1 ? 'bank_transfer' : 'cash',
                    'reference_number' => 'PAY' . time() . rand(100, 999),
                    'status' => 'completed',
                    'is_payroll_deduction' => rand(1, 3) === 1 ? 1 : 0
                ));
            }
        }
    }
    
    // Generate sample contributions
    foreach ($users as $user) {
        // Share capital contribution
        $wpdb->insert($contributions_table, array(
            'user_id' => $user->ID,
            'amount' => rand(5000, 20000),
            'contribution_type' => 'share_capital',
            'is_share_capital' => 1,
            'contribution_date' => date('Y-m-d H:i:s', strtotime('-' . rand(30, 365) . ' days')),
            'status' => 'completed',
            'payment_method' => 'bank_transfer',
            'reference_number' => 'SC' . time() . rand(100, 999)
        ));
        
        // Monthly contributions
        for ($i = 0; $i < rand(3, 12); $i++) {
            $wpdb->insert($contributions_table, array(
                'user_id' => $user->ID,
                'amount' => rand(1000, 5000),
                'contribution_type' => 'monthly',
                'is_share_capital' => 0,
                'contribution_date' => date('Y-m-d H:i:s', strtotime('-' . ($i * 30) . ' days')),
                'status' => 'completed',
                'payment_method' => rand(1, 2) === 1 ? 'bank_transfer' : 'mpesa',
                'reference_number' => 'CON' . time() . rand(100, 999)
            ));
        }
    }
}

/**
 * Generate sample disbursement data
 */
function daystar_generate_sample_disbursement_data() {
    global $wpdb;
    
    $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
    
    // Get active and completed loans that don't have disbursement records
    $loans = $wpdb->get_results("
        SELECT l.id, l.user_id, l.amount 
        FROM {$wpdb->prefix}daystar_loans l 
        LEFT JOIN {$disbursements_table} d ON l.id = d.loan_id 
        WHERE l.status IN ('active', 'completed') 
        AND d.id IS NULL 
        LIMIT 30
    ");
    
    $disbursement_methods = array('bank_transfer', 'cheque', 'cash', 'mobile_money');
    
    foreach ($loans as $loan) {
        $method = $disbursement_methods[array_rand($disbursement_methods)];
        
        $wpdb->insert($disbursements_table, array(
            'loan_id' => $loan->id,
            'disbursement_method' => $method,
            'disbursement_reference' => strtoupper($method) . time() . rand(100, 999),
            'disbursement_details' => json_encode(array(
                'account_number' => '1234567890',
                'bank_name' => 'Sample Bank',
                'branch' => 'Main Branch'
            )),
            'status' => 'completed',
            'disbursed_by' => 1,
            'disbursed_date' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 365) . ' days')),
            'recipient_confirmation' => rand(1, 10) <= 8 ? 1 : 0, // 80% confirmed
            'recipient_confirmation_date' => date('Y-m-d H:i:s')
        ));
    }
}

/**
 * Initialize sample data if needed
 */
function daystar_init_sample_reports_data() {
    // Only generate sample data in development/testing environments
    if (defined('WP_DEBUG') && WP_DEBUG) {
        daystar_generate_sample_loan_data();
        daystar_generate_sample_disbursement_data();
    }
}

// Hook to generate sample data
add_action('admin_init', 'daystar_init_sample_reports_data');

/**
 * Add admin notice about sample data
 */
function daystar_sample_data_admin_notice() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        global $wpdb;
        $loan_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans");
        
        if ($loan_count > 0) {
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p><strong>Daystar SACCO:</strong> Sample reporting data has been generated for testing. ';
            echo 'You can view the reports under <a href="' . admin_url('admin.php?page=daystar-reports') . '">Reports</a>.</p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'daystar_sample_data_admin_notice');