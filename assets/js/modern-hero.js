/**
 * Modern Hero Section JavaScript - Consolidated
 * Complete hero functionality including animations, interactions, and background effects
 */

/**
 * Initialize hero animations
 */
function initHeroAnimations() {
    // Animate elements on load
    const heroElements = document.querySelectorAll('.hero-main-content, .hero-quick-actions-panel');
    
    heroElements.forEach((element, index) => {
        if (element) {
            element.style.opacity = '0';
            element.style.transform = index === 0 ? 'translateX(-50px)' : 'translateX(50px)';
            
            setTimeout(() => {
                element.style.transition = 'all 1s cubic-bezier(0.4, 0, 0.2, 1)';
                element.style.opacity = '1';
                element.style.transform = 'translateX(0)';
            }, 300 + (index * 200));
        }
    });
    
    // Animate benefit items
    const benefitItems = document.querySelectorAll('.benefit-item');
    benefitItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 800 + (index * 100));
    });
}

/**
 * Initialize scroll indicator
 */
function initScrollIndicator() {
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', () => {
            const nextSection = document.querySelector('.homepage-sections-bg, .stats-section');
            if (nextSection) {
                nextSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
        
        // Hide scroll indicator when user scrolls
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.pointerEvents = 'none';
            } else {
                scrollIndicator.style.opacity = '1';
                scrollIndicator.style.pointerEvents = 'auto';
            }
        });
    }
}

/**
 * Initialize parallax effects
 */
function initParallaxEffects() {
    const shapes = document.querySelectorAll('.floating-shapes .shape');
    
    if (shapes.length === 0) return;
    
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        shapes.forEach((shape, index) => {
            const speed = 0.5 + (index * 0.1);
            shape.style.transform = `translateY(${rate * speed}px)`;
        });
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
    
    // Mouse movement parallax (only on larger screens)
    if (window.innerWidth > 768) {
        document.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            shapes.forEach((shape, index) => {
                const speed = 10 + (index * 5);
                const x = (mouseX - 0.5) * speed;
                const y = (mouseY - 0.5) * speed;
                
                shape.style.transform += ` translate(${x}px, ${y}px)`;
            });
        });
    }
}

/**
 * Initialize interactive elements
 */
function initInteractiveElements() {
    // Add hover effects to quick action cards
    const actionCards = document.querySelectorAll('.quick-action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateX(8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateX(0) scale(1)';
        });
    });
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn-primary-modern, .btn-secondary-modern');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add typewriter effect to title
    const titleLines = document.querySelectorAll('.hero-title span');
    titleLines.forEach((line, index) => {
        line.style.opacity = '0';
        line.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            line.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            line.style.opacity = '1';
            line.style.transform = 'translateY(0)';
        }, 1000 + (index * 300));
    });
}

/**
 * Initialize background effects
 */
function initBackgroundEffects() {
    const heroSection = document.querySelector('.modern-hero-section');
    
    if (heroSection) {
        // Test if background image loads
        const bgImage = new Image();
        bgImage.onload = function() {
            console.log('Hero background image loaded successfully');
            heroSection.classList.add('bg-loaded');
        };
        
        bgImage.onerror = function() {
            console.error('Failed to load hero background image');
            // Add fallback styling
            heroSection.style.background = 'linear-gradient(135deg, #006994 0%, #20B2AA 100%)';
        };
        
        // Use the WordPress theme directory path
        const themePath = window.location.origin + '/wp-content/themes/daystar-theme4 - Copy (3) - Copynewer/assets/images/hero-bg-1.jpg';
        bgImage.src = themePath;
    }
}

/**
 * Initialize simple parallax for background
 */
function initBackgroundParallax() {
    const heroSection = document.querySelector('.modern-hero-section');
    
    if (!heroSection || window.innerWidth <= 768) return;
    
    let ticking = false;
    
    function updateBackgroundParallax() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.3;
        
        heroSection.style.setProperty('--parallax-y', `${rate}px`);
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateBackgroundParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
}

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all hero functionality
    initHeroAnimations();
    initScrollIndicator();
    initParallaxEffects();
    initInteractiveElements();
    initBackgroundEffects();
    initBackgroundParallax();
    
    /**
     * Handle responsive behavior
     */
    function handleResponsive() {
        const heroGrid = document.querySelector('.hero-content-grid');
        const quickActionsPanel = document.querySelector('.hero-quick-actions-panel');
        
        function checkScreenSize() {
            if (window.innerWidth <= 992) {
                if (heroGrid) heroGrid.style.textAlign = 'center';
                if (quickActionsPanel) {
                    quickActionsPanel.style.maxWidth = '500px';
                    quickActionsPanel.style.margin = '0 auto';
                }
            } else {
                if (heroGrid) heroGrid.style.textAlign = 'left';
                if (quickActionsPanel) {
                    quickActionsPanel.style.maxWidth = 'none';
                    quickActionsPanel.style.margin = '0';
                }
            }
        }
        
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
    }
    
    handleResponsive();
    
    /**
     * Performance optimization
     */
    function optimizePerformance() {
        // Preload critical images
        const criticalImages = [
            '/wp-content/themes/daystar-theme4 - Copy (3) - Copynewer/assets/images/hero-bg-1.jpg'
        ];
        
        criticalImages.forEach(src => {
            const img = new Image();
            img.src = window.location.origin + src;
        });
    }
    
    optimizePerformance();
});

// Add CSS for ripple effect
const rippleCSS = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
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

// Inject ripple CSS
const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style);

// Add CSS custom properties support
document.documentElement.style.setProperty('--parallax-y', '0px');

// Export functions for external use if needed
window.HeroModule = {
    initHeroAnimations,
    initScrollIndicator,
    initParallaxEffects,
    initInteractiveElements,
    initBackgroundEffects,
    initBackgroundParallax
};