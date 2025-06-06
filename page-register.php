<?php
/**
 * The template for displaying the Registration page - Improved Version
 *
 * This is the improved Registration page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main register-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Become a Member</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Register</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/register-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="auth-card fade-in">
                        <div class="auth-header text-center">
                            <h2>Register</h2>
                            <p class="text-muted">Please provide your details to become a member</p>
                        </div>
                        
                        <div class="auth-body">
                            <?php do_action('daystar_before_registration_form'); ?>
                            <form id="registrationForm" class="auth-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                                <input type="hidden" name="action" value="daystar_register_member">
                                <input type="hidden" name="registration_nonce" value="<?php echo wp_create_nonce('daystar_registration_nonce'); ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                                            <div class="invalid-feedback">Please enter your first name</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                                            <div class="invalid-feedback">Please enter your last name</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="id_number" class="form-label">ID/Passport Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="id_number" name="id_number" required>
                                            <div class="invalid-feedback">Please enter your ID/Passport number</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                            <div class="invalid-feedback">Please enter your date of birth</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check me-4">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" required>
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check me-4">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" required>
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" required>
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please select your gender</div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="marital_status" class="form-label">Marital Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="marital_status" name="marital_status" required>
                                        <option value="" selected disabled>Select your marital status</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                    <div class="invalid-feedback">Please select your marital status</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <div class="invalid-feedback">Please enter your email address</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                            <div class="invalid-feedback">Please enter your phone number</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="alt_phone" class="form-label">Alternative Phone Number</label>
                                    <input type="tel" class="form-control" id="alt_phone" name="alt_phone">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="physical_address" class="form-label">Physical Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="physical_address" name="physical_address" rows="3" required></textarea>
                                    <div class="invalid-feedback">Please enter your physical address</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city" required>
                                            <div class="invalid-feedback">Please enter your city</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                                            <div class="invalid-feedback">Please enter your postal code</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="job_title" class="form-label">Occupation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="job_title" name="job_title" required>
                                    <div class="invalid-feedback">Please enter your occupation</div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="employment_status" class="form-label">Employment Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="employment_status" name="employment_status" required>
                                        <option value="" selected disabled>Select your employment status</option>
                                        <option value="employed">Employed</option>
                                        <option value="self-employed">Self-Employed</option>
                                        <option value="business-owner">Business Owner</option>
                                        <option value="student">Student</option>
                                        <option value="retired">Retired</option>
                                        <option value="unemployed">Unemployed</option>
                                    </select>
                                    <div class="invalid-feedback">Please select your employment status</div>
                                </div>

                                <div id="employerDetails" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label for="employer" class="form-label">Employer <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="employer" name="employer">
                                        <div class="invalid-feedback">Please enter your employer</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="employment_duration" class="form-label">Employment Duration (Years) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="employment_duration" name="employment_duration" min="0">
                                        <div class="invalid-feedback">Please enter your employment duration</div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="monthly_income" class="form-label">Monthly Income (KSh) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="monthly_income" name="monthly_income" required min="0" step="any">
                                    <div class="invalid-feedback">Please enter your monthly income</div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="kra_pin" class="form-label">KRA PIN <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kra_pin" name="kra_pin" required>
                                    <div class="invalid-feedback">Please enter your KRA PIN</div>
                                </div>

                                <hr class="my-4">
                                <h3 class="mb-3">Account Credentials</h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                            <div class="invalid-feedback">Please choose a username</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <div class="invalid-feedback">Please enter a password</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                            <div class="invalid-feedback">Please confirm your password</div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h3 class="mb-3">Initial Contributions</h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="initial_contribution" class="form-label">Initial Share Contribution (Min KSh 1,000) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="initial_contribution" name="initial_contribution" required min="1000">
                                            <div class="invalid-feedback">Minimum initial contribution is KSh 1,000</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="monthly_contribution" class="form-label">Monthly Savings Contribution (Min KSh 500) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="monthly_contribution" name="monthly_contribution" required min="500">
                                            <div class="invalid-feedback">Minimum monthly contribution is KSh 500</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="termsAgreement" name="termsAgreement" required>
                                    <label class="form-check-label" for="termsAgreement">
                                        I agree to the <a href="<?php echo esc_url(home_url('terms-and-conditions')); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo esc_url(home_url('privacy-policy')); ?>" target="_blank">Privacy Policy</a>
                                    </label>
                                    <div class="invalid-feedback">You must agree to the terms and conditions</div>
                                </div>
                                
                                <div class="form-group d-flex justify-content-between">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="auth-help mt-4 text-center fade-in">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Already have an account?</h5>
                                <p class="card-text">If you're already a member, you can sign in to access your account.</p>
                                <a href="<?php echo esc_url(home_url('login')); ?>" class="btn btn-sm btn-outline-primary">Sign In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Benefits Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Membership Benefits</h2>
                <p class="section-subtitle">Enjoy these exclusive benefits as a member</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Competitive Rates</h3>
                        <p>Access loans with lower interest rates and earn higher returns on your savings compared to traditional banks.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>Dividend Payments</h3>
                        <p>Receive annual dividend payments based on your share capital and participation in the SACCO.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>Financial Education</h3>
                        <p>Access free financial literacy workshops, seminars, and resources to improve your financial knowledge.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Insurance Coverage</h3>
                        <p>Benefit from group insurance policies at discounted rates, including life, health, and property insurance.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-vote-yea" aria-hidden="true"></i>
                        </div>
                        <h3>Voting Rights</h3>
                        <p>Participate in decision-making processes by voting at Annual General Meetings and electing board members.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="benefit-icon">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Digital Banking</h3>
                        <p>Enjoy convenient access to your accounts through our mobile app and online banking platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about membership registration</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion fade-in" id="registrationFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What are the requirements to join?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#registrationFAQ">
                                <div class="accordion-body">
                                    To join our SACCO, you need to be at least 18 years old, have a valid ID or passport, provide proof of income, and make an initial deposit of at least KSh 5,000 for share capital and KSh 1,000 for the membership fee.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How long does the registration process take?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#registrationFAQ">
                                <div class="accordion-body">
                                    The online registration process takes about 15-20 minutes to complete. After submission, your application will be reviewed within 2-3 business days, and you'll receive your membership confirmation via email.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What documents do I need to provide?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#registrationFAQ">
                                <div class="accordion-body">
                                    You'll need to provide a copy of your ID or passport, a recent passport-sized photograph, proof of residence (utility bill or lease agreement), and proof of income (payslip or bank statements for the last 3 months).
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I register online or do I need to visit a branch?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#registrationFAQ">
                                <div class="accordion-body">
                                    You can complete the initial registration process online. However, you'll need to visit one of our branches to submit your original documents for verification and to sign the membership agreement before your account is fully activated.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    When can I start applying for loans?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#registrationFAQ">
                                <div class="accordion-body">
                                    New members can apply for loans after 6 months of consistent contributions. However, emergency loans may be available after 3 months of membership, depending on your contribution history and financial need.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <p>Have more questions? <a href="<?php echo esc_url(home_url('contact-us')); ?>">Contact our support team</a></p>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const employmentStatus = document.getElementById('employment_status');
    const employerDetails = document.getElementById('employerDetails');
    const employerInput = document.getElementById('employer');
    const employmentDurationInput = document.getElementById('employment_duration');

    if (employmentStatus) {
        employmentStatus.addEventListener('change', function() {
            if (this.value === 'employed' || this.value === 'business-owner') {
                employerDetails.style.display = 'block';
                employerInput.required = true;
                employmentDurationInput.required = true;
            } else {
                employerDetails.style.display = 'none';
                employerInput.required = false;
                employmentDurationInput.required = false;
            }
        });
    }

    // Basic form validation (can be enhanced)
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                // Highlight errors or provide messages
                // For now, relying on browser's default validation UI
            }
            this.classList.add('was-validated'); // Bootstrap validation styling

            // Password confirmation validation
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                event.preventDefault();
                event.stopPropagation();
                document.getElementById('confirm_password').setCustomValidity("Passwords do not match.");
                // Add visual feedback for password mismatch
            } else {
                document.getElementById('confirm_password').setCustomValidity("");
            }
        });
    }
     // Password strength meter (if needed in future steps)
    const passwordInput = document.getElementById('password');
    // const passwordStrength = document.getElementById('passwordStrength'); // No password strength element in this form yet
    
    if (passwordInput) { // Removed passwordStrength check as it's not in the form
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;
            
            // Example: Update a non-existent strength indicator or log to console
            // console.log("Password strength: " + strength);
            // If you add a password strength indicator element, uncomment and adapt the switch statement below
            /*
            switch (strength) {
                case 0:
                case 1:
                    passwordStrength.className = 'password-strength weak';
                    passwordStrength.textContent = 'Weak';
                    break;
                case 2:
                case 3:
                    passwordStrength.className = 'password-strength medium';
                    passwordStrength.textContent = 'Medium';
                    break;
                case 4:
                case 5:
                    passwordStrength.className = 'password-strength strong';
                    passwordStrength.textContent = 'Strong';
                    break;
            }
            */
        });
    }
});
</script>

<?php
get_footer();
