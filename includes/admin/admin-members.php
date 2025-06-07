<?php
/**
 * Daystar Member Management Admin Functions
 *
 * Handles member management in the admin area
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the member management admin page
 */
function daystar_render_admin_members_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Handle actions
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'view':
                if (isset($_GET['id'])) {
                    daystar_render_member_details_page(intval($_GET['id']));
                    return;
                }
                break;
            case 'edit':
                if (isset($_GET['id'])) {
                    daystar_render_member_edit_page(intval($_GET['id']));
                    return;
                }
                break;
            case 'approve':
                if (isset($_GET['id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'approve_member_' . $_GET['id'])) {
                    daystar_approve_member(intval($_GET['id']));
                    wp_redirect(admin_url('admin.php?page=daystar-admin-members&status=pending&approved=1'));
                    exit;
                }
                break;
            case 'reject':
                if (isset($_GET['id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'reject_member_' . $_GET['id'])) {
                    daystar_reject_member(intval($_GET['id']));
                    wp_redirect(admin_url('admin.php?page=daystar-admin-members&status=pending&rejected=1'));
                    exit;
                }
                break;
        }
    }
    
    // Process form submissions
    if (isset($_POST['action']) && $_POST['action'] == 'update_member' && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update_member_' . $_POST['member_id'])) {
        daystar_update_member($_POST);
        wp_redirect(admin_url('admin.php?page=daystar-admin-members&updated=1'));
        exit;
    }
    
    // Get current filter/status
    $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'active';
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Member Management</h1>
        <hr class="wp-header-end">
        
        <?php
        // Show status messages
        if (isset($_GET['approved'])) {
            echo '<div class="notice notice-success"><p>Member has been approved successfully.</p></div>';
        }
        if (isset($_GET['rejected'])) {
            echo '<div class="notice notice-warning"><p>Member application has been rejected.</p></div>';
        }
        if (isset($_GET['updated'])) {
            echo '<div class="notice notice-success"><p>Member details updated successfully.</p></div>';
        }
        ?>
        
        <nav class="nav-tab-wrapper wp-clearfix">
            <a href="<?php echo admin_url('admin.php?page=daystar-admin-members'); ?>" 
               class="nav-tab <?php echo $status === 'active' ? 'nav-tab-active' : ''; ?>">
                Active Members
            </a>
            <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=pending'); ?>" 
               class="nav-tab <?php echo $status === 'pending' ? 'nav-tab-active' : ''; ?>">
                Pending Approvals
                <?php 
                $pending_count = daystar_get_members_count('pending');
                if ($pending_count > 0) {
                    echo '<span class="awaiting-mod count-' . $pending_count . '"><span class="pending-count">' . $pending_count . '</span></span>';
                }
                ?>
            </a>
            <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=suspended'); ?>" 
               class="nav-tab <?php echo $status === 'suspended' ? 'nav-tab-active' : ''; ?>">
                Suspended Members
            </a>
        </nav>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <select name="filter_action" id="filter-by-date">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="this-week">This Week</option>
                    <option value="this-month">This Month</option>
                </select>
                <input type="submit" name="filter_action" id="filter-submit" class="button" value="Filter">
            </div>
            <div class="tablenav-pages">
                <!-- Pagination will go here -->
            </div>
        </div>
        
        <table class="wp-list-table widefat fixed striped table-view-list members">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-member-number">Member Number</th>
                    <th scope="col" class="manage-column column-name">Name</th>
                    <th scope="col" class="manage-column column-email">Email</th>
                    <th scope="col" class="manage-column column-phone">Phone</th>
                    <th scope="col" class="manage-column column-registration-date">Registration Date</th>
                    <?php if ($status === 'pending'): ?>
                        <th scope="col" class="manage-column column-documents">Documents</th>
                        <th scope="col" class="manage-column column-contribution">Initial Contribution</th>
                    <?php else: ?>
                        <th scope="col" class="manage-column column-balance">Account Balance</th>
                        <th scope="col" class="manage-column column-last-contribution">Last Contribution</th>
                    <?php endif; ?>
                    <th scope="col" class="manage-column column-actions">Actions</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php
                // Get members based on status
                $members = daystar_get_members_by_status($status);
                
                if (!empty($members)) {
                    foreach ($members as $member) {
                        ?>
                        <tr>
                            <td class="column-member-number">
                                <?php echo esc_html($member['member_number']); ?>
                            </td>
                            <td class="column-name">
                                <strong>
                                    <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member['ID']); ?>">
                                        <?php echo esc_html($member['name']); ?>
                                    </a>
                                </strong>
                            </td>
                            <td class="column-email">
                                <a href="mailto:<?php echo esc_attr($member['email']); ?>">
                                    <?php echo esc_html($member['email']); ?>
                                </a>
                            </td>
                            <td class="column-phone">
                                <?php echo esc_html($member['phone']); ?>
                            </td>
                            <td class="column-registration-date">
                                <?php echo esc_html(date('M j, Y', strtotime($member['registration_date']))); ?>
                            </td>
                            <?php if ($status === 'pending'): ?>
                                <td class="column-documents">
                                    <?php 
                                    $doc_count = daystar_get_member_document_count($member['ID']);
                                    echo sprintf(
                                        '<span class="document-count">%d/5</span>',
                                        $doc_count
                                    ); 
                                    if ($doc_count > 0) {
                                        echo ' <a href="#" class="view-documents">View</a>';
                                    }
                                    ?>
                                </td>
                                <td class="column-contribution">
                                    <?php 
                                    echo 'KSh ' . number_format($member['initial_contribution'], 2);
                                    if ($member['contribution_status'] === 'paid') {
                                        echo ' <span class="status-paid">Paid</span>';
                                    }
                                    ?>
                                </td>
                            <?php else: ?>
                                <td class="column-balance">
                                    KSh <?php echo number_format($member['account_balance'], 2); ?>
                                </td>
                                <td class="column-last-contribution">
                                    <?php 
                                    if (!empty($member['last_contribution_date'])) {
                                        echo esc_html(date('M j, Y', strtotime($member['last_contribution_date'])));
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </td>
                            <?php endif; ?>
                            <td class="column-actions">
                                <div class="row-actions">
                                    <span class="view">
                                        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member['ID']); ?>">
                                            View
                                        </a>
                                        |
                                    </span>
                                    <span class="edit">
                                        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=edit&id=' . $member['ID']); ?>">
                                            Edit
                                        </a>
                                        <?php if ($status === 'pending'): ?>
                                            |
                                    </span>
                                    <span class="approve">
                                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=approve&id=' . $member['ID']), 'approve_member_' . $member['ID']); ?>" 
                                           onclick="return confirm('Are you sure you want to approve this member?');">
                                            Approve
                                        </a>
                                        |
                                    </span>
                                    <span class="reject">
                                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=reject&id=' . $member['ID']), 'reject_member_' . $member['ID']); ?>" 
                                           onclick="return confirm('Are you sure you want to reject this member application?');" 
                                           class="submitdelete">
                                            Reject
                                        </a>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">
                            <?php 
                            if ($status === 'pending') {
                                echo 'No pending member applications.';
                            } else {
                                echo 'No members found.';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        
        <div class="tablenav bottom">
            <div class="tablenav-pages">
                <!-- Pagination will go here -->
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render member details page
 */
function daystar_render_member_details_page($member_id) {
    // Get member data
    $member = daystar_get_member_by_id($member_id);
    
    if (!$member) {
        wp_die('Member not found.');
    }
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Member Details</h1>
        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members'); ?>" class="page-title-action">Back to Members</a>
        <hr class="wp-header-end">
        
        <div class="member-details-container">
            <div class="member-header">
                <h2><?php echo esc_html($member['name']); ?> <span class="member-number">(<?php echo esc_html($member['member_number']); ?>)</span></h2>
                <div class="member-status status-<?php echo esc_attr($member['status']); ?>">
                    <?php echo ucfirst(esc_html($member['status'])); ?>
                </div>
            </div>
            
            <div class="member-actions">
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=edit&id=' . $member_id); ?>" class="button">Edit Member</a>
                
                <?php if ($member['status'] === 'pending' || get_user_meta($member_id, 'member_status', true) === 'pending') : ?>
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=approve&id=' . $member_id), 'approve_member_' . $member_id); ?>" class="button button-primary">Approve Member</a>
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=reject&id=' . $member_id), 'reject_member_' . $member_id); ?>" class="button">Reject Member</a>
                <?php elseif ($member['status'] == 'active') : ?>
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=deactivate&id=' . $member_id), 'deactivate_member_' . $member_id); ?>" class="button">Deactivate Member</a>
                <?php elseif ($member['status'] == 'inactive') : ?>
                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=activate&id=' . $member_id), 'activate_member_' . $member_id); ?>" class="button button-primary">Activate Member</a>
                <?php endif; ?>
                
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=send_message&id=' . $member_id); ?>" class="button">Send Message</a>
            </div>
            
            <div class="member-details-grid">
                <div class="member-details-column">
                    <div class="member-details-section">
                        <h3>Personal Information</h3>
                        <table class="form-table">
                            <tr>
                                <th>Full Name</th>
                                <td><?php echo esc_html($member['name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo esc_html($member['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo esc_html($member['phone']); ?></td>
                            </tr>
                            <tr>
                                <th>ID Number</th>
                                <td><?php echo esc_html($member['id_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td><?php echo date('F j, Y', strtotime($member['dob'])); ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?php echo esc_html($member['gender']); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="member-details-section">
                        <h3>Address Information</h3>
                        <table class="form-table">
                            <tr>
                                <th>Physical Address</th>
                                <td><?php echo esc_html($member['address']); ?></td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?php echo esc_html($member['city']); ?></td>
                            </tr>
                            <tr>
                                <th>County</th>
                                <td><?php echo esc_html($member['county']); ?></td>
                            </tr>
                            <tr>
                                <th>Postal Code</th>
                                <td><?php echo esc_html($member['postal_code']); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="member-details-section">
                        <h3>Employment Information</h3>
                        <table class="form-table">
                            <tr>
                                <th>Employer</th>
                                <td><?php echo esc_html($member['employer']); ?></td>
                            </tr>
                            <tr>
                                <th>Occupation</th>
                                <td><?php echo esc_html($member['occupation']); ?></td>
                            </tr>
                            <tr>
                                <th>Monthly Income</th>
                                <td>KES <?php echo number_format($member['monthly_income'], 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="member-details-column">
                    <div class="member-details-section">
                        <h3>Membership Information</h3>
                        <table class="form-table">
                            <tr>
                                <th>Member Number</th>
                                <td><?php echo esc_html($member['member_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Join Date</th>
                                <td><?php echo date('F j, Y', strtotime($member['join_date'])); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="member-status status-<?php echo esc_attr($member['status']); ?>">
                                        <?php echo ucfirst(esc_html($member['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Contributions</th>
                                <td>KES <?php echo number_format($member['contributions'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Share Capital</th>
                                <td>KES <?php echo number_format($member['share_capital'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Registration Fee</th>
                                <td><?php echo $member['registration_fee_paid'] ? 'Paid' : 'Not Paid'; ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="member-details-section">
                        <h3>Next of Kin</h3>
                        <table class="form-table">
                            <tr>
                                <th>Name</th>
                                <td><?php echo esc_html($member['next_of_kin_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Relationship</th>
                                <td><?php echo esc_html($member['next_of_kin_relationship']); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo esc_html($member['next_of_kin_phone']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo esc_html($member['next_of_kin_email']); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="member-details-section">
                        <h3>Bank Information</h3>
                        <table class="form-table">
                            <tr>
                                <th>Bank Name</th>
                                <td><?php echo esc_html($member['bank_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td><?php echo esc_html($member['bank_branch']); ?></td>
                            </tr>
                            <tr>
                                <th>Account Number</th>
                                <td><?php echo esc_html($member['bank_account_number']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="member-details-section">
                <h3>Recent Activity</h3>
                <table class="widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // In a real implementation, query activity logs for this member
                        $activities = array(
                            array(
                                'date' => '2025-06-01 09:30:45',
                                'activity' => 'Loan Application',
                                'details' => 'Applied for a Development Loan of KES 150,000'
                            ),
                            array(
                                'date' => '2025-05-15 14:22:10',
                                'activity' => 'Payment',
                                'details' => 'Made a contribution payment of KES 5,000'
                            ),
                            array(
                                'date' => '2025-05-01 10:05:33',
                                'activity' => 'Profile Update',
                                'details' => 'Updated contact information'
                            ),
                        );
                        
                        if (!empty($activities)) {
                            foreach ($activities as $activity) {
                                echo '<tr>';
                                echo '<td>' . date('M j, Y, g:i a', strtotime($activity['date'])) . '</td>';
                                echo '<td>' . esc_html($activity['activity']) . '</td>';
                                echo '<td>' . esc_html($activity['details']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3">No recent activity.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <style>
        .member-details-container {
            margin-top: 20px;
        }
        .member-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .member-number {
            color: #777;
            font-size: 0.8em;
            margin-left: 10px;
        }
        .member-header .member-status {
            margin-left: 20px;
        }
        .member-actions {
            margin-bottom: 20px;
        }
        .member-actions .button {
            margin-right: 10px;
        }
        .member-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .member-details-section {
            margin-bottom: 30px;
        }
        .member-details-section h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .member-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        .status-active {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .status-pending {
            background-color: #fcf8e3;
            color: #8a6d3b;
        }
        .status-inactive {
            background-color: #f2dede;
            color: #a94442;
        }
        @media (max-width: 782px) {
            .member-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <?php
}

/**
 * Render member edit page
 */
function daystar_render_member_edit_page($member_id) {
    // Get member data
    $member = daystar_get_member_by_id($member_id);
    
    if (!$member) {
        wp_die('Member not found.');
    }
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Edit Member</h1>
        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member_id); ?>" class="page-title-action">Back to Member Details</a>
        <hr class="wp-header-end">
        
        <form method="post" action="<?php echo admin_url('admin.php?page=daystar-admin-members'); ?>">
            <?php wp_nonce_field('update_member_' . $member_id); ?>
            <input type="hidden" name="action" value="update_member">
            <input type="hidden" name="member_id" value="<?php echo esc_attr($member_id); ?>">
            
            <div class="member-edit-container">
                <div class="member-edit-grid">
                    <div class="member-edit-column">
                        <div class="member-edit-section">
                            <h3>Personal Information</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="first_name">First Name</label></th>
                                    <td>
                                        <input type="text" name="first_name" id="first_name" class="regular-text" value="<?php echo esc_attr($member['first_name']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="last_name">Last Name</label></th>
                                    <td>
                                        <input type="text" name="last_name" id="last_name" class="regular-text" value="<?php echo esc_attr($member['last_name']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="email">Email</label></th>
                                    <td>
                                        <input type="email" name="email" id="email" class="regular-text" value="<?php echo esc_attr($member['email']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="phone">Phone</label></th>
                                    <td>
                                        <input type="tel" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr($member['phone']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="id_number">ID Number</label></th>
                                    <td>
                                        <input type="text" name="id_number" id="id_number" class="regular-text" value="<?php echo esc_attr($member['id_number']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="dob">Date of Birth</label></th>
                                    <td>
                                        <input type="date" name="dob" id="dob" class="regular-text" value="<?php echo esc_attr(date('Y-m-d', strtotime($member['dob']))); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="gender">Gender</label></th>
                                    <td>
                                        <select name="gender" id="gender" required>
                                            <option value="male" <?php selected($member['gender'], 'male'); ?>>Male</option>
                                            <option value="female" <?php selected($member['gender'], 'female'); ?>>Female</option>
                                            <option value="other" <?php selected($member['gender'], 'other'); ?>>Other</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="member-edit-section">
                            <h3>Address Information</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="address">Physical Address</label></th>
                                    <td>
                                        <textarea name="address" id="address" class="regular-text" rows="3" required><?php echo esc_textarea($member['address']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="city">City</label></th>
                                    <td>
                                        <input type="text" name="city" id="city" class="regular-text" value="<?php echo esc_attr($member['city']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="county">County</label></th>
                                    <td>
                                        <input type="text" name="county" id="county" class="regular-text" value="<?php echo esc_attr($member['county']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="postal_code">Postal Code</label></th>
                                    <td>
                                        <input type="text" name="postal_code" id="postal_code" class="regular-text" value="<?php echo esc_attr($member['postal_code']); ?>" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="member-edit-section">
                            <h3>Employment Information</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="employer">Employer</label></th>
                                    <td>
                                        <input type="text" name="employer" id="employer" class="regular-text" value="<?php echo esc_attr($member['employer']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="occupation">Occupation</label></th>
                                    <td>
                                        <input type="text" name="occupation" id="occupation" class="regular-text" value="<?php echo esc_attr($member['occupation']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="monthly_income">Monthly Income (KES)</label></th>
                                    <td>
                                        <input type="number" name="monthly_income" id="monthly_income" class="regular-text" value="<?php echo esc_attr($member['monthly_income']); ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="member-edit-column">
                        <div class="member-edit-section">
                            <h3>Membership Information</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="member_number">Member Number</label></th>
                                    <td>
                                        <input type="text" name="member_number" id="member_number" class="regular-text" value="<?php echo esc_attr($member['member_number']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="join_date">Join Date</label></th>
                                    <td>
                                        <input type="date" name="join_date" id="join_date" class="regular-text" value="<?php echo esc_attr(date('Y-m-d', strtotime($member['join_date']))); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="status">Status</label></th>
                                    <td>
                                        <select name="status" id="status" required>
                                            <option value="active" <?php selected($member['status'], 'active'); ?>>Active</option>
                                            <option value="pending" <?php selected($member['status'], 'pending'); ?>>Pending</option>
                                            <option value="inactive" <?php selected($member['status'], 'inactive'); ?>>Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="contributions">Total Contributions (KES)</label></th>
                                    <td>
                                        <input type="number" name="contributions" id="contributions" class="regular-text" value="<?php echo esc_attr($member['contributions']); ?>" readonly>
                                        <p class="description">This field is automatically calculated and cannot be edited directly.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="share_capital">Share Capital (KES)</label></th>
                                    <td>
                                        <input type="number" name="share_capital" id="share_capital" class="regular-text" value="<?php echo esc_attr($member['share_capital']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="registration_fee_paid">Registration Fee</label></th>
                                    <td>
                                        <select name="registration_fee_paid" id="registration_fee_paid">
                                            <option value="1" <?php selected($member['registration_fee_paid'], true); ?>>Paid</option>
                                            <option value="0" <?php selected($member['registration_fee_paid'], false); ?>>Not Paid</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="member-edit-section">
                            <h3>Next of Kin</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="next_of_kin_name">Name</label></th>
                                    <td>
                                        <input type="text" name="next_of_kin_name" id="next_of_kin_name" class="regular-text" value="<?php echo esc_attr($member['next_of_kin_name']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="next_of_kin_relationship">Relationship</label></th>
                                    <td>
                                        <input type="text" name="next_of_kin_relationship" id="next_of_kin_relationship" class="regular-text" value="<?php echo esc_attr($member['next_of_kin_relationship']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="next_of_kin_phone">Phone</label></th>
                                    <td>
                                        <input type="tel" name="next_of_kin_phone" id="next_of_kin_phone" class="regular-text" value="<?php echo esc_attr($member['next_of_kin_phone']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="next_of_kin_email">Email</label></th>
                                    <td>
                                        <input type="email" name="next_of_kin_email" id="next_of_kin_email" class="regular-text" value="<?php echo esc_attr($member['next_of_kin_email']); ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="member-edit-section">
                            <h3>Bank Information</h3>
                            <table class="form-table">
                                <tr>
                                    <th><label for="bank_name">Bank Name</label></th>
                                    <td>
                                        <input type="text" name="bank_name" id="bank_name" class="regular-text" value="<?php echo esc_attr($member['bank_name']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="bank_branch">Branch</label></th>
                                    <td>
                                        <input type="text" name="bank_branch" id="bank_branch" class="regular-text" value="<?php echo esc_attr($member['bank_branch']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="bank_account_number">Account Number</label></th>
                                    <td>
                                        <input type="text" name="bank_account_number" id="bank_account_number" class="regular-text" value="<?php echo esc_attr($member['bank_account_number']); ?>" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="member-edit-actions">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Update Member">
                    <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member_id); ?>" class="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    
    <style>
        .member-edit-container {
            margin-top: 20px;
        }
        .member-edit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .member-edit-section {
            margin-bottom: 30px;
        }
        .member-edit-section h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .member-edit-actions {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .member-edit-actions .button {
            margin-right: 10px;
        }
        @media (max-width: 782px) {
            .member-edit-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <?php
}

/**
 * Get members by status
 */
function daystar_get_members_by_status($status = 'active') {
    $args = array(
        'role__in' => array('member', 'pending_member'),
        'number' => -1
    );
    
    // Add status filter if not requesting all members
    if ($status !== 'all') {
        $args['meta_key'] = 'member_status';
        $args['meta_value'] = $status;
    }
    
    $user_query = new WP_User_Query($args);
    $members = array();
    
    if (!empty($user_query->get_results())) {
        foreach ($user_query->get_results() as $user) {
            // Basic user data
            $member_data = array(
                'ID' => $user->ID,
                'name' => $user->display_name,
                'email' => $user->user_email,
                'member_number' => get_user_meta($user->ID, 'member_number', true),
                'phone' => get_user_meta($user->ID, 'phone', true),
                'registration_date' => get_user_meta($user->ID, 'registration_date', true),
                'status' => get_user_meta($user->ID, 'member_status', true) ?: 'pending',
                
                // Personal Information
                'id_number' => get_user_meta($user->ID, 'id_number', true) ?: '',
                'dob' => get_user_meta($user->ID, 'date_of_birth', true) ?: '1970-01-01',
                'gender' => get_user_meta($user->ID, 'gender', true) ?: '',
                
                // Address Information
                'address' => get_user_meta($user->ID, 'address', true) ?: '',
                'city' => get_user_meta($user->ID, 'city', true) ?: '',
                'county' => get_user_meta($user->ID, 'county', true) ?: '',
                'postal_code' => get_user_meta($user->ID, 'postal_code', true) ?: '',
                
                // Employment Information
                'employer' => get_user_meta($user->ID, 'employer', true) ?: '',
                'occupation' => get_user_meta($user->ID, 'occupation', true) ?: '',
                'monthly_income' => floatval(get_user_meta($user->ID, 'monthly_income', true)) ?: 0.00,
                
                // Membership Information
                'join_date' => get_user_meta($user->ID, 'join_date', true) ?: '1970-01-01',
                'contributions' => floatval(get_user_meta($user->ID, 'total_contributions', true)) ?: 0.00,
                'share_capital' => floatval(get_user_meta($user->ID, 'share_capital', true)) ?: 0.00,
                'registration_fee_paid' => get_user_meta($user->ID, 'registration_fee_paid', true) ? 'Paid' : 'Not Paid',
                
                // Next of Kin
                'next_of_kin_name' => get_user_meta($user->ID, 'next_of_kin_name', true) ?: '',
                'next_of_kin_relationship' => get_user_meta($user->ID, 'next_of_kin_relationship', true) ?: '',
                'next_of_kin_phone' => get_user_meta($user->ID, 'next_of_kin_phone', true) ?: '',
                'next_of_kin_email' => get_user_meta($user->ID, 'next_of_kin_email', true) ?: '',
                
                // Bank Information
                'bank_name' => get_user_meta($user->ID, 'bank_name', true) ?: '',
                'bank_branch' => get_user_meta($user->ID, 'bank_branch', true) ?: '',
                'bank_account_number' => get_user_meta($user->ID, 'bank_account_number', true) ?: '',
                
                // Additional fields for list view
                'initial_contribution' => floatval(get_user_meta($user->ID, 'initial_contribution', true)) ?: 0.00,
                'contribution_status' => get_user_meta($user->ID, 'contribution_status', true) ?: '',
                'account_balance' => floatval(get_user_meta($user->ID, 'account_balance', true)) ?: 0.00,
                'last_contribution_date' => get_user_meta($user->ID, 'last_contribution_date', true) ?: ''
            );
            
            $members[] = $member_data;
        }
    }
    
    return $members;
}

/**
 * Get count of members by status
 */
function daystar_get_members_count($status = 'active') {
    $args = array(
        'role' => $status === 'pending' ? 'pending_member' : 'member',
        'meta_key' => 'member_status',
        'meta_value' => $status,
        'count_total' => true,
    );
    
    $user_query = new WP_User_Query($args);
    return $user_query->get_total();
}

/**
 * Get member document count with caching
 */
function daystar_get_member_document_count($user_id) {
    // Try to get from cache first
    $cache_key = 'member_doc_count_' . $user_id;
    $doc_count = wp_cache_get($cache_key);
    
    if ($doc_count === false) {
        $args = array(
            'post_type' => 'member_document',
            'author' => $user_id,
            'post_status' => 'private',
            'posts_per_page' => -1
        );
        
        $query = new WP_Query($args);
        $doc_count = $query->found_posts;
        
        // Cache the result for 1 hour
        wp_cache_set($cache_key, $doc_count, '', HOUR_IN_SECONDS);
    }
    
    return $doc_count;
}

/**
 * Get member by ID
 */
function daystar_get_member_by_id($member_id) {
    $members = daystar_get_members_by_status('all');
    
    foreach ($members as $member) {
        // Convert both IDs to integers for reliable comparison
        if ((int)$member['ID'] === (int)$member_id) {
            return $member;
        }
    }
    
    return false;
}

/**
 * Get member count by status
 */
function daystar_get_member_count($status = 'all') {
    $members = daystar_get_members_by_status($status);
    return count($members);
}

/**
 * Approve member
 */
function daystar_approve_member($user_id) {
    $user = get_userdata($user_id);
    if (!$user) {
        return false;
    }

    // Update user role and status
    $user->remove_role('pending_member');
    $user->add_role('member');
    update_user_meta($user_id, 'member_status', 'active');
    update_user_meta($user_id, 'verification_date', current_time('mysql'));
    update_user_meta($user_id, 'verified_by', get_current_user_id());

    // Send approval email
    $subject = 'Daystar SACCO Membership Approved';
    $message = "Dear {$user->display_name},\n\n";
    $message .= "Congratulations! Your membership application has been approved.\n\n";
    $message .= "Member Number: " . get_user_meta($user_id, 'member_number', true) . "\n";
    $message .= "You can now log in to your member dashboard to access all member features.\n\n";
    $message .= "Next Steps:\n";
    $message .= "1. Make your initial contribution if you haven't already\n";
    $message .= "2. Set up your monthly contribution schedule\n";
    $message .= "3. Explore available savings and loan products\n\n";
    $message .= "Login here: " . home_url('login') . "\n\n";
    $message .= "Best regards,\nDaystar SACCO Team";

    wp_mail($user->user_email, $subject, $message);

    // Send SMS notification
    $phone = get_user_meta($user_id, 'phone', true);
    $sms_message = "Congratulations! Your Daystar SACCO membership has been approved. Login to your account to get started.";
    daystar_send_sms($phone, $sms_message);

    return true;
}

/**
 * Reject member
 */
function daystar_reject_member($user_id) {
    $user = get_userdata($user_id);
    if (!$user) {
        return false;
    }

    // Update user status
    update_user_meta($user_id, 'member_status', 'rejected');
    update_user_meta($user_id, 'rejection_date', current_time('mysql'));
    update_user_meta($user_id, 'rejected_by', get_current_user_id());

    // Send rejection email
    $subject = 'Daystar SACCO Membership Application Status';
    $message = "Dear {$user->display_name},\n\n";
    $message .= "We regret to inform you that your membership application has been reviewed and cannot be approved at this time.\n\n";
    $message .= "Common reasons for rejection include:\n";
    $message .= "- Incomplete or invalid documentation\n";
    $message .= "- Not meeting eligibility criteria\n";
    $message .= "- Insufficient information provided\n\n";
    $message .= "You may submit a new application after addressing these potential issues.\n\n";
    $message .= "If you need clarification or assistance, please contact our support team:\n";
    $message .= "Email: support@daystar.co.ke\n";
    $message .= "Phone: +254 XXX XXX XXX\n\n";
    $message .= "Best regards,\nDaystar SACCO Team";

    wp_mail($user->user_email, $subject, $message);

    return true;
}

/**
 * Update member
 */
function daystar_update_member($data) {
    // In a real implementation, update the user and user meta with the provided data
    // For now, we'll just return true for demonstration purposes
    return true;
}
