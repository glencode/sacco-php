<?php
/**
 * Manual table creation for loan appeals
 * Run this file once to create the appeals table
 */

// Include WordPress
require_once('../../../../../../../wp-config.php');

global $wpdb;

$appeals_table = $wpdb->prefix . 'daystar_loan_appeals';

// Check if table exists
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$appeals_table'") == $appeals_table;

if (!$table_exists) {
    echo "<h2>Creating Loan Appeals Table...</h2>";
    
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
    
    // Check if table was created
    $table_exists_after = $wpdb->get_var("SHOW TABLES LIKE '$appeals_table'") == $appeals_table;
    
    if ($table_exists_after) {
        echo "<p style='color: green; font-weight: bold;'>✅ Table created successfully!</p>";
        
        // Add sample data
        $loans_table = $wpdb->prefix . 'daystar_loans';
        
        // Get first user
        $sample_user = get_users(array('number' => 1));
        if (!empty($sample_user)) {
            $user_id = $sample_user[0]->ID;
            
            // Create a sample rejected loan
            $rejected_loan_id = $wpdb->insert(
                $loans_table,
                array(
                    'user_id' => $user_id,
                    'loan_type' => 'emergency',
                    'amount' => 50000.00,
                    'balance' => 0.00,
                    'interest_rate' => 12.00,
                    'term_months' => 12,
                    'monthly_payment' => 0.00,
                    'loan_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
                    'status' => 'rejected',
                    'purpose' => 'Medical emergency',
                    'approved_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
                    'rejection_reason' => 'Insufficient share capital. Current share capital is below the required minimum of KES 5,000.',
                    'application_waiting_number' => 'APP-2024-SAMPLE',
                    'priority_score' => 85
                )
            );
            
            if ($rejected_loan_id) {
                $rejected_loan_id = $wpdb->insert_id;
                
                // Add sample appeal
                $appeal_result = $wpdb->insert(
                    $appeals_table,
                    array(
                        'loan_id' => $rejected_loan_id,
                        'user_id' => $user_id,
                        'appeal_date' => date('Y-m-d H:i:s', strtotime('-5 days')),
                        'reason_for_appeal' => 'I believe my share capital calculation was incorrect. I have made additional contributions since my application was submitted, bringing my total share capital to KES 6,500. I have attached bank statements showing these recent contributions. This medical emergency is urgent as it involves my child\'s surgery.',
                        'status' => 'pending',
                        'appeal_deadline' => date('Y-m-d', strtotime('+5 days')),
                        'original_rejection_reason' => 'Insufficient share capital. Current share capital is below the required minimum of KES 5,000.'
                    )
                );
                
                if ($appeal_result) {
                    echo "<p style='color: blue;'>📝 Sample appeal data added successfully!</p>";
                } else {
                    echo "<p style='color: orange;'>⚠️ Table created but failed to add sample appeal data.</p>";
                }
            } else {
                echo "<p style='color: orange;'>⚠️ Table created but failed to add sample loan data.</p>";
            }
        }
        
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ Failed to create table!</p>";
    }
} else {
    echo "<h2>Table Already Exists</h2>";
    echo "<p style='color: green;'>✅ The loan appeals table already exists.</p>";
    
    // Show table info
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $appeals_table");
    echo "<p><strong>Records in table:</strong> $count</p>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li>✅ Database table: wp_daystar_loan_appeals</li>";
echo "<li>✅ Backend logic: includes/loan-appeals.php</li>";
echo "<li>✅ Frontend page: page-loan-appeal.php</li>";
echo "<li>✅ Admin interface: includes/admin/admin-loan-appeals.php</li>";
echo "<li>✅ Integration: Added to loan-admin.php</li>";
echo "</ul>";

echo "<p><strong>Access Points:</strong></p>";
echo "<ul>";
echo "<li><strong>Member Appeal Page:</strong> <a href='" . home_url('/loan-appeal/') . "'>/loan-appeal/</a></li>";
echo "<li><strong>Admin Appeals:</strong> <a href='" . admin_url('admin.php?page=daystar-loan-appeals') . "'>Admin Dashboard → Loan Appeals</a></li>";
echo "</ul>";

echo "<p><em>Setup completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>