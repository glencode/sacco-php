<?php
/**
 * The template for displaying the Products/Services page - Improved Version
 *
 * This is the improved Products/Services page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main products-page" style="
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/productsimg2.jpg') no-repeat center center fixed !important; 
    background-size: cover !important;
    min-height: 100vh !important;
">
    
    <!-- Enhanced Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="daystar-badge badge-primary" data-aos="fade-up">Comprehensive Financial Solutions</span>
                    <h1 class="page-title" data-aos="fade-up" data-aos-delay="200">Our Loan Products</h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="400">Empowering your financial journey with flexible, affordable loan solutions designed to meet your unique needs and aspirations.</p>
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="600">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Loan Products</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image" data-aos="fade-left" data-aos-delay="800">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/products-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Overview Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title">Loan Solutions Tailored for You</h2>
                        <p class="lead">We offer a comprehensive range of loan products designed to meet your unique financial needs at every stage of life.</p>
                        <p>Whether you're planning a major purchase, need emergency funds, or looking to invest in development projects, our team of financial experts is here to help you achieve your goals with personalized loan solutions and competitive rates.</p>
                        <div class="mt-4">
                            <a href="#loans" class="btn btn-primary">View Our Loans</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="products-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/products-overview.jpg" alt="Financial advisor meeting with client" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Loan Products Section -->
    <section id="loans" class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Loan Products</h2>
                <p class="section-subtitle">Flexible financing solutions to meet your needs</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-icon">
                            <i class="fas fa-building" aria-hidden="true"></i>
                        </div>
                        <h3>Development Loans</h3>
                        <ul class="product-features">
                            <li>Long-term development projects</li>
                            <li>Up to 36-month repayment terms</li>
                            <li>Maximum KSh 2,000,000</li>
                            <li>Flexible security options</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('development-loans')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>School Fees Loans</h3>
                        <ul class="product-features">
                            <li>Education financing</li>
                            <li>Up to 24-month repayment terms</li>
                            <li>Maximum KSh 500,000</li>
                            <li>Quick processing for urgent needs</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">10%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('school-fees-loans')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in" data-aos="fade-up" data-aos-delay="300">
                        <div class="product-icon">
                            <i class="fas fa-heartbeat" aria-hidden="true"></i>
                        </div>
                        <h3>Emergency Loans</h3>
                        <ul class="product-features">
                            <li>Same-day processing</li>
                            <li>Up to 12-month repayment terms</li>
                            <li>Maximum KSh 200,000</li>
                            <li>Minimal documentation required</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">15%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('emergency-loans')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h3>Special Loans</h3>
                        <ul class="product-features">
                            <li>Customizable terms</li>
                            <li>Up to 48-month repayment terms</li>
                            <li>Maximum KSh 1,000,000</li>
                            <li>Personalized service</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">14%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('special-loans')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                        </div>
                        <h3>Super Saver Loans</h3>
                        <ul class="product-features">
                            <li>Lowest interest rates</li>
                            <li>Up to 60-month repayment terms</li>
                            <li>Maximum KSh 800,000</li>
                            <li>Exclusive benefits for super savers</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">8%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('super-saver-loans')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Salary Advance</h3>
                        <ul class="product-features">
                            <li>Instant processing</li>
                            <li>Short-term repayment (30 days)</li>
                            <li>Maximum KSh 100,000</li>
                            <li>Simple fee structure</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">10%</span>
                            <span class="rate-label">One-time Fee</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('salary-advance')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-primary">Try Our Loan Calculator</a>
            </div>
        </div>
    </section>

    <!-- Loan Comparison Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Loan Comparison</h2>
                <p class="section-subtitle">Compare our loan products to find the right fit for your needs</p>
            </div>
            
            <div class="table-responsive mt-5 fade-in">
                <table class="table product-comparison-table">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            <th scope="col">Development Loans</th>
                            <th scope="col">Emergency Loans</th>
                            <th scope="col">Super Saver Loans</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Maximum Amount</th>
                            <td>KSh 2,000,000</td>
                            <td>KSh 200,000</td>
                            <td>KSh 800,000</td>
                        </tr>
                        <tr>
                            <th scope="row">Interest Rate</th>
                            <td>12% p.a.</td>
                            <td>15% p.a.</td>
                            <td>8% p.a.</td>
                        </tr>
                        <tr>
                            <th scope="row">Maximum Term</th>
                            <td>36 months</td>
                            <td>12 months</td>
                            <td>60 months</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Time</th>
                            <td>7-14 days</td>
                            <td>Same day</td>
                            <td>3-5 days</td>
                        </tr>
                        <tr>
                            <th scope="row">Minimum Membership</th>
                            <td>6 months</td>
                            <td>1 month</td>
                            <td>24 months</td>
                        </tr>
                        <tr>
                            <th scope="row">Early Repayment Fee</th>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Fee</th>
                            <td>2%</td>
                            <td>None</td>
                            <td>Waived</td>
                        </tr>
                        <tr>
                            <th scope="row">Special Requirements</th>
                            <td>Project proposal</td>
                            <td>Emergency proof</td>
                            <td>Super saver status</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive mt-5 fade-in">
                <table class="table product-comparison-table">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            <th scope="col">School Fees Loans</th>
                            <th scope="col">Special Loans</th>
                            <th scope="col">Salary Advance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Maximum Amount</th>
                            <td>KSh 500,000</td>
                            <td>KSh 1,000,000</td>
                            <td>KSh 100,000</td>
                        </tr>
                        <tr>
                            <th scope="row">Interest Rate</th>
                            <td>10% p.a.</td>
                            <td>14% p.a.</td>
                            <td>10% one-time fee</td>
                        </tr>
                        <tr>
                            <th scope="row">Maximum Term</th>
                            <td>24 months</td>
                            <td>48 months</td>
                            <td>30 days</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Time</th>
                            <td>3-7 days</td>
                            <td>7-14 days</td>
                            <td>Same day</td>
                        </tr>
                        <tr>
                            <th scope="row">Minimum Membership</th>
                            <td>3 months</td>
                            <td>12 months</td>
                            <td>1 month</td>
                        </tr>
                        <tr>
                            <th scope="row">Early Repayment Fee</th>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Fee</th>
                            <td>1.5%</td>
                            <td>2.5%</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <th scope="row">Special Requirements</th>
                            <td>School fee invoice</td>
                            <td>Detailed proposal</td>
                            <td>Pay slip</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Additional Services Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Additional Services</h2>
                <p class="section-subtitle">Beyond loans, we offer a range of financial services</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-tasks" aria-hidden="true"></i>
                        </div>
                        <h3>Loan Management</h3>
                        <p>Comprehensive loan management services to help you track, manage, and optimize your loan portfolio with expert guidance and support.</p>
                        <a href="<?php echo esc_url(home_url('services/loan-management')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                        </div>
                        <h3>General Finance Planning</h3>
                        <p>Work with our certified financial advisors to create a personalized plan to achieve your short and long-term financial goals.</p>
                        <a href="<?php echo esc_url(home_url('services/financial-planning')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Risk Management</h3>
                        <p>Protect your financial future with our comprehensive risk management services, including assessment, mitigation strategies, and insurance solutions.</p>
                        <a href="<?php echo esc_url(home_url('services/risk-management')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our Products & Services</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Products & Services specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('products-services'),
                        'operator' => 'IN'
                    )
                )
            ));
            
            // Fallback to all testimonials if no categorized ones found
            if (!$testimonials_query->have_posts()) {
                $testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => 8,
                    'post_status' => 'publish',
                    'orderby' => 'rand'
                ));
            }
            
            if ($testimonials_query->have_posts()) : ?>
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                            // Get custom fields using WordPress native functions
                            $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                            $member_since = get_post_meta(get_the_ID(), '_member_since', true);
                            $position = get_post_meta(get_the_ID(), '_position', true);
                            $member_type = get_post_meta(get_the_ID(), '_member_type', true);
                            
                            // Set defaults if fields are empty
                            $rating = $rating ? floatval($rating) : 5;
                            $member_since = $member_since ? $member_since : '';
                            $position = $position ? $position : '';
                            $member_type = $member_type ? $member_type : 'Member';
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
                                    <p>"<?php echo wp_trim_words(get_the_content(), 40, '...'); ?>"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title(), 'class' => 'testimonial-img')); ?>
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
                                        <?php if ($member_type && $member_type !== 'Member') : ?>
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
                                    <p>"Daystar SACCO offers an excellent range of financial products. From development loans to emergency funds, they have everything I need to manage my finances effectively."</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <div class="testimonial-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5>Peter Mwangi</h5>
                                        <p class="position">Business Owner</p>
                                        <p class="member-since">Member since 2017</p>
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
    </section>

    </main>

<?php
get_footer();
