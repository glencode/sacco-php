<?php
/**
 * The template for displaying single loan product
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sacco-php
 */

get_header();

// Get custom fields with fallback data
$interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '14% p.a.';
$max_amount = get_post_meta(get_the_ID(), 'maximum_amount', true) ?: 'KSh 1,000,000';
$min_amount = get_post_meta(get_the_ID(), 'minimum_amount', true) ?: 'KSh 50,000';
$loan_term = get_post_meta(get_the_ID(), 'loan_term', true) ?: 'Up to 48 months';
$processing_time = get_post_meta(get_the_ID(), 'processing_time', true) ?: '24-48 hours';
$processing_fee = get_post_meta(get_the_ID(), 'processing_fee', true) ?: '2% of loan amount';
$requirements = get_post_meta(get_the_ID(), 'requirements', true);
$insurance_partner = get_post_meta(get_the_ID(), '_insurance_partner_company', true);
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

	<section class="loan-detail-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="loan-detail-card">
						<div class="loan-detail-header">
							<div class="row align-items-center">
								<div class="col-md-8">
									<h2><?php the_title(); ?></h2>
									<p class="lead mb-0"><?php echo get_the_excerpt(); ?></p>
								</div>
								<div class="col-md-4">
									<div class="loan-rate-box">
										<div class="rate-title">Interest Rate</div>
										<div class="rate-value"><?php echo esc_html($interest_rate); ?></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="loan-detail-body">
							<div class="loan-features">
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
										if (strpos($title, 'personal') !== false) {
											echo '<li>Quick approval and disbursement</li>';
											echo '<li>Flexible repayment terms</li>';
											echo '<li>No collateral required for amounts up to KSh 500,000</li>';
											echo '<li>Competitive interest rates</li>';
											echo '<li>Early repayment option with no penalties</li>';
										} elseif (strpos($title, 'business') !== false) {
											echo '<li>Tailored for business expansion and operations</li>';
											echo '<li>Higher loan limits for established businesses</li>';
											echo '<li>Flexible collateral requirements</li>';
											echo '<li>Option for moratorium period</li>';
											echo '<li>Free business advisory services</li>';
										} elseif (strpos($title, 'emergency') !== false) {
											echo '<li>Same day processing</li>';
											echo '<li>Minimal documentation required</li>';
											echo '<li>Available to members with good credit history</li>';
											echo '<li>Quick disbursement</li>';
											echo '<li>Flexible repayment options</li>';
										} else {
											echo '<li>Competitive interest rates</li>';
											echo '<li>Flexible repayment terms</li>';
											echo '<li>Quick processing and approval</li>';
											echo '<li>Minimal documentation required</li>';
											echo '<li>No hidden charges or fees</li>';
										}
									}
									?>
								</ul>
							</div>
							
							<div class="loan-details">
								<h3>Loan Details</h3>
								<ul class="detail-list">
									<li>
										<span class="detail-label">Minimum Amount</span>
										<span class="detail-value"><?php echo esc_html($min_amount); ?></span>
									</li>
									<li>
										<span class="detail-label">Maximum Amount</span>
										<span class="detail-value"><?php echo esc_html($max_amount); ?></span>
									</li>
									<li>
										<span class="detail-label">Interest Rate</span>
										<span class="detail-value"><?php echo esc_html($interest_rate); ?></span>
									</li>
									<li>
										<span class="detail-label">Repayment Period</span>
										<span class="detail-value"><?php echo esc_html($loan_term); ?></span>
									</li>
									<li>
										<span class="detail-label">Processing Time</span>
										<span class="detail-value"><?php echo esc_html($processing_time); ?></span>
									</li>
									<li>
										<span class="detail-label">Processing Fee</span>
										<span class="detail-value"><?php echo esc_html($processing_fee); ?></span>
									</li>
									<?php if ($insurance_partner) : ?>
									<li>
										<span class="detail-label">Insurance Partner</span>
										<span class="detail-value"><?php echo esc_html($insurance_partner); ?></span>
									</li>
									<?php endif; ?>
								</ul>
							</div>
							
							<div class="loan-description">
								<h3>Full Description</h3>
								<?php the_content(); ?>
							</div>
							
							<div class="loan-eligibility mt-4">
								<h3>Eligibility Requirements</h3>
								<ul class="requirements-list">
									<?php
									if (!empty($requirements)) {
										$requirements_array = explode("\n", $requirements);
										foreach ($requirements_array as $requirement) {
											if (!empty(trim($requirement))) {
												echo '<li><i class="fas fa-check-circle"></i><span>' . esc_html(trim($requirement)) . '</span></li>';
											}
										}
									} else {
										// Fallback requirements
										echo '<li><i class="fas fa-check-circle"></i><span>Must be a registered member of Harambee SACCO for at least 3 months</span></li>';
										echo '<li><i class="fas fa-check-circle"></i><span>Must have regular savings with the SACCO</span></li>';
										echo '<li><i class="fas fa-check-circle"></i><span>Minimum monthly income of KSh 15,000</span></li>';
										echo '<li><i class="fas fa-check-circle"></i><span>Clear CRB record or evidence of debt settlement</span></li>';
										echo '<li><i class="fas fa-check-circle"></i><span>Must provide all required documentation</span></li>';
									}
									?>
								</ul>
							</div>
							
							<div class="loan-cta mt-4">
								<div class="row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-primary btn-lg w-100">Apply Now</a>
									</div>
									<div class="col-sm-6">
										<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-outline-primary btn-lg w-100">Calculate Repayment</a>
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
							<p>Estimate your repayments</p>
						</div>
						<div class="calculator-body">
							<form id="quick-calculator-form">
								<div class="mb-3">
									<label for="quick-amount" class="form-label">Loan Amount (KSh)</label>
									<input type="number" class="form-control" id="quick-amount" value="500000" min="0" step="10000">
								</div>
								
								<div class="mb-3">
									<label for="quick-term" class="form-label">Term (Months)</label>
									<select class="form-select" id="quick-term">
										<option value="12">12 months</option>
										<option value="24">24 months</option>
										<option value="36" selected>36 months</option>
										<option value="48">48 months</option>
										<option value="60">60 months</option>
									</select>
								</div>
								
								<div class="calculator-result">
									<div class="result-title">Monthly Repayment</div>
									<div class="result-value" id="quick-result">KSh 0.00</div>
								</div>
								
								<div class="text-center mt-3">
									<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-link">Advanced Calculator</a>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Related Loans -->
					<div class="related-loans">
						<h3 class="mb-4">Related Loans</h3>
						
						<?php
						// Get related loan products
						$related_loans = new WP_Query(array(
							'post_type' => 'loan',
							'posts_per_page' => 3,
							'post__not_in' => array(get_the_ID()),
							'orderby' => 'rand'
						));
						
						if ($related_loans->have_posts()) :
							while ($related_loans->have_posts()) : $related_loans->the_post();
								// Get custom fields
								$rel_interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '14% p.a.';
								$rel_max_amount = get_post_meta(get_the_ID(), 'maximum_amount', true) ?: 'KSh 1,000,000';
						?>
							<div class="related-loan-card mb-3">
								<h4><?php the_title(); ?></h4>
								<div class="loan-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value"><?php echo esc_html($rel_interest_rate); ?></div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Max. Amount</div>
										<div class="highlight-value"><?php echo esc_html($rel_max_amount); ?></div>
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
							<div class="related-loan-card mb-3">
								<h4>Personal Loan</h4>
								<div class="loan-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">14% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Max. Amount</div>
										<div class="highlight-value">KSh 1M</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
							
							<div class="related-loan-card mb-3">
								<h4>Emergency Loan</h4>
								<div class="loan-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">15% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Max. Amount</div>
										<div class="highlight-value">KSh 500K</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
							
							<div class="related-loan-card mb-3">
								<h4>Education Loan</h4>
								<div class="loan-highlights mb-3">
									<div class="highlight-item">
										<div class="highlight-label">Interest Rate</div>
										<div class="highlight-value">12% p.a.</div>
									</div>
									<div class="highlight-item">
										<div class="highlight-label">Max. Amount</div>
										<div class="highlight-value">KSh 800K</div>
									</div>
								</div>
								<a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
							</div>
						<?php endif; ?>
					</div>
					
					<!-- Required Documents -->
					<div class="documents-box mt-4">
						<h3>Required Documents</h3>
						<ul class="document-list">
							<li><i class="far fa-id-card"></i> Original ID and copy (front and back)</li>
							<li><i class="far fa-file-alt"></i> Recent payslips (3 months)</li>
							<li><i class="fas fa-file-invoice-dollar"></i> Bank statements (3 months)</li>
							<li><i class="far fa-images"></i> Passport-sized photographs (2)</li>
							<li><i class="far fa-file-pdf"></i> Filled loan application form</li>
							<li><i class="far fa-handshake"></i> Guarantor details and forms</li>
						</ul>
						<a href="<?php echo esc_url(home_url('/downloads/')); ?>" class="btn btn-outline-primary w-100 mt-3">Download Forms</a>
					</div>
					
					<!-- Need Help Box -->
					<div class="help-box mt-4">
						<h3>Need Help?</h3>
						<p>Contact our loan officers for assistance with your application or for more information about this loan product.</p>
						<div class="contact-info">
							<div class="contact-item">
								<i class="fas fa-phone-alt"></i>
								<span>+254 700 123 456</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-envelope"></i>
								<span>loans@harambeesacco.com</span>
							</div>
						</div>
						<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-primary w-100 mt-3">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="application-process bg-light py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center mb-4">
					<h2>Loan Application Process</h2>
					<p class="lead">Follow these simple steps to apply for your loan</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 mb-4">
					<div class="process-step h-100">
						<div class="step-number">1</div>
						<h3>Submit Application</h3>
						<p>Complete and submit the loan application form with all required documents.</p>
					</div>
				</div>
				<div class="col-md-3 mb-4">
					<div class="process-step h-100">
						<div class="step-number">2</div>
						<h3>Application Review</h3>
						<p>Our loan officers will review your application and may contact you for additional information.</p>
					</div>
				</div>
				<div class="col-md-3 mb-4">
					<div class="process-step h-100">
						<div class="step-number">3</div>
						<h3>Loan Approval</h3>
						<p>If approved, you'll be notified and asked to sign the loan agreement.</p>
					</div>
				</div>
				<div class="col-md-3 mb-4">
					<div class="process-step h-100">
						<div class="step-number">4</div>
						<h3>Disbursement</h3>
						<p>The approved funds will be disbursed to your account within 24-48 hours.</p>
					</div>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-12 text-center">
					<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-primary btn-lg">Apply For This Loan</a>
				</div>
			</div>
		</div>
	</section>

	<section class="cta-section bg-primary text-white py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2>Ready to Apply for This Loan?</h2>
					<p class="mb-0">Get started with your loan application today and take a step closer to achieving your financial goals.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-light btn-lg">Apply Now</a>
					<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-outline-light btn-lg ms-2">Calculate</a>
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
		const quickAmount = document.getElementById('quick-amount');
		const quickTerm = document.getElementById('quick-term');
		const quickResult = document.getElementById('quick-result');
		
		// Get interest rate from the page
		const interestRateText = document.querySelector('.rate-value').textContent;
		const interestRate = parseFloat(interestRateText.replace(/[^0-9.]/g, '')) / 100;
		
		// Calculate function
		function calculateRepayment() {
			const amount = parseFloat(quickAmount.value) || 0;
			const months = parseInt(quickTerm.value) || 36;
			const monthlyRate = interestRate / 12;
			
			// Calculate monthly payment using PMT formula
			let monthlyPayment;
			if (monthlyRate === 0) {
				monthlyPayment = amount / months;
			} else {
				monthlyPayment = (amount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));
			}
			
			// Format and display result
			quickResult.textContent = `KSh ${monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
		}
		
		// Add event listeners
		quickAmount.addEventListener('input', calculateRepayment);
		quickTerm.addEventListener('change', calculateRepayment);
		
		// Initial calculation
		calculateRepayment();
	});
</script>

<style>
	/* Process Step Cards */
	.process-step {
		background-color: #fff;
		padding: 25px 20px;
		border-radius: 10px;
		text-align: center;
		box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
		transition: all 0.3s ease;
		height: 100%;
	}
	
	.process-step:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
	}
	
	.process-step .step-number {
		width: 50px;
		height: 50px;
		line-height: 50px;
		border-radius: 50%;
		background-color: #5ca157;
		color: #fff;
		font-size: 1.5rem;
		font-weight: 600;
		margin: 0 auto 15px;
	}
	
	.process-step h3 {
		font-size: 1.2rem;
		margin-bottom: 15px;
		color: #2c3624;
	}
	
	.process-step p {
		color: #6c757d;
		margin-bottom: 0;
	}
	
	/* Document List */
	.document-list {
		list-style: none;
		padding-left: 0;
		margin-bottom: 0;
	}
	
	.document-list li {
		padding: 10px 0;
		border-bottom: 1px dashed #e9ecef;
		display: flex;
		align-items: center;
	}
	
	.document-list li:last-child {
		border-bottom: none;
	}
	
	.document-list li i {
		color: #5ca157;
		margin-right: 10px;
		font-size: 1.1rem;
		width: 20px;
	}
	
	/* Documents Box */
	.documents-box {
		background-color: #f8f9fa;
		border-radius: 10px;
		padding: 20px;
	}
	
	.documents-box h3 {
		font-size: 1.3rem;
		color: #2c3624;
		margin-bottom: 15px;
	}
</style>

<?php
get_footer(); 