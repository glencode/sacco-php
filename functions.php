<?php
/**
 * sacco-php functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sacco-php
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sacco_php_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on sacco-php, use a find and replace
		* to change 'sacco-php' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'sacco-php', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary'      => esc_html__( 'Primary Navigation', 'sacco-php' ),
			'footer_links' => esc_html__( 'Footer Links', 'sacco-php' ),
			'footer_quick_links' => esc_html__( 'Footer Quick Links', 'sacco-php' ),
			'social_links' => esc_html__( 'Social Media Links', 'sacco-php' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'sacco_php_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'sacco_php_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sacco_php_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sacco_php_content_width', 640 );
}
add_action( 'after_setup_theme', 'sacco_php_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sacco_php_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'sacco-php' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'sacco-php' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	// Footer Widget Area 1
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 1', 'sacco-php' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in the first footer column.', 'sacco-php' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	// Footer Widget Area 2
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 2', 'sacco-php' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in the second footer column.', 'sacco-php' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	// Footer Widget Area 3
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 3', 'sacco-php' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in the third footer column.', 'sacco-php' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	// Footer Widget Area 4
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 4', 'sacco-php' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here to appear in the fourth footer column.', 'sacco-php' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'sacco_php_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sacco_php_scripts() {    // Modern main CSS - load this first as it contains preloader styles
    wp_enqueue_style('sacco-php-modern-main', get_template_directory_uri() . '/assets/css/modern-main.css', array(), _S_VERSION);
    
    // Base theme style (info only, no actual styles)
    wp_enqueue_style('sacco-php-style', get_stylesheet_uri(), array('sacco-php-modern-main'), _S_VERSION);
    wp_style_add_data('sacco-php-style', 'rtl', 'replace');

    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '5.1.3', 'all');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');
    
    // Enhanced Navigation styles with glassmorphism
    wp_enqueue_style('daystar-navigation', get_template_directory_uri() . '/assets/css/navigation.css', array('sacco-php-modern-main'), '1.0.1');
    
    // Navigation Override - Remove white containers and colored borders
    wp_enqueue_style('daystar-navigation-override', get_template_directory_uri() . '/assets/css/navigation-override.css', array('daystar-navigation'), '1.0.0');
    
    // Footer Redesign - Complete oceanic theme footer
    wp_enqueue_style('daystar-footer-redesign', get_template_directory_uri() . '/assets/css/footer-redesign.css', array('sacco-php-modern-main'), '1.0.0');
    
    // Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0', 'all');
      // AOS CSS
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
    
    // Table of Contents CSS (when needed)
    if (is_singular() && !is_front_page()) {
        wp_enqueue_style('table-of-contents-styles', get_template_directory_uri() . '/assets/css/template-parts/table-of-contents.css', array('sacco-php-modern-main'), _S_VERSION);
    }

    // jQuery
    wp_enqueue_script('jquery');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.1.3', true);
    
    // Swiper JS - Updated to latest stable version
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), '11.0.0', true);
    
    // Chart.js
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', array(), '3.7.1', true);
    
    // AOS JS
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

    // Their functionality is now integrated into main.js and front-page.js
    
    // Main custom JS (depends on all other scripts)
    wp_enqueue_script('sacco-php-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap-js', 'swiper-js', 'chart-js', 'aos-js'), _S_VERSION, true);

    // Front page specific styles and JS
    if (is_front_page()) {
        wp_enqueue_style('sacco-php-front-page-css', get_template_directory_uri() . '/assets/css/front-page.css', array('sacco-php-modern-main'), _S_VERSION);
        wp_enqueue_script('sacco-php-front-page', get_template_directory_uri() . '/assets/js/front-page.js', array('sacco-php-main'), _S_VERSION, true);
        
        // Localize script for AJAX calls
        wp_localize_script('sacco-php-front-page', 'daystar_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('daystar_ajax_nonce')
        ));
    }

    // Comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Table of Contents script (when needed)
    if (is_singular() && !is_front_page()) {
        wp_enqueue_script('table-of-contents-script', get_template_directory_uri() . '/assets/js/template-parts/table-of-contents.js', array('jquery'), _S_VERSION, true);
    }

    // Page specific styles
    if (is_page('about')) {
        wp_enqueue_style('page-about-styles', get_template_directory_uri() . '/assets/css/pages/page-about.css', array('sacco-php-modern-main'), _S_VERSION);
    }

    if (is_page('downloads')) {
        wp_enqueue_style('page-downloads-styles', get_template_directory_uri() . '/assets/css/pages/page-downloads.css', array('sacco-php-modern-main'), _S_VERSION);
    }

    if (is_page_template('page-delegates.php')) {
        wp_enqueue_style('page-delegates-styles', get_template_directory_uri() . '/assets/css/pages/page-delegates.css', array('sacco-php-modern-main'), _S_VERSION);
        wp_enqueue_script('page-delegates-script', get_template_directory_uri() . '/assets/js/page-delegates.js', array('jquery', 'aos-js'), _S_VERSION, true);
    }

    if (is_page_template('page-management-team.php')) {
        wp_enqueue_style('page-management-team-styles', get_template_directory_uri() . '/assets/css/pages/page-management-team.css', array('sacco-php-modern-main'), _S_VERSION);
        wp_enqueue_script('page-delegates-script', get_template_directory_uri() . '/assets/js/page-delegates.js', array('jquery', 'aos-js'), _S_VERSION, true);
    }

    if (is_page_template('page-supervisory-committee.php')) {
        wp_enqueue_style('page-supervisory-committee-styles', get_template_directory_uri() . '/assets/css/pages/page-supervisory-committee.css', array('sacco-php-modern-main'), _S_VERSION);
        wp_enqueue_script('page-delegates-script', get_template_directory_uri() . '/assets/js/page-delegates.js', array('jquery', 'aos-js'), _S_VERSION, true);
    }

    if (is_page_template('page-our-history.php')) {
        wp_enqueue_style('page-our-history-styles', get_template_directory_uri() . '/assets/css/pages/page-our-history.css', array('sacco-php-modern-main'), _S_VERSION);
        wp_enqueue_script('page-our-history-script', get_template_directory_uri() . '/assets/js/pages/page-our-history.js', array('jquery', 'aos-js'), _S_VERSION, true);
    }

    if (is_singular('product') || is_singular('loan') || is_singular('savings')) {
        wp_enqueue_style('faq-section-styles', get_template_directory_uri() . '/assets/css/template-parts/faq-section.css', array('sacco-php-modern-main'), _S_VERSION);
    }
}
add_action( 'wp_enqueue_scripts', 'sacco_php_scripts' );

// Register Custom Post Type for Slides
function sacco_php_register_slide_cpt() {

	$labels = array(
		'name'                  => _x( 'Slides', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Slides', 'sacco-php' ),
		'name_admin_bar'        => __( 'Slide', 'sacco-php' ),
		'archives'              => __( 'Slide Archives', 'sacco-php' ),
		'attributes'            => __( 'Slide Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Slide:', 'sacco-php' ),
		'all_items'             => __( 'All Slides', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Slide', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Slide', 'sacco-php' ),
		'edit_item'             => __( 'Edit Slide', 'sacco-php' ),
		'update_item'           => __( 'Update Slide', 'sacco-php' ),
		'view_item'             => __( 'View Slide', 'sacco-php' ),
		'view_items'            => __( 'View Slides', 'sacco-php' ),
		'search_items'          => __( 'Search Slide', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Background Image', 'sacco-php' ), // Changed for clarity
		'set_featured_image'    => __( 'Set background image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove background image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as background image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into slide', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this slide', 'sacco-php' ),
		'items_list'            => __( 'Slides list', 'sacco-php' ),
		'items_list_navigation' => __( 'Slides list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter slides list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Slide', 'sacco-php' ),
		'description'           => __( 'For creating hero slider content', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields' ), // Added custom-fields
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true, // Set to true to be accessible, but may not need individual slide pages
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5, // Below Posts
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, // No archive page needed for slides
		'exclude_from_search'   => true,
		'publicly_queryable'    => false, // Individual slides likely don't need to be queryable by URL
		'capability_type'       => 'post',
        'show_in_rest'          => true, // Important for potential future headless use or JS fetching
	);
	register_post_type( 'slide', $args );

}
add_action( 'init', 'sacco_php_register_slide_cpt', 0 );

// Meta Boxes for Slide CPT
function sacco_php_register_slide_meta_boxes() {
    add_meta_box(
        'slide_link_button_meta_box',
        __('Slide Link & Button', 'sacco-php'),
        'sacco_php_slide_meta_box_callback',
        'slide',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_slide', 'sacco_php_register_slide_meta_boxes');

function sacco_php_slide_meta_box_callback($post) {
    wp_nonce_field('sacco_php_slide_meta_box', 'sacco_php_slide_meta_box_nonce');

    $slide_button_text = get_post_meta($post->ID, '_slide_button_text', true);
    $slide_button_url = get_post_meta($post->ID, '_slide_button_url', true);
    $slide_link_url = get_post_meta($post->ID, '_slide_link_url', true); // Optional: For linking the whole slide

    ?>
    <p>
        <label for="slide_button_text"><?php _e('Button Text (Optional):', 'sacco-php'); ?></label>
        <input type="text" id="slide_button_text" name="slide_button_text" value="<?php echo esc_attr($slide_button_text); ?>" class="widefat" placeholder="e.g., Learn More, Join Now">
    </p>
    <p>
        <label for="slide_button_url"><?php _e('Button URL (Requires Button Text):', 'sacco-php'); ?></label>
        <input type="url" id="slide_button_url" name="slide_button_url" value="<?php echo esc_attr($slide_button_url); ?>" class="widefat" placeholder="https://example.com/your-page">
    </p>
    <hr>
    <p>
        <label for="slide_link_url"><?php _e('Link Entire Slide To URL (Optional - overrides button if set):', 'sacco-php'); ?></label>
        <input type="url" id="slide_link_url" name="slide_link_url" value="<?php echo esc_attr($slide_link_url); ?>" class="widefat" placeholder="https://example.com/another-page">
        <small><?php _e('If you set this, the entire slide will be a clickable link, and the button above might not be necessary or could be hidden by styling.', 'sacco-php'); ?></small>
    </p>
    <?php
}

function sacco_php_save_slide_meta_box_data($post_id) {
    if (!isset($_POST['sacco_php_slide_meta_box_nonce']) || !wp_verify_nonce($_POST['sacco_php_slide_meta_box_nonce'], 'sacco_php_slide_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'slide' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return; // Not a slide post type
    }

    $fields_to_save = [
        '_slide_button_text' => 'slide_button_text',
        '_slide_button_url' => 'slide_button_url',
        '_slide_link_url' => 'slide_link_url',
    ];

    foreach ($fields_to_save as $meta_key => $post_field_name) {
        if (isset($_POST[$post_field_name])) {
            $value = sanitize_text_field($_POST[$post_field_name]);
            if (strpos($post_field_name, '_url') !== false) { // Basic URL sanitization for URL fields
                $value = esc_url_raw($value);
            }
            if (empty($value)) {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $value);
            }
        } else {
            // If a field is not set in POST (e.g. checkbox unchecked, though not applicable here), delete its meta.
            // For text fields, empty check above handles it, but this is good practice if you add checkboxes/radios.
            // delete_post_meta($post_id, $meta_key);
        }
    }
}
add_action('save_post_slide', 'sacco_php_save_slide_meta_box_data');

// Register Custom Post Type for Testimonials
function sacco_php_register_testimonial_cpt() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Testimonials', 'sacco-php' ),
		'name_admin_bar'        => __( 'Testimonial', 'sacco-php' ),
		'archives'              => __( 'Testimonial Archives', 'sacco-php' ),
		'attributes'            => __( 'Testimonial Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Testimonial:', 'sacco-php' ),
		'all_items'             => __( 'All Testimonials', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Testimonial', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Testimonial', 'sacco-php' ),
		'edit_item'             => __( 'Edit Testimonial', 'sacco-php' ),
		'update_item'           => __( 'Update Testimonial', 'sacco-php' ),
		'view_item'             => __( 'View Testimonial', 'sacco-php' ),
		'view_items'            => __( 'View Testimonials', 'sacco-php' ),
		'search_items'          => __( 'Search Testimonial', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Author Image', 'sacco-php' ), // Optional: for author photo
		'set_featured_image'    => __( 'Set author image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove author image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as author image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into testimonial', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this testimonial', 'sacco-php' ),
		'items_list'            => __( 'Testimonials list', 'sacco-php' ),
		'items_list_navigation' => __( 'Testimonials list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter testimonials list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'sacco-php' ),
		'description'           => __( 'Customer/Member Testimonials', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ), // Title for Author Name, Editor for testimonial text, Thumbnail for author photo
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false, // Usually not public, displayed via carousel
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6, // Below Slides
		'menu_icon'             => 'dashicons-testimonial',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'testimonial', $args );

}
add_action( 'init', 'sacco_php_register_testimonial_cpt', 0 );

// Register Custom Post Type for Partners
function sacco_php_register_partner_cpt() {

	$labels = array(
		'name'                  => _x( 'Partners', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Partner', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Partners', 'sacco-php' ),
		'name_admin_bar'        => __( 'Partner', 'sacco-php' ),
		'archives'              => __( 'Partner Archives', 'sacco-php' ),
		'attributes'            => __( 'Partner Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Partner:', 'sacco-php' ),
		'all_items'             => __( 'All Partners', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Partner', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Partner', 'sacco-php' ),
		'edit_item'             => __( 'Edit Partner', 'sacco-php' ),
		'update_item'           => __( 'Update Partner', 'sacco-php' ),
		'view_item'             => __( 'View Partner', 'sacco-php' ),
		'view_items'            => __( 'View Partners', 'sacco-php' ),
		'search_items'          => __( 'Search Partner', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Partner Logo', 'sacco-php' ),
		'set_featured_image'    => __( 'Set partner logo', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove partner logo', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as partner logo', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into partner', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this partner', 'sacco-php' ),
		'items_list'            => __( 'Partners list', 'sacco-php' ),
		'items_list_navigation' => __( 'Partners list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter partners list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Partner', 'sacco-php' ),
		'description'           => __( 'Partner logos and links', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'page-attributes' ), // Title for internal name, Thumbnail for Logo
		'taxonomies'            => array(), // Could add categories like 'Award', 'Partner' later
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 7, // Below Testimonials
		'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'partner', $args );

}
add_action( 'init', 'sacco_php_register_partner_cpt', 0 );

// Register Custom Post Type for Products
function sacco_php_register_product_cpt() {

	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Products', 'sacco-php' ),
		'name_admin_bar'        => __( 'Product', 'sacco-php' ),
		'archives'              => __( 'Product Archives', 'sacco-php' ),
		'attributes'            => __( 'Product Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Product:', 'sacco-php' ),
		'all_items'             => __( 'All Products', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Product', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Product', 'sacco-php' ),
		'edit_item'             => __( 'Edit Product', 'sacco-php' ),
		'update_item'           => __( 'Update Product', 'sacco-php' ),
		'view_item'             => __( 'View Product', 'sacco-php' ),
		'view_items'            => __( 'View Products', 'sacco-php' ),
		'search_items'          => __( 'Search Product', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Product Image', 'sacco-php' ),
		'set_featured_image'    => __( 'Set product image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove product image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as product image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into product', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this product', 'sacco-php' ),
		'items_list'            => __( 'Products list', 'sacco-php' ),
		'items_list_navigation' => __( 'Products list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter products list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Product', 'sacco-php' ),
		'description'           => __( 'SACCO financial products and services', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'taxonomies'            => array( 'product_category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 8,
		'menu_icon'             => 'dashicons-money-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'product', $args );

}
add_action( 'init', 'sacco_php_register_product_cpt', 0 );

// Register Product Category taxonomy
function sacco_php_register_product_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'sacco-php' ),
		'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'sacco-php' ),
		'menu_name'                  => __( 'Product Categories', 'sacco-php' ),
		'all_items'                  => __( 'All Product Categories', 'sacco-php' ),
		'parent_item'                => __( 'Parent Product Category', 'sacco-php' ),
		'parent_item_colon'          => __( 'Parent Product Category:', 'sacco-php' ),
		'new_item_name'              => __( 'New Product Category Name', 'sacco-php' ),
		'add_new_item'               => __( 'Add New Product Category', 'sacco-php' ),
		'edit_item'                  => __( 'Edit Product Category', 'sacco-php' ),
		'update_item'                => __( 'Update Product Category', 'sacco-php' ),
		'view_item'                  => __( 'View Product Category', 'sacco-php' ),
		'separate_items_with_commas' => __( 'Separate product categories with commas', 'sacco-php' ),
		'add_or_remove_items'        => __( 'Add or remove product categories', 'sacco-php' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sacco-php' ),
		'popular_items'              => __( 'Popular Product Categories', 'sacco-php' ),
		'search_items'               => __( 'Search Product Categories', 'sacco-php' ),
		'not_found'                  => __( 'Not Found', 'sacco-php' ),
		'no_terms'                   => __( 'No product categories', 'sacco-php' ),
		'items_list'                 => __( 'Product Categories list', 'sacco-php' ),
		'items_list_navigation'      => __( 'Product Categories list navigation', 'sacco-php' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'product_category', array( 'product' ), $args );

}
add_action( 'init', 'sacco_php_register_product_category_taxonomy', 0 );

// Register Custom Post Type for Awards
function sacco_php_register_award_cpt() {

	$labels = array(
		'name'                  => _x( 'Awards', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Award', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Awards', 'sacco-php' ),
		'name_admin_bar'        => __( 'Award', 'sacco-php' ),
		'archives'              => __( 'Award Archives', 'sacco-php' ),
		'attributes'            => __( 'Award Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Award:', 'sacco-php' ),
		'all_items'             => __( 'All Awards', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Award', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Award', 'sacco-php' ),
		'edit_item'             => __( 'Edit Award', 'sacco-php' ),
		'update_item'           => __( 'Update Award', 'sacco-php' ),
		'view_item'             => __( 'View Award', 'sacco-php' ),
		'view_items'            => __( 'View Awards', 'sacco-php' ),
		'search_items'          => __( 'Search Award', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Award Image', 'sacco-php' ),
		'set_featured_image'    => __( 'Set award image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove award image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as award image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into award', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this award', 'sacco-php' ),
		'items_list'            => __( 'Awards list', 'sacco-php' ),
		'items_list_navigation' => __( 'Awards list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter awards list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Award', 'sacco-php' ),
		'description'           => __( 'SACCO awards and recognitions', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 9,
		'menu_icon'             => 'dashicons-awards',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'award', $args );

}
add_action( 'init', 'sacco_php_register_award_cpt', 0 );

// Register Custom Post Type for FAQs
function sacco_php_register_faq_cpt() {

	$labels = array(
		'name'                  => _x( 'FAQs', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'FAQ', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'FAQs', 'sacco-php' ),
		'name_admin_bar'        => __( 'FAQ', 'sacco-php' ),
		'archives'              => __( 'FAQ Archives', 'sacco-php' ),
		'attributes'            => __( 'FAQ Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent FAQ:', 'sacco-php' ),
		'all_items'             => __( 'All FAQs', 'sacco-php' ),
		'add_new_item'          => __( 'Add New FAQ', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New FAQ', 'sacco-php' ),
		'edit_item'             => __( 'Edit FAQ', 'sacco-php' ),
		'update_item'           => __( 'Update FAQ', 'sacco-php' ),
		'view_item'             => __( 'View FAQ', 'sacco-php' ),
		'view_items'            => __( 'View FAQs', 'sacco-php' ),
		'search_items'          => __( 'Search FAQ', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'FAQ Image', 'sacco-php' ),
		'set_featured_image'    => __( 'Set FAQ image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove FAQ image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as FAQ image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into FAQ', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this FAQ', 'sacco-php' ),
		'items_list'            => __( 'FAQs list', 'sacco-php' ),
		'items_list_navigation' => __( 'FAQs list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter FAQs list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'FAQ', 'sacco-php' ),
		'description'           => __( 'Frequently Asked Questions', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'page-attributes' ),
		'taxonomies'            => array( 'faq_category' ),
		'hierarchical'          => false,
		'public'                => true, // Changed from false
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-editor-help',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => 'faqs', // Changed from false
		'exclude_from_search'   => false,
		'publicly_queryable'    => true, // Changed from false
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'faq', $args );

}
add_action( 'init', 'sacco_php_register_faq_cpt', 0 );

// Register FAQ Category taxonomy
function sacco_php_register_faq_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'FAQ Categories', 'Taxonomy General Name', 'sacco-php' ),
		'singular_name'              => _x( 'FAQ Category', 'Taxonomy Singular Name', 'sacco-php' ),
		'menu_name'                  => __( 'FAQ Categories', 'sacco-php' ),
		'all_items'                  => __( 'All FAQ Categories', 'sacco-php' ),
		'parent_item'                => __( 'Parent FAQ Category', 'sacco-php' ),
		'parent_item_colon'          => __( 'Parent FAQ Category:', 'sacco-php' ),
		'new_item_name'              => __( 'New FAQ Category Name', 'sacco-php' ),
		'add_new_item'               => __( 'Add New FAQ Category', 'sacco-php' ),
		'edit_item'                  => __( 'Edit FAQ Category', 'sacco-php' ),
		'update_item'                => __( 'Update FAQ Category', 'sacco-php' ),
		'view_item'                  => __( 'View FAQ Category', 'sacco-php' ),
		'separate_items_with_commas' => __( 'Separate FAQ categories with commas', 'sacco-php' ),
		'add_or_remove_items'        => __( 'Add or remove FAQ categories', 'sacco-php' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sacco-php' ),
		'popular_items'              => __( 'Popular FAQ Categories', 'sacco-php' ),
		'search_items'               => __( 'Search FAQ Categories', 'sacco-php' ),
		'not_found'                  => __( 'Not Found', 'sacco-php' ),
		'no_terms'                   => __( 'No FAQ categories', 'sacco-php' ),
		'items_list'                 => __( 'FAQ Categories list', 'sacco-php' ),
		'items_list_navigation'      => __( 'FAQ Categories list navigation', 'sacco-php' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'faq_category', array( 'faq' ), $args );

}
add_action( 'init', 'sacco_php_register_faq_category_taxonomy', 0 );

// Register Custom Post Type for Downloads
function sacco_php_register_download_cpt() {

	$labels = array(
		'name'                  => _x( 'Downloads', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Download', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Downloads', 'sacco-php' ),
		'name_admin_bar'        => __( 'Download', 'sacco-php' ),
		'archives'              => __( 'Download Archives', 'sacco-php' ),
		'attributes'            => __( 'Download Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Download:', 'sacco-php' ),
		'all_items'             => __( 'All Downloads', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Download', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Download', 'sacco-php' ),
		'edit_item'             => __( 'Edit Download', 'sacco-php' ),
		'update_item'           => __( 'Update Download', 'sacco-php' ),
		'view_item'             => __( 'View Download', 'sacco-php' ),
		'view_items'            => __( 'View Downloads', 'sacco-php' ),
		'search_items'          => __( 'Search Download', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Download Thumbnail', 'sacco-php' ),
		'set_featured_image'    => __( 'Set download thumbnail', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove download thumbnail', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as download thumbnail', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into download', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this download', 'sacco-php' ),
		'items_list'            => __( 'Downloads list', 'sacco-php' ),
		'items_list_navigation' => __( 'Downloads list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter downloads list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Download', 'sacco-php' ),
		'description'           => __( 'Downloadable resources like forms, bylaws, reports', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ), // Added 'custom-fields'
		'taxonomies'            => array( 'resource_type' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 11,
		'menu_icon'             => 'dashicons-media-document',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'download', $args );

}
add_action( 'init', 'sacco_php_register_download_cpt', 0 );

// Register Resource Type taxonomy
function sacco_php_register_resource_type_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Resource Types', 'Taxonomy General Name', 'sacco-php' ),
		'singular_name'              => _x( 'Resource Type', 'Taxonomy Singular Name', 'sacco-php' ),
		'menu_name'                  => __( 'Resource Types', 'sacco-php' ),
		'all_items'                  => __( 'All Resource Types', 'sacco-php' ),
		'parent_item'                => __( 'Parent Resource Type', 'sacco-php' ),
		'parent_item_colon'          => __( 'Parent Resource Type:', 'sacco-php' ),
		'new_item_name'              => __( 'New Resource Type Name', 'sacco-php' ),
		'add_new_item'               => __( 'Add New Resource Type', 'sacco-php' ),
		'edit_item'                  => __( 'Edit Resource Type', 'sacco-php' ),
		'update_item'                => __( 'Update Resource Type', 'sacco-php' ),
		'view_item'                  => __( 'View Resource Type', 'sacco-php' ),
		'separate_items_with_commas' => __( 'Separate resource types with commas', 'sacco-php' ),
		'add_or_remove_items'        => __( 'Add or remove resource types', 'sacco-php' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sacco-php' ),
		'popular_items'              => __( 'Popular Resource Types', 'sacco-php' ),
		'search_items'               => __( 'Search Resource Types', 'sacco-php' ),
		'not_found'                  => __( 'Not Found', 'sacco-php' ),
		'no_terms'                   => __( 'No resource types', 'sacco-php' ),
		'items_list'                 => __( 'Resource Types list', 'sacco-php' ),
		'items_list_navigation'      => __( 'Resource Types list navigation', 'sacco-php' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'resource_type', array( 'download' ), $args );

}
add_action( 'init', 'sacco_php_register_resource_type_taxonomy', 0 );

/**
 * Register Savings Custom Post Type
 */
function sacco_php_register_savings_cpt() {
    $labels = array(
        'name'                  => _x( 'Savings Products', 'Post Type General Name', 'sacco-php' ),
        'singular_name'         => _x( 'Savings Product', 'Post Type Singular Name', 'sacco-php' ),
        'menu_name'             => __( 'Savings Products', 'sacco-php' ),
        'name_admin_bar'        => __( 'Savings Product', 'sacco-php' ),
        'archives'              => __( 'Savings Product Archives', 'sacco-php' ),
        'attributes'            => __( 'Savings Product Attributes', 'sacco-php' ),
        'parent_item_colon'     => __( 'Parent Savings Product:', 'sacco-php' ),
        'all_items'             => __( 'All Savings Products', 'sacco-php' ),
        'add_new_item'          => __( 'Add New Savings Product', 'sacco-php' ),
        'add_new'               => __( 'Add New', 'sacco-php' ),
        'new_item'              => __( 'New Savings Product', 'sacco-php' ),
        'edit_item'             => __( 'Edit Savings Product', 'sacco-php' ),
        'update_item'           => __( 'Update Savings Product', 'sacco-php' ),
        'view_item'             => __( 'View Savings Product', 'sacco-php' ),
        'view_items'            => __( 'View Savings Products', 'sacco-php' ),
        'search_items'          => __( 'Search Savings Product', 'sacco-php' ),
        'not_found'             => __( 'Not found', 'sacco-php' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
        'featured_image'        => __( 'Featured Image', 'sacco-php' ),
        'set_featured_image'    => __( 'Set featured image', 'sacco-php' ),
        'remove_featured_image' => __( 'Remove featured image', 'sacco-php' ),
        'use_featured_image'    => __( 'Use as featured image', 'sacco-php' ),
        'insert_into_item'      => __( 'Insert into savings product', 'sacco-php' ),
        'uploaded_to_this_item' => __( 'Uploaded to this savings product', 'sacco-php' ),
        'items_list'            => __( 'Savings Products list', 'sacco-php' ),
        'items_list_navigation' => __( 'Savings Products list navigation', 'sacco-php' ),
        'filter_items_list'     => __( 'Filter savings products list', 'sacco-php' ),
    );
    $args = array(
        'label'                 => __( 'Savings Product', 'sacco-php' ),
        'description'           => __( 'Savings products and accounts', 'sacco-php' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'savings_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-piggy-bank',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'savings',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'savings-product' ),
    );
    register_post_type( 'savings', $args );
}
add_action( 'init', 'sacco_php_register_savings_cpt', 0 );

/**
 * Register Savings Category Taxonomy
 */
function sacco_php_register_savings_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Savings Categories', 'Taxonomy General Name', 'sacco-php' ),
        'singular_name'              => _x( 'Savings Category', 'Taxonomy Singular Name', 'sacco-php' ),
        'menu_name'                  => __( 'Savings Categories', 'sacco-php' ),
        'all_items'                  => __( 'All Savings Categories', 'sacco-php' ),
        'parent_item'                => __( 'Parent Savings Category', 'sacco-php' ),
        'parent_item_colon'          => __( 'Parent Savings Category:', 'sacco-php' ),
        'new_item_name'              => __( 'New Savings Category Name', 'sacco-php' ),
        'add_new_item'               => __( 'Add New Savings Category', 'sacco-php' ),
        'edit_item'                  => __( 'Edit Savings Category', 'sacco-php' ),
        'update_item'                => __( 'Update Savings Category', 'sacco-php' ),
        'view_item'                  => __( 'View Savings Category', 'sacco-php' ),
        'separate_items_with_commas' => __( 'Separate savings categories with commas', 'sacco-php' ),
        'add_or_remove_items'        => __( 'Add or remove savings categories', 'sacco-php' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sacco-php' ),
        'popular_items'              => __( 'Popular Savings Categories', 'sacco-php' ),
        'search_items'               => __( 'Search Savings Categories', 'sacco-php' ),
        'not_found'                  => __( 'Not Found', 'sacco-php' ),
        'no_terms'                   => __( 'No savings categories', 'sacco-php' ),
        'items_list'                 => __( 'Savings Categories list', 'sacco-php' ),
        'items_list_navigation'      => __( 'Savings Categories list navigation', 'sacco-php' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'savings_category', array( 'savings' ), $args );
}
add_action( 'init', 'sacco_php_register_savings_category_taxonomy', 0 );

// Register Custom Post Type for Board of Directors
function sacco_php_register_board_director_cpt() {

	$labels = array(
		'name'                  => _x( 'Board of Directors', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Board Member', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Board of Directors', 'sacco-php' ),
		'name_admin_bar'        => __( 'Board Member', 'sacco-php' ),
		'archives'              => __( 'Board Member Archives', 'sacco-php' ),
		'attributes'            => __( 'Board Member Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Board Member:', 'sacco-php' ),
		'all_items'             => __( 'All Board Members', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Board Member', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Board Member', 'sacco-php' ),
		'edit_item'             => __( 'Edit Board Member', 'sacco-php' ),
		'update_item'           => __( 'Update Board Member', 'sacco-php' ),
		'view_item'             => __( 'View Board Member', 'sacco-php' ),
		'view_items'            => __( 'View Board Members', 'sacco-php' ),
		'search_items'          => __( 'Search Board Member', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Board Member Photo', 'sacco-php' ),
		'set_featured_image'    => __( 'Set board member photo', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove board member photo', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as board member photo', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into board member', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this board member', 'sacco-php' ),
		'items_list'            => __( 'Board Members list', 'sacco-php' ),
		'items_list_navigation' => __( 'Board Members list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter board members list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Board Member', 'sacco-php' ),
		'description'           => __( 'Board of Directors members', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 12,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'board_director', $args );

}
add_action( 'init', 'sacco_php_register_board_director_cpt', 0 );

// Meta Boxes for Board Director CPT
function sacco_php_register_board_director_meta_boxes() {
    add_meta_box(
        'board_director_details_meta_box',
        __('Board Member Details', 'sacco-php'),
        'sacco_php_board_director_meta_box_callback',
        'board_director',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_board_director', 'sacco_php_register_board_director_meta_boxes');

function sacco_php_board_director_meta_box_callback($post) {
    wp_nonce_field('sacco_php_board_director_meta_box', 'sacco_php_board_director_meta_box_nonce');

    $position = get_post_meta($post->ID, '_board_position', true);
    $qualifications = get_post_meta($post->ID, '_qualifications', true);
    $experience = get_post_meta($post->ID, '_experience', true);
    $linkedin = get_post_meta($post->ID, '_linkedin_url', true);
    $email = get_post_meta($post->ID, '_email', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $tenure_start = get_post_meta($post->ID, '_tenure_start', true);
    $tenure_end = get_post_meta($post->ID, '_tenure_end', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="board_position"><?php _e('Position:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="board_position" name="board_position" value="<?php echo esc_attr($position); ?>" class="widefat" placeholder="e.g., Chairman, Vice Chairman, Secretary"></td>
        </tr>
        <tr>
            <th><label for="qualifications"><?php _e('Qualifications:', 'sacco-php'); ?></label></th>
            <td><textarea id="qualifications" name="qualifications" class="widefat" rows="3" placeholder="Educational background and professional qualifications"><?php echo esc_textarea($qualifications); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="experience"><?php _e('Experience:', 'sacco-php'); ?></label></th>
            <td><textarea id="experience" name="experience" class="widefat" rows="4" placeholder="Professional experience and expertise"><?php echo esc_textarea($experience); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="email"><?php _e('Email:', 'sacco-php'); ?></label></th>
            <td><input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" class="widefat" placeholder="email@example.com"></td>
        </tr>
        <tr>
            <th><label for="phone"><?php _e('Phone:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" class="widefat" placeholder="+254 700 000 000"></td>
        </tr>
        <tr>
            <th><label for="linkedin_url"><?php _e('LinkedIn URL:', 'sacco-php'); ?></label></th>
            <td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr($linkedin); ?>" class="widefat" placeholder="https://linkedin.com/in/username"></td>
        </tr>
        <tr>
            <th><label for="tenure_start"><?php _e('Tenure Start:', 'sacco-php'); ?></label></th>
            <td><input type="date" id="tenure_start" name="tenure_start" value="<?php echo esc_attr($tenure_start); ?>" class="widefat"></td>
        </tr>
        <tr>
            <th><label for="tenure_end"><?php _e('Tenure End (Optional):', 'sacco-php'); ?></label></th>
            <td><input type="date" id="tenure_end" name="tenure_end" value="<?php echo esc_attr($tenure_end); ?>" class="widefat"></td>
        </tr>
    </table>
    <?php
}

function sacco_php_save_board_director_meta_box_data($post_id) {
    if (!isset($_POST['sacco_php_board_director_meta_box_nonce']) || !wp_verify_nonce($_POST['sacco_php_board_director_meta_box_nonce'], 'sacco_php_board_director_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'board_director' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return;
    }

    $fields_to_save = [
        '_board_position' => 'board_position',
        '_qualifications' => 'qualifications',
        '_experience' => 'experience',
        '_email' => 'email',
        '_phone' => 'phone',
        '_linkedin_url' => 'linkedin_url',
        '_tenure_start' => 'tenure_start',
        '_tenure_end' => 'tenure_end',
    ];

    foreach ($fields_to_save as $meta_key => $post_field_name) {
        if (isset($_POST[$post_field_name])) {
            $value = $_POST[$post_field_name];
            
            if (in_array($post_field_name, ['qualifications', 'experience'])) {
                $sanitized_value = sanitize_textarea_field($value);
            } elseif (in_array($post_field_name, ['linkedin_url'])) {
                $sanitized_value = esc_url_raw($value);
            } elseif (in_array($post_field_name, ['email'])) {
                $sanitized_value = sanitize_email($value);
            } else {
                $sanitized_value = sanitize_text_field($value);
            }
            
            if (empty($sanitized_value)) {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $sanitized_value);
            }
        }
    }
}
add_action('save_post_board_director', 'sacco_php_save_board_director_meta_box_data');

// Register Custom Post Type for Management Team
function sacco_php_register_management_team_cpt() {

	$labels = array(
		'name'                  => _x( 'Management Team', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Management Member', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Management Team', 'sacco-php' ),
		'name_admin_bar'        => __( 'Management Member', 'sacco-php' ),
		'archives'              => __( 'Management Member Archives', 'sacco-php' ),
		'attributes'            => __( 'Management Member Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Management Member:', 'sacco-php' ),
		'all_items'             => __( 'All Management Members', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Management Member', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Management Member', 'sacco-php' ),
		'edit_item'             => __( 'Edit Management Member', 'sacco-php' ),
		'update_item'           => __( 'Update Management Member', 'sacco-php' ),
		'view_item'             => __( 'View Management Member', 'sacco-php' ),
		'view_items'            => __( 'View Management Members', 'sacco-php' ),
		'search_items'          => __( 'Search Management Member', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Management Member Photo', 'sacco-php' ),
		'set_featured_image'    => __( 'Set management member photo', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove management member photo', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as management member photo', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into management member', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this management member', 'sacco-php' ),
		'items_list'            => __( 'Management Members list', 'sacco-php' ),
		'items_list_navigation' => __( 'Management Members list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter management members list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Management Member', 'sacco-php' ),
		'description'           => __( 'Management team members', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 13,
		'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'management_team', $args );

}
add_action( 'init', 'sacco_php_register_management_team_cpt', 0 );

// Register Custom Post Type for Supervisory Committee
function sacco_php_register_supervisory_committee_cpt() {

	$labels = array(
		'name'                  => _x( 'Supervisory Committee', 'Post Type General Name', 'sacco-php' ),
		'singular_name'         => _x( 'Committee Member', 'Post Type Singular Name', 'sacco-php' ),
		'menu_name'             => __( 'Supervisory Committee', 'sacco-php' ),
		'name_admin_bar'        => __( 'Committee Member', 'sacco-php' ),
		'archives'              => __( 'Committee Member Archives', 'sacco-php' ),
		'attributes'            => __( 'Committee Member Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Committee Member:', 'sacco-php' ),
		'all_items'             => __( 'All Committee Members', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Committee Member', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Committee Member', 'sacco-php' ),
		'edit_item'             => __( 'Edit Committee Member', 'sacco-php' ),
		'update_item'           => __( 'Update Committee Member', 'sacco-php' ),
		'view_item'             => __( 'View Committee Member', 'sacco-php' ),
		'view_items'            => __( 'View Committee Members', 'sacco-php' ),
		'search_items'          => __( 'Search Committee Member', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Committee Member Photo', 'sacco-php' ),
		'set_featured_image'    => __( 'Set committee member photo', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove committee member photo', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as committee member photo', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into committee member', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this committee member', 'sacco-php' ),
		'items_list'            => __( 'Committee Members list', 'sacco-php' ),
		'items_list_navigation' => __( 'Committee Members list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter committee members list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Committee Member', 'sacco-php' ),
		'description'           => __( 'Supervisory committee members', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 14,
		'menu_icon'             => 'dashicons-search',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'supervisory_committee', $args );

}
add_action( 'init', 'sacco_php_register_supervisory_committee_cpt', 0 );

// Meta Boxes for Management Team CPT
function sacco_php_register_management_team_meta_boxes() {
    add_meta_box(
        'management_team_details_meta_box',
        __('Management Team Member Details', 'sacco-php'),
        'sacco_php_management_team_meta_box_callback',
        'management_team',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_management_team', 'sacco_php_register_management_team_meta_boxes');

function sacco_php_management_team_meta_box_callback($post) {
    wp_nonce_field('sacco_php_management_team_meta_box', 'sacco_php_management_team_meta_box_nonce');

    $position = get_post_meta($post->ID, '_management_position', true);
    $department = get_post_meta($post->ID, '_department', true);
    $qualifications = get_post_meta($post->ID, '_qualifications', true);
    $experience = get_post_meta($post->ID, '_experience', true);
    $responsibilities = get_post_meta($post->ID, '_responsibilities', true);
    $linkedin = get_post_meta($post->ID, '_linkedin_url', true);
    $email = get_post_meta($post->ID, '_email', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $join_date = get_post_meta($post->ID, '_join_date', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="management_position"><?php _e('Position:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="management_position" name="management_position" value="<?php echo esc_attr($position); ?>" class="widefat" placeholder="e.g., Chief Executive Officer, General Manager"></td>
        </tr>
        <tr>
            <th><label for="department"><?php _e('Department:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="department" name="department" value="<?php echo esc_attr($department); ?>" class="widefat" placeholder="e.g., Executive, Finance, Operations"></td>
        </tr>
        <tr>
            <th><label for="qualifications"><?php _e('Qualifications:', 'sacco-php'); ?></label></th>
            <td><textarea id="qualifications" name="qualifications" class="widefat" rows="3" placeholder="Educational background and professional qualifications"><?php echo esc_textarea($qualifications); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="experience"><?php _e('Experience:', 'sacco-php'); ?></label></th>
            <td><textarea id="experience" name="experience" class="widefat" rows="4" placeholder="Professional experience and expertise"><?php echo esc_textarea($experience); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="responsibilities"><?php _e('Key Responsibilities:', 'sacco-php'); ?></label></th>
            <td><textarea id="responsibilities" name="responsibilities" class="widefat" rows="4" placeholder="Main responsibilities and duties"><?php echo esc_textarea($responsibilities); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="email"><?php _e('Email:', 'sacco-php'); ?></label></th>
            <td><input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" class="widefat" placeholder="email@example.com"></td>
        </tr>
        <tr>
            <th><label for="phone"><?php _e('Phone:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" class="widefat" placeholder="+254 700 000 000"></td>
        </tr>
        <tr>
            <th><label for="linkedin_url"><?php _e('LinkedIn URL:', 'sacco-php'); ?></label></th>
            <td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr($linkedin); ?>" class="widefat" placeholder="https://linkedin.com/in/username"></td>
        </tr>
        <tr>
            <th><label for="join_date"><?php _e('Join Date:', 'sacco-php'); ?></label></th>
            <td><input type="date" id="join_date" name="join_date" value="<?php echo esc_attr($join_date); ?>" class="widefat"></td>
        </tr>
    </table>
    <?php
}

function sacco_php_save_management_team_meta_box_data($post_id) {
    if (!isset($_POST['sacco_php_management_team_meta_box_nonce']) || !wp_verify_nonce($_POST['sacco_php_management_team_meta_box_nonce'], 'sacco_php_management_team_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'management_team' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return;
    }

    $fields_to_save = [
        '_management_position' => 'management_position',
        '_department' => 'department',
        '_qualifications' => 'qualifications',
        '_experience' => 'experience',
        '_responsibilities' => 'responsibilities',
        '_email' => 'email',
        '_phone' => 'phone',
        '_linkedin_url' => 'linkedin_url',
        '_join_date' => 'join_date',
    ];

    foreach ($fields_to_save as $meta_key => $post_field_name) {
        if (isset($_POST[$post_field_name])) {
            $value = $_POST[$post_field_name];
            
            if (in_array($post_field_name, ['qualifications', 'experience', 'responsibilities'])) {
                $sanitized_value = sanitize_textarea_field($value);
            } elseif (in_array($post_field_name, ['linkedin_url'])) {
                $sanitized_value = esc_url_raw($value);
            } elseif (in_array($post_field_name, ['email'])) {
                $sanitized_value = sanitize_email($value);
            } else {
                $sanitized_value = sanitize_text_field($value);
            }
            
            if (empty($sanitized_value)) {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $sanitized_value);
            }
        }
    }
}
add_action('save_post_management_team', 'sacco_php_save_management_team_meta_box_data');

// Meta Boxes for Supervisory Committee CPT
function sacco_php_register_supervisory_committee_meta_boxes() {
    add_meta_box(
        'supervisory_committee_details_meta_box',
        __('Supervisory Committee Member Details', 'sacco-php'),
        'sacco_php_supervisory_committee_meta_box_callback',
        'supervisory_committee',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_supervisory_committee', 'sacco_php_register_supervisory_committee_meta_boxes');

function sacco_php_supervisory_committee_meta_box_callback($post) {
    wp_nonce_field('sacco_php_supervisory_committee_meta_box', 'sacco_php_supervisory_committee_meta_box_nonce');

    $position = get_post_meta($post->ID, '_committee_position', true);
    $qualifications = get_post_meta($post->ID, '_qualifications', true);
    $experience = get_post_meta($post->ID, '_experience', true);
    $responsibilities = get_post_meta($post->ID, '_responsibilities', true);
    $linkedin = get_post_meta($post->ID, '_linkedin_url', true);
    $email = get_post_meta($post->ID, '_email', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $tenure_start = get_post_meta($post->ID, '_tenure_start', true);
    $tenure_end = get_post_meta($post->ID, '_tenure_end', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="committee_position"><?php _e('Position:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="committee_position" name="committee_position" value="<?php echo esc_attr($position); ?>" class="widefat" placeholder="e.g., Chairman, Vice Chairman, Secretary"></td>
        </tr>
        <tr>
            <th><label for="qualifications"><?php _e('Qualifications:', 'sacco-php'); ?></label></th>
            <td><textarea id="qualifications" name="qualifications" class="widefat" rows="3" placeholder="Educational background and professional qualifications"><?php echo esc_textarea($qualifications); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="experience"><?php _e('Experience:', 'sacco-php'); ?></label></th>
            <td><textarea id="experience" name="experience" class="widefat" rows="4" placeholder="Professional experience and expertise"><?php echo esc_textarea($experience); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="responsibilities"><?php _e('Key Responsibilities:', 'sacco-php'); ?></label></th>
            <td><textarea id="responsibilities" name="responsibilities" class="widefat" rows="4" placeholder="Main responsibilities and duties in the committee"><?php echo esc_textarea($responsibilities); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="email"><?php _e('Email:', 'sacco-php'); ?></label></th>
            <td><input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" class="widefat" placeholder="email@example.com"></td>
        </tr>
        <tr>
            <th><label for="phone"><?php _e('Phone:', 'sacco-php'); ?></label></th>
            <td><input type="text" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" class="widefat" placeholder="+254 700 000 000"></td>
        </tr>
        <tr>
            <th><label for="linkedin_url"><?php _e('LinkedIn URL:', 'sacco-php'); ?></label></th>
            <td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr($linkedin); ?>" class="widefat" placeholder="https://linkedin.com/in/username"></td>
        </tr>
        <tr>
            <th><label for="tenure_start"><?php _e('Tenure Start:', 'sacco-php'); ?></label></th>
            <td><input type="date" id="tenure_start" name="tenure_start" value="<?php echo esc_attr($tenure_start); ?>" class="widefat"></td>
        </tr>
        <tr>
            <th><label for="tenure_end"><?php _e('Tenure End (Optional):', 'sacco-php'); ?></label></th>
            <td><input type="date" id="tenure_end" name="tenure_end" value="<?php echo esc_attr($tenure_end); ?>" class="widefat"></td>
        </tr>
    </table>
    <?php
}

function sacco_php_save_supervisory_committee_meta_box_data($post_id) {
    if (!isset($_POST['sacco_php_supervisory_committee_meta_box_nonce']) || !wp_verify_nonce($_POST['sacco_php_supervisory_committee_meta_box_nonce'], 'sacco_php_supervisory_committee_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'supervisory_committee' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return;
    }

    $fields_to_save = [
        '_committee_position' => 'committee_position',
        '_qualifications' => 'qualifications',
        '_experience' => 'experience',
        '_responsibilities' => 'responsibilities',
        '_email' => 'email',
        '_phone' => 'phone',
        '_linkedin_url' => 'linkedin_url',
        '_tenure_start' => 'tenure_start',
        '_tenure_end' => 'tenure_end',
    ];

    foreach ($fields_to_save as $meta_key => $post_field_name) {
        if (isset($_POST[$post_field_name])) {
            $value = $_POST[$post_field_name];
            
            if (in_array($post_field_name, ['qualifications', 'experience', 'responsibilities'])) {
                $sanitized_value = sanitize_textarea_field($value);
            } elseif (in_array($post_field_name, ['linkedin_url'])) {
                $sanitized_value = esc_url_raw($value);
            } elseif (in_array($post_field_name, ['email'])) {
                $sanitized_value = sanitize_email($value);
            } else {
                $sanitized_value = sanitize_text_field($value);
            }
            
            if (empty($sanitized_value)) {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $sanitized_value);
            }
        }
    }
}
add_action('save_post_supervisory_committee', 'sacco_php_save_supervisory_committee_meta_box_data');

/**
 * Enqueue scripts and styles for member portal, savings, and loans.
 */
function sacco_php_enqueue_member_portal_scripts() {
    // Register and enqueue member portal CSS if on member portal pages
    if (is_page(array('member-dashboard', 'member-loans', 'member-savings', 'member-profile', 'member-transactions', 'login'))) {
        wp_enqueue_style('sacco-php-member-portal', get_template_directory_uri() . '/assets/css/member-portal.css', array(), _S_VERSION);
    }
    
    // Register and enqueue savings CSS if on savings related pages
    if (is_post_type_archive('savings') || is_singular('savings') || is_tax('savings_category') || is_page('savings-calculator')) {
        wp_enqueue_style('sacco-php-savings', get_template_directory_uri() . '/assets/css/savings.css', array(), _S_VERSION);
        
        // Enqueue Chart.js if on calculator page
        if (is_page('savings-calculator')) {
            wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array('jquery'), '3.9.1', true);
            wp_enqueue_script('sacco-php-savings-calculator', get_template_directory_uri() . '/assets/js/savings-calculator.js', array('jquery', 'chart-js'), _S_VERSION, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'sacco_php_enqueue_member_portal_scripts');

/**
 * Register meta boxes for Savings Products
 */
function sacco_php_register_savings_meta_boxes() {
    add_meta_box(
        'savings_product_details',
        __('Savings Product Details', 'sacco-php'),
        'sacco_php_savings_meta_box_callback',
        'savings',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sacco_php_register_savings_meta_boxes');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function sacco_php_savings_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('sacco_php_savings_meta_box', 'sacco_php_savings_meta_box_nonce');
    
    // Get values
    $interest_rate = get_post_meta($post->ID, 'interest_rate', true);
    $minimum_deposit = get_post_meta($post->ID, 'minimum_deposit', true);
    $term = get_post_meta($post->ID, 'term', true);
    $withdrawal_terms = get_post_meta($post->ID, 'withdrawal_terms', true);
    $target_audience = get_post_meta($post->ID, 'target_audience', true);
    $features = get_post_meta($post->ID, 'features', true);
    $age_limit = get_post_meta($post->ID, '_age_limit', true); // New field
    
    ?>
    <p>
        <label for="interest_rate"><?php _e('Interest Rate:', 'sacco-php'); ?></label>
        <input type="text" id="interest_rate" name="interest_rate" value="<?php echo esc_attr($interest_rate); ?>" class="widefat" placeholder="e.g., 5% p.a.">
    </p>
    <p>
        <label for="minimum_deposit"><?php _e('Minimum Deposit:', 'sacco-php'); ?></label>
        <input type="text" id="minimum_deposit" name="minimum_deposit" value="<?php echo esc_attr($minimum_deposit); ?>" class="widefat" placeholder="e.g., KSh 1,000">
    </p>
    <p>
        <label for="term"><?php _e('Term Period:', 'sacco-php'); ?></label>
        <input type="text" id="term" name="term" value="<?php echo esc_attr($term); ?>" class="widefat" placeholder="e.g., Flexible, 1 Year, 3 Years">
    </p>
    <p>
        <label for="withdrawal_terms"><?php _e('Withdrawal Terms:', 'sacco-php'); ?></label>
        <input type="text" id="withdrawal_terms" name="withdrawal_terms" value="<?php echo esc_attr($withdrawal_terms); ?>" class="widefat" placeholder="e.g., Anytime, After maturity">
    </p>
    <p>
        <label for="target_audience"><?php _e('Target Audience:', 'sacco-php'); ?></label>
        <input type="text" id="target_audience" name="target_audience" value="<?php echo esc_attr($target_audience); ?>" class="widefat" placeholder="e.g., All members, Children, Seniors">
    </p>
    <p>
        <label for="features"><?php _e('Key Features & Benefits (one per line):', 'sacco-php'); ?></label>
        <textarea id="features" name="features" class="widefat" rows="5" placeholder="Enter one feature per line"><?php echo esc_textarea($features); ?></textarea>
    </p>
    <p>
        <label for="age_limit"><?php _e('Age Limit (e.g., for Junior accounts):', 'sacco-php'); ?></label>
        <input type="text" id="age_limit" name="age_limit" value="<?php echo esc_attr($age_limit); ?>" class="widefat" placeholder="e.g., Members below 18 years, No age limit">
    </p>
    <?php
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function sacco_php_save_savings_meta_box_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['sacco_php_savings_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['sacco_php_savings_meta_box_nonce'], 'sacco_php_savings_meta_box')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'savings' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
         if (!current_user_can('edit_page', $post_id)) { // Fallback capability
            return;
        }
    }

    // Sanitize and save the data
    $meta_fields = array(
        'interest_rate',
        'minimum_deposit',
        'term',
        'withdrawal_terms',
        'target_audience',
        'features',
        'age_limit' // New field
    );

    foreach ($meta_fields as $field_name) {
        if (isset($_POST[$field_name])) {
            $value = $_POST[$field_name];
            $meta_key = ($field_name === 'age_limit') ? '_age_limit' : $field_name; // Use underscore for new field

            if ($field_name === 'features') { // Only features is a textarea here
                $sanitized_value = sanitize_textarea_field($value);
            } else {
                $sanitized_value = sanitize_text_field($value);
            }

            if (empty($sanitized_value)) {
                delete_post_meta($post_id, $meta_key);
            } else {
                update_post_meta($post_id, $meta_key, $sanitized_value);
            }
        }
    }
}
add_action('save_post_savings', 'sacco_php_save_savings_meta_box_data');

/**
 * Enqueue Savings and Loans Page Styles
 */
function sacco_php_product_page_styles() {
    // Savings Archive and Single Savings
    if (is_post_type_archive('savings') || is_singular('savings')) {
        wp_enqueue_style('sacco-savings', get_template_directory_uri() . '/assets/css/savings.css', array(), _S_VERSION);
    }
    
    // Loans Archive and Single Loan
    if (is_post_type_archive('loan') || is_singular('loan')) {
        wp_enqueue_style('sacco-loans', get_template_directory_uri() . '/assets/css/loans.css', array(), _S_VERSION);
    }
    
    // About Page
    if (is_page_template('page-about.php')) {
        wp_enqueue_style('sacco-about', get_template_directory_uri() . '/assets/css/about.css', array(), _S_VERSION);
    }
    
    // Credit Policy Page
    if (is_page_template('page-credit-policy.php')) {
        wp_enqueue_style('sacco-credit-policy', get_template_directory_uri() . '/assets/css/page-credit-policy.css', array(), _S_VERSION);
    }
    
    // Enhanced Loan Application Page
    if (is_page_template('page-loan-application-enhanced.php')) {
        wp_enqueue_style('sacco-loan-application-enhanced', get_template_directory_uri() . '/page-loan-application-enhanced.css', array(), _S_VERSION);
    }
    
    // Loan Dashboard Page
    if (is_page_template('page-loan-dashboard.php')) {
        wp_enqueue_style('sacco-loan-dashboard', get_template_directory_uri() . '/page-loan-dashboard.css', array(), _S_VERSION);
    }
    
    // Member Profile Page
    if (is_page_template('page-member-profile.php')) {
        wp_enqueue_style('sacco-member-profile', get_template_directory_uri() . '/assets/css/page-member-profile.css', array(), _S_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'sacco_php_product_page_styles');

// Login and registration handlers moved to includes/login-handler.php

/**
 * Register AJAX actions for member registration
 */
function daystar_register_ajax_actions() {
    add_action('wp_ajax_daystar_register_member', 'daystar_process_registration');
    add_action('wp_ajax_nopriv_daystar_register_member', 'daystar_process_registration');
}
add_action('init', 'daystar_register_ajax_actions');

/**
 * Instructions: Add this code to your theme's functions.php file or create a new plugin with this code
 */
// ///////////////////////////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('sacco_php_posted_on')) :
    function sacco_php_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }
        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );
        echo '<span class="posted-on">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('sacco_php_posted_by')) :
    function sacco_php_posted_by() {
        echo '<span class="byline"> by <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('sacco_php_entry_footer')) :
    function sacco_php_entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            $categories_list = get_the_category_list( esc_html__( ', ', 'sacco-php' ) );
            if ( $categories_list ) {
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'sacco-php' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'sacco-php' ) );
            if ( $tags_list ) {
                printf( ' <span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sacco-php' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }
        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo ' <span class="comments-link">';
            comments_popup_link( esc_html__( 'Leave a comment', 'sacco-php' ), esc_html__( '1 Comment', 'sacco-php' ), esc_html__( '% Comments', 'sacco-php' ) );
            echo '</span>';
        }
        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'sacco-php' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

// Load custom theme functionalities from the includes directory
$theme_includes_path = get_template_directory() . '/includes/';

require_once $theme_includes_path . 'database-setup.php';
require_once $theme_includes_path . 'member-data.php';
require_once $theme_includes_path . 'session-management.php';
require_once $theme_includes_path . 'member-registration.php';
require_once $theme_includes_path . 'member-profile.php';
require_once $theme_includes_path . 'loan-application.php';
require_once $theme_includes_path . 'payment-integration.php';
require_once $theme_includes_path . 'notifications.php';
require_once $theme_includes_path . 'dashboard-notifications.php';
require_once get_template_directory() . '/includes/admin/admin-init.php';

// Admin functionalities
if (is_admin()) {
    require_once $theme_includes_path . 'admin/admin-dashboard.php';
    require_once $theme_includes_path . 'admin/admin-members.php';
    require_once $theme_includes_path . 'admin/admin-loans.php';
    require_once $theme_includes_path . 'admin/admin-settings.php';
}

// Include core functionality files
require_once $theme_includes_path . 'member-documents.php';
require_once $theme_includes_path . 'member-registration.php';

/**
 * Handle Product Enquiry Form Submission
 */
function sacco_handle_product_enquiry() {
    // Verify nonce
    if ( ! isset( $_POST['enquiry_nonce'] ) || ! wp_verify_nonce( $_POST['enquiry_nonce'], 'product_enquiry_form_nonce' ) ) {
        $redirect_url = isset($_POST['product_id']) ? get_permalink( absint($_POST['product_id']) ) : home_url();
        wp_safe_redirect( add_query_arg(array('form_status' => 'nonce_error', 'modal' => 'productEnquiryModal'), $redirect_url ) );
        exit;
    }    // Sanitize POST data
    $name = isset( $_POST['enquiry_name'] ) ? sanitize_text_field( $_POST['enquiry_name'] ) : '';
    $email = isset( $_POST['enquiry_email'] ) ? sanitize_email( $_POST['enquiry_email'] ) : '';
    $phone = isset( $_POST['enquiry_phone'] ) ? sanitize_text_field( $_POST['enquiry_phone'] ) : '';
    $message = isset( $_POST['enquiry_message'] ) ? sanitize_textarea_field( $_POST['enquiry_message'] ) : '';
    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $product_title = isset( $_POST['product_title'] ) ? sanitize_text_field( $_POST['product_title'] ) : 'N/A';

    // Basic validation
    if ( empty( $name ) || empty( $email ) || empty( $message ) || ! is_email( $email ) || empty( $product_id ) ) {
        $redirect_url = $product_id ? get_permalink( $product_id ) : home_url();
        wp_safe_redirect( add_query_arg(array('form_status' => 'validation_error', 'modal' => 'productEnquiryModal'), $redirect_url ) );
        exit;
    }

    $admin_email = get_option( 'admin_email' );
    $subject = sprintf( 'Product Enquiry: %s', $product_title );

    $body = "New product enquiry received:\n\n";
    $body .= "Product: " . esc_html( $product_title ) . " (ID: " . esc_html( $product_id ) . ")\n";
    $body .= "Name: " . esc_html( $name ) . "\n";
    $body .= "Email: " . esc_html( $email ) . "\n";
    if ( ! empty( $phone ) ) {
        $body .= "Phone: " . esc_html( $phone ) . "\n";
    }
    $body .= "Message:\n" . esc_html( $message ) . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');

    $redirect_url = get_permalink( $product_id );

    if ( wp_mail( $admin_email, $subject, $body, $headers ) ) {
        wp_safe_redirect( add_query_arg(array('form_status' => 'success', 'modal_success' => 'productEnquiryModal'), $redirect_url ) );
    } else {
        wp_safe_redirect( add_query_arg(array('form_status' => 'mail_error', 'modal' => 'productEnquiryModal'), $redirect_url ) );
    }
    exit;
}
add_action('admin_post_nopriv_product_enquiry_submission', 'sacco_handle_product_enquiry');
add_action('admin_post_product_enquiry_submission', 'sacco_handle_product_enquiry');

/**
 * Handle Contact Page Form Submission
 */
function sacco_handle_contact_page_submission() {
    // Verify nonce
    if (!isset($_POST['contact_page_nonce']) || !wp_verify_nonce($_POST['contact_page_nonce'], 'sacco_contact_page_form_nonce')) {
        wp_safe_redirect(add_query_arg('form_status', 'nonce_error', wp_get_referer()));
        exit;
    }

    // Sanitize POST data
    $name = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $email = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $phone = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $department = isset($_POST['contact_department']) ? sanitize_text_field($_POST['contact_department']) : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field($_POST['contact_subject']) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';
    $privacy_agreed = isset($_POST['contact_privacy']) && $_POST['contact_privacy'] === 'agree';

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !is_email($email) || !$privacy_agreed) {
        wp_safe_redirect(add_query_arg('form_status', 'error', wp_get_referer()));
        exit;
    }

    // Prepare email
    $admin_email = get_option('admin_email');
    $email_subject = sprintf('[Contact Form] %s - %s', ucfirst($department), $subject);

    $email_body = "New contact form submission:\n\n";
    $email_body .= "Name: " . esc_html($name) . "\n";
    $email_body .= "Email: " . esc_html($email) . "\n";
    if (!empty($phone)) {
        $email_body .= "Phone: " . esc_html($phone) . "\n";
    }
    $email_body .= "Department: " . esc_html(ucfirst($department)) . "\n";
    $email_body .= "Subject: " . esc_html($subject) . "\n\n";
    $email_body .= "Message:\n" . esc_html($message) . "\n\n";
    $email_body .= "---\n";
    $email_body .= "Submitted from: " . home_url() . "\n";
    $email_body .= "Time: " . current_time('mysql') . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Send email
    if (wp_mail($admin_email, $email_subject, $email_body, $headers)) {
        // Send auto-reply to user
        $user_subject = 'Thank you for contacting Daystar Co-operative Society';
        $user_message = "Dear " . esc_html($name) . ",\n\n";
        $user_message .= "Thank you for contacting us. We have received your message and will respond within 24 hours.\n\n";
        $user_message .= "Your message details:\n";
        $user_message .= "Subject: " . esc_html($subject) . "\n";
        $user_message .= "Department: " . esc_html(ucfirst($department)) . "\n\n";
        $user_message .= "Best regards,\n";
        $user_message .= "Daystar Multipurpose Co-operative Society Ltd\n";
        $user_message .= "Email: info@daystarcoopsacco.com\n";
        $user_message .= "Phone: +254 700 123 456";

        wp_mail($email, $user_subject, $user_message, array('Content-Type: text/plain; charset=UTF-8'));

        wp_safe_redirect(add_query_arg('form_status', 'success', wp_get_referer()));
    } else {
        wp_safe_redirect(add_query_arg('form_status', 'mail_error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_nopriv_contact_page_submission', 'sacco_handle_contact_page_submission');
add_action('admin_post_contact_page_submission', 'sacco_handle_contact_page_submission');

/**
 * Enqueue pending approval styles
 */
function daystar_enqueue_pending_approval_styles() {
    if (is_page('member-dashboard') && is_user_logged_in()) {
        $user_id = get_current_user_id();
        $member_status = get_user_meta($user_id, 'member_status', true);
        
        if ($member_status === 'pending') {
            wp_enqueue_style('daystar-pending-approval',
                get_template_directory_uri() . '/assets/css/pending-approval.css',
                array(),
                filemtime(get_template_directory() . '/assets/css/pending-approval.css')
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_pending_approval_styles');

/**
 * Enqueue member dashboard scripts
 */
function daystar_enqueue_member_dashboard_scripts() {
    // Only enqueue on member dashboard page
    if (!is_page_template('page-member-dashboard.php')) {
        return;
    }

    // Enqueue CSS
    wp_enqueue_style('daystar-member-dashboard-css', 
        get_template_directory_uri() . '/assets/css/member-dashboard.css',
        array(),
        '1.0.0'
    );

    // Enqueue JS
    wp_enqueue_script('daystar-member-dashboard', 
        get_template_directory_uri() . '/assets/js/member-dashboard.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script('daystar-notifications', 
        get_template_directory_uri() . '/assets/js/notifications.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Add localization data for AJAX
    wp_localize_script('daystar-notifications', 'daystarData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('daystar_notifications_nonce'),
        'userId' => get_current_user_id(),
        'documentUploadNonce' => wp_create_nonce('daystar_document_upload')
    ));
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_member_dashboard_scripts');

// AJAX handlers for notifications are handled in includes/dashboard-notifications.php

require_once get_template_directory() . '/includes/auth-helper.php';
require_once get_template_directory() . '/includes/login-handler.php';
require_once get_template_directory() . '/ajax-handlers.php';

/**
 * Customizations for the WordPress admin area
 */
function sacco_php_custom_admin_styles() {
    // Custom CSS for admin area
    echo '<style>
        #adminmenu .toplevel_page_sacco-php div.wp-menu-name {
            font-weight: 600;
            color: #0073aa;
        }
        #adminmenu .toplevel_page_sacco-php div.wp-menu-name:hover {
            color: #005177;
        }
        #adminmenu .toplevel_page_sacco-php div.wp-menu-image:before {
            content: "\f120";
            font-family: dashicons;
            speak: none;
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>';
}
add_action('admin_head', 'sacco_php_custom_admin_styles');

/**
 * Change the login logo URL
 */
function sacco_php_custom_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'sacco_php_custom_login_url');

/**
 * Custom login logo
 */
function sacco_php_custom_login_logo() {
    echo '<style type="text/css">
        #login h1 a {
            background-image: url(' . esc_url( get_template_directory_uri() . '/assets/images/custom-logo.png' ) . ') !important;
            background-size: contain !important;
            width: 100% !important;
            height: 100px !important;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'sacco_php_custom_login_logo');

/**
 * Custom dashboard welcome message
 */
function sacco_php_custom_dashboard_welcome() {
    $user = wp_get_current_user();
    echo '<h2>' . esc_html__( 'Welcome to SACCO PHP Theme', 'sacco-php' ) . '</h2>';
    echo '<p>' . sprintf( esc_html__( 'Hello %s, welcome to your dashboard! Here you can manage your site.', 'sacco-php' ), esc_html( $user->display_name ) ) . '</p>';
}
add_action('admin_notices', 'sacco_php_custom_dashboard_welcome');

/**
 * Redirect subscriber accounts to front end
 */
function sacco_php_redirect_subscriber() {
    // Only redirect subscribers who are NOT members from admin areas
    if ( current_user_can('subscriber') && !current_user_can('member') && is_admin() && !is_ajax() ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action('template_redirect', 'sacco_php_redirect_subscriber');

/**
 * Custom excerpt length
 */
function sacco_php_custom_excerpt_length( $length ) {
    return 20; // Set the number of words for the excerpt
}
add_filter( 'excerpt_length', 'sacco_php_custom_excerpt_length' );

/**
 * Custom login error message
 */
function sacco_php_custom_login_error_message() {
    return __( 'Invalid username or password. Please try again.', 'sacco-php' );
}
add_filter( 'login_errors', 'sacco_php_custom_login_error_message' );

/**
 * Custom password reset message
 */
function sacco_php_custom_password_reset_message( $message, $key ) {
    $message = __( 'Your password has been reset. You can now log in with your new password.', 'sacco-php' );
    return $message;
}
add_filter( 'retrieve_password_message', 'sacco_php_custom_password_reset_message', 10, 2 );

/**
 * Custom user registration email
 */
function sacco_php_custom_user_registration_email( $user_id ) {
    $user = get_userdata( $user_id );
    $to = $user->user_email;
    $subject = __( 'Welcome to SACCO', 'sacco-php' );
    $message = __( 'Thank you for registering at SACCO. We are glad to have you.', 'sacco-php' );
    wp_mail( $to, $subject, $message );
}
add_action( 'user_register', 'sacco_php_custom_user_registration_email' );

/**
 * Custom admin footer text
 */
function sacco_php_custom_admin_footer() {
    echo '© ' . date('Y') . ' ' . esc_html__( 'SACCO. All rights reserved.', 'sacco-php' );
}
add_filter('admin_footer_text', 'sacco_php_custom_admin_footer');

/**
 * Custom dashboard footer text
 */
function sacco_php_custom_dashboard_footer() {
    echo 'Thank you for using SACCO PHP Theme. For support, visit our <a href="https://example.com/support" target="_blank">support page</a>.';
}
add_action('admin_footer', 'sacco_php_custom_dashboard_footer');

/**
 * Enqueue login form scripts
 */
function daystar_enqueue_login_scripts() {
    if (!is_page('login')) {
        return;
    }

    wp_enqueue_script(
        'daystar-login-form',
        get_template_directory_uri() . '/assets/js/login-form.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('daystar-login-form', 'daystar_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'dashboardUrl' => home_url('/member-dashboard'),
        'homeUrl' => home_url(),
        'login_nonce' => wp_create_nonce('daystar_login')
    ));
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_login_scripts');

/**
 * Enqueue registration form scripts
 */
function daystar_enqueue_registration_scripts() {
    if (is_page_template('page-register.php')) {
        wp_enqueue_script(
            'daystar-member-registration',
            get_template_directory_uri() . '/assets/js/member-registration.js',
            array('jquery', 'jquery-validation'), // Added jquery-validation dependency
            _S_VERSION, // Use theme version
            true
        );

        wp_localize_script('daystar-member-registration', 'daystarRegistrationData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'homeUrl' => home_url('/'),
            'registrationNonce' => wp_create_nonce('daystar_register_member_nonce'),
            'securityNonceName' => 'security'
        ));
    }
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_registration_scripts');

// Redirect users after login based on their role
function daystar_login_redirect($redirect_to, $request, $user) {
    // Check if there's an error
    if (isset($user->errors) && !empty($user->errors)) {
        return $redirect_to;
    }

    // Check if user has a role
    if (isset($user->roles) && is_array($user->roles)) {
        // Admin users go to admin dashboard
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        }
        
        // Members and pending members go to member dashboard
        if (in_array('member', $user->roles) || in_array('pending_member', $user->roles)) {
            return home_url('/member-dashboard/');
        }
    }
    
    // Default redirect for other users
    return home_url('/member-dashboard/');
}
add_filter('login_redirect', 'daystar_login_redirect', 10, 3);

// Prevent access to wp-admin for non-admin users
function daystar_restrict_admin_access() {
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        // Allow members and pending members to access member dashboard
        if (current_user_can('member') || in_array('pending_member', wp_get_current_user()->roles)) {
            wp_redirect(home_url('/member-dashboard/'));
            exit;
        }
    }
}
add_action('admin_init', 'daystar_restrict_admin_access');

// Create member role if it doesn't exist
function daystar_add_member_role() {
    if (!get_role('member')) {
        add_role('member', 'Member', array(
            'read' => true,
            'member' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ));
    }

    // Create pending_member role if it doesn't exist
    if (!get_role('pending_member')) {
        add_role('pending_member', 'Pending Member', array(
            'read' => true,
            'member' => true,
        ));
    }
    
    // Update existing roles to ensure they have the member capability
    $member_role = get_role('member');
    if ($member_role && !$member_role->has_cap('member')) {
        $member_role->add_cap('member');
    }
    
    $pending_member_role = get_role('pending_member');
    if ($pending_member_role && !$pending_member_role->has_cap('member')) {
        $pending_member_role->add_cap('member');
    }
}
add_action('init', 'daystar_add_member_role');

// Custom login URL rewrite
function daystar_custom_login_init() {
    add_rewrite_rule('^login/?$', 'index.php?pagename=login', 'top');
    add_rewrite_rule('^member-dashboard/?$', 'index.php?pagename=member-dashboard', 'top');
}
add_action('init', 'daystar_custom_login_init');

// Flush rewrite rules on theme activation
function daystar_flush_rewrite_rules() {
    daystar_custom_login_init();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'daystar_flush_rewrite_rules');

// Handle logout and redirect
function daystar_logout_redirect() {
    wp_redirect(home_url('/login/'));
    exit;
}
add_action('wp_logout', 'daystar_logout_redirect');

// Ensure member dashboard page exists on theme activation
function daystar_create_required_pages() {
    // Create member dashboard page
    $dashboard_page = get_page_by_path('member-dashboard');
    if (!$dashboard_page) {
        $page_id = wp_insert_post(array(
            'post_title' => 'Member Dashboard',
            'post_name' => 'member-dashboard',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ));
        
        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'page-member-dashboard.php');
        }
    }
}
add_action('after_setup_theme', 'daystar_create_required_pages');

// Custom authentication function for member numbers
function daystar_authenticate_member($user, $username, $password) {
    // If WordPress already authenticated the user, return it
    if ($user instanceof WP_User) {
        return $user;
    }

    // Check if the username looks like a member number (starts with DSM or is numeric)
    if (preg_match('/^(DSM\d+|\d+)$/', $username)) {
        // Look for user by member number in user meta
        $users = get_users(array(
            'meta_key' => 'member_number',
            'meta_value' => $username,
            'number' => 1
        ));

        if (!empty($users)) {
            $user = $users[0];
            // Verify password
            if (wp_check_password($password, $user->user_pass, $user->ID)) {
                return $user;
            }
        }
    }

    return $user;
}
add_filter('authenticate', 'daystar_authenticate_member', 30, 3);

// Database tables are created via includes/database-setup.php
// The function daystar_create_database_tables() is defined there and called via after_setup_theme hook

// AJAX handler for member status check
function check_member_status_ajax() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'wp_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $response = array();
    
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $member_number = get_user_meta($current_user->ID, 'member_number', true);
        
        if ($member_number) {
            // User is a logged-in member
            $response['success'] = true;
            $response['data'] = array(
                'redirect_url' => home_url('/member-dashboard/'),
                'member_number' => $member_number,
                'user_name' => $current_user->display_name
            );
        } else {
            // User is logged in but not a member
            $response['success'] = false;
            $response['data'] = array(
                'message' => 'User is not a registered member'
            );
        }
    } else {
        // User is not logged in
        $response['success'] = false;
        $response['data'] = array(
            'message' => 'User not logged in'
        );
    }
    
    wp_send_json($response);
}
add_action('wp_ajax_check_member_status', 'check_member_status_ajax');
add_action('wp_ajax_nopriv_check_member_status', 'check_member_status_ajax');

// Localize AJAX for frontend
 function daystar_localize_ajax() {
     wp_localize_script('jquery', 'wp', array(
         'ajax' => array(
             'settings' => array(
                 'url' => admin_url('admin-ajax.php'),
                 'nonce' => wp_create_nonce('wp_ajax_nonce')
             )
         )
     ));
 }
 add_action('wp_enqueue_scripts', 'daystar_localize_ajax');