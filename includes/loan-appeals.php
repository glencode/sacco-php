<?php
/**
 * Loan Appeals System
 * Implements PRD Section 5 - Loan Appeals Process
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Submit a loan appeal
 */
function daystar_submit_loan_appeal($loan_id, $user_id, $reason_for_appeal, $supporting_documents = '') {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    // Verify the loan exists and belongs to the user
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d AND user_id = %d",
        $loan_id,
        $user_id
    ));
    
    if (!$loan) {
        return array(
            'success' => false,
            'message' => 'Loan not found or you do not have permission to appeal this loan.'
        );
    }
    
    // Check if loan is eligible for appeal (must be rejected)
    if ($loan->status !== 'rejected') {
        return array(
            'success' => false,
            'message' => 'Only rejected loan applications can be appealed.'
        );
    }
    
    // Check if appeal already exists
    $existing_appeal = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$appeals_table} WHERE loan_id = %d",
        $loan_id
    ));
    
    if ($existing_appeal) {
        return array(
            'success' => false,
            'message' => 'An appeal has already been submitted for this loan application.'
        );
    }
    
    // Check if within appeal deadline (15 days from rejection)
    $rejection_date = $loan->approved_date; // Date when rejection was recorded
    $appeal_deadline = date('Y-m-d', strtotime($rejection_date . ' +15 days'));
    
    if (date('Y-m-d') > $appeal_deadline) {
        return array(
            'success' => false,
            'message' => 'Appeal deadline has passed. Appeals must be submitted within 15 days of loan rejection.'
        );
    }
    
    // Insert appeal record
    $result = $wpdb->insert(
        $appeals_table,
        array(
            'loan_id' => $loan_id,
            'user_id' => $user_id,
            'reason_for_appeal' => $reason_for_appeal,
            'supporting_documents' => $supporting_documents,
            'status' => 'pending',
            'appeal_deadline' => $appeal_deadline,
            'original_rejection_reason' => $loan->rejection_reason
        ),
        array('%d', '%d', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($result) {
        $appeal_id = $wpdb->insert_id;
        
        // Send notifications to chairmen
        daystar_notify_chairmen_of_appeal($appeal_id);
        
        // Send confirmation to member
        daystar_send_appeal_confirmation($user_id, $appeal_id);
        
        return array(
            'success' => true,
            'message' => 'Your appeal has been submitted successfully. You will be notified of the outcome.',
            'appeal_id' => $appeal_id
        );
    } else {
        return array(
            'success' => false,
            'message' => 'Failed to submit appeal. Please try again.'
        );
    }
}

/**
 * Get member's appealable loans
 */
function daystar_get_member_appealable_loans($user_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    // Get rejected loans that don't have appeals and are within appeal deadline
    $query = "
        SELECT l.*, 
               DATE_ADD(l.approved_date, INTERVAL 15 DAY) as appeal_deadline,
               DATEDIFF(DATE_ADD(l.approved_date, INTERVAL 15 DAY), CURDATE()) as days_remaining
        FROM {$loans_table} l
        LEFT JOIN {$appeals_table} a ON l.id = a.loan_id
        WHERE l.user_id = %d 
          AND l.status = 'rejected'
          AND a.id IS NULL
          AND DATE_ADD(l.approved_date, INTERVAL 15 DAY) >= CURDATE()
        ORDER BY l.approved_date DESC
    ";
    
    return $wpdb->get_results($wpdb->prepare($query, $user_id));
}

/**
 * Get member's appeal history
 */
function daystar_get_member_appeal_history($user_id) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $query = "
        SELECT a.*, l.loan_type, l.amount, l.purpose
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        WHERE a.user_id = %d
        ORDER BY a.appeal_date DESC
    ";
    
    return $wpdb->get_results($wpdb->prepare($query, $user_id));
}

/**
 * Get all appeals for admin review
 */
function daystar_get_all_appeals($status = 'all', $search = '') {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $users_table = $wpdb->users;
    
    $where_conditions = array("1=1");
    $where_values = array();
    
    if ($status !== 'all') {
        $where_conditions[] = "a.status = %s";
        $where_values[] = $status;
    }
    
    if ($search) {
        $where_conditions[] = "(u.display_name LIKE %s OR l.application_waiting_number LIKE %s)";
        $where_values[] = '%' . $search . '%';
        $where_values[] = '%' . $search . '%';
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $query = "
        SELECT a.*, 
               l.loan_type, l.amount, l.purpose, l.application_waiting_number,
               u.display_name as member_name,
               resolver.display_name as resolved_by_name
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        JOIN {$users_table} u ON a.user_id = u.ID
        LEFT JOIN {$users_table} resolver ON a.resolved_by_user_id = resolver.ID
        WHERE {$where_clause}
        ORDER BY a.appeal_date DESC
    ";
    
    if (!empty($where_values)) {
        $query = $wpdb->prepare($query, $where_values);
    }
    
    return $wpdb->get_results($query);
}

/**
 * Get appeal statistics
 */
function daystar_get_appeal_statistics() {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    $stats = array();
    
    // Total appeals
    $stats['total_appeals'] = $wpdb->get_var("SELECT COUNT(*) FROM {$appeals_table}");
    
    // Pending appeals
    $stats['pending_appeals'] = $wpdb->get_var("SELECT COUNT(*) FROM {$appeals_table} WHERE status = 'pending'");
    
    // Under review appeals
    $stats['under_review'] = $wpdb->get_var("SELECT COUNT(*) FROM {$appeals_table} WHERE status = 'under_review'");
    
    // Resolved appeals this month
    $stats['resolved_this_month'] = $wpdb->get_var("
        SELECT COUNT(*) FROM {$appeals_table} 
        WHERE status IN ('approved', 'rejected') 
        AND MONTH(resolved_date) = MONTH(CURRENT_DATE()) 
        AND YEAR(resolved_date) = YEAR(CURRENT_DATE())
    ");
    
    // Success rate
    $total_resolved = $wpdb->get_var("SELECT COUNT(*) FROM {$appeals_table} WHERE status IN ('approved', 'rejected')");
    $approved_appeals = $wpdb->get_var("SELECT COUNT(*) FROM {$appeals_table} WHERE status = 'approved'");
    
    $stats['success_rate'] = $total_resolved > 0 ? (($approved_appeals / $total_resolved) * 100) : 0;
    
    // Overdue appeals (pending for more than 30 days)
    $stats['overdue_appeals'] = $wpdb->get_var("
        SELECT COUNT(*) FROM {$appeals_table} 
        WHERE status = 'pending' 
        AND DATEDIFF(CURDATE(), appeal_date) > 30
    ");
    
    return $stats;
}

/**
 * Update appeal status
 */
function daystar_update_appeal_status($appeal_id, $new_status, $resolution_details = '', $admin_user_id = null) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $update_data = array(
        'status' => $new_status,
        'updated_at' => current_time('mysql')
    );
    
    if ($resolution_details) {
        $update_data['resolution_details'] = $resolution_details;
    }
    
    if (in_array($new_status, ['approved', 'rejected'])) {
        $update_data['resolved_by_user_id'] = $admin_user_id;
        $update_data['resolved_date'] = current_time('mysql');
    }
    
    $result = $wpdb->update(
        $appeals_table,
        $update_data,
        array('id' => $appeal_id),
        array('%s', '%s', '%s', '%d', '%s'),
        array('%d')
    );
    
    if ($result !== false) {
        // Get appeal details
        $appeal = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$appeals_table} WHERE id = %d",
            $appeal_id
        ));
        
        if ($appeal) {
            // If appeal is approved, update the original loan status
            if ($new_status === 'approved') {
                $wpdb->update(
                    $loans_table,
                    array(
                        'status' => 'approved',
                        'approved_by' => $admin_user_id,
                        'approved_date' => current_time('mysql'),
                        'application_notes' => 'Approved on appeal: ' . $resolution_details
                    ),
                    array('id' => $appeal->loan_id)
                );
                
                // Send loan approval notification
                daystar_send_loan_status_notification($appeal->loan_id, 'approved', 'Approved on appeal');
            }
            
            // Send appeal resolution notification
            daystar_send_appeal_resolution_notification($appeal_id, $new_status, $resolution_details);
            
            // Log the appeal resolution
            daystar_log_appeal_resolution($appeal_id, $new_status, $admin_user_id);
        }
        
        return true;
    }
    
    return false;
}

/**
 * Notify chairmen of new appeal
 */
function daystar_notify_chairmen_of_appeal($appeal_id) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    // Get appeal and loan details
    $appeal_data = $wpdb->get_row($wpdb->prepare("
        SELECT a.*, l.loan_type, l.amount, l.application_waiting_number, u.display_name as member_name
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        JOIN {$wpdb->users} u ON a.user_id = u.ID
        WHERE a.id = %d
    ", $appeal_id));
    
    if (!$appeal_data) return;
    
    // Get chairman user IDs (you would need to implement a way to identify chairmen)
    $chairmen = daystar_get_committee_chairmen();
    
    $title = 'New Loan Appeal Submitted';
    $message = sprintf(
        'A new loan appeal has been submitted by %s for loan application %s (KES %s). Please review the appeal in the admin dashboard.',
        $appeal_data->member_name,
        $appeal_data->application_waiting_number ?: 'APP-' . $appeal_data->loan_id,
        number_format($appeal_data->amount, 2)
    );
    
    foreach ($chairmen as $chairman_id) {
        $wpdb->insert(
            $notifications_table,
            array(
                'user_id' => $chairman_id,
                'title' => $title,
                'message' => $message,
                'type' => 'appeal'
            )
        );
    }
    
    // Also send email notifications if email system is available
    // daystar_send_email_notification($chairmen, $title, $message);
}

/**
 * Send appeal confirmation to member
 */
function daystar_send_appeal_confirmation($user_id, $appeal_id) {
    global $wpdb;
    
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    $title = 'Appeal Submitted Successfully';
    $message = 'Your loan appeal has been submitted successfully. The joint committee will review your appeal and you will be notified of the outcome within 30 days.';
    
    $wpdb->insert(
        $notifications_table,
        array(
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'type' => 'appeal'
        )
    );
}

/**
 * Send appeal resolution notification
 */
function daystar_send_appeal_resolution_notification($appeal_id, $status, $resolution_details) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    $appeal_data = $wpdb->get_row($wpdb->prepare("
        SELECT a.*, l.amount, l.loan_type
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        WHERE a.id = %d
    ", $appeal_id));
    
    if (!$appeal_data) return;
    
    $title = '';
    $message = '';
    
    switch ($status) {
        case 'approved':
            $title = 'Loan Appeal Approved';
            $message = sprintf(
                'Great news! Your loan appeal has been approved by the joint committee. Your original loan application for KES %s will now be processed for disbursement. Resolution: %s',
                number_format($appeal_data->amount, 2),
                $resolution_details
            );
            break;
            
        case 'rejected':
            $title = 'Loan Appeal Decision';
            $message = sprintf(
                'Your loan appeal has been reviewed by the joint committee. Unfortunately, the original decision has been upheld. Resolution: %s',
                $resolution_details
            );
            break;
    }
    
    if ($title && $message) {
        $wpdb->insert(
            $notifications_table,
            array(
                'user_id' => $appeal_data->user_id,
                'title' => $title,
                'message' => $message,
                'type' => 'appeal'
            )
        );
    }
}

/**
 * Log appeal resolution
 */
function daystar_log_appeal_resolution($appeal_id, $status, $admin_user_id) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $credit_history_table = $wpdb->prefix . 'daystar_credit_history';
    
    $appeal = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$appeals_table} WHERE id = %d",
        $appeal_id
    ));
    
    if (!$appeal) return;
    
    $description = "Loan appeal {$status}";
    $credit_impact = ($status === 'approved') ? 10 : 0;
    
    $wpdb->insert(
        $credit_history_table,
        array(
            'user_id' => $appeal->user_id,
            'loan_id' => $appeal->loan_id,
            'event_type' => 'appeal_resolution',
            'description' => $description,
            'credit_score_impact' => $credit_impact
        )
    );
}

/**
 * Get committee chairmen (placeholder - implement based on your user role system)
 */
function daystar_get_committee_chairmen() {
    // This should return user IDs of committee chairmen
    // Implementation depends on how you store user roles/positions
    
    $chairmen = array();
    
    // Get users with chairman roles
    $credit_chairman = get_users(array(
        'meta_key' => 'sacco_role',
        'meta_value' => 'credit_committee_chairman',
        'number' => 1
    ));
    
    $executive_chairman = get_users(array(
        'meta_key' => 'sacco_role',
        'meta_value' => 'executive_committee_chairman',
        'number' => 1
    ));
    
    if (!empty($credit_chairman)) {
        $chairmen[] = $credit_chairman[0]->ID;
    }
    
    if (!empty($executive_chairman)) {
        $chairmen[] = $executive_chairman[0]->ID;
    }
    
    // Fallback to admin users if no specific chairmen found
    if (empty($chairmen)) {
        $admins = get_users(array('role' => 'administrator', 'number' => 2));
        foreach ($admins as $admin) {
            $chairmen[] = $admin->ID;
        }
    }
    
    return $chairmen;
}

/**
 * Check if user can submit appeal for a loan
 */
function daystar_can_submit_appeal($loan_id, $user_id) {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    // Check if loan exists and belongs to user
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$loans_table} WHERE id = %d AND user_id = %d",
        $loan_id,
        $user_id
    ));
    
    if (!$loan || $loan->status !== 'rejected') {
        return false;
    }
    
    // Check if appeal already exists
    $existing_appeal = $wpdb->get_row($wpdb->prepare(
        "SELECT id FROM {$appeals_table} WHERE loan_id = %d",
        $loan_id
    ));
    
    if ($existing_appeal) {
        return false;
    }
    
    // Check if within appeal deadline
    $appeal_deadline = date('Y-m-d', strtotime($loan->approved_date . ' +15 days'));
    
    return date('Y-m-d') <= $appeal_deadline;
}

/**
 * Get appeal details by ID
 */
function daystar_get_appeal_details($appeal_id) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $query = "
        SELECT a.*, 
               l.loan_type, l.amount, l.purpose, l.application_waiting_number, l.interest_rate, l.term_months,
               u.display_name as member_name, u.user_email as member_email,
               resolver.display_name as resolved_by_name
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        JOIN {$wpdb->users} u ON a.user_id = u.ID
        LEFT JOIN {$wpdb->users} resolver ON a.resolved_by_user_id = resolver.ID
        WHERE a.id = %d
    ";
    
    return $wpdb->get_row($wpdb->prepare($query, $appeal_id));
}

/**
 * Schedule committee hearing for appeal
 */
function daystar_schedule_appeal_hearing($appeal_id, $hearing_date, $admin_user_id) {
    global $wpdb;
    
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    
    $result = $wpdb->update(
        $appeals_table,
        array(
            'committee_hearing_date' => $hearing_date,
            'status' => 'under_review'
        ),
        array('id' => $appeal_id),
        array('%s', '%s'),
        array('%d')
    );
    
    if ($result) {
        // Notify member of hearing date
        $appeal = daystar_get_appeal_details($appeal_id);
        if ($appeal) {
            daystar_send_hearing_notification($appeal, $hearing_date);
        }
    }
    
    return $result;
}

/**
 * Send hearing notification to member
 */
function daystar_send_hearing_notification($appeal, $hearing_date) {
    global $wpdb;
    
    $notifications_table = $wpdb->prefix . 'daystar_notifications';
    
    $title = 'Appeal Hearing Scheduled';
    $message = sprintf(
        'Your loan appeal hearing has been scheduled for %s. Please be available to present your case to the joint committee.',
        date('F j, Y \a\t g:i A', strtotime($hearing_date))
    );
    
    $wpdb->insert(
        $notifications_table,
        array(
            'user_id' => $appeal->user_id,
            'title' => $title,
            'message' => $message,
            'type' => 'appeal'
        )
    );
}

/**
 * AJAX handler for appeal submission
 */
function daystar_ajax_submit_loan_appeal() {
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to submit an appeal.');
        return;
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'submit_loan_appeal')) {
        wp_send_json_error('Security check failed.');
        return;
    }
    
    $loan_id = intval($_POST['loan_id']);
    $reason_for_appeal = sanitize_textarea_field($_POST['reason_for_appeal']);
    $user_id = get_current_user_id();
    
    $result = daystar_submit_loan_appeal($loan_id, $user_id, $reason_for_appeal);
    
    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        wp_send_json_error($result['message']);
    }
}
add_action('wp_ajax_submit_loan_appeal', 'daystar_ajax_submit_loan_appeal');

/**
 * AJAX handler for getting loan rejection reason
 */
function daystar_ajax_get_loan_rejection_reason() {
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in.');
        return;
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'get_loan_rejection_reason')) {
        wp_send_json_error('Security check failed.');
        return;
    }
    
    $loan_id = intval($_POST['loan_id']);
    $user_id = get_current_user_id();
    
    global $wpdb;
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $loan = $wpdb->get_row($wpdb->prepare(
        "SELECT rejection_reason FROM {$loans_table} WHERE id = %d AND user_id = %d",
        $loan_id,
        $user_id
    ));
    
    if ($loan) {
        wp_send_json_success($loan->rejection_reason ?: 'No specific reason provided.');
    } else {
        wp_send_json_error('Loan not found.');
    }
}
add_action('wp_ajax_get_loan_rejection_reason', 'daystar_ajax_get_loan_rejection_reason');

/**
 * AJAX handler for getting appeal details
 */
function daystar_ajax_get_appeal_details() {
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in.');
        return;
    }
    
    if (!wp_verify_nonce($_POST['nonce'], 'get_appeal_details')) {
        wp_send_json_error('Security check failed.');
        return;
    }
    
    $appeal_id = intval($_POST['appeal_id']);
    $user_id = get_current_user_id();
    
    global $wpdb;
    $appeals_table = $wpdb->prefix . 'daystar_loan_appeals';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $appeal = $wpdb->get_row($wpdb->prepare("
        SELECT a.*, l.loan_type, l.amount, l.purpose, l.application_waiting_number
        FROM {$appeals_table} a
        JOIN {$loans_table} l ON a.loan_id = l.id
        WHERE a.id = %d AND a.user_id = %d
    ", $appeal_id, $user_id));
    
    if (!$appeal) {
        wp_send_json_error('Appeal not found.');
        return;
    }
    
    ob_start();
    ?>
    <div class="appeal-details-content">
        <div class="detail-section">
            <h4>Appeal Information</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Appeal Date:</span>
                    <span class="detail-value"><?php echo date('F j, Y \a\t g:i A', strtotime($appeal->appeal_date)); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-<?php echo $appeal->status; ?>">
                            <?php echo strtoupper(str_replace('_', ' ', $appeal->status)); ?>
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Appeal Deadline:</span>
                    <span class="detail-value"><?php echo date('F j, Y', strtotime($appeal->appeal_deadline)); ?></span>
                </div>
            </div>
        </div>
        
        <div class="detail-section">
            <h4>Loan Application Details</h4>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Application Number:</span>
                    <span class="detail-value"><?php echo esc_html($appeal->application_waiting_number ?: 'APP-' . $appeal->loan_id); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Loan Type:</span>
                    <span class="detail-value"><?php echo esc_html(ucfirst(str_replace('_', ' ', $appeal->loan_type))); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Amount:</span>
                    <span class="detail-value">KES <?php echo number_format($appeal->amount, 2); ?></span>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <span class="detail-label">Purpose:</span>
                <div class="detail-value"><?php echo esc_html($appeal->purpose); ?></div>
            </div>
        </div>
        
        <div class="detail-section">
            <h4>Original Rejection</h4>
            <div class="detail-value">
                <?php echo esc_html($appeal->original_rejection_reason ?: 'No specific reason provided.'); ?>
            </div>
        </div>
        
        <div class="detail-section">
            <h4>Your Appeal Reason</h4>
            <div class="detail-value" style="white-space: pre-wrap; line-height: 1.6;">
                <?php echo esc_html($appeal->reason_for_appeal); ?>
            </div>
        </div>
        
        <?php if ($appeal->committee_hearing_date) : ?>
            <div class="detail-section">
                <h4>Committee Hearing</h4>
                <div class="detail-item">
                    <span class="detail-label">Hearing Date:</span>
                    <span class="detail-value"><?php echo date('F j, Y \a\t g:i A', strtotime($appeal->committee_hearing_date)); ?></span>
                </div>
                <?php if ($appeal->committee_notes) : ?>
                    <div style="margin-top: 10px;">
                        <span class="detail-label">Committee Notes:</span>
                        <div class="detail-value"><?php echo esc_html($appeal->committee_notes); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($appeal->resolution_details) : ?>
            <div class="detail-section">
                <h4>Resolution</h4>
                <div class="detail-item">
                    <span class="detail-label">Resolution Date:</span>
                    <span class="detail-value"><?php echo date('F j, Y', strtotime($appeal->resolved_date)); ?></span>
                </div>
                <div style="margin-top: 10px;">
                    <span class="detail-label">Resolution Details:</span>
                    <div class="detail-value"><?php echo esc_html($appeal->resolution_details); ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
    .appeal-details-content {
        font-size: 0.95rem;
    }
    
    .detail-section {
        margin-bottom: 25px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 4px solid #1d4ed8;
    }
    
    .detail-section h4 {
        margin: 0 0 15px 0;
        color: #1d4ed8;
        font-size: 1.1rem;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-label {
        font-weight: bold;
        color: #374151;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .detail-value {
        color: #6b7280;
        line-height: 1.4;
    }
    </style>
    <?php
    
    $html = ob_get_clean();
    wp_send_json_success($html);
}
add_action('wp_ajax_get_appeal_details', 'daystar_ajax_get_appeal_details');