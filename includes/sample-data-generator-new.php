<?php
/**
 * Sample Data Generator for SACCO System (FIXED VERSION)
 * Creates comprehensive sample data for demonstration purposes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate comprehensive sample data for the SACCO system
 */
function daystar_generate_sample_data($clear_existing = false) {
    global $wpdb;
    
    // Clear existing data if requested
    if ($clear_existing) {
        daystar_clear_sample_data();
    }
    
    // Generate sample members with different roles
    $members = daystar_create_sample_members();
    
    // Generate sample contributions for all members
    daystar_create_sample_contributions($members);
    
    // Generate sample loans with different statuses
    daystar_create_sample_loans($members);
    
    // Generate sample loan payments
    daystar_create_sample_loan_payments();
    
    // Generate sample guarantor relationships
    daystar_create_sample_guarantors($members);
    
    // Generate sample payslip data
    daystar_create_sample_payslip_data($members);
    
    // Generate sample notifications
    daystar_create_sample_notifications($members);
    
    // Generate sample credit history
    daystar_create_sample_credit_history($members);
    
    // Generate sample collateral records
    daystar_create_sample_collateral();
    
    // Generate sample loan appeals
    daystar_create_sample_loan_appeals();
    
    // Generate sample blacklist entries
    daystar_create_sample_blacklist($members);
    
    // Generate sample share transfers
    daystar_create_sample_share_transfers($members);
    
    return array(
        'success' => true,
        'message' => 'Sample data generated successfully',
        'members_created' => count($members),
        'timestamp' => current_time('mysql')
    );
}

/**
 * Create sample loans with different statuses (FIXED VERSION)
 */
function daystar_create_sample_loans($members) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan_products_table = $wpdb->prefix . 'daystar_loan_products';
    
    // Get available loan products
    $loan_products = $wpdb->get_results("SELECT * FROM $loan_products_table WHERE status = 'active'");
    
    // Check if loan products exist
    if (empty($loan_products)) {
        return; // No loan products available, skip loan creation
    }
    
    $loan_statuses = array('pending', 'approved', 'active', 'completed', 'rejected', 'defaulted');
    $loan_purposes = array(
        'Business expansion',
        'Home improvement',
        'Education fees',
        'Medical expenses',
        'Emergency needs',
        'Investment',
        'Debt consolidation',
        'Equipment purchase'
    );
    
    foreach ($members as $user_id) {
        $member_status = get_user_meta($user_id, 'member_status', true);
        $registration_date = get_user_meta($user_id, 'registration_date', true);
        
        if ($member_status === 'pending') {
            continue; // Skip pending members
        }
        
        // Create 1-3 loans per member
        $num_loans = rand(1, 3);
        
        for ($i = 0; $i < $num_loans; $i++) {
            $product = $loan_products[array_rand($loan_products)];
            $amount = rand($product->min_amount, min($product->max_amount, 500000));
            $term_months = rand($product->min_term_months, $product->max_term_months);
            $status = $loan_statuses[array_rand($loan_statuses)];
            
            // Adjust status based on member status
            if ($member_status === 'suspended' && rand(1, 2) == 1) {
                $status = 'defaulted';
            }
            
            $loan_date = date('Y-m-d H:i:s', strtotime($registration_date . ' +' . rand(1, 18) . ' months'));
            $due_date = date('Y-m-d', strtotime($loan_date . " +{$term_months} months"));
            
            // Calculate monthly payment with division by zero protection
            $monthly_interest_rate = $product->interest_rate / 100 / 12;
            
            // Prevent division by zero
            if ($monthly_interest_rate == 0 || $term_months == 0) {
                $monthly_payment = $amount / max(1, $term_months); // Simple division if no interest
            } else {
                $denominator = pow(1 + $monthly_interest_rate, $term_months) - 1;
                if ($denominator == 0) {
                    $monthly_payment = $amount / $term_months; // Fallback to simple division
                } else {
                    $monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / $denominator;
                }
            }
            
            // Calculate current balance based on status and time
            $balance = $amount;
            if (in_array($status, ['active', 'completed', 'defaulted'])) {
                $months_elapsed = min($term_months, floor((time() - strtotime($loan_date)) / (30 * 24 * 60 * 60)));
                $balance = max(0, $amount - ($monthly_payment * $months_elapsed * 0.8)); // 80% payment rate
                
                if ($status === 'completed') {
                    $balance = 0;
                }
            }
            
            $loan_data = array(
                'user_id' => $user_id,
                'loan_type' => $product->name,
                'amount' => $amount,
                'balance' => $balance,
                'interest_rate' => $product->interest_rate,
                'term_months' => $term_months,
                'monthly_payment' => $monthly_payment,
                'loan_date' => $loan_date,
                'due_date' => $due_date,
                'status' => $status,
                'purpose' => $loan_purposes[array_rand($loan_purposes)],
                'payslip_verified' => in_array($status, ['approved', 'active', 'completed']) ? 1 : 0,
                'eligibility_score' => rand(60, 95),
                'risk_assessment' => rand(1, 3) == 1 ? 'low' : (rand(1, 2) == 1 ? 'medium' : 'high'),
                'priority_score' => rand(50, 100),
                'application_waiting_number' => 'AWN' . $user_id . $i . date('Y'),
                'is_staff_loan' => get_user_meta($user_id, 'is_staff', true) ? 1 : 0,
                'staff_type' => get_user_meta($user_id, 'staff_type', true),
                'delinquency_status' => $status === 'defaulted' ? 'default' : 'current',
                'days_overdue' => $status === 'defaulted' ? rand(30, 180) : 0
            );
            
            // Add approval/rejection details
            if (in_array($status, ['approved', 'active', 'completed'])) {
                $loan_data['approved_by'] = $members[0]; // First member as approver
                $loan_data['approved_date'] = date('Y-m-d H:i:s', strtotime($loan_date . ' +3 days'));
                $loan_data['disbursed_date'] = date('Y-m-d H:i:s', strtotime($loan_date . ' +5 days'));
            } elseif ($status === 'rejected') {
                $loan_data['rejection_reason'] = 'Insufficient guarantors';
            }
            
            $wpdb->insert($loans_table, $loan_data);
        }
    }
}

// Note: This file only contains the fixed function. 
// You need to copy this function back to the original sample-data-generator.php file
// or rename this file to replace the original one.
?>