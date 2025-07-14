<?php
/**
 * Demo Setup Admin Interface
 * Provides admin interface for setting up demo data
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add demo setup admin menu
 */
function daystar_add_demo_setup_admin_menu() {
    add_menu_page(
        'Demo Setup',
        'Demo Setup',
        'manage_options',
        'daystar-demo-setup',
        'daystar_demo_setup_admin_page',
        'dashicons-admin-tools',
        2 // Position near top
    );
}
add_action('admin_menu', 'daystar_add_demo_setup_admin_menu');

/**
 * Demo setup admin page
 */
function daystar_demo_setup_admin_page() {
    ?>
    <div class="wrap">
        <h1>🏦 SACCO Demo Setup</h1>
        <p>Complete setup for client demonstration with realistic sample data.</p>
        
        <div class="notice notice-info">
            <p><strong>Note:</strong> This will create sample data for demonstration purposes. Use this only for demo environments.</p>
        </div>
        
        <div class="card" style="max-width: none;">
            <h2>🚀 Quick Demo Setup</h2>
            <p>This will automatically set up the complete SACCO system with:</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                <div>
                    <h3>👥 Members & Users</h3>
                    <ul>
                        <li>10 sample members with different roles</li>
                        <li>Chairman, Secretary, Treasurer</li>
                        <li>Staff and external members</li>
                        <li>Various member statuses</li>
                    </ul>
                </div>
                
                <div>
                    <h3>💰 Financial Data</h3>
                    <ul>
                        <li>Realistic contribution histories</li>
                        <li>Share capital contributions</li>
                        <li>Monthly contribution records</li>
                        <li>Payment transactions</li>
                    </ul>
                </div>
                
                <div>
                    <h3>📋 Loan System</h3>
                    <ul>
                        <li>7 different loan products</li>
                        <li>Various loan applications</li>
                        <li>Different loan statuses</li>
                        <li>Payment schedules</li>
                    </ul>
                </div>
                
                <div>
                    <h3>🔔 System Features</h3>
                    <ul>
                        <li>Notifications and alerts</li>
                        <li>Credit history records</li>
                        <li>Guarantor relationships</li>
                        <li>Collateral management</li>
                    </ul>
                </div>
            </div>
            
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3>⚙️ Setup Options</h3>
                <label style="display: block; margin: 10px 0;">
                    <input type="checkbox" id="clear_existing_data" checked>
                    Clear existing sample data before generating new data
                </label>
                <label style="display: block; margin: 10px 0;">
                    <input type="checkbox" id="create_admin_user" checked>
                    Create demo admin user (sacco_admin / admin123!)
                </label>
                <label style="display: block; margin: 10px 0;">
                    <input type="checkbox" id="approve_members" checked>
                    Auto-approve all pending members
                </label>
            </div>
            
            <p class="submit">
                <button type="button" class="button button-primary button-hero" id="quick-setup-btn">
                    🎯 Setup Complete Demo System
                </button>
                <span class="spinner" id="quick-setup-spinner"></span>
            </p>
            
            <div id="quick-setup-result" style="display: none;"></div>
        </div>
        
        <div class="card" style="max-width: none;">
            <h2>🔧 Individual Setup Components</h2>
            <p>Set up individual components separately if needed.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                    <h4>📊 Sample Data</h4>
                    <p>Generate members, contributions, loans, and transactions.</p>
                    <button class="button" id="generate-sample-data-btn">Generate Sample Data</button>
                </div>
                
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                    <h4>✅ Member Approval</h4>
                    <p>Auto-approve all pending member applications.</p>
                    <button class="button" id="approve-members-btn">Approve All Members</button>
                </div>
                
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                    <h4>🏦 Loan Products</h4>
                    <p>Create all available loan product types.</p>
                    <button class="button" id="create-loan-products-btn">Create Loan Products</button>
                </div>
                
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                    <h4>🗄️ Database Setup</h4>
                    <p>Initialize all required database tables.</p>
                    <button class="button" id="setup-database-btn">Setup Database</button>
                </div>
            </div>
        </div>
        
        <div class="card" style="max-width: none;">
            <h2>📋 System Status</h2>
            <div id="system-status">
                <button class="button" id="refresh-status-btn">Refresh System Status</button>
                <div id="status-display" style="margin-top: 15px;"></div>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var nonce = '<?php echo wp_create_nonce('daystar_demo_setup_nonce'); ?>';
        
        // Quick setup
        $('#quick-setup-btn').on('click', function() {
            var $btn = $(this);
            var $spinner = $('#quick-setup-spinner');
            var $result = $('#quick-setup-result');
            
            $btn.prop('disabled', true);
            $spinner.addClass('is-active');
            $result.hide();
            
            var options = {
                clear_existing: $('#clear_existing_data').is(':checked'),
                create_admin: $('#create_admin_user').is(':checked'),
                approve_members: $('#approve_members').is(':checked')
            };
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'quick_demo_setup',
                    nonce: nonce,
                    options: options
                },
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        var html = '<div class="notice notice-success" style="padding: 15px;">';
                        html += '<h3>✅ Demo Setup Completed Successfully!</h3>';
                        
                        // Summary
                        if (data.summary) {
                            html += '<h4>📊 Summary:</h4><ul>';
                            for (var key in data.summary) {
                                html += '<li><strong>' + key.replace(/_/g, ' ').toUpperCase() + ':</strong> ' + data.summary[key] + '</li>';
                            }
                            html += '</ul>';
                        }
                        
                        // Credentials
                        if (data.credentials) {
                            html += '<div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0;">';
                            html += '<h4>🔑 Demo Login Credentials:</h4>';
                            html += '<p><strong>Admin:</strong> ' + data.credentials.admin.username + ' / ' + data.credentials.admin.password + '</p>';
                            html += '<p><strong>Sample Members:</strong> All use password "password123"</p>';
                            html += '</div>';
                        }
                        
                        html += '<p><strong>🎉 Your SACCO demo system is ready for client presentation!</strong></p>';
                        html += '</div>';
                        
                        $result.html(html).show();
                        
                        // Refresh status
                        $('#refresh-status-btn').click();
                    } else {
                        $result.html('<div class="notice notice-error"><p><strong>Error:</strong> ' + response.data + '</p></div>').show();
                    }
                },
                error: function() {
                    $result.html('<div class="notice notice-error"><p><strong>Error:</strong> Setup failed.</p></div>').show();
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.removeClass('is-active');
                }
            });
        });
        
        // Individual component buttons
        $('#generate-sample-data-btn').on('click', function() {
            executeAction('generate_sample_data', $(this), 'Sample data generated successfully');
        });
        
        $('#approve-members-btn').on('click', function() {
            executeAction('auto_approve_members', $(this), 'Members approved successfully');
        });
        
        $('#create-loan-products-btn').on('click', function() {
            executeAction('create_loan_products', $(this), 'Loan products created successfully');
        });
        
        $('#setup-database-btn').on('click', function() {
            executeAction('setup_database', $(this), 'Database setup completed');
        });
        
        // Refresh system status
        $('#refresh-status-btn').on('click', function() {
            var $btn = $(this);
            var $display = $('#status-display');
            
            $btn.prop('disabled', true);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_system_status',
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        var status = response.data;
                        var html = '<table class="wp-list-table widefat fixed striped">';
                        html += '<thead><tr><th>Component</th><th>Status</th><th>Count</th></tr></thead><tbody>';
                        
                        for (var key in status) {
                            var item = status[key];
                            var statusIcon = item.exists ? '✅' : '❌';
                            html += '<tr><td>' + key + '</td><td>' + statusIcon + '</td><td>' + (item.count || 'N/A') + '</td></tr>';
                        }
                        
                        html += '</tbody></table>';
                        $display.html(html);
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
        
        function executeAction(action, $btn, successMessage) {
            var originalText = $btn.text();
            $btn.prop('disabled', true).text('Processing...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: action,
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        $btn.text('✅ Done');
                        setTimeout(function() {
                            $btn.text(originalText).prop('disabled', false);
                        }, 2000);
                    } else {
                        alert('Error: ' + response.data);
                        $btn.text(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error executing action');
                    $btn.text(originalText).prop('disabled', false);
                }
            });
        }
        
        // Load initial status
        $('#refresh-status-btn').click();
    });
    </script>
    
    <style>
    .card { margin-bottom: 20px; }
    .button-hero { font-size: 16px !important; padding: 10px 20px !important; height: auto !important; }
    </style>
    <?php
}

/**
 * Setup admin user for demo
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
 * AJAX handler for quick demo setup
 */
function daystar_ajax_quick_demo_setup() {
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_demo_setup_nonce')) {
        wp_die('Security check failed');
    }
    
    $options = $_POST['options'];
    $results = array();
    
    try {
        // Setup database
        daystar_create_database_tables();
        $results['database'] = 'Database tables created';
        
        // Create loan products
        daystar_add_loan_products();
        $results['loan_products'] = 'Loan products created';
        
        // Generate sample data
        if ($options['clear_existing']) {
            $sample_result = daystar_generate_sample_data(true);
        } else {
            $sample_result = daystar_generate_sample_data(false);
        }
        $results['sample_data'] = 'Sample data generated: ' . $sample_result['members_created'] . ' members';
        
        // Auto-approve members
        if ($options['approve_members']) {
            $approval_result = daystar_auto_approve_pending_members();
            $results['member_approval'] = 'Approved ' . $approval_result['approved_count'] . ' members';
        }
        
        // Create admin user
        if ($options['create_admin']) {
            $admin_result = daystar_setup_admin_user();
            $results['admin_user'] = $admin_result['message'];
        }
        
        // Get system summary
        global $wpdb;
        $summary = array(
            'total_members' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->users}"),
            'active_members' => count(get_users(array('meta_key' => 'member_status', 'meta_value' => 'active'))),
            'total_contributions' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_contributions"),
            'total_loans' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans"),
            'loan_products' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_products")
        );
        
        $credentials = array(
            'admin' => array(
                'username' => 'sacco_admin',
                'password' => 'admin123!'
            )
        );
        
        wp_send_json_success(array(
            'results' => $results,
            'summary' => $summary,
            'credentials' => $credentials
        ));
        
    } catch (Exception $e) {
        wp_send_json_error('Setup failed: ' . $e->getMessage());
    }
}
add_action('wp_ajax_quick_demo_setup', 'daystar_ajax_quick_demo_setup');

/**
 * AJAX handler for system status
 */
function daystar_ajax_get_system_status() {
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_demo_setup_nonce')) {
        wp_die('Security check failed');
    }
    
    global $wpdb;
    
    $tables = array(
        'Contributions' => $wpdb->prefix . 'daystar_contributions',
        'Loans' => $wpdb->prefix . 'daystar_loans',
        'Loan Products' => $wpdb->prefix . 'daystar_loan_products',
        'Notifications' => $wpdb->prefix . 'daystar_notifications',
        'Guarantors' => $wpdb->prefix . 'daystar_guarantors',
        'Payslip Data' => $wpdb->prefix . 'daystar_payslip_data'
    );
    
    $status = array();
    
    foreach ($tables as $name => $table) {
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$table'") == $table;
        $count = $exists ? $wpdb->get_var("SELECT COUNT(*) FROM $table") : 0;
        
        $status[$name] = array(
            'exists' => $exists,
            'count' => $count
        );
    }
    
    // Add member counts
    $status['Total Members'] = array(
        'exists' => true,
        'count' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->users}")
    );
    
    $status['Active Members'] = array(
        'exists' => true,
        'count' => count(get_users(array('meta_key' => 'member_status', 'meta_value' => 'active')))
    );
    
    wp_send_json_success($status);
}
add_action('wp_ajax_get_system_status', 'daystar_ajax_get_system_status');

/**
 * Individual component AJAX handlers
 */
function daystar_ajax_create_loan_products() {
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_demo_setup_nonce')) {
        wp_die('Security check failed');
    }
    
    try {
        daystar_add_loan_products();
        wp_send_json_success('Loan products created successfully');
    } catch (Exception $e) {
        wp_send_json_error('Failed to create loan products: ' . $e->getMessage());
    }
}
add_action('wp_ajax_create_loan_products', 'daystar_ajax_create_loan_products');

function daystar_ajax_setup_database() {
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_demo_setup_nonce')) {
        wp_die('Security check failed');
    }
    
    try {
        daystar_create_database_tables();
        wp_send_json_success('Database setup completed successfully');
    } catch (Exception $e) {
        wp_send_json_error('Database setup failed: ' . $e->getMessage());
    }
}
add_action('wp_ajax_setup_database', 'daystar_ajax_setup_database');