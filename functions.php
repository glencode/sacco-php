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
function sacco_php_scripts() {	// Base theme style
	wp_enqueue_style('sacco-php-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('sacco-php-style', 'rtl', 'replace');

	// Bootstrap CSS (base framework)
	wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '5.1.3', 'all');
	
	// Google Fonts
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
	
	// Font Awesome
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');
	
	// Theme base styles
	wp_enqueue_style('sacco-php-base', get_template_directory_uri() . '/assets/css/style.css', array('bootstrap'), _S_VERSION . '.' . time(), 'all');
	
	// Modern effects and enhancements (these should override other styles)
	wp_enqueue_style('sacco-php-modern-effects', get_template_directory_uri() . '/css/modern-effects.css', array('sacco-php-base'), _S_VERSION . '.' . time(), 'all');
	wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '5.1.3', 'all');
	
	// Enqueue Glassmorphism CSS
	wp_enqueue_style('sacco-glassmorphism', get_template_directory_uri() . '/assets/css/glassmorphism.css', array(), _S_VERSION);
	
	// Enqueue Google Fonts
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
	
	// Enqueue Font Awesome
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');
	
	// Enqueue Swiper CSS
	wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '8.0.0', 'all');
	
	// Enqueue Custom CSS
	wp_enqueue_style('sacco-php-custom', get_template_directory_uri() . '/assets/css/style.css', array('bootstrap'), _S_VERSION, 'all');
	
	// Enqueue modern effects stylesheet
    wp_enqueue_style('sacco-php-modern-effects', get_template_directory_uri() . '/assets/css/modern-effects.css', array(), _S_VERSION);
	
	// Enqueue jQuery and Bootstrap first
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.1.3', true);
	
	// Enqueue our custom scripts
	wp_enqueue_script('sacco-php-glassmorphism', get_template_directory_uri() . '/assets/js/glassmorphism.js', array('jquery'), _S_VERSION . '.' . time(), true);
	
	// Add dynamic data for the glassmorphism script
	wp_localize_script('sacco-php-glassmorphism', 'glassmorphismData', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'themeUrl' => get_template_directory_uri(),
		'isLoggedIn' => is_user_logged_in()
	));
	
	// Enqueue Swiper JS
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), '8.0.0', true);
	
	// Enqueue Chart.js for calculators
	wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', array(), '3.7.1', true);
	
	// Enqueue AOS (Animate On Scroll) library for animations
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

    // Enqueue Glassmorphism JS
    wp_enqueue_script('sacco-glassmorphism', get_template_directory_uri() . '/assets/js/glassmorphism.js', array('jquery'), _S_VERSION, true);
	
	// Enqueue Custom JS
	wp_enqueue_script('sacco-php-custom', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'swiper-js', 'chart-js'), _S_VERSION, true);

	// Enqueue AOS (Animate On Scroll) library for animations
	wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
	wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

	// Enqueue custom front page script
	if (is_front_page()) {
		wp_enqueue_script('sacco-php-front-page', get_template_directory_uri() . '/assets/js/front-page.js', array('jquery', 'swiper-js', 'aos-js'), _S_VERSION, true);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (is_page('about')) {
		wp_enqueue_style('page-about-styles', get_template_directory_uri() . '/assets/css/pages/page-about.css', array(), _S_VERSION);
	}

	if (is_page('downloads')) {
		wp_enqueue_style('page-downloads-styles', get_template_directory_uri() . '/assets/css/pages/page-downloads.css', array(), _S_VERSION);
	}

	if (is_singular('product') || is_singular('loan') || is_singular('savings')) { // Or a more specific check if this template part is used elsewhere
		wp_enqueue_style('faq-section-styles', get_template_directory_uri() . '/assets/css/template-parts/faq-section.css', array(), _S_VERSION);
	}

	// Assuming TOC is used on single posts/pages where it makes sense
	if (is_singular() && !is_front_page()) {
		wp_enqueue_style('table-of-contents-styles', get_template_directory_uri() . '/assets/css/template-parts/table-of-contents.css', array(), _S_VERSION);
		wp_enqueue_script('table-of-contents-script', get_template_directory_uri() . '/assets/js/template-parts/table-of-contents.js', array('jquery'), _S_VERSION, true);
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
}
add_action('wp_enqueue_scripts', 'sacco_php_product_page_styles');

/**
 * User login and registration handlers
 */
function sacco_handle_login() {
    if (!isset($_POST['sacco_login_nonce']) || !wp_verify_nonce($_POST['sacco_login_nonce'], 'sacco_login')) {
        return;
    }

    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $credentials = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    );

    $user = wp_signon($credentials, is_ssl());

    if (is_wp_error($user)) {
        $error = $user->get_error_message();

        wp_redirect(add_query_arg('login_error', urlencode($error), wp_get_referer()));
        exit;
    } else {
        wp_redirect(home_url('member-dashboard'));
        exit;
    }
}
add_action('admin_post_sacco_login', 'sacco_handle_login');
add_action('admin_post_nopriv_sacco_login', 'sacco_handle_login');

function sacco_handle_registration() {
    if (!isset($_POST['sacco_register_nonce']) || !wp_verify_nonce($_POST['sacco_register_nonce'], 'sacco_register')) {
        return;
    }

    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        wp_redirect(add_query_arg('register_error', 'passwords_mismatch', wp_get_referer()));
        exit;
    }

    // Create user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        $error = $user_id->get_error_message();
        wp_redirect(add_query_arg('register_error', urlencode($error), wp_get_referer()));
        exit;
    } else {
        // Update user meta
        wp_update_user(array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
        ));

        // Log the user in
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

        // Redirect to member dashboard
        wp_redirect(home_url('member-dashboard'));
        exit;
    }
}
add_action('admin_post_nopriv_sacco_register', 'sacco_handle_registration');

/**
 * Add Member Portal rewrite rules
 */
function sacco_add_member_portal_rewrite_rules() {
    add_rewrite_rule(
        'member-dashboard/?$',
        'index.php?pagename=member-portal&portal_page=dashboard',
        'top'
    );
    
    add_rewrite_rule(
        'member-profile/?$',
        'index.php?pagename=member-portal&portal_page=profile',
        'top'
    );
    
    add_rewrite_rule(
        'member-loans/?$',
        'index.php?pagename=member-portal&portal_page=loans',
        'top'
    );
    
    add_rewrite_rule(
        'member-savings/?$',
        'index.php?pagename=member-portal&portal_page=savings',
        'top'
    );
    
    add_rewrite_rule(
        'member-transactions/?$',
        'index.php?pagename=member-portal&portal_page=transactions',
        'top'
    );
}
add_action('init', 'sacco_add_member_portal_rewrite_rules');

function sacco_add_query_vars($vars) {
    $vars[] = 'portal_page';
    return $vars;
}
add_filter('query_vars', 'sacco_add_query_vars');

/**
 * Member Portal Template Redirects
 */
function sacco_member_portal_template_redirect() {
    global $wp_query;
    
    if (is_page('member-portal')) {
        $portal_page = get_query_var('portal_page');
        
        if ($portal_page == 'dashboard') {
            include(get_template_directory() . '/page-member-dashboard.php');
            exit;
        } elseif ($portal_page == 'profile') {
            include(get_template_directory() . '/includes/member-profile.php');
            exit;        } elseif ($portal_page == 'loans') {
            // include(get_template_directory() . '/page-member-loans.php'); // File missing - was not found in theme root or includes folder.
            exit;
        }
    }
}
add_action('template_redirect', 'sacco_member_portal_template_redirect');

/**
 * Restrict access to member portal pages for non-logged-in users
 */
function sacco_restrict_member_portal_access() {
    if (!is_user_logged_in() && 
        (is_page('member-portal') || 
         get_query_var('portal_page') == 'dashboard' || 
         get_query_var('portal_page') == 'profile' || 
         get_query_var('portal_page') == 'loans' || 
         get_query_var('portal_page') == 'savings' || 
         get_query_var('portal_page') == 'transactions')) {
        
        wp_redirect(home_url('login'));
        exit;
    }
}
add_action('template_redirect', 'sacco_restrict_member_portal_access', 1);

/**
 * Register Loan Custom Post Type
 */
function sacco_php_register_loan_cpt() {
    $labels = array(
        'name'                  => _x( 'Loan Products', 'Post Type General Name', 'sacco-php' ),
        'singular_name'         => _x( 'Loan Product', 'Post Type Singular Name', 'sacco-php' ),
        'menu_name'             => __( 'Loan Products', 'sacco-php' ),
        'name_admin_bar'        => __( 'Loan Product', 'sacco-php' ),
        'archives'              => __( 'Loan Product Archives', 'sacco-php' ),
		'attributes'            => __( 'Loan Product Attributes', 'sacco-php' ),
		'parent_item_colon'     => __( 'Parent Loan Product:', 'sacco-php' ),
		'all_items'             => __( 'All Loan Products', 'sacco-php' ),
		'add_new_item'          => __( 'Add New Loan Product', 'sacco-php' ),
		'add_new'               => __( 'Add New', 'sacco-php' ),
		'new_item'              => __( 'New Loan Product', 'sacco-php' ),
		'edit_item'             => __( 'Edit Loan Product', 'sacco-php' ),
		'update_item'           => __( 'Update Loan Product', 'sacco-php' ),
		'view_item'             => __( 'View Loan Product', 'sacco-php' ),
		'view_items'            => __( 'View Loan Products', 'sacco-php' ),
		'search_items'          => __( 'Search Loan Product', 'sacco-php' ),
		'not_found'             => __( 'Not found', 'sacco-php' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sacco-php' ),
		'featured_image'        => __( 'Featured Image', 'sacco-php' ),
		'set_featured_image'    => __( 'Set featured image', 'sacco-php' ),
		'remove_featured_image' => __( 'Remove featured image', 'sacco-php' ),
		'use_featured_image'    => __( 'Use as featured image', 'sacco-php' ),
		'insert_into_item'      => __( 'Insert into loan product', 'sacco-php' ),
		'uploaded_to_this_item' => __( 'Uploaded to this loan product', 'sacco-php' ),
		'items_list'            => __( 'Loan Products list', 'sacco-php' ),
		'items_list_navigation' => __( 'Loan Products list navigation', 'sacco-php' ),
		'filter_items_list'     => __( 'Filter loan products list', 'sacco-php' ),
	);
	$args = array(
		'label'                 => __( 'Loan Product', 'sacco-php' ),
		'description'           => __( 'Loan products and services', 'sacco-php' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'loan_category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-money-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'loans',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'loan-product' ),
	);
	register_post_type( 'loan', $args );
}
add_action( 'init', 'sacco_php_register_loan_cpt', 0 );

/**
 * Register Loan Category Taxonomy
 */
function sacco_php_register_loan_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Loan Categories', 'Taxonomy General Name', 'sacco-php' ),
        'singular_name'              => _x( 'Loan Category', 'Taxonomy Singular Name', 'sacco-php' ),
        'menu_name'                  => __( 'Loan Categories', 'sacco-php' ),
        'all_items'                  => __( 'All Loan Categories', 'sacco-php' ),
        'parent_item'                => __( 'Parent Loan Category', 'sacco-php' ),
        'parent_item_colon'          => __( 'Parent Loan Category:', 'sacco-php' ),
        'new_item_name'              => __( 'New Loan Category Name', 'sacco-php' ),
        'add_new_item'               => __( 'Add New Loan Category', 'sacco-php' ),
        'edit_item'                  => __( 'Edit Loan Category', 'sacco-php' ),
        'update_item'                => __( 'Update Loan Category', 'sacco-php' ),
        'view_item'                  => __( 'View Loan Category', 'sacco-php' ),
        'separate_items_with_commas' => __( 'Separate loan categories with commas', 'sacco-php' ),
        'add_or_remove_items'        => __( 'Add or remove loan categories', 'sacco-php' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sacco-php' ),
        'popular_items'              => __( 'Popular Loan Categories', 'sacco-php' ),
        'search_items'               => __( 'Search Loan Categories', 'sacco-php' ),
        'not_found'                  => __( 'Not Found', 'sacco-php' ),
        'no_terms'                   => __( 'No loan categories', 'sacco-php' ),
        'items_list'                 => __( 'Loan Categories list', 'sacco-php' ),
        'items_list_navigation'      => __( 'Loan Categories list navigation', 'sacco-php' ),
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
    register_taxonomy( 'loan_category', array( 'loan' ), $args );
}
add_action( 'init', 'sacco_php_register_loan_category_taxonomy', 0 );

/**
 * Register meta boxes for Loan Products
 */
function sacco_php_register_loan_meta_boxes() {
    add_meta_box(
        'loan_product_details',
        __('Loan Product Details', 'sacco-php'),
        'sacco_php_loan_meta_box_callback',
        'loan',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sacco_php_register_loan_meta_boxes');

/**
 * Meta box display callback for loans.
 *
 * @param WP_Post $post Current post object.
 */
function sacco_php_loan_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('sacco_php_loan_meta_box', 'sacco_php_loan_meta_box_nonce');
    
    // Get values
    $interest_rate = get_post_meta($post->ID, 'interest_rate', true);
    $minimum_amount = get_post_meta($post->ID, 'minimum_amount', true);
    $maximum_amount = get_post_meta($post->ID, 'maximum_amount', true);
    $loan_term = get_post_meta($post->ID, 'loan_term', true);
    $loan_badge = get_post_meta($post->ID, 'loan_badge', true);
    $processing_time = get_post_meta($post->ID, 'processing_time', true);
    $processing_fee = get_post_meta($post->ID, 'processing_fee', true);
    $features = get_post_meta($post->ID, 'features', true);
    $requirements = get_post_meta($post->ID, 'requirements', true);
    $insurance_partner_company = get_post_meta($post->ID, '_insurance_partner_company', true);
    
    // New fields
    $loan_policy_category = get_post_meta($post->ID, 'loan_policy_category', true);
    $base_interest_rate_pa = get_post_meta($post->ID, 'base_interest_rate_pa', true);
    $interest_rate_type = get_post_meta($post->ID, 'interest_rate_type', true);
    $processing_fee_flat = get_post_meta($post->ID, 'processing_fee_flat', true);
    $sinking_fund_percentage = get_post_meta($post->ID, 'sinking_fund_percentage', true);
    $appraisal_fee_percentage = get_post_meta($post->ID, 'appraisal_fee_percentage', true);
    
    // New fields (Part 2)
    $refinance_charge_percentage = get_post_meta($post->ID, 'refinance_charge_percentage', true);
    $salary_advance_one_off_rate = get_post_meta($post->ID, 'salary_advance_one_off_rate', true);
    $salary_advance_compounded_rate = get_post_meta($post->ID, 'salary_advance_compounded_rate', true);
    $instant_loan_charge_percentage = get_post_meta($post->ID, 'instant_loan_charge_percentage', true);
    $loan_factor_deposits = get_post_meta($post->ID, 'loan_factor_deposits', true);
    $requires_postdated_cheques = get_post_meta($post->ID, 'requires_postdated_cheques', true);
    $minimum_deposit_requirement = get_post_meta($post->ID, 'minimum_deposit_requirement', true);

    ?>
    <p>
        <label for="interest_rate"><?php _e('Interest Rate:', 'sacco-php'); ?></label>
        <input type="text" id="interest_rate" name="interest_rate" value="<?php echo esc_attr($interest_rate); ?>" class="widefat" placeholder="e.g., 14% p.a.">
    </p>
    <p>
        <label for="minimum_amount"><?php _e('Minimum Amount:', 'sacco-php'); ?></label>
        <input type="text" id="minimum_amount" name="minimum_amount" value="<?php echo esc_attr($minimum_amount); ?>" class="widefat" placeholder="e.g., KSh 10,000">
    </p>
    <p>
        <label for="maximum_amount"><?php _e('Maximum Amount:', 'sacco-php'); ?></label>
        <input type="text" id="maximum_amount" name="maximum_amount" value="<?php echo esc_attr($maximum_amount); ?>" class="widefat" placeholder="e.g., KSh 1,000,000">
    </p>
    <p>
        <label for="loan_term"><?php _e('Loan Term:', 'sacco-php'); ?></label>
        <input type="text" id="loan_term" name="loan_term" value="<?php echo esc_attr($loan_term); ?>" class="widefat" placeholder="e.g., Up to 48 months">
    </p>
    <p>
        <label for="loan_badge"><?php _e('Badge (Optional):', 'sacco-php'); ?></label>
        <input type="text" id="loan_badge" name="loan_badge" value="<?php echo esc_attr($loan_badge); ?>" class="widefat" placeholder="e.g., Popular, New, Featured">
        <small><?php _e('Leave empty for no badge', 'sacco-php'); ?></small>
    </p>
    <p>
        <label for="processing_time"><?php _e('Processing Time:', 'sacco-php'); ?></label>
        <input type="text" id="processing_time" name="processing_time" value="<?php echo esc_attr($processing_time); ?>" class="widefat" placeholder="e.g., 24-48 hours">
    </p>
    <p>
        <label for="processing_fee"><?php _e('Processing Fee:', 'sacco-php'); ?></label>
        <input type="text" id="processing_fee" name="processing_fee" value="<?php echo esc_attr($processing_fee); ?>" class="widefat" placeholder="e.g., 2% of loan amount">
    </p>
    <p>
        <label for="features"><?php _e('Key Features & Benefits (one per line):', 'sacco-php'); ?></label>
        <textarea id="features" name="features" class="widefat" rows="5" placeholder="Enter one feature per line"><?php echo esc_textarea($features); ?></textarea>
    </p>
    <p>
        <label for="requirements"><?php _e('Requirements (one per line):', 'sacco-php'); ?></label>
        <textarea id="requirements" name="requirements" class="widefat" rows="5" placeholder="Enter one requirement per line"><?php echo esc_textarea($requirements); ?></textarea>
    </p>
    <p>
        <label for="insurance_partner_company"><?php _e('Insurance Partner Company (if applicable for IPF loans):', 'sacco-php'); ?></label>
        <input type="text" id="insurance_partner_company" name="insurance_partner_company" value="<?php echo esc_attr($insurance_partner_company); ?>" class="widefat" placeholder="e.g., ABC Insurance Ltd.">
    </p>
    <hr>
    <p><strong><?php _e('Loan Policy & Interest Details:', 'sacco-php'); ?></strong></p>
    <p>
        <label for="loan_policy_category"><?php _e('Loan Policy Category:', 'sacco-php'); ?></label>
        <select id="loan_policy_category" name="loan_policy_category" class="widefat">
            <option value="" <?php selected($loan_policy_category, ''); ?>><?php _e('Select Policy Category', 'sacco-php'); ?></option>
            <option value="normal_development" <?php selected($loan_policy_category, 'normal_development'); ?>><?php _e('Normal/Development Loan', 'sacco-php'); ?></option>
            <option value="school_fees" <?php selected($loan_policy_category, 'school_fees'); ?>><?php _e('School Fees Loan', 'sacco-php'); ?></option>
            <option value="instant_loan" <?php selected($loan_policy_category, 'instant_loan'); ?>><?php _e('Instant Loan', 'sacco-php'); ?></option>
            <option value="refinance_loan" <?php selected($loan_policy_category, 'refinance_loan'); ?>><?php _e('Refinance Loan', 'sacco-php'); ?></option>
            <option value="emergency_loan" <?php selected($loan_policy_category, 'emergency_loan'); ?>><?php _e('Emergency Loan', 'sacco-php'); ?></option>
            <option value="special_loan" <?php selected($loan_policy_category, 'special_loan'); ?>><?php _e('Special Loan', 'sacco-php'); ?></option>
            <option value="super_saver" <?php selected($loan_policy_category, 'super_saver'); ?>><?php _e('Super Saver Loan', 'sacco-php'); ?></option>
            <option value="salary_advance" <?php selected($loan_policy_category, 'salary_advance'); ?>><?php _e('Salary Advance', 'sacco-php'); ?></option>
        </select>
    </p>
    <p>
        <label for="base_interest_rate_pa"><?php _e('Base Interest Rate (p.a %):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="base_interest_rate_pa" name="base_interest_rate_pa" value="<?php echo esc_attr($base_interest_rate_pa); ?>" class="widefat" placeholder="e.g., 12.5">
    </p>
    <p>
        <label for="interest_rate_type"><?php _e('Interest Rate Type:', 'sacco-php'); ?></label>
        <select id="interest_rate_type" name="interest_rate_type" class="widefat">
            <option value="reducing_balance" <?php selected($interest_rate_type, 'reducing_balance'); ?>><?php _e('Reducing Balance', 'sacco-php'); ?></option>
            <option value="compounded" <?php selected($interest_rate_type, 'compounded'); ?>><?php _e('Compounded', 'sacco-php'); ?></option>
            <option value="one_off" <?php selected($interest_rate_type, 'one_off'); ?>><?php _e('One-off', 'sacco-php'); ?></option>
        </select>
    </p>
    <p>
        <label for="processing_fee_flat"><?php _e('Processing Fee (Flat):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="processing_fee_flat" name="processing_fee_flat" value="<?php echo esc_attr($processing_fee_flat); ?>" class="widefat" placeholder="e.g., 500">
    </p>
    <p>
        <label for="sinking_fund_percentage"><?php _e('Sinking Fund (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="sinking_fund_percentage" name="sinking_fund_percentage" value="<?php echo esc_attr($sinking_fund_percentage); ?>" class="widefat" placeholder="e.g., 1.0">
    </p>
    <p>
        <label for="appraisal_fee_percentage"><?php _e('Appraisal Fee (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="appraisal_fee_percentage" name="appraisal_fee_percentage" value="<?php echo esc_attr($appraisal_fee_percentage); ?>" class="widefat" placeholder="e.g., 0.5">
    </p>
    <p>
        <label for="refinance_charge_percentage"><?php _e('Refinance Charge (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="refinance_charge_percentage" name="refinance_charge_percentage" value="<?php echo esc_attr($refinance_charge_percentage); ?>" class="widefat" placeholder="e.g., 1.5">
    </p>
    <p>
        <label for="salary_advance_one_off_rate"><?php _e('Salary Advance One-off Rate (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="salary_advance_one_off_rate" name="salary_advance_one_off_rate" value="<?php echo esc_attr($salary_advance_one_off_rate); ?>" class="widefat" placeholder="e.g., 5">
    </p>
    <p>
        <label for="salary_advance_compounded_rate"><?php _e('Salary Advance Compounded Rate (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="salary_advance_compounded_rate" name="salary_advance_compounded_rate" value="<?php echo esc_attr($salary_advance_compounded_rate); ?>" class="widefat" placeholder="e.g., 10">
    </p>
    <p>
        <label for="instant_loan_charge_percentage"><?php _e('Instant Loan Charge (%):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="instant_loan_charge_percentage" name="instant_loan_charge_percentage" value="<?php echo esc_attr($instant_loan_charge_percentage); ?>" class="widefat" placeholder="e.g., 8">
    </p>
    <p>
        <label for="loan_factor_deposits"><?php _e('Loan Factor (multiplier of deposits):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="loan_factor_deposits" name="loan_factor_deposits" value="<?php echo esc_attr($loan_factor_deposits); ?>" class="widefat" placeholder="e.g., 3">
    </p>
    <p>
        <label for="minimum_deposit_requirement"><?php _e('Minimum Deposit Requirement (for eligibility):', 'sacco-php'); ?></label>
        <input type="number" step="1" id="minimum_deposit_requirement" name="minimum_deposit_requirement" value="<?php echo esc_attr($minimum_deposit_requirement); ?>" class="widefat" placeholder="e.g., 50000">
    </p>
    <p>
        <input type="checkbox" id="requires_postdated_cheques" name="requires_postdated_cheques" value="1" <?php checked( $requires_postdated_cheques, '1' ); ?> />
        <label for="requires_postdated_cheques"><?php _e('Requires Post-dated Cheques', 'sacco-php'); ?></label>
    </p>
    <hr>
    <p><strong><?php _e('Special Loan Charges & Eligibility:', 'sacco-php'); ?></strong></p>
    <?php
    $defer_charge_flat = get_post_meta($post->ID, 'defer_charge_flat', true);
    $defer_penalty_percentage = get_post_meta($post->ID, 'defer_penalty_percentage', true);
    $bounced_cheque_fee_flat = get_post_meta($post->ID, 'bounced_cheque_fee_flat', true);
    $requires_shares_for_application = get_post_meta($post->ID, 'requires_shares_for_application', true);
    // Default to '1' (checked) if no value is saved yet (for new posts)
    if ('' === $requires_shares_for_application && $post->post_status === 'auto-draft') { // auto-draft is for new, unsaved posts
        $requires_shares_for_application = '1';
    }
    ?>
    <p>
        <label for="defer_charge_flat"><?php _e('Defer Charge (Flat Ksh):', 'sacco-php'); ?></label>
        <input type="number" step="1" id="defer_charge_flat" name="defer_charge_flat" value="<?php echo esc_attr($defer_charge_flat); ?>" class="widefat" placeholder="e.g., 1000">
    </p>
    <p>
        <label for="defer_penalty_percentage"><?php _e('Defer Penalty Charge (% of instalment):', 'sacco-php'); ?></label>
        <input type="number" step="any" id="defer_penalty_percentage" name="defer_penalty_percentage" value="<?php echo esc_attr($defer_penalty_percentage); ?>" class="widefat" placeholder="e.g., 5.5">
    </p>
    <p>
        <label for="bounced_cheque_fee_flat"><?php _e('Bounced Cheque Fee (Flat Ksh):', 'sacco-php'); ?></label>
        <input type="number" step="1" id="bounced_cheque_fee_flat" name="bounced_cheque_fee_flat" value="<?php echo esc_attr($bounced_cheque_fee_flat); ?>" class="widefat" placeholder="e.g., 2000">
    </p>
    <p>
        <input type="checkbox" id="requires_shares_for_application" name="requires_shares_for_application" value="1" <?php checked( $requires_shares_for_application, '1' ); ?> />
        <label for="requires_shares_for_application"><?php _e('Requires Share Capital for Application', 'sacco-php'); ?></label>
    </p>
    <hr>
    <p><strong><?php _e('Repayment Periods & Maximum Amounts:', 'sacco-php'); ?></strong></p>
    
    <?php
    // Repayment Period Fields
    $repayment_fields = [
        'repayment_period_part_timers_permanent_months' => __('Repayment - Part-timers & Permanent (months):', 'sacco-php'),
        'repayment_period_others_months' => __('Repayment - Others (months):', 'sacco-php'),
        'repayment_period_supersavers_months' => __('Repayment - Supersavers (months):', 'sacco-php'),
        'repayment_period_school_fees_months' => __('Repayment - School Fees (months):', 'sacco-php'),
        'repayment_period_instant_loan_months' => __('Repayment - Instant Loan (months):', 'sacco-php'),
        'repayment_period_emergency_loan_months' => __('Repayment - Emergency Loan (months):', 'sacco-php'),
        'repayment_period_salary_advance_months' => __('Repayment - Salary Advance (months):', 'sacco-php'),
    ];

    foreach ($repayment_fields as $meta_key => $label) {
        $value = get_post_meta($post->ID, $meta_key, true);
        ?>
        <p>
            <label for="<?php echo esc_attr($meta_key); ?>"><?php echo esc_html($label); ?></label>
            <input type="number" step="1" id="<?php echo esc_attr($meta_key); ?>" name="<?php echo esc_attr($meta_key); ?>" value="<?php echo esc_attr($value); ?>" class="widefat" placeholder="<?php _e('Months', 'sacco-php'); ?>">
        </p>
        <?php
    }

    // Maximum Loan Amount Fields
    $max_loan_fields = [
        'max_loan_development' => __('Max Loan - Development (Ksh):', 'sacco-php'),
        'max_loan_super_saver' => __('Max Loan - Super Saver (Ksh):', 'sacco-php'),
        'max_loan_instant' => __('Max Loan - Instant (Ksh):', 'sacco-php'),
        'max_loan_emergency' => __('Max Loan - Emergency (Ksh):', 'sacco-php'),
        'max_loan_special' => __('Max Loan - Special (Ksh):', 'sacco-php'),
    ];

    foreach ($max_loan_fields as $meta_key => $label) {
        $value = get_post_meta($post->ID, $meta_key, true);
        ?>
        <p>
            <label for="<?php echo esc_attr($meta_key); ?>"><?php echo esc_html($label); ?></label>
            <input type="number" step="1" id="<?php echo esc_attr($meta_key); ?>" name="<?php echo esc_attr($meta_key); ?>" value="<?php echo esc_attr($value); ?>" class="widefat" placeholder="<?php _e('Amount in Ksh', 'sacco-php'); ?>">
        </p>
        <?php
    }
    ?>
    
    <p><strong><?php _e('Special Loan Repayment Configuration (Max 3 Tiers):', 'sacco-php'); ?></strong></p>
    <?php
    for ($i = 1; $i <= 3; $i++) {
        $amount_limit_key = "special_loan_config_{$i}_amount_limit";
        $repayment_period_key = "special_loan_config_{$i}_repayment_period";
        $amount_limit_value = get_post_meta($post->ID, $amount_limit_key, true);
        $repayment_period_value = get_post_meta($post->ID, $repayment_period_key, true);
        ?>
        <div style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px;">
            <p><em><?php printf(esc_html__('Configuration Tier %d', 'sacco-php'), $i); ?></em></p>
            <p>
                <label for="<?php echo esc_attr($amount_limit_key); ?>"><?php _e('Max Amount Limit (Ksh) - Tier:', 'sacco-php'); ?></label>
                <input type="number" step="1" id="<?php echo esc_attr($amount_limit_key); ?>" name="<?php echo esc_attr($amount_limit_key); ?>" value="<?php echo esc_attr($amount_limit_value); ?>" class="widefat" placeholder="<?php _e('e.g., 100000', 'sacco-php'); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($repayment_period_key); ?>"><?php _e('Repayment Period (Months) - Tier:', 'sacco-php'); ?></label>
                <input type="number" step="1" id="<?php echo esc_attr($repayment_period_key); ?>" name="<?php echo esc_attr($repayment_period_key); ?>" value="<?php echo esc_attr($repayment_period_value); ?>" class="widefat" placeholder="<?php _e('e.g., 4', 'sacco-php'); ?>">
            </p>
        </div>
        <?php
    }
    ?>
    <?php
}

/**
 * Save meta box content for loans.
 *
 * @param int $post_id Post ID
 */
function sacco_php_save_loan_meta_box_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['sacco_php_loan_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['sacco_php_loan_meta_box_nonce'], 'sacco_php_loan_meta_box')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'loan' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        // For other post types or if post_type is not set
        if (!current_user_can('edit_page', $post_id)) { // Fallback capability
            return;
        }
    }

    // Sanitize and save the data
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
        'insurance_partner_company', // Note: form field is 'insurance_partner_company', meta key is '_insurance_partner_company'
        // New fields
        'loan_policy_category',
        'base_interest_rate_pa',
        'interest_rate_type',
        'processing_fee_flat',
        'sinking_fund_percentage',
        'appraisal_fee_percentage',
        // New fields (Part 2)
        'refinance_charge_percentage',
        'salary_advance_one_off_rate',
        'salary_advance_compounded_rate',
        'instant_loan_charge_percentage',
        'loan_factor_deposits',
        'minimum_deposit_requirement',
        // Note: 'requires_postdated_cheques' & 'requires_shares_for_application' are handled separately below
        
        // Repayment Periods & Max Amounts
        'repayment_period_part_timers_permanent_months',
        'repayment_period_others_months',
        'repayment_period_supersavers_months',
        'repayment_period_school_fees_months',
        'repayment_period_instant_loan_months',
        'repayment_period_emergency_loan_months',
        'repayment_period_salary_advance_months',
        'max_loan_development',
        'max_loan_super_saver',
        'max_loan_instant',
        'max_loan_emergency',
        'max_loan_special',
        // Special Loan Configs are handled separately below
        
        // Final new charge fields
        'defer_charge_flat',
        'defer_penalty_percentage',
        'bounced_cheque_fee_flat'
    );

    foreach ($meta_fields as $field_name) {
        // Skip checkboxes here, they are handled below
        if ($field_name === 'requires_postdated_cheques' || $field_name === 'requires_shares_for_application') {
            continue;
        }

        if (isset($_POST[$field_name])) {
            $value = $_POST[$field_name];
            $meta_key = ($field_name === 'insurance_partner_company') ? '_insurance_partner_company' : $field_name;

            // Determine sanitization type
            if (in_array($field_name, [
                'base_interest_rate_pa', 'processing_fee_flat', 'sinking_fund_percentage', 'appraisal_fee_percentage',
                'refinance_charge_percentage', 'salary_advance_one_off_rate', 'salary_advance_compounded_rate',
                'instant_loan_charge_percentage', 'loan_factor_deposits', 'minimum_deposit_requirement',
                'repayment_period_part_timers_permanent_months', 'repayment_period_others_months',
                'repayment_period_supersavers_months', 'repayment_period_school_fees_months',
                'repayment_period_instant_loan_months', 'repayment_period_emergency_loan_months',
                'repayment_period_salary_advance_months',
                'max_loan_development', 'max_loan_super_saver', 'max_loan_instant',
                'max_loan_emergency', 'max_loan_special',
                'defer_charge_flat', 'defer_penalty_percentage', 'bounced_cheque_fee_flat'
                ])) {
                $sanitized_value = floatval($value);
            } elseif (in_array($field_name, [
                'minimum_deposit_requirement', 'defer_charge_flat', 'bounced_cheque_fee_flat',
                'repayment_period_part_timers_permanent_months', 'repayment_period_others_months',
                'repayment_period_supersavers_months', 'repayment_period_school_fees_months',
                'repayment_period_instant_loan_months', 'repayment_period_emergency_loan_months',
                'repayment_period_salary_advance_months',
                'max_loan_development', 'max_loan_super_saver', 'max_loan_instant',
                'max_loan_emergency', 'max_loan_special'
            ])) {
                $sanitized_value = intval($value);
            } elseif ($field_name === 'features' || $field_name === 'requirements') {
                $sanitized_value = sanitize_textarea_field($value);
            } elseif (in_array($field_name, ['loan_policy_category', 'interest_rate_type'])) {
                $sanitized_value = sanitize_text_field($value);
            } else {
                $sanitized_value = sanitize_text_field($value);
            }

            // Save or delete meta
            if ($value === '' || (is_numeric($sanitized_value) && $value === '')) { 
                 delete_post_meta($post_id, $meta_key);
            } elseif (is_numeric($sanitized_value) || !empty($sanitized_value)) {
                 update_post_meta($post_id, $meta_key, $sanitized_value);
            } else {
                 delete_post_meta($post_id, $meta_key);
            }

        } else {
             if (in_array($field_name, [
                'base_interest_rate_pa', 'processing_fee_flat', 'sinking_fund_percentage', 'appraisal_fee_percentage',
                'loan_policy_category', 'interest_rate_type',
                'refinance_charge_percentage', 'salary_advance_one_off_rate', 'salary_advance_compounded_rate',
                'instant_loan_charge_percentage', 'loan_factor_deposits', 'minimum_deposit_requirement',
                'repayment_period_part_timers_permanent_months', 'repayment_period_others_months',
                'repayment_period_supersavers_months', 'repayment_period_school_fees_months',
                'repayment_period_instant_loan_months', 'repayment_period_emergency_loan_months',
                'repayment_period_salary_advance_months',
                'max_loan_development', 'max_loan_super_saver', 'max_loan_instant',
                'max_loan_emergency', 'max_loan_special',
                'defer_charge_flat', 'defer_penalty_percentage', 'bounced_cheque_fee_flat'
                ])) {
                 delete_post_meta($post_id, $meta_key);
             }
        }
    }
    
    // Handle checkbox for 'requires_postdated_cheques'
    if (isset($_POST['requires_postdated_cheques']) && $_POST['requires_postdated_cheques'] === '1') {
        update_post_meta($post_id, 'requires_postdated_cheques', '1');
    } else {
        delete_post_meta($post_id, 'requires_postdated_cheques');
    }
    
    // Handle checkbox for 'requires_shares_for_application'
    if (isset($_POST['requires_shares_for_application']) && $_POST['requires_shares_for_application'] === '1') {
        update_post_meta($post_id, 'requires_shares_for_application', '1');
    } else {
        update_post_meta($post_id, 'requires_shares_for_application', '0');
    }

    // Handle Special Loan Repayment Configuration (3 tiers)
    for ($i = 1; $i <= 3; $i++) {
        $amount_limit_key = "special_loan_config_{$i}_amount_limit";
        $repayment_period_key = "special_loan_config_{$i}_repayment_period";

        $amount_limit_value = isset($_POST[$amount_limit_key]) ? intval($_POST[$amount_limit_key]) : '';
        $repayment_period_value = isset($_POST[$repayment_period_key]) ? intval($_POST[$repayment_period_key]) : '';

        if ($amount_limit_value !== '' && $repayment_period_value !== '') {
            update_post_meta($post_id, $amount_limit_key, $amount_limit_value);
            update_post_meta($post_id, $repayment_period_key, $repayment_period_value);
        } else {
            delete_post_meta($post_id, $amount_limit_key);
            delete_post_meta($post_id, $repayment_period_key);
        }
    }
}
add_action('save_post_loan', 'sacco_php_save_loan_meta_box_data');

/**
 * Add WhatsApp Floating Button
 */
function sacco_php_add_whatsapp_button() {
    // Get WhatsApp number from theme options or use default
    $whatsapp_number = get_theme_mod('whatsapp_number', '+254700000000');
    
    // Get pre-filled message from theme options or use default
    $whatsapp_message = get_theme_mod('whatsapp_message', 'Hello! I have a question about Sacco services.');
    
    // Encode message for URL
    $encoded_message = urlencode($whatsapp_message);
    
    // Generate WhatsApp link
    $whatsapp_link = "https://wa.me/{$whatsapp_number}?text={$encoded_message}";
    
    // Output the floating button HTML
    echo '<a href="' . esc_url($whatsapp_link) . '" class="whatsapp-float" target="_blank" rel="noopener noreferrer">';
    echo '<i class="fab fa-whatsapp"></i>';
    echo '</a>';
}
add_action('wp_footer', 'sacco_php_add_whatsapp_button');

/**
 * Register Savings Goal Custom Post Type
 */
function sacco_php_register_goal_post_type() {
    $labels = array(
        'name'                  => _x('Savings Goals', 'Post type general name', 'sacco-php'),
        'singular_name'         => _x('Savings Goal', 'Post type singular name', 'sacco-php'),
        'menu_name'             => _x('Savings Goals', 'Admin Menu text', 'sacco-php'),
        'name_admin_bar'        => _x('Savings Goal', 'Add New on Toolbar', 'sacco-php'),
        'add_new'               => __('Add New', 'sacco-php'),
        'add_new_item'          => __('Add New Savings Goal', 'sacco-php'),
        'new_item'              => __('New Savings Goal', 'sacco-php'),
        'edit_item'             => __('Edit Savings Goal', 'sacco-php'),
        'view_item'             => __('View Savings Goal', 'sacco-php'),
        'all_items'             => __('All Savings Goals', 'sacco-php'),
        'search_items'          => __('Search Savings Goals', 'sacco-php'),
        'not_found'             => __('No savings goals found.', 'sacco-php'),
        'not_found_in_trash'    => __('No savings goals found in Trash.', 'sacco-php'),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'savings-product'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-piggy-bank',
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    );
    register_post_type('savings', $args);
}
add_action('init', 'sacco_php_register_savings_cpt');



/**
 * Enqueue custom styles and scripts with version parameter for cache busting
 */
function daystar_enqueue_custom_styles_and_scripts() {
    // Enqueue custom CSS with version parameter for cache busting
    wp_enqueue_style(
        'daystar-custom-styles',
        get_template_directory_uri() . '/assets/css/daystar-styles.css',
        array(),
        time() // Use current timestamp to force cache refresh
    );
    
    // Enqueue custom JavaScript with version parameter for cache busting
    wp_enqueue_script(
        'daystar-custom-scripts',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        time(), // Use current timestamp to force cache refresh
        true // Load in footer
    );
    
    // Enqueue Bootstrap JS if not already included
    if (!wp_script_is('bootstrap', 'enqueued')) {
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            '5.1.3',
            true
        );
    }
    
    // Enqueue Font Awesome if not already included
    if (!wp_script_is('font-awesome', 'enqueued')) {
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
            array(),
            '5.15.4'
        );
    }
}
add_action('wp_enqueue_scripts', 'daystar_enqueue_custom_styles_and_scripts', 999); // High priority to override theme defaults

/**
 * Fix navbar menu functionality
 */
function daystar_fix_navbar_menu() {
    // Add theme support for menus if not already added
    if (!current_theme_supports('menus')) {
        add_theme_support('menus');
    }
    
    // Register navigation menus if not already registered
    if (!has_nav_menu('primary')) {
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'daystar'),
            'footer' => __('Footer Menu', 'daystar'),
        ));
    }
    
    // Add custom menu walker class for Bootstrap 5 compatibility
    if (!class_exists('Daystar_Bootstrap_Navwalker')) {
        /**
         * Bootstrap 5 Nav Walker
         */
        class Daystar_Bootstrap_Navwalker extends Walker_Nav_Menu {
            /**
             * Starts the element output.
             */
            public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
                $indent = ($depth) ? str_repeat("\t", $depth) : '';
                
                $classes = empty($item->classes) ? array() : (array) $item->classes;
                $classes[] = 'nav-item';
                
                // Add .dropdown class to items with children
                if ($args->walker->has_children) {
                    $classes[] = 'dropdown';
                }
                
                $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
                $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                
                $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
                $id = $id ? ' id="' . esc_attr($id) . '"' : '';
                
                $output .= $indent . '<li' . $id . $class_names .'>';
                
                $atts = array();
                $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
                $atts['target'] = !empty($item->target) ? $item->target : '';
                $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
                $atts['href']   = !empty($item->url) ? $item->url : '';
                
                // Add Bootstrap 5 attributes for dropdown toggle
                if ($args->walker->has_children) {
                    $atts['class'] = 'nav-link dropdown-toggle';
                    $atts['id'] = 'navbarDropdown' . $item->ID;
                    $atts['role'] = 'button';
                    $atts['data-bs-toggle'] = 'dropdown';
                    $atts['aria-expanded'] = 'false';
                } else {
                    $atts['class'] = $depth > 0 ? 'dropdown-item' : 'nav-link';
                }
                
                $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
                
                $attributes = '';
                foreach ($atts as $attr => $value) {
                    if (!empty($value)) {
                        $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }
                
                $title = apply_filters('the_title', $item->title, $item->ID);
                $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
                
                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
                
                // Add dropdown menu wrapper
                if ($args->walker->has_children) {
                    $item_output .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown' . $item->ID . '">';
                }
                
                $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }
            
            /**
             * Ends the element output.
             */
            public function end_el(&$output, $item, $depth = 0, $args = array()) {
                $output .= "</li>\n";
            }
            
            /**
             * Starts the list before the elements are added.
             */
            public function start_lvl(&$output, $depth = 0, $args = array()) {
                $indent = str_repeat("\t", $depth);
                $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
            }
            
            /**
             * Ends the list of after the elements are added.
             */
            public function end_lvl(&$output, $depth = 0, $args = array()) {
                $indent = str_repeat("\t", $depth);
                $output .= "$indent</ul>\n";
            }
        }
    }
}
add_action('after_setup_theme', 'daystar_fix_navbar_menu');

/**
 * Add inline JavaScript fixes to handle theme-specific issues
 */
function daystar_add_inline_js_fixes() {
    $custom_js = "
        jQuery(document).ready(function($) {
            // Fix dropdown menus
            $('.dropdown-toggle').on('click', function(e) {
                if (!$(this).parent().hasClass('show')) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).parent().toggleClass('show');
                    $(this).next('.dropdown-menu').toggleClass('show');
                }
            });
            
            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown').removeClass('show');
                    $('.dropdown-menu').removeClass('show');
                }
            });
            
            // Fix mobile menu toggle
            $('.navbar-toggler').on('click', function() {
                $('.navbar-collapse').toggleClass('show');
            });
            
            // Initialize WhatsApp button if not exists
            if ($('.whatsapp-button').length === 0) {
                $('body').append('<a href=\"https://wa.me/254731629716\" class=\"whatsapp-button\" target=\"_blank\" rel=\"noopener noreferrer\" aria-label=\"Contact us on WhatsApp\"><i class=\"fab fa-whatsapp\"></i></a>');
            }
            
            // Fix preloader
            if ($('#preloader').length > 0) {
                setTimeout(function() {
                    $('#preloader').fadeOut('slow');
                }, 1000);
            }
        });
    ";
    
    wp_add_inline_script('daystar-custom-scripts', $custom_js);
}
add_action('wp_enqueue_scripts', 'daystar_add_inline_js_fixes', 1000); // High priority

/**
 * Add custom login/registration links to replace non-functional ones
 */
function daystar_replace_login_register_links() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Replace login button with WordPress login link
            $('.member-login-btn, .btn-login, a:contains("LOGIN")').attr('href', '<?php echo esc_url(wp_login_url()); ?>');
            
            // Replace registration links with WordPress registration link
            $('a:contains("Register"), a:contains("REGISTER"), a:contains("Become a Member")').attr('href', '<?php echo esc_url(wp_registration_url()); ?>');
        });
    </script>
    <?php
}
add_action('wp_footer', 'daystar_replace_login_register_links');

/**
 * Clear cache on plugin activation
 */
function daystar_clear_cache_on_activation() {
    // Clear WordPress object cache
    wp_cache_flush();
    
    // Clear any page caching
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }
    
    // Clear Autoptimize cache if plugin is active
    if (class_exists('autoptimizeCache')) {
        autoptimizeCache::clearall();
    }
    
    // Clear W3 Total Cache if plugin is active
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
}
register_activation_hook(__FILE__, 'daystar_clear_cache_on_activation');

/**
 * Add this code to functions.php or create a plugin
 */
// End of WordPress Login and Registration Functionality section

/**
 * Customize the WordPress login page
 */
function daystar_custom_login_page() {
    // Enqueue custom login page styles
    wp_enqueue_style(
        'daystar-custom-login-page',
        get_template_directory_uri() . '/assets/css/components/login-page.css',
        array(),
        time() // Or a specific version number
    );
}
add_action('login_head', 'daystar_custom_login_page');

/**
 * Change the login logo URL to point to the site's homepage
 */
function daystar_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'daystar_login_logo_url');

/**
 * Change the login logo title
 */
function daystar_login_logo_title() {
    return 'Daystar Multi-Purpose Co-op Society Ltd.';
}
add_filter('login_headertext', 'daystar_login_logo_title');

/**
 * Redirect users after login based on role
 */
function daystar_login_redirect($redirect_to, $request, $user) {
    // If user is an admin, redirect to admin dashboard
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        } else {
            // For regular members, redirect to member dashboard
            return home_url('/member-dashboard/');
        }
    }
    
    // Default redirect
    return $redirect_to;
}
add_filter('login_redirect', 'daystar_login_redirect', 10, 3);

/**
 * Add custom fields to registration form
 */
function daystar_custom_registration_fields() {
    // Only add these fields on the registration page
    if ('wp-login.php' == $GLOBALS['pagenow'] && isset($_REQUEST['action']) && $_REQUEST['action'] == 'register') {
        ?>
        <style type="text/css">
            #registerform p {
                margin-bottom: 15px;
            }
            
            #registerform .form-field {
                margin-bottom: 15px;
            }
            
            #registerform label {
                display: block;
                margin-bottom: 5px;
            }
            
            #registerform input[type="text"],
            #registerform input[type="tel"],
            #registerform input[type="number"] {
                width: 100%;
                padding: 5px;
                font-size: 14px;
            }
            
            #registerform .description {
                font-size: 12px;
                color: #666;
                margin-top: 3px;
            }
            
            #registerform .required {
                color: red;
            }
        </style>
        
        <p class="form-field">
            <label for="first_name">First Name <span class="required">*</span></label>
            <input type="text" name="first_name" id="first_name" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="last_name">Last Name <span class="required">*</span></label>
            <input type="text" name="last_name" id="last_name" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="phone">Phone Number <span class="required">*</span></label>
            <input type="tel" name="phone" id="phone" class="input" required />
            <span class="description">Enter your phone number registered with M-Pesa</span>
        </p>
        
        <p class="form-field">
            <label for="id_number">ID Number <span class="required">*</span></label>
            <input type="text" name="id_number" id="id_number" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="initial_contribution">Initial Contribution (KSh) <span class="required">*</span></label>
            <input type="number" name="initial_contribution" id="initial_contribution" class="input" min="12000" value="12000" required />
            <span class="description">Minimum contribution is KSh 12,000</span>
        </p>
        
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Add validation to the registration form
                var registerForm = document.getElementById('registerform');
                if (registerForm) {
                    registerForm.addEventListener('submit', function(e) {
                        var firstName = document.getElementById('first_name').value;
                        var lastName = document.getElementById('last_name').value;
                        var phone = document.getElementById('phone').value;
                        var idNumber = document.getElementById('id_number').value;
                        var initialContribution = document.getElementById('initial_contribution').value;
                        
                        var errors = [];
                        
                        if (!firstName) {
                            errors.push('First name is required');
                        }
                        
                        if (!lastName) {
                            errors.push('Last name is required');
                        }
                        
                        if (!phone) {
                            errors.push('Phone number is required');
                        }
                        
                        if (!idNumber) {
                            errors.push('ID number is required');
                        }
                        
                        if (!initialContribution || initialContribution < 12000) {
                            errors.push('Initial contribution must be at least KSh 12,000');
                        }
                        
                        if (errors.length > 0) {
                            e.preventDefault();
                            alert(errors.join('\\n'));
                        }
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('login_form_register', 'daystar_custom_registration_fields');

/**
 * Save custom registration fields
 */
function daystar_save_custom_registration_fields($user_id) {
    if (isset($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }
    
    if (isset($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
    
    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    
    if (isset($_POST['id_number'])) {
        update_user_meta($user_id, 'id_number', sanitize_text_field($_POST['id_number']));
    }
    
    if (isset($_POST['initial_contribution'])) {
        update_user_meta($user_id, 'initial_contribution', sanitize_text_field($_POST['initial_contribution']));
    }
    
    // Generate a unique member number
    $member_number = 'DST' . date('Y') . rand(1000, 9999);
    update_user_meta($user_id, 'member_number', $member_number);
    
    // Set user role to "member"
    $user = new WP_User($user_id);
    $user->set_role('member'); // Make sure this role exists or use 'subscriber'
}
add_action('user_register', 'daystar_save_custom_registration_fields');

/**
 * Create custom member role if it doesn't exist
 */
function daystar_create_member_role() {
    // Check if the role already exists
    if (!get_role('member')) {
        // Create the member role with same capabilities as subscriber
        add_role(
            'member',
            __('Member'),
            get_role('subscriber')->capabilities
        );
    }
}
add_action('init', 'daystar_create_member_role');

/**
 * Add shortcode to display member dashboard
 */
function daystar_member_dashboard_shortcode() {
    // Enqueue member dashboard styles
    wp_enqueue_style(
        'daystar-member-dashboard',
        get_template_directory_uri() . '/assets/css/components/member-dashboard.css',
        array(),
        time() // Or a specific version number
    );

    // Check if user is logged in
    if (!is_user_logged_in()) {
        return '<div class="alert alert-warning">Please <a href="' . wp_login_url() . '">login</a> to view your dashboard.</div>';
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $member_number = get_user_meta($current_user->ID, 'member_number', true);
    $first_name = get_user_meta($current_user->ID, 'first_name', true);
    $last_name = get_user_meta($current_user->ID, 'last_name', true);
    $phone = get_user_meta($current_user->ID, 'phone', true);
    $initial_contribution = get_user_meta($current_user->ID, 'initial_contribution', true);
    
    // Build dashboard HTML
    $output = '<div class="member-dashboard">';
    
    // Welcome section
    $output .= '<div class="dashboard-welcome">';
    $output .= '<h2>Welcome, ' . esc_html($first_name) . '!</h2>';
    $output .= '<p>Member Number: <strong>' . esc_html($member_number) . '</strong></p>';
    $output .= '</div>';
    
    // Dashboard tabs
    $output .= '<div class="dashboard-tabs">';
    $output .= '<ul class="nav nav-tabs" id="memberDashboardTabs" role="tablist">';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="savings-tab" data-bs-toggle="tab" data-bs-target="#savings" type="button" role="tab" aria-controls="savings" aria-selected="false">Savings</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab" aria-controls="loans" aria-selected="false">Loans</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button></li>';
    $output .= '</ul>';
    
    // Tab content
    $output .= '<div class="tab-content" id="memberDashboardTabContent">';
    
    // Overview tab
    $output .= '<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">';
    $output .= '<div class="dashboard-cards">';
    $output .= '<div class="row">';
    
    // Savings card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Total Savings</h5>';
    $output .= '<h3 class="card-value">KSh ' . number_format($initial_contribution, 2) . '</h3>';
    $output .= '<a href="#savings" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#savings">View Details</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Loans card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Active Loans</h5>';
    $output .= '<h3 class="card-value">0</h3>';
    $output .= '<a href="#loans" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#loans">View Details</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Eligibility card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Loan Eligibility</h5>';
    $output .= '<h3 class="card-value">KSh ' . number_format($initial_contribution * 3, 2) . '</h3>';
    $output .= '<a href="#loans" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#loans">Apply for Loan</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End row
    $output .= '</div>'; // End dashboard-cards
    
    // Recent transactions
    $output .= '<div class="recent-transactions mt-4">';
    $output .= '<h4>Recent Transactions</h4>';
    $output .= '<div class="table-responsive">';
    $output .= '<table class="table table-striped">';
    $output .= '<thead><tr><th>Date</th><th>Description</th><th>Amount</th><th>Status</th></tr></thead>';
    $output .= '<tbody>';
    $output .= '<tr><td>' . date('Y-m-d') . '</td><td>Initial Contribution</td><td>KSh ' . number_format($initial_contribution, 2) . '</td><td><span class="badge bg-success">Completed</span></td></tr>';
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End overview tab
    
    // Savings tab
    $output .= '<div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="savings-tab">';
    $output .= '<h4>Savings Summary</h4>';
    $output .= '<div class="table-responsive">';
    $output .= '<table class="table table-striped">';
    $output .= '<thead><tr><th>Type</th><th>Amount</th><th>Last Contribution</th></tr></thead>';
    $output .= '<tbody>';
    $output .= '<tr><td>Regular Savings</td><td>KSh ' . number_format($initial_contribution, 2) . '</td><td>' . date('Y-m-d') . '</td></tr>';
    $output .= '<tr><td>Share Capital</td><td>KSh 5,000.00</td><td>' . date('Y-m-d') . '</td></tr>';
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>';
    
    // Make contribution button
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/payment/') . '" class="btn btn-primary">Make Contribution</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End savings tab
    
    // Loans tab
    $output .= '<div class="tab-pane fade" id="loans" role="tabpanel" aria-labelledby="loans-tab">';
    $output .= '<h4>Loan Products</h4>';
    $output .= '<div class="row">';
    
    // Development Loan
    $output .= '<div class="col-md-6 mb-4">';
    $output .= '<div class="card h-100">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Development Loan</h5>';
    $output .= '<ul class="list-unstyled">';
    $output .= '<li>Up to KSh 2,000,000</li>';
    $output .= '<li>36 months repayment period</li>';
    $output .= '<li>12% interest per annum</li>';
    $output .= '<li>Maximum of 3 times member\'s deposits</li>';
    $output .= '</ul>';
    $output .= '<a href="' . home_url('/loan-application/?type=development') . '" class="btn btn-primary">Apply Now</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Emergency Loan
    $output .= '<div class="col-md-6 mb-4">';
    $output .= '<div class="card h-100">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Emergency Loan</h5>';
    $output .= '<ul class="list-unstyled">';
    $output .= '<li>Up to KSh 100,000</li>';
    $output .= '<li>12 months repayment period</li>';
    $output .= '<li>12% interest per annum</li>';
    $output .= '<li>Maximum of 1.5 times member\'s deposits</li>';
    $output .= '</ul>';
    $output .= '<a href="' . home_url('/loan-application/?type=emergency') . '" class="btn btn-primary">Apply Now</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End row
    
    // View all loan products link
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/products-services/') . '" class="btn btn-outline-primary">View All Loan Products</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End loans tab
    
    // Profile tab
    $output .= '<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">';
    $output .= '<h4>Personal Information</h4>';
    $output .= '<div class="row">';
    $output .= '<div class="col-md-6">';
    $output .= '<p><strong>Name:</strong> ' . esc_html($first_name . ' ' . $last_name) . '</p>';
    $output .= '<p><strong>Member Number:</strong> ' . esc_html($member_number) . '</p>';
    $output .= '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>';
    $output .= '</div>';
    $output .= '<div class="col-md-6">';
    $output .= '<p><strong>Email:</strong> ' . esc_html($current_user->user_email) . '</p>';
    $output .= '<p><strong>ID Number:</strong> ' . esc_html(get_user_meta($current_user->ID, 'id_number', true)) . '</p>';
    $output .= '<p><strong>Membership Date:</strong> ' . date('Y-m-d', strtotime($current_user->user_registered)) . '</p>';
    $output .= '</div>';
    $output .= '</div>'; // End row
    

    
    // Update profile button
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/edit-profile/') . '" class="btn btn-primary">Update Profile</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End profile tab
    
    $output .= '</div>'; // End tab content
    $output .= '</div>'; // End dashboard-tabs
    
    $output .= '</div>'; // End member-dashboard
    
    return $output;
}
add_shortcode('member_dashboard', 'daystar_member_dashboard_shortcode');

/**
 * Add shortcode to display login form
 */
function daystar_login_form_shortcode() {
    // Enqueue login form styles
    wp_enqueue_style(
        'daystar-login-form',
        get_template_directory_uri() . '/assets/css/components/login-form.css',
        array(),
        time() // Or a specific version number
    );

    if (is_user_logged_in()) {
        return '<div class="alert alert-info">You are already logged in. <a href="' . home_url('/member-dashboard/') . '">Go to Dashboard</a> or <a href="' . wp_logout_url(home_url()) . '">Logout</a></div>';
    }
    
    $args = array(
        'echo'           => false,
        'remember'       => true,
        'redirect'       => home_url('/member-dashboard/'),
        'form_id'        => 'loginform',
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'label_username' => __('Username or Email Address'),
        'label_password' => __('Password'),
        'label_remember' => __('Remember Me'),
        'label_log_in'   => __('Log In'),
        'value_username' => '',
        'value_remember' => false
    );
    
    $login_form = wp_login_form($args);
    
    // Add custom styling and registration link
    $output = '<div class="custom-login-form">';
    $output .= '<h2>Member Login</h2>';
    $output .= '<p>Access your account to view your savings, loans, and more</p>';
    $output .= $login_form;
    $output .= '<div class="login-links">';
    $output .= '<p><a href="' . wp_lostpassword_url() . '">Forgot your password?</a></p>';
    $output .= '<p>Don\'t have an account? <a href="' . wp_registration_url() . '">Register Now</a></p>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}
add_shortcode('login_form', 'daystar_login_form_shortcode');

/**
 * Add shortcode to display registration form
 */
function daystar_registration_form_shortcode() {
    // Enqueue registration form styles
    wp_enqueue_style(
        'daystar-registration-form',
        get_template_directory_uri() . '/assets/css/components/registration-form.css',
        array(),
        time() // Or a specific version number
    );

    if (is_user_logged_in()) {
        return '<div class="alert alert-info">You are already registered and logged in. <a href="' . home_url('/member-dashboard/') . '">Go to Dashboard</a></div>';
    }
    
    if (!get_option('users_can_register')) {
        return '<div class="alert alert-warning">Registration is currently disabled. Please contact the administrator.</div>';
    }
    
    // Check if form was submitted
    if (isset($_POST['daystar_register_nonce']) && wp_verify_nonce($_POST['daystar_register_nonce'], 'daystar_register_user')) {
        $user_login = sanitize_user($_POST['user_login']);
        $user_email = sanitize_email($_POST['user_email']);
        $user_pass = $_POST['user_pass'];
        $pass_confirm = $_POST['pass_confirm'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $phone = sanitize_text_field($_POST['phone']);
        $id_number = sanitize_text_field($_POST['id_number']);
        $initial_contribution = intval($_POST['initial_contribution']);
        
        $errors = array();
        
        // Validate fields
        if (empty($user_login)) {
            $errors[] = 'Username is required';
        }
        
        if (empty($user_email)) {
            $errors[] = 'Email is required';
        } elseif (!is_email($user_email)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($user_pass)) {
            $errors[] = 'Password is required';
        }
        
        if ($user_pass !== $pass_confirm) {
            $errors[] = 'Passwords do not match';
        }
        
        if (empty($first_name)) {
            $errors[] = 'First name is required';
        }
        
        if (empty($last_name)) {
            $errors[] = 'Last name is required';
        }
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if (empty($id_number)) {
            $errors[] = 'ID number is required';
        }
        
        if ($initial_contribution < 12000) {
            $errors[] = 'Initial contribution must be at least KSh 12,000';
        }
        
        // Check if username exists
        if (username_exists($user_login)) {
            $errors[] = 'Username already exists';
        }
        
        // Check if email exists
        if (email_exists($user_email)) {
            $errors[] = 'Email already exists';
        }
        
        // If no errors, register user
        if (empty($errors)) {
            $user_id = wp_create_user($user_login, $user_pass, $user_email);
            
            if (!is_wp_error($user_id)) {
                // Update user meta
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                update_user_meta($user_id, 'phone', $phone);
                update_user_meta($user_id, 'id_number', $id_number);
                update_user_meta($user_id, 'initial_contribution', $initial_contribution);
                
                // Generate a unique member number
                $member_number = 'DST' . date('Y') . rand(1000, 9999);
                update_user_meta($user_id, 'member_number', $member_number);
                
                // Set user role to "member"
                $user = new WP_User($user_id);
                $user->set_role('member'); // Make sure this role exists or use 'subscriber'
                
                // Log the user in
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
                
                // Redirect to payment page
                wp_redirect(home_url('/payment/?type=registration&amount=' . $initial_contribution));
                exit;
            } else {
                $errors[] = $user_id->get_error_message();
            }
        }
    }
    
    // Display registration form
    $output = '<div class="custom-registration-form">';
    
    // Display errors if any
    if (!empty($errors)) {
        $output .= '<div class="alert alert-danger"><ul>';
        foreach ($errors as $error) {
            $output .= '<li>' . esc_html($error) . '</li>';
        }
        $output .= '</ul></div>';
    }
    
    $output .= '<h2>Become a Member</h2>';
    $output .= '<p>Join our cooperative society and enjoy exclusive benefits</p>';
    
    $output .= '<form id="daystar_registration_form" method="post" action="">';
    $output .= wp_nonce_field('daystar_register_user', 'daystar_register_nonce', true, false);
    
    // Account Information
    $output .= '<h4>Account Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_login">Username <span class="required">*</span></label>';
    $output .= '<input type="text" name="user_login" id="user_login" class="form-control" value="' . (isset($_POST['user_login']) ? esc_attr($_POST['user_login']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_email">Email <span class="required">*</span></label>';
    $output .= '<input type="email" name="user_email" id="user_email" class="form-control" value="' . (isset($_POST['user_email']) ? esc_attr($_POST['user_email']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_pass">Password <span class="required">*</span></label>';
    $output .= '<input type="password" name="user_pass" id="user_pass" class="form-control" required />';
    $output .= '<small class="form-text text-muted">Password must be at least 8 characters long</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="pass_confirm">Confirm Password <span class="required">*</span></label>';
    $output .= '<input type="password" name="pass_confirm" id="pass_confirm" class="form-control" required />';
    $output .= '</div>';
    
    // Personal Information
    $output .= '<h4 class="mt-4">Personal Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="first_name">First Name <span class="required">*</span></label>';
    $output .= '<input type="text" name="first_name" id="first_name" class="form-control" value="' . (isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="last_name">Last Name <span class="required">*</span></label>';
    $output .= '<input type="text" name="last_name" id="last_name" class="form-control" value="' . (isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="phone">Phone Number <span class="required">*</span></label>';
    $output .= '<input type="tel" name="phone" id="phone" class="form-control" value="' . (isset($_POST['phone']) ? esc_attr($_POST['phone']) : '') . '" required />';
    $output .= '<small class="form-text text-muted">Enter your phone number registered with M-Pesa</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="id_number">ID Number <span class="required">*</span></label>';
    $output .= '<input type="text" name="id_number" id="id_number" class="form-control" value="' . (isset($_POST['id_number']) ? esc_attr($_POST['id_number']) : '') . '" required />';
    $output .= '</div>';
    
    // Contribution Information
    $output .= '<h4 class="mt-4">Contribution Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="initial_contribution">Initial Contribution (KSh) <span class="required">*</span></label>';
    $output .= '<input type="number" name="initial_contribution" id="initial_contribution" class="form-control" min="12000" value="' . (isset($_POST['initial_contribution']) ? esc_attr($_POST['initial_contribution']) : '12000') . '" required />';
    $output .= '<small class="form-text text-muted">Minimum contribution is KSh 12,000</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group form-check mt-4">';
    $output .= '<input type="checkbox" name="terms_agreement" id="terms_agreement" class="form-check-input" required />';
    $output .= '<label class="form-check-label" for="terms_agreement">I agree to the <a href="' . home_url('/terms-conditions/') . '" target="_blank">Terms and Conditions</a> and <a href="' . home_url('/privacy-policy/') . '" target="_blank">Privacy Policy</a></label>';
    $output .= '</div>';
    
    $output .= '<div class="form-group mt-4">';
    $output .= '<button type="submit" class="btn btn-primary btn-block">Register</button>';
    $output .= '</div>';
    
    $output .= '</form>';
    
    $output .= '<div class="login-link mt-4 text-center">';
    $output .= '<p>Already have an account? <a href="' . wp_login_url() . '">Login Now</a></p>';
    $output .= '</div>';
    
    $output .= '</div>'; // End custom-registration-form
    
    // Add validation script
    $output .= '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("daystar_registration_form");
            
            if (form) {
                form.addEventListener("submit", function(e) {
                    var userPass = document.getElementById("user_pass").value;
                    var passConfirm = document.getElementById("pass_confirm").value;
                    var termsAgreement = document.getElementById("terms_agreement").checked;
                    var initialContribution = document.getElementById("initial_contribution").value;
                    
                    var errors = [];
                    
                    if (userPass.length < 8) {
                        errors.push("Password must be at least 8 characters long");
                    }
                    
                    if (userPass !== passConfirm) {
                        errors.push("Passwords do not match");
                    }
                    
                    if (!termsAgreement) {
                        errors.push("You must agree to the terms and conditions");
                    }
                    
                    if (initialContribution < 12000) {
                        errors.push("Initial contribution must be at least KSh 12,000");
                    }
                    
                    if (errors.length > 0) {
                        e.preventDefault();
                        alert(errors.join("\\n"));
                    }
                });
            }
        });
    </script>';
    
    return $output;
}
add_shortcode('registration_form', 'daystar_registration_form_shortcode');

/**
  */
// End of M-Pesa Payment Integration section

/**
 * Register M-Pesa settings page in WordPress admin
 */
function daystar_mpesa_register_settings_page() {
    add_options_page(
        'M-Pesa Settings',
        'M-Pesa Settings',
        'manage_options',
        'daystar-mpesa-settings',
        'daystar_mpesa_settings_page_callback'
    );
}
add_action('admin_menu', 'daystar_mpesa_register_settings_page');

/**
 * Register M-Pesa settings
 */
function daystar_mpesa_register_settings() {
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_key');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_secret');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_shortcode');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_passkey');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_environment');
}
add_action('admin_init', 'daystar_mpesa_register_settings');

/**
 * M-Pesa settings page callback
 */
function daystar_mpesa_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>M-Pesa Integration Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('daystar_mpesa_settings_group'); ?>
            <?php do_settings_sections('daystar_mpesa_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Environment</th>
                    <td>
                        <select name="daystar_mpesa_environment">
                            <option value="sandbox" <?php selected(get_option('daystar_mpesa_environment'), 'sandbox'); ?>>Sandbox (Testing)</option>
                            <option value="production" <?php selected(get_option('daystar_mpesa_environment'), 'production'); ?>>Production (Live)</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Key</th>
                    <td><input type="text" name="daystar_mpesa_consumer_key" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_key')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Secret</th>
                    <td><input type="password" name="daystar_mpesa_consumer_secret" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_secret')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Shortcode (Paybill/Till Number)</th>
                    <td><input type="text" name="daystar_mpesa_shortcode" value="<?php echo esc_attr(get_option('daystar_mpesa_shortcode')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Passkey</th>
                    <td><input type="password" name="daystar_mpesa_passkey" value="<?php echo esc_attr(get_option('daystar_mpesa_passkey')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <div class="card">
            <h2>M-Pesa Integration Instructions</h2>
            <p>To set up M-Pesa integration:</p>
            <ol>
                <li>Register for a Safaricom Developer Account at <a href="https://developer.safaricom.co.ke/" target="_blank">https://developer.safaricom.co.ke/</a></li>
                <li>Create a new app and get your Consumer Key and Consumer Secret</li>
                <li>Set up your callback URL in the Safaricom Developer Portal to: <code><?php echo home_url('/mpesa-callback/'); ?></code></li>
                <li>Enter your credentials above and save changes</li>
                <li>Use the <code>[mpesa_payment_form]</code> shortcode on any page to display the payment form</li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * M-Pesa API Class
 */
class Daystar_MPesa_API {
    /**
     * Get base URL based on environment
     */
    public static function get_base_url() {
        $environment = get_option('daystar_mpesa_environment', 'sandbox');
        return $environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }
    
    /**
     * Generate access token
     */
    public static function get_access_token() {
        $consumer_key = get_option('daystar_mpesa_consumer_key');
        $consumer_secret = get_option('daystar_mpesa_consumer_secret');
        
        if (empty($consumer_key) || empty($consumer_secret)) {
            return new WP_Error('missing_credentials', 'M-Pesa API credentials are not configured');
        }
        
        $url = self::get_base_url() . '/oauth/v1/generate?grant_type=client_credentials';
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret)
            )
        );
        
        $response = wp_remote_get($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body);
        
        if (isset($result->access_token)) {
            return $result->access_token;
        } else {
            return new WP_Error('token_error', 'Failed to get access token: ' . $body);
        }
    }
    
    /**
     * Initiate STK Push
     */
    public static function initiate_stk_push($phone, $amount, $reference, $description) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpush/v1/processrequest';
        
        // Format phone number (remove leading 0 and add country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => home_url('/mpesa-callback/'),
            'AccountReference' => $reference,
            'TransactionDesc' => $description
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    /**
     * Check transaction status
     */
    public static function check_transaction_status($checkout_request_id) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpushquery/v1/query';
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkout_request_id
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}

/**
 * Register custom post type for M-Pesa transactions
 */
function daystar_register_mpesa_transaction_post_type() {
    $labels = array(
        'name'               => 'M-Pesa Transactions',
        'singular_name'      => 'M-Pesa Transaction',
        'menu_name'          => 'M-Pesa Transactions',
        'name_admin_bar'     => 'M-Pesa Transaction',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Transaction',
        'new_item'           => 'New Transaction',
        'edit_item'          => 'Edit Transaction',
        'view_item'          => 'View Transaction',
        'all_items'          => 'All Transactions',
        'search_items'       => 'Search Transactions',
        'parent_item_colon'  => 'Parent Transactions:',
        'not_found'          => 'No transactions found.',
        'not_found_in_trash' => 'No transactions found in Trash.'
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title')
    );
    
    register_post_type('mpesa_transaction', $args);
}
add_action('init', 'daystar_register_mpesa_transaction_post_type');

/**
 * Add custom meta boxes for M-Pesa transactions
 */
function daystar_add_mpesa_transaction_meta_boxes() {
    add_meta_box(
        'mpesa_transaction_details',
        'Transaction Details',
        'daystar_mpesa_transaction_details_callback',
        'mpesa_transaction',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'daystar_add_mpesa_transaction_meta_boxes');

/**
 * M-Pesa transaction details meta box callback
 */
function daystar_mpesa_transaction_details_callback($post) {
    $transaction_type = get_post_meta($post->ID, '_transaction_type', true);
    $amount = get_post_meta($post->ID, '_amount', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $reference = get_post_meta($post->ID, '_reference', true);
    $mpesa_receipt = get_post_meta($post->ID, '_mpesa_receipt', true);
    $checkout_request_id = get_post_meta($post->ID, '_checkout_request_id', true);
    $status = get_post_meta($post->ID, '_status', true);
    $user_id = get_post_meta($post->ID, '_user_id', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="transaction_type">Transaction Type</label></th>
            <td><?php echo esc_html($transaction_type); ?></td>
        </tr>
        <tr>
            <th><label for="amount">Amount</label></th>
            <td>KSh <?php echo esc_html(number_format($amount, 2)); ?></td>
        </tr>
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <tr>
            <th><label for="reference">Reference</label></th>
            <td><?php echo esc_html($reference); ?></td>
        </tr>
        <tr>
            <th><label for="mpesa_receipt">M-Pesa Receipt</label></th>
            <td><?php echo esc_html($mpesa_receipt); ?></td>
        </tr>
        <tr>
            <th><label for="checkout_request_id">Checkout Request ID</label></th>
            <td><?php echo esc_html($checkout_request_id); ?></td>
        </tr>
        <tr>
            <th><label for="status">Status</label></th>
            <td>
                <?php
                $status_class = '';
                switch ($status) {
                    case 'pending':
                        $status_class = 'pending';
                        break;
                    case 'completed':
                        $status_class = 'completed';
                        break;
                    case 'failed':
                        $status_class = 'failed';
                        break;
                }
                ?>
                <span class="status-<?php echo $status_class; ?>"><?php echo esc_html(ucfirst($status)); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_id">User</label></th>
            <td>
                <?php
                if ($user_id) {
                    $user = get_user_by('id', $user_id);
                    if ($user) {
                        echo '<a href="' . esc_url(get_edit_user_link($user_id)) . '">' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</a>';
                    } else {
                        echo 'User not found';
                    }
                } else {
                    echo 'Guest';
                }
                ?>
            </td>
        </tr>
    </table>
    <style>
        .status-pending {
            background-color: #f8dda7;
            color: #94660c;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-completed {
            background-color: #c6e1c6;
            color: #5b841b;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
    <?php
}

/**
 * Register custom endpoint for M-Pesa callback
 */
function daystar_register_mpesa_callback_endpoint() {
    add_rewrite_rule('^mpesa-callback/?$', 'index.php?mpesa_callback=1', 'top');
    add_rewrite_tag('%mpesa_callback%', '([^&]+)');
}
add_action('init', 'daystar_register_mpesa_callback_endpoint');

/**
 * Handle M-Pesa callback
 */
function daystar_handle_mpesa_callback() {
    if (get_query_var('mpesa_callback')) {
        // Get callback data
        $callback_data = file_get_contents('php://input');
        $callback_data = json_decode($callback_data, true);
        
        // Log callback data for debugging
        error_log('M-Pesa Callback: ' . print_r($callback_data, true));
        
        // Process callback data
        if (isset($callback_data['Body']['stkCallback'])) {
            $result_code = $callback_data['Body']['stkCallback']['ResultCode'];
            $result_desc = $callback_data['Body']['stkCallback']['ResultDesc'];
            $merchant_request_id = $callback_data['Body']['stkCallback']['MerchantRequestID'];
            $checkout_request_id = $callback_data['Body']['stkCallback']['CheckoutRequestID'];
            
            // Find transaction by checkout request ID
            $args = array(
                'post_type' => 'mpesa_transaction',
                'meta_query' => array(
                    array(
                        'key' => '_checkout_request_id',
                        'value' => $checkout_request_id
                    )
                )
            );
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
                $query->the_post();
                $transaction_id = get_the_ID();
                
                // Check if transaction was successful
                if ($result_code === 0) {
                    // Transaction successful
                    $callback_metadata = $callback_data['Body']['stkCallback']['CallbackMetadata']['Item'];
                    
                    // Extract transaction details
                    $amount = null;
                    $mpesa_receipt_number = null;
                    $transaction_date = null;
                    $phone_number = null;
                    
                    foreach ($callback_metadata as $item) {
                        switch ($item['Name']) {
                            case 'Amount':
                                $amount = $item['Value'];
                                break;
                            case 'MpesaReceiptNumber':
                                $mpesa_receipt_number = $item['Value'];
                                break;
                            case 'TransactionDate':
                                $transaction_date = $item['Value'];
                                break;
                            case 'PhoneNumber':
                                $phone_number = $item['Value'];
                                break;
                        }
                    }
                    
                    // Update transaction
                    update_post_meta($transaction_id, '_status', 'completed');
                    update_post_meta($transaction_id, '_mpesa_receipt', $mpesa_receipt_number);
                    update_post_meta($transaction_id, '_transaction_date', $transaction_date);
                    
                    // Get transaction type
                    $transaction_type = get_post_meta($transaction_id, '_transaction_type', true);
                    $user_id = get_post_meta($transaction_id, '_user_id', true);
                    
                    // Process based on transaction type
                    if ($transaction_type === 'contribution' && $user_id) {
                        // Update user contribution
                        $current_contribution = get_user_meta($user_id, 'total_contribution', true);
                        $new_contribution = $current_contribution ? $current_contribution + $amount : $amount;
                        update_user_meta($user_id, 'total_contribution', $new_contribution);
                        
                        // Add contribution record
                        $contribution_history = get_user_meta($user_id, 'contribution_history', true);
                        if (!$contribution_history) {
                            $contribution_history = array();
                        }
                        
                        $contribution_history[] = array(
                            'date' => current_time('mysql'),
                            'amount' => $amount,
                            'receipt' => $mpesa_receipt_number
                        );
                        
                        update_user_meta($user_id, 'contribution_history', $contribution_history);
                    } elseif ($transaction_type === 'registration' && $user_id) {
                        // Update user registration status
                        update_user_meta($user_id, 'registration_payment_status', 'completed');
                        update_user_meta($user_id, 'registration_payment_date', current_time('mysql'));
                        update_user_meta($user_id, 'registration_payment_receipt', $mpesa_receipt_number);
                        
                        // Send welcome email
                        $user = get_user_by('id', $user_id);
                        if ($user) {
                            $to = $user->user_email;
                            $subject = 'Welcome to Daystar Multi-Purpose Co-op Society Ltd.';
                            $message = "Dear " . get_user_meta($user_id, 'first_name', true) . ",\n\n";
                            $message .= "Thank you for registering with Daystar Multi-Purpose Co-op Society Ltd. Your registration payment has been received.\n\n";
                            $message .= "Your member number is: " . get_user_meta($user_id, 'member_number', true) . "\n";
                            $message .= "M-Pesa Receipt: " . $mpesa_receipt_number . "\n";
                            $message .= "Amount: KSh " . number_format($amount, 2) . "\n\n";
                            $message .= "You can now log in to your account and access all member features.\n\n";
                            $message .= "Best regards,\n";
                            $message .= "Daystar Multi-Purpose Co-op Society Ltd.";
                            
                            wp_mail($to, $subject, $message);
                        }
                    } elseif ($transaction_type === 'loan_repayment' && $user_id) {
                        // Update loan repayment
                        // This would require additional logic based on your loan management system
                    }
                } else {
                    // Transaction failed
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $result_desc);
                }
                
                wp_reset_postdata();
            }
        }
        
        // Return response to M-Pesa
        header('Content-Type: application/json');
        echo json_encode(array('ResultCode' => 0, 'ResultDesc' => 'Success'));
        exit;
    }
}
add_action('template_redirect', 'daystar_handle_mpesa_callback');

/**
 * Add shortcode to display M-Pesa payment form
 */
function daystar_mpesa_payment_form_shortcode($atts) {
    // Enqueue M-Pesa payment form styles
    wp_enqueue_style(
        'daystar-mpesa-payment-form',
        get_template_directory_uri() . '/assets/css/components/mpesa-payment-form.css',
        array(),
        time() // Or a specific version number
    );

    $atts = shortcode_atts(array(
        'type' => '',
        'amount' => '',
        'reference' => ''
    ), $atts);
    
    // Check if M-Pesa is configured
    $consumer_key = get_option('daystar_mpesa_consumer_key');
    $consumer_secret = get_option('daystar_mpesa_consumer_secret');
    $shortcode = get_option('daystar_mpesa_shortcode');
    $passkey = get_option('daystar_mpesa_passkey');
    
    if (empty($consumer_key) || empty($consumer_secret) || empty($shortcode) || empty($passkey)) {
        return '<div class="alert alert-warning">M-Pesa integration is not fully configured. Please contact the administrator.</div>';
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $phone = get_user_meta($user_id, 'phone', true);
    
    // Process form submission
    if (isset($_POST['mpesa_payment_submit']) && isset($_POST['mpesa_payment_nonce']) && wp_verify_nonce($_POST['mpesa_payment_nonce'], 'mpesa_payment_action')) {
        $payment_type = sanitize_text_field($_POST['payment_type']);
        $amount = intval($_POST['amount']);
        $phone = sanitize_text_field($_POST['phone']);
        $reference = sanitize_text_field($_POST['reference']);
        
        // Validate form data
        $errors = array();
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if ($amount <= 0) {
            $errors[] = 'Amount must be greater than zero';
        }
        
        if (empty($payment_type)) {
            $errors[] = 'Payment type is required';
        }
        
        // If no validation errors, initiate payment
        if (empty($errors)) {
            // Generate reference if not provided
            if (empty($reference)) {
                $reference = 'DST' . date('YmdHis') . rand(100, 999);
            }
            
            // Set description based on payment type
            $description = '';
            switch ($payment_type) {
                case 'contribution':
                    $description = 'Daystar Coop Contribution';
                    break;
                case 'loan_repayment':
                    $description = 'Daystar Coop Loan Repayment';
                    break;
                case 'registration':
                    $description = 'Daystar Coop Registration Fee';
                    break;
                default:
                    $description = 'Daystar Coop Payment';
            }
            
            // Create transaction record
            $transaction_id = wp_insert_post(array(
                'post_title' => $reference,
                'post_type' => 'mpesa_transaction',
                'post_status' => 'publish'
            ));
            
            if ($transaction_id) {
                update_post_meta($transaction_id, '_transaction_type', $payment_type);
                update_post_meta($transaction_id, '_amount', $amount);
                update_post_meta($transaction_id, '_phone', $phone);
                update_post_meta($transaction_id, '_reference', $reference);
                update_post_meta($transaction_id, '_status', 'pending');
                update_post_meta($transaction_id, '_user_id', $user_id);
                update_post_meta($transaction_id, '_created_at', current_time('mysql'));
                
                // Initiate STK Push
                $result = Daystar_MPesa_API::initiate_stk_push($phone, $amount, $reference, $description);
                
                if (is_wp_error($result)) {
                    $errors[] = $result->get_error_message();
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $result->get_error_message());
                } elseif (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                    // Store checkout request ID
                    update_post_meta($transaction_id, '_checkout_request_id', $result['CheckoutRequestID']);
                    
                    // Store in session for status checking
                    $_SESSION['mpesa_checkout_request_id'] = $result['CheckoutRequestID'];
                    $_SESSION['mpesa_transaction_id'] = $transaction_id;
                    
                    // Redirect to payment status page
                    wp_redirect(add_query_arg('payment_status', 'pending', home_url('/payment-status/')));
                    exit;
                } else {
                    $error_message = isset($result['errorMessage']) ? $result['errorMessage'] : 'Payment request failed. Please try again.';
                    $errors[] = $error_message;
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', $error_message);
                }
            } else {
                $errors[] = 'Failed to create transaction record';
            }
        }
    }
    
    // Display payment form
    ob_start();
    ?>
    <div class="mpesa-payment-form">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo esc_html($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form id="mpesaPaymentForm" method="post" action="">
            <?php wp_nonce_field('mpesa_payment_action', 'mpesa_payment_nonce'); ?>
            
            <div class="form-group">
                <label for="paymentType">Payment Type</label>
                <select class="form-control" id="paymentType" name="payment_type" required>
                    <option value="" selected disabled>Select payment type</option>
                    <option value="contribution" <?php selected($atts['type'], 'contribution'); ?>>Monthly Contribution</option>
                    <option value="loan_repayment" <?php selected($atts['type'], 'loan_repayment'); ?>>Loan Repayment</option>
                    <option value="registration" <?php selected($atts['type'], 'registration'); ?>>Registration Fee</option>
                    <option value="other" <?php selected($atts['type'], 'other'); ?>>Other Payment</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="amount">Amount (KSh)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">KSh</span>
                    </div>
                    <input type="number" class="form-control" id="amount" name="amount" min="1" step="1" value="<?php echo esc_attr($atts['amount']); ?>" required>
                </div>
                <small class="form-text text-muted">Enter the amount you wish to pay</small>
            </div>
            
            <div class="form-group">
                <label for="phone">M-Pesa Phone Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 0712345678" value="<?php echo esc_attr($phone); ?>" required>
                </div>
                <small class="form-text text-muted">Enter the phone number registered with M-Pesa</small>
            </div>
            
            <div class="form-group">
                <label for="reference">Reference (Optional)</label>
                <input type="text" class="form-control" id="reference" name="reference" placeholder="e.g., Invoice number, Member number" value="<?php echo esc_attr($atts['reference']); ?>">
                <small class="form-text text-muted">Enter a reference for this payment if applicable</small>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="mpesa_payment_submit" id="payButton">
                    Pay with M-Pesa
                </button>
            </div>
        </form>
        
        <div class="payment-info mt-4">
            <h5>How it works:</h5>
            <ol>
                <li>Enter your payment details and click "Pay with M-Pesa"</li>
                <li>You will receive an STK push notification on your phone</li>
                <li>Enter your M-Pesa PIN to authorize the payment</li>
                <li>You will receive an M-Pesa confirmation message</li>
                <li>Your payment will be processed and your account updated</li>
            </ol>
        </div>
        
        <div class="text-center mt-4">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/mpesa-logo.png'); ?>" alt="M-Pesa Logo" class="img-fluid mb-3" style="max-height: 60px;">
            <p class="text-muted small">
                <i class="fas fa-lock me-1"></i> Your payment information is secure and encrypted.
                Daystar Multi-Purpose Co-op Society Ltd. is an authorized M-Pesa partner.
            </p>
        </div>
    </div>
    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Format phone number
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    
                    // Ensure it starts with 0
                    if (value.length > 0 && value.charAt(0) !== '0') {
                        value = '0' + value;
                    }
                    
                    // Limit to 10 digits
                    if (value.length > 10) {
                        value = value.substring(0, 10);
                    }
                    
                    this.value = value;
                });
            }
            
            // Set minimum amount based on payment type
            const paymentTypeSelect = document.getElementById('paymentType');
            const amountInput = document.getElementById('amount');
            
            if (paymentTypeSelect && amountInput) {
                paymentTypeSelect.addEventListener('change', function() {
                    const paymentType = this.value;
                    
                    switch (paymentType) {
                        case 'contribution':
                            amountInput.min = 2000;
                            if (amountInput.value < 2000 || amountInput.value === '') {
                                amountInput.value = 2000;
                            }
                            break;
                        case 'registration':
                            amountInput.min = 5000;
                            if (amountInput.value < 5000 || amountInput.value === '') {
                                amountInput.value = 5000;
                            }
                            break;
                        default:
                            amountInput.min = 1;
                            if (amountInput.value < 1) {
                                amountInput.value = '';
                            }
                    }
                });
                
                // Trigger change event if payment type is pre-selected
                if (paymentTypeSelect.value) {
                    const event = new Event('change');
                    paymentTypeSelect.dispatchEvent(event);
                }
            }
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('mpesa_payment_form', 'daystar_mpesa_payment_form_shortcode');

/**
 * Add shortcode to display payment status
 */
function daystar_payment_status_shortcode() {
    // Check if payment status is in URL
    $payment_status = isset($_GET['payment_status']) ? sanitize_text_field($_GET['payment_status']) : '';
    
    // Check if checkout request ID is in session
    $checkout_request_id = isset($_SESSION['mpesa_checkout_request_id']) ? $_SESSION['mpesa_checkout_request_id'] : '';
    $transaction_id = isset($_SESSION['mpesa_transaction_id']) ? $_SESSION['mpesa_transaction_id'] : '';
    
    if (empty($checkout_request_id) || empty($transaction_id)) {
        return '<div class="alert alert-warning">No payment information found. Please try again.</div>';
    }
    
    // Get transaction details
    $transaction_type = get_post_meta($transaction_id, '_transaction_type', true);
    $amount = get_post_meta($transaction_id, '_amount', true);
    $phone = get_post_meta($transaction_id, '_phone', true);
    $reference = get_post_meta($transaction_id, '_reference', true);
    $status = get_post_meta($transaction_id, '_status', true);
    
    ob_start();
    ?>
    <div class="payment-status">
        <h2>Payment Status</h2>
        
        <?php if ($status === 'pending'): ?>
            <div class="alert alert-info">
                <p><strong>Your payment is being processed.</strong></p>
                <p>Please check your phone for the M-Pesa STK push notification and enter your PIN to complete the payment.</p>
                <p>This page will automatically update when your payment is confirmed.</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        <?php elseif ($status === 'completed'): ?>
            <div class="alert alert-success">
                <p><strong>Payment Successful!</strong></p>
                <p>Your payment of KSh <?php echo number_format($amount, 2); ?> has been received.</p>
                <p>M-Pesa Receipt: <?php echo esc_html(get_post_meta($transaction_id, '_mpesa_receipt', true)); ?></p>
                <p>Reference: <?php echo esc_html($reference); ?></p>
                <p>Thank you for your payment.</p>
            </div>
            
            <?php
            // Clear session variables
            unset($_SESSION['mpesa_checkout_request_id']);
            unset($_SESSION['mpesa_transaction_id']);
            ?>
        <?php elseif ($status === 'failed'): ?>
            <div class="alert alert-danger">
                <p><strong>Payment Failed</strong></p>
                <p>Your payment could not be processed.</p>
                <p>Reason: <?php echo esc_html(get_post_meta($transaction_id, '_failure_reason', true)); ?></p>
                <p>Please try again or contact support for assistance.</p>
            </div>
            
            <?php
            // Clear session variables
            unset($_SESSION['mpesa_checkout_request_id']);
            unset($_SESSION['mpesa_transaction_id']);
            ?>
        <?php endif; ?>
        
        <div class="payment-details">
            <h4>Payment Details</h4>
            <table class="table">
                <tr>
                    <th>Payment Type:</th>
                    <td><?php echo esc_html(ucfirst($transaction_type)); ?></td>
                </tr>
                <tr>
                    <th>Amount:</th>
                    <td>KSh <?php echo number_format($amount, 2); ?></td>
                </tr>
                <tr>
                    <th>Phone Number:</th>
                    <td><?php echo esc_html($phone); ?></td>
                </tr>
                <tr>
                    <th>Reference:</th>
                    <td><?php echo esc_html($reference); ?></td>
                </tr>
            </table>
        </div>
        
        <?php if ($status === 'pending'): ?>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/payment/')); ?>" class="btn btn-outline-primary">Make Another Payment</a>
            </div>
            
            <script type="text/javascript">
                // Check payment status every 5 seconds
                setInterval(function() {
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=check_mpesa_payment_status&checkout_request_id=<?php echo esc_js($checkout_request_id); ?>&_wpnonce=<?php echo wp_create_nonce('check_mpesa_payment_status'); ?>')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'completed' || data.status === 'failed') {
                                // Reload page to show updated status
                                window.location.reload();
                            }
                        })
                        .catch(error => console.error('Error checking payment status:', error));
                }, 5000);
            </script>
        <?php else: ?>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/member-dashboard/')); ?>" class="btn btn-primary">Go to Dashboard</a>
                <a href="<?php echo esc_url(home_url('/payment/')); ?>" class="btn btn-outline-primary">Make Another Payment</a>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
        .payment-status {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .payment-status h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00447c;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .payment-details {
            margin-top: 30px;
        }
        
        .payment-details h4 {
            margin-bottom: 15px;
            color: #00447c;
        }
        
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        
        .table th {
            width: 40%;
            text-align: left;
        }
        
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            margin: 0 5px;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #00447c;
            border-color: #00447c;
        }
        
        .btn-outline-primary {
            color: #00447c;
            background-color: transparent;
            border-color: #00447c;
        }
        
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('payment_status', 'daystar_payment_status_shortcode');

/**
 * AJAX handler for checking payment status
 */
function daystar_check_mpesa_payment_status() {
    // Verify nonce
    check_ajax_referer('check_mpesa_payment_status');
    
    // Get checkout request ID
    $checkout_request_id = isset($_GET['checkout_request_id']) ? sanitize_text_field($_GET['checkout_request_id']) : '';
    
    if (empty($checkout_request_id)) {
        wp_send_json_error('Invalid checkout request ID');
    }
    
    // Find transaction by checkout request ID
    $args = array(
        'post_type' => 'mpesa_transaction',
        'meta_query' => array(
            array(
                'key' => '_checkout_request_id',
                'value' => $checkout_request_id
            )
        )
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $transaction_id = get_the_ID();
        $status = get_post_meta($transaction_id, '_status', true);
        
        wp_reset_postdata();
        
        // If still pending, check status with M-Pesa API
        if ($status === 'pending') {
            $result = Daystar_MPesa_API::check_transaction_status($checkout_request_id);
            
            if (!is_wp_error($result) && isset($result['ResultCode'])) {
                if ($result['ResultCode'] === '0') {
                    // Transaction successful
                    update_post_meta($transaction_id, '_status', 'completed');
                    $status = 'completed';
                } elseif ($result['ResultCode'] !== '1032') { // 1032 means request is still being processed
                    // Transaction failed
                    update_post_meta($transaction_id, '_status', 'failed');
                    update_post_meta($transaction_id, '_failure_reason', isset($result['ResultDesc']) ? $result['ResultDesc'] : 'Payment failed');
                    $status = 'failed';
                }
            }
        }
        
        wp_send_json_success(array('status' => $status));
    } else {
        wp_send_json_error('Transaction not found');
    }
}
add_action('wp_ajax_check_mpesa_payment_status', 'daystar_check_mpesa_payment_status');
add_action('wp_ajax_nopriv_check_mpesa_payment_status', 'daystar_check_mpesa_payment_status');

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

require_once $theme_includes_path . 'session-management.php';
require_once $theme_includes_path . 'member-registration.php';
require_once $theme_includes_path . 'member-profile.php';
require_once $theme_includes_path . 'loan-application.php';
require_once $theme_includes_path . 'payment-integration.php';
require_once $theme_includes_path . 'notifications.php';
require_once $theme_includes_path . 'dashboard-notifications.php';

// Admin functionalities
if (is_admin()) {
    require_once $theme_includes_path . 'admin/admin-dashboard.php';
    // Note: admin-dashboard.php itself requires other admin files which might be missing.
}

/**
 * Handle Product Enquiry Form Submission
 */
function sacco_handle_product_enquiry() {
    // Verify nonce
    if ( ! isset( $_POST['enquiry_nonce'] ) || ! wp_verify_nonce( $_POST['enquiry_nonce'], 'product_enquiry_form_nonce' ) ) {
        $redirect_url = isset($_POST['product_id']) ? get_permalink( absint($_POST['product_id']) ) : home_url();
        wp_safe_redirect( add_query_arg(array('form_status' => 'nonce_error', 'modal' => 'productEnquiryModal'), $redirect_url ) );
        exit;
    }

    // Sanitize POST data
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