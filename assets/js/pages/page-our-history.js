/**
 * Our History Page JavaScript
 * Handles animations, counters, and interactive elements
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize AOS (Animate On Scroll) if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true,
            offset: 100
        });
    }
    
    // Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    if (current > target) current = target;
                    
                    // Format large numbers
                    if (target >= 1000000000) {
                        counter.textContent = (current / 1000000000).toFixed(1) + 'B';
                    } else if (target >= 1000000) {
                        counter.textContent = (current / 1000000).toFixed(1) + 'M';
                    } else if (target >= 1000) {
                        counter.textContent = (current / 1000).toFixed(0) + 'K';
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                    
                    requestAnimationFrame(updateCounter);
                }
            };
            
            updateCounter();
        });
    }
    
    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                counterObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe hero stats section
    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) {
        counterObserver.observe(heroStats);
    }
    
    // Timeline item hover effects
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach(item => {
        const card = item.querySelector('.timeline-card');
        const dot = item.querySelector('.timeline-dot');
        
        if (card && dot) {
            card.addEventListener('mouseenter', () => {
                dot.style.transform = 'translateX(-50%) scale(1.2)';
                dot.style.boxShadow = '0 15px 40px rgba(96, 165, 250, 0.6)';
            });
            
            card.addEventListener('mouseleave', () => {
                dot.style.transform = 'translateX(-50%) scale(1)';
                dot.style.boxShadow = '0 8px 25px rgba(96, 165, 250, 0.4)';
            });
        }
    });
    
    // Achievement cards animation on scroll
    const achievementCards = document.querySelectorAll('.achievement-card');
    const achievementObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                achievementObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    achievementCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        achievementObserver.observe(card);
    });
    
    // Parallax effect for background layers
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallaxLayers = document.querySelectorAll('.parallax-layer');
        
        parallaxLayers.forEach((layer, index) => {
            const speed = (index + 1) * 0.1;
            const yPos = -(scrolled * speed);
            layer.style.transform = `translateY(${yPos}px)`;
        });
    }
    
    // Throttled scroll event for parallax
    let ticking = false;
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', () => {
        requestTick();
        ticking = false;
    });
    
    // Smooth scroll for internal links
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Timeline progress indicator
    function updateTimelineProgress() {
        const timeline = document.querySelector('.timeline');
        if (!timeline) return;
        
        const timelineRect = timeline.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const timelineTop = timelineRect.top;
        const timelineHeight = timelineRect.height;
        
        // Calculate progress (0 to 1)
        let progress = 0;
        if (timelineTop < windowHeight && timelineTop + timelineHeight > 0) {
            const visibleTop = Math.max(0, windowHeight - timelineTop);
            const visibleHeight = Math.min(timelineHeight, visibleTop);
            progress = visibleHeight / timelineHeight;
        }
        
        // Update timeline line gradient
        const timelineLine = timeline.querySelector('::before');
        if (timelineLine) {
            const gradientStop = Math.min(100, progress * 100);
            timeline.style.setProperty('--timeline-progress', `${gradientStop}%`);
        }
    }
    
    // Add CSS custom property for timeline progress
    const style = document.createElement('style');
    style.textContent = `
        .timeline::before {
            background: linear-gradient(180deg, 
                #60a5fa 0%, 
                #3b82f6 var(--timeline-progress, 0%), 
                rgba(96, 165, 250, 0.3) var(--timeline-progress, 0%), 
                rgba(96, 165, 250, 0.1) 100%);
        }
    `;
    document.head.appendChild(style);
    
    // Update timeline progress on scroll
    window.addEventListener('scroll', updateTimelineProgress);
    updateTimelineProgress(); // Initial call
    
    // Add loading animation for timeline items
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
                timelineObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    
    timelineItems.forEach(item => {
        timelineObserver.observe(item);
    });
    
    // Add ripple effect to buttons
    function createRipple(event) {
        const button = event.currentTarget;
        const circle = document.createElement('span');
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;
        
        circle.style.width = circle.style.height = `${diameter}px`;
        circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
        circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
        circle.classList.add('ripple');
        
        const ripple = button.getElementsByClassName('ripple')[0];
        if (ripple) {
            ripple.remove();
        }
        
        button.appendChild(circle);
    }
    
    // Add ripple effect CSS
    const rippleStyle = document.createElement('style');
    rippleStyle.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(rippleStyle);
    
    // Apply ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', createRipple);
    });
    
    // Add floating animation to achievement icons
    const achievementIcons = document.querySelectorAll('.achievement-icon');
    achievementIcons.forEach((icon, index) => {
        icon.style.animationDelay = `${index * 0.2}s`;
        icon.classList.add('floating');
    });
    
    // Add floating animation CSS
    const floatingStyle = document.createElement('style');
    floatingStyle.textContent = `
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    `;
    document.head.appendChild(floatingStyle);
    
    // Add typewriter effect to hero title (optional enhancement)
    function typewriterEffect(element, text, speed = 100) {
        element.textContent = '';
        let i = 0;
        
        function typeChar() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeChar, speed);
            }
        }
        
        typeChar();
    }
    
    // Apply typewriter effect to hero title if desired
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle && heroTitle.textContent) {
        const originalText = heroTitle.textContent;
        // Uncomment the line below to enable typewriter effect
        // typewriterEffect(heroTitle, originalText, 150);
    }
    
    // Add scroll-triggered animations for goal cards
    const goalCards = document.querySelectorAll('.goal-card');
    const goalObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, index * 150);
                goalObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    goalCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px) scale(0.9)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        goalObserver.observe(card);
    });
    
    // Performance optimization: Reduce animations on low-end devices
    const isLowEndDevice = navigator.hardwareConcurrency <= 2 || 
                          navigator.deviceMemory <= 2 || 
                          /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isLowEndDevice) {
        // Disable some animations for better performance
        document.body.classList.add('reduced-motion');
        
        const reducedMotionStyle = document.createElement('style');
        reducedMotionStyle.textContent = `
            .reduced-motion * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        `;
        document.head.appendChild(reducedMotionStyle);
    }
    
    console.log('History page JavaScript initialized successfully');
});