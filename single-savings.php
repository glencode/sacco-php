<?php
/**
 * The template for displaying single savings product
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sacco-php
 */

get_header();

// Get custom fields with fallback data
$interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '5%';
$min_deposit = get_post_meta(get_the_ID(), 'minimum_deposit', true) ?: 'KSh 1,000';
$term = get_post_meta(get_the_ID(), 'term', true) ?: 'Flexible';
$withdrawal_terms = get_post_meta(get_the_ID(), 'withdrawal_terms', true) ?: 'Withdraw anytime';
$target_audience = get_post_meta(get_the_ID(), 'target_audience', true) ?: 'All members';
$age_limit = get_post_meta(get_the_ID(), '_age_limit', true);
?>

<!-- Table of Contents -->
<?php get_template_part('template-parts/content/table-of-contents'); ?>

<main id="primary" class="site-main">

	<?php while (have_posts()) : the_post(); ?>

	<section class="page-header bg-primary text-white py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs text-white">','</p>' );
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
					<div class="product-detail-card">
						<div class="product-detail-header">
							<div class="row align-items-center">
								<div class="col-md-8">
									<h2><?php the_title(); ?></h2>
									<p class="lead mb-0"><?php echo get_the_excerpt(); ?></p>
								</div>
								<div class="col-md-4">
									<div class="product-rate-box">
										<div class="rate-title">Interest Rate</div>
										<div class="rate-value"><?php echo esc_html($interest_rate); ?></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="product-detail-body">
							<div class="product-features">
								<h3>Key Features & Benefits</h3>
								<ul>
									<?php
									// Get features from custom field or use fallback
									$features = get_post_meta(get_the_ID(), 'features', true);
									if (!empty($features)) {
										$features_array = explode("\n", $features);
										foreach ($features_array as $feature) {
											if (!empty(trim($feature))) {
												echo '<li>' . esc_html(trim($feature)) . '</li>';
											}
										}
									} else {
										// Fallback features based on title
										$title = strtolower(get_the_title());
										if (strpos($title, 'regular') !== false) {
											echo '<li>Easy access to your funds</li>';
											echo '<li>No minimum balance requirements</li>';
											echo '<li>Competitive interest rates</li>';
											echo '<li>No monthly maintenance fees</li>';
											echo '<li>Free online and mobile banking</li>';
										} elseif (strpos($title, 'fixed') !== false || strpos($title, 'term') !== false) {
											echo '<li>Higher fixed interest rates</li>';
											echo '<li>Choice of term periods</li>';
											echo '<li>Interest paid on maturity or monthly</li>';
											echo '<li>Option to auto-renew</li>';
											echo '<li>Secure investment for planned expenses</li>';
										} elseif (strpos($title, 'children') !== false || strpos($title, 'junior') !== false) {
											echo '<li>Special interest rates for children</li>';
											echo '<li>Develops saving habits early</li>';
											echo '<li>Perfect for education planning</li>';
											echo '<li>Flexible deposits</li>';
											echo '<li>No maintenance fees</li>';
										} else {
											echo '<li>Competitive interest rates</li>';
											echo '<li>Flexible withdrawal terms</li>';
											echo '<li>No hidden fees</li>';
											echo '<li>Easy account management</li>';
											echo '<li>Personalized savings advice</li>';
										}
									}
									?>
								</ul>
							</div>
							
							<div class="product-details">
								<h3>Account Details</h3>
								<ul class="detail-list">
									<li>
										<span class="detail-label">Minimum Opening Deposit</span>
										<span class="detail-value"><?php echo esc_html($min_deposit); ?></span>
									</li>
									<li>
										<span class="detail-label">Interest Rate</span>
										<span class="detail-value"><?php echo esc_html($interest_rate); ?></span>
									</li>
									<li>
										<span class="detail-label">Term Period</span>
										<span class="detail-value"><?php echo esc_html($term); ?></span>
									</li>
									<li>
										<span class="detail-label">Withdrawal Terms</span>
										<span class="detail-value"><?php echo esc_html($withdrawal_terms); ?></span>
									</li>
									<li>
										<span class="detail-label">Target Audience</span>
										<span class="detail-value"><?php echo esc_html($target_audience); ?></span>
									</li>
									<?php if ($age_limit) : ?>
									<li>
										<span class="detail-label">Age Limit</span>
										<span class="detail-value"><?php echo esc_html($age_limit); ?></span>
									</li>
									<?php endif; ?>
									<li>
										<span class="detail-label">Interest Calculation</span>
										<span class="detail-value">Daily, paid monthly</span>
									</li>
								</ul>
							</div>
							
							<div class="product-description">
								<h3>Full Description</h3>
								<?php the_content(); ?>
							</div>
							
							<div class="product-cta mt-4">
								<div class="row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<a href="<?php echo esc_url(home_url('/member-portal/')); ?>" class="btn btn-primary btn-lg w-100">Open Account</a>
									</div>
									<div class="col-sm-6">
										<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary btn-lg w-100">Calculate Returns</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 mt-4 mt-lg-0">
					<!-- Calculator Widget -->
					<div class="calculator-widget mb-4">
						<div class="calculator-header">
							<h3>Quick Calculator</h3>
							<p>Estimate your returns</p>
						</div>
						<div class="calculator-body">
							<form id="quick-calculator-form">
								<div class="mb-3">
									<label for="quick-deposit" class="form-label">Initial Deposit (KSh)</label>
									<input type="number" class="form-control" id="quick-deposit" value="10000" min="0" step="1000">
								</div>
								
								<div class="mb-3">
									<label for="quick-monthly" class="form-label">Monthly Addition (KSh)</label>
									<input type="number" class="form-control" id="quick-monthly" value="2000" min="0" step="500">
								</div>
								
								<div class="mb-3">
									<label for="quick-years" class="form-label">Years</label>
									<select class="form-select" id="quick-years">
										<option value="1">1 Year</option>
										<option value="3" selected>3 Years</option>
										<option value="5">5 Years</option>
										<option value="10">10 Years</option>
									</select>
								</div>
								
								<div class="calculator-result">
									<div class="result-title">Estimated Final Balance</div>
									<div class="result-value" id="quick-result">KSh 0.00</div>
								</div>
								
								<div class="text-center mt-3">
									<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-link">Advanced Calculator</a>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Related Products -->
					<div class="related-products">
						<h3 class="mb-4">Related Products</h3>
						
						<?php
						// Get related savings products
						$related_products = new WP_Query(array(
							'post_type' => 'savings',
							'posts_per_page' => 3,
							'post__not_in' => array(get_the_ID()),
							'orderby' => 'rand'
						));
						
						if ($related_products->have_posts()) :
							while ($related_products->have_posts()) : $related_products->the_post();
								// Get custom fields
								$rel_interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '5%';
								$rel_min_deposit = get_post_meta(get_the_ID(), 'minimum_deposit', true) ?: 'KSh 1,000';
						?>
							<div class="related-product-card mb-3">
								<h4><?php the_title(); ?></h4>
								<div class="product-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value"><?php echo esc_html($rel_interest_rate); ?></div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Min. Deposit</div>
										<div class="highlight-value"><?php echo esc_html($rel_min_deposit); ?></div>
									</div>
								</div>
								<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
						<?php
							endwhile;
							wp_reset_postdata();
						else:
							// Fallback static data
						?>
							<div class="related-product-card mb-3">
								<h4>Regular Savings Account</h4>
								<div class="product-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">3% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Min. Deposit</div>
										<div class="highlight-value">KSh 1,000</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
							
							<div class="related-product-card mb-3">
								<h4>Fixed Deposit Account</h4>
								<div class="product-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">7% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Min. Deposit</div>
										<div class="highlight-value">KSh 50,000</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
							
							<div class="related-product-card mb-3">
								<h4>Junior Savings Account</h4>
								<div class="product-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">5.5% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Min. Deposit</div>
										<div class="highlight-value">KSh 2,000</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
						<?php endif; ?>
					</div>
					
					<!-- Need Help Box -->
					<div class="help-box mt-4">
						<h3>Need Help?</h3>
						<p>Contact our customer service team for assistance with opening a savings account or for more information.</p>
						<div class="contact-info">
							<div class="contact-item">
								<i class="fas fa-phone-alt"></i>
								<span>+254 700 123 456</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-envelope"></i>
								<span>savings@harambeesacco.com</span>
							</div>
						</div>
						<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-primary w-100 mt-3">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</section>

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

	<!-- FAQ Section -->
	<?php get_template_part('template-parts/content/faq-section'); ?>

	<?php endwhile; ?>

</main><!-- #main -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Quick calculator
		const quickCalculatorForm = document.getElementById('quick-calculator-form');
		const quickDeposit = document.getElementById('quick-deposit');
		const quickMonthly = document.getElementById('quick-monthly');
		const quickYears = document.getElementById('quick-years');
		const quickResult = document.getElementById('quick-result');
		
		// Get interest rate from the page
		const interestRateText = document.querySelector('.rate-value').textContent;
		const interestRate = parseFloat(interestRateText.replace(/[^0-9.]/g, '')) / 100;
		
		// Calculate function
		function calculateReturns() {
			const deposit = parseFloat(quickDeposit.value) || 0;
			const monthly = parseFloat(quickMonthly.value) || 0;
			const years = parseInt(quickYears.value) || 1;
			
			// Simple calculation for quick estimate
			let balance = deposit;
			const months = years * 12;
			
			for (let i = 0; i < months; i++) {
				balance += monthly;
				balance += balance * (interestRate / 12);
			}
			
			// Format and display result
			quickResult.textContent = `KSh ${balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
		}
		
		// Add event listeners
		quickDeposit.addEventListener('input', calculateReturns);
		quickMonthly.addEventListener('input', calculateReturns);
		quickYears.addEventListener('change', calculateReturns);
		
		// Initial calculation
		calculateReturns();
	});
</script>

<style>
	/* Related Products */
	.related-product-card {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
		padding: 15px;
		transition: all 0.3s ease;
	}
	
	.related-product-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
	}
	
	.related-product-card h4 {
		font-size: 1.1rem;
		margin-bottom: 10px;
		color: #2c3624;
	}
	
	/* Calculator Widget */
	.calculator-widget {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
		overflow: hidden;
	}
	
	.calculator-widget .calculator-header {
		background-color: #5ca157;
		color: #fff;
		padding: 20px;
		text-align: center;
	}
	
	.calculator-widget .calculator-header h3 {
		margin-bottom: 5px;
		color: #fff;
	}
	
	.calculator-widget .calculator-header p {
		margin-bottom: 0;
		opacity: 0.9;
	}
	
	.calculator-widget .calculator-body {
		padding: 20px;
	}
	
	/* Help Box */
	.help-box {
		background-color: #f8f9fa;
		border-radius: 10px;
		padding: 20px;
	}
	
	.help-box h3 {
		font-size: 1.3rem;
		color: #2c3624;
		margin-bottom: 15px;
	}
	
	.contact-info {
		margin: 15px 0;
	}
	
	.contact-item {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
	}
	
	.contact-item i {
		width: 20px;
		color: #5ca157;
		margin-right: 10px;
	}
</style>

<?php
get_footer(); 