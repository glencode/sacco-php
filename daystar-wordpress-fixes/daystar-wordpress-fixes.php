<?php
/**
 * Daystar Co-op WordPress Theme Fixes
 * 
 * This file contains WordPress-specific fixes for the Daystar Co-op website
 * to address design issues, navbar functionality, and other theme-related problems.
 */

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
 * Add inline CSS fixes to handle theme-specific issues
 */
function daystar_add_inline_css_fixes() {
    $custom_css = "
        /* Fix navbar styling */
        .navbar {
            background-color: #f8f9fa !important;
            padding: 1rem;
        }
        
        .navbar-brand img {
            max-height: 50px;
        }
        
        .navbar-nav .nav-link {
            color: #333 !important;
            padding: 0.5rem 1rem;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #0056b3 !important;
        }
        
        .dropdown-menu {
            border-radius: 0;
            margin-top: 0;
            border-color: #eee;
        }
        
        /* Fix header colors */
        .top-bar {
            background-color: #0056b3 !important;
            color: #ffffff !important;
        }
        
        /* Fix member login button */
        .member-login-btn {
            background-color: #00447c !important;
            color: #ffffff !important;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }
        
        /* Fix hero section */
        .hero-section {
            background: linear-gradient(135deg, rgba(0, 128, 128, 0.8) 0%, rgba(0, 68, 124, 0.8) 100%) !important;
            color: #ffffff;
            padding: 4rem 0;
        }
        
        .hero-section h1,
        .hero-section h2,
        .hero-section h3 {
            color: #ffffff !important;
        }
        
        /* Fix buttons */
        .btn-primary {
            background-color: #00447c !important;
            border-color: #00447c !important;
        }
        
        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #003366 !important;
            border-color: #003366 !important;
        }
        
        /* Fix footer */
        .site-footer {
            background-color: #00447c !important;
            color: #ffffff !important;
            padding: 3rem 0;
        }
        
        .site-footer a {
            color: #ffffff !important;
        }
        
        /* Fix WhatsApp button */
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25d366;
            color: #ffffff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-decoration: none;
        }
        
        .whatsapp-button:hover {
            background-color: #128c7e;
            color: #ffffff;
        }
        
        /* Fix membership cards */
        .step-item,
        .membership-card {
            background-color: #ffffff !important;
            color: #333333 !important;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Fix responsive issues */
        @media (max-width: 768px) {
            .navbar-collapse {
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            
            .hero-section {
                padding: 2rem 0;
            }
        }
    ";
    
    wp_add_inline_style('daystar-custom-styles', $custom_css);
}
add_action('wp_enqueue_scripts', 'daystar_add_inline_css_fixes', 1000); // Even higher priority

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
// Instructions: Add this code to your theme's functions.php file or create a new plugin with this code
