<?php
/**
 * The template for displaying product archive
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
					<h1 class="page-title">
						<?php 
						if (is_tax('product_category')) {
							single_term_title('Products: ');
						} else {
							echo 'Our Products';
						}
						?>
					</h1>
					<?php
					if (function_exists('yoast_breadcrumb')) {
						yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>');
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url()); ?>">Home</a> &gt; 
							<?php
							if (is_tax('product_category')) {
								echo '<a href="' . esc_url(get_post_type_archive_link('product')) . '">Products</a> &gt; ';
								single_term_title();
							} else {
								echo 'Products';
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

	<section class="products-archive-section py-5">
		<div class="container">
			<div class="row">
				<!-- Sidebar with Categories -->
				<div class="col-lg-3 mb-4">
					<div class="product-sidebar">
						<div class="card">
							<div class="card-header bg-primary text-white">
								<h4 class="mb-0">Product Categories</h4>
							</div>
							<div class="card-body">
								<ul class="product-categories-list">
									<?php
									$terms = get_terms(array(
										'taxonomy' => 'product_category',
										'hide_empty' => true,
									));
									
									if (!empty($terms) && !is_wp_error($terms)) {
										foreach ($terms as $term) {
											$active_class = '';
											if (is_tax('product_category', $term->slug)) {
												$active_class = 'active';
											}
											echo '<li class="' . $active_class . '"><a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a></li>';
										}
									} else {
										echo '<li>No categories found</li>';
									}
									?>
								</ul>
							</div>
						</div>
						
						<!-- Contact Box -->
						<div class="card mt-4">
							<div class="card-header bg-light">
								<h4 class="mb-0">Need Assistance?</h4>
							</div>
							<div class="card-body">
								<p>Contact our team for personalized guidance on our products.</p>
								<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Contact Us</a>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Products Grid -->
				<div class="col-lg-9">
					<?php if (have_posts()) : ?>
					
					<!-- Optional Intro Text for Category -->
					<?php if (is_tax('product_category') && term_description()) : ?>
					<div class="category-description mb-4">
						<?php echo term_description(); ?>
					</div>
					<?php endif; ?>
					
					<div class="row">
						<?php
						/* Start the Loop */
						while (have_posts()) :
							the_post();
							
							// Get product image
							$product_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
							if (!$product_img) {
								$product_img = get_template_directory_uri() . '/img/default-product.jpg';
							}
						?>
						<div class="col-md-6 col-lg-4 mb-4">
							<div class="product-card">
								<div class="product-image">
									<img src="<?php echo esc_url($product_img); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
								</div>
								<div class="product-content">
									<h3 class="product-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="product-excerpt">
										<?php the_excerpt(); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>
					
					<div class="pagination-container mt-4">
						<?php
						$pagination = get_the_posts_pagination(array(
							'mid_size' => 2,
							'prev_text' => '<i class="fas fa-angle-left"></i> Previous',
							'next_text' => 'Next <i class="fas fa-angle-right"></i>',
							'screen_reader_text' => ' ',
							'class' => 'pagination-links',
						));
						
						// Output pagination with Bootstrap styling
						echo str_replace(
							array('<nav class="navigation pagination"', 'class="nav-links"', 'class="page-numbers current"', 'class="page-numbers"', 'class="next page-numbers"', 'class="prev page-numbers"'), 
							array('<nav class="navigation pagination" aria-label="Products"', 'class="pagination mb-0 justify-content-center"', 'class="page-link current"', 'class="page-link"', 'class="page-link next"', 'class="page-link prev"'),
							$pagination
						);
						?>
					</div>
					
					<?php else : ?>
						<div class="no-products-found text-center">
							<h3>No Products Found</h3>
							<p>Sorry, no products are available at this time. Please check back later.</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 