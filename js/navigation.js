/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */

// Enhanced navigation functionality
(function() {
    const siteNavigation = document.getElementById('site-navigation');
    const button = siteNavigation?.querySelector('.menu-toggle');
    const menu = siteNavigation?.querySelector('ul');
    const header = document.querySelector('.site-header');
    let lastScroll = 0;

    if (!siteNavigation || !button || !menu || !header) {
        return;
    }

    // Initialize mobile menu
    function initMobileMenu() {
        button.addEventListener('click', toggleMenu);
        document.addEventListener('click', closeMenuOnClickOutside);
        window.addEventListener('resize', handleResize);
    }

    // Toggle mobile menu
    function toggleMenu() {
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        siteNavigation.classList.toggle('toggled');
        button.setAttribute('aria-expanded', !isExpanded);
        
        // Prevent body scroll when menu is open
        document.body.style.overflow = isExpanded ? '' : 'hidden';
    }

    // Close menu when clicking outside
    function closeMenuOnClickOutside(event) {
        if (siteNavigation.classList.contains('toggled') && 
            !event.target.closest('.main-navigation') && 
            !event.target.closest('.menu-toggle')) {
            toggleMenu();
        }
    }

    // Handle window resize
    function handleResize() {
        if (window.innerWidth > 991 && siteNavigation.classList.contains('toggled')) {
            siteNavigation.classList.remove('toggled');
            button.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }

    // Enhanced scroll behavior
    function handleScroll() {
        const currentScroll = window.pageYOffset;
        const scrollDelta = 10;
        const scrollThreshold = 100;

        // Add or remove scrolled class based on scroll position
        if (currentScroll > scrollThreshold) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Hide/show header based on scroll direction
        if (currentScroll > lastScroll && currentScroll > scrollThreshold) {
            // Scrolling down
            header.classList.add('header-hidden');
        } else {
            // Scrolling up
            header.classList.remove('header-hidden');
        }

        lastScroll = currentScroll;
    }

    // Initialize dropdown menus
    function initDropdowns() {
        const dropdownLinks = menu.querySelectorAll('.menu-item-has-children > a');
        
        dropdownLinks.forEach(link => {
            // Add dropdown toggle button
            const toggleBtn = document.createElement('button');
            toggleBtn.classList.add('dropdown-toggle');
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.innerHTML = '<span class="screen-reader-text">Toggle Dropdown</span>';
            link.parentNode.insertBefore(toggleBtn, link.nextSibling);

            // Handle dropdown toggle
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                toggleBtn.closest('.menu-item-has-children').classList.toggle('sub-menu-active');
            });
        });
    }

    // Initialize everything
    function init() {
        initMobileMenu();
        initDropdowns();
        window.addEventListener('scroll', handleScroll, { passive: true });
        
        // Set initial states
        menu.classList.add('nav-menu');
        button.setAttribute('aria-expanded', 'false');
        
        // Add keyboard navigation support
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && siteNavigation.classList.contains('toggled')) {
                toggleMenu();
            }
        });
    }

    // Start when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
