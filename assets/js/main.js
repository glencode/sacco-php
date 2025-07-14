/**
 * Enhanced Main theme JavaScript file with Glassmorphism and Modern Effects
 * Addresses Swiper loop warnings and implements advanced animations
 */
(function($) {
    'use strict';

    // Global variables
    let heroSwiper = null;
    let isScrolling = false;
    let ticking = false;

    // Preloader handling with enhanced animations
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader, #preloader');
        if (preloader) {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
                // Initialize animations after preloader
                initFloatingElements();
                initParallaxEffects();
            }, 500);
        }
    });

    // Handle sticky header with smooth transition
    function handleScroll() {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const header = document.querySelector('.site-header');
                if (header) {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    if (scrollTop > 50) {
                        header.classList.add('scrolled', 'scroll-transition');
                    } else {
                        header.classList.remove('scrolled');
                    }
                }
                ticking = false;
            });
            ticking = true;
        }
    }

    // Scroll handler for sticky header
    function initStickyHeader() {
        const navbar = document.querySelector('.navbar.sticky-top');
        if (!navbar) return;

        function handleScroll() {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    if (scrollTop > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }

        // Add scroll event listener
        window.addEventListener('scroll', handleScroll, { passive: true });

        // Initialize header state on page load
        handleScroll();
    }

    // Add scroll event listener
    window.addEventListener('scroll', handleScroll, { passive: true });

    // Document ready
    $(document).ready(function() {
        initStickyHeader();
        // Initialize core functionality
        initNavbar();
        initSliders();
        initGlassmorphism();
        initAnimations();
        initMicroInteractions();
        
        // Initialize stat counters on front page
        if ($('.stat-number').length) {
            initCounters();
        }
        
        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // Form handlers
        initFormHandlers();
        
        // Initialize member functionality
        initMemberButton();
        
        // Smooth scrolling
        initSmoothScrolling();
        
        // Performance optimizations
        initScrollOptimizations();
    });

    // Initialize navbar with glassmorphism and scroll effects
    function initNavbar() {
        const navbar = document.querySelector('.main-navigation');
        if (!navbar) return;
        
        let lastScrollTop = 0;
        const scrollThreshold = 50; // Reduced threshold for faster response
        
        // Add body class for fixed navigation spacing
        document.body.classList.add('has-fixed-nav');
        
        // Ensure sticky positioning is properly applied
        function ensureStickyPosition() {
            // Force sticky positioning with fallback to fixed
            if (CSS.supports('position', 'sticky') || CSS.supports('position', '-webkit-sticky')) {
                navbar.style.position = 'sticky';
                navbar.style.webkitPosition = '-webkit-sticky';
            } else {
                navbar.style.position = 'fixed';
            }
            navbar.style.top = '0';
            navbar.style.zIndex = '9999';
            navbar.style.width = '100%';
        }
        
        // Apply sticky positioning immediately
        ensureStickyPosition();
        
        function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add/remove scrolled class for styling changes on ALL pages
            if (scrollTop > scrollThreshold) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Keep navbar always visible - remove hide/show behavior
            navbar.classList.remove('scroll-down');
            navbar.classList.add('scroll-up');
            
            // Ensure sticky position is maintained
            ensureStickyPosition();
            
            lastScrollTop = scrollTop;
        }
        
        // Initialize scroll state immediately for non-homepage pages
        if (!document.body.classList.contains('home')) {
            // For non-homepage pages, check initial scroll position
            const initialScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (initialScrollTop > scrollThreshold) {
                navbar.classList.add('scrolled');
            }
        }
        
        // Throttled scroll event
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Handle window resize to maintain sticky behavior
        window.addEventListener('resize', function() {
            ensureStickyPosition();
        });
        
        // Handle orientation change on mobile devices
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                ensureStickyPosition();
            }, 100);
        });
        
        // Enhanced dropdown functionality with proper hover states
        const dropdowns = navbar.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.nav-link');
            const menu = dropdown.querySelector('.dropdown-menu');
            const submenuIndicator = dropdown.querySelector('.submenu-indicator');
            
            if (toggle && menu) {
                let hoverTimeout;
                
                // Add submenu indicator if it doesn't exist
                if (!submenuIndicator) {
                    const indicator = document.createElement('i');
                    indicator.className = 'fas fa-chevron-down submenu-indicator';
                    toggle.appendChild(indicator);
                }
                
                dropdown.addEventListener('mouseenter', () => {
                    clearTimeout(hoverTimeout);
                    // Show dropdown with animation
                    menu.style.opacity = '1';
                    menu.style.visibility = 'visible';
                    menu.style.transform = 'translateY(0)';
                });
                
                dropdown.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        // Hide dropdown with animation
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateY(-10px)';
                    }, 150);
                });
                
                // Keyboard navigation support
                toggle.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const isVisible = menu.style.visibility === 'visible';
                        if (isVisible) {
                            menu.style.opacity = '0';
                            menu.style.visibility = 'hidden';
                            menu.style.transform = 'translateY(-10px)';
                        } else {
                            menu.style.opacity = '1';
                            menu.style.visibility = 'visible';
                            menu.style.transform = 'translateY(0)';
                        }
                    }
                });
            }
        });
        
        // Mobile menu toggle enhancement
        const mobileToggle = navbar.querySelector('.navbar-toggler');
        const navbarCollapse = navbar.querySelector('.navbar-collapse');
        
        if (mobileToggle && navbarCollapse) {
            mobileToggle.addEventListener('click', () => {
                // Add animation class
                navbarCollapse.classList.add('collapsing');
                setTimeout(() => {
                    navbarCollapse.classList.remove('collapsing');
                }, 350);
            });
        }
        
        // Active page highlighting
        const currentPath = window.location.pathname;
        const navLinks = navbar.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (linkPath === currentPath || (currentPath === '/' && link.href.includes('home'))) {
                link.classList.add('active');
                // Also add active class to parent nav item
                const parentNavItem = link.closest('.nav-item');
                if (parentNavItem) {
                    parentNavItem.classList.add('active');
                }
            }
        });
    }

    // Enhanced Slider Initialization (Fixed Swiper Loop Issues)
    function initSliders() {
        // Hero slider with proper configuration
        if ($('.hero-slider').length && typeof Swiper !== 'undefined') {
            try {
                const heroSlides = document.querySelectorAll('.hero-slider .swiper-slide');
                
                // Only enable loop if we have more than 1 slide
                const enableLoop = heroSlides.length > 1;
                
                heroSwiper = new Swiper('.hero-slider', {
                    loop: enableLoop,
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    autoplay: enableLoop ? {
                        delay: 5000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    } : false,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    speed: 1500,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    on: {
                        slideChange: function() {
                            // Switch slide content with animation
                            const activeIndex = this.realIndex;
                            $('.slide-content').removeClass('active').fadeOut(300);
                            setTimeout(() => {
                                $(`.slide-content[data-slide="${activeIndex}"]`).addClass('active').fadeIn(500);
                            }, 300);
                            
                            // Trigger custom event
                            $(document).trigger('heroSlideChanged', [activeIndex]);
                        },
                        init: function() {
                            // Initialize first slide content
                            $('.slide-content').removeClass('active').hide();
                            $('.slide-content[data-slide="0"]').addClass('active').show();
                        }
                    }
                });

                // Add glassmorphism to swiper controls
                $('.swiper-pagination-bullet').css({
                    'background': 'rgba(255, 255, 255, 0.5)',
                    'backdrop-filter': 'blur(10px)'
                });
                
                $('.swiper-pagination-bullet-active').css({
                    'background': 'rgba(255, 255, 255, 0.9)'
                });

            } catch (error) {
                console.error('Hero slider initialization failed:', error);
                // Fallback to simple slide rotation
                initFallbackSlider();
            }
        }
        
        // Testimonials slider with single slide configuration
        if ($('.testimonials-slider').length && typeof Swiper !== 'undefined') {
            const testimonialSlides = document.querySelectorAll('.testimonials-slider .swiper-slide');
            const enableTestimonialLoop = testimonialSlides.length > 1; // Enable loop if more than 1 slide
            
            if (testimonialSlides.length > 0) {
                new Swiper('.testimonials-slider', {
                    loop: enableTestimonialLoop,
                    slidesPerView: 1, // Always show only one testimonial
                    slidesPerGroup: 1,
                    centeredSlides: false,
                    autoplay: enableTestimonialLoop ? {
                        delay: 5000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    } : false,
                    spaceBetween: 0,
                    speed: 800,
                    effect: 'slide',
                    pagination: {
                        el: '.testimonials-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.testimonials-next',
                        prevEl: '.testimonials-prev',
                    },
                    // Remove breakpoints to ensure single slide on all devices
                    on: {
                        slideChange: function() {
                            // Add fade effect to testimonial content
                            $('.testimonial-card').removeClass('active');
                            setTimeout(() => {
                                $('.swiper-slide-active .testimonial-card').addClass('active');
                            }, 100);
                        },
                        init: function() {
                            // Initialize first slide as active
                            $('.swiper-slide-active .testimonial-card').addClass('active');
                        }
                    }
                });
            }
        }
    }

    // Fallback slider for when Swiper fails
    function initFallbackSlider() {
        const slides = $('.hero-slide');
        if (slides.length <= 1) return;
        
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.removeClass('active').eq(index).addClass('active');
            $('.slide-content').removeClass('active').eq(index).addClass('active');
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        // Auto-advance slides
        setInterval(nextSlide, 5000);
        
        // Initialize first slide
        showSlide(0);
    }

    // Glassmorphism Effects
    function initGlassmorphism() {
        // Remove inline styles to let CSS take precedence
        $('.hero-content-container').removeAttr('style');
        $('.quick-actions-panel').removeAttr('style');

        // Apply glassmorphism to stat cards
        $('.stat-item').css({
            'background': 'rgba(0, 90, 156, 0.1)',
            'backdrop-filter': 'blur(15px)',
            'border': '1px solid rgba(255, 255, 255, 0.2)',
            'border-radius': '12px',
            'transition': 'all 0.3s ease'
        });

        // Apply glassmorphism to service cards
        $('.service-card, .product-card').css({
            'background': 'rgba(255, 255, 255, 0.1)',
            'backdrop-filter': 'blur(15px)',
            'border': '1px solid rgba(255, 255, 255, 0.2)',
            'border-radius': '16px',
            'transition': 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)'
        });
    }

    // Advanced Animations
    function initAnimations() {
        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        }

        // Custom scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.stat-item, .service-card, .product-card').forEach(el => {
            observer.observe(el);
        });
    }

    // Micro-interactions
    function initMicroInteractions() {
        // Enhanced hover effects for cards
        $('.stat-item, .service-card, .product-card').hover(
            function() {
                $(this).css({
                    'transform': 'translateY(-8px) scale(1.02)',
                    'box-shadow': '0 12px 40px rgba(0, 90, 156, 0.2)'
                });
            },
            function() {
                $(this).css({
                    'transform': 'translateY(0) scale(1)',
                    'box-shadow': '0 8px 32px rgba(0, 0, 0, 0.1)'
                });
            }
        );

        // Button hover effects
        $('.btn').hover(
            function() {
                $(this).css({
                    'transform': 'translateY(-2px)',
                    'box-shadow': '0 8px 25px rgba(0, 90, 156, 0.3)'
                });
            },
            function() {
                $(this).css({
                    'transform': 'translateY(0)',
                    'box-shadow': 'none'
                });
            }
        );

        // Quick action items
        $('.quick-action-item').on('click', function() {
            const action = $(this).data('action');
            
            // Add click animation
            $(this).css('transform', 'scale(0.95)');
            setTimeout(() => {
                $(this).css('transform', 'scale(1)');
            }, 150);
            
            // Handle actions
            switch(action) {
                case 'login':
                    window.location.href = '/login';
                    break;
                case 'calculator':
                    window.location.href = '/loan-calculator';
                    break;
                case 'register':
                    window.location.href = '/register';
                    break;
            }
        });
    }

    // Floating Background Elements
    function initFloatingElements() {
        const heroSection = document.querySelector('.hero-section');
        if (!heroSection) return;

        // Create floating elements
        for (let i = 0; i < 6; i++) {
            const element = document.createElement('div');
            element.className = 'floating-element';
            element.style.cssText = `
                position: absolute;
                width: ${Math.random() * 100 + 50}px;
                height: ${Math.random() * 100 + 50}px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                top: ${Math.random() * 100}%;
                left: ${Math.random() * 100}%;
                animation: float ${Math.random() * 10 + 10}s infinite linear;
                pointer-events: none;
                z-index: 1;
            `;
            heroSection.appendChild(element);
        }

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
                50% { transform: translateY(-20px) rotate(180deg); opacity: 0.3; }
                100% { transform: translateY(0px) rotate(360deg); opacity: 0.7; }
            }
        `;
        document.head.appendChild(style);
    }

    // Parallax Effects
    function initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.parallax-element');
        
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    const scrolled = window.pageYOffset;
                    
                    parallaxElements.forEach(element => {
                        const speed = element.dataset.speed || 0.5;
                        const yPos = -(scrolled * speed);
                        element.style.transform = `translateY(${yPos}px)`;
                    });
                    
                    ticking = false;
                });
                ticking = true;
            }
        });
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

    // Form Handlers
    function initFormHandlers() {
        // Product Enquiry Form submission
        $('#productEnquiryForm').on('submit', function(e) {
            e.preventDefault();
            // Add loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.text('Sending...').prop('disabled', true);
            
            // Simulate form submission
            setTimeout(() => {
                alert('Thank you for your enquiry. We will get back to you shortly.');
                $(this).trigger('reset');
                submitBtn.text(originalText).prop('disabled', false);
            }, 1000);
        });
        
        // Contact Form submission
        $('.contact-form-native').on('submit', function(e) {
            e.preventDefault();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.text('Sending...').prop('disabled', true);
            
            setTimeout(() => {
                alert('Thank you for your message. We will get back to you shortly.');
                $(this).trigger('reset');
                submitBtn.text(originalText).prop('disabled', false);
            }, 1000);
        });
    }

    // Member button functionality
    function initMemberButton() {
        $('.member-login-btn').on('click', function(e) {
            e.preventDefault();
            
            try {
                // Check if user is logged in
                if (typeof wp !== 'undefined' && wp.ajax) {
                    // WordPress AJAX call to check login status
                    $.ajax({
                        url: wp.ajax.settings.url,
                        type: 'POST',
                        data: {
                            action: 'check_member_status',
                            nonce: wp.ajax.settings.nonce
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = response.data.redirect_url || '/member-portal';
                            } else {
                                window.location.href = '/login';
                            }
                        },
                        error: function() {
                            window.location.href = '/login';
                        }
                    });
                } else {
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Member button error:', error);
                window.location.href = '/login';
            }
        });
    }

    // Smooth scrolling
    function initSmoothScrolling() {
        $('.scroll-link').on('click', function(e) {
            e.preventDefault();
            var target = $(this.hash);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80 // Account for fixed navbar
                }, 800, 'easeInOutCubic');
            }
        });
    }

    // Performance optimizations
    function initScrollOptimizations() {
        // Throttled scroll handler
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(function() {
                // Scroll-based optimizations
                const scrollTop = window.pageYOffset;
                
                // Hide/show elements based on scroll
                if (scrollTop > 200) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            }, 100);
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // Add back to top button
    $(document).ready(function() {
        $('body').append('<button class="back-to-top" style="display:none;"><i class="fas fa-arrow-up"></i></button>');
        
        $('.back-to-top').css({
            'position': 'fixed',
            'bottom': '30px',
            'right': '30px',
            'width': '50px',
            'height': '50px',
            'background': 'rgba(0, 90, 156, 0.9)',
            'color': 'white',
            'border': 'none',
            'border-radius': '50%',
            'cursor': 'pointer',
            'z-index': '1000',
            'backdrop-filter': 'blur(10px)',
            'transition': 'all 0.3s ease'
        }).on('click', function() {
            $('html, body').animate({scrollTop: 0}, 800);
        });
    });

})(jQuery);