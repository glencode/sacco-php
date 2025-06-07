<?php
/**
 * Daystar Loan Management Admin Functions
 *
 * Handles loan management in the admin area
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the loan management admin page
 */
function daystar_render_admin_loans_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get current filter/status
    $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
    
    // Handle actions
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'view':
                if (isset($_GET['id'])) {
                    daystar_render_loan_details_page(intval($_GET['id']));
                    return;
                }
                break;
            case 'approve':
                if (isset($_GET['id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'approve_loan_' . $_GET['id'])) {
                    daystar_approve_loan(intval($_GET['id']));
                    wp_redirect(admin_url('admin.php?page=daystar-admin-loans&status=pending&approved=1'));
                    exit;
                }
                break;
            case 'reject':
                if (isset($_GET['id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'reject_loan_' . $_GET['id'])) {
                    daystar_reject_loan(intval($_GET['id']));
                    wp_redirect(admin_url('admin.php?page=daystar-admin-loans&status=pending&rejected=1'));
                    exit;
                }
                break;
        }
    }
    
    // Get loans based on status
    $loans = daystar_get_loans_by_status($status);
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Loan Applications</h1>
        <hr class="wp-header-end">
        
        <?php
        // Show status messages
        if (isset($_GET['approved'])) {
            echo '<div class="notice notice-success"><p>Loan application approved successfully.</p></div>';
        } elseif (isset($_GET['rejected'])) {
            echo '<div class="notice notice-info"><p>Loan application rejected.</p></div>';
        }
        ?>
        
        <ul class="subsubsub">
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans'); ?>" <?php echo $status == 'all' ? 'class="current"' : ''; ?>>
                    All <span class="count">(<?php echo daystar_get_loan_count('all'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&status=pending'); ?>" <?php echo $status == 'pending' ? 'class="current"' : ''; ?>>
                    Pending <span class="count">(<?php echo daystar_get_loan_count('pending'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&status=approved'); ?>" <?php echo $status == 'approved' ? 'class="current"' : ''; ?>>
                    Approved <span class="count">(<?php echo daystar_get_loan_count('approved'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&status=disbursed'); ?>" <?php echo $status == 'disbursed' ? 'class="current"' : ''; ?>>
                    Disbursed <span class="count">(<?php echo daystar_get_loan_count('disbursed'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&status=completed'); ?>" <?php echo $status == 'completed' ? 'class="current"' : ''; ?>>
                    Completed <span class="count">(<?php echo daystar_get_loan_count('completed'); ?>)</span>
                </a>
            </li>
        </ul>
        
        <form id="loans-filter" method="get">
            <input type="hidden" name="page" value="daystar-admin-loans">
            
            <div class="tablenav top">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
                    <select name="action" id="bulk-action-selector-top">
                        <option value="-1">Bulk Actions</option>
                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Apply">
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column column-cb check-column">
                            <input type="checkbox">
                        </th>
                        <th scope="col" class="manage-column">Application ID</th>
                        <th scope="col" class="manage-column">Member</th>
                        <th scope="col" class="manage-column">Loan Type</th>
                        <th scope="col" class="manage-column">Amount</th>
                        <th scope="col" class="manage-column">Application Date</th>
                        <th scope="col" class="manage-column">Status</th>
                        <th scope="col" class="manage-column">Actions</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php if (!empty($loans)) : ?>
                        <?php foreach ($loans as $loan) : ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="loans[]" value="<?php echo esc_attr($loan['id']); ?>">
                                </td>
                                <td>
                                    <strong>
                                        <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&action=view&id=' . $loan['id']); ?>">
                                            <?php echo esc_html($loan['application_id']); ?>
                                        </a>
                                    </strong>
                                </td>
                                <td>
                                    <?php 
                                    $member = get_user_by('id', $loan['user_id']);
                                    echo esc_html($member->display_name);
                                    echo '<br><small>' . esc_html(get_user_meta($member->ID, 'member_number', true)) . '</small>';
                                    ?>
                                </td>
                                <td><?php echo esc_html($loan['loan_type']); ?></td>
                                <td>KES <?php echo number_format($loan['amount'], 2); ?></td>
                                <td><?php echo date('M j, Y', strtotime($loan['application_date'])); ?></td>
                                <td>
                                    <span class="status-<?php echo esc_attr($loan['status']); ?>">
                                        <?php echo ucfirst(esc_html($loan['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans&action=view&id=' . $loan['id']); ?>" class="button">View</a>
                                    
                                    <?php if ($loan['status'] == 'pending') : ?>
                                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-loans&action=approve&id=' . $loan['id']), 'approve_loan_' . $loan['id']); ?>" class="button button-primary">Approve</a>
                                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-loans&action=reject&id=' . $loan['id']), 'reject_loan_' . $loan['id']); ?>" class="button">Reject</a>
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
        </form>
    </div>

    <style>
        .status-pending {
            color: #856404;
            background-color: #fff3cd;
            padding: 3px 8px;
            border-radius: 3px;
        }
        
        .status-approved {
            color: #155724;
            background-color: #d4edda;
            padding: 3px 8px;
            border-radius: 3px;
        }
        
        .status-disbursed {
            color: #004085;
            background-color: #cce5ff;
            padding: 3px 8px;
            border-radius: 3px;
        }
        
        .status-completed {
            color: #383d41;
            background-color: #e2e3e5;
            padding: 3px 8px;
            border-radius: 3px;
        }
        
        .status-rejected {
            color: #721c24;
            background-color: #f8d7da;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
    <?php
}

/**
 * Render loan details page
 */
function daystar_render_loan_details_page($loan_id) {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get loan data
    $loan = daystar_get_loan_by_id($loan_id);
    
    if (!$loan) {
        wp_die('Loan application not found.');
    }
    
    $member = get_user_by('id', $loan['user_id']);
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Loan Application Details</h1>
        <a href="<?php echo admin_url('admin.php?page=daystar-admin-loans'); ?>" class="page-title-action">Back to Loans</a>
        <hr class="wp-header-end">
        
        <div class="loan-details-container">
            <div class="loan-details-grid">
                <div class="loan-details-column">
                    <div class="loan-details-section">
                        <h2>Application Information</h2>
                        <table class="form-table">
                            <tr>
                                <th><label>Application ID</label></th>
                                <td><?php echo esc_html($loan['application_id']); ?></td>
                            </tr>
                            <tr>
                                <th><label>Loan Type</label></th>
                                <td><?php echo esc_html($loan['loan_type']); ?></td>
                            </tr>
                            <tr>
                                <th><label>Amount Requested</label></th>
                                <td>KES <?php echo number_format($loan['amount'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><label>Loan Term</label></th>
                                <td><?php echo esc_html($loan['term']); ?> months</td>
                            </tr>
                            <tr>
                                <th><label>Application Date</label></th>
                                <td><?php echo date('M j, Y', strtotime($loan['application_date'])); ?></td>
                            </tr>
                            <tr>
                                <th><label>Status</label></th>
                                <td>
                                    <span class="status-<?php echo esc_attr($loan['status']); ?>">
                                        <?php echo ucfirst(esc_html($loan['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="loan-details-section">
                        <h2>Member Information</h2>
                        <table class="form-table">
                            <tr>
                                <th><label>Member Name</label></th>
                                <td><?php echo esc_html($member->display_name); ?></td>
                            </tr>
                            <tr>
                                <th><label>Member Number</label></th>
                                <td><?php echo esc_html(get_user_meta($member->ID, 'member_number', true)); ?></td>
                            </tr>
                            <tr>
                                <th><label>Email</label></th>
                                <td><?php echo esc_html($member->user_email); ?></td>
                            </tr>
                            <tr>
                                <th><label>Phone</label></th>
                                <td><?php echo esc_html(get_user_meta($member->ID, 'phone', true)); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="loan-details-column">
                    <div class="loan-details-section">
                        <h2>Loan Details</h2>
                        <table class="form-table">
                            <tr>
                                <th><label>Purpose</label></th>
                                <td><?php echo esc_html($loan['purpose']); ?></td>
                            </tr>
                            <tr>
                                <th><label>Monthly Payment</label></th>
                                <td>KES <?php echo number_format($loan['monthly_payment'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><label>Total Interest</label></th>
                                <td>KES <?php echo number_format($loan['total_interest'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><label>Total Repayment</label></th>
                                <td>KES <?php echo number_format($loan['total_repayment'], 2); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <?php if ($loan['status'] == 'pending') : ?>
                        <div class="loan-details-section">
                            <h2>Actions</h2>
                            <p>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-loans&action=approve&id=' . $loan['id']), 'approve_loan_' . $loan['id']); ?>" class="button button-primary">Approve Loan</a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-loans&action=reject&id=' . $loan['id']), 'reject_loan_' . $loan['id']); ?>" class="button">Reject Loan</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        .loan-details-container {
            margin-top: 20px;
        }
        .loan-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .loan-details-section {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            margin-bottom: 20px;
        }
        .loan-details-section h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        @media (max-width: 782px) {
            .loan-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <?php
}

/**
 * Get loans by status
 */
function daystar_get_loans_by_status($status = 'all') {
    // In a real implementation, this would query a custom table
    // For now, return sample data
    return array(
        array(
            'id' => 1,
            'application_id' => 'LOAN-2025-001',
            'user_id' => 1,
            'loan_type' => 'Development Loan',
            'amount' => 750000,
            'term' => 36,
            'purpose' => 'Home renovation',
            'monthly_payment' => 25000,
            'total_interest' => 150000,
            'total_repayment' => 900000,
            'application_date' => '2025-05-30',
            'status' => 'pending'
        ),
        // Add more sample loans as needed
    );
}

/**
 * Get loan by ID
 */
function daystar_get_loan_by_id($loan_id) {
    // In a real implementation, this would query a custom table
    // For now, return sample data
    $loans = daystar_get_loans_by_status('all');
    foreach ($loans as $loan) {
        if ($loan['id'] == $loan_id) {
            return $loan;
        }
    }
    return false;
}

/**
 * Get loan count by status
 */
function daystar_get_loan_count($status) {
    // In a real implementation, this would query a custom table
    // For now, return sample counts
    switch ($status) {
        case 'pending':
            return 5;
        case 'approved':
            return 10;
        case 'disbursed':
            return 15;
        case 'completed':
            return 20;
        default:
            return 50;
    }
}

/**
 * Approve a loan application
 */
function daystar_approve_loan($loan_id) {
    // In a real implementation, this would update the database
    // For now, just return true
    return true;
}

/**
 * Reject a loan application
 */
function daystar_reject_loan($loan_id) {
    // In a real implementation, this would update the database
    // For now, just return true
    return true;
}
