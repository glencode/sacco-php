<?php
/**
 * Template Name: Savings Details Page
 *
 * The template for displaying details of a specific savings product.
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
	
	<section class="savings-overview-section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="savings-overview-content">
						<?php the_content(); ?>
						
						<?php
						// Define savings details with fallback values
						$interest_rate = get_post_meta(get_the_ID(), 'interest_rate', true) ?: '6% p.a.';
						$min_deposit = get_post_meta(get_the_ID(), 'minimum_deposit', true) ?: 'KSh 1,000';
						$term = get_post_meta(get_the_ID(), 'term', true) ?: 'Flexible';
						$withdrawal_terms = get_post_meta(get_the_ID(), 'withdrawal_terms', true) ?: 'Anytime with notice';
						$target_audience = get_post_meta(get_the_ID(), 'target_audience', true) ?: 'All members';
						?>
						
						<div class="savings-key-features mt-4">
							<h3>Key Features</h3>
							<div class="row g-3">
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Interest Rate</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($interest_rate); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Minimum Deposit</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($min_deposit); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Term</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($term); ?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="feature-card p-3 border rounded bg-white">
										<h4 class="h6 text-primary mb-1">Withdrawal Terms</h4>
										<p class="mb-0 fw-bold"><?php echo esc_html($withdrawal_terms); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="savings-overview-image">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow-sm' ) ); ?>
						</div>
					<?php else : ?>
						<div class="savings-overview-image">
							<img src="<?php echo get_template_directory_uri(); ?>/img/savings-placeholder.jpg" alt="<?php the_title(); ?>" class="img-fluid rounded shadow-sm">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="savings-details-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="savings-tabs">
						<ul class="nav nav-pills mb-4" id="savingsDetailsTabs" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="benefits-tab" data-bs-toggle="pill" data-bs-target="#benefits" type="button" role="tab" aria-controls="benefits" aria-selected="true">Benefits</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="requirements-tab" data-bs-toggle="pill" data-bs-target="#requirements" type="button" role="tab" aria-controls="requirements" aria-selected="false">Requirements</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="process-tab" data-bs-toggle="pill" data-bs-target="#process" type="button" role="tab" aria-controls="process" aria-selected="false">Account Opening</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="terms-tab" data-bs-toggle="pill" data-bs-target="#terms" type="button" role="tab" aria-controls="terms" aria-selected="false">Terms & Conditions</button>
							</li>
						</ul>
						<div class="tab-content p-4 bg-white rounded shadow-sm" id="savingsDetailsTabContent">
							<div class="tab-pane fade show active" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
								<?php 
								$benefits = get_post_meta(get_the_ID(), 'benefits', true);
								if (!empty($benefits)) {
									echo wp_kses_post($benefits);
								} else {
								?>
									<h3>Benefits of this Savings Product</h3>
									<ul class="feature-list mb-0">
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Competitive Interest Rates:</strong> Earn higher returns on your savings compared to traditional bank accounts.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Flexible Deposits:</strong> Add funds at your convenience, with options for automatic deposits from your salary.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Safety and Security:</strong> Your savings are secured by the SACCO's adherence to regulatory requirements.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Low Fees:</strong> Minimal account maintenance fees to maximize your returns.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Access to Loans:</strong> Build a savings history that qualifies you for higher loan limits.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Goal-based Saving:</strong> Create and track specific financial goals with our digital tools.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Financial Education:</strong> Access to workshops and resources to improve your financial literacy.</li>
										<li><i class="fas fa-check-circle text-primary me-2"></i> <strong>Regular Statements:</strong> Track your progress with monthly electronic statements.</li>
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
									<h3>Account Opening Requirements</h3>
									<p>To open this savings account, you will need:</p>
									<ul>
										<li>SACCO membership (new members must complete the membership application first)</li>
										<li>Completed savings account opening form</li>
										<li>Original and copy of your National ID or Passport</li>
										<li>Two recent passport-sized photographs</li>
										<li>Proof of address (utility bill, lease agreement, etc.)</li>
										<li>KRA PIN Certificate</li>
										<li>Initial deposit of at least <?php echo esc_html($min_deposit); ?></li>
									</ul>
									<?php if ($target_audience != 'All members') : ?>
										<div class="alert alert-info mt-3">
											<strong>Note:</strong> This account is specifically designed for <?php echo esc_html($target_audience); ?>.
										</div>
									<?php endif; ?>
								<?php } ?>
							</div>
							<div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="process-tab">
								<?php 
								$process = get_post_meta(get_the_ID(), 'process', true);
								if (!empty($process)) {
									echo wp_kses_post($process);
								} else {
								?>
									<h3>Account Opening Process</h3>
									<div class="application-process">
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</span>
											</div>
											<div class="step-content">
												<h4>Complete Application Form</h4>
												<p>Download and fill out the account opening form with all required details.</p>
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
												<h4>Submit Application</h4>
												<p>Visit our office or apply online through the member portal.</p>
											</div>
										</div>
										<div class="process-step d-flex mb-4">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">4</span>
											</div>
											<div class="step-content">
												<h4>Make Initial Deposit</h4>
												<p>Make your first deposit to activate the account.</p>
											</div>
										</div>
										<div class="process-step d-flex">
											<div class="step-number me-3">
												<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">5</span>
											</div>
											<div class="step-content">
												<h4>Account Activation</h4>
												<p>Your account will be activated, and you'll receive your account details.</p>
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
										<li><strong>Interest Calculation:</strong> Interest is calculated on a daily basis and credited to the account monthly.</li>
										<li><strong>Minimum Balance:</strong> A minimum balance of <?php echo esc_html($min_deposit); ?> must be maintained in the account.</li>
										<li><strong>Withdrawals:</strong> <?php echo esc_html($withdrawal_terms); ?></li>
										<li><strong>Account Maintenance:</strong> A small fee of KSh 100 may be charged quarterly for account maintenance.</li>
										<li><strong>Statements:</strong> Electronic statements are provided monthly at no cost. Paper statements may incur a small fee.</li>
										<li><strong>Dormant Accounts:</strong> Accounts with no activity for 12 months will be classified as dormant and may incur additional fees.</li>
										<li><strong>Account Closure:</strong> The account may be closed at any time by submitting a written request.</li>
										<li><strong>Tax:</strong> Interest earned may be subject to withholding tax as per government regulations.</li>
										<li><strong>Rate Changes:</strong> Interest rates are subject to change based on market conditions and regulatory changes.</li>
									</ol>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="savings-sidebar">
						<!-- Savings Calculator Widget -->
						<div class="calculator-widget card border-0 shadow-sm mb-4">
							<div class="card-header bg-primary text-white py-3">
								<h3 class="card-title h5 mb-0">Savings Calculator</h3>
							</div>
							<div class="card-body">
								<form id="mini-savings-calculator" class="mini-calculator">
									<div class="mb-3">
										<label for="initialDeposit" class="form-label">Initial Deposit (KSh)</label>
										<input type="number" class="form-control" id="initialDeposit" min="1000" step="1000" value="10000">
									</div>
									<div class="mb-3">
										<label for="monthlyContribution" class="form-label">Monthly Contribution (KSh)</label>
										<input type="number" class="form-control" id="monthlyContribution" min="0" step="500" value="1000">
									</div>
									<div class="mb-3">
										<label for="savingsTerm" class="form-label">Saving Period (years)</label>
										<input type="number" class="form-control" id="savingsTerm" min="1" max="30" step="1" value="5">
									</div>
									<div class="mb-3">
										<label for="savingsRate" class="form-label">Interest Rate (%)</label>
										<input type="number" class="form-control" id="savingsRate" min="1" max="15" step="0.5" value="<?php echo esc_attr(str_replace('%', '', str_replace(' p.a.', '', $interest_rate))); ?>">
									</div>
									<button type="button" id="calculateSavings" class="btn btn-primary w-100">Calculate</button>
								</form>
								
								<div class="calculation-results mt-4" style="display: none;">
									<h4 class="h6 mb-3">Final Balance:</h4>
									<p class="h3 text-primary mb-3" id="finalBalance">KSh 0</p>
									
									<div class="row">
										<div class="col-6">
											<p class="mb-1 small">Total Deposits:</p>
											<p class="fw-bold" id="totalDeposits">KSh 0</p>
										</div>
										<div class="col-6">
											<p class="mb-1 small">Interest Earned:</p>
											<p class="fw-bold" id="interestEarned">KSh 0</p>
										</div>
									</div>
									
									<div class="text-center mt-3">
										<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary btn-sm">Advanced Calculator</a>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Open Account Card -->
						<div class="open-account-card card border-0 shadow-sm mb-4">
							<div class="card-body text-center p-4">
								<h3 class="card-title h5 mb-3">Ready to Start Saving?</h3>
								<p class="card-text mb-4">Open your account today or talk to our savings advisors.</p>
								<a href="<?php echo esc_url(home_url('/downloads/savings-account-form/')); ?>" class="btn btn-primary mb-2 w-100">Download Account Form</a>
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
										<p class="mb-0 small">Call our savings advisors</p>
										<p class="mb-0 fw-bold">+254 700 000 000</p>
									</div>
								</div>
								<div class="contact-option d-flex align-items-center mb-3">
									<div class="icon me-3">
										<i class="fas fa-envelope fa-lg text-primary"></i>
									</div>
									<div class="contact-info">
										<p class="mb-0 small">Email us</p>
										<p class="mb-0 fw-bold">savings@sacconame.co.ke</p>
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
								<h3 class="card-title h5 mb-0">Related Savings Products</h3>
							</div>
							<div class="card-body p-0">
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-piggy-bank text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Fixed Deposit Account</h4>
												<p class="small mb-0 text-muted">Higher returns on fixed terms</p>
											</div>
										</a>
									</li>
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-graduation-cap text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Education Savings Plan</h4>
												<p class="small mb-0 text-muted">Save for your children's education</p>
											</div>
										</a>
									</li>
									<li class="list-group-item">
										<a href="#" class="d-flex text-decoration-none text-dark">
											<div class="me-3">
												<i class="fas fa-home text-primary"></i>
											</div>
											<div>
												<h4 class="h6 mb-1">Housing Savings Plan</h4>
												<p class="small mb-0 text-muted">Save towards home ownership</p>
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
	
	<section class="savings-comparison-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2>How Our Savings Compare</h2>
					<p class="lead">See how our <?php the_title(); ?> compares to other options</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="table-responsive">
						<table class="table comparison-table bg-white border">
							<thead class="bg-primary text-white">
								<tr>
									<th scope="col">Features</th>
									<th scope="col" class="text-center"><?php the_title(); ?></th>
									<th scope="col" class="text-center">Commercial Bank Savings</th>
									<th scope="col" class="text-center">Money Market Fund</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Interest Rate</th>
									<td class="text-center text-success"><?php echo esc_html($interest_rate); ?></td>
									<td class="text-center">2-3% p.a.</td>
									<td class="text-center">7-9% p.a.</td>
								</tr>
								<tr>
									<th scope="row">Minimum Balance</th>
									<td class="text-center"><?php echo esc_html($min_deposit); ?></td>
									<td class="text-center">KSh 1,000 - 5,000</td>
									<td class="text-center">KSh 5,000 - 10,000</td>
								</tr>
								<tr>
									<th scope="row">Account Fees</th>
									<td class="text-center text-success">Minimal</td>
									<td class="text-center">Monthly ledger fees</td>
									<td class="text-center">Management fee</td>
								</tr>
								<tr>
									<th scope="row">Withdrawal Restrictions</th>
									<td class="text-center"><?php echo esc_html($withdrawal_terms); ?></td>
									<td class="text-center">Limited withdrawals</td>
									<td class="text-center">1-3 days processing</td>
								</tr>
								<tr>
									<th scope="row">Access to Loans</th>
									<td class="text-center text-success">Yes, based on savings</td>
									<td class="text-center">Limited relationship</td>
									<td class="text-center">No</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="savings-faqs-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2>Frequently Asked Questions</h2>
					<p class="lead">Find answers to common questions about our <?php the_title(); ?></p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="accordion" id="savingsFaqAccordion">
						<!-- FAQ Item 1 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									How is interest calculated on this account?
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#savingsFaqAccordion">
								<div class="accordion-body">
									<p>Interest is calculated on a daily basis on the minimum monthly balance and credited to your account on a monthly basis. The current interest rate is <?php echo esc_html($interest_rate); ?>, which may be adjusted based on market conditions.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 2 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									How can I deposit funds into my account?
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#savingsFaqAccordion">
								<div class="accordion-body">
									<p>You can deposit funds into your account through several convenient methods:</p>
									<ul>
										<li>Direct deposit at any of our SACCO branches</li>
										<li>Mobile money transfer (M-PESA, Airtel Money)</li>
										<li>Bank transfer to our SACCO account</li>
										<li>Automatic deduction from your salary (check-off system)</li>
										<li>Through our mobile banking app and online banking platform</li>
									</ul>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 3 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									What happens if I need to withdraw my savings before the term ends?
								</button>
							</h3>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#savingsFaqAccordion">
								<div class="accordion-body">
									<p><?php echo esc_html($withdrawal_terms); ?>. Early withdrawals may be subject to a notice period or a small fee depending on the amount and timing. For emergency situations, we offer flexible options to ensure you can access your funds when needed.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 4 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									Can I have multiple savings accounts?
								</button>
							</h3>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#savingsFaqAccordion">
								<div class="accordion-body">
									<p>Yes, you can open multiple savings accounts for different purposes. This can help you organize your finances and save for specific goals separately. Each account will have its own account number and statement, making it easier to track your progress toward different financial objectives.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 5 -->
						<div class="accordion-item border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFive">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									Is my money safe with the SACCO?
								</button>
							</h3>
							<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#savingsFaqAccordion">
								<div class="accordion-body">
									<p>Yes, your savings are secure with our SACCO. We are regulated by the SACCO Societies Regulatory Authority (SASRA) and maintain strict compliance with all regulatory requirements. Additionally, we have robust internal controls and risk management systems in place to ensure the safety of members' funds. Our SACCO is also covered by the Deposit Guarantee Fund, providing additional protection for your savings.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-5">
				<div class="col-lg-12 text-center">
					<p class="mb-4">Have more questions about our savings accounts?</p>
					<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-outline-primary">Contact Our Savings Advisors</a>
				</div>
			</div>
		</div>
	</section>
	
	<section class="savings-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2 class="text-white">Start Growing Your Savings Today</h2>
					<p class="lead mb-0">Open a <?php the_title(); ?> and take the first step towards achieving your financial goals.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/apply-online/')); ?>" class="btn btn-light btn-lg">Open Account Now</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple savings calculator functionality
    const calculateSavingsBtn = document.getElementById('calculateSavings');
    const calculationResults = document.querySelector('.calculation-results');
    
    if (calculateSavingsBtn) {
        calculateSavingsBtn.addEventListener('click', function() {
            const initialDeposit = parseFloat(document.getElementById('initialDeposit').value);
            const monthlyContribution = parseFloat(document.getElementById('monthlyContribution').value);
            const savingsTerm = parseInt(document.getElementById('savingsTerm').value);
            const savingsRate = parseFloat(document.getElementById('savingsRate').value);
            
            if (!isNaN(initialDeposit) && !isNaN(monthlyContribution) && !isNaN(savingsTerm) && !isNaN(savingsRate)) {
                // Convert annual rate to monthly
                const monthlyRate = savingsRate / 100 / 12;
                const months = savingsTerm * 12;
                
                // Calculate final balance with compound interest
                let balance = initialDeposit;
                for (let i = 0; i < months; i++) {
                    balance += monthlyContribution;
                    balance *= (1 + monthlyRate);
                }
                
                const totalDeposits = initialDeposit + (monthlyContribution * months);
                const interestEarned = balance - totalDeposits;
                
                // Display results
                document.getElementById('finalBalance').textContent = 'KSh ' + balance.toFixed(2);
                document.getElementById('totalDeposits').textContent = 'KSh ' + totalDeposits.toFixed(2);
                document.getElementById('interestEarned').textContent = 'KSh ' + interestEarned.toFixed(2);
                
                calculationResults.style.display = 'block';
            }
        });
    }
});
</script>

<?php
get_footer(); 
?> 