<?php
/**
 * Template Name: Management Team Page
 *
 * The template for displaying the Management Team page.
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
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<?php the_title(); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<?php
	while ( have_posts() ) :
		the_post();
	?>
	
	<section class="page-content-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer(); 
?> 