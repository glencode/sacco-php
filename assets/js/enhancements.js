/**
 * Enhanced JavaScript functionality for SACCO PHP theme
 * Adds animations, counters, and interactive elements
 */

document.addEventListener('DOMContentLoaded', function() {
    // Preloader
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        window.addEventListener('load', function() {
            preloader.classList.add('loaded');
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        });
    }
    
    // Fade-in animations
    const fadeElements = document.querySelectorAll('.fade-in');
    
    function checkFade() {
        fadeElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const isVisible = (elementTop < window.innerHeight - 100) && (elementBottom > 0);
            
            if (isVisible) {
                element.classList.add('visible');
            }
        });
    }
    
    // Initial check
    checkFade();
    
    // Check on scroll
    window.addEventListener('scroll', checkFade);
    
    // Counter animation for stats
    const statNumbers = document.querySelectorAll('.stat-number');
    
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(function() {
            current += step;
            
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }
    
    function checkCounters() {
        statNumbers.forEach(counter => {
            const elementTop = counter.getBoundingClientRect().top;
            const isVisible = elementTop < window.innerHeight - 100;
            
            if (isVisible && !counter.classList.contains('counted')) {
                counter.classList.add('counted');
                animateCounter(counter);
            }
        });
    }
    
    // Initial check
    checkCounters();
    
    // Check on scroll
    window.addEventListener('scroll', checkCounters);
    
    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Mobile Menu Toggle (from main.js)
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    const mainNavigation = document.querySelector('.main-navigation');
    const menuOverlay = document.querySelector('.menu-overlay');
    
    if (menuToggle && mainNavigation) {
        menuToggle.addEventListener('click', function() {
            mainNavigation.classList.add('active');
            menuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (mobileMenuClose && mainNavigation) {
        mobileMenuClose.addEventListener('click', function() {
            mainNavigation.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    if (menuOverlay) {
        menuOverlay.addEventListener('click', function() {
            mainNavigation.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Submenu Toggle for Mobile
    const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children');
    
    menuItemsWithChildren.forEach(function(item) {
        const link = item.querySelector('a');
        
        // Create toggle button for submenu
        const toggleBtn = document.createElement('button');
        toggleBtn.classList.add('submenu-toggle');
        toggleBtn.setAttribute('aria-label', 'Toggle submenu');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-down" aria-hidden="true"></i>';
        
        link.parentNode.insertBefore(toggleBtn, link.nextSibling);
        
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            item.classList.toggle('active');
        });
    });
    
    // Sticky Navigation
    const header = document.getElementById('masthead');
    let lastScrollTop = 0;
    let ticking = false;
    
    function updateStickyNav() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const headerHeight = header ? header.offsetHeight : 100;
        
        if (scrollTop > headerHeight && scrollTop > lastScrollTop) {
            // Scrolling down
            header.classList.add('sticky');
        } else if (scrollTop <= 10) {
            // At top
            header.classList.remove('sticky');
        }
        
        lastScrollTop = scrollTop;
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateStickyNav);
            ticking = true;
        }
    }
    
    // Throttled scroll event
    window.addEventListener('scroll', requestTick, { passive: true });
    
    // Scroll indicator functionality
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', function() {
            const featuresSection = document.getElementById('features');
            
            if (featuresSection) {
                const headerOffset = 100;
                const elementPosition = featuresSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    }
    
    // Form validation for CTA form
    const ctaForm = document.querySelector('.cta-form');
    
    if (ctaForm) {
        const emailInput = ctaForm.querySelector('input[type="email"]');
        const submitButton = ctaForm.querySelector('button');
        
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (emailInput.value.trim() === '') {
                emailInput.style.borderColor = '#dc3545';
                
                // Create error message if it doesn't exist
                if (!ctaForm.querySelector('.error-message')) {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.style.color = '#dc3545';
                    errorMessage.style.fontSize = '0.875rem';
                    errorMessage.style.marginTop = '0.5rem';
                    errorMessage.textContent = 'Please enter your email address';
                    
                    ctaForm.appendChild(errorMessage);
                }
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                emailInput.style.borderColor = '#dc3545';
                
                // Create or update error message
                let errorMessage = ctaForm.querySelector('.error-message');
                
                if (!errorMessage) {
                    errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.style.color = '#dc3545';
                    errorMessage.style.fontSize = '0.875rem';
                    errorMessage.style.marginTop = '0.5rem';
                    ctaForm.appendChild(errorMessage);
                }
                
                errorMessage.textContent = 'Please enter a valid email address';
            } else {
                emailInput.style.borderColor = '#28a745';
                
                // Remove error message if it exists
                const errorMessage = ctaForm.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'success-message';
                successMessage.style.color = '#28a745';
                successMessage.style.fontSize = '0.875rem';
                successMessage.style.marginTop = '0.5rem';
                successMessage.textContent = 'Thank you! We\'ll be in touch soon.';
                
                ctaForm.appendChild(successMessage);
                
                // Reset form
                emailInput.value = '';
                
                // Remove success message after 3 seconds
                setTimeout(function() {
                    successMessage.remove();
                }, 3000);
            }
        });
        
        // Reset validation on input
        emailInput.addEventListener('input', function() {
            emailInput.style.borderColor = '';
            
            // Remove error message if it exists
            const errorMessage = ctaForm.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    }
    
    // Accessibility improvements - make dropdowns accessible via keyboard
    const navLinks = document.querySelectorAll('.main-navigation .menu-item-has-children > a');
    
    navLinks.forEach(link => {
        link.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                
                const parent = this.parentNode;
                const subMenu = parent.querySelector('.sub-menu');
                
                if (subMenu) {
                    const isVisible = getComputedStyle(subMenu).display !== 'none';
                    
                    if (!isVisible) {
                        // Hide all other submenus
                        document.querySelectorAll('.sub-menu').forEach(menu => {
                            menu.style.display = 'none';
                        });
                        
                        // Show this submenu
                        subMenu.style.display = 'block';
                        
                        // Focus the first link in the submenu
                        const firstLink = subMenu.querySelector('a');
                        if (firstLink) {
                            firstLink.focus();
                        }
                    } else {
                        subMenu.style.display = 'none';
                    }
                }
            }
        });
    });
    
    // Close submenus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-item-has-children')) {
            document.querySelectorAll('.sub-menu').forEach(menu => {
                menu.style.display = '';
            });
        }
    });
});
