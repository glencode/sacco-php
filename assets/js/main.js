/**
 * Main theme JavaScript file
 */
(function($) {
    'use strict';

    // Preloader handling
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });

    // Document ready
    $(document).ready(function() {
        
        // Initialize any Swiper sliders on the page
        initSliders();
        
        // Initialize stat counters on front page
        if ($('.stat-number').length) {
            initCounters();
        }
        
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Product Enquiry Form submission
        $('#productEnquiryForm').on('submit', function(e) {
            e.preventDefault();
            // Here you would typically add AJAX to submit the form
            alert('Thank you for your enquiry. We will get back to you shortly.');
            $(this).trigger('reset');
        });
        
        // Contact Form submission (native form)
        $('.contact-form-native').on('submit', function(e) {
            e.preventDefault();
            // Here you would typically add AJAX to submit the form
            alert('Thank you for your message. We will get back to you shortly.');
            $(this).trigger('reset');
        });
    });
    
    // Initialize all Swiper sliders
    function initSliders() {
        // Hero slider on front page
        if ($('.hero-slider').length) {
            new Swiper('.hero-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
        
        // Testimonials slider
        if ($('.testimonials-slider').length) {
            new Swiper('.testimonials-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: true,
                },
                slidesPerView: 1,
                spaceBetween: 30,
                pagination: {
                    el: '.testimonials-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                },
            });
        }
    }
    
    // Initialize stat counters
    function initCounters() {
        $('.stat-number').each(function() {
            var $this = $(this);
            var countTo = parseInt($this.attr('data-count'));
            
            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum).toLocaleString());
                },
                complete: function() {
                    $this.text(this.countNum.toLocaleString());
                }
            });
        });
    }
    
    // Add smooth scrolling to all links with .scroll-link class
    $('.scroll-link').on('click', function(e) {
        e.preventDefault();
        var target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 70 // Adjust offset as needed
            }, 800);
        }
    });
    
    // Performance optimizations
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lazy loading
        initLazyLoading();
        
        // Initialize scroll performance optimizations
        initScrollOptimizations();
        
        // Initialize intersection observer for animations
        initAnimationObserver();
        
        // Initialize preloader
        initPreloader();

        // Load dynamic content
        loadDynamicContent();
        
        // Optimize scroll performance
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (!scrollTimeout) {
                window.requestAnimationFrame(() => {
                    // Handle scroll-based animations and loading
                    scrollTimeout = null;
                });
                scrollTimeout = true;
            }
        });

        // Optimize form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const submitButton = form.querySelector('[type="submit"]');
                if (submitButton) submitButton.disabled = true;
                
                try {
                    const formData = new FormData(form);
                    // Add your form submission logic here
                } catch (error) {
                    console.error('Form submission error:', error);
                } finally {
                    if (submitButton) submitButton.disabled = false;
                }
            });
        });

        // Navbar scroll effect
        const header = document.querySelector('nav.navbar.sticky-top');
        let lastScroll = 0;
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (header) { // Ensure header exists
                // Add/remove scrolled class
                if (currentScroll > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                // Hide/show header on scroll
                if (currentScroll > lastScroll && currentScroll > 500) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                }
            } // End if (header)
            lastScroll = currentScroll;
        });
    });

    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // Use native lazy loading
            const images = document.querySelectorAll('img[data-src]');
            images.forEach(img => {
                img.src = img.dataset.src;
                img.loading = 'lazy';
            });
        } else {
            // Fallback to Intersection Observer
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    function initScrollOptimizations() {
        let ticking = false;
        let lastKnownScrollPosition = 0;
        let scrollTimeout;

        // Throttle scroll events
        window.addEventListener('scroll', () => {
            lastKnownScrollPosition = window.scrollY;

            if (!ticking) {
                window.requestAnimationFrame(() => {
                    handleScroll(lastKnownScrollPosition);
                    ticking = false;
                });

                ticking = true;
            }

            // Debounce intensive operations
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                handleScrollEnd(lastKnownScrollPosition);
            }, 150);
        });
    }

    function handleScroll(scrollPos) {
        // Handle scroll-based animations efficiently
        const header = document.querySelector('nav.navbar.sticky-top'); // This header is locally scoped
        if (header) { // Check this local header
            if (scrollPos > 100) {
                header.classList.add('fixed-header');
            } else {
                header.classList.remove('fixed-header');
            }
        }
    }

    function handleScrollEnd(scrollPos) {
        // Handle operations that should happen after scrolling stops
        const backToTop = document.querySelector('.back-to-top');
        if (backToTop) {
            if (scrollPos > 500) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        }
    }

    function initAnimationObserver() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            animatedElements.forEach(element => {
                animationObserver.observe(element);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            animatedElements.forEach(element => {
                element.classList.add('animated');
            });
        }
    }

    function initPreloader() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            // Add loading state
            document.body.classList.add('loading');
            
            window.addEventListener('load', () => {
                // Remove preloader after all content is loaded
                setTimeout(() => {
                    preloader.classList.add('preloader-hidden');
                    document.body.classList.remove('loading');
                    
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 500);
                }, 500);
            });
        }
    }

    // Performance optimization for dynamic content loading
    const loadDynamicContent = () => {
        const intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    if (target.dataset.src) {
                        target.src = target.dataset.src;
                        target.removeAttribute('data-src');
                    }
                    if (target.dataset.background) {
                        target.style.backgroundImage = `url(${target.dataset.background})`;
                        target.removeAttribute('data-background');
                    }
                    intersectionObserver.unobserve(target);
                }
            });
        }, {
            rootMargin: '50px'
        });

        // Observe all elements with data-src or data-background
        document.querySelectorAll('[data-src], [data-background]').forEach(element => {
            intersectionObserver.observe(element);
        });
    };

    // Debounce utility function
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

    // Throttle utility function
    function throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Optimize resize handlers
    const optimizedResize = debounce(() => {
        // Handle resize operations here
    }, 250);

    window.addEventListener('resize', optimizedResize);

    // Resource hint preloading
    function preloadResources() {
        const resources = [
            { type: 'style', url: '/wp-content/themes/sacco-php/style.css' },
            { type: 'script', url: '/wp-content/themes/sacco-php/js/navigation.js' },
            // Add other critical resources
        ];

        resources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = resource.type === 'style' ? 'preload' : 'prefetch';
            link.as = resource.type === 'style' ? 'style' : 'script';
            link.href = resource.url;
            document.head.appendChild(link);
        });
    }

    // Initialize performance monitoring
    if ('performance' in window && 'PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                // Log performance metrics
                console.debug('Performance metric:', {
                    name: entry.name,
                    duration: entry.duration,
                    type: entry.entryType
                });
            });
        });

        // Observe various performance metrics
        observer.observe({ entryTypes: ['largest-contentful-paint', 'first-input', 'layout-shift'] });
    }

    // Initialize on page load
    preloadResources();

    // Scroll behavior and mobile menu functionality
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.querySelector('nav.navbar.sticky-top');
        const menuToggle = document.querySelector('.navbar-toggler');
        const mainNav = document.querySelector('#navbarMain');
        
        // Handle scroll events
        window.addEventListener('scroll', () => {
            if (header) { // Ensure header exists
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
        });

        // Handle mobile menu toggle
        if (menuToggle) { // Ensure menuToggle exists
            menuToggle.addEventListener('click', () => {
                if (mainNav) { // Keep inner check for mainNav as it's a separate element
                    mainNav.classList.toggle('toggled');
                }
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (mainNav && mainNav.classList.contains('toggled') &&
                !e.target.closest('#navbarMain') && // Adjusted selector
                (!menuToggle || !menuToggle.contains(e.target))) { // Keep menuToggle check here as it's part of the logic
                mainNav.classList.remove('toggled');
            }
        });
    });

})(jQuery);

// Main Custom Scripts

// Initialize AOS (Animate On Scroll)
// Ensure this is called after AOS library is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800, // values from 0 to 3000, with step 50ms
            easing: 'ease-in-out', // default easing for AOS animations
            once: true, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
        });
    }

    // Add sticky navbar functionality (basic example)
    const navbar = document.querySelector('.navbar'); // Adjust selector if needed
    if (navbar && navbar.classList.contains('sticky-top')) {
        let sticky = navbar.offsetTop;
        function stickyNavbar() {
            if (window.pageYOffset >= sticky + 50) { // Add class when scrolled past original position + offset
                // navbar.classList.add("navbar-sticky-active"); // Add a class to apply glassmorphism or other styles
            } else {
                // navbar.classList.remove("navbar-sticky-active");
            }
        }
        window.onscroll = function() { stickyNavbar() };
    }
});
