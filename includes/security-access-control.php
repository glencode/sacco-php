<?php
/**
 * Security & Access Control System
 * Implements comprehensive RBAC, audit logging, and security measures
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize Security & Access Control System
 */
class Daystar_Security_Access_Control {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init_security_system'));
        add_action('wp_loaded', array($this, 'setup_custom_roles'));
        add_action('admin_init', array($this, 'create_audit_table'));
        
        // Security hooks
        add_action('wp_login', array($this, 'log_user_login'), 10, 2);
        add_action('wp_logout', array($this, 'log_user_logout'));
        add_action('wp_login_failed', array($this, 'log_failed_login'));
        
        // HTTPS enforcement
        add_action('template_redirect', array($this, 'enforce_https'));
        
        // Input sanitization hooks
        add_filter('pre_user_login', array($this, 'sanitize_user_input'));
        add_filter('pre_user_email', array($this, 'sanitize_email_input'));
        
        // CSRF protection
        add_action('wp_enqueue_scripts', array($this, 'enqueue_security_scripts'));
    }
    
    /**
     * Initialize the security system
     */
    public function init_security_system() {
        // Force secure cookies if HTTPS
        if (is_ssl()) {
            ini_set('session.cookie_secure', 1);
            ini_set('session.cookie_httponly', 1);
        }
        
        // Set security headers
        $this->set_security_headers();
    }
    
    /**
     * Set security headers
     */
    private function set_security_headers() {
        if (!headers_sent()) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
            
            if (is_ssl()) {
                header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
            }
        }
    }
    
    /**
     * Enforce HTTPS for the entire site
     */
    public function enforce_https() {
        if (!is_ssl() && !is_admin()) {
            $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            wp_redirect($redirect_url, 301);
            exit;
        }
    }
    
    /**
     * Setup custom WordPress roles and capabilities
     */
    public function setup_custom_roles() {
        // Remove default roles we don't need
        $this->cleanup_default_roles();
        
        // Add custom roles
        $this->add_loan_officer_role();
        $this->add_credit_committee_role();
        $this->add_treasurer_role();
        $this->add_cmc_member_role();
        $this->add_member_role();
        
        // Update administrator capabilities
        $this->update_administrator_capabilities();
    }
    
    /**
     * Clean up default WordPress roles
     */
    private function cleanup_default_roles() {
        // Remove unnecessary default roles
        $roles_to_remove = array('subscriber', 'contributor', 'author', 'editor');
        
        foreach ($roles_to_remove as $role) {
            if (get_role($role)) {
                remove_role($role);
            }
        }
    }
    
    /**
     * Add Loan Officer role
     */
    private function add_loan_officer_role() {
        $capabilities = array(
            'read' => true,
            'manage_loan_applications' => true,
            'view_member_data' => true,
            'verify_payslips' => true,
            'calculate_eligibility' => true,
            'generate_loan_reports' => true,
            'access_loan_dashboard' => true,
            'edit_loan_applications' => true,
            'view_loan_schedules' => true,
            'manage_guarantors' => true,
            'verify_collateral' => true,
            'upload_files' => true,
        );
        
        add_role('loan_officer', 'Loan Officer', $capabilities);
    }
    
    /**
     * Add Credit Committee Member role
     */
    private function add_credit_committee_role() {
        $capabilities = array(
            'read' => true,
            'approve_loans' => true,
            'reject_loans' => true,
            'view_loan_applications' => true,
            'view_member_data' => true,
            'view_credit_reports' => true,
            'manage_loan_appeals' => true,
            'set_loan_conditions' => true,
            'view_risk_assessments' => true,
            'access_committee_dashboard' => true,
            'manage_credit_policy' => true,
            'view_delinquency_reports' => true,
        );
        
        add_role('credit_committee', 'Credit Committee Member', $capabilities);
    }
    
    /**
     * Add Treasurer role
     */
    private function add_treasurer_role() {
        $capabilities = array(
            'read' => true,
            'disburse_loans' => true,
            'manage_payments' => true,
            'view_all_reports' => true,
            'manage_financial_data' => true,
            'access_treasury_dashboard' => true,
            'view_member_data' => true,
            'generate_financial_reports' => true,
            'manage_loan_disbursements' => true,
            'verify_payments' => true,
            'manage_reconciliation' => true,
            'view_audit_logs' => true,
            'export_financial_data' => true,
            'manage_deduction_lists' => true,
        );
        
        add_role('treasurer', 'Treasurer', $capabilities);
    }
    
    /**
     * Add CMC Member role
     */
    private function add_cmc_member_role() {
        $capabilities = array(
            'read' => true,
            'view_all_reports' => true,
            'access_cmc_dashboard' => true,
            'view_member_data' => true,
            'view_financial_summaries' => true,
            'view_policy_documents' => true,
            'view_audit_logs' => true,
            'monitor_compliance' => true,
            'view_risk_reports' => true,
            'access_governance_tools' => true,
        );
        
        add_role('cmc_member', 'CMC Member', $capabilities);
    }
    
    /**
     * Add Member role
     */
    private function add_member_role() {
        $capabilities = array(
            'read' => true,
            'member' => true,
            'apply_for_loans' => true,
            'view_own_data' => true,
            'update_profile' => true,
            'view_own_loans' => true,
            'make_payments' => true,
            'view_statements' => true,
            'upload_documents' => true,
            'submit_appeals' => true,
            'access_member_dashboard' => true,
        );
        
        add_role('member', 'Member', $capabilities);
    }
    
    /**
     * Update administrator capabilities
     */
    private function update_administrator_capabilities() {
        $admin_role = get_role('administrator');
        if ($admin_role) {
            // Add all custom capabilities to administrator
            $custom_capabilities = array(
                'manage_loan_applications', 'approve_loans', 'reject_loans', 'disburse_loans',
                'view_member_data', 'manage_members_data', 'view_all_reports', 'manage_credit_policy',
                'verify_payslips', 'calculate_eligibility', 'manage_payments', 'manage_financial_data',
                'view_audit_logs', 'manage_system_security', 'access_admin_dashboard',
                'manage_user_roles', 'view_system_logs', 'manage_backup_restore',
                'configure_system_settings', 'manage_integrations'
            );
            
            foreach ($custom_capabilities as $cap) {
                $admin_role->add_cap($cap);
            }
        }
    }
    
    /**
     * Create audit log table
     */
    public function create_audit_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        
        // Check if table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = $wpdb->get_charset_collate();
            
            $sql = "CREATE TABLE $table_name (
                log_id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id bigint(20) NOT NULL,
                action varchar(100) NOT NULL,
                object_type varchar(50) NOT NULL,
                object_id bigint(20) DEFAULT NULL,
                details longtext DEFAULT NULL,
                ip_address varchar(45) NOT NULL,
                user_agent text DEFAULT NULL,
                timestamp datetime DEFAULT CURRENT_TIMESTAMP,
                session_id varchar(255) DEFAULT NULL,
                severity varchar(20) DEFAULT 'info',
                PRIMARY KEY (log_id),
                KEY user_id (user_id),
                KEY action (action),
                KEY object_type (object_type),
                KEY object_id (object_id),
                KEY timestamp (timestamp),
                KEY severity (severity),
                KEY ip_address (ip_address)
            ) $charset_collate;";
            
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
    
    /**
     * Log user actions for audit trail
     */
    public static function log_action($action, $object_type = '', $object_id = null, $details = array(), $severity = 'info') {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        
        // Check if table exists, create if it doesn't
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            self::create_audit_table_static();
        }
        
        $user_id = get_current_user_id();
        $ip_address = self::get_client_ip();
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
        $session_id = session_id();
        
        // Sanitize and prepare details
        $details_json = wp_json_encode($details);
        
        $wpdb->insert(
            $table_name,
            array(
                'user_id' => $user_id,
                'action' => sanitize_text_field($action),
                'object_type' => sanitize_text_field($object_type),
                'object_id' => $object_id,
                'details' => $details_json,
                'ip_address' => $ip_address,
                'user_agent' => $user_agent,
                'session_id' => $session_id,
                'severity' => sanitize_text_field($severity),
                'timestamp' => current_time('mysql')
            ),
            array('%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s')
        );
    }
    
    /**
     * Static method to create audit table
     */
    private static function create_audit_table_static() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            log_id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            action varchar(100) NOT NULL,
            object_type varchar(50) NOT NULL,
            object_id bigint(20) DEFAULT NULL,
            details longtext DEFAULT NULL,
            ip_address varchar(45) NOT NULL,
            user_agent text DEFAULT NULL,
            timestamp datetime DEFAULT CURRENT_TIMESTAMP,
            session_id varchar(255) DEFAULT NULL,
            severity varchar(20) DEFAULT 'info',
            PRIMARY KEY (log_id),
            KEY user_id (user_id),
            KEY action (action),
            KEY object_type (object_type),
            KEY object_id (object_id),
            KEY timestamp (timestamp),
            KEY severity (severity),
            KEY ip_address (ip_address)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Get client IP address
     */
    private static function get_client_ip() {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    }
    
    /**
     * Log user login
     */
    public function log_user_login($user_login, $user) {
        self::log_action(
            'user_login',
            'user',
            $user->ID,
            array(
                'username' => $user_login,
                'user_email' => $user->user_email,
                'user_roles' => $user->roles
            ),
            'info'
        );
    }
    
    /**
     * Log user logout
     */
    public function log_user_logout() {
        $user_id = get_current_user_id();
        if ($user_id) {
            self::log_action(
                'user_logout',
                'user',
                $user_id,
                array(),
                'info'
            );
        }
    }
    
    /**
     * Log failed login attempts
     */
    public function log_failed_login($username) {
        self::log_action(
            'login_failed',
            'user',
            null,
            array(
                'attempted_username' => $username,
                'timestamp' => current_time('mysql')
            ),
            'warning'
        );
    }
    
    /**
     * Sanitize user input
     */
    public function sanitize_user_input($input) {
        return sanitize_user($input, true);
    }
    
    /**
     * Sanitize email input
     */
    public function sanitize_email_input($email) {
        return sanitize_email($email);
    }
    
    /**
     * Enqueue security scripts
     */
    public function enqueue_security_scripts() {
        wp_localize_script('jquery', 'daystar_security', array(
            'nonce' => wp_create_nonce('daystar_security_nonce'),
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}

/**
 * Security Helper Functions
 */

/**
 * Check if current user has specific capability
 */
function daystar_user_can($capability, $object_id = null) {
    if ($object_id) {
        return current_user_can($capability, $object_id);
    }
    return current_user_can($capability);
}

/**
 * Require specific capability or redirect
 */
function daystar_require_capability($capability, $redirect_url = null) {
    if (!daystar_user_can($capability)) {
        if (!$redirect_url) {
            $redirect_url = home_url('/login/?message=insufficient_permissions');
        }
        
        Daystar_Security_Access_Control::log_action(
            'access_denied',
            'capability_check',
            null,
            array(
                'required_capability' => $capability,
                'user_capabilities' => wp_get_current_user()->allcaps
            ),
            'warning'
        );
        
        wp_redirect($redirect_url);
        exit;
    }
}

/**
 * Enhanced member access check with role-based permissions
 */
function daystar_check_enhanced_member_access($required_capabilities = array(), $redirect_to = '') {
    if (!is_user_logged_in()) {
        nocache_headers();
        if (empty($redirect_to)) {
            $redirect_to = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        $login_url = home_url('/login/?redirect_to=' . urlencode($redirect_to));
        wp_redirect($login_url);
        exit;
    }

    $current_user = wp_get_current_user();
    
    // Check if user has any of the required capabilities
    if (!empty($required_capabilities)) {
        $has_permission = false;
        foreach ($required_capabilities as $capability) {
            if (daystar_user_can($capability)) {
                $has_permission = true;
                break;
            }
        }
        
        if (!$has_permission) {
            Daystar_Security_Access_Control::log_action(
                'access_denied',
                'page_access',
                null,
                array(
                    'required_capabilities' => $required_capabilities,
                    'user_roles' => $current_user->roles,
                    'requested_url' => $_SERVER['REQUEST_URI']
                ),
                'warning'
            );
            
            nocache_headers();
            wp_redirect(home_url('/login/?message=insufficient_permissions'));
            exit;
        }
    }

    return $current_user;
}

/**
 * Data encryption functions
 */

/**
 * Encrypt sensitive data
 */
function daystar_encrypt_data($data, $key = null) {
    if (!$key) {
        $key = defined('DAYSTAR_ENCRYPTION_KEY') ? DAYSTAR_ENCRYPTION_KEY : wp_salt('secure_auth');
    }
    
    $method = 'AES-256-CBC';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    
    return base64_encode($iv . $encrypted);
}

/**
 * Decrypt sensitive data
 */
function daystar_decrypt_data($encrypted_data, $key = null) {
    if (!$key) {
        $key = defined('DAYSTAR_ENCRYPTION_KEY') ? DAYSTAR_ENCRYPTION_KEY : wp_salt('secure_auth');
    }
    
    $data = base64_decode($encrypted_data);
    $method = 'AES-256-CBC';
    $iv_length = openssl_cipher_iv_length($method);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    
    return openssl_decrypt($encrypted, $method, $key, 0, $iv);
}

/**
 * Enhanced input validation and sanitization
 */

/**
 * Validate and sanitize loan application data
 */
function daystar_validate_loan_application($data) {
    $errors = array();
    $sanitized_data = array();
    
    // Validate loan amount
    if (empty($data['loan_amount']) || !is_numeric($data['loan_amount']) || $data['loan_amount'] <= 0) {
        $errors[] = 'Invalid loan amount';
    } else {
        $sanitized_data['loan_amount'] = floatval($data['loan_amount']);
    }
    
    // Validate loan type
    if (empty($data['loan_type'])) {
        $errors[] = 'Loan type is required';
    } else {
        $sanitized_data['loan_type'] = sanitize_text_field($data['loan_type']);
    }
    
    // Validate term months
    if (empty($data['term_months']) || !is_numeric($data['term_months']) || $data['term_months'] <= 0) {
        $errors[] = 'Invalid loan term';
    } else {
        $sanitized_data['term_months'] = intval($data['term_months']);
    }
    
    // Validate purpose
    if (!empty($data['purpose'])) {
        $sanitized_data['purpose'] = sanitize_textarea_field($data['purpose']);
    }
    
    // Log validation attempt
    Daystar_Security_Access_Control::log_action(
        'loan_application_validation',
        'loan',
        null,
        array(
            'validation_errors' => $errors,
            'data_fields' => array_keys($data)
        ),
        empty($errors) ? 'info' : 'warning'
    );
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors,
        'data' => $sanitized_data
    );
}

/**
 * Validate and sanitize member data
 */
function daystar_validate_member_data($data) {
    $errors = array();
    $sanitized_data = array();
    
    // Validate email
    if (!empty($data['email'])) {
        if (!is_email($data['email'])) {
            $errors[] = 'Invalid email address';
        } else {
            $sanitized_data['email'] = sanitize_email($data['email']);
        }
    }
    
    // Validate phone number
    if (!empty($data['phone'])) {
        $phone = preg_replace('/[^0-9+]/', '', $data['phone']);
        if (strlen($phone) < 10) {
            $errors[] = 'Invalid phone number';
        } else {
            $sanitized_data['phone'] = $phone;
        }
    }
    
    // Validate national ID
    if (!empty($data['national_id'])) {
        $national_id = preg_replace('/[^0-9]/', '', $data['national_id']);
        if (strlen($national_id) !== 8) {
            $errors[] = 'Invalid national ID number';
        } else {
            $sanitized_data['national_id'] = $national_id;
        }
    }
    
    // Validate names
    foreach (array('first_name', 'last_name') as $field) {
        if (!empty($data[$field])) {
            if (!preg_match('/^[a-zA-Z\s]+$/', $data[$field])) {
                $errors[] = "Invalid $field";
            } else {
                $sanitized_data[$field] = sanitize_text_field($data[$field]);
            }
        }
    }
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors,
        'data' => $sanitized_data
    );
}

/**
 * CSRF Protection
 */

/**
 * Generate CSRF token
 */
function daystar_generate_csrf_token($action = 'default') {
    return wp_create_nonce('daystar_csrf_' . $action);
}

/**
 * Verify CSRF token
 */
function daystar_verify_csrf_token($token, $action = 'default') {
    return wp_verify_nonce($token, 'daystar_csrf_' . $action);
}

/**
 * Output CSRF token field
 */
function daystar_csrf_field($action = 'default') {
    $token = daystar_generate_csrf_token($action);
    echo '<input type="hidden" name="daystar_csrf_token" value="' . esc_attr($token) . '">';
}

/**
 * Verify CSRF token from request
 */
function daystar_verify_csrf_from_request($action = 'default') {
    $token = isset($_POST['daystar_csrf_token']) ? $_POST['daystar_csrf_token'] : '';
    
    if (!daystar_verify_csrf_token($token, $action)) {
        Daystar_Security_Access_Control::log_action(
            'csrf_token_invalid',
            'security',
            null,
            array(
                'action' => $action,
                'token_provided' => !empty($token)
            ),
            'error'
        );
        
        wp_die('Security check failed. Please try again.', 'Security Error', array('response' => 403));
    }
    
    return true;
}

/**
 * Initialize the security system
 */
function daystar_init_security_system() {
    return Daystar_Security_Access_Control::get_instance();
}

// Initialize the security system
add_action('plugins_loaded', 'daystar_init_security_system');

/**
 * Admin interface for viewing audit logs
 */
function daystar_add_audit_log_admin_page() {
    if (current_user_can('view_audit_logs')) {
        add_management_page(
            'Audit Logs',
            'Audit Logs',
            'view_audit_logs',
            'daystar-audit-logs',
            'daystar_audit_logs_page'
        );
    }
}
add_action('admin_menu', 'daystar_add_audit_log_admin_page');

/**
 * Audit logs admin page
 */
function daystar_audit_logs_page() {
    global $wpdb;
    
    if (!current_user_can('view_audit_logs')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    $table_name = $wpdb->prefix . 'daystar_audit_log';
    $per_page = 50;
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($page - 1) * $per_page;
    
    // Filters
    $where_conditions = array('1=1');
    $where_values = array();
    
    if (!empty($_GET['user_id'])) {
        $where_conditions[] = 'user_id = %d';
        $where_values[] = intval($_GET['user_id']);
    }
    
    if (!empty($_GET['action'])) {
        $where_conditions[] = 'action LIKE %s';
        $where_values[] = '%' . $wpdb->esc_like($_GET['action']) . '%';
    }
    
    if (!empty($_GET['severity'])) {
        $where_conditions[] = 'severity = %s';
        $where_values[] = sanitize_text_field($_GET['severity']);
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Get total count
    $total_query = "SELECT COUNT(*) FROM $table_name WHERE $where_clause";
    if (!empty($where_values)) {
        $total_query = $wpdb->prepare($total_query, $where_values);
    }
    $total_items = $wpdb->get_var($total_query);
    
    // Get logs
    $logs_query = "SELECT * FROM $table_name WHERE $where_clause ORDER BY timestamp DESC LIMIT %d OFFSET %d";
    $query_values = array_merge($where_values, array($per_page, $offset));
    $logs = $wpdb->get_results($wpdb->prepare($logs_query, $query_values));
    
    ?>
    <div class="wrap">
        <h1>Audit Logs</h1>
        
        <form method="get">
            <input type="hidden" name="page" value="daystar-audit-logs">
            <p class="search-box">
                <label for="user_id">User ID:</label>
                <input type="number" name="user_id" value="<?php echo esc_attr($_GET['user_id'] ?? ''); ?>">
                
                <label for="action">Action:</label>
                <input type="text" name="action" value="<?php echo esc_attr($_GET['action'] ?? ''); ?>">
                
                <label for="severity">Severity:</label>
                <select name="severity">
                    <option value="">All</option>
                    <option value="info" <?php selected($_GET['severity'] ?? '', 'info'); ?>>Info</option>
                    <option value="warning" <?php selected($_GET['severity'] ?? '', 'warning'); ?>>Warning</option>
                    <option value="error" <?php selected($_GET['severity'] ?? '', 'error'); ?>>Error</option>
                </select>
                
                <input type="submit" class="button" value="Filter">
            </p>
        </form>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Object Type</th>
                    <th>Object ID</th>
                    <th>IP Address</th>
                    <th>Severity</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <?php $user = get_user_by('id', $log->user_id); ?>
                    <tr>
                        <td><?php echo esc_html($log->timestamp); ?></td>
                        <td><?php echo $user ? esc_html($user->display_name) : 'Unknown'; ?></td>
                        <td><?php echo esc_html($log->action); ?></td>
                        <td><?php echo esc_html($log->object_type); ?></td>
                        <td><?php echo esc_html($log->object_id); ?></td>
                        <td><?php echo esc_html($log->ip_address); ?></td>
                        <td>
                            <span class="severity-<?php echo esc_attr($log->severity); ?>">
                                <?php echo esc_html(ucfirst($log->severity)); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($log->details): ?>
                                <details>
                                    <summary>View Details</summary>
                                    <pre><?php echo esc_html($log->details); ?></pre>
                                </details>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php
        // Pagination
        $total_pages = ceil($total_items / $per_page);
        if ($total_pages > 1) {
            echo '<div class="tablenav"><div class="tablenav-pages">';
            echo paginate_links(array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $total_pages,
                'current' => $page
            ));
            echo '</div></div>';
        }
        ?>
    </div>
    
    <style>
        .severity-info { color: #0073aa; }
        .severity-warning { color: #dba617; }
        .severity-error { color: #dc3232; }
        details summary { cursor: pointer; }
        details pre { background: #f1f1f1; padding: 10px; margin-top: 5px; }
    </style>
    <?php
}