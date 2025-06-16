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

// Modern Hero Slider with Glassmorphism
const modernHeroSlider = {
    currentSlide: 0,
    slides: [],
    autoplayInterval: null,
    autoplayDelay: 5000,

    init: function() {
        this.slides = document.querySelectorAll('.hero-slide');
        if (this.slides.length > 1) {
            this.createNavigation();
            this.bindEvents();
            this.startAutoplay();
        }
        this.initQuickActions();
    },

    createNavigation: function() {
        const heroSection = document.querySelector('.hero-section');
        const navContainer = document.createElement('div');
        navContainer.className = 'hero-nav';
        
        for (let i = 0; i < this.slides.length; i++) {
            const dot = document.createElement('div');
            dot.className = `hero-dot ${i === 0 ? 'active' : ''}`;
            dot.setAttribute('data-slide', i);
            navContainer.appendChild(dot);
        }
        
        heroSection.appendChild(navContainer);
    },

    bindEvents: function() {
        const self = this;
        
        // Dot navigation
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('hero-dot')) {
                const slideIndex = parseInt(e.target.getAttribute('data-slide'));
                self.goToSlide(slideIndex);
            }
        });

        // Pause on hover
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.addEventListener('mouseenter', () => self.stopAutoplay());
            heroSection.addEventListener('mouseleave', () => self.startAutoplay());
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.which === 37) { // Left arrow
                self.previousSlide();
            } else if (e.which === 39) { // Right arrow
                self.nextSlide();
            }
        });
    },

    goToSlide: function(index) {
        if (index === this.currentSlide) return;

        // Remove active class from current slide and dot
        this.slides[this.currentSlide].classList.remove('active');
        const currentDot = document.querySelector(`.hero-dot[data-slide="${this.currentSlide}"]`);
        if (currentDot) currentDot.classList.remove('active');

        // Update current slide
        this.currentSlide = index;

        // Add active class to new slide and dot
        this.slides[this.currentSlide].classList.add('active');
        const newDot = document.querySelector(`.hero-dot[data-slide="${this.currentSlide}"]`);
        if (newDot) newDot.classList.add('active');
    },

    nextSlide: function() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    },

    previousSlide: function() {
        const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(prevIndex);
    },

    startAutoplay: function() {
        const self = this;
        this.autoplayInterval = setInterval(function() {
            self.nextSlide();
        }, this.autoplayDelay);
    },

    stopAutoplay: function() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    },

    initQuickActions: function() {
        const quickActionItems = document.querySelectorAll('.quick-action-item');
        quickActionItems.forEach(item => {
            item.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                modernHeroSlider.handleQuickAction(action);
            });
        });
    },

    handleQuickAction: function(action) {
        const actions = {
            'login': '/login',
            'register': '/register',
            'calculator': '/loan-calculator',
            'contact': '/contact',
            'products': '/products-services',
            'about': '/about'
        };
        
        if (actions[action]) {
            window.location.href = actions[action];
        }
    }
};

// Statistics Counter Animation
const statsCounter = {
    init: function() {
        this.bindScrollEvent();
    },

    bindScrollEvent: function() {
        const self = this;
        window.addEventListener('scroll', function() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(function(element) {
                if (!element.classList.contains('counted') && self.isInViewport(element)) {
                    self.animateCounter(element);
                    element.classList.add('counted');
                }
            });
        });
    },

    isInViewport: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    },

    animateCounter: function(element) {
        const target = parseInt(element.getAttribute('data-count')) || parseInt(element.textContent.replace(/[^0-9]/g, ''));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }
};

// Dynamic Content Loader
const dynamicContentLoader = {
    init: function() {
        this.loadHeroSlides();
        this.loadStats();
        this.loadServices();
    },

    loadHeroSlides: function() {
        if (typeof daystar_ajax !== 'undefined') {
            fetch(daystar_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_hero_slides',
                    nonce: daystar_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.slides) {
                    this.updateHeroSlides(data.data.slides);
                }
            })
            .catch(error => console.log('Failed to load hero slides:', error));
        }
    },

    updateHeroSlides: function(slides) {
        const heroSlider = document.querySelector('.hero-slider');
        if (!heroSlider) return;
        
        heroSlider.innerHTML = '';

        slides.forEach((slide, index) => {
            const slideElement = document.createElement('div');
            slideElement.className = `hero-slide ${index === 0 ? 'active' : ''}`;
            slideElement.style.backgroundImage = `url('${slide.image}')`;
            
            slideElement.innerHTML = `
                <div class="hero-slide-content">
                    <h2>${slide.title}</h2>
                    <p>${slide.description}</p>
                </div>
            `;
            
            heroSlider.appendChild(slideElement);
        });

        // Reinitialize slider
        modernHeroSlider.init();
    },

    loadStats: function() {
        if (typeof daystar_ajax !== 'undefined') {
            fetch(daystar_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_homepage_stats',
                    nonce: daystar_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.updateStats(data.data);
                }
            })
            .catch(error => console.log('Failed to load stats:', error));
        }
    },

    updateStats: function(stats) {
        if (stats.members) {
            const membersElement = document.querySelector('.stat-number[data-stat="members"]');
            if (membersElement) membersElement.setAttribute('data-count', stats.members);
        }
        if (stats.loans_disbursed) {
            const loansElement = document.querySelector('.stat-number[data-stat="loans"]');
            if (loansElement) loansElement.setAttribute('data-count', stats.loans_disbursed);
        }
        if (stats.total_savings) {
            const savingsElement = document.querySelector('.stat-number[data-stat="savings"]');
            if (savingsElement) savingsElement.setAttribute('data-count', stats.total_savings);
        }
        if (stats.years_serving) {
            const yearsElement = document.querySelector('.stat-number[data-stat="years"]');
            if (yearsElement) yearsElement.setAttribute('data-count', stats.years_serving);
        }
    },

    loadServices: function() {
        if (typeof daystar_ajax !== 'undefined') {
            fetch(daystar_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_featured_services',
                    nonce: daystar_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.services) {
                    this.updateServices(data.data.services);
                }
            })
            .catch(error => console.log('Failed to load services:', error));
        }
    },

    updateServices: function(services) {
        const servicesGrid = document.querySelector('.services-grid');
        if (!servicesGrid) return;
        
        servicesGrid.innerHTML = '';

        services.forEach(service => {
            const serviceCard = document.createElement('div');
            serviceCard.className = 'service-card animate-on-scroll';
            serviceCard.innerHTML = `
                <i class="service-icon ${service.icon}"></i>
                <h3 class="service-title">${service.title}</h3>
                <p class="service-description">${service.description}</p>
                <a href="${service.link}" class="service-link">Learn More →</a>
            `;
            servicesGrid.appendChild(serviceCard);
        });
    }
};

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
    console.log('Initializing front page...');
    
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }
    
    // Initialize modern hero slider
    modernHeroSlider.init();
    
    // Initialize statistics counter
    statsCounter.init();
    
    // Load dynamic content
    dynamicContentLoader.init();
    
    // Initialize scroll animations
    initScrollAnimations();
    
    // Initialize parallax effects
    initParallaxEffects();
    
    // Initialize smooth scrolling
    initSmoothScrolling();
    
    // Initialize glassmorphism effects
    initGlassmorphismEffects();
    
    console.log('Front page initialization complete');
    
    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS with enhanced settings
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            delay: 100,
            easing: 'ease-out-cubic'
        });

        // Enhanced Hero Slider - Fixed loop warning
        const heroSlides = document.querySelectorAll('.hero-slider .swiper-slide');
        if (heroSlides.length > 0) {
            const heroSwiper = new Swiper('.hero-slider', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: heroSlides.length > 1, // Only enable loop if more than 1 slide
                autoplay: heroSlides.length > 1 ? {
                    delay: 6000,
                    disableOnInteraction: false,
                } : false,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 1500,
                parallax: true,
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
                    init: function() {
                        if (this.autoplay && heroSlides.length > 1) {
                            this.el.addEventListener('mouseenter', () => {
                                this.autoplay.stop();
                            });
                            this.el.addEventListener('mouseleave', () => {
                                this.autoplay.start();
                            });
                        }
                    },
                    slideChangeTransitionStart: function () {
                        const activeSlide = this.slides[this.activeIndex];
                        const elements = activeSlide.querySelectorAll('[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]');
                        elements.forEach(el => {
                            el.style.opacity = '0';
                            el.style.transform = 'translate3d(0, 50px, 0)';
                        });
                    },
                    slideChangeTransitionEnd: function () {
                        const activeSlide = this.slides[this.activeIndex];
                        const elements = activeSlide.querySelectorAll('[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]');
                        elements.forEach((el, index) => {
                            setTimeout(() => {
                                el.style.opacity = '1';
                                el.style.transform = 'translate3d(0, 0, 0)';
                                el.style.transition = 'transform 1s cubic-bezier(0.4, 0, 0.2, 1), opacity 1s cubic-bezier(0.4, 0, 0.2, 1)';
                            }, index * 200);
                        });
                    }
                }
            });
        }

        // Partners Slider - Fixed loop warning
        const partnerSlides = document.querySelectorAll('.partners-slider .swiper-slide');
        if (partnerSlides.length > 0) {
            const partnersSwiper = new Swiper('.partners-slider', {
                slidesPerView: 2,
                spaceBetween: 30,
                loop: partnerSlides.length > 5, // Only enable loop if more slides than max view
                autoplay: partnerSlides.length > 2 ? {
                    delay: 3000,
                    disableOnInteraction: false,
                } : false,
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
        }

        // Enhanced Testimonials Slider - Fixed loop warning
        const testimonialSlides = document.querySelectorAll('.testimonials-slider .swiper-slide');
        if (testimonialSlides.length > 0) {
            const testimonialsSlider = new Swiper('.testimonials-slider', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: testimonialSlides.length > 1, // Only enable loop if more than 1 slide
                autoplay: testimonialSlides.length > 1 ? {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                } : false,
                effect: 'coverflow',
                coverflowEffect: {
                    rotate: 15,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows: true,
                },
                speed: 800,
                centeredSlides: true,
                navigation: {
                    nextEl: '.testimonials-next',
                    prevEl: '.testimonials-prev',
                },
                pagination: {
                    el: '.testimonials-pagination',
                    clickable: true,
                    dynamicBullets: true,
                    renderBullet: function (index, className) {
                        return `<span class="${className}"></span>`;
                    },
                },
                breakpoints: {
                    480: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        effect: 'slide'
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                        effect: 'slide'
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        effect: 'slide'
                    }
                },
                on: {
                    init: function () {
                        // Add enhanced class to all testimonial cards
                        this.slides.forEach(slide => {
                            const card = slide.querySelector('.testimonial-card');
                            if (card) {
                                card.classList.add('enhanced');
                            }
                        });
                    },
                    slideChange: function () {
                        // Add enhanced animations
                        const activeSlide = this.slides[this.activeIndex];
                        if (activeSlide) {
                            const content = activeSlide.querySelectorAll('.testimonial-content, .testimonial-author, .testimonial-rating');
                            content.forEach((el, index) => {
                                el.style.opacity = '0';
                                el.style.transform = 'translateY(30px)';
                                setTimeout(() => {
                                    el.style.opacity = '1';
                                    el.style.transform = 'translateY(0)';
                                    el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                                }, index * 150);
                            });
                        }
                    },
                    transitionStart: function () {
                        // Add quote icon animation
                        this.slides.forEach(slide => {
                            const quoteIcon = slide.querySelector('.testimonial-quote-icon');
                            if (quoteIcon) {
                                quoteIcon.style.transform = 'scale(0.8) rotate(-10deg)';
                                quoteIcon.style.opacity = '0.5';
                            }
                        });
                    },
                    transitionEnd: function () {
                        // Reset quote icon animation
                        const activeSlide = this.slides[this.activeIndex];
                        if (activeSlide) {
                            const quoteIcon = activeSlide.querySelector('.testimonial-quote-icon');
                            if (quoteIcon) {
                                quoteIcon.style.transform = 'scale(1) rotate(0deg)';
                                quoteIcon.style.opacity = '0.2';
                                quoteIcon.style.transition = 'all 0.4s ease';
                            }
                        }
                    }
                }
            });
        }

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

        // Initialize preloader
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            window.addEventListener('load', function() {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            });
        }

        // Lazy load images
        const lazyImages = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('fade-in');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));

        // Header scroll behavior
        let lastScroll = 0;
        const header = document.querySelector('.site-header');
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                header.classList.remove('scroll-up');
                return;
            }
            
            if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
                // Scrolling down
                header.classList.remove('scroll-up');
                header.classList.add('scroll-down');
            } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
                // Scrolling up
                header.classList.remove('scroll-down');
                header.classList.add('scroll-up');
            }
            
            lastScroll = currentScroll;
        });

        // Performance optimizations
        // Debounce scroll and resize events
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

        // Efficient scroll handler
        const debouncedScroll = debounce(() => {
            const scrolled = window.pageYOffset;
            
            // Update floating nav opacity
            const floatingNav = document.querySelector('.floating-quick-nav');
            if (floatingNav) {
                floatingNav.style.opacity = scrolled > 100 ? '0.9' : '1';
            }
            
            // Update parallax elements
            document.querySelectorAll('.parallax').forEach(element => {
                const speed = element.dataset.speed || 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        }, 10);

        window.addEventListener('scroll', debouncedScroll);

        // Dynamic content loading for infinite scroll sections
        const loadMoreContent = async (container, page) => {
            try {
                const response = await fetch(`/wp-json/wp/v2/posts?page=${page}&per_page=6`);
                const posts = await response.json();
                
                posts.forEach(post => {
                    const postElement = createPostElement(post);
                    container.appendChild(postElement);
                });
                
                return posts.length > 0;
            } catch (error) {
                console.error('Error loading more content:', error);
                return false;
            }
        };

        // Initialize infinite scroll if container exists
        const contentContainer = document.querySelector('.infinite-scroll-container');
        if (contentContainer) {
            let currentPage = 1;
            let isLoading = false;
            
            const infiniteScrollObserver = new IntersectionObserver(async (entries) => {
                if (entries[0].isIntersecting && !isLoading) {
                    isLoading = true;
                    const hasMore = await loadMoreContent(contentContainer, ++currentPage);
                    isLoading = false;
                    
                    if (!hasMore) {
                        infiniteScrollObserver.disconnect();
                    }
                }
            });
            
            infiniteScrollObserver.observe(document.querySelector('.infinite-scroll-trigger'));
        }
    });

    // Dynamic content loading
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dynamic loading for testimonials
        initDynamicTestimonials();
        
        // Initialize dynamic loading for products
        initDynamicProducts();
        
        // Initialize intersection observer for animations
        initIntersectionObserver();
    });
}

// Scroll animations for elements
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

// Parallax effects for hero section
function initParallaxEffects() {
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.parallax-element');
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
}

// Smooth scrolling for anchor links
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            if (href && href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// Glassmorphism effect on scroll
function initGlassmorphismEffects() {
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const quickActionsPanel = document.querySelector('.quick-actions-panel');
        
        if (quickActionsPanel) {
            const opacity = Math.min(0.95, 0.7 + (scrolled / 1000));
            quickActionsPanel.style.backgroundColor = `rgba(255, 255, 255, ${opacity})`;
        }
    });
}

function initDynamicTestimonials() {
    const testimonialsContainer = document.querySelector('.testimonials-container');
    if (!testimonialsContainer) return;

    let page = 1;
    const loadMoreTestimonials = async () => {
        try {
            const response = await fetch(`/wp-json/wp/v2/testimonial?page=${page}&per_page=3`);
            const testimonials = await response.json();
            
            testimonials.forEach(testimonial => {
                const testimonialElement = createTestimonialElement(testimonial);
                testimonialsContainer.appendChild(testimonialElement);
            });
            
            page++;
        } catch (error) {
            console.error('Error loading testimonials:', error);
        }
    };

    // Intersection Observer for infinite scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadMoreTestimonials();
            }
        });
    }, { threshold: 0.5 });

    const loadMoreTrigger = document.querySelector('.load-more-testimonials');
    if (loadMoreTrigger) {
        observer.observe(loadMoreTrigger);
    }
}

function createTestimonialElement(testimonial) {
    const template = document.createElement('div');
    template.className = 'testimonial-card-home';
    template.setAttribute('data-aos', 'fade-up');
    template.innerHTML = `
        <div class="testimonial-content">
            <i class="fas fa-quote-left testimonial-icon"></i>
            <p>${testimonial.content.rendered}</p>
        </div>
        <div class="testimonial-author">
            <div class="testimonial-author-img">
                ${testimonial._embedded?.['wp:featuredmedia'] ? 
                    `<img src="${testimonial._embedded['wp:featuredmedia'][0].source_url}" alt="${testimonial.title.rendered}">` :
                    '<img src="/wp-content/themes/sacco-php/assets/images/default-avatar.png" alt="Default avatar">'}
            </div>
            <div class="testimonial-author-info">
                <h4 class="testimonial-author-name">${testimonial.title.rendered}</h4>
                <p class="testimonial-author-role">${testimonial.meta.role || ''}</p>
            </div>
        </div>
    `;
    return template;
}

function initDynamicProducts() {
    const productsContainer = document.querySelector('.products-container');
    if (!productsContainer) return;

    let productsPage = 1;
    const loadMoreProducts = async () => {
        try {
            const response = await fetch(`/wp-json/wp/v2/product?page=${productsPage}&per_page=6`);
            const products = await response.json();
            
            products.forEach(product => {
                const productElement = createProductElement(product);
                productsContainer.appendChild(productElement);
            });
            
            productsPage++;
        } catch (error) {
            console.error('Error loading products:', error);
        }
    };

    // Intersection Observer for products
    const productObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadMoreProducts();
            }
        });
    }, { threshold: 0.5 });

    const loadMoreProductsTrigger = document.querySelector('.load-more-products');
    if (loadMoreProductsTrigger) {
        productObserver.observe(loadMoreProductsTrigger);
    }
}

function createProductElement(product) {
    const template = document.createElement('div');
    template.className = 'product-card';
    template.setAttribute('data-aos', 'fade-up');
    template.innerHTML = `
        <div class="product-image">
            ${product._embedded?.['wp:featuredmedia'] ? 
                `<img src="${product._embedded['wp:featuredmedia'][0].source_url}" alt="${product.title.rendered}">` :
                '<img src="/wp-content/themes/sacco-php/assets/images/default-product.png" alt="Default product image">'}
        </div>
        <div class="product-content">
            <h3 class="product-title">${product.title.rendered}</h3>
            <div class="product-excerpt">${product.excerpt.rendered}</div>
            <a href="${product.link}" class="btn btn-primary">Learn More</a>
        </div>
    `;
    return template;
}

function initIntersectionObserver() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Lazy load images
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));

    // Animate elements on scroll
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    const elementObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });

    animatedElements.forEach(element => elementObserver.observe(element));
}

// Handle preloader
window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.classList.add('preloader-hidden');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

// Run dependency check when DOM is ready
document.addEventListener('DOMContentLoaded', ensureDependencies);