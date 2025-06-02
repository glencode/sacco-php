<?php
/**
 * Authentication related functions
 */

function sacco_handle_login() {
    if (!isset($_POST['sacco_login_nonce']) || !wp_verify_nonce($_POST['sacco_login_nonce'], 'sacco_login')) {
        wp_die(__('Invalid nonce specified', 'sacco-php'), __('Error', 'sacco-php'), array(
            'response' => 403,
            'back_link' => true,
        ));
    }

    $credentials = array(
        'user_login'    => sanitize_user($_POST['username']),
        'user_password' => $_POST['password'],
        'remember'      => isset($_POST['remember'])
    );

    $user = wp_signon($credentials, is_ssl());

    if (is_wp_error($user)) {
        wp_redirect(add_query_arg('login', 'failed', wp_login_url()));
        exit;
    }

    wp_redirect(home_url('/member-dashboard/'));
    exit;
}
add_action('admin_post_sacco_login', 'sacco_handle_login');
add_action('admin_post_nopriv_sacco_login', 'sacco_handle_login');

function sacco_handle_registration() {
    if (!isset($_POST['sacco_register_nonce']) || !wp_verify_nonce($_POST['sacco_register_nonce'], 'sacco_register')) {
        wp_die(__('Invalid nonce specified', 'sacco-php'));
    }

    $user_data = array(
        'user_login' => sanitize_user($_POST['username']),
        'user_email' => sanitize_email($_POST['email']),
        'user_pass'  => $_POST['password'],
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name'  => sanitize_text_field($_POST['last_name'])
    );

    if ($_POST['password'] !== $_POST['confirm_password']) {
        wp_redirect(add_query_arg('registration', 'password_mismatch', home_url('/register/')));
        exit;
    }

    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        wp_redirect(add_query_arg('registration', 'failed', home_url('/register/')));
        exit;
    }

    // Add custom user meta
    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'id_number', sanitize_text_field($_POST['id_number']));
    update_user_meta($user_id, 'initial_contribution', sanitize_text_field($_POST['initial_contribution']));
    update_user_meta($user_id, 'member_number', 'DST' . date('Y') . sprintf('%04d', $user_id));

    // Set user role
    $user = new WP_User($user_id);
    $user->set_role('member');

    // Log the user in
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    wp_redirect(home_url('/member-dashboard/'));
    exit;
}
add_action('admin_post_nopriv_sacco_register', 'sacco_handle_registration');

function sacco_restrict_member_portal_access() {
    $member_pages = array(
        'member-dashboard',
        'member-loans',
        'member-savings',
        'member-profile',
        'member-transactions'
    );

    if (is_page($member_pages) && !is_user_logged_in()) {
        wp_redirect(wp_login_url(get_permalink()));
        exit;
    }
}
add_action('template_redirect', 'sacco_restrict_member_portal_access', 1);
