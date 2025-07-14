<?php
/**
 * Comprehensive Loan Eligibility System
 * Implements PRD Section 2.2 & 2.3 requirements
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Comprehensive loan eligibility calculation
 * Implements all PRD Section 2.2 criteria
 * 
 * @param int $user_id User ID
 * @param string $loan_type Type of loan being applied for
 * @param float $requested_amount Requested loan amount
 * @return array Detailed eligibility assessment
 */
function daystar_comprehensive_loan_eligibility($user_id, $loan_type = '', $requested_amount = 0) {
    $eligibility = array(
        'is_eligible' => false,
        'eligibility_score' => 0,
        'max_loan_amount' => 0,
        'risk_assessment' => 'high',
        'criteria_results' => array(),
        'recommendations' => array(),
        'warnings' => array()
    );
    
    // 1. Check minimum share capital requirement
    $share_capital_check = daystar_check_share_capital_requirement($user_id);
    $eligibility['criteria_results']['share_capital'] = $share_capital_check;
    
    // 2. Check consistent contributions
    $contribution_check = daystar_check_consistent_contributions_requirement($user_id);
    $eligibility['criteria_results']['consistent_contributions'] = $contribution_check;
    
    // 3. Check membership duration
    $membership_check = daystar_check_membership_duration($user_id);
    $eligibility['criteria_results']['membership_duration'] = $membership_check;
    
    // 4. Check productive activity/economic income
    $income_check = daystar_check_economic_income($user_id);
    $eligibility['criteria_results']['economic_income'] = $income_check;
    
    // 5. Check credit history
    $credit_history_check = daystar_check_credit_history($user_id);
    $eligibility['criteria_results']['credit_history'] = $credit_history_check;
    
    // 6. Check aggregate loan limits
    $aggregate_limit_check = daystar_check_aggregate_loan_limits($user_id, $loan_type, $requested_amount);
    $eligibility['criteria_results']['aggregate_limits'] = $aggregate_limit_check;
    
    // 7. Check staff loan factor (if applicable)
    $staff_factor_check = daystar_check_staff_loan_factor($user_id);
    $eligibility['criteria_results']['staff_factor'] = $staff_factor_check;
    
    // 8. Check guarantor requirements
    $guarantor_check = daystar_check_guarantor_requirements($user_id, $requested_amount);
    $eligibility['criteria_results']['guarantors'] = $guarantor_check;
    
    // 9. Check collateral requirements
    $collateral_check = daystar_check_collateral_requirements($user_id, $loan_type, $requested_amount);
    $eligibility['criteria_results']['collateral'] = $collateral_check;
    
    // Calculate overall eligibility score
    $eligibility['eligibility_score'] = daystar_calculate_eligibility_score($eligibility['criteria_results']);
    
    // Determine risk assessment
    $eligibility['risk_assessment'] = daystar_assess_loan_risk($eligibility['criteria_results'], $eligibility['eligibility_score']);
    
    // Calculate maximum loan amount
    $eligibility['max_loan_amount'] = daystar_calculate_maximum_loan_amount($user_id, $eligibility['criteria_results']);
    
    // Determine overall eligibility
    $eligibility['is_eligible'] = daystar_determine_overall_eligibility($eligibility['criteria_results'], $eligibility['eligibility_score']);
    
    // Generate recommendations and warnings
    $eligibility['recommendations'] = daystar_generate_eligibility_recommendations($eligibility['criteria_results']);
    $eligibility['warnings'] = daystar_generate_eligibility_warnings($eligibility['criteria_results']);
    
    return $eligibility;
}

/**
 * Check minimum share capital requirement (KSh 5,000 or 250 shares)
 */
function daystar_check_share_capital_requirement($user_id) {
    $share_capital = daystar_get_member_share_capital($user_id);
    $min_required = 5000; // KSh 5,000
    
    return array(
        'met' => $share_capital >= $min_required,
        'current_amount' => $share_capital,
        'required_amount' => $min_required,
        'score' => $share_capital >= $min_required ? 20 : 0,
        'description' => 'Minimum share capital of KSh 5,000 required'
    );
}

/**
 * Check consistent contributions requirement (KSh 12,000 over 6 months)
 */
function daystar_check_consistent_contributions_requirement($user_id) {
    $contribution_check = daystar_verify_consistent_contributions($user_id, 6, 2000);
    
    return array(
        'met' => $contribution_check['is_consistent'],
        'months_compliant' => $contribution_check['months_met'],
        'total_contributed' => $contribution_check['total_contributed'],
        'required_total' => $contribution_check['total_required'],
        'compliance_percentage' => $contribution_check['compliance_percentage'],
        'score' => $contribution_check['is_consistent'] ? 25 : ($contribution_check['compliance_percentage'] / 100 * 25),
        'description' => 'Consistent contributions of KSh 12,000 over 6 months required'
    );
}

/**
 * Check membership duration requirement (6 months minimum)
 */
function daystar_check_membership_duration($user_id) {
    $registration_date = get_user_meta($user_id, 'registration_date', true);
    $months_as_member = 0;
    $met = false;
    
    if ($registration_date) {
        $reg_timestamp = strtotime($registration_date);
        $months_as_member = floor((time() - $reg_timestamp) / (30 * 24 * 60 * 60));
        $met = $months_as_member >= 6;
    }
    
    return array(
        'met' => $met,
        'months_as_member' => $months_as_member,
        'required_months' => 6,
        'score' => $met ? 15 : 0,
        'description' => 'Minimum 6 months membership required'
    );
}

/**
 * Check productive activity/economic income
 */
function daystar_check_economic_income($user_id) {
    // Check if member has verified payslip data
    $payslip_data = daystar_get_latest_verified_payslip($user_id);
    $employment_status = get_user_meta($user_id, 'employment_status', true);
    $business_income = get_user_meta($user_id, 'business_income', true);
    
    $has_income = false;
    $income_amount = 0;
    $income_source = '';
    
    if ($payslip_data) {
        $has_income = true;
        $income_amount = $payslip_data->net_salary;
        $income_source = 'Employment';
    } elseif ($business_income && $business_income > 0) {
        $has_income = true;
        $income_amount = $business_income;
        $income_source = 'Business';
    }
    
    return array(
        'met' => $has_income,
        'income_amount' => $income_amount,
        'income_source' => $income_source,
        'score' => $has_income ? 15 : 0,
        'description' => 'Verifiable source of income required'
    );
}

/**
 * Check comprehensive credit history
 */
function daystar_check_credit_history($user_id) {
    global $wpdb;
    
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan_payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    // Get loan history
    $loan_history = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE user_id = %d ORDER BY loan_date DESC",
        $user_id
    ));
    
    // Calculate credit score based on history
    $credit_score = 100; // Start with perfect score
    $total_loans = count($loan_history);
    $defaulted_loans = 0;
    $late_payments = 0;
    
    foreach ($loan_history as $loan) {
        // Check for defaults
        if ($loan->status === 'defaulted') {
            $defaulted_loans++;
            $credit_score -= 30;
        }
        
        // Check payment history
        $payment_history = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$loan_payments_table} WHERE loan_id = %d ORDER BY payment_date ASC",
            $loan->id
        ));
        
        // Count late payments (simplified logic)
        foreach ($payment_history as $payment) {
            $expected_date = date('Y-m-d', strtotime($loan->loan_date . ' +1 month'));
            if ($payment->payment_date > $expected_date) {
                $late_payments++;
                $credit_score -= 5;
            }
        }
    }
    
    $credit_score = max(0, min(100, $credit_score)); // Keep between 0-100
    
    return array(
        'met' => $credit_score >= 60, // Minimum acceptable score
        'credit_score' => $credit_score,
        'total_loans' => $total_loans,
        'defaulted_loans' => $defaulted_loans,
        'late_payments' => $late_payments,
        'score' => ($credit_score / 100) * 10, // Max 10 points
        'description' => 'Good credit history required (minimum score: 60)'
    );
}

/**
 * Check aggregate loan limits
 */
function daystar_check_aggregate_loan_limits($user_id, $loan_type, $requested_amount) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Get current outstanding loans
    $outstanding_loans = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(balance) FROM {$loans_table} WHERE user_id = %d AND status IN ('active', 'approved')",
        $user_id
    ));
    
    $outstanding_loans = (float)($outstanding_loans ?: 0);
    
    // Set limits based on loan type
    $limits = array(
        'development' => 2000000, // KSh 2,000,000
        'super_saver' => 3000000, // KSh 3,000,000
        'emergency' => 500000,    // KSh 500,000
        'school_fees' => 1000000, // KSh 1,000,000
        'business' => 2500000     // KSh 2,500,000
    );
    
    $applicable_limit = isset($limits[$loan_type]) ? $limits[$loan_type] : 1000000;
    $total_after_new_loan = $outstanding_loans + $requested_amount;
    $within_limits = $total_after_new_loan <= $applicable_limit;
    
    return array(
        'met' => $within_limits,
        'current_outstanding' => $outstanding_loans,
        'requested_amount' => $requested_amount,
        'total_after_loan' => $total_after_new_loan,
        'applicable_limit' => $applicable_limit,
        'available_limit' => max(0, $applicable_limit - $outstanding_loans),
        'score' => $within_limits ? 10 : 0,
        'description' => 'Must not exceed aggregate loan limits'
    );
}

/**
 * Check staff loan factor calculation
 */
function daystar_check_staff_loan_factor($user_id) {
    $is_staff = get_user_meta($user_id, 'is_staff', true);
    $staff_type = get_user_meta($user_id, 'staff_type', true);
    
    if (!$is_staff) {
        return array(
            'applicable' => false,
            'staff_type' => 'Not staff',
            'additional_amount' => 0,
            'score' => 0,
            'description' => 'Staff loan factor not applicable'
        );
    }
    
    $additional_amount = 0;
    $payslip_data = daystar_get_latest_verified_payslip($user_id);
    
    if ($staff_type === 'part_time_teaching') {
        // Part-time teaching staff: add KSh 10,000
        $additional_amount = 10000;
    } elseif ($staff_type === 'permanent' && $payslip_data) {
        // Other permanent staff: 50% of specific allowances
        $allowances = $payslip_data->responsibility_allowance + 
                     $payslip_data->telephone_allowance + 
                     $payslip_data->hod_allowance;
        $additional_amount = $allowances * 0.5;
    }
    
    return array(
        'applicable' => true,
        'staff_type' => $staff_type,
        'additional_amount' => $additional_amount,
        'score' => $additional_amount > 0 ? 5 : 0,
        'description' => 'Staff loan factor provides additional borrowing capacity'
    );
}

/**
 * Check guarantor requirements
 */
function daystar_check_guarantor_requirements($user_id, $requested_amount) {
    // For now, we'll check if the user has provided guarantor information
    // In a real implementation, this would validate against actual guarantor data
    
    $guarantor_1 = get_user_meta($user_id, 'temp_guarantor_1', true);
    $guarantor_2 = get_user_meta($user_id, 'temp_guarantor_2', true);
    
    $has_guarantors = !empty($guarantor_1) && !empty($guarantor_2);
    
    // Check if guarantors are valid members
    $guarantor_1_valid = false;
    $guarantor_2_valid = false;
    
    if ($guarantor_1) {
        $guarantor_1_user = daystar_get_user_by_member_number($guarantor_1);
        $guarantor_1_valid = $guarantor_1_user && get_user_meta($guarantor_1_user->ID, 'member_status', true) === 'active';
    }
    
    if ($guarantor_2) {
        $guarantor_2_user = daystar_get_user_by_member_number($guarantor_2);
        $guarantor_2_valid = $guarantor_2_user && get_user_meta($guarantor_2_user->ID, 'member_status', true) === 'active';
    }
    
    $valid_guarantors = $guarantor_1_valid && $guarantor_2_valid;
    
    return array(
        'met' => $valid_guarantors,
        'has_guarantors' => $has_guarantors,
        'guarantor_1_valid' => $guarantor_1_valid,
        'guarantor_2_valid' => $guarantor_2_valid,
        'score' => $valid_guarantors ? 10 : 0,
        'description' => 'Two valid guarantors required'
    );
}

/**
 * Check collateral requirements
 */
function daystar_check_collateral_requirements($user_id, $loan_type, $requested_amount) {
    // Collateral requirements vary by loan type and amount
    $collateral_required = false;
    $min_collateral_value = 0;
    
    // Define collateral requirements
    if ($requested_amount > 500000) {
        $collateral_required = true;
        $min_collateral_value = $requested_amount * 1.2; // 120% of loan amount
    } elseif (in_array($loan_type, ['business', 'development']) && $requested_amount > 200000) {
        $collateral_required = true;
        $min_collateral_value = $requested_amount;
    }
    
    // Check if collateral has been provided
    $collateral_provided = get_user_meta($user_id, 'temp_collateral_value', true);
    $collateral_sufficient = $collateral_provided >= $min_collateral_value;
    
    return array(
        'required' => $collateral_required,
        'met' => !$collateral_required || $collateral_sufficient,
        'provided_value' => $collateral_provided,
        'required_value' => $min_collateral_value,
        'score' => (!$collateral_required || $collateral_sufficient) ? 5 : 0,
        'description' => $collateral_required ? 'Collateral required for this loan amount' : 'No collateral required'
    );
}

/**
 * Calculate overall eligibility score
 */
function daystar_calculate_eligibility_score($criteria_results) {
    $total_score = 0;
    
    foreach ($criteria_results as $criterion) {
        if (isset($criterion['score'])) {
            $total_score += $criterion['score'];
        }
    }
    
    return min(100, $total_score); // Cap at 100
}

/**
 * Assess loan risk based on criteria
 */
function daystar_assess_loan_risk($criteria_results, $eligibility_score) {
    if ($eligibility_score >= 80) {
        return 'low';
    } elseif ($eligibility_score >= 60) {
        return 'medium';
    } else {
        return 'high';
    }
}

/**
 * Calculate maximum loan amount based on all factors
 */
function daystar_calculate_maximum_loan_amount($user_id, $criteria_results) {
    $base_amount = 0;
    
    // Base calculation: 3x share capital + 2x regular contributions
    if (isset($criteria_results['share_capital'])) {
        $base_amount += $criteria_results['share_capital']['current_amount'] * 3;
    }
    
    $regular_contributions = daystar_get_member_regular_contributions($user_id);
    $base_amount += $regular_contributions * 2;
    
    // Add staff factor if applicable
    if (isset($criteria_results['staff_factor']) && $criteria_results['staff_factor']['applicable']) {
        $base_amount += $criteria_results['staff_factor']['additional_amount'];
    }
    
    // Apply risk adjustment
    $risk_multiplier = 1.0;
    if (isset($criteria_results['credit_history'])) {
        $credit_score = $criteria_results['credit_history']['credit_score'];
        if ($credit_score >= 80) {
            $risk_multiplier = 1.2;
        } elseif ($credit_score < 60) {
            $risk_multiplier = 0.8;
        }
    }
    
    $max_amount = $base_amount * $risk_multiplier;
    
    // Apply aggregate limits
    if (isset($criteria_results['aggregate_limits'])) {
        $max_amount = min($max_amount, $criteria_results['aggregate_limits']['available_limit']);
    }
    
    return max(0, $max_amount);
}

/**
 * Determine overall eligibility
 */
function daystar_determine_overall_eligibility($criteria_results, $eligibility_score) {
    // Must meet minimum requirements
    $required_criteria = ['share_capital', 'consistent_contributions', 'membership_duration'];
    
    foreach ($required_criteria as $criterion) {
        if (!isset($criteria_results[$criterion]) || !$criteria_results[$criterion]['met']) {
            return false;
        }
    }
    
    // Must have minimum eligibility score
    return $eligibility_score >= 60;
}

/**
 * Generate eligibility recommendations
 */
function daystar_generate_eligibility_recommendations($criteria_results) {
    $recommendations = array();
    
    foreach ($criteria_results as $key => $criterion) {
        if (!$criterion['met']) {
            switch ($key) {
                case 'share_capital':
                    $needed = $criterion['required_amount'] - $criterion['current_amount'];
                    $recommendations[] = "Increase share capital by KSh " . number_format($needed, 2) . " to meet minimum requirement.";
                    break;
                    
                case 'consistent_contributions':
                    $recommendations[] = "Maintain consistent monthly contributions of KSh 2,000 for " . 
                                       (6 - $criterion['months_compliant']) . " more months.";
                    break;
                    
                case 'membership_duration':
                    $needed_months = 6 - $criterion['months_as_member'];
                    $recommendations[] = "Continue membership for " . $needed_months . " more months to meet minimum duration.";
                    break;
                    
                case 'economic_income':
                    $recommendations[] = "Provide verifiable proof of income (payslip or business income documentation).";
                    break;
                    
                case 'guarantors':
                    $recommendations[] = "Secure two valid guarantors who are active SACCO members.";
                    break;
                    
                case 'collateral':
                    if ($criterion['required']) {
                        $needed = $criterion['required_value'] - $criterion['provided_value'];
                        $recommendations[] = "Provide additional collateral worth KSh " . number_format($needed, 2) . ".";
                    }
                    break;
            }
        }
    }
    
    return $recommendations;
}

/**
 * Generate eligibility warnings
 */
function daystar_generate_eligibility_warnings($criteria_results) {
    $warnings = array();
    
    // Check for potential issues
    if (isset($criteria_results['credit_history']) && $criteria_results['credit_history']['credit_score'] < 70) {
        $warnings[] = "Credit score is below optimal level. Consider improving payment history.";
    }
    
    if (isset($criteria_results['aggregate_limits']) && 
        $criteria_results['aggregate_limits']['current_outstanding'] > 0) {
        $warnings[] = "You have existing outstanding loans. This may affect your borrowing capacity.";
    }
    
    return $warnings;
}

/**
 * Get latest verified payslip data for a user
 */
function daystar_get_latest_verified_payslip($user_id) {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$payslip_table} 
         WHERE user_id = %d AND verification_status = 'verified' 
         ORDER BY payslip_year DESC, payslip_month DESC 
         LIMIT 1",
        $user_id
    ));
}

/**
 * Get user by member number
 */
function daystar_get_user_by_member_number($member_number) {
    $users = get_users(array(
        'meta_key' => 'member_number',
        'meta_value' => $member_number,
        'number' => 1
    ));
    
    return !empty($users) ? $users[0] : false;
}

/**
 * Save payslip data
 */
function daystar_save_payslip_data($user_id, $payslip_data) {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    $data = array(
        'user_id' => $user_id,
        'gross_salary' => $payslip_data['gross_salary'],
        'net_salary' => $payslip_data['net_salary'],
        'basic_salary' => $payslip_data['basic_salary'] ?? 0,
        'responsibility_allowance' => $payslip_data['responsibility_allowance'] ?? 0,
        'telephone_allowance' => $payslip_data['telephone_allowance'] ?? 0,
        'hod_allowance' => $payslip_data['hod_allowance'] ?? 0,
        'other_allowances' => $payslip_data['other_allowances'] ?? 0,
        'total_deductions' => $payslip_data['total_deductions'] ?? 0,
        'payslip_month' => $payslip_data['payslip_month'],
        'payslip_year' => $payslip_data['payslip_year'],
        'document_path' => $payslip_data['document_path'] ?? '',
        'verification_status' => 'pending'
    );
    
    return $wpdb->insert($payslip_table, $data);
}

/**
 * Verify payslip data (admin function)
 */
function daystar_verify_payslip_data($payslip_id, $admin_user_id, $verification_notes = '') {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    return $wpdb->update(
        $payslip_table,
        array(
            'verification_status' => 'verified',
            'verified_by_user_id' => $admin_user_id,
            'verified_date' => current_time('mysql'),
            'verification_notes' => $verification_notes
        ),
        array('id' => $payslip_id),
        array('%s', '%d', '%s', '%s'),
        array('%d')
    );
}

/**
 * Save guarantor information
 */
function daystar_save_guarantor($loan_id, $guarantor_user_id, $amount_guaranteed, $guarantee_type = 'shares') {
    global $wpdb;
    
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    
    return $wpdb->insert(
        $guarantors_table,
        array(
            'loan_id' => $loan_id,
            'guaranteed_by_user_id' => $guarantor_user_id,
            'amount_guaranteed' => $amount_guaranteed,
            'guarantee_type' => $guarantee_type,
            'guarantor_status' => 'pending'
        )
    );
}

/**
 * Save collateral information
 */
function daystar_save_collateral($loan_id, $user_id, $collateral_data) {
    global $wpdb;
    
    $collateral_table = $wpdb->prefix . 'daystar_collateral';
    
    return $wpdb->insert(
        $collateral_table,
        array(
            'loan_id' => $loan_id,
            'user_id' => $user_id,
            'collateral_type' => $collateral_data['type'],
            'estimated_value' => $collateral_data['value'],
            'description' => $collateral_data['description'],
            'document_path' => $collateral_data['document_path'] ?? '',
            'verification_status' => 'pending'
        )
    );
}

/**
 * Record credit history event
 */
function daystar_record_credit_event($user_id, $loan_id, $event_type, $amount = 0, $description = '', $credit_impact = 0) {
    global $wpdb;
    
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    return $wpdb->insert(
        $credit_history_table,
        array(
            'user_id' => $user_id,
            'loan_id' => $loan_id,
            'event_type' => $event_type,
            'amount' => $amount,
            'description' => $description,
            'credit_score_impact' => $credit_impact
        )
    );
}

/**
 * Get member's guarantor capacity
 */
function daystar_get_guarantor_capacity($user_id) {
    global $wpdb;
    
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    
    // Get total amount currently guaranteed
    $total_guaranteed = $wpdb->get_var($wpdb->prepare(
        "SELECT SUM(amount_guaranteed) FROM {$guarantors_table} 
         WHERE guaranteed_by_user_id = %d AND guarantor_status = 'approved'",
        $user_id
    ));
    
    $total_guaranteed = (float)($total_guaranteed ?: 0);
    
    // Calculate available capacity (typically 3x share capital)
    $share_capital = daystar_get_member_share_capital($user_id);
    $max_capacity = $share_capital * 3;
    $available_capacity = max(0, $max_capacity - $total_guaranteed);
    
    return array(
        'max_capacity' => $max_capacity,
        'total_guaranteed' => $total_guaranteed,
        'available_capacity' => $available_capacity
    );
}

/**
 * Check if user can guarantee a specific amount
 */
function daystar_can_guarantee_amount($user_id, $amount) {
    $capacity = daystar_get_guarantor_capacity($user_id);
    return $capacity['available_capacity'] >= $amount;
}

/**
 * Validate guarantor eligibility
 */
function daystar_validate_guarantor($guarantor_user_id, $loan_applicant_id, $amount) {
    $errors = array();
    
    // Check if guarantor is an active member
    $member_status = get_user_meta($guarantor_user_id, 'member_status', true);
    if ($member_status !== 'active') {
        $errors[] = 'Guarantor must be an active member.';
    }
    
    // Check if guarantor has sufficient capacity
    if (!daystar_can_guarantee_amount($guarantor_user_id, $amount)) {
        $capacity = daystar_get_guarantor_capacity($guarantor_user_id);
        $errors[] = 'Guarantor has insufficient capacity. Available: KSh ' . number_format($capacity['available_capacity'], 2);
    }
    
    // Check if guarantor is not the same as applicant
    if ($guarantor_user_id == $loan_applicant_id) {
        $errors[] = 'Member cannot guarantee their own loan.';
    }
    
    // Check for officer cross-guaranteeing (if applicable)
    $guarantor_role = get_user_meta($guarantor_user_id, 'sacco_role', true);
    $applicant_role = get_user_meta($loan_applicant_id, 'sacco_role', true);
    
    if (in_array($guarantor_role, ['chairman', 'secretary', 'treasurer']) && 
        in_array($applicant_role, ['chairman', 'secretary', 'treasurer'])) {
        $errors[] = 'SACCO officers should not guarantee each other.';
    }
    
    return array(
        'valid' => empty($errors),
        'errors' => $errors
    );
}

/**
 * Helper functions for member data calculations
 */



/**
 * Log loan status changes
 */
function daystar_log_loan_status_change($loan_id, $new_status, $admin_user_id, $notes = '') {
    global $wpdb;
    
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    // Get loan details
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan) return false;
    
    $description = "Loan status changed to: {$new_status}";
    if ($notes) {
        $description .= " - Notes: {$notes}";
    }
    
    return $wpdb->insert(
        $credit_history_table,
        array(
            'user_id' => $loan->user_id,
            'loan_id' => $loan_id,
            'event_type' => 'status_change',
            'description' => $description,
            'credit_score_impact' => daystar_get_credit_impact_for_status($new_status)
        )
    );
}

/**
 * Get credit score impact for status changes
 */
function daystar_get_credit_impact_for_status($status) {
    $impacts = array(
        'approved' => 5,
        'disbursed' => 10,
        'rejected' => -5,
        'defaulted' => -30,
        'completed' => 15
    );
    
    return isset($impacts[$status]) ? $impacts[$status] : 0;
}