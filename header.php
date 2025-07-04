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
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.svg">
    <!-- Remove favicon.ico reference to prevent 404 error -->
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    
    <?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div id="preloader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top main-navigation" id="mainNavigation">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand site-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar multipurpose logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd." class="logo-img">
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="mobile-menu-close" style="display: none;">&times;</span>
        </button>
        
        <!-- Navigation Items -->
        <div class="collapse navbar-collapse nav-menu" id="navbarMain">
            <ul class="navbar-nav ms-auto main-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                </li>
                
                <li class="nav-item dropdown has-submenu">
                    <a class="nav-link dropdown-toggle <?php echo is_page('about-us') || is_page('our-history') || is_page('management-team') || is_page('board-of-directors') || is_page('delegates') || is_page('supervisory-committee') ? 'active' : ''; ?>" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About Us
                        <i class="fas fa-chevron-down submenu-indicator"></i>
                    </a>
                    <ul class="dropdown-menu submenu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('about-us')); ?>">About Us</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('our-history')); ?>">Our History</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('management-team')); ?>">Management Team</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('board-of-directors')); ?>">Board of Directors</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('delegates')); ?>">Delegates</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('supervisory-committee')); ?>">Supervisory Committee</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown has-submenu mega-menu">
                    <a class="nav-link dropdown-toggle <?php echo is_page('products-services') || is_page('development-loans') || is_page('school-fees-loans') || is_page('emergency-loans') || is_page('special-loans') || is_page('super-saver-loans') || is_page('salary-advance') ? 'active' : ''; ?>" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products & Services
                        <i class="fas fa-chevron-down submenu-indicator"></i>
                    </a>
                    <ul class="dropdown-menu submenu mega-menu-content" aria-labelledby="productsDropdown">
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
                    <a class="nav-link dropdown-toggle <?php echo is_page('membership') || is_page('how-to-join') || is_page('membership-benefits') ? 'active' : ''; ?>" href="#" id="membershipDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Membership
                        <i class="fas fa-chevron-down submenu-indicator"></i>
                    </a>
                    <ul class="dropdown-menu submenu" aria-labelledby="membershipDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership')); ?>">Membership Overview</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('how-to-join')); ?>">How to Join</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('membership-benefits')); ?>">Membership Benefits</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown has-submenu">
                    <a class="nav-link dropdown-toggle <?php echo is_page('loan-calculator') || is_page('savings-calculator') ? 'active' : ''; ?>" href="#" id="calculatorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Calculators
                        <i class="fas fa-chevron-down submenu-indicator"></i>
                    </a>
                    <ul class="dropdown-menu submenu" aria-labelledby="calculatorsDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('loan-calculator')); ?>">Loan Calculator</a></li>
                        <li><a class="dropdown-item" href="<?php echo esc_url(home_url('savings-calculator')); ?>">Savings Calculator</a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo is_page('contact-us') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('contact-us')); ?>">Contact Us</a>
                </li>
                
                <li class="nav-item ms-lg-3">
                    <?php if (is_user_logged_in()): ?>
                        <?php 
                        $current_user = wp_get_current_user();
                        $member_status = get_user_meta($current_user->ID, 'member_status', true);
                        ?>
                        <div class="dropdown member-dropdown">
                            <a class="btn btn-success dropdown-toggle" href="#" role="button" id="memberDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-check me-1"></i> <?php echo esc_html($current_user->display_name); ?>
                                <i class="fas fa-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end submenu" aria-labelledby="memberDropdown">
                                <?php if ($member_status === 'active'): ?>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('member-dashboard')); ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('member-profile')); ?>"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('loan-application')); ?>"><i class="fas fa-money-bill-wave me-2"></i>Apply for Loan</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo esc_url(home_url('member-dashboard')); ?>"><i class="fas fa-clock me-2"></i>Pending Approval</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-primary" href="<?php echo esc_url(home_url('login')); ?>">
                            <i class="fas fa-user me-1"></i> Member Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="content" class="site-content">
