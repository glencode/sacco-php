/**
 * Daystar Multi-Purpose Co-op Society - Authentication Module
 * 
 * This module provides login and registration functionality specific to Daystar Multi-Purpose Co-op Society Ltd.
 * It implements the authentication processes as specified in the Daystar credit policy.
 */

class DaystarAuthentication {
    /**
     * Initialize login form
     * 
     * @param {string} formId - ID of the login form
     */
    static initializeLoginForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        // Set up form validation
        this.setupLoginFormValidation(form);
        
        // Set up password toggle
        this.setupPasswordToggle(form);
    }
    
    /**
     * Initialize registration form
     * 
     * @param {string} formId - ID of the registration form
     */
    static initializeRegistrationForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        // Set up form validation
        this.setupRegistrationFormValidation(form);
        
        // Set up password toggle
        this.setupPasswordToggle(form);
        
        // Set up multi-step form
        this.setupMultiStepForm(form);
    }
    
    /**
     * Set up login form validation
     * 
     * @param {HTMLElement} form - Login form element
     */
    static setupLoginFormValidation(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Reset previous validation errors
            const errorMessages = form.querySelector('.error-messages');
            const successMessage = form.querySelector('.success-message');
            
            if (errorMessages) {
                errorMessages.classList.add('d-none');
                errorMessages.textContent = '';
            }
            
            if (successMessage) {
                successMessage.classList.add('d-none');
            }
            
            // Show loading state
            const submitBtn = form.querySelector('[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';
            
            // Validate form
            const isValid = this.validateLoginForm(form);
            
            if (isValid) {
                // Submit form
                this.submitLoginForm(form, submitBtn, originalBtnText);
            } else {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
    
    /**
     * Validate login form
     * 
     * @param {HTMLElement} form - Login form element
     * @return {boolean} Whether form is valid
     */
    static validateLoginForm(form) {
        let isValid = true;
        
        // Validate member number/email
        const memberInput = form.querySelector('[name="member_number"], [name="email"]');
        if (memberInput && !memberInput.value.trim()) {
            this.showValidationError(memberInput, 'Please enter your member number or email');
            isValid = false;
        }
        
        // Validate password
        const passwordInput = form.querySelector('[name="password"]');
        if (passwordInput && !passwordInput.value.trim()) {
            this.showValidationError(passwordInput, 'Please enter your password');
            isValid = false;
        }
        
        return isValid;
    }
    
    /**
     * Submit login form
     * 
     * @param {HTMLElement} form - Login form element
     * @param {HTMLElement} submitBtn - Submit button element
     * @param {string} originalBtnText - Original button text
     */
    static submitLoginForm(form, submitBtn, originalBtnText) {
        // In a real implementation, this would submit the form data to the server
        // For this demo, we'll simulate a successful login
        
        // Simulate form submission
        setTimeout(() => {
            const errorMessages = form.querySelector('.error-messages');
            const successMessage = form.querySelector('.success-message');
            
            // Simulate successful login
            if (successMessage) {
                successMessage.textContent = 'Login successful! Redirecting to dashboard...';
                successMessage.classList.remove('d-none');
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = 'page-member-dashboard.php';
                }, 2000);
            }
            
            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }, 1500);
    }
    
    /**
     * Set up registration form validation
     * 
     * @param {HTMLElement} form - Registration form element
     */
    static setupRegistrationFormValidation(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Reset previous validation errors
            const errorMessages = form.querySelector('.error-messages');
            const successMessage = form.querySelector('.success-message');
            
            if (errorMessages) {
                errorMessages.classList.add('d-none');
                errorMessages.textContent = '';
            }
            
            if (successMessage) {
                successMessage.classList.add('d-none');
            }
            
            // Show loading state
            const submitBtn = form.querySelector('[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...';
            
            // Validate form
            const isValid = this.validateRegistrationForm(form);
            
            if (isValid) {
                // Submit form
                this.submitRegistrationForm(form, submitBtn, originalBtnText);
            } else {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
    
    /**
     * Validate registration form
     * 
     * @param {HTMLElement} form - Registration form element
     * @return {boolean} Whether form is valid
     */
    static validateRegistrationForm(form) {
        let isValid = true;
        
        // Validate personal information
        const personalFields = [
            { name: 'first_name', label: 'First Name', required: true },
            { name: 'last_name', label: 'Last Name', required: true },
            { name: 'email', label: 'Email Address', required: true, type: 'email' },
            { name: 'phone', label: 'Phone Number', required: true },
            { name: 'id_number', label: 'ID Number', required: true }
        ];
        
        personalFields.forEach(field => {
            const input = form.querySelector(`[name="${field.name}"]`);
            if (!input) return;
            
            if (field.required && !input.value.trim()) {
                this.showValidationError(input, `${field.label} is required`);
                isValid = false;
            } else if (field.type === 'email' && !this.validateEmail(input.value)) {
                this.showValidationError(input, 'Please enter a valid email address');
                isValid = false;
            }
        });
        
        // Validate employment information
        const employmentFields = [
            { name: 'employment_status', label: 'Employment Status', required: true },
            { name: 'employer', label: 'Employer', required: false },
            { name: 'job_title', label: 'Job Title', required: false }
        ];
        
        employmentFields.forEach(field => {
            const input = form.querySelector(`[name="${field.name}"]`);
            if (!input) return;
            
            if (field.required && !input.value.trim()) {
                this.showValidationError(input, `${field.label} is required`);
                isValid = false;
            }
        });
        
        // Validate contribution amount
        const contributionInput = form.querySelector('[name="initial_contribution"]');
        if (contributionInput) {
            const contribution = parseFloat(contributionInput.value);
            if (isNaN(contribution) || contribution < 12000) {
                this.showValidationError(contributionInput, 'Initial contribution must be at least KSh 12,000');
                isValid = false;
            }
        }
        
        // Validate passwords
        const passwordInput = form.querySelector('[name="password"]');
        const confirmPasswordInput = form.querySelector('[name="confirm_password"]');
        
        if (passwordInput && confirmPasswordInput) {
            if (!passwordInput.value.trim()) {
                this.showValidationError(passwordInput, 'Password is required');
                isValid = false;
            } else if (passwordInput.value.length < 8) {
                this.showValidationError(passwordInput, 'Password must be at least 8 characters long');
                isValid = false;
            }
            
            if (!confirmPasswordInput.value.trim()) {
                this.showValidationError(confirmPasswordInput, 'Please confirm your password');
                isValid = false;
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                this.showValidationError(confirmPasswordInput, 'Passwords do not match');
                isValid = false;
            }
        }
        
        // Validate terms acceptance
        const termsCheckbox = form.querySelector('[name="terms"]');
        if (termsCheckbox && !termsCheckbox.checked) {
            this.showValidationError(termsCheckbox, 'You must accept the terms and conditions');
            isValid = false;
        }
        
        return isValid;
    }
    
    /**
     * Submit registration form
     * 
     * @param {HTMLElement} form - Registration form element
     * @param {HTMLElement} submitBtn - Submit button element
     * @param {string} originalBtnText - Original button text
     */
    static submitRegistrationForm(form, submitBtn, originalBtnText) {
        // In a real implementation, this would submit the form data to the server
        // For this demo, we'll simulate a successful registration
        
        // Simulate form submission
        setTimeout(() => {
            const errorMessages = form.querySelector('.error-messages');
            const successMessage = form.querySelector('.success-message');
            
            // Simulate successful registration
            if (successMessage) {
                // Hide form
                form.style.display = 'none';
                
                // Show success message
                successMessage.innerHTML = `
                    <h4>Registration Successful!</h4>
                    <p>Thank you for registering with Daystar Multi-Purpose Co-op Society Ltd.</p>
                    <p>Your application has been received and is being processed. You will receive an email with further instructions.</p>
                    <p>Your temporary member number is: <strong>DSM-${Date.now().toString().substring(6)}</strong></p>
                    <div class="mt-4">
                        <a href="page-login.php" class="btn btn-primary">Proceed to Login</a>
                    </div>
                `;
                successMessage.classList.remove('d-none');
            }
            
            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }, 2000);
    }
    
    /**
     * Set up password toggle
     * 
     * @param {HTMLElement} form - Form element
     */
    static setupPasswordToggle(form) {
        const passwordToggles = form.querySelectorAll('.password-toggle');
        
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        });
    }
    
    /**
     * Set up multi-step form
     * 
     * @param {HTMLElement} form - Registration form element
     */
    static setupMultiStepForm(form) {
        const steps = form.querySelectorAll('.form-step');
        if (steps.length <= 1) return;
        
        const progressBar = form.querySelector('.progress-bar');
        const nextButtons = form.querySelectorAll('.btn-next-step');
        const prevButtons = form.querySelectorAll('.btn-prev-step');
        
        // Set up next buttons
        nextButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Validate current step
                const currentStep = steps[index];
                const isValid = this.validateStep(currentStep, index);
                
                if (isValid) {
                    // Hide current step
                    currentStep.classList.add('d-none');
                    
                    // Show next step
                    steps[index + 1].classList.remove('d-none');
                    
                    // Update progress bar
                    if (progressBar) {
                        const progress = ((index + 2) / steps.length) * 100;
                        progressBar.style.width = `${progress}%`;
                        progressBar.setAttribute('aria-valuenow', progress);
                        progressBar.textContent = `Step ${index + 2} of ${steps.length}`;
                    }
                }
            });
        });
        
        // Set up previous buttons
        prevButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Hide current step
                const currentStepIndex = index + 1; // Previous buttons are in steps 1, 2, etc.
                steps[currentStepIndex].classList.add('d-none');
                
                // Show previous step
                steps[currentStepIndex - 1].classList.remove('d-none');
                
                // Update progress bar
                if (progressBar) {
                    const progress = (currentStepIndex / steps.length) * 100;
                    progressBar.style.width = `${progress}%`;
                    progressBar.setAttribute('aria-valuenow', progress);
                    progressBar.textContent = `Step ${currentStepIndex} of ${steps.length}`;
                }
            });
        });
    }
    
    /**
     * Validate form step
     * 
     * @param {HTMLElement} step - Form step element
     * @param {number} stepIndex - Step index
     * @return {boolean} Whether step is valid
     */
    static validateStep(step, stepIndex) {
        let isValid = true;
        
        // Get all required inputs in this step
        const requiredInputs = step.querySelectorAll('input[required], select[required], textarea[required]');
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                this.showValidationError(input, `This field is required`);
                isValid = false;
            } else if (input.type === 'email' && !this.validateEmail(input.value)) {
                this.showValidationError(input, 'Please enter a valid email address');
                isValid = false;
            }
        });
        
        // Step-specific validation
        if (stepIndex === 1) { // Employment and contribution step
            const contributionInput = step.querySelector('[name="initial_contribution"]');
            if (contributionInput) {
                const contribution = parseFloat(contributionInput.value);
                if (isNaN(contribution) || contribution < 12000) {
                    this.showValidationError(contributionInput, 'Initial contribution must be at least KSh 12,000');
                    isValid = false;
                }
            }
        } else if (stepIndex === 2) { // Password and terms step
            const passwordInput = step.querySelector('[name="password"]');
            const confirmPasswordInput = step.querySelector('[name="confirm_password"]');
            
            if (passwordInput && confirmPasswordInput) {
                if (passwordInput.value.length < 8) {
                    this.showValidationError(passwordInput, 'Password must be at least 8 characters long');
                    isValid = false;
                }
                
                if (passwordInput.value !== confirmPasswordInput.value) {
                    this.showValidationError(confirmPasswordInput, 'Passwords do not match');
                    isValid = false;
                }
            }
            
            const termsCheckbox = step.querySelector('[name="terms"]');
            if (termsCheckbox && !termsCheckbox.checked) {
                this.showValidationError(termsCheckbox, 'You must accept the terms and conditions');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    /**
     * Show validation error message
     * 
     * @param {HTMLElement} element - Form element with error
     * @param {string} message - Error message
     */
    static showValidationError(element, message) {
        // Remove any existing error message
        const existingError = element.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error message element
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message text-danger mt-1 small';
        errorElement.textContent = message;
        
        // Add error class to input
        element.classList.add('is-invalid');
        
        // Add error message after input
        element.parentNode.appendChild(errorElement);
    }
    
    /**
     * Validate email format
     * 
     * @param {string} email - Email address to validate
     * @return {boolean} Whether email is valid
     */
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    /**
     * Initialize password reset form
     * 
     * @param {string} formId - ID of the password reset form
     */
    static initializePasswordResetForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Reset previous validation errors
            const errorMessages = form.querySelector('.error-messages');
            const successMessage = form.querySelector('.success-message');
            
            if (errorMessages) {
                errorMessages.classList.add('d-none');
                errorMessages.textContent = '';
            }
            
            if (successMessage) {
                successMessage.classList.add('d-none');
            }
            
            // Show loading state
            const submitBtn = form.querySelector('[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
            
            // Validate email
            const emailInput = form.querySelector('[name="email"]');
            let isValid = true;
            
            if (!emailInput.value.trim()) {
                this.showValidationError(emailInput, 'Please enter your email address');
                isValid = false;
            } else if (!this.validateEmail(emailInput.value)) {
                this.showValidationError(emailInput, 'Please enter a valid email address');
                isValid = false;
            }
            
            if (isValid) {
                // Simulate form submission
                setTimeout(() => {
                    // Hide form
                    form.style.display = 'none';
                    
                    // Show success message
                    if (successMessage) {
                        successMessage.innerHTML = `
                            <h4>Password Reset Email Sent</h4>
                            <p>We have sent a password reset link to <strong>${emailInput.value}</strong>.</p>
                            <p>Please check your email and follow the instructions to reset your password.</p>
                            <div class="mt-4">
                                <a href="page-login.php" class="btn btn-primary">Return to Login</a>
                            </div>
                        `;
                        successMessage.classList.remove('d-none');
                    }
                    
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }, 1500);
            } else {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
}

// Initialize authentication when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize login form if present
    DaystarAuthentication.initializeLoginForm('login-form');
    
    // Initialize registration form if present
    DaystarAuthentication.initializeRegistrationForm('registration-form');
    
    // Initialize password reset form if present
    DaystarAuthentication.initializePasswordResetForm('password-reset-form');
});

// Export the authentication module for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarAuthentication;
}
