<?php
/**
 * M-Pesa Payment Integration for WordPress - Daystar Co-op
 * 
 * This file contains WordPress-specific M-Pesa payment integration
 * for the Daystar Multi-Purpose Co-op Society Ltd. website.
 */

/**
 * Register M-Pesa settings page in WordPress admin
 */
function daystar_mpesa_register_settings_page() {
    add_options_page(
        'M-Pesa Settings',
        'M-Pesa Settings',
        'manage_options',
        'daystar-mpesa-settings',
        'daystar_mpesa_settings_page_callback'
    );
}
add_action('admin_menu', 'daystar_mpesa_register_settings_page');

/**
 * Register M-Pesa settings
 */
function daystar_mpesa_register_settings() {
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_key');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_secret');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_shortcode');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_passkey');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_environment');
}
add_action('admin_init', 'daystar_mpesa_register_settings');

/**
 * M-Pesa settings page callback
 */
function daystar_mpesa_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>M-Pesa Integration Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('daystar_mpesa_settings_group'); ?>
            <?php do_settings_sections('daystar_mpesa_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Environment</th>
                    <td>
                        <select name="daystar_mpesa_environment">
                            <option value="sandbox" <?php selected(get_option('daystar_mpesa_environment'), 'sandbox'); ?>>Sandbox (Testing)</option>
                            <option value="production" <?php selected(get_option('daystar_mpesa_environment'), 'production'); ?>>Production (Live)</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Key</th>
                    <td><input type="text" name="daystar_mpesa_consumer_key" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_key')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Secret</th>
                    <td><input type="password" name="daystar_mpesa_consumer_secret" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_secret')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Shortcode (Paybill/Till Number)</th>
                    <td><input type="text" name="daystar_mpesa_shortcode" value="<?php echo esc_attr(get_option('daystar_mpesa_shortcode')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Passkey</th>
                    <td><input type="password" name="daystar_mpesa_passkey" value="<?php echo esc_attr(get_option('daystar_mpesa_passkey')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <div class="card">
            <h2>M-Pesa Integration Instructions</h2>
            <p>To set up M-Pesa integration:</p>
            <ol>
                <li>Register for a Safaricom Developer Account at <a href="https://developer.safaricom.co.ke/" target="_blank">https://developer.safaricom.co.ke/</a></li>
                <li>Create a new app and get your Consumer Key and Consumer Secret</li>
                <li>Set up your callback URL in the Safaricom Developer Portal to: <code><?php echo home_url('/mpesa-callback/'); ?></code></li>
                <li>Enter your credentials above and save changes</li>
                <li>Use the <code>[mpesa_payment_form]</code> shortcode on any page to display the payment form</li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * M-Pesa API Class
 */
class Daystar_MPesa_API {
    /**
     * Get base URL based on environment
     */
    public static function get_base_url() {
        $environment = get_option('daystar_mpesa_environment', 'sandbox');
        return $environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }
    
    /**
     * Generate access token
     */
    public static function get_access_token() {
        $consumer_key = get_option('daystar_mpesa_consumer_key');
        $consumer_secret = get_option('daystar_mpesa_consumer_secret');
        
        if (empty($consumer_key) || empty($consumer_secret)) {
            return new WP_Error('missing_credentials', 'M-Pesa API credentials are not configured');
        }
        
        $url = self::get_base_url() . '/oauth/v1/generate?grant_type=client_credentials';
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret)
            )
        );
        
        $response = wp_remote_get($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body);
        
        if (isset($result->access_token)) {
            return $result->access_token;
        } else {
            return new WP_Error('token_error', 'Failed to get access token: ' . $body);
        }
    }
    
    /**
     * Initiate STK Push
     */
    public static function initiate_stk_push($phone, $amount, $reference, $description) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpush/v1/processrequest';
        
        // Format phone number (remove leading 0 and add country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => home_url('/mpesa-callback/'),
            'AccountReference' => $reference,
            'TransactionDesc' => $description
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    /**
     * Check transaction status
     */
    public static function check_transaction_status($checkout_request_id) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpushquery/v1/query';
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkout_request_id
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}

/**
 * Register custom post type for M-Pesa transactions
 */
function daystar_register_mpesa_transaction_post_type() {
    $labels = array(
        'name'               => 'M-Pesa Transactions',
        'singular_name'      => 'M-Pesa Transaction',
        'menu_name'          => 'M-Pesa Transactions',
        'name_admin_bar'     => 'M-Pesa Transaction',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Transaction',
        'new_item'           => 'New Transaction',
        'edit_item'          => 'Edit Transaction',
        'view_item'          => 'View Transaction',
        'all_items'          => 'All Transactions',
        'search_items'       => 'Search Transactions',
        'parent_item_colon'  => 'Parent Transactions:',
        'not_found'          => 'No transactions found.',
        'not_found_in_trash' => 'No transactions found in Trash.'
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title')
    );
    
    register_post_type('mpesa_transaction', $args);
}
add_action('init', 'daystar_register_mpesa_transaction_post_type');

/**
 * Add custom meta boxes for M-Pesa transactions
 */
function daystar_add_mpesa_transaction_meta_boxes() {
    add_meta_box(
        'mpesa_transaction_details',
        'Transaction Details',
        'daystar_mpesa_transaction_details_callback',
        'mpesa_transaction',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'daystar_add_mpesa_transaction_meta_boxes');

/**
 * M-Pesa transaction details meta box callback
 */
function daystar_mpesa_transaction_details_callback($post) {
    $transaction_type = get_post_meta($post->ID, '_transaction_type', true);
    $amount = get_post_meta($post->ID, '_amount', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $reference = get_post_meta($post->ID, '_reference', true);
    $mpesa_receipt = get_post_meta($post->ID, '_mpesa_receipt', true);
    $checkout_request_id = get_post_meta($post->ID, '_checkout_request_id', true);
    $status = get_post_meta($post->ID, '_status', true);
    $user_id = get_post_meta($post->ID, '_user_id', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="transaction_type">Transaction Type</label></th>
            <td><?php echo esc_html($transaction_type); ?></td>
        </tr>
        <tr>
            <th><label for="amount">Amount</label></th>
            <td>KSh <?php echo esc_html(number_format($amount, 2)); ?></td>
        </tr>
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <tr>
            <th><label for="reference">Reference</label></th>
            <td><?php echo esc_html($reference); ?></td>
        </tr>
        <tr>
            <th><label for="mpesa_receipt">M-Pesa Receipt</label></th>
            <td><?php echo esc_html($mpesa_receipt); ?></td>
        </tr>
        <tr>
            <th><label for="checkout_request_id">Checkout Request ID</label></th>
            <td><?php echo esc_html($checkout_request_id); ?></td>
        </tr>
        <tr>
            <th><label for="status">Status</label></th>
            <td>
                <?php
                $status_class = '';
                switch ($status) {
                    case 'pending':
                        $status_class = 'pending';
                        break;
                    case 'completed':
                        $status_class = 'completed';
                        break;
                    case 'failed':
                        $status_class = 'failed';
                        break;
                }
                ?>
                <span class="status-<?php echo $status_class; ?>"><?php echo esc_html(ucfirst($status)); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_id">User</label></th>
            <td>
                <?php
                if ($user_id) {
                    $user = get_user_by('id', $user_id);
                    if ($user) {
                        echo '<a href="' . esc_url(get_edit_user_link($user_id)) . '">' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</a>';
                    } else {
                        echo 'User not found';
                    }
                } else {
                    echo 'Guest';
                }
                ?>
            </td>
        </tr>
    </table>
    <style>
        .status-pending {
            background-color: #f8dda7;
            color: #94660c;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-completed {
            background-color: #c6e1c6;
            color: #5b841b;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
    <?php
}

/**
 * Register custom endpoint for M-Pesa callback
 */
function daystar_register_mpesa_callback_endpoint() {
    add_rewrite_rule('^mpesa-callback/?$', 'index.php?mpesa_callback=1', 'top');
    add_rewrite_tag('%mpesa_callback%', '([^&]+)');
}
add_action('init', 'daystar_register_mpesa_callback_endpoint');

/**
 * Handle M-Pesa callback
 */
function daystar_handle_mpesa_callback() {
    if (get_query_var('mpesa_callback')) {
        // Get callback data
        $callback_data = file_get_contents('php://input');
        $callback_data = json_decode($callback_data, true);
        
        // Log callback data for debugging
        error_log('M-Pesa Callback: ' . print_r($callback_data, true));
        
        // Process callback data
        if (isset($callback_data['Body']['stkCallback'])) {
            $result_code = $callback_data['Body']['stkCallback']['ResultCode'];
            $result_desc = $callback_data['Body']['stkCallback']['ResultDesc'];
            $merchant_request_id = $callback_data['Body']['stkCallback']['MerchantRequestID'];
            $checkout_request_id = $callback_data['Body']['stkCallback']['CheckoutRequestID'];
            
            // Find transaction by checkout request ID
            $args = array(
                'post_type' => 'mpesa_transaction',
                'meta_query' => array(
                    array(
                        'key' => '_checkout_request_id',
                        'value' => $checkout_request_id
                    )
                )
            );
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
                $query->the_post();
                $transaction_id = get_the_ID();
                
                // Check if transaction was successful
                if ($result_code === 0) {
                    // Transaction successful
                    $callback_metadata = $callback_data['Body']['stkCallback']['CallbackMetadata']['Item'];
                    
                    // Extract transaction details
                    $amount = null;
                    $mpesa_receipt_number = null;
                    $transaction_date = null;
                    $phone_number = null;
                    
                    foreach ($callback_metadata as $item) {
                        switch ($item['Name']) {
                            case 'Amount':
                                $amount = $item['Value'];
                                break;
                            case 'MpesaReceiptNumber':
                                $mpesa_receipt_number = $item['Value'];
                                break;
                            case 'TransactionDate':
                                $transaction_date = $item['Value'];
                                break;
                            case 'PhoneNumber':
                                $phone_number = $item['Value'];
                                break;
                        }
                    }
                    
                    // Update transaction
                    update_post_meta($transaction_id, '_status', 'completed');
                    update_post_meta($transaction_id, '_mpesa_receipt', $mpesa_receipt_number);
                    update_post_meta($transaction_id, '_transaction_date', $transaction_date);
                    
                    // Get transaction type
                    $transaction_type = get_post_meta($transaction_id, '_transaction_type', true);
                    $user_id = get_post_meta($transaction_id, '_user_id', true);
                    
                    // Process based on transaction type
                    if ($transaction_type === 'contribution' && $user_id) {
                        // Update user contribution
                        $current_contribution = get_user_meta($user_id, 'total_contribution', true);
                        $new_contribution = $current_contribution ? $current_contribution + $amount : $amount;
                        update_user_meta($user_id, 'total_contribution', $new_contribution);
                        
                        // Add contribution record
                        $contribution_history = get_user_meta($user_id, 'contribution_history', true);
                        if (!$contribution_history) {
                            $contribution_history = array();
                        }
                        
                        $contribution_history[] = array(
                            'date' => current_time('mysql'),
                            'amount' => $amount,
                            'receipt' => $mpesa_receipt_number
                        );
                        
                        update_user_meta($user_id, 'contribution_history', $contribution_history);
                    } elseif ($transaction_type === 'registration' && $user_id) {
                        // Update user registration status
                        update_user_meta($user_id, 'registration_payment_status', 'completed');
                        update_user_meta($user_id, 'registration_payment_date', current_time('mysql'));
                        update_user_meta($user_id, 'registration_payment_receipt', $mpesa_receipt_number);
                        
                        // Send welcome email
                        $user = get_user_by('id', $user_id);
                        if ($user) {
                            $to = $user->user_email;
                            $subject = 'Welcome to Daystar Multi-Purpose Co-op Society Ltd.';
                            $message = "Dear " . get_user_meta($user_id, 'first_name', true) . ",\n\n";
                            $message .= "Thank you for registering with Daystar Multi-Purpose Co-op Society Ltd. Your registration payment has been received.\n\n";
                            $message .= "Your member number is: " . get_user_meta($user_id, 'member_number', true) . "\n";
                            $message .= "M-Pesa Receipt: " . $mpesa_receipt_number . "\n";
                            $message .= "Amount: KSh " . number_format($amount, 2) . "\n\n";
                            $message .= "You can now log in to your account and access all member features.\n\n";
                            $message .= "Best regards,\n";
                            $message .= "Daystar Multi-Purpose Co-op Society Ltd.";
                            
                            wp_mail($to, $subject, $message);
                        }
                    } elseif ($transaction_type === 'loan_repayment' && $user_id) {
                        // Update loan repayment
                        // This would require additional logic based on your loan management system
                    }
                } else {
                    // Transaction failed
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $result_desc);
                }
                
                wp_reset_postdata();
            }
        }
        
        // Return response to M-Pesa
        header('Content-Type: application/json');
        echo json_encode(array('ResultCode' => 0, 'ResultDesc' => 'Success'));
        exit;
    }
}
add_action('template_redirect', 'daystar_handle_mpesa_callback');

/**
 * Add shortcode to display M-Pesa payment form
 */
function daystar_mpesa_payment_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'type' => '',
        'amount' => '',
        'reference' => ''
    ), $atts);
    
    // Check if M-Pesa is configured
    $consumer_key = get_option('daystar_mpesa_consumer_key');
    $consumer_secret = get_option('daystar_mpesa_consumer_secret');
    $shortcode = get_option('daystar_mpesa_shortcode');
    $passkey = get_option('daystar_mpesa_passkey');
    
    if (empty($consumer_key) || empty($consumer_secret) || empty($shortcode) || empty($passkey)) {
        return '<div class="alert alert-warning">M-Pesa integration is not fully configured. Please contact the administrator.</div>';
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $phone = get_user_meta($user_id, 'phone', true);
    
    // Process form submission
    if (isset($_POST['mpesa_payment_submit']) && isset($_POST['mpesa_payment_nonce']) && wp_verify_nonce($_POST['mpesa_payment_nonce'], 'mpesa_payment_action')) {
        $payment_type = sanitize_text_field($_POST['payment_type']);
        $amount = intval($_POST['amount']);
        $phone = sanitize_text_field($_POST['phone']);
        $reference = sanitize_text_field($_POST['reference']);
        
        // Validate form data
        $errors = array();
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if ($amount <= 0) {
            $errors[] = 'Amount must be greater than zero';
        }
        
        if (empty($payment_type)) {
            $errors[] = 'Payment type is required';
        }
        
        // If no validation errors, initiate payment
        if (empty($errors)) {
            // Generate reference if not provided
            if (empty($reference)) {
                $reference = 'DST' . date('YmdHis') . rand(100, 999);
            }
            
            // Set description based on payment type
            $description = '';
            switch ($payment_type) {
                case 'contribution':
                    $description = 'Daystar Coop Contribution';
                    break;
                case 'loan_repayment':
                    $description = 'Daystar Coop Loan Repayment';
                    break;
                case 'registration':
                    $description = 'Daystar Coop Registration Fee';
                    break;
                default:
                    $description = 'Daystar Coop Payment';
            }
            
            // Create transaction record
            $transaction_id = wp_insert_post(array(
                'post_title' => $reference,
                'post_type' => 'mpesa_transaction',
                'post_status' => 'publish'
            ));
            
            if ($transaction_id) {
                update_post_meta($transaction_id, '_transaction_type', $payment_type);
                update_post_meta($transaction_id, '_amount', $amount);
                update_post_meta($transaction_id, '_phone', $phone);
                update_post_meta($transaction_id, '_reference', $reference);
                update_post_meta($transaction_id, '_status', 'pending');
                update_post_meta($transaction_id, '_user_id', $user_id);
                update_post_meta($transaction_id, '_created_at', current_time('mysql'));
                
                // Initiate STK Push
                $result = Daystar_MPesa_API::initiate_stk_push($phone, $amount, $reference, $description);
                
                if (is_wp_error($result)) {
                    $errors[] = $result->get_error_message();
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $result->get_error_message());
                } elseif (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                    // Store checkout request ID
                    update_post_meta($transaction_id, '_checkout_request_id', $result['CheckoutRequestID']);
                    
                    // Store in session for status checking
                    $_SESSION['mpesa_checkout_request_id'] = $result['CheckoutRequestID'];
                    $_SESSION['mpesa_transaction_id'] = $transaction_id;
                    
                    // Redirect to payment status page
                    wp_redirect(add_query_arg('payment_status', 'pending', home_url('/payment-status/')));
                    exit;
                } else {
                    $error_message = isset($result['errorMessage']) ? $result['errorMessage'] : 'Payment request failed. Please try again.';
                    $errors[] = $error_message;
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $error_message);
                }
            } else {
                $errors[] = 'Failed to create transaction record';
            }
        }
    }
    
    // Display payment form
    ob_start();
    ?>
    <div class="mpesa-payment-form">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo esc_html($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form id="mpesaPaymentForm" method="post" action="">
            <?php wp_nonce_field('mpesa_payment_action', 'mpesa_payment_nonce'); ?>
            
            <div class="form-group">
                <label for="paymentType">Payment Type</label>
                <select class="form-control" id="paymentType" name="payment_type" required>
                    <option value="" selected disabled>Select payment type</option>
                    <option value="contribution" <?php selected($atts['type'], 'contribution'); ?>>Monthly Contribution</option>
                    <option value="loan_repayment" <?php selected($atts['type'], 'loan_repayment'); ?>>Loan Repayment</option>
                    <option value="registration" <?php selected($atts['type'], 'registration'); ?>>Registration Fee</option>
                    <option value="other" <?php selected($atts['type'], 'other'); ?>>Other Payment</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="amount">Amount (KSh)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">KSh</span>
                    </div>
                    <input type="number" class="form-control" id="amount" name="amount" min="1" step="1" value="<?php echo esc_attr($atts['amount']); ?>" required>
                </div>
                <small class="form-text text-muted">Enter the amount you wish to pay</small>
            </div>
            
            <div class="form-group">
                <label for="phone">M-Pesa Phone Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 0712345678" value="<?php echo esc_attr($phone); ?>" required>
                </div>
                <small class="form-text text-muted">Enter the phone number registered with M-Pesa</small>
            </div>
            
            <div class="form-group">
                <label for="reference">Reference (Optional)</label>
                <input type="text" class="form-control" id="reference" name="reference" placeholder="e.g., Invoice number, Member number" value="<?php echo esc_attr($atts['reference']); ?>">
                <small class="form-text text-muted">Enter a reference for this payment if applicable</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="mpesa_payment_submit" id="payButton">
                    Pay with M-Pesa
                </button>
            </div>
        </form>
        
        <div class="payment-info mt-4">
            <h5>How it works:</h5>
            <ol>
                <li>Enter your payment details and click "Pay with M-Pesa"</li>
                <li>You will receive an STK push notification on your phone</li>
                <li>Enter your M-Pesa PIN to authorize the payment</li>
                <li>You will receive an M-Pesa confirmation message</li>
                <li>Your payment will be processed and your account updated</li>
            </ol>
        </div>
        
        <div class="text-center mt-4">
            <img src="<?php echo esc_url(plugins_url('assets/images/mpesa-logo.png', __FILE__)); ?>" alt="M-Pesa Logo" class="img-fluid mb-3" style="max-height: 60px;">
            <p class="text-muted small">
                <i class="fas fa-lock me-1"></i> Your payment information is secure and encrypted.
                Daystar Multi-Purpose Co-op Society Ltd. is an authorized M-Pesa partner.
            </p>
        </div>
    </div>
    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Format phone number
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    
                    // Ensure it starts with 0
                    if (value.length > 0 && value.charAt(0) !== '0') {
                        value = '0' + value;
                    }
                    
                    // Limit to 10 digits
                    if (value.length > 10) {
                        value = value.substring(0, 10);
                    }
                    
                    this.value = value;
                });
            }
            
            // Set minimum amount based on payment type
            const paymentTypeSelect = document.getElementById('paymentType');
            const amountInput = document.getElementById('amount');
            
            if (paymentTypeSelect && amountInput) {
                paymentTypeSelect.addEventListener('change', function() {
                    const paymentType = this.value;
                    
                    switch (paymentType) {
                        case 'contribution':
                            amountInput.min = 2000;
                            if (amountInput.value < 2000 || amountInput.value === '') {
                                amountInput.value = 2000;
                            }
                            break;
                        case 'registration':
                            amountInput.min = 5000;
                            if (amountInput.value < 5000 || amountInput.value === '') {
                                amountInput.value = 5000;
                            }
                            break;
                        default:
                            amountInput.min = 1;
                            if (amountInput.value < 1) {
                                amountInput.value = '';
                            }
                    }
                });
                
                // Trigger change event if payment type is pre-selected
                if (paymentTypeSelect.value) {
                    const event = new Event('change');
                    paymentTypeSelect.dispatchEvent(event);
                }
            }
        });
    </script>
    
    <style>
        .mpesa-payment-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        
        .btn-primary {
            background-color: #00447c;
            border-color: #00447c;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        
        .btn-primary:hover {
            background-color: #003366;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .payment-info {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 4px;
        }
        
        .payment-info h5 {
            margin-top: 0;
            color: #00447c;
        }
        
        .payment-info ol {
            padding-left: 20px;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('mpesa_payment_form', 'daystar_mpesa_payment_form_shortcode');

/**
 * Add shortcode to display payment status
 */
function daystar_payment_status_shortcode() {
    // Check if payment status is in URL
    $payment_status = isset($_GET['payment_status']) ? sanitize_text_field($_GET['payment_status']) : '';
    
    // Check if checkout request ID is in session
    $checkout_request_id = isset($_SESSION['mpesa_checkout_request_id']) ? $_SESSION['mpesa_checkout_request_id'] : '';
    $transaction_id = isset($_SESSION['mpesa_transaction_id']) ? $_SESSION['mpesa_transaction_id'] : '';
    
    if (empty($checkout_request_id) || empty($transaction_id)) {
        return '<div class="alert alert-warning">No payment information found. Please try again.</div>';
    }
    
    // Get transaction details
    $transaction_type = get_post_meta($transaction_id, '_transaction_type', true);
    $amount = get_post_meta($transaction_id, '_amount', true);
    $phone = get_post_meta($transaction_id, '_phone', true);
    $reference = get_post_meta($transaction_id, '_reference', true);
    $status = get_post_meta($transaction_id, '_status', true);
    
    ob_start();
    ?>
    <div class="payment-status">
        <h2>Payment Status</h2>
        
        <?php if ($status === 'pending'): ?>
            <div class="alert alert-info">
                <p><strong>Your payment is being processed.</strong></p>
                <p>Please check your phone for the M-Pesa STK push notification and enter your PIN to complete the payment.</p>
                <p>This page will automatically update when your payment is confirmed.</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        <?php elseif ($status === 'completed'): ?>
            <div class="alert alert-success">
                <p><strong>Payment Successful!</strong></p>
                <p>Your payment of KSh <?php echo number_format($amount, 2); ?> has been received.</p>
                <p>M-Pesa Receipt: <?php echo esc_html(get_post_meta($transaction_id, '_mpesa_receipt', true)); ?></p>
                <p>Reference: <?php echo esc_html($reference); ?></p>
                <p>Thank you for your payment.</p>
            </div>
            
            <?php
            // Clear session variables
            unset($_SESSION['mpesa_checkout_request_id']);
            unset($_SESSION['mpesa_transaction_id']);
            ?>
        <?php elseif ($status === 'failed'): ?>
            <div class="alert alert-danger">
                <p><strong>Payment Failed</strong></p>
                <p>Your payment could not be processed.</p>
                <p>Reason: <?php echo esc_html(get_post_meta($transaction_id, '_failure_reason', true)); ?></p>
                <p>Please try again or contact support for assistance.</p>
            </div>
            
            <?php
            // Clear session variables
            unset($_SESSION['mpesa_checkout_request_id']);
            unset($_SESSION['mpesa_transaction_id']);
            ?>
        <?php endif; ?>
        
        <div class="payment-details">
            <h4>Payment Details</h4>
            <table class="table">
                <tr>
                    <th>Payment Type:</th>
                    <td><?php echo esc_html(ucfirst($transaction_type)); ?></td>
                </tr>
                <tr>
                    <th>Amount:</th>
                    <td>KSh <?php echo number_format($amount, 2); ?></td>
                </tr>
                <tr>
                    <th>Phone Number:</th>
                    <td><?php echo esc_html($phone); ?></td>
                </tr>
                <tr>
                    <th>Reference:</th>
                    <td><?php echo esc_html($reference); ?></td>
                </tr>
            </table>
        </div>
        
        <?php if ($status === 'pending'): ?>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/payment/')); ?>" class="btn btn-outline-primary">Make Another Payment</a>
            </div>
            
            <script type="text/javascript">
                // Check payment status every 5 seconds
                setInterval(function() {
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=check_mpesa_payment_status&checkout_request_id=<?php echo esc_js($checkout_request_id); ?>&_wpnonce=<?php echo wp_create_nonce('check_mpesa_payment_status'); ?>')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'completed' || data.status === 'failed') {
                                // Reload page to show updated status
                                window.location.reload();
                            }
                        })
                        .catch(error => console.error('Error checking payment status:', error));
                }, 5000);
            </script>
        <?php else: ?>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/member-dashboard/')); ?>" class="btn btn-primary">Go to Dashboard</a>
                <a href="<?php echo esc_url(home_url('/payment/')); ?>" class="btn btn-outline-primary">Make Another Payment</a>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
        .payment-status {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .payment-status h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00447c;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .payment-details {
            margin-top: 30px;
        }
        
        .payment-details h4 {
            margin-bottom: 15px;
            color: #00447c;
        }
        
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        
        .table th {
            width: 40%;
            text-align: left;
        }
        
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            margin: 0 5px;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #00447c;
            border-color: #00447c;
        }
        
        .btn-outline-primary {
            color: #00447c;
            background-color: transparent;
            border-color: #00447c;
        }
        
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('payment_status', 'daystar_payment_status_shortcode');

/**
 * AJAX handler for checking payment status
 */
function daystar_check_mpesa_payment_status() {
    // Verify nonce
    check_ajax_referer('check_mpesa_payment_status');
    
    // Get checkout request ID
    $checkout_request_id = isset($_GET['checkout_request_id']) ? sanitize_text_field($_GET['checkout_request_id']) : '';
    
    if (empty($checkout_request_id)) {
        wp_send_json_error('Invalid checkout request ID');
    }
    
    // Find transaction by checkout request ID
    $args = array(
        'post_type' => 'mpesa_transaction',
        'meta_query' => array(
            array(
                'key' => '_checkout_request_id',
                'value' => $checkout_request_id
            )
        )
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $transaction_id = get_the_ID();
        $status = get_post_meta($transaction_id, '_status', true);
        
        wp_reset_postdata();
        
        // If still pending, check status with M-Pesa API
        if ($status === 'pending') {
            $result = Daystar_MPesa_API::check_transaction_status($checkout_request_id);
            
            if (!is_wp_error($result) && isset($result['ResultCode'])) {
                if ($result['ResultCode'] === '0') {
                    // Transaction successful
                    update_post_meta($transaction_id, '_status', 'completed');
                    $status = 'completed';
                } elseif ($result['ResultCode'] !== '1032') { // 1032 means request is still being processed
                    // Transaction failed
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', isset($result['ResultDesc']) ? $result['ResultDesc'] : 'Payment failed');
                    $status = 'failed';
                }
            }
        }
        
        wp_send_json_success(array('status' => $status));
    } else {
        wp_send_json_error('Transaction not found');
    }
}
add_action('wp_ajax_check_mpesa_payment_status', 'daystar_check_mpesa_payment_status');
add_action('wp_ajax_nopriv_check_mpesa_payment_status', 'daystar_check_mpesa_payment_status');

/**
 * Instructions: Add this code to your theme's functions.php file or create a new plugin with this code
 */
