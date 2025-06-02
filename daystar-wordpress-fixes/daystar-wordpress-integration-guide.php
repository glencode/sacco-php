<?php
/**
 * Daystar Co-op WordPress Theme Integration
 * 
 * This file contains instructions for integrating all WordPress fixes
 * into the Daystar Multi-Purpose Co-op Society Ltd. website.
 */

/**
 * INTEGRATION INSTRUCTIONS
 * 
 * Follow these steps to properly integrate all fixes into your WordPress site:
 * 
 * 1. Create a child theme (recommended) or edit your current theme's functions.php
 * 2. Add the code from the three PHP files to your functions.php or as separate plugins
 * 3. Clear all caches after implementation
 * 4. Test all functionality
 */

/**
 * OPTION 1: Add to functions.php
 * 
 * Copy and paste the contents of these files into your theme's functions.php:
 * - daystar-wordpress-fixes.php
 * - daystar-wordpress-login-fixes.php
 * - daystar-wordpress-mpesa-integration.php
 */

/**
 * OPTION 2: Create separate plugins (RECOMMENDED)
 * 
 * For each file, create a separate plugin:
 * 
 * 1. Create folders in wp-content/plugins:
 *    - daystar-design-fixes
 *    - daystar-login-system
 *    - daystar-mpesa-integration
 * 
 * 2. In each folder, create a main PHP file with the same name as the folder
 *    and add the plugin header, then include the respective PHP file.
 * 
 * Example for daystar-design-fixes/daystar-design-fixes.php:
 * 
 * <?php
 * /**
 *  * Plugin Name: Daystar Design Fixes
 *  * Description: Fixes for Daystar Co-op WordPress theme design issues
 *  * Version: 1.0
 *  * Author: Daystar Developer
 *  * /
 * 
 * // Include the fixes
 * require_once plugin_dir_path(__FILE__) . 'fixes.php';
 * 
 * Then copy the content of daystar-wordpress-fixes.php into fixes.php
 */

/**
 * SHORTCODES USAGE
 * 
 * The following shortcodes are available:
 * 
 * [login_form] - Displays a custom login form
 * [registration_form] - Displays a custom registration form
 * [member_dashboard] - Displays the member dashboard
 * [mpesa_payment_form] - Displays the M-Pesa payment form
 * [payment_status] - Displays payment status
 * 
 * Create WordPress pages and add these shortcodes to the content.
 */

/**
 * PAGE SETUP
 * 
 * Create the following pages in WordPress:
 * 
 * 1. Login Page
 *    - Title: Member Login
 *    - Slug: login
 *    - Content: [login_form]
 * 
 * 2. Registration Page
 *    - Title: Become a Member
 *    - Slug: register
 *    - Content: [registration_form]
 * 
 * 3. Member Dashboard Page
 *    - Title: Member Dashboard
 *    - Slug: member-dashboard
 *    - Content: [member_dashboard]
 *    - Set page visibility to Private
 * 
 * 4. Payment Page
 *    - Title: Make a Payment
 *    - Slug: payment
 *    - Content: [mpesa_payment_form]
 *    - Set page visibility to Private
 * 
 * 5. Payment Status Page
 *    - Title: Payment Status
 *    - Slug: payment-status
 *    - Content: [payment_status]
 *    - Set page visibility to Private
 */

/**
 * MENU SETUP
 * 
 * 1. Go to Appearance > Menus
 * 2. Create a Primary Menu with your main navigation items
 * 3. Create a Footer Menu with important links
 * 4. Assign the menus to the appropriate locations
 */

/**
 * TROUBLESHOOTING
 * 
 * If you encounter issues:
 * 
 * 1. Clear all caches (WordPress, browser, any caching plugins)
 * 2. Check for JavaScript errors in the browser console
 * 3. Ensure all required plugins are active
 * 4. Check for theme compatibility issues
 * 5. Verify that jQuery is properly loaded
 * 6. Check PHP error logs for any backend issues
 */

/**
 * CACHE CLEARING
 * 
 * Add this code to clear all caches when activating the plugins:
 */
function daystar_clear_all_caches() {
    // Clear WordPress object cache
    wp_cache_flush();
    
    // Clear any page caching
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }
    
    // Clear Autoptimize cache if plugin is active
    if (class_exists('autoptimizeCache')) {
        autoptimizeCache::clearall();
    }
    
    // Clear W3 Total Cache if plugin is active
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    
    // Clear WP Super Cache if plugin is active
    if (function_exists('wp_cache_clean_cache')) {
        global $file_prefix;
        wp_cache_clean_cache($file_prefix, true);
    }
    
    // Add version timestamp to force browser cache refresh
    update_option('daystar_cache_buster', time());
}

/**
 * ADDITIONAL NOTES
 * 
 * 1. The M-Pesa integration requires proper API credentials from Safaricom
 * 2. Set up the M-Pesa credentials in the WordPress admin under Settings > M-Pesa Settings
 * 3. Ensure all callback URLs are properly configured in the Safaricom Developer Portal
 * 4. Test the payment system in sandbox mode before going live
 */
