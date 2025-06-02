<?php
/**
 * The template for displaying the registration page
 *
 * @package daystar-coop
 */

get_header();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-coop-logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd." class="img-fluid" style="max-height: 80px;">
                    </div>
                    <h2>Become a Member</h2>
                    <p class="text-muted">Join our cooperative society and enjoy exclusive benefits</p>
                </div>
                
                <!-- Registration Form with Improved Validation -->
                <form id="registrationForm" method="post" action="<?php echo esc_url(home_url('process-registration')); ?>" class="needs-validation" novalidate>
                    <!-- Error Messages Container -->
                    <div id="registrationErrorMessages" class="alert alert-danger d-none mb-4"></div>
                    
                    <!-- Success Message Container -->
                    <div id="registrationSuccessMessage" class="alert alert-success d-none mb-4"></div>
                    
                    <!-- Progress Indicator -->
                    <div class="mb-4">
                        <div class="progress">
                            <div id="registrationProgress" class="progress-bar bg-primary" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                        </div>
                    </div>
                    
                    <!-- Step 1: Personal Information -->
                    <div id="step1" class="registration-step">
                        <h4 class="mb-4">Personal Information</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                                <div class="invalid-feedback">Please enter your first name</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                                <div class="invalid-feedback">Please enter your last name</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 0712345678" required>
                            <div class="invalid-feedback">Please enter a valid phone number</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="idNumber" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="idNumber" name="id_number" required>
                            <div class="invalid-feedback">Please enter your ID number</div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="nextToStep2">Next Step</button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Employment Information -->
                    <div id="step2" class="registration-step d-none">
                        <h4 class="mb-4">Employment Information</h4>
                        
                        <div class="mb-3">
                            <label for="employmentStatus" class="form-label">Employment Status</label>
                            <select class="form-select" id="employmentStatus" name="employment_status" required>
                                <option value="" selected disabled>Select your employment status</option>
                                <option value="employed">Employed</option>
                                <option value="self-employed">Self-Employed</option>
                                <option value="business">Business Owner</option>
                                <option value="student">Student</option>
                                <option value="retired">Retired</option>
                            </select>
                            <div class="invalid-feedback">Please select your employment status</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="employer" class="form-label">Employer/Business Name</label>
                            <input type="text" class="form-control" id="employer" name="employer">
                            <div class="form-text">If applicable</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="monthlyIncome" class="form-label">Monthly Income (KSh)</label>
                            <input type="number" class="form-control" id="monthlyIncome" name="monthly_income" min="0">
                        </div>
                        
                        <div class="mb-3">
                            <label for="initialContribution" class="form-label">Initial Contribution (KSh)</label>
                            <input type="number" class="form-control" id="initialContribution" name="initial_contribution" min="12000" value="12000" required>
                            <div class="form-text">Minimum contribution is KSh 12,000</div>
                            <div class="invalid-feedback">Minimum contribution is KSh 12,000</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="backToStep1">Previous Step</button>
                            <button type="button" class="btn btn-primary" id="nextToStep3">Next Step</button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Account Setup -->
                    <div id="step3" class="registration-step d-none">
                        <h4 class="mb-4">Account Setup</h4>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Create Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="registerPassword" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Please create a password</div>
                            <div class="form-text">Password must be at least 8 characters long and include letters and numbers</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Passwords do not match</div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="termsAgreement" name="terms_agreement" required>
                            <label class="form-check-label" for="termsAgreement">
                                I agree to the <a href="<?php echo esc_url(home_url('terms-conditions')); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo esc_url(home_url('privacy-policy')); ?>" target="_blank">Privacy Policy</a>
                            </label>
                            <div class="invalid-feedback">You must agree to the terms and conditions</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="backToStep2">Previous Step</button>
                            <button type="submit" class="btn btn-primary" id="registerButton">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="registerSpinner" role="status" aria-hidden="true"></span>
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="mt-4">
                    <div class="auth-divider">
                        <span>or</span>
                    </div>
                    
                    <div class="text-center">
                        <p class="mb-3">Already have an account?</p>
                        <a href="<?php echo esc_url(home_url('login')); ?>" class="btn btn-outline-primary">Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
    const registerPassword = document.getElementById('registerPassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    
    if (toggleRegisterPassword && registerPassword) {
        toggleRegisterPassword.addEventListener('click', function() {
            const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    if (toggleConfirmPassword && confirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    // Multi-step form navigation
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const nextToStep2 = document.getElementById('nextToStep2');
    const backToStep1 = document.getElementById('backToStep1');
    const nextToStep3 = document.getElementById('nextToStep3');
    const backToStep2 = document.getElementById('backToStep2');
    const progressBar = document.getElementById('registrationProgress');
    
    if (nextToStep2) {
        nextToStep2.addEventListener('click', function() {
            // Validate step 1 fields
            const firstName = document.getElementById('firstName');
            const lastName = document.getElementById('lastName');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const idNumber = document.getElementById('idNumber');
            
            let isValid = true;
            
            if (!firstName.value) {
                firstName.classList.add('is-invalid');
                isValid = false;
            } else {
                firstName.classList.remove('is-invalid');
            }
            
            if (!lastName.value) {
                lastName.classList.add('is-invalid');
                isValid = false;
            } else {
                lastName.classList.remove('is-invalid');
            }
            
            if (!email.value || !email.value.includes('@')) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.remove('is-invalid');
            }
            
            if (!phone.value) {
                phone.classList.add('is-invalid');
                isValid = false;
            } else {
                phone.classList.remove('is-invalid');
            }
            
            if (!idNumber.value) {
                idNumber.classList.add('is-invalid');
                isValid = false;
            } else {
                idNumber.classList.remove('is-invalid');
            }
            
            if (isValid) {
                step1.classList.add('d-none');
                step2.classList.remove('d-none');
                progressBar.style.width = '66%';
                progressBar.setAttribute('aria-valuenow', '66');
                progressBar.textContent = 'Step 2 of 3';
            }
        });
    }
    
    if (backToStep1) {
        backToStep1.addEventListener('click', function() {
            step2.classList.add('d-none');
            step1.classList.remove('d-none');
            progressBar.style.width = '33%';
            progressBar.setAttribute('aria-valuenow', '33');
            progressBar.textContent = 'Step 1 of 3';
        });
    }
    
    if (nextToStep3) {
        nextToStep3.addEventListener('click', function() {
            // Validate step 2 fields
            const employmentStatus = document.getElementById('employmentStatus');
            const initialContribution = document.getElementById('initialContribution');
            
            let isValid = true;
            
            if (!employmentStatus.value) {
                employmentStatus.classList.add('is-invalid');
                isValid = false;
            } else {
                employmentStatus.classList.remove('is-invalid');
            }
            
            if (!initialContribution.value || initialContribution.value < 12000) {
                initialContribution.classList.add('is-invalid');
                isValid = false;
            } else {
                initialContribution.classList.remove('is-invalid');
            }
            
            if (isValid) {
                step2.classList.add('d-none');
                step3.classList.remove('d-none');
                progressBar.style.width = '100%';
                progressBar.setAttribute('aria-valuenow', '100');
                progressBar.textContent = 'Step 3 of 3';
            }
        });
    }
    
    if (backToStep2) {
        backToStep2.addEventListener('click', function() {
            step3.classList.add('d-none');
            step2.classList.remove('d-none');
            progressBar.style.width = '66%';
            progressBar.setAttribute('aria-valuenow', '66');
            progressBar.textContent = 'Step 2 of 3';
        });
    }
    
    // Form validation and submission
    const form = document.getElementById('registrationForm');
    const errorMessages = document.getElementById('registrationErrorMessages');
    const successMessage = document.getElementById('registrationSuccessMessage');
    const registerButton = document.getElementById('registerButton');
    const registerSpinner = document.getElementById('registerSpinner');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Clear previous error messages
            errorMessages.classList.add('d-none');
            errorMessages.textContent = '';
            successMessage.classList.add('d-none');
            
            // Validate password match
            const password = document.getElementById('registerPassword').value;
            const confirmPasswordValue = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPasswordValue) {
                document.getElementById('confirmPassword').classList.add('is-invalid');
                errorMessages.textContent = 'Passwords do not match. Please try again.';
                errorMessages.classList.remove('d-none');
                return;
            }
            
            // Validate terms agreement
            const termsAgreement = document.getElementById('termsAgreement');
            if (!termsAgreement.checked) {
                termsAgreement.classList.add('is-invalid');
                errorMessages.textContent = 'You must agree to the terms and conditions.';
                errorMessages.classList.remove('d-none');
                return;
            }
            
            // Show loading spinner
            registerButton.setAttribute('disabled', 'disabled');
            registerSpinner.classList.remove('d-none');
            
            // Validate form
            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                registerButton.removeAttribute('disabled');
                registerSpinner.classList.add('d-none');
                return;
            }
            
            // Get form data
            const formData = new FormData(form);
            
            // Simulate AJAX request (replace with actual AJAX in production)
            setTimeout(function() {
                // For demonstration purposes - in production, use actual AJAX
                successMessage.textContent = 'Registration successful! Your application is being processed. You will receive an email with further instructions.';
                successMessage.classList.remove('d-none');
                
                // Reset form and go back to step 1
                form.reset();
                step3.classList.add('d-none');
                step1.classList.remove('d-none');
                progressBar.style.width = '33%';
                progressBar.setAttribute('aria-valuenow', '33');
                progressBar.textContent = 'Step 1 of 3';
                
                registerButton.removeAttribute('disabled');
                registerSpinner.classList.add('d-none');
                
                // Scroll to top of form
                form.scrollIntoView({ behavior: 'smooth' });
            }, 2000);
        });
    }
});
</script>

<?php get_footer(); ?>
