<?php
/**
 * The template for displaying the Salary Advance page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main loan-product-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Salary Advance</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Salary Advance</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salary-advance-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Overview Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <span class="daystar-badge badge-info">Maximum KSh 100,000</span>
                        <h2 class="section-title text-start">Salary Advance</h2>
                        <p class="lead">Quick access to your salary before payday with minimal documentation and fast processing.</p>
                        <p>Our Salary Advance product is designed to help you bridge the gap between paydays. Whether you need funds for an unexpected expense or want to take advantage of a time-sensitive opportunity, this short-term advance gives you immediate access to a portion of your upcoming salary.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-info me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-info">Calculate Cost</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salary-advance-hero.jpg" alt="Salary Advance" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Features Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Key Features & Benefits</h2>
                <p class="section-subtitle">Why choose our Salary Advance</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-bolt" aria-hidden="true"></i>
                        </div>
                        <h3>Instant Processing</h3>
                        <p>Get your salary advance approved and disbursed within hours, not days.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Simple Fee Structure</h3>
                        <p>One-time fee of 10% of the advance amount - no monthly interest calculations.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-day" aria-hidden="true"></i>
                        </div>
                        <h3>Short-Term Repayment</h3>
                        <p>Automatic deduction from your next salary payment - typically within 30 days.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Minimal Documentation</h3>
                        <p>Simple application process with minimal paperwork required.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Salary-Based Security</h3>
                        <p>Your salary serves as security - no additional guarantors required.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Digital Application</h3>
                        <p>Apply online or via mobile for maximum convenience and speed.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">How Salary Advance Works</h2>
                <p class="section-subtitle">Simple and straightforward process</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="how-it-works fade-in">
                        <div class="work-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Apply for Advance</h4>
                                <p>Submit your salary advance request with the amount you need (up to 50% of your monthly salary).</p>
                            </div>
                        </div>
                        
                        <div class="work-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Instant Verification</h4>
                                <p>We verify your employment status and salary details with your employer or through pay slips.</p>
                            </div>
                        </div>
                        
                        <div class="work-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Quick Approval</h4>
                                <p>Receive approval within hours and get funds disbursed to your account immediately.</p>
                            </div>
                        </div>
                        
                        <div class="work-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h4>Automatic Repayment</h4>
                                <p>The advance plus fee is automatically deducted from your next salary payment.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="advance-calculator fade-in">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h3 class="mb-0">Advance Calculator</h3>
                            </div>
                            <div class="card-body">
                                <form id="advanceCalculatorForm">
                                    <div class="mb-3">
                                        <label for="monthlySalary" class="form-label">Monthly Salary (KSh)</label>
                                        <input type="number" class="form-control" id="monthlySalary" min="20000" max="500000" value="80000" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="advanceAmount" class="form-label">Advance Amount (KSh)</label>
                                        <input type="number" class="form-control" id="advanceAmount" min="5000" max="100000" value="30000" required>
                                        <div class="form-text">Maximum: 50% of monthly salary</div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-info w-100">Calculate</button>
                                </form>
                                
                                <div id="calculatorResults" class="mt-4" style="display: none;">
                                    <div class="results-summary">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="summary-item">
                                                    <h6>Advance Amount</h6>
                                                    <div class="summary-value" id="advanceAmountResult">KSh 30,000</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="summary-item">
                                                    <h6>Processing Fee (10%)</h6>
                                                    <div class="summary-value" id="processingFee">KSh 3,000</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="summary-item">
                                                    <h6>Amount Received</h6>
                                                    <div class="summary-value" id="amountReceived">KSh 27,000</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="summary-item">
                                                    <h6>Total Repayment</h6>
                                                    <div class="summary-value" id="totalRepayment">KSh 30,000</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Eligibility Criteria</h2>
                        <p class="lead">To qualify for a Salary Advance, you must meet these simple requirements:</p>
                        
                        <div class="eligibility-list">
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-user-check" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Active Membership</h4>
                                    <p>Be an active member of Daystar Co-op with at least 1 month of membership.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Stable Employment</h4>
                                    <p>Have stable employment with regular monthly salary payments.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Minimum Salary</h4>
                                    <p>Earn a minimum monthly salary of KSh 20,000.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>No Outstanding Advance</h4>
                                    <p>Must not have any outstanding salary advance at the time of application.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-percentage" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Advance Limit</h4>
                                    <p>Maximum advance is 50% of your monthly salary or KSh 100,000, whichever is lower.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="advance-info fade-in">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0">Important Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <h5><i class="fas fa-clock text-info me-2"></i>Processing Time</h5>
                                    <p>Applications submitted before 2:00 PM are processed the same day. Applications after 2:00 PM are processed the next working day.</p>
                                </div>
                                
                                <div class="info-item">
                                    <h5><i class="fas fa-calendar text-info me-2"></i>Repayment</h5>
                                    <p>Automatic deduction from your next salary payment. If salary is delayed, repayment is due within 45 days of advance.</p>
                                </div>
                                
                                <div class="info-item">
                                    <h5><i class="fas fa-redo text-info me-2"></i>Frequency</h5>
                                    <p>You can apply for a new salary advance once the previous one is fully repaid. Maximum of 6 advances per year.</p>
                                </div>
                                
                                <div class="info-item">
                                    <h5><i class="fas fa-exclamation-triangle text-warning me-2"></i>Late Payment</h5>
                                    <p>Late payment attracts a penalty of 2% per month on the outstanding amount.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Process Section -->
    <section id="apply" class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Quick Application Process</h2>
                <p class="section-subtitle">Get your salary advance in just a few steps</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Apply Online</h3>
                            <p class="step-description">Fill out the simple online application form with your details.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Upload Documents</h3>
                            <p class="step-description">Upload your recent pay slip and ID copy.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Instant Approval</h3>
                            <p class="step-description">Receive approval notification within minutes.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Get Funds</h3>
                            <p class="step-description">Funds are disbursed to your account immediately after approval.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="required-documents fade-in">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h4 class="mb-0">Required Documents</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i> Recent pay slip (current month)</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Copy of national ID or passport</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Completed application form</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Employment confirmation letter (if first-time applicant)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0">Contact Information</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Salary Advance Hotline:</strong></p>
                                <p class="h5 text-info"><i class="fas fa-phone me-2"></i> +254 700 123 456</p>
                                <p><strong>Email:</strong> advances@daystarco-op.com</p>
                                <p><strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-info btn-lg">Apply for Salary Advance</a>
                <a href="tel:+254700123456" class="btn btn-outline-info btn-lg ms-2">Call Now</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about Salary Advance</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion fade-in" id="salaryAdvanceFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How quickly can I get my salary advance?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#salaryAdvanceFAQ">
                                <div class="accordion-body">
                                    <p>Applications submitted before 2:00 PM are typically processed and disbursed the same day. Applications submitted after 2:00 PM are processed the next working day. Once approved, funds are transferred to your account immediately.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What is the maximum amount I can advance?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#salaryAdvanceFAQ">
                                <div class="accordion-body">
                                    <p>You can advance up to 50% of your monthly salary or KSh 100,000, whichever is lower. For example, if your monthly salary is KSh 60,000, you can advance up to KSh 30,000. If your salary is KSh 250,000, you can still only advance up to KSh 100,000.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How often can I apply for a salary advance?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#salaryAdvanceFAQ">
                                <div class="accordion-body">
                                    <p>You can apply for a new salary advance once your previous advance is fully repaid. However, there's a maximum limit of 6 salary advances per calendar year to encourage responsible borrowing.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    What happens if my salary is delayed?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#salaryAdvanceFAQ">
                                <div class="accordion-body">
                                    <p>If your salary is delayed, you have up to 45 days from the advance date to repay. After 45 days, a late payment penalty of 2% per month applies to the outstanding amount. Please contact us immediately if you anticipate any delays.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Can I repay my advance early?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#salaryAdvanceFAQ">
                                <div class="accordion-body">
                                    <p>Yes, you can repay your salary advance early without any additional charges. The processing fee remains the same regardless of when you repay. Early repayment allows you to apply for another advance sooner if needed.</p>
                                </div>
                            </div>
                        </div>
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
                <p class="section-subtitle">What our members say about our Salary Advance</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Salary Advance specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('salary-advance'),
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
                                    <p>"The salary advance service from Daystar SACCO has been a lifesaver during tight months. Quick processing and fair terms make it the perfect short-term solution."</p>
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
    </section>

    <!-- CTA Section -->
    <section class="cta-section bg-info">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title text-white">Need Money Before Payday?</h2>
                        <p class="cta-subtitle text-white">Get instant access to your salary with our quick and convenient salary advance.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-light btn-lg">Apply Now</a>
                        <a href="tel:+254700123456" class="btn btn-outline-light btn-lg ms-2">Call Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Calculator Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Advance Calculator
    const advanceForm = document.getElementById('advanceCalculatorForm');
    const monthlySalary = document.getElementById('monthlySalary');
    const advanceAmount = document.getElementById('advanceAmount');
    const calculatorResults = document.getElementById('calculatorResults');
    
    // Result elements
    const advanceAmountResult = document.getElementById('advanceAmountResult');
    const processingFee = document.getElementById('processingFee');
    const amountReceived = document.getElementById('amountReceived');
    const totalRepayment = document.getElementById('totalRepayment');
    
    // Update advance amount limit based on salary
    if (monthlySalary) {
        monthlySalary.addEventListener('input', function() {
            const salary = parseFloat(this.value) || 0;
            const maxAdvance = Math.min(salary * 0.5, 100000);
            
            if (advanceAmount) {
                advanceAmount.max = maxAdvance;
                if (parseFloat(advanceAmount.value) > maxAdvance) {
                    advanceAmount.value = maxAdvance;
                }
            }
        });
    }
    
    // Calculate advance on form submit
    if (advanceForm) {
        advanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAdvance();
        });
    }
    
    // Calculate advance function
    function calculateAdvance() {
        if (!monthlySalary || !advanceAmount || !calculatorResults) return;
        
        const salary = parseFloat(monthlySalary.value) || 0;
        const advance = parseFloat(advanceAmount.value) || 0;
        const maxAdvance = Math.min(salary * 0.5, 100000);
        
        // Validate advance amount
        if (advance > maxAdvance) {
            alert(`Maximum advance amount is KSh ${formatNumber(maxAdvance.toFixed(0))} (50% of your salary or KSh 100,000, whichever is lower)`);
            return;
        }
        
        if (advance < 5000) {
            alert('Minimum advance amount is KSh 5,000');
            return;
        }
        
        // Calculate fees and amounts
        const fee = advance * 0.10; // 10% processing fee
        const received = advance - fee;
        const repayment = advance;
        
        // Update results
        if (advanceAmountResult) advanceAmountResult.textContent = 'KSh ' + formatNumber(advance.toFixed(0));
        if (processingFee) processingFee.textContent = 'KSh ' + formatNumber(fee.toFixed(0));
        if (amountReceived) amountReceived.textContent = 'KSh ' + formatNumber(received.toFixed(0));
        if (totalRepayment) totalRepayment.textContent = 'KSh ' + formatNumber(repayment.toFixed(0));
        
        // Show results
        calculatorResults.style.display = 'block';
    }
    
    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Initial calculation
    calculateAdvance();
});
</script>

<?php
get_footer();