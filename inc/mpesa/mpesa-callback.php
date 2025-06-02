<?php
/**
 * M-Pesa Callback Handler
 *
 * @package daystar-website-fixes
 */

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
