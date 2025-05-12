<?php
/**
 * The template for displaying single product posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url()); ?>">Home</a> &gt; 
							<a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>">Products</a> &gt; 
							<?php the_title(); ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="product-detail-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="product-featured-image mb-4">
							<?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
						</div>
						<?php endif; ?>

						<div class="product-content">
							<div class="entry-content">
								<?php the_content(); ?>
							</div>
						</div>
					</article>
				</div>
				
				<div class="col-lg-4">
					<div class="product-sidebar">
						<div class="card mb-4">
							<div class="card-header bg-primary text-white">
								<h4 class="mb-0">Product Information</h4>
							</div>
							<div class="card-body">
								<?php
								// Display product categories
								$product_categories = get_the_terms(get_the_ID(), 'product_category');
								if ($product_categories && !is_wp_error($product_categories)) {
									echo '<p class="mb-2"><strong>Categories:</strong> ';
									$cat_links = [];
									foreach ($product_categories as $category) {
										$cat_links[] = '<a href="' . esc_url(get_term_link($category)) . '" class="badge bg-secondary text-decoration-none">' . esc_html($category->name) . '</a>';
									}
									echo implode(' ', $cat_links);
									echo '</p>';
								}

								// Placeholder for other generic product details if needed via ACF or simple meta
								$product_sku = get_post_meta(get_the_ID(), '_product_sku', true);
								if ($product_sku) {
									echo '<p class="mb-1"><strong>SKU:</strong> ' . esc_html($product_sku) . '</p>';
								}
								// Add more generic fields here as needed, e.g. availability, reference number etc.
								
								// If there's an excerpt, it can be shown here too, or a specific short description field
                                $short_description = get_the_excerpt(); 
                                if ( $short_description && !has_post_thumbnail() ) { // Show if no featured image, or if you always want it
                                    echo '<p class="text-muted small">'. $short_description .'</p>';
                                }

								// Removed specific financial fields like interest_rate, min_amount etc.
								// General products might not have these. For specific product types that do, 
								// consider using the Loan or Savings CPTs, or adding ACF fields 
								// and conditionally displaying them based on product_category.
								?>
								<div class="product-cta mt-3">
									<button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productEnquiryModal">Enquire About This Product</button>
								</div>
							</div>
						</div>
						
						<div class="card">
							<div class="card-header bg-light">
								<h4 class="mb-0">Related Products</h4>
							</div>
							<div class="card-body">
								<?php
								// Get related products
								$terms = get_the_terms(get_the_ID(), 'product_category');
								$term_ids = array();
								
								if ($terms && !is_wp_error($terms)) {
									foreach ($terms as $term) {
										$term_ids[] = $term->term_id;
									}
								}
								
								$args = array(
									'post_type' => 'product',
									'posts_per_page' => 3,
									'post__not_in' => array(get_the_ID()),
									'tax_query' => array(
										array(
											'taxonomy' => 'product_category',
											'field' => 'term_id',
											'terms' => $term_ids,
										),
									),
								);
								
								$related_products = new WP_Query($args);
								
								if ($related_products->have_posts()) :
									while ($related_products->have_posts()) : $related_products->the_post();
								?>
								<div class="related-product-item mb-3">
									<a href="<?php the_permalink(); ?>" class="related-product-link">
										<div class="row align-items-center">
											<?php if (has_post_thumbnail()) : ?>
											<div class="col-4">
												<div class="related-product-image">
													<?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid rounded')); ?>
												</div>
											</div>
											<?php endif; ?>
											<div class="<?php echo has_post_thumbnail() ? 'col-8' : 'col-12'; ?>">
												<h5 class="related-product-title"><?php the_title(); ?></h5>
											</div>
										</div>
									</a>
								</div>
								<?php
									endwhile;
									wp_reset_postdata();
								else :
									echo '<p>No related products found.</p>';
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Product Enquiry Modal -->
	<div class="modal fade" id="productEnquiryModal" tabindex="-1" aria-labelledby="productEnquiryModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="productEnquiryModalLabel">Enquire About <?php the_title(); ?></h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?php
					// Display form submission status messages for the modal
					if (isset($_GET['form_status']) && isset($_GET['modal']) && $_GET['modal'] === 'productEnquiryModal') {
						$status = sanitize_key($_GET['form_status']);
						$message_text = '';
						$message_type = 'info';

						if ($status === 'error') {
							$message_text = esc_html__('There was an error with your enquiry. Please check the required fields and try again.', 'sacco-php');
							$message_type = 'danger';
						} elseif ($status === 'mail_error') {
							$message_text = esc_html__('Sorry, there was an issue sending your enquiry. Please try again later.', 'sacco-php');
							$message_type = 'warning';
						}

						if ($message_text) {
							echo '<div class="alert alert-' . esc_attr($message_type) . ' mb-3" role="alert">' . $message_text . '</div>';
						}
					}
					?>
					<form id="productEnquiryForm" class="product-enquiry-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
						<input type="hidden" name="action" value="product_enquiry_submission">
						<input type="hidden" name="product_id" value="<?php echo esc_attr(get_the_ID()); ?>">
						<input type="hidden" name="product_title" value="<?php echo esc_attr(get_the_title()); ?>">
						<?php wp_nonce_field('product_enquiry_form_nonce', 'enquiry_nonce'); ?>

						<div class="mb-3">
							<label for="enquiryName" class="form-label">Your Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="enquiryName" name="enquiry_name" required>
						</div>
						<div class="mb-3">
							<label for="enquiryEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
							<input type="email" class="form-control" id="enquiryEmail" name="enquiry_email" required>
						</div>
						<div class="mb-3">
							<label for="enquiryPhone" class="form-label">Phone Number</label>
							<input type="tel" class="form-control" id="enquiryPhone" name="enquiry_phone">
						</div>
						<div class="mb-3">
							<label for="enquiryMessage" class="form-label">Your Message <span class="text-danger">*</span></label>
							<textarea class="form-control" id="enquiryMessage" name="enquiry_message" rows="4" required></textarea>
						</div>
						<button type="submit" class="btn btn-primary w-100">Submit Enquiry</button>
						<div class="form-status mt-3"></div> <!-- For AJAX messages -->
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Product Enquiry Success Feedback (Can be a modal or a dedicated section revealed by JS) -->
	<?php 
	if (isset($_GET['form_status']) && $_GET['form_status'] === 'success' && isset($_GET['modal_success']) && $_GET['modal_success'] === 'productEnquiryModal') : ?>
	<div class="modal fade" id="productEnquiryModalSuccess" tabindex="-1" aria-labelledby="productEnquiryModalSuccessLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-success text-white">
					<h5 class="modal-title" id="productEnquiryModalSuccessLabel">Enquiry Sent!</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-center">
					<p class="lead"><i class="fas fa-check-circle fa-3x text-success mb-3"></i></p>
					<p><?php esc_html_e('Thank you for your enquiry about ', 'sacco-php'); ?><strong><?php the_title(); ?></strong>.</p>
					<p><?php esc_html_e('We will get back to you shortly.', 'sacco-php'); ?></p>
					<button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			const urlParams = new URLSearchParams(window.location.search);
			if (urlParams.get('modal') === 'productEnquiryModal' && (urlParams.get('form_status') === 'error' || urlParams.get('form_status') === 'mail_error')) {
				const enquiryModal = new bootstrap.Modal(document.getElementById('productEnquiryModal'));
				enquiryModal.show();
			}
			if (urlParams.get('modal_success') === 'productEnquiryModal' && urlParams.get('form_status') === 'success'){
				 const successModal = new bootstrap.Modal(document.getElementById('productEnquiryModalSuccess'));
				 successModal.show();
			}
		});
	</script>
	<?php endif; ?>

</main><!-- #main -->

<?php
get_footer(); 