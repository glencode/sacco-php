<?php
/**
 * Sample Data Generator for SACCO System
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
 * Create sample members with different roles and statuses
 */
function daystar_create_sample_members() {
    $members = array();
    
    // Define member profiles with realistic data
    $member_profiles = array(
        array(
            'username' => 'john_doe',
            'email' => 'john.doe@daystar.ac.ke',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role' => 'member',
            'member_number' => 'DS001',
            'member_status' => 'active',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'chairman',
            'phone' => '+254712345678',
            'id_number' => '12345678',
            'department' => 'Finance',
            'registration_date' => date('Y-m-d', strtotime('-2 years')),
            'business_income' => 0
        ),
        array(
            'username' => 'mary_smith',
            'email' => 'mary.smith@daystar.ac.ke',
            'first_name' => 'Mary',
            'last_name' => 'Smith',
            'role' => 'member',
            'member_number' => 'DS002',
            'member_status' => 'active',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'secretary',
            'phone' => '+254723456789',
            'id_number' => '23456789',
            'department' => 'Human Resources',
            'registration_date' => date('Y-m-d', strtotime('-18 months')),
            'business_income' => 0
        ),
        array(
            'username' => 'peter_johnson',
            'email' => 'peter.johnson@daystar.ac.ke',
            'first_name' => 'Peter',
            'last_name' => 'Johnson',
            'role' => 'member',
            'member_number' => 'DS003',
            'member_status' => 'active',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'treasurer',
            'phone' => '+254734567890',
            'id_number' => '34567890',
            'department' => 'Accounting',
            'registration_date' => date('Y-m-d', strtotime('-15 months')),
            'business_income' => 0
        ),
        array(
            'username' => 'sarah_wilson',
            'email' => 'sarah.wilson@daystar.ac.ke',
            'first_name' => 'Sarah',
            'last_name' => 'Wilson',
            'role' => 'member',
            'member_number' => 'DS004',
            'member_status' => 'active',
            'employment_status' => 'part_time',
            'staff_type' => 'part_time_teaching',
            'is_staff' => true,
            'sacco_role' => 'member',
            'phone' => '+254745678901',
            'id_number' => '45678901',
            'department' => 'Business',
            'registration_date' => date('Y-m-d', strtotime('-12 months')),
            'business_income' => 25000
        ),
        array(
            'username' => 'david_brown',
            'email' => 'david.brown@example.com',
            'first_name' => 'David',
            'last_name' => 'Brown',
            'role' => 'member',
            'member_number' => 'DS005',
            'member_status' => 'active',
            'employment_status' => 'self_employed',
            'staff_type' => '',
            'is_staff' => false,
            'sacco_role' => 'member',
            'phone' => '+254756789012',
            'id_number' => '56789012',
            'department' => '',
            'registration_date' => date('Y-m-d', strtotime('-10 months')),
            'business_income' => 45000
        ),
        array(
            'username' => 'grace_mwangi',
            'email' => 'grace.mwangi@daystar.ac.ke',
            'first_name' => 'Grace',
            'last_name' => 'Mwangi',
            'role' => 'member',
            'member_number' => 'DS006',
            'member_status' => 'active',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'member',
            'phone' => '+254767890123',
            'id_number' => '67890123',
            'department' => 'IT',
            'registration_date' => date('Y-m-d', strtotime('-8 months')),
            'business_income' => 0
        ),
        array(
            'username' => 'james_kiprotich',
            'email' => 'james.kiprotich@example.com',
            'first_name' => 'James',
            'last_name' => 'Kiprotich',
            'role' => 'pending_member',
            'member_number' => 'DS007',
            'member_status' => 'pending',
            'employment_status' => 'employed',
            'staff_type' => '',
            'is_staff' => false,
            'sacco_role' => 'member',
            'phone' => '+254778901234',
            'id_number' => '78901234',
            'department' => '',
            'registration_date' => date('Y-m-d', strtotime('-2 months')),
            'business_income' => 0
        ),
        array(
            'username' => 'lucy_wanjiku',
            'email' => 'lucy.wanjiku@daystar.ac.ke',
            'first_name' => 'Lucy',
            'last_name' => 'Wanjiku',
            'role' => 'member',
            'member_number' => 'DS008',
            'member_status' => 'suspended',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'member',
            'phone' => '+254789012345',
            'id_number' => '89012345',
            'department' => 'Library',
            'registration_date' => date('Y-m-d', strtotime('-6 months')),
            'business_income' => 0
        ),
        array(
            'username' => 'michael_ochieng',
            'email' => 'michael.ochieng@example.com',
            'first_name' => 'Michael',
            'last_name' => 'Ochieng',
            'role' => 'member',
            'member_number' => 'DS009',
            'member_status' => 'active',
            'employment_status' => 'contract',
            'staff_type' => '',
            'is_staff' => false,
            'sacco_role' => 'member',
            'phone' => '+254790123456',
            'id_number' => '90123456',
            'department' => '',
            'registration_date' => date('Y-m-d', strtotime('-14 months')),
            'business_income' => 35000
        ),
        array(
            'username' => 'esther_njeri',
            'email' => 'esther.njeri@daystar.ac.ke',
            'first_name' => 'Esther',
            'last_name' => 'Njeri',
            'role' => 'member',
            'member_number' => 'DS010',
            'member_status' => 'active',
            'employment_status' => 'permanent',
            'staff_type' => 'permanent',
            'is_staff' => true,
            'sacco_role' => 'member',
            'phone' => '+254701234567',
            'id_number' => '01234567',
            'department' => 'Communications',
            'registration_date' => date('Y-m-d', strtotime('-20 months')),
            'business_income' => 0
        )
    );
    
    foreach ($member_profiles as $profile) {
        // Check if user already exists
        $existing_user = get_user_by('login', $profile['username']);
        if ($existing_user) {
            $members[] = $existing_user->ID;
            continue;
        }
        
        // Create WordPress user
        $user_id = wp_create_user(
            $profile['username'],
            'password123', // Default password
            $profile['email']
        );
        
        if (!is_wp_error($user_id)) {
            // Update user data
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $profile['first_name'],
                'last_name' => $profile['last_name'],
                'role' => $profile['role']
            ));
            
            // Add member metadata
            foreach ($profile as $key => $value) {
                if (!in_array($key, ['username', 'email', 'first_name', 'last_name', 'role'])) {
                    update_user_meta($user_id, $key, $value);
                }
            }
            
            $members[] = $user_id;
        }
    }
    
    return $members;
}

/**
 * Create sample contributions for members
 */
function daystar_create_sample_contributions($members) {
    global $wpdb;
    
    $contributions_table = $wpdb->prefix . 'daystar_contributions';
    
    foreach ($members as $user_id) {
        $member_status = get_user_meta($user_id, 'member_status', true);
        $registration_date = get_user_meta($user_id, 'registration_date', true);
        
        if ($member_status === 'pending') {
            continue; // Skip pending members
        }
        
        // Share capital contribution
        $share_capital_amount = rand(5000, 15000);
        $wpdb->insert(
            $contributions_table,
            array(
                'user_id' => $user_id,
                'amount' => $share_capital_amount,
                'contribution_type' => 'share_capital',
                'is_share_capital' => 1,
                'contribution_date' => $registration_date . ' 10:00:00',
                'status' => 'completed',
                'payment_method' => 'bank_transfer',
                'reference_number' => 'SC' . $user_id . time(),
                'notes' => 'Initial share capital contribution'
            )
        );
        
        // Monthly contributions
        $months_since_registration = floor((time() - strtotime($registration_date)) / (30 * 24 * 60 * 60));
        $months_since_registration = min($months_since_registration, 24); // Cap at 24 months
        
        for ($i = 0; $i < $months_since_registration; $i++) {
            $contribution_date = date('Y-m-d H:i:s', strtotime($registration_date . " +{$i} months"));
            $amount = rand(1500, 3000);
            
            // Some members might miss contributions
            if (rand(1, 10) > 8 && $member_status === 'suspended') {
                continue; // Skip this contribution
            }
            
            $wpdb->insert(
                $contributions_table,
                array(
                    'user_id' => $user_id,
                    'amount' => $amount,
                    'contribution_type' => 'monthly',
                    'is_share_capital' => 0,
                    'contribution_date' => $contribution_date,
                    'status' => 'completed',
                    'payment_method' => rand(1, 3) == 1 ? 'mpesa' : 'bank_transfer',
                    'reference_number' => 'TXN' . $user_id . $i . time(),
                    'notes' => 'Monthly contribution'
                )
            );
        }
        
        // Additional share capital contributions
        if (rand(1, 3) == 1) {
            $additional_amount = rand(2000, 8000);
            $additional_date = date('Y-m-d H:i:s', strtotime($registration_date . ' +' . rand(2, 12) . ' months'));
            
            $wpdb->insert(
                $contributions_table,
                array(
                    'user_id' => $user_id,
                    'amount' => $additional_amount,
                    'contribution_type' => 'additional_share_capital',
                    'is_share_capital' => 1,
                    'contribution_date' => $additional_date,
                    'status' => 'completed',
                    'payment_method' => 'bank_transfer',
                    'reference_number' => 'ASC' . $user_id . time(),
                    'notes' => 'Additional share capital contribution'
                )
            );
        }
    }
}

/**
 * Create sample loans with different statuses
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
            
            // Calculate monthly payment
            $monthly_interest_rate = $product->interest_rate / 100 / 12;
            // Prevent division by zero
            $denominator = pow(1 + $monthly_interest_rate, $term_months) - 1;
            if ($denominator == 0 || $monthly_interest_rate == 0) {
                $monthly_payment = $amount / max(1, $term_months); // Simple division if no interest
            } else {
                $monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / $denominator;
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

/**
 * Create sample loan payments
 */
function daystar_create_sample_loan_payments() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan_payments_table = $wpdb->prefix . 'daystar_loan_payments';
    
    // Get active and completed loans
    $loans = $wpdb->get_results("SELECT * FROM $loans_table WHERE status IN ('active', 'completed', 'defaulted')");
    
    foreach ($loans as $loan) {
        $months_elapsed = floor((time() - strtotime($loan->loan_date)) / (30 * 24 * 60 * 60));
        $months_elapsed = min($months_elapsed, $loan->term_months);
        
        // Create payments for elapsed months
        for ($i = 1; $i <= $months_elapsed; $i++) {
            // Skip some payments for defaulted loans
            if ($loan->status === 'defaulted' && rand(1, 3) == 1) {
                continue;
            }
            
            $payment_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . " +{$i} months"));
            $payment_amount = $loan->monthly_payment + rand(-500, 500); // Some variation
            $principal_amount = $payment_amount * 0.7; // Approximate
            $interest_amount = $payment_amount * 0.3;
            
            $wpdb->insert(
                $loan_payments_table,
                array(
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'amount' => $payment_amount,
                    'principal_amount' => $principal_amount,
                    'interest_amount' => $interest_amount,
                    'payment_date' => $payment_date,
                    'payment_method' => rand(1, 3) == 1 ? 'mpesa' : 'bank_transfer',
                    'reference_number' => 'PAY' . $loan->id . $i . time(),
                    'status' => 'completed',
                    'is_payroll_deduction' => get_user_meta($loan->user_id, 'is_staff', true) && rand(1, 2) == 1 ? 1 : 0
                )
            );
        }
    }
}

/**
 * Create sample guarantor relationships
 */
function daystar_create_sample_guarantors($members) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    
    // Get loans that need guarantors
    $loans = $wpdb->get_results("SELECT * FROM $loans_table WHERE status IN ('approved', 'active', 'completed')");
    
    foreach ($loans as $loan) {
        // Each loan gets 2 guarantors
        $available_guarantors = array_filter($members, function($member_id) use ($loan) {
            return $member_id != $loan->user_id; // Can't guarantee own loan
        });
        
        $selected_guarantors = array_rand(array_flip($available_guarantors), min(2, count($available_guarantors)));
        if (!is_array($selected_guarantors)) {
            $selected_guarantors = array($selected_guarantors);
        }
        
        foreach ($selected_guarantors as $guarantor_id) {
            $amount_guaranteed = $loan->amount / 2; // Split guarantee amount
            
            $wpdb->insert(
                $guarantors_table,
                array(
                    'loan_id' => $loan->id,
                    'guaranteed_by_user_id' => $guarantor_id,
                    'amount_guaranteed' => $amount_guaranteed,
                    'guarantor_status' => 'approved',
                    'guarantee_type' => 'shares',
                    'guarantor_notes' => 'Approved guarantor for loan application'
                )
            );
        }
    }
}

/**
 * Create sample payslip data
 */
function daystar_create_sample_payslip_data($members) {
    global $wpdb;
    
    $payslip_table = $wpdb->prefix . 'daystar_payslip_data';
    
    foreach ($members as $user_id) {
        $is_staff = get_user_meta($user_id, 'is_staff', true);
        $staff_type = get_user_meta($user_id, 'staff_type', true);
        
        if (!$is_staff) {
            continue; // Only create payslips for staff
        }
        
        // Create payslips for last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = date('m', strtotime("-{$i} months"));
            $year = date('Y', strtotime("-{$i} months"));
            
            // Generate realistic salary data
            $basic_salary = rand(40000, 120000);
            $responsibility_allowance = rand(5000, 15000);
            $telephone_allowance = 2000;
            $hod_allowance = $staff_type === 'permanent' ? rand(0, 10000) : 0;
            $other_allowances = rand(1000, 5000);
            
            $gross_salary = $basic_salary + $responsibility_allowance + $telephone_allowance + $hod_allowance + $other_allowances;
            $total_deductions = $gross_salary * 0.3; // 30% deductions
            $net_salary = $gross_salary - $total_deductions;
            
            $wpdb->insert(
                $payslip_table,
                array(
                    'user_id' => $user_id,
                    'gross_salary' => $gross_salary,
                    'net_salary' => $net_salary,
                    'basic_salary' => $basic_salary,
                    'responsibility_allowance' => $responsibility_allowance,
                    'telephone_allowance' => $telephone_allowance,
                    'hod_allowance' => $hod_allowance,
                    'other_allowances' => $other_allowances,
                    'total_deductions' => $total_deductions,
                    'payslip_month' => $year . '-' . $month,
                    'payslip_year' => $year,
                    'verification_status' => 'verified',
                    'verified_by_user_id' => $members[0], // First member as verifier
                    'verified_date' => current_time('mysql')
                )
            );
        }
    }
}

/**
 * Create sample notifications
 */
function daystar_create_sample_notifications($members) {
    global $wpdb;
    
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    $notification_templates = array(
        array(
            'title' => 'Contribution Received',
            'message' => 'Your monthly contribution of KES {amount} has been received and processed.',
            'type' => 'contribution'
        ),
        array(
            'title' => 'Loan Application Approved',
            'message' => 'Your loan application for KES {amount} has been approved. Disbursement will be processed within 3 working days.',
            'type' => 'loan'
        ),
        array(
            'title' => 'Payment Reminder',
            'message' => 'Your loan payment of KES {amount} is due on {date}. Please ensure timely payment to avoid penalties.',
            'type' => 'reminder'
        ),
        array(
            'title' => 'AGM Notice',
            'message' => 'The Annual General Meeting is scheduled for {date}. Your attendance is highly encouraged.',
            'type' => 'announcement'
        ),
        array(
            'title' => 'Share Capital Update',
            'message' => 'Your share capital has been updated. Current balance: KES {amount}.',
            'type' => 'share_capital'
        ),
        array(
            'title' => 'System Maintenance',
            'message' => 'The SACCO system will undergo maintenance on {date} from 2:00 AM to 4:00 AM.',
            'type' => 'system'
        )
    );
    
    foreach ($members as $user_id) {
        // Create 3-8 notifications per member
        $num_notifications = rand(3, 8);
        
        for ($i = 0; $i < $num_notifications; $i++) {
            $template = $notification_templates[array_rand($notification_templates)];
            $created_date = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'));
            
            // Replace placeholders
            $message = str_replace(
                array('{amount}', '{date}'),
                array(number_format(rand(1000, 50000), 2), date('M j, Y', strtotime('+' . rand(1, 30) . ' days'))),
                $template['message']
            );
            
            $wpdb->insert(
                $notifications_table,
                array(
                    'user_id' => $user_id,
                    'title' => $template['title'],
                    'message' => $message,
                    'type' => $template['type'],
                    'is_read' => rand(1, 3) == 1 ? 0 : 1, // 1/3 unread
                    'created_at' => $created_date,
                    'read_at' => rand(1, 3) == 1 ? null : date('Y-m-d H:i:s', strtotime($created_date . ' +' . rand(1, 24) . ' hours'))
                )
            );
        }
    }
}

/**
 * Create sample credit history
 */
function daystar_create_sample_credit_history($members) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    $loans = $wpdb->get_results("SELECT * FROM $loans_table");
    
    $event_types = array(
        'loan_application' => 0,
        'loan_approval' => 5,
        'loan_disbursement' => 10,
        'payment_made' => 2,
        'late_payment' => -5,
        'loan_completion' => 15,
        'loan_default' => -30
    );
    
    foreach ($loans as $loan) {
        // Create credit events for each loan
        foreach ($event_types as $event_type => $impact) {
            // Skip events that don't apply to loan status
            if ($loan->status === 'pending' && !in_array($event_type, ['loan_application'])) {
                continue;
            }
            if ($loan->status === 'rejected' && !in_array($event_type, ['loan_application'])) {
                continue;
            }
            
            $event_date = $loan->loan_date;
            $description = '';
            
            switch ($event_type) {
                case 'loan_application':
                    $description = "Loan application submitted for KES " . number_format($loan->amount, 2);
                    break;
                case 'loan_approval':
                    $description = "Loan approved for KES " . number_format($loan->amount, 2);
                    $event_date = $loan->approved_date ?: $loan->loan_date;
                    break;
                case 'loan_disbursement':
                    $description = "Loan disbursed for KES " . number_format($loan->amount, 2);
                    $event_date = $loan->disbursed_date ?: $loan->loan_date;
                    break;
                case 'payment_made':
                    if (in_array($loan->status, ['active', 'completed'])) {
                        $description = "Regular payment made";
                        $event_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +1 month'));
                    } else {
                        continue 2;
                    }
                    break;
                case 'late_payment':
                    if ($loan->status === 'defaulted' || rand(1, 5) == 1) {
                        $description = "Late payment recorded";
                        $event_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +' . rand(2, 6) . ' months'));
                    } else {
                        continue 2;
                    }
                    break;
                case 'loan_completion':
                    if ($loan->status === 'completed') {
                        $description = "Loan completed successfully";
                        $event_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +' . $loan->term_months . ' months'));
                    } else {
                        continue 2;
                    }
                    break;
                case 'loan_default':
                    if ($loan->status === 'defaulted') {
                        $description = "Loan defaulted";
                        $event_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +' . rand(6, 18) . ' months'));
                    } else {
                        continue 2;
                    }
                    break;
            }
            
            $wpdb->insert(
                $credit_history_table,
                array(
                    'user_id' => $loan->user_id,
                    'loan_id' => $loan->id,
                    'event_type' => $event_type,
                    'event_date' => $event_date,
                    'amount' => $loan->amount,
                    'description' => $description,
                    'credit_score_impact' => $impact
                )
            );
        }
    }
}

/**
 * Create sample collateral records
 */
function daystar_create_sample_collateral() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $collateral_table = $wpdb->prefix . 'daystar_collateral';
    
    // Get loans above 200,000 that might need collateral
    $loans = $wpdb->get_results("SELECT * FROM $loans_table WHERE amount > 200000 AND status IN ('approved', 'active', 'completed')");
    
    $collateral_types = array(
        'Vehicle' => array(50000, 2000000),
        'Land Title' => array(100000, 5000000),
        'House' => array(200000, 10000000),
        'Equipment' => array(20000, 500000),
        'Shares/Securities' => array(10000, 1000000)
    );
    
    foreach ($loans as $loan) {
        // 60% chance of having collateral
        if (rand(1, 10) <= 6) {
            $type = array_rand($collateral_types);
            $value_range = $collateral_types[$type];
            $estimated_value = rand($value_range[0], min($value_range[1], $loan->amount * 1.5));
            
            $wpdb->insert(
                $collateral_table,
                array(
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'collateral_type' => $type,
                    'estimated_value' => $estimated_value,
                    'description' => "Sample {$type} collateral for loan security",
                    'verification_status' => 'verified',
                    'verified_by_user_id' => 1,
                    'verified_date' => current_time('mysql'),
                    'verification_notes' => 'Verified during loan processing'
                )
            );
        }
    }
}

/**
 * Create sample loan appeals
 */
function daystar_create_sample_loan_appeals() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan_appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    // Get rejected loans
    $rejected_loans = $wpdb->get_results("SELECT * FROM $loans_table WHERE status = 'rejected'");
    
    $appeal_reasons = array(
        'Disagreement with eligibility assessment',
        'Additional guarantors now available',
        'Improved financial circumstances',
        'Collateral now available',
        'Clarification on application requirements'
    );
    
    foreach ($rejected_loans as $loan) {
        // 30% chance of appeal
        if (rand(1, 10) <= 3) {
            $appeal_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +' . rand(1, 14) . ' days'));
            $deadline = date('Y-m-d', strtotime($appeal_date . ' +30 days'));
            
            $wpdb->insert(
                $loan_appeals_table,
                array(
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'appeal_date' => $appeal_date,
                    'reason_for_appeal' => $appeal_reasons[array_rand($appeal_reasons)],
                    'supporting_documents' => 'Additional guarantor forms, updated payslip',
                    'status' => rand(1, 3) == 1 ? 'pending' : (rand(1, 2) == 1 ? 'approved' : 'rejected'),
                    'appeal_deadline' => $deadline,
                    'original_rejection_reason' => $loan->rejection_reason ?: 'Insufficient guarantors'
                )
            );
        }
    }
}

/**
 * Create sample blacklist entries
 */
function daystar_create_sample_blacklist($members) {
    global $wpdb;
    
    $blacklist_table = $wpdb->prefix . 'daystar_blacklist';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Get defaulted loans
    $defaulted_loans = $wpdb->get_results("SELECT * FROM $loans_table WHERE status = 'defaulted'");
    
    foreach ($defaulted_loans as $loan) {
        // 50% chance of blacklisting for defaulted loans
        if (rand(1, 2) == 1) {
            $blacklist_date = date('Y-m-d H:i:s', strtotime($loan->loan_date . ' +' . rand(6, 12) . ' months'));
            
            $wpdb->insert(
                $blacklist_table,
                array(
                    'user_id' => $loan->user_id,
                    'reason' => 'Loan default - failure to repay loan within agreed terms',
                    'blacklist_date' => $blacklist_date,
                    'status' => rand(1, 4) == 1 ? 'removed' : 'active',
                    'blacklisted_by' => $members[0],
                    'automatic_blacklist' => 1,
                    'loan_id' => $loan->id,
                    'notes' => 'Automatically blacklisted due to loan default'
                )
            );
        }
    }
}

/**
 * Create sample share transfers
 */
function daystar_create_sample_share_transfers($members) {
    global $wpdb;
    
    $share_transfers_table = $wpdb->prefix . 'daystar_share_transfers';
    
    // Create a few share transfer requests
    for ($i = 0; $i < 5; $i++) {
        $from_user = $members[array_rand($members)];
        $to_user = $members[array_rand($members)];
        
        if ($from_user == $to_user) {
            continue; // Skip same user transfers
        }
        
        $amount = rand(1000, 10000);
        $status = array('pending', 'approved', 'rejected')[array_rand(array('pending', 'approved', 'rejected'))];
        
        $wpdb->insert(
            $share_transfers_table,
            array(
                'from_user_id' => $from_user,
                'to_user_id' => $to_user,
                'share_amount' => $amount,
                'transfer_reason' => 'Family transfer request',
                'status' => $status,
                'requested_date' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days')),
                'approved_by' => $status === 'approved' ? $members[0] : null,
                'approved_date' => $status === 'approved' ? current_time('mysql') : null
            )
        );
    }
}

/**
 * Clear existing sample data
 */
function daystar_clear_sample_data() {
    global $wpdb;
    
    $tables = array(
        'daystar_contributions',
        'daystar_loans',
        'daystar_loan_payments',
        'daystar_loan_schedules',
        'daystar_notifications',
        'daystar_guarantors',
        'daystar_collateral',
        'daystar_payslip_data',
        'daystar_credit_history',
        'daystar_loan_appeals',
        'daystar_blacklist',
        'daystar_share_transfers'
    );
    
    foreach ($tables as $table) {
        $table_name = $wpdb->prefix . $table;
        $wpdb->query("TRUNCATE TABLE $table_name");
    }
    
    // Remove sample users (those with member numbers starting with DS)
    $sample_users = get_users(array(
        'meta_key' => 'member_number',
        'meta_value' => 'DS',
        'meta_compare' => 'LIKE'
    ));
    
    foreach ($sample_users as $user) {
        wp_delete_user($user->ID);
    }
}

/**
 * AJAX handler for generating sample data
 */
function daystar_ajax_generate_sample_data() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_sample_data_nonce')) {
        wp_die('Security check failed');
    }
    
    $clear_existing = isset($_POST['clear_existing']) && $_POST['clear_existing'] === 'true';
    
    $result = daystar_generate_sample_data($clear_existing);
    
    wp_send_json_success($result);
}
add_action('wp_ajax_generate_sample_data', 'daystar_ajax_generate_sample_data');

/**
 * Add admin menu for sample data generator
 */
function daystar_add_sample_data_admin_menu() {
    add_submenu_page(
        'tools.php',
        'SACCO Sample Data Generator',
        'Sample Data Generator',
        'manage_options',
        'daystar-sample-data',
        'daystar_sample_data_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_sample_data_admin_menu');

/**
 * Admin page for sample data generator
 */
function daystar_sample_data_admin_page() {
    ?>
    <div class="wrap">
        <h1>SACCO Sample Data Generator</h1>
        <p>Generate comprehensive sample data for the SACCO system to showcase functionality.</p>
        
        <div class="card">
            <h2>Generate Sample Data</h2>
            <p>This will create:</p>
            <ul>
                <li>10 sample members with different roles and statuses</li>
                <li>Realistic contribution histories</li>
                <li>Various loan applications and statuses</li>
                <li>Payment records and schedules</li>
                <li>Guarantor relationships</li>
                <li>Payslip data for staff members</li>
                <li>Notifications and credit history</li>
                <li>Collateral and appeal records</li>
            </ul>
            
            <form id="sample-data-form">
                <table class="form-table">
                    <tr>
                        <th scope="row">Clear Existing Data</th>
                        <td>
                            <label>
                                <input type="checkbox" id="clear_existing" name="clear_existing" value="true">
                                Remove all existing sample data before generating new data
                            </label>
                            <p class="description">Warning: This will permanently delete all sample data!</p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary" id="generate-btn">
                        Generate Sample Data
                    </button>
                    <span class="spinner" id="sample-data-spinner"></span>
                </p>
            </form>
            
            <div id="sample-data-result" style="display: none;"></div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#sample-data-form').on('submit', function(e) {
            e.preventDefault();
            
            var $btn = $('#generate-btn');
            var $spinner = $('#sample-data-spinner');
            var $result = $('#sample-data-result');
            
            $btn.prop('disabled', true);
            $spinner.addClass('is-active');
            $result.hide();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'generate_sample_data',
                    nonce: '<?php echo wp_create_nonce('daystar_sample_data_nonce'); ?>',
                    clear_existing: $('#clear_existing').is(':checked') ? 'true' : 'false'
                },
                success: function(response) {
                    if (response.success) {
                        $result.html('<div class="notice notice-success"><p><strong>Success!</strong> ' + response.data.message + '</p><p>Members created: ' + response.data.members_created + '</p></div>').show();
                    } else {
                        $result.html('<div class="notice notice-error"><p><strong>Error:</strong> ' + response.data + '</p></div>').show();
                    }
                },
                error: function() {
                    $result.html('<div class="notice notice-error"><p><strong>Error:</strong> Failed to generate sample data.</p></div>').show();
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.removeClass('is-active');
                }
            });
        });
    });
    </script>
    <?php
}