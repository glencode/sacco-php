<?php
/**
 * Daystar Loan Application Functions
 *
 * Handles loan application functionality and processing
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the action to handle loan application form submission
 */
function daystar_loan_application_actions() {
    add_action('wp_ajax_daystar_submit_loan_application', 'daystar_process_loan_application');
}
add_action('init', 'daystar_loan_application_actions');

/**
 * Process the loan application form
 */
function daystar_process_loan_application() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to apply for a loan.');
        exit;
    }
    
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'daystar_loan_application_nonce')) {
        wp_send_json_error('Security check failed. Please refresh the page and try again.');
        exit;
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Check if user is a member
    if (!in_array('member', $current_user->roles)) {
        wp_send_json_error('Only members can apply for loans.');
        exit;
    }
    
    // Check if member is active
    $member_status = get_user_meta($user_id, 'member_status', true);
    if ($member_status !== 'active') {
        wp_send_json_error('Your membership must be active to apply for a loan.');
        exit;
    }
    
    // Collect and sanitize form data
    $loan_type = isset($_POST['loan_type']) ? sanitize_text_field($_POST['loan_type']) : '';
    $loan_amount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0;
    $loan_term = isset($_POST['loan_term']) ? intval($_POST['loan_term']) : 0;
    $loan_purpose = isset($_POST['loan_purpose']) ? sanitize_textarea_field($_POST['loan_purpose']) : '';
    
    // Guarantor 1
    $guarantor1_member_no = isset($_POST['guarantor1_member_no']) ? sanitize_text_field($_POST['guarantor1_member_no']) : '';
    $guarantor1_name = isset($_POST['guarantor1_name']) ? sanitize_text_field($_POST['guarantor1_name']) : '';
    $guarantor1_phone = isset($_POST['guarantor1_phone']) ? sanitize_text_field($_POST['guarantor1_phone']) : '';
    $guarantor1_amount = isset($_POST['guarantor1_amount']) ? floatval($_POST['guarantor1_amount']) : 0;
    
    // Guarantor 2
    $guarantor2_member_no = isset($_POST['guarantor2_member_no']) ? sanitize_text_field($_POST['guarantor2_member_no']) : '';
    $guarantor2_name = isset($_POST['guarantor2_name']) ? sanitize_text_field($_POST['guarantor2_name']) : '';
    $guarantor2_phone = isset($_POST['guarantor2_phone']) ? sanitize_text_field($_POST['guarantor2_phone']) : '';
    $guarantor2_amount = isset($_POST['guarantor2_amount']) ? floatval($_POST['guarantor2_amount']) : 0;
    
    // Validate required fields
    $errors = array();
    
    if (empty($loan_type)) $errors[] = 'Loan type is required.';
    
    if ($loan_amount <= 0) {
        $errors[] = 'Loan amount must be greater than zero.';
    } else {
        // Check loan amount against eligibility
        $max_loan_amount = daystar_calculate_loan_eligibility($user_id);
        if ($loan_amount > $max_loan_amount) {
            $errors[] = 'The requested loan amount exceeds your eligibility. Maximum eligible amount is KES ' . number_format($max_loan_amount, 2) . '.';
        }
        
        // Check minimum and maximum loan amounts based on loan type
        $min_amount = daystar_get_loan_min_amount($loan_type);
        $max_amount = daystar_get_loan_max_amount($loan_type);
        
        if ($loan_amount < $min_amount) {
            $errors[] = 'The minimum loan amount for this loan type is KES ' . number_format($min_amount, 2) . '.';
        }
        
        if ($loan_amount > $max_amount) {
            $errors[] = 'The maximum loan amount for this loan type is KES ' . number_format($max_amount, 2) . '.';
        }
    }
    
    if ($loan_term <= 0) $errors[] = 'Loan term is required.';
    if (empty($loan_purpose)) $errors[] = 'Loan purpose is required.';
    
    // Validate guarantors
    if (empty($guarantor1_member_no)) $errors[] = 'Guarantor 1 member number is required.';
    if (empty($guarantor1_name)) $errors[] = 'Guarantor 1 name is required.';
    if (empty($guarantor1_phone)) $errors[] = 'Guarantor 1 phone number is required.';
    if ($guarantor1_amount <= 0) $errors[] = 'Guarantor 1 amount must be greater than zero.';
    
    if (empty($guarantor2_member_no)) $errors[] = 'Guarantor 2 member number is required.';
    if (empty($guarantor2_name)) $errors[] = 'Guarantor 2 name is required.';
    if (empty($guarantor2_phone)) $errors[] = 'Guarantor 2 phone number is required.';
    if ($guarantor2_amount <= 0) $errors[] = 'Guarantor 2 amount must be greater than zero.';
    
    // Check if guarantor amounts cover the loan amount
    $total_guaranteed = $guarantor1_amount + $guarantor2_amount;
    if ($total_guaranteed < $loan_amount) {
        $errors[] = 'The total guaranteed amount must be at least equal to the loan amount.';
    }
    
    // Check if member has existing loans
    $existing_loans = daystar_get_member_active_loans($user_id);
    $has_active_loans = !empty($existing_loans);
    
    // Check loan policy for multiple loans
    if ($has_active_loans) {
        // Check if member is eligible for another loan based on policy
        $eligible_for_multiple = daystar_check_multiple_loan_eligibility($user_id, $loan_type);
        
        if (!$eligible_for_multiple) {
            $errors[] = 'You have existing active loans. According to our policy, you must clear your current loans before applying for a new one.';
        }
    }
    
    // If there are errors, return them
    if (!empty($errors)) {
        wp_send_json_error(array('errors' => $errors));
        exit;
    }
    
    // Calculate loan details
    $interest_rate = daystar_get_loan_interest_rate($loan_type);
    $monthly_payment = daystar_calculate_monthly_payment($loan_amount, $interest_rate, $loan_term);
    
    // Generate a unique loan application ID
    $loan_application_id = 'LA' . date('Ymd') . str_pad(wp_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
    // Save loan application
    $loan_application = array(
        'loan_application_id' => $loan_application_id,
        'user_id' => $user_id,
        'loan_type' => $loan_type,
        'loan_amount' => $loan_amount,
        'loan_term' => $loan_term,
        'interest_rate' => $interest_rate,
        'monthly_payment' => $monthly_payment,
        'loan_purpose' => $loan_purpose,
        'guarantor1_member_no' => $guarantor1_member_no,
        'guarantor1_name' => $guarantor1_name,
        'guarantor1_phone' => $guarantor1_phone,
        'guarantor1_amount' => $guarantor1_amount,
        'guarantor2_member_no' => $guarantor2_member_no,
        'guarantor2_name' => $guarantor2_name,
        'guarantor2_phone' => $guarantor2_phone,
        'guarantor2_amount' => $guarantor2_amount,
        'application_date' => current_time('mysql'),
        'status' => 'pending',
    );
    
    // In a real implementation, this would be saved to a database table
    // For now, we'll save it as user meta for demonstration purposes
    $applications = get_user_meta($user_id, 'loan_applications', true);
    if (!is_array($applications)) {
        $applications = array();
    }
    $applications[$loan_application_id] = $loan_application;
    update_user_meta($user_id, 'loan_applications', $applications);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New Loan Application: ' . $loan_application_id;
    $message = "A new loan application has been submitted:\n\n";
    $message .= "Application ID: $loan_application_id\n";
    $message .= "Member: {$current_user->display_name} ({$current_user->user_email})\n";
    $message .= "Loan Type: $loan_type\n";
    $message .= "Amount: KES " . number_format($loan_amount, 2) . "\n";
    $message .= "Term: $loan_term months\n\n";
    $message .= "Please login to the admin dashboard to review this application.";
    
    wp_mail($admin_email, $subject, $message);
    
    // Send confirmation email to member
    $subject = 'Loan Application Received - ' . $loan_application_id;
    $message = "Dear {$current_user->first_name},\n\n";
    $message .= "Your loan application has been received and is being processed.\n\n";
    $message .= "Application ID: $loan_application_id\n";
    $message .= "Loan Type: $loan_type\n";
    $message .= "Amount: KES " . number_format($loan_amount, 2) . "\n";
    $message .= "Term: $loan_term months\n";
    $message .= "Monthly Payment: KES " . number_format($monthly_payment, 2) . "\n\n";
    $message .= "You will be notified once your application has been reviewed.\n\n";
    $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
    
    wp_mail($current_user->user_email, $subject, $message);
    
    // Return success response
    wp_send_json_success(array(
        'message' => 'Your loan application has been submitted successfully.',
        'application_id' => $loan_application_id,
        'redirect_url' => home_url('/member-dashboard/?tab=loans')
    ));
    exit;
}

/**
 * Calculate loan eligibility for a member
 */
function daystar_calculate_loan_eligibility($user_id) {
    // Get member's total contributions
    $total_contributions = daystar_get_member_total_contributions($user_id);
    
    // According to credit policy, members can borrow up to 3 times their total contributions
    $max_loan_amount = $total_contributions * 3;
    
    // Cap the maximum loan amount based on policy
    $absolute_max = 1000000; // 1 million KES
    if ($max_loan_amount > $absolute_max) {
        $max_loan_amount = $absolute_max;
    }
    
    return $max_loan_amount;
}

/**
 * Get member's total contributions
 */
function daystar_get_member_total_contributions($user_id) {
    // In a real implementation, this would query a database table
    // For now, we'll return a sample value for demonstration purposes
    return 75000; // 75,000 KES
}

/**
 * Get minimum loan amount based on loan type
 */
function daystar_get_loan_min_amount($loan_type) {
    $min_amounts = array(
        'development' => 50000,
        'emergency' => 10000,
        'school-fees' => 20000,
        'business' => 100000
    );
    
    return isset($min_amounts[$loan_type]) ? $min_amounts[$loan_type] : 10000;
}

/**
 * Get maximum loan amount based on loan type
 */
function daystar_get_loan_max_amount($loan_type) {
    $max_amounts = array(
        'development' => 500000,
        'emergency' => 100000,
        'school-fees' => 200000,
        'business' => 1000000
    );
    
    return isset($max_amounts[$loan_type]) ? $max_amounts[$loan_type] : 500000;
}

/**
 * Get loan interest rate based on loan type
 */
function daystar_get_loan_interest_rate($loan_type) {
    $interest_rates = array(
        'development' => 12, // 12% per annum
        'emergency' => 10,   // 10% per annum
        'school-fees' => 8,  // 8% per annum
        'business' => 14     // 14% per annum
    );
    
    return isset($interest_rates[$loan_type]) ? $interest_rates[$loan_type] : 12;
}

/**
 * Calculate monthly loan payment
 */
function daystar_calculate_monthly_payment($principal, $annual_interest_rate, $term_months) {
    // Convert annual interest rate to monthly
    $monthly_interest_rate = ($annual_interest_rate / 100) / 12;
    
    // Calculate monthly payment using the formula: P * r * (1+r)^n / ((1+r)^n - 1)
    $monthly_payment = $principal * $monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months) / (pow(1 + $monthly_interest_rate, $term_months) - 1);
    
    return round($monthly_payment, 2);
}

/**
 * Get member's active loans
 */
function daystar_get_member_active_loans($user_id) {
    // In a real implementation, this would query a database table
    // For now, we'll return sample data for demonstration purposes
    $active_loans = array(
        array(
            'id' => 'L2025001',
            'type' => 'Development Loan',
            'amount' => 100000,
            'date_issued' => '2025-01-15',
            'term' => 24,
            'interest_rate' => 12,
            'monthly_payment' => 4707.35,
            'balance' => 75000,
            'status' => 'active'
        ),
        array(
            'id' => 'L2024050',
            'type' => 'Emergency Loan',
            'amount' => 50000,
            'date_issued' => '2024-10-05',
            'term' => 12,
            'interest_rate' => 10,
            'monthly_payment' => 4387.50,
            'balance' => 25000,
            'status' => 'active'
        )
    );
    
    return $active_loans;
}

/**
 * Check if member is eligible for multiple loans
 */
function daystar_check_multiple_loan_eligibility($user_id, $new_loan_type) {
    // Get member's active loans
    $active_loans = daystar_get_member_active_loans($user_id);
    
    // Check if member has any active loans
    if (empty($active_loans)) {
        return true;
    }
    
    // Check if member has good repayment history
    $good_repayment_history = daystar_check_repayment_history($user_id);
    if (!$good_repayment_history) {
        return false;
    }
    
    // Check if member has sufficient contribution balance
    $total_contributions = daystar_get_member_total_contributions($user_id);
    
    // Calculate total outstanding loan balance
    $total_outstanding = 0;
    foreach ($active_loans as $loan) {
        $total_outstanding += $loan['balance'];
    }
    
    // According to policy, total loans should not exceed 3 times contributions
    $max_allowed = $total_contributions * 3;
    
    // Check if new loan would exceed the maximum allowed
    $new_loan_amount = daystar_get_loan_min_amount($new_loan_type);
    if (($total_outstanding + $new_loan_amount) > $max_allowed) {
        return false;
    }
    
    // Check if emergency loan is being requested
    if ($new_loan_type === 'emergency') {
        // Emergency loans may be allowed even with existing loans
        return true;
    }
    
    // Check loan type restrictions
    foreach ($active_loans as $loan) {
        // If member already has a development loan, they can't get another one
        if ($loan['type'] === 'Development Loan' && $new_loan_type === 'development') {
            return false;
        }
        
        // If member already has a business loan, they can't get another one
        if ($loan['type'] === 'Business Loan' && $new_loan_type === 'business') {
            return false;
        }
    }
    
    return true;
}

/**
 * Check member's loan repayment history
 */
function daystar_check_repayment_history($user_id) {
    // In a real implementation, this would query a database table
    // For now, we'll return true for demonstration purposes
    return true;
}

/**
 * Add loan application admin page
 */
function daystar_add_loan_application_menu() {
    add_menu_page(
        'Loan Applications',
        'Loan Applications',
        'manage_options',
        'daystar-loan-applications',
        'daystar_loan_applications_page',
        'dashicons-money-alt',
        30
    );
}
add_action('admin_menu', 'daystar_add_loan_application_menu');

/**
 * Render loan applications admin page
 */
function daystar_loan_applications_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get all loan applications
    $applications = daystar_get_all_loan_applications();
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="filter-status">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="disbursed">Disbursed</option>
                </select>
                <input type="submit" id="filter-submit" class="button" value="Filter">
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Member</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Term</th>
                    <th>Application Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applications)) : ?>
                    <?php foreach ($applications as $application) : ?>
                        <tr>
                            <td><?php echo esc_html($application['loan_application_id']); ?></td>
                            <td>
                                <?php 
                                $user = get_user_by('id', $application['user_id']);
                                echo esc_html($user->display_name);
                                ?>
                            </td>
                            <td><?php echo esc_html(ucfirst($application['loan_type'])); ?> Loan</td>
                            <td>KES <?php echo number_format($application['loan_amount'], 2); ?></td>
                            <td><?php echo esc_html($application['loan_term']); ?> months</td>
                            <td><?php echo date('M j, Y', strtotime($application['application_date'])); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($application['status']); ?>">
                                    <?php echo ucfirst(esc_html($application['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="button view-application" data-id="<?php echo esc_attr($application['loan_application_id']); ?>">View</a>
                                
                                <?php if ($application['status'] === 'pending') : ?>
                                    <a href="#" class="button approve-application" data-id="<?php echo esc_attr($application['loan_application_id']); ?>">Approve</a>
                                    <a href="#" class="button reject-application" data-id="<?php echo esc_attr($application['loan_application_id']); ?>">Reject</a>
                                <?php endif; ?>
                                
                                <?php if ($application['status'] === 'approved') : ?>
                                    <a href="#" class="button disburse-loan" data-id="<?php echo esc_attr($application['loan_application_id']); ?>">Disburse</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No loan applications found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Application Details Modal -->
    <div id="application-details-modal" style="display: none;">
        <div class="application-details-content">
            <h2>Loan Application Details</h2>
            <div id="application-details-body"></div>
            <div class="application-details-footer">
                <button class="button close-modal">Close</button>
            </div>
        </div>
    </div>
    
    <style>
        .status-pending {
            color: #f0ad4e;
            font-weight: bold;
        }
        .status-approved {
            color: #5cb85c;
            font-weight: bold;
        }
        .status-rejected {
            color: #d9534f;
            font-weight: bold;
        }
        .status-disbursed {
            color: #5bc0de;
            font-weight: bold;
        }
        #application-details-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
        .application-details-content {
            position: relative;
            background-color: #fff;
            margin: 50px auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .close-modal {
            margin-top: 20px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Filter applications
        $('#filter-submit').on('click', function() {
            var status = $('#filter-status').val();
            // In a real implementation, this would reload the page with a status filter
            // For now, we'll just show/hide rows
            if (status) {
                $('tbody tr').hide();
                $('tbody tr').each(function() {
                    if ($(this).find('td:nth-child(7) span').hasClass('status-' + status)) {
                        $(this).show();
                    }
                });
            } else {
                $('tbody tr').show();
            }
        });
        
        // View application details
        $('.view-application').on('click', function(e) {
            e.preventDefault();
            var applicationId = $(this).data('id');
            
            // In a real implementation, this would make an AJAX request to get application details
            // For now, we'll just show a sample modal
            $('#application-details-body').html('<p>Loading application details...</p>');
            $('#application-details-modal').show();
            
            // Simulate AJAX request
            setTimeout(function() {
                var detailsHtml = '<div class="application-details">';
                detailsHtml += '<h3>Application ID: ' + applicationId + '</h3>';
                detailsHtml += '<div class="application-section">';
                detailsHtml += '<h4>Member Information</h4>';
                detailsHtml += '<p><strong>Name:</strong> John Doe</p>';
                detailsHtml += '<p><strong>Member Number:</strong> DST00123</p>';
                detailsHtml += '<p><strong>Email:</strong> john.doe@example.com</p>';
                detailsHtml += '<p><strong>Phone:</strong> +254712345678</p>';
                detailsHtml += '</div>';
                
                detailsHtml += '<div class="application-section">';
                detailsHtml += '<h4>Loan Details</h4>';
                detailsHtml += '<p><strong>Loan Type:</strong> Development Loan</p>';
                detailsHtml += '<p><strong>Amount:</strong> KES 100,000.00</p>';
                detailsHtml += '<p><strong>Term:</strong> 24 months</p>';
                detailsHtml += '<p><strong>Interest Rate:</strong> 12% per annum</p>';
                detailsHtml += '<p><strong>Monthly Payment:</strong> KES 4,707.35</p>';
                detailsHtml += '<p><strong>Purpose:</strong> Home renovation and improvements</p>';
                detailsHtml += '</div>';
                
                detailsHtml += '<div class="application-section">';
                detailsHtml += '<h4>Guarantors</h4>';
                detailsHtml += '<h5>Guarantor 1</h5>';
                detailsHtml += '<p><strong>Name:</strong> Jane Smith</p>';
                detailsHtml += '<p><strong>Member Number:</strong> DST00456</p>';
                detailsHtml += '<p><strong>Phone:</strong> +254723456789</p>';
                detailsHtml += '<p><strong>Amount Guaranteed:</strong> KES 60,000.00</p>';
                
                detailsHtml += '<h5>Guarantor 2</h5>';
                detailsHtml += '<p><strong>Name:</strong> Robert Johnson</p>';
                detailsHtml += '<p><strong>Member Number:</strong> DST00789</p>';
                detailsHtml += '<p><strong>Phone:</strong> +254734567890</p>';
                detailsHtml += '<p><strong>Amount Guaranteed:</strong> KES 40,000.00</p>';
                detailsHtml += '</div>';
                
                detailsHtml += '</div>';
                
                $('#application-details-body').html(detailsHtml);
            }, 500);
        });
        
        // Close modal
        $('.close-modal').on('click', function() {
            $('#application-details-modal').hide();
        });
        
        // Approve application
        $('.approve-application').on('click', function(e) {
            e.preventDefault();
            var applicationId = $(this).data('id');
            
            if (confirm('Are you sure you want to approve this loan application?')) {
                // In a real implementation, this would make an AJAX request to approve the application
                alert('Loan application ' + applicationId + ' has been approved.');
                // Refresh the page
                location.reload();
            }
        });
        
        // Reject application
        $('.reject-application').on('click', function(e) {
            e.preventDefault();
            var applicationId = $(this).data('id');
            
            if (confirm('Are you sure you want to reject this loan application?')) {
                // In a real implementation, this would make an AJAX request to reject the application
                alert('Loan application ' + applicationId + ' has been rejected.');
                // Refresh the page
                location.reload();
            }
        });
        
        // Disburse loan
        $('.disburse-loan').on('click', function(e) {
            e.preventDefault();
            var applicationId = $(this).data('id');
            
            if (confirm('Are you sure you want to disburse this loan?')) {
                // In a real implementation, this would make an AJAX request to disburse the loan
                alert('Loan ' + applicationId + ' has been disbursed.');
                // Refresh the page
                location.reload();
            }
        });
    });
    </script>
    <?php
}

/**
 * Get all loan applications
 */
function daystar_get_all_loan_applications() {
    // In a real implementation, this would query a database table
    // For now, we'll return sample data for demonstration purposes
    $applications = array(
        array(
            'loan_application_id' => 'LA20250601001',
            'user_id' => 1,
            'loan_type' => 'development',
            'loan_amount' => 150000,
            'loan_term' => 24,
            'interest_rate' => 12,
            'monthly_payment' => 7061.03,
            'loan_purpose' => 'Home renovation',
            'guarantor1_member_no' => 'DST00456',
            'guarantor1_name' => 'Jane Smith',
            'guarantor1_phone' => '+254723456789',
            'guarantor1_amount' => 90000,
            'guarantor2_member_no' => 'DST00789',
            'guarantor2_name' => 'Robert Johnson',
            'guarantor2_phone' => '+254734567890',
            'guarantor2_amount' => 60000,
            'application_date' => '2025-06-01 09:30:45',
            'status' => 'pending',
        ),
        array(
            'loan_application_id' => 'LA20250531002',
            'user_id' => 2,
            'loan_type' => 'emergency',
            'loan_amount' => 50000,
            'loan_term' => 12,
            'interest_rate' => 10,
            'monthly_payment' => 4387.50,
            'loan_purpose' => 'Medical expenses',
            'guarantor1_member_no' => 'DST00123',
            'guarantor1_name' => 'John Doe',
            'guarantor1_phone' => '+254712345678',
            'guarantor1_amount' => 30000,
            'guarantor2_member_no' => 'DST00456',
            'guarantor2_name' => 'Jane Smith',
            'guarantor2_phone' => '+254723456789',
            'guarantor2_amount' => 20000,
            'application_date' => '2025-05-31 14:15:22',
            'status' => 'approved',
        ),
        array(
            'loan_application_id' => 'LA20250530003',
            'user_id' => 3,
            'loan_type' => 'business',
            'loan_amount' => 300000,
            'loan_term' => 36,
            'interest_rate' => 14,
            'monthly_payment' => 10261.35,
            'loan_purpose' => 'Business expansion',
            'guarantor1_member_no' => 'DST00789',
            'guarantor1_name' => 'Robert Johnson',
            'guarantor1_phone' => '+254734567890',
            'guarantor1_amount' => 150000,
            'guarantor2_member_no' => 'DST00123',
            'guarantor2_name' => 'John Doe',
            'guarantor2_phone' => '+254712345678',
            'guarantor2_amount' => 150000,
            'application_date' => '2025-05-30 11:05:33',
            'status' => 'rejected',
        ),
        array(
            'loan_application_id' => 'LA20250529004',
            'user_id' => 4,
            'loan_type' => 'school-fees',
            'loan_amount' => 80000,
            'loan_term' => 12,
            'interest_rate' => 8,
            'monthly_payment' => 6933.33,
            'loan_purpose' => 'University tuition',
            'guarantor1_member_no' => 'DST00456',
            'guarantor1_name' => 'Jane Smith',
            'guarantor1_phone' => '+254723456789',
            'guarantor1_amount' => 40000,
            'guarantor2_member_no' => 'DST00789',
            'guarantor2_name' => 'Robert Johnson',
            'guarantor2_phone' => '+254734567890',
            'guarantor2_amount' => 40000,
            'application_date' => '2025-05-29 16:45:10',
            'status' => 'disbursed',
        ),
    );
    
    return $applications;
}

/**
 * Add loan calculator shortcode
 */
function daystar_loan_calculator_shortcode() {
    ob_start();
    ?>
    <div class="loan-calculator">
        <h3>Loan Calculator</h3>
        <div class="calculator-form">
            <div class="form-group">
                <label for="calc-loan-amount">Loan Amount (KES)</label>
                <input type="number" id="calc-loan-amount" class="form-control" value="100000" min="10000" max="1000000">
            </div>
            
            <div class="form-group">
                <label for="calc-loan-term">Loan Term (Months)</label>
                <select id="calc-loan-term" class="form-control">
                    <option value="6">6 months</option>
                    <option value="12">12 months</option>
                    <option value="18">18 months</option>
                    <option value="24" selected>24 months</option>
                    <option value="36">36 months</option>
                    <option value="48">48 months</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="calc-interest-rate">Interest Rate (% per annum)</label>
                <select id="calc-interest-rate" class="form-control">
                    <option value="8">8% - School Fees Loan</option>
                    <option value="10">10% - Emergency Loan</option>
                    <option value="12" selected>12% - Development Loan</option>
                    <option value="14">14% - Business Loan</option>
                </select>
            </div>
            
            <button type="button" id="calculate-loan" class="btn btn-primary">Calculate</button>
        </div>
        
        <div class="calculator-results" style="display: none;">
            <h4>Loan Summary</h4>
            <table class="table">
                <tr>
                    <th>Monthly Payment:</th>
                    <td id="result-monthly-payment">KES 0.00</td>
                </tr>
                <tr>
                    <th>Total Payment:</th>
                    <td id="result-total-payment">KES 0.00</td>
                </tr>
                <tr>
                    <th>Total Interest:</th>
                    <td id="result-total-interest">KES 0.00</td>
                </tr>
            </table>
            
            <div class="amortization-schedule-toggle">
                <button type="button" id="show-schedule" class="btn btn-outline-primary btn-sm">Show Repayment Schedule</button>
            </div>
            
            <div class="amortization-schedule" style="display: none;">
                <h5>Repayment Schedule</h5>
                <div class="table-responsive">
                    <table class="table table-sm" id="amortization-table">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Payment Amount</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#calculate-loan').on('click', function() {
            var loanAmount = parseFloat($('#calc-loan-amount').val());
            var loanTerm = parseInt($('#calc-loan-term').val());
            var interestRate = parseFloat($('#calc-interest-rate').val());
            
            if (isNaN(loanAmount) || loanAmount <= 0) {
                alert('Please enter a valid loan amount.');
                return;
            }
            
            // Calculate monthly payment
            var monthlyRate = (interestRate / 100) / 12;
            var monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
            var totalPayment = monthlyPayment * loanTerm;
            var totalInterest = totalPayment - loanAmount;
            
            // Display results
            $('#result-monthly-payment').text('KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#result-total-payment').text('KES ' + totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#result-total-interest').text('KES ' + totalInterest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            
            $('.calculator-results').show();
            
            // Generate amortization schedule
            var balance = loanAmount;
            var schedule = '';
            
            for (var i = 1; i <= loanTerm; i++) {
                var interest = balance * monthlyRate;
                var principal = monthlyPayment - interest;
                balance -= principal;
                
                if (balance < 0) balance = 0;
                
                schedule += '<tr>';
                schedule += '<td>' + i + '</td>';
                schedule += '<td>KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>';
                schedule += '<td>KES ' + principal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>';
                schedule += '<td>KES ' + interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>';
                schedule += '<td>KES ' + balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>';
                schedule += '</tr>';
            }
            
            $('#amortization-table tbody').html(schedule);
        });
        
        $('#show-schedule').on('click', function() {
            $('.amortization-schedule').toggle();
            $(this).text(function(i, text) {
                return text === "Show Repayment Schedule" ? "Hide Repayment Schedule" : "Show Repayment Schedule";
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('loan_calculator', 'daystar_loan_calculator_shortcode');

/**
 * Add loan types admin page
 */
function daystar_add_loan_types_menu() {
    add_submenu_page(
        'daystar-loan-applications',
        'Loan Types',
        'Loan Types',
        'manage_options',
        'daystar-loan-types',
        'daystar_loan_types_page'
    );
}
add_action('admin_menu', 'daystar_add_loan_types_menu');

/**
 * Render loan types admin page
 */
function daystar_loan_types_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get all loan types
    $loan_types = daystar_get_loan_types();
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="#" class="button button-primary add-loan-type">Add New Loan Type</a>
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Loan Type</th>
                    <th>Interest Rate</th>
                    <th>Min Amount</th>
                    <th>Max Amount</th>
                    <th>Min Term</th>
                    <th>Max Term</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($loan_types)) : ?>
                    <?php foreach ($loan_types as $type) : ?>
                        <tr>
                            <td><?php echo esc_html(ucfirst($type['name'])); ?> Loan</td>
                            <td><?php echo esc_html($type['interest_rate']); ?>% p.a.</td>
                            <td>KES <?php echo number_format($type['min_amount'], 2); ?></td>
                            <td>KES <?php echo number_format($type['max_amount'], 2); ?></td>
                            <td><?php echo esc_html($type['min_term']); ?> months</td>
                            <td><?php echo esc_html($type['max_term']); ?> months</td>
                            <td>
                                <span class="status-<?php echo $type['active'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $type['active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="#" class="button edit-loan-type" data-id="<?php echo esc_attr($type['id']); ?>">Edit</a>
                                <a href="#" class="button <?php echo $type['active'] ? 'deactivate-loan-type' : 'activate-loan-type'; ?>" data-id="<?php echo esc_attr($type['id']); ?>">
                                    <?php echo $type['active'] ? 'Deactivate' : 'Activate'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No loan types found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <style>
        .status-active {
            color: #5cb85c;
            font-weight: bold;
        }
        .status-inactive {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
    <?php
}

/**
 * Get all loan types
 */
function daystar_get_loan_types() {
    // In a real implementation, this would query a database table
    // For now, we'll return sample data for demonstration purposes
    $loan_types = array(
        array(
            'id' => 'development',
            'name' => 'development',
            'interest_rate' => 12,
            'min_amount' => 50000,
            'max_amount' => 500000,
            'min_term' => 6,
            'max_term' => 48,
            'active' => true
        ),
        array(
            'id' => 'emergency',
            'name' => 'emergency',
            'interest_rate' => 10,
            'min_amount' => 10000,
            'max_amount' => 100000,
            'min_term' => 3,
            'max_term' => 12,
            'active' => true
        ),
        array(
            'id' => 'school-fees',
            'name' => 'school-fees',
            'interest_rate' => 8,
            'min_amount' => 20000,
            'max_amount' => 200000,
            'min_term' => 3,
            'max_term' => 12,
            'active' => true
        ),
        array(
            'id' => 'business',
            'name' => 'business',
            'interest_rate' => 14,
            'min_amount' => 100000,
            'max_amount' => 1000000,
            'min_term' => 12,
            'max_term' => 60,
            'active' => true
        )
    );
    
    return $loan_types;
}
