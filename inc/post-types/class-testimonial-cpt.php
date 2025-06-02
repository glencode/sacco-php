<?php
/**
 * Custom Post Type - Testimonials
 * 
 * @package daystar-website-fixes
 */

/**
 * Class to handle testimonial custom post type
 */
class Daystar_Testimonial_CPT {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
    }

    /**
     * Register testimonial post type
     */
    public function register_post_type() {
        $labels = array(
            'name'               => _x('Testimonials', 'Post Type General Name', 'sacco-php'),
            'singular_name'      => _x('Testimonial', 'Post Type Singular Name', 'sacco-php'),
            'menu_name'          => __('Testimonials', 'sacco-php'),
            'name_admin_bar'     => __('Testimonial', 'sacco-php'),
            'all_items'          => __('All Testimonials', 'sacco-php'),
            'add_new'            => __('Add New', 'sacco-php'),
            'add_new_item'       => __('Add New Testimonial', 'sacco-php'),
            'edit_item'          => __('Edit Testimonial', 'sacco-php'),
            'view_item'          => __('View Testimonial', 'sacco-php'),
            'search_items'       => __('Search Testimonials', 'sacco-php'),
            'not_found'          => __('No testimonials found', 'sacco-php'),
            'not_found_in_trash' => __('No testimonials found in trash', 'sacco-php'),
            'featured_image'     => __('Author Image', 'sacco-php'),
            'set_featured_image' => __('Set author image', 'sacco-php'),
        );

        $args = array(
            'label'               => __('Testimonial', 'sacco-php'),
            'description'         => __('Customer/Member Testimonials', 'sacco-php'),
            'labels'             => $labels,
            'supports'           => array('title', 'editor', 'thumbnail', 'revisions', 'page-attributes'),
            'hierarchical'       => false,
            'public'             => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-testimonial',
            'show_in_admin_bar'  => true,
            'show_in_nav_menus'  => false,
            'can_export'         => true,
            'has_archive'        => false,
            'exclude_from_search'=> true,
            'publicly_queryable' => false,
            'capability_type'    => 'post',
            'show_in_rest'       => true,
        );

        register_post_type('testimonial', $args);
    }
}

// Initialize the class
new Daystar_Testimonial_CPT();
