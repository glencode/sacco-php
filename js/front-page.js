// Ensure critical dependencies are available
function ensureDependencies() {
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.warn('jQuery not loaded, attempting to load from CDN');
        loadScript('https://code.jquery.com/jquery-3.6.0.min.js', function() {
            console.log('jQuery loaded successfully');
            initializePage();
        });
        return;
    }

    // Check if Swiper is loaded
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper not loaded, attempting to load from CDN');
        loadScript('https://unpkg.com/swiper@8/swiper-bundle.min.js', function() {
            console.log('Swiper loaded successfully');
            initializePage();
        });
        return;
    }

    // Check if AOS is loaded
    if (typeof AOS === 'undefined') {
        console.warn('AOS not loaded, attempting to load from CDN');
        loadScript('https://unpkg.com/aos@2.3.1/dist/aos.js', function() {
            console.log('AOS loaded successfully');
            initializePage();
        });
        return;
    }

    // If all dependencies are loaded, initialize the page
    initializePage();
}

// Helper function to load scripts dynamically
function loadScript(url, callback) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    script.onload = callback;
    document.head.appendChild(script);
}

// Initialize page functionality
function initializePage() {
    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Hero Slider
        const heroSwiper = new Swiper('.hero-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 1000,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"><span class="bullet-inner"></span></span>';
                },
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                slideChangeTransitionStart: function () {
                    const activeSlide = this.slides[this.activeIndex];
                    const elements = activeSlide.querySelectorAll('.animate-in');
                    elements.forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(20px)';
                    });
                },
                slideChangeTransitionEnd: function () {
                    const activeSlide = this.slides[this.activeIndex];
                    const elements = activeSlide.querySelectorAll('.animate-in');
                    elements.forEach((el, index) => {
                        setTimeout(() => {
                            el.style.opacity = '1';
                            el.style.transform = 'translateY(0)';
                        }, index * 200);
                    });
                }
            }
        });

        // Partners Slider
        const partnersSwiper = new Swiper('.partners-slider', {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
            }
        });

        // Testimonials Slider
        const testimonialsSwiper = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.testimonials-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        // Stats Counter Animation
        function animateNumber(element, final, duration = 2000) {
            let start = 0;
            const increment = final > 1000 ? 10 : 1;
            const stepTime = Math.abs(Math.floor(duration / (final / increment)));
            
            const timer = setInterval(() => {
                start += increment;
                element.textContent = start.toLocaleString();
                
                if (start >= final) {
                    element.textContent = final.toLocaleString();
                    clearInterval(timer);
                }
            }, stepTime);
        }

        // Initialize counters when they come into view
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('stat-number')) {
                        const finalValue = parseInt(entry.target.dataset.value, 10);
                        animateNumber(entry.target, finalValue);
                    }
                    entry.target.classList.add('animated');
                    statsObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.stat-number').forEach(
            stat => statsObserver.observe(stat)
        );

        // Progress bar animation
        document.querySelectorAll('.stat-progress .progress-bar').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });

        // Floating Quick Nav Shadow on Scroll
        const quickNav = document.querySelector('.floating-quick-nav');
        if (quickNav) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    quickNav.classList.add('shadow-lg');
                } else {
                    quickNav.classList.remove('shadow-lg');
                }
            });
        }

        // Feature Cards hover effect with enhanced interaction
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.feature-hover').style.opacity = '1';
                this.querySelector('.feature-hover').style.transform = 'translateY(0)';
                
                const icon = this.querySelector('.feature-icon');
                icon.style.transform = 'rotateY(360deg)';
            });

            card.addEventListener('mouseleave', function() {
                this.querySelector('.feature-hover').style.opacity = '0';
                this.querySelector('.feature-hover').style.transform = 'translateY(20px)';
                
                const icon = this.querySelector('.feature-icon');
                icon.style.transform = 'rotateY(0deg)';
            });
        });

        // Parallax effect for hero section
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                heroSection.style.transform = `translateY(${scrolled * 0.4}px)`;
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
    });
}

// Run dependency check when DOM is ready
document.addEventListener('DOMContentLoaded', ensureDependencies);