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
 * @return array Authentication result with status and message
 */
function daystar_authenticate_user($member_id, $password) {
    // In a real implementation, this would check against the database
    // For this demo, we'll simulate authentication
    
    // Validate inputs
    if (empty($member_id) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Please enter both member number/email and password.'
        ];
    }
    
    // Simulate database check
    // In production, use proper password hashing and verification
    $valid_credentials = false;
    
    // Demo credentials for testing
    if (($member_id === 'DSM12345' || $member_id === 'demo@daystarsacco.co.ke') && $password === 'password123') {
        $valid_credentials = true;
        $user_data = [
            'member_id' => 'DSM12345',
            'name' => 'John Doe',
            'email' => 'demo@daystarsacco.co.ke',
            'role' => 'member',
            'status' => 'active'
        ];
    }
    
    if ($valid_credentials) {
        // Create session
        $_SESSION['daystar_user'] = $user_data;
        $_SESSION['daystar_logged_in'] = true;
        $_SESSION['daystar_login_time'] = time();
        
        // Set session expiry (8 hours)
        $_SESSION['daystar_expiry_time'] = time() + (8 * 60 * 60);
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        return [
            'success' => true,
            'message' => 'Login successful!',
            'user' => $user_data
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Invalid member number/email or password. Please try again.'
        ];
    }
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
    // Check if session exists and is valid
    if (isset($_SESSION['daystar_logged_in']) && $_SESSION['daystar_logged_in'] === true) {
        // Check if session has expired
        if (isset($_SESSION['daystar_expiry_time']) && time() < $_SESSION['daystar_expiry_time']) {
            return true;
        } else {
            // Session expired, log out user
            daystar_logout_user();
            return false;
        }
    }
    
    return false;
}

/**
 * Get current user data
 * 
 * @return array|null User data or null if not logged in
 */
function daystar_get_current_user() {
    if (daystar_is_user_logged_in() && isset($_SESSION['daystar_user'])) {
        return $_SESSION['daystar_user'];
    }
    
    return null;
}

/**
 * Log out user
 * 
 * @return void
 */
function daystar_logout_user() {
    // Unset all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    // Destroy the session
    session_destroy();
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
    
    if (is_array($required_role)) {
        return in_array($user['role'], $required_role);
    } else {
        return $user['role'] === $required_role;
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
    
    $result = daystar_authenticate_user($member_id, $password);
    
    if ($result['success']) {
        // Set longer session expiry if remember me is checked
        if ($remember) {
            $_SESSION['daystar_expiry_time'] = time() + (30 * 24 * 60 * 60); // 30 days
        }
    }
    
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
