<?php
/**
 * The template for displaying the Special Loans page for Daystar Multi-Purpose Co-op Society Ltd.
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
                    <h1 class="page-title">Special Loans</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Special Loans</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/special-loan-icon.svg" alt="" aria-hidden="true">
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
                        <span class="daystar-badge badge-warning">Maximum KSh 200,000</span>
                        <h2 class="section-title text-start">Special Loans</h2>
                        <p class="lead">Character-based loans without payslip consideration for trusted members.</p>
                        <p>Our Special Loan product is designed for trusted members with good credit history who need quick financing without the requirement of payslip verification. These loans are based on character and trust, requiring post-dated cheques as security.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-warning me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-warning">Calculate Repayments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/special-loan-hero.jpg" alt="Special Loan" class="img-fluid rounded-lg shadow">
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
                <p class="section-subtitle">Why choose our Special Loan</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-cogs" aria-hidden="true"></i>
                        </div>
                        <h3>Customizable Terms</h3>
                        <p>Flexible loan terms and conditions tailored to your specific needs and circumstances.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Competitive Interest Rate</h3>
                        <p>5% per month on reducing balance, competitive rates for character-based financing.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Short Repayment Period</h3>
                        <p>Quick repayment over 4-6 months based on loan amount, ensuring manageable monthly payments.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Reasonable Loan Limit</h3>
                        <p>Borrow between KSh 10,000 to KSh 200,000 based on your character and credit history.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-handshake" aria-hidden="true"></i>
                        </div>
                        <h3>No Payslip Required</h3>
                        <p>Character-based lending that doesn't require payslip verification for trusted members.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h3>Post-dated Cheque Security</h3>
                        <p>Secured by post-dated cheques, providing security while maintaining trust-based lending.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Loan Types Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Types of Special Loans</h2>
                <p class="section-subtitle">Various special financing options available</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-store" aria-hidden="true"></i>
                        </div>
                        <h3>Business Opportunity Loans</h3>
                        <p>Financing for unique business opportunities, partnerships, or time-sensitive investments that require immediate capital.</p>
                        <ul class="loan-type-features">
                            <li>Quick approval for time-sensitive opportunities</li>
                            <li>Flexible repayment based on business cash flow</li>
                            <li>Up to KSh 1,000,000 for substantial investments</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Professional Development Loans</h3>
                        <p>Support for advanced education, professional certifications, or specialized training programs.</p>
                        <ul class="loan-type-features">
                            <li>Funding for advanced degrees and certifications</li>
                            <li>Deferred payment options during study period</li>
                            <li>Investment in your professional future</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </div>
                        <h3>Property Investment Loans</h3>
                        <p>Financing for real estate investments, land purchases, or property development projects.</p>
                        <ul class="loan-type-features">
                            <li>Support for property investment opportunities</li>
                            <li>Flexible terms based on property value</li>
                            <li>Competitive rates for real estate ventures</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                        </div>
                        <h3>Life Event Loans</h3>
                        <p>Financing for significant life events such as weddings, family celebrations, or major life transitions.</p>
                        <ul class="loan-type-features">
                            <li>Support for important life milestones</li>
                            <li>Reasonable rates for personal celebrations</li>
                            <li>Flexible repayment to suit your budget</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-tools" aria-hidden="true"></i>
                        </div>
                        <h3>Equipment & Technology Loans</h3>
                        <p>Financing for specialized equipment, technology, or tools needed for professional or business purposes.</p>
                        <ul class="loan-type-features">
                            <li>Support for professional equipment purchases</li>
                            <li>Technology upgrade financing</li>
                            <li>Terms aligned with equipment lifespan</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="special-loan-type fade-in">
                        <div class="loan-type-icon">
                            <i class="fas fa-globe" aria-hidden="true"></i>
                        </div>
                        <h3>Travel & Experience Loans</h3>
                        <p>Financing for educational travel, professional conferences, or once-in-a-lifetime experiences.</p>
                        <ul class="loan-type-features">
                            <li>Support for educational and professional travel</li>
                            <li>Reasonable terms for experience investments</li>
                            <li>Quick approval for time-sensitive opportunities</li>
                        </ul>
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
                        <p class="lead">To qualify for a Special Loan, you must meet the following requirements:</p>
                        
                        <div class="eligibility-list">
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-user-check" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Membership Duration</h4>
                                    <p>Be a member of Daystar Co-op for at least 12 months with consistent contributions.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-coins" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Good Credit History</h4>
                                    <p>Demonstrate excellent credit history with no defaults or late payments.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Share Capital</h4>
                                    <p>Own a minimum of KSh 10,000 as share capital (500 shares worth KSh 200 each).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-file-contract" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Post-dated Cheques</h4>
                                    <p>Provide post-dated cheques as security for the loan repayment.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>No Payslip Required</h4>
                                    <p>Character-based lending without the need for payslip verification.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="application-process fade-in">
                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h3 class="mb-0">Special Loan Application Process</h3>
                            </div>
                            <div class="card-body">
                                <div class="process-step">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h5>Initial Consultation</h5>
                                        <p>Schedule a meeting with our loan officer to discuss your special financing needs.</p>
                                    </div>
                                </div>
                                
                                <div class="process-step">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h5>Proposal Preparation</h5>
                                        <p>Prepare a detailed proposal outlining your loan purpose, amount needed, and repayment plan.</p>
                                    </div>
                                </div>
                                
                                <div class="process-step">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h5>Committee Review</h5>
                                        <p>Your application will be reviewed by our special loans committee for approval.</p>
                                    </div>
                                </div>
                                
                                <div class="process-step">
                                    <div class="step-number">4</div>
                                    <div class="step-content">
                                        <h5>Customized Terms</h5>
                                        <p>If approved, we'll work with you to finalize customized loan terms and conditions.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Calculator Section -->
    <section id="calculator" class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Special Loan Calculator</h2>
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
                                        <input type="number" class="form-control" id="loanAmount" min="10000" max="200000" value="100000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="10000" max="200000" step="5000" value="100000">
                                        <div class="range-labels">
                                            <span>KSh 10,000</span>
                                            <span>KSh 200,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="4" max="6" value="4" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="4" max="6" step="1" value="4">
                                        <div class="range-labels">
                                            <span>4 months</span>
                                            <span>6 months</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning w-100">Calculate</button>
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
                                            <div class="summary-value" id="monthlyPayment">KSh 30,000.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Interest</h4>
                                            <div class="summary-value" id="totalInterest">KSh 20,000.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Payment</h4>
                                            <div class="summary-value" id="totalPayment">KSh 120,000.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Interest Rate</h4>
                                            <div class="summary-value">5% p.m.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chart-container mt-4">
                                <canvas id="loanChart"></canvas>
                            </div>
                            
                            <div class="results-actions mt-4">
                                <button class="btn btn-outline-warning me-2" id="viewAmortizationBtn">
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

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our Special Loans</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Special Loans specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('special-loans'),
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
                                    <p>"The special loan product offered exactly what I needed with customized terms. Daystar SACCO truly understands individual member needs and provides personalized solutions."</p>
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
    <section class="cta-section bg-warning">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title text-dark">Have a Special Financing Need?</h2>
                        <p class="cta-subtitle text-dark">Let's discuss how we can create a customized loan solution for you.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-dark btn-lg">Apply Now</a>
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-dark btn-lg ms-2">Schedule Consultation</a>
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
        const monthlyRate = 0.05; // 5% per month for special loans
        const months = parseInt(loanTerm.value);
        
        // Calculate for Special Loans - 5% per month on reducing balance
        let balance = principal;
        let totalInterest = 0;
        
        for (let i = 1; i <= months; i++) {
            const interestPayment = balance * monthlyRate;
            const principalPayment = principal / months;
            balance -= principalPayment;
            totalInterest += interestPayment;
        }
        
        const monthlyPayment = (principal / months) + (totalInterest / months);
        const totalPayment = principal + totalInterest;
        
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
                    backgroundColor: ['#ffc107', '#f7b731'],
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