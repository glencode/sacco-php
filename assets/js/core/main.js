/**
 * Daystar Multi-Purpose Co-op Society - Main JavaScript
 * 
 * Core functionality and initialization for the Daystar website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    initBootstrapComponents();
    
    // Initialize navigation
    initNavigation();
    
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
 * Initialize navigation functionality
 */
function initNavigation() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (mobileMenuToggle && navbarCollapse) {
        mobileMenuToggle.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });
    }
    
    // Dropdown menus
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

// Export functions for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initBootstrapComponents,
        initNavigation,
        initAnimations,
        initWhatsAppButton,
        removePreloader
    };
}
