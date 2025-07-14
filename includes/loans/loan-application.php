<?php
/**
 * Consolidated Loan Application System
 * Handles all loan application functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register AJAX handlers
add_action('wp_ajax_submit_loan_application', 'daystar_submit_loan_application');
add_action('wp_ajax_check_loan_eligibility', 'daystar_ajax_check_loan_eligibility');
add_action('wp_ajax_validate_guarantor', 'daystar_ajax_validate_guarantor');
add_action('wp_ajax_check_guarantor_capacity', 'daystar_ajax_check_guarantor_capacity');
add_action('wp_ajax_submit_comprehensive_loan_application', 'daystar_submit_comprehensive_loan_application');

/**
 * Handle basic loan application submission
 */
function daystar_submit_loan_application() {
    // Security checks
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to apply for a loan.');
        return;
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_loan_application_nonce')) {
        wp_send_json_error('Security check failed. Please refresh the page and try again.');
        return;
    }
    
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Check member status
    if (!in_array('member', $current_user->roles)) {
        wp_send_json_error('Only members can apply for loans.');
        return;
    }
    
    $member_status = get_user_meta($user_id, 'member_status', true);
    if ($member_status !== 'active') {
        wp_send_json_error('Your membership must be active to apply for a loan.');
        return;
    }
    
    // Collect and sanitize form data
    $loan_data = array(
        'loan_type' => sanitize_text_field($_POST['loan_type']),
        'loan_amount' => floatval($_POST['loan_amount']),
        'loan_term' => intval($_POST['loan_term']),
        'loan_purpose' => sanitize_textarea_field($_POST['loan_purpose']),
        'guarantor1_member_no' => sanitize_text_field($_POST['guarantor1_member_no']),
        'guarantor1_name' => sanitize_text_field($_POST['guarantor1_name']),
        'guarantor1_phone' => sanitize_text_field($_POST['guarantor1_phone']),
        'guarantor1_amount' => floatval($_POST['guarantor1_amount']),
        'guarantor2_member_no' => sanitize_text_field($_POST['guarantor2_member_no']),
        'guarantor2_name' => sanitize_text_field($_POST['guarantor2_name']),
        'guarantor2_phone' => sanitize_text_field($_POST['guarantor2_phone']),
        'guarantor2_amount' => floatval($_POST['guarantor2_amount']),
        'terms_agreement' => isset($_POST['terms_agreement'])
    );
    
    // Validate application data
    $validation_result = daystar_validate_basic_loan_application($loan_data, $user_id);
    if (!$validation_result['valid']) {
        wp_send_json_error(array('errors' => $validation_result['errors']));
        return;
    }
    
    // Generate waiting number
    $waiting_number = daystar_generate_waiting_number();
    
    // Save application
    $loan_id = daystar_save_basic_loan_application($user_id, $loan_data, $waiting_number);
    if (!$loan_id) {
        wp_send_json_error('Failed to save application. Please try again.');
        return;
    }
    
    // Send confirmations
    daystar_send_basic_application_confirmations($user_id, $loan_id, $waiting_number, $loan_data);
    
    wp_send_json_success(array(
        'message' => 'Your loan application has been submitted successfully.',
        'waiting_number' => $waiting_number,
        'loan_id' => $loan_id,
        'redirect_url' => home_url('/member-dashboard/?tab=loans&application=' . $waiting_number)
    ));
}

/**
 * Handle comprehensive loan application submission
 */
function daystar_submit_comprehensive_loan_application() {
    // Security checks
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to submit a loan application.');
        return;
    }
    
    if (!wp_verify_nonce($_POST['application_nonce'], 'comprehensive_loan_application')) {
        wp_send_json_error('Security check failed. Please refresh the page and try again.');
        return;
    }
    
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Check member status
    if (!in_array('member', $current_user->roles)) {
        wp_send_json_error('Only members can apply for loans.');
        return;
    }
    
    $member_status = get_user_meta($user_id, 'member_status', true);
    if ($member_status !== 'active') {
        wp_send_json_error('Your membership must be active to apply for a loan.');
        return;
    }
    
    // Collect and sanitize comprehensive form data
    $application_data = daystar_collect_comprehensive_application_data($_POST, $_FILES);
    
    // Validate comprehensive application data
    $validation_result = daystar_validate_comprehensive_application($application_data, $user_id);
    if (!$validation_result['valid']) {
        wp_send_json_error($validation_result['errors']);
        return;
    }
    
    // Check submission deadline for Development loans
    $deadline_check = daystar_check_submission_deadline($application_data['loan_type']);
    if (!$deadline_check['allowed']) {
        if (!$deadline_check['force_next_cycle']) {
            wp_send_json_error($deadline_check['message']);
            return;
        }
        // Mark for next cycle processing
        $application_data['processing_cycle'] = $deadline_check['next_cycle'];
        $application_data['deadline_note'] = $deadline_check['message'];
    }
    
    // Generate unique waiting number
    $waiting_number = daystar_generate_waiting_number();
    
    // Process file uploads
    $upload_results = daystar_process_application_uploads($_FILES, $waiting_number);
    if (!$upload_results['success']) {
        wp_send_json_error('File upload error: ' . $upload_results['error']);
        return;
    }
    
    // Save comprehensive application to database
    $loan_id = daystar_save_comprehensive_application($user_id, $application_data, $upload_results['files'], $waiting_number);
    if (!$loan_id) {
        wp_send_json_error('Failed to save application. Please try again.');
        return;
    }
    
    // Send confirmation notifications
    daystar_send_comprehensive_application_confirmations($user_id, $loan_id, $waiting_number, $application_data);
    
    // Record application event in credit history
    daystar_record_credit_event(
        $user_id, 
        $loan_id, 
        'comprehensive_application_submitted', 
        $application_data['loan_amount'], 
        'Comprehensive loan application submitted with waiting number: ' . $waiting_number,
        5 // Positive credit impact for application submission
    );
    
    wp_send_json_success(array(
        'message' => 'Your comprehensive loan application has been submitted successfully.',
        'waiting_number' => $waiting_number,
        'loan_id' => $loan_id,
        'processing_note' => $application_data['deadline_note'] ?? '',
        'redirect_url' => home_url('/member-dashboard/?tab=loans&application=' . $waiting_number)
    ));
}

/**
 * AJAX handler for loan eligibility check
 */
function daystar_ajax_check_loan_eligibility() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'loan_eligibility_check')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in');
        return;
    }
    
    $user_id = get_current_user_id();
    $loan_type = sanitize_text_field($_POST['loan_type']);
    $loan_amount = floatval($_POST['loan_amount']);
    
    // Perform eligibility check
    if (function_exists('daystar_comprehensive_loan_eligibility')) {
        $eligibility = daystar_comprehensive_loan_eligibility($user_id, $loan_type, $loan_amount);
    } else {
        // Fallback to basic eligibility
        $max_amount = daystar_calculate_loan_eligibility($user_id, $loan_type, $loan_amount);
        $eligibility = array(
            'is_eligible' => $loan_amount <= $max_amount,
            'max_loan_amount' => $max_amount,
            'eligibility_score' => $loan_amount <= $max_amount ? 75 : 45,
            'risk_assessment' => $loan_amount <= $max_amount ? 'medium' : 'high',
            'criteria_results' => array(),
            'recommendations' => array(),
            'warnings' => array()
        );
    }
    
    wp_send_json_success($eligibility);
}

/**
 * AJAX handler for guarantor validation
 */
function daystar_ajax_validate_guarantor() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'validate_guarantor')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in');
        return;
    }
    
    $member_number = sanitize_text_field($_POST['member_number']);
    $current_user_id = get_current_user_id();
    
    // Find user by member number
    $guarantor_user = daystar_get_user_by_member_number($member_number);
    
    if (!$guarantor_user) {
        wp_send_json_error('Member not found');
        return;
    }
    
    // Validate guarantor
    if (function_exists('daystar_validate_guarantor')) {
        $validation = daystar_validate_guarantor($guarantor_user->ID, $current_user_id, 0);
        
        if ($validation['valid']) {
            wp_send_json_success(array(
                'name' => $guarantor_user->display_name,
                'member_number' => $member_number,
                'user_id' => $guarantor_user->ID
            ));
        } else {
            wp_send_json_error(implode(', ', $validation['errors']));
        }
    } else {
        // Basic validation
        $member_status = get_user_meta($guarantor_user->ID, 'member_status', true);
        if ($member_status === 'active' && $guarantor_user->ID !== $current_user_id) {
            wp_send_json_success(array(
                'name' => $guarantor_user->display_name,
                'member_number' => $member_number,
                'user_id' => $guarantor_user->ID
            ));
        } else {
            wp_send_json_error('Invalid guarantor');
        }
    }
}

/**
 * AJAX handler for guarantor capacity check
 */
function daystar_ajax_check_guarantor_capacity() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'check_guarantor_capacity')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in');
        return;
    }
    
    $member_number = sanitize_text_field($_POST['member_number']);
    $amount = floatval($_POST['amount']);
    
    // Find user by member number
    $guarantor_user = daystar_get_user_by_member_number($member_number);
    
    if (!$guarantor_user) {
        wp_send_json_error('Member not found');
        return;
    }
    
    // Check guarantor capacity
    if (function_exists('daystar_get_guarantor_capacity')) {
        $capacity = daystar_get_guarantor_capacity($guarantor_user->ID);
        $can_guarantee = daystar_can_guarantee_amount($guarantor_user->ID, $amount);
        
        wp_send_json_success(array(
            'max_capacity' => $capacity['max_capacity'],
            'total_guaranteed' => $capacity['total_guaranteed'],
            'available_capacity' => $capacity['available_capacity'],
            'can_guarantee' => $can_guarantee
        ));
    } else {
        // Basic capacity check
        $share_capital = daystar_get_member_share_capital($guarantor_user->ID);
        $max_capacity = $share_capital * 3;
        
        wp_send_json_success(array(
            'max_capacity' => $max_capacity,
            'total_guaranteed' => 0,
            'available_capacity' => $max_capacity,
            'can_guarantee' => $amount <= $max_capacity
        ));
    }
}

/**
 * Validate basic loan application data
 */
function daystar_validate_basic_loan_application($data, $user_id) {
    $errors = array();
    
    // Basic field validation
    if (empty($data['loan_type'])) $errors[] = 'Loan type is required.';
    if ($data['loan_amount'] <= 0) $errors[] = 'Loan amount must be greater than zero.';
    if ($data['loan_term'] <= 0) $errors[] = 'Loan term is required.';
    if (empty($data['loan_purpose'])) $errors[] = 'Loan purpose is required.';
    if (empty($data['guarantor1_member_no'])) $errors[] = 'Guarantor 1 member number is required.';
    if (empty($data['guarantor2_member_no'])) $errors[] = 'Guarantor 2 member number is required.';
    if (!$data['terms_agreement']) $errors[] = 'You must agree to the terms and conditions.';
    
    // Loan type specific validation
    $loan_config = daystar_get_loan_type_config($data['loan_type']);
    if ($loan_config) {
        if ($data['loan_amount'] < $loan_config['min_amount']) {
            $errors[] = 'Minimum loan amount for this type is KES ' . number_format($loan_config['min_amount'], 2);
        }
        if ($data['loan_amount'] > $loan_config['max_amount']) {
            $errors[] = 'Maximum loan amount for this type is KES ' . number_format($loan_config['max_amount'], 2);
        }
        if (!in_array($data['loan_term'], $loan_config['terms'])) {
            $errors[] = 'Invalid loan term for this loan type.';
        }
    }
    
    // Basic eligibility check
    $max_loan_amount = daystar_calculate_loan_eligibility($user_id, $data['loan_type'], $data['loan_amount']);
    if ($data['loan_amount'] > $max_loan_amount) {
        $errors[] = 'The requested loan amount exceeds your eligibility. Maximum eligible amount is KES ' . number_format($max_loan_amount, 2) . '.';
    }
    
    // Check if guarantor amounts cover loan amount
    $total_guaranteed = $data['guarantor1_amount'] + $data['guarantor2_amount'];
    if ($total_guaranteed < $data['loan_amount']) {
        $errors[] = 'The total guaranteed amount must be at least equal to the loan amount.';
    }
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors
    );
}

/**
 * Save basic loan application
 */
function daystar_save_basic_loan_application($user_id, $data, $waiting_number) {
    global $wpdb;
    
    // Check if this is a staff loan
    $staff_loan_info = daystar_check_staff_loan_eligibility($user_id);
    
    // Calculate loan details
    $loan_config = daystar_get_loan_type_config($data['loan_type']);
    $interest_rate = $loan_config['interest_rate'] ?? 12;
    
    // Apply extended repayment period for staff loans if needed
    $final_term = $data['loan_term'];
    if ($staff_loan_info['is_staff'] && $staff_loan_info['extended_term_eligible']) {
        $final_term = min($data['loan_term'], 48); // Maximum 48 months for staff
    }
    
    $monthly_payment = daystar_calculate_monthly_payment($data['loan_amount'], $interest_rate, $final_term);
    $processing_fee = $data['loan_amount'] * ($loan_config['processing_fee'] ?? 0.02);
    
    // Insert loan application
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan_insert_data = array(
        'user_id' => $user_id,
        'loan_type' => $data['loan_type'],
        'amount' => $data['loan_amount'],
        'balance' => $data['loan_amount'],
        'interest_rate' => $interest_rate,
        'term_months' => $final_term,
        'monthly_payment' => $monthly_payment,
        'purpose' => $data['loan_purpose'],
        'status' => 'pending',
        'application_waiting_number' => $waiting_number,
        'processing_fee' => $processing_fee,
        'is_staff_loan' => $staff_loan_info['is_staff'] ? 1 : 0,
        'staff_type' => $staff_loan_info['staff_type'],
        'application_notes' => 'Basic loan application submitted' . ($staff_loan_info['is_staff'] ? ' (Staff Loan)' : '')
    );
    
    $loan_result = $wpdb->insert($loans_table, $loan_insert_data);
    
    if ($loan_result === false) {
        return false;
    }
    
    $loan_id = $wpdb->insert_id;
    
    // Save guarantor information (basic)
    $guarantor1_user = daystar_get_user_by_member_number($data['guarantor1_member_no']);
    $guarantor2_user = daystar_get_user_by_member_number($data['guarantor2_member_no']);
    
    if ($guarantor1_user && function_exists('daystar_save_guarantor')) {
        daystar_save_guarantor($loan_id, $guarantor1_user->ID, $data['guarantor1_amount'], 'shares');
    }
    
    if ($guarantor2_user && function_exists('daystar_save_guarantor')) {
        daystar_save_guarantor($loan_id, $guarantor2_user->ID, $data['guarantor2_amount'], 'shares');
    }
    
    return $loan_id;
}

/**
 * Send basic application confirmations
 */
function daystar_send_basic_application_confirmations($user_id, $loan_id, $waiting_number, $data) {
    $user = get_user_by('ID', $user_id);
    
    // Send email confirmation to applicant
    $subject = 'Loan Application Confirmation - ' . $waiting_number;
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Thank you for submitting your loan application.\n\n";
    $message .= "APPLICATION DETAILS:\n";
    $message .= "Waiting Number: {$waiting_number}\n";
    $message .= "Loan Type: " . ucfirst(str_replace('_', ' ', $data['loan_type'])) . "\n";
    $message .= "Amount: KES " . number_format($data['loan_amount'], 2) . "\n";
    $message .= "Term: {$data['loan_term']} months\n";
    $message .= "Submission Date: " . date('F j, Y g:i A') . "\n\n";
    $message .= "Your application will be reviewed within 7-14 working days.\n\n";
    $message .= "Thank you for choosing Daystar Multi-Purpose Co-op Society.\n\n";
    $message .= "Best regards,\nDaystar SACCO Credit Department";
    
    wp_mail($user->user_email, $subject, $message);
    
    // Send notification to admin
    $admin_email = get_option('admin_email');
    $admin_subject = 'New Loan Application - ' . $waiting_number;
    $admin_message = "A new loan application has been submitted:\n\n";
    $admin_message .= "Applicant: {$user->display_name} ({$user->user_email})\n";
    $admin_message .= "Waiting Number: {$waiting_number}\n";
    $admin_message .= "Loan Type: " . ucfirst(str_replace('_', ' ', $data['loan_type'])) . "\n";
    $admin_message .= "Amount: KES " . number_format($data['loan_amount'], 2) . "\n\n";
    $admin_message .= "Please login to the admin dashboard to review this application.";
    
    wp_mail($admin_email, $admin_subject, $admin_message);
    
    // Create in-app notification
    if (function_exists('daystar_create_notification')) {
        daystar_create_notification(
            $user_id,
            'Loan Application Submitted',
            "Your loan application ({$waiting_number}) has been submitted successfully. Processing time: 7-14 working days.",
            'loan'
        );
    }
}

/**
 * Collect comprehensive application data
 */
function daystar_collect_comprehensive_application_data($post_data, $files_data) {
    return array(
        // Loan details
        'loan_type' => sanitize_text_field($post_data['loan_type']),
        'loan_amount' => floatval($post_data['loan_amount']),
        'loan_term' => intval($post_data['loan_term']),
        'loan_purpose' => sanitize_textarea_field($post_data['loan_purpose']),
        'repayment_method' => sanitize_text_field($post_data['repayment_method'] ?? 'salary_deduction'),
        
        // Economic information
        'employment_status' => sanitize_text_field($post_data['employment_status']),
        'employer_name' => sanitize_text_field($post_data['employer_name'] ?? ''),
        'monthly_income' => floatval($post_data['monthly_income']),
        'other_income' => floatval($post_data['other_income'] ?? 0),
        'monthly_expenses' => floatval($post_data['monthly_expenses']),
        'existing_loans' => floatval($post_data['existing_loans'] ?? 0),
        'productive_activity' => sanitize_textarea_field($post_data['productive_activity']),
        
        // Security information
        'security_type' => sanitize_text_field($post_data['security_type']),
        'land_location' => sanitize_text_field($post_data['land_location'] ?? ''),
        'land_value' => floatval($post_data['land_value'] ?? 0),
        'title_deed_number' => sanitize_text_field($post_data['title_deed_number'] ?? ''),
        'vehicle_make' => sanitize_text_field($post_data['vehicle_make'] ?? ''),
        'vehicle_year' => intval($post_data['vehicle_year'] ?? 0),
        'vehicle_registration' => sanitize_text_field($post_data['vehicle_registration'] ?? ''),
        'vehicle_value' => floatval($post_data['vehicle_value'] ?? 0),
        
        // Guarantors
        'guarantor1_member_no' => sanitize_text_field($post_data['guarantor1_member_no']),
        'guarantor1_amount' => floatval($post_data['guarantor1_amount']),
        'guarantor1_relationship' => sanitize_text_field($post_data['guarantor1_relationship'] ?? ''),
        'guarantor2_member_no' => sanitize_text_field($post_data['guarantor2_member_no']),
        'guarantor2_amount' => floatval($post_data['guarantor2_amount']),
        'guarantor2_relationship' => sanitize_text_field($post_data['guarantor2_relationship'] ?? ''),
        
        // Agreements
        'terms_agreement' => isset($post_data['terms_agreement']),
        'information_accuracy' => isset($post_data['information_accuracy']),
        'processing_consent' => isset($post_data['processing_consent'])
    );
}

/**
 * Validate comprehensive application data
 */
function daystar_validate_comprehensive_application($data, $user_id) {
    $errors = array();
    
    // Basic field validation
    if (empty($data['loan_type'])) $errors[] = 'Loan type is required.';
    if ($data['loan_amount'] <= 0) $errors[] = 'Loan amount must be greater than zero.';
    if ($data['loan_term'] <= 0) $errors[] = 'Loan term is required.';
    if (empty($data['loan_purpose'])) $errors[] = 'Loan purpose is required.';
    if (empty($data['employment_status'])) $errors[] = 'Employment status is required.';
    if ($data['monthly_income'] <= 0) $errors[] = 'Monthly income is required.';
    if ($data['monthly_expenses'] <= 0) $errors[] = 'Monthly expenses are required.';
    if (empty($data['productive_activity'])) $errors[] = 'Productive activity description is required.';
    if (empty($data['security_type'])) $errors[] = 'Security type is required.';
    if (empty($data['guarantor1_member_no'])) $errors[] = 'Guarantor 1 member number is required.';
    if (empty($data['guarantor2_member_no'])) $errors[] = 'Guarantor 2 member number is required.';
    
    // Agreement validation
    if (!$data['terms_agreement']) $errors[] = 'You must agree to the terms and conditions.';
    if (!$data['information_accuracy']) $errors[] = 'You must certify the accuracy of information.';
    if (!$data['processing_consent']) $errors[] = 'You must consent to data processing.';
    
    // Loan type specific validation
    $loan_config = daystar_get_loan_type_config($data['loan_type']);
    if ($loan_config) {
        if ($data['loan_amount'] < $loan_config['min_amount']) {
            $errors[] = 'Minimum loan amount for this type is KES ' . number_format($loan_config['min_amount'], 2);
        }
        if ($data['loan_amount'] > $loan_config['max_amount']) {
            $errors[] = 'Maximum loan amount for this type is KES ' . number_format($loan_config['max_amount'], 2);
        }
        if (!in_array($data['loan_term'], $loan_config['terms'])) {
            $errors[] = 'Invalid loan term for this loan type.';
        }
    }
    
    // Comprehensive eligibility check if available
    if (function_exists('daystar_comprehensive_loan_eligibility')) {
        $eligibility = daystar_comprehensive_loan_eligibility($user_id, $data['loan_type'], $data['loan_amount']);
        if (!$eligibility['is_eligible']) {
            $errors[] = 'You do not meet the eligibility requirements for this loan.';
            $errors = array_merge($errors, $eligibility['recommendations']);
        }
    }
    
    // Debt service ratio validation
    $monthly_payment = daystar_calculate_monthly_payment(
        $data['loan_amount'], 
        $loan_config['interest_rate'] ?? 12, 
        $data['loan_term']
    );
    $total_debt_service = $data['existing_loans'] + $monthly_payment;
    $debt_service_ratio = ($total_debt_service / $data['monthly_income']) * 100;
    
    if ($debt_service_ratio > 40) {
        $errors[] = 'Debt service ratio (' . number_format($debt_service_ratio, 1) . '%) exceeds the maximum allowed (40%).';
    }
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors
    );
}

/**
 * Process application file uploads
 */
function daystar_process_application_uploads($files, $waiting_number) {
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    
    $uploaded_files = array();
    $upload_errors = array();
    
    // Define upload directory
    $upload_dir = wp_upload_dir();
    $loan_upload_dir = $upload_dir['basedir'] . '/loan-applications/' . $waiting_number;
    
    if (!file_exists($loan_upload_dir)) {
        wp_mkdir_p($loan_upload_dir);
    }
    
    // Process each file type
    $file_types = array(
        'payslip_document' => 'Payslip',
        'bank_statement' => 'Bank Statement',
        'id_document' => 'ID Document',
        'title_deed_document' => 'Title Deed',
        'logbook_document' => 'Vehicle Logbook',
        'valuation_report' => 'Valuation Report',
        'vehicle_valuation' => 'Vehicle Valuation'
    );
    
    foreach ($file_types as $field_name => $file_description) {
        if (isset($files[$field_name]) && $files[$field_name]['error'] === UPLOAD_ERR_OK) {
            $upload_result = daystar_handle_secure_upload($files[$field_name], $loan_upload_dir, $file_description);
            
            if ($upload_result['success']) {
                $uploaded_files[$field_name] = $upload_result['file_path'];
            } else {
                $upload_errors[] = $file_description . ': ' . $upload_result['error'];
            }
        }
    }
    
    if (!empty($upload_errors)) {
        return array(
            'success' => false,
            'error' => implode(', ', $upload_errors)
        );
    }
    
    return array(
        'success' => true,
        'files' => $uploaded_files
    );
}

/**
 * Handle secure file upload
 */
function daystar_handle_secure_upload($file, $upload_dir, $description) {
    // Validate file type
    $allowed_types = array('pdf', 'jpg', 'jpeg', 'png');
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_types)) {
        return array(
            'success' => false,
            'error' => 'Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.'
        );
    }
    
    // Validate file size (max 10MB)
    $max_size = 10 * 1024 * 1024; // 10MB
    if ($file['size'] > $max_size) {
        return array(
            'success' => false,
            'error' => 'File size exceeds maximum allowed size of 10MB.'
        );
    }
    
    // Generate secure filename
    $secure_filename = uniqid() . '_' . sanitize_file_name($file['name']);
    $file_path = $upload_dir . '/' . $secure_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return array(
            'success' => true,
            'file_path' => $file_path,
            'filename' => $secure_filename
        );
    } else {
        return array(
            'success' => false,
            'error' => 'Failed to save uploaded file.'
        );
    }
}

/**
 * Save comprehensive application to database
 */
function daystar_save_comprehensive_application($user_id, $data, $files, $waiting_number) {
    global $wpdb;
    
    // Start transaction
    $wpdb->query('START TRANSACTION');
    
    try {
        // Check if this is a staff loan
        $staff_loan_info = daystar_check_staff_loan_eligibility($user_id);
        
        // Calculate loan details
        $loan_config = daystar_get_loan_type_config($data['loan_type']);
        $interest_rate = $loan_config['interest_rate'] ?? 12;
        
        // Apply extended repayment period for staff loans if needed
        $final_term = $data['loan_term'];
        if ($staff_loan_info['is_staff'] && $staff_loan_info['extended_term_eligible']) {
            $final_term = min($data['loan_term'], 48); // Maximum 48 months for staff
        }
        
        $monthly_payment = daystar_calculate_monthly_payment($data['loan_amount'], $interest_rate, $final_term);
        $processing_fee = $data['loan_amount'] * ($loan_config['processing_fee'] ?? 0.02);
        
        // Get eligibility assessment if available
        $eligibility_score = 75;
        $risk_assessment = 'medium';
        
        if (function_exists('daystar_comprehensive_loan_eligibility')) {
            $eligibility = daystar_comprehensive_loan_eligibility($user_id, $data['loan_type'], $data['loan_amount']);
            $eligibility_score = $eligibility['eligibility_score'];
            $risk_assessment = $eligibility['risk_assessment'];
        }
        
        // Insert loan application
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $loan_insert_data = array(
            'user_id' => $user_id,
            'loan_type' => $data['loan_type'],
            'amount' => $data['loan_amount'],
            'balance' => $data['loan_amount'],
            'interest_rate' => $interest_rate,
            'term_months' => $final_term,
            'monthly_payment' => $monthly_payment,
            'purpose' => $data['loan_purpose'],
            'status' => 'pending',
            'eligibility_score' => $eligibility_score,
            'risk_assessment' => $risk_assessment,
            'is_staff_loan' => $staff_loan_info['is_staff'] ? 1 : 0,
            'staff_type' => $staff_loan_info['staff_type'],
            'application_notes' => 'Comprehensive application submitted' . ($staff_loan_info['is_staff'] ? ' (Staff Loan)' : ''),
            'application_waiting_number' => $waiting_number,
            'processing_fee' => $processing_fee,
            'repayment_method' => $data['repayment_method'],
            'employment_status' => $data['employment_status'],
            'employer_name' => $data['employer_name'],
            'monthly_income' => $data['monthly_income'],
            'monthly_expenses' => $data['monthly_expenses'],
            'productive_activity' => $data['productive_activity'],
            'processing_cycle' => $data['processing_cycle'] ?? date('F Y'),
            'deadline_note' => $data['deadline_note'] ?? ''
        );
        
        $loan_result = $wpdb->insert($loans_table, $loan_insert_data);
        if ($loan_result === false) {
            throw new Exception('Failed to insert loan application');
        }
        
        $loan_id = $wpdb->insert_id;
        
        // Save guarantor information
        $guarantor1_user = daystar_get_user_by_member_number($data['guarantor1_member_no']);
        $guarantor2_user = daystar_get_user_by_member_number($data['guarantor2_member_no']);
        
        if ($guarantor1_user && function_exists('daystar_save_guarantor')) {
            daystar_save_guarantor($loan_id, $guarantor1_user->ID, $data['guarantor1_amount'], 'shares');
        }
        
        if ($guarantor2_user && function_exists('daystar_save_guarantor')) {
            daystar_save_guarantor($loan_id, $guarantor2_user->ID, $data['guarantor2_amount'], 'shares');
        }
        
        // Save collateral/security information if applicable
        if ($data['security_type'] !== 'guarantors_only' && function_exists('daystar_save_collateral')) {
            $collateral_data = array(
                'type' => $data['security_type'],
                'value' => $data['land_value'] ?: $data['vehicle_value'] ?: 0,
                'description' => daystar_build_security_description($data),
                'document_path' => implode(',', array_filter($files))
            );
            
            daystar_save_collateral($loan_id, $user_id, $collateral_data);
        }
        
        // Save application documents if function exists
        if (function_exists('daystar_save_application_documents')) {
            daystar_save_application_documents($loan_id, $files);
        }
        
        // Commit transaction
        $wpdb->query('COMMIT');
        
        return $loan_id;
        
    } catch (Exception $e) {
        // Rollback transaction
        $wpdb->query('ROLLBACK');
        error_log('Loan application save error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Build security description from form data
 */
function daystar_build_security_description($data) {
    $description = '';
    
    switch ($data['security_type']) {
        case 'land_title':
            $description = "Land Title - Location: {$data['land_location']}, Title Deed: {$data['title_deed_number']}, Value: KES " . number_format($data['land_value'], 2);
            break;
        case 'vehicle':
            $description = "Vehicle - Make/Model: {$data['vehicle_make']}, Year: {$data['vehicle_year']}, Registration: {$data['vehicle_registration']}, Value: KES " . number_format($data['vehicle_value'], 2);
            break;
        case 'salary':
            $description = "Salary Assignment - Employer: {$data['employer_name']}, Monthly Income: KES " . number_format($data['monthly_income'], 2);
            break;
        default:
            $description = ucfirst(str_replace('_', ' ', $data['security_type']));
            break;
    }
    
    return $description;
}

/**
 * Send comprehensive application confirmations
 */
function daystar_send_comprehensive_application_confirmations($user_id, $loan_id, $waiting_number, $data) {
    $user = get_user_by('ID', $user_id);
    
    // Send email confirmation to applicant
    $subject = 'Comprehensive Loan Application Confirmation - ' . $waiting_number;
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Thank you for submitting your comprehensive loan application.\n\n";
    $message .= "APPLICATION DETAILS:\n";
    $message .= "Waiting Number: {$waiting_number}\n";
    $message .= "Loan Type: " . ucfirst(str_replace('_', ' ', $data['loan_type'])) . "\n";
    $message .= "Amount: KES " . number_format($data['loan_amount'], 2) . "\n";
    $message .= "Term: {$data['loan_term']} months\n";
    $message .= "Submission Date: " . date('F j, Y g:i A') . "\n\n";
    
    if (!empty($data['deadline_note'])) {
        $message .= "PROCESSING NOTE:\n";
        $message .= $data['deadline_note'] . "\n\n";
    }
    
    $message .= "WHAT HAPPENS NEXT:\n";
    $message .= "1. Your application will be reviewed by our credit committee\n";
    $message .= "2. We may contact you for additional information if needed\n";
    $message .= "3. You will be notified of the decision within 7-14 working days\n";
    $message .= "4. If approved, loan disbursement will be processed to your registered account\n\n";
    
    $message .= "You can track your application status by logging into your member dashboard.\n\n";
    $message .= "Thank you for choosing Daystar Multi-Purpose Co-op Society.\n\n";
    $message .= "Best regards,\n";
    $message .= "Daystar SACCO Credit Department";
    
    wp_mail($user->user_email, $subject, $message);
    
    // Send notification to admin
    $admin_email = get_option('admin_email');
    $admin_subject = 'New Comprehensive Loan Application - ' . $waiting_number;
    $admin_message = "A new comprehensive loan application has been submitted:\n\n";
    $admin_message .= "APPLICANT INFORMATION:\n";
    $admin_message .= "Name: {$user->display_name}\n";
    $admin_message .= "Email: {$user->user_email}\n";
    $admin_message .= "Member Number: " . get_user_meta($user->ID, 'member_number', true) . "\n\n";
    $admin_message .= "APPLICATION DETAILS:\n";
    $admin_message .= "Waiting Number: {$waiting_number}\n";
    $admin_message .= "Loan Type: " . ucfirst(str_replace('_', ' ', $data['loan_type'])) . "\n";
    $admin_message .= "Amount: KES " . number_format($data['loan_amount'], 2) . "\n";
    $admin_message .= "Term: {$data['loan_term']} months\n";
    $admin_message .= "Purpose: {$data['loan_purpose']}\n";
    $admin_message .= "Monthly Income: KES " . number_format($data['monthly_income'], 2) . "\n";
    $admin_message .= "Security Type: " . ucfirst(str_replace('_', ' ', $data['security_type'])) . "\n\n";
    $admin_message .= "Please login to the admin dashboard to review this application.\n";
    $admin_message .= "Dashboard URL: " . admin_url('admin.php?page=daystar-comprehensive-loans');
    
    wp_mail($admin_email, $admin_subject, $admin_message);
    
    // Create in-app notification
    if (function_exists('daystar_create_notification')) {
        daystar_create_notification(
            $user_id,
            'Comprehensive Loan Application Submitted',
            "Your comprehensive loan application ({$waiting_number}) has been submitted successfully. Processing time: 7-14 working days.",
            'loan'
        );
    }
}

/**
 * Check if user is eligible for staff loan benefits
 */
function daystar_check_staff_loan_eligibility($user_id) {
    // Check if user is staff member
    $is_staff = get_user_meta($user_id, 'is_staff', true);
    $staff_type = get_user_meta($user_id, 'staff_type', true);
    $user_roles = get_user_meta($user_id, 'wp_capabilities', true);
    
    // If not explicitly marked as staff, check user roles for staff indicators
    if (!$is_staff) {
        // Check if user has staff-related roles or meta
        $staff_indicators = array('staff', 'employee', 'faculty', 'administrator', 'office_bearer');
        
        if (is_array($user_roles)) {
            foreach ($staff_indicators as $indicator) {
                if (array_key_exists($indicator, $user_roles)) {
                    $is_staff = true;
                    $staff_type = $staff_type ?: $indicator;
                    break;
                }
            }
        }
        
        // Check employment status from user meta
        $employment_status = get_user_meta($user_id, 'employment_status', true);
        if (in_array($employment_status, array('permanent', 'part_time_teaching', 'contract'))) {
            $is_staff = true;
            $staff_type = $staff_type ?: $employment_status;
        }
    }
    
    // Determine if eligible for extended terms
    $extended_term_eligible = false;
    if ($is_staff) {
        // Staff members are eligible for extended repayment periods on a need basis
        $extended_term_eligible = true;
    }
    
    return array(
        'is_staff' => (bool)$is_staff,
        'staff_type' => $staff_type ?: 'general_member',
        'extended_term_eligible' => $extended_term_eligible,
        'max_term_months' => $is_staff ? 48 : 36
    );
}

/**
 * Enhanced guarantor validation with officer cross-guarantee warning
 */
function daystar_validate_guarantor_with_officer_check($guarantor_user_id, $applicant_user_id, $amount) {
    $validation_result = array(
        'valid' => true,
        'errors' => array(),
        'warnings' => array()
    );
    
    // Basic guarantor validation
    if (function_exists('daystar_validate_guarantor')) {
        $basic_validation = daystar_validate_guarantor($guarantor_user_id, $applicant_user_id, $amount);
        if (!$basic_validation['valid']) {
            return $basic_validation;
        }
    }
    
    // Check for officer cross-guaranteeing
    $applicant_staff_info = daystar_check_staff_loan_eligibility($applicant_user_id);
    $guarantor_staff_info = daystar_check_staff_loan_eligibility($guarantor_user_id);
    
    // Check if both are officers/staff members
    if ($applicant_staff_info['is_staff'] && $guarantor_staff_info['is_staff']) {
        // Check if they are both office bearers or in sensitive positions
        $applicant_roles = get_user_meta($applicant_user_id, 'sacco_roles', true);
        $guarantor_roles = get_user_meta($guarantor_user_id, 'sacco_roles', true);
        
        $sensitive_roles = array('chairman', 'vice_chairman', 'secretary', 'treasurer', 'committee_member', 'office_bearer');
        
        $applicant_is_officer = false;
        $guarantor_is_officer = false;
        
        if (is_array($applicant_roles)) {
            foreach ($sensitive_roles as $role) {
                if (in_array($role, $applicant_roles)) {
                    $applicant_is_officer = true;
                    break;
                }
            }
        }
        
        if (is_array($guarantor_roles)) {
            foreach ($sensitive_roles as $role) {
                if (in_array($role, $guarantor_roles)) {
                    $guarantor_is_officer = true;
                    break;
                }
            }
        }
        
        // If both are officers, add warning
        if ($applicant_is_officer && $guarantor_is_officer) {
            $validation_result['warnings'][] = 'OFFICER CROSS-GUARANTEE WARNING: Both applicant and guarantor are office bearers. This requires special committee attention as per PRD Section 6.';
        } elseif ($applicant_staff_info['staff_type'] === 'office_bearer' || $guarantor_staff_info['staff_type'] === 'office_bearer') {
            $validation_result['warnings'][] = 'STAFF GUARANTEE NOTICE: This involves office bearers/staff members. Committee should review for potential conflicts of interest.';
        }
    }
    
    return $validation_result;
}

/**
 * Get staff loan approval workflow notes
 */
function daystar_get_staff_loan_approval_notes($loan_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan || !$loan->is_staff_loan) {
        return '';
    }
    
    $notes = array();
    $notes[] = '📋 STAFF LOAN - SPECIAL CONSIDERATIONS:';
    $notes[] = '• This application is from a staff member/office bearer';
    $notes[] = '• Extended repayment period (up to 48 months) may be considered on need basis';
    $notes[] = '• Application can be approved in CMC meeting in absence of applicant';
    
    // Check for officer guarantees
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    $guarantors = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$guarantors_table} WHERE loan_id = %d",
        $loan_id
    ));
    
    foreach ($guarantors as $guarantor) {
        $guarantor_staff_info = daystar_check_staff_loan_eligibility($guarantor->guaranteed_by_user_id);
        if ($guarantor_staff_info['is_staff']) {
            $guarantor_user = get_user_by('ID', $guarantor->guaranteed_by_user_id);
            $notes[] = '⚠️ WARNING: Guarantor ' . $guarantor_user->display_name . ' is also a staff member/officer';
        }
    }
    
    $notes[] = '• Review for compliance with PRD Section 6 requirements';
    
    return implode("\n", $notes);
}