<?php
/**
 * Admin page to safely run the testimonials population script
 * Add this to your functions.php or run it as a one-time admin page
 */

// Add admin menu item
function daystar_add_testimonials_admin_menu() {
    add_management_page(
        'Populate Testimonials',
        'Populate Testimonials',
        'manage_options',
        'daystar-populate-testimonials',
        'daystar_populate_testimonials_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_testimonials_admin_menu');

// Admin page callback
function daystar_populate_testimonials_admin_page() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    echo '<div class="wrap">';
    echo '<h1>Populate Testimonials</h1>';
    
    if (isset($_POST['populate_testimonials']) && wp_verify_nonce($_POST['_wpnonce'], 'populate_testimonials')) {
        echo '<div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; margin: 20px 0;">';
        
        // Include and run the population script
        require_once get_template_directory() . '/populate-testimonials.php';
        
        echo '</div>';
    } else {
        ?>
        <div class="card" style="background: #fff; border: 1px solid #ccd0d4; margin: 20px 0; padding: 20px;">
            <h2>Daystar SACCO Testimonials Population</h2>
            <p>This script will create testimonial categories and populate the testimonials CPT with authentic Kenyan testimonials.</p>
            
            <h3>What this script does:</h3>
            <ul>
                <li>Creates 11 testimonial categories for different pages/services</li>
                <li>Adds 35+ authentic Kenyan testimonials with proper meta data</li>
                <li>Categorizes testimonials appropriately for different pages</li>
                <li>Sets up the complete testimonials system</li>
            </ul>
            
            <h3>Before running:</h3>
            <ul>
                <li>Make sure you have a backup of your database</li>
                <li>Ensure the testimonial CPT is registered (should be automatic)</li>
                <li>This script is safe to run multiple times (won't create duplicates)</li>
            </ul>
            
            <form method="post">
                <?php wp_nonce_field('populate_testimonials'); ?>
                <p>
                    <input type="submit" name="populate_testimonials" class="button button-primary" value="Populate Testimonials" onclick="return confirm('Are you sure you want to populate testimonials? This will create new testimonial categories and testimonials.');">
                </p>
            </form>
        </div>
        
        <div class="card" style="background: #fff; border: 1px solid #ccd0d4; margin: 20px 0; padding: 20px;">
            <h3>After running the script:</h3>
            <ul>
                <li>Check <strong>Testimonials</strong> in your admin menu to see the new testimonials</li>
                <li>Check <strong>Testimonials > Testimonial Categories</strong> to see the categories</li>
                <li>Update your page templates to use the categorized testimonials</li>
                <li>Refer to the documentation for implementation examples</li>
            </ul>
        </div>
        <?php
    }
    
    echo '</div>';
}
?>