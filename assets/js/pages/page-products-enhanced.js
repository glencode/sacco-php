/**
 * Enhanced Products & Services Pages JavaScript
 * Adds interactive animations, smooth scrolling, and enhanced user experience
 */

document.addEventListener('DOMContentLoaded', function() {
    // Set background image with correct WordPress path
    setBackgroundImage();
    
    // Initialize enhanced animations and interactions
    initializeEnhancedAnimations();
    initializeProductCardInteractions();
    initializeScrollAnimations();
    initializeParallaxEffects();
    initializeEnhancedCalculator();
    initializeTestimonialSlider();
    initializeFilterAnimations();
    initializeFloatingElements();
    
    // Initialize AOS with custom settings
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100,
            delay: 100
        });
    }
});

/**
 * Set background image with correct WordPress path
 */
function setBackgroundImage() {
    const productsPage = document.querySelector('.products-page, .loan-product-page');
    if (!productsPage) return;
    
    // Try to get the theme directory URL from WordPress
    const themeUrl = window.location.origin + '/wp-content/themes/daystar-theme4 - Copy (3) - Copynewer';
    const imagePath = themeUrl + '/assets/images/productsimg.jpg';
    
    // Set the background image
    productsPage.style.backgroundImage = `
        url('${imagePath}'),
        url('../../images/productsimg.jpg'),
        url('../images/productsimg.jpg'),
        linear-gradient(135deg, #006994 0%, #20B2AA 50%, #40E0D0 100%)
    `;
    
    // Test if image loads
    const img = new Image();
    img.onload = function() {
        console.log('Background image loaded successfully:', imagePath);
        // Reduce overlay opacity when image loads
        const overlay = document.querySelector('.products-page::before, .loan-product-page::before');
        if (overlay) {
            document.documentElement.style.setProperty('--overlay-opacity', '0.1');
        }
    };
    img.onerror = function() {
        console.log('Background image failed to load:', imagePath);
        // Keep gradient background as fallback
    };
    img.src = imagePath;
}

/**
 * Initialize enhanced animations for page elements
 */
function initializeEnhancedAnimations() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                
                // Add staggered animation for child elements
                const children = entry.target.querySelectorAll('.product-card, .feature-card, .service-card, .step-item');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.style.opacity = '1';
                        child.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe fade-in elements
    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Initialize product card interactions - Optimized for Performance
 */
function initializeProductCardInteractions() {
    const productCards = document.querySelectorAll('.product-card, .feature-card, .service-card');
    
    productCards.forEach(card => {
        // Simplified hover effects - no heavy animations
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        // Simplified click animation
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a, button')) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-8px)';
                }, 150);
            }
        });
    });
}

/**
 * Initialize scroll animations
 */
function initializeScrollAnimations() {
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Progress indicator for long pages
    createScrollProgressIndicator();
}

/**
 * Create scroll progress indicator
 */
function createScrollProgressIndicator() {
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(135deg, #20B2AA, #40E0D0);
        z-index: 9999;
        transition: width 0.3s ease;
        box-shadow: 0 2px 10px rgba(32, 178, 170, 0.3);
    `;
    
    document.body.appendChild(progressBar);
    
    window.addEventListener('scroll', () => {
        const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        progressBar.style.width = scrolled + '%';
    });
}

/**
 * Initialize parallax effects - Disabled for Performance
 */
function initializeParallaxEffects() {
    // Parallax effects disabled to improve performance
    // Background image is now fixed via CSS
}

/**
 * Initialize enhanced calculator functionality
 */
function initializeEnhancedCalculator() {
    const calculatorForm = document.getElementById('loanCalculatorForm');
    if (!calculatorForm) return;
    
    // Add real-time calculation
    const inputs = calculatorForm.querySelectorAll('input[type="number"], input[type="range"]');
    inputs.forEach(input => {
        input.addEventListener('input', debounce(calculateLoanRealTime, 300));
    });
    
    // Add input animations
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.boxShadow = '0 8px 25px rgba(32, 178, 170, 0.2)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            this.parentElement.style.boxShadow = 'none';
        });
    });
}

/**
 * Real-time loan calculation
 */
function calculateLoanRealTime() {
    const loanAmount = document.getElementById('loanAmount');
    const loanTerm = document.getElementById('loanTerm');
    
    if (!loanAmount || !loanTerm) return;
    
    const principal = parseFloat(loanAmount.value) || 0;
    const months = parseInt(loanTerm.value) || 1;
    const annualRate = 0.12; // 12% per annum
    const monthlyRate = annualRate / 12;
    
    if (principal > 0 && months > 0) {
        const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
        const totalPayment = monthlyPayment * months;
        const totalInterest = totalPayment - principal;
        
        // Update results with animation
        updateResultWithAnimation('monthlyPayment', 'KSh ' + formatNumber(monthlyPayment.toFixed(2)));
        updateResultWithAnimation('totalInterest', 'KSh ' + formatNumber(totalInterest.toFixed(2)));
        updateResultWithAnimation('totalPayment', 'KSh ' + formatNumber(totalPayment.toFixed(2)));
    }
}

/**
 * Update result with animation
 */
function updateResultWithAnimation(elementId, value) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    element.style.transform = 'scale(1.1)';
    element.style.color = '#20B2AA';
    
    setTimeout(() => {
        element.textContent = value;
        element.style.transform = 'scale(1)';
        element.style.color = '';
    }, 150);
}

/**
 * Initialize testimonial slider enhancements
 */
function initializeTestimonialSlider() {
    const testimonialSlider = document.querySelector('.testimonials-slider');
    if (!testimonialSlider || typeof Swiper === 'undefined') return;
    
    new Swiper('.testimonials-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.testimonials-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.testimonials-next',
            prevEl: '.testimonials-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            }
        },
        effect: 'slide',
        speed: 800,
        on: {
            slideChange: function() {
                // Add slide change animation
                this.slides.forEach(slide => {
                    slide.style.transform = 'scale(0.9)';
                    slide.style.opacity = '0.7';
                });
                
                const activeSlide = this.slides[this.activeIndex];
                if (activeSlide) {
                    activeSlide.style.transform = 'scale(1)';
                    activeSlide.style.opacity = '1';
                }
            }
        }
    });
}

/**
 * Initialize filter animations
 */
function initializeFilterAnimations() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Filter products (if applicable)
            const filterValue = this.getAttribute('data-filter');
            if (filterValue) {
                filterProducts(filterValue);
            }
        });
    });
}

/**
 * Filter products with animation
 */
function filterProducts(filterValue) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach((product, index) => {
        const shouldShow = filterValue === 'all' || product.classList.contains(filterValue);
        
        if (shouldShow) {
            setTimeout(() => {
                product.style.display = 'block';
                product.style.opacity = '0';
                product.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    product.style.opacity = '1';
                    product.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        } else {
            product.style.opacity = '0';
            product.style.transform = 'translateY(-30px)';
            setTimeout(() => {
                product.style.display = 'none';
            }, 300);
        }
    });
}

/**
 * Initialize floating elements - Disabled for Performance
 */
function initializeFloatingElements() {
    // Floating elements disabled to improve performance and reduce cursor lag
    // Background effects are now handled via CSS only
}

/**
 * Utility function: Debounce
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Utility function: Format number with commas
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Initialize enhanced accordion functionality
 */
function initializeEnhancedAccordion() {
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
}

/**
 * Initialize enhanced form interactions
 */
function initializeEnhancedForms() {
    const formInputs = document.querySelectorAll('.form-control, .form-check-input');
    
    formInputs.forEach(input => {
        // Add focus animations
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
        
        // Add validation animations
        input.addEventListener('invalid', function() {
            this.style.borderColor = '#ff4757';
            this.style.boxShadow = '0 0 0 3px rgba(255, 71, 87, 0.2)';
        });
        
        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.style.borderColor = '#20B2AA';
                this.style.boxShadow = '0 0 0 3px rgba(32, 178, 170, 0.2)';
            }
        });
    });
}

/**
 * Initialize page load animations
 */
function initializePageLoadAnimations() {
    // Add page load animation
    document.body.style.opacity = '0';
    document.body.style.transform = 'translateY(20px)';
    
    window.addEventListener('load', () => {
        document.body.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        document.body.style.opacity = '1';
        document.body.style.transform = 'translateY(0)';
    });
}

/**
 * Initialize enhanced tooltips
 */
function initializeEnhancedTooltips() {
    // Create custom tooltips for better styling
    const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('title') || this.getAttribute('data-bs-original-title');
            if (tooltipText) {
                createCustomTooltip(this, tooltipText);
            }
        });
        
        element.addEventListener('mouseleave', function() {
            removeCustomTooltip();
        });
    });
}

/**
 * Create custom tooltip
 */
function createCustomTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: rgba(30, 41, 59, 0.95);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.875rem;
        z-index: 10000;
        pointer-events: none;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
    
    setTimeout(() => {
        tooltip.style.opacity = '1';
        tooltip.style.transform = 'translateY(0)';
    }, 50);
}

/**
 * Remove custom tooltip
 */
function removeCustomTooltip() {
    const tooltip = document.querySelector('.custom-tooltip');
    if (tooltip) {
        tooltip.style.opacity = '0';
        tooltip.style.transform = 'translateY(10px)';
        setTimeout(() => {
            tooltip.remove();
        }, 300);
    }
}

// Initialize all enhancements when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeEnhancedAccordion();
    initializeEnhancedForms();
    initializePageLoadAnimations();
    initializeEnhancedTooltips();
});

// Add CSS for enhanced animations
const enhancedStyles = document.createElement('style');
enhancedStyles.textContent = `
    .focused {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }
    
    .floating-shape {
        will-change: transform;
    }
    
    .custom-tooltip::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: rgba(30, 41, 59, 0.95);
    }
    
    .scroll-progress {
        will-change: width;
    }
    
    @media (prefers-reduced-motion: reduce) {
        .floating-shape,
        .scroll-progress,
        .custom-tooltip {
            animation: none !important;
            transition: none !important;
        }
    }
`;
document.head.appendChild(enhancedStyles);