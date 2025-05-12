<?php
/**
 * Template Name: Registration Page
 *
 * The template for displaying the member registration page.
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

	<section class="registration-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="registration-card">
						<div class="registration-header">
							<h2>Create Your Account</h2>
							<p>Join Harambee SACCO today and start your journey to financial success.</p>
						</div>
						
						<div class="registration-body">
							<?php
							// Check for errors
							if (isset($_GET['register_error'])) {
								$error = urldecode($_GET['register_error']);
								echo '<div class="alert alert-danger">' . esc_html($error) . '</div>';
							}
							
							// Check for success
							if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
								echo '<div class="alert alert-success">Registration successful! Please check your email for verification instructions.</div>';
							}
							?>
							
							<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" id="register-form" class="needs-validation" novalidate>
								<input type="hidden" name="action" value="sacco_register">
								<?php wp_nonce_field('sacco_register', 'sacco_register_nonce'); ?>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Account Information</h3>
									</div>
									<div class="col-md-6 mb-3">
										<label for="username" class="form-label">Username*</label>
										<input type="text" class="form-control" id="username" name="username" required>
										<div class="invalid-feedback">Please choose a username.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email" class="form-label">Email Address*</label>
										<input type="email" class="form-control" id="email" name="email" required>
										<div class="invalid-feedback">Please enter a valid email address.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="password" class="form-label">Password*</label>
										<input type="password" class="form-control" id="password" name="password" minlength="8" required>
										<div class="invalid-feedback">Password must be at least 8 characters.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="confirm_password" class="form-label">Confirm Password*</label>
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
										<div class="invalid-feedback">Passwords do not match.</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Personal Information</h3>
									</div>
									<div class="col-md-6 mb-3">
										<label for="first_name" class="form-label">First Name*</label>
										<input type="text" class="form-control" id="first_name" name="first_name" required>
										<div class="invalid-feedback">Please enter your first name.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="last_name" class="form-label">Last Name*</label>
										<input type="text" class="form-control" id="last_name" name="last_name" required>
										<div class="invalid-feedback">Please enter your last name.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="id_number" class="form-label">ID Number*</label>
										<input type="text" class="form-control" id="id_number" name="id_number" required>
										<div class="invalid-feedback">Please enter your ID number.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="phone" class="form-label">Phone Number*</label>
										<input type="tel" class="form-control" id="phone" name="phone" required>
										<div class="invalid-feedback">Please enter your phone number.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="date_of_birth" class="form-label">Date of Birth*</label>
										<input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
										<div class="invalid-feedback">Please enter your date of birth.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="gender" class="form-label">Gender*</label>
										<select class="form-select" id="gender" name="gender" required>
											<option value="">Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
											<option value="other">Other</option>
										</select>
										<div class="invalid-feedback">Please select your gender.</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Contact Information</h3>
									</div>
									<div class="col-md-12 mb-3">
										<label for="address" class="form-label">Physical Address*</label>
										<input type="text" class="form-control" id="address" name="address" required>
										<div class="invalid-feedback">Please enter your address.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="city" class="form-label">City/Town*</label>
										<input type="text" class="form-control" id="city" name="city" required>
										<div class="invalid-feedback">Please enter your city/town.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="postal_code" class="form-label">Postal Code*</label>
										<input type="text" class="form-control" id="postal_code" name="postal_code" required>
										<div class="invalid-feedback">Please enter your postal code.</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Employment Information</h3>
									</div>
									<div class="col-md-6 mb-3">
										<label for="employment_status" class="form-label">Employment Status*</label>
										<select class="form-select" id="employment_status" name="employment_status" required>
											<option value="">Select Status</option>
											<option value="full-time">Full-time Employed</option>
											<option value="part-time">Part-time Employed</option>
											<option value="self-employed">Self-Employed</option>
											<option value="business-owner">Business Owner</option>
											<option value="unemployed">Unemployed</option>
											<option value="retired">Retired</option>
										</select>
										<div class="invalid-feedback">Please select your employment status.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="employer" class="form-label">Employer Name</label>
										<input type="text" class="form-control" id="employer" name="employer">
										<small class="text-muted">Required for employed applicants</small>
									</div>
									<div class="col-md-6 mb-3">
										<label for="occupation" class="form-label">Occupation/Position</label>
										<input type="text" class="form-control" id="occupation" name="occupation">
									</div>
									<div class="col-md-6 mb-3">
										<label for="monthly_income" class="form-label">Monthly Income (KSh)</label>
										<input type="number" class="form-control" id="monthly_income" name="monthly_income">
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Next of Kin</h3>
									</div>
									<div class="col-md-6 mb-3">
										<label for="kin_name" class="form-label">Full Name*</label>
										<input type="text" class="form-control" id="kin_name" name="kin_name" required>
										<div class="invalid-feedback">Please enter your next of kin's name.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="kin_relationship" class="form-label">Relationship*</label>
										<input type="text" class="form-control" id="kin_relationship" name="kin_relationship" required>
										<div class="invalid-feedback">Please enter your relationship.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="kin_phone" class="form-label">Phone Number*</label>
										<input type="tel" class="form-control" id="kin_phone" name="kin_phone" required>
										<div class="invalid-feedback">Please enter your next of kin's phone number.</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="kin_email" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="kin_email" name="kin_email">
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h3 class="section-title">Membership Type</h3>
									</div>
									<div class="col-md-12">
										<div class="form-check mb-3">
											<input class="form-check-input" type="radio" name="membership_type" id="regular_membership" value="regular" checked>
											<label class="form-check-label" for="regular_membership">
												<strong>Regular Membership</strong>
												<p class="text-muted">For individuals seeking to save and access loans. Monthly contribution: KSh 1,000</p>
											</label>
										</div>
										<div class="form-check mb-3">
											<input class="form-check-input" type="radio" name="membership_type" id="business_membership" value="business">
											<label class="form-check-label" for="business_membership">
												<strong>Business Membership</strong>
												<p class="text-muted">For business owners seeking financing options. Monthly contribution: KSh 2,000</p>
											</label>
										</div>
										<div class="form-check mb-3">
											<input class="form-check-input" type="radio" name="membership_type" id="premium_membership" value="premium">
											<label class="form-check-label" for="premium_membership">
												<strong>Premium Membership</strong>
												<p class="text-muted">For individuals seeking enhanced benefits and priority service. Monthly contribution: KSh 5,000</p>
											</label>
										</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-12">
										<div class="form-check mb-3">
											<input class="form-check-input" type="checkbox" id="terms_agree" name="terms_agree" required>
											<label class="form-check-label" for="terms_agree">
												I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> of Harambee SACCO*
											</label>
											<div class="invalid-feedback">
												You must agree to the terms and conditions to proceed.
											</div>
										</div>
										<div class="form-check mb-3">
											<input class="form-check-input" type="checkbox" id="privacy_agree" name="privacy_agree" required>
											<label class="form-check-label" for="privacy_agree">
												I consent to the processing of my personal data as per the <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>*
											</label>
											<div class="invalid-feedback">
												You must agree to the privacy policy to proceed.
											</div>
										</div>
										<div class="form-check mb-3">
											<input class="form-check-input" type="checkbox" id="marketing_agree" name="marketing_agree">
											<label class="form-check-label" for="marketing_agree">
												I agree to receive marketing communications about products, services, and promotions from Harambee SACCO
											</label>
										</div>
									</div>
								</div>
								
								<div class="g-recaptcha mb-4" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
								
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-lg px-5">Register</button>
								</div>
							</form>
							
							<div class="mt-4 text-center">
								<p>Already have an account? <a href="<?php echo esc_url(home_url('/login/')); ?>">Login here</a></p>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 mt-4 mt-lg-0">
					<div class="sidebar-card mb-4">
						<h3>Membership Benefits</h3>
						<ul class="benefits-list">
							<li>
								<i class="fas fa-piggy-bank"></i>
								<span>Competitive Interest Rates on Savings</span>
							</li>
							<li>
								<i class="fas fa-hand-holding-usd"></i>
								<span>Access to Affordable Loans</span>
							</li>
							<li>
								<i class="fas fa-users"></i>
								<span>Dividends Based on Shareholding</span>
							</li>
							<li>
								<i class="fas fa-graduation-cap"></i>
								<span>Financial Education and Training</span>
							</li>
							<li>
								<i class="fas fa-shield-alt"></i>
								<span>Insurance and Welfare Benefits</span>
							</li>
							<li>
								<i class="fas fa-credit-card"></i>
								<span>Access to ATM and Mobile Banking</span>
							</li>
						</ul>
					</div>
					
					<div class="sidebar-card mb-4">
						<h3>How to Join</h3>
						<div class="steps-list">
							<div class="step-item">
								<div class="step-number">1</div>
								<div class="step-content">
									<h4>Complete the Registration Form</h4>
									<p>Fill out the online registration form with your personal details.</p>
								</div>
							</div>
							<div class="step-item">
								<div class="step-number">2</div>
								<div class="step-content">
									<h4>Verify Your Identity</h4>
									<p>Visit any of our branches with your ID card and KRA PIN for verification.</p>
								</div>
							</div>
							<div class="step-item">
								<div class="step-number">3</div>
								<div class="step-content">
									<h4>Pay Registration Fee</h4>
									<p>Pay the one-time registration fee of KSh 1,000 and your first monthly contribution.</p>
								</div>
							</div>
							<div class="step-item">
								<div class="step-number">4</div>
								<div class="step-content">
									<h4>Receive Membership Number</h4>
									<p>Once approved, you'll receive your unique membership number and account details.</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class="need-help-card">
						<h3>Need Help?</h3>
						<p>Our member services team is available to assist you with the registration process.</p>
						<div class="contact-info">
							<div class="contact-item">
								<i class="fas fa-phone-alt"></i>
								<span>+254 700 123 456</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-envelope"></i>
								<span>membership@harambeesacco.com</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-map-marker-alt"></i>
								<span>Visit any of our branches</span>
							</div>
						</div>
						<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary w-100 mt-3">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Terms and Conditions Modal -->
	<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h4>1. Membership</h4>
					<p>Membership is open to individuals who meet the following criteria:</p>
					<ul>
						<li>Must be at least 18 years of age</li>
						<li>Must provide valid identification (National ID, Passport, or Alien ID)</li>
						<li>Must provide KRA PIN</li>
						<li>Must pay the registration fee and initial contribution</li>
					</ul>
					
					<h4>2. Contributions</h4>
					<p>Members are required to make monthly contributions based on their membership type. Failure to contribute for three consecutive months may result in membership dormancy.</p>
					
					<h4>3. Loans</h4>
					<p>Members qualify for loans after 3 months of continuous contributions. Loan amounts are determined by savings and repayment capacity. All loans are subject to approval and may require guarantors.</p>
					
					<h4>4. Withdrawals</h4>
					<p>Members may withdraw from their savings account, subject to maintaining the minimum required balance. Withdrawal from the SACCO requires a 30-day notice and settlement of outstanding loans.</p>
					
					<h4>5. Dividends</h4>
					<p>Dividends are distributed annually based on shareholding. The rate is determined by the Board of Directors and approved at the Annual General Meeting.</p>
					
					<h4>6. Information Accuracy</h4>
					<p>Members must provide accurate information during registration. The SACCO reserves the right to verify information provided and may terminate membership for fraudulent information.</p>
					
					<h4>7. Changes to Terms</h4>
					<p>The SACCO reserves the right to modify these terms and conditions at any time. Members will be notified of any changes through official channels.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Privacy Policy Modal -->
	<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h4>1. Information Collection</h4>
					<p>We collect personal information including but not limited to name, contact details, identification numbers, employment information, and financial information for the purpose of providing our services.</p>
					
					<h4>2. Use of Information</h4>
					<p>We use your information to:</p>
					<ul>
						<li>Process applications and manage your account</li>
						<li>Process transactions and provide requested services</li>
						<li>Comply with legal and regulatory requirements</li>
						<li>Communicate important information about your account</li>
						<li>Improve our services and develop new products</li>
					</ul>
					
					<h4>3. Information Sharing</h4>
					<p>We may share your information with:</p>
					<ul>
						<li>Service providers who assist in delivering our services</li>
						<li>Regulatory authorities as required by law</li>
						<li>Credit reference bureaus for credit assessment</li>
					</ul>
					<p>We do not sell or rent your personal information to third parties for marketing purposes without your consent.</p>
					
					<h4>4. Data Security</h4>
					<p>We implement appropriate technical and organizational measures to protect your personal information from unauthorized access, loss, or alteration.</p>
					
					<h4>5. Your Rights</h4>
					<p>You have the right to:</p>
					<ul>
						<li>Access your personal information</li>
						<li>Correct inaccurate information</li>
						<li>Request deletion of your information (subject to legal requirements)</li>
						<li>Object to processing of your information</li>
						<li>Withdraw consent for marketing communications</li>
					</ul>
					
					<h4>6. Retention</h4>
					<p>We retain your information for as long as necessary to fulfill the purposes for which it was collected, or as required by law.</p>
					
					<h4>7. Changes to Privacy Policy</h4>
					<p>We may update this privacy policy from time to time. Any changes will be posted on our website and communicated through appropriate channels.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<section class="cta-section bg-primary text-white py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2>Ready to Start Your Financial Journey?</h2>
					<p class="mb-0">Join Harambee SACCO today and take the first step towards financial empowerment and growth.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="#register-form" class="btn btn-light btn-lg">Register Now</a>
					<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password confirmation validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
    
    // Form validation
    const form = document.getElementById('register-form');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
    
    // Employment status dependent fields
    const employmentStatus = document.getElementById('employment_status');
    const employerField = document.getElementById('employer');
    const occupationField = document.getElementById('occupation');
    
    employmentStatus.addEventListener('change', function() {
        const value = this.value;
        const requireEmployer = value === 'full-time' || value === 'part-time';
        
        if (requireEmployer) {
            employerField.setAttribute('required', '');
            occupationField.setAttribute('required', '');
        } else {
            employerField.removeAttribute('required');
            occupationField.removeAttribute('required');
        }
    });
});
</script>

<style>
/* Registration Card */
.registration-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.registration-header {
    background-color: #f8f9fa;
    padding: 30px;
    border-bottom: 1px solid #efefef;
    text-align: center;
}

.registration-header h2 {
    margin-bottom: 10px;
    color: #2c3624;
}

.registration-header p {
    color: #6c757d;
    margin-bottom: 0;
}

.registration-body {
    padding: 30px;
}

.section-title {
    color: #2c3624;
    font-size: 1.3rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #efefef;
}

/* Sidebar Cards */
.sidebar-card, .need-help-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    padding: 25px;
}

.sidebar-card h3, .need-help-card h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #2c3624;
}

/* Benefits List */
.benefits-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #efefef;
}

.benefits-list li:last-child {
    border-bottom: none;
}

.benefits-list li i {
    color: #5ca157;
    margin-right: 10px;
    font-size: 1.2rem;
    width: 25px;
}

/* Steps List */
.steps-list {
    margin-bottom: 0;
}

.step-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.step-item:last-child {
    margin-bottom: 0;
}

.step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #5ca157;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
}

.step-content h4 {
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #2c3624;
}

.step-content p {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
}

/* Contact Info */
.contact-info {
    margin: 15px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.contact-item:last-child {
    margin-bottom: 0;
}

.contact-item i {
    width: 20px;
    color: #5ca157;
    margin-right: 10px;
}

/* Form Styling */
.form-check-label a {
    color: #5ca157;
    text-decoration: none;
}

.form-check-label a:hover {
    text-decoration: underline;
}

/* Responsive Styles */
@media (max-width: 767.98px) {
    .registration-header,
    .registration-body {
        padding: 20px;
    }
    
    .sidebar-card, .need-help-card {
        padding: 20px;
        margin-top: 20px;
    }
}
</style>

<?php
get_footer(); 