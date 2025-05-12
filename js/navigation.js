/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.querySelector( '.menu-toggle' );

	// Return early if the button doesn't exist.
	if ( ! button ) {
		return;
	}

	const menu = siteNavigation.querySelector( 'ul' );

	// Hide menu toggle button if menu is empty and return early.
	if ( ! menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	});

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	});

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// Toggle focus each time a menu link is focused or blurred.
	for ( const link of links ) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for ( const link of linksWithChildren ) {
		link.addEventListener( 'touchstart', toggleFocus, false );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( ! self.classList.contains( 'nav-menu' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}

		if ( event.type === 'touchstart' ) {
			const menuItem = this.parentNode;
			event.preventDefault();
			for ( const link of menuItem.parentNode.children ) {
				if ( menuItem !== link ) {
					link.classList.remove( 'focus' );
				}
			}
			menuItem.classList.toggle( 'focus' );
		}
	}

	// Mega Menu Functionality
	setupMegaMenu();

	function setupMegaMenu() {
		const menuItems = document.querySelectorAll('#primary-menu > li.menu-item-has-children');
		const megaMenuContainer = document.querySelector('.mega-menu-container');
		
		if (!menuItems.length || !megaMenuContainer) {
			return;
		}

		// Setup hovering on menu items
		menuItems.forEach(item => {
			// Check if the menu item has many children (indicating it could be a mega menu)
			const subMenu = item.querySelector('ul.sub-menu');
			
			if (subMenu && subMenu.children.length > 5) {
				// This should likely be a mega menu
				item.classList.add('has-mega-menu');
				
				// Store HTML for megamenu content
				item.megaMenuContent = createMegaMenuHTML(subMenu);
				
				// Add event listeners
				item.addEventListener('mouseenter', showMegaMenu);
				item.addEventListener('mouseleave', hideMegaMenu);
			}
		});

		// Add event listener to mega menu container 
		megaMenuContainer.addEventListener('mouseenter', () => {
			megaMenuContainer.classList.add('active');
		});
		megaMenuContainer.addEventListener('mouseleave', () => {
			megaMenuContainer.classList.remove('active');
			document.querySelector('.menu-item-has-children.active')?.classList.remove('active');
		});
	}

	function showMegaMenu() {
		// Set active class on menu item
		this.classList.add('active');
		
		// Add content to the mega menu container
		const megaMenuContainer = document.querySelector('.mega-menu-container');
		megaMenuContainer.innerHTML = this.megaMenuContent;
		
		// Show the mega menu
		megaMenuContainer.classList.add('active');
	}

	function hideMegaMenu() {
		// Check if the mouse is over the mega menu container
		const megaMenuContainer = document.querySelector('.mega-menu-container');
		
		if (!megaMenuContainer.matches(':hover')) {
			// If not hovering over mega menu, hide it
			this.classList.remove('active');
			megaMenuContainer.classList.remove('active');
		}
	}

	function createMegaMenuHTML(subMenu) {
		// Get all submenu items
		const items = Array.from(subMenu.children);
		const columns = Math.min(4, Math.ceil(items.length / 4)); // Max 4 columns
		
		let html = '<div class="row mega-menu-row">';
		
		// Create columns
		for (let i = 0; i < columns; i++) {
			html += '<div class="col-md-' + (12 / columns) + ' mega-menu-column">';
			html += '<ul class="mega-menu-items">';
			
			// Add items to this column
			const columnItems = items.slice(i * Math.ceil(items.length / columns), (i + 1) * Math.ceil(items.length / columns));
			
			for (const item of columnItems) {
				html += item.outerHTML;
			}
			
			html += '</ul>';
			html += '</div>';
		}
		
		html += '</div>';
		return html;
	}

	// Add scroll behavior for glassmorphic navbar
	function handleNavbarScroll() {
		const header = document.querySelector('.site-header');
		const scrollTrigger = 100; // Adjust this value as needed

		window.addEventListener('scroll', () => {
			if (window.scrollY > scrollTrigger) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
		});
	}

	// Initialize scroll behavior
	document.addEventListener('DOMContentLoaded', () => {
		handleNavbarScroll();
	});

	// Navbar scroll effect
	document.addEventListener('DOMContentLoaded', function() {
		const header = document.querySelector('.site-header');
		const scrollThreshold = 50;

		function handleScroll() {
			if (window.scrollY > scrollThreshold) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
		}

		window.addEventListener('scroll', handleScroll);
		// Initial check
		handleScroll();
	});
}() );
