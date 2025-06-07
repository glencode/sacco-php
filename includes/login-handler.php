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
    $redirect_to = !empty($_POST['redirect_to']) ? $_POST['redirect_to'] : '';
    if (empty($redirect_to)) {
        $redirect_to = home_url('/member-dashboard');
    }

    // Attempt login
    $user = wp_signon($creds, true);

    if (is_wp_error($user)) {
        if ($is_ajax) {
            wp_send_json_error(array('message' => $user->get_error_message()));
        } else {
            wp_safe_redirect(add_query_arg('login_error', urlencode($user->get_error_message()), wp_get_referer()));
            exit;
        }
    }

    // Get user's member status
    $member_status = get_user_meta($user->ID, 'member_status', true);
    
    // Set the auth cookie since wp_signon() doesn't do it automatically for AJAX requests
    wp_set_auth_cookie($user->ID, $creds['remember']);
    
    // For pending members, always redirect to dashboard
    if ($member_status === 'pending') {
        if ($is_ajax) {
            wp_send_json_success(array(
                'redirect_to' => home_url('/member-dashboard'),
                'message' => 'Login successful'
            ));
        } else {
            nocache_headers();
            wp_redirect(home_url('/member-dashboard'));
            exit;
        }
    }
    
    // For active members and other roles, redirect to requested page or dashboard
    if ($is_ajax) {
        wp_send_json_success(array(
            'redirect_to' => $redirect_to,
            'message' => 'Login successful'
        ));
    } else {
        nocache_headers();
        wp_redirect($redirect_to);
        exit;
    }
}

// Register the handler for both AJAX and non-AJAX requests
add_action('admin_post_nopriv_daystar_login', 'daystar_handle_login');
add_action('admin_post_daystar_login', 'daystar_handle_login');
add_action('wp_ajax_nopriv_daystar_login', 'daystar_handle_login');
add_action('wp_ajax_daystar_login', 'daystar_handle_login');
