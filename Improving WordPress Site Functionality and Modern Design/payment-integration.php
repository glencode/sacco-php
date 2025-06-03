<?php
/**
 * Daystar Payment Integration Functions
 *
 * Handles payment integration with M-Pesa and other payment methods
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the action to handle payment form submission
 */
function daystar_payment_actions() {
    add_action('wp_ajax_daystar_process_payment', 'daystar_process_payment');
}
add_action('init', 'daystar_payment_actions');

/**
 * Process payment request
 */
function daystar_process_payment() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to make a payment.');
        exit;
    }
    
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_payment_nonce')) {
        wp_send_json_error('Security check failed. Please refresh the page and try again.');
        exit;
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Check if user is a member
    if (!in_array('member', $current_user->roles)) {
        wp_send_json_error('Only members can make payments.');
        exit;
    }
    
    // Collect and sanitize form data
    $payment_purpose = isset($_POST['payment_purpose']) ? sanitize_text_field($_POST['payment_purpose']) : '';
    $payment_amount = isset($_POST['payment_amount']) ? floatval($_POST['payment_amount']) : 0;
    $payment_method = isset($_POST['payment_method']) ? sanitize_text_field($_POST['payment_method']) : '';
    $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
    
    // Validate required fields
    $errors = array();
    
    if (empty($payment_purpose)) $errors[] = 'Payment purpose is required.';
    
    if ($payment_amount <= 0) {
        $errors[] = 'Payment amount must be greater than zero.';
    } else {
        // Check minimum payment amount based on purpose
        $min_amount = daystar_get_min_payment_amount($payment_purpose);
        if ($payment_amount < $min_amount) {
            $errors[] = 'The minimum payment amount for ' . $payment_purpose . ' is KES ' . number_format($min_amount, 2) . '.';
        }
    }
    
    if (empty($payment_method)) $errors[] = 'Payment method is required.';
    
    if ($payment_method === 'mpesa') {
        if (empty($phone_number)) {
            $errors[] = 'Phone number is required for M-Pesa payments.';
        } else {
            // Validate phone number format (simple check for now)
            if (!preg_match('/^\+?\d{10,15}$/', $phone_number)) {
                $errors[] = 'Please enter a valid phone number.';
            }
        }
    }
    
    // If there are errors, return them
    if (!empty($errors)) {
        wp_send_json_error(array('errors' => $errors));
        exit;
    }
    
    // Generate a unique payment reference
    $payment_reference = 'PAY' . date('Ymd') . str_pad(wp_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
    // Process payment based on method
    switch ($payment_method) {
        case 'mpesa':
            $result = daystar_process_mpesa_payment($user_id, $payment_amount, $payment_purpose, $phone_number, $payment_reference);
            break;
        case 'bank_transfer':
            $result = daystar_process_bank_transfer($user_id, $payment_amount, $payment_purpose, $payment_reference);
            break;
        default:
            $result = array(
                'success' => false,
                'message' => 'Invalid payment method.'
            );
    }
    
    // Return result
    if ($result['success']) {
        wp_send_json_success(array(
            'message' => $result['message'],
            'payment_reference' => $payment_reference,
            'redirect_url' => home_url('/member-dashboard/?tab=contributions')
        ));
    } else {
        wp_send_json_error($result['message']);
    }
    exit;
}

/**
 * Get minimum payment amount based on purpose
 */
function daystar_get_min_payment_amount($purpose) {
    $min_amounts = array(
        'contribution' => 500,
        'loan_repayment' => 1000,
        'registration_fee' => 1000,
        'share_capital' => 1000
    );
    
    return isset($min_amounts[$purpose]) ? $min_amounts[$purpose] : 500;
}

/**
 * Process M-Pesa payment
 */
function daystar_process_mpesa_payment($user_id, $amount, $purpose, $phone_number, $reference) {
    // In a real implementation, this would integrate with the M-Pesa API
    // For now, we'll simulate a successful payment for demonstration purposes
    
    // Get member data
    $user = get_user_by('id', $user_id);
    $member_number = get_user_meta($user_id, 'member_number', true);
    
    // Format phone number (remove + and country code if present)
    $phone_number = preg_replace('/^\+?254/', '0', $phone_number);
    
    // Save payment record
    $payment = array(
        'payment_reference' => $reference,
        'user_id' => $user_id,
        'amount' => $amount,
        'purpose' => $purpose,
        'method' => 'mpesa',
        'phone_number' => $phone_number,
        'status' => 'pending',
        'date' => current_time('mysql')
    );
    
    // In a real implementation, this would be saved to a database table
    // For now, we'll save it as user meta for demonstration purposes
    $payments = get_user_meta($user_id, 'payments', true);
    if (!is_array($payments)) {
        $payments = array();
    }
    $payments[$reference] = $payment;
    update_user_meta($user_id, 'payments', $payments);
    
    // Simulate M-Pesa STK push
    // In a real implementation, this would call the M-Pesa API to initiate an STK push
    
    // For demonstration purposes, we'll simulate a successful payment
    $payment['status'] = 'completed';
    $payment['mpesa_receipt'] = 'MP' . strtoupper(substr(md5($reference), 0, 8));
    $payment['completion_date'] = current_time('mysql');
    $payments[$reference] = $payment;
    update_user_meta($user_id, 'payments', $payments);
    
    // Update member data based on payment purpose
    switch ($purpose) {
        case 'contribution':
            // Update member's contribution record
            daystar_update_member_contribution($user_id, $amount, $reference);
            break;
        case 'loan_repayment':
            // Update loan repayment record
            daystar_update_loan_repayment($user_id, $amount, $reference);
            break;
        case 'registration_fee':
            // Update registration fee payment
            update_user_meta($user_id, 'registration_fee_paid', true);
            update_user_meta($user_id, 'registration_fee_amount', $amount);
            update_user_meta($user_id, 'registration_fee_date', current_time('mysql'));
            update_user_meta($user_id, 'registration_fee_reference', $reference);
            break;
        case 'share_capital':
            // Update share capital
            $share_capital = get_user_meta($user_id, 'share_capital', true);
            $share_capital = is_numeric($share_capital) ? $share_capital : 0;
            $share_capital += $amount;
            update_user_meta($user_id, 'share_capital', $share_capital);
            break;
    }
    
    // Send notification email to member
    $subject = 'Payment Confirmation - ' . $reference;
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Your payment of KES " . number_format($amount, 2) . " has been received and processed.\n\n";
    $message .= "Payment Details:\n";
    $message .= "Reference: $reference\n";
    $message .= "Amount: KES " . number_format($amount, 2) . "\n";
    $message .= "Purpose: " . ucfirst(str_replace('_', ' ', $purpose)) . "\n";
    $message .= "Method: M-Pesa\n";
    $message .= "M-Pesa Receipt: {$payment['mpesa_receipt']}\n";
    $message .= "Date: " . date('F j, Y, g:i a', strtotime($payment['completion_date'])) . "\n\n";
    $message .= "Thank you for your payment.\n\n";
    $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
    
    wp_mail($user->user_email, $subject, $message);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New Payment Received - ' . $reference;
    $message = "A new payment has been received:\n\n";
    $message .= "Member: {$user->display_name} ({$member_number})\n";
    $message .= "Reference: $reference\n";
    $message .= "Amount: KES " . number_format($amount, 2) . "\n";
    $message .= "Purpose: " . ucfirst(str_replace('_', ' ', $purpose)) . "\n";
    $message .= "Method: M-Pesa\n";
    $message .= "M-Pesa Receipt: {$payment['mpesa_receipt']}\n";
    $message .= "Date: " . date('F j, Y, g:i a', strtotime($payment['completion_date'])) . "\n";
    
    wp_mail($admin_email, $subject, $message);
    
    return array(
        'success' => true,
        'message' => 'Your payment has been processed successfully. M-Pesa receipt: ' . $payment['mpesa_receipt']
    );
}

/**
 * Process bank transfer payment
 */
function daystar_process_bank_transfer($user_id, $amount, $purpose, $reference) {
    // In a real implementation, this would provide bank details and track the payment
    // For now, we'll simulate a pending payment for demonstration purposes
    
    // Get member data
    $user = get_user_by('id', $user_id);
    $member_number = get_user_meta($user_id, 'member_number', true);
    
    // Save payment record
    $payment = array(
        'payment_reference' => $reference,
        'user_id' => $user_id,
        'amount' => $amount,
        'purpose' => $purpose,
        'method' => 'bank_transfer',
        'status' => 'pending',
        'date' => current_time('mysql')
    );
    
    // In a real implementation, this would be saved to a database table
    // For now, we'll save it as user meta for demonstration purposes
    $payments = get_user_meta($user_id, 'payments', true);
    if (!is_array($payments)) {
        $payments = array();
    }
    $payments[$reference] = $payment;
    update_user_meta($user_id, 'payments', $payments);
    
    // Send notification email to member
    $subject = 'Bank Transfer Instructions - ' . $reference;
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Thank you for initiating a bank transfer payment of KES " . number_format($amount, 2) . ".\n\n";
    $message .= "Please use the following details to complete your bank transfer:\n\n";
    $message .= "Bank: ABC Bank\n";
    $message .= "Account Name: Daystar Multi-Purpose Co-op Society\n";
    $message .= "Account Number: 1234567890\n";
    $message .= "Branch: Main Branch\n";
    $message .= "Reference: $reference\n\n";
    $message .= "Important: Please include the reference number in your bank transfer to ensure your payment is properly credited to your account.\n\n";
    $message .= "Once your payment has been received and verified, we will update your account accordingly.\n\n";
    $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
    
    wp_mail($user->user_email, $subject, $message);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New Bank Transfer Initiated - ' . $reference;
    $message = "A new bank transfer payment has been initiated:\n\n";
    $message .= "Member: {$user->display_name} ({$member_number})\n";
    $message .= "Reference: $reference\n";
    $message .= "Amount: KES " . number_format($amount, 2) . "\n";
    $message .= "Purpose: " . ucfirst(str_replace('_', ' ', $purpose)) . "\n";
    $message .= "Method: Bank Transfer\n";
    $message .= "Date: " . date('F j, Y, g:i a', strtotime($payment['date'])) . "\n";
    
    wp_mail($admin_email, $subject, $message);
    
    return array(
        'success' => true,
        'message' => 'Your bank transfer request has been recorded. Please complete the transfer using the instructions sent to your email.'
    );
}

/**
 * Update member contribution record
 */
function daystar_update_member_contribution($user_id, $amount, $reference) {
    // Get existing contributions
    $contributions = get_user_meta($user_id, 'contributions', true);
    if (!is_array($contributions)) {
        $contributions = array();
    }
    
    // Add new contribution
    $contributions[] = array(
        'amount' => $amount,
        'date' => current_time('mysql'),
        'reference' => $reference,
        'method' => 'mpesa',
        'status' => 'completed'
    );
    
    // Update user meta
    update_user_meta($user_id, 'contributions', $contributions);
    
    // Update total contributions
    $total_contributions = get_user_meta($user_id, 'total_contributions', true);
    $total_contributions = is_numeric($total_contributions) ? $total_contributions : 0;
    $total_contributions += $amount;
    update_user_meta($user_id, 'total_contributions', $total_contributions);
}

/**
 * Update loan repayment record
 */
function daystar_update_loan_repayment($user_id, $amount, $reference) {
    // In a real implementation, this would update the loan balance in a database table
    // For now, we'll simulate a loan repayment for demonstration purposes
    
    // Get active loans
    $active_loans = daystar_get_member_active_loans($user_id);
    
    if (!empty($active_loans)) {
        // Apply payment to the first active loan
        $loan = $active_loans[0];
        
        // Calculate new balance
        $new_balance = $loan['balance'] - $amount;
        if ($new_balance < 0) $new_balance = 0;
        
        // Update loan balance
        $loan['balance'] = $new_balance;
        
        // Add repayment record
        $loan['repayments'][] = array(
            'amount' => $amount,
            'date' => current_time('mysql'),
            'reference' => $reference,
            'method' => 'mpesa',
            'status' => 'completed'
        );
        
        // Check if loan is fully repaid
        if ($new_balance <= 0) {
            $loan['status'] = 'completed';
            $loan['completion_date'] = current_time('mysql');
        }
        
        // In a real implementation, this would update the loan record in a database table
        // For now, we'll save it as user meta for demonstration purposes
        $loans = get_user_meta($user_id, 'loans', true);
        if (!is_array($loans)) {
            $loans = array();
        }
        $loans[$loan['id']] = $loan;
        update_user_meta($user_id, 'loans', $loans);
    }
}

/**
 * Add M-Pesa callback handler
 */
function daystar_mpesa_callback() {
    // This function would handle callbacks from the M-Pesa API
    // For now, we'll just define it for demonstration purposes
    
    // Get the callback data
    $callback_data = file_get_contents('php://input');
    
    // Log the callback data
    error_log('M-Pesa Callback: ' . $callback_data);
    
    // Parse the callback data
    $callback = json_decode($callback_data, true);
    
    if ($callback && isset($callback['Body']['stkCallback'])) {
        $result_code = $callback['Body']['stkCallback']['ResultCode'];
        $result_desc = $callback['Body']['stkCallback']['ResultDesc'];
        $merchant_request_id = $callback['Body']['stkCallback']['MerchantRequestID'];
        $checkout_request_id = $callback['Body']['stkCallback']['CheckoutRequestID'];
        
        if ($result_code == 0) {
            // Payment successful
            $amount = $callback['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
            $mpesa_receipt = $callback['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $transaction_date = $callback['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $phone_number = $callback['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            
            // In a real implementation, this would update the payment record in a database table
            // For now, we'll just log the successful payment
            error_log('M-Pesa Payment Successful: ' . $mpesa_receipt);
        } else {
            // Payment failed
            error_log('M-Pesa Payment Failed: ' . $result_desc);
        }
    }
    
    // Return a response to M-Pesa
    header('Content-Type: application/json');
    echo json_encode(array('ResultCode' => 0, 'ResultDesc' => 'Success'));
    exit;
}
add_action('rest_api_init', function() {
    register_rest_route('daystar/v1', '/mpesa-callback', array(
        'methods' => 'POST',
        'callback' => 'daystar_mpesa_callback',
        'permission_callback' => '__return_true'
    ));
});

/**
 * Add payment management admin page
 */
function daystar_add_payment_menu() {
    add_menu_page(
        'Payments',
        'Payments',
        'manage_options',
        'daystar-payments',
        'daystar_payments_page',
        'dashicons-money',
        31
    );
}
add_action('admin_menu', 'daystar_add_payment_menu');

/**
 * Render payments admin page
 */
function daystar_payments_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get all payments
    $payments = daystar_get_all_payments();
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="filter-status">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
                <select id="filter-method">
                    <option value="">All Methods</option>
                    <option value="mpesa">M-Pesa</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <select id="filter-purpose">
                    <option value="">All Purposes</option>
                    <option value="contribution">Contribution</option>
                    <option value="loan_repayment">Loan Repayment</option>
                    <option value="registration_fee">Registration Fee</option>
                    <option value="share_capital">Share Capital</option>
                </select>
                <input type="submit" id="filter-submit" class="button" value="Filter">
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($payments)) : ?>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?php echo esc_html($payment['payment_reference']); ?></td>
                            <td>
                                <?php 
                                $user = get_user_by('id', $payment['user_id']);
                                echo esc_html($user->display_name);
                                ?>
                            </td>
                            <td>KES <?php echo number_format($payment['amount'], 2); ?></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $payment['purpose'])); ?></td>
                            <td><?php echo $payment['method'] === 'mpesa' ? 'M-Pesa' : 'Bank Transfer'; ?></td>
                            <td><?php echo date('M j, Y, g:i a', strtotime($payment['date'])); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($payment['status']); ?>">
                                    <?php echo ucfirst(esc_html($payment['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="button view-payment" data-id="<?php echo esc_attr($payment['payment_reference']); ?>">View</a>
                                
                                <?php if ($payment['status'] === 'pending' && $payment['method'] === 'bank_transfer') : ?>
                                    <a href="#" class="button approve-payment" data-id="<?php echo esc_attr($payment['payment_reference']); ?>">Approve</a>
                                    <a href="#" class="button reject-payment" data-id="<?php echo esc_attr($payment['payment_reference']); ?>">Reject</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <style>
        .status-completed {
            color: #5cb85c;
            font-weight: bold;
        }
        .status-pending {
            color: #f0ad4e;
            font-weight: bold;
        }
        .status-failed {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Filter payments
        $('#filter-submit').on('click', function() {
            var status = $('#filter-status').val();
            var method = $('#filter-method').val();
            var purpose = $('#filter-purpose').val();
            
            // In a real implementation, this would reload the page with filters
            // For now, we'll just show/hide rows
            $('tbody tr').show();
            
            if (status) {
                $('tbody tr').each(function() {
                    if (!$(this).find('td:nth-child(7) span').hasClass('status-' + status)) {
                        $(this).hide();
                    }
                });
            }
            
            if (method) {
                $('tbody tr').each(function() {
                    var methodText = $(this).find('td:nth-child(5)').text().toLowerCase();
                    if (method === 'mpesa' && methodText !== 'm-pesa') {
                        $(this).hide();
                    } else if (method === 'bank_transfer' && methodText !== 'bank transfer') {
                        $(this).hide();
                    }
                });
            }
            
            if (purpose) {
                $('tbody tr').each(function() {
                    var purposeText = $(this).find('td:nth-child(4)').text().toLowerCase().replace(' ', '_');
                    if (purposeText !== purpose) {
                        $(this).hide();
                    }
                });
            }
        });
        
        // View payment details
        $('.view-payment').on('click', function(e) {
            e.preventDefault();
            var paymentId = $(this).data('id');
            
            // In a real implementation, this would show payment details
            alert('View payment details for ' + paymentId);
        });
        
        // Approve payment
        $('.approve-payment').on('click', function(e) {
            e.preventDefault();
            var paymentId = $(this).data('id');
            
            if (confirm('Are you sure you want to approve this payment?')) {
                // In a real implementation, this would make an AJAX request to approve the payment
                alert('Payment ' + paymentId + ' has been approved.');
                // Refresh the page
                location.reload();
            }
        });
        
        // Reject payment
        $('.reject-payment').on('click', function(e) {
            e.preventDefault();
            var paymentId = $(this).data('id');
            
            if (confirm('Are you sure you want to reject this payment?')) {
                // In a real implementation, this would make an AJAX request to reject the payment
                alert('Payment ' + paymentId + ' has been rejected.');
                // Refresh the page
                location.reload();
            }
        });
    });
    </script>
    <?php
}

/**
 * Get all payments
 */
function daystar_get_all_payments() {
    // In a real implementation, this would query a database table
    // For now, we'll return sample data for demonstration purposes
    $payments = array(
        array(
            'payment_reference' => 'PAY20250601001',
            'user_id' => 1,
            'amount' => 5000,
            'purpose' => 'contribution',
            'method' => 'mpesa',
            'phone_number' => '0712345678',
            'mpesa_receipt' => 'MP12345678',
            'status' => 'completed',
            'date' => '2025-06-01 09:30:45',
            'completion_date' => '2025-06-01 09:31:22'
        ),
        array(
            'payment_reference' => 'PAY20250531002',
            'user_id' => 2,
            'amount' => 10000,
            'purpose' => 'loan_repayment',
            'method' => 'mpesa',
            'phone_number' => '0723456789',
            'mpesa_receipt' => 'MP23456789',
            'status' => 'completed',
            'date' => '2025-05-31 14:15:22',
            'completion_date' => '2025-05-31 14:16:05'
        ),
        array(
            'payment_reference' => 'PAY20250530003',
            'user_id' => 3,
            'amount' => 15000,
            'purpose' => 'share_capital',
            'method' => 'bank_transfer',
            'status' => 'pending',
            'date' => '2025-05-30 11:05:33'
        ),
        array(
            'payment_reference' => 'PAY20250529004',
            'user_id' => 4,
            'amount' => 1000,
            'purpose' => 'registration_fee',
            'method' => 'mpesa',
            'phone_number' => '0734567890',
            'mpesa_receipt' => 'MP34567890',
            'status' => 'completed',
            'date' => '2025-05-29 16:45:10',
            'completion_date' => '2025-05-29 16:46:30'
        ),
        array(
            'payment_reference' => 'PAY20250528005',
            'user_id' => 5,
            'amount' => 7500,
            'purpose' => 'contribution',
            'method' => 'bank_transfer',
            'status' => 'failed',
            'date' => '2025-05-28 10:20:15'
        ),
    );
    
    return $payments;
}

/**
 * Add payment shortcode
 */
function daystar_payment_form_shortcode() {
    ob_start();
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        echo '<div class="alert alert-warning">You must be logged in to make a payment. <a href="' . esc_url(home_url('/login')) . '">Login</a> or <a href="' . esc_url(home_url('/register')) . '">Register</a></div>';
        return ob_get_clean();
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    
    // Check if user is a member
    if (!in_array('member', $current_user->roles)) {
        echo '<div class="alert alert-warning">Only members can make payments.</div>';
        return ob_get_clean();
    }
    
    // Get member data
    $user_id = $current_user->ID;
    $phone = get_user_meta($user_id, 'phone', true);
    
    ?>
    <div class="payment-form-container">
        <h3>Make a Payment</h3>
        
        <form id="payment-form" class="needs-validation" novalidate>
            <?php wp_nonce_field('daystar_payment_nonce', 'payment_nonce'); ?>
            
            <div class="form-group">
                <label for="payment-purpose">Payment Purpose <span class="required">*</span></label>
                <select class="form-control" id="payment-purpose" name="payment_purpose" required>
                    <option value="">Select Payment Purpose</option>
                    <option value="contribution">Monthly Contribution</option>
                    <option value="loan_repayment">Loan Repayment</option>
                    <option value="registration_fee">Registration Fee</option>
                    <option value="share_capital">Share Capital</option>
                </select>
                <div class="invalid-feedback">Please select a payment purpose.</div>
            </div>
            
            <div class="form-group">
                <label for="payment-amount">Amount (KES) <span class="required">*</span></label>
                <input type="number" class="form-control" id="payment-amount" name="payment_amount" min="500" required>
                <div class="invalid-feedback">Please enter a valid amount.</div>
                <small class="form-text text-muted">Minimum amount: KES 500</small>
            </div>
            
            <div class="form-group">
                <label>Payment Method <span class="required">*</span></label>
                <div class="payment-methods">
                    <div class="form-check payment-method-option">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment-method-mpesa" value="mpesa" checked>
                        <label class="form-check-label" for="payment-method-mpesa">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mpesa-logo.png" alt="M-Pesa" class="payment-method-logo">
                            M-Pesa
                        </label>
                    </div>
                    <div class="form-check payment-method-option">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment-method-bank" value="bank_transfer">
                        <label class="form-check-label" for="payment-method-bank">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bank-logo.png" alt="Bank Transfer" class="payment-method-logo">
                            Bank Transfer
                        </label>
                    </div>
                </div>
            </div>
            
            <div id="mpesa-details" class="payment-method-details">
                <div class="form-group">
                    <label for="phone-number">M-Pesa Phone Number <span class="required">*</span></label>
                    <input type="tel" class="form-control" id="phone-number" name="phone_number" value="<?php echo esc_attr($phone); ?>" placeholder="+254XXXXXXXXX" required>
                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                    <small class="form-text text-muted">Enter the phone number registered with M-Pesa</small>
                </div>
            </div>
            
            <div id="bank-details" class="payment-method-details" style="display: none;">
                <div class="alert alert-info">
                    <h5>Bank Transfer Details</h5>
                    <p>Please use the following details to make your bank transfer:</p>
                    <p>Bank: ABC Bank<br>
                    Account Name: Daystar Multi-Purpose Co-op Society<br>
                    Account Number: 1234567890<br>
                    Branch: Main Branch</p>
                    <p>After making the transfer, you will receive a reference number to track your payment.</p>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Make Payment</button>
            </div>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Toggle payment method details
        $('input[name="payment_method"]').on('change', function() {
            var method = $(this).val();
            
            if (method === 'mpesa') {
                $('#mpesa-details').show();
                $('#bank-details').hide();
                $('#phone-number').prop('required', true);
            } else if (method === 'bank_transfer') {
                $('#mpesa-details').hide();
                $('#bank-details').show();
                $('#phone-number').prop('required', false);
            }
        });
        
        // Form validation and submission
        $('#payment-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this)[0];
            
            if (form.checkValidity() === false) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            
            // Show loading state
            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
            
            // Collect form data
            var formData = {
                action: 'daystar_process_payment',
                nonce: $('#payment_nonce').val(),
                payment_purpose: $('#payment-purpose').val(),
                payment_amount: $('#payment-amount').val(),
                payment_method: $('input[name="payment_method"]:checked').val(),
                phone_number: $('#phone-number').val()
            };
            
            // Submit the form via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Redirect to the dashboard
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            }
                        });
                    } else {
                        // Show error message
                        var errorMessage = 'An error occurred. Please try again.';
                        
                        if (response.data && response.data.errors) {
                            errorMessage = response.data.errors.join('<br>');
                        } else if (response.data) {
                            errorMessage = response.data;
                        }
                        
                        Swal.fire({
                            title: 'Error',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        
                        // Reset button
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                },
                error: function() {
                    // Show error message
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    
                    // Reset button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    });
    </script>
    <?php
    
    return ob_get_clean();
}
add_shortcode('payment_form', 'daystar_payment_form_shortcode');
