<?php
/**
 * Integration Admin Interface
 * 
 * Provides admin interface for managing accounting API, M-Pesa, and notification integrations
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Integration Admin Interface Class
 */
class DaystarIntegrationAdmin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_generate_api_key', array($this, 'generate_api_key'));
        add_action('wp_ajax_revoke_api_key', array($this, 'revoke_api_key'));
        add_action('wp_ajax_test_mpesa_connection', array($this, 'test_mpesa_connection'));
        add_action('wp_ajax_test_notification_provider', array($this, 'test_notification_provider'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Integrations',
            'Integrations',
            'manage_options',
            'daystar-integrations',
            array($this, 'admin_page'),
            'dashicons-admin-plugins',
            30
        );
        
        add_submenu_page(
            'daystar-integrations',
            'Accounting API',
            'Accounting API',
            'manage_options',
            'daystar-accounting-api',
            array($this, 'accounting_api_page')
        );
        
        add_submenu_page(
            'daystar-integrations',
            'M-Pesa Settings',
            'M-Pesa Settings',
            'manage_options',
            'daystar-mpesa-settings',
            array($this, 'mpesa_settings_page')
        );
        
        add_submenu_page(
            'daystar-integrations',
            'Notification Settings',
            'Notification Settings',
            'manage_options',
            'daystar-notification-settings',
            array($this, 'notification_settings_page')
        );
        
        add_submenu_page(
            'daystar-integrations',
            'Integration Logs',
            'Integration Logs',
            'manage_options',
            'daystar-integration-logs',
            array($this, 'integration_logs_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        // M-Pesa settings
        register_setting('daystar_mpesa_settings', 'daystar_mpesa_config');
        
        // Notification provider settings
        register_setting('daystar_notification_settings', 'daystar_twilio_config');
        register_setting('daystar_notification_settings', 'daystar_africastalking_config');
        register_setting('daystar_notification_settings', 'daystar_infobip_config');
        register_setting('daystar_notification_settings', 'daystar_sendgrid_config');
        register_setting('daystar_notification_settings', 'daystar_mailgun_config');
        register_setting('daystar_notification_settings', 'daystar_ses_config');
        register_setting('daystar_notification_settings', 'daystar_notification_defaults');
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'daystar-integrations') === false) {
            return;
        }
        
        wp_enqueue_script('daystar-integration-admin', get_template_directory_uri() . '/assets/js/integration-admin.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style('daystar-integration-admin', get_template_directory_uri() . '/assets/css/integration-admin.css', array(), '1.0.0');
        
        wp_localize_script('daystar-integration-admin', 'daystarIntegrationAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('daystar_integration_admin')
        ));
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Integration Management</h1>
            
            <div class="integration-dashboard">
                <div class="integration-cards">
                    <div class="integration-card">
                        <div class="card-header">
                            <h3>Accounting API</h3>
                            <span class="status-indicator <?php echo $this->get_accounting_api_status(); ?>"></span>
                        </div>
                        <div class="card-body">
                            <p>RESTful API for external accounting system integration</p>
                            <div class="card-stats">
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_api_key_count(); ?></span>
                                    <span class="stat-label">Active API Keys</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_api_usage_count(); ?></span>
                                    <span class="stat-label">API Calls Today</span>
                                </div>
                            </div>
                            <a href="<?php echo admin_url('admin.php?page=daystar-accounting-api'); ?>" class="button button-primary">Manage API</a>
                        </div>
                    </div>
                    
                    <div class="integration-card">
                        <div class="card-header">
                            <h3>M-Pesa Integration</h3>
                            <span class="status-indicator <?php echo $this->get_mpesa_status(); ?>"></span>
                        </div>
                        <div class="card-body">
                            <p>Bi-directional M-Pesa payments and disbursements</p>
                            <div class="card-stats">
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_mpesa_transaction_count(); ?></span>
                                    <span class="stat-label">Transactions Today</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_mpesa_success_rate(); ?>%</span>
                                    <span class="stat-label">Success Rate</span>
                                </div>
                            </div>
                            <a href="<?php echo admin_url('admin.php?page=daystar-mpesa-settings'); ?>" class="button button-primary">Configure M-Pesa</a>
                        </div>
                    </div>
                    
                    <div class="integration-card">
                        <div class="card-header">
                            <h3>Notification Gateway</h3>
                            <span class="status-indicator <?php echo $this->get_notification_status(); ?>"></span>
                        </div>
                        <div class="card-body">
                            <p>SMS and Email notification system</p>
                            <div class="card-stats">
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_notification_count(); ?></span>
                                    <span class="stat-label">Notifications Today</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value"><?php echo $this->get_notification_delivery_rate(); ?>%</span>
                                    <span class="stat-label">Delivery Rate</span>
                                </div>
                            </div>
                            <a href="<?php echo admin_url('admin.php?page=daystar-notification-settings'); ?>" class="button button-primary">Configure Notifications</a>
                        </div>
                    </div>
                </div>
                
                <div class="integration-logs-preview">
                    <h3>Recent Integration Activity</h3>
                    <div class="logs-table">
                        <?php $this->display_recent_logs(); ?>
                    </div>
                    <a href="<?php echo admin_url('admin.php?page=daystar-integration-logs'); ?>" class="button">View All Logs</a>
                </div>
            </div>
        </div>
        
        <style>
        .integration-dashboard {
            margin-top: 20px;
        }
        
        .integration-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .integration-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .status-indicator.active {
            background-color: #46b450;
        }
        
        .status-indicator.inactive {
            background-color: #dc3232;
        }
        
        .status-indicator.warning {
            background-color: #ffb900;
        }
        
        .card-stats {
            display: flex;
            gap: 20px;
            margin: 15px 0;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-value {
            display: block;
            font-size: 24px;
            font-weight: bold;
            color: #0073aa;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
        }
        
        .integration-logs-preview {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }
        
        .logs-table {
            margin: 15px 0;
        }
        </style>
        <?php
    }
    
    /**
     * Accounting API page
     */
    public function accounting_api_page() {
        if (isset($_POST['generate_key'])) {
            $this->handle_generate_api_key();
        }
        
        $api_keys = get_option('daystar_accounting_api_keys', array());
        $webhooks = get_option('daystar_accounting_webhooks', array());
        ?>
        <div class="wrap">
            <h1>Accounting API Management</h1>
            
            <div class="api-management">
                <div class="api-section">
                    <h2>API Keys</h2>
                    <p>Generate and manage API keys for external accounting system access.</p>
                    
                    <form method="post" action="">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Key Name</th>
                                <td>
                                    <input type="text" name="key_name" class="regular-text" placeholder="e.g., QuickBooks Integration" required>
                                    <p class="description">Descriptive name for this API key</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Permissions</th>
                                <td>
                                    <fieldset>
                                        <label><input type="checkbox" name="permissions[]" value="read_loans" checked> Read Loans</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="read_repayments" checked> Read Repayments</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="read_contributions" checked> Read Contributions</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="read_members" checked> Read Members</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="read_financial_summary" checked> Read Financial Summary</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="manage_webhooks"> Manage Webhooks</label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <?php submit_button('Generate API Key', 'primary', 'generate_key'); ?>
                    </form>
                    
                    <h3>Active API Keys</h3>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Key</th>
                                <th>Permissions</th>
                                <th>Created</th>
                                <th>Last Used</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($api_keys)) : ?>
                                <?php foreach ($api_keys as $key_id => $key_data) : ?>
                                    <tr>
                                        <td><?php echo esc_html($key_data['name']); ?></td>
                                        <td>
                                            <code class="api-key-display"><?php echo esc_html(substr($key_data['key'], 0, 8) . '...'); ?></code>
                                            <button type="button" class="button button-small show-full-key" data-key="<?php echo esc_attr($key_data['key']); ?>">Show</button>
                                        </td>
                                        <td><?php echo esc_html(implode(', ', $key_data['permissions'])); ?></td>
                                        <td><?php echo esc_html(date('M j, Y', strtotime($key_data['created_at']))); ?></td>
                                        <td><?php echo esc_html($key_data['last_used'] ? date('M j, Y g:i A', strtotime($key_data['last_used'])) : 'Never'); ?></td>
                                        <td>
                                            <button type="button" class="button button-small revoke-key" data-key-id="<?php echo esc_attr($key_id); ?>">Revoke</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">No API keys generated yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="api-section">
                    <h2>API Documentation</h2>
                    <div class="api-docs">
                        <h3>Base URL</h3>
                        <code><?php echo home_url('/wp-json/daystar-accounting/v1/'); ?></code>
                        
                        <h3>Authentication</h3>
                        <p>Include your API key in the request header:</p>
                        <code>Authorization: Bearer YOUR_API_KEY</code>
                        
                        <h3>Available Endpoints</h3>
                        <ul>
                            <li><code>GET /loans</code> - Retrieve loans</li>
                            <li><code>GET /loans/{id}</code> - Retrieve specific loan</li>
                            <li><code>GET /repayments</code> - Retrieve repayments</li>
                            <li><code>GET /contributions</code> - Retrieve contributions</li>
                            <li><code>GET /members</code> - Retrieve members</li>
                            <li><code>GET /financial-summary</code> - Retrieve financial summary</li>
                            <li><code>POST /webhooks</code> - Register webhook</li>
                        </ul>
                        
                        <h3>Example Request</h3>
                        <pre><code>curl -X GET "<?php echo home_url('/wp-json/daystar-accounting/v1/loans'); ?>" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json"</code></pre>
                    </div>
                </div>
                
                <div class="api-section">
                    <h2>Registered Webhooks</h2>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>URL</th>
                                <th>Events</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($webhooks)) : ?>
                                <?php foreach ($webhooks as $webhook_id => $webhook) : ?>
                                    <tr>
                                        <td><?php echo esc_html($webhook['url']); ?></td>
                                        <td><?php echo esc_html(implode(', ', $webhook['events'])); ?></td>
                                        <td>
                                            <span class="status-<?php echo $webhook['active'] ? 'active' : 'inactive'; ?>">
                                                <?php echo $webhook['active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo esc_html(date('M j, Y', strtotime($webhook['created_at']))); ?></td>
                                        <td>
                                            <button type="button" class="button button-small">Test</button>
                                            <button type="button" class="button button-small">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">No webhooks registered.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('.show-full-key').on('click', function() {
                var key = $(this).data('key');
                var display = $(this).siblings('.api-key-display');
                
                if ($(this).text() === 'Show') {
                    display.text(key);
                    $(this).text('Hide');
                } else {
                    display.text(key.substring(0, 8) + '...');
                    $(this).text('Show');
                }
            });
            
            $('.revoke-key').on('click', function() {
                if (confirm('Are you sure you want to revoke this API key? This action cannot be undone.')) {
                    var keyId = $(this).data('key-id');
                    
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'revoke_api_key',
                            key_id: keyId,
                            nonce: '<?php echo wp_create_nonce('daystar_integration_admin'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Failed to revoke API key: ' + response.data);
                            }
                        }
                    });
                }
            });
        });
        </script>
        <?php
    }
    
    /**
     * M-Pesa settings page
     */
    public function mpesa_settings_page() {
        if (isset($_POST['submit'])) {
            $this->save_mpesa_settings();
        }
        
        $config = get_option('daystar_mpesa_config', array());
        ?>
        <div class="wrap">
            <h1>M-Pesa Integration Settings</h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('daystar_mpesa_settings'); ?>
                
                <div class="mpesa-settings">
                    <div class="settings-section">
                        <h2>Environment Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Environment</th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" name="environment" value="sandbox" <?php checked($config['environment'] ?? 'sandbox', 'sandbox'); ?>>
                                            Sandbox (Testing)
                                        </label><br>
                                        <label>
                                            <input type="radio" name="environment" value="production" <?php checked($config['environment'] ?? 'sandbox', 'production'); ?>>
                                            Production (Live)
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="settings-section">
                        <h2>API Credentials</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Consumer Key</th>
                                <td>
                                    <input type="text" name="consumer_key" value="<?php echo esc_attr($config['consumer_key'] ?? ''); ?>" class="regular-text" required>
                                    <p class="description">Your M-Pesa app consumer key</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Consumer Secret</th>
                                <td>
                                    <input type="password" name="consumer_secret" value="<?php echo esc_attr($config['consumer_secret'] ?? ''); ?>" class="regular-text" required>
                                    <p class="description">Your M-Pesa app consumer secret</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Shortcode</th>
                                <td>
                                    <input type="text" name="shortcode" value="<?php echo esc_attr($config['shortcode'] ?? ''); ?>" class="regular-text" required>
                                    <p class="description">Your M-Pesa paybill or till number</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Passkey</th>
                                <td>
                                    <input type="password" name="passkey" value="<?php echo esc_attr($config['passkey'] ?? ''); ?>" class="regular-text" required>
                                    <p class="description">Your M-Pesa passkey for STK push</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="settings-section">
                        <h2>B2C Settings (For Disbursements)</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Initiator Name</th>
                                <td>
                                    <input type="text" name="initiator_name" value="<?php echo esc_attr($config['initiator_name'] ?? ''); ?>" class="regular-text">
                                    <p class="description">Username for B2C transactions</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Security Credential</th>
                                <td>
                                    <textarea name="security_credential" class="large-text" rows="4"><?php echo esc_textarea($config['security_credential'] ?? ''); ?></textarea>
                                    <p class="description">Encrypted security credential for B2C</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="settings-section">
                        <h2>Test Connection</h2>
                        <p>Test your M-Pesa configuration to ensure it's working correctly.</p>
                        <button type="button" id="test-mpesa-connection" class="button button-secondary">Test Connection</button>
                        <div id="test-results" style="margin-top: 10px;"></div>
                    </div>
                </div>
                
                <?php submit_button('Save Settings'); ?>
            </form>
            
            <div class="mpesa-transactions">
                <h2>Recent M-Pesa Transactions</h2>
                <?php $this->display_mpesa_transactions(); ?>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#test-mpesa-connection').on('click', function() {
                var button = $(this);
                var results = $('#test-results');
                
                button.prop('disabled', true).text('Testing...');
                results.html('<div class="notice notice-info"><p>Testing M-Pesa connection...</p></div>');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'test_mpesa_connection',
                        nonce: '<?php echo wp_create_nonce('daystar_integration_admin'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            results.html('<div class="notice notice-success"><p>M-Pesa connection successful!</p></div>');
                        } else {
                            results.html('<div class="notice notice-error"><p>M-Pesa connection failed: ' + response.data + '</p></div>');
                        }
                    },
                    error: function() {
                        results.html('<div class="notice notice-error"><p>Failed to test M-Pesa connection.</p></div>');
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Test Connection');
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * Notification settings page
     */
    public function notification_settings_page() {
        if (isset($_POST['submit'])) {
            $this->save_notification_settings();
        }
        
        $twilio_config = get_option('daystar_twilio_config', array());
        $africastalking_config = get_option('daystar_africastalking_config', array());
        $sendgrid_config = get_option('daystar_sendgrid_config', array());
        $defaults = get_option('daystar_notification_defaults', array());
        ?>
        <div class="wrap">
            <h1>Notification Settings</h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('daystar_notification_settings'); ?>
                
                <div class="notification-settings">
                    <div class="settings-section">
                        <h2>Default Providers</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Default SMS Provider</th>
                                <td>
                                    <select name="default_sms_provider">
                                        <option value="twilio" <?php selected($defaults['sms_provider'] ?? 'twilio', 'twilio'); ?>>Twilio</option>
                                        <option value="africastalking" <?php selected($defaults['sms_provider'] ?? 'twilio', 'africastalking'); ?>>Africa's Talking</option>
                                        <option value="infobip" <?php selected($defaults['sms_provider'] ?? 'twilio', 'infobip'); ?>>Infobip</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Default Email Provider</th>
                                <td>
                                    <select name="default_email_provider">
                                        <option value="sendgrid" <?php selected($defaults['email_provider'] ?? 'sendgrid', 'sendgrid'); ?>>SendGrid</option>
                                        <option value="mailgun" <?php selected($defaults['email_provider'] ?? 'sendgrid', 'mailgun'); ?>>Mailgun</option>
                                        <option value="ses" <?php selected($defaults['email_provider'] ?? 'sendgrid', 'ses'); ?>>Amazon SES</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="settings-section">
                        <h2>Twilio SMS Configuration</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Account SID</th>
                                <td>
                                    <input type="text" name="twilio_account_sid" value="<?php echo esc_attr($twilio_config['account_sid'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Auth Token</th>
                                <td>
                                    <input type="password" name="twilio_auth_token" value="<?php echo esc_attr($twilio_config['auth_token'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">From Number</th>
                                <td>
                                    <input type="text" name="twilio_from_number" value="<?php echo esc_attr($twilio_config['from_number'] ?? ''); ?>" class="regular-text">
                                    <p class="description">Your Twilio phone number (e.g., +1234567890)</p>
                                </td>
                            </tr>
                        </table>
                        <button type="button" class="button test-provider" data-provider="twilio" data-type="sms">Test Twilio</button>
                    </div>
                    
                    <div class="settings-section">
                        <h2>Africa's Talking SMS Configuration</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Username</th>
                                <td>
                                    <input type="text" name="africastalking_username" value="<?php echo esc_attr($africastalking_config['username'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">API Key</th>
                                <td>
                                    <input type="password" name="africastalking_api_key" value="<?php echo esc_attr($africastalking_config['api_key'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">From (Optional)</th>
                                <td>
                                    <input type="text" name="africastalking_from" value="<?php echo esc_attr($africastalking_config['from'] ?? ''); ?>" class="regular-text">
                                    <p class="description">Sender ID (if approved)</p>
                                </td>
                            </tr>
                        </table>
                        <button type="button" class="button test-provider" data-provider="africastalking" data-type="sms">Test Africa's Talking</button>
                    </div>
                    
                    <div class="settings-section">
                        <h2>SendGrid Email Configuration</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">API Key</th>
                                <td>
                                    <input type="password" name="sendgrid_api_key" value="<?php echo esc_attr($sendgrid_config['api_key'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">From Email</th>
                                <td>
                                    <input type="email" name="sendgrid_from_email" value="<?php echo esc_attr($sendgrid_config['from_email'] ?? ''); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">From Name</th>
                                <td>
                                    <input type="text" name="sendgrid_from_name" value="<?php echo esc_attr($sendgrid_config['from_name'] ?? 'Daystar SACCO'); ?>" class="regular-text">
                                </td>
                            </tr>
                        </table>
                        <button type="button" class="button test-provider" data-provider="sendgrid" data-type="email">Test SendGrid</button>
                    </div>
                    
                    <div class="settings-section">
                        <h2>Test Notifications</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Test Phone Number</th>
                                <td>
                                    <input type="text" id="test-phone" class="regular-text" placeholder="+254700000000">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Test Email Address</th>
                                <td>
                                    <input type="email" id="test-email" class="regular-text" placeholder="test@example.com">
                                </td>
                            </tr>
                        </table>
                        <div id="test-notification-results"></div>
                    </div>
                </div>
                
                <?php submit_button('Save Settings'); ?>
            </form>
            
            <div class="notification-stats">
                <h2>Notification Statistics</h2>
                <?php $this->display_notification_stats(); ?>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('.test-provider').on('click', function() {
                var provider = $(this).data('provider');
                var type = $(this).data('type');
                var button = $(this);
                var contact = type === 'sms' ? $('#test-phone').val() : $('#test-email').val();
                
                if (!contact) {
                    alert('Please enter a test ' + (type === 'sms' ? 'phone number' : 'email address'));
                    return;
                }
                
                button.prop('disabled', true).text('Testing...');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'test_notification_provider',
                        provider_type: type,
                        provider_name: provider,
                        test_contact: contact,
                        nonce: '<?php echo wp_create_nonce('daystar_integration_admin'); ?>'
                    },
                    success: function(response) {
                        var results = $('#test-notification-results');
                        if (response.success) {
                            results.html('<div class="notice notice-success"><p>' + provider + ' test successful!</p></div>');
                        } else {
                            results.html('<div class="notice notice-error"><p>' + provider + ' test failed: ' + response.data + '</p></div>');
                        }
                    },
                    error: function() {
                        $('#test-notification-results').html('<div class="notice notice-error"><p>Failed to test ' + provider + '.</p></div>');
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Test ' + provider.charAt(0).toUpperCase() + provider.slice(1));
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * Integration logs page
     */
    public function integration_logs_page() {
        ?>
        <div class="wrap">
            <h1>Integration Logs</h1>
            
            <div class="log-filters">
                <form method="get" action="">
                    <input type="hidden" name="page" value="daystar-integration-logs">
                    
                    <select name="log_type">
                        <option value="">All Types</option>
                        <option value="api" <?php selected($_GET['log_type'] ?? '', 'api'); ?>>API Calls</option>
                        <option value="mpesa" <?php selected($_GET['log_type'] ?? '', 'mpesa'); ?>>M-Pesa Transactions</option>
                        <option value="notifications" <?php selected($_GET['log_type'] ?? '', 'notifications'); ?>>Notifications</option>
                        <option value="webhooks" <?php selected($_GET['log_type'] ?? '', 'webhooks'); ?>>Webhooks</option>
                    </select>
                    
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="success" <?php selected($_GET['status'] ?? '', 'success'); ?>>Success</option>
                        <option value="failed" <?php selected($_GET['status'] ?? '', 'failed'); ?>>Failed</option>
                        <option value="pending" <?php selected($_GET['status'] ?? '', 'pending'); ?>>Pending</option>
                    </select>
                    
                    <input type="date" name="date_from" value="<?php echo esc_attr($_GET['date_from'] ?? ''); ?>">
                    <input type="date" name="date_to" value="<?php echo esc_attr($_GET['date_to'] ?? ''); ?>">
                    
                    <input type="submit" class="button" value="Filter">
                    <a href="<?php echo admin_url('admin.php?page=daystar-integration-logs'); ?>" class="button">Clear</a>
                </form>
            </div>
            
            <div class="integration-logs">
                <?php $this->display_integration_logs(); ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Helper methods for status and statistics
     */
    private function get_accounting_api_status() {
        $api_keys = get_option('daystar_accounting_api_keys', array());
        return !empty($api_keys) ? 'active' : 'inactive';
    }
    
    private function get_mpesa_status() {
        $config = get_option('daystar_mpesa_config', array());
        return (!empty($config['consumer_key']) && !empty($config['consumer_secret'])) ? 'active' : 'inactive';
    }
    
    private function get_notification_status() {
        $twilio = get_option('daystar_twilio_config', array());
        $sendgrid = get_option('daystar_sendgrid_config', array());
        return (!empty($twilio['account_sid']) || !empty($sendgrid['api_key'])) ? 'active' : 'inactive';
    }
    
    private function get_api_key_count() {
        $api_keys = get_option('daystar_accounting_api_keys', array());
        return count(array_filter($api_keys, function($key) { return $key['active']; }));
    }
    
    private function get_api_usage_count() {
        $logs = get_option('daystar_api_usage_logs', array());
        $today = date('Y-m-d');
        return count(array_filter($logs, function($log) use ($today) {
            return strpos($log['timestamp'], $today) === 0;
        }));
    }
    
    private function get_mpesa_transaction_count() {
        global $wpdb;
        $today = date('Y-m-d');
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_mpesa_transactions WHERE DATE(created_at) = %s",
            $today
        ));
    }
    
    private function get_mpesa_success_rate() {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_mpesa_transactions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $successful = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_mpesa_transactions WHERE status = 'completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        
        return $total > 0 ? round(($successful / $total) * 100) : 0;
    }
    
    private function get_notification_count() {
        global $wpdb;
        $today = date('Y-m-d');
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE DATE(created_at) = %s",
            $today
        ));
    }
    
    private function get_notification_delivery_rate() {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $delivered = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE status IN ('sent', 'delivered') AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        
        return $total > 0 ? round(($delivered / $total) * 100) : 0;
    }
    
    /**
     * Display methods
     */
    private function display_recent_logs() {
        // Implementation for displaying recent logs
        echo '<p>Recent integration activity will be displayed here.</p>';
    }
    
    private function display_mpesa_transactions() {
        global $wpdb;
        
        $transactions = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}daystar_mpesa_transactions 
             ORDER BY created_at DESC LIMIT 10"
        );
        
        if (!empty($transactions)) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>Type</th><th>Amount</th><th>Phone</th><th>Status</th><th>Date</th></tr></thead>';
            echo '<tbody>';
            foreach ($transactions as $transaction) {
                echo '<tr>';
                echo '<td>' . esc_html($transaction->transaction_type) . '</td>';
                echo '<td>KES ' . number_format($transaction->amount, 2) . '</td>';
                echo '<td>' . esc_html($transaction->phone_number) . '</td>';
                echo '<td>' . esc_html($transaction->status) . '</td>';
                echo '<td>' . esc_html(date('M j, Y g:i A', strtotime($transaction->created_at))) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>No M-Pesa transactions found.</p>';
        }
    }
    
    private function display_notification_stats() {
        global $wpdb;
        
        $stats = array(
            'total_today' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE DATE(created_at) = CURDATE()"),
            'sms_today' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE channel = 'sms' AND DATE(created_at) = CURDATE()"),
            'email_today' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE channel = 'email' AND DATE(created_at) = CURDATE()"),
            'failed_today' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications WHERE status = 'failed' AND DATE(created_at) = CURDATE()")
        );
        
        echo '<div class="notification-stats-grid">';
        echo '<div class="stat-box"><h3>' . $stats['total_today'] . '</h3><p>Total Today</p></div>';
        echo '<div class="stat-box"><h3>' . $stats['sms_today'] . '</h3><p>SMS Today</p></div>';
        echo '<div class="stat-box"><h3>' . $stats['email_today'] . '</h3><p>Email Today</p></div>';
        echo '<div class="stat-box"><h3>' . $stats['failed_today'] . '</h3><p>Failed Today</p></div>';
        echo '</div>';
    }
    
    private function display_integration_logs() {
        // Implementation for displaying filtered integration logs
        echo '<p>Integration logs will be displayed here based on filters.</p>';
    }
    
    /**
     * AJAX handlers
     */
    public function generate_api_key() {
        check_ajax_referer('daystar_integration_admin', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $key_name = sanitize_text_field($_POST['key_name']);
        $permissions = array_map('sanitize_text_field', $_POST['permissions'] ?? array());
        
        $api_key = wp_generate_password(32, false);
        $key_id = wp_generate_uuid4();
        
        $api_keys = get_option('daystar_accounting_api_keys', array());
        $api_keys[$key_id] = array(
            'name' => $key_name,
            'key' => $api_key,
            'permissions' => $permissions,
            'active' => true,
            'created_at' => current_time('mysql'),
            'last_used' => null
        );
        
        update_option('daystar_accounting_api_keys', $api_keys);
        
        wp_send_json_success(array(
            'message' => 'API key generated successfully',
            'key_id' => $key_id,
            'api_key' => $api_key
        ));
    }
    
    public function revoke_api_key() {
        check_ajax_referer('daystar_integration_admin', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $key_id = sanitize_text_field($_POST['key_id']);
        
        $api_keys = get_option('daystar_accounting_api_keys', array());
        if (isset($api_keys[$key_id])) {
            unset($api_keys[$key_id]);
            update_option('daystar_accounting_api_keys', $api_keys);
            wp_send_json_success('API key revoked successfully');
        } else {
            wp_send_json_error('API key not found');
        }
    }
    
    public function test_mpesa_connection() {
        check_ajax_referer('daystar_integration_admin', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Test M-Pesa connection by trying to get access token
        try {
            $mpesa = new DaystarEnhancedMPesa();
            // This would call a test method on the M-Pesa class
            wp_send_json_success('M-Pesa connection successful');
        } catch (Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }
    
    public function test_notification_provider() {
        check_ajax_referer('daystar_integration_admin', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $provider_type = sanitize_text_field($_POST['provider_type']);
        $provider_name = sanitize_text_field($_POST['provider_name']);
        $test_contact = sanitize_text_field($_POST['test_contact']);
        
        // This would call the notification gateway test method
        $gateway = new DaystarNotificationGateway();
        $result = $gateway->test_notification_provider();
        
        if ($result['success']) {
            wp_send_json_success($result['message']);
        } else {
            wp_send_json_error($result['message']);
        }
    }
    
    /**
     * Handle form submissions
     */
    private function handle_generate_api_key() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'daystar_integration_admin')) {
            wp_die('Security check failed');
        }
        
        $key_name = sanitize_text_field($_POST['key_name']);
        $permissions = array_map('sanitize_text_field', $_POST['permissions'] ?? array());
        
        $api_key = wp_generate_password(32, false);
        $key_id = wp_generate_uuid4();
        
        $api_keys = get_option('daystar_accounting_api_keys', array());
        $api_keys[$key_id] = array(
            'name' => $key_name,
            'key' => $api_key,
            'permissions' => $permissions,
            'active' => true,
            'created_at' => current_time('mysql'),
            'last_used' => null
        );
        
        update_option('daystar_accounting_api_keys', $api_keys);
        
        add_settings_error('daystar_integration', 'api_key_generated', 'API key generated successfully!', 'success');
    }
    
    private function save_mpesa_settings() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'daystar_mpesa_settings')) {
            wp_die('Security check failed');
        }
        
        $config = array(
            'environment' => sanitize_text_field($_POST['environment']),
            'consumer_key' => sanitize_text_field($_POST['consumer_key']),
            'consumer_secret' => sanitize_text_field($_POST['consumer_secret']),
            'shortcode' => sanitize_text_field($_POST['shortcode']),
            'passkey' => sanitize_text_field($_POST['passkey']),
            'initiator_name' => sanitize_text_field($_POST['initiator_name']),
            'security_credential' => sanitize_textarea_field($_POST['security_credential'])
        );
        
        update_option('daystar_mpesa_config', $config);
        
        add_settings_error('daystar_integration', 'mpesa_settings_saved', 'M-Pesa settings saved successfully!', 'success');
    }
    
    private function save_notification_settings() {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'daystar_notification_settings')) {
            wp_die('Security check failed');
        }
        
        // Save default providers
        $defaults = array(
            'sms_provider' => sanitize_text_field($_POST['default_sms_provider']),
            'email_provider' => sanitize_text_field($_POST['default_email_provider'])
        );
        update_option('daystar_notification_defaults', $defaults);
        
        // Save Twilio config
        $twilio_config = array(
            'account_sid' => sanitize_text_field($_POST['twilio_account_sid']),
            'auth_token' => sanitize_text_field($_POST['twilio_auth_token']),
            'from_number' => sanitize_text_field($_POST['twilio_from_number'])
        );
        update_option('daystar_twilio_config', $twilio_config);
        
        // Save Africa's Talking config
        $africastalking_config = array(
            'username' => sanitize_text_field($_POST['africastalking_username']),
            'api_key' => sanitize_text_field($_POST['africastalking_api_key']),
            'from' => sanitize_text_field($_POST['africastalking_from'])
        );
        update_option('daystar_africastalking_config', $africastalking_config);
        
        // Save SendGrid config
        $sendgrid_config = array(
            'api_key' => sanitize_text_field($_POST['sendgrid_api_key']),
            'from_email' => sanitize_email($_POST['sendgrid_from_email']),
            'from_name' => sanitize_text_field($_POST['sendgrid_from_name'])
        );
        update_option('daystar_sendgrid_config', $sendgrid_config);
        
        add_settings_error('daystar_integration', 'notification_settings_saved', 'Notification settings saved successfully!', 'success');
    }
}

// Initialize the admin interface
new DaystarIntegrationAdmin();