<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SACCO
 * @subpackage sacco-php
 * @since SACCO 1.0.0
 */

?>

	<footer id="site-footer" class="site-footer">
		<div class="container py-5">
			<div class="row">
				<div class="col-lg-4 mb-4 mb-lg-0">
					<div class="footer-logo mb-3">
						<?php
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else {
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="img-fluid">
							</a>
							<?php
						}
						?>
					</div>
					<p class="footer-about">Harambee SACCO is a leading financial cooperative committed to empowering our members through innovative savings and loan products, financial education, and exceptional member service.</p>
					<div class="social-links mt-4">
						<a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
					</div>
				</div>

				<div class="col-lg-2 col-md-4 mb-4 mb-md-0">
					<h5 class="footer-heading">Quick Links</h5>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About Us</a></li>
						<li><a href="<?php echo esc_url( home_url( '/products-services' ) ); ?>">Products</a></li>
						<li><a href="<?php echo esc_url( home_url( '/how-to-join' ) ); ?>">Membership</a></li>
						<li><a href="<?php echo esc_url( home_url( '/news-events' ) ); ?>">News & Events</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact</a></li>
					</ul>
				</div>

				<div class="col-lg-3 col-md-4 mb-4 mb-md-0">
					<h5 class="footer-heading">Products</h5>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/savings-accounts' ) ); ?>">Savings Accounts</a></li>
						<li><a href="<?php echo esc_url( home_url( '/loans' ) ); ?>">Loan Products</a></li>
						<li><a href="<?php echo esc_url( home_url( '/financial-education' ) ); ?>">Financial Education</a></li>
						<li><a href="<?php echo esc_url( home_url( '/downloads' ) ); ?>">Resources</a></li>
						<li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>">FAQ</a></li>
					</ul>
				</div>

				<div class="col-lg-3 col-md-4">
					<h5 class="footer-heading">Contact Us</h5>
					<ul class="footer-contact">
						<li><i class="fas fa-map-marker-alt me-2"></i> Harambee Plaza, 12th Floor, Nairobi</li>
						<li><i class="fas fa-phone-alt me-2"></i> +254 700 000 000</li>
						<li><i class="fas fa-envelope me-2"></i> info@harambeesacco.com</li>
						<li><i class="fas fa-clock me-2"></i> Mon-Fri: 8:00 AM - 5:00 PM</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="footer-bottom py-3">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 text-center text-md-start">
						<p class="copyright">
							&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved. Licensed and Regulated by SASRA.
							<?php if (function_exists('the_privacy_policy_link')) the_privacy_policy_link('', ' | '); ?>
						</p>
					</div>
					<div class="col-md-6 text-center text-md-end">
						<ul class="footer-legal-links">
							<li><a href="#">Terms of Service</a></li>
							<li class="mx-2">|</li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>

</body>
</html>
