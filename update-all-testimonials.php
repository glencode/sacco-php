<?php
/**
 * Script to Update All Pages with Categorized Testimonials
 * 
 * This script will update all pages to use the new categorized testimonials system
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
        die('Error: This script must be run from WordPress admin or wp-config.php could not be found.');
    }
}

/**
 * Generate testimonials query code for different page types
 */
function generate_testimonials_query($page_type, $posts_per_page = 3) {
    $category_mapping = array(
        'development-loans' => 'development-loans',
        'emergency-loans' => 'emergency-loans',
        'school-fees-loans' => 'school-fees-loans',
        'special-loans' => 'special-loans',
        'super-saver-loans' => 'super-saver-loans',
        'salary-advance' => 'salary-advance',
        'savings-accounts' => 'savings-accounts',
        'membership-benefits' => 'membership-benefits',
        'products-services' => array('products-services', 'general'),
        'financial-education' => 'financial-education',
        'homepage' => array('general', 'membership-benefits')
    );
    
    $categories = isset($category_mapping[$page_type]) ? $category_mapping[$page_type] : 'general';
    
    if (is_array($categories)) {
        $tax_query = "
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('" . implode("', '", $categories) . "'),
                        'operator' => 'IN'
                    )
                )";
    } else {
        $tax_query = "
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => '$categories'
                    )
                )";
    }
    
    return "
            <?php
            // Query testimonials from custom post type - $page_type testimonials
            \$testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => $posts_per_page,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                $tax_query
            ));
            
            // Fallback to general testimonials if no specific testimonials found
            if (!\$testimonials_query->have_posts()) {
                \$testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => $posts_per_page,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'testimonial_category',
                            'field' => 'slug',
                            'terms' => 'general'
                        )
                    )
                ));
            }
            ?>";
}

/**
 * Generate testimonials display code
 */
function generate_testimonials_display($layout = 'grid') {
    if ($layout === 'slider') {
        return '
            <?php if ($testimonials_query->have_posts()) : ?>
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                            // Get custom fields
                            $rating = get_post_meta(get_the_ID(), \'_testimonial_rating\', true);
                            $member_since = get_post_meta(get_the_ID(), \'_member_since\', true);
                            $position = get_post_meta(get_the_ID(), \'_position\', true);
                            $member_type = get_post_meta(get_the_ID(), \'_member_type\', true);
                            
                            // Set defaults if fields are empty
                            $rating = $rating ? floatval($rating) : 5;
                            $member_since = $member_since ? $member_since : \'\';
                            $position = $position ? $position : \'\';
                            $member_type = $member_type ? $member_type : \'Member\';
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card enhanced">
                                <div class="testimonial-quote-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <?php if ($i <= floor($rating)) : ?>
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php elseif ($i <= $rating) : ?>
                                            <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                        <?php else : ?>
                                            <i class="far fa-star" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-content">
                                    <p>"<?php echo wp_trim_words(get_the_content(), 40, \'...\'); ?>"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail(\'thumbnail\', array(\'alt\' => get_the_title(), \'class\' => \'testimonial-img\')); ?>
                                        <?php else : ?>
                                            <div class="testimonial-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5><?php the_title(); ?></h5>
                                        <?php if ($position) : ?>
                                            <p class="position"><?php echo esc_html($position); ?></p>
                                        <?php endif; ?>
                                        <?php if ($member_type && $member_type !== \'Member\') : ?>
                                            <p class="member-type"><?php echo esc_html($member_type); ?></p>
                                        <?php endif; ?>
                                        <?php if ($member_since) : ?>
                                            <p class="member-since">Member since <?php echo esc_html($member_since); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="testimonials-navigation">
                        <div class="swiper-button-prev testimonials-prev">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="swiper-button-next testimonials-next">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination testimonials-pagination"></div>
                </div>
            <?php else : ?>
                <!-- Fallback message if no testimonials -->
                <div class="alert alert-info">
                    <p>No testimonials available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>';
    } else {
        // Grid layout
        return '
            <?php if ($testimonials_query->have_posts()) : ?>
                <div class="row">
                    <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        // Get custom fields
                        $rating = get_post_meta(get_the_ID(), \'_testimonial_rating\', true);
                        $member_since = get_post_meta(get_the_ID(), \'_member_since\', true);
                        $position = get_post_meta(get_the_ID(), \'_position\', true);
                        $member_type = get_post_meta(get_the_ID(), \'_member_type\', true);
                        
                        // Set defaults if fields are empty
                        $rating = $rating ? floatval($rating) : 5;
                        $member_since = $member_since ? $member_since : \'\';
                        $position = $position ? $position : \'\';
                        $member_type = $member_type ? $member_type : \'Member\';
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-card fade-in">
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= floor($rating)) : ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                    <?php elseif ($i <= $rating) : ?>
                                        <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                    <?php else : ?>
                                        <i class="far fa-star" aria-hidden="true"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="testimonial-content">
                                <p>"<?php echo wp_trim_words(get_the_content(), 30, \'...\'); ?>"</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail(\'thumbnail\', array(\'alt\' => get_the_title(), \'class\' => \'testimonial-img\')); ?>
                                    <?php else : ?>
                                        <div class="testimonial-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="testimonial-author-info">
                                    <h5><?php the_title(); ?></h5>
                                    <?php if ($position) : ?>
                                        <p><?php echo esc_html($position); ?></p>
                                    <?php endif; ?>
                                    <?php if ($member_since) : ?>
                                        <small class="text-muted">Member since <?php echo esc_html($member_since); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <!-- Fallback message if no testimonials -->
                <div class="alert alert-info">
                    <p>No testimonials available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>';
    }
}

/**
 * Pages to update with their corresponding testimonial categories
 */
function get_pages_to_update() {
    return array(
        'page-development-loans.php' => array(
            'category' => 'development-loans',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-emergency-loans.php' => array(
            'category' => 'emergency-loans',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-school-fees-loans.php' => array(
            'category' => 'school-fees-loans',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-special-loans.php' => array(
            'category' => 'special-loans',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-super-saver-loans.php' => array(
            'category' => 'super-saver-loans',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-salary-advance.php' => array(
            'category' => 'salary-advance',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-savings-accounts.php' => array(
            'category' => 'savings-accounts',
            'layout' => 'grid',
            'posts_per_page' => 3
        ),
        'page-membership-benefits.php' => array(
            'category' => 'membership-benefits',
            'layout' => 'grid',
            'posts_per_page' => 4
        ),
        'page-products-services.php' => array(
            'category' => 'products-services',
            'layout' => 'slider',
            'posts_per_page' => 6
        ),
        'page-financial-education.php' => array(
            'category' => 'financial-education',
            'layout' => 'grid',
            'posts_per_page' => 3
        )
    );
}

/**
 * Display update instructions and code examples
 */
function display_update_instructions() {
    echo "<h1>Testimonials System Update Instructions</h1>\n";
    echo "<p>This page provides the updated code for all pages to use categorized testimonials.</p>\n";
    
    $pages = get_pages_to_update();
    
    foreach ($pages as $filename => $config) {
        echo "<div style='border: 1px solid #ddd; margin: 20px 0; padding: 20px; background: #f9f9f9;'>\n";
        echo "<h2>$filename</h2>\n";
        echo "<p><strong>Category:</strong> {$config['category']}</p>\n";
        echo "<p><strong>Layout:</strong> {$config['layout']}</p>\n";
        echo "<p><strong>Posts per page:</strong> {$config['posts_per_page']}</p>\n";
        
        echo "<h3>Query Code:</h3>\n";
        echo "<pre style='background: #f0f0f0; padding: 10px; overflow-x: auto;'>";
        echo htmlspecialchars(generate_testimonials_query($config['category'], $config['posts_per_page']));
        echo "</pre>\n";
        
        echo "<h3>Display Code:</h3>\n";
        echo "<pre style='background: #f0f0f0; padding: 10px; overflow-x: auto;'>";
        echo htmlspecialchars(generate_testimonials_display($config['layout']));
        echo "</pre>\n";
        
        echo "</div>\n";
    }
    
    echo "<div style='border: 1px solid #28a745; margin: 20px 0; padding: 20px; background: #d4edda;'>\n";
    echo "<h2>Implementation Steps:</h2>\n";
    echo "<ol>\n";
    echo "<li><strong>Run the testimonials population script</strong> first via WordPress Admin > Tools > Populate Testimonials</li>\n";
    echo "<li><strong>For each page listed above:</strong></li>\n";
    echo "<ul>\n";
    echo "<li>Find the existing testimonials section in the page file</li>\n";
    echo "<li>Replace the static testimonials with the Query Code provided</li>\n";
    echo "<li>Replace the testimonials display HTML with the Display Code provided</li>\n";
    echo "<li>Test the page to ensure testimonials are loading correctly</li>\n";
    echo "</ul>\n";
    echo "<li><strong>Verify the results:</strong></li>\n";
    echo "<ul>\n";
    echo "<li>Each page should show testimonials relevant to its category</li>\n";
    echo "<li>If no category-specific testimonials exist, it should fall back to general testimonials</li>\n";
    echo "<li>Testimonials should display with proper ratings, member info, and formatting</li>\n";
    echo "</ul>\n";
    echo "</ol>\n";
    echo "</div>\n";
    
    echo "<div style='border: 1px solid #ffc107; margin: 20px 0; padding: 20px; background: #fff3cd;'>\n";
    echo "<h2>Important Notes:</h2>\n";
    echo "<ul>\n";
    echo "<li><strong>Backup your files</strong> before making changes</li>\n";
    echo "<li><strong>Test on a staging site</strong> first if possible</li>\n";
    echo "<li><strong>Random order:</strong> Testimonials will appear in random order on each page load for variety</li>\n";
    echo "<li><strong>Fallback system:</strong> If no testimonials exist for a specific category, general testimonials will be shown</li>\n";
    echo "<li><strong>Responsive design:</strong> The provided code includes responsive classes for mobile compatibility</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='border: 1px solid #17a2b8; margin: 20px 0; padding: 20px; background: #d1ecf1;'>\n";
    echo "<h2>Available Testimonial Categories:</h2>\n";
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
    } else {
        echo "<p><em>No testimonial categories found. Please run the testimonials population script first.</em></p>\n";
    }
    echo "</div>\n";
}

// Run the display function if accessed directly
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    display_update_instructions();
}
?>