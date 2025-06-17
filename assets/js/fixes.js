/**
 * Daystar Multi-Purpose Co-op Society Ltd. JavaScript Fixes
 * This file contains fixes for JavaScript functionality issues
 */

document.addEventListener('DOMContentLoaded', function() {
    // Fix for mobile menu toggle
    const mobileMenuToggle = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (mobileMenuToggle && navbarCollapse) {
        mobileMenuToggle.addEventListener('click', function() {
            navbarCollapse.classList.toggle('show');
        });
    }
    
    // Fix for dropdown menus
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const dropdown = parent.querySelector('.dropdown-menu');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                if (menu !== dropdown) {
                    menu.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    
    // Fix for membership cards background color
    const membershipCards = document.querySelectorAll('.step-item');
    membershipCards.forEach(function(card) {
        card.style.backgroundColor = '#ffffff';
        card.style.color = '#333333';
    });
    
    // Fix for footer background color
    const footer = document.querySelector('.site-footer');
    if (footer) {
        footer.style.backgroundColor = '#00447c';
        footer.style.color = '#ffffff';
    }
    
    // Fix for WhatsApp button
    const whatsappButton = document.createElement('a');
    whatsappButton.href = 'https://wa.me/254731629716';
    whatsappButton.className = 'whatsapp-button';
    whatsappButton.target = '_blank';
    whatsappButton.rel = 'noopener noreferrer';
    whatsappButton.innerHTML = '<i class="fab fa-whatsapp"></i>';
    whatsappButton.setAttribute('aria-label', 'Contact us on WhatsApp');
    document.body.appendChild(whatsappButton);
    
    // Fix for preloader - REMOVE THIS ENTIRE BLOCK
    // const preloader = document.getElementById('preloader');
    // if (preloader) {
    //     window.addEventListener('load', function() {
    //         preloader.style.display = 'none';
    //     });
    //     
    //     // Fallback to hide preloader after 3 seconds
    //     setTimeout(function() {
    //         preloader.style.display = 'none';
    //     }, 3000);
    // }
    
    // Fix for scroll animations
    const fadeElements = document.querySelectorAll('.fade-in');
    
    function checkFade() {
        fadeElements.forEach(function(element) {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }
    
    // Initial check
    checkFade();
    
    // Check on scroll
    window.addEventListener('scroll', checkFade);
});
