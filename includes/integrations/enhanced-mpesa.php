<?php
/**
 * Enhanced M-Pesa Integration
 * 
 * Full bi-directional M-Pesa functionality with robust error handling,
 * transaction status tracking, and reconciliation capabilities
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced M-Pesa Integration Class
 */
class DaystarEnhancedMPesa {
    
    private $consumer_key;
    private $consumer_secret;
    private $shortcode;
    private $passkey;
    private $initiator_name;
    private $security_credential;
    private $callback_url;
    private $timeout_url;
    private $result_url;
    private $environment;
    
    public function __construct() {
        $this->load_config();
        $this->init_hooks();
        $this->setup_database();
    }
    
    /**
     * Load M-Pesa configuration
     */
    private function load_config() {
        $config = get_option('daystar_mpesa_config', array());
        
        $this->environment = $config['environment'] ?? 'sandbox';
        $this->consumer_key = $config['consumer_key'] ?? '';
        $this->consumer_secret = $config['consumer_secret'] ?? '';
        $this->shortcode = $config['shortcode'] ?? '';
        $this->passkey = $config['passkey'] ?? '';
        $this->initiator_name = $config['initiator_name'] ?? '';
        $this->security_credential = $config['security_credential'] ?? '';
        
        $base_url = home_url();
        $this->callback_url = $base_url . '/wp-json/daystar/v1/mpesa/callback';
        $this->timeout_url = $base_url . '/wp-json/daystar/v1/mpesa/timeout';
        $this->result_url = $base_url . '/wp-json/daystar/v1/mpesa/result';
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        add_action('wp_ajax_mpesa_stk_push', array($this, 'handle_stk_push'));
        add_action('wp_ajax_mpesa_b2c_payment', array($this, 'handle_b2c_payment'));
        add_action('wp_ajax_mpesa_transaction_status', array($this, 'check_transaction_status'));
        add_action('daystar_mpesa_reconciliation', array($this, 'run_reconciliation'));
        
        // Schedule reconciliation
        if (!wp_next_scheduled('daystar_mpesa_reconciliation')) {
            wp_schedule_event(time(), 'hourly', 'daystar_mpesa_reconciliation');
        }
    }
    
    /**
     * Setup database tables for M-Pesa transactions
     */
    private function setup_database() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_mpesa_transactions';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            transaction_type varchar(50) NOT NULL,
            merchant_request_id varchar(100),
            checkout_request_id varchar(100),
            conversation_id varchar(100),
            originator_conversation_id varchar(100),
            transaction_id varchar(100),
            mpesa_receipt_number varchar(100),
            phone_number varchar(20),
            amount decimal(15,2) NOT NULL,
            account_reference varchar(100),
            transaction_desc text,
            member_id bigint(20),
            loan_id bigint(20),
            payment_purpose varchar(50),
            status varchar(20) DEFAULT 'pending',
            result_code varchar(10),
            result_desc text,
            request_data longtext,
            response_data longtext,
            callback_data longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_checkout_request_id (checkout_request_id),
            KEY idx_transaction_id (transaction_id),
            KEY idx_mpesa_receipt (mpesa_receipt_number),
            KEY idx_member_id (member_id),
            KEY idx_status (status),
            KEY idx_created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('daystar/v1', '/mpesa/callback', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_callback'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('daystar/v1', '/mpesa/timeout', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_timeout'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('daystar/v1', '/mpesa/result', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_result'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('daystar/v1', '/mpesa/reconciliation', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_reconciliation_webhook'),
            'permission_callback' => array($this, 'verify_mpesa_webhook')
        ));
    }
    
    /**
     * Get M-Pesa access token
     */
    private function get_access_token() {
        $cache_key = 'daystar_mpesa_access_token';
        $cached_token = get_transient($cache_key);
        
        if ($cached_token) {
            return $cached_token;
        }
        
        $url = $this->get_base_url() . '/oauth/v1/generate?grant_type=client_credentials';
        
        $credentials = base64_encode($this->consumer_key . ':' . $this->consumer_secret);
        
        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json'
            ),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            $this->log_error('Access token request failed', $response->get_error_message());
            throw new Exception('Failed to get access token: ' . $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!isset($data['access_token'])) {
            $this->log_error('Invalid access token response', $body);
            throw new Exception('Invalid access token response');
        }
        
        // Cache token for 50 minutes (expires in 1 hour)
        set_transient($cache_key, $data['access_token'], 3000);
        
        return $data['access_token'];
    }
    
    /**
     * Get M-Pesa base URL based on environment
     */
    private function get_base_url() {
        return $this->environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }
    
    /**
     * Initiate STK Push for customer payments
     */
    public function initiate_stk_push($phone, $amount, $account_reference, $transaction_desc, $member_id = null, $payment_purpose = null) {
        try {
            $access_token = $this->get_access_token();
            
            // Format phone number
            $phone = $this->format_phone_number($phone);
            
            // Generate timestamp and password
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
            $request_data = array(
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $this->callback_url,
                'AccountReference' => $account_reference,
                'TransactionDesc' => $transaction_desc
            );
            
            $url = $this->get_base_url() . '/mpesa/stkpush/v1/processrequest';
            
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode($request_data),
                'timeout' => 30
            ));
            
            if (is_wp_error($response)) {
                throw new Exception('STK Push request failed: ' . $response->get_error_message());
            }
            
            $body = wp_remote_retrieve_body($response);
            $result = json_decode($body, true);
            
            // Save transaction record
            $transaction_id = $this->save_transaction(array(
                'transaction_type' => 'stk_push',
                'merchant_request_id' => $result['MerchantRequestID'] ?? null,
                'checkout_request_id' => $result['CheckoutRequestID'] ?? null,
                'phone_number' => $phone,
                'amount' => $amount,
                'account_reference' => $account_reference,
                'transaction_desc' => $transaction_desc,
                'member_id' => $member_id,
                'payment_purpose' => $payment_purpose,
                'status' => isset($result['ResponseCode']) && $result['ResponseCode'] === '0' ? 'pending' : 'failed',
                'result_code' => $result['ResponseCode'] ?? null,
                'result_desc' => $result['ResponseDescription'] ?? null,
                'request_data' => json_encode($request_data),
                'response_data' => $body
            ));
            
            if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                return array(
                    'success' => true,
                    'transaction_id' => $transaction_id,
                    'checkout_request_id' => $result['CheckoutRequestID'],
                    'merchant_request_id' => $result['MerchantRequestID'],
                    'message' => 'STK push sent successfully'
                );
            } else {
                throw new Exception($result['ResponseDescription'] ?? 'STK push failed');
            }
            
        } catch (Exception $e) {
            $this->log_error('STK Push failed', $e->getMessage(), array(
                'phone' => $phone,
                'amount' => $amount,
                'account_reference' => $account_reference
            ));
            
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Initiate B2C payment for loan disbursements
     */
    public function initiate_b2c_payment($phone, $amount, $remarks, $occasion = null, $member_id = null, $loan_id = null) {
        try {
            $access_token = $this->get_access_token();
            
            // Format phone number
            $phone = $this->format_phone_number($phone);
            
            $request_data = array(
                'InitiatorName' => $this->initiator_name,
                'SecurityCredential' => $this->security_credential,
                'CommandID' => 'BusinessPayment',
                'Amount' => $amount,
                'PartyA' => $this->shortcode,
                'PartyB' => $phone,
                'Remarks' => $remarks,
                'QueueTimeOutURL' => $this->timeout_url,
                'ResultURL' => $this->result_url,
                'Occasion' => $occasion ?? $remarks
            );
            
            $url = $this->get_base_url() . '/mpesa/b2c/v1/paymentrequest';
            
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode($request_data),
                'timeout' => 30
            ));
            
            if (is_wp_error($response)) {
                throw new Exception('B2C payment request failed: ' . $response->get_error_message());
            }
            
            $body = wp_remote_retrieve_body($response);
            $result = json_decode($body, true);
            
            // Save transaction record
            $transaction_id = $this->save_transaction(array(
                'transaction_type' => 'b2c_payment',
                'conversation_id' => $result['ConversationID'] ?? null,
                'originator_conversation_id' => $result['OriginatorConversationID'] ?? null,
                'phone_number' => $phone,
                'amount' => $amount,
                'transaction_desc' => $remarks,
                'member_id' => $member_id,
                'loan_id' => $loan_id,
                'status' => isset($result['ResponseCode']) && $result['ResponseCode'] === '0' ? 'pending' : 'failed',
                'result_code' => $result['ResponseCode'] ?? null,
                'result_desc' => $result['ResponseDescription'] ?? null,
                'request_data' => json_encode($request_data),
                'response_data' => $body
            ));
            
            if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                return array(
                    'success' => true,
                    'transaction_id' => $transaction_id,
                    'conversation_id' => $result['ConversationID'],
                    'originator_conversation_id' => $result['OriginatorConversationID'],
                    'message' => 'B2C payment initiated successfully'
                );
            } else {
                throw new Exception($result['ResponseDescription'] ?? 'B2C payment failed');
            }
            
        } catch (Exception $e) {
            $this->log_error('B2C Payment failed', $e->getMessage(), array(
                'phone' => $phone,
                'amount' => $amount,
                'remarks' => $remarks
            ));
            
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Query transaction status
     */
    public function query_transaction_status($checkout_request_id) {
        try {
            $access_token = $this->get_access_token();
            
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
            $request_data = array(
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkout_request_id
            );
            
            $url = $this->get_base_url() . '/mpesa/stkpushquery/v1/query';
            
            $response = wp_remote_post($url, array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode($request_data),
                'timeout' => 30
            ));
            
            if (is_wp_error($response)) {
                throw new Exception('Transaction status query failed: ' . $response->get_error_message());
            }
            
            $body = wp_remote_retrieve_body($response);
            $result = json_decode($body, true);
            
            // Update transaction record
            $this->update_transaction_by_checkout_id($checkout_request_id, array(
                'result_code' => $result['ResultCode'] ?? null,
                'result_desc' => $result['ResultDesc'] ?? null,
                'status' => $this->map_result_code_to_status($result['ResultCode'] ?? null)
            ));
            
            return $result;
            
        } catch (Exception $e) {
            $this->log_error('Transaction status query failed', $e->getMessage(), array(
                'checkout_request_id' => $checkout_request_id
            ));
            
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Handle STK Push callback
     */
    public function handle_callback($request) {
        $body = $request->get_body();
        $data = json_decode($body, true);
        
        $this->log_info('STK Push callback received', $body);
        
        if (!isset($data['Body']['stkCallback'])) {
            return new WP_REST_Response(array('ResultCode' => 1, 'ResultDesc' => 'Invalid callback data'), 400);
        }
        
        $callback = $data['Body']['stkCallback'];
        $checkout_request_id = $callback['CheckoutRequestID'];
        $result_code = $callback['ResultCode'];
        $result_desc = $callback['ResultDesc'];
        
        $update_data = array(
            'result_code' => $result_code,
            'result_desc' => $result_desc,
            'callback_data' => $body,
            'status' => $this->map_result_code_to_status($result_code)
        );
        
        if ($result_code == 0) {
            // Successful payment
            $metadata = $callback['CallbackMetadata']['Item'] ?? array();
            
            foreach ($metadata as $item) {
                switch ($item['Name']) {
                    case 'Amount':
                        $update_data['amount'] = $item['Value'];
                        break;
                    case 'MpesaReceiptNumber':
                        $update_data['mpesa_receipt_number'] = $item['Value'];
                        break;
                    case 'TransactionDate':
                        $update_data['transaction_date'] = $this->format_mpesa_date($item['Value']);
                        break;
                    case 'PhoneNumber':
                        $update_data['phone_number'] = $item['Value'];
                        break;
                }
            }
            
            // Process successful payment
            $this->process_successful_payment($checkout_request_id, $update_data);
        }
        
        $this->update_transaction_by_checkout_id($checkout_request_id, $update_data);
        
        return new WP_REST_Response(array('ResultCode' => 0, 'ResultDesc' => 'Success'), 200);
    }
    
    /**
     * Handle B2C result callback
     */
    public function handle_result($request) {
        $body = $request->get_body();
        $data = json_decode($body, true);
        
        $this->log_info('B2C result callback received', $body);
        
        if (!isset($data['Result'])) {
            return new WP_REST_Response(array('ResultCode' => 1, 'ResultDesc' => 'Invalid result data'), 400);
        }
        
        $result = $data['Result'];
        $conversation_id = $result['ConversationID'];
        $result_code = $result['ResultCode'];
        $result_desc = $result['ResultDesc'];
        
        $update_data = array(
            'result_code' => $result_code,
            'result_desc' => $result_desc,
            'callback_data' => $body,
            'status' => $this->map_result_code_to_status($result_code)
        );
        
        if ($result_code == 0) {
            // Successful disbursement
            $parameters = $result['ResultParameters']['ResultParameter'] ?? array();
            
            foreach ($parameters as $param) {
                switch ($param['Key']) {
                    case 'TransactionAmount':
                        $update_data['amount'] = $param['Value'];
                        break;
                    case 'TransactionReceipt':
                        $update_data['mpesa_receipt_number'] = $param['Value'];
                        break;
                    case 'ReceiverPartyPublicName':
                        $update_data['receiver_name'] = $param['Value'];
                        break;
                    case 'TransactionCompletedDateTime':
                        $update_data['transaction_date'] = $param['Value'];
                        break;
                    case 'B2CUtilityAccountAvailableFunds':
                        $update_data['utility_balance'] = $param['Value'];
                        break;
                    case 'B2CWorkingAccountAvailableFunds':
                        $update_data['working_balance'] = $param['Value'];
                        break;
                }
            }
            
            // Process successful disbursement
            $this->process_successful_disbursement($conversation_id, $update_data);
        }
        
        $this->update_transaction_by_conversation_id($conversation_id, $update_data);
        
        return new WP_REST_Response(array('ResultCode' => 0, 'ResultDesc' => 'Success'), 200);
    }
    
    /**
     * Handle timeout callback
     */
    public function handle_timeout($request) {
        $body = $request->get_body();
        $data = json_decode($body, true);
        
        $this->log_info('Transaction timeout received', $body);
        
        if (isset($data['Result']['ConversationID'])) {
            $this->update_transaction_by_conversation_id($data['Result']['ConversationID'], array(
                'status' => 'timeout',
                'result_desc' => 'Transaction timed out',
                'callback_data' => $body
            ));
        }
        
        return new WP_REST_Response(array('ResultCode' => 0, 'ResultDesc' => 'Success'), 200);
    }
    
    /**
     * Process successful payment
     */
    private function process_successful_payment($checkout_request_id, $payment_data) {
        global $wpdb;
        
        $transaction = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_mpesa_transactions WHERE checkout_request_id = %s",
            $checkout_request_id
        ));
        
        if (!$transaction) {
            return;
        }
        
        // Process based on payment purpose
        switch ($transaction->payment_purpose) {
            case 'loan_repayment':
                $this->process_loan_repayment($transaction, $payment_data);
                break;
            case 'contribution':
                $this->process_contribution($transaction, $payment_data);
                break;
            case 'registration_fee':
                $this->process_registration_fee($transaction, $payment_data);
                break;
            case 'share_capital':
                $this->process_share_capital($transaction, $payment_data);
                break;
        }
        
        // Send notification
        $this->send_payment_notification($transaction, $payment_data);
        
        // Trigger webhook
        do_action('daystar_mpesa_payment_received', $transaction, $payment_data);
    }
    
    /**
     * Process successful disbursement
     */
    private function process_successful_disbursement($conversation_id, $disbursement_data) {
        global $wpdb;
        
        $transaction = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_mpesa_transactions WHERE conversation_id = %s",
            $conversation_id
        ));
        
        if (!$transaction || !$transaction->loan_id) {
            return;
        }
        
        // Update loan status to disbursed
        $wpdb->update(
            $wpdb->prefix . 'daystar_loans',
            array(
                'status' => 'disbursed',
                'disbursement_date' => current_time('mysql'),
                'disbursement_method' => 'mpesa',
                'disbursement_reference' => $disbursement_data['mpesa_receipt_number']
            ),
            array('id' => $transaction->loan_id),
            array('%s', '%s', '%s', '%s'),
            array('%d')
        );
        
        // Send notification
        $this->send_disbursement_notification($transaction, $disbursement_data);
        
        // Trigger webhook
        do_action('daystar_mpesa_disbursement_completed', $transaction, $disbursement_data);
    }
    
    /**
     * Run reconciliation process
     */
    public function run_reconciliation() {
        global $wpdb;
        
        // Get pending transactions older than 5 minutes
        $pending_transactions = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_mpesa_transactions 
             WHERE status = 'pending' AND created_at < %s",
            date('Y-m-d H:i:s', strtotime('-5 minutes'))
        ));
        
        foreach ($pending_transactions as $transaction) {
            if ($transaction->checkout_request_id) {
                // Query STK push status
                $this->query_transaction_status($transaction->checkout_request_id);
            }
            
            // Add delay to avoid rate limiting
            sleep(1);
        }
        
        $this->log_info('Reconciliation completed', count($pending_transactions) . ' transactions processed');
    }
    
    /**
     * Save transaction record
     */
    private function save_transaction($data) {
        global $wpdb;
        
        $wpdb->insert(
            $wpdb->prefix . 'daystar_mpesa_transactions',
            $data,
            array(
                '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
            )
        );
        
        return $wpdb->insert_id;
    }
    
    /**
     * Update transaction by checkout request ID
     */
    private function update_transaction_by_checkout_id($checkout_request_id, $data) {
        global $wpdb;
        
        $wpdb->update(
            $wpdb->prefix . 'daystar_mpesa_transactions',
            $data,
            array('checkout_request_id' => $checkout_request_id)
        );
    }
    
    /**
     * Update transaction by conversation ID
     */
    private function update_transaction_by_conversation_id($conversation_id, $data) {
        global $wpdb;
        
        $wpdb->update(
            $wpdb->prefix . 'daystar_mpesa_transactions',
            $data,
            array('conversation_id' => $conversation_id)
        );
    }
    
    /**
     * Format phone number for M-Pesa
     */
    private function format_phone_number($phone) {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Convert to international format
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) !== '254') {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }
    
    /**
     * Format M-Pesa date to MySQL datetime
     */
    private function format_mpesa_date($mpesa_date) {
        // M-Pesa date format: 20231201143045 (YYYYMMDDHHmmss)
        return date('Y-m-d H:i:s', strtotime($mpesa_date));
    }
    
    /**
     * Map M-Pesa result code to status
     */
    private function map_result_code_to_status($result_code) {
        switch ($result_code) {
            case '0':
                return 'completed';
            case '1032':
                return 'cancelled';
            case '1037':
                return 'timeout';
            case '1':
                return 'insufficient_funds';
            case '26':
                return 'invalid_phone';
            default:
                return 'failed';
        }
    }
    
    /**
     * Process loan repayment
     */
    private function process_loan_repayment($transaction, $payment_data) {
        global $wpdb;
        
        // Find active loan for member
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans 
             WHERE member_id = %d AND status IN ('active', 'disbursed') 
             ORDER BY disbursement_date ASC LIMIT 1",
            $transaction->member_id
        ));
        
        if (!$loan) {
            return;
        }
        
        // Calculate payment allocation
        $amount = floatval($payment_data['amount']);
        $outstanding_balance = $loan->amount - $loan->paid_amount;
        $monthly_payment = $loan->monthly_payment;
        
        // Simple allocation: interest first, then principal
        $interest_rate = $loan->interest_rate / 100 / 12; // Monthly interest rate
        $interest_amount = min($amount, $outstanding_balance * $interest_rate);
        $principal_amount = $amount - $interest_amount;
        
        // Record repayment
        $wpdb->insert(
            $wpdb->prefix . 'daystar_loan_repayments',
            array(
                'loan_id' => $loan->id,
                'member_id' => $transaction->member_id,
                'amount' => $amount,
                'principal_amount' => $principal_amount,
                'interest_amount' => $interest_amount,
                'payment_method' => 'mpesa',
                'payment_reference' => $payment_data['mpesa_receipt_number'],
                'payment_date' => current_time('mysql'),
                'status' => 'completed'
            )
        );
        
        // Update loan paid amount
        $new_paid_amount = $loan->paid_amount + $amount;
        $wpdb->update(
            $wpdb->prefix . 'daystar_loans',
            array(
                'paid_amount' => $new_paid_amount,
                'status' => $new_paid_amount >= $loan->amount ? 'completed' : $loan->status
            ),
            array('id' => $loan->id)
        );
        
        // Trigger action
        do_action('daystar_repayment_received', $wpdb->insert_id);
    }
    
    /**
     * Process contribution
     */
    private function process_contribution($transaction, $payment_data) {
        global $wpdb;
        
        $amount = floatval($payment_data['amount']);
        
        // Record contribution
        $wpdb->insert(
            $wpdb->prefix . 'daystar_contributions',
            array(
                'member_id' => $transaction->member_id,
                'amount' => $amount,
                'contribution_type' => 'monthly',
                'payment_method' => 'mpesa',
                'payment_reference' => $payment_data['mpesa_receipt_number'],
                'contribution_date' => current_time('mysql'),
                'status' => 'completed'
            )
        );
        
        // Update member total contributions
        $total_contributions = get_user_meta($transaction->member_id, 'total_contributions', true) ?: 0;
        update_user_meta($transaction->member_id, 'total_contributions', $total_contributions + $amount);
        
        // Trigger action
        do_action('daystar_contribution_received', $wpdb->insert_id);
    }
    
    /**
     * Process registration fee
     */
    private function process_registration_fee($transaction, $payment_data) {
        update_user_meta($transaction->member_id, 'registration_fee_paid', true);
        update_user_meta($transaction->member_id, 'registration_fee_amount', $payment_data['amount']);
        update_user_meta($transaction->member_id, 'registration_fee_reference', $payment_data['mpesa_receipt_number']);
        update_user_meta($transaction->member_id, 'registration_fee_date', current_time('mysql'));
    }
    
    /**
     * Process share capital
     */
    private function process_share_capital($transaction, $payment_data) {
        $amount = floatval($payment_data['amount']);
        $share_capital = get_user_meta($transaction->member_id, 'share_capital', true) ?: 0;
        update_user_meta($transaction->member_id, 'share_capital', $share_capital + $amount);
    }
    
    /**
     * Send payment notification
     */
    private function send_payment_notification($transaction, $payment_data) {
        if (!$transaction->member_id) {
            return;
        }
        
        $user = get_user_by('id', $transaction->member_id);
        if (!$user) {
            return;
        }
        
        $message = sprintf(
            "Payment of KES %s received successfully. M-Pesa Receipt: %s. Thank you!",
            number_format($payment_data['amount'], 2),
            $payment_data['mpesa_receipt_number']
        );
        
        // Send via notification system
        daystar_send_notification(
            $transaction->member_id,
            $message,
            'sms',
            'Payment Confirmation'
        );
    }
    
    /**
     * Send disbursement notification
     */
    private function send_disbursement_notification($transaction, $disbursement_data) {
        if (!$transaction->member_id) {
            return;
        }
        
        $user = get_user_by('id', $transaction->member_id);
        if (!$user) {
            return;
        }
        
        $message = sprintf(
            "Loan disbursement of KES %s has been sent to your M-Pesa. Receipt: %s",
            number_format($disbursement_data['amount'], 2),
            $disbursement_data['mpesa_receipt_number']
        );
        
        // Send via notification system
        daystar_send_notification(
            $transaction->member_id,
            $message,
            'sms',
            'Loan Disbursement'
        );
    }
    
    /**
     * Verify M-Pesa webhook
     */
    public function verify_mpesa_webhook($request) {
        // Implement webhook verification logic
        return true;
    }
    
    /**
     * Handle AJAX STK Push request
     */
    public function handle_stk_push() {
        check_ajax_referer('daystar_mpesa_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }
        
        $phone = sanitize_text_field($_POST['phone']);
        $amount = floatval($_POST['amount']);
        $purpose = sanitize_text_field($_POST['purpose']);
        $reference = sanitize_text_field($_POST['reference']);
        
        $result = $this->initiate_stk_push(
            $phone,
            $amount,
            $reference,
            'Daystar SACCO Payment',
            get_current_user_id(),
            $purpose
        );
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }
    }
    
    /**
     * Handle AJAX B2C payment request
     */
    public function handle_b2c_payment() {
        check_ajax_referer('daystar_mpesa_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $phone = sanitize_text_field($_POST['phone']);
        $amount = floatval($_POST['amount']);
        $remarks = sanitize_text_field($_POST['remarks']);
        $member_id = intval($_POST['member_id']);
        $loan_id = intval($_POST['loan_id']);
        
        $result = $this->initiate_b2c_payment(
            $phone,
            $amount,
            $remarks,
            null,
            $member_id,
            $loan_id
        );
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }
    }
    
    /**
     * Handle AJAX transaction status check
     */
    public function check_transaction_status() {
        check_ajax_referer('daystar_mpesa_nonce', 'nonce');
        
        $checkout_request_id = sanitize_text_field($_POST['checkout_request_id']);
        
        $result = $this->query_transaction_status($checkout_request_id);
        
        wp_send_json_success($result);
    }
    
    /**
     * Log error
     */
    private function log_error($message, $details = '', $context = array()) {
        error_log(sprintf(
            '[Daystar M-Pesa Error] %s: %s | Context: %s',
            $message,
            $details,
            json_encode($context)
        ));
    }
    
    /**
     * Log info
     */
    private function log_info($message, $details = '') {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                '[Daystar M-Pesa Info] %s: %s',
                $message,
                $details
            ));
        }
    }
}

// Initialize enhanced M-Pesa integration
new DaystarEnhancedMPesa();