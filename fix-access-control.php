<?php
/**
 * Access Control Diagnostic and Fix Script
 * Run this script to diagnose and fix access control issues
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // For Local by Flywheel setup
    $wp_config_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-config.php';
    if (file_exists($wp_config_path)) {
        require_once($wp_config_path);
    } else {
        // Alternative paths to try
        $alt_paths = [
            dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-config.php',
            dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/wp-config.php',
            $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php'
        ];
        
        foreach ($alt_paths as $path) {
            if (file_exists($path)) {
                require_once($path);
                break;
            }
        }
        
        // If still not found, try to bootstrap WordPress
        if (!defined('ABSPATH')) {
            // Last resort - try to find wp-load.php
            $wp_load_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
            if (file_exists($wp_load_path)) {
                require_once($wp_load_path);
            } else {
                die('WordPress configuration file not found. Please run this script from WordPress admin or ensure WordPress is properly installed.');
            }
        }
    }
}

// Only allow administrators to run this script
if (!current_user_can('administrator')) {
    wp_die('Access denied. Only administrators can run this script.');
}

echo '<h1>Daystar SACCO Access Control Diagnostic</h1>';

// Check if security class exists
if (!class_exists('Daystar_Security_Access_Control')) {
    echo '<div style="background: #ffcccc; padding: 10px; margin: 10px 0; border: 1px solid #ff0000;">';
    echo '<strong>ERROR:</strong> Daystar_Security_Access_Control class not found. Loading security system...';
    echo '</div>';
    
    // Try to load the security system
    require_once(get_template_directory() . '/includes/security-access-control.php');
    
    if (class_exists('Daystar_Security_Access_Control')) {
        echo '<div style="background: #ccffcc; padding: 10px; margin: 10px 0; border: 1px solid #00ff00;">';
        echo '<strong>SUCCESS:</strong> Security system loaded successfully.';
        echo '</div>';
    }
}

// Get current user info
$current_user = wp_get_current_user();
echo '<h2>Current User Information</h2>';
echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<tr><td><strong>User ID:</strong></td><td>' . $current_user->ID . '</td></tr>';
echo '<tr><td><strong>Username:</strong></td><td>' . $current_user->user_login . '</td></tr>';
echo '<tr><td><strong>Display Name:</strong></td><td>' . $current_user->display_name . '</td></tr>';
echo '<tr><td><strong>Email:</strong></td><td>' . $current_user->user_email . '</td></tr>';
echo '<tr><td><strong>Current Roles:</strong></td><td>' . implode(', ', $current_user->roles) . '</td></tr>';
echo '</table>';

// Check user capabilities
echo '<h2>User Capabilities</h2>';
$important_caps = ['administrator', 'member', 'manage_options', 'view_member_data', 'access_member_dashboard'];
echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<tr><th>Capability</th><th>Has Permission</th></tr>';
foreach ($important_caps as $cap) {
    $has_cap = current_user_can($cap) ? 'YES' : 'NO';
    $color = current_user_can($cap) ? '#ccffcc' : '#ffcccc';
    echo '<tr style="background: ' . $color . '"><td>' . $cap . '</td><td>' . $has_cap . '</td></tr>';
}
echo '</table>';

// Check available roles
echo '<h2>Available WordPress Roles</h2>';
global $wp_roles;
$all_roles = $wp_roles->roles;
echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<tr><th>Role</th><th>Display Name</th><th>Capabilities</th></tr>';
foreach ($all_roles as $role_key => $role_data) {
    echo '<tr>';
    echo '<td>' . $role_key . '</td>';
    echo '<td>' . $role_data['name'] . '</td>';
    echo '<td>' . implode(', ', array_keys($role_data['capabilities'])) . '</td>';
    echo '</tr>';
}
echo '</table>';

// Fix options
echo '<h2>Fix Options</h2>';

if (isset($_POST['fix_action'])) {
    switch ($_POST['fix_action']) {
        case 'add_admin_role':
            $current_user->add_role('administrator');
            echo '<div style="background: #ccffcc; padding: 10px; margin: 10px 0; border: 1px solid #00ff00;">';
            echo 'Administrator role added to your account.';
            echo '</div>';
            break;
            
        case 'add_member_role':
            $current_user->add_role('member');
            echo '<div style="background: #ccffcc; padding: 10px; margin: 10px 0; border: 1px solid #00ff00;">';
            echo 'Member role added to your account.';
            echo '</div>';
            break;
            
        case 'create_custom_roles':
            // Initialize security system to create roles
            if (class_exists('Daystar_Security_Access_Control')) {
                $security = Daystar_Security_Access_Control::get_instance();
                $security->setup_custom_roles();
                echo '<div style="background: #ccffcc; padding: 10px; margin: 10px 0; border: 1px solid #00ff00;">';
                echo 'Custom roles created successfully.';
                echo '</div>';
            }
            break;
            
        case 'bypass_security':
            // Create a temporary bypass
            update_option('daystar_security_bypass', true);
            echo '<div style="background: #ffffcc; padding: 10px; margin: 10px 0; border: 1px solid #ffaa00;">';
            echo 'Security bypass enabled temporarily. Remember to disable this later.';
            echo '</div>';
            break;
    }
    
    // Refresh user data
    $current_user = wp_get_current_user();
}

echo '<form method="post">';
echo '<h3>Quick Fixes:</h3>';

if (!in_array('administrator', $current_user->roles)) {
    echo '<button type="submit" name="fix_action" value="add_admin_role" style="background: #0073aa; color: white; padding: 10px; margin: 5px; border: none; cursor: pointer;">Add Administrator Role</button><br>';
}

if (!in_array('member', $current_user->roles)) {
    echo '<button type="submit" name="fix_action" value="add_member_role" style="background: #00a32a; color: white; padding: 10px; margin: 5px; border: none; cursor: pointer;">Add Member Role</button><br>';
}

echo '<button type="submit" name="fix_action" value="create_custom_roles" style="background: #8c8f94; color: white; padding: 10px; margin: 5px; border: none; cursor: pointer;">Create/Update Custom Roles</button><br>';

echo '<button type="submit" name="fix_action" value="bypass_security" style="background: #d63638; color: white; padding: 10px; margin: 5px; border: none; cursor: pointer;">Enable Security Bypass (Temporary)</button><br>';

echo '</form>';

// Check if security bypass is enabled
if (get_option('daystar_security_bypass')) {
    echo '<div style="background: #ffcccc; padding: 10px; margin: 10px 0; border: 1px solid #ff0000;">';
    echo '<strong>WARNING:</strong> Security bypass is currently enabled. ';
    echo '<a href="?disable_bypass=1" style="color: #d63638;">Click here to disable it</a>';
    echo '</div>';
}

if (isset($_GET['disable_bypass'])) {
    delete_option('daystar_security_bypass');
    echo '<div style="background: #ccffcc; padding: 10px; margin: 10px 0; border: 1px solid #00ff00;">';
    echo 'Security bypass disabled.';
    echo '</div>';
}

// Test access to member dashboard
echo '<h2>Test Access</h2>';
echo '<a href="/page-member-dashboard" target="_blank" style="background: #0073aa; color: white; padding: 10px; text-decoration: none; display: inline-block; margin: 5px;">Test Member Dashboard Access</a>';

echo '<h2>Manual Solutions</h2>';
echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0;">';
echo '<h3>If the above fixes don\'t work, try these manual solutions:</h3>';
echo '<ol>';
echo '<li><strong>Database Fix:</strong> Go to your WordPress admin → Users → Your Profile → Role and manually set it to "Administrator"</li>';
echo '<li><strong>Functions.php Fix:</strong> Add this code to your theme\'s functions.php temporarily:<br>';
echo '<code>add_action(\'init\', function() { if (is_user_logged_in()) { wp_get_current_user()->add_role(\'administrator\'); }); </code></li>';
echo '<li><strong>Plugin Conflict:</strong> Deactivate all plugins temporarily to check for conflicts</li>';
echo '<li><strong>Theme Switch:</strong> Temporarily switch to a default WordPress theme to isolate the issue</li>';
echo '</ol>';
echo '</div>';

echo '<h2>Security System Status</h2>';
echo '<div style="background: #f0f0f0; padding: 15px; margin: 10px 0;">';

// Check if security files exist
$security_files = [
    'security-access-control.php' => get_template_directory() . '/includes/security-access-control.php',
    'auth-helper.php' => get_template_directory() . '/includes/auth-helper.php',
];

foreach ($security_files as $name => $path) {
    if (file_exists($path)) {
        echo '<div style="color: green;">✓ ' . $name . ' exists</div>';
    } else {
        echo '<div style="color: red;">✗ ' . $name . ' missing</div>';
    }
}

// Check if functions are available
$required_functions = ['daystar_check_member_access', 'daystar_user_can'];
foreach ($required_functions as $func) {
    if (function_exists($func)) {
        echo '<div style="color: green;">✓ Function ' . $func . ' available</div>';
    } else {
        echo '<div style="color: red;">✗ Function ' . $func . ' missing</div>';
    }
}

echo '</div>';
?>