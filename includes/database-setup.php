<?php
/**
 * Database Setup Functions
 * Creates necessary tables for the SACCO system
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create all necessary database tables
 */
function daystar_create_database_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Contributions table
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    $contributions_sql = "CREATE TABLE $contributions_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        amount decimal(10,2) NOT NULL,
        contribution_type varchar(50) DEFAULT 'monthly',
        is_share_capital tinyint(1) DEFAULT 0,
        contribution_date datetime DEFAULT CURRENT_TIMESTAMP,
        status varchar(20) DEFAULT 'completed',
        payment_method varchar(50) DEFAULT 'bank_transfer',
        reference_number varchar(100),
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY contribution_date (contribution_date),
        KEY status (status),
        KEY is_share_capital (is_share_capital)
    ) $charset_collate;";
    
    // Loans table
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loans_sql = "CREATE TABLE $loans_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        loan_type varchar(50) NOT NULL,
        amount decimal(10,2) NOT NULL,
        balance decimal(10,2) NOT NULL,
        interest_rate decimal(5,2) DEFAULT 12.00,
        term_months int(11) DEFAULT 12,
        monthly_payment decimal(10,2),
        loan_date datetime DEFAULT CURRENT_TIMESTAMP,
        due_date date,
        status varchar(20) DEFAULT 'pending',
        purpose text,
        payslip_verified tinyint(1) DEFAULT 0,
        payslip_data_id mediumint(9) NULL,
        eligibility_score int(3) DEFAULT 0,
        risk_assessment varchar(20) DEFAULT 'medium',
        priority_score int(3) DEFAULT 0,
        application_waiting_number varchar(50),
        deadline_note text,
        approved_by bigint(20),
        approved_date datetime,
        disbursed_date datetime,
        rejection_reason text,
        application_notes text,
        is_staff_loan tinyint(1) DEFAULT 0,
        staff_type varchar(50) NULL,
        is_willful_failure tinyint(1) DEFAULT 0,
        willful_failure_date datetime NULL,
        willful_failure_notes text,
        delinquency_status varchar(50) DEFAULT 'current',
        days_overdue int(11) DEFAULT 0,
        last_delinquency_check datetime NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY loan_date (loan_date),
        KEY status (status),
        KEY due_date (due_date),
        KEY payslip_verified (payslip_verified),
        KEY eligibility_score (eligibility_score),
        KEY risk_assessment (risk_assessment),
        KEY priority_score (priority_score),
        KEY application_waiting_number (application_waiting_number),
        KEY is_staff_loan (is_staff_loan),
        KEY staff_type (staff_type),
        KEY delinquency_status (delinquency_status),
        KEY days_overdue (days_overdue),
        KEY last_delinquency_check (last_delinquency_check)
    ) $charset_collate;";
    
    // Loan payments table
    $loan_payments_table = $wpdb->prefix . 'daystar_loan_payments';
    $loan_payments_sql = "CREATE TABLE $loan_payments_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        user_id bigint(20) NOT NULL,
        amount decimal(10,2) NOT NULL,
        principal_amount decimal(10,2) NOT NULL,
        interest_amount decimal(10,2) NOT NULL,
        payment_date datetime DEFAULT CURRENT_TIMESTAMP,
        payment_method varchar(50) DEFAULT 'bank_transfer',
        reference_number varchar(100),
        status varchar(20) DEFAULT 'completed',
        notes text,
        receipt_path varchar(255),
        is_payroll_deduction tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY user_id (user_id),
        KEY payment_date (payment_date),
        KEY payment_method (payment_method),
        KEY is_payroll_deduction (is_payroll_deduction)
    ) $charset_collate;";
    
    // Loan schedules table
    $loan_schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    $loan_schedules_sql = "CREATE TABLE $loan_schedules_table (
        schedule_id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        installment_number int(11) NOT NULL,
        due_date date NOT NULL,
        expected_principal decimal(10,2) NOT NULL,
        expected_interest decimal(10,2) NOT NULL,
        expected_total decimal(10,2) NOT NULL,
        status varchar(20) DEFAULT 'due',
        amount_paid decimal(10,2) DEFAULT 0.00,
        payment_date datetime NULL,
        days_overdue int(11) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (schedule_id),
        KEY loan_id (loan_id),
        KEY due_date (due_date),
        KEY status (status),
        KEY installment_number (installment_number),
        KEY days_overdue (days_overdue),
        UNIQUE KEY unique_loan_installment (loan_id, installment_number)
    ) $charset_collate;";
    
    // Notifications table
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    $notifications_sql = "CREATE TABLE $notifications_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        title varchar(255) NOT NULL,
        message text NOT NULL,
        type varchar(50) DEFAULT 'info',
        is_read tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        read_at datetime NULL,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY is_read (is_read),
        KEY created_at (created_at)
    ) $charset_collate;";
    
    // Share transfers table
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    $share_transfers_sql = "CREATE TABLE $share_transfers_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        from_user_id bigint(20) NOT NULL,
        to_user_id bigint(20) NOT NULL,
        share_amount decimal(10,2) NOT NULL,
        transfer_reason text,
        status varchar(20) DEFAULT 'pending',
        requested_date datetime DEFAULT CURRENT_TIMESTAMP,
        approved_by bigint(20) NULL,
        approved_date datetime NULL,
        processed_date datetime NULL,
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY from_user_id (from_user_id),
        KEY to_user_id (to_user_id),
        KEY status (status),
        KEY requested_date (requested_date)
    ) $charset_collate;";
    
    // Guarantors table
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    $guarantors_sql = "CREATE TABLE $guarantors_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        guaranteed_by_user_id bigint(20) NOT NULL,
        amount_guaranteed decimal(10,2) NOT NULL,
        guarantor_status varchar(20) DEFAULT 'pending',
        guarantee_type varchar(50) DEFAULT 'shares',
        guarantor_notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY guaranteed_by_user_id (guaranteed_by_user_id),
        KEY guarantor_status (guarantor_status),
        KEY guarantee_type (guarantee_type)
    ) $charset_collate;";
    
    // Collateral table
    $collateral_table = $wpdb->prefix . 'daystar_collateral';
    $collateral_sql = "CREATE TABLE $collateral_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        user_id bigint(20) NOT NULL,
        collateral_type varchar(100) NOT NULL,
        estimated_value decimal(12,2) NOT NULL,
        description text,
        document_path varchar(255),
        verification_status varchar(20) DEFAULT 'pending',
        verified_by_user_id bigint(20) NULL,
        verified_date datetime NULL,
        verification_notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY user_id (user_id),
        KEY collateral_type (collateral_type),
        KEY verification_status (verification_status)
    ) $charset_collate;";
    
    // Payslip data table
    $payslip_data_table = $wpdb->prefix . 'daystar_payslip_data';
    $payslip_data_sql = "CREATE TABLE $payslip_data_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        gross_salary decimal(10,2) NOT NULL,
        net_salary decimal(10,2) NOT NULL,
        basic_salary decimal(10,2) DEFAULT 0,
        responsibility_allowance decimal(10,2) DEFAULT 0,
        telephone_allowance decimal(10,2) DEFAULT 0,
        hod_allowance decimal(10,2) DEFAULT 0,
        other_allowances decimal(10,2) DEFAULT 0,
        total_deductions decimal(10,2) DEFAULT 0,
        payslip_month varchar(7) NOT NULL,
        payslip_year int(4) NOT NULL,
        document_path varchar(255),
        verified_by_user_id bigint(20) NULL,
        verified_date datetime NULL,
        verification_status varchar(20) DEFAULT 'pending',
        verification_notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY payslip_month (payslip_month),
        KEY payslip_year (payslip_year),
        KEY verification_status (verification_status),
        UNIQUE KEY unique_user_month_year (user_id, payslip_month, payslip_year)
    ) $charset_collate;";
    
    // Credit history table
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    $credit_history_sql = "CREATE TABLE $credit_history_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        loan_id mediumint(9) NOT NULL,
        event_type varchar(50) NOT NULL,
        event_date datetime DEFAULT CURRENT_TIMESTAMP,
        amount decimal(10,2) DEFAULT 0,
        description text,
        credit_score_impact int(3) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY loan_id (loan_id),
        KEY event_type (event_type),
        KEY event_date (event_date)
    ) $charset_collate;";
    
    // Loan appeals table
    $loan_appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loan_appeals_sql = "CREATE TABLE $loan_appeals_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        user_id bigint(20) NOT NULL,
        appeal_date datetime DEFAULT CURRENT_TIMESTAMP,
        reason_for_appeal text NOT NULL,
        supporting_documents text,
        status varchar(20) DEFAULT 'pending',
        resolution_details text,
        resolved_by_user_id bigint(20) NULL,
        resolved_date datetime NULL,
        appeal_deadline date,
        committee_hearing_date datetime NULL,
        committee_notes text,
        original_rejection_reason text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY user_id (user_id),
        KEY status (status),
        KEY appeal_date (appeal_date),
        KEY appeal_deadline (appeal_deadline),
        KEY committee_hearing_date (committee_hearing_date)
    ) $charset_collate;";
    
    // Blacklist table
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    $blacklist_sql = "CREATE TABLE $blacklist_table (
        blacklist_id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        reason text NOT NULL,
        blacklist_date datetime DEFAULT CURRENT_TIMESTAMP,
        unblacklist_date datetime NULL,
        status varchar(20) DEFAULT 'active',
        blacklisted_by bigint(20) NULL,
        unblacklisted_by bigint(20) NULL,
        notes text,
        automatic_blacklist tinyint(1) DEFAULT 0,
        loan_id mediumint(9) NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (blacklist_id),
        KEY user_id (user_id),
        KEY status (status),
        KEY blacklist_date (blacklist_date),
        KEY unblacklist_date (unblacklist_date),
        KEY automatic_blacklist (automatic_blacklist),
        KEY loan_id (loan_id)
    ) $charset_collate;";
    
    // Loan products table
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    $loan_products_sql = "CREATE TABLE $loan_products_table (
        product_id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        description text,
        min_amount decimal(12,2) NOT NULL DEFAULT 0.00,
        max_amount decimal(12,2) NOT NULL DEFAULT 0.00,
        min_term_months int(11) NOT NULL DEFAULT 1,
        max_term_months int(11) NOT NULL DEFAULT 12,
        interest_rate decimal(5,2) NOT NULL DEFAULT 12.00,
        interest_type varchar(20) NOT NULL DEFAULT 'reducing_balance',
        charges longtext,
        eligibility_rules longtext,
        required_documents longtext,
        priority_score_factor int(3) DEFAULT 50,
        status varchar(20) DEFAULT 'active',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (product_id),
        KEY name (name),
        KEY status (status),
        KEY priority_score_factor (priority_score_factor),
        UNIQUE KEY unique_product_name (name)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    // Loan disbursements table
    $loan_disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
    $loan_disbursements_sql = "CREATE TABLE $loan_disbursements_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        disbursement_method varchar(50) NOT NULL,
        disbursement_reference varchar(100) NOT NULL,
        disbursement_details longtext,
        status varchar(50) DEFAULT 'pending',
        disbursed_by bigint(20) NULL,
        disbursed_date datetime NULL,
        evidence_path varchar(255) NULL,
        digital_signature_data longtext NULL,
        recipient_confirmation tinyint(1) DEFAULT 0,
        recipient_confirmation_date datetime NULL,
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY disbursement_reference (disbursement_reference),
        KEY status (status),
        KEY disbursed_by (disbursed_by)
    ) $charset_collate;";

    dbDelta($contributions_sql);
    dbDelta($loans_sql);
    dbDelta($loan_payments_sql);
    dbDelta($loan_schedules_sql);
    dbDelta($notifications_sql);
    dbDelta($share_transfers_sql);
    dbDelta($guarantors_sql);
    dbDelta($collateral_sql);
    dbDelta($payslip_data_sql);
    dbDelta($credit_history_sql);
    dbDelta($loan_appeals_sql);
    dbDelta($blacklist_sql);
    // Loan recovery tables
    $deduction_lists_table = $wpdb->prefix . 'daystar_deduction_lists';
    $deduction_lists_sql = "CREATE TABLE $deduction_lists_table (
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
    
    $reconciliation_reports_table = $wpdb->prefix . 'daystar_reconciliation_reports';
    $reconciliation_reports_sql = "CREATE TABLE $reconciliation_reports_table (
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
    
    $loan_anomalies_table = $wpdb->prefix . 'daystar_loan_anomalies';
    $loan_anomalies_sql = "CREATE TABLE $loan_anomalies_table (
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

    dbDelta($loan_products_sql);
    dbDelta($loan_disbursements_sql);
    // Policy management tables
    $policy_versions_table = $wpdb->prefix . 'daystar_policy_versions';
    $policy_versions_sql = "CREATE TABLE $policy_versions_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        version_number varchar(20) NOT NULL,
        content longtext NOT NULL,
        published_date datetime NULL,
        effective_date datetime NOT NULL,
        status varchar(20) DEFAULT 'draft',
        created_by_user_id bigint(20) NOT NULL,
        updated_by_user_id bigint(20) NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY version_number (version_number),
        KEY status (status),
        KEY effective_date (effective_date),
        KEY created_by_user_id (created_by_user_id)
    ) $charset_collate;";
    
    $policy_audit_log_table = $wpdb->prefix . 'daystar_policy_audit_log';
    $policy_audit_log_sql = "CREATE TABLE $policy_audit_log_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        policy_id mediumint(9) NOT NULL,
        action varchar(50) NOT NULL,
        description text,
        user_id bigint(20) NOT NULL,
        ip_address varchar(45),
        user_agent text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY policy_id (policy_id),
        KEY action (action),
        KEY user_id (user_id),
        KEY created_at (created_at)
    ) $charset_collate;";

    dbDelta($deduction_lists_sql);
    dbDelta($reconciliation_reports_sql);
    dbDelta($loan_anomalies_sql);
    dbDelta($policy_versions_sql);
    dbDelta($policy_audit_log_sql);
    
    // Add some sample data for testing
    daystar_add_sample_data();
}

/**
 * Add sample data for testing
 */
function daystar_add_sample_data() {
    global $wpdb;
    
    // Add loan products first
    daystar_add_loan_products();
    
    // Get a sample user (first registered member)
    $sample_user = get_users(array(
        'meta_key' => 'member_number',
        'meta_compare' => 'EXISTS',
        'number' => 1
    ));
    
    if (!empty($sample_user)) {
        $user_id = $sample_user[0]->ID;
        
        // Add sample contributions
        $contributions_table = $wpdb->prefix . 'daystar_contributions';
        
        // Share capital contribution
        $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $user_id,
                'amount' => 5000.00,
                'contribution_type' => 'share_capital',
                'is_share_capital' => 1,
                'contribution_date' => date('Y-m-d H:i:s', strtotime('-6 months')),
                'status' => 'completed',
                'payment_method' => 'bank_transfer',
                'reference_number' => 'SC' . time(),
                'notes' => 'Initial share capital contribution'
            )
        );
        
        // Monthly contributions
        $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $user_id,
                'amount' => 2000.00,
                'contribution_type' => 'monthly',
                'is_share_capital' => 0,
                'contribution_date' => date('Y-m-d H:i:s', strtotime('-1 month')),
                'status' => 'completed',
                'payment_method' => 'bank_transfer',
                'reference_number' => 'TXN' . time()
            )
        );
        
        $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $user_id,
                'amount' => 2000.00,
                'contribution_type' => 'monthly',
                'is_share_capital' => 0,
                'contribution_date' => date('Y-m-d H:i:s'),
                'status' => 'completed',
                'payment_method' => 'bank_transfer',
                'reference_number' => 'TXN' . (time() + 1)
            )
        );
        
        // Add sample loan
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $wpdb->insert(
            $loans_table,
            array(
                'user_id' => $user_id,
                'loan_type' => 'Development Loan',
                'amount' => 100000.00,
                'balance' => 95292.65,
                'interest_rate' => 12.00,
                'term_months' => 24,
                'monthly_payment' => 4707.35,
                'loan_date' => date('Y-m-d H:i:s', strtotime('-2 months')),
                'due_date' => date('Y-m-d', strtotime('+22 months')),
                'status' => 'active',
                'purpose' => 'Business development',
                'approved_date' => date('Y-m-d H:i:s', strtotime('-2 months')),
                'disbursed_date' => date('Y-m-d H:i:s', strtotime('-2 months'))
            )
        );
        
        // Add sample notifications
        $notifications_table = $wpdb->prefix . 'daystar_notifications';
        $notifications = array(
            array(
                'user_id' => $user_id,
                'title' => 'Contribution Received',
                'message' => 'Your contribution of KES 5,000 has been received.',
                'type' => 'contribution',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ),
            array(
                'user_id' => $user_id,
                'title' => 'Loan Approved',
                'message' => 'Your loan application has been approved.',
                'type' => 'loan',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ),
            array(
                'user_id' => $user_id,
                'title' => 'AGM Notice',
                'message' => 'Annual General Meeting scheduled for June 15, 2025.',
                'type' => 'announcement',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            )
        );
        
        foreach ($notifications as $notification) {
            $wpdb->insert($notifications_table, $notification);
        }
    }
}

/**
 * Initialize database on theme activation
 */
function daystar_init_database() {
    // Check if tables exist
    global $wpdb;
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$contributions_table'") != $contributions_table) {
        daystar_create_database_tables();
    }
}

/**
 * Add loan products to the database
 */
function daystar_add_loan_products() {
    global $wpdb;
    
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // Check if products already exist
    $existing_products = $wpdb->get_var("SELECT COUNT(*) FROM $loan_products_table");
    if ($existing_products > 0) {
        return; // Products already exist
    }
    
    // Define loan products based on PRD Section 8
    $loan_products = array(
        array(
            'name' => 'Development Loan',
            'description' => 'Long-term development projects and investments with competitive rates.',
            'min_amount' => 10000.00,
            'max_amount' => 2000000.00,
            'min_term_months' => 1,
            'max_term_months' => 36,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => json_encode(array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount'),
                array('name' => 'Insurance', 'type' => 'percentage', 'value' => 0.5, 'basis' => 'loan_amount')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'requires_payslip' => true,
                'no_outstanding_development_loan' => true,
                'submission_deadline' => 30
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Payslip', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Project Proposal', 'mandatory' => false)
            )),
            'priority_score_factor' => 70,
            'status' => 'active'
        ),
        array(
            'name' => 'School Fees Loan',
            'description' => 'Education financing for school fees and related educational expenses.',
            'min_amount' => 5000.00,
            'max_amount' => 500000.00,
            'min_term_months' => 1,
            'max_term_months' => 12,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => json_encode(array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'no_outstanding_school_fees_loan' => true
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Fee Structure', 'mandatory' => true),
                array('name' => 'Admission Letter', 'mandatory' => false),
                array('name' => 'National ID Copy', 'mandatory' => true)
            )),
            'priority_score_factor' => 80,
            'status' => 'active'
        ),
        array(
            'name' => 'Emergency Loan',
            'description' => 'Quick financial assistance for unexpected emergency situations.',
            'min_amount' => 5000.00,
            'max_amount' => 100000.00,
            'min_term_months' => 1,
            'max_term_months' => 12,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => json_encode(array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'no_outstanding_emergency_loan' => true,
                'emergency_types' => array('hospitalization', 'funeral', 'court_fine', 'accident')
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Emergency Evidence', 'mandatory' => true),
                array('name' => 'Medical Report', 'mandatory' => false, 'condition' => 'hospitalization'),
                array('name' => 'Death Certificate', 'mandatory' => false, 'condition' => 'funeral'),
                array('name' => 'Court Order', 'mandatory' => false, 'condition' => 'court_fine'),
                array('name' => 'National ID Copy', 'mandatory' => true)
            )),
            'priority_score_factor' => 90,
            'status' => 'active'
        ),
        array(
            'name' => 'Special Loan',
            'description' => 'Character-based loans without payslip consideration for trusted members.',
            'min_amount' => 10000.00,
            'max_amount' => 200000.00,
            'min_term_months' => 4,
            'max_term_months' => 6,
            'interest_rate' => 5.00,
            'interest_type' => 'monthly_reducing',
            'charges' => json_encode(array(
                array('name' => 'Deferral Charge', 'type' => 'percentage', 'value' => 2.0, 'basis' => 'outstanding_balance', 'condition' => 'deferral'),
                array('name' => 'Bounced Cheque Penalty', 'type' => 'flat', 'value' => 1000.00, 'condition' => 'bounced_cheque')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 12,
                'min_share_capital' => 10000,
                'good_credit_history' => true,
                'requires_postdated_cheques' => true,
                'no_payslip_required' => true,
                'term_based_on_amount' => array(
                    array('min_amount' => 10000, 'max_amount' => 100000, 'term_months' => 4),
                    array('min_amount' => 100001, 'max_amount' => 200000, 'term_months' => 6)
                )
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Post-dated Cheques', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Character Reference', 'mandatory' => false)
            )),
            'priority_score_factor' => 60,
            'status' => 'active'
        ),
        array(
            'name' => 'Super Saver Loan',
            'description' => 'Premium loans for high-deposit members with excellent terms.',
            'min_amount' => 50000.00,
            'max_amount' => 3000000.00,
            'min_term_months' => 1,
            'max_term_months' => 48,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => json_encode(array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 0.5, 'basis' => 'loan_amount')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 12,
                'min_deposits' => 1000000,
                'requires_guarantors' => false,
                'premium_member_status' => true
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Deposit Statement', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Investment Plan', 'mandatory' => false)
            )),
            'priority_score_factor' => 95,
            'status' => 'active'
        ),
        array(
            'name' => 'Salary Advance',
            'description' => 'Short-term financial assistance for immediate needs.',
            'min_amount' => 1000.00,
            'max_amount' => 100000.00,
            'min_term_months' => 1,
            'max_term_months' => 3,
            'interest_rate' => 0.00, // Special handling for one-off charges
            'interest_type' => 'one_off_charge',
            'charges' => json_encode(array(
                array('name' => 'One-off Charge (Members)', 'type' => 'percentage', 'value' => 10.0, 'basis' => 'loan_amount', 'condition' => 'member'),
                array('name' => 'One-off Charge (Non-members)', 'type' => 'percentage', 'value' => 12.5, 'basis' => 'loan_amount', 'condition' => 'non_member'),
                array('name' => 'Compounded Charge', 'type' => 'percentage', 'value' => 5.0, 'basis' => 'outstanding_balance', 'condition' => 'extended_term')
            )),
            'eligibility_rules' => json_encode(array(
                'min_membership_months' => 3,
                'proof_of_capacity' => true,
                'max_term_months' => 3,
                'quick_processing' => true
            )),
            'required_documents' => json_encode(array(
                array('name' => 'Proof of Capacity to Repay', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true)
            )),
            'priority_score_factor' => 85,
            'status' => 'active'
        ),
            );
    
    // Insert loan products
    foreach ($loan_products as $product) {
        $wpdb->insert($loan_products_table, $product);
    }
}

// Hook to run on theme activation
add_action('after_switch_theme', 'daystar_init_database');

// Also run on admin_init to ensure tables exist
add_action('admin_init', 'daystar_init_database');