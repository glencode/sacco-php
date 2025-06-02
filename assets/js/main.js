/**
 * Main JavaScript file for Daystar Multi-Purpose Co-op Society Ltd. website
 * Includes all core functionality and fixes for the website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    initBootstrapComponents();
    
    // Fix navigation and dropdown issues
    fixNavigationIssues();
    
    // Fix styling issues
    fixStylingIssues();
    
    // Initialize animations
    initAnimations();
    
    // Initialize WhatsApp button
    initWhatsAppButton();
    
    // Remove preloader
    removePreloader();
});

/**
 * Initialize Bootstrap components
 */
function initBootstrapComponents() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

/**
 * Fix navigation and dropdown issues
 */
function fixNavigationIssues() {
    // Fix for mobile menu toggle
    const mobileMenuToggle = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (mobileMenuToggle && navbarCollapse) {
        mobileMenuToggle.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });
    }
    
    // Fix for dropdown menus
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const dropdown = parent.querySelector('.dropdown-menu');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                if (menu !== dropdown) {
                    menu.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    
    // Sticky navigation
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.classList.add('navbar-sticky');
            } else {
                navbar.classList.remove('navbar-sticky');
            }
        });
    }
}

/**
 * Fix styling issues
 */
function fixStylingIssues() {
    // Fix for membership cards background color
    const membershipCards = document.querySelectorAll('.step-item, .membership-card');
    membershipCards.forEach(function(card) {
        card.style.backgroundColor = '#ffffff';
        card.style.color = '#333333';
    });
    
    // Fix for footer background color
    const footer = document.querySelector('.site-footer');
    if (footer) {
        footer.style.backgroundColor = '#00447c';
        footer.style.color = '#ffffff';
    }
    
    // Fix for top bar
    const topBar = document.querySelector('.top-bar');
    if (topBar) {
        topBar.style.backgroundColor = '#00447c';
        topBar.style.color = '#ffffff';
    }
    
    // Fix for buttons
    const primaryButtons = document.querySelectorAll('.btn-primary');
    primaryButtons.forEach(function(button) {
        button.style.backgroundColor = '#00447c';
        button.style.borderColor = '#00447c';
    });
}

/**
 * Initialize animations
 */
function initAnimations() {
    // Fade-in animations
    const fadeElements = document.querySelectorAll('.fade-in');
    
    function checkFade() {
        fadeElements.forEach(function(element) {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }
    
    // Initial check
    checkFade();
    
    // Check on scroll
    window.addEventListener('scroll', checkFade);
    
    // Counter animations
    const counterElements = document.querySelectorAll('.counter-value');
    
    function startCounter() {
        counterElements.forEach(function(counter) {
            const elementTop = counter.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds
                const step = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateCounter = function() {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
            }
        });
    }
    
    // Check counters on scroll
    window.addEventListener('scroll', startCounter);
    
    // Initial check
    startCounter();
}

/**
 * Initialize WhatsApp button
 */
function initWhatsAppButton() {
    // Create WhatsApp button if it doesn't exist
    if (!document.querySelector('.whatsapp-button')) {
        const whatsappButton = document.createElement('a');
        whatsappButton.href = 'https://wa.me/254731629716';
        whatsappButton.className = 'whatsapp-button';
        whatsappButton.target = '_blank';
        whatsappButton.rel = 'noopener noreferrer';
        whatsappButton.innerHTML = '<i class="fab fa-whatsapp"></i>';
        whatsappButton.setAttribute('aria-label', 'Contact us on WhatsApp');
        document.body.appendChild(whatsappButton);
    }
}

/**
 * Remove preloader
 */
function removePreloader() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', function() {
            preloader.style.display = 'none';
        });
        
        // Fallback to hide preloader after 3 seconds
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 3000);
    }
}

/**
 * Login form functionality
 */
function initLoginForm() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;
    
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
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const errorMessages = document.getElementById('loginErrorMessages');
        const successMessage = document.getElementById('loginSuccessMessage');
        const loginButton = document.getElementById('loginButton');
        const loginSpinner = document.getElementById('loginSpinner');
        
        // Clear previous error messages
        errorMessages.classList.add('d-none');
        errorMessages.textContent = '';
        successMessage.classList.add('d-none');
        
        // Show loading spinner
        loginButton.setAttribute('disabled', 'disabled');
        loginSpinner.classList.remove('d-none');
        
        // Validate form
        if (!loginForm.checkValidity()) {
            event.stopPropagation();
            loginForm.classList.add('was-validated');
            loginButton.removeAttribute('disabled');
            loginSpinner.classList.add('d-none');
            return;
        }
        
        // Get form data
        const formData = new FormData(loginForm);
        
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
                    window.location.href = '/member-dashboard';
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

/**
 * Registration form functionality
 */
function initRegistrationForm() {
    const registrationForm = document.getElementById('registrationForm');
    if (!registrationForm) return;
    
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
    registrationForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const errorMessages = document.getElementById('registrationErrorMessages');
        const successMessage = document.getElementById('registrationSuccessMessage');
        const registerButton = document.getElementById('registerButton');
        const registerSpinner = document.getElementById('registerSpinner');
        
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
        if (!registrationForm.checkValidity()) {
            event.stopPropagation();
            registrationForm.classList.add('was-validated');
            registerButton.removeAttribute('disabled');
            registerSpinner.classList.add('d-none');
            return;
        }
        
        // Get form data
        const formData = new FormData(registrationForm);
        
        // Simulate AJAX request (replace with actual AJAX in production)
        setTimeout(function() {
            // For demonstration purposes - in production, use actual AJAX
            successMessage.textContent = 'Registration successful! Your application is being processed. You will receive an email with further instructions.';
            successMessage.classList.remove('d-none');
            
            // Reset form and go back to step 1
            registrationForm.reset();
            step3.classList.add('d-none');
            step1.classList.remove('d-none');
            progressBar.style.width = '33%';
            progressBar.setAttribute('aria-valuenow', '33');
            progressBar.textContent = 'Step 1 of 3';
            
            registerButton.removeAttribute('disabled');
            registerSpinner.classList.add('d-none');
            
            // Scroll to top of form
            registrationForm.scrollIntoView({ behavior: 'smooth' });
        }, 2000);
    });
}

// Initialize login and registration forms if they exist
document.addEventListener('DOMContentLoaded', function() {
    initLoginForm();
    initRegistrationForm();
});
