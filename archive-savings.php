<?php
/**
 * The template for displaying savings products archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-primary text-white py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title">Savings Products</h1>
					<p class="lead">Explore our range of savings products designed to help you achieve your financial goals.</p>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs text-white">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="savings-overview py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center">
					<h2 class="section-title">Why Save With Us?</h2>
					<p class="section-description">Our savings products offer competitive interest rates, flexible terms, and secure management of your funds.</p>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-percentage"></i>
						</div>
						<h3>Competitive Returns</h3>
						<p>Enjoy competitive interest rates that help your money grow faster than traditional banking options.</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-shield-alt"></i>
						</div>
						<h3>Secure & Protected</h3>
						<p>Your savings are protected by the SACCO Deposit Guarantee Fund for peace of mind.</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-hand-holding-usd"></i>
						</div>
						<h3>Easy Access</h3>
						<p>Access your funds when you need them with our flexible withdrawal options and online banking.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="savings-products py-5">
		<div class="container">
			<!-- Filter Categories -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="category-filter text-center">
						<button class="filter-btn active" data-filter="all">All Products</button>
						<?php
						$savings_categories = get_terms(array(
							'taxonomy' => 'savings_category',
							'hide_empty' => true,
						));
						
						if (!empty($savings_categories) && !is_wp_error($savings_categories)) {
							foreach ($savings_categories as $category) {
								echo '<button class="filter-btn" data-filter="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
							}
						}
						?>
					</div>
				</div>
			</div>
			
			<!-- Products Grid -->
			<div class="row product-grid">
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); 
						// Get product categories
						$product_categories = get_the_terms(get_the_ID(), 'savings_category');
						$category_classes = '';
						if (!empty($product_categories) && !is_wp_error($product_categories)) {
							foreach ($product_categories as $category) {
								$category_classes .= ' ' . $category->slug;
							}
						}
						
						// Get custom fields (using fallback data if not set)
						$interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '5%';
						$min_deposit = get_post_meta(get_the_ID(), 'minimum_deposit', true) ?: 'KSh 1,000';
						$term = get_post_meta(get_the_ID(), 'term', true) ?: 'Flexible';
					?>
						<div class="col-lg-4 col-md-6 mb-4 product-item<?php echo esc_attr($category_classes); ?>">
							<div class="product-card h-100">
								<?php if (has_post_thumbnail()) : ?>
									<div class="product-image">
										<?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
									</div>
								<?php endif; ?>
								<div class="product-body">
									<h3 class="product-title"><?php the_title(); ?></h3>
									
									<div class="product-highlights">
										<div class="highlight-item">
											<div class="highlight-label">Interest Rate</div>
											<div class="highlight-value"><?php echo esc_html($interest_rate); ?></div>
										</div>
										<div class="highlight-item">
											<div class="highlight-label">Minimum Deposit</div>
											<div class="highlight-value"><?php echo esc_html($min_deposit); ?></div>
										</div>
										<div class="highlight-item">
											<div class="highlight-label">Term</div>
											<div class="highlight-value"><?php echo esc_html($term); ?></div>
										</div>
									</div>
									
									<div class="product-excerpt">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="product-actions">
										<a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
										<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					
					<!-- Pagination -->
					<div class="col-12">
						<div class="pagination-container">
							<?php 
							echo paginate_links(array(
								'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
								'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
							)); 
							?>
						</div>
					</div>
					
				<?php else : ?>
					<div class="col-12">
						<div class="no-products">
							<p>No savings products found. Please check back later.</p>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	
	<!-- Fallback static data if no products are created yet -->
	<?php if (!have_posts()) : ?>
		<section class="savings-products py-5">
			<div class="container">
				<div class="row product-grid">
					<!-- Regular Savings Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Regular Savings" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Regular Savings Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">3% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 1,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Flexible</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Our Regular Savings Account offers easy access to your funds while earning competitive interest. Perfect for everyday savings and emergency funds.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Premium Savings Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Premium Savings" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Premium Savings Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">5% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 10,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Flexible</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Enjoy higher interest rates with our Premium Savings Account. Designed for medium-term goals with better returns than regular savings.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Fixed Deposit Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Fixed Deposit" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Fixed Deposit Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">7% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 50,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">1 Year</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Maximize returns with our Fixed Deposit Account. Lock in your money for a fixed period to earn higher interest rates.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Holiday Savings Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Holiday Savings" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Holiday Savings Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">6% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 5,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">1 Year</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Save for your next vacation with our Holiday Savings Account. Make regular contributions and access your funds when you're ready for your holiday.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Children's Savings Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Children's Savings" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Children's Savings Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">5.5% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 2,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Until 18 years</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Start saving for your child's future with our dedicated Children's Savings Account. Great for education planning and teaching financial responsibility.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Retirement Savings Account -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="product-card h-100">
							<div class="product-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Retirement Savings" class="img-fluid">
							</div>
							<div class="product-body">
								<h3 class="product-title">Retirement Savings Account</h3>
								
								<div class="product-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">8% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Minimum Deposit</div>
										<div class="highlight-value">KSh 5,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Long-term</div>
									</div>
								</div>
								
								<div class="product-excerpt">
									<p>Plan for a comfortable retirement with our specialized Retirement Savings Account. Enjoy tax benefits and higher interest rates for long-term savings.</p>
								</div>
								
								<div class="product-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary">Calculate Returns</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
	
	<section class="cta-section bg-primary text-white py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2>Ready to Start Saving?</h2>
					<p class="mb-0">Open an account today and start your journey to financial security with our competitive savings products.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-light btn-lg">Contact Us</a>
					<a href="<?php echo esc_url(home_url('/member-portal/')); ?>" class="btn btn-outline-light btn-lg ms-2">Join Now</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Category filter functionality
		const filterButtons = document.querySelectorAll('.filter-btn');
		const productItems = document.querySelectorAll('.product-item');
		
		filterButtons.forEach(button => {
			button.addEventListener('click', function() {
				// Remove active class from all buttons
				filterButtons.forEach(btn => btn.classList.remove('active'));
				
				// Add active class to clicked button
				this.classList.add('active');
				
				// Get filter value
				const filterValue = this.getAttribute('data-filter');
				
				// Show/hide products based on filter
				productItems.forEach(item => {
					if (filterValue === 'all') {
						item.style.display = 'block';
					} else {
						if (item.classList.contains(filterValue)) {
							item.style.display = 'block';
						} else {
							item.style.display = 'none';
						}
					}
				});
			});
		});
	});
</script>

<?php
get_footer(); 