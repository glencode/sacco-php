<?php
/**
 * sacco-php Theme Customizer
 *
 * @package sacco-php
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sacco_php_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'sacco_php_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'sacco_php_customize_partial_blogdescription',
			)
		);
	}

    // --- Footer Settings Panel ---
    $wp_customize->add_panel( 'footer_settings_panel', array(
        'title'       => __( 'Footer Settings', 'sacco-php' ),
        'priority'    => 140, // After Menus, Widgets, etc.
        'description' => __( 'Customize the theme footer content.', 'sacco-php' ),
    ) );

    // --- Footer Column 1 Section: Description & Social ---
    $wp_customize->add_section( 'footer_col1_section', array(
        'title'    => __( 'Footer Column 1 (Info/Social)', 'sacco-php' ),
        'panel'    => 'footer_settings_panel',
        'priority' => 10,
    ) );

    // Footer Description Setting
    $wp_customize->add_setting( 'footer_description', array(
        'default'           => 'Leading IT consultancy firm providing cutting-edge technology solutions...',
        'sanitize_callback' => 'wp_kses_post', // Allow basic HTML
        'transport'         => 'postMessage', // Optional: Use postMessage for live preview without refresh
    ) );
    $wp_customize->add_control( 'footer_description', array(
        'label'    => __( 'Footer Description', 'sacco-php' ),
        'section'  => 'footer_col1_section',
        'type'     => 'textarea',
    ) );

    // Note: We will use the WP Menu for social links, not individual theme_mods like the reference file for easier management.
    // You can add individual URL fields here if you prefer that over the menu system:
    /*
    $wp_customize->add_setting( 'footer_facebook_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'footer_facebook_url', array( 'label' => __( 'Facebook URL', 'sacco-php' ), 'section' => 'footer_col1_section', 'type' => 'url' ) );
    // ... Add settings/controls for Twitter, LinkedIn, Instagram ...
    */

    // --- Footer Column 3 Section: Contact Info ---
    $wp_customize->add_section( 'footer_col3_section', array(
        'title'    => __( 'Footer Column 3 (Contact Info)', 'sacco-php' ),
        'panel'    => 'footer_settings_panel',
        'priority' => 30,
    ) );

    // Address Setting
    $wp_customize->add_setting( 'footer_address', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_address', array( 'label' => __( 'Address', 'sacco-php' ), 'section' => 'footer_col3_section', 'type' => 'text' ) );

    // Phone Setting
    $wp_customize->add_setting( 'footer_phone', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_phone', array( 'label' => __( 'Phone Number', 'sacco-php' ), 'section' => 'footer_col3_section', 'type' => 'text' ) );

    // Email Setting
    $wp_customize->add_setting( 'footer_email', array( 'default' => '', 'sanitize_callback' => 'sanitize_email', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_email', array( 'label' => __( 'Email Address', 'sacco-php' ), 'section' => 'footer_col3_section', 'type' => 'email' ) );

    // Working Hours Setting
    $wp_customize->add_setting( 'footer_working_hours', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_working_hours', array( 'label' => __( 'Working Hours', 'sacco-php' ), 'section' => 'footer_col3_section', 'type' => 'text' ) );

    // --- Footer Bottom Bar Section ---
    $wp_customize->add_section( 'footer_bottom_bar_section', array(
        'title'    => __( 'Footer Bottom Bar', 'sacco-php' ),
        'panel'    => 'footer_settings_panel',
        'priority' => 40,
    ) );

    // Developed By Text Setting
    $wp_customize->add_setting( 'footer_developed_by_text', array( 'default' => 'Your Developer Name', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_developed_by_text', array( 'label' => __( '\'Developed by\' Text', 'sacco-php' ), 'section' => 'footer_bottom_bar_section', 'type' => 'text' ) );

    // Developed By Link Setting
    $wp_customize->add_setting( 'footer_developed_by_link', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'footer_developed_by_link', array( 'label' => __( '\'Developed by\' Link', 'sacco-php' ), 'section' => 'footer_bottom_bar_section', 'type' => 'url' ) );

    // Add selective refresh partials for footer settings
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'footer_description', array(
            'selector'        => '.footer-description',
            'render_callback' => function() {
                return nl2br(esc_html(get_theme_mod('footer_description')));
            },
        ));
        $wp_customize->selective_refresh->add_partial( 'footer_contact_info', array(
            'selector'        => '.footer-contact-info', // Target the container for all contact info
            'render_callback' => 'sacco_php_customize_partial_footer_contact_info', // We need a function to render the block
        ));
        // Add partials for developed by text/link if needed
    }

    // --- Homepage Settings Panel ---
    $wp_customize->add_panel( 'homepage_settings_panel', array(
        'title'       => __( 'Homepage Settings', 'sacco-php' ),
        'priority'    => 135, // Just before Footer Settings
        'description' => __( 'Customize various sections of the homepage.', 'sacco-php' ),
    ) );

    // --- Hero Slider Defaults Section ---
    $wp_customize->add_section( 'hero_slider_defaults_section', array(
        'title'    => __( 'Hero Slider Defaults', 'sacco-php' ),
        'panel'    => 'homepage_settings_panel',
        'priority' => 10,
        'description' => __( 'Set default content for the hero slider if no slides are created via the "Slides" post type.', 'sacco-php' ),
    ) );

    // Default Slide Title
    $wp_customize->add_setting( 'default_slide_title', array(
        'default'           => 'Welcome to Our Sacco',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'default_slide_title', array(
        'label'    => __( 'Default Slide Title', 'sacco-php' ),
        'section'  => 'hero_slider_defaults_section',
        'type'     => 'text',
    ) );

    // Default Slide Subtitle
    $wp_customize->add_setting( 'default_slide_subtitle', array(
        'default'           => 'Empowering your financial journey.',
        'sanitize_callback' => 'wp_kses_post', // Allow some basic HTML if needed, or sanitize_text_field
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'default_slide_subtitle', array(
        'label'    => __( 'Default Slide Subtitle/Text', 'sacco-php' ),
        'section'  => 'hero_slider_defaults_section',
        'type'     => 'textarea',
    ) );

    // Default Slide Button Text
    $wp_customize->add_setting( 'default_slide_button_text', array(
        'default'           => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'default_slide_button_text', array(
        'label'    => __( 'Default Slide Button Text', 'sacco-php' ),
        'section'  => 'hero_slider_defaults_section',
        'type'     => 'text',
    ) );

    // Default Slide Button URL
    $wp_customize->add_setting( 'default_slide_button_url', array(
        'default'           => '#about-us',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'default_slide_button_url', array(
        'label'    => __( 'Default Slide Button URL', 'sacco-php' ),
        'section'  => 'hero_slider_defaults_section',
        'type'     => 'url',
    ) );
    
    // Selective refresh for default hero slider content
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'default_slide_title_partial', array(
            'selector'        => '.hero-slider .slide-title', // Ensure this selector is specific enough for the default slide
            'settings'        => array('default_slide_title'),
            'render_callback' => function() {
                return esc_html(get_theme_mod('default_slide_title', 'Welcome to Our Sacco'));
            },
            // Minor optimization: only render if it's actually the default slide being shown.
            // This might require a JS check or a body class when no CPT slides exist.
            // For now, this will attempt to update if the selector is present.
        ) );
        $wp_customize->selective_refresh->add_partial( 'default_slide_subtitle_partial', array(
            'selector'        => '.hero-slider .slide-subtitle p', // Adjust selector as needed
            'settings'        => array('default_slide_subtitle'),
            'render_callback' => function() {
                return wp_kses_post(get_theme_mod('default_slide_subtitle', 'Empowering your financial journey.'));
            },
        ) );
         $wp_customize->selective_refresh->add_partial( 'default_slide_button_partial', array(
            'selector'        => '.hero-slider .slide-buttons .btn', // Adjust selector
            'settings'        => array('default_slide_button_text', 'default_slide_button_url'),
            'render_callback' => function() {
                $text = get_theme_mod('default_slide_button_text', 'Learn More');
                $url = get_theme_mod('default_slide_button_url', '#about-us');
                return '<a href="' . esc_url($url) . '" class="btn btn-primary">' . esc_html($text) . '</a>';
            },
            'container_inclusive' => true, // Replace the whole button
        ) );
    }

}
add_action( 'customize_register', 'sacco_php_customize_register' );

// Callback function to render the footer contact info block for selective refresh
function sacco_php_customize_partial_footer_contact_info() {
    $address = get_theme_mod('footer_address');
    $phone   = get_theme_mod('footer_phone');
    $email   = get_theme_mod('footer_email');
    $hours   = get_theme_mod('footer_working_hours');

    if ($address) {
        echo '<p><i class="fas fa-map-marker-alt"></i> ' . esc_html($address) . '</p>';
    }
    if ($phone) {
        echo '<p><i class="fas fa-phone-alt"></i> <a href="tel:' . esc_attr(preg_replace('/[^0-9+]/ ', '', $phone)) . '">' . esc_html($phone) . '</a></p>';
    }
    if ($email) {
        echo '<p><i class="fas fa-envelope"></i> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
    }
    if ($hours) {
        echo '<p><i class="fas fa-clock"></i> ' . esc_html($hours) . '</p>';
    }
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function sacco_php_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function sacco_php_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sacco_php_customize_preview_js() {
	wp_enqueue_script( 'sacco-php-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'sacco_php_customize_preview_js' );
