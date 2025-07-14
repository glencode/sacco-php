<?php
/**
 * The template for displaying FAQ Category archive pages
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
						<?php esc_html_e('FAQs: ', 'sacco-php'); ?><?php echo esc_html($current_term->name); ?>
					</h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<a href="<?php echo esc_url(home_url('faqs')); ?>"><?php esc_html_e('FAQs', 'sacco-php'); ?></a> &gt; 
							<?php echo esc_html($current_term->name); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="faq-category-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<?php 
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
					?>
						<div class="category-description mb-4 alert alert-info">
							<?php echo wp_kses_post($term_description); ?>
						</div>
					<?php endif; ?>

					<?php if ( have_posts() ) : ?>
						<div class="accordion" id="faqCategoryAccordion-<?php echo esc_attr($current_term->slug); ?>">
							<?php
							$faq_cat_count = 0;
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();
								$faq_cat_count++;
								$faq_id = 'faq-cat-' . get_the_ID();
								$is_first = ($faq_cat_count === 1);
							?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-<?php echo esc_attr($faq_id); ?>">
									<button class="accordion-button <?php echo $is_first ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($faq_id); ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo esc_attr($faq_id); ?>">
										<?php the_title(); ?>
									</button>
								</h2>
								<div id="collapse-<?php echo esc_attr($faq_id); ?>" class="accordion-collapse collapse <?php echo $is_first ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo esc_attr($faq_id); ?>" data-bs-parent="#faqCategoryAccordion-<?php echo esc_attr($current_term->slug); ?>">
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
							<p><?php esc_html_e( 'Sorry, no frequently asked questions are available in this category. Please check back later or view all FAQs.', 'sacco-php' ); ?></p>
							<a href="<?php echo esc_url(home_url('faqs')); ?>" class="btn btn-primary mt-3"><?php esc_html_e('View All FAQs', 'sacco-php'); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 