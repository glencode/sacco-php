<?php
/**
 * Admin page to run the loan pages setup
 * 
 * Add this to your WordPress admin to run the setup script safely
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu item
add_action('admin_menu', 'daystar_add_setup_admin_page');

function daystar_add_setup_admin_page() {
    add_management_page(
        'Setup Loan Pages',
        'Setup Loan Pages',
        'manage_options',
        'daystar-setup-loan-pages',
        'daystar_setup_admin_page'
    );
}

function daystar_setup_admin_page() {
    // Check if setup should be run
    if (isset($_POST['run_setup']) && wp_verify_nonce($_POST['setup_nonce'], 'daystar_setup_loan_pages')) {
        // Include the setup script
        require_once get_template_directory() . '/setup-loan-pages.php';
        
        // Run the setup
        $results = daystar_setup_loan_pages();
        
        // Display results
        ?>
        <div class="wrap">
            <h1>Setup Results</h1>
            <?php if ($results['success']): ?>
                <div class="notice notice-success">
                    <p><strong>Success!</strong> <?php echo esc_html($results['message']); ?></p>
                </div>
            <?php else: ?>
                <div class="notice notice-error">
                    <p><strong>Error!</strong> <?php echo esc_html($results['message']); ?></p>
                </div>
            <?php endif; ?>
            
            <h2>Created Pages</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>Status</th>
                        <th>URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results['details']['pages'] as $page): ?>
                        <tr>
                            <td><strong><?php echo esc_html($page['title']); ?></strong></td>
                            <td>
                                <?php if ($page['status'] === 'created'): ?>
                                    <span style="color: green;">✅ Created</span>
                                <?php elseif ($page['status'] === 'already_exists'): ?>
                                    <span style="color: orange;">⚠️ Already Exists</span>
                                <?php else: ?>
                                    <span style="color: red;">❌ Error</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($page['url'])): ?>
                                    <a href="<?php echo esc_url($page['url']); ?>" target="_blank"><?php echo esc_html($page['slug']); ?></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($page['id'])): ?>
                                    <a href="<?php echo get_edit_post_link($page['id']); ?>">Edit</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <h2>Menu Updates</h2>
            <p><?php echo esc_html($results['details']['menu']['message']); ?></p>
            
            <h2>Next Steps</h2>
            <ol>
                <li><a href="<?php echo home_url('/products-services/'); ?>" target="_blank">Visit Products & Services page</a></li>
                <li><a href="<?php echo admin_url('nav-menus.php'); ?>">Manage Navigation Menus</a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=page'); ?>">Manage Pages</a></li>
            </ol>
        </div>
        <?php
        return;
    }
    
    // Show setup form
    ?>
    <div class="wrap">
        <h1>Setup Loan Pages</h1>
        <p>This tool will create WordPress pages for all your loan products and add them to your navigation menu.</p>
        
        <div class="card">
            <h2>What will be created:</h2>
            <ul>
                <li><strong>Loan Pages:</strong> Development Loans, Emergency Loans, School Fees Loans, Special Loans, Super Saver Loans, Salary Advance</li>
                <li><strong>Savings Pages:</strong> Savings Accounts, Savings Calculator</li>
                <li><strong>Service Pages:</strong> Loan Calculator, Loan Application</li>
                <li><strong>Menu Items:</strong> All pages will be added to your Products & Services submenu</li>
            </ul>
        </div>
        
        <form method="post" action="">
            <?php wp_nonce_field('daystar_setup_loan_pages', 'setup_nonce'); ?>
            <p>
                <input type="submit" name="run_setup" class="button button-primary button-large" value="Create Loan Pages & Setup Menu" onclick="return confirm('This will create new pages and update your navigation menu. Continue?');">
            </p>
        </form>
        
        <div class="card">
            <h3>Important Notes:</h3>
            <ul>
                <li>Existing pages will not be overwritten</li>
                <li>Your page templates (like page-development-loans.php) will automatically be used</li>
                <li>You can customize the menu order later in Appearance → Menus</li>
                <li>All pages will be published and visible immediately</li>
            </ul>
        </div>
    </div>
    <?php
}