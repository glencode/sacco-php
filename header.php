<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sacco-php
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'sacco-php' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="top-bar bg-dark text-white py-2">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<div class="contact-info d-flex flex-wrap">
							<div class="phone me-4">
								<i class="fas fa-phone-alt me-2"></i><span>+254 700 123 456</span>
							</div>
							<div class="email">
								<i class="fas fa-envelope me-2"></i><span>info@sacco.com</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 text-md-end">
						<div class="social-links">
							<?php 
							// Social media menu
							if ( has_nav_menu( 'social_links' ) ) {
								wp_nav_menu( array(
									'theme_location' => 'social_links',
									'menu_id'        => 'social-menu',
									'menu_class'     => 'social-menu list-inline mb-0',
									'container'      => false,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>',
								) );
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="main-header py-3">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-3 col-md-4 col-6">
						<div class="site-branding">
							<?php
							the_custom_logo();
							if ( is_front_page() && is_home() ) :
								?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php
							else :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$sacco_php_description = get_bloginfo( 'description', 'display' );
							if ( $sacco_php_description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $sacco_php_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>
						</div><!-- .site-branding -->
					</div>
					<div class="col-lg-7 col-md-4 col-6 d-flex justify-content-start justify-content-lg-center">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<i class="fas fa-bars"></i>
							</button>
							
							<!-- Mobile Menu Overlay -->
							<div class="mobile-menu-overlay"></div>
							
							<!-- Mobile Menu Wrapper -->
							<div class="mobile-menu-wrapper">
								<div class="mobile-menu-header">
									<span class="site-title"><?php bloginfo( 'name' ); ?></span>
									<button class="mobile-menu-close" aria-label="Close menu">
										<i class="fas fa-times"></i>
									</button>
								</div>
							
							<?php
							if (has_nav_menu('primary')) {
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
										'menu_class'     => 'primary-menu',
										'container'      => false,
										'depth'          => 4, // Make sure all levels display properly
									)
								);
							}
							?>
							</div><!-- .mobile-menu-wrapper -->
						</nav><!-- #site-navigation -->
					</div>
					<div class="col-lg-2 col-md-4 d-none d-md-block">
						<div class="header-cta text-end">
							<?php if (is_user_logged_in()) : ?>
								<a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="btn btn-primary btn-sm">My Account</a>
							<?php else : ?>
								<a href="<?php echo esc_url(home_url('login')); ?>" class="btn btn-primary btn-sm">Member Portal</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu variables
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-navigation');
    const mobileMenuWrapper = document.querySelector('.mobile-menu-wrapper');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    const body = document.body;
    
    let isToggling = false; // Debounce flag
    
    // Check for small screens
    function isSmallScreen() {
        return window.innerWidth <= 768;
    }
    
    // Toggle mobile menu
    function toggleMobileMenu() {
        if (isToggling) {
            console.log('Toggle attempt blocked due to rapid re-entry');
            return; // Prevent re-entry if already processing
        }
        isToggling = true;
        console.log('Toggling menu - setting isToggling to true');

        console.log('Before toggle: mainNav active?', mainNav.classList.contains('active'));
        mainNav.classList.toggle('active');
        console.log('After toggle: mainNav active?', mainNav.classList.contains('active'));
        
        mobileMenuOverlay.classList.toggle('active');
        body.classList.toggle('mobile-menu-open');
        
        const expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
        menuToggle.setAttribute('aria-expanded', !expanded);

        // Reset the flag after a slightly longer delay to allow all operations to complete
        setTimeout(() => {
            console.log('Resetting isToggling to false after timeout');
            isToggling = false;
        }, 100); // Increased to 100ms
    }
    
    // Define the click handler function for the main menu toggle
    function menuToggleClickHandler(e) {
        console.log('Menu toggle clicked');
        e.preventDefault();
        e.stopPropagation(); // Prevent event from bubbling to other elements like the overlay
        toggleMobileMenu();
    }
    
    // Open mobile menu
    if (menuToggle) {
        // Remove any existing listener first to prevent duplicates
        menuToggle.removeEventListener('click', menuToggleClickHandler);
        // Then add the listener
        menuToggle.addEventListener('click', menuToggleClickHandler);
    }
    
    // Close mobile menu
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileMenu();
        });
    }
    
    // Close mobile menu when clicking overlay
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileMenu();
        });
    }
    
    // Close mobile menu with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mainNav.classList.contains('active')) {
            toggleMobileMenu();
        }
    });
    
    // Process mobile menu dropdowns - improved recursive approach
    function setupMobileMenuDropdowns() {
        // Function to handle nested dropdowns at all levels recursively
        function setupDropdowns(container) {
            // Find all menu items with children in this container
            const menuItemsWithChildren = container.querySelectorAll(':scope > li.menu-item-has-children');
            
            menuItemsWithChildren.forEach(function(item) {
                const link = item.querySelector(':scope > a');
                const submenu = item.querySelector(':scope > ul.sub-menu');
                
                if (link && submenu) {
                    // Create dropdown toggle if it doesn't exist
                    if (!item.querySelector(':scope > .dropdown-toggle')) {
                        const dropdownToggle = document.createElement('button');
                        dropdownToggle.className = 'dropdown-toggle';
                        dropdownToggle.setAttribute('aria-expanded', 'false');
                        dropdownToggle.setAttribute('aria-label', 'Expand submenu');
                        
                        // Add dropdown toggle button after the link
                        link.parentNode.insertBefore(dropdownToggle, link.nextSibling);
                        
                        // Add click event to toggle button
                        dropdownToggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            
                            // Toggle submenu visibility
                            submenu.classList.toggle('toggled-on');
                            
                            // Toggle ARIA state
                            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                            this.setAttribute('aria-expanded', !expanded);
                        });
                    }
                    
                    // Process next level of dropdowns recursively
                    setupDropdowns(submenu);
                }
            });
        }
        
        // Start with primary menu
        const primaryMenu = document.getElementById('primary-menu');
        if (primaryMenu) {
            setupDropdowns(primaryMenu);
        }
    }
    
    // Initialize mobile menu dropdowns
    setupMobileMenuDropdowns();
    
    // Handle desktop menu positioning
    function handleSubmenuPositioning() {
        if (window.innerWidth <= 768) return; // Skip on mobile
        
        // Process all levels of menu items recursively
        function checkPosition(container) {
            const items = container.querySelectorAll(':scope > li.menu-item-has-children');
            
            items.forEach(function(item) {
                const submenu = item.querySelector(':scope > ul.sub-menu');
                if (!submenu) return;
                
                // Reset position class
                item.classList.remove('position-edge');
                
                // Check if this is a top-level menu item
                const isTopLevel = container.id === 'primary-menu';
                
                if (isTopLevel) {
                    // For top-level items, check right edge of window
                    const rect = item.getBoundingClientRect();
                    const submenuWidth = submenu.offsetWidth;
                    
                    if (rect.left + submenuWidth > window.innerWidth) {
                        item.classList.add('position-edge');
                    }
                } else {
                    // For submenu items, check right edge for their children
                    const rect = item.getBoundingClientRect();
                    const submenuWidth = submenu.offsetWidth;
                    
                    if (rect.right + submenuWidth > window.innerWidth) {
                        item.classList.add('position-edge');
                    }
                }
                
                // Continue recursively
                checkPosition(submenu);
            });
        }
        
        // Start from primary menu
        const primaryMenu = document.getElementById('primary-menu');
        if (primaryMenu) {
            checkPosition(primaryMenu);
        }
    }
    
    // Run submenu positioning
    handleSubmenuPositioning();
    window.addEventListener('resize', handleSubmenuPositioning);
    
    // Keyboard navigation for accessibility
    function setupKeyboardNavigation() {
        // Handle keyboard navigation for all menu items with children
        document.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
            link.addEventListener('keydown', function(e) {
                // If Enter or Space pressed
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    
                    const parent = this.parentElement;
                    const submenu = parent.querySelector(':scope > ul.sub-menu');
                    const dropdownToggle = parent.querySelector(':scope > .dropdown-toggle');
                    
                    if (submenu) {
                        if (window.innerWidth > 768) {
                            // Desktop behavior
                            parent.classList.add('focus');
                            submenu.style.opacity = '1';
                            submenu.style.visibility = 'visible';
                            
                            // Focus first item in submenu
                            const firstItem = submenu.querySelector('a');
                            if (firstItem) {
                                setTimeout(() => firstItem.focus(), 100);
                            }
                        } else {
                            // Mobile behavior - trigger dropdown toggle
                            if (dropdownToggle) {
                                dropdownToggle.click();
                                // Focus first item in submenu
                                const firstItem = submenu.querySelector('a');
                                if (firstItem) {
                                    setTimeout(() => firstItem.focus(), 100);
                                }
                            }
                        }
                    }
                }
            });
        });
        
        // Handle Escape key for closing menus
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const focusedItem = document.querySelector('.menu-item-has-children.focus');
                if (focusedItem) {
                    focusedItem.classList.remove('focus');
                    focusedItem.querySelector('a').focus();
                }
                
                // For mobile: close open submenus
                if (window.innerWidth <= 768) {
                    const openSubmenus = document.querySelectorAll('.sub-menu.toggled-on');
                    if (openSubmenus.length > 0) {
                        // Get the last opened submenu
                        const lastSubmenu = openSubmenus[openSubmenus.length - 1];
                        lastSubmenu.classList.remove('toggled-on');
                        
                        // Update toggle button
                        const parentItem = lastSubmenu.parentElement;
                        const toggleButton = parentItem?.querySelector('.dropdown-toggle');
                        if (toggleButton) {
                            toggleButton.setAttribute('aria-expanded', 'false');
                            toggleButton.focus();
                        }
                    }
                }
            }
        });
    }
    
    // Setup keyboard navigation
    setupKeyboardNavigation();
    
    // Set initial state for mobile menu
    function setInitialMobileMenuState() {
        if (isSmallScreen()) {
            // For small screens, ensure menu is initialized properly
            mainNav.classList.remove('active');  // Start with menu closed
            mobileMenuOverlay.classList.remove('active');
            body.classList.remove('mobile-menu-open');
        }
    }
    
    // Initialize menu state
    setInitialMobileMenuState();
    
    // Handle window resize
    window.addEventListener('resize', function() {
        // Reset mobile menu when resizing to desktop
        if (window.innerWidth > 768 && mainNav.classList.contains('active')) {
            mainNav.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            body.classList.remove('mobile-menu-open');
            
            // Reset all dropdown toggles
            document.querySelectorAll('.dropdown-toggle[aria-expanded="true"]').forEach(toggle => {
                toggle.setAttribute('aria-expanded', 'false');
            });
            
            // Reset all open submenus
            document.querySelectorAll('.sub-menu.toggled-on').forEach(submenu => {
                submenu.classList.remove('toggled-on');
            });
        }
    });
});
</script>
