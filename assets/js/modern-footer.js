/**
 * Modern Footer JavaScript Enhancements
 * Handles newsletter subscription, animations, and interactive features
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Newsletter Form Handling
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Basic email validation
            const email = emailInput.value.trim();
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            submitBtn.disabled = true;
            
            // Simulate API call (replace with actual implementation)
            setTimeout(() => {
                // Reset form
                emailInput.value = '';
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                
                // Show success message
                showNotification('Thank you for subscribing to our newsletter!', 'success');
            }, 2000);
        });
    }
    
    // Social Links Analytics Tracking
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const platform = this.classList.contains('facebook') ? 'Facebook' :
                           this.classList.contains('twitter') ? 'Twitter' :
                           this.classList.contains('instagram') ? 'Instagram' :
                           this.classList.contains('linkedin') ? 'LinkedIn' :
                           this.classList.contains('youtube') ? 'YouTube' : 'Unknown';
            
            // Track social media clicks (replace with your analytics implementation)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'social_click', {
                    'social_platform': platform,
                    'event_category': 'Footer',
                    'event_label': 'Social Media'
                });
            }
        });
    });
    
    // Footer Links Tracking
    const footerLinks = document.querySelectorAll('.footer-nav a, .footer-legal a');
    footerLinks.forEach(link => {
        link.addEventListener('click', function() {
            const linkText = this.textContent.trim();
            
            // Track footer link clicks
            if (typeof gtag !== 'undefined') {
                gtag('event', 'footer_link_click', {
                    'link_text': linkText,
                    'event_category': 'Footer',
                    'event_label': 'Navigation'
                });
            }
        });
    });
    
    // Smooth scroll for footer links that point to page sections
    const internalLinks = document.querySelectorAll('.footer-nav a[href^="#"], .footer-legal a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Enhanced Back to Top Button
    const backToTopBtn = document.querySelector('.back-to-top');
    if (backToTopBtn) {
        // Show/hide based on scroll position
        window.addEventListener('scroll', throttle(() => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        }, 100));
        
        // Smooth scroll to top
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add click animation
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Smooth scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Track back to top clicks
            if (typeof gtag !== 'undefined') {
                gtag('event', 'back_to_top_click', {
                    'event_category': 'Footer',
                    'event_label': 'Navigation'
                });
            }
        });
    }
    
    // Footer Animation on Scroll
    const footerSections = document.querySelectorAll('.footer-section');
    if (footerSections.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const footerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        footerSections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            footerObserver.observe(section);
        });
    }
    
    // Contact Information Click Handlers
    const contactItems = document.querySelectorAll('.contact-item');
    contactItems.forEach(item => {
        const icon = item.querySelector('.contact-icon i');
        const details = item.querySelector('.contact-details p');
        
        if (icon && details) {
            // Make phone numbers clickable
            if (icon.classList.contains('fa-phone')) {
                const phoneText = details.textContent.trim();
                const phoneNumbers = phoneText.match(/\+?\d[\d\s-]+/g);
                if (phoneNumbers && phoneNumbers.length > 0) {
                    const primaryPhone = phoneNumbers[0].replace(/\s/g, '');
                    item.style.cursor = 'pointer';
                    item.addEventListener('click', () => {
                        window.location.href = `tel:${primaryPhone}`;
                    });
                }
            }
            
            // Make email addresses clickable
            if (icon.classList.contains('fa-envelope')) {
                const emailText = details.textContent.trim();
                const emailMatch = emailText.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/);
                if (emailMatch) {
                    item.style.cursor = 'pointer';
                    item.addEventListener('click', () => {
                        window.location.href = `mailto:${emailMatch[0]}`;
                    });
                }
            }
            
            // Make addresses clickable (open in maps)
            if (icon.classList.contains('fa-map-marker-alt')) {
                item.style.cursor = 'pointer';
                item.addEventListener('click', () => {
                    const address = details.textContent.trim();
                    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
                    window.open(mapsUrl, '_blank');
                });
            }
        }
    });
    
    // Brand Name Animation
    const brandName = document.querySelector('.brand-name');
    if (brandName) {
        brandName.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        brandName.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
    
    // Newsletter Input Focus Effects
    const newsletterInput = document.querySelector('.newsletter-form input[type="email"]');
    if (newsletterInput) {
        newsletterInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.boxShadow = '0 8px 30px rgba(79, 195, 247, 0.3)';
        });
        
        newsletterInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
            this.parentElement.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.2)';
        });
    }
});

// Utility Functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `footer-notification footer-notification--${type}`;
    notification.innerHTML = `
        <div class="footer-notification__content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 350px;
        font-size: 14px;
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after delay
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Add CSS for notifications
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    .footer-notification__content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-notification__content i {
        font-size: 16px;
        flex-shrink: 0;
    }
    
    @media (max-width: 768px) {
        .footer-notification {
            right: 10px !important;
            left: 10px !important;
            max-width: none !important;
            transform: translateY(-100px) !important;
        }
        
        .footer-notification.show {
            transform: translateY(0) !important;
        }
    }
`;
document.head.appendChild(notificationStyles);