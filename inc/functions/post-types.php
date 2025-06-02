<?php
/**
 * Post Type Registration Functions
 */

function sacco_register_post_types() {
    register_post_type('loan', array(
        'labels' => array(
            'name'                  => _x('Loan Products', 'Post Type General Name', 'sacco-php'),
            'singular_name'         => _x('Loan Product', 'Post Type Singular Name', 'sacco-php'),
            'menu_name'             => __('Loan Products', 'sacco-php'),
        ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'has_archive'           => 'loans',
        'rewrite'               => array('slug' => 'loan-product'),
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt')
    ));

    register_post_type('savings', array(
        'labels' => array(
            'name'                  => _x('Savings Products', 'Post Type General Name', 'sacco-php'),
            'singular_name'         => _x('Savings Product', 'Post Type Singular Name', 'sacco-php'),
            'menu_name'             => __('Savings Products', 'sacco-php'),
        ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'has_archive'           => 'savings',
        'rewrite'               => array('slug' => 'savings-product'),
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt')
    ));

    // Add other post types here
}
add_action('init', 'sacco_register_post_types');

function sacco_register_taxonomies() {
    register_taxonomy('loan_category', array('loan'), array(
        'labels' => array(
            'name'              => _x('Loan Categories', 'taxonomy general name', 'sacco-php'),
            'singular_name'     => _x('Loan Category', 'taxonomy singular name', 'sacco-php'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'loan-category'),
    ));

    register_taxonomy('savings_category', array('savings'), array(
        'labels' => array(
            'name'              => _x('Savings Categories', 'taxonomy general name', 'sacco-php'),
            'singular_name'     => _x('Savings Category', 'taxonomy singular name', 'sacco-php'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'savings-category'),
    ));

    // Add other taxonomies here
}
add_action('init', 'sacco_register_taxonomies');
