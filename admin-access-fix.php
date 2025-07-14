<?php
/**
 * Admin Access Fix - Add this to functions.php temporarily
 * Copy this entire code and paste it at the end of your functions.php file
 */

// Add admin menu for access control fix
function daystar_add_access_fix_menu() {
    add_management_page(
        'Access Control Fix',
        'Access Fix',
        'read', // Lower permission requirement
        'daystar-access-fix',
        'daystar_access_fix_page'
    );
}
add_action('admin_menu', 'daystar_add_access_fix_menu');

// Access fix admin page
function daystar_access_fix_page() {
    if (!is_user_logged_in()) {
        wp_die('You must be logged in to access this page.');
    }
    
    $current_user = wp_get_current_user();
    
    // Handle form submissions
    if (isset($_POST['fix_action']) && wp_verify_nonce($_POST['_wpnonce'], 'daystar_access_fix')) {
        switch ($_POST['fix_action']) {
            case 'add_admin_role':
                $current_user->add_role('administrator');
                echo '<div class="notice notice-success"><p>Administrator role added successfully!</p></div>';
                break;
                
            case 'add_member_role':
                $current_user->add_role('member');
                echo '<div class="notice notice-success"><p>Member role added successfully!</p></div>';
                break;
                
            case 'create_custom_roles':
                // Load security system if available
                $security_file = get_template_directory() . '/includes/security-access-control.php';
                if (file_exists($security_file)) {
                    require_once $security_file;
                    if (class_exists('Daystar_Security_Access_Control')) {
                        $security = Daystar_Security_Access_Control::get_instance();
                        $security->setup_custom_roles();
                        echo '<div class="notice notice-success"><p>Custom roles created successfully!</p></div>';
                    }
                } else {
                    echo '<div class="notice notice-error"><p>Security system file not found.</p></div>';
                }
                break;
                
            case 'bypass_security':
                update_option('daystar_security_bypass', true);
                echo '<div class="notice notice-warning"><p>Security bypass enabled temporarily.</p></div>';
                break;
        }
        
        // Refresh user data
        $current_user = wp_get_current_user();
    }
    
    if (isset($_GET['disable_bypass'])) {
        delete_option('daystar_security_bypass');
        echo '<div class="notice notice-success"><p>Security bypass disabled.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Daystar SACCO Access Control Fix</h1>
        
        <div class="card">
            <h2>Current User Information</h2>
            <table class="widefat">
                <tr><td><strong>User ID:</strong></td><td><?php echo $current_user->ID; ?></td></tr>
                <tr><td><strong>Username:</strong></td><td><?php echo $current_user->user_login; ?></td></tr>
                <tr><td><strong>Display Name:</strong></td><td><?php echo $current_user->display_name; ?></td></tr>
                <tr><td><strong>Email:</strong></td><td><?php echo $current_user->user_email; ?></td></tr>
                <tr><td><strong>Current Roles:</strong></td><td><?php echo implode(', ', $current_user->roles); ?></td></tr>
            </table>
        </div>
        
        <div class="card">
            <h2>User Capabilities</h2>
            <table class="widefat">
                <thead>
                    <tr><th>Capability</th><th>Has Permission</th></tr>
                </thead>
                <tbody>
                    <?php
                    $important_caps = ['administrator', 'member', 'manage_options', 'view_member_data', 'access_member_dashboard'];
                    foreach ($important_caps as $cap) {
                        $has_cap = current_user_can($cap);
                        $status = $has_cap ? '✓ YES' : '✗ NO';
                        $color = $has_cap ? 'green' : 'red';
                        echo '<tr><td>' . $cap . '</td><td style="color: ' . $color . ';">' . $status . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="card">
            <h2>Quick Fixes</h2>
            <form method="post">
                <?php wp_nonce_field('daystar_access_fix'); ?>
                
                <?php if (!in_array('administrator', $current_user->roles)): ?>
                    <p>
                        <button type="submit" name="fix_action" value="add_admin_role" class="button button-primary">
                            Add Administrator Role
                        </button>
                        <span class="description">This will give you full admin access.</span>
                    </p>
                <?php endif; ?>
                
                <?php if (!in_array('member', $current_user->roles)): ?>
                    <p>
                        <button type="submit" name="fix_action" value="add_member_role" class="button button-secondary">
                            Add Member Role
                        </button>
                        <span class="description">This will give you member dashboard access.</span>
                    </p>
                <?php endif; ?>
                
                <p>
                    <button type="submit" name="fix_action" value="create_custom_roles" class="button">
                        Create/Update Custom Roles
                    </button>
                    <span class="description">This will create all the custom SACCO roles.</span>
                </p>
                
                <p>
                    <button type="submit" name="fix_action" value="bypass_security" class="button button-link-delete">
                        Enable Security Bypass (Temporary)
                    </button>
                    <span class="description">Use this as a last resort.</span>
                </p>
            </form>
        </div>
        
        <?php if (get_option('daystar_security_bypass')): ?>
        <div class="notice notice-warning">
            <p><strong>WARNING:</strong> Security bypass is currently enabled. 
            <a href="?page=daystar-access-fix&disable_bypass=1" class="button button-small">Disable Bypass</a></p>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Test Access</h2>
            <p>
                <a href="<?php echo home_url('/page-member-dashboard'); ?>" target="_blank" class="button button-primary">
                    Test Member Dashboard Access
                </a>
            </p>
        </div>
        
        <div class="card">
            <h2>System Status</h2>
            <?php
            $security_files = [
                'security-access-control.php' => get_template_directory() . '/includes/security-access-control.php',
                'auth-helper.php' => get_template_directory() . '/includes/auth-helper.php',
            ];
            
            foreach ($security_files as $name => $path) {
                $exists = file_exists($path);
                $status = $exists ? '✓' : '✗';
                $color = $exists ? 'green' : 'red';
                echo '<p style="color: ' . $color . ';">' . $status . ' ' . $name . '</p>';
            }
            
            $required_functions = ['daystar_check_member_access', 'daystar_user_can'];
            foreach ($required_functions as $func) {
                $exists = function_exists($func);
                $status = $exists ? '✓' : '✗';
                $color = $exists ? 'green' : 'red';
                echo '<p style="color: ' . $color . ';">' . $status . ' Function ' . $func . '</p>';
            }
            ?>
        </div>
        
        <div class="card">
            <h2>Manual Solutions</h2>
            <ol>
                <li><strong>WordPress Admin:</strong> Go to Users → Your Profile and manually set role to "Administrator"</li>
                <li><strong>Database Fix:</strong> Update wp_usermeta table to set administrator capabilities</li>
                <li><strong>Plugin Conflict:</strong> Deactivate all plugins temporarily</li>
                <li><strong>Theme Switch:</strong> Switch to a default theme temporarily</li>
            </ol>
        </div>
    </div>
    
    <style>
    .card {
        background: #fff;
        border: 1px solid #ccd0d4;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        margin: 20px 0;
        padding: 20px;
    }
    .card h2 {
        margin-top: 0;
    }
    </style>
    <?php
}
?>