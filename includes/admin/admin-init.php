<?php
/**
 * Admin Initialization
 * Handles early admin setup and initialization
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize admin area
 */
function daystar_admin_init() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }

    // Buffer output to prevent header issues
    ob_start();
    
    // Include admin modules
    require_once get_template_directory() . '/includes/admin/admin-delinquency.php';
    
    // Remove default welcome panel
    remove_action('welcome_panel', 'wp_welcome_panel');
    
    // Add our custom welcome panel
    add_action('welcome_panel', 'daystar_welcome_panel');
}
add_action('admin_init', 'daystar_admin_init', 1);

/**
 * Custom welcome panel
 */
function daystar_welcome_panel() {
    if (!current_user_can('edit_posts')) {
        return;
    }
    
    $user = wp_get_current_user();
    ?>
    <div class="welcome-panel-content">
        <h2><?php _e('Welcome to Daystar SACCO Dashboard', 'daystar'); ?></h2>
        <p class="about-description">
            <?php 
            printf(
                __('Hello %s, welcome to your dashboard! Here you can manage your site and SACCO operations.', 'daystar'),
                '<strong>' . esc_html($user->display_name) . '</strong>'
            ); 
            ?>
        </p>
        
        <div class="welcome-panel-column-container">
            <div class="welcome-panel-column">
                <h3><?php _e('Quick Links', 'daystar'); ?></h3>
                <ul>
                    <li><?php printf('<a href="%s" class="welcome-icon welcome-view-site">' . __('View Your Site', 'daystar') . '</a>', esc_url(home_url('/'))); ?></li>
                    <li><?php printf('<a href="%s" class="welcome-icon welcome-edit-page">' . __('Manage Members', 'daystar') . '</a>', esc_url(admin_url('admin.php?page=daystar-admin-members'))); ?></li>
                    <li><?php printf('<a href="%s" class="welcome-icon welcome-edit-page">' . __('Manage Loans', 'daystar') . '</a>', esc_url(admin_url('admin.php?page=daystar-admin-loans'))); ?></li>
                </ul>
            </div>
            <div class="welcome-panel-column">
                <h3><?php _e('Loan Statistics', 'daystar'); ?></h3>
                <?php 
                if (function_exists('daystar_get_delinquency_statistics')) {
                    $stats = daystar_get_delinquency_statistics();
                    $total_delinquent = 0;
                    foreach ($stats as $status => $stat) {
                        if ($status !== 'current') {
                            $total_delinquent += $stat['loan_count'];
                        }
                    }
                    echo '<p><strong>Delinquent Loans:</strong> ' . $total_delinquent . '</p>';
                    
                    if (isset($stats[DAYSTAR_DELINQUENCY_90_PLUS])) {
                        echo '<p><strong>90+ Days Overdue:</strong> ' . $stats[DAYSTAR_DELINQUENCY_90_PLUS]['loan_count'] . '</p>';
                    }
                }
                ?>
            </div>
            <div class="welcome-panel-column welcome-panel-last">
                <h3><?php _e('Recent Activity', 'daystar'); ?></h3>
                <?php 
                // Add recent activity here
                ?>
            </div>
        </div>
    </div>
    <?php
}
