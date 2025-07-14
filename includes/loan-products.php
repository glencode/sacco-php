<?php
/**
 * Loan Products Management Functions
 * Handles CRUD operations and business logic for loan products
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all active loan products
 */
function daystar_get_loan_products($status = 'active') {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loan_products';
    
    $sql = "SELECT * FROM $table_name WHERE status = %s ORDER BY priority_score_factor DESC, name ASC";
    $results = $wpdb->get_results($wpdb->prepare($sql, $status));
    
    // Decode JSON fields
    foreach ($results as $product) {
        $product->charges = json_decode($product->charges, true);
        $product->eligibility_rules = json_decode($product->eligibility_rules, true);
        $product->required_documents = json_decode($product->required_documents, true);
    }
    
    return $results;
}

/**
 * Get a specific loan product by ID or name
 */
function daystar_get_loan_product($identifier, $by = 'product_id') {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loan_products';
    
    if ($by === 'product_id') {
        $sql = "SELECT * FROM $table_name WHERE product_id = %d";
        $result = $wpdb->get_row($wpdb->prepare($sql, $identifier));
    } else {
        $sql = "SELECT * FROM $table_name WHERE name = %s";
        $result = $wpdb->get_row($wpdb->prepare($sql, $identifier));
    }
    
    if ($result) {
        // Decode JSON fields
        $result->charges = json_decode($result->charges, true);
        $result->eligibility_rules = json_decode($result->eligibility_rules, true);
        $result->required_documents = json_decode($result->required_documents, true);
    }
    
    return $result;
}

/**
 * Create a new loan product
 */
function daystar_create_loan_product($data) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loan_products';
    
    // Encode JSON fields
    if (isset($data['charges']) && is_array($data['charges'])) {
        $data['charges'] = json_encode($data['charges']);
    }
    if (isset($data['eligibility_rules']) && is_array($data['eligibility_rules'])) {
        $data['eligibility_rules'] = json_encode($data['eligibility_rules']);
    }
    if (isset($data['required_documents']) && is_array($data['required_documents'])) {
        $data['required_documents'] = json_encode($data['required_documents']);
    }
    
    $result = $wpdb->insert($table_name, $data);
    
    if ($result === false) {
        return false;
    }
    
    return $wpdb->insert_id;
}

/**
 * Update an existing loan product
 */
function daystar_update_loan_product($product_id, $data) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loan_products';
    
    // Encode JSON fields
    if (isset($data['charges']) && is_array($data['charges'])) {
        $data['charges'] = json_encode($data['charges']);
    }
    if (isset($data['eligibility_rules']) && is_array($data['eligibility_rules'])) {
        $data['eligibility_rules'] = json_encode($data['eligibility_rules']);
    }
    if (isset($data['required_documents']) && is_array($data['required_documents'])) {
        $data['required_documents'] = json_encode($data['required_documents']);
    }
    
    $data['updated_at'] = current_time('mysql');
    
    $result = $wpdb->update(
        $table_name,
        $data,
        array('product_id' => $product_id)
    );
    
    return $result !== false;
}

/**
 * Delete a loan product (soft delete by setting status to inactive)
 */
function daystar_delete_loan_product($product_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_loan_products';
    
    $result = $wpdb->update(
        $table_name,
        array(
            'status' => 'inactive',
            'updated_at' => current_time('mysql')
        ),
        array('product_id' => $product_id)
    );
    
    return $result !== false;
}

/**
 * Check if a member is eligible for a specific loan product
 */
function daystar_check_loan_eligibility($user_id, $product_id, $loan_amount = 0) {
    $product = daystar_get_loan_product($product_id);
    if (!$product) {
        return array('eligible' => false, 'errors' => array('Product not found'));
    }
    
    $eligibility_rules = $product->eligibility_rules;
    $errors = array();
    
    // Check if member is blacklisted first
    if (function_exists('daystar_is_member_blacklisted') && daystar_is_member_blacklisted($user_id)) {
        return array('eligible' => false, 'errors' => array('Member is blacklisted and cannot apply for loans'));
    }
    
    // Get member data
    $member_data = daystar_get_member_data($user_id);
    if (!$member_data) {
        return array('eligible' => false, 'errors' => array('Member data not found'));
    }
    
    // Check minimum membership months
    if (isset($eligibility_rules['min_membership_months'])) {
        $membership_months = daystar_get_membership_months($user_id);
        if ($membership_months < $eligibility_rules['min_membership_months']) {
            $errors[] = "Minimum membership period of {$eligibility_rules['min_membership_months']} months required";
        }
    }
    
    // Check minimum share capital
    if (isset($eligibility_rules['min_share_capital'])) {
        $share_capital = daystar_get_member_share_capital($user_id);
        if ($share_capital < $eligibility_rules['min_share_capital']) {
            $errors[] = "Minimum share capital of KSh " . number_format($eligibility_rules['min_share_capital']) . " required";
        }
    }
    
    // Check minimum contributions
    if (isset($eligibility_rules['min_contributions'])) {
        $total_contributions = daystar_get_member_total_contributions($user_id);
        if ($total_contributions < $eligibility_rules['min_contributions']) {
            $errors[] = "Minimum contributions of KSh " . number_format($eligibility_rules['min_contributions']) . " required";
        }
    }
    
    // Check for outstanding loans of the same type
    $outstanding_check_fields = array(
        'no_outstanding_development_loan',
        'no_outstanding_school_fees_loan',
        'no_outstanding_emergency_loan'
    );
    
    foreach ($outstanding_check_fields as $field) {
        if (isset($eligibility_rules[$field]) && $eligibility_rules[$field]) {
            $loan_type = str_replace(array('no_outstanding_', '_loan'), array('', ''), $field);
            $loan_type = str_replace('_', ' ', $loan_type);
            $loan_type = ucwords($loan_type) . ' Loan';
            
            if (daystar_has_outstanding_loan($user_id, $loan_type)) {
                $errors[] = "No outstanding {$loan_type} allowed";
            }
        }
    }
    
    // Check loan amount limits
    if ($loan_amount > 0) {
        if ($loan_amount < $product->min_amount) {
            $errors[] = "Minimum loan amount is KSh " . number_format($product->min_amount);
        }
        if ($loan_amount > $product->max_amount) {
            $errors[] = "Maximum loan amount is KSh " . number_format($product->max_amount);
        }
    }
    
    // Check for minimum deposits (Super Saver Loan)
    if (isset($eligibility_rules['min_deposits'])) {
        $total_deposits = daystar_get_member_total_deposits($user_id);
        if ($total_deposits < $eligibility_rules['min_deposits']) {
            $errors[] = "Minimum deposits of KSh " . number_format($eligibility_rules['min_deposits']) . " required";
        }
    }
    
    // Check credit history for Special Loans
    if (isset($eligibility_rules['good_credit_history']) && $eligibility_rules['good_credit_history']) {
        if (!daystar_has_good_credit_history($user_id)) {
            $errors[] = "Good credit history required";
        }
    }
    
    return array(
        'eligible' => empty($errors),
        'errors' => $errors,
        'product' => $product
    );
}

/**
 * Calculate loan payment details based on product rules
 */
function daystar_calculate_loan_payment($product_id, $loan_amount, $term_months) {
    $product = daystar_get_loan_product($product_id);
    if (!$product) {
        return false;
    }
    
    $calculation = array(
        'principal' => $loan_amount,
        'term_months' => $term_months,
        'interest_rate' => $product->interest_rate,
        'interest_type' => $product->interest_type,
        'charges' => array(),
        'total_charges' => 0,
        'monthly_payment' => 0,
        'total_interest' => 0,
        'total_payment' => 0
    );
    
    // Calculate charges
    if ($product->charges) {
        foreach ($product->charges as $charge) {
            $charge_amount = 0;
            
            switch ($charge['type']) {
                case 'percentage':
                    if ($charge['basis'] === 'loan_amount') {
                        $charge_amount = $loan_amount * ($charge['value'] / 100);
                    }
                    break;
                case 'flat':
                    $charge_amount = $charge['value'];
                    break;
            }
            
            $calculation['charges'][] = array(
                'name' => $charge['name'],
                'amount' => $charge_amount
            );
            $calculation['total_charges'] += $charge_amount;
        }
    }
    
    // Calculate interest and payments based on interest type
    switch ($product->interest_type) {
        case 'reducing_balance':
            $monthly_rate = ($product->interest_rate / 100) / 12;
            if ($monthly_rate > 0) {
                $calculation['monthly_payment'] = $loan_amount * $monthly_rate * pow(1 + $monthly_rate, $term_months) / (pow(1 + $monthly_rate, $term_months) - 1);
                $calculation['total_payment'] = $calculation['monthly_payment'] * $term_months;
                $calculation['total_interest'] = $calculation['total_payment'] - $loan_amount;
            } else {
                $calculation['monthly_payment'] = $loan_amount / $term_months;
                $calculation['total_payment'] = $loan_amount;
                $calculation['total_interest'] = 0;
            }
            break;
            
        case 'monthly_reducing_balance':
        case 'monthly_reducing':
            // For Special Loans - 5% per month
            $monthly_rate = $product->interest_rate / 100;
            $balance = $loan_amount;
            $total_interest = 0;
            
            for ($i = 1; $i <= $term_months; $i++) {
                $interest_payment = $balance * $monthly_rate;
                $principal_payment = $loan_amount / $term_months;
                $balance -= $principal_payment;
                $total_interest += $interest_payment;
            }
            
            $calculation['monthly_payment'] = ($loan_amount / $term_months) + ($total_interest / $term_months);
            $calculation['total_interest'] = $total_interest;
            $calculation['total_payment'] = $loan_amount + $total_interest;
            break;
            
        case 'one_off_charge':
            // For Salary Advance - one-off percentage charge
            $charge_rate = 10; // Default for members
            foreach ($product->charges as $charge) {
                if ($charge['condition'] === 'member') {
                    $charge_rate = $charge['value'];
                    break;
                }
            }
            
            $one_off_charge = $loan_amount * ($charge_rate / 100);
            $calculation['monthly_payment'] = ($loan_amount + $one_off_charge) / $term_months;
            $calculation['total_interest'] = $one_off_charge;
            $calculation['total_payment'] = $loan_amount + $one_off_charge;
            break;
            
        case 'flat':
            $total_interest = $loan_amount * ($product->interest_rate / 100) * ($term_months / 12);
            $calculation['monthly_payment'] = ($loan_amount + $total_interest) / $term_months;
            $calculation['total_interest'] = $total_interest;
            $calculation['total_payment'] = $loan_amount + $total_interest;
            break;
    }
    
    return $calculation;
}

/**
 * Generate amortization schedule for a loan
 */
function daystar_generate_amortization_schedule($product_id, $loan_amount, $term_months) {
    $product = daystar_get_loan_product($product_id);
    if (!$product) {
        return false;
    }
    
    $schedule = array();
    $balance = $loan_amount;
    
    switch ($product->interest_type) {
        case 'reducing_balance':
            $monthly_rate = ($product->interest_rate / 100) / 12;
            $monthly_payment = $loan_amount * $monthly_rate * pow(1 + $monthly_rate, $term_months) / (pow(1 + $monthly_rate, $term_months) - 1);
            
            for ($i = 1; $i <= $term_months; $i++) {
                $interest_payment = $balance * $monthly_rate;
                $principal_payment = $monthly_payment - $interest_payment;
                $balance -= $principal_payment;
                
                $schedule[] = array(
                    'month' => $i,
                    'payment' => $monthly_payment,
                    'principal' => $principal_payment,
                    'interest' => $interest_payment,
                    'balance' => max(0, $balance)
                );
            }
            break;
            
        case 'monthly_reducing_balance':
        case 'monthly_reducing':
            $monthly_rate = $product->interest_rate / 100;
            $principal_payment = $loan_amount / $term_months;
            
            for ($i = 1; $i <= $term_months; $i++) {
                $interest_payment = $balance * $monthly_rate;
                $total_payment = $principal_payment + $interest_payment;
                $balance -= $principal_payment;
                
                $schedule[] = array(
                    'month' => $i,
                    'payment' => $total_payment,
                    'principal' => $principal_payment,
                    'interest' => $interest_payment,
                    'balance' => max(0, $balance)
                );
            }
            break;
            
        case 'one_off_charge':
            $charge_rate = 10; // Default for members
            foreach ($product->charges as $charge) {
                if ($charge['condition'] === 'member') {
                    $charge_rate = $charge['value'];
                    break;
                }
            }
            
            $one_off_charge = $loan_amount * ($charge_rate / 100);
            $monthly_payment = ($loan_amount + $one_off_charge) / $term_months;
            
            for ($i = 1; $i <= $term_months; $i++) {
                $principal_payment = $loan_amount / $term_months;
                $interest_payment = ($i === 1) ? $one_off_charge : 0;
                $balance -= $principal_payment;
                
                $schedule[] = array(
                    'month' => $i,
                    'payment' => $monthly_payment,
                    'principal' => $principal_payment,
                    'interest' => $interest_payment,
                    'balance' => max(0, $balance)
                );
            }
            break;
    }
    
    return $schedule;
}

/**
 * Get loan products formatted for frontend consumption
 */
function daystar_get_loan_products_for_frontend() {
    $products = daystar_get_loan_products();
    $formatted_products = array();
    
    foreach ($products as $product) {
        $formatted_products[] = array(
            'id' => $product->product_id,
            'name' => $product->name,
            'description' => $product->description,
            'min_amount' => $product->min_amount,
            'max_amount' => $product->max_amount,
            'min_term' => $product->min_term_months,
            'max_term' => $product->max_term_months,
            'interest_rate' => $product->interest_rate,
            'interest_type' => $product->interest_type,
            'charges' => $product->charges,
            'eligibility_rules' => $product->eligibility_rules,
            'required_documents' => $product->required_documents,
            'priority_score' => $product->priority_score_factor
        );
    }
    
    return $formatted_products;
}

/**
 * Get general loan eligibility for dashboard display
 */
function daystar_get_general_loan_eligibility($user_id) {
    // Get member data
    $share_capital = daystar_get_member_share_capital($user_id);
    $total_contributions = daystar_get_member_total_contributions($user_id);
    $membership_months = daystar_get_membership_months($user_id);
    
    // Basic eligibility criteria
    $min_share_capital = 5000;
    $min_membership_months = 6;
    $min_contributions = 10000;
    
    // Check each criterion
    $share_capital_met = $share_capital >= $min_share_capital;
    $membership_met = $membership_months >= $min_membership_months;
    $contributions_met = $total_contributions >= $min_contributions;
    
    // Calculate maximum loan amount (typically 3x share capital or contributions)
    $max_loan_amount = max($share_capital * 3, $total_contributions * 2);
    $max_loan_amount = min($max_loan_amount, 500000); // Cap at 500k
    
    // Overall eligibility
    $is_eligible = $share_capital_met && $membership_met && $contributions_met;
    
    return array(
        'is_eligible' => $is_eligible,
        'max_loan_amount' => $max_loan_amount,
        'share_capital' => array(
            'amount' => $share_capital,
            'required' => $min_share_capital,
            'met' => $share_capital_met
        ),
        'membership_months' => array(
            'months' => $membership_months,
            'required' => $min_membership_months,
            'met' => $membership_met
        ),
        'contributions' => array(
            'amount' => $total_contributions,
            'required' => $min_contributions,
            'met' => $contributions_met
        )
    );
}


/**
 * Helper function to get member data
 */
function daystar_get_member_data($user_id) {
    $user = get_user_by('ID', $user_id);
    if (!$user) {
        return false;
    }
    
    return array(
        'user_id' => $user_id,
        'member_number' => get_user_meta($user_id, 'member_number', true),
        'member_status' => get_user_meta($user_id, 'member_status', true),
        'registration_date' => get_user_meta($user_id, 'registration_date', true)
    );
}

/**
 * Helper function to get membership months
 */
function daystar_get_membership_months($user_id) {
    $registration_date = get_user_meta($user_id, 'registration_date', true);
    if (!$registration_date) {
        return 0;
    }
    
    $registration_timestamp = strtotime($registration_date);
    $current_timestamp = time();
    $months = floor(($current_timestamp - $registration_timestamp) / (30 * 24 * 60 * 60));
    
    return max(0, $months);
}


/**
 * Helper function to get member total deposits (for Super Saver eligibility)
 */
function daystar_get_member_total_deposits($user_id) {
    // This would typically include savings accounts, fixed deposits, etc.
    // For now, we'll use total contributions as a proxy
    return daystar_get_member_total_contributions($user_id);
}

/**
 * Helper function to check if member has outstanding loan of specific type
 */
function daystar_has_outstanding_loan($user_id, $loan_type) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $sql = "SELECT COUNT(*) FROM $loans_table WHERE user_id = %d AND loan_type = %s AND status IN ('active', 'approved', 'disbursed')";
    $count = $wpdb->get_var($wpdb->prepare($sql, $user_id, $loan_type));
    
    return intval($count) > 0;
}

/**
 * Helper function to check credit history
 */
function daystar_has_good_credit_history($user_id) {
    global $wpdb;
    
    // Check for any defaulted loans or negative credit events
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    $sql = "SELECT COUNT(*) FROM $credit_history_table WHERE user_id = %d AND event_type IN ('default', 'late_payment', 'bounced_cheque') AND event_date > DATE_SUB(NOW(), INTERVAL 12 MONTH)";
    $negative_events = $wpdb->get_var($wpdb->prepare($sql, $user_id));
    
    return intval($negative_events) === 0;
}

/**
 * Apply for a loan using product-based system
 */
function daystar_apply_for_loan($user_id, $product_id, $loan_amount, $term_months, $additional_data = array()) {
    // Check eligibility
    $eligibility = daystar_check_loan_eligibility($user_id, $product_id, $loan_amount);
    if (!$eligibility['eligible']) {
        return array(
            'success' => false,
            'errors' => $eligibility['errors']
        );
    }
    
    $product = $eligibility['product'];
    
    // Calculate loan details
    $calculation = daystar_calculate_loan_payment($product_id, $loan_amount, $term_months);
    if (!$calculation) {
        return array(
            'success' => false,
            'errors' => array('Unable to calculate loan payment')
        );
    }
    
    // Create loan application
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $loan_data = array(
        'user_id' => $user_id,
        'loan_type' => $product->name,
        'amount' => $loan_amount,
        'balance' => $loan_amount,
        'interest_rate' => $product->interest_rate,
        'term_months' => $term_months,
        'monthly_payment' => $calculation['monthly_payment'],
        'loan_date' => current_time('mysql'),
        'due_date' => date('Y-m-d', strtotime("+{$term_months} months")),
        'status' => 'pending',
        'purpose' => isset($additional_data['purpose']) ? $additional_data['purpose'] : '',
        'priority_score' => $product->priority_score_factor,
        'application_waiting_number' => daystar_generate_waiting_number()
    );
    
    // Add any additional data
    $loan_data = array_merge($loan_data, $additional_data);
    
    $result = $wpdb->insert($loans_table, $loan_data);
    
    if ($result === false) {
        return array(
            'success' => false,
            'errors' => array('Failed to submit loan application')
        );
    }
    
    $loan_id = $wpdb->insert_id;
    
    // Generate loan schedule
    $schedule = daystar_generate_amortization_schedule($product_id, $loan_amount, $term_months);
    if ($schedule) {
        daystar_save_loan_schedule($loan_id, $schedule);
    }
    
    return array(
        'success' => true,
        'loan_id' => $loan_id,
        'waiting_number' => $loan_data['application_waiting_number'],
        'calculation' => $calculation
    );
}

/**
 * Save loan schedule to database
 */
function daystar_save_loan_schedule($loan_id, $schedule) {
    global $wpdb;
    
    $schedules_table = $wpdb->prefix . 'daystar_loan_schedules';
    
    foreach ($schedule as $installment) {
        $wpdb->insert($schedules_table, array(
            'loan_id' => $loan_id,
            'installment_number' => $installment['month'],
            'due_date' => date('Y-m-d', strtotime("+{$installment['month']} months")),
            'expected_principal' => $installment['principal'],
            'expected_interest' => $installment['interest'],
            'expected_total' => $installment['payment']
        ));
    }
}