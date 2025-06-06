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

    <!-- Registration Steps Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Registration Process</h2>
                <p class="section-subtitle">Complete the following steps to become a member</p>
            </div>
            
            <div class="registration-steps fade-in">
                <div class="step-progress">
                    <div class="step-progress-bar" data-progress="25"></div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item active">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Personal Information</h3>
                            <p class="step-description">Fill in your basic personal details</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Contact Details</h3>
                            <p class="step-description">Provide your contact information</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Account Setup</h3>
                            <p class="step-description">Choose your account preferences</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Verification</h3>
                            <p class="step-description">Verify your identity and submit</p>
                        </div>
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
                            <h2>Step 1: Personal Information</h2>
                            <p class="text-muted">Please provide your personal details</p>
                        </div>
                        
                        <div class="auth-body">
                            <form id="registrationForm" class="auth-form" action="#" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                                            <div class="invalid-feedback">Please enter your first name</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                                            <div class="invalid-feedback">Please enter your last name</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="idNumber" class="form-label">ID/Passport Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="idNumber" name="idNumber" required>
                                            <div class="invalid-feedback">Please enter your ID/Passport number</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="dateOfBirth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
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
                                    <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" required>
                                    <div class="invalid-feedback">Please enter your occupation</div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="employmentStatus" class="form-label">Employment Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="employmentStatus" name="employmentStatus" required>
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
                                
                                <div class="form-group mb-3">
                                    <label for="monthlyIncome" class="form-label">Monthly Income (KSh) <span class="text-danger">*</span></label>
                                    <select class="form-select" id="monthlyIncome" name="monthlyIncome" required>
                                        <option value="" selected disabled>Select your income range</option>
                                        <option value="below-20000">Below 20,000</option>
                                        <option value="20000-50000">20,000 - 50,000</option>
                                        <option value="50001-100000">50,001 - 100,000</option>
                                        <option value="100001-200000">100,001 - 200,000</option>
                                        <option value="above-200000">Above 200,000</option>
                                    </select>
                                    <div class="invalid-feedback">Please select your monthly income range</div>
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
                                    <button type="submit" class="btn btn-primary">Continue to Step 2</button>
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

<!-- Registration Form Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const registrationForm = document.getElementById('registrationForm');
    
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (!this.checkValidity()) {
                event.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            // Form is valid, show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            // Simulate API call (in a real implementation, this would be an actual API call)
            setTimeout(function() {
                // For demo purposes, redirect to step 2
                window.location.href = '<?php echo esc_url(home_url('register-step-2')); ?>';
            }, 2000);
        });
    }
    
    // Password strength meter (if needed in future steps)
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('passwordStrength');
    
    if (passwordInput && passwordStrength) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;
            
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
        });
    }
});
</script>

<?php
get_footer();
