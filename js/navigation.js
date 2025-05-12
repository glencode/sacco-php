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

    // Initialize menu
    function initMenu() {
        // Setup mobile menu
        button.addEventListener('click', toggleMenu);
        document.addEventListener('click', handleClickOutside);
        window.addEventListener('resize', handleResize);
        window.addEventListener('scroll', handleScroll, { passive: true });

        // Initialize dropdowns
        initDropdowns();

        // Set initial states
        menu.classList.add('nav-menu');
        button.setAttribute('aria-expanded', 'false');

        // Add keyboard navigation support
        setupKeyboardNav();
    }

    // Toggle mobile menu
    function toggleMenu() {
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        siteNavigation.classList.toggle('toggled');
        button.setAttribute('aria-expanded', !isExpanded);
        
        // Handle body scroll lock
        document.body.style.overflow = isExpanded ? '' : 'hidden';
    }

    // Handle click outside menu
    function handleClickOutside(event) {
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

        // Reset any inline styles on submenus
        const submenus = menu.querySelectorAll('.sub-menu');
        submenus.forEach(submenu => {
            submenu.style.display = '';
            submenu.style.maxHeight = '';
        });
    }

    // Enhanced scroll behavior
    function handleScroll() {
        const currentScroll = window.pageYOffset;
        const scrollDelta = 10;
        const scrollThreshold = 100;

        // Toggle header classes based on scroll position
        if (currentScroll > scrollThreshold) {
            header.classList.add('scrolled');
            // Add glass effect class when not at top
            header.classList.add('glass-effect');
        } else {
            header.classList.remove('scrolled');
            header.classList.remove('glass-effect');
        }

        // Hide/show header based on scroll direction
        if (currentScroll > lastScroll && currentScroll > scrollThreshold) {
            // Scrolling down - hide header
            header.classList.add('header-hidden');
        } else {
            // Scrolling up - show header
            header.classList.remove('header-hidden');
        }

        lastScroll = currentScroll;
    }

    // Initialize dropdown menus
    function initDropdowns() {
        const dropdownLinks = menu.querySelectorAll('.menu-item-has-children > a');
        
        dropdownLinks.forEach(link => {
            const menuItem = link.parentElement;
            const submenu = menuItem.querySelector('.sub-menu');
            
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
                
                if (submenu) {
                    if (!isExpanded) {
                        // Opening submenu
                        submenu.style.display = 'block';
                        setTimeout(() => {
                            submenu.style.opacity = '1';
                            submenu.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        // Closing submenu
                        submenu.style.opacity = '0';
                        submenu.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            submenu.style.display = 'none';
                        }, 300);
                    }
                }
            });

            // Handle hover on desktop
            if (window.innerWidth > 991) {
                menuItem.addEventListener('mouseenter', () => {
                    if (submenu) {
                        submenu.style.display = 'block';
                        setTimeout(() => {
                            submenu.style.opacity = '1';
                            submenu.style.transform = 'translateY(0)';
                        }, 10);
                    }
                });

                menuItem.addEventListener('mouseleave', () => {
                    if (submenu) {
                        submenu.style.opacity = '0';
                        submenu.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            submenu.style.display = 'none';
                        }, 300);
                    }
                });
            }
        });
    }

    // Setup keyboard navigation
    function setupKeyboardNav() {
        document.addEventListener('keydown', (e) => {
            // Close menu on Escape
            if (e.key === 'Escape' && siteNavigation.classList.contains('toggled')) {
                toggleMenu();
            }

            // Add visible focus indicators when using keyboard
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-nav-active');
            }
        });

        // Remove keyboard focus indicators when using mouse
        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-nav-active');
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMenu);
    } else {
        initMenu();
    }
})();
