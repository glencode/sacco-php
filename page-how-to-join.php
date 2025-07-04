<?php
/**
 * Template Name: How to Join Page
 *
 * The template for displaying membership information and how to join.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/how-to-join.css?v=1.0">

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5 parallax-bg">
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
	
	<section class="join-intro-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<h2>Become a Member Today</h2>
					<p class="lead mb-4">Join our thriving community of members and access a wide range of financial services tailored to meet your needs.</p>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-eligibility-section py-5 bg-light">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">Membership Eligibility</h2>
					<p class="section-subtitle">Who can join our SACCO?</p>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="eligibility-icon mb-3 text-center">
								<i class="fas fa-user-tie fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Employed Individuals</h3>
							<ul class="eligibility-list">
								<li>Employees of registered companies or organizations</li>
								<li>Government employees</li>
								<li>Teachers and educational staff</li>
								<li>Healthcare workers</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="eligibility-icon mb-3 text-center">
								<i class="fas fa-store fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Business Owners</h3>
							<ul class="eligibility-list">
								<li>Registered small business owners</li>
								<li>Self-employed individuals</li>
								<li>Entrepreneurs with valid business permits</li>
								<li>Consultants and freelancers</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="eligibility-icon mb-3 text-center">
								<i class="fas fa-users fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Community Members</h3>
							<ul class="eligibility-list">
								<li>Residents of specified geographic areas</li>
								<li>Members of registered community groups</li>
								<li>Family members of existing SACCO members</li>
								<li>Retirees who meet our criteria</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-process-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">How to Join</h2>
					<p class="section-subtitle">Follow these simple steps to become a member</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="join-process">
						<!-- Step 1 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">
											<span>1</span>
										</div>
									</div>
									<div class="col-md-10">
										<h3>Download and Complete the Membership Application Form</h3>
										<p>Fill out the membership application form with your personal details, contact information, and employment/business information.</p>
										<a href="<?php echo esc_url(home_url('/downloads/membership-form/')); ?>" class="btn btn-primary">Download Form</a>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 2 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">
											<span>2</span>
										</div>
									</div>
									<div class="col-md-10">
										<h3>Gather Required Documents</h3>
										<p>Prepare the following documents:</p>
										<ul class="mb-0">
											<li>A copy of your National ID or Passport</li>
											<li>Recent passport-sized photo</li>
											<li>Proof of income (payslip, business financial statements)</li>
											<li>Proof of residence (utility bill, rental agreement)</li>
											<li>KRA PIN Certificate</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 3 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">
											<span>3</span>
										</div>
									</div>
									<div class="col-md-10">
										<h3>Pay Membership Fee and Initial Deposits</h3>
										<p>Make the following payments:</p>
										<ul class="mb-0">
											<li><strong>Registration Fee:</strong> KSh 1,000 (one-time, non-refundable)</li>
											<li><strong>Minimum Share Capital:</strong> KSh 5,000</li>
											<li><strong>Minimum Deposit:</strong> KSh 3,000</li>
										</ul>
										<p class="mt-3 mb-0"><em>Payments can be made via M-PESA or direct deposit to our bank account.</em></p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 4 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">
											<span>4</span>
										</div>
									</div>
									<div class="col-md-10">
										<h3>Submit Your Application</h3>
										<p>Submit your completed application form and all required documents:</p>
										<div class="row g-3 mt-2">
											<div class="col-md-4">
												<div class="submission-method p-3 border rounded text-center h-100">
													<i class="fas fa-building mb-2 text-primary"></i>
													<h4 class="h5">In Person</h4>
													<p class="mb-0 small">Visit our office during business hours</p>
												</div>
											</div>
											<div class="col-md-4">
												<div class="submission-method p-3 border rounded text-center h-100">
													<i class="fas fa-envelope mb-2 text-primary"></i>
													<h4 class="h5">By Email</h4>
													<p class="mb-0 small">Send scanned copies to membership@sacconame.co.ke</p>
												</div>
											</div>
											<div class="col-md-4">
												<div class="submission-method p-3 border rounded text-center h-100">
													<i class="fas fa-globe mb-2 text-primary"></i>
													<h4 class="h5">Online</h4>
													<p class="mb-0 small">Apply through our online registration portal</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 5 -->
						<div class="join-step card border-0 shadow-sm">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">
											<span>5</span>
										</div>
									</div>
									<div class="col-md-10">
										<h3>Application Review and Approval</h3>
										<p>Your application will be reviewed by our membership committee, and upon approval:</p>
										<ul class="mb-0">
											<li>You'll receive a membership certificate</li>
											<li>Your member account will be activated</li>
											<li>You'll get access to our member portal</li>
											<li>You'll be eligible for all member benefits and services</li>
										</ul>
										<p class="mt-3 mb-0"><em>The approval process typically takes 3-5 working days.</em></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; ?>
	
	<section class="join-benefits-section py-5 bg-light">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">Benefits of Membership</h2>
					<p class="section-subtitle">Enjoy these exclusive advantages as a member</p>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-hand-holding-usd fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Competitive Loan Rates</h3>
							<p class="card-text">Access loans at lower interest rates than most commercial banks with flexible repayment terms.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-chart-line fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Attractive Returns</h3>
							<p class="card-text">Earn competitive dividends on your shares and interest on your savings deposits.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-shield-alt fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Financial Security</h3>
							<p class="card-text">Member deposits are protected through prudent management and adherence to regulatory standards.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-graduation-cap fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Financial Education</h3>
							<p class="card-text">Access workshops, seminars, and resources to improve your financial literacy and management skills.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-mobile-alt fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Digital Banking</h3>
							<p class="card-text">Manage your accounts 24/7 through our modern digital banking platforms and mobile app.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-vote-yea fa-2x text-primary"></i>
							</div>
							<h3 class="card-title h4 text-center">Democratic Control</h3>
							<p class="card-text">Participate in the governance of the SACCO through voting rights at Annual General Meetings.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-faq-section py-5">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Frequently Asked Questions</h2>
					<p class="section-subtitle">Common questions about membership</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="accordion" id="joinFaqAccordion">
						<!-- FAQ Item 1 -->
						<div class="accordion-item border-0 shadow-sm mb-3">
							<h3 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									How long does the membership application process take?
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#joinFaqAccordion">
								<div class="accordion-body">
									The entire process typically takes 3-5 working days from submission of a complete application with all required documents. After approval, your membership becomes active immediately, and you can start accessing our services.
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 2 -->
						<div class="accordion-item border-0 shadow-sm mb-3">
							<h3 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Can I join if I'm self-employed?
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#joinFaqAccordion">
								<div class="accordion-body">
									Yes! Self-employed individuals are welcome to join our SACCO. You'll need to provide your business registration documents, financial statements, and other required documents as proof of income and business operation.
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 3 -->
						<div class="accordion-item border-0 shadow-sm mb-3">
							<h3 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									What's the difference between shares and deposits?
								</button>
							</h3>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#joinFaqAccordion">
								<div class="accordion-body">
									<p><strong>Shares:</strong> These represent your ownership in the SACCO. Shares earn dividends based on the SACCO's performance, which are declared annually. Shares are generally long-term investments and have withdrawal restrictions.</p>
									<p class="mb-0"><strong>Deposits:</strong> These are your savings in the SACCO. Deposits earn interest at predetermined rates and are more accessible for withdrawals, depending on the type of deposit account you hold.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 4 -->
						<div class="accordion-item border-0 shadow-sm mb-3">
							<h3 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									How soon can I apply for a loan after joining?
								</button>
							</h3>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#joinFaqAccordion">
								<div class="accordion-body">
									New members typically need to be active for at least 3-6 months before qualifying for major loans. However, some small emergency loans may be available earlier, depending on your contribution history and the specific loan product requirements.
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 5 -->
						<div class="accordion-item border-0 shadow-sm">
							<h3 class="accordion-header" id="headingFive">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									Can I manage my SACCO account online?
								</button>
							</h3>
							<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#joinFaqAccordion">
								<div class="accordion-body">
									Yes! Our SACCO provides a secure online member portal and mobile app where you can view your accounts, make deposit transactions, apply for loans, track loan repayments, and access various other services 24/7 from anywhere.
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-12 text-center">
					<p class="mb-4">Have more questions about joining our SACCO?</p>
					<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-outline-primary">Contact Us</a>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<h2 class="text-white">Ready to Join Our SACCO?</h2>
					<p class="lead mb-4">Take the first step toward your financial success by becoming a member today.</p>
					<a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-light me-2">Register Online</a>
					<a href="<?php echo esc_url(home_url('/downloads/membership-form/')); ?>" class="btn btn-outline-light">Download Application Form</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?>