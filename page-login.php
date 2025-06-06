<?php
/**
 * The template for displaying the Login page - Improved Version
 *
 * This is the improved Login page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main login-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Member Login</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card fade-in">
                        <div class="auth-header text-center">
                            <div class="auth-logo mb-4">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>" class="img-fluid" style="max-height: 60px;">
                            </div>
                            <h2>Welcome Back</h2>
                            <p class="text-muted">Sign in to access your account</p>
                        </div>
                        
                        <div class="auth-body">
                            <form id="loginForm" class="auth-form" action="#" method="post">
                                <div class="form-group mb-3">
                                    <label for="memberNumber" class="form-label">Member Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="Enter your member number" required>
                                    </div>
                                    <div class="invalid-feedback">Please enter your member number</div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="password" class="form-label">Password</label>
                                        <a href="<?php echo esc_url(home_url('forgot-password')); ?>" class="small">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" aria-label="Toggle password visibility">
                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Please enter your password</div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me on this device
                                    </label>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                    <div class="form-message mt-3"></div>
                                </div>
                            </form>
                            
                            <div class="auth-divider">
                                <span>or</span>
                            </div>
                            
                            <div class="social-login">
                                <button class="btn btn-outline-secondary w-100 mb-3">
                                    <i class="fab fa-google me-2" aria-hidden="true"></i> Sign in with Google
                                </button>
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="fab fa-facebook-f me-2" aria-hidden="true"></i> Sign in with Facebook
                                </button>
                            </div>
                        </div>
                        
                        <div class="auth-footer text-center">
                            <p>Don't have an account? <a href="<?php echo esc_url(home_url('register')); ?>">Register Now</a></p>
                        </div>
                    </div>
                    
                    <div class="auth-help mt-4 text-center fade-in">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Need Help?</h5>
                                <p class="card-text">If you're having trouble logging in, please contact our support team.</p>
                                <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-sm btn-outline-primary">Contact Support</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Notice Section -->
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="security-notice fade-in">
                        <h3><i class="fas fa-shield-alt me-2" aria-hidden="true"></i> Security Notice</h3>
                        <ul class="security-tips">
                            <li>Never share your login credentials with anyone.</li>
                            <li>Ensure you're on the official website before entering your details.</li>
                            <li>We will never ask for your full password over the phone or via email.</li>
                            <li>Always log out when using public computers or devices.</li>
                            <li>Regularly update your password for enhanced security.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Login Form Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
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
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing in...';
            
            // Simulate API call (in a real implementation, this would be an actual API call)
            setTimeout(function() {
                // For demo purposes, show success message
                const formMessage = loginForm.querySelector('.form-message');
                formMessage.innerHTML = '<div class="alert alert-success">Login successful! Redirecting to dashboard...</div>';
                
                // Redirect to dashboard after a short delay
                setTimeout(function() {
                    window.location.href = '<?php echo esc_url(home_url('member-dashboard')); ?>';
                }, 1500);
            }, 2000);
        });
    }
    
    // Password visibility toggle
    const togglePassword = document.querySelector('.toggle-password');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
});
</script>

<?php
get_footer();
