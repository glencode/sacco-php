<?php
/**
 * Template Name: Login Page
 * 
 * This is the template for the login page.
 * It includes the login form and password reset link.
 */

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Member Login</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </nav>
    </div>
</div>

<section class="login-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="card-title text-center mb-4">Member Login</h2>
                        
                        <!-- Login Form -->
                        <form id="login-form" class="needs-validation" novalidate>
                            <!-- Error Messages -->
                            <div class="alert alert-danger d-none error-messages" role="alert"></div>
                            
                            <!-- Success Message -->
                            <div class="alert alert-success d-none success-message" role="alert"></div>
                            
                            <!-- Member Number / Email Field -->
                            <div class="mb-4">
                                <label for="member_number" class="form-label">Member Number or Email</label>
                                <input type="text" class="form-control" id="member_number" name="member_number" required>
                                <div class="invalid-feedback">
                                    Please enter your member number or email.
                                </div>
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary password-toggle" type="button">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Please enter your password.
                                </div>
                            </div>
                            
                            <!-- Remember Me Checkbox -->
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                <label class="form-check-label" for="remember_me">Remember me</label>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Login
                                </button>
                            </div>
                        </form>
                        
                        <!-- Additional Links -->
                        <div class="mt-4 text-center">
                            <p><a href="<?php echo home_url('password-reset'); ?>">Forgot your password?</a></p>
                            <p>Don't have an account? <a href="<?php echo home_url('register'); ?>">Register now</a></p>
                        </div>
                    </div>
                </div>
                
                <!-- Help Box -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Need Help?</h5>
                        <p>If you're having trouble logging in or need assistance, please contact our support team:</p>
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
            DaystarAuthentication.initializeLoginForm('login-form');
        }
    });
</script>

<?php get_footer(); ?>
