<?php
/**
 * Template Name: New Password Set Page
 * 
 * This is the template for setting a new password after receiving a reset link.
 */

get_header();

// Get token from URL
$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Set New Password</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('login'); ?>">Login</a></li>
                <li class="breadcrumb-item active" aria-current="page">Set New Password</li>
            </ol>
        </nav>
    </div>
</div>

<section class="new-password-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="card-title text-center mb-4">Set New Password</h2>
                        
                        <?php if (empty($token)): ?>
                            <!-- Invalid Token Message -->
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Invalid Reset Link</h4>
                                <p>The password reset link is invalid or has expired. Please request a new password reset link.</p>
                                <hr>
                                <p class="mb-0">
                                    <a href="<?php echo home_url('password-reset'); ?>" class="btn btn-primary">Request New Reset Link</a>
                                </p>
                            </div>
                        <?php else: ?>
                            <!-- New Password Form -->
                            <form id="new-password-form" class="needs-validation" novalidate>
                                <!-- Error Messages -->
                                <div class="alert alert-danger d-none error-messages" role="alert"></div>
                                
                                <!-- Success Message -->
                                <div class="alert alert-success d-none success-message" role="alert"></div>
                                
                                <input type="hidden" name="token" value="<?php echo esc_attr($token); ?>">
                                
                                <p class="mb-4">Please enter your new password below.</p>
                                
                                <!-- New Password Field -->
                                <div class="mb-4">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        <button class="btn btn-outline-secondary password-toggle" type="button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Password must be at least 8 characters long.</div>
                                </div>
                                
                                <!-- Confirm Password Field -->
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        <button class="btn btn-outline-secondary password-toggle" type="button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        Set New Password
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
                        <!-- Additional Links -->
                        <div class="mt-4 text-center">
                            <p>Remember your password? <a href="<?php echo home_url('login'); ?>">Back to Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize password toggles
        const passwordToggles = document.querySelectorAll('.password-toggle');
        
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
        
        // Initialize form submission
        const form = document.getElementById('new-password-form');
        if (form) {
            form.addEventListener('submit', function(e) {
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
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                
                // Validate form
                let isValid = true;
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (newPassword.length < 8) {
                    showValidationError(document.getElementById('new_password'), 'Password must be at least 8 characters long');
                    isValid = false;
                }
                
                if (newPassword !== confirmPassword) {
                    showValidationError(document.getElementById('confirm_password'), 'Passwords do not match');
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
                                <h4>Password Reset Successful!</h4>
                                <p>Your password has been reset successfully.</p>
                                <div class="mt-4">
                                    <a href="<?php echo home_url('login'); ?>" class="btn btn-primary">Proceed to Login</a>
                                </div>
                            `;
                            successMessage.classList.remove('d-none');
                        }
                    }, 1500);
                } else {
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        }
        
        function showValidationError(element, message) {
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
    });
</script>

<?php get_footer(); ?>
