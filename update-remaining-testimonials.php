<?php
/**
 * Script to update testimonials sections on remaining pages
 * This script will update the testimonials sections on the remaining pages to match the homepage design
 */

// Define the enhanced testimonials section template
function get_enhanced_testimonials_section($page_slug, $page_title, $fallback_testimonial) {
    return '    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our ' . $page_title . '</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - ' . $page_title . ' specific
            $testimonials_query = new WP_Query(array(
                \'post_type\' => \'testimonial\',
                \'posts_per_page\' => 8,
                \'post_status\' => \'publish\',
                \'orderby\' => \'rand\', // Random order for variety
                \'tax_query\' => array(
                    array(
                        \'taxonomy\' => \'testimonial_category\',
                        \'field\' => \'slug\',
                        \'terms\' => array(\'' . $page_slug . '\'),
                        \'operator\' => \'IN\'
                    )
                )
            ));
            
            // Fallback to all testimonials if no categorized ones found
            if (!$testimonials_query->have_posts()) {
                $testimonials_query = new WP_Query(array(
                    \'post_type\' => \'testimonial\',
                    \'posts_per_page\' => 8,
                    \'post_status\' => \'publish\',
                    \'orderby\' => \'rand\'
                ));
            }
            
            if ($testimonials_query->have_posts()) : ?>
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                            // Get custom fields using WordPress native functions
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
                <!-- Fallback static testimonials if no dynamic content -->
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-card enhanced">
                                <div class="testimonial-quote-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="testimonial-content">
                                    <p>"' . $fallback_testimonial . '"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <div class="testimonial-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5>Sample Member</h5>
                                        <p class="position">SACCO Member</p>
                                        <p class="member-since">Member since 2020</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </section>';
}

// Define the pages to update
$pages_to_update = array(
    'page-salary-advance.php' => array(
        'slug' => 'salary-advance',
        'title' => 'Salary Advance',
        'fallback' => 'The salary advance service from Daystar SACCO has been a lifesaver during tight months. Quick processing and fair terms make it the perfect short-term solution.'
    ),
    'page-school-fees-loans.php' => array(
        'slug' => 'school-fees-loans',
        'title' => 'School Fees Loans',
        'fallback' => 'Thanks to Daystar SACCO\'s school fees loan, I was able to pay my children\'s fees on time. The competitive rates and flexible terms made education financing stress-free.'
    ),
    'page-special-loans.php' => array(
        'slug' => 'special-loans',
        'title' => 'Special Loans',
        'fallback' => 'The special loan product offered exactly what I needed with customized terms. Daystar SACCO truly understands individual member needs and provides personalized solutions.'
    ),
    'page-super-saver-loans.php' => array(
        'slug' => 'super-saver-loans',
        'title' => 'Super Saver Loans',
        'fallback' => 'As a long-term member, the super saver loan rewards my loyalty with excellent rates and terms. It\'s great to see my consistent saving efforts being recognized and rewarded.'
    )
);

echo "Enhanced testimonials section template created successfully!\n";
echo "Pages to update: " . implode(', ', array_keys($pages_to_update)) . "\n";
echo "Please manually update each page file with the enhanced testimonials section.\n";

// Output the template for each page
foreach ($pages_to_update as $filename => $page_data) {
    echo "\n\n=== TEMPLATE FOR $filename ===\n";
    echo get_enhanced_testimonials_section($page_data['slug'], $page_data['title'], $page_data['fallback']);
    echo "\n=== END TEMPLATE FOR $filename ===\n";
}
?>