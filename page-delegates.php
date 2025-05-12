<?php
/**
 * Template Name: Delegates Page
 *
 * The template for displaying the Sacco delegates information.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) { // Check if Yoast breadcrumbs are active
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} elseif ( function_exists('woocommerce_breadcrumb') ) { // Check for WooCommerce breadcrumbs
					    woocommerce_breadcrumb();
					} elseif ( function_exists('bcn_display') ) { // Check for Breadcrumb NavXT
					    echo '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
					    bcn_display();
					    echo '</div>';
					} else {
					    // Fallback breadcrumbs (simple version)
					    echo '<p class="breadcrumbs"><a href="' . esc_url(home_url('/')) . '">Home</a> &raquo; ' . get_the_title() . '</p>';
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="page-content-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' ); // Uses content-page.php

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 