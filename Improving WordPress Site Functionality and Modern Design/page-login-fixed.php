<?php
/**
 * The template for displaying the login page
 *
 * @package daystar-coop
 */

get_header();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-coop-logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd." class="img-fluid" style="max-height: 80px;">
                    </div>
                    <h2>Member Login</h2>
                    <p class="text-muted">Access your account to view your savings, loans, and more</p>
                </div>
                
                <!-- Login Form with Improved Validation -->
                <form id="loginForm" method="post" action="<?php echo esc_url(home_url('process-login')); ?>" class="needs-validation" novalidate>
                    <!-- Error Messages Container -->
                    <div id="loginErrorMessages" class="alert alert-danger d-none mb-4"></div>
                    
                    <!-- Success Message Container -->
                    <div id="loginSuccessMessage" class="alert alert-success d-none mb-4"></div>
                    
                    <div class="mb-4">
                        <label for="memberNumber" class="form-label">Member Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="memberNumber" name="member_number" placeholder="Enter your member number" required>
                            <div class="invalid-feedback">Please enter your member number</div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback">Please enter your password</div>
                        </div>
                    </div>
                    
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="loginButton">
                            <span class="spinner-border spinner-border-sm d-none me-2" id="loginSpinner" role="status" aria-hidden="true"></span>
                            Login
                        </button>
                    </div>
                    
                    <div class="text-center mb-4">
                        <a href="<?php echo esc_url(home_url('forgot-password')); ?>">Forgot your password?</a>
                    </div>
                    
                    <div class="auth-divider">
                        <span>or</span>
                    </div>
                    
                    <div class="text-center">
                        <p class="mb-3">Don't have an account?</p>
                        <a href="<?php echo esc_url(home_url('register')); ?>" class="btn btn-outline-primary">Register Now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Login JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    // Form validation
    const form = document.getElementById('loginForm');
    const errorMessages = document.getElementById('loginErrorMessages');
    const successMessage = document.getElementById('loginSuccessMessage');
    const loginButton = document.getElementById('loginButton');
    const loginSpinner = document.getElementById('loginSpinner');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Clear previous error messages
            errorMessages.classList.add('d-none');
            errorMessages.textContent = '';
            successMessage.classList.add('d-none');
            
            // Show loading spinner
            loginButton.setAttribute('disabled', 'disabled');
            loginSpinner.classList.remove('d-none');
            
            // Validate form
            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                loginButton.removeAttribute('disabled');
                loginSpinner.classList.add('d-none');
                return;
            }
            
            // Get form data
            const formData = new FormData(form);
            
            // Simulate AJAX request (replace with actual AJAX in production)
            setTimeout(function() {
                // For demonstration purposes - in production, use actual AJAX
                const memberNumber = document.getElementById('memberNumber').value;
                
                // Simulate successful login
                if (memberNumber && password.value) {
                    successMessage.textContent = 'Login successful! Redirecting to dashboard...';
                    successMessage.classList.remove('d-none');
                    
                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = '<?php echo esc_url(home_url('member-dashboard')); ?>';
                    }, 2000);
                } else {
                    // Simulate login error
                    errorMessages.textContent = 'Invalid member number or password. Please try again.';
                    errorMessages.classList.remove('d-none');
                    loginButton.removeAttribute('disabled');
                    loginSpinner.classList.add('d-none');
                }
            }, 1500);
        });
    }
});
</script>

<?php get_footer(); ?>
