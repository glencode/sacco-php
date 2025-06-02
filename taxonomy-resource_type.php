<?php
/**
 * The template for displaying Resource Type (Download Category) archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
$current_term = get_queried_object();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title">
						<?php single_term_title(); ?>
					</h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>"><?php esc_html_e('Downloads', 'sacco-php'); ?></a> &gt; 
							<?php single_term_title(); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="downloads-category-section py-5">
		<div class="container">
			<?php 
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
			?>
				<div class="category-description mb-4 alert alert-info">
					<?php echo wp_kses_post($term_description); ?>
				</div>
			<?php endif; ?>

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
					<?php sacco_php_pagination(); // Assumes sacco_php_pagination() is defined in template-tags.php ?>
				</div>

			<?php else : ?>
				<div class="no-downloads-found text-center">
					<h3><?php esc_html_e( 'No Downloads Found', 'sacco-php' ); ?></h3>
					<p><?php esc_html_e( 'Sorry, no downloads are available in this category. Please check back later or view all downloads.', 'sacco-php' ); ?></p>
					<a href="<?php echo esc_url(get_post_type_archive_link('download')); ?>" class="btn btn-primary mt-3"><?php esc_html_e('View All Downloads', 'sacco-php'); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 