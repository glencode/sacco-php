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

// Add necessary JavaScript variables
?>
<script type="text/javascript">
    var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
    var homeUrl = '<?php echo esc_url(home_url()); ?>';
</script>

<?php wp_enqueue_script('jquery'); ?>

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
                            <?php do_action('daystar_before_registration_form'); ?>                            <form id="registrationForm" class="auth-form needs-validation" novalidate>
                                <?php wp_nonce_field('daystar_register_member_nonce', 'security'); ?>
                                <input type="hidden" name="action" value="daystar_register_member">                                <!-- Display form validation errors -->
                                <div class="alert alert-danger d-none" id="registrationErrors"></div>
                                <!-- Display success message -->
                                <div class="alert alert-success d-none" id="registrationSuccess"></div>
                                
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
                                
                                <hr class="my-4">
                                <h3 class="mb-3">Bank Information</h3>
                                
                                <div class="form-group mb-3">
                                    <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                    <select class="form-select" id="bank_name" name="bank_name" required>
                                        <option value="" selected disabled>Select your bank</option>
                                        <option value="equity">Equity Bank</option>
                                        <option value="kcb">KCB Bank</option>
                                        <option value="cooperative">Co-operative Bank</option>
                                        <option value="stanchart">Standard Chartered</option>
                                        <option value="absa">ABSA Bank</option>
                                        <option value="dtb">Diamond Trust Bank</option>
                                        <option value="ncba">NCBA Bank</option>
                                        <option value="family">Family Bank</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select your bank</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="bank_branch" class="form-label">Branch Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" required>
                                            <div class="invalid-feedback">Please enter your bank branch</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="account_number" name="account_number" required>
                                            <div class="invalid-feedback">Please enter your account number</div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h3 class="mb-3">Required Documents</h3>
                                <p class="text-muted mb-3">Please scan and upload clear copies of the following documents:</p>

                                <div class="document-upload-section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="id_doc" class="form-label">National ID/Passport <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="id_doc" name="id_doc" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <div class="form-text">Maximum file size: 5MB</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="photo" class="form-label">Passport Photo <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>
                                                <div class="form-text">Recent passport-sized photograph</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="proof_of_residence" class="form-label">Proof of Residence <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="proof_of_residence" name="proof_of_residence" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <div class="form-text">Utility bill or lease agreement</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="income_proof" class="form-label">Proof of Income <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="income_proof" name="income_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <div class="form-text">Latest payslip or 3 months bank statements</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kra_cert" class="form-label">KRA PIN Certificate <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="kra_cert" name="kra_cert" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <div class="form-text">PDF or image format</div>
                                    </div>
                                </div>

                                <div class="document-requirements alert alert-info mt-3">
                                    <h4 class="alert-heading h5">Document Requirements:</h4>
                                    <ul class="mb-0">
                                        <li>All documents must be clear and legible</li>
                                        <li>File size should not exceed 5MB per document</li>
                                        <li>Accepted formats: PDF, JPG, JPEG, PNG</li>
                                        <li>Original documents must be presented at a branch for verification</li>
                                    </ul>
                                </div>

                                <hr class="my-4">
                                <div class="form-checks mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="declaration" name="declaration" required>
                                        <label class="form-check-label" for="declaration">
                                            I declare that all information provided is true and accurate
                                        </label>
                                        <div class="invalid-feedback">You must confirm this declaration</div>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                                        <label class="form-check-label" for="consent">
                                            I consent to credit reference bureau checks
                                        </label>
                                        <div class="invalid-feedback">Consent is required for registration</div>
                                    </div>                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms_agreement" name="terms_agreement" required>
                                        <label class="form-check-label" for="terms_agreement">
                                            I agree to the <a href="<?php echo esc_url(home_url('terms-and-conditions')); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo esc_url(home_url('privacy-policy')); ?>" target="_blank">Privacy Policy</a>
                                        </label>
                                        <div class="invalid-feedback">You must agree to the terms and conditions</div>
                                    </div>
                                </div>
                                
                                <div class="form-group d-flex justify-content-between">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="registerSubmit">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        Register
                                    </button>
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

    // Handle employment status conditional fields
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

    // Form submission handling
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('registerSubmit');
    const errorsDiv = document.getElementById('registrationErrors');
    const successDiv = document.getElementById('registrationSuccess');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset error state
            errorsDiv.classList.add('d-none');
            successDiv.classList.add('d-none');
            errorsDiv.innerHTML = '';
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            // Create FormData
            const formData = new FormData(form);
            
            // Log form data for debugging (remove in production)
            console.log('Sending form data:', Object.fromEntries(formData));
            
            // Send AJAX request
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Registration response:', response);
                    
                    if (response.success) {
                        successDiv.classList.remove('d-none');
                        successDiv.innerHTML = 'Registration successful! Redirecting...';
                        
                        // Hide form on success
                        form.style.display = 'none';
                        
                        setTimeout(function() {
                            window.location.href = `${homeUrl}/registration-success/?member=${encodeURIComponent(response.data.member_number)}`;
                        }, 1500);
                    } else {
                        errorsDiv.classList.remove('d-none');
                        errorsDiv.innerHTML = response.data?.message || 'Registration failed. Please try again.';
                        
                        // Reset submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Register';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Registration error:', {xhr, status, error});
                    errorsDiv.classList.remove('d-none');
                    errorsDiv.innerHTML = 'An error occurred. Please try again.';
                    
                    // Reset submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Register';
                }
            });
        });
    }
});
</script>

<?php
get_footer();
