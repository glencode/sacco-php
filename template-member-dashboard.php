<?php
/**
 * Template Name: Member Dashboard Template
 *
 * The template for displaying the member dashboard.
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
													$progress = min(100, round(($current_amount / $goal_amount) * 100));
												}
												
												// Determine priority badge class
												$priority_class = 'bg-secondary';
												if ($priority === 'high') {
													$priority_class = 'bg-danger';
												} elseif ($priority === 'medium') {
													$priority_class = 'bg-warning';
												} elseif ($priority === 'low') {
													$priority_class = 'bg-info';
												}
												?>
												<div class="col-md-6 mb-4">
													<div class="goal-card">
														<div class="d-flex justify-content-between align-items-start mb-2">
															<h4 class="goal-title"><?php the_title(); ?></h4>
															<span class="badge <?php echo esc_attr($priority_class); ?>"><?php echo ucfirst(esc_html($priority)); ?></span>
														</div>
														<p class="goal-category small text-muted mb-1"><?php echo esc_html($goal_category); ?></p>
														<div class="progress mb-2">
															<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo esc_attr($progress); ?>%" aria-valuenow="<?php echo esc_attr($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<div class="d-flex justify-content-between">
															<span>KSh <?php echo number_format($current_amount); ?></span>
															<span>KSh <?php echo number_format($goal_amount); ?></span>
														</div>
														<div class="goal-footer mt-3 d-flex justify-content-between align-items-center">
															<div class="target-date small">
																<i class="far fa-calendar-alt"></i> Target: <?php echo esc_html($target_date); ?>
															</div>
															<div class="goal-actions">
																<button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateGoalModal" data-goal-id="<?php the_ID(); ?>">Update</button>
															</div>
														</div>
													</div>
												</div>
											<?php endwhile; wp_reset_postdata(); ?>
										</div>
									<?php else : ?>
										<div class="empty-goals text-center py-4">
											<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/empty-goals.svg'); ?>" alt="No Goals" class="mb-3" width="120">
											<h4>No Savings Goals Yet</h4>
											<p class="text-muted">Start tracking your financial goals by creating your first savings goal.</p>
											<button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addGoalModal">
												<i class="fas fa-plus"></i> Create First Goal
											</button>
										</div>
									<?php endif; ?>
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
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addGoalModalLabel">Add New Savings Goal</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="add-goal-form">
						<div class="mb-3">
							<label for="goal-title" class="form-label">Goal Title</label>
							<input type="text" class="form-control" id="goal-title" required>
						</div>
						<div class="mb-3">
							<label for="goal-category" class="form-label">Category</label>
							<select class="form-select" id="goal-category" required>
								<option value="">Select a category</option>
								<option value="Education">Education</option>
								<option value="Home">Home</option>
								<option value="Vehicle">Vehicle</option>
								<option value="Travel">Travel</option>
								<option value="Emergency">Emergency Fund</option>
								<option value="Retirement">Retirement</option>
								<option value="Other">Other</option>
							</select>
						</div>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="goal-amount" class="form-label">Target Amount (KSh)</label>
								<input type="number" class="form-control" id="goal-amount" required min="1000">
							</div>
							<div class="col-md-6 mb-3">
								<label for="current-amount" class="form-label">Current Amount (KSh)</label>
								<input type="number" class="form-control" id="current-amount" value="0" min="0">
							</div>
						</div>
						<div class="mb-3">
							<label for="target-date" class="form-label">Target Date</label>
							<input type="date" class="form-control" id="target-date" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Priority</label>
							<div class="d-flex gap-3">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="goal-priority" id="priority-high" value="high">
									<label class="form-check-label" for="priority-high">High</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="goal-priority" id="priority-medium" value="medium" checked>
									<label class="form-check-label" for="priority-medium">Medium</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="goal-priority" id="priority-low" value="low">
									<label class="form-check-label" for="priority-low">Low</label>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label for="goal-description" class="form-label">Description (Optional)</label>
							<textarea class="form-control" id="goal-description" rows="3"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="save-goal-btn">Save Goal</button>
				</div>
			</div>
		</div>
	</div>

</main><!-- #main -->

<?php
get_footer();
