<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
						<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
						?>
						<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">', '</p>' );
						} else {
							// Basic breadcrumbs fallback
							?>
							<div class="breadcrumbs">
								<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
								<?php 
								// Attempt to generate a meaningful breadcrumb for archives
								if (is_category()) {
									single_cat_title();
								} elseif (is_tag()) {
									single_tag_title();
								} elseif (is_author()) {
									the_author();
								} elseif (is_day()) {
									echo get_the_date();
								} elseif (is_month()) {
									echo get_the_date(_x('F Y', 'monthly archives date format', 'sacco-php'));
								} elseif (is_year()) {
									echo get_the_date(_x('Y', 'yearly archives date format', 'sacco-php'));
								} else {
									esc_html_e('Archives', 'sacco-php');
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</section>

		<section class="archive-content-section py-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<?php if ( have_posts() ) : ?>
							<div class="blog-posts-grid">
								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/content', get_post_type() ? get_post_format() : get_post_type() );
								endwhile;
								?>
							</div>

							<div class="pagination-container mt-5">
								<?php the_posts_pagination(); ?>
							</div>

						<?php else : ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>
					</div>
					<div class="col-lg-4">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
