<?php
/**
 * The template for displaying the Super Saver Loans page for Daystar Multi-Purpose Co-op Society Ltd.
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
                    <h1 class="page-title">Super Saver Loans</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Super Saver Loans</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/super-saver-icon.svg" alt="" aria-hidden="true">
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
                        <span class="daystar-badge badge-success">Maximum KSh 800,000</span>
                        <h2 class="section-title text-start">Super Saver Loans</h2>
                        <p class="lead">Exclusive loan product for our most dedicated savers with exceptional benefits.</p>
                        <p>The Super Saver Loan is our premium loan product designed specifically for members who have demonstrated exceptional commitment to saving. This loan offers the most competitive rates and favorable terms as a reward for your dedication to building your financial future through consistent savings.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-success me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-success">Calculate Repayments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/super-saver-hero.jpg" alt="Super Saver Loan" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Features Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Exclusive Features & Benefits</h2>
                <p class="section-subtitle">Premium benefits for our super savers</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Lowest Interest Rate</h3>
                        <p>Enjoy our most competitive rate at 8% per annum on reducing balance - our best rate for super savers.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Extended Repayment Period</h3>
                        <p>Repay your loan over a period of up to 60 months with flexible monthly installments.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>High Loan Limit</h3>
                        <p>Access up to KSh 800,000 based on your savings history and repayment capacity.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h3>Priority Processing</h3>
                        <p>Fast-track approval process for qualified super savers with priority consideration.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Savings-Based Security</h3>
                        <p>Your substantial savings serve as primary security, reducing guarantor requirements.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-gift" aria-hidden="true"></i>
                        </div>
                        <h3>Exclusive Benefits</h3>
                        <p>Additional perks including reduced fees and exclusive member events for super savers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Super Saver Qualification Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Super Saver Qualification</h2>
                        <p class="lead">To qualify as a Super Saver and access this exclusive loan, you must meet these criteria:</p>
                        
                        <div class="eligibility-list">
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-calendar-check" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Membership Duration</h4>
                                    <p>Be a member of Daystar Co-op for at least 24 months with consistent contributions.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Minimum Savings</h4>
                                    <p>Have accumulated at least KSh 100,000 in total savings (shares + deposits).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-chart-line" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Consistent Saving Pattern</h4>
                                    <p>Demonstrate consistent monthly savings of at least KSh 5,000 for the past 12 months.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-medal" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Excellent Credit History</h4>
                                    <p>Have an excellent loan repayment history with no defaults or late payments.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Strong Repayment Capacity</h4>
                                    <p>Demonstrate strong and stable income to support loan repayments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="super-saver-benefits fade-in">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h3 class="mb-0">Super Saver Status Benefits</h3>
                            </div>
                            <div class="card-body">
                                <p>As a Super Saver member, you enjoy:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Lowest interest rates on all loan products</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Priority loan processing and approval</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Reduced or waived loan processing fees</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Higher loan limits based on savings</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Exclusive financial planning consultations</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Invitations to special member events</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Enhanced dividend rates on savings</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Dedicated customer service support</li>
                                </ul>
                                
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-trophy me-2"></i>
                                    <strong>Elite Status:</strong> Super Savers represent our most valued members who have shown exceptional commitment to financial growth.
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
                <h2 class="section-title">Super Saver Loan Calculator</h2>
                <p class="section-subtitle">Calculate your payments with our lowest interest rate</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="calculator-card fade-in">
                        <div class="calculator-header">
                            <h3>Calculate Your Loan</h3>
                            <p>See how our lowest rates benefit your repayment schedule</p>
                        </div>
                        
                        <div class="calculator-body">
                            <form id="loanCalculatorForm">
                                <div class="form-group mb-4">
                                    <label for="loanAmount" class="form-label">Loan Amount (KSh)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control" id="loanAmount" min="50000" max="800000" value="400000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="50000" max="800000" step="10000" value="400000">
                                        <div class="range-labels">
                                            <span>KSh 50,000</span>
                                            <span>KSh 800,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="6" max="60" value="36" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="6" max="60" step="1" value="36">
                                        <div class="range-labels">
                                            <span>6 months</span>
                                            <span>60 months</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success w-100">Calculate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="results-card fade-in">
                        <div class="results-header">
                            <h3>Loan Summary</h3>
                            <p>Your estimated loan repayment details at 8% p.a.</p>
                        </div>
                        
                        <div class="results-body">
                            <div class="results-summary">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Monthly Payment</h4>
                                            <div class="summary-value" id="monthlyPayment">KSh 12,133.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Interest</h4>
                                            <div class="summary-value" id="totalInterest">KSh 36,788.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Payment</h4>
                                            <div class="summary-value" id="totalPayment">KSh 436,788.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Interest Rate</h4>
                                            <div class="summary-value text-success">8% p.a.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="savings-comparison mt-4">
                                <div class="alert alert-success">
                                    <h5><i class="fas fa-calculator me-2"></i>Super Saver Advantage</h5>
                                    <p class="mb-1">Compared to our standard 12% rate:</p>
                                    <p class="mb-0"><strong>You save KSh 15,000+ in interest!</strong></p>
                                </div>
                            </div>
                            
                            <div class="chart-container mt-4">
                                <canvas id="loanChart"></canvas>
                            </div>
                            
                            <div class="results-actions mt-4">
                                <button class="btn btn-outline-success me-2" id="viewAmortizationBtn">
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
                <h2 class="section-title">Super Saver Application Process</h2>
                <p class="section-subtitle">Streamlined process for our valued super savers</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Verify Status</h3>
                            <p class="step-description">Confirm your Super Saver status and qualification criteria.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Submit Application</h3>
                            <p class="step-description">Complete the streamlined Super Saver loan application form.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Priority Review</h3>
                            <p class="step-description">Benefit from fast-track processing and priority consideration.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Quick Approval</h3>
                            <p class="step-description">Receive approval and disbursement within 3-5 working days.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="super-saver-check fade-in">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Check Your Super Saver Status</h4>
                    </div>
                    <div class="card-body">
                        <p>Not sure if you qualify as a Super Saver? Contact our member services team to verify your status and learn how to qualify.</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p><strong>Member Services:</strong></p>
                                <p><i class="fas fa-phone text-success me-2"></i> +254 700 123 456</p>
                                <p><i class="fas fa-envelope text-success me-2"></i> members@daystarco-op.com</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p><strong>Office Hours:</strong></p>
                                <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                                <p>Saturday: 9:00 AM - 1:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-success btn-lg">Apply for Super Saver Loan</a>
                <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-success btn-lg ms-2">Check Status</a>
            </div>
        </div>
    </section>

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our Super Saver Loans</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Super Saver Loans specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('super-saver-loans'),
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
                                    <p>"As a long-term member, the super saver loan rewards my loyalty with excellent rates and terms. It's great to see my consistent saving efforts being recognized and rewarded."</p>
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
    <section class="cta-section bg-success">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title text-white">Ready to Enjoy Super Saver Benefits?</h2>
                        <p class="cta-subtitle text-white">Access our lowest rates and exclusive benefits as a valued super saver.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-light btn-lg">Apply Now</a>
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-light btn-lg ms-2">Learn More</a>
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
        const annualRate = 0.08; // 8% per annum for super saver loans
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
                    backgroundColor: ['#28a745', '#f7b731'],
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