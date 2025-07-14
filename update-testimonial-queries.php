<?php
/**
 * Helper Script to Update Testimonial Queries
 * 
 * This script provides examples of how to update existing testimonial queries
 * to use the new testimonial categories for different pages.
 */

// Prevent direct access - only allow when WordPress is loaded
if (!defined('ABSPATH')) {
    // Try to find wp-config.php in common locations
    $config_paths = array(
        '../../../../wp-config.php',
        '../../../../../wp-config.php',
        '../../../../../../wp-config.php',
        '../../../wp-config.php'
    );
    
    $config_loaded = false;
    foreach ($config_paths as $config_path) {
        if (file_exists($config_path)) {
            require_once($config_path);
            $config_loaded = true;
            break;
        }
    }
    
    if (!$config_loaded) {
        die('Error: This script must be run from WordPress admin or wp-config.php could not be found. Please use the admin interface instead.');
    }
}

/**
 * Example function to get testimonials by category
 */
function get_testimonials_by_category($category_slug, $posts_per_page = 3) {
    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'orderby' => 'rand', // Random order for variety
        'tax_query' => array(
            array(
                'taxonomy' => 'testimonial_category',
                'field' => 'slug',
                'terms' => $category_slug
            )
        )
    );
    
    return new WP_Query($args);
}

/**
 * Example function to get testimonials for multiple categories
 */
function get_testimonials_by_multiple_categories($category_slugs, $posts_per_page = 3) {
    $args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'testimonial_category',
                'field' => 'slug',
                'terms' => $category_slugs,
                'operator' => 'IN'
            )
        )
    );
    
    return new WP_Query($args);
}

/**
 * Display usage examples
 */
function display_testimonial_query_examples() {
    echo "<h1>Testimonial Query Examples</h1>\n";
    echo "<p>Here are examples of how to update your testimonial queries to use categories:</p>\n";
    
    echo "<h2>1. Homepage/General Testimonials</h2>\n";
    echo "<pre>\n";
    echo "// For front-page.php or general testimonials\n";
    echo "\$testimonials = get_testimonials_by_category('general', 5);\n";
    echo "\n";
    echo "// Or mix general with membership benefits\n";
    echo "\$testimonials = get_testimonials_by_multiple_categories(['general', 'membership-benefits'], 5);\n";
    echo "</pre>\n";
    
    echo "<h2>2. Development Loans Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-development-loans.php\n";
    echo "\$testimonials = get_testimonials_by_category('development-loans', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>3. Emergency Loans Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-emergency-loans.php\n";
    echo "\$testimonials = get_testimonials_by_category('emergency-loans', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>4. School Fees Loans Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-school-fees-loans.php\n";
    echo "\$testimonials = get_testimonials_by_category('school-fees-loans', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>5. Savings Accounts Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-savings-accounts.php\n";
    echo "\$testimonials = get_testimonials_by_category('savings-accounts', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>6. Products & Services Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-products-services.php\n";
    echo "\$testimonials = get_testimonials_by_category('products-services', 4);\n";
    echo "\n";
    echo "// Or mix multiple relevant categories\n";
    echo "\$testimonials = get_testimonials_by_multiple_categories([\n";
    echo "    'products-services', \n";
    echo "    'development-loans', \n";
    echo "    'savings-accounts'\n";
    echo "], 6);\n";
    echo "</pre>\n";
    
    echo "<h2>7. Membership Benefits Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-membership-benefits.php\n";
    echo "\$testimonials = get_testimonials_by_category('membership-benefits', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>8. Financial Education Page</h2>\n";
    echo "<pre>\n";
    echo "// For page-financial-education.php\n";
    echo "\$testimonials = get_testimonials_by_category('financial-education', 3);\n";
    echo "</pre>\n";
    
    echo "<h2>Complete Example Implementation</h2>\n";
    echo "<pre>\n";
    echo "&lt;?php\n";
    echo "// Example for development loans page\n";
    echo "\$testimonials_query = new WP_Query(array(\n";
    echo "    'post_type' => 'testimonial',\n";
    echo "    'posts_per_page' => 3,\n";
    echo "    'post_status' => 'publish',\n";
    echo "    'orderby' => 'rand',\n";
    echo "    'tax_query' => array(\n";
    echo "        array(\n";
    echo "            'taxonomy' => 'testimonial_category',\n";
    echo "            'field' => 'slug',\n";
    echo "            'terms' => 'development-loans'\n";
    echo "        )\n";
    echo "    )\n";
    echo "));\n";
    echo "\n";
    echo "if (\$testimonials_query->have_posts()) : ?>\n";
    echo "    &lt;div class=\"testimonials-slider swiper\">\n";
    echo "        &lt;div class=\"swiper-wrapper\">\n";
    echo "            &lt;?php while (\$testimonials_query->have_posts()) : \$testimonials_query->the_post();\n";
    echo "                \$rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);\n";
    echo "                \$member_since = get_post_meta(get_the_ID(), '_member_since', true);\n";
    echo "                \$member_type = get_post_meta(get_the_ID(), '_member_type', true);\n";
    echo "                \$position = get_post_meta(get_the_ID(), '_position', true);\n";
    echo "            ?>\n";
    echo "            &lt;div class=\"swiper-slide\">\n";
    echo "                &lt;div class=\"testimonial-card enhanced\">\n";
    echo "                    &lt;!-- Your testimonial card HTML here -->\n";
    echo "                    &lt;h5>&lt;?php the_title(); ?>&lt;/h5>\n";
    echo "                    &lt;p>&lt;?php echo wp_trim_words(get_the_content(), 40, '...'); ?>&lt;/p>\n";
    echo "                    &lt;!-- Rating, member info, etc. -->\n";
    echo "                &lt;/div>\n";
    echo "            &lt;/div>\n";
    echo "            &lt;?php endwhile; ?>\n";
    echo "        &lt;/div>\n";
    echo "    &lt;/div>\n";
    echo "&lt;?php endif;\n";
    echo "wp_reset_postdata();\n";
    echo "?>\n";
    echo "</pre>\n";
    
    echo "<h2>Available Categories</h2>\n";
    $categories = get_terms(array(
        'taxonomy' => 'testimonial_category',
        'hide_empty' => false
    ));
    
    if (!empty($categories)) {
        echo "<ul>\n";
        foreach ($categories as $category) {
            echo "<li><strong>{$category->name}</strong> (slug: <code>{$category->slug}</code>) - {$category->description}</li>\n";
        }
        echo "</ul>\n";
    }
    
    echo "<h2>Tips for Implementation</h2>\n";
    echo "<ul>\n";
    echo "<li><strong>Fallback:</strong> Always include a fallback to general testimonials if a specific category has no testimonials</li>\n";
    echo "<li><strong>Random Order:</strong> Use 'orderby' => 'rand' to show different testimonials on each page load</li>\n";
    echo "<li><strong>Multiple Categories:</strong> Use multiple categories for pages that could benefit from various testimonial types</li>\n";
    echo "<li><strong>Performance:</strong> Consider caching testimonial queries for better performance</li>\n";
    echo "</ul>\n";
}

// Run the examples if accessed directly
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    display_testimonial_query_examples();
}
?>