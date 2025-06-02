<?php
/**
 * FAQ Custom Post Type
 */

class FAQ_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('FAQs', 'daystar'),
            'singular_name'      => __('FAQ', 'daystar'),
            'menu_name'          => __('FAQs', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New FAQ', 'daystar'),
            'edit_item'          => __('Edit FAQ', 'daystar'),
            'new_item'           => __('New FAQ', 'daystar'),
            'view_item'          => __('View FAQ', 'daystar'),
            'search_items'       => __('Search FAQs', 'daystar'),
            'not_found'          => __('No FAQs found', 'daystar'),
            'not_found_in_trash' => __('No FAQs found in trash', 'daystar')
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'supports'            => array('title', 'editor'),
            'menu_icon'           => 'dashicons-format-status',
            'rewrite'             => array('slug' => 'faqs')
        );

        register_post_type('faq', $args);
    }

    public function register_taxonomy() {
        $labels = array(
            'name'              => __('FAQ Categories', 'daystar'),
            'singular_name'     => __('FAQ Category', 'daystar'),
            'search_items'      => __('Search FAQ Categories', 'daystar'),
            'all_items'         => __('All FAQ Categories', 'daystar'),
            'parent_item'       => __('Parent FAQ Category', 'daystar'),
            'parent_item_colon' => __('Parent FAQ Category:', 'daystar'),
            'edit_item'         => __('Edit FAQ Category', 'daystar'),
            'update_item'       => __('Update FAQ Category', 'daystar'),
            'add_new_item'      => __('Add New FAQ Category', 'daystar'),
            'new_item_name'     => __('New FAQ Category Name', 'daystar'),
            'menu_name'         => __('FAQ Categories', 'daystar'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'faq-category'),
        );

        register_taxonomy('faq_category', array('faq'), $args);
    }
}

new FAQ_CPT();
