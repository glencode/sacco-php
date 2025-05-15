<?php
/**
 * This script creates the Member Dashboard page in WordPress if it doesn't exist
 * 
 * Run this from the WordPress root directory with:
 * wp eval-file wp-content/themes/sacco-php/create-member-dashboard.php
 */

// Check if the dashboard page already exists
$existing_page = get_page_by_path('member-dashboard');

if (!$existing_page) {
    // Create the Member Dashboard page
    $dashboard_page = array(
        'post_title'    => 'Member Dashboard',
        'post_name'     => 'member-dashboard',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_content'  => '',
        'page_template' => 'page-member-dashboard.php'
    );
    
    // Insert the page into the database
    $page_id = wp_insert_post($dashboard_page);
    
    if ($page_id) {
        // Set the page template
        update_post_meta($page_id, '_wp_page_template', 'page-member-dashboard.php');
        echo "Member Dashboard page created successfully.\n";
    } else {
        echo "Failed to create Member Dashboard page.\n";
    }
} else {
    echo "Member Dashboard page already exists.\n";
    
    // Update the page template if needed
    if (get_post_meta($existing_page->ID, '_wp_page_template', true) !== 'page-member-dashboard.php') {
        update_post_meta($existing_page->ID, '_wp_page_template', 'page-member-dashboard.php');
        echo "Updated Member Dashboard page template.\n";
    }
}
