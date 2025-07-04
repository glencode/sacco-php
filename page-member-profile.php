<?php
/**
 * Template Name: Member Profile
 *
 * This is the template for the member profile page.
 *
 * @package Daystar
 */

require_once get_template_directory() . '/includes/auth-helper.php';

$current_user = daystar_check_member_access(home_url('/member-dashboard'));

// Get member data
$user_id = $current_user->ID;
$member_number = get_user_meta($user_id, 'member_number', true);
$member_status = get_user_meta($user_id, 'member_status', true);
$registration_date = get_user_meta($user_id, 'registration_date', true);

// Get additional user meta data
$phone_number = get_user_meta($user_id, 'phone_number', true);
$id_number = get_user_meta($user_id, 'id_number', true);
$date_of_birth = get_user_meta($user_id, 'date_of_birth', true);
$employment_type = get_user_meta($user_id, 'employment_type', true);
$department = get_user_meta($user_id, 'department', true);
$employee_number = get_user_meta($user_id, 'employee_number', true);
$next_of_kin_name = get_user_meta($user_id, 'next_of_kin_name', true);
$next_of_kin_phone = get_user_meta($user_id, 'next_of_kin_phone', true);
$next_of_kin_relationship = get_user_meta($user_id, 'next_of_kin_relationship', true);
$address = get_user_meta($user_id, 'address', true);
$city = get_user_meta($user_id, 'city', true);
$postal_code = get_user_meta($user_id, 'postal_code', true);
$membership_date = get_user_meta($user_id, 'membership_date', true);

// Mock financial data - replace with actual database queries
$financial_summary = array(
    'total_deposits' => 150000,
    'share_capital' => 25000,
    'total_shares' => 125,
    'outstanding_loans' => 120000,
    'loan_limit' => 450000,
    'dividend_earned' => 8500,
    'interest_earned' => 12000
);

// Handle form submission
if ($_POST && wp_verify_nonce($_POST['profile_nonce'], 'update_profile')) {
    // Update user data
    $user_data = array(
        'ID' => $user_id,
        'display_name' => sanitize_text_field($_POST['display_name']),
        'user_email' => sanitize_email($_POST['user_email'])
    );
    
    wp_update_user($user_data);
    
    // Update user meta
    update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone_number']));
    update_user_meta($user_id, 'date_of_birth', sanitize_text_field($_POST['date_of_birth']));
    update_user_meta($user_id, 'employment_type', sanitize_text_field($_POST['employment_type']));
    update_user_meta($user_id, 'department', sanitize_text_field($_POST['department']));
    update_user_meta($user_id, 'employee_number', sanitize_text_field($_POST['employee_number']));
    update_user_meta($user_id, 'next_of_kin_name', sanitize_text_field($_POST['next_of_kin_name']));
    update_user_meta($user_id, 'next_of_kin_phone', sanitize_text_field($_POST['next_of_kin_phone']));
    update_user_meta($user_id, 'next_of_kin_relationship', sanitize_text_field($_POST['next_of_kin_relationship']));
    update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
    update_user_meta($user_id, 'city', sanitize_text_field($_POST['city']));
    update_user_meta($user_id, 'postal_code', sanitize_text_field($_POST['postal_code']));
    
    $success_message = 'Profile updated successfully!';
}

get_header();
?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 dashboard-sidebar">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Daystar Logo" class="sidebar-logo">
                        <button class="sidebar-toggle d-lg-none">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <nav class="sidebar-nav">
                        <ul>
                            <li><a href="<?php echo home_url('/member-dashboard?page=dashboard'); ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="active"><a href="<?php echo home_url('/member-dashboard?page=profile'); ?>"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a href="<?php echo home_url('/member-dashboard?page=loans'); ?>"><i class="fas fa-money-bill-wave"></i> Loans</a></li>
                            <li><a href="<?php echo home_url('/member-dashboard?page=savings'); ?>"><i class="fas fa-piggy-bank"></i> Savings</a></li>
                            <li><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10 dashboard-main">
                <div class="content">
                    <div class="content-header">
                        <h1>Member Profile</h1>
                    </div>

                    <div class="content-body">
                        <!-- Profile Header -->
                        <div class="profile-header-card">
                            <div class="profile-banner">
                                <div class="profile-avatar">
                                    <div class="avatar-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <h2><?php echo esc_html($current_user->display_name); ?></h2>
                                    <p class="member-details">
                                        <span class="member-number">Member #<?php echo esc_html($member_number ?: 'N/A'); ?></span>
                                        <span class="separator">•</span>
                                        <span class="membership-date">Member since <?php echo $membership_date ? date('M Y', strtotime($membership_date)) : 'N/A'; ?></span>
                                    </p>
                                    <div class="profile-stats">
                                        <div class="stat-item">
                                            <span class="stat-value">KSh <?php echo number_format($financial_summary['total_deposits']); ?></span>
                                            <span class="stat-label">Total Deposits</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?php echo $financial_summary['total_shares']; ?></span>
                                            <span class="stat-label">Shares Owned</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value">KSh <?php echo number_format($financial_summary['loan_limit']); ?></span>
                                            <span class="stat-label">Loan Limit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Personal Information -->
                                <div class="card profile-section">
                                    <div class="card-header">
                                        <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                                        <button class="btn btn-sm btn-outline-primary" onclick="toggleEdit('personal')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($success_message)): ?>
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <form id="personal-info-form" method="post" action="">
                                            <?php wp_nonce_field('update_profile', 'profile_nonce'); ?>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="display_name">Full Name</label>
                                                        <input type="text" id="display_name" name="display_name" 
                                                               value="<?php echo esc_attr($current_user->display_name); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="user_email">Email Address</label>
                                                        <input type="email" id="user_email" name="user_email" 
                                                               value="<?php echo esc_attr($current_user->user_email); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone_number">Phone Number</label>
                                                        <input type="tel" id="phone_number" name="phone_number" 
                                                               value="<?php echo esc_attr($phone_number); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="id_number">ID Number</label>
                                                        <input type="text" id="id_number" name="id_number" 
                                                               value="<?php echo esc_attr($id_number); ?>" 
                                                               class="form-control" readonly>
                                                        <small class="form-text text-muted">Contact admin to change ID number</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_of_birth">Date of Birth</label>
                                                        <input type="date" id="date_of_birth" name="date_of_birth" 
                                                               value="<?php echo esc_attr($date_of_birth); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="employment_type">Employment Type</label>
                                                        <select id="employment_type" name="employment_type" class="form-control" disabled>
                                                            <option value="">Select Employment Type</option>
                                                            <option value="permanent" <?php selected($employment_type, 'permanent'); ?>>Permanent</option>
                                                            <option value="contract" <?php selected($employment_type, 'contract'); ?>>Contract</option>
                                                            <option value="part-time" <?php selected($employment_type, 'part-time'); ?>>Part-time</option>
                                                            <option value="casual" <?php selected($employment_type, 'casual'); ?>>Casual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="department">Department</label>
                                                        <input type="text" id="department" name="department" 
                                                               value="<?php echo esc_attr($department); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="employee_number">Employee Number</label>
                                                        <input type="text" id="employee_number" name="employee_number" 
                                                               value="<?php echo esc_attr($employee_number); ?>" 
                                                               class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions" style="display: none;">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Save Changes
                                                </button>
                                                <button type="button" class="btn btn-secondary" onclick="cancelEdit('personal')">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Next of Kin Information -->
                                <div class="card profile-section">
                                    <div class="card-header">
                                        <h4><i class="fas fa-users"></i> Next of Kin Information</h4>
                                        <button class="btn btn-sm btn-outline-primary" onclick="toggleEdit('nextofkin')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="next_of_kin_name">Next of Kin Name</label>
                                                    <input type="text" id="next_of_kin_name" name="next_of_kin_name" 
                                                           value="<?php echo esc_attr($next_of_kin_name); ?>" 
                                                           class="form-control" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="next_of_kin_phone">Next of Kin Phone</label>
                                                    <input type="tel" id="next_of_kin_phone" name="next_of_kin_phone" 
                                                           value="<?php echo esc_attr($next_of_kin_phone); ?>" 
                                                           class="form-control" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="next_of_kin_relationship">Relationship</label>
                                                    <select id="next_of_kin_relationship" name="next_of_kin_relationship" class="form-control" disabled>
                                                        <option value="">Select Relationship</option>
                                                        <option value="spouse" <?php selected($next_of_kin_relationship, 'spouse'); ?>>Spouse</option>
                                                        <option value="parent" <?php selected($next_of_kin_relationship, 'parent'); ?>>Parent</option>
                                                        <option value="child" <?php selected($next_of_kin_relationship, 'child'); ?>>Child</option>
                                                        <option value="sibling" <?php selected($next_of_kin_relationship, 'sibling'); ?>>Sibling</option>
                                                        <option value="other" <?php selected($next_of_kin_relationship, 'other'); ?>>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="card profile-section">
                                    <div class="card-header">
                                        <h4><i class="fas fa-map-marker-alt"></i> Address Information</h4>
                                        <button class="btn btn-sm btn-outline-primary" onclick="toggleEdit('address')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address">Physical Address</label>
                                                    <textarea id="address" name="address" rows="3" 
                                                              class="form-control" readonly><?php echo esc_textarea($address); ?></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city">City/Town</label>
                                                    <input type="text" id="city" name="city" 
                                                           value="<?php echo esc_attr($city); ?>" 
                                                           class="form-control" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="postal_code">Postal Code</label>
                                                    <input type="text" id="postal_code" name="postal_code" 
                                                           value="<?php echo esc_attr($postal_code); ?>" 
                                                           class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Financial Summary -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-chart-pie"></i> Financial Summary</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="financial-cards">
                                            <div class="financial-card deposits">
                                                <div class="card-icon">
                                                    <i class="fas fa-piggy-bank"></i>
                                                </div>
                                                <div class="card-content">
                                                    <h5>Total Deposits</h5>
                                                    <p class="amount">KSh <?php echo number_format($financial_summary['total_deposits']); ?></p>
                                                    <small class="growth">+5.2% this month</small>
                                                </div>
                                            </div>
                                            
                                            <div class="financial-card shares">
                                                <div class="card-icon">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                                <div class="card-content">
                                                    <h5>Share Capital</h5>
                                                    <p class="amount">KSh <?php echo number_format($financial_summary['share_capital']); ?></p>
                                                    <small><?php echo $financial_summary['total_shares']; ?> shares @ KSh 200</small>
                                                </div>
                                            </div>
                                            
                                            <div class="financial-card loans">
                                                <div class="card-icon">
                                                    <i class="fas fa-credit-card"></i>
                                                </div>
                                                <div class="card-content">
                                                    <h5>Outstanding Loans</h5>
                                                    <p class="amount">KSh <?php echo number_format($financial_summary['outstanding_loans']); ?></p>
                                                    <small><?php echo round(($financial_summary['outstanding_loans'] / $financial_summary['loan_limit']) * 100, 1); ?>% of limit used</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="financial-actions mt-3">
                                            <a href="<?php echo home_url('/loan-dashboard'); ?>" class="btn btn-primary btn-block">
                                                <i class="fas fa-chart-line"></i> View Full Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="quick-actions-list">
                                            <a href="<?php echo home_url('/loan-application-enhanced'); ?>" class="quick-action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-plus-circle"></i>
                                                </div>
                                                <div class="action-content">
                                                    <h5>Apply for Loan</h5>
                                                    <p>Submit a new loan application</p>
                                                </div>
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <a href="#" class="quick-action-item" onclick="changePassword()">
                                                <div class="action-icon">
                                                    <i class="fas fa-key"></i>
                                                </div>
                                                <div class="action-content">
                                                    <h5>Change Password</h5>
                                                    <p>Update your account password</p>
                                                </div>
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <a href="<?php echo home_url('/contact-us'); ?>" class="quick-action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-headset"></i>
                                                </div>
                                                <div class="action-content">
                                                    <h5>Contact Support</h5>
                                                    <p>Get help with your account</p>
                                                </div>
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">
                    <i class="fas fa-key"></i> Change Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="password-change-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                        <small class="form-text text-muted">Password must be at least 8 characters long</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Profile editing functionality
function toggleEdit(section) {
    const form = document.getElementById(section === 'personal' ? 'personal-info-form' : section + '-form');
    const inputs = form.querySelectorAll('input, select, textarea');
    const actions = form.querySelector('.form-actions');
    const editBtn = form.closest('.card').querySelector('.btn-outline-primary');
    
    inputs.forEach(input => {
        if (input.name !== 'id_number') { // ID number should remain readonly
            input.readOnly = false;
            input.disabled = false;
        }
    });
    
    if (actions) {
        actions.style.display = 'block';
    }
    
    editBtn.style.display = 'none';
}

function cancelEdit(section) {
    const form = document.getElementById(section === 'personal' ? 'personal-info-form' : section + '-form');
    const inputs = form.querySelectorAll('input, select, textarea');
    const actions = form.querySelector('.form-actions');
    const editBtn = form.closest('.card').querySelector('.btn-outline-primary');
    
    // Reset form to original values
    form.reset();
    
    inputs.forEach(input => {
        input.readOnly = true;
        input.disabled = true;
    });
    
    if (actions) {
        actions.style.display = 'none';
    }
    
    editBtn.style.display = 'inline-block';
}

// Password change functionality
function changePassword() {
    $('#passwordModal').modal('show');
}

// Handle password change form submission
document.getElementById('password-change-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Validate passwords
    if (newPassword.length < 8) {
        alert('New password must be at least 8 characters long.');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('New password and confirmation do not match.');
        return;
    }
    
    // Here you would typically send an AJAX request to update the password
    // For now, we'll just show a success message
    alert('Password changed successfully!');
    $('#passwordModal').modal('hide');
    this.reset();
});

// Form validation for profile updates
document.getElementById('personal-info-form').addEventListener('submit', function(e) {
    const email = document.getElementById('user_email').value;
    const phone = document.getElementById('phone_number').value;
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return;
    }
    
    // Basic phone validation (Kenyan format)
    const phoneRegex = /^(\+254|0)[17]\d{8}$/;
    if (phone && !phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid Kenyan phone number (e.g., +254712345678 or 0712345678).');
        return;
    }
});

// Auto-hide success messages after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

<?php
get_footer();
