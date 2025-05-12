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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'sacco-php' ); ?></a>

	<header id="masthead" class="site-header">
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
								<p class="site-description"><?php echo $sacco_php_description; ?></p>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-lg-7 col-md-4 col-6">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<i class="fas fa-bars"></i>
							</button>
							
							<div class="mobile-menu-overlay"></div>
							
							<div class="mobile-menu-wrapper">
								<div class="mobile-menu-header">
									<span class="site-title"><?php bloginfo( 'name' ); ?></span>
									<button class="mobile-menu-close" aria-label="Close menu">
										<i class="fas fa-times"></i>
									</button>
								</div>
							
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
							</div>
						</nav>
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
	</header>
</div>
</body>
</html>
