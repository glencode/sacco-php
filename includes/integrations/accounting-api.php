<?php
/**
 * Accounting System API Integration
 * 
 * Provides RESTful API endpoints for external accounting system integration
 * Handles data synchronization between SACCO system and accounting software
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accounting API Configuration
 */
class DaystarAccountingAPI {
    
    private $api_version = 'v1';
    private $namespace = 'daystar-accounting';
    
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
        add_action('init', array($this, 'setup_authentication'));
    }
    
    /**
     * Register REST API routes
     */
    public function register_routes() {
        $namespace = $this->namespace . '/' . $this->api_version;
        
        // Loans endpoints
        register_rest_route($namespace, '/loans', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_loans'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'status' => array(
                    'description' => 'Filter by loan status',
                    'type' => 'string',
                    'enum' => array('active', 'completed', 'defaulted', 'pending')
                ),
                'date_from' => array(
                    'description' => 'Filter loans from date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'date_to' => array(
                    'description' => 'Filter loans to date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'page' => array(
                    'description' => 'Page number for pagination',
                    'type' => 'integer',
                    'default' => 1
                ),
                'per_page' => array(
                    'description' => 'Number of items per page',
                    'type' => 'integer',
                    'default' => 50,
                    'maximum' => 100
                )
            )
        ));
        
        register_rest_route($namespace, '/loans/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_loan'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'id' => array(
                    'description' => 'Loan ID',
                    'type' => 'integer'
                )
            )
        ));
        
        // Repayments endpoints
        register_rest_route($namespace, '/repayments', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_repayments'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'loan_id' => array(
                    'description' => 'Filter by loan ID',
                    'type' => 'integer'
                ),
                'member_id' => array(
                    'description' => 'Filter by member ID',
                    'type' => 'integer'
                ),
                'date_from' => array(
                    'description' => 'Filter repayments from date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'date_to' => array(
                    'description' => 'Filter repayments to date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'page' => array(
                    'description' => 'Page number for pagination',
                    'type' => 'integer',
                    'default' => 1
                ),
                'per_page' => array(
                    'description' => 'Number of items per page',
                    'type' => 'integer',
                    'default' => 50,
                    'maximum' => 100
                )
            )
        ));
        
        // Contributions endpoints
        register_rest_route($namespace, '/contributions', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_contributions'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'member_id' => array(
                    'description' => 'Filter by member ID',
                    'type' => 'integer'
                ),
                'date_from' => array(
                    'description' => 'Filter contributions from date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'date_to' => array(
                    'description' => 'Filter contributions to date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'page' => array(
                    'description' => 'Page number for pagination',
                    'type' => 'integer',
                    'default' => 1
                ),
                'per_page' => array(
                    'description' => 'Number of items per page',
                    'type' => 'integer',
                    'default' => 50,
                    'maximum' => 100
                )
            )
        ));
        
        // Members endpoints
        register_rest_route($namespace, '/members', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_members'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'status' => array(
                    'description' => 'Filter by member status',
                    'type' => 'string',
                    'enum' => array('active', 'inactive', 'suspended')
                ),
                'page' => array(
                    'description' => 'Page number for pagination',
                    'type' => 'integer',
                    'default' => 1
                ),
                'per_page' => array(
                    'description' => 'Number of items per page',
                    'type' => 'integer',
                    'default' => 50,
                    'maximum' => 100
                )
            )
        ));
        
        // Financial summary endpoints
        register_rest_route($namespace, '/financial-summary', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_financial_summary'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'period' => array(
                    'description' => 'Summary period',
                    'type' => 'string',
                    'enum' => array('daily', 'weekly', 'monthly', 'quarterly', 'yearly'),
                    'default' => 'monthly'
                ),
                'date_from' => array(
                    'description' => 'Summary from date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                ),
                'date_to' => array(
                    'description' => 'Summary to date (YYYY-MM-DD)',
                    'type' => 'string',
                    'format' => 'date'
                )
            )
        ));
        
        // Webhook registration endpoint
        register_rest_route($namespace, '/webhooks', array(
            'methods' => 'POST',
            'callback' => array($this, 'register_webhook'),
            'permission_callback' => array($this, 'check_api_permissions'),
            'args' => array(
                'url' => array(
                    'description' => 'Webhook URL',
                    'type' => 'string',
                    'format' => 'uri',
                    'required' => true
                ),
                'events' => array(
                    'description' => 'Events to subscribe to',
                    'type' => 'array',
                    'items' => array(
                        'type' => 'string',
                        'enum' => array('loan.created', 'loan.approved', 'loan.disbursed', 'repayment.received', 'contribution.received', 'member.created')
                    ),
                    'required' => true
                ),
                'secret' => array(
                    'description' => 'Webhook secret for verification',
                    'type' => 'string'
                )
            )
        ));
    }
    
    /**
     * Setup API authentication
     */
    public function setup_authentication() {
        // Add custom authentication header support
        add_filter('determine_current_user', array($this, 'authenticate_api_request'), 20);
    }
    
    /**
     * Authenticate API requests using API key
     */
    public function authenticate_api_request($user_id) {
        // Only authenticate for our API endpoints
        if (!$this->is_accounting_api_request()) {
            return $user_id;
        }
        
        $api_key = $this->get_api_key_from_request();
        
        if (!$api_key) {
            return $user_id;
        }
        
        // Validate API key
        $valid_keys = get_option('daystar_accounting_api_keys', array());
        
        foreach ($valid_keys as $key_data) {
            if (hash_equals($key_data['key'], $api_key) && $key_data['active']) {
                // Log API usage
                $this->log_api_usage($key_data['name'], $_SERVER['REQUEST_URI']);
                
                // Return a system user ID for API requests
                return $this->get_api_user_id();
            }
        }
        
        return $user_id;
    }
    
    /**
     * Check if current request is for accounting API
     */
    private function is_accounting_api_request() {
        $request_uri = $_SERVER['REQUEST_URI'];
        return strpos($request_uri, '/wp-json/' . $this->namespace . '/') !== false;
    }
    
    /**
     * Get API key from request headers or query parameters
     */
    private function get_api_key_from_request() {
        // Check Authorization header
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        
        // Check X-API-Key header
        if (isset($headers['X-API-Key'])) {
            return $headers['X-API-Key'];
        }
        
        // Check query parameter
        if (isset($_GET['api_key'])) {
            return $_GET['api_key'];
        }
        
        return null;
    }
    
    /**
     * Get or create API user ID
     */
    private function get_api_user_id() {
        $api_user = get_user_by('login', 'accounting_api_user');
        
        if (!$api_user) {
            // Create API user
            $user_id = wp_insert_user(array(
                'user_login' => 'accounting_api_user',
                'user_email' => 'api@daystar.co.ke',
                'user_pass' => wp_generate_password(32),
                'role' => 'api_user',
                'display_name' => 'Accounting API User'
            ));
            
            if (!is_wp_error($user_id)) {
                return $user_id;
            }
        }
        
        return $api_user->ID;
    }
    
    /**
     * Log API usage
     */
    private function log_api_usage($api_name, $endpoint) {
        $log_entry = array(
            'timestamp' => current_time('mysql'),
            'api_name' => $api_name,
            'endpoint' => $endpoint,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
        
        $logs = get_option('daystar_api_usage_logs', array());
        $logs[] = $log_entry;
        
        // Keep only last 1000 entries
        if (count($logs) > 1000) {
            $logs = array_slice($logs, -1000);
        }
        
        update_option('daystar_api_usage_logs', $logs);
    }
    
    /**
     * Check API permissions
     */
    public function check_api_permissions($request) {
        $api_key = $this->get_api_key_from_request();
        
        if (!$api_key) {
            return new WP_Error('no_api_key', 'API key is required', array('status' => 401));
        }
        
        $valid_keys = get_option('daystar_accounting_api_keys', array());
        
        foreach ($valid_keys as $key_data) {
            if (hash_equals($key_data['key'], $api_key) && $key_data['active']) {
                return true;
            }
        }
        
        return new WP_Error('invalid_api_key', 'Invalid API key', array('status' => 401));
    }
    
    /**
     * Get loans endpoint
     */
    public function get_loans($request) {
        global $wpdb;
        
        $params = $request->get_params();
        $page = intval($params['page']);
        $per_page = intval($params['per_page']);
        $offset = ($page - 1) * $per_page;
        
        // Build query conditions
        $where_conditions = array('1=1');
        $where_values = array();
        
        if (!empty($params['status'])) {
            $where_conditions[] = 'status = %s';
            $where_values[] = $params['status'];
        }
        
        if (!empty($params['date_from'])) {
            $where_conditions[] = 'application_date >= %s';
            $where_values[] = $params['date_from'];
        }
        
        if (!empty($params['date_to'])) {
            $where_conditions[] = 'application_date <= %s';
            $where_values[] = $params['date_to'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        // Get total count
        $count_query = "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans WHERE {$where_clause}";
        if (!empty($where_values)) {
            $count_query = $wpdb->prepare($count_query, $where_values);
        }
        $total_items = $wpdb->get_var($count_query);
        
        // Get loans
        $query = "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE {$where_clause} ORDER BY application_date DESC LIMIT %d OFFSET %d";
        $query_values = array_merge($where_values, array($per_page, $offset));
        $loans = $wpdb->get_results($wpdb->prepare($query, $query_values), ARRAY_A);
        
        // Format loans for API response
        $formatted_loans = array();
        foreach ($loans as $loan) {
            $formatted_loans[] = $this->format_loan_for_api($loan);
        }
        
        return new WP_REST_Response(array(
            'loans' => $formatted_loans,
            'pagination' => array(
                'page' => $page,
                'per_page' => $per_page,
                'total_items' => intval($total_items),
                'total_pages' => ceil($total_items / $per_page)
            )
        ), 200);
    }
    
    /**
     * Get single loan endpoint
     */
    public function get_loan($request) {
        global $wpdb;
        
        $loan_id = intval($request['id']);
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ), ARRAY_A);
        
        if (!$loan) {
            return new WP_Error('loan_not_found', 'Loan not found', array('status' => 404));
        }
        
        // Get loan repayments
        $repayments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loan_repayments WHERE loan_id = %d ORDER BY payment_date DESC",
            $loan_id
        ), ARRAY_A);
        
        $formatted_loan = $this->format_loan_for_api($loan);
        $formatted_loan['repayments'] = array_map(array($this, 'format_repayment_for_api'), $repayments);
        
        return new WP_REST_Response($formatted_loan, 200);
    }
    
    /**
     * Get repayments endpoint
     */
    public function get_repayments($request) {
        global $wpdb;
        
        $params = $request->get_params();
        $page = intval($params['page']);
        $per_page = intval($params['per_page']);
        $offset = ($page - 1) * $per_page;
        
        // Build query conditions
        $where_conditions = array('1=1');
        $where_values = array();
        
        if (!empty($params['loan_id'])) {
            $where_conditions[] = 'loan_id = %d';
            $where_values[] = intval($params['loan_id']);
        }
        
        if (!empty($params['member_id'])) {
            $where_conditions[] = 'member_id = %d';
            $where_values[] = intval($params['member_id']);
        }
        
        if (!empty($params['date_from'])) {
            $where_conditions[] = 'payment_date >= %s';
            $where_values[] = $params['date_from'];
        }
        
        if (!empty($params['date_to'])) {
            $where_conditions[] = 'payment_date <= %s';
            $where_values[] = $params['date_to'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        // Get total count
        $count_query = "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_repayments WHERE {$where_clause}";
        if (!empty($where_values)) {
            $count_query = $wpdb->prepare($count_query, $where_values);
        }
        $total_items = $wpdb->get_var($count_query);
        
        // Get repayments
        $query = "SELECT * FROM {$wpdb->prefix}daystar_loan_repayments WHERE {$where_clause} ORDER BY payment_date DESC LIMIT %d OFFSET %d";
        $query_values = array_merge($where_values, array($per_page, $offset));
        $repayments = $wpdb->get_results($wpdb->prepare($query, $query_values), ARRAY_A);
        
        // Format repayments for API response
        $formatted_repayments = array_map(array($this, 'format_repayment_for_api'), $repayments);
        
        return new WP_REST_Response(array(
            'repayments' => $formatted_repayments,
            'pagination' => array(
                'page' => $page,
                'per_page' => $per_page,
                'total_items' => intval($total_items),
                'total_pages' => ceil($total_items / $per_page)
            )
        ), 200);
    }
    
    /**
     * Get contributions endpoint
     */
    public function get_contributions($request) {
        global $wpdb;
        
        $params = $request->get_params();
        $page = intval($params['page']);
        $per_page = intval($params['per_page']);
        $offset = ($page - 1) * $per_page;
        
        // Build query conditions
        $where_conditions = array('1=1');
        $where_values = array();
        
        if (!empty($params['member_id'])) {
            $where_conditions[] = 'member_id = %d';
            $where_values[] = intval($params['member_id']);
        }
        
        if (!empty($params['date_from'])) {
            $where_conditions[] = 'contribution_date >= %s';
            $where_values[] = $params['date_from'];
        }
        
        if (!empty($params['date_to'])) {
            $where_conditions[] = 'contribution_date <= %s';
            $where_values[] = $params['date_to'];
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        
        // Get total count
        $count_query = "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_contributions WHERE {$where_clause}";
        if (!empty($where_values)) {
            $count_query = $wpdb->prepare($count_query, $where_values);
        }
        $total_items = $wpdb->get_var($count_query);
        
        // Get contributions
        $query = "SELECT * FROM {$wpdb->prefix}daystar_contributions WHERE {$where_clause} ORDER BY contribution_date DESC LIMIT %d OFFSET %d";
        $query_values = array_merge($where_values, array($per_page, $offset));
        $contributions = $wpdb->get_results($wpdb->prepare($query, $query_values), ARRAY_A);
        
        // Format contributions for API response
        $formatted_contributions = array_map(array($this, 'format_contribution_for_api'), $contributions);
        
        return new WP_REST_Response(array(
            'contributions' => $formatted_contributions,
            'pagination' => array(
                'page' => $page,
                'per_page' => $per_page,
                'total_items' => intval($total_items),
                'total_pages' => ceil($total_items / $per_page)
            )
        ), 200);
    }
    
    /**
     * Get members endpoint
     */
    public function get_members($request) {
        $params = $request->get_params();
        $page = intval($params['page']);
        $per_page = intval($params['per_page']);
        
        $args = array(
            'role' => 'member',
            'number' => $per_page,
            'offset' => ($page - 1) * $per_page,
            'orderby' => 'registered',
            'order' => 'DESC'
        );
        
        if (!empty($params['status'])) {
            $args['meta_query'] = array(
                array(
                    'key' => 'member_status',
                    'value' => $params['status'],
                    'compare' => '='
                )
            );
        }
        
        $user_query = new WP_User_Query($args);
        $members = $user_query->get_results();
        $total_members = $user_query->get_total();
        
        // Format members for API response
        $formatted_members = array();
        foreach ($members as $member) {
            $formatted_members[] = $this->format_member_for_api($member);
        }
        
        return new WP_REST_Response(array(
            'members' => $formatted_members,
            'pagination' => array(
                'page' => $page,
                'per_page' => $per_page,
                'total_items' => intval($total_members),
                'total_pages' => ceil($total_members / $per_page)
            )
        ), 200);
    }
    
    /**
     * Get financial summary endpoint
     */
    public function get_financial_summary($request) {
        global $wpdb;
        
        $params = $request->get_params();
        $period = $params['period'];
        $date_from = $params['date_from'] ?? date('Y-m-01'); // First day of current month
        $date_to = $params['date_to'] ?? date('Y-m-t'); // Last day of current month
        
        // Get loan disbursements
        $loan_disbursements = $wpdb->get_var($wpdb->prepare(
            "SELECT COALESCE(SUM(amount), 0) FROM {$wpdb->prefix}daystar_loans 
             WHERE status = 'disbursed' AND disbursement_date BETWEEN %s AND %s",
            $date_from, $date_to
        ));
        
        // Get loan repayments
        $loan_repayments = $wpdb->get_var($wpdb->prepare(
            "SELECT COALESCE(SUM(amount), 0) FROM {$wpdb->prefix}daystar_loan_repayments 
             WHERE payment_date BETWEEN %s AND %s",
            $date_from, $date_to
        ));
        
        // Get contributions
        $contributions = $wpdb->get_var($wpdb->prepare(
            "SELECT COALESCE(SUM(amount), 0) FROM {$wpdb->prefix}daystar_contributions 
             WHERE contribution_date BETWEEN %s AND %s",
            $date_from, $date_to
        ));
        
        // Get outstanding loans
        $outstanding_loans = $wpdb->get_var(
            "SELECT COALESCE(SUM(amount - paid_amount), 0) FROM {$wpdb->prefix}daystar_loans 
             WHERE status IN ('active', 'disbursed')"
        );
        
        // Get total members
        $total_members = count(get_users(array('role' => 'member')));
        
        // Get active members (members with activity in the period)
        $active_members = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT member_id) FROM (
                SELECT member_id FROM {$wpdb->prefix}daystar_loan_repayments WHERE payment_date BETWEEN %s AND %s
                UNION
                SELECT member_id FROM {$wpdb->prefix}daystar_contributions WHERE contribution_date BETWEEN %s AND %s
            ) as active_members",
            $date_from, $date_to, $date_from, $date_to
        ));
        
        return new WP_REST_Response(array(
            'period' => array(
                'from' => $date_from,
                'to' => $date_to,
                'type' => $period
            ),
            'financial_data' => array(
                'loan_disbursements' => floatval($loan_disbursements),
                'loan_repayments' => floatval($loan_repayments),
                'contributions' => floatval($contributions),
                'outstanding_loans' => floatval($outstanding_loans),
                'net_cash_flow' => floatval($loan_repayments + $contributions - $loan_disbursements)
            ),
            'member_data' => array(
                'total_members' => intval($total_members),
                'active_members' => intval($active_members)
            ),
            'generated_at' => current_time('c')
        ), 200);
    }
    
    /**
     * Register webhook endpoint
     */
    public function register_webhook($request) {
        $params = $request->get_params();
        
        $webhook = array(
            'id' => wp_generate_uuid4(),
            'url' => $params['url'],
            'events' => $params['events'],
            'secret' => $params['secret'] ?? wp_generate_password(32),
            'active' => true,
            'created_at' => current_time('mysql')
        );
        
        $webhooks = get_option('daystar_accounting_webhooks', array());
        $webhooks[$webhook['id']] = $webhook;
        update_option('daystar_accounting_webhooks', $webhooks);
        
        return new WP_REST_Response(array(
            'webhook_id' => $webhook['id'],
            'message' => 'Webhook registered successfully'
        ), 201);
    }
    
    /**
     * Format loan data for API response
     */
    private function format_loan_for_api($loan) {
        return array(
            'id' => intval($loan['id']),
            'member_id' => intval($loan['member_id']),
            'member_number' => get_user_meta($loan['member_id'], 'member_number', true),
            'product_id' => intval($loan['product_id']),
            'amount' => floatval($loan['amount']),
            'interest_rate' => floatval($loan['interest_rate']),
            'term_months' => intval($loan['term_months']),
            'monthly_payment' => floatval($loan['monthly_payment']),
            'total_payable' => floatval($loan['total_payable']),
            'paid_amount' => floatval($loan['paid_amount']),
            'balance' => floatval($loan['amount'] - $loan['paid_amount']),
            'status' => $loan['status'],
            'application_date' => $loan['application_date'],
            'approval_date' => $loan['approval_date'],
            'disbursement_date' => $loan['disbursement_date'],
            'due_date' => $loan['due_date'],
            'purpose' => $loan['purpose']
        );
    }
    
    /**
     * Format repayment data for API response
     */
    private function format_repayment_for_api($repayment) {
        return array(
            'id' => intval($repayment['id']),
            'loan_id' => intval($repayment['loan_id']),
            'member_id' => intval($repayment['member_id']),
            'amount' => floatval($repayment['amount']),
            'payment_method' => $repayment['payment_method'],
            'payment_reference' => $repayment['payment_reference'],
            'payment_date' => $repayment['payment_date'],
            'principal_amount' => floatval($repayment['principal_amount']),
            'interest_amount' => floatval($repayment['interest_amount']),
            'penalty_amount' => floatval($repayment['penalty_amount'] ?? 0),
            'status' => $repayment['status']
        );
    }
    
    /**
     * Format contribution data for API response
     */
    private function format_contribution_for_api($contribution) {
        return array(
            'id' => intval($contribution['id']),
            'member_id' => intval($contribution['member_id']),
            'member_number' => get_user_meta($contribution['member_id'], 'member_number', true),
            'amount' => floatval($contribution['amount']),
            'contribution_type' => $contribution['contribution_type'],
            'payment_method' => $contribution['payment_method'],
            'payment_reference' => $contribution['payment_reference'],
            'contribution_date' => $contribution['contribution_date'],
            'status' => $contribution['status']
        );
    }
    
    /**
     * Format member data for API response
     */
    private function format_member_for_api($member) {
        return array(
            'id' => intval($member->ID),
            'member_number' => get_user_meta($member->ID, 'member_number', true),
            'first_name' => $member->first_name,
            'last_name' => $member->last_name,
            'email' => $member->user_email,
            'phone' => get_user_meta($member->ID, 'phone', true),
            'id_number' => get_user_meta($member->ID, 'id_number', true),
            'registration_date' => $member->user_registered,
            'status' => get_user_meta($member->ID, 'member_status', true) ?: 'active',
            'total_contributions' => floatval(get_user_meta($member->ID, 'total_contributions', true)),
            'share_capital' => floatval(get_user_meta($member->ID, 'share_capital', true))
        );
    }
}

// Initialize the accounting API
new DaystarAccountingAPI();

/**
 * Webhook trigger functions
 */
function daystar_trigger_webhook($event, $data) {
    $webhooks = get_option('daystar_accounting_webhooks', array());
    
    foreach ($webhooks as $webhook) {
        if (!$webhook['active'] || !in_array($event, $webhook['events'])) {
            continue;
        }
        
        $payload = array(
            'event' => $event,
            'data' => $data,
            'timestamp' => current_time('c'),
            'webhook_id' => $webhook['id']
        );
        
        // Add signature for verification
        $signature = hash_hmac('sha256', json_encode($payload), $webhook['secret']);
        
        // Send webhook asynchronously
        wp_remote_post($webhook['url'], array(
            'body' => json_encode($payload),
            'headers' => array(
                'Content-Type' => 'application/json',
                'X-Daystar-Signature' => 'sha256=' . $signature,
                'X-Daystar-Event' => $event
            ),
            'timeout' => 30,
            'blocking' => false
        ));
    }
}

// Hook into various events to trigger webhooks
add_action('daystar_loan_created', function($loan_id) {
    global $wpdb;
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
        $loan_id
    ), ARRAY_A);
    
    if ($loan) {
        daystar_trigger_webhook('loan.created', $loan);
    }
});

add_action('daystar_loan_approved', function($loan_id) {
    global $wpdb;
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
        $loan_id
    ), ARRAY_A);
    
    if ($loan) {
        daystar_trigger_webhook('loan.approved', $loan);
    }
});

add_action('daystar_loan_disbursed', function($loan_id) {
    global $wpdb;
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
        $loan_id
    ), ARRAY_A);
    
    if ($loan) {
        daystar_trigger_webhook('loan.disbursed', $loan);
    }
});

add_action('daystar_repayment_received', function($repayment_id) {
    global $wpdb;
    $repayment = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}daystar_loan_repayments WHERE id = %d",
        $repayment_id
    ), ARRAY_A);
    
    if ($repayment) {
        daystar_trigger_webhook('repayment.received', $repayment);
    }
});

add_action('daystar_contribution_received', function($contribution_id) {
    global $wpdb;
    $contribution = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}daystar_contributions WHERE id = %d",
        $contribution_id
    ), ARRAY_A);
    
    if ($contribution) {
        daystar_trigger_webhook('contribution.received', $contribution);
    }
});

add_action('user_register', function($user_id) {
    $user = get_user_by('id', $user_id);
    if ($user && in_array('member', $user->roles)) {
        daystar_trigger_webhook('member.created', array(
            'id' => $user_id,
            'member_number' => get_user_meta($user_id, 'member_number', true),
            'email' => $user->user_email,
            'registration_date' => $user->user_registered
        ));
    }
});