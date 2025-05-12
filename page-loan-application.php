<?php
/**
 * Template Name: Loan Application
 *
 * The template for the loan application form.
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

	<section class="loan-application-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="application-card">
						<div class="application-header">
							<h2>Apply for a Loan</h2>
							<p>Complete the form below to apply for a loan. Fields marked with * are required.</p>
						</div>
						
						<div class="application-body">
							<form id="loan-application-form" class="needs-validation" novalidate>
								<!-- Loan Type -->
								<div class="mb-4">
									<h3 class="section-title">Loan Information</h3>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="loan-type" class="form-label">Loan Type*</label>
											<select class="form-select" id="loan-type" name="loan_type" required>
												<option value="">Select Loan Type</option>
												<option value="personal">Personal Loan</option>
												<option value="business">Business Loan</option>
												<option value="emergency">Emergency Loan</option>
												<option value="education">Education Loan</option>
												<option value="home">Home Loan</option>
												<option value="vehicle">Vehicle Loan</option>
											</select>
											<div class="invalid-feedback">Please select a loan type.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="loan-amount" class="form-label">Loan Amount (KSh)*</label>
											<input type="number" class="form-control" id="loan-amount" name="loan_amount" placeholder="Enter amount" min="5000" required>
											<div class="invalid-feedback">Please enter a valid loan amount (minimum KSh 5,000).</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="loan-purpose" class="form-label">Purpose of Loan*</label>
											<input type="text" class="form-control" id="loan-purpose" name="loan_purpose" placeholder="Brief description of loan purpose" required>
											<div class="invalid-feedback">Please provide the purpose of the loan.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="loan-term" class="form-label">Repayment Period*</label>
											<select class="form-select" id="loan-term" name="loan_term" required>
												<option value="">Select Term</option>
												<option value="6">6 months</option>
												<option value="12">12 months</option>
												<option value="18">18 months</option>
												<option value="24">24 months</option>
												<option value="36">36 months</option>
												<option value="48">48 months</option>
												<option value="60">60 months</option>
											</select>
											<div class="invalid-feedback">Please select a repayment period.</div>
										</div>
									</div>
								</div>

								<!-- Personal Information -->
								<div class="mb-4">
									<h3 class="section-title">Personal Information</h3>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="first-name" class="form-label">First Name*</label>
											<input type="text" class="form-control" id="first-name" name="first_name" placeholder="Enter first name" required>
											<div class="invalid-feedback">Please enter your first name.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="last-name" class="form-label">Last Name*</label>
											<input type="text" class="form-control" id="last-name" name="last_name" placeholder="Enter last name" required>
											<div class="invalid-feedback">Please enter your last name.</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="id-number" class="form-label">ID Number*</label>
											<input type="text" class="form-control" id="id-number" name="id_number" placeholder="National ID number" required>
											<div class="invalid-feedback">Please enter your ID number.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="kra-pin" class="form-label">KRA PIN</label>
											<input type="text" class="form-control" id="kra-pin" name="kra_pin" placeholder="KRA PIN number">
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="date-of-birth" class="form-label">Date of Birth*</label>
											<input type="date" class="form-control" id="date-of-birth" name="date_of_birth" required>
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
								</div>
								
								<!-- Contact Information -->
								<div class="mb-4">
									<h3 class="section-title">Contact Information</h3>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email" class="form-label">Email Address*</label>
											<input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
											<div class="invalid-feedback">Please enter a valid email address.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="phone" class="form-label">Phone Number*</label>
											<input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. 0712345678" required>
											<div class="invalid-feedback">Please enter your phone number.</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 mb-3">
											<label for="physical-address" class="form-label">Physical Address*</label>
											<input type="text" class="form-control" id="physical-address" name="physical_address" placeholder="Enter your physical address" required>
											<div class="invalid-feedback">Please enter your physical address.</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="city" class="form-label">City/Town*</label>
											<input type="text" class="form-control" id="city" name="city" placeholder="Enter city or town" required>
											<div class="invalid-feedback">Please enter your city or town.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="postal-code" class="form-label">Postal Code*</label>
											<input type="text" class="form-control" id="postal-code" name="postal_code" placeholder="Enter postal code" required>
											<div class="invalid-feedback">Please enter your postal code.</div>
										</div>
									</div>
								</div>
								
								<!-- Employment Information -->
								<div class="mb-4">
									<h3 class="section-title">Employment Information</h3>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="employment-status" class="form-label">Employment Status*</label>
											<select class="form-select" id="employment-status" name="employment_status" required>
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
											<label for="monthly-income" class="form-label">Monthly Income (KSh)*</label>
											<input type="number" class="form-control" id="monthly-income" name="monthly_income" placeholder="Enter your monthly income" required>
											<div class="invalid-feedback">Please enter your monthly income.</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="employer-name" class="form-label">Employer Name</label>
											<input type="text" class="form-control" id="employer-name" name="employer_name" placeholder="Enter employer name">
											<small class="text-muted">Required for employed applicants</small>
										</div>
										<div class="col-md-6 mb-3">
											<label for="employment-period" class="form-label">Employment Period</label>
											<select class="form-select" id="employment-period" name="employment_period">
												<option value="">Select Period</option>
												<option value="less-than-1">Less than 1 year</option>
												<option value="1-3">1-3 years</option>
												<option value="3-5">3-5 years</option>
												<option value="5-10">5-10 years</option>
												<option value="more-than-10">More than 10 years</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 mb-3">
											<label for="employer-address" class="form-label">Employer Address</label>
											<input type="text" class="form-control" id="employer-address" name="employer_address" placeholder="Enter employer address">
										</div>
									</div>
								</div>
								
								<!-- Bank Details -->
								<div class="mb-4">
									<h3 class="section-title">Bank Details</h3>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="bank-name" class="form-label">Bank Name*</label>
											<input type="text" class="form-control" id="bank-name" name="bank_name" placeholder="Enter bank name" required>
											<div class="invalid-feedback">Please enter your bank name.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="bank-branch" class="form-label">Branch*</label>
											<input type="text" class="form-control" id="bank-branch" name="bank_branch" placeholder="Enter branch name" required>
											<div class="invalid-feedback">Please enter your bank branch.</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="account-number" class="form-label">Account Number*</label>
											<input type="text" class="form-control" id="account-number" name="account_number" placeholder="Enter account number" required>
											<div class="invalid-feedback">Please enter your account number.</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="account-name" class="form-label">Account Name*</label>
											<input type="text" class="form-control" id="account-name" name="account_name" placeholder="Enter account name" required>
											<div class="invalid-feedback">Please enter your account name.</div>
										</div>
									</div>
								</div>
								
								<!-- References -->
								<div class="mb-4">
									<h3 class="section-title">References</h3>
									<p class="section-description">Please provide details of two guarantors</p>
									
									<!-- First Reference -->
									<div class="reference-section mb-3">
										<h4>Reference 1</h4>
										<div class="row">
											<div class="col-md-6 mb-3">
												<label for="ref1-name" class="form-label">Full Name*</label>
												<input type="text" class="form-control" id="ref1-name" name="ref1_name" placeholder="Enter full name" required>
												<div class="invalid-feedback">Please enter reference's full name.</div>
											</div>
											<div class="col-md-6 mb-3">
												<label for="ref1-relationship" class="form-label">Relationship*</label>
												<input type="text" class="form-control" id="ref1-relationship" name="ref1_relationship" placeholder="e.g. Colleague, Friend, Relative" required>
												<div class="invalid-feedback">Please enter your relationship.</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 mb-3">
												<label for="ref1-phone" class="form-label">Phone Number*</label>
												<input type="tel" class="form-control" id="ref1-phone" name="ref1_phone" placeholder="Enter phone number" required>
												<div class="invalid-feedback">Please enter reference's phone number.</div>
											</div>
											<div class="col-md-6 mb-3">
												<label for="ref1-email" class="form-label">Email Address</label>
												<input type="email" class="form-control" id="ref1-email" name="ref1_email" placeholder="Enter email address">
											</div>
										</div>
									</div>
									
									<!-- Second Reference -->
									<div class="reference-section">
										<h4>Reference 2</h4>
										<div class="row">
											<div class="col-md-6 mb-3">
												<label for="ref2-name" class="form-label">Full Name*</label>
												<input type="text" class="form-control" id="ref2-name" name="ref2_name" placeholder="Enter full name" required>
												<div class="invalid-feedback">Please enter reference's full name.</div>
											</div>
											<div class="col-md-6 mb-3">
												<label for="ref2-relationship" class="form-label">Relationship*</label>
												<input type="text" class="form-control" id="ref2-relationship" name="ref2_relationship" placeholder="e.g. Colleague, Friend, Relative" required>
												<div class="invalid-feedback">Please enter your relationship.</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 mb-3">
												<label for="ref2-phone" class="form-label">Phone Number*</label>
												<input type="tel" class="form-control" id="ref2-phone" name="ref2_phone" placeholder="Enter phone number" required>
												<div class="invalid-feedback">Please enter reference's phone number.</div>
											</div>
											<div class="col-md-6 mb-3">
												<label for="ref2-email" class="form-label">Email Address</label>
												<input type="email" class="form-control" id="ref2-email" name="ref2_email" placeholder="Enter email address">
											</div>
										</div>
									</div>
								</div>
								
								<!-- Documents Upload -->
								<div class="mb-4">
									<h3 class="section-title">Required Documents</h3>
									<p class="section-description">Please upload the following documents in PDF, JPG, or PNG format.</p>
									
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="id-copy" class="form-label">ID Copy (Front & Back)*</label>
											<input type="file" class="form-control" id="id-copy" name="id_copy" accept=".pdf,.jpg,.jpeg,.png" required>
											<div class="invalid-feedback">Please upload your ID copy.</div>
											<small class="text-muted">Maximum size: 2MB</small>
										</div>
										<div class="col-md-6 mb-3">
											<label for="payslip" class="form-label">Recent Payslip*</label>
											<input type="file" class="form-control" id="payslip" name="payslip" accept=".pdf,.jpg,.jpeg,.png" required>
											<div class="invalid-feedback">Please upload your recent payslip.</div>
											<small class="text-muted">Maximum size: 2MB</small>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="bank-statement" class="form-label">Bank Statement (Last 3 months)*</label>
											<input type="file" class="form-control" id="bank-statement" name="bank_statement" accept=".pdf,.jpg,.jpeg,.png" required>
											<div class="invalid-feedback">Please upload your bank statement.</div>
											<small class="text-muted">Maximum size: 5MB</small>
										</div>
										<div class="col-md-6 mb-3">
											<label for="additional-document" class="form-label">Additional Document</label>
											<input type="file" class="form-control" id="additional-document" name="additional_document" accept=".pdf,.jpg,.jpeg,.png">
											<small class="text-muted">Maximum size: 2MB</small>
										</div>
									</div>
								</div>
								
								<!-- Terms and Conditions -->
								<div class="mb-4">
									<h3 class="section-title">Terms and Conditions</h3>
									<div class="terms-container mb-3">
										<div class="terms-content">
											<p>By submitting this application:</p>
											<ol>
												<li>I confirm that the information provided is accurate and complete.</li>
												<li>I authorize Harambee SACCO to verify the information provided from any source they deem fit.</li>
												<li>I understand that any false information may result in the rejection of my application.</li>
												<li>I agree to comply with the SACCO's rules and regulations regarding loans.</li>
												<li>I understand that submission of this application does not guarantee approval.</li>
												<li>I authorize Harambee SACCO to check my credit history as part of the application process.</li>
												<li>I agree to pay any applicable fees related to this loan application.</li>
											</ol>
										</div>
									</div>
									<div class="form-check mb-3">
										<input class="form-check-input" type="checkbox" id="agree-terms" name="agree_terms" required>
										<label class="form-check-label" for="agree-terms">
											I have read and agree to the terms and conditions*
										</label>
										<div class="invalid-feedback">
											You must agree to the terms and conditions to proceed.
										</div>
									</div>
									<div class="form-check mb-3">
										<input class="form-check-input" type="checkbox" id="agree-processing" name="agree_processing" required>
										<label class="form-check-label" for="agree-processing">
											I consent to the processing of my personal data for the purpose of this loan application*
										</label>
										<div class="invalid-feedback">
											You must agree to the processing of your personal data to proceed.
										</div>
									</div>
								</div>
								
								<!-- Submit Button -->
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-lg px-5">Submit Application</button>
								</div>
							</form>
							
							<!-- Application Success Alert (Hidden by default) -->
							<div class="alert alert-success mt-4" id="application-success" style="display: none;">
								<h4 class="alert-heading">Application Submitted Successfully!</h4>
								<p>Thank you for your loan application. Your application has been received and is being processed.</p>
								<p>We will contact you shortly regarding the status of your application. Your application reference number is: <strong id="application-reference"></strong></p>
							</div>
						</div>
					</div>
					
					<div class="loan-info-card mt-4">
						<h3>Application Process</h3>
						<div class="process-steps">
							<div class="step">
								<div class="step-number">1</div>
								<div class="step-content">
									<h4>Submit Application</h4>
									<p>Complete and submit the online application form with all required documents.</p>
								</div>
							</div>
							<div class="step">
								<div class="step-number">2</div>
								<div class="step-content">
									<h4>Application Review</h4>
									<p>Our loan officers will review your application and may contact you for additional information.</p>
								</div>
							</div>
							<div class="step">
								<div class="step-number">3</div>
								<div class="step-content">
									<h4>Approval Decision</h4>
									<p>You will be notified of the decision within 3-5 working days of submitting a complete application.</p>
								</div>
							</div>
							<div class="step">
								<div class="step-number">4</div>
								<div class="step-content">
									<h4>Disbursement</h4>
									<p>If approved, the loan amount will be disbursed to your bank account within 24-48 hours.</p>
								</div>
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
					<h2>Need Help with Your Application?</h2>
					<p class="mb-0">Our customer service team is available to assist you with any questions regarding your loan application.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-light btn-lg">Contact Us</a>
					<a href="<?php echo esc_url(home_url('/faqs/')); ?>" class="btn btn-outline-light btn-lg ms-2">FAQs</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Form validation
		const form = document.getElementById('loan-application-form');
		const successAlert = document.getElementById('application-success');
		const referenceElement = document.getElementById('application-reference');
		
		form.addEventListener('submit', function(event) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			} else {
				event.preventDefault();
				
				// In a real implementation, you would submit the form data to the server here
				// For demonstration purposes, we'll just show the success message
				
				// Generate a random reference number
				const referenceNumber = 'LOAN' + Math.floor(100000 + Math.random() * 900000);
				referenceElement.textContent = referenceNumber;
				
				// Hide the form and show success message
				form.style.display = 'none';
				successAlert.style.display = 'block';
				
				// Scroll to success message
				successAlert.scrollIntoView({ behavior: 'smooth' });
			}
			
			form.classList.add('was-validated');
		});
		
		// Show/hide employer fields based on employment status
		const employmentStatus = document.getElementById('employment-status');
		const employerFields = document.querySelectorAll('#employer-name, #employer-address, #employment-period');
		
		employmentStatus.addEventListener('change', function() {
			const value = this.value;
			const requireEmployer = value === 'full-time' || value === 'part-time';
			
			employerFields.forEach(field => {
				field.required = requireEmployer;
				if (requireEmployer) {
					field.closest('.mb-3').classList.add('required-field');
				} else {
					field.closest('.mb-3').classList.remove('required-field');
				}
			});
		});
	});
</script>

<style>
	.application-card {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
		overflow: hidden;
	}
	
	.application-header {
		background-color: #f8f9fa;
		padding: 30px;
		border-bottom: 1px solid #efefef;
		text-align: center;
	}
	
	.application-header h2 {
		margin-bottom: 10px;
		color: #2c3624;
	}
	
	.application-header p {
		color: #6c757d;
		margin-bottom: 0;
	}
	
	.application-body {
		padding: 30px;
	}
	
	.section-title {
		color: #2c3624;
		font-size: 1.3rem;
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 1px solid #efefef;
	}
	
	.section-description {
		margin-bottom: 20px;
		color: #6c757d;
	}
	
	.reference-section {
		background-color: #f8f9fa;
		padding: 20px;
		border-radius: 8px;
		margin-bottom: 15px;
	}
	
	.reference-section h4 {
		font-size: 1.1rem;
		margin-bottom: 15px;
		color: #2c3624;
	}
	
	.terms-container {
		max-height: 200px;
		overflow-y: auto;
		padding: 15px;
		background-color: #f8f9fa;
		border: 1px solid #dee2e6;
		border-radius: 5px;
	}
	
	.terms-content {
		font-size: 0.9rem;
	}
	
	.required-field label::after {
		content: "*";
		color: #dc3545;
		margin-left: 3px;
	}
	
	.loan-info-card {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
		padding: 30px;
	}
	
	.loan-info-card h3 {
		color: #2c3624;
		margin-bottom: 30px;
		text-align: center;
	}
	
	.process-steps {
		display: flex;
		flex-wrap: wrap;
	}
	
	.step {
		display: flex;
		align-items: flex-start;
		margin-bottom: 20px;
		width: 100%;
	}
	
	.step-number {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		background-color: #5ca157;
		color: #fff;
		font-weight: bold;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 15px;
		flex-shrink: 0;
	}
	
	.step-content {
		flex-grow: 1;
	}
	
	.step-content h4 {
		font-size: 1.1rem;
		margin-bottom: 5px;
		color: #2c3624;
	}
	
	.step-content p {
		color: #6c757d;
		margin-bottom: 0;
	}
	
	@media (min-width: 768px) {
		.step {
			width: 50%;
		}
	}
	
	@media (max-width: 767.98px) {
		.application-header,
		.application-body {
			padding: 20px;
		}
		
		.step {
			width: 100%;
		}
	}
</style>

<?php
get_footer(); 