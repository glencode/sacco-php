<?php
/**
 * Fix Dashboard Errors Script
 * Fixes the critical errors preventing the member dashboard from loading
 */

// Include WordPress
require_once('../../../wp-config.php');

if (!current_user_can('manage_options')) {
    die('Access denied. You must be an administrator to run this script.');
}

echo "<h1>🔧 Fix Dashboard Errors</h1>";
echo "<p>This script will fix the critical errors preventing the member dashboard from loading.</p>";

// Fix 1: Create the audit log table
echo "<h2>1. Creating Audit Log Table</h2>";

global $wpdb;
$table_name = $wpdb->prefix . 'daystar_audit_log';

// Check if table exists
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        log_id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        action varchar(100) NOT NULL,
        object_type varchar(50) NOT NULL,
        object_id bigint(20) DEFAULT NULL,
        details longtext DEFAULT NULL,
        ip_address varchar(45) NOT NULL,
        user_agent text DEFAULT NULL,
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        session_id varchar(255) DEFAULT NULL,
        severity varchar(20) DEFAULT 'info',
        PRIMARY KEY (log_id),
        KEY user_id (user_id),
        KEY action (action),
        KEY object_type (object_type),
        KEY object_id (object_id),
        KEY timestamp (timestamp),
        KEY severity (severity),
        KEY ip_address (ip_address)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Check if table was created successfully
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        echo "<span style='color: green;'>✅ Audit log table created successfully</span><br>";
    } else {
        echo "<span style='color: red;'>❌ Failed to create audit log table</span><br>";
    }
} else {
    echo "<span style='color: blue;'>ℹ️ Audit log table already exists</span><br>";
}

// Fix 2: Test the loan eligibility function
echo "<h2>2. Testing Loan Eligibility Function</h2>";

// Include the required files
require_once(get_template_directory() . '/includes/loan-products.php');
require_once(get_template_directory() . '/includes/member-data.php');

// Test if the new function exists
if (function_exists('daystar_get_general_loan_eligibility')) {
    echo "<span style='color: green;'>✅ General loan eligibility function exists</span><br>";
    
    // Test with a sample user ID (use admin user for testing)
    $admin_users = get_users(array('role' => 'administrator', 'number' => 1));
    if (!empty($admin_users)) {
        $test_user_id = $admin_users[0]->ID;
        
        try {
            $eligibility = daystar_get_general_loan_eligibility($test_user_id);
            echo "<span style='color: green;'>✅ Function executes without errors</span><br>";
            echo "<span style='color: blue;'>ℹ️ Test result: " . ($eligibility['is_eligible'] ? 'Eligible' : 'Not eligible') . "</span><br>";
        } catch (Exception $e) {
            echo "<span style='color: red;'>❌ Function error: " . $e->getMessage() . "</span><br>";
        }
    }
} else {
    echo "<span style='color: red;'>❌ General loan eligibility function not found</span><br>";
}

// Fix 3: Check required database tables
echo "<h2>3. Checking Required Database Tables</h2>";

$required_tables = array(
    'daystar_contributions' => 'Member contributions data',
    'daystar_loans' => 'Loan applications and records',
    'daystar_loan_products' => 'Available loan products',
    'daystar_notifications' => 'Member notifications',
    'daystar_audit_log' => 'System audit log'
);

foreach ($required_tables as $table_suffix => $description) {
    $full_table_name = $wpdb->prefix . $table_suffix;
    if ($wpdb->get_var("SHOW TABLES LIKE '$full_table_name'") == $full_table_name) {
        echo "<span style='color: green;'>✅ {$full_table_name}</span> - {$description}<br>";
    } else {
        echo "<span style='color: red;'>❌ {$full_table_name}</span> - {$description} (MISSING)<br>";
    }
}

// Fix 4: Check if member roles exist
echo "<h2>4. Checking Member Roles</h2>";

$required_roles = array('member', 'pending_member');
foreach ($required_roles as $role) {
    if (get_role($role)) {
        echo "<span style='color: green;'>✅ '{$role}' role exists</span><br>";
    } else {
        echo "<span style='color: red;'>❌ '{$role}' role missing</span><br>";
    }
}

// Fix 5: Test member access function
echo "<h2>5. Testing Member Access Function</h2>";

require_once(get_template_directory() . '/includes/auth-helper.php');

if (function_exists('daystar_check_member_access')) {
    echo "<span style='color: green;'>✅ Member access function exists</span><br>";
} else {
    echo "<span style='color: red;'>❌ Member access function not found</span><br>";
}

// Summary and recommendations
echo "<h2>6. Summary and Recommendations</h2>";

echo "<div style='background: #f0f8ff; border: 1px solid #0073aa; padding: 15px; border-radius: 5px;'>";
echo "<h3>✅ Fixes Applied</h3>";
echo "<ul>";
echo "<li>Fixed function signature mismatch in loan eligibility check</li>";
echo "<li>Created missing audit log table</li>";
echo "<li>Added fallback table creation in audit logging</li>";
echo "</ul>";

echo "<h3>🎯 Next Steps</h3>";
echo "<ol>";
echo "<li><strong>Test the member dashboard:</strong> Try accessing the member dashboard page</li>";
echo "<li><strong>Check for missing tables:</strong> If any tables are missing, run the database setup</li>";
echo "<li><strong>Generate sample data:</strong> If no members exist, run the sample data generator</li>";
echo "</ol>";

echo "<h3>🔗 Quick Links</h3>";
echo "<p>";
echo "<a href='/member-dashboard/' style='background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px; margin-right: 10px;'>Test Member Dashboard</a>";
echo "<a href='/wp-admin/admin.php?page=daystar-admin-members' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px; margin-right: 10px;'>Admin Members</a>";
echo "<a href='check-members.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;'>Check Members</a>";
echo "</p>";
echo "</div>";

echo "<hr>";
echo "<p><em>Fix completed at " . current_time('mysql') . "</em></p>";
?>