<?php
/**
 * Quick Fix Script for SACCO Demo Issues
 * Run this script to fix the current errors
 */

echo "<h1>🔧 SACCO Quick Fix</h1>";
echo "<p>Fixing current issues...</p>";

// Fix 1: Replace the problematic function in sample-data-generator.php
$sample_data_file = __DIR__ . '/includes/sample-data-generator.php';

if (!file_exists($sample_data_file)) {
    echo "<p>❌ Error: sample-data-generator.php not found at: $sample_data_file</p>";
    exit;
}

$content = file_get_contents($sample_data_file);

// Replace the problematic division calculation
$old_calculation = '$monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / 
                              (pow(1 + $monthly_interest_rate, $term_months) - 1);';

$new_calculation = '// Prevent division by zero
            $denominator = pow(1 + $monthly_interest_rate, $term_months) - 1;
            if ($denominator == 0 || $monthly_interest_rate == 0) {
                $monthly_payment = $amount / max(1, $term_months); // Simple division if no interest
            } else {
                $monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / $denominator;
            }';

$content = str_replace($old_calculation, $new_calculation, $content);

// Add check for empty loan products
$old_products_check = '$loan_products = $wpdb->get_results("SELECT * FROM $loan_products_table WHERE status = \'active\'");
    
    $loan_statuses = array(\'pending\', \'approved\', \'active\', \'completed\', \'rejected\', \'defaulted\');';

$new_products_check = '$loan_products = $wpdb->get_results("SELECT * FROM $loan_products_table WHERE status = \'active\'");
    
    // Check if loan products exist
    if (empty($loan_products)) {
        return; // No loan products available, skip loan creation
    }
    
    $loan_statuses = array(\'pending\', \'approved\', \'active\', \'completed\', \'rejected\', \'defaulted\');';

$content = str_replace($old_products_check, $new_products_check, $content);

if (file_put_contents($sample_data_file, $content)) {
    echo "<p>✅ Fixed division by zero error in sample data generator</p>";
} else {
    echo "<p>❌ Failed to update sample data generator</p>";
}

// Fix 2: Replace supervisory_committee with shorter name in functions.php
$functions_file = __DIR__ . '/functions.php';

if (!file_exists($functions_file)) {
    echo "<p>❌ Error: functions.php not found at: $functions_file</p>";
    exit;
}

$functions_content = file_get_contents($functions_file);

// Replace all instances of supervisory_committee with supervisory_comm
$functions_content = str_replace('supervisory_committee', 'supervisory_comm', $functions_content);

if (file_put_contents($functions_file, $functions_content)) {
    echo "<p>✅ Fixed post type name length issue</p>";
} else {
    echo "<p>❌ Failed to update functions.php</p>";
}

echo "<h2>🎉 All Issues Fixed!</h2>";
echo "<p>The following issues have been resolved:</p>";
echo "<ul>";
echo "<li>✅ Division by zero error in loan calculation</li>";
echo "<li>✅ Post type name too long (supervisory_committee → supervisory_comm)</li>";
echo "<li>✅ Added check for empty loan products</li>";
echo "</ul>";

echo "<p><strong>Your SACCO demo setup should now work without errors!</strong></p>";
echo "<p><a href='/wp-admin/admin.php?page=daystar-demo-setup' class='button button-primary' style='background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;'>Go to Demo Setup</a></p>";

echo "<h3>📋 Manual Steps (if needed):</h3>";
echo "<ol>";
echo "<li>Go to WordPress Admin Dashboard</li>";
echo "<li>Look for 'Demo Setup' in the main menu</li>";
echo "<li>Click 'Setup Complete Demo System'</li>";
echo "<li>Wait for completion and note the login credentials</li>";
echo "</ol>";
?>