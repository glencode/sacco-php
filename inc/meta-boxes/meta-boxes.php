<?php
/**
 * Meta Boxes Registration
 */

function sacco_register_meta_boxes() {
    // Loan Product Meta Box
    add_meta_box(
        'loan_product_details',
        __('Loan Product Details', 'sacco-php'),
        'sacco_loan_meta_box_callback',
        'loan',
        'normal',
        'high'
    );

    // Savings Product Meta Box
    add_meta_box(
        'savings_product_details',
        __('Savings Product Details', 'sacco-php'),
        'sacco_savings_meta_box_callback',
        'savings',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sacco_register_meta_boxes');

function sacco_save_loan_meta($post_id) {
    if (!isset($_POST['sacco_loan_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['sacco_loan_meta_box_nonce'], 'sacco_loan_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $meta_fields = array(
        'interest_rate',
        'minimum_amount',
        'maximum_amount',
        'loan_term',
        'loan_badge',
        'processing_time',
        'processing_fee',
        'features',
        'requirements',
        'base_interest_rate_pa',
        'loan_factor_deposits',
        'minimum_deposit_requirement'
    );

    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_loan', 'sacco_save_loan_meta');

function sacco_save_savings_meta($post_id) {
    if (!isset($_POST['sacco_savings_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['sacco_savings_meta_box_nonce'], 'sacco_savings_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $meta_fields = array(
        'interest_rate',
        'minimum_deposit',
        'term',
        'withdrawal_terms',
        'target_audience',
        'features',
        'age_limit'
    );

    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_savings', 'sacco_save_savings_meta');
