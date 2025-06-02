<?php
/**
 * The template for displaying the front page of Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content fade-in">
                        <h1>Empowering Your Financial Journey</h1>
                        <p>Daystar Multi-Purpose Co-op Society Ltd. offers tailored financial solutions to help you achieve your goals. Join our community of members building a brighter financial future together.</p>
                        <div class="hero-buttons">
                            <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-secondary btn-lg me-3">Become a Member</a>
                            <a href="<?php echo esc_url(home_url('products-services')); ?>" class="btn btn-outline-light btn-lg">Explore Our Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.png" alt="Daystar Co-op members" class="img-fluid rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Requirements Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Membership Requirements</h2>
                <p class="section-subtitle">Join our cooperative society and enjoy exclusive benefits</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>6 Months Membership</h3>
                        <p>To be eligible for loans, you must be a member for at least 6 months with consistent contributions.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Minimum Contribution</h3>
                        <p>Contribute consistently not less than KSh 12,000 (KSh 2,000 × 6 months) to qualify for loans.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                        </div>
                        <h3>Share Capital</h3>
                        <p>Own a minimum of KSh 5,000 as share capital (250 shares worth KSh 200 each).</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary">Learn How to Join</a>
            </div>
        </div>
    </section>

    <!-- Loan Products Section -->
    <section class="section">
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
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/special-loan.jpg" alt="Special Loan" class="img-fluid rounded-lg shadow">
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
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salary-advance.jpg" alt="Salary Advance" class="img-fluid rounded-lg shadow">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section bg-light">
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
    <section class="section">
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
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-preview.png" alt="Loan Calculator Preview" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about us</p>
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
                            <p>"The Development Loan from Daystar Co-op helped me build my dream home. The application process was straightforward, and the repayment terms were very manageable."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial1.jpg" alt="John Mwangi">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>John Mwangi</h5>
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
                            <p>"As a parent, the School Fees Loan has been a lifesaver. It's helped me provide quality education for my children without financial strain. I'm grateful for Daystar Co-op's support."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial2.jpg" alt="Mary Wambui">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Mary Wambui</h5>
                                <p>Member since 2016</p>
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
                            <p>"The Emergency Loan came through for me during a medical crisis. The quick processing and compassionate service made a difficult time much easier to handle."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial3.jpg" alt="David Ochieng">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>David Ochieng</h5>
                                <p>Member since 2019</p>
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
