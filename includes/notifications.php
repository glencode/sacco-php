<?php
/**
 * Daystar Notification Functions
 *
 * Handles sending email and potentially SMS notifications for various events.
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set email content type to HTML
 */
function daystar_set_html_content_type() {
    return 'text/html';
}

/**
 * Send a notification email
 *
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $message Email body (HTML)
 * @param array $headers Optional email headers
 * @return bool True if email was sent successfully, false otherwise
 */
function daystar_send_email($to, $subject, $message, $headers = array()) {
    add_filter('wp_mail_content_type', 'daystar_set_html_content_type');
    
    // Add default headers if not provided
    if (empty($headers)) {
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $headers[] = 'From: ' . $site_name . ' <' . $admin_email . '>';
    }
    
    // Wrap message in a basic HTML template
    $full_message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . esc_html($subject) . '</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            .header { background-color: #f8f8f8; padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
            .content { padding: 20px 0; }
            .footer { margin-top: 20px; font-size: 0.9em; color: #777; text-align: center; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>' . esc_html(get_bloginfo('name')) . '</h2>
            </div>
            <div class="content">
                ' . $message . '
            </div>
            <div class="footer">
                <p>&copy; ' . date('Y') . ' ' . esc_html(get_bloginfo('name')) . '. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';
    
    $result = wp_mail($to, $subject, $full_message, $headers);
    
    // Remove the filter to avoid affecting other emails
    remove_filter('wp_mail_content_type', 'daystar_set_html_content_type');
    
    return $result;
}

/**
 * Send Welcome Email to New Member (Pending Approval)
 */
function daystar_send_welcome_pending_email($user_id) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Welcome to Daystar Multi-Purpose Co-op Society!';
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Thank you for registering with Daystar Multi-Purpose Co-op Society. Your application has been received and is currently pending review by our administration team.</p>';
    $message .= '<p>You will receive another email notification once your membership has been approved. This process usually takes 2-3 business days.</p>';
    $message .= '<p>In the meantime, if you have any questions, please feel free to contact us.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send New Member Registration Notification to Admin
 */
function daystar_send_admin_new_member_notification($user_id) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $admin_email = get_option('admin_email');
    $subject = 'New Member Registration Pending Approval';
    $message = '<p>A new member has registered and is awaiting approval:</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Name:</strong> ' . esc_html($user->display_name) . '</li>';
    $message .= '<li><strong>Email:</strong> ' . esc_html($user->user_email) . '</li>';
    $message .= '<li><strong>Registration Date:</strong> ' . date('F j, Y, g:i a') . '</li>';
    $message .= '</ul>';
    $message .= '<p>Please log in to the admin dashboard to review and approve/reject the application:</p>';
    $message .= '<p><a href="' . admin_url('admin.php?page=daystar-admin-members&status=pending') . '">Review Pending Members</a></p>';
    
    return daystar_send_email($admin_email, $subject, $message);
}

/**
 * Send Membership Approved Email
 */
function daystar_send_membership_approved_email($user_id) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $member_number = get_user_meta($user_id, 'member_number', true);
    
    $subject = 'Your Daystar Co-op Membership is Approved!';
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Congratulations! Your membership application for Daystar Multi-Purpose Co-op Society has been approved.</p>';
    $message .= '<p>Your Member Number is: <strong>' . esc_html($member_number) . '</strong></p>';
    $message .= '<p>You can now log in to your member dashboard to access services, make contributions, and apply for loans:</p>';
    $message .= '<p><a href="' . home_url('/member-dashboard/') . '">Access Member Dashboard</a></p>';
    $message .= '<p>Welcome to the Daystar family!</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Membership Rejected Email
 */
function daystar_send_membership_rejected_email($user_id, $reason = '') {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Update on Your Daystar Co-op Membership Application';
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>We regret to inform you that your membership application for Daystar Multi-Purpose Co-op Society could not be approved at this time.</p>';
    if (!empty($reason)) {
        $message .= '<p><strong>Reason:</strong> ' . esc_html($reason) . '</p>';
    }
    $message .= '<p>If you believe this decision was made in error or have further questions, please contact our support team.</p>';
    $message .= '<p>Sincerely,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Loan Application Received Email to Member
 */
function daystar_send_loan_application_received_email($user_id, $application_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Loan Application Received - ' . $application_details['loan_application_id'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Your loan application has been successfully received and is now under review. Here are the details:</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Application ID:</strong> ' . esc_html($application_details['loan_application_id']) . '</li>';
    $message .= '<li><strong>Loan Type:</strong> ' . esc_html(ucfirst($application_details['loan_type'])) . ' Loan</li>';
    $message .= '<li><strong>Amount Requested:</strong> KES ' . number_format($application_details['loan_amount'], 2) . '</li>';
    $message .= '<li><strong>Term:</strong> ' . esc_html($application_details['loan_term']) . ' months</li>';
    $message .= '<li><strong>Estimated Monthly Payment:</strong> KES ' . number_format($application_details['monthly_payment'], 2) . '</li>';
    $message .= '</ul>';
    $message .= '<p>The review process typically takes 5-7 business days. You will be notified via email once a decision has been made.</p>';
    $message .= '<p>You can track the status of your application in your member dashboard.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Loan Application Notification to Admin
 */
function daystar_send_admin_loan_application_notification($user_id, $application_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $admin_email = get_option('admin_email');
    $subject = 'New Loan Application Submitted - ' . $application_details['loan_application_id'];
    $message = '<p>A new loan application has been submitted and requires review:</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Application ID:</strong> ' . esc_html($application_details['loan_application_id']) . '</li>';
    $message .= '<li><strong>Member Name:</strong> ' . esc_html($user->display_name) . '</li>';
    $message .= '<li><strong>Member Number:</strong> ' . esc_html(get_user_meta($user_id, 'member_number', true)) . '</li>';
    $message .= '<li><strong>Loan Type:</strong> ' . esc_html(ucfirst($application_details['loan_type'])) . ' Loan</li>';
    $message .= '<li><strong>Amount Requested:</strong> KES ' . number_format($application_details['loan_amount'], 2) . '</li>';
    $message .= '<li><strong>Term:</strong> ' . esc_html($application_details['loan_term']) . ' months</li>';
    $message .= '</ul>';
    $message .= '<p>Please log in to the admin dashboard to review the full application details:</p>';
    $message .= '<p><a href="' . admin_url('admin.php?page=daystar-admin-loans&action=view&id=' . $application_details['loan_application_id']) . '">Review Loan Application</a></p>';
    
    return daystar_send_email($admin_email, $subject, $message);
}

/**
 * Send Loan Approved Email
 */
function daystar_send_loan_approved_email($user_id, $application_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Congratulations! Your Loan Application is Approved - ' . $application_details['loan_application_id'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>We are pleased to inform you that your loan application has been approved!</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Application ID:</strong> ' . esc_html($application_details['loan_application_id']) . '</li>';
    $message .= '<li><strong>Loan Type:</strong> ' . esc_html(ucfirst($application_details['loan_type'])) . ' Loan</li>';
    $message .= '<li><strong>Approved Amount:</strong> KES ' . number_format($application_details['loan_amount'], 2) . '</li>';
    $message .= '<li><strong>Term:</strong> ' . esc_html($application_details['loan_term']) . ' months</li>';
    $message .= '<li><strong>Monthly Payment:</strong> KES ' . number_format($application_details['monthly_payment'], 2) . '</li>';
    $message .= '</ul>';
    $message .= '<p>The loan amount will be disbursed to your registered bank account within 1-2 business days.</p>';
    $message .= '<p>You can view the loan details and repayment schedule in your member dashboard.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Loan Rejected Email
 */
function daystar_send_loan_rejected_email($user_id, $application_details, $reason = '') {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Update on Your Loan Application - ' . $application_details['loan_application_id'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>We regret to inform you that your loan application (' . esc_html($application_details['loan_application_id']) . ') could not be approved at this time.</p>';
    if (!empty($reason)) {
        $message .= '<p><strong>Reason:</strong> ' . esc_html($reason) . '</p>';
    }
    $message .= '<p>We encourage you to review the loan policy or contact us if you have any questions or wish to discuss this further.</p>';
    $message .= '<p>Sincerely,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Loan Disbursed Email
 */
function daystar_send_loan_disbursed_email($user_id, $application_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Your Loan Has Been Disbursed - ' . $application_details['loan_application_id'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Good news! Your approved loan (' . esc_html($application_details['loan_application_id']) . ') of KES ' . number_format($application_details['loan_amount'], 2) . ' has been disbursed.</p>';
    $message .= '<p>The funds should reflect in your registered bank account shortly.</p>';
    $message .= '<p>Your first repayment of KES ' . number_format($application_details['monthly_payment'], 2) . ' is due on [Next Payment Due Date]. Please ensure timely payments to maintain a good standing.</p>';
    $message .= '<p>You can view your loan statement and repayment schedule in the member dashboard.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    // Note: Replace [Next Payment Due Date] with actual calculated date
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Enhanced Loan Disbursement Email with Method Details
 */
function daystar_send_enhanced_loan_disbursement_email($user_id, $disbursement_data) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Loan Disbursed Successfully - ' . $disbursement_data['loan_application_id'];
    
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Great news! Your approved loan has been successfully disbursed.</p>';
    
    $message .= '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">';
    $message .= '<h3 style="margin-top: 0; color: #28a745;">Disbursement Details</h3>';
    $message .= '<ul style="list-style: none; padding: 0;">';
    $message .= '<li><strong>Application ID:</strong> ' . esc_html($disbursement_data['loan_application_id']) . '</li>';
    $message .= '<li><strong>Loan Type:</strong> ' . esc_html($disbursement_data['loan_type']) . '</li>';
    $message .= '<li><strong>Amount Disbursed:</strong> KES ' . number_format($disbursement_data['loan_amount'], 2) . '</li>';
    $message .= '<li><strong>Disbursement Method:</strong> ' . esc_html(ucfirst(str_replace('_', ' ', $disbursement_data['disbursement_method']))) . '</li>';
    $message .= '<li><strong>Reference Number:</strong> ' . esc_html($disbursement_data['disbursement_reference']) . '</li>';
    $message .= '<li><strong>Disbursement Date:</strong> ' . date('F j, Y', strtotime($disbursement_data['disbursed_date'])) . '</li>';
    $message .= '</ul>';
    $message .= '</div>';
    
    // Add method-specific information
    if ($disbursement_data['disbursement_method'] === 'mpesa') {
        $message .= '<p><strong>M-Pesa Disbursement:</strong> The funds have been sent to your registered M-Pesa number. You should receive an M-Pesa confirmation message shortly.</p>';
    } elseif ($disbursement_data['disbursement_method'] === 'bank_transfer') {
        $message .= '<p><strong>Bank Transfer:</strong> The funds have been transferred to your registered bank account. Please allow 1-2 business days for the funds to reflect in your account.</p>';
    } elseif ($disbursement_data['disbursement_method'] === 'cash') {
        $message .= '<p><strong>Cash Collection:</strong> Your loan amount is ready for collection at our office. Please bring a valid ID for verification.</p>';
    }
    
    $message .= '<div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">';
    $message .= '<h4 style="margin-top: 0; color: #856404;">Important Repayment Information</h4>';
    $message .= '<p>Your loan repayment schedule has been generated. Your first payment of <strong>KES ' . number_format($disbursement_data['monthly_payment'], 2) . '</strong> is due one month from the disbursement date.</p>';
    $message .= '<p>Please ensure timely payments to maintain a good credit standing with the SACCO.</p>';
    $message .= '</div>';
    
    $message .= '<p>You can view your complete loan details, repayment schedule, and make payments through your member dashboard:</p>';
    $message .= '<p><a href="' . home_url('/member-dashboard/') . '" style="background-color: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Access Member Dashboard</a></p>';
    
    $message .= '<p>If you have any questions about your loan or need assistance, please don\'t hesitate to contact us.</p>';
    $message .= '<p>Thank you for choosing Daystar Multi-Purpose Co-op Society!</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send SMS notification for loan disbursement
 */
function daystar_send_loan_disbursement_sms($phone_number, $disbursement_data) {
    $message = "DAYSTAR SACCO: Your loan of KES " . number_format($disbursement_data['loan_amount'], 2) . " has been disbursed successfully. ";
    $message .= "Ref: " . $disbursement_data['disbursement_reference'] . ". ";
    $message .= "First payment of KES " . number_format($disbursement_data['monthly_payment'], 2) . " due in 1 month. Thank you!";
    
    // In a real implementation, integrate with SMS gateway
    // For now, we'll log the SMS
    error_log("SMS to {$phone_number}: {$message}");
    
    return true;
}

/**
 * Send Payment Confirmation Email to Member
 */
function daystar_send_payment_confirmation_email($user_id, $payment_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Payment Confirmation - ' . $payment_details['payment_reference'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Your payment has been successfully received and processed. Thank you!</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Payment Reference:</strong> ' . esc_html($payment_details['payment_reference']) . '</li>';
    $message .= '<li><strong>Amount:</strong> KES ' . number_format($payment_details['amount'], 2) . '</li>';
    $message .= '<li><strong>Purpose:</strong> ' . esc_html(ucfirst(str_replace('_', ' ', $payment_details['purpose']))) . '</li>';
    $message .= '<li><strong>Method:</strong> ' . esc_html(ucfirst($payment_details['method'])) . '</li>';
    if (!empty($payment_details['mpesa_receipt'])) {
        $message .= '<li><strong>M-Pesa Receipt:</strong> ' . esc_html($payment_details['mpesa_receipt']) . '</li>';
    }
    $message .= '<li><strong>Date:</strong> ' . date('F j, Y, g:i a', strtotime($payment_details['completion_date'])) . '</li>';
    $message .= '</ul>';
    $message .= '<p>Your account has been updated accordingly. You can view your transaction history in the member dashboard.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Payment Notification to Admin
 */
function daystar_send_admin_payment_notification($user_id, $payment_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $admin_email = get_option('admin_email');
    $subject = 'New Payment Received - ' . $payment_details['payment_reference'];
    $message = '<p>A new payment has been successfully processed:</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Payment Reference:</strong> ' . esc_html($payment_details['payment_reference']) . '</li>';
    $message .= '<li><strong>Member Name:</strong> ' . esc_html($user->display_name) . '</li>';
    $message .= '<li><strong>Member Number:</strong> ' . esc_html(get_user_meta($user_id, 'member_number', true)) . '</li>';
    $message .= '<li><strong>Amount:</strong> KES ' . number_format($payment_details['amount'], 2) . '</li>';
    $message .= '<li><strong>Purpose:</strong> ' . esc_html(ucfirst(str_replace('_', ' ', $payment_details['purpose']))) . '</li>';
    $message .= '<li><strong>Method:</strong> ' . esc_html(ucfirst($payment_details['method'])) . '</li>';
    if (!empty($payment_details['mpesa_receipt'])) {
        $message .= '<li><strong>M-Pesa Receipt:</strong> ' . esc_html($payment_details['mpesa_receipt']) . '</li>';
    }
    $message .= '<li><strong>Date:</strong> ' . date('F j, Y, g:i a', strtotime($payment_details['completion_date'])) . '</li>';
    $message .= '</ul>';
    $message .= '<p>The member account and relevant records have been updated.</p>';
    $message .= '<p>You can view the payment details in the admin dashboard:</p>';
    $message .= '<p><a href="' . admin_url('admin.php?page=daystar-admin-payments') . '">View Payments</a></p>';
    
    return daystar_send_email($admin_email, $subject, $message);
}

/**
 * Send Bank Transfer Instructions Email
 */
function daystar_send_bank_transfer_instructions_email($user_id, $payment_details) {
    $user = get_user_by('id', $user_id);
    if (!$user) return false;
    
    $subject = 'Bank Transfer Instructions - ' . $payment_details['payment_reference'];
    $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
    $message .= '<p>Thank you for initiating a bank transfer payment of KES ' . number_format($payment_details['amount'], 2) . ' for ' . esc_html(str_replace('_', ' ', $payment_details['purpose'])) . '.</p>';
    $message .= '<p>Please use the following details to complete your bank transfer:</p>';
    $message .= '<ul>';
    $message .= '<li><strong>Bank Name:</strong> [Your Bank Name]</li>'; // Replace with actual bank name
    $message .= '<li><strong>Account Name:</strong> Daystar Multi-Purpose Co-op Society</li>';
    $message .= '<li><strong>Account Number:</strong> [Your Account Number]</li>'; // Replace with actual account number
    $message .= '<li><strong>Branch:</strong> [Your Branch Name]</li>'; // Replace with actual branch name
    $message .= '<li><strong>Payment Reference:</strong> <strong>' . esc_html($payment_details['payment_reference']) . '</strong></li>';
    $message .= '</ul>';
    $message .= '<p><strong>Important:</strong> Please ensure you include the Payment Reference in your transaction details so we can correctly allocate your payment.</p>';
    $message .= '<p>Once your payment is received and verified (usually within 1-2 business days), your account will be updated, and you will receive a confirmation email.</p>';
    $message .= '<p>Best regards,<br>The Daystar Team</p>';
    
    return daystar_send_email($user->user_email, $subject, $message);
}

/**
 * Send Password Reset Email
 */
function daystar_send_password_reset_email($user_email, $reset_link) {
    $subject = 'Password Reset Request for Daystar Co-op';
    $message = '<p>Hello,</p>';
    $message .= '<p>You recently requested to reset your password for your Daystar Multi-Purpose Co-op Society account.</p>';
    $message .= '<p>Click the link below to reset it:</p>';
    $message .= '<p><a href="' . esc_url($reset_link) . '">' . esc_url($reset_link) . '</a></p>';
    $message .= '<p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>';
    $message .= '<p>This password reset link is valid for the next 24 hours.</p>';
    $message .= '<p>Thanks,<br>The Daystar Team</p>';
    
    return daystar_send_email($user_email, $subject, $message);
}

// TODO: Add functions for SMS notifications if required
// function daystar_send_sms($phone_number, $message) { ... }

?>
