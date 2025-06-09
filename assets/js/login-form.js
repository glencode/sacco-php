// Login form handler
function initLoginForm() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!this.checkValidity()) {
            event.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        // Clear previous messages
        const messageDiv = loginForm.querySelector('.form-message');
        messageDiv.innerHTML = '';

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing in...';

        // Get redirect URL and nonce
        const redirectInput = this.querySelector('input[name="redirect_to"]');
        const redirectTo = redirectInput ? redirectInput.value : '';

        // Prepare form data
        const formData = new FormData(this);
        formData.append('action', 'daystar_login');
        formData.append('login_nonce', daystar_ajax.login_nonce);

        // Send AJAX request
        fetch(daystar_ajax.ajaxurl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                // Show success message
                messageDiv.innerHTML = '<div class="alert alert-success">Login successful! Redirecting...</div>';
                
                // Redirect to appropriate page
                let redirectUrl = '';
                
                if (response.data && response.data.redirect_to) {
                    redirectUrl = response.data.redirect_to;
                } else if (redirectTo) {
                    redirectUrl = redirectTo;
                } else {
                    // Default fallback
                    redirectUrl = window.location.origin + '/member-dashboard/';
                }
                
                // Small delay to show success message
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 500);
                
            } else {
                // Show error message
                let errorMessage = 'Login failed. Please try again.';
                if (response.data && response.data.message) {
                    errorMessage = response.data.message;
                }
                
                messageDiv.innerHTML = '<div class="alert alert-danger">' + errorMessage.replace(/(<([^>]+)>)/gi, "") + '</div>';
                
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            // Handle network errors
            console.error('Login error:', error);
            messageDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Handle password visibility toggle
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initLoginForm();
});