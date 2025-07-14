<?php
/**
 * Admin cleanup functions for database maintenance
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for cleanup functions
 */
function daystar_add_cleanup_admin_menu() {
    add_management_page(
        'Database Cleanup',
        'Database Cleanup',
        'manage_options',
        'daystar-cleanup',
        'daystar_cleanup_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_cleanup_admin_menu');

/**
 * Admin page for cleanup functions
 */
function daystar_cleanup_admin_page() {
    $message = '';
    $message_type = '';
    
    if (isset($_POST['remove_refinance_loan'])) {
        $result = daystar_remove_refinance_loan();
        $message = $result['message'];
        $message_type = $result['success'] ? 'success' : 'error';
    }
    
    if (isset($_POST['ensure_core_products'])) {
        $result = daystar_ensure_core_loan_products();
        $message = $result['message'];
        $message_type = $result['success'] ? 'success' : 'error';
    }
    
    if (isset($_POST['reset_all_products'])) {
        $result = daystar_reset_all_loan_products();
        $message = $result['message'];
        $message_type = $result['success'] ? 'success' : 'error';
    }
    
    if (isset($_POST['add_special_loan'])) {
        $result = daystar_add_special_loan_specifically();
        $message = $result['message'];
        $message_type = $result['success'] ? 'success' : 'error';
    }
    
    if (isset($_POST['debug_database'])) {
        $result = daystar_debug_database_state();
        $message = $result['message'];
        $message_type = 'info';
    }
    
    if (isset($_POST['fix_schema'])) {
        $result = daystar_fix_database_schema();
        $message = $result['message'];
        $message_type = $result['success'] ? 'success' : 'error';
    }
    
    if ($message) {
        echo '<div class="notice notice-' . $message_type . '"><p>' . $message . '</p></div>';
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    ?>
    <div class="wrap">
        <h1>Database Cleanup & Management</h1>
        <p>Use these tools to clean up database inconsistencies and ensure compliance with current credit policies.</p>
        
        <!-- Core Loan Products Status -->
        <div class="card">
            <h2>Core Loan Products Status</h2>
            <p>According to the SACCO credit policy, there should be exactly 6 loan products:</p>
            
            <?php
            $core_products = daystar_get_core_loan_products_config();
            $existing_products = $wpdb->get_results("SELECT name, min_amount, max_amount, interest_rate, interest_type, min_term_months, max_term_months FROM $loan_products_table WHERE status = 'active' ORDER BY name");
            
            $existing_names = array_column($existing_products, 'name');
            $core_names = array_keys($core_products);
            
            echo '<div class="loan-products-status">';
            echo '<h3>Expected Products vs Current Database:</h3>';
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>Product Name</th><th>Status</th><th>Amount Range</th><th>Interest Rate</th><th>Term</th></tr></thead>';
            echo '<tbody>';
            
            foreach ($core_products as $name => $config) {
                $exists = in_array($name, $existing_names);
                $status_class = $exists ? 'success' : 'error';
                $status_text = $exists ? '✓ Present' : '✗ Missing';
                
                echo '<tr>';
                echo '<td><strong>' . esc_html($name) . '</strong></td>';
                echo '<td><span class="status-' . $status_class . '">' . $status_text . '</span></td>';
                echo '<td>KSh ' . number_format($config['min_amount']) . ' - KSh ' . number_format($config['max_amount']) . '</td>';
                echo '<td>' . $config['interest_rate'] . '% ' . (in_array($config['interest_type'], ['monthly_reducing_balance', 'monthly_reducing']) ? 'p.m.' : 'p.a.') . '</td>';
                echo '<td>' . $config['min_term_months'] . '-' . $config['max_term_months'] . ' months</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
            echo '</div>';
            
            // Check for extra products
            $extra_products = array_diff($existing_names, $core_names);
            if (!empty($extra_products)) {
                echo '<div class="notice notice-warning inline">';
                echo '<p><strong>Extra Products Found:</strong> ' . implode(', ', $extra_products) . '</p>';
                echo '<p>These products are not part of the core credit policy and should be reviewed.</p>';
                echo '</div>';
            }
            
            $missing_products = array_diff($core_names, $existing_names);
            if (!empty($missing_products)) {
                echo '<div class="notice notice-error inline">';
                echo '<p><strong>Missing Products:</strong> ' . implode(', ', $missing_products) . '</p>';
                echo '</div>';
            }
            
            if (empty($missing_products) && empty($extra_products)) {
                echo '<div class="notice notice-success inline">';
                echo '<p><strong>✓ All core loan products are properly configured!</strong></p>';
                echo '</div>';
            }
            ?>
            
            <div class="cleanup-actions">
                <h3>Management Actions:</h3>
                
                <?php if (!empty($missing_products)) : ?>
                <form method="post" style="display: inline-block; margin-right: 10px;">
                    <input type="hidden" name="ensure_core_products" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button button-primary">Add Missing Core Products</button>
                </form>
                <?php endif; ?>
                
                <form method="post" style="display: inline-block; margin-right: 10px;" onsubmit="return confirm('This will reset ALL loan products to match the credit policy. Continue?');">
                    <input type="hidden" name="reset_all_products" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button button-secondary">Reset All Products to Policy Standards</button>
                </form>
                
                <?php if (in_array('Special Loan', $missing_products)) : ?>
                <form method="post" style="display: inline-block; margin-right: 10px;">
                    <input type="hidden" name="add_special_loan" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button button-primary">Add Special Loan Only</button>
                </form>
                <?php endif; ?>
                
                <form method="post" style="display: inline-block; margin-right: 10px;">
                    <input type="hidden" name="debug_database" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button">Debug Database State</button>
                </form>
                
                <form method="post" style="display: inline-block;">
                    <input type="hidden" name="fix_schema" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button button-secondary">Fix Database Schema</button>
                </form>
            </div>
        </div>
        
        <!-- Refinance Loan Cleanup -->
        <div class="card">
            <h2>Legacy Product Cleanup</h2>
            <p>Remove products that are no longer part of the credit policy.</p>
            
            <?php
            $refinance_exists = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $loan_products_table WHERE name = %s",
                'Refinance Loan'
            ));
            
            if ($refinance_exists > 0) {
                echo '<p><strong>Status:</strong> <span class="status-error">Refinance Loan product found in database.</span></p>';
                ?>
                <form method="post" style="display: inline-block;">
                    <input type="hidden" name="remove_refinance_loan" value="1">
                    <?php wp_nonce_field('daystar_cleanup_nonce'); ?>
                    <button type="submit" class="button button-primary">Remove Refinance Loan</button>
                </form>
                <?php
            } else {
                echo '<p><strong>Status:</strong> <span class="status-success">✓ No legacy products found.</span></p>';
            }
            ?>
        </div>
        
        <!-- Current Database State -->
        <div class="card">
            <h2>Current Database State</h2>
            <p>All loan products currently in the database:</p>
            
            <?php
            if ($existing_products) {
                echo '<table class="wp-list-table widefat fixed striped">';
                echo '<thead><tr><th>Product Name</th><th>Amount Range</th><th>Interest Rate</th><th>Term Range</th><th>Interest Type</th></tr></thead>';
                echo '<tbody>';
                
                foreach ($existing_products as $product) {
                    $is_core = in_array($product->name, $core_names);
                    $row_class = $is_core ? '' : 'style="background-color: #fff3cd;"';
                    
                    echo '<tr ' . $row_class . '>';
                    echo '<td>' . esc_html($product->name) . ($is_core ? '' : ' <em>(non-core)</em>') . '</td>';
                    echo '<td>KSh ' . number_format($product->min_amount) . ' - KSh ' . number_format($product->max_amount) . '</td>';
                    echo '<td>' . $product->interest_rate . '%</td>';
                    echo '<td>' . $product->min_term_months . '-' . $product->max_term_months . ' months</td>';
                    echo '<td>' . esc_html($product->interest_type) . '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<p><strong>No loan products found in database.</strong></p>';
                echo '<form method="post">';
                echo '<input type="hidden" name="ensure_core_products" value="1">';
                wp_nonce_field('daystar_cleanup_nonce');
                echo '<button type="submit" class="button button-primary">Create Core Loan Products</button>';
                echo '</form>';
            }
            ?>
        </div>
        
        <!-- Database Statistics -->
        <div class="card">
            <h2>Database Statistics</h2>
            <?php
            $stats = daystar_get_database_stats();
            echo '<div class="database-stats">';
            echo '<div class="stat-grid">';
            foreach ($stats as $label => $count) {
                echo '<div class="stat-item">';
                echo '<div class="stat-number">' . number_format($count) . '</div>';
                echo '<div class="stat-label">' . $label . '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            ?>
        </div>
    </div>
    
    <style>
    .status-success { color: #46b450; font-weight: bold; }
    .status-error { color: #dc3232; font-weight: bold; }
    .cleanup-actions { margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd; }
    .loan-products-status { margin: 15px 0; }
    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
    .stat-item { text-align: center; padding: 15px; background: #f9f9f9; border-radius: 4px; }
    .stat-number { font-size: 24px; font-weight: bold; color: #0073aa; }
    .stat-label { font-size: 12px; color: #666; margin-top: 5px; }
    .database-stats { margin: 15px 0; }
    </style>
    <?php
}

/**
 * Remove Refinance Loan from database
 */
function daystar_remove_refinance_loan() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['_wpnonce'], 'daystar_cleanup_nonce')) {
        return array('success' => false, 'message' => 'Security check failed.');
    }
    
    global $wpdb;
    
    // Remove Refinance Loan from loan products table
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    $result = $wpdb->delete(
        $loan_products_table,
        array('name' => 'Refinance Loan')
    );
    
    if ($result !== false) {
        $message = "Successfully removed Refinance Loan from loan products. Rows affected: " . $result;
        
        // Check for existing loans of this type
        $loans_table = $wpdb->prefix . 'daystar_loans';
        $loan_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $loans_table WHERE loan_type = %s",
            'Refinance Loan'
        ));
        
        if ($loan_count > 0) {
            $message .= " Warning: Found $loan_count existing Refinance Loan applications in the system. These should be reviewed and possibly converted to other loan types.";
        } else {
            $message .= " No existing Refinance Loan applications found.";
        }
        
        return array('success' => true, 'message' => $message);
    } else {
        return array('success' => false, 'message' => 'Error removing Refinance Loan or it doesn\'t exist.');
    }
}

/**
 * Get core loan products configuration according to credit policy
 */
function daystar_get_core_loan_products_config() {
    return array(
        'Development Loan' => array(
            'name' => 'Development Loan',
            'description' => 'Long-term development projects and investments with competitive rates.',
            'min_amount' => 10000.00,
            'max_amount' => 2000000.00,
            'min_term_months' => 1,
            'max_term_months' => 36,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount'),
                array('name' => 'Insurance', 'type' => 'percentage', 'value' => 0.5, 'basis' => 'loan_amount')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'requires_payslip' => true,
                'no_outstanding_development_loan' => true,
                'submission_deadline' => 30
            ),
            'required_documents' => array(
                array('name' => 'Payslip', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Project Proposal', 'mandatory' => false)
            ),
            'priority_score_factor' => 70,
            'status' => 'active'
        ),
        'School Fees Loan' => array(
            'name' => 'School Fees Loan',
            'description' => 'Education financing for school fees and related educational expenses.',
            'min_amount' => 5000.00,
            'max_amount' => 500000.00,
            'min_term_months' => 1,
            'max_term_months' => 12,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'no_outstanding_school_fees_loan' => true
            ),
            'required_documents' => array(
                array('name' => 'Fee Structure', 'mandatory' => true),
                array('name' => 'Admission Letter', 'mandatory' => false),
                array('name' => 'National ID Copy', 'mandatory' => true)
            ),
            'priority_score_factor' => 80,
            'status' => 'active'
        ),
        'Emergency Loan' => array(
            'name' => 'Emergency Loan',
            'description' => 'Quick financial assistance for unexpected emergency situations.',
            'min_amount' => 5000.00,
            'max_amount' => 100000.00,
            'min_term_months' => 1,
            'max_term_months' => 12,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 1.0, 'basis' => 'loan_amount')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 6,
                'min_share_capital' => 5000,
                'min_contributions' => 12000,
                'requires_guarantors' => true,
                'no_outstanding_emergency_loan' => true,
                'emergency_types' => array('hospitalization', 'funeral', 'court_fine', 'accident')
            ),
            'required_documents' => array(
                array('name' => 'Emergency Evidence', 'mandatory' => true),
                array('name' => 'Medical Report', 'mandatory' => false, 'condition' => 'hospitalization'),
                array('name' => 'Death Certificate', 'mandatory' => false, 'condition' => 'funeral'),
                array('name' => 'Court Order', 'mandatory' => false, 'condition' => 'court_fine'),
                array('name' => 'National ID Copy', 'mandatory' => true)
            ),
            'priority_score_factor' => 90,
            'status' => 'active'
        ),
        'Special Loan' => array(
            'name' => 'Special Loan',
            'description' => 'Character-based loans without payslip consideration for trusted members.',
            'min_amount' => 10000.00,
            'max_amount' => 200000.00,
            'min_term_months' => 4,
            'max_term_months' => 6,
            'interest_rate' => 5.00,
            'interest_type' => 'monthly_reducing',
            'charges' => array(
                array('name' => 'Deferral Charge', 'type' => 'percentage', 'value' => 2.0, 'basis' => 'outstanding_balance', 'condition' => 'deferral'),
                array('name' => 'Bounced Cheque Penalty', 'type' => 'flat', 'value' => 1000.00, 'condition' => 'bounced_cheque')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 12,
                'min_share_capital' => 10000,
                'good_credit_history' => true,
                'requires_postdated_cheques' => true,
                'no_payslip_required' => true,
                'term_based_on_amount' => array(
                    array('min_amount' => 10000, 'max_amount' => 100000, 'term_months' => 4),
                    array('min_amount' => 100001, 'max_amount' => 200000, 'term_months' => 6)
                )
            ),
            'required_documents' => array(
                array('name' => 'Post-dated Cheques', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Character Reference', 'mandatory' => false)
            ),
            'priority_score_factor' => 60,
            'status' => 'active'
        ),
        'Super Saver Loan' => array(
            'name' => 'Super Saver Loan',
            'description' => 'Premium loans for high-deposit members with excellent terms.',
            'min_amount' => 50000.00,
            'max_amount' => 3000000.00,
            'min_term_months' => 1,
            'max_term_months' => 48,
            'interest_rate' => 12.00,
            'interest_type' => 'reducing_balance',
            'charges' => array(
                array('name' => 'Processing Fee', 'type' => 'percentage', 'value' => 0.5, 'basis' => 'loan_amount')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 12,
                'min_deposits' => 1000000,
                'requires_guarantors' => false,
                'premium_member_status' => true
            ),
            'required_documents' => array(
                array('name' => 'Deposit Statement', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true),
                array('name' => 'Investment Plan', 'mandatory' => false)
            ),
            'priority_score_factor' => 95,
            'status' => 'active'
        ),
        'Salary Advance' => array(
            'name' => 'Salary Advance',
            'description' => 'Short-term financial assistance for immediate needs.',
            'min_amount' => 1000.00,
            'max_amount' => 100000.00,
            'min_term_months' => 1,
            'max_term_months' => 3,
            'interest_rate' => 0.00, // Special handling for one-off charges
            'interest_type' => 'one_off_charge',
            'charges' => array(
                array('name' => 'One-off Charge (Members)', 'type' => 'percentage', 'value' => 10.0, 'basis' => 'loan_amount', 'condition' => 'member'),
                array('name' => 'One-off Charge (Non-members)', 'type' => 'percentage', 'value' => 12.5, 'basis' => 'loan_amount', 'condition' => 'non_member'),
                array('name' => 'Compounded Charge', 'type' => 'percentage', 'value' => 5.0, 'basis' => 'outstanding_balance', 'condition' => 'extended_term')
            ),
            'eligibility_rules' => array(
                'min_membership_months' => 3,
                'proof_of_capacity' => true,
                'max_term_months' => 3,
                'quick_processing' => true
            ),
            'required_documents' => array(
                array('name' => 'Proof of Capacity to Repay', 'mandatory' => true),
                array('name' => 'National ID Copy', 'mandatory' => true)
            ),
            'priority_score_factor' => 85,
            'status' => 'active'
        )
    );
}

/**
 * Ensure core loan products exist in database
 */
function daystar_ensure_core_loan_products() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    $core_products = daystar_get_core_loan_products_config();
    $existing_products = $wpdb->get_results("SELECT name FROM $loan_products_table WHERE status = 'active'");
    $existing_names = array_column($existing_products, 'name');
    
    $added_count = 0;
    $updated_count = 0;
    $errors = array();
    
    foreach ($core_products as $name => $config) {
        // Encode JSON fields
        $config['charges'] = json_encode($config['charges']);
        $config['eligibility_rules'] = json_encode($config['eligibility_rules']);
        $config['required_documents'] = json_encode($config['required_documents']);
        $config['created_at'] = current_time('mysql');
        $config['updated_at'] = current_time('mysql');
        
        if (in_array($name, $existing_names)) {
            // Update existing product
            $result = $wpdb->update(
                $loan_products_table,
                $config,
                array('name' => $name),
                null,
                array('%s')
            );
            if ($result !== false) {
                $updated_count++;
            } else {
                $errors[] = "Failed to update $name: " . $wpdb->last_error;
            }
        } else {
            // Insert new product
            $result = $wpdb->insert($loan_products_table, $config);
            if ($result !== false) {
                $added_count++;
            } else {
                $errors[] = "Failed to add $name: " . $wpdb->last_error;
                
                // Try to check if there's an inactive version we can reactivate
                $inactive_product = $wpdb->get_row($wpdb->prepare(
                    "SELECT product_id FROM $loan_products_table WHERE name = %s AND status = 'inactive'",
                    $name
                ));
                
                if ($inactive_product) {
                    // Reactivate and update the inactive product
                    $config['status'] = 'active';
                    $reactivate_result = $wpdb->update(
                        $loan_products_table,
                        $config,
                        array('product_id' => $inactive_product->product_id)
                    );
                    
                    if ($reactivate_result !== false) {
                        $added_count++;
                        // Remove the error since we successfully reactivated
                        array_pop($errors);
                    }
                }
            }
        }
    }
    
    $message = "Core loan products synchronized. Added: $added_count, Updated: $updated_count";
    if (!empty($errors)) {
        $message .= ". Errors: " . implode('; ', $errors);
        return array('success' => false, 'message' => $message);
    }
    
    return array('success' => true, 'message' => $message);
}

/**
 * Reset all loan products to match credit policy
 */
function daystar_reset_all_loan_products() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // First, deactivate all existing products
    $wpdb->update(
        $loan_products_table,
        array('status' => 'inactive', 'updated_at' => current_time('mysql')),
        array('status' => 'active')
    );
    
    // Then add all core products
    $result = daystar_ensure_core_loan_products();
    
    if ($result['success']) {
        $result['message'] = 'All loan products have been reset to match the credit policy standards.';
    }
    
    return $result;
}

/**
 * Get database statistics
 */
function daystar_get_database_stats() {
    global $wpdb;
    
    return array(
        'Active Loan Products' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loan_products WHERE status = 'active'"),
        'Total Loans' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans"),
        'Active Loans' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_loans WHERE status IN ('active', 'approved', 'disbursed')"),
        'Total Members' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->users} u INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id WHERE um.meta_key = 'member_number'"),
        'Total Contributions' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_contributions"),
        'Notifications' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}daystar_notifications")
    );
}

/**
 * AJAX handler for cleanup functions
 */
function daystar_ajax_cleanup_refinance() {
    $result = daystar_remove_refinance_loan();
    
    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        wp_send_json_error($result['message']);
    }
}
add_action('wp_ajax_cleanup_refinance', 'daystar_ajax_cleanup_refinance');

/**
 * Add Special Loan specifically
 */
function daystar_add_special_loan_specifically() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // Get Special Loan configuration
    $core_products = daystar_get_core_loan_products_config();
    $special_loan_config = $core_products['Special Loan'];
    
    // Check if Special Loan already exists (active or inactive)
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT product_id, status FROM $loan_products_table WHERE name = %s",
        'Special Loan'
    ));
    
    // Encode JSON fields
    $special_loan_config['charges'] = json_encode($special_loan_config['charges']);
    $special_loan_config['eligibility_rules'] = json_encode($special_loan_config['eligibility_rules']);
    $special_loan_config['required_documents'] = json_encode($special_loan_config['required_documents']);
    $special_loan_config['created_at'] = current_time('mysql');
    $special_loan_config['updated_at'] = current_time('mysql');
    
    if ($existing) {
        // Update existing product and ensure it's active
        $special_loan_config['status'] = 'active';
        $result = $wpdb->update(
            $loan_products_table,
            $special_loan_config,
            array('product_id' => $existing->product_id)
        );
        
        if ($result !== false) {
            return array('success' => true, 'message' => 'Special Loan updated and activated successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to update Special Loan: ' . $wpdb->last_error);
        }
    } else {
        // Insert new Special Loan
        $result = $wpdb->insert($loan_products_table, $special_loan_config);
        
        if ($result !== false) {
            return array('success' => true, 'message' => 'Special Loan added successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to add Special Loan: ' . $wpdb->last_error);
        }
    }
}

/**
 * Debug database state
 */
function daystar_debug_database_state() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // Get all products (active and inactive)
    $all_products = $wpdb->get_results("SELECT name, status, created_at, updated_at FROM $loan_products_table ORDER BY name");
    
    // Check table structure
    $table_structure = $wpdb->get_results("DESCRIBE $loan_products_table");
    
    // Check for Special Loan specifically
    $special_loan_check = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $loan_products_table WHERE name = %s",
        'Special Loan'
    ));
    
    $debug_info = "=== DATABASE DEBUG INFO ===\n\n";
    $debug_info .= "Table: $loan_products_table\n";
    $debug_info .= "Total products in database: " . count($all_products) . "\n\n";
    
    $debug_info .= "All products:\n";
    foreach ($all_products as $product) {
        $debug_info .= "- {$product->name} (Status: {$product->status})\n";
    }
    
    $debug_info .= "\nSpecial Loan check:\n";
    if ($special_loan_check) {
        $debug_info .= "- Found Special Loan with ID: {$special_loan_check->product_id}\n";
        $debug_info .= "- Status: {$special_loan_check->status}\n";
        $debug_info .= "- Created: {$special_loan_check->created_at}\n";
        $debug_info .= "- Updated: {$special_loan_check->updated_at}\n";
    } else {
        $debug_info .= "- Special Loan NOT found in database\n";
    }
    
    $debug_info .= "\nLast database error: " . ($wpdb->last_error ?: 'None') . "\n";
    
    return array('success' => true, 'message' => nl2br($debug_info));
}

/**
 * Fix database schema issues
 */
function daystar_fix_database_schema() {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'Insufficient permissions.');
    }
    
    global $wpdb;
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // Fix the interest_type field length
    $result = $wpdb->query("ALTER TABLE $loan_products_table MODIFY COLUMN interest_type varchar(30) NOT NULL DEFAULT 'reducing_balance'");
    
    if ($result !== false) {
        return array('success' => true, 'message' => 'Database schema updated successfully. The interest_type field can now handle longer values.');
    } else {
        return array('success' => false, 'message' => 'Failed to update database schema: ' . $wpdb->last_error);
    }
}

/**
 * AJAX handler for ensuring core products
 */
function daystar_ajax_ensure_core_products() {
    $result = daystar_ensure_core_loan_products();
    
    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        wp_send_json_error($result['message']);
    }
}
add_action('wp_ajax_ensure_core_products', 'daystar_ajax_ensure_core_products');
?>