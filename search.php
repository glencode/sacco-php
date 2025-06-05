<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'sacco-php' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
						<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">', '</p>' );
						} else {
							// Basic breadcrumbs fallback
							?><div class="breadcrumbs"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<?php esc_html_e('Search Results', 'sacco-php'); ?>
							</div><?php
						}
						?>
					</div>
				</div>
			</div>
		</section>

		<section class="search-results-section py-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<?php if ( have_posts() ) : ?>
							<div class="search-results-list">
								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();

									/**
									 * Run the loop for the search to output the results.
									 * If you want to overload this in a child theme then include a file
									 * called content-search.php and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'search' );

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
