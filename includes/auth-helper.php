<?php
/**
 * Authentication Helper Functions
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
            // Get current URL
            $redirect_to = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        // Generate login URL
        $login_url = wp_login_url($redirect_to);
        // Redirect user
        wp_redirect($login_url);
        exit;
    }

    $current_user = wp_get_current_user();

    // Check if user is a member or pending member
    if (!in_array('member', $current_user->roles) && !in_array('pending_member', $current_user->roles)) {
        nocache_headers();
        wp_redirect(home_url('/'));
        exit;
    }

    return $current_user;
}

/**
 * Check member status and redirect if necessary
 * Call this before any output
 */
function daystar_check_member_status($member_status, $allowed_statuses = ['active']) {
    if (!in_array($member_status, $allowed_statuses)) {
        nocache_headers();
        wp_redirect(home_url('/member-dashboard'));
        exit;
    }
    return true;
}
