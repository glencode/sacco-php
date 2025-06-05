<?php
/**
 * The template for displaying Download archive pages
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
					<h1 class="page-title"><?php post_type_archive_title('', true); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<?php post_type_archive_title('', true); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="downloads-archive-section py-5">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="row gy-4">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						get_template_part('template-parts/content/content', 'download-card');
					endwhile;
					?>
				</div>

				<div class="pagination-container mt-5">
					<?php the_posts_pagination(); ?>
				</div>

			<?php else : ?>
				<div class="no-downloads-found text-center">
					<h3><?php esc_html_e( 'No Downloads Found', 'sacco-php' ); ?></h3>
					<p><?php esc_html_e( 'Sorry, no downloads are available at this time. Please check back later.', 'sacco-php' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 