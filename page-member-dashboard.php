<?php
/**
 * Template Name: Member Dashboard
 *
 * The template for displaying the member dashboard.
 *
 * @package sacco-php
 */

get_header();

// Get current user
$current_user = wp_get_current_user();
?>

<style>
/* Color Hunt Palette Integration */
:root {
    --color-light-blue: #B1F0F7;
    --color-medium-blue: #81BFDA;
    --color-light-cream: #F5F0CD;
    --color-golden: #FADA7A;
}

.bg-primary {
    background-color: var(--color-medium-blue) !important;
}

.btn-primary {
    background-color: var(--color-medium-blue);
    border-color: var(--color-medium-blue);
}

.btn-primary:hover {
    background-color: #6ba8c4;
    border-color: #6ba8c4;
}

.btn-outline-primary {
    color: var(--color-medium-blue);
    border-color: var(--color-medium-blue);
}

.btn-outline-primary:hover {
    background-color: var(--color-medium-blue);
    border-color: var(--color-medium-blue);
}

.member-sidebar .list-group-item.active {
    background-color: var(--color-light-blue);
    border-color: var(--color-medium-blue);
    color: #333;
}

.member-sidebar .list-group-item:hover {
    background-color: var(--color-light-cream);
}

.member-support-card {
    background: linear-gradient(135deg, var(--color-light-cream), var(--color-golden));
    padding: 1.5rem;
    border-radius: 10px;
    border: 1px solid var(--color-golden);
}

.dashboard-card {
    background: white;
    border: 1px solid var(--color-light-blue);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(177, 240, 247, 0.3);
}

.dashboard-card-header {
    background: linear-gradient(135deg, var(--color-light-blue), var(--color-medium-blue));
    padding: 1rem 1.5rem;
    border-radius: 10px 10px 0 0;
    border-bottom: 1px solid var(--color-medium-blue);
}

.dashboard-card-title {
    color: #333;
    margin: 0;
    font-weight: 600;
}

.account-summary-item {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--color-light-cream), var(--color-golden));
    border-radius: 10px;
    border: 1px solid var(--color-golden);
}

.summary-icon {
    width: 60px;
    height: 60px;
    background: var(--color-medium-blue);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.quick-link-card {
    display: block;
    text-decoration: none;
    text-align: center;
    padding: 1.5rem 1rem;
    background: linear-gradient(135deg, var(--color-light-blue), var(--color-medium-blue));
    border-radius: 10px;
    transition: all 0.3s ease;
    color: #333;
    border: 1px solid var(--color-medium-blue);
}

.quick-link-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(129, 191, 218, 0.4);
    color: #333;
    text-decoration: none;
}

.quick-link-icon {
    width: 50px;
    height: 50px;
    background: var(--color-golden);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    color: #333;
    font-size: 1.2rem;
}

.savings-goal-card {
    background: white;
    border: 1px solid var(--color-light-blue);
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(177, 240, 247, 0.3);
}

.goal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.goal-badge.bg-danger {
    background-color: #e74c3c !important;
}

.goal-badge.bg-warning {
    background-color: var(--color-golden) !important;
    color: #333 !important;
}

.goal-badge.bg-info {
    background-color: var(--color-light-blue) !important;
    color: #333 !important;
}

.progress-bar.bg-success {
    background-color: var(--color-medium-blue) !important;
}

.announcement-item {
    background: var(--color-light-cream);
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid var(--color-golden);
}

.announcement-date {
    color: var(--color-medium-blue);
    font-weight: 600;
    font-size: 0.9rem;
}

.modal-header.bg-primary {
    background: linear-gradient(135deg, var(--color-medium-blue), var(--color-light-blue)) !important;
    color: #333 !important;
}

.btn-close {
    filter: brightness(0.7);
}

.bg-light {
    background-color: var(--color-light-cream) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(177, 240, 247, 0.1);
}

.badge.bg-success {
    background-color: var(--color-medium-blue) !important;
}

.badge.bg-primary {
    background-color: var(--color-golden) !important;
    color: #333 !important;
}

.text-success {
    color: var(--color-medium-blue) !important;
}
</style>

<main id="primary" class="site-main">

	<section class="member-header bg-primary text-white py-4">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<h1 class="member-dashboard-title">Member Dashboard</h1>
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
							<a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="list-group-item list-group-item-action active">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
							<a href="<?php echo esc_url(home_url('member-profile')); ?>" class="list-group-item list-group-item-action">
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
						
						<div class="member-support-card mt-4">
							<h4><i class="fas fa-headset"></i> Need Help?</h4>
							<p>Our support team is available to assist you with any questions or issues.</p>
							<div class="d-grid">
								<a href="<?php echo esc_url(home_url('contact')); ?>" class="btn btn-outline-primary">Contact Support</a>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Main Content -->
				<div class="col-lg-9">
					<div class="member-content-wrapper">
						<div id="member-dashboard-section" class="member-content-section current-section">
							<!-- Account Summary -->
							<div class="dashboard-card mb-4">
								<div class="dashboard-card-header">
									<h2 class="dashboard-card-title">Account Summary</h2>
								</div>
								<div class="dashboard-card-body">
									<div class="row">
										<div class="col-md-4 mb-4 mb-md-0">
											<div class="account-summary-item text-center">
												<div class="summary-icon">
													<i class="fas fa-piggy-bank"></i>
												</div>
												<h4>Total Savings</h4>
												<div class="summary-amount">KSh 125,000.00</div>
												<div class="summary-change text-success">
													<i class="fas fa-arrow-up"></i> 3.5% this month
												</div>
											</div>
										</div>
										<div class="col-md-4 mb-4 mb-md-0">
											<div class="account-summary-item text-center">
												<div class="summary-icon">
													<i class="fas fa-coins"></i>
												</div>
												<h4>Total Shares</h4>
												<div class="summary-amount">KSh 75,000.00</div>
												<div class="summary-change text-success">
													<i class="fas fa-arrow-up"></i> 2.1% this month
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="account-summary-item text-center">
												<div class="summary-icon">
													<i class="fas fa-hand-holding-usd"></i>
												</div>
												<h4>Outstanding Loans</h4>
												<div class="summary-amount">KSh 230,000.00</div>
												<div class="summary-change text-danger">
													<i class="fas fa-arrow-down"></i> 5.2% this month
												</div>
											</div>
										</div>
									</div>
									
									<div class="account-summary-chart mt-4">
										<canvas id="account-summary-chart" height="100"></canvas>
									</div>
								</div>
							</div>
							
							<!-- Quick Links -->
							<div class="dashboard-card mb-4">
								<div class="dashboard-card-header">
									<h2 class="dashboard-card-title">Quick Actions</h2>
								</div>
								<div class="dashboard-card-body">
									<div class="row">
										<div class="col-6 col-md-3 mb-3">
											<a href="#" class="quick-link-card">
												<div class="quick-link-icon">
													<i class="fas fa-exchange-alt"></i>
												</div>
												<div class="quick-link-text">Transfer Funds</div>
											</a>
										</div>
										<div class="col-6 col-md-3 mb-3">
											<a href="#" class="quick-link-card">
												<div class="quick-link-icon">
													<i class="fas fa-file-invoice"></i>
												</div>
												<div class="quick-link-text">Request Statement</div>
											</a>
										</div>
										<div class="col-6 col-md-3 mb-3">
											<a href="<?php echo esc_url(home_url('loan-application')); ?>" class="quick-link-card">
												<div class="quick-link-icon">
													<i class="fas fa-hand-holding-usd"></i>
												</div>
												<div class="quick-link-text">Apply for Loan</div>
											</a>
										</div>
										<div class="col-6 col-md-3 mb-3">
											<a href="<?php echo esc_url(home_url('contact')); ?>" class="quick-link-card">
												<div class="quick-link-icon">
													<i class="fas fa-envelope"></i>
												</div>
												<div class="quick-link-text">Send Message</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Recent Transactions -->
							<div class="dashboard-card mb-4">
								<div class="dashboard-card-header d-flex justify-content-between align-items-center">
									<h2 class="dashboard-card-title">Recent Transactions</h2>
									<a href="<?php echo esc_url(home_url('member-transactions')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
								</div>
								<div class="dashboard-card-body">
									<div class="table-responsive">
										<table class="table table-hover transaction-table">
											<thead>
												<tr>
													<th>Date</th>
													<th>Description</th>
													<th>Type</th>
													<th>Amount</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>2023-07-15</td>
													<td>Salary Deposit</td>
													<td><span class="badge bg-success">Credit</span></td>
													<td>KSh 45,000.00</td>
													<td><span class="badge bg-success">Completed</span></td>
												</tr>
												<tr>
													<td>2023-07-10</td>
													<td>Loan Repayment</td>
													<td><span class="badge bg-danger">Debit</span></td>
													<td>KSh 12,500.00</td>
													<td><span class="badge bg-success">Completed</span></td>
												</tr>
												<tr>
													<td>2023-07-05</td>
													<td>Interest Earned</td>
													<td><span class="badge bg-success">Credit</span></td>
													<td>KSh 1,250.00</td>
													<td><span class="badge bg-success">Completed</span></td>
												</tr>
												<tr>
													<td>2023-07-01</td>
													<td>Dividend Payout</td>
													<td><span class="badge bg-success">Credit</span></td>
													<td>KSh 3,500.00</td>
													<td><span class="badge bg-success">Completed</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							<!-- Loan Summary -->
							<div class="dashboard-card mb-4">
								<div class="dashboard-card-header d-flex justify-content-between align-items-center">
									<h2 class="dashboard-card-title">Active Loans</h2>
									<a href="<?php echo esc_url(home_url('member-loans')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
								</div>
								<div class="dashboard-card-body">
									<div class="table-responsive">
										<table class="table table-hover loan-table">
											<thead>
												<tr>
													<th>Loan Type</th>
													<th>Issue Date</th>
													<th>Total Amount</th>
													<th>Balance</th>
													<th>Next Payment</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Development Loan</td>
													<td>2023-01-15</td>
													<td>KSh 250,000.00</td>
													<td>KSh 180,000.00</td>
													<td>KSh 12,500.00 (2023-08-15)</td>
													<td><span class="badge bg-primary">Active</span></td>
												</tr>
												<tr>
													<td>Emergency Loan</td>
													<td>2023-05-10</td>
													<td>KSh 50,000.00</td>
													<td>KSh 50,000.00</td>
													<td>KSh 5,000.00 (2023-08-10)</td>
													<td><span class="badge bg-primary">Active</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							<!-- Savings Goals -->
							<div class="dashboard-card">
								<div class="dashboard-card-header d-flex justify-content-between align-items-center">
									<h2 class="dashboard-card-title">My Savings Goals</h2>
									<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">
										<i class="fas fa-plus"></i> Add New Goal
									</button>
								</div>
								<div class="dashboard-card-body">
									<?php
									// Get current user's savings goals
									$goals_query = new WP_Query(array(
										'post_type' => 'savings_goal',
										'author' => get_current_user_id(),
										'posts_per_page' => -1,
										'orderby' => 'meta_value',
										'meta_key' => 'goal_priority',
										'meta_query' => array(
											array(
												'key' => 'goal_priority',
												'value' => array('high', 'medium', 'low'),
												'compare' => 'IN'
											)
										)
									));
									
									if ($goals_query->have_posts()) : 
										?>
										<div class="row">
											<?php while ($goals_query->have_posts()) : $goals_query->the_post(); 
												// Get goal meta data
												$goal_amount = get_post_meta(get_the_ID(), 'goal_amount', true) ?: 0;
												$current_amount = get_post_meta(get_the_ID(), 'current_amount', true) ?: 0;
												$target_date = get_post_meta(get_the_ID(), 'target_date', true);
												$goal_category = get_post_meta(get_the_ID(), 'goal_category', true);
												$priority = get_post_meta(get_the_ID(), 'goal_priority', true);
												
												// Calculate progress percentage
												$progress = 0;
												if ($goal_amount > 0) {
													$progress = ($current_amount / $goal_amount) * 100;
													$progress = min(100, round($progress));
												}
												
												// Format target date
												$formatted_date = $target_date ? date_i18n(get_option('date_format'), strtotime($target_date)) : '';
												
												// Icon based on category
												$category_icons = array(
													'emergency' => 'fa-umbrella',
													'education' => 'fa-graduation-cap',
													'home' => 'fa-home',
													'vehicle' => 'fa-car',
													'vacation' => 'fa-plane',
													'wedding' => 'fa-ring',
													'retirement' => 'fa-umbrella-beach',
													'business' => 'fa-briefcase',
													'other' => 'fa-piggy-bank'
												);
												$icon = isset($category_icons[$goal_category]) ? $category_icons[$goal_category] : 'fa-piggy-bank';
												
												// Badge color based on priority
												$priority_colors = array(
													'high' => 'bg-danger',
													'medium' => 'bg-warning',
													'low' => 'bg-info'
												);
												$badge_color = isset($priority_colors[$priority]) ? $priority_colors[$priority] : 'bg-secondary';
											?>
											<div class="col-lg-4 col-md-6 mb-4">
												<div class="savings-goal-card h-100">
													<div class="goal-header">
														<h4><i class="fas <?php echo esc_attr($icon); ?> me-2"></i> <?php the_title(); ?></h4>
														<span class="goal-badge <?php echo esc_attr($badge_color); ?>"><?php echo ucfirst(esc_html($priority)); ?></span>
													</div>
													
													<div class="goal-progress">
														<div class="progress">
															<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo esc_attr($progress); ?>%" 
																aria-valuenow="<?php echo esc_attr($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<div class="goal-amounts">
															<span>KSh <?php echo number_format($current_amount); ?></span>
															<span><?php echo esc_html($progress); ?>%</span>
															<span>KSh <?php echo number_format($goal_amount); ?></span>
														</div>
													</div>
													
													<div class="goal-footer">
														<div class="goal-date">
															<i class="far fa-calendar-alt"></i> Target: <?php echo esc_html($formatted_date); ?>
														</div>
														<div class="goal-actions">
															<button type="button" class="btn btn-sm btn-outline-primary add-funds-btn" data-goal-id="<?php echo get_the_ID(); ?>">
																<i class="fas fa-plus-circle"></i> Add Funds
															</button>
														</div>
													</div>
												</div>
											</div>
											<?php endwhile; wp_reset_postdata(); ?>
										</div>
									<?php else : ?>
										<div class="text-center py-4">
											<div class="mb-3">
												<i class="fas fa-piggy-bank fa-3x text-muted"></i>
											</div>
											<h3>No Savings Goals Yet</h3>
											<p class="text-muted">Create your first savings goal to start tracking your progress.</p>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">
												<i class="fas fa-plus"></i> Create a Goal
											</button>
										</div>
									<?php endif; ?>
								</div>
							</div>
							
							<!-- Announcements -->
							<div class="dashboard-card">
								<div class="dashboard-card-header">
									<h2 class="dashboard-card-title">Announcements</h2>
								</div>
								<div class="dashboard-card-body">
									<div class="announcement-item mb-3">
										<div class="announcement-date">July 20, 2023</div>
										<h4 class="announcement-title">Annual General Meeting Notice</h4>
										<div class="announcement-content">
											<p>The Annual General Meeting will be held on August 15, 2023, at the SACCO headquarters starting at 9:00 AM. All members are invited to attend.</p>
										</div>
										<a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
									</div>
									<div class="announcement-item">
										<div class="announcement-date">July 15, 2023</div>
										<h4 class="announcement-title">New Mobile Banking App Launch</h4>
										<div class="announcement-content">
											<p>We are excited to announce the launch of our new mobile banking app. Download now from the App Store or Google Play Store for a better banking experience.</p>
										</div>
										<a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Add Goal Modal -->
	<div class="modal fade" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="addGoalModalLabel">Create New Savings Goal</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="add-goal-form">
						<div class="row mb-3">
							<div class="col-md-6">
								<label for="goal-name" class="form-label">Goal Name</label>
								<input type="text" class="form-control" id="goal-name" name="goal_name" required>
							</div>
							<div class="col-md-6">
								<label for="goal-category" class="form-label">Category</label>
								<select class="form-select" id="goal-category" name="goal_category">
									<option value="emergency">Emergency Fund</option>
									<option value="education">Education</option>
									<option value="home">Home Purchase/Renovation</option>
									<option value="vehicle">Vehicle</option>
									<option value="vacation">Vacation</option>
									<option value="wedding">Wedding</option>
									<option value="retirement">Retirement</option>
									<option value="business">Business</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>
						
						<div class="row mb-3">
							<div class="col-md-6">
								<label for="goal-amount" class="form-label">Target Amount (KSh)</label>
								<input type="number" class="form-control" id="goal-amount" name="goal_amount" min="1000" step="1000" required>
							</div>
							<div class="col-md-6">
								<label for="goal-date" class="form-label">Target Date</label>
								<input type="date" class="form-control" id="goal-date" name="target_date" required>
							</div>
						</div>
						
						<div class="row mb-3">
							<div class="col-md-6">
								<label for="initial-deposit" class="form-label">Initial Deposit (KSh)</label>
								<input type="number" class="form-control" id="initial-deposit" name="initial_deposit" min="0" step="1000" value="0">
							</div>
							<div class="col-md-6">
								<label for="goal-priority" class="form-label">Priority</label>
								<select class="form-select" id="goal-priority" name="goal_priority">
									<option value="high">High</option>
									<option value="medium" selected>Medium</option>
									<option value="low">Low</option>
								</select>
							</div>
						</div>
						
						<div class="mb-3">
							<label for="goal-description" class="form-label">Description (Optional)</label>
							<textarea class="form-control" id="goal-description" name="goal_description" rows="3"></textarea>
						</div>
						
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="auto-deposit" name="auto_deposit">
								<label class="form-check-label" for="auto-deposit">
									Enable Automatic Deposits
								</label>
							</div>
						</div>
						
						<div id="auto-deposit-options" class="mb-3 p-3 bg-light rounded" style="display: none;">
							<div class="row">
								<div class="col-md-6">
									<label for="auto-deposit-amount" class="form-label">Deposit Amount (KSh)</label>
									<input type="number" class="form-control" id="auto-deposit-amount" name="auto_deposit_amount" min="100" step="100">
								</div>
								<div class="col-md-6">
									<label for="auto-deposit-frequency" class="form-label">Frequency</label>
									<select class="form-select" id="auto-deposit-frequency" name="auto_deposit_frequency">
										<option value="weekly">Weekly</option>
										<option value="biweekly">Every 2 Weeks</option>
										<option value="monthly">Monthly</option>
									</select>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" form="add-goal-form">Create Goal</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>