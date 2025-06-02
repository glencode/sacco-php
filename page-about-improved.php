<?php
/**
 * The template for displaying the About page - Improved Version
 *
 * This is the improved About page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main about-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">About Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-intro.jpg" alt="Our SACCO office building" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-content fade-in">
                        <h2 class="section-title">Welcome to <?php bloginfo('name'); ?></h2>
                        <p class="lead">We are a leading financial cooperative committed to empowering our members through innovative savings and loan products, financial education, and exceptional service.</p>
                        <p>Established in 1995, our SACCO has grown to serve over 50,000 members across the country. We believe in the cooperative principle of people helping people, and our mission is to help our members achieve financial success through affordable financial services and education.</p>
                        <div class="mt-4">
                            <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary me-3">Join Us</a>
                            <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-primary">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Our Core Values</h2>
                <p class="section-subtitle">The principles that guide everything we do</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-handshake" aria-hidden="true"></i>
                        </div>
                        <h3>Integrity</h3>
                        <p>We conduct our business with honesty, transparency, and accountability in all our dealings with members and stakeholders.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-users" aria-hidden="true"></i>
                        </div>
                        <h3>Community</h3>
                        <p>We believe in the power of cooperation and are committed to improving the financial well-being of our community.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                        </div>
                        <h3>Innovation</h3>
                        <p>We continuously seek new ways to improve our services and meet the evolving needs of our members.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Security</h3>
                        <p>We prioritize the safety of our members' funds and personal information through robust systems and practices.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Education</h3>
                        <p>We are committed to providing financial education to empower our members to make informed financial decisions.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="value-card fade-in">
                        <div class="value-icon">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                        </div>
                        <h3>Member Focus</h3>
                        <p>Our members are at the center of everything we do, and their satisfaction is our ultimate measure of success.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our History Timeline -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Our Journey</h2>
                <p class="section-subtitle">A timeline of our growth and achievements</p>
            </div>
            
            <div class="timeline fade-in">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">1995</div>
                        <h3>Foundation</h3>
                        <p>Established with just 50 members and a vision to create a member-owned financial institution.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">2000</div>
                        <h3>First Branch</h3>
                        <p>Opened our first physical branch office to better serve our growing membership of 5,000.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">2005</div>
                        <h3>Digital Transformation</h3>
                        <p>Launched our first online banking platform, bringing convenience to our 15,000 members.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">2010</div>
                        <h3>Expansion</h3>
                        <p>Reached 25,000 members and expanded to 10 branches across the country.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">2015</div>
                        <h3>Innovation Award</h3>
                        <p>Recognized with the National Financial Innovation Award for our mobile banking solution.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">2020</div>
                        <h3>Milestone</h3>
                        <p>Celebrated our 25th anniversary with 50,000 members and $2 billion in assets.</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-date">Today</div>
                        <h3>Looking Forward</h3>
                        <p>Continuing to grow and innovate while staying true to our core mission of serving our members.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Our Leadership Team</h2>
                <p class="section-subtitle">Meet the dedicated professionals guiding our organization</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-1.jpg" alt="Sarah Johnson - CEO">
                        </div>
                        <div class="team-content">
                            <h3>Sarah Johnson</h3>
                            <p class="team-position">Chief Executive Officer</p>
                            <p class="team-bio">With over 20 years of experience in the financial sector, Sarah leads our organization with vision and integrity.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-2.jpg" alt="Michael Rodriguez - CFO">
                        </div>
                        <div class="team-content">
                            <h3>Michael Rodriguez</h3>
                            <p class="team-position">Chief Financial Officer</p>
                            <p class="team-bio">Michael ensures our financial stability and growth through strategic planning and sound fiscal management.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-3.jpg" alt="Jennifer Lee - COO">
                        </div>
                        <div class="team-content">
                            <h3>Jennifer Lee</h3>
                            <p class="team-position">Chief Operations Officer</p>
                            <p class="team-bio">Jennifer oversees our day-to-day operations, ensuring excellent service delivery to all our members.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-4.jpg" alt="David Ochieng - CTO">
                        </div>
                        <div class="team-content">
                            <h3>David Ochieng</h3>
                            <p class="team-position">Chief Technology Officer</p>
                            <p class="team-bio">David leads our digital transformation initiatives, ensuring we leverage technology to serve our members better.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-5.jpg" alt="Grace Muthoni - Head of Member Services">
                        </div>
                        <div class="team-content">
                            <h3>Grace Muthoni</h3>
                            <p class="team-position">Head of Member Services</p>
                            <p class="team-bio">Grace ensures that our members receive exceptional service and support across all our branches.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card fade-in">
                        <div class="team-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-6.jpg" alt="Robert Kamau - Head of Credit">
                        </div>
                        <div class="team-content">
                            <h3>Robert Kamau</h3>
                            <p class="team-position">Head of Credit</p>
                            <p class="team-bio">Robert oversees our loan products and ensures responsible lending practices that benefit our members.</p>
                            <div class="team-social">
                                <a href="#" aria-label="LinkedIn profile"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="#" aria-label="Twitter profile"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('board-of-directors')); ?>" class="btn btn-primary">Meet Our Board of Directors</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">What Our Members Say</h2>
                <p class="section-subtitle">Hear from those who have experienced our services</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The mortgage process was seamless and the team provided exceptional guidance throughout. I'm now a proud homeowner thanks to their support!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial1.jpg" alt="Jane Doe">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Jane Doe</h5>
                                <p>Member since 2018</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The financial education workshops have completely transformed how I manage my finances. I've paid off debt and started building real savings!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial2.jpg" alt="John Smith">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>John Smith</h5>
                                <p>Member since 2020</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The business loan I received helped me expand my small business. The personalized service and competitive rates made all the difference."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial3.jpg" alt="Mary Johnson">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Mary Johnson</h5>
                                <p>Member since 2015</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Ready to Join Our Community?</h2>
                        <p class="cta-subtitle">Become a member today and start your journey to financial success.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-gradient btn-lg">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
