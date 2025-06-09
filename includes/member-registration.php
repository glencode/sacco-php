<?php
/**
 * Daystar Member Registration Functions
 *
 * Handles the registration process for new members
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the action to handle member registration form submission
 */
function daystar_register_member_actions() {
    add_action('wp_ajax_daystar_register_member', 'daystar_process_registration');
    add_action('wp_ajax_nopriv_daystar_register_member', 'daystar_process_registration');
}
add_action('init', 'daystar_register_member_actions');

/**
 * Process the member registration form
 */
function daystar_process_registration() {
    try {
        // Verify nonce
        check_ajax_referer('daystar_register_member_nonce', 'security');
        
        if (empty($_POST)) {
            throw new Exception('No data received');
        }
    
        // Collect and sanitize form data
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $id_number = isset($_POST['id_number']) ? sanitize_text_field($_POST['id_number']) : '';
        $date_of_birth = isset($_POST['date_of_birth']) ? sanitize_text_field($_POST['date_of_birth']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $marital_status = isset($_POST['marital_status']) ? sanitize_text_field($_POST['marital_status']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $alt_phone = isset($_POST['alt_phone']) ? sanitize_text_field($_POST['alt_phone']) : '';
        $physical_address = isset($_POST['physical_address']) ? sanitize_textarea_field($_POST['physical_address']) : '';
        $postal_code = isset($_POST['postal_code']) ? sanitize_text_field($_POST['postal_code']) : '';
        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
        $employment_status = isset($_POST['employment_status']) ? sanitize_text_field($_POST['employment_status']) : '';
        $employer = isset($_POST['employer']) ? sanitize_text_field($_POST['employer']) : '';
        $job_title = isset($_POST['job_title']) ? sanitize_text_field($_POST['job_title']) : '';
        $monthly_income = isset($_POST['monthly_income']) ? floatval($_POST['monthly_income']) : 0;
        $kra_pin = isset($_POST['kra_pin']) ? sanitize_text_field($_POST['kra_pin']) : '';
        
        // Bank details
        $bank_name = isset($_POST['bank_name']) ? sanitize_text_field($_POST['bank_name']) : '';
        $bank_branch = isset($_POST['bank_branch']) ? sanitize_text_field($_POST['bank_branch']) : '';
        $account_number = isset($_POST['account_number']) ? sanitize_text_field($_POST['account_number']) : '';
        
        $initial_contribution = isset($_POST['initial_contribution']) ? floatval($_POST['initial_contribution']) : 0;
        $monthly_contribution = isset($_POST['monthly_contribution']) ? floatval($_POST['monthly_contribution']) : 0;
        
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $terms_agreement = isset($_POST['terms_agreement']) ? true : false;
        
        // Enhanced validation
        $errors = array();
        
        // Required fields validation
        $required_fields = array(
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'id_number' => 'ID Number',
            'kra_pin' => 'KRA PIN',
            'date_of_birth' => 'Date of Birth',
            'physical_address' => 'Physical Address',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'employment_status' => 'Employment Status',
            'monthly_income' => 'Monthly Income',
            'bank_name' => 'Bank Name',
            'bank_branch' => 'Bank Branch',
            'account_number' => 'Account Number'
        );
        
        foreach ($required_fields as $field => $label) {
            if (empty($$field)) {
                $errors[] = $label . ' is required.';
            }
        }
        
        // Email validation
        if (!is_email($email)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (email_exists($email)) {
            $errors[] = 'This email address is already registered.';
        }
        
        // Phone number validation (Kenyan format)
        if (!preg_match('/^(?:\+254|0)[17]\d{8}$/', $phone)) {
            $errors[] = 'Please enter a valid Kenyan phone number.';
        }
        
        // ID Number validation
        if (!preg_match('/^\d{8}$/', $id_number)) {
            $errors[] = 'Please enter a valid 8-digit ID number.';
        }
        
        // KRA PIN validation
        if (!preg_match('/^[A-Z]\d{9}[A-Z]$/', $kra_pin)) {
            $errors[] = 'Please enter a valid KRA PIN (Format: A123456789B).';
        }
        
        // Age validation (must be at least 18)
        $dob = new DateTime($date_of_birth);
        $today = new DateTime();
        $age = $today->diff($dob)->y;
        if ($age < 18) {
            $errors[] = 'You must be at least 18 years old to register.';
        }
        
        // Password validation
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }
        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match.';
        }
        
        // Contribution validation
        if ($initial_contribution < 12000) {
            $errors[] = 'Initial contribution must be at least KSh 12,000.';
        }
        if ($monthly_contribution < 2000) {
            $errors[] = 'Monthly contribution must be at least KSh 2,000.';
        }
        
        // Terms agreement validation
        if (!$terms_agreement) {
            $errors[] = 'You must agree to the Terms and Conditions.';
        }
        
        if (!empty($errors)) {
            wp_send_json_error(array(
                'message' => implode('<br>', $errors)
            ));
            wp_die();
        }
        
        // Generate username from email
        $username = sanitize_user(current(explode('@', $email)), true);
        $username = daystar_ensure_unique_username($username);
        
        // Create the user
        $user_data = array(
            'user_login' => $username,
            'user_pass' => $password,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
            'role' => 'pending_member'
        );
        
        $user_id = wp_insert_user($user_data); // First and ONLY user creation
        
        if (is_wp_error($user_id)) {
            wp_send_json_error(array(
                'message' => 'Error creating user: ' . $user_id->get_error_message()
            ));
            wp_die();
        }
        
        // Generate member number (DST + current year + random 5 digits)
        $member_number = 'DST' . date('Y') . str_pad(wp_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        // Ensure member_number is unique as well, though less critical than username
        // (Consider adding a check if member_numbers need to be strictly unique across all time)

        // User is already created with 'pending_member' role. 
        // The 'member' role will be assigned upon admin approval.
        // No need to call wp_insert_user again or manually add/remove roles here.
        
        // Save member metadata
        $meta_fields = array(
            'member_number' => $member_number,
            'id_number' => $id_number,
            'date_of_birth' => $date_of_birth,
            'gender' => $gender,
            'marital_status' => $marital_status,
            'phone' => $phone,
            'alt_phone' => $alt_phone,
            'physical_address' => $physical_address,
            'postal_code' => $postal_code,
            'city' => $city,
            'employment_status' => $employment_status,
            'employer' => $employer,
            'job_title' => $job_title,
            'monthly_income' => $monthly_income,
            'kra_pin' => $kra_pin,
            'bank_name' => $bank_name,
            'bank_branch' => $bank_branch,
            'account_number' => $account_number,
            'initial_contribution' => $initial_contribution,
            'monthly_contribution' => $monthly_contribution,
            'member_status' => 'pending',
            'registration_date' => current_time('mysql'),
            'account_balance' => 0,
            'total_contributions' => 0,
            'last_contribution_date' => '',
            'verification_status' => 'pending',
            'verification_date' => '',
            'verified_by' => ''
        );
        
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }
        
        // Send notifications
        daystar_send_registration_notifications($user_id);
        
        wp_send_json_success(array(
            'message' => 'Registration successful! Please check your email for confirmation.',
            'member_number' => $member_number
        ));
        
    } catch (Exception $e) {
        wp_send_json_error(array(
            'message' => $e->getMessage()
        ));
    }
    
    wp_die();
}

/**
 * Ensure username is unique
 */
function daystar_ensure_unique_username($username) {
    $username = strtolower($username);
    $username = preg_replace('/[^a-z0-9]/', '', $username);
    
    $temp_username = $username;
    $counter = 1;
    
    while (username_exists($temp_username)) {
        $temp_username = $username . $counter;
        $counter++;
    }
    
    return $temp_username;
}

/**
 * Send registration notifications
 */
function daystar_send_registration_notifications($user_id) {
    $user = get_userdata($user_id);
    if (!$user) return;

    $admin_email = get_option('admin_email');
    $member_number = get_user_meta($user_id, 'member_number', true);
    $phone = get_user_meta($user_id, 'phone', true);

    // Member email notification
    $subject = 'Welcome to Daystar SACCO - Registration Confirmation';
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Thank you for registering with Daystar Multi-Purpose Co-op Society Ltd.\n\n";
    $message .= "Your Member Number is: {$member_number}\n\n";
    $message .= "Your registration is currently pending approval. You will receive an email once your membership has been approved.\n\n";
    $message .= "Next Steps:\n";
    $message .= "1. Make your initial contribution of KSh " . number_format(get_user_meta($user_id, 'initial_contribution', true), 2) . "\n";
    $message .= "2. Upload the required documents in your member dashboard\n";
    $message .= "3. Visit any of our branches with your original documents for verification\n\n";
    $message .= "Required Documents:\n";
    $message .= "- Original ID/Passport\n";
    $message .= "- Recent passport-sized photograph\n";
    $message .= "- Proof of residence (utility bill)\n";
    $message .= "- Latest payslip or 3 months bank statements\n";
    $message .= "- KRA PIN certificate\n\n";
    $message .= "For assistance, contact our support team:\n";
    $message .= "Email: support@daystar.co.ke\n";
    $message .= "Phone: +254 XXX XXX XXX\n\n";
    $message .= "Best regards,\nDaystar SACCO Team";

    wp_mail($user->user_email, $subject, $message);

    // Admin notification
    $subject = 'New Member Registration - ' . $member_number;
    $message = "A new member has registered:\n\n";
    $message .= "Member Number: {$member_number}\n";
    $message .= "Name: {$user->first_name} {$user->last_name}\n";
    $message .= "Email: {$user->user_email}\n";
    $message .= "Phone: {$phone}\n\n";
    $message .= "Initial Contribution: KSh " . number_format(get_user_meta($user_id, 'initial_contribution', true), 2) . "\n";
    $message .= "Monthly Contribution: KSh " . number_format(get_user_meta($user_id, 'monthly_contribution', true), 2) . "\n\n";
    $message .= "Review Application: " . admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $user_id);

    wp_mail($admin_email, $subject, $message);

    // SMS notification (implement your SMS gateway integration here)
    $sms_message = "Welcome to Daystar SACCO! Your member number is {$member_number}. Please check your email for registration details.";
    daystar_send_sms($phone, $sms_message);
}

/**
 * Send SMS using your preferred gateway
 */
function daystar_send_sms($phone, $message) {
    // Implement your SMS gateway integration here
    // Example using Africa's Talking API
    try {
        // Your implementation here
        return true;
    } catch (Exception $e) {
        error_log('SMS sending failed: ' . $e->getMessage());
        return false;
    }
}

/**
 * Display registration errors
 */
function daystar_display_registration_errors() {
    if (isset($_GET['registration_error'])) {
        $errors = explode('|', urldecode($_GET['registration_error']));
        
        echo '<div class="alert alert-danger form-error">';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . esc_html($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}
add_action('daystar_before_registration_form', 'daystar_display_registration_errors');

/**
 * Check if user is approved before login
 */
function daystar_check_user_status($user, $username, $password) {
    // Get user by username or email
    if (!$user) {
        $user = get_user_by('email', $username);
    }
    
    // If user exists and has the member role
    if ($user && in_array('member', $user->roles)) {
        $member_status = get_user_meta($user->ID, 'member_status', true);
        

        // If member status is suspended, prevent login
        if ($member_status === 'suspended') {
            return new WP_Error('account_suspended', __('Your account has been suspended. Please contact the administrator.'));
        }
    }
    
    return $user;
}
add_filter('authenticate', 'daystar_check_user_status', 30, 3);
