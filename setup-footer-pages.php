<?php
/**
 * Setup script to create footer pages with their templates
 * Run this once to create Privacy Policy, Terms & Conditions, and FAQs pages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // If not in WordPress context, include wp-config.php
    require_once(dirname(__FILE__) . '/../../../../wp-config.php');
}

function create_footer_pages() {
    $pages_to_create = array(
        array(
            'post_title' => 'Privacy Policy',
            'post_name' => 'privacy-policy',
            'post_content' => 'This page displays our comprehensive privacy policy. Content is handled by the page template.',
            'meta_description' => 'Learn how Daystar Multi-Purpose Co-operative Society Ltd. protects your personal information and privacy.',
            'template' => 'page-privacy-policy.php'
        ),
        array(
            'post_title' => 'Terms & Conditions',
            'post_name' => 'terms-conditions',
            'post_content' => 'This page displays our membership terms and conditions. Content is handled by the page template.',
            'meta_description' => 'Read the terms and conditions for membership in Daystar Multi-Purpose Co-operative Society Ltd.',
            'template' => 'page-terms-conditions.php'
        ),
        array(
            'post_title' => 'Frequently Asked Questions',
            'post_name' => 'faqs',
            'post_content' => 'This page displays frequently asked questions about our services. Content is handled by the page template.',
            'meta_description' => 'Find answers to common questions about Daystar Multi-Purpose Co-operative Society Ltd. services and membership.',
            'template' => 'page-faqs.php'
        )
    );

    $created_pages = array();
    $updated_pages = array();
    $errors = array();

    foreach ($pages_to_create as $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['post_name']);
        
        if ($existing_page) {
            // Update existing page
            $page_id = $existing_page->ID;
            
            // Update page template
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            
            // Update meta description if it doesn't exist
            if (!get_post_meta($page_id, '_yoast_wpseo_metadesc', true)) {
                update_post_meta($page_id, '_yoast_wpseo_metadesc', $page_data['meta_description']);
            }
            
            $updated_pages[] = array(
                'title' => $page_data['post_title'],
                'url' => get_permalink($page_id),
                'edit_url' => admin_url('post.php?post=' . $page_id . '&action=edit')
            );
        } else {
            // Create new page
            $page_args = array(
                'post_title' => $page_data['post_title'],
                'post_name' => $page_data['post_name'],
                'post_content' => $page_data['post_content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1, // Admin user
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            );

            $page_id = wp_insert_post($page_args);

            if ($page_id && !is_wp_error($page_id)) {
                // Set page template
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
                
                // Set meta description for SEO
                update_post_meta($page_id, '_yoast_wpseo_metadesc', $page_data['meta_description']);
                
                // Set page order
                wp_update_post(array(
                    'ID' => $page_id,
                    'menu_order' => 999 // Put at end of menu
                ));

                $created_pages[] = array(
                    'title' => $page_data['post_title'],
                    'url' => get_permalink($page_id),
                    'edit_url' => admin_url('post.php?post=' . $page_id . '&action=edit')
                );
            } else {
                $errors[] = 'Failed to create page: ' . $page_data['post_title'];
            }
        }
    }

    return array(
        'created' => $created_pages,
        'updated' => $updated_pages,
        'errors' => $errors
    );
}

// Check if we're running this script directly or via WordPress admin
if (isset($_GET['create_footer_pages']) && $_GET['create_footer_pages'] === 'true') {
    // Add admin notice hook
    add_action('admin_notices', function() {
        $results = create_footer_pages();
        
        echo '<div class="notice notice-success is-dismissible">';
        echo '<h3>Footer Pages Setup Complete!</h3>';
        
        if (!empty($results['created'])) {
            echo '<h4>Created Pages:</h4>';
            echo '<ul>';
            foreach ($results['created'] as $page) {
                echo '<li><strong>' . esc_html($page['title']) . '</strong> - ';
                echo '<a href="' . esc_url($page['url']) . '" target="_blank">View Page</a> | ';
                echo '<a href="' . esc_url($page['edit_url']) . '">Edit Page</a></li>';
            }
            echo '</ul>';
        }
        
        if (!empty($results['updated'])) {
            echo '<h4>Updated Pages:</h4>';
            echo '<ul>';
            foreach ($results['updated'] as $page) {
                echo '<li><strong>' . esc_html($page['title']) . '</strong> - ';
                echo '<a href="' . esc_url($page['url']) . '" target="_blank">View Page</a> | ';
                echo '<a href="' . esc_url($page['edit_url']) . '">Edit Page</a></li>';
            }
            echo '</ul>';
        }
        
        if (!empty($results['errors'])) {
            echo '<h4>Errors:</h4>';
            echo '<ul>';
            foreach ($results['errors'] as $error) {
                echo '<li style="color: red;">' . esc_html($error) . '</li>';
            }
            echo '</ul>';
        }
        
        echo '<p><strong>Note:</strong> The page templates are now properly assigned. The content is generated dynamically by the templates.</p>';
        echo '</div>';
    });
}

// Add admin menu item for easy access
add_action('admin_menu', function() {
    add_theme_page(
        'Setup Footer Pages',
        'Setup Footer Pages',
        'read', // Lower capability requirement
        'setup-footer-pages',
        'display_setup_footer_pages_admin'
    );
});

function display_setup_footer_pages_admin() {
    ?>
    <div class="wrap">
        <h1>Setup Footer Pages</h1>
        <p>This tool will create or update the footer pages (Privacy Policy, Terms & Conditions, and FAQs) with their proper templates.</p>
        
        <div class="card">
            <h2>Pages to be created/updated:</h2>
            <ul>
                <li><strong>Privacy Policy</strong> - Comprehensive data protection policy</li>
                <li><strong>Terms & Conditions</strong> - Membership terms and conditions</li>
                <li><strong>FAQs</strong> - Frequently asked questions with search and filtering</li>
            </ul>
        </div>
        
        <div class="card">
            <h2>Template Files Status:</h2>
            <?php
            $template_files = array(
                'page-privacy-policy.php' => 'Privacy Policy Template',
                'page-terms-conditions.php' => 'Terms & Conditions Template',
                'page-faqs.php' => 'FAQs Template'
            );
            
            echo '<ul>';
            foreach ($template_files as $file => $description) {
                $file_path = get_template_directory() . '/' . $file;
                if (file_exists($file_path)) {
                    echo '<li style="color: green;">✓ ' . esc_html($description) . ' - <code>' . esc_html($file) . '</code></li>';
                } else {
                    echo '<li style="color: red;">✗ ' . esc_html($description) . ' - <code>' . esc_html($file) . '</code> (Missing)</li>';
                }
            }
            echo '</ul>';
            ?>
        </div>
        
        <div class="card">
            <h2>Current Footer Pages Status:</h2>
            <?php
            $footer_pages = array(
                'privacy-policy' => 'Privacy Policy',
                'terms-conditions' => 'Terms & Conditions',
                'faqs' => 'FAQs'
            );
            
            echo '<ul>';
            foreach ($footer_pages as $slug => $title) {
                $page = get_page_by_path($slug);
                if ($page) {
                    $template = get_post_meta($page->ID, '_wp_page_template', true);
                    echo '<li style="color: green;">✓ ' . esc_html($title) . ' - ';
                    echo '<a href="' . esc_url(get_permalink($page->ID)) . '" target="_blank">View</a> | ';
                    echo '<a href="' . esc_url(admin_url('post.php?post=' . $page->ID . '&action=edit')) . '">Edit</a>';
                    if ($template) {
                        echo ' (Template: <code>' . esc_html($template) . '</code>)';
                    }
                    echo '</li>';
                } else {
                    echo '<li style="color: orange;">⚠ ' . esc_html($title) . ' - Not created yet</li>';
                }
            }
            echo '</ul>';
            ?>
        </div>
        
        <p>
            <a href="<?php echo admin_url('themes.php?page=setup-footer-pages&create_footer_pages=true'); ?>" 
               class="button button-primary button-large">
                Create/Update Footer Pages
            </a>
        </p>
        
        <div class="card">
            <h3>What this tool does:</h3>
            <ol>
                <li>Creates the three footer pages if they don't exist</li>
                <li>Assigns the correct page templates to each page</li>
                <li>Sets appropriate meta descriptions for SEO</li>
                <li>Updates existing pages with correct templates if they already exist</li>
            </ol>
            
            <h3>After running this tool:</h3>
            <ul>
                <li>Visit each page to see the content generated by the templates</li>
                <li>The footer links will now work properly</li>
                <li>Content is dynamically generated and styled to match your theme</li>
                <li>Pages are mobile-responsive and SEO-optimized</li>
            </ul>
        </div>
    </div>
    <?php
}

// If running directly (not recommended, but for testing)
if (!function_exists('wp_insert_post') && basename($_SERVER['PHP_SELF']) === 'setup-footer-pages.php') {
    echo "This script should be run from WordPress admin. Please access it via:\n";
    echo "WordPress Admin > Appearance > Setup Footer Pages\n";
    exit;
}
?>