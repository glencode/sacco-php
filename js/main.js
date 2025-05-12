/**
 * Main theme JavaScript file
 */
(function($) {
    'use strict';

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
    
})(jQuery); 