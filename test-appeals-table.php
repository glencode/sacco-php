<?php
/**
 * Test file to verify loan appeals table creation
 * This file can be run to check if the appeals table exists
 */

// Include WordPress
require_once('../../../../../../../wp-config.php');

global $wpdb;

$appeals_table = $wpdb->prefix . 'daystar_loan_appeals';

// Check if table exists
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$appeals_table'") == $appeals_table;

echo "<h2>Loan Appeals Table Test</h2>";
echo "<p><strong>Table Name:</strong> $appeals_table</p>";
echo "<p><strong>Table Exists:</strong> " . ($table_exists ? 'YES' : 'NO') . "</p>";

if (!$table_exists) {
    echo "<p style='color: red;'>Table does not exist. Creating table...</p>";
    
    // Create the table
    $charset_collate = $wpdb->get_charset_collate();
    
    $loan_appeals_sql = "CREATE TABLE $appeals_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        loan_id mediumint(9) NOT NULL,
        user_id bigint(20) NOT NULL,
        appeal_date datetime DEFAULT CURRENT_TIMESTAMP,
        reason_for_appeal text NOT NULL,
        supporting_documents text,
        status varchar(20) DEFAULT 'pending',
        resolution_details text,
        resolved_by_user_id bigint(20) NULL,
        resolved_date datetime NULL,
        appeal_deadline date,
        committee_hearing_date datetime NULL,
        committee_notes text,
        original_rejection_reason text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY loan_id (loan_id),
        KEY user_id (user_id),
        KEY status (status),
        KEY appeal_date (appeal_date),
        KEY appeal_deadline (appeal_deadline),
        KEY committee_hearing_date (committee_hearing_date)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $result = dbDelta($loan_appeals_sql);
    
    echo "<p><strong>Creation Result:</strong></p>";
    echo "<pre>" . print_r($result, true) . "</pre>";
    
    // Check again
    $table_exists_after = $wpdb->get_var("SHOW TABLES LIKE '$appeals_table'") == $appeals_table;
    echo "<p><strong>Table Exists After Creation:</strong> " . ($table_exists_after ? 'YES' : 'NO') . "</p>";
} else {
    echo "<p style='color: green;'>Table exists! Checking structure...</p>";
    
    // Show table structure
    $columns = $wpdb->get_results("DESCRIBE $appeals_table");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>{$column->Field}</td>";
        echo "<td>{$column->Type}</td>";
        echo "<td>{$column->Null}</td>";
        echo "<td>{$column->Key}</td>";
        echo "<td>{$column->Default}</td>";
        echo "<td>{$column->Extra}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check for sample data
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $appeals_table");
    echo "<p><strong>Records in table:</strong> $count</p>";
    
    if ($count > 0) {
        $appeals = $wpdb->get_results("SELECT * FROM $appeals_table LIMIT 5");
        echo "<h3>Sample Appeals:</h3>";
        echo "<pre>" . print_r($appeals, true) . "</pre>";
    }
}

// Test other related tables
$loans_table = $wpdb->prefix . 'daystar_loans';
$loans_exist = $wpdb->get_var("SHOW TABLES LIKE '$loans_table'") == $loans_table;
echo "<p><strong>Loans Table Exists:</strong> " . ($loans_exist ? 'YES' : 'NO') . "</p>";

if ($loans_exist) {
    $rejected_loans = $wpdb->get_var("SELECT COUNT(*) FROM $loans_table WHERE status = 'rejected'");
    echo "<p><strong>Rejected Loans (appealable):</strong> $rejected_loans</p>";
}

echo "<hr>";
echo "<p><em>Test completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>