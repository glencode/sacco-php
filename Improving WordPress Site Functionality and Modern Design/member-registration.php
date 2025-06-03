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
    add_action('admin_post_nopriv_daystar_register_member', 'daystar_process_registration');
    add_action('admin_post_daystar_register_member', 'daystar_process_registration');
}
add_action('init', 'daystar_register_member_actions');

/**
 * Process the member registration form
 */
function daystar_process_registration() {
    // Verify nonce
    if (!isset($_POST['registration_nonce']) || !wp_verify_nonce($_POST['registration_nonce'], 'daystar_registration_nonce')) {
        wp_die('Security check failed. Please try again.', 'Security Error', array('response' => 403));
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
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
    $postal_code = isset($_POST['postal_code']) ? sanitize_text_field($_POST['postal_code']) : '';
    
    $employment_status = isset($_POST['employment_status']) ? sanitize_text_field($_POST['employment_status']) : '';
    $employer = isset($_POST['employer']) ? sanitize_text_field($_POST['employer']) : '';
    $job_title = isset($_POST['job_title']) ? sanitize_text_field($_POST['job_title']) : '';
    $monthly_income = isset($_POST['monthly_income']) ? floatval($_POST['monthly_income']) : 0;
    $employment_duration = isset($_POST['employment_duration']) ? floatval($_POST['employment_duration']) : 0;
    $kra_pin = isset($_POST['kra_pin']) ? sanitize_text_field($_POST['kra_pin']) : '';
    
    $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $initial_contribution = isset($_POST['initial_contribution']) ? floatval($_POST['initial_contribution']) : 0;
    $monthly_contribution = isset($_POST['monthly_contribution']) ? floatval($_POST['monthly_contribution']) : 0;
    $terms_agreement = isset($_POST['terms_agreement']) ? true : false;
    
    // Validate required fields
    $errors = array();
    
    // Personal Information validation
    if (empty($first_name)) $errors[] = 'First name is required.';
    if (empty($last_name)) $errors[] = 'Last name is required.';
    if (empty($id_number)) $errors[] = 'ID number is required.';
    if (empty($date_of_birth)) $errors[] = 'Date of birth is required.';
    if (empty($gender)) $errors[] = 'Gender is required.';
    if (empty($marital_status)) $errors[] = 'Marital status is required.';
    
    // Contact Details validation
    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!is_email($email)) {
        $errors[] = 'Please enter a valid email address.';
    } elseif (email_exists($email)) {
        $errors[] = 'This email address is already registered.';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required.';
    } else {
        // Validate phone number format (simple check for now)
        if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
            $errors[] = 'Please enter a valid phone number.';
        }
    }
    
    if (empty($physical_address)) $errors[] = 'Physical address is required.';
    if (empty($city)) $errors[] = 'City/Town is required.';
    
    // Employment Information validation
    if (empty($employment_status)) $errors[] = 'Employment status is required.';
    if ($employment_status != 'unemployed') {
        if (empty($employer)) $errors[] = 'Employer/Business name is required.';
        if (empty($job_title)) $errors[] = 'Job title/Position is required.';
        if ($monthly_income <= 0) $errors[] = 'Monthly income must be greater than zero.';
    }
    if (empty($kra_pin)) $errors[] = 'KRA PIN is required.';
    
    // Account Setup validation
    if (empty($username)) {
        $errors[] = 'Username is required.';
    } elseif (username_exists($username)) {
        $errors[] = 'This username is already taken.';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must include at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must include at least one lowercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must include at least one number.';
    } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = 'Password must include at least one special character.';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }
    
    if ($initial_contribution < 1000) {
        $errors[] = 'Initial contribution must be at least KES 1,000.';
    }
    
    if ($monthly_contribution < 500) {
        $errors[] = 'Monthly contribution must be at least KES 500.';
    }
    
    if (!$terms_agreement) {
        $errors[] = 'You must agree to the Terms and Conditions.';
    }
    
    // If there are errors, redirect back to the registration page with error messages
    if (!empty($errors)) {
        $error_string = implode('|', $errors);
        $redirect_url = add_query_arg(array(
            'registration_error' => urlencode($error_string),
            'first_name' => urlencode($first_name),
            'last_name' => urlencode($last_name),
            'email' => urlencode($email),
            'username' => urlencode($username)
        ), home_url('/register'));
        
        wp_redirect($redirect_url);
        exit;
    }
    
    // Create the user account
    $user_data = array(
        'user_login' => $username,
        'user_pass' => $password,
        'user_email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name,
        'role' => 'member' // Custom role for members
    );
    
    $user_id = wp_insert_user($user_data);
    
    // Check if user creation was successful
    if (is_wp_error($user_id)) {
        $error = $user_id->get_error_message();
        $redirect_url = add_query_arg(array(
            'registration_error' => urlencode($error),
            'first_name' => urlencode($first_name),
            'last_name' => urlencode($last_name),
            'email' => urlencode($email),
            'username' => urlencode($username)
        ), home_url('/register'));
        
        wp_redirect($redirect_url);
        exit;
    }
    
    // Save additional user meta data
    update_user_meta($user_id, 'id_number', $id_number);
    update_user_meta($user_id, 'date_of_birth', $date_of_birth);
    update_user_meta($user_id, 'gender', $gender);
    update_user_meta($user_id, 'marital_status', $marital_status);
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'alt_phone', $alt_phone);
    update_user_meta($user_id, 'physical_address', $physical_address);
    update_user_meta($user_id, 'city', $city);
    update_user_meta($user_id, 'postal_code', $postal_code);
    update_user_meta($user_id, 'employment_status', $employment_status);
    update_user_meta($user_id, 'employer', $employer);
    update_user_meta($user_id, 'job_title', $job_title);
    update_user_meta($user_id, 'monthly_income', $monthly_income);
    update_user_meta($user_id, 'employment_duration', $employment_duration);
    update_user_meta($user_id, 'kra_pin', $kra_pin);
    update_user_meta($user_id, 'initial_contribution', $initial_contribution);
    update_user_meta($user_id, 'monthly_contribution', $monthly_contribution);
    update_user_meta($user_id, 'member_status', 'pending'); // Set initial status as pending
    update_user_meta($user_id, 'registration_date', current_time('mysql'));
    update_user_meta($user_id, 'terms_agreement', $terms_agreement);
    
    // Generate a unique member number
    $member_number = 'DST' . str_pad($user_id, 5, '0', STR_PAD_LEFT);
    update_user_meta($user_id, 'member_number', $member_number);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New Member Registration: ' . $first_name . ' ' . $last_name;
    $message = "A new member has registered and is pending approval:\n\n";
    $message .= "Name: $first_name $last_name\n";
    $message .= "Email: $email\n";
    $message .= "Phone: $phone\n";
    $message .= "Member Number: $member_number\n\n";
    $message .= "Please login to the admin dashboard to review and approve this member.";
    
    wp_mail($admin_email, $subject, $message);
    
    // Send welcome email to the new member
    $subject = 'Welcome to Daystar Multi-Purpose Co-op Society';
    $message = "Dear $first_name,\n\n";
    $message .= "Thank you for registering with Daystar Multi-Purpose Co-op Society. Your registration is currently pending approval.\n\n";
    $message .= "Your Member Number: $member_number\n";
    $message .= "Username: $username\n\n";
    $message .= "Once your registration is approved, you will receive another email with further instructions.\n\n";
    $message .= "If you have any questions, please contact our support team.\n\n";
    $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
    
    wp_mail($email, $subject, $message);
    
    // Redirect to registration success page
    wp_redirect(home_url('/registration-success?member=' . $member_number));
    exit;
}

/**
 * Create custom member role on plugin activation
 */
function daystar_create_member_role() {
    add_role(
        'member',
        'Member',
        array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'publish_posts' => false,
            'upload_files' => false,
        )
    );
}
register_activation_hook(__FILE__, 'daystar_create_member_role');

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
        
        // If member status is pending, prevent login
        if ($member_status === 'pending') {
            return new WP_Error('account_pending', __('Your account is pending approval. Please check your email for updates.'));
        }
        
        // If member status is suspended, prevent login
        if ($member_status === 'suspended') {
            return new WP_Error('account_suspended', __('Your account has been suspended. Please contact the administrator.'));
        }
    }
    
    return $user;
}
add_filter('authenticate', 'daystar_check_user_status', 30, 3);
