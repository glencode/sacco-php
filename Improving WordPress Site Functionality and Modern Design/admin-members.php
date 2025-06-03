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
    $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
    
    // Get members based on status
    $members = daystar_get_members_by_status($status);
    
    // Display notices
    if (isset($_GET['approved'])) {
        echo '<div class="notice notice-success is-dismissible"><p>Member approved successfully.</p></div>';
    } elseif (isset($_GET['rejected'])) {
        echo '<div class="notice notice-warning is-dismissible"><p>Member rejected.</p></div>';
    } elseif (isset($_GET['updated'])) {
        echo '<div class="notice notice-success is-dismissible"><p>Member updated successfully.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=add'); ?>" class="page-title-action">Add New</a>
        <hr class="wp-header-end">
        
        <ul class="subsubsub">
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=all'); ?>" <?php echo $status == 'all' ? 'class="current"' : ''; ?>>
                    All <span class="count">(<?php echo daystar_get_member_count('all'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=active'); ?>" <?php echo $status == 'active' ? 'class="current"' : ''; ?>>
                    Active <span class="count">(<?php echo daystar_get_member_count('active'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=pending'); ?>" <?php echo $status == 'pending' ? 'class="current"' : ''; ?>>
                    Pending <span class="count">(<?php echo daystar_get_member_count('pending'); ?>)</span>
                </a> |
            </li>
            <li>
                <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&status=inactive'); ?>" <?php echo $status == 'inactive' ? 'class="current"' : ''; ?>>
                    Inactive <span class="count">(<?php echo daystar_get_member_count('inactive'); ?>)</span>
                </a>
            </li>
        </ul>
        
        <form id="members-filter" method="get">
            <input type="hidden" name="page" value="daystar-admin-members">
            
            <div class="tablenav top">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
                    <select name="action" id="bulk-action-selector-top">
                        <option value="-1">Bulk Actions</option>
                        <option value="approve">Approve</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="activate">Activate</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Apply">
                </div>
                
                <div class="alignleft actions">
                    <label for="filter-by-date" class="screen-reader-text">Filter by date</label>
                    <select name="filter_date" id="filter-by-date">
                        <option value="">All dates</option>
                        <option value="today">Today</option>
                        <option value="this_week">This week</option>
                        <option value="this_month">This month</option>
                    </select>
                    
                    <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
                </div>
                
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo count($members); ?> items</span>
                    <!-- Pagination would go here in a real implementation -->
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <input id="cb-select-all-1" type="checkbox">
                        </td>
                        <th scope="col" class="manage-column column-member_number">Member Number</th>
                        <th scope="col" class="manage-column column-name">Name</th>
                        <th scope="col" class="manage-column column-email">Email</th>
                        <th scope="col" class="manage-column column-phone">Phone</th>
                        <th scope="col" class="manage-column column-contributions">Contributions</th>
                        <th scope="col" class="manage-column column-join_date">Join Date</th>
                        <th scope="col" class="manage-column column-status">Status</th>
                    </tr>
                </thead>
                
                <tbody id="the-list">
                    <?php if (!empty($members)) : ?>
                        <?php foreach ($members as $member) : ?>
                            <tr>
                                <th scope="row" class="check-column">
                                    <input type="checkbox" name="members[]" value="<?php echo esc_attr($member['id']); ?>">
                                </th>
                                <td class="member_number column-member_number">
                                    <strong>
                                        <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member['id']); ?>">
                                            <?php echo esc_html($member['member_number']); ?>
                                        </a>
                                    </strong>
                                    <div class="row-actions">
                                        <span class="view">
                                            <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=view&id=' . $member['id']); ?>">View</a> |
                                        </span>
                                        <span class="edit">
                                            <a href="<?php echo admin_url('admin.php?page=daystar-admin-members&action=edit&id=' . $member['id']); ?>">Edit</a>
                                            <?php if ($member['status'] == 'pending') : ?>
                                                |
                                            <?php endif; ?>
                                        </span>
                                        <?php if ($member['status'] == 'pending') : ?>
                                            <span class="approve">
                                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=approve&id=' . $member['id']), 'approve_member_' . $member['id']); ?>">Approve</a> |
                                            </span>
                                            <span class="reject">
                                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=daystar-admin-members&action=reject&id=' . $member['id']), 'reject_member_' . $member['id']); ?>">Reject</a>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="name column-name"><?php echo esc_html($member['name']); ?></td>
                                <td class="email column-email"><?php echo esc_html($member['email']); ?></td>
                                <td class="phone column-phone"><?php echo esc_html($member['phone']); ?></td>
                                <td class="contributions column-contributions">KES <?php echo number_format($member['contributions'], 2); ?></td>
                                <td class="join_date column-join_date"><?php echo date('M j, Y', strtotime($member['join_date'])); ?></td>
                                <td class="status column-status">
                                    <span class="member-status status-<?php echo esc_attr($member['status']); ?>">
                                        <?php echo ucfirst(esc_html($member['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">No members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                
                <tfoot>
                    <tr>
                        <td class="manage-column column-cb check-column">
                            <input id="cb-select-all-2" type="checkbox">
                        </td>
                        <th scope="col" class="manage-column column-member_number">Member Number</th>
                        <th scope="col" class="manage-column column-name">Name</th>
                        <th scope="col" class="manage-column column-email">Email</th>
                        <th scope="col" class="manage-column column-phone">Phone</th>
                        <th scope="col" class="manage-column column-contributions">Contributions</th>
                        <th scope="col" class="manage-column column-join_date">Join Date</th>
                        <th scope="col" class="manage-column column-status">Status</th>
                    </tr>
                </tfoot>
            </table>
            
            <div class="tablenav bottom">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>
                    <select name="action2" id="bulk-action-selector-bottom">
                        <option value="-1">Bulk Actions</option>
                        <option value="approve">Approve</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="activate">Activate</option>
                    </select>
                    <input type="submit" id="doaction2" class="button action" value="Apply">
                </div>
                
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo count($members); ?> items</span>
                    <!-- Pagination would go here in a real implementation -->
                </div>
            </div>
        </form>
    </div>
    
    <style>
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
    </style>
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
                
                <?php if ($member['status'] == 'pending') : ?>
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
function daystar_get_members_by_status($status = 'all') {
    // In a real implementation, query the database for users with 'member' role and specified status
    // For now, we'll return sample data for demonstration purposes
    
    $members = array(
        array(
            'id' => 1,
            'member_number' => 'DST00123',
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+254712345678',
            'id_number' => '12345678',
            'dob' => '1985-05-15',
            'gender' => 'male',
            'address' => '123 Main St, Apartment 4B',
            'city' => 'Nairobi',
            'county' => 'Nairobi',
            'postal_code' => '00100',
            'employer' => 'ABC Company',
            'occupation' => 'Software Developer',
            'monthly_income' => 80000,
            'join_date' => '2024-01-15',
            'status' => 'active',
            'contributions' => 75000,
            'share_capital' => 10000,
            'registration_fee_paid' => true,
            'next_of_kin_name' => 'Jane Doe',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_phone' => '+254723456789',
            'next_of_kin_email' => 'jane.doe@example.com',
            'bank_name' => 'ABC Bank',
            'bank_branch' => 'Main Branch',
            'bank_account_number' => '1234567890'
        ),
        array(
            'id' => 2,
            'member_number' => 'DST00456',
            'name' => 'Jane Smith',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '+254723456789',
            'id_number' => '23456789',
            'dob' => '1990-08-22',
            'gender' => 'female',
            'address' => '456 Park Ave',
            'city' => 'Nairobi',
            'county' => 'Nairobi',
            'postal_code' => '00200',
            'employer' => 'XYZ Corporation',
            'occupation' => 'Marketing Manager',
            'monthly_income' => 95000,
            'join_date' => '2024-02-20',
            'status' => 'active',
            'contributions' => 60000,
            'share_capital' => 10000,
            'registration_fee_paid' => true,
            'next_of_kin_name' => 'John Smith',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_phone' => '+254712345678',
            'next_of_kin_email' => 'john.smith@example.com',
            'bank_name' => 'XYZ Bank',
            'bank_branch' => 'Central Branch',
            'bank_account_number' => '2345678901'
        ),
        array(
            'id' => 3,
            'member_number' => 'DST00789',
            'name' => 'Robert Johnson',
            'first_name' => 'Robert',
            'last_name' => 'Johnson',
            'email' => 'robert.johnson@example.com',
            'phone' => '+254734567890',
            'id_number' => '34567890',
            'dob' => '1978-11-10',
            'gender' => 'male',
            'address' => '789 Oak St',
            'city' => 'Mombasa',
            'county' => 'Mombasa',
            'postal_code' => '80100',
            'employer' => 'Self-employed',
            'occupation' => 'Business Owner',
            'monthly_income' => 120000,
            'join_date' => '2024-03-05',
            'status' => 'active',
            'contributions' => 90000,
            'share_capital' => 15000,
            'registration_fee_paid' => true,
            'next_of_kin_name' => 'Mary Johnson',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_phone' => '+254745678901',
            'next_of_kin_email' => 'mary.johnson@example.com',
            'bank_name' => 'DEF Bank',
            'bank_branch' => 'Mombasa Branch',
            'bank_account_number' => '3456789012'
        ),
        array(
            'id' => 4,
            'member_number' => 'DST00555',
            'name' => 'Alice Brown',
            'first_name' => 'Alice',
            'last_name' => 'Brown',
            'email' => 'alice.brown@example.com',
            'phone' => '+254756789012',
            'id_number' => '45678901',
            'dob' => '1992-04-18',
            'gender' => 'female',
            'address' => '555 Elm St',
            'city' => 'Kisumu',
            'county' => 'Kisumu',
            'postal_code' => '40100',
            'employer' => 'GHI Ltd',
            'occupation' => 'Accountant',
            'monthly_income' => 70000,
            'join_date' => '2024-04-10',
            'status' => 'pending',
            'contributions' => 0,
            'share_capital' => 5000,
            'registration_fee_paid' => true,
            'next_of_kin_name' => 'David Brown',
            'next_of_kin_relationship' => 'Brother',
            'next_of_kin_phone' => '+254767890123',
            'next_of_kin_email' => 'david.brown@example.com',
            'bank_name' => 'GHI Bank',
            'bank_branch' => 'Kisumu Branch',
            'bank_account_number' => '4567890123'
        ),
        array(
            'id' => 5,
            'member_number' => 'DST00222',
            'name' => 'Michael Green',
            'first_name' => 'Michael',
            'last_name' => 'Green',
            'email' => 'michael.green@example.com',
            'phone' => '+254778901234',
            'id_number' => '56789012',
            'dob' => '1983-09-30',
            'gender' => 'male',
            'address' => '222 Pine St',
            'city' => 'Nakuru',
            'county' => 'Nakuru',
            'postal_code' => '20100',
            'employer' => 'JKL Corporation',
            'occupation' => 'Engineer',
            'monthly_income' => 85000,
            'join_date' => '2024-05-22',
            'status' => 'pending',
            'contributions' => 0,
            'share_capital' => 5000,
            'registration_fee_paid' => false,
            'next_of_kin_name' => 'Sarah Green',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_phone' => '+254789012345',
            'next_of_kin_email' => 'sarah.green@example.com',
            'bank_name' => 'JKL Bank',
            'bank_branch' => 'Nakuru Branch',
            'bank_account_number' => '5678901234'
        ),
        array(
            'id' => 6,
            'member_number' => 'DST00333',
            'name' => 'Susan Wilson',
            'first_name' => 'Susan',
            'last_name' => 'Wilson',
            'email' => 'susan.wilson@example.com',
            'phone' => '+254790123456',
            'id_number' => '67890123',
            'dob' => '1975-12-05',
            'gender' => 'female',
            'address' => '333 Cedar St',
            'city' => 'Eldoret',
            'county' => 'Uasin Gishu',
            'postal_code' => '30100',
            'employer' => 'MNO Industries',
            'occupation' => 'HR Manager',
            'monthly_income' => 90000,
            'join_date' => '2023-11-15',
            'status' => 'inactive',
            'contributions' => 45000,
            'share_capital' => 10000,
            'registration_fee_paid' => true,
            'next_of_kin_name' => 'James Wilson',
            'next_of_kin_relationship' => 'Spouse',
            'next_of_kin_phone' => '+254701234567',
            'next_of_kin_email' => 'james.wilson@example.com',
            'bank_name' => 'MNO Bank',
            'bank_branch' => 'Eldoret Branch',
            'bank_account_number' => '6789012345'
        ),
    );
    
    // Filter members by status if not 'all'
    if ($status !== 'all') {
        $filtered_members = array();
        foreach ($members as $member) {
            if ($member['status'] === $status) {
                $filtered_members[] = $member;
            }
        }
        return $filtered_members;
    }
    
    return $members;
}

/**
 * Get member by ID
 */
function daystar_get_member_by_id($member_id) {
    $members = daystar_get_members_by_status('all');
    
    foreach ($members as $member) {
        if ($member['id'] == $member_id) {
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
function daystar_approve_member($member_id) {
    // In a real implementation, update the user meta to set status to 'active'
    // For now, we'll just return true for demonstration purposes
    return true;
}

/**
 * Reject member
 */
function daystar_reject_member($member_id) {
    // In a real implementation, update the user meta to set status to 'rejected'
    // For now, we'll just return true for demonstration purposes
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
