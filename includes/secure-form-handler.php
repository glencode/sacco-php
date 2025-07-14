<?php
/**
 * Secure Form Handler
 * Implements comprehensive input validation, sanitization, and CSRF protection
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Secure Form Handler Class
 */
class Daystar_Secure_Form_Handler {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('wp_ajax_secure_loan_application', array($this, 'handle_loan_application'));
        add_action('wp_ajax_secure_member_update', array($this, 'handle_member_update'));
        add_action('wp_ajax_secure_payment_submission', array($this, 'handle_payment_submission'));
        add_action('wp_ajax_secure_loan_approval', array($this, 'handle_loan_approval'));
        add_action('wp_ajax_secure_loan_disbursement', array($this, 'handle_loan_disbursement'));
        
        // Non-privileged actions for member-facing forms
        add_action('wp_ajax_nopriv_secure_member_registration', array($this, 'handle_member_registration'));
    }
    
    /**
     * Handle secure loan application submission
     */
    public function handle_loan_application() {
        try {
            // Verify user is logged in and has permission
            if (!is_user_logged_in()) {
                throw new Exception('Authentication required');
            }
            
            // Check CSRF token
            if (!daystar_verify_csrf_from_request('loan_application')) {
                throw new Exception('Security verification failed');
            }
            
            // Check user capability
            if (!current_user_can('apply_for_loans')) {
                throw new Exception('Insufficient permissions');
            }
            
            // Validate and sanitize input
            $validation_result = $this->validate_loan_application_data($_POST);
            if (!$validation_result['valid']) {
                throw new Exception('Validation failed: ' . implode(', ', $validation_result['errors']));
            }
            
            $sanitized_data = $validation_result['data'];
            $user_id = get_current_user_id();
            
            // Additional business logic validation
            $eligibility_check = $this->check_loan_eligibility($user_id, $sanitized_data);
            if (!$eligibility_check['eligible']) {
                throw new Exception('Eligibility check failed: ' . $eligibility_check['reason']);
            }
            
            // Process the loan application
            $loan_id = $this->create_loan_application($user_id, $sanitized_data);
            
            // Log the action
            Daystar_Security_Access_Control::log_action(
                'loan_application_submitted',
                'loan',
                $loan_id,
                array(
                    'loan_type' => $sanitized_data['loan_type'],
                    'amount' => $sanitized_data['loan_amount'],
                    'term_months' => $sanitized_data['term_months']
                ),
                'info'
            );
            
            wp_send_json_success(array(
                'message' => 'Loan application submitted successfully',
                'loan_id' => $loan_id,
                'application_number' => 'LA' . str_pad($loan_id, 6, '0', STR_PAD_LEFT)
            ));
            
        } catch (Exception $e) {
            // Log the error
            Daystar_Security_Access_Control::log_action(
                'loan_application_error',
                'loan',
                null,
                array(
                    'error_message' => $e->getMessage(),
                    'form_data' => $this->sanitize_log_data($_POST)
                ),
                'error'
            );
            
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
    
    /**
     * Handle secure member profile update
     */
    public function handle_member_update() {
        try {
            // Verify user is logged in
            if (!is_user_logged_in()) {
                throw new Exception('Authentication required');
            }
            
            // Check CSRF token
            if (!daystar_verify_csrf_from_request('member_update')) {
                throw new Exception('Security verification failed');
            }
            
            // Check user capability
            if (!current_user_can('update_profile')) {
                throw new Exception('Insufficient permissions');
            }
            
            // Validate and sanitize input
            $validation_result = daystar_validate_member_data($_POST);
            if (!$validation_result['valid']) {
                throw new Exception('Validation failed: ' . implode(', ', $validation_result['errors']));
            }
            
            $sanitized_data = $validation_result['data'];
            $user_id = get_current_user_id();
            
            // Update member data
            $this->update_member_profile($user_id, $sanitized_data);
            
            // Log the action
            Daystar_Security_Access_Control::log_action(
                'member_profile_updated',
                'member',
                $user_id,
                array(
                    'updated_fields' => array_keys($sanitized_data)
                ),
                'info'
            );
            
            wp_send_json_success(array(
                'message' => 'Profile updated successfully'
            ));
            
        } catch (Exception $e) {
            // Log the error
            Daystar_Security_Access_Control::log_action(
                'member_update_error',
                'member',
                get_current_user_id(),
                array(
                    'error_message' => $e->getMessage()
                ),
                'error'
            );
            
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
    
    /**
     * Handle secure loan approval
     */
    public function handle_loan_approval() {
        try {
            // Check user capability
            daystar_require_capability('approve_loans');
            
            // Check CSRF token
            if (!daystar_verify_csrf_from_request('loan_approval')) {
                throw new Exception('Security verification failed');
            }
            
            // Validate input
            $loan_id = intval($_POST['loan_id'] ?? 0);
            $action = sanitize_text_field($_POST['approval_action'] ?? '');
            $notes = sanitize_textarea_field($_POST['approval_notes'] ?? '');
            
            if (!$loan_id || !in_array($action, ['approve', 'reject'])) {
                throw new Exception('Invalid input parameters');
            }
            
            // Process approval/rejection
            $result = $this->process_loan_approval($loan_id, $action, $notes);
            
            // Log the action
            Daystar_Security_Access_Control::log_action(
                'loan_' . $action . 'd',
                'loan',
                $loan_id,
                array(
                    'action' => $action,
                    'notes' => $notes,
                    'approved_by' => get_current_user_id()
                ),
                'info'
            );
            
            wp_send_json_success(array(
                'message' => 'Loan ' . $action . 'd successfully',
                'loan_id' => $loan_id
            ));
            
        } catch (Exception $e) {
            // Log the error
            Daystar_Security_Access_Control::log_action(
                'loan_approval_error',
                'loan',
                intval($_POST['loan_id'] ?? 0),
                array(
                    'error_message' => $e->getMessage(),
                    'attempted_action' => $_POST['approval_action'] ?? ''
                ),
                'error'
            );
            
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
    
    /**
     * Handle secure loan disbursement
     */
    public function handle_loan_disbursement() {
        try {
            // Check user capability
            daystar_require_capability('disburse_loans');
            
            // Check CSRF token
            if (!daystar_verify_csrf_from_request('loan_disbursement')) {
                throw new Exception('Security verification failed');
            }
            
            // Validate input
            $loan_id = intval($_POST['loan_id'] ?? 0);
            $disbursement_method = sanitize_text_field($_POST['disbursement_method'] ?? '');
            $disbursement_reference = sanitize_text_field($_POST['disbursement_reference'] ?? '');
            $notes = sanitize_textarea_field($_POST['disbursement_notes'] ?? '');
            
            if (!$loan_id || empty($disbursement_method) || empty($disbursement_reference)) {
                throw new Exception('Invalid input parameters');
            }
            
            // Process disbursement
            $result = $this->process_loan_disbursement($loan_id, $disbursement_method, $disbursement_reference, $notes);
            
            // Log the action
            Daystar_Security_Access_Control::log_action(
                'loan_disbursed',
                'loan',
                $loan_id,
                array(
                    'disbursement_method' => $disbursement_method,
                    'disbursement_reference' => $disbursement_reference,
                    'disbursed_by' => get_current_user_id()
                ),
                'info'
            );
            
            wp_send_json_success(array(
                'message' => 'Loan disbursed successfully',
                'loan_id' => $loan_id,
                'disbursement_reference' => $disbursement_reference
            ));
            
        } catch (Exception $e) {
            // Log the error
            Daystar_Security_Access_Control::log_action(
                'loan_disbursement_error',
                'loan',
                intval($_POST['loan_id'] ?? 0),
                array(
                    'error_message' => $e->getMessage()
                ),
                'error'
            );
            
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }
    
    /**
     * Validate loan application data
     */
    private function validate_loan_application_data($data) {
        $errors = array();
        $sanitized_data = array();
        
        // Validate loan amount
        if (empty($data['loan_amount']) || !is_numeric($data['loan_amount']) || $data['loan_amount'] <= 0) {
            $errors[] = 'Invalid loan amount';
        } else {
            $amount = floatval($data['loan_amount']);
            if ($amount < 1000 || $amount > 5000000) {
                $errors[] = 'Loan amount must be between KES 1,000 and KES 5,000,000';
            } else {
                $sanitized_data['loan_amount'] = $amount;
            }
        }
        
        // Validate loan type
        $valid_loan_types = array('Development Loan', 'School Fees Loan', 'Emergency Loan', 'Special Loan', 'Super Saver Loan', 'Salary Advance');
        if (empty($data['loan_type']) || !in_array($data['loan_type'], $valid_loan_types)) {
            $errors[] = 'Invalid loan type';
        } else {
            $sanitized_data['loan_type'] = sanitize_text_field($data['loan_type']);
        }
        
        // Validate term months
        if (empty($data['term_months']) || !is_numeric($data['term_months']) || $data['term_months'] <= 0) {
            $errors[] = 'Invalid loan term';
        } else {
            $term = intval($data['term_months']);
            if ($term < 1 || $term > 48) {
                $errors[] = 'Loan term must be between 1 and 48 months';
            } else {
                $sanitized_data['term_months'] = $term;
            }
        }
        
        // Validate purpose
        if (!empty($data['purpose'])) {
            $purpose = sanitize_textarea_field($data['purpose']);
            if (strlen($purpose) > 1000) {
                $errors[] = 'Purpose description too long (maximum 1000 characters)';
            } else {
                $sanitized_data['purpose'] = $purpose;
            }
        }
        
        // Validate guarantors if provided
        if (!empty($data['guarantors']) && is_array($data['guarantors'])) {
            $sanitized_guarantors = array();
            foreach ($data['guarantors'] as $guarantor) {
                if (!empty($guarantor['member_number'])) {
                    $member_number = sanitize_text_field($guarantor['member_number']);
                    $amount = floatval($guarantor['amount'] ?? 0);
                    
                    if ($amount > 0) {
                        $sanitized_guarantors[] = array(
                            'member_number' => $member_number,
                            'amount' => $amount
                        );
                    }
                }
            }
            $sanitized_data['guarantors'] = $sanitized_guarantors;
        }
        
        return array(
            'valid' => empty($errors),
            'errors' => $errors,
            'data' => $sanitized_data
        );
    }
    
    /**
     * Check loan eligibility
     */
    private function check_loan_eligibility($user_id, $loan_data) {
        global $wpdb;
        
        // Get user membership data
        $member_number = get_user_meta($user_id, 'member_number', true);
        if (empty($member_number)) {
            return array('eligible' => false, 'reason' => 'Invalid member');
        }
        
        // Check for existing active loans of the same type
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $existing_loans = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $loans_table WHERE user_id = %d AND loan_type = %s AND status IN ('active', 'pending', 'approved')",
            $user_id,
            $loan_data['loan_type']
        ));
        
        if ($existing_loans > 0) {
            return array('eligible' => false, 'reason' => 'Existing active loan of the same type');
        }
        
        // Check minimum membership period (6 months)
        $registration_date = get_user_meta($user_id, 'registration_date', true);
        if ($registration_date) {
            $months_since_registration = (time() - strtotime($registration_date)) / (30 * 24 * 60 * 60);
            if ($months_since_registration < 6) {
                return array('eligible' => false, 'reason' => 'Minimum membership period not met');
            }
        }
        
        // Check minimum share capital
        $contributions_table = $wpdb->prefix . 'daystar_contributions';
        $share_capital = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(amount) FROM $contributions_table WHERE user_id = %d AND is_share_capital = 1 AND status = 'completed'",
            $user_id
        ));
        
        if ($share_capital < 5000) {
            return array('eligible' => false, 'reason' => 'Minimum share capital requirement not met');
        }
        
        return array('eligible' => true, 'reason' => 'Eligible');
    }
    
    /**
     * Create loan application
     */
    private function create_loan_application($user_id, $data) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        
        // Calculate monthly payment (basic calculation)
        $monthly_payment = $this->calculate_monthly_payment(
            $data['loan_amount'],
            12.0, // Default interest rate
            $data['term_months']
        );
        
        $loan_data = array(
            'user_id' => $user_id,
            'loan_type' => $data['loan_type'],
            'amount' => $data['loan_amount'],
            'balance' => $data['loan_amount'],
            'interest_rate' => 12.00,
            'term_months' => $data['term_months'],
            'monthly_payment' => $monthly_payment,
            'status' => 'pending',
            'purpose' => $data['purpose'] ?? '',
            'loan_date' => current_time('mysql'),
            'due_date' => date('Y-m-d', strtotime('+' . $data['term_months'] . ' months')),
            'created_at' => current_time('mysql')
        );
        
        $result = $wpdb->insert($loans_table, $loan_data);
        
        if ($result === false) {
            throw new Exception('Failed to create loan application');
        }
        
        return $wpdb->insert_id;
    }
    
    /**
     * Calculate monthly payment
     */
    private function calculate_monthly_payment($principal, $annual_rate, $months) {
        $monthly_rate = $annual_rate / 100 / 12;
        if ($monthly_rate == 0) {
            return $principal / $months;
        }
        
        $payment = $principal * ($monthly_rate * pow(1 + $monthly_rate, $months)) / (pow(1 + $monthly_rate, $months) - 1);
        return round($payment, 2);
    }
    
    /**
     * Update member profile
     */
    private function update_member_profile($user_id, $data) {
        // Update user meta
        foreach ($data as $key => $value) {
            // Encrypt sensitive data
            if (in_array($key, array('national_id', 'phone'))) {
                $value = daystar_encrypt_data($value);
            }
            update_user_meta($user_id, $key, $value);
        }
    }
    
    /**
     * Process loan approval
     */
    private function process_loan_approval($loan_id, $action, $notes) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $approver_id = get_current_user_id();
        
        $update_data = array(
            'approved_by' => $approver_id,
            'approved_date' => current_time('mysql'),
            'application_notes' => $notes,
            'updated_at' => current_time('mysql')
        );
        
        if ($action === 'approve') {
            $update_data['status'] = 'approved';
        } else {
            $update_data['status'] = 'rejected';
            $update_data['rejection_reason'] = $notes;
        }
        
        $result = $wpdb->update(
            $loans_table,
            $update_data,
            array('id' => $loan_id),
            array('%d', '%s', '%s', '%s', '%s'),
            array('%d')
        );
        
        if ($result === false) {
            throw new Exception('Failed to update loan status');
        }
        
        return true;
    }
    
    /**
     * Process loan disbursement
     */
    private function process_loan_disbursement($loan_id, $method, $reference, $notes) {
        global $wpdb;
        
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
        
        // Update loan status
        $wpdb->update(
            $loans_table,
            array(
                'status' => 'active',
                'disbursed_date' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            array('id' => $loan_id),
            array('%s', '%s', '%s'),
            array('%d')
        );
        
        // Create disbursement record
        $wpdb->insert(
            $disbursements_table,
            array(
                'loan_id' => $loan_id,
                'disbursement_method' => $method,
                'disbursement_reference' => $reference,
                'status' => 'completed',
                'disbursed_by' => get_current_user_id(),
                'disbursed_date' => current_time('mysql'),
                'notes' => $notes,
                'created_at' => current_time('mysql')
            )
        );
        
        return true;
    }
    
    /**
     * Sanitize data for logging
     */
    private function sanitize_log_data($data) {
        $sanitized = array();
        $sensitive_fields = array('password', 'national_id', 'account_number');
        
        foreach ($data as $key => $value) {
            if (in_array($key, $sensitive_fields)) {
                $sanitized[$key] = '[REDACTED]';
            } else {
                $sanitized[$key] = is_string($value) ? substr($value, 0, 100) : $value;
            }
        }
        
        return $sanitized;
    }
}

// Initialize the secure form handler
function daystar_init_secure_form_handler() {
    return Daystar_Secure_Form_Handler::get_instance();
}

add_action('init', 'daystar_init_secure_form_handler');

/**
 * Helper function to output secure form with CSRF protection
 */
function daystar_secure_form_start($action, $method = 'POST', $attributes = array()) {
    $default_attributes = array(
        'class' => 'daystar-secure-form',
        'data-action' => $action
    );
    
    $attributes = array_merge($default_attributes, $attributes);
    $attr_string = '';
    
    foreach ($attributes as $key => $value) {
        $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    
    echo '<form method="' . esc_attr($method) . '"' . $attr_string . '>';
    daystar_csrf_field($action);
}

/**
 * Helper function to close secure form
 */
function daystar_secure_form_end() {
    echo '</form>';
}

/**
 * Secure file upload handler
 */
function daystar_handle_secure_file_upload($file, $allowed_types = array('pdf', 'jpg', 'jpeg', 'png'), $max_size = 5242880) {
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new Exception('Invalid file upload');
    }
    
    // Check for upload errors
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new Exception('No file uploaded');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new Exception('File too large');
        default:
            throw new Exception('Upload error');
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        throw new Exception('File size exceeds limit');
    }
    
    // Check file type
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($file_info, $file['tmp_name']);
    finfo_close($file_info);
    
    $allowed_mime_types = array(
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png'
    );
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $allowed_types) || 
        !isset($allowed_mime_types[$extension]) || 
        $mime_type !== $allowed_mime_types[$extension]) {
        throw new Exception('Invalid file type');
    }
    
    // Generate secure filename
    $upload_dir = wp_upload_dir();
    $secure_filename = wp_unique_filename($upload_dir['path'], sanitize_file_name($file['name']));
    $upload_path = $upload_dir['path'] . '/' . $secure_filename;
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        throw new Exception('Failed to save file');
    }
    
    // Log file upload
    Daystar_Security_Access_Control::log_action(
        'file_uploaded',
        'file',
        null,
        array(
            'filename' => $secure_filename,
            'original_name' => $file['name'],
            'size' => $file['size'],
            'type' => $mime_type
        ),
        'info'
    );
    
    return array(
        'filename' => $secure_filename,
        'path' => $upload_path,
        'url' => $upload_dir['url'] . '/' . $secure_filename
    );
}