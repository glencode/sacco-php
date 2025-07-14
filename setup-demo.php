<?php
/**
 * Demo Setup Script
 * Complete setup script for SACCO system demonstration
 * 
 * This script should be run once to set up the system for client demonstration
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // Load WordPress if accessed directly
    require_once('../../../../../../../wp-load.php');
}

// Check if user has admin privileges
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

/**
 * Complete demo setup
 */
function daystar_setup_complete_demo() {
    $results = array();
    
    // Step 1: Initialize database tables
    $results['database'] = daystar_setup_database();
    
    // Step 2: Create loan products
    $results['loan_products'] = daystar_setup_loan_products();
    
    // Step 3: Generate sample members
    $results['sample_data'] = daystar_generate_sample_data(true); // Clear existing first
    
    // Step 4: Auto-approve all pending members
    $results['member_approval'] = daystar_auto_approve_pending_members();
    
    // Step 5: Create admin user if needed
    $results['admin_setup'] = daystar_setup_admin_user();
    
    // Step 6: Configure system settings
    $results['system_config'] = daystar_configure_system_settings();
    
    return $results;
}

/**
 * Setup database tables
 */
function daystar_setup_database() {
    try {
        daystar_create_database_tables();
        return array(
            'success' => true,
            'message' => 'Database tables created successfully'
        );
    } catch (Exception $e) {
        return array(
            'success' => false,
            'message' => 'Database setup failed: ' . $e->getMessage()
        );
    }
}

/**
 * Setup loan products
 */
function daystar_setup_loan_products() {
    try {
        daystar_add_loan_products();
        return array(
            'success' => true,
            'message' => 'Loan products created successfully'
        );
    } catch (Exception $e) {
        return array(
            'success' => false,
            'message' => 'Loan products setup failed: ' . $e->getMessage()
        );
    }
}

/**
 * Setup admin user
 */
function daystar_setup_admin_user() {
    // Check if admin user exists
    $admin_user = get_user_by('login', 'sacco_admin');
    
    if ($admin_user) {
        return array(
            'success' => true,
            'message' => 'Admin user already exists',
            'username' => 'sacco_admin'
        );
    }
    
    // Create admin user
    $user_id = wp_create_user(
        'sacco_admin',
        'admin123!',
        'admin@daystar-sacco.com'
    );
    
    if (is_wp_error($user_id)) {
        return array(
            'success' => false,
            'message' => 'Failed to create admin user: ' . $user_id->get_error_message()
        );
    }
    
    // Set user as administrator
    $user = new WP_User($user_id);
    $user->set_role('administrator');
    
    // Add SACCO-specific metadata
    update_user_meta($user_id, 'first_name', 'SACCO');
    update_user_meta($user_id, 'last_name', 'Administrator');
    update_user_meta($user_id, 'member_number', 'ADMIN001');
    update_user_meta($user_id, 'member_status', 'active');
    update_user_meta($user_id, 'sacco_role', 'admin');
    update_user_meta($user_id, 'is_staff', true);
    update_user_meta($user_id, 'staff_type', 'permanent');
    update_user_meta($user_id, 'employment_status', 'permanent');
    update_user_meta($user_id, 'registration_date', current_time('Y-m-d'));
    update_user_meta($user_id, 'phone', '+254700000000');
    
    return array(
        'success' => true,
        'message' => 'Admin user created successfully',
        'username' => 'sacco_admin',
        'password' => 'admin123!',
        'user_id' => $user_id
    );
}

/**
 * Configure system settings
 */
function daystar_configure_system_settings() {
    // Set up WordPress options for SACCO system
    $settings = array(
        'daystar_sacco_name' => 'Daystar University SACCO',
        'daystar_min_share_capital' => 5000,
        'daystar_min_monthly_contribution' => 2000,
        'daystar_max_loan_amount' => 3000000,
        'daystar_default_interest_rate' => 12.0,
        'daystar_loan_processing_fee' => 1.0,
        'daystar_system_currency' => 'KES',
        'daystar_demo_mode' => true,
        'daystar_setup_completed' => current_time('mysql')
    );
    
    foreach ($settings as $option => $value) {
        update_option($option, $value);
    }
    
    return array(
        'success' => true,
        'message' => 'System settings configured successfully',
        'settings' => $settings
    );
}

/**
 * Generate demo report
 */
function daystar_generate_demo_report($setup_results) {
    $report = array(
        'setup_date' => current_time('mysql'),
        'setup_results' => $setup_results,
        'system_status' => array(),
        'demo_credentials' => array(),
        'sample_data_summary' => array()
    );
    
    // Get system status
    global $wpdb;
    
    $tables = array(
        'contributions' => $wpdb->prefix . 'daystar_contributions',
        'loans' => $wpdb->prefix . 'daystar_loans',
        'members' => $wpdb->users,
        'notifications' => $wpdb->prefix . 'daystar_notifications',
        'loan_products' => $wpdb->prefix . 'daystar_loan_products'
    );
    
    foreach ($tables as $name => $table) {
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table");
        $report['system_status'][$name] = $count;
    }
    
    // Get member statistics
    $active_members = get_users(array(
        'meta_key' => 'member_status',
        'meta_value' => 'active',
        'count_total' => true
    ));
    
    $pending_members = get_users(array(
        'meta_key' => 'member_status',
        'meta_value' => 'pending',
        'count_total' => true
    ));
    
    $report['sample_data_summary'] = array(
        'total_members' => $report['system_status']['members'],
        'active_members' => $active_members,
        'pending_members' => $pending_members,
        'total_contributions' => $report['system_status']['contributions'],
        'total_loans' => $report['system_status']['loans'],
        'total_notifications' => $report['system_status']['notifications'],
        'loan_products' => $report['system_status']['loan_products']
    );
    
    // Demo credentials
    $report['demo_credentials'] = array(
        'admin_user' => array(
            'username' => 'sacco_admin',
            'password' => 'admin123!',
            'role' => 'Administrator'
        ),
        'sample_members' => array(
            array('username' => 'john_doe', 'password' => 'password123', 'role' => 'Chairman'),
            array('username' => 'mary_smith', 'password' => 'password123', 'role' => 'Secretary'),
            array('username' => 'peter_johnson', 'password' => 'password123', 'role' => 'Treasurer'),
            array('username' => 'sarah_wilson', 'password' => 'password123', 'role' => 'Member (Part-time Staff)'),
            array('username' => 'david_brown', 'password' => 'password123', 'role' => 'Member (External)')
        )
    );
    
    return $report;
}

// Handle AJAX request
if (isset($_POST['action']) && $_POST['action'] === 'setup_demo') {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_setup_demo_nonce')) {
        wp_die('Security check failed');
    }
    
    $setup_results = daystar_setup_complete_demo();
    $demo_report = daystar_generate_demo_report($setup_results);
    
    wp_send_json_success($demo_report);
}

// If accessed directly, show setup page
if (!isset($_POST['action'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>SACCO Demo Setup</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
            .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .header { text-align: center; margin-bottom: 30px; }
            .logo { color: #0073aa; font-size: 24px; font-weight: bold; }
            .setup-card { border: 1px solid #ddd; padding: 20px; margin: 20px 0; border-radius: 5px; }
            .button { background: #0073aa; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
            .button:hover { background: #005a87; }
            .button:disabled { background: #ccc; cursor: not-allowed; }
            .spinner { display: none; margin-left: 10px; }
            .spinner.active { display: inline-block; }
            .result { margin-top: 20px; padding: 15px; border-radius: 4px; }
            .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
            .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
            .credentials { background: #e2e3e5; padding: 15px; border-radius: 4px; margin: 10px 0; }
            .credentials h4 { margin-top: 0; }
            .step { margin: 15px 0; padding: 10px; border-left: 4px solid #0073aa; background: #f9f9f9; }
            ul { margin: 10px 0; padding-left: 20px; }
            .summary-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
            .summary-table th, .summary-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            .summary-table th { background: #f2f2f2; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">🏦 Daystar University SACCO</div>
                <h1>Demo Setup System</h1>
                <p>Complete setup for client demonstration</p>
            </div>
            
            <div class="setup-card">
                <h2>🚀 Demo Setup</h2>
                <p>This will set up the complete SACCO system with sample data for demonstration purposes.</p>
                
                <div class="step">
                    <h3>What will be created:</h3>
                    <ul>
                        <li>✅ Database tables and structure</li>
                        <li>👥 10 sample members with different roles</li>
                        <li>💰 Realistic contribution histories</li>
                        <li>📋 Various loan applications and statuses</li>
                        <li>💳 Payment records and schedules</li>
                        <li>🤝 Guarantor relationships</li>
                        <li>📄 Payslip data for staff members</li>
                        <li>🔔 Notifications and credit history</li>
                        <li>🏠 Collateral and appeal records</li>
                        <li>⚙️ System configuration</li>
                    </ul>
                </div>
                
                <button id="setup-btn" class="button">
                    🎯 Setup Complete Demo System
                </button>
                <span class="spinner" id="setup-spinner">⏳ Setting up...</span>
                
                <div id="setup-result" style="display: none;"></div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#setup-btn').on('click', function() {
                var $btn = $(this);
                var $spinner = $('#setup-spinner');
                var $result = $('#setup-result');
                
                $btn.prop('disabled', true);
                $spinner.addClass('active');
                $result.hide();
                
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        action: 'setup_demo',
                        nonce: '<?php echo wp_create_nonce('daystar_setup_demo_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            var data = response.data;
                            var html = '<div class="result success">';
                            html += '<h3>✅ Demo Setup Completed Successfully!</h3>';
                            
                            // Setup results
                            html += '<h4>Setup Results:</h4><ul>';
                            for (var key in data.setup_results) {
                                var result = data.setup_results[key];
                                var status = result.success ? '✅' : '❌';
                                html += '<li>' + status + ' ' + key + ': ' + result.message + '</li>';
                            }
                            html += '</ul>';
                            
                            // System summary
                            html += '<h4>System Summary:</h4>';
                            html += '<table class="summary-table">';
                            html += '<tr><th>Component</th><th>Count</th></tr>';
                            for (var key in data.sample_data_summary) {
                                html += '<tr><td>' + key.replace(/_/g, ' ').toUpperCase() + '</td><td>' + data.sample_data_summary[key] + '</td></tr>';
                            }
                            html += '</table>';
                            
                            // Demo credentials
                            html += '<div class="credentials">';
                            html += '<h4>🔑 Demo Login Credentials:</h4>';
                            html += '<p><strong>Administrator:</strong><br>';
                            html += 'Username: <code>' + data.demo_credentials.admin_user.username + '</code><br>';
                            html += 'Password: <code>' + data.demo_credentials.admin_user.password + '</code></p>';
                            
                            html += '<p><strong>Sample Members:</strong></p><ul>';
                            data.demo_credentials.sample_members.forEach(function(member) {
                                html += '<li>' + member.username + ' (Password: password123) - ' + member.role + '</li>';
                            });
                            html += '</ul></div>';
                            
                            html += '<p><strong>🎉 Your SACCO demo system is now ready for client presentation!</strong></p>';
                            html += '</div>';
                            
                            $result.html(html).show();
                        } else {
                            $result.html('<div class="result error"><h3>❌ Setup Failed</h3><p>' + response.data + '</p></div>').show();
                        }
                    },
                    error: function() {
                        $result.html('<div class="result error"><h3>❌ Setup Failed</h3><p>An error occurred during setup.</p></div>').show();
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $spinner.removeClass('active');
                    }
                });
            });
        });
        </script>
    </body>
    </html>
    <?php
}
?>