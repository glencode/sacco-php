<?php
/**
 * AJAX Handlers for Daystar Member Dashboard
 * 
 * This file contains all AJAX handlers for dynamic content in the member dashboard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue AJAX scripts and localize data
 */
function daystar_enqueue_ajax_scripts() {
    if (is_user_logged_in()) {
        wp_enqueue_script('daystar-ajax', get_template_directory_uri() . '/assets/js/member-dashboard.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('daystar-ajax', 'daystar_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('daystar_ajax_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_ajax_scripts');

/**
 * Get member dashboard data
 */
function daystar_get_member_dashboard_data() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        return;
    }
    
    $user_id = get_current_user_id();
    $member_id = get_user_meta($user_id, 'member_id', true);
    
    if (!$member_id) {
        wp_send_json_error('Member ID not found');
        return;
    }
    
    // Get member data using existing functions
    $balance = daystar_get_member_balance($member_id);
    $total_contributions = daystar_get_total_member_contributions($member_id);
    $total_loans = daystar_get_total_member_loans($member_id);
    
    $data = array(
        'balance' => $balance,
        'total_contributions' => $total_contributions,
        'total_loans' => $total_loans
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_get_member_dashboard_data', 'daystar_get_member_dashboard_data');

/**
 * Get member loan data
 */
function daystar_get_member_loan_data() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        return;
    }
    
    $user_id = get_current_user_id();
    $member_id = get_user_meta($user_id, 'member_id', true);
    
    if (!$member_id) {
        wp_send_json_error('Member ID not found');
        return;
    }
    
    // Get member loans using existing function
    $loans = daystar_get_member_loans($member_id);
    
    $data = array(
        'loans' => $loans
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_get_member_loan_data', 'daystar_get_member_loan_data');

/**
 * Get member notifications via AJAX
 */
function daystar_ajax_get_member_notifications() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        return;
    }
    
    $user_id = get_current_user_id();
    $member_id = get_user_meta($user_id, 'member_id', true);
    
    if (!$member_id) {
        wp_send_json_error('Member ID not found');
        return;
    }
    
    // Get member notifications using existing function
    $notifications = daystar_get_member_notifications($member_id);
    
    $data = array(
        'notifications' => $notifications
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_get_member_notifications', 'daystar_ajax_get_member_notifications');

// Notification read functionality moved to dashboard-notifications.php to avoid duplication

/**
 * Get member contributions chart data
 */
function daystar_get_member_contributions_chart() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error('User not logged in');
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'daystar_contributions';
    
    // Get contributions for the last 12 months
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT 
            DATE_FORMAT(contribution_date, '%%Y-%%m') as month,
            SUM(amount) as total_amount
        FROM {$table_name} 
        WHERE member_id = %d 
            AND contribution_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(contribution_date, '%%Y-%%m')
        ORDER BY month ASC",
        $user_id
    ));
    
    // Prepare chart data
    $labels = array();
    $data = array();
    
    // Create array for last 12 months
    for ($i = 11; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-{$i} months"));
        $month_name = date('M Y', strtotime("-{$i} months"));
        $labels[] = $month_name;
        $data[$month] = 0;
    }
    
    // Fill in actual data
    foreach ($results as $result) {
        if (isset($data[$result->month])) {
            $data[$result->month] = floatval($result->total_amount);
        }
    }
    
    $chart_data = array(
        'labels' => $labels,
        'data' => array_values($data)
    );
    
    wp_send_json_success($chart_data);
}
add_action('wp_ajax_get_member_contributions_chart', 'daystar_get_member_contributions_chart');

/**
 * Get hero slides for front page
 */
function daystar_get_hero_slides() {
    // Check nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Sample hero slides data - replace with actual database query
    $slides = array(
        array(
            'id' => 1,
            'title' => 'Welcome to Daystar SACCO',
            'subtitle' => 'Your Financial Partner for Life',
            'description' => 'Join thousands of members who trust us with their financial future. Experience seamless banking, competitive rates, and exceptional service.',
            'image' => get_template_directory_uri() . '/assets/images/hero-slide-1.jpg',
            'cta_text' => 'Join Today',
            'cta_link' => '/register'
        ),
        array(
            'id' => 2,
            'title' => 'Affordable Loans',
            'subtitle' => 'Quick & Easy Approval',
            'description' => 'Get the financial support you need with our competitive loan products. From personal loans to business financing, we have got you covered.',
            'image' => get_template_directory_uri() . '/assets/images/hero-slide-2.jpg',
            'cta_text' => 'Apply Now',
            'cta_link' => '/loans'
        ),
        array(
            'id' => 3,
            'title' => 'Smart Savings',
            'subtitle' => 'Grow Your Wealth',
            'description' => 'Start your savings journey with us and watch your money grow. Enjoy attractive interest rates and flexible saving options.',
            'image' => get_template_directory_uri() . '/assets/images/hero-slide-3.jpg',
            'cta_text' => 'Start Saving',
            'cta_link' => '/savings'
        )
    );
    
    wp_send_json_success($slides);
}

// Hook for both logged-in and non-logged-in users
add_action('wp_ajax_get_hero_slides', 'daystar_get_hero_slides');
add_action('wp_ajax_nopriv_get_hero_slides', 'daystar_get_hero_slides');

/**
 * Get statistics for front page
 */
function daystar_get_statistics() {
    // Check nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    global $wpdb;
    
    // Get actual statistics from database
    $total_members = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_members WHERE status = 'active'");
    $total_loans = $wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}daystar_loans WHERE status = 'approved'");
    $total_savings = $wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}daystar_contributions");
    $years_serving = date('Y') - 2010; // Assuming SACCO started in 2010
    
    $statistics = array(
        array(
            'number' => $total_members ?: 2500,
            'label' => 'Happy Members',
            'icon' => 'fas fa-users'
        ),
        array(
            'number' => number_format($total_loans ?: 50000000),
            'label' => 'Loans Disbursed',
            'icon' => 'fas fa-hand-holding-usd',
            'prefix' => 'KSh '
        ),
        array(
            'number' => number_format($total_savings ?: 25000000),
            'label' => 'Total Savings',
            'icon' => 'fas fa-piggy-bank',
            'prefix' => 'KSh '
        ),
        array(
            'number' => $years_serving,
            'label' => 'Years Serving',
            'icon' => 'fas fa-calendar-alt',
            'suffix' => '+'
        )
    );
    
    wp_send_json_success($statistics);
}

// Hook for both logged-in and non-logged-in users
add_action('wp_ajax_get_statistics', 'daystar_get_statistics');
add_action('wp_ajax_nopriv_get_statistics', 'daystar_get_statistics');

/**
 * Get featured services for front page
 */
function daystar_get_featured_services() {
    // Check nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_ajax_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    // Sample services data - replace with actual database query or custom post type
    $services = array(
        array(
            'id' => 1,
            'title' => 'Personal Loans',
            'description' => 'Quick and affordable personal loans with competitive interest rates and flexible repayment terms.',
            'icon' => 'fas fa-user-check',
            'link' => '/loans/personal',
            'features' => array('Quick Approval', 'Low Interest', 'Flexible Terms')
        ),
        array(
            'id' => 2,
            'title' => 'Savings Account',
            'description' => 'Secure your future with our high-yield savings accounts and watch your money grow over time.',
            'icon' => 'fas fa-piggy-bank',
            'link' => '/savings',
            'features' => array('High Interest', 'No Hidden Fees', 'Easy Access')
        ),
        array(
            'id' => 3,
            'title' => 'Business Loans',
            'description' => 'Fuel your business growth with our tailored business financing solutions and expert support.',
            'icon' => 'fas fa-briefcase',
            'link' => '/loans/business',
            'features' => array('Business Growth', 'Expert Support', 'Tailored Solutions')
        ),
        array(
            'id' => 4,
            'title' => 'Mobile Banking',
            'description' => 'Bank on the go with our secure mobile banking platform. Access your accounts anytime, anywhere.',
            'icon' => 'fas fa-mobile-alt',
            'link' => '/mobile-banking',
            'features' => array('24/7 Access', 'Secure Platform', 'Easy Transfers')
        )
    );
    
    wp_send_json_success($services);
}

// Hook for both logged-in and non-logged-in users
add_action('wp_ajax_get_featured_services', 'daystar_get_featured_services');
add_action('wp_ajax_nopriv_get_featured_services', 'daystar_get_featured_services');

/**
 * Helper function to get total member contributions
 */
function daystar_get_total_member_contributions($member_id) {
    global $wpdb;
    
    $total = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(amount) FROM {$wpdb->prefix}daystar_contributions WHERE member_id = %d",
        $member_id
    ));
    
    return $total ? floatval($total) : 0;
}

/**
 * Helper function to get total member loans
 */
function daystar_get_total_member_loans($member_id) {
    global $wpdb;
    
    $total = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(amount) FROM {$wpdb->prefix}daystar_loans WHERE member_id = %d AND status = 'active'",
        $member_id
    ));
    
    return $total ? floatval($total) : 0;
}

/**
 * Document upload handler
 */
function daystar_upload_document() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['security'], 'daystar_document_upload')) {
        wp_die('Security check failed');
    }
    
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        return;
    }
    
    if (!isset($_FILES['document']) || $_FILES['document']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('No file uploaded or upload error');
        return;
    }
    
    $user_id = get_current_user_id();
    $member_id = get_user_meta($user_id, 'member_id', true);
    $document_type = sanitize_text_field($_POST['document_type']);
    
    if (!$member_id) {
        wp_send_json_error('Member ID not found');
        return;
    }
    
    // Handle file upload
    $uploaded_file = wp_handle_upload($_FILES['document'], array('test_form' => false));
    
    if (isset($uploaded_file['error'])) {
        wp_send_json_error($uploaded_file['error']);
        return;
    }
    
    // Save document information to database
    global $wpdb;
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'daystar_member_documents',
        array(
            'member_id' => $member_id,
            'document_type' => $document_type,
            'file_path' => $uploaded_file['url'],
            'file_name' => basename($uploaded_file['file']),
            'upload_date' => current_time('mysql'),
            'status' => 'pending'
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result) {
        wp_send_json_success('Document uploaded successfully');
    } else {
        wp_send_json_error('Failed to save document information');
    }
}
add_action('wp_ajax_daystar_upload_document', 'daystar_upload_document');

/**
 * Localize script data for document uploads
 */
function daystar_localize_document_upload_data() {
    if (is_page_template('page-member-dashboard.php')) {
        wp_localize_script('daystar-member-dashboard', 'daystarData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'documentUploadNonce' => wp_create_nonce('daystar_document_upload')
        ));
    }
}
add_action('wp_enqueue_scripts', 'daystar_localize_document_upload_data');