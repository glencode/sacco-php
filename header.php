<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Add FontAwesome for icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	
	<style>
		/* Sticky Navigation Styles */
		.sticky-nav {
			position: fixed;
			top: -100px;
			left: 0;
			right: 0;
			z-index: 9999;
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
			box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			border-bottom: 1px solid rgba(0, 0, 0, 0.1);
		}
		
		.sticky-nav.show {
			top: 0;
			transform: translateY(0);
		}
		
		.sticky-nav .container {
			padding: 0.5rem 15px;
		}
		
		.sticky-nav .site-branding {
			display: flex;
			align-items: center;
		}
		
		.sticky-nav .site-title {
			margin: 0;
			font-size: 1.2rem;
		}
		
		.sticky-nav .site-title a {
			text-decoration: none;
			color: #333;
			font-weight: 600;
		}
		
		.sticky-nav .main-navigation {
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.sticky-nav .primary-menu {
			display: flex;
			list-style: none;
			margin: 0;
			padding: 0;
			gap: 2rem;
		}
		
		.sticky-nav .primary-menu li {
			position: relative;
		}
		
		.sticky-nav .primary-menu a {
			text-decoration: none;
			color: #333;
			font-weight: 500;
			padding: 0.5rem 0;
			transition: color 0.3s ease;
			position: relative;
		}
		
		.sticky-nav .primary-menu a:hover {
			color: #007cba;
		}
		
		.sticky-nav .primary-menu a::after {
			content: '';
			position: absolute;
			bottom: -2px;
			left: 0;
			width: 0;
			height: 2px;
			background: #007cba;
			transition: width 0.3s ease;
		}
		
		.sticky-nav .primary-menu a:hover::after {
			width: 100%;
		}
		
		.sticky-nav .header-cta {
			display: flex;
			align-items: center;
			justify-content: flex-end;
		}
		
		.sticky-nav .btn {
			padding: 0.5rem 1rem;
			border-radius: 4px;
			text-decoration: none;
			font-weight: 500;
			transition: all 0.3s ease;
		}
		
		.sticky-nav .btn-light {
			background: #f8f9fa;
			color: #333;
			border: 1px solid #dee2e6;
		}
		
		.sticky-nav .btn-light:hover {
			background: #e9ecef;
			transform: translateY(-1px);
		}
		
		/* Mobile menu toggle for sticky nav */
		.sticky-nav .menu-toggle {
			display: none;
			background: none;
			border: none;
			font-size: 1.2rem;
			color: #333;
			cursor: pointer;
		}
		
		/* Mobile responsive */
		@media (max-width: 991px) {
			.sticky-nav .primary-menu {
				display: none;
			}
			
			.sticky-nav .menu-toggle {
				display: block;
			}
		}
		
		@media (max-width: 767px) {
			.sticky-nav .container {
				padding: 0.5rem 10px;
			}
			
			.sticky-nav .site-title {
				font-size: 1rem;
			}
		}
		
		/* Animation for smooth reveal */
		@keyframes slideDown {
			from {
				transform: translateY(-100%);
				opacity: 0;
			}
			to {
				transform: translateY(0);
				opacity: 1;
			}
		}
		
		.sticky-nav.show {
			animation: slideDown 0.3s ease-out;
		}
	</style>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'sacco-php' ); ?></a>

	<!-- Sticky Navigation -->
	<nav class="sticky-nav" id="sticky-nav">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-3 col-md-4 col-7">
					<div class="site-branding">
						<?php
						the_custom_logo();
						?>
						<p class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</p>
					</div>
				</div>
				<div class="col-lg-7 col-md-4 col-5">
					<nav class="main-navigation">
						<button class="menu-toggle" aria-controls="sticky-primary-menu" aria-expanded="false">
							<i class="fas fa-bars"></i>
						</button>
						<?php
						if (has_nav_menu('primary')) {
							wp_nav_menu(array(
								'theme_location' => 'primary',
								'menu_id'        => 'sticky-primary-menu',
								'menu_class'     => 'primary-menu',
								'container'      => false,
								'depth'          => 3,
							));
						}
						?>
					</nav>
				</div>
				<div class="col-lg-2 col-md-4 d-none d-md-block">
					<div class="header-cta">
						<?php if (is_user_logged_in()) : ?>
							<a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="btn btn-light btn-sm">My Account</a>
						<?php else : ?>
							<a href="<?php echo esc_url(home_url('login')); ?>" class="btn btn-light btn-sm">Member Portal</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<!-- Original Header -->
	<header id="masthead" class="site-header">
		<div class="main-header">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-3 col-md-4 col-7">
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
							?>
						</div>
					</div>
					<div class="col-lg-7 col-md-4 col-5">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<i class="fas fa-bars"></i>
							</button>
							<?php
							if (has_nav_menu('primary')) {
								wp_nav_menu(array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
									'menu_class'     => 'primary-menu',
									'container'      => false,
									'depth'          => 3,
								));
							}
							?>
							<!-- Close button for mobile menu -->
							<button class="mobile-menu-close" aria-label="Close menu">
								<i class="fas fa-times"></i>
							</button>
						</nav>
					</div>
					<div class="col-lg-2 col-md-4 d-none d-md-block">
						<div class="header-cta text-end">
							<?php if (is_user_logged_in()) : ?>
								<a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="btn btn-light btn-sm">My Account</a>
							<?php else : ?>
								<a href="<?php echo esc_url(home_url('login')); ?>" class="btn btn-light btn-sm">Member Portal</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

	<script>
		// Sticky Navigation Functionality
		document.addEventListener('DOMContentLoaded', function() {
			const stickyNav = document.getElementById('sticky-nav');
			const header = document.getElementById('masthead');
			let lastScrollTop = 0;
			let ticking = false;
			
			function updateStickyNav() {
				const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
				const headerHeight = header ? header.offsetHeight : 100;
				
				// Show sticky nav when scrolling down past header
				if (scrollTop > headerHeight && scrollTop > lastScrollTop) {
					// Scrolling down
					stickyNav.classList.add('show');
				} else if (scrollTop <= headerHeight || scrollTop < lastScrollTop - 5) {
					// Scrolling up or at top
					stickyNav.classList.remove('show');
				}
				
				lastScrollTop = scrollTop;
				ticking = false;
			}
			
			function requestTick() {
				if (!ticking) {
					requestAnimationFrame(updateStickyNav);
					ticking = true;
				}
			}
			
			// Throttled scroll event
			window.addEventListener('scroll', requestTick, { passive: true });
			
			// Initial check
			updateStickyNav();
		});
	</script>
</div>
</body>
</html>