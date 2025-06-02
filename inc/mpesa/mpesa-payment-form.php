<?php
/**
 * M-Pesa Payment Form
 *
 * @package daystar-website-fixes
 */

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
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/mpesa-logo.png'); ?>" alt="M-Pesa Logo" class="img-fluid mb-3" style="max-height: 60px;">
            <p class="text-muted small">
                <i class="fas fa-lock me-1"></i> Your payment information is secure and encrypted.
                Daystar Multi-Purpose Co-op Society Ltd. is an authorized M-Pesa partner.
            </p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('mpesa_payment_form', 'daystar_mpesa_payment_form_shortcode');
