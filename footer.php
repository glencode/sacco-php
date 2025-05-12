<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sacco-php
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row footer-widgets">
				<div class="col-lg-3 col-md-6">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php else : ?>
						<div class="footer-widget">
							<h4 class="footer-widget-title">About Us</h4>
							<div class="footer-about">
								<p>Harambee SACCO is a premier savings and credit cooperative organization dedicated to empowering members financially through innovative solutions.</p>
								<div class="footer-contact mt-4">
									<p><i class="fas fa-map-marker-alt me-2"></i> 123 Main Street, Nairobi, Kenya</p>
									<p><i class="fas fa-phone-alt me-2"></i> +254 700 123 456</p>
									<p><i class="fas fa-envelope me-2"></i> info@sacco.com</p>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="col-lg-3 col-md-6">
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<?php dynamic_sidebar( 'footer-2' ); ?>
					<?php else : ?>
						<div class="footer-widget">
							<h4 class="footer-widget-title">Quick Links</h4>
							<?php
							if (has_nav_menu('footer_quick_links')) {
								wp_nav_menu(array(
									'theme_location' => 'footer_quick_links',
									'menu_class'     => 'footer-menu',
									'container'      => false,
								));
							} else {
								// Fallback menu
								echo '<ul>';
								echo '<li><a href="' . esc_url(home_url()) . '">Home</a></li>';
								echo '<li><a href="' . esc_url(home_url('about-us')) . '">About Us</a></li>';
								echo '<li><a href="' . esc_url(home_url('products')) . '">Products</a></li>';
								echo '<li><a href="' . esc_url(home_url('contact')) . '">Contact</a></li>';
								echo '</ul>';
							}
							?>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="col-lg-3 col-md-6">
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<?php dynamic_sidebar( 'footer-3' ); ?>
					<?php else : ?>
						<div class="footer-widget">
							<h4 class="footer-widget-title">Our Products</h4>
							<ul>
								<?php
								// Display Product CPT links
								$products = new WP_Query(array(
									'post_type' => 'product',
									'posts_per_page' => 5,
								));
								
								if ($products->have_posts()) {
									while ($products->have_posts()) {
										$products->the_post();
										echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
									}
									wp_reset_postdata();
								} else {
									// Fallback if no products
									echo '<li><a href="#">Savings Account</a></li>';
									echo '<li><a href="#">Personal Loans</a></li>';
									echo '<li><a href="#">Home Loans</a></li>';
									echo '<li><a href="#">Business Loans</a></li>';
									echo '<li><a href="#">Education Loans</a></li>';
								}
								?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="col-lg-3 col-md-6">
					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<?php dynamic_sidebar( 'footer-4' ); ?>
					<?php else : ?>
						<div class="footer-widget">
							<h4 class="footer-widget-title">Newsletter</h4>
							<p>Subscribe to our newsletter to get updates on our latest services and promotions.</p>
							<form class="footer-newsletter mt-3">
								<div class="input-group mb-3">
									<input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
									<button class="btn btn-primary" type="button">Subscribe</button>
								</div>
							</form>
							<div class="social-links mt-4">
								<?php 
								// Social media menu
								if (has_nav_menu('social_links')) {
									wp_nav_menu(array(
										'theme_location' => 'social_links',
										'menu_id'        => 'footer-social-menu',
										'menu_class'     => 'footer-social-menu list-inline mb-0',
										'container'      => false,
										'link_before'    => '<span class="screen-reader-text">',
										'link_after'     => '</span>',
									));
								} else {
									// Fallback social links
									echo '<ul class="footer-social-menu list-inline mb-0">';
									echo '<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i><span class="screen-reader-text">Facebook</span></a></li>';
									echo '<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i><span class="screen-reader-text">Twitter</span></a></li>';
									echo '<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i><span class="screen-reader-text">Instagram</span></a></li>';
									echo '<li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i><span class="screen-reader-text">LinkedIn</span></a></li>';
									echo '</ul>';
								}
								?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p class="copyright">
							&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved. Licensed and Regulated by SASRA.
							<?php if (function_exists('the_privacy_policy_link')) the_privacy_policy_link('', ' | '); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/254700000000" class="whatsapp-float" target="_blank" rel="noopener noreferrer">
	<i class="fab fa-whatsapp"></i>
</a>

<?php wp_footer(); ?>

</body>
</html>
