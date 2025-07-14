<?php
/**
 * SMS/Email Gateway Integration
 * 
 * Generic notification system with support for multiple SMS and email providers
 * Provides automated, event-driven notifications for various SACCO activities
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Notification Gateway Manager
 */
class DaystarNotificationGateway {
    
    private $sms_providers = array();
    private $email_providers = array();
    private $default_sms_provider = 'twilio';
    private $default_email_provider = 'sendgrid';
    
    public function __construct() {
        $this->init_providers();
        $this->init_hooks();
        $this->setup_database();
    }
    
    /**
     * Initialize notification providers
     */
    private function init_providers() {
        // SMS Providers
        $this->sms_providers = array(
            'twilio' => new DaystarTwilioSMS(),
            'africastalking' => new DaystarAfricasTalkingSMS(),
            'infobip' => new DaystarInfobipSMS()
        );
        
        // Email Providers
        $this->email_providers = array(
            'sendgrid' => new DaystarSendGridEmail(),
            'mailgun' => new DaystarMailgunEmail(),
            'ses' => new DaystarSESEmail()
        );
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        // Event-driven notifications
        add_action('daystar_loan_application_submitted', array($this, 'notify_loan_application_submitted'));
        add_action('daystar_loan_approved', array($this, 'notify_loan_approved'));
        add_action('daystar_loan_declined', array($this, 'notify_loan_declined'));
        add_action('daystar_loan_disbursed', array($this, 'notify_loan_disbursed'));
        add_action('daystar_repayment_received', array($this, 'notify_repayment_received'));
        add_action('daystar_repayment_overdue', array($this, 'notify_repayment_overdue'));
        add_action('daystar_contribution_received', array($this, 'notify_contribution_received'));
        add_action('daystar_member_registered', array($this, 'notify_member_registered'));
        add_action('daystar_policy_updated', array($this, 'notify_policy_updated'));
        add_action('daystar_anomaly_detected', array($this, 'notify_anomaly_detected'));
        
        // Scheduled notifications
        add_action('daystar_send_repayment_reminders', array($this, 'send_repayment_reminders'));
        add_action('daystar_send_contribution_reminders', array($this, 'send_contribution_reminders'));
        
        // Schedule recurring notifications
        if (!wp_next_scheduled('daystar_send_repayment_reminders')) {
            wp_schedule_event(time(), 'daily', 'daystar_send_repayment_reminders');
        }
        
        if (!wp_next_scheduled('daystar_send_contribution_reminders')) {
            wp_schedule_event(time(), 'weekly', 'daystar_send_contribution_reminders');
        }
        
        // AJAX handlers
        add_action('wp_ajax_send_bulk_notification', array($this, 'handle_bulk_notification'));
        add_action('wp_ajax_test_notification_provider', array($this, 'test_notification_provider'));
    }
    
    /**
     * Setup database tables
     */
    private function setup_database() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_notifications';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            recipient_id bigint(20) NOT NULL,
            recipient_type varchar(20) DEFAULT 'member',
            notification_type varchar(50) NOT NULL,
            channel varchar(20) NOT NULL,
            provider varchar(50),
            subject varchar(255),
            message text NOT NULL,
            recipient_contact varchar(100),
            status varchar(20) DEFAULT 'pending',
            provider_response text,
            provider_message_id varchar(100),
            sent_at datetime,
            delivered_at datetime,
            failed_at datetime,
            retry_count int DEFAULT 0,
            max_retries int DEFAULT 3,
            priority varchar(10) DEFAULT 'normal',
            scheduled_for datetime,
            event_type varchar(50),
            event_data longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_recipient_id (recipient_id),
            KEY idx_status (status),
            KEY idx_channel (channel),
            KEY idx_scheduled_for (scheduled_for),
            KEY idx_created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Generic notification function
     */
    public function send_notification($recipient_id, $message, $channel = 'sms', $subject = null, $options = array()) {
        // Validate inputs
        if (!$recipient_id || !$message || !in_array($channel, array('sms', 'email', 'both'))) {
            return array('success' => false, 'message' => 'Invalid parameters');
        }
        
        $results = array();
        
        if ($channel === 'both') {
            $results['sms'] = $this->send_sms($recipient_id, $message, $options);
            $results['email'] = $this->send_email($recipient_id, $message, $subject, $options);
        } elseif ($channel === 'sms') {
            $results['sms'] = $this->send_sms($recipient_id, $message, $options);
        } elseif ($channel === 'email') {
            $results['email'] = $this->send_email($recipient_id, $message, $subject, $options);
        }
        
        return $results;
    }
    
    /**
     * Send SMS notification
     */
    public function send_sms($recipient_id, $message, $options = array()) {
        $recipient = $this->get_recipient_info($recipient_id);
        if (!$recipient || !$recipient['phone']) {
            return array('success' => false, 'message' => 'Invalid recipient or missing phone number');
        }
        
        $provider_name = $options['provider'] ?? $this->default_sms_provider;
        $provider = $this->sms_providers[$provider_name] ?? null;
        
        if (!$provider) {
            return array('success' => false, 'message' => 'SMS provider not available');
        }
        
        // Save notification record
        $notification_id = $this->save_notification(array(
            'recipient_id' => $recipient_id,
            'notification_type' => $options['type'] ?? 'general',
            'channel' => 'sms',
            'provider' => $provider_name,
            'message' => $message,
            'recipient_contact' => $recipient['phone'],
            'priority' => $options['priority'] ?? 'normal',
            'scheduled_for' => $options['scheduled_for'] ?? null,
            'event_type' => $options['event_type'] ?? null,
            'event_data' => isset($options['event_data']) ? json_encode($options['event_data']) : null
        ));
        
        // Send immediately if not scheduled
        if (empty($options['scheduled_for'])) {
            return $this->process_sms_notification($notification_id, $provider, $recipient['phone'], $message, $options);
        }
        
        return array('success' => true, 'message' => 'SMS scheduled successfully', 'notification_id' => $notification_id);
    }
    
    /**
     * Send email notification
     */
    public function send_email($recipient_id, $message, $subject = null, $options = array()) {
        $recipient = $this->get_recipient_info($recipient_id);
        if (!$recipient || !$recipient['email']) {
            return array('success' => false, 'message' => 'Invalid recipient or missing email address');
        }
        
        $provider_name = $options['provider'] ?? $this->default_email_provider;
        $provider = $this->email_providers[$provider_name] ?? null;
        
        if (!$provider) {
            return array('success' => false, 'message' => 'Email provider not available');
        }
        
        $subject = $subject ?: 'Notification from Daystar SACCO';
        
        // Save notification record
        $notification_id = $this->save_notification(array(
            'recipient_id' => $recipient_id,
            'notification_type' => $options['type'] ?? 'general',
            'channel' => 'email',
            'provider' => $provider_name,
            'subject' => $subject,
            'message' => $message,
            'recipient_contact' => $recipient['email'],
            'priority' => $options['priority'] ?? 'normal',
            'scheduled_for' => $options['scheduled_for'] ?? null,
            'event_type' => $options['event_type'] ?? null,
            'event_data' => isset($options['event_data']) ? json_encode($options['event_data']) : null
        ));
        
        // Send immediately if not scheduled
        if (empty($options['scheduled_for'])) {
            return $this->process_email_notification($notification_id, $provider, $recipient['email'], $message, $subject, $options);
        }
        
        return array('success' => true, 'message' => 'Email scheduled successfully', 'notification_id' => $notification_id);
    }
    
    /**
     * Process SMS notification
     */
    private function process_sms_notification($notification_id, $provider, $phone, $message, $options = array()) {
        try {
            $result = $provider->send($phone, $message, $options);
            
            $update_data = array(
                'status' => $result['success'] ? 'sent' : 'failed',
                'provider_response' => json_encode($result),
                'provider_message_id' => $result['message_id'] ?? null,
                'sent_at' => $result['success'] ? current_time('mysql') : null,
                'failed_at' => !$result['success'] ? current_time('mysql') : null
            );
            
            $this->update_notification($notification_id, $update_data);
            
            return $result;
            
        } catch (Exception $e) {
            $this->update_notification($notification_id, array(
                'status' => 'failed',
                'provider_response' => json_encode(array('error' => $e->getMessage())),
                'failed_at' => current_time('mysql')
            ));
            
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
    
    /**
     * Process email notification
     */
    private function process_email_notification($notification_id, $provider, $email, $message, $subject, $options = array()) {
        try {
            $result = $provider->send($email, $message, $subject, $options);
            
            $update_data = array(
                'status' => $result['success'] ? 'sent' : 'failed',
                'provider_response' => json_encode($result),
                'provider_message_id' => $result['message_id'] ?? null,
                'sent_at' => $result['success'] ? current_time('mysql') : null,
                'failed_at' => !$result['success'] ? current_time('mysql') : null
            );
            
            $this->update_notification($notification_id, $update_data);
            
            return $result;
            
        } catch (Exception $e) {
            $this->update_notification($notification_id, array(
                'status' => 'failed',
                'provider_response' => json_encode(array('error' => $e->getMessage())),
                'failed_at' => current_time('mysql')
            ));
            
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
    
    /**
     * Get recipient information
     */
    private function get_recipient_info($recipient_id) {
        $user = get_user_by('id', $recipient_id);
        if (!$user) {
            return null;
        }
        
        return array(
            'id' => $user->ID,
            'name' => $user->display_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->user_email,
            'phone' => get_user_meta($user->ID, 'phone', true)
        );
    }
    
    /**
     * Save notification record
     */
    private function save_notification($data) {
        global $wpdb;
        
        $wpdb->insert(
            $wpdb->prefix . 'daystar_notifications',
            $data
        );
        
        return $wpdb->insert_id;
    }
    
    /**
     * Update notification record
     */
    private function update_notification($notification_id, $data) {
        global $wpdb;
        
        $wpdb->update(
            $wpdb->prefix . 'daystar_notifications',
            $data,
            array('id' => $notification_id)
        );
    }
    
    /**
     * Event-driven notification handlers
     */
    public function notify_loan_application_submitted($loan_id) {
        global $wpdb;
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ));
        
        if (!$loan) return;
        
        $message = sprintf(
            "Dear %s, your loan application for KES %s has been received and is under review. Reference: %s",
            get_user_meta($loan->member_id, 'first_name', true),
            number_format($loan->amount, 2),
            'LOAN' . str_pad($loan_id, 6, '0', STR_PAD_LEFT)
        );
        
        $this->send_notification($loan->member_id, $message, 'both', 'Loan Application Received', array(
            'type' => 'loan_application',
            'event_type' => 'loan.application.submitted',
            'event_data' => array('loan_id' => $loan_id)
        ));
    }
    
    public function notify_loan_approved($loan_id) {
        global $wpdb;
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ));
        
        if (!$loan) return;
        
        $message = sprintf(
            "Congratulations! Your loan application for KES %s has been approved. Disbursement will be processed within 24 hours.",
            number_format($loan->amount, 2)
        );
        
        $this->send_notification($loan->member_id, $message, 'both', 'Loan Approved', array(
            'type' => 'loan_approval',
            'event_type' => 'loan.approved',
            'event_data' => array('loan_id' => $loan_id),
            'priority' => 'high'
        ));
    }
    
    public function notify_loan_declined($loan_id, $reason = '') {
        global $wpdb;
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ));
        
        if (!$loan) return;
        
        $message = sprintf(
            "We regret to inform you that your loan application for KES %s has been declined. %s For more information, please contact us.",
            number_format($loan->amount, 2),
            $reason ? "Reason: $reason. " : ""
        );
        
        $this->send_notification($loan->member_id, $message, 'both', 'Loan Application Update', array(
            'type' => 'loan_decline',
            'event_type' => 'loan.declined',
            'event_data' => array('loan_id' => $loan_id, 'reason' => $reason)
        ));
    }
    
    public function notify_loan_disbursed($loan_id) {
        global $wpdb;
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ));
        
        if (!$loan) return;
        
        $message = sprintf(
            "Your loan of KES %s has been disbursed successfully. First repayment is due on %s. Thank you for choosing Daystar SACCO.",
            number_format($loan->amount, 2),
            date('M j, Y', strtotime($loan->due_date))
        );
        
        $this->send_notification($loan->member_id, $message, 'both', 'Loan Disbursed', array(
            'type' => 'loan_disbursement',
            'event_type' => 'loan.disbursed',
            'event_data' => array('loan_id' => $loan_id),
            'priority' => 'high'
        ));
    }
    
    public function notify_repayment_received($repayment_id) {
        global $wpdb;
        
        $repayment = $wpdb->get_row($wpdb->prepare(
            "SELECT r.*, l.amount as loan_amount, l.paid_amount 
             FROM {$wpdb->prefix}daystar_loan_repayments r
             JOIN {$wpdb->prefix}daystar_loans l ON r.loan_id = l.id
             WHERE r.id = %d",
            $repayment_id
        ));
        
        if (!$repayment) return;
        
        $balance = $repayment->loan_amount - $repayment->paid_amount;
        
        $message = sprintf(
            "Payment of KES %s received. Outstanding balance: KES %s. Thank you for your payment!",
            number_format($repayment->amount, 2),
            number_format($balance, 2)
        );
        
        $this->send_notification($repayment->member_id, $message, 'sms', null, array(
            'type' => 'repayment_confirmation',
            'event_type' => 'repayment.received',
            'event_data' => array('repayment_id' => $repayment_id)
        ));
    }
    
    public function notify_repayment_overdue($loan_id) {
        global $wpdb;
        
        $loan = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans WHERE id = %d",
            $loan_id
        ));
        
        if (!$loan) return;
        
        $days_overdue = floor((time() - strtotime($loan->due_date)) / (24 * 60 * 60));
        $balance = $loan->amount - $loan->paid_amount;
        
        $message = sprintf(
            "REMINDER: Your loan payment of KES %s is %d days overdue. Outstanding balance: KES %s. Please make payment to avoid penalties.",
            number_format($loan->monthly_payment, 2),
            $days_overdue,
            number_format($balance, 2)
        );
        
        $this->send_notification($loan->member_id, $message, 'both', 'Overdue Payment Reminder', array(
            'type' => 'overdue_reminder',
            'event_type' => 'repayment.overdue',
            'event_data' => array('loan_id' => $loan_id, 'days_overdue' => $days_overdue),
            'priority' => 'high'
        ));
    }
    
    public function notify_contribution_received($contribution_id) {
        global $wpdb;
        
        $contribution = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_contributions WHERE id = %d",
            $contribution_id
        ));
        
        if (!$contribution) return;
        
        $total_contributions = get_user_meta($contribution->member_id, 'total_contributions', true) ?: 0;
        
        $message = sprintf(
            "Contribution of KES %s received. Total contributions: KES %s. Thank you for your commitment!",
            number_format($contribution->amount, 2),
            number_format($total_contributions, 2)
        );
        
        $this->send_notification($contribution->member_id, $message, 'sms', null, array(
            'type' => 'contribution_confirmation',
            'event_type' => 'contribution.received',
            'event_data' => array('contribution_id' => $contribution_id)
        ));
    }
    
    public function notify_member_registered($user_id) {
        $user = get_user_by('id', $user_id);
        if (!$user || !in_array('member', $user->roles)) return;
        
        $member_number = get_user_meta($user_id, 'member_number', true);
        
        $message = sprintf(
            "Welcome to Daystar SACCO, %s! Your member number is %s. Complete your registration by paying the registration fee.",
            $user->first_name,
            $member_number
        );
        
        $this->send_notification($user_id, $message, 'both', 'Welcome to Daystar SACCO', array(
            'type' => 'welcome',
            'event_type' => 'member.registered',
            'event_data' => array('member_number' => $member_number)
        ));
    }
    
    public function notify_policy_updated($policy_type, $policy_title) {
        // Get all active members
        $members = get_users(array(
            'role' => 'member',
            'meta_query' => array(
                array(
                    'key' => 'member_status',
                    'value' => 'active',
                    'compare' => '='
                )
            )
        ));
        
        $message = sprintf(
            "NOTICE: %s has been updated. Please review the changes on our website or visit our office for details.",
            $policy_title
        );
        
        foreach ($members as $member) {
            $this->send_notification($member->ID, $message, 'both', 'Policy Update Notice', array(
                'type' => 'policy_update',
                'event_type' => 'policy.updated',
                'event_data' => array('policy_type' => $policy_type, 'policy_title' => $policy_title)
            ));
        }
    }
    
    public function notify_anomaly_detected($anomaly_type, $details) {
        // Get admin users
        $admins = get_users(array('role' => 'administrator'));
        
        $message = sprintf(
            "ALERT: %s detected. Details: %s. Please review immediately.",
            ucfirst(str_replace('_', ' ', $anomaly_type)),
            $details
        );
        
        foreach ($admins as $admin) {
            $this->send_notification($admin->ID, $message, 'email', 'Security Alert - Anomaly Detected', array(
                'type' => 'security_alert',
                'event_type' => 'anomaly.detected',
                'event_data' => array('anomaly_type' => $anomaly_type, 'details' => $details),
                'priority' => 'urgent'
            ));
        }
    }
    
    /**
     * Send repayment reminders
     */
    public function send_repayment_reminders() {
        global $wpdb;
        
        // Get loans with upcoming due dates (next 3 days)
        $upcoming_loans = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}daystar_loans 
             WHERE status IN ('active', 'disbursed') 
             AND due_date BETWEEN %s AND %s",
            date('Y-m-d'),
            date('Y-m-d', strtotime('+3 days'))
        ));
        
        foreach ($upcoming_loans as $loan) {
            $days_until_due = floor((strtotime($loan->due_date) - time()) / (24 * 60 * 60));
            $balance = $loan->amount - $loan->paid_amount;
            
            $message = sprintf(
                "REMINDER: Your loan payment of KES %s is due in %d days (%s). Outstanding balance: KES %s.",
                number_format($loan->monthly_payment, 2),
                $days_until_due,
                date('M j, Y', strtotime($loan->due_date)),
                number_format($balance, 2)
            );
            
            $this->send_notification($loan->member_id, $message, 'sms', null, array(
                'type' => 'payment_reminder',
                'event_type' => 'repayment.reminder',
                'event_data' => array('loan_id' => $loan->id, 'days_until_due' => $days_until_due)
            ));
        }
    }
    
    /**
     * Send contribution reminders
     */
    public function send_contribution_reminders() {
        // Get members who haven't contributed this month
        $members = get_users(array(
            'role' => 'member',
            'meta_query' => array(
                array(
                    'key' => 'member_status',
                    'value' => 'active',
                    'compare' => '='
                )
            )
        ));
        
        $current_month = date('Y-m');
        
        foreach ($members as $member) {
            // Check if member has contributed this month
            global $wpdb;
            $contribution_this_month = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}daystar_contributions 
                 WHERE member_id = %d AND DATE_FORMAT(contribution_date, '%%Y-%%m') = %s",
                $member->ID,
                $current_month
            ));
            
            if ($contribution_this_month == 0) {
                $message = sprintf(
                    "Hello %s, this is a friendly reminder to make your monthly contribution. Thank you for your continued support!",
                    $member->first_name
                );
                
                $this->send_notification($member->ID, $message, 'sms', null, array(
                    'type' => 'contribution_reminder',
                    'event_type' => 'contribution.reminder',
                    'event_data' => array('month' => $current_month)
                ));
            }
        }
    }
    
    /**
     * Handle bulk notification AJAX request
     */
    public function handle_bulk_notification() {
        check_ajax_referer('daystar_notification_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $recipients = $_POST['recipients'] ?? array();
        $message = sanitize_textarea_field($_POST['message']);
        $channel = sanitize_text_field($_POST['channel']);
        $subject = sanitize_text_field($_POST['subject']);
        
        $results = array();
        $success_count = 0;
        $error_count = 0;
        
        foreach ($recipients as $recipient_id) {
            $result = $this->send_notification($recipient_id, $message, $channel, $subject, array(
                'type' => 'bulk_notification'
            ));
            
            if ($result['success'] ?? false) {
                $success_count++;
            } else {
                $error_count++;
            }
            
            $results[] = array(
                'recipient_id' => $recipient_id,
                'result' => $result
            );
        }
        
        wp_send_json_success(array(
            'message' => sprintf('Sent %d notifications successfully, %d failed', $success_count, $error_count),
            'results' => $results
        ));
    }
    
    /**
     * Test notification provider
     */
    public function test_notification_provider() {
        check_ajax_referer('daystar_notification_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        $provider_type = sanitize_text_field($_POST['provider_type']);
        $provider_name = sanitize_text_field($_POST['provider_name']);
        $test_contact = sanitize_text_field($_POST['test_contact']);
        
        if ($provider_type === 'sms') {
            $provider = $this->sms_providers[$provider_name] ?? null;
            if ($provider) {
                $result = $provider->send($test_contact, 'Test message from Daystar SACCO notification system.');
                wp_send_json_success($result);
            }
        } elseif ($provider_type === 'email') {
            $provider = $this->email_providers[$provider_name] ?? null;
            if ($provider) {
                $result = $provider->send($test_contact, 'This is a test email from Daystar SACCO notification system.', 'Test Email');
                wp_send_json_success($result);
            }
        }
        
        wp_send_json_error('Provider not found');
    }
}

/**
 * SMS Provider Interfaces
 */
interface SMSProviderInterface {
    public function send($phone, $message, $options = array());
    public function get_delivery_status($message_id);
}

/**
 * Email Provider Interface
 */
interface EmailProviderInterface {
    public function send($email, $message, $subject, $options = array());
    public function get_delivery_status($message_id);
}

/**
 * Twilio SMS Provider
 */
class DaystarTwilioSMS implements SMSProviderInterface {
    
    private $account_sid;
    private $auth_token;
    private $from_number;
    
    public function __construct() {
        $config = get_option('daystar_twilio_config', array());
        $this->account_sid = $config['account_sid'] ?? '';
        $this->auth_token = $config['auth_token'] ?? '';
        $this->from_number = $config['from_number'] ?? '';
    }
    
    public function send($phone, $message, $options = array()) {
        if (!$this->account_sid || !$this->auth_token || !$this->from_number) {
            return array('success' => false, 'message' => 'Twilio not configured');
        }
        
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->account_sid}/Messages.json";
        
        $data = array(
            'From' => $this->from_number,
            'To' => $phone,
            'Body' => $message
        );
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($this->account_sid . ':' . $this->auth_token),
                'Content-Type' => 'application/x-www-form-urlencoded'
            ),
            'body' => http_build_query($data),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (isset($result['sid'])) {
            return array(
                'success' => true,
                'message_id' => $result['sid'],
                'message' => 'SMS sent successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $result['message'] ?? 'Failed to send SMS'
            );
        }
    }
    
    public function get_delivery_status($message_id) {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->account_sid}/Messages/{$message_id}.json";
        
        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($this->account_sid . ':' . $this->auth_token)
            ),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        return array(
            'success' => true,
            'status' => $result['status'] ?? 'unknown',
            'error_code' => $result['error_code'] ?? null,
            'error_message' => $result['error_message'] ?? null
        );
    }
}

/**
 * Africa's Talking SMS Provider
 */
class DaystarAfricasTalkingSMS implements SMSProviderInterface {
    
    private $username;
    private $api_key;
    private $from;
    
    public function __construct() {
        $config = get_option('daystar_africastalking_config', array());
        $this->username = $config['username'] ?? '';
        $this->api_key = $config['api_key'] ?? '';
        $this->from = $config['from'] ?? '';
    }
    
    public function send($phone, $message, $options = array()) {
        if (!$this->username || !$this->api_key) {
            return array('success' => false, 'message' => 'Africa\'s Talking not configured');
        }
        
        $url = 'https://api.africastalking.com/version1/messaging';
        
        $data = array(
            'username' => $this->username,
            'to' => $phone,
            'message' => $message
        );
        
        if ($this->from) {
            $data['from'] = $this->from;
        }
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'apiKey' => $this->api_key,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ),
            'body' => http_build_query($data),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (isset($result['SMSMessageData']['Recipients'][0]['status']) && 
            $result['SMSMessageData']['Recipients'][0]['status'] === 'Success') {
            return array(
                'success' => true,
                'message_id' => $result['SMSMessageData']['Recipients'][0]['messageId'],
                'message' => 'SMS sent successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $result['SMSMessageData']['Message'] ?? 'Failed to send SMS'
            );
        }
    }
    
    public function get_delivery_status($message_id) {
        // Africa's Talking doesn't provide a direct delivery status API
        // This would need to be implemented via webhooks
        return array('success' => true, 'status' => 'unknown');
    }
}

/**
 * Infobip SMS Provider
 */
class DaystarInfobipSMS implements SMSProviderInterface {
    
    private $api_key;
    private $base_url;
    private $from;
    
    public function __construct() {
        $config = get_option('daystar_infobip_config', array());
        $this->api_key = $config['api_key'] ?? '';
        $this->base_url = $config['base_url'] ?? 'https://api.infobip.com';
        $this->from = $config['from'] ?? '';
    }
    
    public function send($phone, $message, $options = array()) {
        if (!$this->api_key) {
            return array('success' => false, 'message' => 'Infobip not configured');
        }
        
        $url = $this->base_url . '/sms/2/text/advanced';
        
        $data = array(
            'messages' => array(
                array(
                    'from' => $this->from,
                    'destinations' => array(
                        array('to' => $phone)
                    ),
                    'text' => $message
                )
            )
        );
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'App ' . $this->api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (isset($result['messages'][0]['status']['groupId']) && 
            $result['messages'][0]['status']['groupId'] == 1) {
            return array(
                'success' => true,
                'message_id' => $result['messages'][0]['messageId'],
                'message' => 'SMS sent successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $result['messages'][0]['status']['description'] ?? 'Failed to send SMS'
            );
        }
    }
    
    public function get_delivery_status($message_id) {
        $url = $this->base_url . '/sms/1/reports';
        
        $response = wp_remote_get($url . '?messageId=' . $message_id, array(
            'headers' => array(
                'Authorization' => 'App ' . $this->api_key
            ),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        return array(
            'success' => true,
            'status' => $result['results'][0]['status']['name'] ?? 'unknown'
        );
    }
}

/**
 * SendGrid Email Provider
 */
class DaystarSendGridEmail implements EmailProviderInterface {
    
    private $api_key;
    private $from_email;
    private $from_name;
    
    public function __construct() {
        $config = get_option('daystar_sendgrid_config', array());
        $this->api_key = $config['api_key'] ?? '';
        $this->from_email = $config['from_email'] ?? '';
        $this->from_name = $config['from_name'] ?? 'Daystar SACCO';
    }
    
    public function send($email, $message, $subject, $options = array()) {
        if (!$this->api_key || !$this->from_email) {
            return array('success' => false, 'message' => 'SendGrid not configured');
        }
        
        $url = 'https://api.sendgrid.com/v3/mail/send';
        
        $data = array(
            'personalizations' => array(
                array(
                    'to' => array(
                        array('email' => $email)
                    ),
                    'subject' => $subject
                )
            ),
            'from' => array(
                'email' => $this->from_email,
                'name' => $this->from_name
            ),
            'content' => array(
                array(
                    'type' => 'text/html',
                    'value' => $this->format_email_content($message, $options)
                )
            )
        );
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        
        if ($response_code == 202) {
            $headers = wp_remote_retrieve_headers($response);
            return array(
                'success' => true,
                'message_id' => $headers['X-Message-Id'] ?? null,
                'message' => 'Email sent successfully'
            );
        } else {
            $body = wp_remote_retrieve_body($response);
            $result = json_decode($body, true);
            return array(
                'success' => false,
                'message' => $result['errors'][0]['message'] ?? 'Failed to send email'
            );
        }
    }
    
    public function get_delivery_status($message_id) {
        // SendGrid provides webhook-based delivery status
        // This would need to be implemented via webhooks
        return array('success' => true, 'status' => 'unknown');
    }
    
    private function format_email_content($message, $options = array()) {
        $template = $options['template'] ?? 'default';
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Daystar SACCO</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="' . get_template_directory_uri() . '/assets/images/logo.png" alt="Daystar SACCO" style="max-width: 200px;">
                </div>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 5px;">
                    ' . nl2br(esc_html($message)) . '
                </div>
                <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
                    <p>Daystar Multi-Purpose Co-operative Society Ltd.<br>
                    Email: info@daystar.co.ke | Phone: +254 700 000 000</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}

/**
 * Mailgun Email Provider
 */
class DaystarMailgunEmail implements EmailProviderInterface {
    
    private $api_key;
    private $domain;
    private $from_email;
    private $from_name;
    
    public function __construct() {
        $config = get_option('daystar_mailgun_config', array());
        $this->api_key = $config['api_key'] ?? '';
        $this->domain = $config['domain'] ?? '';
        $this->from_email = $config['from_email'] ?? '';
        $this->from_name = $config['from_name'] ?? 'Daystar SACCO';
    }
    
    public function send($email, $message, $subject, $options = array()) {
        if (!$this->api_key || !$this->domain || !$this->from_email) {
            return array('success' => false, 'message' => 'Mailgun not configured');
        }
        
        $url = "https://api.mailgun.net/v3/{$this->domain}/messages";
        
        $data = array(
            'from' => $this->from_name . ' <' . $this->from_email . '>',
            'to' => $email,
            'subject' => $subject,
            'html' => $this->format_email_content($message, $options)
        );
        
        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('api:' . $this->api_key)
            ),
            'body' => $data,
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (isset($result['id'])) {
            return array(
                'success' => true,
                'message_id' => $result['id'],
                'message' => 'Email sent successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $result['message'] ?? 'Failed to send email'
            );
        }
    }
    
    public function get_delivery_status($message_id) {
        $url = "https://api.mailgun.net/v3/{$this->domain}/events";
        
        $response = wp_remote_get($url . '?message-id=' . $message_id, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('api:' . $this->api_key)
            ),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        return array(
            'success' => true,
            'status' => $result['items'][0]['event'] ?? 'unknown'
        );
    }
    
    private function format_email_content($message, $options = array()) {
        // Similar to SendGrid formatting
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Daystar SACCO</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="' . get_template_directory_uri() . '/assets/images/logo.png" alt="Daystar SACCO" style="max-width: 200px;">
                </div>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 5px;">
                    ' . nl2br(esc_html($message)) . '
                </div>
                <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
                    <p>Daystar Multi-Purpose Co-operative Society Ltd.<br>
                    Email: info@daystar.co.ke | Phone: +254 700 000 000</p>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}

/**
 * Amazon SES Email Provider
 */
class DaystarSESEmail implements EmailProviderInterface {
    
    private $access_key;
    private $secret_key;
    private $region;
    private $from_email;
    private $from_name;
    
    public function __construct() {
        $config = get_option('daystar_ses_config', array());
        $this->access_key = $config['access_key'] ?? '';
        $this->secret_key = $config['secret_key'] ?? '';
        $this->region = $config['region'] ?? 'us-east-1';
        $this->from_email = $config['from_email'] ?? '';
        $this->from_name = $config['from_name'] ?? 'Daystar SACCO';
    }
    
    public function send($email, $message, $subject, $options = array()) {
        if (!$this->access_key || !$this->secret_key || !$this->from_email) {
            return array('success' => false, 'message' => 'Amazon SES not configured');
        }
        
        // This is a simplified implementation
        // In production, you would use the AWS SDK for PHP
        return array('success' => false, 'message' => 'Amazon SES implementation requires AWS SDK');
    }
    
    public function get_delivery_status($message_id) {
        return array('success' => true, 'status' => 'unknown');
    }
}

// Initialize the notification gateway
new DaystarNotificationGateway();

/**
 * Global notification function for easy access
 */
function daystar_send_notification($recipient_id, $message, $channel = 'sms', $subject = null, $options = array()) {
    global $daystar_notification_gateway;
    
    if (!$daystar_notification_gateway) {
        $daystar_notification_gateway = new DaystarNotificationGateway();
    }
    
    return $daystar_notification_gateway->send_notification($recipient_id, $message, $channel, $subject, $options);
}