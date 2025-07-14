<?php
/**
 * Staff Loan Enhancements
 * Implements PRD Section 6 - Loans to Office Bearers and Staff
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add staff loan fields to loan admin display
 */
function daystar_add_staff_loan_admin_display() {
    add_action('admin_head', 'daystar_staff_loan_admin_styles');
    add_filter('daystar_loan_admin_row_content', 'daystar_add_staff_loan_indicators', 10, 2);
}
add_action('init', 'daystar_add_staff_loan_admin_display');

/**
 * Add CSS styles for staff loan indicators
 */
function daystar_staff_loan_admin_styles() {
    ?>
    <style>
    .staff-loan-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
        margin-top: 4px;
    }
    
    .staff-loan-warning {
        background: #fef2f2;
        color: #dc2626;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 4px solid #dc2626;
        margin: 10px 0;
        font-size: 0.9rem;
    }
    
    .staff-loan-notice {
        background: #eff6ff;
        color: #1e40af;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 4px solid #1e40af;
        margin: 10px 0;
        font-size: 0.9rem;
    }
    
    .officer-guarantee-warning {
        background: #fef2f2;
        border: 2px solid #dc2626;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
    }
    
    .officer-guarantee-warning h4 {
        color: #dc2626;
        margin: 0 0 10px 0;
        font-size: 1.1rem;
    }
    
    .extended-term-notice {
        background: #f0fdf4;
        color: #166534;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 4px solid #16a34a;
        margin: 10px 0;
        font-size: 0.9rem;
    }
    </style>
    <?php
}

/**
 * Enhanced loan status update for staff loans
 */
function daystar_update_staff_loan_status($loan_id, $status, $admin_user_id, $notes = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Get loan details
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan) {
        return false;
    }
    
    // Standard loan status update
    $result = daystar_update_loan_status($loan_id, $status, $admin_user_id, $notes);
    
    // Additional processing for staff loans
    if ($result && $loan->is_staff_loan) {
        // Add staff loan specific notes
        $staff_notes = daystar_get_staff_loan_approval_notes($loan_id);
        
        if ($status === 'approved') {
            // Add special approval note for staff loans
            $additional_notes = "\n\nSTAFF LOAN APPROVAL NOTES:\n" . $staff_notes;
            $wpdb->update(
                $loans_table,
                array('application_notes' => $loan->application_notes . $additional_notes),
                array('id' => $loan_id)
            );
            
            // Send special notification for staff loan approval
            daystar_send_staff_loan_approval_notification($loan_id);
        }
        
        // Log staff loan decision in audit trail
        daystar_log_staff_loan_decision($loan_id, $status, $admin_user_id, $notes);
    }
    
    return $result;
}

/**
 * Send special notification for staff loan approval
 */
function daystar_send_staff_loan_approval_notification($loan_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan) return;
    
    $user = get_user_by('ID', $loan->user_id);
    if (!$user) return;
    
    // Send email notification
    $subject = 'Staff Loan Approved - ' . ($loan->application_waiting_number ?: 'APP-' . $loan->id);
    $message = "Dear {$user->first_name},\n\n";
    $message .= "Your staff loan application has been approved with the following details:\n\n";
    $message .= "Application Number: " . ($loan->application_waiting_number ?: 'APP-' . $loan->id) . "\n";
    $message .= "Loan Type: " . ucfirst(str_replace('_', ' ', $loan->loan_type)) . "\n";
    $message .= "Amount: KES " . number_format($loan->amount, 2) . "\n";
    $message .= "Term: {$loan->term_months} months\n";
    $message .= "Monthly Payment: KES " . number_format($loan->monthly_payment, 2) . "\n\n";
    
    if ($loan->term_months > 36) {
        $message .= "SPECIAL TERMS:\n";
        $message .= "• Extended repayment period of {$loan->term_months} months approved based on need assessment\n";
        $message .= "• This is in accordance with staff loan policy provisions\n\n";
    }
    
    $message .= "NEXT STEPS:\n";
    $message .= "1. Loan disbursement will be processed within 2-3 working days\n";
    $message .= "2. First payment will be due one month from disbursement date\n";
    $message .= "3. You will receive disbursement confirmation via SMS and email\n\n";
    
    $message .= "As a staff member, please note:\n";
    $message .= "• This loan was approved under staff loan provisions\n";
    $message .= "• Regular repayment is essential to maintain good standing\n";
    $message .= "• Contact the SACCO office for any payment arrangements\n\n";
    
    $message .= "Thank you for your continued service and membership.\n\n";
    $message .= "Best regards,\n";
    $message .= "Daystar SACCO Credit Committee";
    
    wp_mail($user->user_email, $subject, $message);
    
    // Create in-app notification
    if (function_exists('daystar_create_notification')) {
        daystar_create_notification(
            $loan->user_id,
            'Staff Loan Approved',
            "Your staff loan application has been approved. Disbursement will be processed within 2-3 working days.",
            'loan'
        );
    }
}

/**
 * Log staff loan decision in audit trail
 */
function daystar_log_staff_loan_decision($loan_id, $status, $admin_user_id, $notes) {
    global $wpdb;
    
    $audit_table = $wpdb->prefix . 'daystar_audit_log';
    
    // Create audit log table if it doesn't exist
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$audit_table} (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        entity_type varchar(50) NOT NULL,
        entity_id mediumint(9) NOT NULL,
        action varchar(50) NOT NULL,
        details text,
        user_id bigint(20) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY entity_type (entity_type),
        KEY entity_id (entity_id),
        KEY user_id (user_id)
    )");
    
    $admin_user = get_user_by('ID', $admin_user_id);
    $details = array(
        'loan_id' => $loan_id,
        'status' => $status,
        'notes' => $notes,
        'admin_name' => $admin_user ? $admin_user->display_name : 'Unknown',
        'timestamp' => current_time('mysql'),
        'special_type' => 'staff_loan'
    );
    
    $wpdb->insert(
        $audit_table,
        array(
            'entity_type' => 'staff_loan',
            'entity_id' => $loan_id,
            'action' => 'status_change_' . $status,
            'details' => json_encode($details),
            'user_id' => $admin_user_id
        )
    );
}

/**
 * Display staff loan warnings in Credit Committee dashboard
 */
function daystar_display_staff_loan_warnings($loan_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if (!$loan || !$loan->is_staff_loan) {
        return '';
    }
    
    $warnings = array();
    $notices = array();
    
    // Check for extended repayment period
    if ($loan->term_months > 36) {
        $notices[] = "Extended repayment period of {$loan->term_months} months (beyond standard 36 months)";
    }
    
    // Check for officer guarantees
    $guarantors_table = $wpdb->prefix . 'daystar_guarantors';
    $guarantors = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$guarantors_table} WHERE loan_id = %d",
        $loan_id
    ));
    
    $officer_guarantors = array();
    foreach ($guarantors as $guarantor) {
        $guarantor_staff_info = daystar_check_staff_loan_eligibility($guarantor->guaranteed_by_user_id);
        if ($guarantor_staff_info['is_staff']) {
            $guarantor_user = get_user_by('ID', $guarantor->guaranteed_by_user_id);
            $officer_guarantors[] = $guarantor_user->display_name;
        }
    }
    
    if (!empty($officer_guarantors)) {
        $warnings[] = "Officer cross-guarantee detected: " . implode(', ', $officer_guarantors) . " (also staff/officer)";
    }
    
    // Generate HTML output
    $output = '';
    
    if (!empty($warnings)) {
        $output .= '<div class="officer-guarantee-warning">';
        $output .= '<h4>⚠️ OFFICER CROSS-GUARANTEE WARNING</h4>';
        foreach ($warnings as $warning) {
            $output .= '<p>' . esc_html($warning) . '</p>';
        }
        $output .= '<p><strong>Action Required:</strong> Committee must review for potential conflicts of interest as per PRD Section 6.</p>';
        $output .= '</div>';
    }
    
    if (!empty($notices)) {
        $output .= '<div class="staff-loan-notice">';
        $output .= '<h4>📋 Staff Loan Special Considerations</h4>';
        foreach ($notices as $notice) {
            $output .= '<p>' . esc_html($notice) . '</p>';
        }
        $output .= '<p><strong>Note:</strong> Application can be approved in CMC meeting in absence of applicant.</p>';
        $output .= '</div>';
    }
    
    return $output;
}

/**
 * Add staff loan information to loan details modal
 */
function daystar_add_staff_loan_details_to_modal($loan_details_html, $loan) {
    if (!$loan->is_staff_loan) {
        return $loan_details_html;
    }
    
    $staff_section = '<div class="loan-section staff-loan-section">';
    $staff_section .= '<h3 style="color: #92400e;">👥 Staff Loan Information</h3>';
    $staff_section .= '<div class="info-grid">';
    
    $staff_section .= '<div class="info-item">';
    $staff_section .= '<div class="info-label">Staff Type</div>';
    $staff_section .= '<div class="info-value">' . esc_html(ucfirst(str_replace('_', ' ', $loan->staff_type ?: 'General Staff'))) . '</div>';
    $staff_section .= '</div>';
    
    if ($loan->term_months > 36) {
        $staff_section .= '<div class="info-item">';
        $staff_section .= '<div class="info-label">Extended Term</div>';
        $staff_section .= '<div class="info-value" style="color: #16a34a; font-weight: bold;">';
        $staff_section .= $loan->term_months . ' months (Extended beyond standard 36 months)';
        $staff_section .= '</div>';
        $staff_section .= '</div>';
    }
    
    $staff_section .= '</div>';
    
    // Add staff loan approval notes
    $approval_notes = daystar_get_staff_loan_approval_notes($loan->id);
    if ($approval_notes) {
        $staff_section .= '<div style="margin-top: 15px;">';
        $staff_section .= '<div class="info-label">Staff Loan Considerations</div>';
        $staff_section .= '<div class="info-value" style="white-space: pre-line; background: #f9fafb; padding: 10px; border-radius: 4px;">';
        $staff_section .= esc_html($approval_notes);
        $staff_section .= '</div>';
        $staff_section .= '</div>';
    }
    
    $staff_section .= '</div>';
    
    // Insert staff section after basic loan information
    $loan_details_html = str_replace(
        '</div>', // End of first loan section
        '</div>' . $staff_section,
        $loan_details_html,
        1 // Only replace the first occurrence
    );
    
    return $loan_details_html;
}

/**
 * Validate staff loan application with enhanced checks
 */
function daystar_validate_staff_loan_application($loan_data, $user_id) {
    $validation_result = array(
        'valid' => true,
        'errors' => array(),
        'warnings' => array(),
        'staff_considerations' => array()
    );
    
    // Check if this is a staff loan
    $staff_info = daystar_check_staff_loan_eligibility($user_id);
    
    if (!$staff_info['is_staff']) {
        return $validation_result; // Not a staff loan, no special validation needed
    }
    
    // Staff loan specific validations
    
    // 1. Check extended repayment period
    if ($loan_data['loan_term'] > 36) {
        if ($loan_data['loan_term'] > 48) {
            $validation_result['errors'][] = 'Maximum repayment period for staff loans is 48 months.';
        } else {
            $validation_result['staff_considerations'][] = 'Extended repayment period of ' . $loan_data['loan_term'] . ' months requested (beyond standard 36 months).';
        }
    }
    
    // 2. Check for officer guarantees
    if (isset($loan_data['guarantor1_member_no']) && isset($loan_data['guarantor2_member_no'])) {
        $guarantor1_user = daystar_get_user_by_member_number($loan_data['guarantor1_member_no']);
        $guarantor2_user = daystar_get_user_by_member_number($loan_data['guarantor2_member_no']);
        
        if ($guarantor1_user) {
            $guarantor1_staff_info = daystar_check_staff_loan_eligibility($guarantor1_user->ID);
            if ($guarantor1_staff_info['is_staff']) {
                $validation_result['warnings'][] = 'Guarantor 1 (' . $guarantor1_user->display_name . ') is also a staff member/officer. Committee review required for potential conflicts.';
            }
        }
        
        if ($guarantor2_user) {
            $guarantor2_staff_info = daystar_check_staff_loan_eligibility($guarantor2_user->ID);
            if ($guarantor2_staff_info['is_staff']) {
                $validation_result['warnings'][] = 'Guarantor 2 (' . $guarantor2_user->display_name . ') is also a staff member/officer. Committee review required for potential conflicts.';
            }
        }
    }
    
    // 3. Add staff loan processing notes
    $validation_result['staff_considerations'][] = 'This application is from a staff member and can be approved in CMC meeting in absence of applicant.';
    
    if ($staff_info['staff_type'] === 'office_bearer') {
        $validation_result['staff_considerations'][] = 'Applicant is an office bearer - special attention required per PRD Section 6.';
    }
    
    return $validation_result;
}

/**
 * Add staff loan hooks to existing functions
 */
function daystar_init_staff_loan_hooks() {
    // Hook into loan validation
    add_filter('daystar_loan_validation_result', 'daystar_enhance_loan_validation_for_staff', 10, 3);
    
    // Hook into loan status updates
    add_action('daystar_loan_status_updated', 'daystar_handle_staff_loan_status_update', 10, 4);
    
    // Hook into admin display
    add_filter('daystar_loan_admin_additional_info', 'daystar_add_staff_loan_admin_info', 10, 2);
}
add_action('init', 'daystar_init_staff_loan_hooks');

/**
 * Enhance loan validation for staff loans
 */
function daystar_enhance_loan_validation_for_staff($validation_result, $loan_data, $user_id) {
    $staff_validation = daystar_validate_staff_loan_application($loan_data, $user_id);
    
    // Merge validation results
    $validation_result['errors'] = array_merge($validation_result['errors'], $staff_validation['errors']);
    $validation_result['warnings'] = array_merge($validation_result['warnings'] ?? array(), $staff_validation['warnings']);
    $validation_result['staff_considerations'] = $staff_validation['staff_considerations'];
    
    return $validation_result;
}

/**
 * Handle staff loan status updates
 */
function daystar_handle_staff_loan_status_update($loan_id, $status, $admin_user_id, $notes) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d",
        $loan_id
    ));
    
    if ($loan && $loan->is_staff_loan) {
        daystar_log_staff_loan_decision($loan_id, $status, $admin_user_id, $notes);
        
        if ($status === 'approved') {
            daystar_send_staff_loan_approval_notification($loan_id);
        }
    }
}

/**
 * Add staff loan information to admin display
 */
function daystar_add_staff_loan_admin_info($additional_info, $loan) {
    if ($loan->is_staff_loan) {
        $staff_info = '<div class="staff-loan-badge">👥 STAFF LOAN</div>';
        
        if ($loan->staff_type) {
            $staff_info .= '<br><small style="color: #92400e;">Type: ' . esc_html(ucfirst(str_replace('_', ' ', $loan->staff_type))) . '</small>';
        }
        
        if ($loan->term_months > 36) {
            $staff_info .= '<br><small style="color: #16a34a; font-weight: bold;">Extended Term: ' . $loan->term_months . ' months</small>';
        }
        
        $additional_info .= $staff_info;
    }
    
    return $additional_info;
}

/**
 * Generate staff loan summary report
 */
function daystar_generate_staff_loan_summary() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $summary = array();
    
    // Total staff loans
    $summary['total_staff_loans'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE is_staff_loan = 1");
    
    // Active staff loans
    $summary['active_staff_loans'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE is_staff_loan = 1 AND status = 'active'");
    
    // Staff loans with extended terms
    $summary['extended_term_loans'] = $wpdb->get_var("SELECT COUNT(*) FROM {$loans_table} WHERE is_staff_loan = 1 AND term_months > 36");
    
    // Staff loan portfolio value
    $summary['staff_loan_portfolio'] = $wpdb->get_var("SELECT SUM(balance) FROM {$loans_table} WHERE is_staff_loan = 1 AND status IN ('active', 'disbursed')") ?: 0;
    
    // Staff loan types breakdown
    $staff_types = $wpdb->get_results("SELECT staff_type, COUNT(*) as count FROM {$loans_table} WHERE is_staff_loan = 1 GROUP BY staff_type");
    $summary['staff_types'] = array();
    
    foreach ($staff_types as $type) {
        $summary['staff_types'][$type->staff_type ?: 'general'] = $type->count;
    }
    
    return $summary;
}

/**
 * Display staff loan summary in admin dashboard
 */
function daystar_display_staff_loan_summary_widget() {
    $summary = daystar_generate_staff_loan_summary();
    
    ?>
    <div class="staff-loan-summary-widget" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
        <h3 style="margin-top: 0; color: #92400e;">👥 Staff Loan Summary</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
            <div class="summary-item">
                <div style="font-size: 1.5rem; font-weight: bold; color: #92400e;"><?php echo $summary['total_staff_loans']; ?></div>
                <div style="font-size: 0.9rem; color: #6b7280;">Total Staff Loans</div>
            </div>
            
            <div class="summary-item">
                <div style="font-size: 1.5rem; font-weight: bold; color: #059669;"><?php echo $summary['active_staff_loans']; ?></div>
                <div style="font-size: 0.9rem; color: #6b7280;">Active</div>
            </div>
            
            <div class="summary-item">
                <div style="font-size: 1.5rem; font-weight: bold; color: #1d4ed8;"><?php echo $summary['extended_term_loans']; ?></div>
                <div style="font-size: 0.9rem; color: #6b7280;">Extended Terms</div>
            </div>
            
            <div class="summary-item">
                <div style="font-size: 1.2rem; font-weight: bold; color: #dc2626;">KES <?php echo number_format($summary['staff_loan_portfolio'], 0); ?></div>
                <div style="font-size: 0.9rem; color: #6b7280;">Portfolio Value</div>
            </div>
        </div>
        
        <?php if (!empty($summary['staff_types'])) : ?>
            <div style="margin-top: 15px;">
                <h4 style="margin: 10px 0 5px 0; color: #374151;">Staff Types:</h4>
                <?php foreach ($summary['staff_types'] as $type => $count) : ?>
                    <span style="display: inline-block; background: #f3f4f6; padding: 4px 8px; border-radius: 4px; margin: 2px; font-size: 0.85rem;">
                        <?php echo esc_html(ucfirst(str_replace('_', ' ', $type))); ?>: <?php echo $count; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Add staff loan summary to admin dashboard
 */
function daystar_add_staff_loan_dashboard_widget() {
    $screen = get_current_screen();
    
    if (in_array($screen->id, ['toplevel_page_daystar-credit-committee', 'toplevel_page_daystar-loan-management'])) {
        add_action('admin_notices', 'daystar_display_staff_loan_summary_widget');
    }
}
add_action('current_screen', 'daystar_add_staff_loan_dashboard_widget');