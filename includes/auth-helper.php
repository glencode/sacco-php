<?php
/**
 * Authentication Helper Functions
 * Enhanced with security and access control integration
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if user has access to member-only pages
 * Call this before any output to prevent headers already sent warnings
 */
function daystar_check_member_access($redirect_to = '') {
    if (!is_user_logged_in()) {
        nocache_headers();
        if (empty($redirect_to)) {
            $redirect_to = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        
        // Log unauthorized access attempt
        Daystar_Security_Access_Control::log_action(
            'unauthorized_access_attempt',
            'page_access',
            null,
            array(
                'requested_url' => $_SERVER['REQUEST_URI'],
                'redirect_to' => $redirect_to,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
            ),
            'warning'
        );
        
        $login_url = home_url('/login/?redirect_to=' . urlencode($redirect_to));
        wp_redirect($login_url);
        exit;
    }

    $current_user = wp_get_current_user();

    // Enhanced role checking with new security roles
    $allowed_roles = ['member', 'pending_member', 'administrator', 'loan_officer', 'credit_committee', 'treasurer', 'cmc_member'];
    $user_has_allowed_role = false;
    foreach ($allowed_roles as $role) {
        if (in_array($role, $current_user->roles)) {
            $user_has_allowed_role = true;
            break;
        }
    }

    // Additionally, allow if user explicitly has 'member' capability
    if (!$user_has_allowed_role && user_can($current_user, 'member')) {
        $user_has_allowed_role = true;
    }

    if (!$user_has_allowed_role) {
        // Log access denied
        Daystar_Security_Access_Control::log_action(
            'access_denied',
            'page_access',
            null,
            array(
                'user_id' => $current_user->ID,
                'user_roles' => $current_user->roles,
                'requested_url' => $_SERVER['REQUEST_URI'],
                'allowed_roles' => $allowed_roles
            ),
            'warning'
        );
        
        // User is logged in but does not have any of the required roles or capabilities.
        // Redirect them to the login page with an access denied message.
        nocache_headers();
        wp_redirect(home_url('/login/?message=access_denied'));
        exit;
    }

    // Log successful access
    Daystar_Security_Access_Control::log_action(
        'page_access_granted',
        'page_access',
        null,
        array(
            'user_id' => $current_user->ID,
            'user_roles' => $current_user->roles,
            'requested_url' => $_SERVER['REQUEST_URI']
        ),
        'info'
    );

    return $current_user;
}

/**
 * Check member status and redirect if necessary
 * Call this before any output
 */
function daystar_check_member_status($member_status, $allowed_statuses = ['active']) {
    if (!in_array($member_status, $allowed_statuses)) {
        $user_id = get_current_user_id();
        
        // Log member status check failure
        Daystar_Security_Access_Control::log_action(
            'member_status_check_failed',
            'member',
            $user_id,
            array(
                'current_status' => $member_status,
                'allowed_statuses' => $allowed_statuses,
                'requested_url' => $_SERVER['REQUEST_URI']
            ),
            'warning'
        );
        
        nocache_headers();
        wp_redirect(home_url('/member-dashboard'));
        exit;
    }
    return true;
}

/**
 * Enhanced role-based access control for specific pages
 */
function daystar_check_role_access($required_roles = array(), $redirect_url = null) {
    if (!is_user_logged_in()) {
        if (!$redirect_url) {
            $redirect_url = home_url('/login/?message=login_required');
        }
        wp_redirect($redirect_url);
        exit;
    }
    
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;
    
    // Check if user has any of the required roles
    $has_required_role = false;
    foreach ($required_roles as $role) {
        if (in_array($role, $user_roles)) {
            $has_required_role = true;
            break;
        }
    }
    
    // Always allow administrators
    if (in_array('administrator', $user_roles)) {
        $has_required_role = true;
    }
    
    if (!$has_required_role) {
        // Log unauthorized role access
        Daystar_Security_Access_Control::log_action(
            'unauthorized_role_access',
            'role_check',
            null,
            array(
                'user_id' => $current_user->ID,
                'user_roles' => $user_roles,
                'required_roles' => $required_roles,
                'requested_url' => $_SERVER['REQUEST_URI']
            ),
            'warning'
        );
        
        if (!$redirect_url) {
            $redirect_url = home_url('/login/?message=insufficient_permissions');
        }
        wp_redirect($redirect_url);
        exit;
    }
    
    return $current_user;
}

/**
 * Check if user can access loan management functions
 */
function daystar_check_loan_management_access() {
    return daystar_check_role_access(array('loan_officer', 'credit_committee', 'administrator'));
}

/**
 * Check if user can approve loans
 */
function daystar_check_loan_approval_access() {
    return daystar_check_role_access(array('credit_committee', 'administrator'));
}

/**
 * Check if user can disburse loans
 */
function daystar_check_loan_disbursement_access() {
    return daystar_check_role_access(array('treasurer', 'administrator'));
}

/**
 * Check if user can view financial reports
 */
function daystar_check_financial_reports_access() {
    return daystar_check_role_access(array('treasurer', 'cmc_member', 'administrator'));
}

/**
 * Check if user can manage credit policy
 */
function daystar_check_credit_policy_access() {
    return daystar_check_role_access(array('credit_committee', 'administrator'));
}

/**
 * Secure session management
 */
function daystar_start_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session parameters
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', is_ssl() ? 1 : 0);
        
        session_start();
        
        // Regenerate session ID periodically for security
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }
}

/**
 * Validate session security
 */
function daystar_validate_session_security() {
    daystar_start_secure_session();
    
    // Check for session hijacking
    $current_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $current_user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (isset($_SESSION['security_ip']) && $_SESSION['security_ip'] !== $current_ip) {
        // IP address changed - potential session hijacking
        Daystar_Security_Access_Control::log_action(
            'session_ip_mismatch',
            'security',
            get_current_user_id(),
            array(
                'original_ip' => $_SESSION['security_ip'],
                'current_ip' => $current_ip,
                'user_agent' => $current_user_agent
            ),
            'error'
        );
        
        session_destroy();
        wp_redirect(home_url('/login/?message=session_security_error'));
        exit;
    }
    
    if (isset($_SESSION['security_user_agent']) && $_SESSION['security_user_agent'] !== $current_user_agent) {
        // User agent changed - potential session hijacking
        Daystar_Security_Access_Control::log_action(
            'session_user_agent_mismatch',
            'security',
            get_current_user_id(),
            array(
                'original_user_agent' => $_SESSION['security_user_agent'],
                'current_user_agent' => $current_user_agent,
                'ip_address' => $current_ip
            ),
            'error'
        );
        
        session_destroy();
        wp_redirect(home_url('/login/?message=session_security_error'));
        exit;
    }
    
    // Set security markers if not set
    if (!isset($_SESSION['security_ip'])) {
        $_SESSION['security_ip'] = $current_ip;
    }
    if (!isset($_SESSION['security_user_agent'])) {
        $_SESSION['security_user_agent'] = $current_user_agent;
    }
}

// Initialize secure session on WordPress init
add_action('init', 'daystar_start_secure_session', 1);
