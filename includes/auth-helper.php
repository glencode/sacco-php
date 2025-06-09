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
            $redirect_to = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        $login_url = home_url('/login/?redirect_to=' . urlencode($redirect_to));
        wp_redirect($login_url);
        exit;
    }

    $current_user = wp_get_current_user();

    // Allowed roles for member areas
    $allowed_roles = ['member', 'pending_member', 'administrator'];
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
        // User is logged in but does not have any of the required roles or capabilities.
        // Redirect them to the login page with an access denied message.
        nocache_headers();
        wp_redirect(home_url('/login/?message=access_denied'));
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
