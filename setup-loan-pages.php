<?php
/**
 * Setup Loan Pages and Menu Structure
 * 
 * This script creates WordPress pages for all loan products and sets up
 * the navigation menu structure to make them accessible through the
 * Products & Services submenu.
 * 
 * Run this script once to set up all loan pages automatically.
 * 
 * @package daystar-coop
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // Load WordPress if running directly
    require_once('../../../wp-load.php');
}

/**
 * Main setup function
 */
function daystar_setup_loan_pages() {
    $results = array();
    
    try {
        // Step 1: Create loan pages
        $results['pages'] = daystar_create_loan_pages();
        
        // Step 2: Create savings pages
        $results['savings_pages'] = daystar_create_savings_pages();
        
        // Step 3: Update navigation menu
        $results['menu'] = daystar_update_navigation_menu();
        
        // Step 4: Create additional service pages
        $results['service_pages'] = daystar_create_service_pages();
        
        return array(
            'success' => true,
            'message' => 'All loan pages and menu structure created successfully!',
            'details' => $results
        );
        
    } catch (Exception $e) {
        return array(
            'success' => false,
            'message' => 'Setup failed: ' . $e->getMessage(),
            'details' => $results
        );
    }
}

/**
 * Create loan product pages
 */
function daystar_create_loan_pages() {
    $loan_pages = array(
        'development-loans' => array(
            'title' => 'Development Loans',
            'content' => 'This page displays information about our Development Loans. Content is handled by the page template.',
            'meta_description' => 'Apply for Development Loans with competitive rates and flexible terms. Up to KSh 2,000,000 for your long-term projects.',
            'featured_text' => 'Long-term financing for your development projects with competitive 12% interest rate.'
        ),
        'emergency-loans' => array(
            'title' => 'Emergency Loans',
            'content' => 'This page displays information about our Emergency Loans. Content is handled by the page template.',
            'meta_description' => 'Get Emergency Loans with same-day processing. Up to KSh 200,000 for urgent financial needs.',
            'featured_text' => 'Quick access to emergency funds with same-day processing and minimal documentation.'
        ),
        'school-fees-loans' => array(
            'title' => 'School Fees Loans',
            'content' => 'This page displays information about our School Fees Loans. Content is handled by the page template.',
            'meta_description' => 'Finance your education with School Fees Loans. Up to KSh 500,000 with flexible repayment terms.',
            'featured_text' => 'Education financing made easy with competitive rates and flexible repayment options.'
        ),
        'special-loans' => array(
            'title' => 'Special Loans',
            'content' => 'This page displays information about our Special Loans. Content is handled by the page template.',
            'meta_description' => 'Customizable Special Loans for unique financial needs. Up to KSh 1,000,000 with personalized terms.',
            'featured_text' => 'Customizable loan solutions tailored to your specific financial requirements.'
        ),
        'super-saver-loans' => array(
            'title' => 'Super Saver Loans',
            'content' => 'This page displays information about our Super Saver Loans. Content is handled by the page template.',
            'meta_description' => 'Exclusive Super Saver Loans for dedicated savers. Lowest rates at 8% with up to KSh 800,000.',
            'featured_text' => 'Exclusive loan product for our most dedicated savers with the lowest interest rates.'
        ),
        'salary-advance' => array(
            'title' => 'Salary Advance',
            'content' => 'This page displays information about our Salary Advance service. Content is handled by the page template.',
            'meta_description' => 'Get instant Salary Advance with same-day processing. Up to KSh 100,000 with simple fee structure.',
            'featured_text' => 'Instant salary advance with same-day processing and simple fee structure.'
        )
    );
    
    $created_pages = array();
    
    foreach ($loan_pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'post_author' => 1,
                'menu_order' => 0
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                // Add custom meta data
                update_post_meta($page_id, '_yoast_wpseo_metadesc', $page_data['meta_description']);
                update_post_meta($page_id, 'featured_text', $page_data['featured_text']);
                update_post_meta($page_id, 'loan_product', true);
                
                $created_pages[] = array(
                    'title' => $page_data['title'],
                    'slug' => $slug,
                    'id' => $page_id,
                    'url' => home_url('/' . $slug . '/'),
                    'status' => 'created'
                );
            } else {
                $created_pages[] = array(
                    'title' => $page_data['title'],
                    'slug' => $slug,
                    'status' => 'error',
                    'error' => is_wp_error($page_id) ? $page_id->get_error_message() : 'Unknown error'
                );
            }
        } else {
            $created_pages[] = array(
                'title' => $page_data['title'],
                'slug' => $slug,
                'id' => $existing_page->ID,
                'url' => home_url('/' . $slug . '/'),
                'status' => 'already_exists'
            );
        }
    }
    
    return $created_pages;
}

/**
 * Create savings product pages
 */
function daystar_create_savings_pages() {
    $savings_pages = array(
        'savings-accounts' => array(
            'title' => 'Savings Accounts',
            'content' => 'This page displays information about our Savings Accounts. Content is handled by the page template.',
            'meta_description' => 'Open a savings account with competitive interest rates and flexible terms.',
            'featured_text' => 'Secure your future with our range of savings account options.'
        ),
        'savings-calculator' => array(
            'title' => 'Savings Calculator',
            'content' => 'This page provides a savings calculator tool. Content is handled by the page template.',
            'meta_description' => 'Calculate your savings growth with our interactive savings calculator.',
            'featured_text' => 'Plan your savings goals with our easy-to-use calculator.'
        )
    );
    
    $created_pages = array();
    
    foreach ($savings_pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'post_author' => 1,
                'menu_order' => 0
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                // Add custom meta data
                update_post_meta($page_id, '_yoast_wpseo_metadesc', $page_data['meta_description']);
                update_post_meta($page_id, 'featured_text', $page_data['featured_text']);
                update_post_meta($page_id, 'savings_product', true);
                
                $created_pages[] = array(
                    'title' => $page_data['title'],
                    'slug' => $slug,
                    'id' => $page_id,
                    'url' => home_url('/' . $slug . '/'),
                    'status' => 'created'
                );
            }
        } else {
            $created_pages[] = array(
                'title' => $page_data['title'],
                'slug' => $slug,
                'id' => $existing_page->ID,
                'url' => home_url('/' . $slug . '/'),
                'status' => 'already_exists'
            );
        }
    }
    
    return $created_pages;
}

/**
 * Create additional service pages
 */
function daystar_create_service_pages() {
    $service_pages = array(
        'loan-calculator' => array(
            'title' => 'Loan Calculator',
            'content' => 'This page provides a loan calculator tool. Content is handled by the page template.',
            'meta_description' => 'Calculate your loan repayments with our interactive loan calculator.',
            'featured_text' => 'Plan your loan repayments with our easy-to-use calculator.'
        ),
        'loan-application' => array(
            'title' => 'Loan Application',
            'content' => 'This page provides the loan application form. Content is handled by the page template.',
            'meta_description' => 'Apply for a loan online with our secure application form.',
            'featured_text' => 'Apply for your loan quickly and securely online.'
        )
    );
    
    $created_pages = array();
    
    foreach ($service_pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'post_author' => 1,
                'menu_order' => 0
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                // Add custom meta data
                update_post_meta($page_id, '_yoast_wpseo_metadesc', $page_data['meta_description']);
                update_post_meta($page_id, 'featured_text', $page_data['featured_text']);
                
                $created_pages[] = array(
                    'title' => $page_data['title'],
                    'slug' => $slug,
                    'id' => $page_id,
                    'url' => home_url('/' . $slug . '/'),
                    'status' => 'created'
                );
            }
        } else {
            $created_pages[] = array(
                'title' => $page_data['title'],
                'slug' => $slug,
                'id' => $existing_page->ID,
                'url' => home_url('/' . $slug . '/'),
                'status' => 'already_exists'
            );
        }
    }
    
    return $created_pages;
}

/**
 * Update navigation menu to include loan pages
 */
function daystar_update_navigation_menu() {
    // Get the primary menu
    $menu_name = 'primary';
    $menu = wp_get_nav_menu_object($menu_name);
    
    if (!$menu) {
        // Try to find any menu
        $menus = wp_get_nav_menus();
        if (!empty($menus)) {
            $menu = $menus[0];
        } else {
            return array(
                'status' => 'error',
                'message' => 'No navigation menu found. Please create a menu manually in Appearance > Menus.'
            );
        }
    }
    
    // Get existing menu items
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    
    // Find Products & Services menu item
    $products_menu_item = null;
    foreach ($menu_items as $item) {
        if (strpos(strtolower($item->title), 'products') !== false && strpos(strtolower($item->title), 'services') !== false) {
            $products_menu_item = $item;
            break;
        }
    }
    
    if (!$products_menu_item) {
        return array(
            'status' => 'warning',
            'message' => 'Products & Services menu item not found. Please add loan pages to your menu manually.'
        );
    }
    
    // Get loan pages
    $loan_pages = array(
        'development-loans' => 'Development Loans',
        'emergency-loans' => 'Emergency Loans',
        'school-fees-loans' => 'School Fees Loans',
        'special-loans' => 'Special Loans',
        'super-saver-loans' => 'Super Saver Loans',
        'salary-advance' => 'Salary Advance'
    );
    
    $added_items = array();
    $menu_order = 100; // Start with a high number to add at the end
    
    foreach ($loan_pages as $slug => $title) {
        $page = get_page_by_path($slug);
        if ($page) {
            // Check if menu item already exists
            $exists = false;
            foreach ($menu_items as $item) {
                if ($item->object_id == $page->ID) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                // Add menu item
                $menu_item_id = wp_update_nav_menu_item($menu->term_id, 0, array(
                    'menu-item-title' => $title,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page->ID,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $products_menu_item->ID,
                    'menu-item-position' => $menu_order++
                ));
                
                if (!is_wp_error($menu_item_id)) {
                    $added_items[] = $title;
                }
            }
        }
    }
    
    return array(
        'status' => 'success',
        'menu_name' => $menu->name,
        'menu_id' => $menu->term_id,
        'added_items' => $added_items,
        'message' => count($added_items) . ' loan pages added to navigation menu.'
    );
}

/**
 * Display setup results
 */
function daystar_display_setup_results($results) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Loan Pages Setup Results</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
            .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .success { color: #28a745; }
            .error { color: #dc3545; }
            .warning { color: #ffc107; }
            .info { color: #17a2b8; }
            .page-list { margin: 20px 0; }
            .page-item { padding: 10px; margin: 5px 0; border-left: 4px solid #007cba; background: #f8f9fa; }
            .status-created { border-left-color: #28a745; }
            .status-exists { border-left-color: #ffc107; }
            .status-error { border-left-color: #dc3545; }
            .btn { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px 0 0; }
            .btn:hover { background: #005a87; }
            .section { margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 4px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🚀 Loan Pages Setup Results</h1>
            
            <?php if ($results['success']): ?>
                <div class="success">
                    <h2>✅ Setup Completed Successfully!</h2>
                    <p><?php echo esc_html($results['message']); ?></p>
                </div>
            <?php else: ?>
                <div class="error">
                    <h2>❌ Setup Failed</h2>
                    <p><?php echo esc_html($results['message']); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Loan Pages Results -->
            <div class="section">
                <h3>📄 Loan Pages</h3>
                <div class="page-list">
                    <?php foreach ($results['details']['pages'] as $page): ?>
                        <div class="page-item status-<?php echo $page['status'] === 'created' ? 'created' : ($page['status'] === 'already_exists' ? 'exists' : 'error'); ?>">
                            <strong><?php echo esc_html($page['title']); ?></strong>
                            <br>
                            <small>
                                Status: <?php echo esc_html(ucfirst(str_replace('_', ' ', $page['status']))); ?>
                                <?php if (isset($page['url'])): ?>
                                    | <a href="<?php echo esc_url($page['url']); ?>" target="_blank">View Page</a>
                                <?php endif; ?>
                                <?php if (isset($page['error'])): ?>
                                    | Error: <?php echo esc_html($page['error']); ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Savings Pages Results -->
            <div class="section">
                <h3>💰 Savings Pages</h3>
                <div class="page-list">
                    <?php foreach ($results['details']['savings_pages'] as $page): ?>
                        <div class="page-item status-<?php echo $page['status'] === 'created' ? 'created' : ($page['status'] === 'already_exists' ? 'exists' : 'error'); ?>">
                            <strong><?php echo esc_html($page['title']); ?></strong>
                            <br>
                            <small>
                                Status: <?php echo esc_html(ucfirst(str_replace('_', ' ', $page['status']))); ?>
                                <?php if (isset($page['url'])): ?>
                                    | <a href="<?php echo esc_url($page['url']); ?>" target="_blank">View Page</a>
                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Service Pages Results -->
            <div class="section">
                <h3>🔧 Service Pages</h3>
                <div class="page-list">
                    <?php foreach ($results['details']['service_pages'] as $page): ?>
                        <div class="page-item status-<?php echo $page['status'] === 'created' ? 'created' : ($page['status'] === 'already_exists' ? 'exists' : 'error'); ?>">
                            <strong><?php echo esc_html($page['title']); ?></strong>
                            <br>
                            <small>
                                Status: <?php echo esc_html(ucfirst(str_replace('_', ' ', $page['status']))); ?>
                                <?php if (isset($page['url'])): ?>
                                    | <a href="<?php echo esc_url($page['url']); ?>" target="_blank">View Page</a>
                                <?php endif; ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Menu Results -->
            <div class="section">
                <h3>🧭 Navigation Menu</h3>
                <?php if ($results['details']['menu']['status'] === 'success'): ?>
                    <div class="success">
                        <p>✅ Menu updated successfully!</p>
                        <p>Added <?php echo count($results['details']['menu']['added_items']); ?> items to the "<?php echo esc_html($results['details']['menu']['menu_name']); ?>" menu.</p>
                        <?php if (!empty($results['details']['menu']['added_items'])): ?>
                            <p><strong>Added items:</strong> <?php echo implode(', ', $results['details']['menu']['added_items']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="warning">
                        <p>⚠️ <?php echo esc_html($results['details']['menu']['message']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Next Steps -->
            <div class="section">
                <h3>🎯 Next Steps</h3>
                <ol>
                    <li><strong>Check your website:</strong> Visit your site and navigate to Products & Services to see the new loan pages.</li>
                    <li><strong>Customize menu (if needed):</strong> Go to <a href="<?php echo admin_url('nav-menus.php'); ?>">Appearance → Menus</a> to reorder or customize menu items.</li>
                    <li><strong>Test loan pages:</strong> Click on each loan product link to ensure the templates are working correctly.</li>
                    <li><strong>Update content:</strong> If needed, you can edit page content in <a href="<?php echo admin_url('edit.php?post_type=page'); ?>">Pages</a>.</li>
                </ol>
            </div>
            
            <!-- Quick Links -->
            <div style="margin-top: 30px;">
                <a href="<?php echo home_url('/products-services/'); ?>" class="btn" target="_blank">View Products & Services</a>
                <a href="<?php echo admin_url('nav-menus.php'); ?>" class="btn">Manage Menus</a>
                <a href="<?php echo admin_url('edit.php?post_type=page'); ?>" class="btn">Manage Pages</a>
                <a href="<?php echo home_url(); ?>" class="btn">Visit Site</a>
            </div>
        </div>
    </body>
    </html>
    <?php
}

// Run the setup if accessed directly
if (!defined('ABSPATH') || (defined('ABSPATH') && isset($_GET['run_setup']))) {
    $results = daystar_setup_loan_pages();
    daystar_display_setup_results($results);
    exit;
}

// If included in WordPress, provide a function to run setup
if (defined('ABSPATH')) {
    /**
     * Function to run setup from WordPress admin or other scripts
     */
    function run_daystar_loan_pages_setup() {
        return daystar_setup_loan_pages();
    }
}