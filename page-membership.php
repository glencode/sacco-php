<?php
/**
 * The template for displaying the Membership page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main membership-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Membership</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Membership</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/membership-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Overview Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Join Our Cooperative Community</h2>
                        <p class="lead">Become a member of Daystar Multi-Purpose Co-op Society Ltd. and enjoy exclusive financial benefits and services.</p>
                        <p>Membership in our cooperative society is open to all Daystar University staff, faculty, and associated individuals. When you join, you become a co-owner of the society, with voting rights and access to our full range of financial products and services.</p>
                        <p>Our cooperative model is built on the principles of mutual support, financial empowerment, and community development. Together, we create opportunities for growth and prosperity for all our members.</p>
                        <div class="mt-4">
                            <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary me-3">How to Join</a>
                            <a href="<?php echo esc_url(home_url('membership-benefits')); ?>" class="btn btn-outline-primary">Membership Benefits</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="membership-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/membership-hero.jpg" alt="Daystar Co-op Members" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Requirements Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Membership Requirements</h2>
                <p class="section-subtitle">What you need to become a member</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-user-plus" aria-hidden="true"></i>
                        </div>
                        <h3>Eligibility</h3>
                        <p>Membership is open to Daystar University staff, faculty, and associated individuals. You must be at least 18 years old and have a valid ID.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                        </div>
                        <h3>Share Capital</h3>
                        <p>Purchase a minimum of KSh 5,000 as share capital (250 shares worth KSh 200 each). Shares are only transferable if you cease to be a member.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Monthly Contributions</h3>
                        <p>Commit to a minimum monthly contribution of KSh 2,000. Consistent contributions are required for loan eligibility.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-signature" aria-hidden="true"></i>
                        </div>
                        <h3>Application Form</h3>
                        <p>Complete and submit the membership application form with all required documentation and signatures.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-id-card" aria-hidden="true"></i>
                        </div>
                        <h3>Documentation</h3>
                        <p>Provide copies of your national ID or passport, recent passport-sized photographs, and proof of employment or association.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>Registration Fee</h3>
                        <p>Pay a one-time non-refundable registration fee of KSh 1,000 to process your membership application.</p>
                    </div>
                </div>
            </div>
            
            <div class="daystar-notice notice-info mt-4 fade-in">
                <p><strong>Note:</strong> To be eligible for loans, you must be a member for at least 6 months with consistent contributions totaling not less than KSh 12,000 (KSh 2,000 × 6 months).</p>
            </div>
        </div>
    </section>

    <!-- Membership Benefits Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Membership Benefits</h2>
                <p class="section-subtitle">Why join Daystar Multi-Purpose Co-op Society</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Competitive Savings Returns</h3>
                                <p>Earn attractive returns on your savings and share capital through annual dividends and interest on deposits.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-percentage" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Affordable Loan Products</h3>
                                <p>Access a variety of loan products with competitive interest rates and flexible repayment terms tailored to your needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-vote-yea" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Democratic Participation</h3>
                                <p>Exercise your voting rights at Annual General Meetings and participate in the governance of the cooperative.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Financial Education</h3>
                                <p>Access financial literacy workshops, investment seminars, and personalized financial advice from our experts.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-shield-alt" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Financial Security</h3>
                                <p>Build a secure financial future through consistent savings and access to emergency funds when needed.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Community Support</h3>
                                <p>Be part of a supportive community that shares common financial goals and values mutual assistance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Journey Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Your Membership Journey</h2>
                <p class="section-subtitle">From application to full membership benefits</p>
            </div>
            
            <div class="membership-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Application</h3>
                            <p class="step-description">Complete and submit your membership application with all required documentation.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Approval</h3>
                            <p class="step-description">Your application is reviewed and approved by the management committee.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Initial Contributions</h3>
                            <p class="step-description">Make your initial share capital purchase and begin monthly contributions.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Full Membership</h3>
                            <p class="step-description">After 6 months of consistent contributions, gain access to all loan products and services.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary btn-lg">Start Your Application</a>
            </div>
        </div>
    </section>

    <!-- Membership FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about membership</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion fade-in" id="membershipFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Who is eligible to join Daystar Multi-Purpose Co-op Society?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#membershipFAQ">
                                <div class="accordion-body">
                                    <p>Membership is primarily open to Daystar University staff, faculty, and associated individuals. This includes:</p>
                                    <ul>
                                        <li>Current employees of Daystar University</li>
                                        <li>Faculty members (full-time and part-time)</li>
                                        <li>Administrative staff</li>
                                        <li>Support staff</li>
                                        <li>Retired Daystar University employees</li>
                                        <li>Other individuals with a direct association to Daystar University</li>
                                    </ul>
                                    <p>If you're unsure about your eligibility, please contact our office for clarification.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How long does it take to process a membership application?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#membershipFAQ">
                                <div class="accordion-body">
                                    <p>Membership applications are typically processed within 7-14 working days from the date of submission, provided all required documentation is complete and in order. Once your application is approved, you will receive a membership certificate and account details for making your initial contributions.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Can I withdraw my savings at any time?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#membershipFAQ">
                                <div class="accordion-body">
                                    <p>Your savings in the cooperative are divided into two categories:</p>
                                    <ol>
                                        <li><strong>Share Capital:</strong> This is your ownership stake in the cooperative and can only be withdrawn if you cease to be a member.</li>
                                        <li><strong>Deposits/Savings:</strong> Regular savings can be partially withdrawn, subject to maintaining the minimum required balance and following the withdrawal procedures. Withdrawal requests are processed within 14 days.</li>
                                    </ol>
                                    <p>Note that if you have an outstanding loan, your savings serve as collateral and may have withdrawal restrictions.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How are dividends calculated and distributed?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#membershipFAQ">
                                <div class="accordion-body">
                                    <p>Dividends are calculated based on your share capital holdings and are distributed annually after the Annual General Meeting (AGM). The dividend rate is determined by the cooperative's financial performance during the year and is approved by members at the AGM.</p>
                                    <p>Additionally, interest on deposits is calculated based on your average savings balance throughout the year. Both dividends and interest on deposits can be either withdrawn or added to your savings account, based on your preference.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    What happens to my membership if I leave Daystar University?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#membershipFAQ">
                                <div class="accordion-body">
                                    <p>If you leave Daystar University, you have the following options regarding your membership:</p>
                                    <ol>
                                        <li><strong>Continue Membership:</strong> You may continue your membership if you can maintain your monthly contributions and remain in good standing.</li>
                                        <li><strong>Transfer Membership:</strong> In some cases, you may transfer your shares to another eligible individual, subject to approval by the management committee.</li>
                                        <li><strong>Withdraw Membership:</strong> You can choose to withdraw from the cooperative, in which case your share capital and savings will be refunded after deducting any outstanding loans or obligations. The withdrawal process typically takes 60-90 days to complete.</li>
                                    </ol>
                                    <p>Each case is handled individually, so please contact our office for guidance specific to your situation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <p>Have more questions? <a href="<?php echo esc_url(home_url('contact-us')); ?>">Contact our membership team</a> for personalized assistance.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">Hear from our valued members</p>
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
                            <p>"Joining Daystar Co-op was one of the best financial decisions I've made. The consistent savings habit has helped me build a solid financial foundation, and the loans have enabled me to achieve goals I never thought possible."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial1.jpg" alt="Jane Muthoni">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Jane Muthoni</h5>
                                <p>Member since 2015</p>
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
                            <p>"The sense of community at Daystar Co-op is unmatched. Beyond the financial benefits, I've found a supportive network of like-minded individuals who share my values of financial responsibility and mutual support."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial2.jpg" alt="Robert Ochieng">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Robert Ochieng</h5>
                                <p>Member since 2017</p>
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
                            <p>"As a faculty member, I appreciate how Daystar Co-op understands our unique financial needs. The School Fees Loan has been particularly helpful for my children's education, and the dividends provide a nice annual boost to my savings."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial3.jpg" alt="Dr. Sarah Kamau">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Dr. Sarah Kamau</h5>
                                <p>Member since 2016</p>
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
