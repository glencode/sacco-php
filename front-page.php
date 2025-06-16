<?php
/**
 * The template for displaying the front page of Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Full-Screen Hero Section with Integrated Navigation -->
    <section class="hero-section parallax-element" data-speed="0.5">
        <!-- Hero Background Slider -->
        <div class="hero-slider swiper">
            <div class="swiper-wrapper">
                <!-- Default slides - will be replaced by dynamic content -->
                <div class="swiper-slide hero-slide" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg-1.jpeg')">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide hero-slide" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg-2.jpg')">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide hero-slide" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg-3.jpg')">
                    <div class="hero-overlay"></div>
                </div>
            </div>
            <!-- Swiper Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Swiper Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        
        <!-- Integrated Navigation Bar -->
        <nav class="hero-navbar navbar navbar-expand-lg" id="hero-navigation">
            <div class="container">
                <!-- Enhanced Logo -->
                <a class="navbar-brand hero-logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar multipurpose logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd." class="logo-img">
                </a>
                
                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler hero-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#heroNavbarMain" aria-controls="heroNavbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Navigation Items -->
                <div class="collapse navbar-collapse hero-nav-menu" id="heroNavbarMain">
                    <ul class="navbar-nav ms-auto hero-main-menu">
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                        </li>
                        
                        <li class="nav-item dropdown has-submenu">
                            <a class="nav-link dropdown-toggle <?php echo is_page('about-us') || is_page('our-history') || is_page('management-team') || is_page('board-of-directors') ? 'active' : ''; ?>" href="#" id="heroAboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                About Us
                                <i class="fas fa-chevron-down submenu-indicator"></i>
                            </a>
                            <ul class="dropdown-menu hero-submenu" aria-labelledby="heroAboutDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('about-us')); ?>">About Us</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('our-history')); ?>">Our History</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('management-team')); ?>">Management Team</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('board-of-directors')); ?>">Board of Directors</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown has-submenu mega-menu">
                            <a class="nav-link dropdown-toggle <?php echo is_page('products-services') || is_page('development-loans') || is_page('school-fees-loans') || is_page('emergency-loans') || is_page('special-loans') || is_page('super-saver-loans') || is_page('salary-advance') ? 'active' : ''; ?>" href="#" id="heroProductsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products & Services
                                <i class="fas fa-chevron-down submenu-indicator"></i>
                            </a>
                            <ul class="dropdown-menu hero-submenu mega-menu-content" aria-labelledby="heroProductsDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('products-services')); ?>">All Products & Services</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Loan Products</h6></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('development-loans')); ?>">Development Loans</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('school-fees-loans')); ?>">School Fees Loans</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('emergency-loans')); ?>">Emergency Loans</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('special-loans')); ?>">Special Loans</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('super-saver-loans')); ?>">Super Saver Loans</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('salary-advance')); ?>">Salary Advance</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown has-submenu">
                            <a class="nav-link dropdown-toggle <?php echo is_page('membership') || is_page('how-to-join') || is_page('membership-benefits') ? 'active' : ''; ?>" href="#" id="heroMembershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Membership
                                <i class="fas fa-chevron-down submenu-indicator"></i>
                            </a>
                            <ul class="dropdown-menu hero-submenu" aria-labelledby="heroMembershipDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership')); ?>">Membership</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('how-to-join')); ?>">How to Join</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership-benefits')); ?>">Membership Benefits</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown has-submenu">
                            <a class="nav-link dropdown-toggle" href="#" id="heroCalculatorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Calculators
                                <i class="fas fa-chevron-down submenu-indicator"></i>
                            </a>
                            <ul class="dropdown-menu hero-submenu" aria-labelledby="heroCalculatorsDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('loan-calculator')); ?>">Loan Calculator</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('savings-calculator')); ?>">Savings Calculator</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url(home_url('contact-us')); ?>">Contact Us</a>
                        </li>
                        
                        <!-- Enhanced Member Button -->
                        <?php if (is_user_logged_in()): ?>
                            <?php $current_user = wp_get_current_user(); ?>
                            <li class="nav-item dropdown member-dropdown">
                                <a class="nav-link dropdown-toggle member-btn" href="#" id="heroMemberDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    <span class="member-name"><?php echo esc_html($current_user->display_name); ?></span>
                                </a>
                                <ul class="dropdown-menu hero-submenu member-menu" aria-labelledby="heroMemberDropdown">
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('member-dashboard')); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('my-account')); ?>"><i class="fas fa-user-cog"></i> My Account</a></li>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('my-loans')); ?>"><i class="fas fa-money-bill-wave"></i> My Loans</a></li>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('my-savings')); ?>"><i class="fas fa-piggy-bank"></i> My Savings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link member-login-btn" href="<?php echo esc_url(home_url('login')); ?>">
                                    <i class="fas fa-sign-in-alt"></i> Member Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Hero Content with Slide-Specific Text -->
        <div class="hero-content-container hero-content-repositioned">
            <div class="hero-text-content">
                <div class="slide-content" data-slide="0">
                    <h1 class="hero-title">Empowering Your Financial Journey</h1>
                    <p class="hero-subtitle">Join our community of members building a brighter financial future together.</p>
                    <div class="hero-cta">
                        <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary">Join Now</a>
                        <a href="<?php echo esc_url(home_url('products-services')); ?>" class="btn btn-secondary">Our Services</a>
                    </div>
                </div>
                <div class="slide-content" data-slide="1">
                    <h1 class="hero-title">Flexible Loan Solutions</h1>
                    <p class="hero-subtitle">Access competitive loans for development, education, and emergency needs with flexible repayment terms.</p>
                    <div class="hero-cta">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary">Apply for Loan</a>
                        <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-secondary">Calculate Loan</a>
                    </div>
                </div>
                <div class="slide-content" data-slide="2">
                    <h1 class="hero-title">Secure Savings Plans</h1>
                    <p class="hero-subtitle">Grow your wealth with our attractive savings accounts and investment opportunities.</p>
                    <div class="hero-cta">
                        <a href="<?php echo esc_url(home_url('savings-accounts')); ?>" class="btn btn-primary">Start Saving</a>
                        <a href="<?php echo esc_url(home_url('savings-calculator')); ?>" class="btn btn-secondary">Calculate Savings</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Glassmorphic Quick Actions Panel -->
        <div class="quick-actions-panel enhanced">
            <h3 class="quick-actions-title">Quick Actions</h3>
            <div class="quick-actions-grid">
                <div class="quick-action-item" data-action="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Member Login</span>
                </div>
                <div class="quick-action-item" data-action="calculator">
                    <i class="fas fa-calculator"></i>
                    <span>Loan Calculator</span>
                </div>
                <div class="quick-action-item" data-action="register">
                    <i class="fas fa-user-plus"></i>
                    <span>Join Now</span>
                </div>
            </div>
        </div>
        
        <!-- Hero Navigation will be added by JavaScript -->
    </section>
    
    <!-- Statistics Section -->
    <section class="stats-section animate-on-scroll">
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
                    <div class="stat-number" data-stat="savings" data-count="50000000">0</div>
                    <div class="stat-label">Total Savings (KSh)</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-stat="years" data-count="15">0</div>
                    <div class="stat-label">Years Serving</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Comprehensive financial solutions tailored to your needs</p>
            </div>
            
            <div class="services-grid">
                <!-- Default services - will be replaced by dynamic content -->
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-piggy-bank"></i>
                    <h3 class="service-title">Savings Accounts</h3>
                    <p class="service-description">Secure your future with our competitive savings accounts offering attractive interest rates.</p>
                    <a href="/savings" class="service-link">Learn More →</a>
                </div>
                
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-hand-holding-usd"></i>
                    <h3 class="service-title">Personal Loans</h3>
                    <p class="service-description">Access quick and affordable personal loans for your immediate financial needs.</p>
                    <a href="/loans" class="service-link">Learn More →</a>
                </div>
                
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-home"></i>
                    <h3 class="service-title">Development Loans</h3>
                    <p class="service-description">Build your dream home or invest in property with our development loan products.</p>
                    <a href="/development-loans" class="service-link">Learn More →</a>
                </div>
                
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-graduation-cap"></i>
                    <h3 class="service-title">Education Loans</h3>
                    <p class="service-description">Invest in education with our flexible school fees and education financing options.</p>
                    <a href="/education-loans" class="service-link">Learn More →</a>
                </div>
                
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-shield-alt"></i>
                    <h3 class="service-title">Emergency Loans</h3>
                    <p class="service-description">Quick access to emergency funds when you need them most, with minimal documentation.</p>
                    <a href="/emergency-loans" class="service-link">Learn More →</a>
                </div>
                
                <div class="service-card animate-on-scroll">
                    <i class="service-icon fas fa-chart-line"></i>
                    <h3 class="service-title">Investment Plans</h3>
                    <p class="service-description">Grow your wealth with our diverse investment opportunities and financial planning services.</p>
                    <a href="/investments" class="service-link">Learn More →</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Membership Requirements Section -->
    <section class="membership-section animate-on-scroll">
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
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-preview.jpeg" alt="Loan Calculator Preview" class="img-fluid rounded-lg shadow">
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
                <p class="section-subtitle">What our members say about us</p>
            </div>
            
            <?php
            // Query testimonials from custom post type
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 6,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($testimonials_query->have_posts()) : ?>
            <div class="testimonials-slider swiper">
                <div class="swiper-wrapper">
                    <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        $rating = get_field('testimonial_rating') ?: 5;
                        $member_since = get_field('member_since') ?: '';
                        $position = get_field('position') ?: '';
                    ?>
                    <div class="swiper-slide">
                        <div class="testimonial-card enhanced fade-in">
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
                                <p>"<?php echo wp_trim_words(get_the_content(), 30, '...'); ?>"</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title())); ?>
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
                    <!-- Static fallback testimonials -->
                    <div class="swiper-slide">
                        <div class="testimonial-card enhanced">
                            <div class="testimonial-quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                <p>"Daystar SACCO has transformed my financial life. Their loan services are quick and reliable, and the savings plans have helped me achieve my goals faster than I ever imagined."</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial-1.jpg" alt="Sarah Wanjiku">
                                </div>
                                <div class="testimonial-author-info">
                                    <h5>Sarah Wanjiku</h5>
                                    <p class="position">Small Business Owner</p>
                                    <p class="member-since">Member since 2019</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="testimonial-card enhanced">
                            <div class="testimonial-quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                <p>"The customer service at Daystar SACCO is exceptional. They guided me through every step of my home loan application, making the process smooth and stress-free."</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial-2.jpg" alt="John Kamau">
                                </div>
                                <div class="testimonial-author-info">
                                    <h5>John Kamau</h5>
                                    <p class="position">Teacher</p>
                                    <p class="member-since">Member since 2020</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="testimonial-card enhanced">
                            <div class="testimonial-quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                <p>"I've been with Daystar SACCO for over 5 years, and their commitment to member welfare is unmatched. The dividends and interest rates are competitive and fair."</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="testimonial-author-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/testimonial-3.jpg" alt="Grace Muthoni">
                                </div>
                                <div class="testimonial-author-info">
                                    <h5>Grace Muthoni</h5>
                                    <p class="position">Nurse</p>
                                    <p class="member-since">Member since 2018</p>
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
