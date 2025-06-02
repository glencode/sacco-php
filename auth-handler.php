<?php
/**
 * Login and Registration Handler for Daystar Multi-Purpose Co-op Society Ltd.
 * 
 * This file handles the server-side processing of login and registration requests
 * including validation, authentication, and database operations.
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Process login request
 */
function process_login() {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
        // Get form data
        $member_number = isset($_POST['member_number']) ? trim($_POST['member_number']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $remember_me = isset($_POST['remember_me']) ? true : false;
        
        // Validate form data
        $errors = [];
        
        if (empty($member_number)) {
            $errors[] = 'Member number is required';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required';
        }
        
        // If no validation errors, attempt to authenticate
        if (empty($errors)) {
            // In a real application, you would check credentials against a database
            // For demonstration purposes, we'll use a simple check
            if ($member_number === 'DEMO123' && $password === 'password123') {
                // Authentication successful
                
                // Set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['member_number'] = $member_number;
                $_SESSION['member_name'] = 'Demo User'; // In real app, get from database
                
                // Set remember me cookie if requested
                if ($remember_me) {
                    $token = bin2hex(random_bytes(32)); // Generate secure token
                    setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                    
                    // In real app, store token in database associated with user
                }
                
                // Redirect to dashboard
                header('Location: member-dashboard.php');
                exit;
            } else {
                // Authentication failed
                $errors[] = 'Invalid member number or password';
            }
        }
        
        // If there are errors, store them in session and redirect back to login page
        if (!empty($errors)) {
            $_SESSION['login_errors'] = $errors;
            header('Location: login.php');
            exit;
        }
    }
}

/**
 * Process registration request
 */
function process_registration() {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
        // Get form data
        $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $id_number = isset($_POST['id_number']) ? trim($_POST['id_number']) : '';
        $employment_status = isset($_POST['employment_status']) ? trim($_POST['employment_status']) : '';
        $employer = isset($_POST['employer']) ? trim($_POST['employer']) : '';
        $monthly_income = isset($_POST['monthly_income']) ? (float)$_POST['monthly_income'] : 0;
        $initial_contribution = isset($_POST['initial_contribution']) ? (float)$_POST['initial_contribution'] : 0;
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $terms_agreement = isset($_POST['terms_agreement']) ? true : false;
        
        // Validate form data
        $errors = [];
        
        if (empty($first_name)) {
            $errors[] = 'First name is required';
        }
        
        if (empty($last_name)) {
            $errors[] = 'Last name is required';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if (empty($id_number)) {
            $errors[] = 'ID number is required';
        }
        
        if (empty($employment_status)) {
            $errors[] = 'Employment status is required';
        }
        
        if ($initial_contribution < 12000) {
            $errors[] = 'Initial contribution must be at least KSh 12,000';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }
        
        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match';
        }
        
        if (!$terms_agreement) {
            $errors[] = 'You must agree to the terms and conditions';
        }
        
        // If no validation errors, process registration
        if (empty($errors)) {
            // In a real application, you would store the data in a database
            // For demonstration purposes, we'll just simulate success
            
            // Generate a unique member number
            $member_number = 'DST' . date('Y') . rand(1000, 9999);
            
            // Store registration data in session for demonstration
            $_SESSION['registration_success'] = true;
            $_SESSION['member_number'] = $member_number;
            
            // Redirect to registration success page
            header('Location: registration-success.php');
            exit;
        }
        
        // If there are errors, store them in session and redirect back to registration page
        if (!empty($errors)) {
            $_SESSION['registration_errors'] = $errors;
            $_SESSION['registration_data'] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'id_number' => $id_number,
                'employment_status' => $employment_status,
                'employer' => $employer,
                'monthly_income' => $monthly_income,
                'initial_contribution' => $initial_contribution
            ];
            header('Location: register.php');
            exit;
        }
    }
}

/**
 * Process logout request
 */
function process_logout() {
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        // Destroy session
        session_unset();
        session_destroy();
        
        // Remove remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Redirect to home page
        header('Location: index.php');
        exit;
    }
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Redirect if not logged in
 */
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get current user data
 */
function get_current_user() {
    if (is_logged_in()) {
        return [
            'member_number' => $_SESSION['member_number'],
            'name' => $_SESSION['member_name']
        ];
    }
    return null;
}

// Process requests
process_login();
process_registration();
process_logout();
