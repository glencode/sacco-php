<?php
/**
 * Fix Member Roles Script
 * Updates existing sample data users to have correct roles
 */

// Include WordPress
require_once('../../../wp-config.php');

if (!current_user_can('manage_options')) {
    die('Access denied. You must be an administrator to run this script.');
}

echo "<h1>🔧 Fix Member Roles</h1>";
echo "<p>This script will update existing sample data users to have the correct roles for the SACCO system.</p>";

// Get all users with member numbers (sample data users)
$users_with_member_numbers = get_users(array(
    'meta_key' => 'member_number',
    'meta_compare' => 'EXISTS',
    'number' => -1
));

echo "<h2>Found " . count($users_with_member_numbers) . " users with member numbers</h2>";

$updated_count = 0;
$pending_count = 0;
$active_count = 0;

foreach ($users_with_member_numbers as $user) {
    $member_number = get_user_meta($user->ID, 'member_number', true);
    $member_status = get_user_meta($user->ID, 'member_status', true);
    $current_roles = $user->roles;
    
    echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
    echo "<strong>{$user->display_name}</strong> (ID: {$user->ID}, Member: {$member_number})<br>";
    echo "Current Status: {$member_status}<br>";
    echo "Current Roles: " . implode(', ', $current_roles) . "<br>";
    
    // Determine correct role based on member status
    $correct_role = ($member_status === 'pending') ? 'pending_member' : 'member';
    
    // Check if user has the correct role
    if (!in_array($correct_role, $current_roles)) {
        // Remove all current roles
        foreach ($current_roles as $role) {
            $user->remove_role($role);
        }
        
        // Add correct role
        $user->add_role($correct_role);
        
        echo "<span style='color: green;'>✅ Updated role to: {$correct_role}</span><br>";
        $updated_count++;
        
        if ($correct_role === 'pending_member') {
            $pending_count++;
        } else {
            $active_count++;
        }
    } else {
        echo "<span style='color: blue;'>ℹ️ Role already correct: {$correct_role}</span><br>";
        
        if ($correct_role === 'pending_member') {
            $pending_count++;
        } else {
            $active_count++;
        }
    }
    
    echo "</div>";
}

echo "<h2>Summary</h2>";
echo "<ul>";
echo "<li><strong>Total users processed:</strong> " . count($users_with_member_numbers) . "</li>";
echo "<li><strong>Users updated:</strong> {$updated_count}</li>";
echo "<li><strong>Active members:</strong> {$active_count}</li>";
echo "<li><strong>Pending members:</strong> {$pending_count}</li>";
echo "</ul>";

echo "<h3>✅ Role fix completed!</h3>";
echo "<p>You can now check the admin member management page to see your members.</p>";
echo "<p><a href='/wp-admin/admin.php?page=daystar-admin-members' style='background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;'>Go to Member Management</a></p>";

// Also check if the member and pending_member roles exist
echo "<h3>Role Status Check</h3>";
$member_role = get_role('member');
$pending_member_role = get_role('pending_member');

if ($member_role) {
    echo "<span style='color: green;'>✅ 'member' role exists</span><br>";
} else {
    echo "<span style='color: red;'>❌ 'member' role does not exist</span><br>";
}

if ($pending_member_role) {
    echo "<span style='color: green;'>✅ 'pending_member' role exists</span><br>";
} else {
    echo "<span style='color: red;'>❌ 'pending_member' role does not exist</span><br>";
}

echo "<hr>";
echo "<p><em>Script completed at " . current_time('mysql') . "</em></p>";
?>