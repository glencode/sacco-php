<?php
/**
 * Check Members Script
 * Diagnoses the current state of members in the system
 */

// Include WordPress
require_once('../../../wp-config.php');

if (!current_user_can('manage_options')) {
    die('Access denied. You must be an administrator to run this script.');
}

echo "<h1>🔍 Member System Diagnostic</h1>";
echo "<p>This script checks the current state of members in your SACCO system.</p>";

// Check 1: All users with member numbers
echo "<h2>1. Users with Member Numbers</h2>";
$users_with_member_numbers = get_users(array(
    'meta_key' => 'member_number',
    'meta_compare' => 'EXISTS',
    'number' => -1
));

echo "<p><strong>Found:</strong> " . count($users_with_member_numbers) . " users with member numbers</p>";

if (!empty($users_with_member_numbers)) {
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'>";
    echo "<th>ID</th><th>Name</th><th>Email</th><th>Member Number</th><th>Status</th><th>Roles</th>";
    echo "</tr>";
    
    foreach ($users_with_member_numbers as $user) {
        $member_number = get_user_meta($user->ID, 'member_number', true);
        $member_status = get_user_meta($user->ID, 'member_status', true);
        $roles = implode(', ', $user->roles);
        
        echo "<tr>";
        echo "<td>{$user->ID}</td>";
        echo "<td>{$user->display_name}</td>";
        echo "<td>{$user->user_email}</td>";
        echo "<td>{$member_number}</td>";
        echo "<td>{$member_status}</td>";
        echo "<td>{$roles}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>❌ No users found with member numbers. This suggests sample data hasn't been generated or there's an issue.</p>";
}

// Check 2: Users by role
echo "<h2>2. Users by Role</h2>";

$member_users = get_users(array('role' => 'member'));
$pending_member_users = get_users(array('role' => 'pending_member'));
$subscriber_users = get_users(array('role' => 'subscriber'));

echo "<ul>";
echo "<li><strong>Member role:</strong> " . count($member_users) . " users</li>";
echo "<li><strong>Pending Member role:</strong> " . count($pending_member_users) . " users</li>";
echo "<li><strong>Subscriber role:</strong> " . count($subscriber_users) . " users</li>";
echo "</ul>";

// Check 3: What the admin function would return
echo "<h2>3. Admin Function Results</h2>";

// Include the admin functions
require_once(get_template_directory() . '/includes/admin/admin-members.php');

$active_members = daystar_get_members_by_status('active');
$pending_members = daystar_get_members_by_status('pending');
$suspended_members = daystar_get_members_by_status('suspended');
$all_members = daystar_get_members_by_status('all');

echo "<ul>";
echo "<li><strong>Active members:</strong> " . count($active_members) . "</li>";
echo "<li><strong>Pending members:</strong> " . count($pending_members) . "</li>";
echo "<li><strong>Suspended members:</strong> " . count($suspended_members) . "</li>";
echo "<li><strong>All members:</strong> " . count($all_members) . "</li>";
echo "</ul>";

// Check 4: Role existence
echo "<h2>4. Role Status</h2>";
$member_role = get_role('member');
$pending_member_role = get_role('pending_member');

echo "<ul>";
if ($member_role) {
    echo "<li style='color: green;'>✅ 'member' role exists</li>";
} else {
    echo "<li style='color: red;'>❌ 'member' role does not exist</li>";
}

if ($pending_member_role) {
    echo "<li style='color: green;'>✅ 'pending_member' role exists</li>";
} else {
    echo "<li style='color: red;'>❌ 'pending_member' role does not exist</li>";
}
echo "</ul>";

// Check 5: Sample data with DS member numbers
echo "<h2>5. Sample Data Check</h2>";
$sample_users = get_users(array(
    'meta_key' => 'member_number',
    'meta_value' => 'DS',
    'meta_compare' => 'LIKE',
    'number' => -1
));

echo "<p><strong>Sample users (DS* member numbers):</strong> " . count($sample_users) . "</p>";

if (!empty($sample_users)) {
    echo "<p style='color: green;'>✅ Sample data appears to be present</p>";
} else {
    echo "<p style='color: orange;'>⚠️ No sample data found. You may need to run the sample data generator.</p>";
}

// Recommendations
echo "<h2>6. Recommendations</h2>";

if (count($users_with_member_numbers) == 0) {
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px;'>";
    echo "<h3>🎯 Action Required: Generate Sample Data</h3>";
    echo "<p>No members found. You need to generate sample data:</p>";
    echo "<ol>";
    echo "<li>Go to <strong>WordPress Admin → Demo Setup</strong></li>";
    echo "<li>Click <strong>'Setup Complete Demo System'</strong></li>";
    echo "<li>Or go to <strong>Tools → Sample Data Generator</strong></li>";
    echo "</ol>";
    echo "</div>";
} elseif (count($all_members) == 0) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
    echo "<h3>🔧 Action Required: Fix User Roles</h3>";
    echo "<p>Members exist but aren't showing in admin. Run the role fix script:</p>";
    echo "<p><a href='fix-member-roles.php' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;'>Run Role Fix Script</a></p>";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px;'>";
    echo "<h3>✅ System Looks Good!</h3>";
    echo "<p>Members are properly configured and should be visible in the admin.</p>";
    echo "<p><a href='/wp-admin/admin.php?page=daystar-admin-members' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;'>Go to Member Management</a></p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><em>Diagnostic completed at " . current_time('mysql') . "</em></p>";
?>