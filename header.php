<?php
/**
 * The header for Daystar Multi-Purpose Co-op Society Ltd. website
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package daystar-coop
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="description" content="Daystar Multi-Purpose Co-op Society Ltd. - Empowering members through financial solutions">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/daystar-styles.css">
    
    <?php wp_head(); ?>
    
    <!-- Skip to content link for accessibility -->
    <a href="#primary" class="skip-to-content">Skip to content</a>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div id="preloader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Top Bar -->
<div class="top-bar bg-primary text-white py-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-3">
                        <i class="fas fa-phone-alt me-1"></i> Airtel: 0731-629-716 | Safaricom: 0799-174-239
                    </li>
                    <li class="list-inline-item">
                        <i class="fas fa-envelope me-1"></i> daystarmultipurpose@daystar.ac.ke
                    </li>
                </ul>
            </div>
            <div class="col-md-6 text-md-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-3">
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="text-white">
                            <i class="fas fa-map-marker-alt me-1"></i> Find Us
                        </a>
                    </li>
                    <li class="list-inline-item me-3">
                        <a href="<?php echo esc_url(home_url('faqs')); ?>" class="text-white">
                            <i class="fas fa-question-circle me-1"></i> FAQs
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <div class="dropdown">
                            <a class="text-white dropdown-toggle" href="#" role="button" id="quickLinksDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-link me-1"></i> Quick Links
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="quickLinksDropdown">
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('credit-policy')); ?>">Credit Policy</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('downloads')); ?>">Downloads</a></li>
                                <li><a class="dropdown-item" href="<?php echo esc_url(home_url('news-events')); ?>">News & Events</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="https://www.daystar.ac.ke" target="_blank">Daystar University</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar multipurpose logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd.">
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo is_page('about-us') || is_page('our-history') || is_page('management-team') || is_page('board-of-directors') ? 'active' : ''; ?>" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('about-us')); ?>">About Us</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('our-history')); ?>">Our History</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('management-team')); ?>">Management Team</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('board-of-directors')); ?>">Board of Directors</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo is_page('products-services') || is_page('development-loans') || is_page('school-fees-loans') || is_page('emergency-loans') || is_page('special-loans') || is_page('super-saver-loans') || is_page('salary-advance') ? 'active' : ''; ?>" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products & Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
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
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo is_page('membership') || is_page('how-to-join') || is_page('membership-benefits') ? 'active' : ''; ?>" href="#" id="membershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Membership
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="membershipDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership')); ?>">Membership Overview</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('how-to-join')); ?>">How to Join</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership-benefits')); ?>">Membership Benefits</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo is_page('loan-calculator') || is_page('savings-calculator') ? 'active' : ''; ?>" href="#" id="calculatorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Calculators
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="calculatorsDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('loan-calculator')); ?>">Loan Calculator</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('savings-calculator')); ?>">Savings Calculator</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo is_page('contact-us') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('contact-us')); ?>">Contact Us</a>
                </li>
                
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary" href="<?php echo esc_url(home_url('login')); ?>">
                        <i class="fas fa-user me-1"></i> Member Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="content" class="site-content">
