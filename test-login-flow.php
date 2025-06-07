<?php
/**
 * Test file to debug login flow and redirections
 */

define('WP_USE_THEMES', false); 
require_once(__DIR__ . '/../../../../wp-load.php');

echo "Testing login flow:\n\n";

// Test 1: Check login form hidden fields
$form = file_get_contents(__DIR__ . '/page-login.php');
echo "1. Login form hidden fields:\n";
if (strpos($form, 'wp_nonce_field(\'daystar_login\', \'login_nonce\')') !== false) {
    echo "✓ Nonce field present\n";
} else {
    echo "✗ Missing nonce field\n";
}
if (strpos($form, 'name="action" value="daystar_login"') !== false) {
    echo "✓ Action field present\n";
} else {
    echo "✗ Missing action field\n";
}

// Test 2: Check login handler hook
echo "\n2. Login action hook registration:\n";
if (has_action('admin_post_daystar_login') || has_action('admin_post_nopriv_daystar_login')) {
    echo "✓ Login action hook registered\n";
} else {
    echo "✗ Login action hook not found\n";
}

// Test 3: Check redirect handling
echo "\n3. Redirect handling:\n";
if (strpos($form, 'redirect_to') !== false) {
    echo "✓ Redirect parameter present in form\n";
} else {
    echo "✗ Missing redirect parameter\n";
}

// Test 4: Check auth helper functions
echo "\n4. Auth helper functions:\n";
if (function_exists('daystar_check_member_access')) {
    echo "✓ Member access check function exists\n";
} else {
    echo "✗ Missing member access check function\n";
}

// Test 5: Check login error handling
echo "\n5. Login error handling:\n";
if (strpos($form, 'form-message') !== false) {
    echo "✓ Error display container present\n";
} else {
    echo "✗ Missing error display container\n";
}
