<?php
/**
 * The template for displaying the front page of Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Modern Hero Section with Dynamic Content -->
    <section class="modern-hero-section" id="hero">
        <!-- Animated Background Elements -->
        <div class="hero-background">
            <div class="hero-bg-overlay"></div>
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>
        </div>
        
        <!-- Hero Content Grid -->
        <div class="hero-container">
            <div class="hero-content-grid">
                <!-- Main Content Area -->
                <div class="hero-main-content">
                    <h1 class="hero-title">
                        <span class="title-line-1">Empowering Your</span>
                        <span class="title-line-2 gradient-text">Financial Future</span>
                        <span class="title-line-3">Together</span>
                    </h1>
                    
                    <p class="hero-description">
                        A Daystar Staff saving and Credit Society established in 1990, dedicated to improving the welfare of Daystar staff through pooled resources in the form of monthly deposits and advancing loans to members.
                    </p>
                    
                    <!-- Key Benefits -->
                    <div class="hero-benefits">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <span>Competitive Rates</span>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <span>Quick Processing</span>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <span>Secure & Trusted</span>
                        </div>
                    </div>
                    
               
                </div>
                
                <!-- Creative Quick Actions Panel -->
                <div class="hero-quick-actions-panel">
                    <div class="quick-actions-header">
                        <h3>Quick Access</h3>
                        <p>Get started in seconds</p>
                    </div>
                    
                    <div class="quick-actions-grid-modern">
                        <a href="<?php echo esc_url(home_url('register')); ?>" class="quick-action-card" data-action="register">
                            <div class="action-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="action-content">
                                <h4>Join Now</h4>
                                <p>Become a member</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="quick-action-card" data-action="apply">
                            <div class="action-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="action-content">
                                <h4>Apply for Loan</h4>
                                <p>Start your application</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="scroll-indicator">
                <div class="scroll-text">Scroll to explore</div>
                <div class="scroll-arrow">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sections with Ocean Background Overlay -->
    <div class="homepage-sections-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/oceanbackground.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
        <!-- Ocean Background Overlay -->
        <div class="ocean-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(2px); z-index: 1;"></div>
        
        <!-- Statistics Section -->
        <section class="stats-section animate-on-scroll" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number" data-stat="members" data-count="2500">0</div>
                        <div class="stat-label">Active Members</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-stat="loans" data-count="15000000">0</div>
                        <div class="stat-label">Loans Disbursed (KSh)</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-stat="applications" data-count="5000">0</div>
                        <div class="stat-label">Loan Applications Processed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-stat="years" data-count="34">0</div>
                        <div class="stat-label">Years Serving</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Services Section -->
        <section class="services-section" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <h2 class="section-title">About Daystar Multi-Purpose Co-operative Society</h2>
                    <p class="section-subtitle">A Daystar Staff saving and Credit Society established in 1990</p>
                </div>
                
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="about-content animate-on-scroll">
                            <div class="university-badge">
                                <i class="fas fa-university"></i>
                                <span>Daystar University Community</span>
                            </div>
                            <h3>Your Trusted Financial Partner</h3>
                            <p>Daystar Multi-Purpose Co-operative Society Ltd. is a Daystar Staff saving and Credit Society established in 1990. Our ultimate objective is to improve the welfare of Daystar staff through pooling of resources in the form of monthly deposits and advancing the same to members as loans.</p>
                            
                            <div class="key-highlights">
                                <div class="highlight-item">
                                    <i class="fas fa-users"></i>
                                    <div>
                                        <strong>Member-Owned</strong>
                                        <p>Every member is a co-owner with voting rights and shared prosperity</p>
                                    </div>
                                </div>
                                <div class="highlight-item">
                                    <i class="fas fa-handshake"></i>
                                    <div>
                                        <strong>Community-Focused</strong>
                                        <p>Dedicated to serving the unique needs of the Daystar University family</p>
                                    </div>
                                </div>
                                <div class="highlight-item">
                                    <i class="fas fa-chart-line"></i>
                                    <div>
                                        <strong>34+ Years Experience</strong>
                                        <p>Over three decades of trusted financial services and member support</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="cta-buttons">
                                <a href="<?php echo esc_url(home_url('about')); ?>" class="btn btn-primary">Learn More About Us</a>
                                <a href="<?php echo esc_url(home_url('membership')); ?>" class="btn btn-outline-primary">Membership Info</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-image animate-on-scroll">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-campus-community.jpg" alt="Daystar University Community" class="img-fluid rounded-lg shadow">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Membership Requirements Section -->
        <section class="membership-section animate-on-scroll" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Membership Requirements</h2>
                    <p class="section-subtitle">Join our cooperative society and enjoy exclusive benefits</p>
                </div>
                
                <div class="requirements-grid">
                    <div class="requirement-card animate-on-scroll">
                        <div class="requirement-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>6 Months Membership</h3>
                        <p>To be eligible for loans, you must be a member for at least 6 months with consistent contributions.</p>
                    </div>
                    
                    <div class="requirement-card animate-on-scroll">
                        <div class="requirement-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3>Minimum Contribution</h3>
                        <p>Contribute consistently not less than KSh 12,000 (KSh 2,000 × 6 months) to qualify for loans.</p>
                    </div>
                    
                    <div class="requirement-card animate-on-scroll">
                        <div class="requirement-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3>Share Capital</h3>
                        <p>Own a minimum of KSh 5,000 as share capital (250 shares worth KSh 200 each).</p>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary btn-lg">Learn How to Join</a>
                </div>
            </div>
        </section>

        <!-- Loan Products Section -->
        <section class="section" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="text-center mb-5 fade-in">
                    <h2 class="section-title">Our Loan Products</h2>
                    <p class="section-subtitle">Tailored financial solutions to meet your needs</p>
                </div>
                
                <div class="loan-types-tabs fade-in">
                    <ul class="nav nav-pills mb-4 justify-content-center" id="loanTypesTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="development-tab" data-bs-toggle="pill" data-bs-target="#development" type="button" role="tab" aria-controls="development" aria-selected="true">Development</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="school-tab" data-bs-toggle="pill" data-bs-target="#school" type="button" role="tab" aria-controls="school" aria-selected="false">School Fees</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="emergency-tab" data-bs-toggle="pill" data-bs-target="#emergency" type="button" role="tab" aria-controls="emergency" aria-selected="false">Emergency</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="special-tab" data-bs-toggle="pill" data-bs-target="#special" type="button" role="tab" aria-controls="special" aria-selected="false">Special</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="supersaver-tab" data-bs-toggle="pill" data-bs-target="#supersaver" type="button" role="tab" aria-controls="supersaver" aria-selected="false">Super Saver</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="pill" data-bs-target="#salary" type="button" role="tab" aria-controls="salary" aria-selected="false">Salary Advance</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="loanTypesTabContent">
                        <!-- Development Loan -->
                        <div class="tab-pane fade show active" id="development" role="tabpanel" aria-labelledby="development-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>Development Loan</h3>
                                    <p class="lead">For your long-term development projects and investments.</p>
                                    <ul class="feature-list">
                                        <li><strong>Maximum Amount:</strong> KSh 2,000,000</li>
                                        <li><strong>Interest Rate:</strong> 12% per annum on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> Up to 36 months</li>
                                        <li><strong>Requirements:</strong> Fully guaranteed by shares/guarantors</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('development-loans')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/development-loan.jpg" alt="Development Loan" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        
                        <!-- School Fees Loan -->
                        <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="school-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>School Fees Loan</h3>
                                    <p class="lead">Invest in education with our affordable school fees financing.</p>
                                    <ul class="feature-list">
                                        <li><strong>Interest Rate:</strong> 12% per annum on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> Up to 12 months</li>
                                        <li><strong>Requirements:</strong> Fee structure or admission letter</li>
                                        <li><strong>Additional:</strong> Fully guaranteed by shares/guarantors</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('school-fees-loans')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/school-fees-loan.jpg" alt="School Fees Loan" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Emergency Loan -->
                        <div class="tab-pane fade" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>Emergency Loan</h3>
                                    <p class="lead">Quick financial assistance for unexpected situations.</p>
                                    <ul class="feature-list">
                                        <li><strong>Maximum Amount:</strong> KSh 100,000</li>
                                        <li><strong>Repayment Period:</strong> Up to 12 months</li>
                                        <li><strong>Eligible Emergencies:</strong> Hospitalization, funeral expenses, court fines, etc.</li>
                                        <li><strong>Requirements:</strong> Documentary evidence of emergency</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('emergency-loans')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/emergency-loan.jpg" alt="Emergency Loan" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Special Loan -->
                        <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>Special Loan</h3>
                                    <p class="lead">Character-based loans without payslip consideration.</p>
                                    <ul class="feature-list">
                                        <li><strong>Maximum Amount:</strong> KSh 200,000</li>
                                        <li><strong>Interest Rate:</strong> 5% per month on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> 4-6 months (based on amount)</li>
                                        <li><strong>Requirements:</strong> Postdated cheques as guarantee</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('special-loans')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/special-loan.jpeg" alt="Special Loan" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Super Saver Loan -->
                        <div class="tab-pane fade" id="supersaver" role="tabpanel" aria-labelledby="supersaver-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>Super Saver Loan</h3>
                                    <p class="lead">Premium loans for our high-deposit members.</p>
                                    <ul class="feature-list">
                                        <li><strong>Maximum Amount:</strong> KSh 3,000,000</li>
                                        <li><strong>Repayment Period:</strong> Up to 48 months</li>
                                        <li><strong>Eligibility:</strong> Deposits of more than KSh 1,000,000</li>
                                        <li><strong>Requirements:</strong> Fully guaranteed by shares/guarantors</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('super-saver-loans')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/super-saver-loan.jpg" alt="Super Saver Loan" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Salary Advance -->
                        <div class="tab-pane fade" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <h3>Salary Advance</h3>
                                    <p class="lead">Short-term financial assistance for immediate needs.</p>
                                    <ul class="feature-list">
                                        <li><strong>Repayment Period:</strong> Maximum 3 months</li>
                                        <li><strong>Interest Fee:</strong> 10% one-off charge for first month (members)</li>
                                        <li><strong>Non-members:</strong> 12.5% for one month</li>
                                        <li><strong>Requirements:</strong> Proof of capacity to repay</li>
                                    </ul>
                                    <div class="mt-4">
                                        <a href="<?php echo esc_url(home_url('salary-advance')); ?>" class="btn btn-primary">Learn More</a>
                                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary ms-2">Calculate Repayments</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salary-advance.jpeg" alt="Salary Advance" class="img-fluid rounded-lg shadow">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="section bg-light" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="text-center mb-5 fade-in">
                    <h2 class="section-title">Why Choose Daystar Co-op</h2>
                    <p class="section-subtitle">Experience the benefits of our cooperative society</p>
                </div>
                
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-percentage" aria-hidden="true"></i>
                            </div>
                            <h3>Competitive Rates</h3>
                            <p>Enjoy favorable interest rates on loans and attractive returns on your savings.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-handshake" aria-hidden="true"></i>
                            </div>
                            <h3>Member-Owned</h3>
                            <p>As a member, you're a co-owner with voting rights and shared prosperity.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt" aria-hidden="true"></i>
                            </div>
                            <h3>Financial Security</h3>
                            <p>Build a secure financial future through consistent savings and smart borrowing.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="feature-card fade-in">
                            <div class="feature-icon">
                                <i class="fas fa-university" aria-hidden="true"></i>
                            </div>
                            <h3>Daystar Affiliation</h3>
                            <p>Benefit from our strong connection with Daystar University community.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Loan Calculator Preview Section -->
        <section class="section" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="section-content fade-in">
                            <h2 class="section-title text-start">Plan Your Finances</h2>
                            <p class="lead">Use our loan calculator to estimate your monthly payments and plan your finances effectively.</p>
                            <p>Our easy-to-use calculators help you determine loan repayments, interest costs, and total payment amounts for all our loan products. Make informed financial decisions with accurate calculations.</p>
                            <div class="mt-4">
                                <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-primary">Try Our Loan Calculator</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="calculator-preview fade-in">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-preview.jpeg" alt="Loan Calculator Preview" class="img-fluid rounded-lg shadow">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Dynamic Testimonials Section -->
        <section class="section testimonials-section bg-light" style="position: relative; z-index: 2;">
            <div class="container">
                <div class="text-center mb-5 fade-in">
                    <h2 class="section-title">Member Testimonials</h2>
                    <p class="section-subtitle">What our members say about us</p>
                </div>
                
                <?php
                // Query testimonials from custom post type - Homepage gets general and membership benefits
                $testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => 8,
                    'post_status' => 'publish',
                    'orderby' => 'rand', // Random order for variety
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'testimonial_category',
                            'field' => 'slug',
                            'terms' => array('general', 'membership-benefits'),
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
                                        <p>"Daystar SACCO has transformed my financial life. Their loan services are quick and reliable, helping me secure funding for my business expansion when I needed it most."</p>
                                    </div>
                                    <div class="testimonial-author">
                                        <div class="testimonial-author-img">
                                            <div class="testimonial-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="testimonial-author-info">
                                            <h5>Sarah Wanjiku</h5>
                                            <p class="position">Small Business Owner</p>
                                            <p class="member-since">Member since 2019</p>
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
    </div> <!-- End homepage-sections-bg -->

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <!-- Left Icon -->
                <div class="cta-icon-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg-icon1.svg" alt="Partnership Icon" class="cta-icon cta-icon-1">
                </div>
                
                <!-- Right Icon -->
                <div class="cta-icon-right">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg-icon2.svg" alt="Success Icon" class="cta-icon cta-icon-2">
                </div>
                
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Ready to Join Daystar Co-op?</h2>
                        <p class="cta-subtitle">Take the first step toward financial empowerment and become a member today.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-gradient btn-lg">Join Now</a>
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();