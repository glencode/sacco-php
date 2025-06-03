<?php
/**
 * Template Name: Password Reset Page
 * 
 * This is the template for the password reset page.
 * It allows members to request a password reset link.
 */

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Reset Password</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('login'); ?>">Login</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
            </ol>
        </nav>
    </div>
</div>

<section class="password-reset-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="card-title text-center mb-4">Reset Your Password</h2>
                        
                        <!-- Password Reset Form -->
                        <form id="password-reset-form" class="needs-validation" novalidate>
                            <!-- Error Messages -->
                            <div class="alert alert-danger d-none error-messages" role="alert"></div>
                            
                            <!-- Success Message -->
                            <div class="alert alert-success d-none success-message" role="alert"></div>
                            
                            <p class="mb-4">Enter your email address below and we'll send you a link to reset your password.</p>
                            
                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Send Reset Link
                                </button>
                            </div>
                        </form>
                        
                        <!-- Additional Links -->
                        <div class="mt-4 text-center">
                            <p>Remember your password? <a href="<?php echo home_url('login'); ?>">Back to Login</a></p>
                        </div>
                    </div>
                </div>
                
                <!-- Help Box -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Need Help?</h5>
                        <p>If you're having trouble resetting your password or need assistance, please contact our support team:</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone me-2"></i> +254 731 629 716</li>
                            <li><i class="fa fa-envelope me-2"></i> <a href="mailto:info@daystarsacco.co.ke">info@daystarsacco.co.ke</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize authentication module
        if (typeof DaystarAuthentication !== 'undefined') {
            DaystarAuthentication.initializePasswordResetForm('password-reset-form');
        }
    });
</script>

<?php get_footer(); ?>
