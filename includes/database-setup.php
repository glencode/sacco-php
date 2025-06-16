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
        KEY status (status)
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
        status varchar(20) DEFAULT 'active',
        purpose text,
        guarantor_1 varchar(100),
        guarantor_2 varchar(100),
        collateral text,
        approved_by bigint(20),
        approved_date datetime,
        disbursed_date datetime,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY loan_date (loan_date),
        KEY status (status),
        KEY due_date (due_date)
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
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY user_id (user_id),
        KEY payment_date (payment_date)
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
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($contributions_sql);
    dbDelta($loans_sql);
    dbDelta($loan_payments_sql);
    dbDelta($notifications_sql);
    
    // Add some sample data for testing
    daystar_add_sample_data();
}

/**
 * Add sample data for testing
 */
function daystar_add_sample_data() {
    global $wpdb;
    
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
        $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $user_id,
                'amount' => 5000.00,
                'contribution_type' => 'monthly',
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
                'amount' => 20500.00,
                'contribution_type' => 'monthly',
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

// Hook to run on theme activation
add_action('after_switch_theme', 'daystar_init_database');

// Also run on admin_init to ensure tables exist
add_action('admin_init', 'daystar_init_database');