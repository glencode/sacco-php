<?php
/**
 * Template Name: Tenders Page
 *
 * The template for displaying Tenders and Procurement information.
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
			<div class="row justify-content-center">
				<div class="col-lg-10 entry-content">
					<?php 
					// Main content for tenders, can be populated via editor
					the_content(); 

					// Placeholder for a list of tenders if not using editor content
					// This could be replaced with a loop from a CPT or ACF repeater field later
					/*
					if ( !get_the_content() ) {
						echo '<div class="alert alert-info">Currently, there are no active tenders. Please check back soon.</div>';
						// Example structure for a tender item:
						/*
						echo '<div class="tender-item card mb-3">';
							echo '<div class="card-body">';
								echo '<h5 class="card-title">Tender Title Example</h5>';
								echo '<p class="card-text"><small class="text-muted">Reference: TNDR/001/2024 | Closing Date: 31st December 2024</small></p>';
								echo '<p class="card-text">Brief description of the tender...</p>';
								echo '<a href="#" class="btn btn-primary">Download Tender Document</a>';
							echo '</div>';
						echo '</div>';
						*\/
					}
					*/
					?>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer(); 