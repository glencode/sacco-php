<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package sacco-php
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found py-5 text-center">
			<div class="container">
				<div class="page-content">
					<h1 class="page-title display-1 fw-bold text-primary"><?php esc_html_e( '404', 'sacco-php' ); ?></h1>
					<h2 class="mb-4"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'sacco-php' ); ?></h2>
					<p class="lead"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'sacco-php' ); ?></p>

					<?php get_search_form(); ?>

					<div class="row justify-content-center mt-5">
						<div class="col-md-8">
							<h3 class="mb-3"><?php esc_html_e( 'Maybe try these useful links:', 'sacco-php' ); ?></h3>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary', // Or another relevant menu
									'container'      => 'nav',
									'container_class'=> 'footer-navigation-404',
									'menu_class'     => 'list-unstyled d-flex flex-wrap justify-content-center',
									'fallback_cb'    => false,
									'depth'          => 1 // Keep it simple
								)
							);

							// Fallback if menu not set
							if ( !has_nav_menu( 'primary' ) ) {
								echo '<ul class="list-unstyled d-flex flex-wrap justify-content-center">';
								echo '<li class="mx-2"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Homepage', 'sacco-php') . '</a></li>';
								echo '<li class="mx-2"><a href="' . esc_url(home_url('/contact/')) . '">' . esc_html__('Contact Us', 'sacco-php') . '</a></li>';
								echo '<li class="mx-2"><a href="' . esc_url(home_url('faqs')) . '">' . esc_html__('FAQs', 'sacco-php') . '</a></li>';
								echo '</ul>';
							}
							?>
						</div>
					</div>

					<div class="mt-5">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg"><?php esc_html_e( 'Go to Homepage', 'sacco-php' ); ?></a>
					</div>

				</div><!-- .page-content -->
			</div><!-- .container -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
