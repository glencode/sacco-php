<?php
/**
 * Handles all login related functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle the login form submission
 */
function daystar_handle_login() {
    $is_ajax = defined('DOING_AJAX') && DOING_AJAX;
    
    // Verify nonce
    if (!isset($_POST['login_nonce']) || !wp_verify_nonce($_POST['login_nonce'], 'daystar_login')) {
        if ($is_ajax) {
            wp_send_json_error(array('message' => 'Security check failed. Please refresh the page and try again.'));
        } else {
            wp_safe_redirect(add_query_arg('login_error', 'security_check_failed', wp_get_referer()));
            exit;
        }
    }

    // Validate credentials
    if (empty($_POST['member_number']) || empty($_POST['password'])) {
        if ($is_ajax) {
            wp_send_json_error(array('message' => 'Please enter both member number/email and password.'));
        } else {
            wp_safe_redirect(add_query_arg('login_error', 'missing_fields', wp_get_referer()));
            exit;
        }
    }

    // Setup credentials
    $creds = array(
        'user_login'    => sanitize_text_field($_POST['member_number']),
        'user_password' => $_POST['password'],
        'remember'      => isset($_POST['rememberMe'])
    );

    // Get the redirect URL
    $redirect_to = !empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : '';
    
    // Attempt login
    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        if ($is_ajax) {
            wp_send_json_error(array('message' => $user->get_error_message()));
        } else {
            wp_safe_redirect(add_query_arg('login_error', urlencode($user->get_error_message()), wp_get_referer()));
            exit;
        }
    }

    // Set the current user
    wp_set_current_user($user->ID);
    
    // Set the auth cookie
    wp_set_auth_cookie($user->ID, $creds['remember']);

    // Get user's member status and determine redirect
    $member_status = get_user_meta($user->ID, 'member_status', true);
    $user_roles = $user->roles;
    
    // Determine final redirect URL
    $final_redirect = '';
    
    if (!empty($redirect_to)) {
        $final_redirect = $redirect_to;
    } else {
        // Default redirect logic based on user role/status
        if (in_array('administrator', $user_roles)) {
            $final_redirect = admin_url();
        } elseif (in_array('member', $user_roles) || $member_status === 'active' || $member_status === 'pending') {
            $final_redirect = home_url('/member-dashboard/');
        } else {
            $final_redirect = home_url('/member-dashboard/');
        }
    }
    
    // Ensure we have a valid redirect URL
    if (empty($final_redirect)) {
        $final_redirect = home_url('/member-dashboard/');
    }
    
    // Store user session data for custom session management if needed
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['daystar_user'] = array(
        'ID' => $user->ID,
        'user_login' => $user->user_login,
        'user_email' => $user->user_email,
        'display_name' => $user->display_name,
        'roles' => $user_roles,
        'member_status' => $member_status
    );
    $_SESSION['daystar_logged_in'] = true;
    $_SESSION['daystar_login_time'] = time();
    
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    if ($is_ajax) {
        wp_send_json_success(array(
            'redirect_to' => $final_redirect,
            'message' => 'Login successful',
            'user' => array(
                'ID' => $user->ID,
                'display_name' => $user->display_name,
                'member_status' => $member_status
            )
        ));
    } else {
        nocache_headers();
        wp_safe_redirect($final_redirect);
        exit;
    }
}

// Register the handler for both AJAX and non-AJAX requests
add_action('admin_post_nopriv_daystar_login', 'daystar_handle_login');
add_action('admin_post_daystar_login', 'daystar_handle_login');
add_action('wp_ajax_nopriv_daystar_login', 'daystar_handle_login');
add_action('wp_ajax_daystar_login', 'daystar_handle_login');

/**
 * Check if member dashboard page exists, create if it doesn't
 */
function daystar_ensure_member_dashboard() {
    $dashboard_page = get_page_by_path('member-dashboard');
    
    if (!$dashboard_page) {
        // Create the member dashboard page
        $dashboard_page_id = wp_insert_post(array(
            'post_title' => 'Member Dashboard',
            'post_name' => 'member-dashboard',
            'post_content' => '[member_dashboard]', // Assuming you have a shortcode
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ));
        
        if ($dashboard_page_id) {
            // Set the page template if you have a custom template
            update_post_meta($dashboard_page_id, '_wp_page_template', 'template-member-dashboard.php');
        }
    }
}

// Hook to ensure dashboard page exists
add_action('init', 'daystar_ensure_member_dashboard');