<?php
/**
 * The template for displaying the Emergency Loans page for Daystar Multi-Purpose Co-op Society Ltd.
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
                    <h1 class="page-title">Emergency Loans</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Emergency Loans</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/emergency-loan-icon.svg" alt="" aria-hidden="true">
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
                        <span class="daystar-badge badge-danger">Maximum KSh 200,000</span>
                        <h2 class="section-title text-start">Emergency Loans</h2>
                        <p class="lead">Quick access to emergency funds when you need them most, with minimal documentation.</p>
                        <p>Life is unpredictable, and emergencies can happen when you least expect them. Our Emergency Loan is designed to provide you with quick access to funds during urgent situations such as medical emergencies, urgent repairs, or other unforeseen circumstances that require immediate financial attention.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-danger me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-danger">Calculate Repayments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/emergency-loan-hero.jpg" alt="Emergency Loan" class="img-fluid rounded-lg shadow">
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
                <p class="section-subtitle">Why choose our Emergency Loan</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-bolt" aria-hidden="true"></i>
                        </div>
                        <h3>Same-Day Processing</h3>
                        <p>Get your emergency loan approved and disbursed within 24 hours for urgent situations.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Competitive Interest Rate</h3>
                        <p>15% per annum on reducing balance, reasonable rates for emergency financing.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Flexible Repayment</h3>
                        <p>Repay your loan over a period of up to 12 months with manageable monthly installments.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Minimal Documentation</h3>
                        <p>Streamlined application process with minimal paperwork for faster approval.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Share-Based Security</h3>
                        <p>Secure your loan primarily with your shares for quick processing.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-heart" aria-hidden="true"></i>
                        </div>
                        <h3>Emergency Support</h3>
                        <p>Specifically designed to help members during their most challenging times.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Eligibility Criteria</h2>
                        <p class="lead">To qualify for an Emergency Loan, you must meet the following requirements:</p>
                        
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
                                    <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Minimum Share Capital</h4>
                                    <p>Own a minimum of KSh 2,000 as share capital (100 shares worth KSh 200 each).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Genuine Emergency</h4>
                                    <p>Demonstrate a genuine emergency situation requiring immediate financial assistance.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Repayment Capacity</h4>
                                    <p>Show ability to repay the loan through salary or other verifiable income.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Good Standing</h4>
                                    <p>Be in good standing with no defaulted loans or disciplinary issues.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="emergency-info fade-in">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h3 class="mb-0">Emergency Situations Covered</h3>
                            </div>
                            <div class="card-body">
                                <p>Our Emergency Loans are designed to help with:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-heartbeat text-danger me-2"></i> Medical emergencies and hospital bills</li>
                                    <li><i class="fas fa-home text-danger me-2"></i> Urgent home repairs (roof, plumbing, electrical)</li>
                                    <li><i class="fas fa-car text-danger me-2"></i> Vehicle breakdown and urgent repairs</li>
                                    <li><i class="fas fa-graduation-cap text-danger me-2"></i> Urgent school fee payments</li>
                                    <li><i class="fas fa-tools text-danger me-2"></i> Essential appliance replacement</li>
                                    <li><i class="fas fa-umbrella text-danger me-2"></i> Natural disaster recovery</li>
                                    <li><i class="fas fa-plane text-danger me-2"></i> Emergency travel expenses</li>
                                    <li><i class="fas fa-exclamation-circle text-danger me-2"></i> Other unforeseen urgent expenses</li>
                                </ul>
                                
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> You may be required to provide documentation supporting your emergency situation.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Calculator Section -->
    <section id="calculator" class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Emergency Loan Calculator</h2>
                <p class="section-subtitle">Estimate your monthly payments and total interest</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="calculator-card fade-in">
                        <div class="calculator-header">
                            <h3>Calculate Your Loan</h3>
                            <p>Adjust the values to see how different loan amounts and terms affect your repayments</p>
                        </div>
                        
                        <div class="calculator-body">
                            <form id="loanCalculatorForm">
                                <div class="form-group mb-4">
                                    <label for="loanAmount" class="form-label">Loan Amount (KSh)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control" id="loanAmount" min="5000" max="200000" value="50000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="5000" max="200000" step="5000" value="50000">
                                        <div class="range-labels">
                                            <span>KSh 5,000</span>
                                            <span>KSh 200,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="1" max="12" value="6" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="1" max="12" step="1" value="6">
                                        <div class="range-labels">
                                            <span>1 month</span>
                                            <span>12 months</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger w-100">Calculate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="results-card fade-in">
                        <div class="results-header">
                            <h3>Loan Summary</h3>
                            <p>Your estimated loan repayment details</p>
                        </div>
                        
                        <div class="results-body">
                            <div class="results-summary">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Monthly Payment</h4>
                                            <div class="summary-value" id="monthlyPayment">KSh 8,792.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Interest</h4>
                                            <div class="summary-value" id="totalInterest">KSh 2,752.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Payment</h4>
                                            <div class="summary-value" id="totalPayment">KSh 52,752.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Interest Rate</h4>
                                            <div class="summary-value">15% p.a.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chart-container mt-4">
                                <canvas id="loanChart"></canvas>
                            </div>
                            
                            <div class="results-actions mt-4">
                                <button class="btn btn-outline-danger me-2" id="viewAmortizationBtn">
                                    <i class="fas fa-table me-2" aria-hidden="true"></i> View Schedule
                                </button>
                                <button class="btn btn-outline-secondary" id="printResultsBtn">
                                    <i class="fas fa-print me-2" aria-hidden="true"></i> Print Results
                                </button>
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
                <h2 class="section-title">Emergency Application Process</h2>
                <p class="section-subtitle">Fast-track process for urgent situations</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Contact Us</h3>
                            <p class="step-description">Call our emergency line or visit our office immediately.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Explain Emergency</h3>
                            <p class="step-description">Provide details about your emergency situation and required amount.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Quick Documentation</h3>
                            <p class="step-description">Provide minimal required documents and emergency proof.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Same-Day Approval</h3>
                            <p class="step-description">Receive approval and disbursement within 24 hours.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="emergency-contact fade-in">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h4 class="mb-0">Emergency Contact</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Emergency Loan Hotline:</strong></p>
                                <p class="h5 text-danger"><i class="fas fa-phone me-2"></i> +254 700 123 456</p>
                                <p><strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM</p>
                                <p><strong>Emergency Hours:</strong> Available 24/7 for genuine emergencies</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Required Documents</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i> National ID copy</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Recent pay slip</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Emergency proof (medical bill, quotation, etc.)</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Completed application form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-danger btn-lg">Apply for Emergency Loan</a>
                <a href="tel:+254700123456" class="btn btn-outline-danger btn-lg ms-2">Call Emergency Line</a>
            </div>
        </div>
    </section>

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our Emergency Loans</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Emergency Loans specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('emergency-loans'),
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
                                    <p>"When my child was hospitalized unexpectedly, Daystar SACCO's Emergency Loan saved the day. I got the funds within hours and could focus on what mattered most - my family."</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <div class="testimonial-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5>Mary Njeri</h5>
                                        <p class="position">Administrative Assistant</p>
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
    <section class="cta-section bg-danger">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title text-white">Facing an Emergency? We're Here to Help</h2>
                        <p class="cta-subtitle text-white">Get the financial support you need during challenging times.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-light btn-lg">Apply Now</a>
                        <a href="tel:+254700123456" class="btn btn-outline-light btn-lg ms-2">Emergency Call</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Loan Calculator Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loan Calculator
    const loanForm = document.getElementById('loanCalculatorForm');
    const loanAmount = document.getElementById('loanAmount');
    const loanAmountSlider = document.getElementById('loanAmountSlider');
    const loanTerm = document.getElementById('loanTerm');
    const loanTermSlider = document.getElementById('loanTermSlider');
    
    // Get result elements
    const monthlyPaymentEl = document.getElementById('monthlyPayment');
    const totalInterestEl = document.getElementById('totalInterest');
    const totalPaymentEl = document.getElementById('totalPayment');
    
    // Chart variables
    let loanChart;
    
    // Sync input fields with sliders
    if (loanAmount && loanAmountSlider) {
        loanAmount.addEventListener('input', function() {
            loanAmountSlider.value = this.value;
            calculateLoan();
        });
        
        loanAmountSlider.addEventListener('input', function() {
            loanAmount.value = this.value;
            calculateLoan();
        });
    }
    
    if (loanTerm && loanTermSlider) {
        loanTerm.addEventListener('input', function() {
            loanTermSlider.value = this.value;
            calculateLoan();
        });
        
        loanTermSlider.addEventListener('input', function() {
            loanTerm.value = this.value;
            calculateLoan();
        });
    }
    
    // Calculate loan on form submit
    if (loanForm) {
        loanForm.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateLoan();
        });
    }
    
    // Calculate loan function
    function calculateLoan() {
        if (!loanAmount || !loanTerm || !monthlyPaymentEl || !totalInterestEl || !totalPaymentEl) return;
        
        // Get values from form
        const principal = parseFloat(loanAmount.value);
        const annualRate = 0.15; // 15% per annum for emergency loans
        const months = parseInt(loanTerm.value);
        
        // Calculate for reducing balance
        const monthlyRate = annualRate / 12;
        const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
        const totalPayment = monthlyPayment * months;
        const totalInterest = totalPayment - principal;
        
        // Update results
        monthlyPaymentEl.textContent = 'KSh ' + formatNumber(monthlyPayment.toFixed(2));
        totalInterestEl.textContent = 'KSh ' + formatNumber(totalInterest.toFixed(2));
        totalPaymentEl.textContent = 'KSh ' + formatNumber(totalPayment.toFixed(2));
        
        // Update chart
        updateChart(principal, totalInterest);
    }
    
    // Update chart
    function updateChart(principal, totalInterest) {
        const ctx = document.getElementById('loanChart');
        if (!ctx) return;
        
        // Destroy existing chart if it exists
        if (loanChart) {
            loanChart.destroy();
        }
        
        // Create new chart
        loanChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal', 'Interest'],
                datasets: [{
                    data: [principal, totalInterest],
                    backgroundColor: ['#dc3545', '#f7b731'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return label + ': KSh ' + formatNumber(value.toFixed(2));
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Initial calculation
    calculateLoan();
});
</script>

<?php
get_footer();