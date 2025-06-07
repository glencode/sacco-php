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
                            <form id="loginForm" class="auth-form needs-validation" novalidate>
                                <?php wp_nonce_field('daystar_login', 'login_nonce'); ?>
                                <?php 
                                // Preserve the redirect_to parameter if it exists
                                $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url('/member-dashboard');
                                ?>
                                <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>">
                                
                                <div class="form-group mb-3">
                                    <label for="member_number" class="form-label">Member Number or Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="member_number" name="member_number" placeholder="Enter your member number or email" required>
                                    </div>
                                    <div class="invalid-feedback">Please enter your member number or email</div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="password" class="form-label">Password</label>
                                        <a href="<?php echo esc_url(home_url('password-reset')); ?>" class="small">Forgot Password?</a>
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
                            
                            <?php if (isset($_GET['login_error'])): ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo esc_html(urldecode($_GET['login_error'])); ?>
                            </div>
                            <?php endif; ?>
                            
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

<!-- Login Form Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    initLoginForm();
});
</script>

<?php
get_footer();
