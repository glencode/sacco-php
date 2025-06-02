<?php
/**
 * The template for displaying loan products archive
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
					<h1 class="page-title">Loan Products</h1>
					<p class="lead">Explore our range of loan products designed to meet your financial needs.</p>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs text-white">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="loans-overview py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center">
					<h2 class="section-title">Why Choose Our Loans?</h2>
					<p class="section-description">Our loan products offer competitive interest rates, flexible repayment terms, and quick processing to help you achieve your goals.</p>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-percentage"></i>
						</div>
						<h3>Competitive Rates</h3>
						<p>Enjoy some of the lowest interest rates in the market, with options tailored to your financial situation.</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-bolt"></i>
						</div>
						<h3>Quick Processing</h3>
						<p>Get your loan approved and disbursed within 24-48 hours of submitting a complete application.</p>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-handshake"></i>
						</div>
						<h3>Flexible Terms</h3>
						<p>Choose from flexible repayment periods and options that suit your income and financial goals.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="loan-products py-5">
		<div class="container">
			<!-- Filter Categories -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="category-filter text-center">
						<button class="filter-btn active" data-filter="all">All Products</button>
						<?php
						$loan_categories = get_terms(array(
							'taxonomy' => 'loan_category',
							'hide_empty' => true,
						));
						
						if (!empty($loan_categories) && !is_wp_error($loan_categories)) {
							foreach ($loan_categories as $category) {
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
						$product_categories = get_the_terms(get_the_ID(), 'loan_category');
						$category_classes = '';
						if (!empty($product_categories) && !is_wp_error($product_categories)) {
							foreach ($product_categories as $category) {
								$category_classes .= ' ' . $category->slug;
							}
						}
						
						// Get custom fields (using fallback data if not set)
						$interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '14% p.a.';
						$max_amount = get_post_meta(get_the_ID(), 'maximum_amount', true) ?: 'KSh 1,000,000';
						$term = get_post_meta(get_the_ID(), 'loan_term', true) ?: 'Up to 48 months';
						$badge = get_post_meta(get_the_ID(), 'loan_badge', true) ?: '';
					?>
						<div class="col-lg-4 col-md-6 mb-4 product-item<?php echo esc_attr($category_classes); ?>">
							<div class="loan-card h-100">
								<?php if (!empty($badge)) : ?>
									<div class="loan-badge"><?php echo esc_html($badge); ?></div>
								<?php endif; ?>
								
								<?php if (has_post_thumbnail()) : ?>
									<div class="loan-image">
										<?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
									</div>
								<?php endif; ?>
								<div class="loan-body">
									<h3 class="loan-title"><?php the_title(); ?></h3>
									
									<div class="loan-highlights">
										<div class="highlight-item">
											<div class="highlight-label">Interest Rate</div>
											<div class="highlight-value"><?php echo esc_html($interest_rate); ?></div>
										</div>
										<div class="highlight-item">
											<div class="highlight-label">Maximum Amount</div>
											<div class="highlight-value"><?php echo esc_html($max_amount); ?></div>
										</div>
										<div class="highlight-item">
											<div class="highlight-label">Term</div>
											<div class="highlight-value"><?php echo esc_html($term); ?></div>
										</div>
									</div>
									
									<div class="loan-excerpt">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="loan-actions">
										<a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
										<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
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
							<p>No loan products found. Please check back later.</p>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	
	<!-- Fallback static data if no products are created yet -->
	<?php if (!have_posts()) : ?>
		<section class="loan-products py-5">
			<div class="container">
				<div class="row product-grid">
					<!-- Personal Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-badge">Popular</div>
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Personal Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Personal Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">14% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 1,000,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 48 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Meet your personal financial needs with our flexible personal loans. Perfect for emergencies, education, medical expenses, or home improvements.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Business Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Business Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Business Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">16% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 3,000,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 60 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Grow your business with our affordable business financing options. Ideal for expanding operations, purchasing inventory, or managing cash flow.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Emergency Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-badge">Quick Approval</div>
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Emergency Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Emergency Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">15% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 500,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 24 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Quick access to funds when you need them most. Our emergency loans are processed within 24 hours to help you handle unexpected financial needs.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Education Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Education Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Education Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">12% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 800,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 36 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Invest in education with our specially designed education loans. Cover tuition fees, learning materials, and other educational expenses for yourself or your children.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Home Improvement Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Home Improvement Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Home Improvement Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">13% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 2,000,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 60 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Transform your home with our home improvement loans. Finance renovations, repairs, extensions, and upgrades to create your dream living space.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Vehicle Loan -->
					<div class="col-lg-4 col-md-6 mb-4">
						<div class="loan-card h-100">
							<div class="loan-badge">Low Rate</div>
							<div class="loan-image">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.jpg" alt="Vehicle Loan" class="img-fluid">
							</div>
							<div class="loan-body">
								<h3 class="loan-title">Vehicle Loan</h3>
								
								<div class="loan-highlights">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">11% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Maximum Amount</div>
										<div class="highlight-value">KSh 3,500,000</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Term</div>
										<div class="highlight-value">Up to 60 months</div>
									</div>
								</div>
								
								<div class="loan-excerpt">
									<p>Get on the road with our competitive vehicle loans. Finance the purchase of new or used vehicles with flexible repayment terms and quick processing.</p>
								</div>
								
								<div class="loan-actions">
									<a href="#" class="btn btn-primary">View Details</a>
									<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-outline-primary">Apply Now</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
	
	<section class="loan-calculator-promo bg-light py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<h2>Calculate Your Loan Repayment</h2>
					<p>Use our loan calculator to estimate your monthly repayments and total interest payments. Plan your finances better with accurate calculations.</p>
					<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-primary">Try Loan Calculator</a>
				</div>
				<div class="col-lg-6">
					<div class="calculator-preview">
						<div class="calculator-header">
							<h3>Loan Calculator</h3>
						</div>
						<div class="calculator-body">
							<div class="form-group mb-3">
								<label for="loan-amount">Loan Amount (KSh)</label>
								<input type="text" class="form-control" id="loan-amount" value="500,000" disabled>
							</div>
							<div class="form-group mb-3">
								<label for="loan-term">Term (months)</label>
								<input type="text" class="form-control" id="loan-term" value="36" disabled>
							</div>
							<div class="form-group mb-3">
								<label for="interest-rate">Interest Rate (%)</label>
								<input type="text" class="form-control" id="interest-rate" value="14%" disabled>
							</div>
							<div class="calculator-result">
								<div class="result-title">Monthly Payment</div>
								<div class="result-value">KSh 17,020</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="cta-section bg-primary text-white py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2>Ready to Apply for a Loan?</h2>
					<p class="mb-0">Take the first step towards achieving your financial goals. Our application process is quick and convenient.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-light btn-lg">Apply Now</a>
					<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
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