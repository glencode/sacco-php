<?php
/**
 * Loan Disbursement Procedure
 * 
 * Handles the complete loan disbursement process including:
 * - Automated notifications (email/SMS)
 * - Electronic disbursement via M-Pesa and bank transfers
 * - Digital signatures and confirmations
 * - Payment evidence attachment
 * - Transaction tracking and reconciliation
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/notifications.php';
require_once get_template_directory() . '/mpesa-integration.php';

/**
 * Loan Disbursement Handler Class
 */
class LoanDisbursementHandler {
    
    /**
     * Initialize disbursement hooks
     */
    public static function init() {
        add_action('wp_ajax_initiate_loan_disbursement', array(__CLASS__, 'ajax_initiate_disbursement'));
        add_action('wp_ajax_upload_disbursement_evidence', array(__CLASS__, 'ajax_upload_evidence'));
        add_action('wp_ajax_confirm_disbursement_receipt', array(__CLASS__, 'ajax_confirm_receipt'));
        add_action('wp_ajax_check_mpesa_disbursement_status', array(__CLASS__, 'ajax_check_mpesa_status'));
        
        // Hook for automatic disbursement notifications
        add_action('loan_disbursed', array(__CLASS__, 'trigger_disbursement_notifications'), 10, 2);
    }
    
    /**
     * Initiate loan disbursement process
     */
    public static function initiate_disbursement($loan_id, $disbursement_method = 'bank_transfer', $disbursement_details = array()) {
        global $wpdb;
        
        try {
            // Validate loan
            $loan = self::get_loan_details($loan_id);
            if (!$loan) {
                throw new Exception('Loan not found');
            }
            
            if ($loan->status !== 'approved') {
                throw new Exception('Loan must be approved before disbursement');
            }
            
            if (!empty($loan->disbursed_date)) {
                throw new Exception('Loan has already been disbursed');
            }
            
            // Get user details
            $user = get_user_by('id', $loan->user_id);
            if (!$user) {
                throw new Exception('User not found');
            }
            
            $disbursement_reference = 'DSB' . date('YmdHis') . $loan_id;
            $disbursement_result = array();
            
            // Process disbursement based on method
            switch ($disbursement_method) {
                case 'mpesa':
                    $disbursement_result = self::process_mpesa_disbursement($loan, $user, $disbursement_details, $disbursement_reference);
                    break;
                    
                case 'bank_transfer':
                    $disbursement_result = self::process_bank_transfer_disbursement($loan, $user, $disbursement_details, $disbursement_reference);
                    break;
                    
                case 'cash':
                    $disbursement_result = self::process_cash_disbursement($loan, $user, $disbursement_details, $disbursement_reference);
                    break;
                    
                default:
                    throw new Exception('Invalid disbursement method');
            }
            
            // Update loan record
            $update_data = array(
                'status' => 'disbursed',
                'disbursed_date' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            );
            
            $loans_table = $wpdb->prefix . 'daystar_loans';
            $updated = $wpdb->update(
                $loans_table,
                $update_data,
                array('id' => $loan_id),
                array('%s', '%s', '%s'),
                array('%d')
            );
            
            if ($updated === false) {
                throw new Exception('Failed to update loan status');
            }
            
            // Create disbursement record
            self::create_disbursement_record($loan_id, $disbursement_method, $disbursement_reference, $disbursement_result);
            
            // Generate loan repayment schedule
            self::generate_repayment_schedule($loan_id);
            
            // Trigger notifications
            do_action('loan_disbursed', $loan_id, $disbursement_result);
            
            return array(
                'success' => true,
                'message' => 'Loan disbursement initiated successfully',
                'disbursement_reference' => $disbursement_reference,
                'disbursement_result' => $disbursement_result
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Process M-Pesa disbursement (B2C)
     */
    private static function process_mpesa_disbursement($loan, $user, $details, $reference) {
        // Get user phone number
        $phone = get_user_meta($user->ID, 'phone_number', true);
        if (empty($phone)) {
            throw new Exception('User phone number not found for M-Pesa disbursement');
        }
        
        // Validate phone number format
        $phone = self::format_phone_number($phone);
        
        // Initiate M-Pesa B2C transaction
        $mpesa_result = self::initiate_mpesa_b2c($phone, $loan->amount, $reference, 'Loan disbursement');
        
        if (!$mpesa_result['success']) {
            throw new Exception('M-Pesa disbursement failed: ' . $mpesa_result['message']);
        }
        
        return array(
            'method' => 'mpesa',
            'phone_number' => $phone,
            'transaction_id' => $mpesa_result['transaction_id'] ?? null,
            'status' => 'pending',
            'details' => $mpesa_result
        );
    }
    
    /**
     * Process bank transfer disbursement
     */
    private static function process_bank_transfer_disbursement($loan, $user, $details, $reference) {
        // Get user bank details
        $bank_name = get_user_meta($user->ID, 'bank_name', true);
        $account_number = get_user_meta($user->ID, 'bank_account_number', true);
        $account_name = get_user_meta($user->ID, 'bank_account_name', true);
        
        if (empty($bank_name) || empty($account_number)) {
            throw new Exception('User bank details not found for bank transfer disbursement');
        }
        
        // In a real implementation, this would integrate with banking APIs
        // For now, we'll mark it as pending manual processing
        
        return array(
            'method' => 'bank_transfer',
            'bank_name' => $bank_name,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'status' => 'pending_manual_processing',
            'instructions' => 'Bank transfer to be processed manually by finance team'
        );
    }
    
    /**
     * Process cash disbursement
     */
    private static function process_cash_disbursement($loan, $user, $details, $reference) {
        return array(
            'method' => 'cash',
            'status' => 'pending_collection',
            'collection_location' => $details['collection_location'] ?? 'Main Office',
            'instructions' => 'Cash ready for collection at specified location'
        );
    }
    
    /**
     * Initiate M-Pesa B2C transaction
     */
    private static function initiate_mpesa_b2c($phone, $amount, $reference, $description) {
        try {
            // This would use the actual M-Pesa B2C API
            // For demonstration, we'll simulate the process
            
            $access_token = MPesaAPI::getAccessToken();
            
            $url = MPesaConfig::getBaseUrl() . '/mpesa/b2c/v1/paymentrequest';
            
            $data = array(
                'InitiatorName' => 'testapi',
                'SecurityCredential' => 'YOUR_SECURITY_CREDENTIAL',
                'CommandID' => 'BusinessPayment',
                'Amount' => $amount,
                'PartyA' => MPesaConfig::SHORTCODE,
                'PartyB' => $phone,
                'Remarks' => $description,
                'QueueTimeOutURL' => MPesaConfig::CALLBACK_URL . '?type=timeout',
                'ResultURL' => MPesaConfig::CALLBACK_URL . '?type=result',
                'Occasion' => $reference
            );
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            if ($response === false) {
                throw new Exception('M-Pesa B2C request failed: ' . curl_error($curl));
            }
            
            curl_close($curl);
            
            $result = json_decode($response, true);
            
            if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                return array(
                    'success' => true,
                    'transaction_id' => $result['ConversationID'],
                    'originator_conversation_id' => $result['OriginatorConversationID'],
                    'response_description' => $result['ResponseDescription']
                );
            } else {
                return array(
                    'success' => false,
                    'message' => $result['ResponseDescription'] ?? 'Unknown error'
                );
            }
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Create disbursement record
     */
    private static function create_disbursement_record($loan_id, $method, $reference, $result) {
        global $wpdb;
        
        $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
        
        // Create table if it doesn't exist
        self::create_disbursements_table();
        
        $data = array(
            'loan_id' => $loan_id,
            'disbursement_method' => $method,
            'disbursement_reference' => $reference,
            'disbursement_details' => json_encode($result),
            'status' => $result['status'] ?? 'completed',
            'created_at' => current_time('mysql')
        );
        
        $wpdb->insert($disbursements_table, $data);
        
        return $wpdb->insert_id;
    }
    
    /**
     * Create disbursements table if it doesn't exist
     */
    private static function create_disbursements_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_loan_disbursements';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            loan_id mediumint(9) NOT NULL,
            disbursement_method varchar(50) NOT NULL,
            disbursement_reference varchar(100) NOT NULL,
            disbursement_details longtext,
            status varchar(50) DEFAULT 'pending',
            disbursed_by bigint(20) NULL,
            disbursed_date datetime NULL,
            evidence_path varchar(255) NULL,
            digital_signature_data longtext NULL,
            recipient_confirmation tinyint(1) DEFAULT 0,
            recipient_confirmation_date datetime NULL,
            notes text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY loan_id (loan_id),
            KEY disbursement_reference (disbursement_reference),
            KEY status (status),
            KEY disbursed_by (disbursed_by)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Generate loan repayment schedule
     */
    private static function generate_repayment_schedule($loan_id) {
        global $wpdb;
        
        $loan = self::get_loan_details($loan_id);
        if (!$loan) {
            return false;
        }
        
        $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
        
        // Clear existing schedule
        $wpdb->delete($schedules_table, array('loan_id' => $loan_id));
        
        $principal_per_installment = $loan->amount / $loan->term_months;
        $monthly_interest_rate = $loan->interest_rate / 100 / 12;
        
        for ($i = 1; $i <= $loan->term_months; $i++) {
            $due_date = date('Y-m-d', strtotime($loan->disbursed_date . " +{$i} months"));
            
            // Calculate reducing balance interest
            $remaining_balance = $loan->amount - (($i - 1) * $principal_per_installment);
            $interest_amount = $remaining_balance * $monthly_interest_rate;
            
            $schedule_data = array(
                'loan_id' => $loan_id,
                'installment_number' => $i,
                'due_date' => $due_date,
                'expected_principal' => $principal_per_installment,
                'expected_interest' => $interest_amount,
                'expected_total' => $principal_per_installment + $interest_amount,
                'status' => 'due'
            );
            
            $wpdb->insert($schedules_table, $schedule_data);
        }
        
        return true;
    }
    
    /**
     * Trigger disbursement notifications
     */
    public static function trigger_disbursement_notifications($loan_id, $disbursement_result) {
        $loan = self::get_loan_details($loan_id);
        if (!$loan) {
            return;
        }
        
        $user = get_user_by('id', $loan->user_id);
        if (!$user) {
            return;
        }
        
        // Prepare notification data
        $notification_data = array(
            'loan_application_id' => 'LOAN-' . str_pad($loan_id, 6, '0', STR_PAD_LEFT),
            'loan_type' => $loan->loan_type,
            'loan_amount' => $loan->amount,
            'loan_term' => $loan->term_months,
            'monthly_payment' => $loan->monthly_payment,
            'disbursement_method' => $disbursement_result['method'] ?? 'bank_transfer',
            'disbursement_reference' => $disbursement_result['disbursement_reference'] ?? '',
            'disbursed_date' => current_time('mysql')
        );
        
        // Send email notification
        self::send_disbursement_email_notification($user->ID, $notification_data);
        
        // Send SMS notification if phone number is available
        $phone = get_user_meta($user->ID, 'phone_number', true);
        if (!empty($phone)) {
            self::send_disbursement_sms_notification($phone, $notification_data);
        }
        
        // Create in-app notification
        self::create_in_app_notification($user->ID, $notification_data);
        
        // Send admin notification
        self::send_admin_disbursement_notification($user->ID, $notification_data);
    }
    
    /**
     * Send disbursement email notification
     */
    private static function send_disbursement_email_notification($user_id, $data) {
        $user = get_user_by('id', $user_id);
        if (!$user) {
            return false;
        }
        
        $subject = 'Loan Disbursed Successfully - ' . $data['loan_application_id'];
        
        $message = '<p>Dear ' . esc_html($user->first_name) . ',</p>';
        $message .= '<p>Great news! Your approved loan has been successfully disbursed.</p>';
        
        $message .= '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        $message .= '<h3 style="margin-top: 0; color: #28a745;">Disbursement Details</h3>';
        $message .= '<ul style="list-style: none; padding: 0;">';
        $message .= '<li><strong>Application ID:</strong> ' . esc_html($data['loan_application_id']) . '</li>';
        $message .= '<li><strong>Loan Type:</strong> ' . esc_html($data['loan_type']) . '</li>';
        $message .= '<li><strong>Amount Disbursed:</strong> KES ' . number_format($data['loan_amount'], 2) . '</li>';
        $message .= '<li><strong>Disbursement Method:</strong> ' . esc_html(ucfirst(str_replace('_', ' ', $data['disbursement_method']))) . '</li>';
        $message .= '<li><strong>Reference Number:</strong> ' . esc_html($data['disbursement_reference']) . '</li>';
        $message .= '<li><strong>Disbursement Date:</strong> ' . date('F j, Y', strtotime($data['disbursed_date'])) . '</li>';
        $message .= '</ul>';
        $message .= '</div>';
        
        // Add method-specific information
        if ($data['disbursement_method'] === 'mpesa') {
            $message .= '<p><strong>M-Pesa Disbursement:</strong> The funds have been sent to your registered M-Pesa number. You should receive an M-Pesa confirmation message shortly.</p>';
        } elseif ($data['disbursement_method'] === 'bank_transfer') {
            $message .= '<p><strong>Bank Transfer:</strong> The funds have been transferred to your registered bank account. Please allow 1-2 business days for the funds to reflect in your account.</p>';
        } elseif ($data['disbursement_method'] === 'cash') {
            $message .= '<p><strong>Cash Collection:</strong> Your loan amount is ready for collection at our office. Please bring a valid ID for verification.</p>';
        }
        
        $message .= '<div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">';
        $message .= '<h4 style="margin-top: 0; color: #856404;">Important Repayment Information</h4>';
        $message .= '<p>Your loan repayment schedule has been generated. Your first payment of <strong>KES ' . number_format($data['monthly_payment'], 2) . '</strong> is due one month from the disbursement date.</p>';
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
     * Send disbursement SMS notification
     */
    private static function send_disbursement_sms_notification($phone, $data) {
        $message = "DAYSTAR SACCO: Your loan of KES " . number_format($data['loan_amount'], 2) . " has been disbursed successfully. ";
        $message .= "Ref: " . $data['disbursement_reference'] . ". ";
        $message .= "First payment of KES " . number_format($data['monthly_payment'], 2) . " due in 1 month. Thank you!";
        
        // In a real implementation, integrate with SMS gateway
        // For now, we'll log the SMS
        error_log("SMS to {$phone}: {$message}");
        
        return true;
    }
    
    /**
     * Create in-app notification
     */
    private static function create_in_app_notification($user_id, $data) {
        global $wpdb;
        
        $notifications_table = $wpdb->prefix . 'daystar_notifications';
        
        $notification_data = array(
            'user_id' => $user_id,
            'title' => 'Loan Disbursed Successfully',
            'message' => 'Your loan of KES ' . number_format($data['loan_amount'], 2) . ' has been disbursed. Reference: ' . $data['disbursement_reference'],
            'type' => 'loan_disbursement',
            'is_read' => 0,
            'created_at' => current_time('mysql')
        );
        
        return $wpdb->insert($notifications_table, $notification_data);
    }
    
    /**
     * Send admin disbursement notification
     */
    private static function send_admin_disbursement_notification($user_id, $data) {
        $user = get_user_by('id', $user_id);
        if (!$user) {
            return false;
        }
        
        $admin_email = get_option('admin_email');
        $subject = 'Loan Disbursement Completed - ' . $data['loan_application_id'];
        
        $message = '<p>A loan has been successfully disbursed:</p>';
        $message .= '<ul>';
        $message .= '<li><strong>Application ID:</strong> ' . esc_html($data['loan_application_id']) . '</li>';
        $message .= '<li><strong>Member Name:</strong> ' . esc_html($user->display_name) . '</li>';
        $message .= '<li><strong>Member Number:</strong> ' . esc_html(get_user_meta($user_id, 'member_number', true)) . '</li>';
        $message .= '<li><strong>Amount:</strong> KES ' . number_format($data['loan_amount'], 2) . '</li>';
        $message .= '<li><strong>Method:</strong> ' . esc_html(ucfirst(str_replace('_', ' ', $data['disbursement_method']))) . '</li>';
        $message .= '<li><strong>Reference:</strong> ' . esc_html($data['disbursement_reference']) . '</li>';
        $message .= '<li><strong>Date:</strong> ' . date('F j, Y, g:i a', strtotime($data['disbursed_date'])) . '</li>';
        $message .= '</ul>';
        
        $message .= '<p>The member has been notified via email and SMS. The loan repayment schedule has been generated automatically.</p>';
        
        return daystar_send_email($admin_email, $subject, $message);
    }
    
    /**
     * Upload disbursement evidence
     */
    public static function upload_disbursement_evidence($loan_id, $file_data) {
        global $wpdb;
        
        try {
            // Validate file
            $allowed_types = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx');
            $file_extension = strtolower(pathinfo($file_data['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_extension, $allowed_types)) {
                throw new Exception('Invalid file type. Allowed types: ' . implode(', ', $allowed_types));
            }
            
            // Create upload directory
            $upload_dir = wp_upload_dir();
            $disbursement_dir = $upload_dir['basedir'] . '/disbursement-evidence/';
            
            if (!file_exists($disbursement_dir)) {
                wp_mkdir_p($disbursement_dir);
            }
            
            // Generate unique filename
            $filename = 'disbursement_' . $loan_id . '_' . time() . '.' . $file_extension;
            $file_path = $disbursement_dir . $filename;
            
            // Move uploaded file
            if (!move_uploaded_file($file_data['tmp_name'], $file_path)) {
                throw new Exception('Failed to upload file');
            }
            
            // Update disbursement record
            $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
            $relative_path = 'disbursement-evidence/' . $filename;
            
            $updated = $wpdb->update(
                $disbursements_table,
                array('evidence_path' => $relative_path),
                array('loan_id' => $loan_id),
                array('%s'),
                array('%d')
            );
            
            if ($updated === false) {
                throw new Exception('Failed to update disbursement record');
            }
            
            return array(
                'success' => true,
                'message' => 'Evidence uploaded successfully',
                'file_path' => $relative_path
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Record digital signature/confirmation
     */
    public static function record_digital_confirmation($loan_id, $confirmation_data) {
        global $wpdb;
        
        $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
        
        $signature_data = array(
            'confirmed_by' => get_current_user_id(),
            'confirmation_date' => current_time('mysql'),
            'confirmation_type' => $confirmation_data['type'] ?? 'digital_acknowledgment',
            'confirmation_details' => $confirmation_data['details'] ?? '',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        );
        
        $updated = $wpdb->update(
            $disbursements_table,
            array(
                'digital_signature_data' => json_encode($signature_data),
                'recipient_confirmation' => 1,
                'recipient_confirmation_date' => current_time('mysql')
            ),
            array('loan_id' => $loan_id),
            array('%s', '%d', '%s'),
            array('%d')
        );
        
        return $updated !== false;
    }
    
    /**
     * Get loan details
     */
    private static function get_loan_details($loan_id) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $loans_table WHERE id = %d",
            $loan_id
        ));
    }
    
    /**
     * Format phone number for M-Pesa
     */
    private static function format_phone_number($phone) {
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
     * AJAX handler for initiating disbursement
     */
    public static function ajax_initiate_disbursement() {
        // Verify nonce and permissions
        if (!wp_verify_nonce($_POST['nonce'], 'loan_disbursement_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $loan_id = intval($_POST['loan_id']);
        $method = sanitize_text_field($_POST['disbursement_method']);
        $details = array();
        
        if (isset($_POST['details'])) {
            $details = array_map('sanitize_text_field', $_POST['details']);
        }
        
        $result = self::initiate_disbursement($loan_id, $method, $details);
        
        wp_send_json($result);
    }
    
    /**
     * AJAX handler for uploading evidence
     */
    public static function ajax_upload_evidence() {
        // Verify nonce and permissions
        if (!wp_verify_nonce($_POST['nonce'], 'loan_disbursement_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $loan_id = intval($_POST['loan_id']);
        
        if (!isset($_FILES['evidence_file'])) {
            wp_send_json(array('success' => false, 'message' => 'No file uploaded'));
        }
        
        $result = self::upload_disbursement_evidence($loan_id, $_FILES['evidence_file']);
        
        wp_send_json($result);
    }
    
    /**
     * AJAX handler for confirming receipt
     */
    public static function ajax_confirm_receipt() {
        // Verify nonce and permissions
        if (!wp_verify_nonce($_POST['nonce'], 'loan_disbursement_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $loan_id = intval($_POST['loan_id']);
        $confirmation_data = array(
            'type' => sanitize_text_field($_POST['confirmation_type'] ?? 'digital_acknowledgment'),
            'details' => sanitize_textarea_field($_POST['confirmation_details'] ?? '')
        );
        
        $result = self::record_digital_confirmation($loan_id, $confirmation_data);
        
        wp_send_json(array(
            'success' => $result,
            'message' => $result ? 'Confirmation recorded successfully' : 'Failed to record confirmation'
        ));
    }
    
    /**
     * AJAX handler for checking M-Pesa status
     */
    public static function ajax_check_mpesa_status() {
        // Verify nonce and permissions
        if (!wp_verify_nonce($_POST['nonce'], 'loan_disbursement_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $transaction_id = sanitize_text_field($_POST['transaction_id']);
        
        // Check M-Pesa transaction status
        $status = self::check_mpesa_transaction_status($transaction_id);
        
        wp_send_json($status);
    }
    
    /**
     * Check M-Pesa transaction status
     */
    private static function check_mpesa_transaction_status($transaction_id) {
        // In a real implementation, this would query the M-Pesa API
        // For demonstration purposes, we'll return a mock status
        
        return array(
            'success' => true,
            'status' => 'completed',
            'transaction_id' => $transaction_id,
            'amount' => 0,
            'recipient' => '',
            'completion_time' => current_time('mysql')
        );
    }
}

// Initialize the disbursement handler
LoanDisbursementHandler::init();

/**
 * Helper function to get disbursement details
 */
function get_loan_disbursement_details($loan_id) {
    global $wpdb;
    
    $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $disbursements_table WHERE loan_id = %d ORDER BY created_at DESC LIMIT 1",
        $loan_id
    ));
}

/**
 * Helper function to check if loan is disbursed
 */
function is_loan_disbursed($loan_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $disbursed_date = $wpdb->get_var($wpdb->prepare(
        "SELECT disbursed_date FROM $loans_table WHERE id = %d",
        $loan_id
    ));
    
    return !empty($disbursed_date);
}

/**
 * Helper function to get disbursement methods
 */
function get_disbursement_methods() {
    return array(
        'mpesa' => 'M-Pesa',
        'bank_transfer' => 'Bank Transfer',
        'cash' => 'Cash Collection'
    );
}