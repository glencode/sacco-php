<?php
/**
 * Template Name: Member Profile
 *
 * The template for displaying the member profile information and settings.
 *
 * @package sacco-php
 */

get_header();

// Get current user
$current_user = wp_get_current_user();
?>

<main id="primary" class="site-main">

	<section class="member-header bg-primary text-white py-4">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<h1 class="member-dashboard-title">My Profile</h1>
				</div>
				<div class="col-md-6 text-md-end">
					<p class="mb-0">Welcome, <?php echo esc_html($current_user->display_name); ?>!</p>
					<p class="mb-0 member-id">Member ID: <?php echo esc_html(get_user_meta($current_user->ID, 'member_id', true) ?: 'MEM' . str_pad($current_user->ID, 6, '0', STR_PAD_LEFT)); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="member-dashboard-section py-5">
		<div class="container">
			<div class="row">
				<!-- Sidebar Navigation -->
				<div class="col-lg-3 mb-4 mb-lg-0">
					<div class="member-sidebar">
						<div class="list-group">
							<a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
							<a href="<?php echo esc_url(home_url('member-profile')); ?>" class="list-group-item list-group-item-action active">
								<i class="fas fa-user"></i> My Profile
							</a>
							<a href="<?php echo esc_url(home_url('member-savings')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-piggy-bank"></i> My Savings
							</a>
							<a href="<?php echo esc_url(home_url('member-loans')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-hand-holding-usd"></i> My Loans
							</a>
							<a href="<?php echo esc_url(home_url('member-transactions')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-exchange-alt"></i> Transactions
							</a>
							<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="list-group-item list-group-item-action text-danger">
								<i class="fas fa-sign-out-alt"></i> Logout
							</a>
						</div>
					</div>
				</div>
				
				<!-- Main Content -->
					<div id="member-profile-section" class="col-lg-9 member-content-section">
					<!-- Personal Information -->
					<!-- Profile Summary -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Account Overview</h2>
						</div>
						<div class="dashboard-card-body">
							<div class="row align-items-center">
								<div class="col-md-3 mb-4 mb-md-0 text-center">
									<div class="profile-avatar">
										<?php if ($current_user->user_email) : ?>
											<img src="<?php echo esc_url(get_avatar_url($current_user->user_email, array('size' => 150))); ?>" alt="Profile Picture" class="img-fluid rounded-circle">
										<?php else : ?>
											<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-avatar.png'); ?>" alt="Default Avatar" class="img-fluid rounded-circle">
										<?php endif; ?>
										<div class="mt-2">
											<button type="button" class="btn btn-sm btn-outline-primary" id="change-photo">
												<i class="fas fa-camera"></i> Change Photo
											</button>
										</div>
									</div>
								</div>
								<div class="col-md-9">
									<div class="profile-summary">
										<h3 class="profile-name"><?php echo esc_html($current_user->display_name); ?></h3>
										<div class="profile-status">
											<span class="badge bg-success">Active Member</span>
											<span class="badge bg-primary">Since <?php echo date('F Y', strtotime($current_user->user_registered)); ?></span>
										</div>
										
										<div class="profile-details mt-3">
											<div class="row">
												<div class="col-sm-6 mb-2">
													<div class="profile-detail-item">
														<span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
														<span class="detail-value"><?php echo esc_html($current_user->user_email); ?></span>
													</div>
												</div>
												<div class="col-sm-6 mb-2">
													<div class="profile-detail-item">
														<span class="detail-label"><i class="fas fa-phone"></i> Phone:</span>
														<span class="detail-value"><?php echo esc_html(get_user_meta($current_user->ID, 'phone', true) ?: '0700 XXX XXX'); ?></span>
													</div>
												</div>
												<div class="col-sm-6 mb-2">
													<div class="profile-detail-item">
														<span class="detail-label"><i class="fas fa-id-card"></i> ID Number:</span>
														<span class="detail-value"><?php echo esc_html(get_user_meta($current_user->ID, 'id_number', true) ?: 'XXXXX'); ?></span>
													</div>
												</div>
												<div class="col-sm-6 mb-2">
													<div class="profile-detail-item">
														<span class="detail-label"><i class="fas fa-map-marker-alt"></i> Branch:</span>
														<span class="detail-value"><?php echo esc_html(get_user_meta($current_user->ID, 'branch', true) ?: 'Main Branch'); ?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Profile Edit Form -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header d-flex justify-content-between align-items-center">
							<h2 class="dashboard-card-title">Personal Information</h2>
							<button type="button" class="btn btn-sm btn-outline-primary" id="edit-profile-btn">
								<i class="fas fa-edit"></i> Edit
							</button>
						</div>
						<div class="dashboard-card-body">
							<form id="profile-form">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="first-name" class="form-label">First Name</label>
										<input type="text" class="form-control" id="first-name" value="<?php echo esc_attr($current_user->first_name); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="last-name" class="form-label">Last Name</label>
										<input type="text" class="form-control" id="last-name" value="<?php echo esc_attr($current_user->last_name); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="email" value="<?php echo esc_attr($current_user->user_email); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="phone" class="form-label">Phone Number</label>
										<input type="tel" class="form-control" id="phone" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'phone', true) ?: '0700000000'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="id-number" class="form-label">ID Number</label>
										<input type="text" class="form-control" id="id-number" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'id_number', true) ?: '12345678'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="dob" class="form-label">Date of Birth</label>
										<input type="date" class="form-control" id="dob" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'dob', true) ?: '1990-01-01'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="gender" class="form-label">Gender</label>
										<select class="form-select" id="gender" disabled>
											<option value="male" <?php selected(get_user_meta($current_user->ID, 'gender', true), 'male'); ?>>Male</option>
											<option value="female" <?php selected(get_user_meta($current_user->ID, 'gender', true), 'female'); ?>>Female</option>
											<option value="other" <?php selected(get_user_meta($current_user->ID, 'gender', true), 'other'); ?>>Other</option>
										</select>
									</div>
									<div class="col-md-6 mb-3">
										<label for="occupation" class="form-label">Occupation</label>
										<input type="text" class="form-control" id="occupation" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'occupation', true) ?: 'Not specified'); ?>" disabled>
									</div>
								</div>
								
								<div id="profile-actions" style="display:none;">
									<button type="button" class="btn btn-secondary me-2" id="cancel-profile-btn">Cancel</button>
									<button type="submit" class="btn btn-primary" id="save-profile-btn">Save Changes</button>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Address Information -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header d-flex justify-content-between align-items-center">
							<h2 class="dashboard-card-title">Address Information</h2>
							<button type="button" class="btn btn-sm btn-outline-primary" id="edit-address-btn">
								<i class="fas fa-edit"></i> Edit
							</button>
						</div>
						<div class="dashboard-card-body">
							<form id="address-form">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="address" class="form-label">Physical Address</label>
										<input type="text" class="form-control" id="address" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'address', true) ?: '123 Main Street'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="postal-code" class="form-label">Postal Code</label>
										<input type="text" class="form-control" id="postal-code" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'postal_code', true) ?: '00100'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="city" class="form-label">City/Town</label>
										<input type="text" class="form-control" id="city" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'city', true) ?: 'Nairobi'); ?>" disabled>
									</div>
									<div class="col-md-6 mb-3">
										<label for="county" class="form-label">County</label>
										<input type="text" class="form-control" id="county" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'county', true) ?: 'Nairobi'); ?>" disabled>
									</div>
								</div>
								
								<div id="address-actions" style="display:none;">
									<button type="button" class="btn btn-secondary me-2" id="cancel-address-btn">Cancel</button>
									<button type="submit" class="btn btn-primary" id="save-address-btn">Save Changes</button>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Security Settings -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Security Settings</h2>
						</div>
						<div class="dashboard-card-body">
							<form id="security-form">
								<div class="mb-4">
									<label for="current-password" class="form-label">Change Password</label>
									<div class="row g-3 mb-2">
										<div class="col-md-4">
											<input type="password" class="form-control" id="current-password" placeholder="Current Password">
										</div>
										<div class="col-md-4">
											<input type="password" class="form-control" id="new-password" placeholder="New Password">
										</div>
										<div class="col-md-4">
											<input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password">
										</div>
									</div>
									<div>
										<button type="submit" class="btn btn-primary" id="change-password-btn">Update Password</button>
									</div>
								</div>
								
								<div class="mb-4">
									<h5>Two-Factor Authentication</h5>
									<div class="form-check form-switch mb-2">
										<input class="form-check-input" type="checkbox" id="enable-2fa">
										<label class="form-check-label" for="enable-2fa">Enable Two-Factor Authentication</label>
									</div>
									<p class="text-muted small">Add an extra layer of security to your account by requiring a verification code from your mobile device.</p>
								</div>
								
								<div class="mb-4">
									<h5>Account Activity</h5>
									<p>Last login: <strong><?php echo date('F j, Y, g:i a'); ?></strong> from <strong>Nairobi, Kenya</strong></p>
									<button type="button" class="btn btn-outline-primary btn-sm" id="view-activity-btn">View Activity Log</button>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Notification Preferences -->
					<div class="dashboard-card">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Notification Preferences</h2>
						</div>
						<div class="dashboard-card-body">
							<form id="notification-form">
								<div class="row">
									<div class="col-md-6 mb-4">
										<h5>Email Notifications</h5>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="email-account" checked>
											<label class="form-check-label" for="email-account">Account Updates</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="email-transactions" checked>
											<label class="form-check-label" for="email-transactions">Transaction Alerts</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="email-statements" checked>
											<label class="form-check-label" for="email-statements">Monthly Statements</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="email-marketing">
											<label class="form-check-label" for="email-marketing">Promotions & Newsletters</label>
										</div>
									</div>
									
									<div class="col-md-6 mb-4">
										<h5>SMS Notifications</h5>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="sms-account" checked>
											<label class="form-check-label" for="sms-account">Account Updates</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="sms-transactions" checked>
											<label class="form-check-label" for="sms-transactions">Transaction Alerts</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="sms-due-dates" checked>
											<label class="form-check-label" for="sms-due-dates">Payment Due Dates</label>
										</div>
										<div class="form-check mb-2">
											<input class="form-check-input" type="checkbox" id="sms-marketing">
											<label class="form-check-label" for="sms-marketing">Promotions & Offers</label>
										</div>
									</div>
								</div>
								
								<div class="d-flex justify-content-end">
									<button type="submit" class="btn btn-primary" id="save-notifications-btn">Save Preferences</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Profile edit functionality
		const editProfileBtn = document.getElementById('edit-profile-btn');
		const cancelProfileBtn = document.getElementById('cancel-profile-btn');
		const profileForm = document.getElementById('profile-form');
		const profileActions = document.getElementById('profile-actions');
		const profileInputs = profileForm.querySelectorAll('input, select');
		
		editProfileBtn.addEventListener('click', function() {
			profileInputs.forEach(input => {
				input.disabled = false;
			});
			profileActions.style.display = 'block';
			editProfileBtn.style.display = 'none';
		});
		
		cancelProfileBtn.addEventListener('click', function() {
			profileInputs.forEach(input => {
				input.disabled = true;
			});
			profileActions.style.display = 'none';
			editProfileBtn.style.display = 'inline-block';
		});
		
		profileForm.addEventListener('submit', function(e) {
			e.preventDefault();
			// In a real application, this would make an AJAX call to update user profile
			alert('Profile information updated successfully!');
			profileInputs.forEach(input => {
				input.disabled = true;
			});
			profileActions.style.display = 'none';
			editProfileBtn.style.display = 'inline-block';
		});
		
		// Address edit functionality
		const editAddressBtn = document.getElementById('edit-address-btn');
		const cancelAddressBtn = document.getElementById('cancel-address-btn');
		const addressForm = document.getElementById('address-form');
		const addressActions = document.getElementById('address-actions');
		const addressInputs = addressForm.querySelectorAll('input, select');
		
		editAddressBtn.addEventListener('click', function() {
			addressInputs.forEach(input => {
				input.disabled = false;
			});
			addressActions.style.display = 'block';
			editAddressBtn.style.display = 'none';
		});
		
		cancelAddressBtn.addEventListener('click', function() {
			addressInputs.forEach(input => {
				input.disabled = true;
			});
			addressActions.style.display = 'none';
			editAddressBtn.style.display = 'inline-block';
		});
		
		addressForm.addEventListener('submit', function(e) {
			e.preventDefault();
			// In a real application, this would make an AJAX call to update address
			alert('Address information updated successfully!');
			addressInputs.forEach(input => {
				input.disabled = true;
			});
			addressActions.style.display = 'none';
			editAddressBtn.style.display = 'inline-block';
		});
		
		// Security form
		const securityForm = document.getElementById('security-form');
		securityForm.addEventListener('submit', function(e) {
			e.preventDefault();
			// In a real application, this would verify and update the password
			alert('Password updated successfully!');
			document.getElementById('current-password').value = '';
			document.getElementById('new-password').value = '';
			document.getElementById('confirm-password').value = '';
		});
		
		// Notification form
		const notificationForm = document.getElementById('notification-form');
		notificationForm.addEventListener('submit', function(e) {
			e.preventDefault();
			// In a real application, this would save notification preferences
			alert('Notification preferences saved successfully!');
		});
		
		// View activity log
		const viewActivityBtn = document.getElementById('view-activity-btn');
		viewActivityBtn.addEventListener('click', function() {
			alert('In a real application, this would show a modal with account activity history.');
		});
		
		// Change photo button
		const changePhotoBtn = document.getElementById('change-photo');
		changePhotoBtn.addEventListener('click', function() {
			alert('In a real application, this would open a file upload dialog to change your profile photo.');
		});
	});
</script>

<?php
get_footer(); 
?>