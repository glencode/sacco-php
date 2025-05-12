<?php
/**
 * Template Name: Loan Details Page
 *
 * The template for displaying details of a specific loan product.
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
	
	<section class="loan-overview-section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="loan-overview-content">
						<?php the_content(); ?>
						
						<?php
						// Define loan details with fallback values
						$loan_interest = get_post_meta(get_the_ID(), 'loan_interest', true) ?: '14% p.a.';
						$loan_amount = get_post_meta(get_the_ID(), 'loan_amount', true) ?: 'Up to 3 times shares';
						$loan_term = get_post_meta(get_the_ID(), 'loan_term', true) ?: '12 - 48 months';
						$processing_time = get_post_meta(get_the_ID(), 'processing_time', true) ?: '3-5 business days';
						$processing_fee = get_post_meta(get_the_ID(), 'processing_fee', true) ?: '2% of loan amount';
						?>
						
						<div class="loan-key-features mt-4">
							<h3>Key Features</h3>
							<div class="row g-3">
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Interest Rate</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($loan_interest); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Loan Amount</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($loan_amount); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Repayment Period</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($loan_term); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Processing Time</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($processing_time); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="loan-overview-image">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow-sm' ) ); ?>
						</div>
					<?php else : ?>
						<div class="loan-overview-image">
							<img src="<?php echo get_template_directory_uri(); ?>/img/loan-placeholder.jpg" alt="<?php the_title(); ?>" class="img-fluid rounded shadow-sm">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="loan-details-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="loan-tabs">
						<ul class="nav nav-pills mb-4" id="loanDetailsTabs" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="eligibility-tab" data-bs-toggle="pill" data-bs-target="#eligibility" type="button" role="tab" aria-controls="eligibility" aria-selected="true">Eligibility</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="requirements-tab" data-bs-toggle="pill" data-bs-target="#requirements" type="button" role="tab" aria-controls="requirements" aria-selected="false">Requirements</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="process-tab" data-bs-toggle="pill" data-bs-target="#process" type="button" role="tab" aria-controls="process" aria-selected="false">Application Process</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="terms-tab" data-bs-toggle="pill" data-bs-target="#terms" type="button" role="tab" aria-controls="terms" aria-selected="false">Terms & Conditions</button>
							</li>
						</ul>
						<div class="tab-content p-4 bg-white rounded shadow-sm" id="loanDetailsTabContent">
							<div class="tab-pane fade show active" id="eligibility" role="tabpanel" aria-labelledby="eligibility-tab">
								<?php 
								$eligibility = get_post_meta(get_the_ID(), 'eligibility', true);
								if (!empty($eligibility)) {
									echo wp_kses_post($eligibility);
								} else {
								?>
									<h3>Eligibility Criteria</h3>
									<p>To qualify for this loan, you must meet the following criteria:</p>
									<ul>
										<li>Be a registered member of the SACCO for at least 6 months</li>
										<li>Have regular savings contributions for at least 3 months</li>
										<li>Have a minimum share capital of KSh 20,000</li>
										<li>Have a good credit history with the SACCO and other financial institutions</li>
										<li>Have the capacity to repay the loan through salary or business income</li>
										<li>Have suitable guarantors who are SACCO members</li>
									</ul>
								<?php } ?>
							</div>
							<div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
								<?php 
								$requirements = get_post_meta(get_the_ID(), 'requirements', true);
								if (!empty($requirements)) {
									echo wp_kses_post($requirements);
								} else {
								?>
									<h3>Required Documents</h3>
									<p>Please submit the following documents with your loan application:</p>
									<ul>
										<li>Completed loan application form</li>
										<li>Copy of national ID or passport</li>
										<li>Recent passport-sized photograph</li>
										<li>Last 3 months' pay slips (for employed members)</li>
										<li>Business financial statements (for business owners)</li>
										<li>Bank statements for the last 6 months</li>
										<li>Proof of any additional income</li>
										<li>Guarantor forms signed by at least 2 SACCO members</li>
									</ul>
								<?php } ?>
							</div>
							<div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="process-tab">
								<?php 
								$process = get_post_meta(get_the_ID(), 'process', true);
								if (!empty($process)) {
									echo wp_kses_post($process);
								} else {
								?>
									<h3>Application Process</h3>
									<div class="application-process">
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</span>
											</div>
											<div class="step-content">
												<h4>Complete Application Form</h4>
												<p>Download and fill out the loan application form with all required details.</p>
											</div>
										</div>
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">2</span>
											</div>
											<div class="step-content">
												<h4>Gather Required Documents</h4>
												<p>Collect all necessary supporting documents as per the requirements list.</p>
											</div>
										</div>
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">3</span>
											</div>
											<div class="step-content">
												<h4>Get Guarantors</h4>
												<p>Secure at least two SACCO members to guarantee your loan.</p>
											</div>
										</div>
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">4</span>
											</div>
											<div class="step-content">
												<h4>Submit Application</h4>
												<p>Submit your application and documents to our office or via our online portal.</p>
											</div>
										</div>
										<div class="process-step d-flex">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">5</span>
											</div>
											<div class="step-content">
												<h4>Approval Process</h4>
												<p>Your application will be reviewed, and if approved, funds will be disbursed to your account.</p>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
							<div class="tab-pane fade" id="terms" role="tabpanel" aria-labelledby="terms-tab">
								<?php 
								$terms = get_post_meta(get_the_ID(), 'terms', true);
								if (!empty($terms)) {
									echo wp_kses_post($terms);
								} else {
								?>
									<h3>Terms & Conditions</h3>
									<ol>
										<li><strong>Interest Rate:</strong> 14% per annum on reducing balance</li>
										<li><strong>Processing Fee:</strong> 2% of the loan amount (non-refundable)</li>
										<li><strong>Insurance:</strong> 1% of the loan amount for loan protection</li>
										<li><strong>Repayment:</strong> Through check-off system, standing order, or direct deposits</li>
										<li><strong>Security:</strong> Shares, deposits, and guarantors</li>
										<li><strong>Early Repayment:</strong> Allowed without penalty</li>
										<li><strong>Default:</strong> In case of default, your shares, deposits, and guarantors' shares may be used to recover the outstanding balance</li>
										<li><strong>Loan Limit:</strong> Maximum 3 times your total shares and deposits</li>
										<li><strong>Term:</strong> 12 to 48 months depending on loan amount and repayment capacity</li>
									</ol>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="loan-sidebar">
						<!-- Loan Calculator Widget -->
						<div class="calculator-widget card border-0 shadow-sm mb-4">
							<div class="card-header bg-primary text-white py-3">
								<h3 class="card-title h5 mb-0">Loan Calculator</h3>
							</div>
							<div class="card-body">
								<form id="mini-loan-calculator" class="mini-calculator">
									<div class="mb-3">
										<label for="loanAmount" class="form-label">Loan Amount (KSh)</label>
										<input type="number" class="form-control" id="loanAmount" min="10000" step="10000" value="100000">
									</div>
									<div class="mb-3">
										<label for="loanTerm" class="form-label">Loan Term (months)</label>
										<input type="number" class="form-control" id="loanTerm" min="12" max="48" step="12" value="24">
									</div>
									<div class="mb-3">
										<label for="interestRate" class="form-label">Interest Rate (%)</label>
										<input type="number" class="form-control" id="interestRate" min="10" max="20" step="0.5" value="<?php echo esc_attr(str_replace('%', '', str_replace(' p.a.', '', $loan_interest))); ?>">
									</div>
									<button type="button" id="calculateLoan" class="btn btn-primary w-100">Calculate</button>
								</form>
								
								<div class="calculation-results mt-4" style="display: none;">
									<h4 class="h6 mb-3">Monthly Repayment:</h4>
									<p class="h3 text-primary mb-3" id="monthlyPayment">KSh 0</p>
									
									<div class="row">
										<div class="col-6">
											<p class="mb-1 small">Total Interest:</p>
											<p class="fw-bold" id="totalInterest">KSh 0</p>
										</div>
										<div class="col-6">
											<p class="mb-1 small">Total Repayment:</p>
											<p class="fw-bold" id="totalRepayment">KSh 0</p>
										</div>
									</div>
									
									<div class="text-center mt-3">
										<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-outline-primary btn-sm">Advanced Calculator</a>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Apply Now Card -->
						<div class="apply-card card border-0 shadow-sm mb-4">
							<div class="card-body text-center p-4">
								<h3 class="card-title h5 mb-3">Ready to Apply?</h3>
								<p class="card-text mb-4">Download the application form or apply online to get started.</p>
								<a href="<?php echo esc_url(home_url('/downloads/loan-application/')); ?>" class="btn btn-primary mb-2 w-100">Download Application Form</a>
								<a href="<?php echo esc_url(home_url('/apply-online/')); ?>" class="btn btn-outline-primary w-100">Apply Online</a>
							</div>
						</div>
						
						<!-- Need Help Card -->
						<div class="help-card card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<h3 class="card-title h5 mb-3">Need Help?</h3>
								<div class="contact-option d-flex align-items-center mb-3">
									<div class="icon me-3">
										<i class="fas fa-phone-alt fa-lg text-primary"></i>
									</div>
									<div class="contact-info">
										<p class="mb-0 small">Call our loan officers</p>
										<p class="mb-0 fw-bold">+254 700 000 000</p>
									</div>
								</div>
								<div class="contact-option d-flex align-items-center mb-3">
									<div class="icon me-3">
										<i class="fas fa-envelope fa-lg text-primary"></i>
									</div>
									<div class="contact-info">
										<p class="mb-0 small">Email us</p>
										<p class="mb-0 fw-bold">loans@sacconame.co.ke</p>
									</div>
								</div>
								<div class="contact-option d-flex align-items-center">
									<div class="icon me-3">
										<i class="fas fa-comments fa-lg text-primary"></i>
									</div>
									<div class="contact-info">
										<p class="mb-0 small">Live chat</p>
										<button class="btn btn-sm btn-outline-primary mt-1">Start Chat</button>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Related Products -->
						<div class="related-products card border-0 shadow-sm">
							<div class="card-header bg-light py-3">
								<h3 class="card-title h5 mb-0">Related Loan Products</h3>
							</div>
							<div class="card-body p-0">
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-hand-holding-usd text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Emergency Loan</h4>
												<p class="small mb-0 text-muted">Quick funds for urgent needs</p>
											</div>
										</a>
									</li>
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-home text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Mortgage Loan</h4>
												<p class="small mb-0 text-muted">Finance your dream home</p>
											</div>
										</a>
									</li>
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-graduation-cap text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Education Loan</h4>
												<p class="small mb-0 text-muted">Invest in your future</p>
											</div>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; ?>
	
	<section class="loan-faqs-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2>Frequently Asked Questions</h2>
					<p class="lead">Find answers to common questions about our <?php the_title(); ?></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="accordion" id="loanFaqAccordion">
						<!-- FAQ Item 1 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									What are the eligibility requirements for this loan?
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#loanFaqAccordion">
								<div class="accordion-body">
									<p>Eligibility requirements typically include being an active SACCO member for at least 6 months, having regular savings contributions, sufficient share capital, and a good credit history. The specific requirements may vary depending on the loan amount and your financial situation.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 2 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									How long does the loan application process take?
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#loanFaqAccordion">
								<div class="accordion-body">
									<p>The standard processing time is 3-5 business days from submission of a complete application with all required documentation. In some cases, it might take longer if additional information or verification is needed.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 3 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Can I pay off my loan early?
								</button>
							</h3>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#loanFaqAccordion">
								<div class="accordion-body">
									<p>Yes, you can make early repayments or fully settle your loan before the end of the term. We encourage early repayment and do not charge early repayment penalties. This can help you save on interest costs over the life of the loan.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 4 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									How many guarantors do I need for this loan?
								</button>
							</h3>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#loanFaqAccordion">
								<div class="accordion-body">
									<p>Typically, you'll need at least two guarantors who are active SACCO members. The exact number may depend on the loan amount and your credit history. Guarantors should have sufficient shares to cover the guaranteed amount and must be willing to sign the guarantee forms.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 5 -->
						<div class="accordion-item border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFive">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									What happens if I miss a loan payment?
								</button>
							</h3>
							<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#loanFaqAccordion">
								<div class="accordion-body">
									<p>If you miss a loan payment, a late payment fee will be charged, and the loan will accrue additional interest. Continued missed payments may lead to debt recovery actions, including the use of your shares, deposits, or guarantors' shares to recover the outstanding balance. It's important to contact the SACCO immediately if you anticipate difficulty making a payment.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-5">
				<div class="col-lg-12 text-center">
					<p class="mb-4">Have more questions about our loans?</p>
					<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-outline-primary">Contact Our Loan Officers</a>
				</div>
			</div>
		</div>
	</section>
	
	<section class="loan-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2 class="text-white">Ready to Apply?</h2>
					<p class="lead mb-0">Take the first step toward achieving your financial goals with our <?php the_title(); ?>.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/apply-online/')); ?>" class="btn btn-light btn-lg">Apply Now</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple loan calculator functionality
    const calculateLoanBtn = document.getElementById('calculateLoan');
    const calculationResults = document.querySelector('.calculation-results');
    
    if (calculateLoanBtn) {
        calculateLoanBtn.addEventListener('click', function() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value);
            const loanTerm = parseInt(document.getElementById('loanTerm').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value);
            
            if (!isNaN(loanAmount) && !isNaN(loanTerm) && !isNaN(interestRate)) {
                // Calculate monthly payments
                const monthlyRate = interestRate / 100 / 12;
                const monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
                const totalPayment = monthlyPayment * loanTerm;
                const totalInterest = totalPayment - loanAmount;
                
                // Display results
                document.getElementById('monthlyPayment').textContent = 'KSh ' + monthlyPayment.toFixed(2);
                document.getElementById('totalInterest').textContent = 'KSh ' + totalInterest.toFixed(2);
                document.getElementById('totalRepayment').textContent = 'KSh ' + totalPayment.toFixed(2);
                
                calculationResults.style.display = 'block';
            }
        });
    }
});
</script>

<?php
get_footer(); 
?> 