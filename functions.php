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
function sacco_php_scripts() {
	wp_enqueue_style( 'sacco-php-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'sacco-php-style', 'rtl', 'replace' );

	// Enqueue Bootstrap CSS
	wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '5.1.3', 'all');
	
	// Enqueue Glassmorphism CSS
	wp_enqueue_style('sacco-glassmorphism', get_template_directory_uri() . '/css/glassmorphism.css', array(), _S_VERSION);
	
	// Enqueue Google Fonts
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
	
	// Enqueue Font Awesome
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4', 'all');
	
	// Enqueue Swiper CSS
	wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '8.0.0', 'all');
	
	// Enqueue Custom CSS
	wp_enqueue_style('sacco-php-custom', get_template_directory_uri() . '/assets/css/style.css', array('bootstrap'), _S_VERSION, 'all');
	
	// Enqueue jQuery (included with WordPress)
	wp_enqueue_script('jquery');
	
	// Enqueue Bootstrap JS
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.1.3', true);
	
	// Enqueue Swiper JS
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), '8.0.0', true);
	
	// Enqueue Chart.js for calculators
	wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', array(), '3.7.1', true);
	
	// Enqueue AOS (Animate On Scroll) library for animations
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

    // Enqueue Glassmorphism JS
    wp_enqueue_script('sacco-glassmorphism', get_template_directory_uri() . '/js/glassmorphism.js', array('jquery'), _S_VERSION, true);
	
	// Enqueue Custom JS
	wp_enqueue_script('sacco-php-custom', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'swiper-js', 'chart-js'), _S_VERSION, true);

	// Enqueue AOS (Animate On Scroll) library for animations
	wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
	wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);

	// Enqueue custom front page script
	if (is_front_page()) {
		wp_enqueue_script('sacco-php-front-page', get_template_directory_uri() . '/js/front-page.js', array('jquery', 'swiper-js', 'aos-js'), _S_VERSION, true);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sacco_php_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

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
 * Enqueue Calculator and Comparison Scripts
 */
function sacco_php_calculator_scripts() {
	// Calculator pages
	if (is_page_template('page-loan-calculator.php') || 
	    is_page_template('page-mortgage-calculator.php') || 
	    is_page_template('page-savings-calculator.php') ||
	    is_page_template('page-product-comparison.php')) {
		
		// Chart.js for visualizations
		wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', array('jquery'), '3.7.1', true);
		
		// Common calculator functions
		wp_enqueue_script('sacco-calculator-common', get_template_directory_uri() . '/js/calculator-common.js', array('jquery', 'chart-js'), _S_VERSION, true);

		// Loan Calculator specific script
		if (is_page_template('page-loan-calculator.php')) {
			wp_enqueue_script('sacco-loan-calculator', get_template_directory_uri() . '/js/loan-calculator.js', array('jquery', 'chart-js', 'sacco-calculator-common'), _S_VERSION, true);
		}
		
		// Mortgage Calculator specific script
		if (is_page_template('page-mortgage-calculator.php')) {
			wp_enqueue_script('sacco-mortgage-calculator', get_template_directory_uri() . '/js/mortgage-calculator.js', array('jquery', 'chart-js', 'sacco-calculator-common'), _S_VERSION, true);
		}
		
		// Savings Calculator specific script
		if (is_page_template('page-savings-calculator.php')) {
			 wp_enqueue_script('sacco-savings-calculator', get_template_directory_uri() . '/js/savings-calculator.js', array('jquery', 'chart-js', 'sacco-calculator-common'), _S_VERSION, true);
		}
		
		// Product Comparison specific script
		if (is_page_template('page-product-comparison.php')) {
			wp_enqueue_script('sacco-product-comparison', get_template_directory_uri() . '/js/product-comparison.js', array('jquery'), _S_VERSION, true);
		}

		// Calculator styles
		wp_enqueue_style('sacco-calculator-styles', get_template_directory_uri() . '/css/calculator.css', array(), _S_VERSION);
	}
	
	// Member portal template pages
	if (is_page_template('page-member-portal.php') || 
	    is_page_template('page-member-dashboard.php') || 
	    is_page_template('page-member-profile.php') ||
	    is_page_template('page-member-loans.php') ||
	    is_page_template('page-member-savings.php') ||
	    is_page_template('page-member-transactions.php')) {
		
		// Chart.js for member portal visualizations
		wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', array('jquery'), '3.9.1', true);
		
		// Member portal scripts
		wp_enqueue_script('sacco-member-portal', get_template_directory_uri() . '/js/member-portal.js', array('jquery', 'chart-js'), _S_VERSION, true);
	}
}
add_action('wp_enqueue_scripts', 'sacco_php_calculator_scripts');

/**
 * Add custom classes to <article> elements
 */
function sacco_php_add_article_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'single-post';
    } else {
        $classes[] = 'post-item';
    }
    return $classes;
}
add_filter( 'post_class', 'sacco_php_add_article_classes' );

/**
 * Enqueue Front Page Styles
 */
function sacco_php_front_page_styles() {
    if (is_front_page()) {
        wp_enqueue_style('sacco-front-page', get_template_directory_uri() . '/css/front-page.css', array(), _S_VERSION);
    }
    
    // Enqueue Contact Page styles
    if (is_page_template('page-contact.php')) {
        wp_enqueue_style('sacco-contact', get_template_directory_uri() . '/css/contact.css', array(), _S_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'sacco_php_front_page_styles');

/**
 * Handle contact form submission (from footer modal)
 */
function handle_contact_form_submission() {
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form_nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    // Sanitize and validate input
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error('All fields are required');
    }

    // Get recipient email from theme mod - using 'footer_email' as per our customizer.
    // Fallback to admin_email if not set.
    $to = get_theme_mod('footer_email', get_option('admin_email'));
    
    // Email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );

    // Email content
    $email_content = sprintf(
        '<h2>New Contact Form Submission (from Website Footer)</h2>
        <p><strong>Name:</strong> %s</p>
        <p><strong>Email:</strong> %s</p>
        <p><strong>Subject:</strong> %s</p>
        <p><strong>Message:</strong></p>
        <p>%s</p>',
        esc_html($name),
        esc_html($email),
        esc_html($subject),
        nl2br(esc_html($message))
    );

    // Send email
    $sent = wp_mail($to, $subject, $email_content, $headers);

    if ($sent) {
        wp_send_json_success('Email sent successfully');
    } else {
        wp_send_json_error('Failed to send email');
    }
}
add_action('wp_ajax_send_contact_email', 'handle_contact_form_submission'); // For logged-in users
add_action('wp_ajax_nopriv_send_contact_email', 'handle_contact_form_submission'); // For non-logged-in users

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
        wp_enqueue_style('sacco-php-member-portal', get_template_directory_uri() . '/css/member-portal.css', array(), _S_VERSION);
    }
    
    // Register and enqueue savings CSS if on savings related pages
    if (is_post_type_archive('savings') || is_singular('savings') || is_tax('savings_category') || is_page('savings-calculator')) {
        wp_enqueue_style('sacco-php-savings', get_template_directory_uri() . '/css/savings.css', array(), _S_VERSION);
        
        // Enqueue Chart.js if on calculator page
        if (is_page('savings-calculator')) {
            wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array('jquery'), '3.9.1', true);
            wp_enqueue_script('sacco-php-savings-calculator', get_template_directory_uri() . '/js/savings-calculator.js', array('jquery', 'chart-js'), _S_VERSION, true);
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
        wp_enqueue_style('sacco-savings', get_template_directory_uri() . '/css/savings.css', array(), _S_VERSION);
    }
    
    // Loans Archive and Single Loan
    if (is_post_type_archive('loan') || is_singular('loan')) {
        wp_enqueue_style('sacco-loans', get_template_directory_uri() . '/css/loans.css', array(), _S_VERSION);
    }
    
    // About Page
    if (is_page_template('page-about.php')) {
        wp_enqueue_style('sacco-about', get_template_directory_uri() . '/css/about.css', array(), _S_VERSION);
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
            include(get_template_directory() . '/page-member-profile.php');
            exit;
        } elseif ($portal_page == 'loans') {
            include(get_template_directory() . '/page-member-loans.php');
            exit;
        } elseif ($portal_page == 'savings') {
            include(get_template_directory() . '/page-member-savings.php');
            exit;
        } elseif ($portal_page == 'transactions') {
            include(get_template_directory() . '/page-member-transactions.php');
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
    $requirements = get_post_meta($post->ID, 'requirements', true); // Make sure to get this value
    $insurance_partner_company = get_post_meta($post->ID, '_insurance_partner_company', true); // New field
    
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
        'requirements', // Added to ensure it's saved
        'insurance_partner_company' // New field prefixed with underscore for consistency if preferred, but matching form field name here
    );

    foreach ($meta_fields as $field_name) {
        if (isset($_POST[$field_name])) {
            $value = $_POST[$field_name];
            $meta_key = ($field_name === 'insurance_partner_company') ? '_insurance_partner_company' : $field_name; // Use underscore for new field

            if ($field_name === 'features' || $field_name === 'requirements') {
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
 * Asset versioning system
 */
function sacco_php_asset_version($path) {
    $version = filemtime(get_template_directory() . $path);
    return $version;
}

/**
 * Image optimization settings
 */
function sacco_php_optimize_images() {
    // Set default image quality
    add_filter('jpeg_quality', function($quality) {
        return 82;
    });

    // Add custom image sizes with optimal dimensions
    add_image_size('card-thumbnail', 400, 300, true);
    add_image_size('mobile-hero', 800, 600, true);
    add_image_size('desktop-hero', 1920, 1080, true);

    // Add WebP support
    function sacco_php_content_type_webp($headers) {
        if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false) {
            $headers['Vary'] = 'Accept';
        }
        return $headers;
    }
    add_filter('wp_headers', 'sacco_php_content_type_webp');

    // Add responsive image attributes
    function sacco_php_responsive_image_attributes($attributes) {
        if (!isset($attributes['loading'])) {
            $attributes['loading'] = 'lazy';
        }
        if (!isset($attributes['decoding'])) {
            $attributes['decoding'] = 'async';
        }
        return $attributes;
    }
    add_filter('wp_get_attachment_image_attributes', 'sacco_php_responsive_image_attributes');
}
add_action('after_setup_theme', 'sacco_php_optimize_images');

/**
 * Image optimization functions
 */
function sacco_optimize_image_sizes() {
    // Remove default image sizes
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
    
    // Add custom optimized sizes
    add_image_size('card-thumbnail', 480, 320, true);
    add_image_size('hero-mobile', 768, 500, true);
    add_image_size('hero-desktop', 1920, 800, true);
}
add_action('after_setup_theme', 'sacco_optimize_image_sizes');

/**
 * Add WebP support
 */
function sacco_webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'sacco_webp_upload_mimes');

/**
 * Add image quality control
 */
function sacco_jpeg_quality() {
    return 82; // Optimal quality-size ratio
}
add_filter('jpeg_quality', 'sacco_jpeg_quality');

/**
 * Add responsive image attributes
 */
function sacco_responsive_image_attributes($attributes) {
    if (isset($attributes['src'])) {
        $attributes['loading'] = 'lazy';
        $attributes['decoding'] = 'async';
    }
    return $attributes;
}
add_filter('wp_get_attachment_image_attributes', 'sacco_responsive_image_attributes');

/**
 * Disable WordPress scaling for uploaded images
 */
add_filter('big_image_size_threshold', '__return_false');

/**
 * Add preload for critical images
 */
function sacco_preload_critical_images() {
    if (is_front_page()) {
        $hero_image_id = get_theme_mod('hero_image');
        if ($hero_image_id) {
            $hero_image_src = wp_get_attachment_image_src($hero_image_id, 'hero-desktop')[0];
            echo '<link rel="preload" as="image" href="' . esc_url($hero_image_src) . '">';
        }
    }
}
add_action('wp_head', 'sacco_preload_critical_images', 1);



