<?php
/**
 * Daystar Member Profile Functions
 *
 * Handles member profile functionality and verification
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom member profile fields to user profile page
 */
function daystar_add_member_profile_fields($user) {
    // Only show these fields for users with the member role
    if (!in_array('member', $user->roles)) {
        return;
    }
    
    // Get member data
    $member_number = get_user_meta($user->ID, 'member_number', true);
    $id_number = get_user_meta($user->ID, 'id_number', true);
    $date_of_birth = get_user_meta($user->ID, 'date_of_birth', true);
    $gender = get_user_meta($user->ID, 'gender', true);
    $marital_status = get_user_meta($user->ID, 'marital_status', true);
    $phone = get_user_meta($user->ID, 'phone', true);
    $alt_phone = get_user_meta($user->ID, 'alt_phone', true);
    $physical_address = get_user_meta($user->ID, 'physical_address', true);
    $city = get_user_meta($user->ID, 'city', true);
    $postal_code = get_user_meta($user->ID, 'postal_code', true);
    $employment_status = get_user_meta($user->ID, 'employment_status', true);
    $employer = get_user_meta($user->ID, 'employer', true);
    $job_title = get_user_meta($user->ID, 'job_title', true);
    $monthly_income = get_user_meta($user->ID, 'monthly_income', true);
    $employment_duration = get_user_meta($user->ID, 'employment_duration', true);
    $kra_pin = get_user_meta($user->ID, 'kra_pin', true);
    $initial_contribution = get_user_meta($user->ID, 'initial_contribution', true);
    $monthly_contribution = get_user_meta($user->ID, 'monthly_contribution', true);
    $member_status = get_user_meta($user->ID, 'member_status', true);
    $registration_date = get_user_meta($user->ID, 'registration_date', true);
    $verification_date = get_user_meta($user->ID, 'verification_date', true);
    $verified_by = get_user_meta($user->ID, 'verified_by', true);
    
    ?>
    <h2>Member Information</h2>
    <table class="form-table">
        <tr>
            <th><label for="member_number">Member Number</label></th>
            <td>
                <input type="text" name="member_number" id="member_number" value="<?php echo esc_attr($member_number); ?>" class="regular-text" readonly />
                <p class="description">Unique member identification number (auto-generated)</p>
            </td>
        </tr>
        <tr>
            <th><label for="member_status">Member Status</label></th>
            <td>
                <select name="member_status" id="member_status">
                    <option value="pending" <?php selected($member_status, 'pending'); ?>>Pending</option>
                    <option value="active" <?php selected($member_status, 'active'); ?>>Active</option>
                    <option value="suspended" <?php selected($member_status, 'suspended'); ?>>Suspended</option>
                    <option value="inactive" <?php selected($member_status, 'inactive'); ?>>Inactive</option>
                </select>
                <p class="description">Current status of the member</p>
            </td>
        </tr>
        <tr>
            <th><label for="registration_date">Registration Date</label></th>
            <td>
                <input type="text" name="registration_date" id="registration_date" value="<?php echo esc_attr($registration_date); ?>" class="regular-text" readonly />
            </td>
        </tr>
        <tr>
            <th><label for="verification_date">Verification Date</label></th>
            <td>
                <input type="text" name="verification_date" id="verification_date" value="<?php echo esc_attr($verification_date); ?>" class="regular-text" readonly />
                <p class="description">Date when the member was verified</p>
            </td>
        </tr>
    </table>
    
    <h3>Personal Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="id_number">ID Number</label></th>
            <td>
                <input type="text" name="id_number" id="id_number" value="<?php echo esc_attr($id_number); ?>" class="regular-text" />
                <p class="description">National ID or Passport Number</p>
            </td>
        </tr>
        <tr>
            <th><label for="date_of_birth">Date of Birth</label></th>
            <td>
                <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo esc_attr($date_of_birth); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="gender">Gender</label></th>
            <td>
                <select name="gender" id="gender">
                    <option value="male" <?php selected($gender, 'male'); ?>>Male</option>
                    <option value="female" <?php selected($gender, 'female'); ?>>Female</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="marital_status">Marital Status</label></th>
            <td>
                <select name="marital_status" id="marital_status">
                    <option value="single" <?php selected($marital_status, 'single'); ?>>Single</option>
                    <option value="married" <?php selected($marital_status, 'married'); ?>>Married</option>
                    <option value="divorced" <?php selected($marital_status, 'divorced'); ?>>Divorced</option>
                    <option value="widowed" <?php selected($marital_status, 'widowed'); ?>>Widowed</option>
                </select>
            </td>
        </tr>
    </table>
    
    <h3>Contact Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="alt_phone">Alternative Phone</label></th>
            <td>
                <input type="tel" name="alt_phone" id="alt_phone" value="<?php echo esc_attr($alt_phone); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="physical_address">Physical Address</label></th>
            <td>
                <textarea name="physical_address" id="physical_address" rows="3" class="regular-text"><?php echo esc_textarea($physical_address); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="city">City/Town</label></th>
            <td>
                <input type="text" name="city" id="city" value="<?php echo esc_attr($city); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="postal_code">Postal Code</label></th>
            <td>
                <input type="text" name="postal_code" id="postal_code" value="<?php echo esc_attr($postal_code); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    
    <h3>Employment Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="employment_status">Employment Status</label></th>
            <td>
                <select name="employment_status" id="employment_status">
                    <option value="employed" <?php selected($employment_status, 'employed'); ?>>Employed</option>
                    <option value="self-employed" <?php selected($employment_status, 'self-employed'); ?>>Self-Employed</option>
                    <option value="business" <?php selected($employment_status, 'business'); ?>>Business Owner</option>
                    <option value="retired" <?php selected($employment_status, 'retired'); ?>>Retired</option>
                    <option value="unemployed" <?php selected($employment_status, 'unemployed'); ?>>Unemployed</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="employer">Employer/Business Name</label></th>
            <td>
                <input type="text" name="employer" id="employer" value="<?php echo esc_attr($employer); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="job_title">Job Title/Position</label></th>
            <td>
                <input type="text" name="job_title" id="job_title" value="<?php echo esc_attr($job_title); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="monthly_income">Monthly Income (KES)</label></th>
            <td>
                <input type="number" name="monthly_income" id="monthly_income" value="<?php echo esc_attr($monthly_income); ?>" class="regular-text" min="0" />
            </td>
        </tr>
        <tr>
            <th><label for="employment_duration">Years at Current Employment</label></th>
            <td>
                <input type="number" name="employment_duration" id="employment_duration" value="<?php echo esc_attr($employment_duration); ?>" class="regular-text" min="0" step="0.5" />
            </td>
        </tr>
        <tr>
            <th><label for="kra_pin">KRA PIN</label></th>
            <td>
                <input type="text" name="kra_pin" id="kra_pin" value="<?php echo esc_attr($kra_pin); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    
    <h3>Contribution Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="initial_contribution">Initial Contribution (KES)</label></th>
            <td>
                <input type="number" name="initial_contribution" id="initial_contribution" value="<?php echo esc_attr($initial_contribution); ?>" class="regular-text" min="0" />
            </td>
        </tr>
        <tr>
            <th><label for="monthly_contribution">Monthly Contribution (KES)</label></th>
            <td>
                <input type="number" name="monthly_contribution" id="monthly_contribution" value="<?php echo esc_attr($monthly_contribution); ?>" class="regular-text" min="0" />
            </td>
        </tr>
    </table>
    
    <?php if (current_user_can('administrator') && $member_status === 'pending') : ?>
    <div class="member-verification-actions">
        <h3>Member Verification</h3>
        <p>
            <button type="button" class="button button-primary" id="verify-member" data-user-id="<?php echo esc_attr($user->ID); ?>">Verify and Approve Member</button>
            <button type="button" class="button button-secondary" id="reject-member" data-user-id="<?php echo esc_attr($user->ID); ?>">Reject Application</button>
        </p>
        <div id="verification-message"></div>
    </div>
    <?php endif; ?>
    <?php
}
add_action('show_user_profile', 'daystar_add_member_profile_fields');
add_action('edit_user_profile', 'daystar_add_member_profile_fields');

/**
 * Save custom member profile fields
 */
function daystar_save_member_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    // Save member status
    if (isset($_POST['member_status'])) {
        update_user_meta($user_id, 'member_status', sanitize_text_field($_POST['member_status']));
    }
    
    // Save personal information
    if (isset($_POST['id_number'])) {
        update_user_meta($user_id, 'id_number', sanitize_text_field($_POST['id_number']));
    }
    
    if (isset($_POST['date_of_birth'])) {
        update_user_meta($user_id, 'date_of_birth', sanitize_text_field($_POST['date_of_birth']));
    }
    
    if (isset($_POST['gender'])) {
        update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));
    }
    
    if (isset($_POST['marital_status'])) {
        update_user_meta($user_id, 'marital_status', sanitize_text_field($_POST['marital_status']));
    }
    
    // Save contact information
    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    
    if (isset($_POST['alt_phone'])) {
        update_user_meta($user_id, 'alt_phone', sanitize_text_field($_POST['alt_phone']));
    }
    
    if (isset($_POST['physical_address'])) {
        update_user_meta($user_id, 'physical_address', sanitize_textarea_field($_POST['physical_address']));
    }
    
    if (isset($_POST['city'])) {
        update_user_meta($user_id, 'city', sanitize_text_field($_POST['city']));
    }
    
    if (isset($_POST['postal_code'])) {
        update_user_meta($user_id, 'postal_code', sanitize_text_field($_POST['postal_code']));
    }
    
    // Save employment information
    if (isset($_POST['employment_status'])) {
        update_user_meta($user_id, 'employment_status', sanitize_text_field($_POST['employment_status']));
    }
    
    if (isset($_POST['employer'])) {
        update_user_meta($user_id, 'employer', sanitize_text_field($_POST['employer']));
    }
    
    if (isset($_POST['job_title'])) {
        update_user_meta($user_id, 'job_title', sanitize_text_field($_POST['job_title']));
    }
    
    if (isset($_POST['monthly_income'])) {
        update_user_meta($user_id, 'monthly_income', floatval($_POST['monthly_income']));
    }
    
    if (isset($_POST['employment_duration'])) {
        update_user_meta($user_id, 'employment_duration', floatval($_POST['employment_duration']));
    }
    
    if (isset($_POST['kra_pin'])) {
        update_user_meta($user_id, 'kra_pin', sanitize_text_field($_POST['kra_pin']));
    }
    
    // Save contribution information
    if (isset($_POST['initial_contribution'])) {
        update_user_meta($user_id, 'initial_contribution', floatval($_POST['initial_contribution']));
    }
    
    if (isset($_POST['monthly_contribution'])) {
        update_user_meta($user_id, 'monthly_contribution', floatval($_POST['monthly_contribution']));
    }
}
add_action('personal_options_update', 'daystar_save_member_profile_fields');
add_action('edit_user_profile_update', 'daystar_save_member_profile_fields');

/**
 * AJAX handler for member verification
 */
function daystar_verify_member() {
    // Check nonce for security
    check_ajax_referer('daystar_admin_nonce', 'nonce');
    
    // Check if user has permission
    if (!current_user_can('administrator')) {
        wp_send_json_error('You do not have permission to perform this action.');
        exit;
    }
    
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $action = isset($_POST['verification_action']) ? sanitize_text_field($_POST['verification_action']) : '';
    
    if (!$user_id || !$action) {
        wp_send_json_error('Invalid request parameters.');
        exit;
    }
    
    $user = get_user_by('id', $user_id);
    if (!$user || !in_array('member', $user->roles)) {
        wp_send_json_error('Invalid user or user is not a member.');
        exit;
    }
    
    $current_user = wp_get_current_user();
    
    if ($action === 'approve') {
        // Update member status to active
        update_user_meta($user_id, 'member_status', 'active');
        update_user_meta($user_id, 'verification_date', current_time('mysql'));
        update_user_meta($user_id, 'verified_by', $current_user->ID);
        
        // Send approval email to member
        $subject = 'Your Daystar Co-op Membership has been Approved';
        $message = "Dear {$user->first_name},\n\n";
        $message .= "Congratulations! Your membership application for Daystar Multi-Purpose Co-op Society has been approved.\n\n";
        $message .= "You can now log in to your member dashboard using your username and password at " . home_url('/login') . "\n\n";
        $message .= "Your Member Number: " . get_user_meta($user_id, 'member_number', true) . "\n\n";
        $message .= "Please remember to make your initial contribution as indicated during registration.\n\n";
        $message .= "If you have any questions, please contact our support team.\n\n";
        $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
        
        wp_mail($user->user_email, $subject, $message);
        
        wp_send_json_success('Member has been verified and approved successfully.');
    } elseif ($action === 'reject') {
        // Update member status to rejected
        update_user_meta($user_id, 'member_status', 'rejected');
        
        // Send rejection email to member
        $subject = 'Daystar Co-op Membership Application Status';
        $message = "Dear {$user->first_name},\n\n";
        $message .= "We regret to inform you that your membership application for Daystar Multi-Purpose Co-op Society has been declined.\n\n";
        $message .= "If you believe this is an error or would like more information, please contact our support team.\n\n";
        $message .= "Best regards,\nDaystar Multi-Purpose Co-op Society";
        
        wp_mail($user->user_email, $subject, $message);
        
        wp_send_json_success('Member application has been rejected.');
    } else {
        wp_send_json_error('Invalid action specified.');
    }
    
    exit;
}
add_action('wp_ajax_daystar_verify_member', 'daystar_verify_member');

/**
 * Add member verification JavaScript to admin
 */
function daystar_admin_verification_scripts() {
    $screen = get_current_screen();
    
    // Only add to user edit screen
    if ($screen->id !== 'user-edit') {
        return;
    }
    
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#verify-member').on('click', function() {
            if (confirm('Are you sure you want to verify and approve this member?')) {
                var userId = $(this).data('user-id');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'daystar_verify_member',
                        nonce: '<?php echo wp_create_nonce('daystar_admin_nonce'); ?>',
                        user_id: userId,
                        verification_action: 'approve'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#verification-message').html('<div class="notice notice-success"><p>' + response.data + '</p></div>');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#verification-message').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                        }
                    }
                });
            }
        });
        
        $('#reject-member').on('click', function() {
            if (confirm('Are you sure you want to reject this member application?')) {
                var userId = $(this).data('user-id');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'daystar_verify_member',
                        nonce: '<?php echo wp_create_nonce('daystar_admin_nonce'); ?>',
                        user_id: userId,
                        verification_action: 'reject'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#verification-message').html('<div class="notice notice-success"><p>' + response.data + '</p></div>');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#verification-message').html('<div class="notice notice-error"><p>' + response.data + '</p></div>');
                        }
                    }
                });
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'daystar_admin_verification_scripts');

/**
 * Add pending members count to admin menu
 */
function daystar_add_pending_members_count() {
    global $menu;
    
    // Only for administrators
    if (!current_user_can('administrator')) {
        return;
    }
    
    // Count pending members
    $args = array(
        'meta_key' => 'member_status',
        'meta_value' => 'pending',
        'role' => 'member',
        'count_total' => true
    );
    
    $pending_count = count(get_users($args));
    
    if ($pending_count > 0) {
        // Find the users menu
        foreach ($menu as $key => $value) {
            if ($value[2] === 'users.php') {
                $menu[$key][0] .= ' <span class="awaiting-mod count-' . $pending_count . '"><span class="pending-count">' . $pending_count . '</span></span>';
                break;
            }
        }
    }
}
add_action('admin_menu', 'daystar_add_pending_members_count');

/**
 * Add member status column to users list
 */
function daystar_add_member_status_column($columns) {
    $columns['member_status'] = 'Member Status';
    return $columns;
}
add_filter('manage_users_columns', 'daystar_add_member_status_column');

/**
 * Display member status in users list
 */
function daystar_show_member_status_column_content($value, $column_name, $user_id) {
    if ($column_name === 'member_status') {
        $user = get_user_by('id', $user_id);
        
        // Only show for members
        if (!in_array('member', $user->roles)) {
            return 'N/A';
        }
        
        $status = get_user_meta($user_id, 'member_status', true);
        
        switch ($status) {
            case 'pending':
                return '<span class="member-status pending">Pending</span>';
            case 'active':
                return '<span class="member-status active">Active</span>';
            case 'suspended':
                return '<span class="member-status suspended">Suspended</span>';
            case 'inactive':
                return '<span class="member-status inactive">Inactive</span>';
            case 'rejected':
                return '<span class="member-status rejected">Rejected</span>';
            default:
                return 'Unknown';
        }
    }
    
    return $value;
}
add_filter('manage_users_custom_column', 'daystar_show_member_status_column_content', 10, 3);

/**
 * Add CSS for member status in admin
 */
function daystar_admin_member_status_css() {
    ?>
    <style type="text/css">
        .member-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
        }
        .member-status.pending {
            background-color: #f0ad4e;
            color: #fff;
        }
        .member-status.active {
            background-color: #5cb85c;
            color: #fff;
        }
        .member-status.suspended {
            background-color: #d9534f;
            color: #fff;
        }
        .member-status.inactive {
            background-color: #777;
            color: #fff;
        }
        .member-status.rejected {
            background-color: #d9534f;
            color: #fff;
        }
    </style>
    <?php
}
add_action('admin_head', 'daystar_admin_member_status_css');

/**
 * Make member status sortable in users list
 */
function daystar_make_member_status_sortable($columns) {
    $columns['member_status'] = 'member_status';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'daystar_make_member_status_sortable');

/**
 * Sort users by member status
 */
function daystar_sort_by_member_status($query) {
    if (!is_admin()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ($orderby === 'member_status') {
        $query->set('meta_key', 'member_status');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_users', 'daystar_sort_by_member_status');

/**
 * Add member status filter to users list
 */
function daystar_add_member_status_filter() {
    $screen = get_current_screen();
    
    if ($screen->id !== 'users') {
        return;
    }
    
    $status = isset($_GET['member_status']) ? $_GET['member_status'] : '';
    ?>
    <label for="filter-by-member-status" class="screen-reader-text">Filter by member status</label>
    <select name="member_status" id="filter-by-member-status">
        <option value="">All Member Statuses</option>
        <option value="pending" <?php selected($status, 'pending'); ?>>Pending</option>
        <option value="active" <?php selected($status, 'active'); ?>>Active</option>
        <option value="suspended" <?php selected($status, 'suspended'); ?>>Suspended</option>
        <option value="inactive" <?php selected($status, 'inactive'); ?>>Inactive</option>
        <option value="rejected" <?php selected($status, 'rejected'); ?>>Rejected</option>
    </select>
    <?php
}
add_action('restrict_manage_users', 'daystar_add_member_status_filter');

/**
 * Filter users by member status
 */
function daystar_filter_users_by_member_status($query) {
    global $pagenow;
    
    if (!is_admin() || $pagenow !== 'users.php') {
        return;
    }
    
    if (isset($_GET['member_status']) && !empty($_GET['member_status'])) {
        $meta_query = array(
            array(
                'key' => 'member_status',
                'value' => sanitize_text_field($_GET['member_status']),
                'compare' => '='
            )
        );
        
        $query->set('meta_query', $meta_query);
    }
}
add_action('pre_get_users', 'daystar_filter_users_by_member_status');
