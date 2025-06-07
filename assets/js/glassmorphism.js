/**
 * Glassmorphism effects for UI elements
 */
document.addEventListener('DOMContentLoaded', function() {
    // Class for elements that should have glassmorphism effect
    const glassElements = document.querySelectorAll('.glassmorphism');

    // Apply initial glass effect
    glassElements.forEach(element => {
        applyGlassEffect(element);
    });

    // Helper function to apply glass effect
    function applyGlassEffect(element) {
        element.style.backgroundColor = 'var(--glass-bg)';
        element.style.backdropFilter = 'blur(10px)';
        element.style.webkitBackdropFilter = 'blur(10px)';
        element.style.borderRadius = 'var(--border-radius)';
        element.style.border = '1px solid var(--glass-border-color)';
        element.style.boxShadow = 'var(--box-shadow)';
    }

    // Add hover effect for interactive glass elements
    const interactiveGlassElements = document.querySelectorAll('.glassmorphism.interactive');
    
    interactiveGlassElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'all 0.3s ease';
        });

        element.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Add scroll effect for glass elements
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            window.cancelAnimationFrame(scrollTimeout);
        }

        scrollTimeout = window.requestAnimationFrame(function() {
            const scrolled = window.pageYOffset;
            glassElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const distance = Math.min(
                        Math.abs(window.innerHeight - rect.top),
                        Math.abs(rect.bottom)
                    );
                    const opacity = Math.min(1, distance / window.innerHeight);
                    element.style.opacity = 0.7 + (opacity * 0.3);
                }
            });
        });
    });
});
