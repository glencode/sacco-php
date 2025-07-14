<?php
/**
 * The template for displaying the School Fees Loans page for Daystar Multi-Purpose Co-op Society Ltd.
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
                    <h1 class="page-title">School Fees Loans</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">School Fees Loans</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/school-fees-icon.svg" alt="" aria-hidden="true">
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
                        <span class="daystar-badge badge-primary">Maximum KSh 500,000</span>
                        <h2 class="section-title text-start">School Fees Loans</h2>
                        <p class="lead">Ensure your children's education is never interrupted with our affordable school fees financing.</p>
                        <p>Our School Fees Loan is specifically designed to help you pay for your children's education expenses. Whether it's primary, secondary, or tertiary education, we provide quick access to funds with competitive rates and flexible repayment terms that align with your financial capacity.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-primary me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-primary">Calculate Repayments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/school-fees-hero.jpg" alt="School Fees Loan" class="img-fluid rounded-lg shadow">
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
                <p class="section-subtitle">Why choose our School Fees Loan</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Competitive Interest Rate</h3>
                        <p>10% per annum on reducing balance, making education financing affordable for all families.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Flexible Repayment Period</h3>
                        <p>Repay your loan over a period of up to 24 months, giving you time to manage other expenses.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Adequate Loan Limit</h3>
                        <p>Borrow up to KSh 500,000 to cover school fees for multiple children or higher education costs.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>
                        <h3>Quick Processing</h3>
                        <p>Fast approval process to ensure school fees are paid on time without delays.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Minimal Security Requirements</h3>
                        <p>Secure your loan with your shares and guarantors for easier access to education funding.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Education-Focused</h3>
                        <p>Specifically designed for education expenses, supporting your family's academic goals.</p>
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
                        <p class="lead">To qualify for a School Fees Loan, you must meet the following requirements:</p>
                        
                        <div class="eligibility-list">
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-user-check" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Membership Duration</h4>
                                    <p>Be a member of Daystar Co-op for at least 3 months with consistent contributions.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-coins" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Minimum Contribution</h4>
                                    <p>Have contributed not less than KSh 6,000 (KSh 2,000 × 3 months).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Share Capital</h4>
                                    <p>Own a minimum of KSh 3,000 as share capital (150 shares worth KSh 200 each).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>School Fee Invoice</h4>
                                    <p>Provide a valid school fee invoice or admission letter as proof of education expense.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Repayment Capacity</h4>
                                    <p>Your pay slip must demonstrate the ability to support loan repayments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="loan-eligibility-checker fade-in">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0">Quick Eligibility Check</h3>
                            </div>
                            <div class="card-body">
                                <p>Check if you're eligible for a School Fees Loan:</p>
                                <form id="eligibilityCheckerForm">
                                    <div class="mb-3">
                                        <label class="form-label">Have you been a member for at least 3 months?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="membershipDuration" id="membershipYes" value="yes">
                                            <label class="form-check-label" for="membershipYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="membershipDuration" id="membershipNo" value="no">
                                            <label class="form-check-label" for="membershipNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Have you contributed at least KSh 6,000 in total?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contribution" id="contributionYes" value="yes">
                                            <label class="form-check-label" for="contributionYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contribution" id="contributionNo" value="no">
                                            <label class="form-check-label" for="contributionNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Do you have at least KSh 3,000 in share capital?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shareCapital" id="shareCapitalYes" value="yes">
                                            <label class="form-check-label" for="shareCapitalYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shareCapital" id="shareCapitalNo" value="no">
                                            <label class="form-check-label" for="shareCapitalNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">Check Eligibility</button>
                                </form>
                                
                                <div id="eligibilityResult" class="mt-3" style="display: none;"></div>
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
                <h2 class="section-title">School Fees Loan Calculator</h2>
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
                                        <input type="number" class="form-control" id="loanAmount" min="5000" max="500000" value="100000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="5000" max="500000" step="5000" value="100000">
                                        <div class="range-labels">
                                            <span>KSh 5,000</span>
                                            <span>KSh 500,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="1" max="24" value="12" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="1" max="24" step="1" value="12">
                                        <div class="range-labels">
                                            <span>1 month</span>
                                            <span>24 months</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">Calculate</button>
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
                                            <div class="summary-value" id="totalInterest">KSh 5,504.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Payment</h4>
                                            <div class="summary-value" id="totalPayment">KSh 105,504.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Interest Rate</h4>
                                            <div class="summary-value">10% p.a.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chart-container mt-4">
                                <canvas id="loanChart"></canvas>
                            </div>
                            
                            <div class="results-actions mt-4">
                                <button class="btn btn-outline-primary me-2" id="viewAmortizationBtn">
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
                <h2 class="section-title">Application Process</h2>
                <p class="section-subtitle">Simple steps to get your school fees loan</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Check Eligibility</h3>
                            <p class="step-description">Ensure you meet all the eligibility criteria before applying.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Complete Application</h3>
                            <p class="step-description">Fill out the loan application form with all required details.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Submit Documents</h3>
                            <p class="step-description">Provide school fee invoice and other required documentation.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Quick Approval</h3>
                            <p class="step-description">Receive fast approval and loan disbursement for timely fee payment.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary btn-lg">Apply for School Fees Loan</a>
            </div>
        </div>
    </section>

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our School Fees Loans</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - School Fees Loans specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('school-fees-loans'),
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
                                    <p>"Thanks to Daystar SACCO's school fees loan, I was able to pay my children's fees on time. The competitive rates and flexible terms made education financing stress-free."</p>
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
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Don't Let School Fees Stop Your Child's Education</h2>
                        <p class="cta-subtitle">Apply for a school fees loan today and secure your child's academic future.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-gradient btn-lg">Apply Now</a>
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
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
    // Eligibility Checker
    const eligibilityCheckerForm = document.getElementById('eligibilityCheckerForm');
    const eligibilityResult = document.getElementById('eligibilityResult');
    
    if (eligibilityCheckerForm) {
        eligibilityCheckerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const membershipDuration = document.querySelector('input[name="membershipDuration"]:checked')?.value;
            const contribution = document.querySelector('input[name="contribution"]:checked')?.value;
            const shareCapital = document.querySelector('input[name="shareCapital"]:checked')?.value;
            
            if (!membershipDuration || !contribution || !shareCapital) {
                eligibilityResult.innerHTML = '<div class="alert alert-warning">Please answer all questions to check your eligibility.</div>';
                eligibilityResult.style.display = 'block';
                return;
            }
            
            if (membershipDuration === 'yes' && contribution === 'yes' && shareCapital === 'yes') {
                eligibilityResult.innerHTML = '<div class="alert alert-success"><strong>Great!</strong> You appear to be eligible for a School Fees Loan. Please proceed with your application.</div>';
            } else {
                let reasons = [];
                if (membershipDuration === 'no') reasons.push('You must be a member for at least 3 months');
                if (contribution === 'no') reasons.push('You must have contributed at least KSh 6,000');
                if (shareCapital === 'no') reasons.push('You must have at least KSh 3,000 in share capital');
                
                let reasonsHtml = reasons.map(reason => `<li>${reason}</li>`).join('');
                eligibilityResult.innerHTML = `<div class="alert alert-danger"><strong>You may not be eligible at this time.</strong> Reasons:<ul>${reasonsHtml}</ul>Please contact our office for more information.</div>`;
            }
            
            eligibilityResult.style.display = 'block';
        });
    }
    
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
        const annualRate = 0.10; // 10% per annum for school fees loans
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
                    backgroundColor: ['#00447c', '#f7b731'],
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