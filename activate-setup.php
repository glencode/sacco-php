<?php
/**
 * Quick activation script for loan pages setup
 * 
 * Add this code to the end of your functions.php file temporarily,
 * then visit any page of your website to trigger the setup.
 */

// Add this to your functions.php file temporarily
function daystar_auto_setup_loan_pages() {
    // Only run once
    if (get_option('daystar_loan_pages_setup_complete')) {
        return;
    }
    
    // Only run for admin users
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Include the setup script
    require_once get_template_directory() . '/setup-loan-pages.php';
    
    // Run the setup
    $results = daystar_setup_loan_pages();
    
    // Mark as complete
    update_option('daystar_loan_pages_setup_complete', true);
    
    // Show admin notice
    add_action('admin_notices', function() use ($results) {
        $class = $results['success'] ? 'notice-success' : 'notice-error';
        echo '<div class="notice ' . $class . ' is-dismissible">';
        echo '<p><strong>Loan Pages Setup:</strong> ' . esc_html($results['message']) . '</p>';
        if ($results['success']) {
            echo '<p><a href="' . home_url('/products-services/') . '" target="_blank">View Products & Services</a> | ';
            echo '<a href="' . admin_url('nav-menus.php') . '">Manage Menus</a></p>';
        }
        echo '</div>';
    });
}

// Hook to run on admin init
add_action('admin_init', 'daystar_auto_setup_loan_pages');

/**
 * Reset function - add this if you want to run setup again
 */
function daystar_reset_loan_pages_setup() {
    delete_option('daystar_loan_pages_setup_complete');
}

// Uncomment the line below if you want to reset and run setup again
// add_action('admin_init', 'daystar_reset_loan_pages_setup');