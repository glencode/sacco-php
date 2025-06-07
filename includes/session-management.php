<?php
/**
 * Session Management for Daystar Multi-Purpose Co-op Society
 * 
 * This file handles user authentication, session management, and security.
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Authenticate user and create session
 * 
 * @param string $member_id Member ID or email
 * @param string $password User password
 * @param bool $remember Whether to remember the user.
 * @return array Authentication result with status and message
 */
function daystar_authenticate_user($member_id, $password, $remember = false) {
    // Validate inputs
    if (empty($member_id) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Please enter both member number/email and password.'
        ];
    }

    $user = wp_authenticate($member_id, $password);

    if (is_wp_error($user)) {
        return [
            'success' => false,
            'message' => $user->get_error_message(),
        ];
    }

    // Successful WordPress authentication
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID, $remember);

    // Prepare user data for custom session (if needed) and response
    // You might want to store specific metadata or roles here
    $user_data_for_session = [
        'ID' => $user->ID,
        'user_login' => $user->user_login,
        'user_email' => $user->user_email,
        'display_name' => $user->display_name,
        'roles' => $user->roles, // Add user roles
        // Example: Fetch and store a custom role or member status if you have one in user meta
        // 'member_status' => get_user_meta($user->ID, 'member_status', true),
    ];

    // Store essential data in custom session
    $_SESSION['daystar_user'] = $user_data_for_session;
    $_SESSION['daystar_logged_in'] = true;
    $_SESSION['daystar_login_time'] = time();
    $_SESSION['daystar_expiry_time'] = time() + (8 * 60 * 60); // Example custom session expiry

    session_regenerate_id(true);

    return [
        'success' => true,
        'message' => 'Login successful!',
        'user' => $user_data_for_session, // Return WP user data
    ];
}

/**
 * Register new user
 * 
 * @param array $user_data User registration data
 * @return array Registration result with status and message
 */
function daystar_register_user($user_data) {
    // In a real implementation, this would insert into the database
    // For this demo, we'll simulate registration
    
    // Validate required fields
    $required_fields = [
        'first_name', 'last_name', 'email', 'phone', 'id_number',
        'employment_status', 'initial_contribution', 'password'
    ];
    
    foreach ($required_fields as $field) {
        if (empty($user_data[$field])) {
            return [
                'success' => false,
                'message' => 'Please fill in all required fields.'
            ];
        }
    }
    
    // Validate email format
    if (!filter_var($user_data['email'], FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Please enter a valid email address.'
        ];
    }
    
    // Validate password length
    if (strlen($user_data['password']) < 8) {
        return [
            'success' => false,
            'message' => 'Password must be at least 8 characters long.'
        ];
    }
    
    // Validate initial contribution
    if ($user_data['initial_contribution'] < 12000) {
        return [
            'success' => false,
            'message' => 'Initial contribution must be at least KSh 12,000.'
        ];
    }
    
    // Generate member ID
    $member_id = 'DSM' . rand(10000, 99999);
    
    // In production, hash the password before storing
    // $hashed_password = password_hash($user_data['password'], PASSWORD_DEFAULT);
    
    // Simulate successful registration
    return [
        'success' => true,
        'message' => 'Registration successful!',
        'member_id' => $member_id
    ];
}

/**
 * Check if user is logged in
 * 
 * @return bool Whether user is logged in
 */
function daystar_is_user_logged_in() {
    // First, check WordPress's own login status
    if (!is_user_logged_in()) {
        // If WP says not logged in, ensure our custom session is also cleared
        if (isset($_SESSION['daystar_logged_in']) && $_SESSION['daystar_logged_in'] === true) {
            daystar_logout_user(); // This will clear both WP and custom session parts
        }
        return false;
    }

    // If WordPress says user is logged in, then check our custom session layer
    if (isset($_SESSION['daystar_logged_in']) && $_SESSION['daystar_logged_in'] === true) {
        // Check if custom session has expired
        if (isset($_SESSION['daystar_expiry_time']) && time() < $_SESSION['daystar_expiry_time']) {
            return true; // Both WP and custom session are active and valid
        } else {
            // Custom session expired, log out user from both
            daystar_logout_user(); // This will also call wp_logout()
            return false;
        }
    } else {
        // This case is unlikely if wp_authenticate and daystar_authenticate_user are correctly linked,
        // but if WP is logged in and custom session isn't, treat as not fully logged in for Daystar context.
        // Or, could choose to re-initialize custom session here if WP user is valid.
        // For now, let's ensure logout to sync states.
        daystar_logout_user();
        return false;
    }
}

/**
 * Get current user data
 * 
 * @return array|null User data or null if not logged in
 */
function daystar_get_current_user() {
    if (!daystar_is_user_logged_in()) {
        return null;
    }

    $wp_user = wp_get_current_user();

    if ($wp_user && $wp_user->ID !== 0) {
        // WP user exists, use this as the primary source of truth.
        // $_SESSION['daystar_user'] should have been populated with relevant WP user data at login.
        // We can return the contents of $_SESSION['daystar_user'] which might have a subset of WP_User fields
        // or additional custom data. Or, return the WP_User object directly if that's more useful.
        // For consistency with what daystar_authenticate_user stores:
        if (isset($_SESSION['daystar_user'])) {
            // Optionally, verify if $_SESSION['daystar_user']['ID'] matches $wp_user->ID
            // If not, it indicates a potential session desync. For now, trust daystar_is_user_logged_in handled this.
            return $_SESSION['daystar_user'];
        } else {
            // Fallback: if daystar_user is not in session but WP user is logged in,
            // reconstruct it. This situation should ideally be avoided by proper session setup in daystar_authenticate_user.
            $user_data_for_session = [
                'ID' => $wp_user->ID,
                'user_login' => $wp_user->user_login,
                'user_email' => $wp_user->user_email,
                'display_name' => $wp_user->display_name,
            ];
            $_SESSION['daystar_user'] = $user_data_for_session;
            return $user_data_for_session;
        }
    }
    
    // Fallback for safety, though daystar_is_user_logged_in should prevent this state.
    return null;
}

/**
 * Log out user
 * 
 * @return void
 */
function daystar_logout_user() {
    // Log out from WordPress
    wp_logout(); // This handles clearing auth cookies and calling 'wp_logout' action hook.

    // Unset all custom session variables
    $_SESSION = [];
    
    // Delete the session cookie if it's being used by PHP's session handler
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), // Get the name of the PHP session cookie
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    // Destroy the PHP session
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}

/**
 * Request password reset
 * 
 * @param string $email User email
 * @return array Password reset result with status and message
 */
function daystar_request_password_reset($email) {
    // In a real implementation, this would check if email exists and send reset link
    // For this demo, we'll simulate the process
    
    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Please enter a valid email address.'
        ];
    }
    
    // Simulate email check
    $email_exists = ($email === 'demo@daystarsacco.co.ke');
    
    if ($email_exists) {
        // In production, generate reset token and send email
        // For demo, just return success
        return [
            'success' => true,
            'message' => 'Password reset link has been sent to your email.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Email address not found in our records.'
        ];
    }
}

/**
 * Reset user password
 * 
 * @param string $token Reset token
 * @param string $password New password
 * @return array Password reset result with status and message
 */
function daystar_reset_password($token, $password) {
    // In a real implementation, this would verify token and update password
    // For this demo, we'll simulate the process
    
    // Validate token and password
    if (empty($token) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Invalid request. Please try again.'
        ];
    }
    
    if (strlen($password) < 8) {
        return [
            'success' => false,
            'message' => 'Password must be at least 8 characters long.'
        ];
    }
    
    // Simulate token verification
    $valid_token = ($token === 'demo_token');
    
    if ($valid_token) {
        // In production, update password in database
        // For demo, just return success
        return [
            'success' => true,
            'message' => 'Password has been reset successfully. You can now log in with your new password.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Invalid or expired reset token. Please request a new password reset link.'
        ];
    }
}

/**
 * Check if user has required role
 * 
 * @param string|array $required_role Required role(s)
 * @return bool Whether user has required role
 */
function daystar_user_has_role($required_role) {
    $user = daystar_get_current_user();
    
    if (!$user) {
        return false;
    }

    // $user is expected to be the array from $_SESSION['daystar_user']
    // which should now contain a 'roles' key with an array of roles from WP_User object.
    if (!isset($user['roles']) || !is_array($user['roles'])) {
        return false; // User has no roles defined in the session data
    }

    $user_roles = $user['roles'];

    if (is_array($required_role)) {
        // Check if the user has ANY of the required roles
        foreach ($required_role as $role) {
            if (in_array($role, $user_roles)) {
                return true;
            }
        }
        return false;
    } else {
        // Check if the user has the single required role
        return in_array($required_role, $user_roles);
    }
}

/**
 * Redirect if user is not logged in
 * 
 * @param string $redirect_url URL to redirect to
 * @return void
 */
function daystar_require_login($redirect_url = '/login') {
    if (!daystar_is_user_logged_in()) {
        wp_redirect(home_url($redirect_url));
        exit;
    }
}

/**
 * Redirect if user does not have required role
 * 
 * @param string|array $required_role Required role(s)
 * @param string $redirect_url URL to redirect to
 * @return void
 */
function daystar_require_role($required_role, $redirect_url = '/login') {
    if (!daystar_user_has_role($required_role)) {
        wp_redirect(home_url($redirect_url));
        exit;
    }
}

/**
 * Handle AJAX login request
 */
function daystar_ajax_login() {
    // Check nonce for security
    check_ajax_referer('daystar_login_nonce', 'security');
    
    $member_id = isset($_POST['member_id']) ? sanitize_text_field($_POST['member_id']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) && $_POST['remember'] === 'true';
    
    // Pass the remember me status to daystar_authenticate_user
    // wp_set_auth_cookie within daystar_authenticate_user will handle the 'remember me' duration.
    $result = daystar_authenticate_user($member_id, $password, $remember);
    
    // The custom session expiry $_SESSION['daystar_expiry_time'] is still set in daystar_authenticate_user.
    // If $remember is true, WordPress handles longer cookie duration.
    // The custom session expiry can remain as a fixed window or be conditionally longer too,
    // but it's somewhat redundant if relying on WP's cookie.
    // For now, daystar_authenticate_user sets a fixed custom expiry. This is acceptable.
    // If $result['success'] is true, the user is logged in.
    
    wp_send_json($result);
}

/**
 * Handle AJAX registration request
 */
function daystar_ajax_register() {
    // Check nonce for security
    check_ajax_referer('daystar_register_nonce', 'security');
    
    // Sanitize and collect user data
    $user_data = [
        'first_name' => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '',
        'last_name' => isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '',
        'email' => isset($_POST['email']) ? sanitize_email($_POST['email']) : '',
        'phone' => isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '',
        'id_number' => isset($_POST['id_number']) ? sanitize_text_field($_POST['id_number']) : '',
        'employment_status' => isset($_POST['employment_status']) ? sanitize_text_field($_POST['employment_status']) : '',
        'initial_contribution' => isset($_POST['initial_contribution']) ? floatval($_POST['initial_contribution']) : 0,
        'password' => isset($_POST['password']) ? $_POST['password'] : ''
    ];
    
    $result = daystar_register_user($user_data);
    
    wp_send_json($result);
}

/**
 * Handle AJAX password reset request
 */
function daystar_ajax_password_reset() {
    // Check nonce for security
    check_ajax_referer('daystar_password_reset_nonce', 'security');
    
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    
    $result = daystar_request_password_reset($email);
    
    wp_send_json($result);
}

/**
 * Handle AJAX logout request
 */
function daystar_ajax_logout() {
    // Check nonce for security
    check_ajax_referer('daystar_logout_nonce', 'security');
    
    daystar_logout_user();
    
    wp_send_json([
        'success' => true,
        'message' => 'Logged out successfully.'
    ]);
}

// Register AJAX handlers
add_action('wp_ajax_daystar_login', 'daystar_ajax_login');
add_action('wp_ajax_nopriv_daystar_login', 'daystar_ajax_login');

add_action('wp_ajax_daystar_register', 'daystar_ajax_register');
add_action('wp_ajax_nopriv_daystar_register', 'daystar_ajax_register');

add_action('wp_ajax_daystar_password_reset', 'daystar_ajax_password_reset');
add_action('wp_ajax_nopriv_daystar_password_reset', 'daystar_ajax_password_reset');

add_action('wp_ajax_daystar_logout', 'daystar_ajax_logout');
