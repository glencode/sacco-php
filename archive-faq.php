<?php
/**
 * The template for displaying FAQ archive pages
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
					<h1 class="page-title"><?php esc_html_e( 'Frequently Asked Questions', 'sacco-php' ); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<?php esc_html_e( 'FAQs', 'sacco-php' ); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="faq-archive-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<?php if ( have_posts() ) : ?>
						<div class="accordion" id="faqAccordion">
							<?php
							$faq_count = 0;
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();
								$faq_count++;
								$faq_id = 'faq-' . get_the_ID();
								$is_first = ($faq_count === 1);
							?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-<?php echo esc_attr($faq_id); ?>">
									<button class="accordion-button <?php echo $is_first ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($faq_id); ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo esc_attr($faq_id); ?>">
										<?php the_title(); ?>
									</button>
								</h2>
								<div id="collapse-<?php echo esc_attr($faq_id); ?>" class="accordion-collapse collapse <?php echo $is_first ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo esc_attr($faq_id); ?>" data-bs-parent="#faqAccordion">
									<div class="accordion-body">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
							<?php endwhile; ?>
						</div>

						<div class="pagination-container mt-5">
							<?php sacco_php_pagination(); ?>
						</div>

					<?php else : ?>
						<div class="no-faqs-found text-center">
							<h3><?php esc_html_e( 'No FAQs Found', 'sacco-php' ); ?></h3>
							<p><?php esc_html_e( 'Sorry, no frequently asked questions are available at this time. Please check back later.', 'sacco-php' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 