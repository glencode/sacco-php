<?php
/**
 * Setup Credit Policy
 * 
 * This script creates and publishes the initial credit policy for the SACCO.
 * Run this once to set up the credit policy system.
 */

// Include WordPress
require_once('../../../../../../../wp-config.php');

// Include required files
require_once get_template_directory() . '/includes/policy-management.php';
require_once get_template_directory() . '/includes/sample-policy-content.php';

// Check if user has permission
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script. Please log in as an administrator.');
}

echo "<h1>Setting up Credit Policy</h1>\n";

// Create database tables first
echo "<p>Creating database tables...</p>\n";
PolicyManagementHandler::create_policy_tables();
echo "<p>✓ Database tables created successfully.</p>\n";

// Check if a policy already exists
$existing_policy = PolicyManagementHandler::get_current_policy();
if ($existing_policy) {
    echo "<p>⚠️ A published policy already exists (Version: {$existing_policy->version_number})</p>\n";
    echo "<p>Current policy title: {$existing_policy->title}</p>\n";
    echo "<p>Published date: {$existing_policy->published_date}</p>\n";
    echo "<p><a href='" . home_url('/credit-policy/') . "'>View Current Policy</a></p>\n";
    exit;
}

// Create the initial policy version
echo "<p>Creating initial policy version...</p>\n";

$title = 'Daystar SACCO Credit Policy';
$version_number = '1.0';
$content = get_sample_policy_content();
$effective_date = current_time('mysql');

$result = PolicyManagementHandler::create_policy_version($title, $content, $version_number, $effective_date);

if (!$result['success']) {
    die("<p>❌ Failed to create policy: " . $result['message'] . "</p>\n");
}

echo "<p>✓ Policy version created successfully (ID: {$result['policy_id']})</p>\n";

// Publish the policy
echo "<p>Publishing the policy...</p>\n";

$publish_result = PolicyManagementHandler::publish_policy_version($result['policy_id']);

if (!$publish_result['success']) {
    die("<p>❌ Failed to publish policy: " . $publish_result['message'] . "</p>\n");
}

echo "<p>✓ Policy published successfully!</p>\n";

// Verify the policy is now available
$current_policy = PolicyManagementHandler::get_current_policy();
if ($current_policy) {
    echo "<p>✓ Policy verification successful</p>\n";
    echo "<p><strong>Policy Details:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Title: {$current_policy->title}</li>\n";
    echo "<li>Version: {$current_policy->version_number}</li>\n";
    echo "<li>Status: {$current_policy->status}</li>\n";
    echo "<li>Effective Date: {$current_policy->effective_date}</li>\n";
    echo "<li>Published Date: {$current_policy->published_date}</li>\n";
    echo "</ul>\n";
} else {
    echo "<p>❌ Policy verification failed - policy not found</p>\n";
}

echo "<h2>Setup Complete!</h2>\n";
echo "<p>The credit policy has been successfully set up and published.</p>\n";
echo "<p><strong>Next Steps:</strong></p>\n";
echo "<ul>\n";
echo "<li><a href='" . home_url('/credit-policy/') . "'>View the Credit Policy Page</a></li>\n";
echo "<li><a href='" . admin_url('admin.php?page=daystar-admin-policy') . "'>Manage Policies (Admin)</a></li>\n";
echo "<li>Test the PDF download functionality</li>\n";
echo "<li>Verify member notifications work correctly</li>\n";
echo "</ul>\n";

echo "<p><em>You can now delete this setup file as it's no longer needed.</em></p>\n";
?>