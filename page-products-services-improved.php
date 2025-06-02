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

<main id="primary" class="site-main products-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Our Products & Services</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products & Services</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
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
                        <h2 class="section-title">Financial Solutions Tailored for You</h2>
                        <p class="lead">We offer a comprehensive range of financial products and services designed to meet your unique needs at every stage of life.</p>
                        <p>Whether you're saving for the future, planning a major purchase, or looking to grow your wealth, our team of financial experts is here to help you achieve your goals with personalized solutions and competitive rates.</p>
                        <div class="mt-4">
                            <a href="#savings" class="btn btn-primary me-3">Explore Savings</a>
                            <a href="#loans" class="btn btn-outline-primary">View Loans</a>
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

    <!-- Savings Products Section -->
    <section id="savings" class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Savings Products</h2>
                <p class="section-subtitle">Secure your future with our range of savings options</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                        </div>
                        <h3>Regular Savings Account</h3>
                        <ul class="product-features">
                            <li>Competitive interest rates</li>
                            <li>No minimum balance requirements</li>
                            <li>Free online and mobile banking</li>
                            <li>Monthly statements</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">3.5%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/regular')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                        </div>
                        <h3>Fixed Deposit Account</h3>
                        <ul class="product-features">
                            <li>Higher interest rates</li>
                            <li>Terms from 3 to 60 months</li>
                            <li>Minimum deposit of KSh 10,000</li>
                            <li>Interest paid at maturity</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">7.5%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/fixed-deposit')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Education Savings Plan</h3>
                        <ul class="product-features">
                            <li>Save for your child's education</li>
                            <li>Flexible contribution options</li>
                            <li>Tax advantages</li>
                            <li>Competitive interest rates</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">6.0%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/education')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </div>
                        <h3>Housing Savings Plan</h3>
                        <ul class="product-features">
                            <li>Save for your dream home</li>
                            <li>Preferential mortgage rates</li>
                            <li>Flexible contribution schedule</li>
                            <li>Goal-based savings tracking</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">5.5%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/housing')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-umbrella" aria-hidden="true"></i>
                        </div>
                        <h3>Retirement Savings Plan</h3>
                        <ul class="product-features">
                            <li>Long-term retirement planning</li>
                            <li>Tax-advantaged contributions</li>
                            <li>Multiple investment options</li>
                            <li>Regular retirement planning advice</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">6.5%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/retirement')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-coins" aria-hidden="true"></i>
                        </div>
                        <h3>Junior Savings Account</h3>
                        <ul class="product-features">
                            <li>Teach children about saving</li>
                            <li>No monthly fees</li>
                            <li>Attractive interest rates</li>
                            <li>Educational resources included</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">4.0%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('savings-accounts/junior')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('savings-calculator')); ?>" class="btn btn-primary">Try Our Savings Calculator</a>
            </div>
        </div>
    </section>

    <!-- Loan Products Section -->
    <section id="loans" class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Loan Products</h2>
                <p class="section-subtitle">Flexible financing solutions to meet your needs</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </div>
                        <h3>Mortgage Loan</h3>
                        <ul class="product-features">
                            <li>Competitive interest rates</li>
                            <li>Up to 25-year repayment terms</li>
                            <li>Financing up to 90% of property value</li>
                            <li>Flexible repayment options</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/mortgage')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-car" aria-hidden="true"></i>
                        </div>
                        <h3>Auto Loan</h3>
                        <ul class="product-features">
                            <li>New and used vehicle financing</li>
                            <li>Up to 7-year repayment terms</li>
                            <li>Quick approval process</li>
                            <li>No prepayment penalties</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">14%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/auto')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Education Loan</h3>
                        <ul class="product-features">
                            <li>Cover tuition and education expenses</li>
                            <li>Deferred payment options</li>
                            <li>Competitive interest rates</li>
                            <li>Flexible repayment terms</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">10%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/education')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-briefcase" aria-hidden="true"></i>
                        </div>
                        <h3>Business Loan</h3>
                        <ul class="product-features">
                            <li>Start or expand your business</li>
                            <li>Flexible collateral options</li>
                            <li>Customized repayment schedules</li>
                            <li>Business advisory services included</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">15%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/business')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>Personal Loan</h3>
                        <ul class="product-features">
                            <li>Quick access to funds</li>
                            <li>Minimal documentation</li>
                            <li>Flexible use of funds</li>
                            <li>Competitive rates</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">16%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/personal')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-tractor" aria-hidden="true"></i>
                        </div>
                        <h3>Agricultural Loan</h3>
                        <ul class="product-features">
                            <li>Seasonal repayment options</li>
                            <li>Financing for equipment and supplies</li>
                            <li>Technical assistance available</li>
                            <li>Flexible terms aligned with harvest cycles</li>
                        </ul>
                        <div class="product-rate">
                            <span class="rate-value">13%</span>
                            <span class="rate-label">Annual Interest</span>
                        </div>
                        <a href="<?php echo esc_url(home_url('loans/agricultural')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-primary">Try Our Loan Calculator</a>
            </div>
        </div>
    </section>

    <!-- Product Comparison Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Product Comparison</h2>
                <p class="section-subtitle">Compare our products to find the right fit for your needs</p>
            </div>
            
            <div class="table-responsive fade-in">
                <table class="table product-comparison-table">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            <th scope="col">Regular Savings</th>
                            <th scope="col">Fixed Deposit</th>
                            <th scope="col">Retirement Plan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Minimum Deposit</th>
                            <td>KSh 1,000</td>
                            <td>KSh 10,000</td>
                            <td>KSh 5,000</td>
                        </tr>
                        <tr>
                            <th scope="row">Interest Rate</th>
                            <td>3.5% p.a.</td>
                            <td>7.5% p.a.</td>
                            <td>6.5% p.a.</td>
                        </tr>
                        <tr>
                            <th scope="row">Withdrawal Flexibility</th>
                            <td>High</td>
                            <td>Low</td>
                            <td>Medium</td>
                        </tr>
                        <tr>
                            <th scope="row">Term Length</th>
                            <td>No fixed term</td>
                            <td>3-60 months</td>
                            <td>Until retirement</td>
                        </tr>
                        <tr>
                            <th scope="row">Interest Payment</th>
                            <td>Monthly</td>
                            <td>At maturity</td>
                            <td>Quarterly</td>
                        </tr>
                        <tr>
                            <th scope="row">Online Access</th>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Mobile Banking</th>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Monthly Fee</th>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive mt-5 fade-in">
                <table class="table product-comparison-table">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            <th scope="col">Personal Loan</th>
                            <th scope="col">Mortgage Loan</th>
                            <th scope="col">Business Loan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Maximum Amount</th>
                            <td>KSh 1,000,000</td>
                            <td>KSh 50,000,000</td>
                            <td>KSh 10,000,000</td>
                        </tr>
                        <tr>
                            <th scope="row">Interest Rate</th>
                            <td>16% p.a.</td>
                            <td>12% p.a.</td>
                            <td>15% p.a.</td>
                        </tr>
                        <tr>
                            <th scope="row">Maximum Term</th>
                            <td>5 years</td>
                            <td>25 years</td>
                            <td>10 years</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Time</th>
                            <td>1-3 days</td>
                            <td>7-14 days</td>
                            <td>3-7 days</td>
                        </tr>
                        <tr>
                            <th scope="row">Collateral Required</th>
                            <td><i class="fas fa-times text-danger" aria-hidden="true"></i><span class="sr-only">No</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td>Varies</td>
                        </tr>
                        <tr>
                            <th scope="row">Early Repayment Fee</th>
                            <td>None</td>
                            <td>2%</td>
                            <td>1%</td>
                        </tr>
                        <tr>
                            <th scope="row">Processing Fee</th>
                            <td>2%</td>
                            <td>1.5%</td>
                            <td>2.5%</td>
                        </tr>
                        <tr>
                            <th scope="row">Insurance Required</th>
                            <td><i class="fas fa-times text-danger" aria-hidden="true"></i><span class="sr-only">No</span></td>
                            <td><i class="fas fa-check text-success" aria-hidden="true"></i><span class="sr-only">Yes</span></td>
                            <td>Varies</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Additional Services Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Additional Services</h2>
                <p class="section-subtitle">Beyond savings and loans, we offer a range of financial services</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Mobile Banking</h3>
                        <p>Access your accounts, transfer funds, pay bills, and more from our secure mobile app, available 24/7 from anywhere.</p>
                        <a href="<?php echo esc_url(home_url('services/mobile-banking')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-credit-card" aria-hidden="true"></i>
                        </div>
                        <h3>ATM & Debit Cards</h3>
                        <p>Convenient access to your funds with our ATM and debit cards, accepted at thousands of locations nationwide.</p>
                        <a href="<?php echo esc_url(home_url('services/cards')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Money Transfer</h3>
                        <p>Send and receive money locally and internationally with our secure and affordable money transfer services.</p>
                        <a href="<?php echo esc_url(home_url('services/money-transfer')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Insurance Services</h3>
                        <p>Protect what matters most with our range of insurance products, including life, health, property, and more.</p>
                        <a href="<?php echo esc_url(home_url('services/insurance')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                        </div>
                        <h3>Financial Planning</h3>
                        <p>Work with our certified financial advisors to create a personalized plan to achieve your short and long-term financial goals.</p>
                        <a href="<?php echo esc_url(home_url('services/financial-planning')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="fas fa-university" aria-hidden="true"></i>
                        </div>
                        <h3>Investment Advisory</h3>
                        <p>Grow your wealth with expert investment advice and access to a diverse portfolio of investment opportunities.</p>
                        <a href="<?php echo esc_url(home_url('services/investment-advisory')); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">What Our Members Say</h2>
                <p class="section-subtitle">Real experiences from our satisfied members</p>
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
                            <p>"The mortgage loan process was seamless and the team provided exceptional guidance throughout. I'm now a proud homeowner thanks to their support!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial1.jpg" alt="Sarah Johnson">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Sarah Johnson</h5>
                                <p>Mortgage Loan Member</p>
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
                            <p>"The business loan I received helped me expand my small business. The personalized service and competitive rates made all the difference."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial2.jpg" alt="Michael Rodriguez">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Michael Rodriguez</h5>
                                <p>Business Loan Member</p>
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
                            <p>"I've been using the retirement savings plan for 5 years now, and I'm impressed with the returns and the regular updates I receive about my investment."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial3.jpg" alt="Jennifer Lee">
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Jennifer Lee</h5>
                                <p>Retirement Plan Member</p>
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
                        <h2 class="cta-title">Ready to Get Started?</h2>
                        <p class="cta-subtitle">Our financial experts are ready to help you choose the right products for your needs.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-gradient btn-lg">Contact Us</a>
                        <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-outline-light btn-lg ms-2">Join Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
