document.addEventListener('DOMContentLoaded', function() {
    // Initialize number counters for stats
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const options = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalNumber = parseInt(target.getAttribute('data-count'));
                animateNumber(target, finalNumber);
                observer.unobserve(target);
            }
        });
    }, options);

    statNumbers.forEach(number => {
        observer.observe(number);
    });

    // Animate number function
    function animateNumber(element, final) {
        let start = 0;
        const duration = 2000;
        const step = final / (duration / 16);
        
        function updateNumber() {
            start += step;
            if (start < final) {
                element.textContent = Math.floor(start);
                requestAnimationFrame(updateNumber);
            } else {
                element.textContent = final;
            }
        }
        
        requestAnimationFrame(updateNumber);
    }

    // Add parallax effect to floating elements
    document.addEventListener('mousemove', function(e) {
        const floatingElements = document.querySelectorAll('.floating-element');
        
        floatingElements.forEach(element => {
            const speed = element.getAttribute('data-speed') || 5;
            const x = (window.innerWidth - e.pageX * speed) / 100;
            const y = (window.innerHeight - e.pageY * speed) / 100;
            
            element.style.transform = `translateX(${x}px) translateY(${y}px)`;
        });
    });

    // Initialize gradient text animation
    const gradientTexts = document.querySelectorAll('.gradient-text');
    
    gradientTexts.forEach(text => {
        text.addEventListener('mouseover', function() {
            this.style.backgroundSize = '200% auto';
            this.style.backgroundPosition = 'right center';
        });
        
        text.addEventListener('mouseout', function() {
            this.style.backgroundSize = '100% auto';
            this.style.backgroundPosition = 'left center';
        });
    });
});
