<?php
/**
 * Template Name: Member Loans
 *
 * The template for displaying the member loan information.
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
					<h1 class="member-dashboard-title">My Loans</h1>
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
							<a href="<?php echo esc_url(home_url('member-profile')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-user"></i> My Profile
							</a>
							<a href="<?php echo esc_url(home_url('member-savings')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-piggy-bank"></i> My Savings
							</a>
							<a href="<?php echo esc_url(home_url('member-loans')); ?>" class="list-group-item list-group-item-action active">
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
				<div class="col-lg-9">
					<!-- Loan Summary -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Loan Summary</h2>
						</div>
						<div class="dashboard-card-body">
							<div class="row">
								<div class="col-md-4 mb-4 mb-md-0">
									<div class="account-summary-item text-center">
										<div class="summary-icon">
											<i class="fas fa-money-bill-wave"></i>
										</div>
										<h4>Total Loan Balance</h4>
										<div class="summary-amount">KSh 230,000.00</div>
									</div>
								</div>
								<div class="col-md-4 mb-4 mb-md-0">
									<div class="account-summary-item text-center">
										<div class="summary-icon">
											<i class="fas fa-calendar-alt"></i>
										</div>
										<h4>Next Payment Due</h4>
										<div class="summary-amount">KSh 17,500.00</div>
										<small>Due on 2023-08-15</small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="account-summary-item text-center">
										<div class="summary-icon">
											<i class="fas fa-landmark"></i>
										</div>
										<h4>Loan Qualification</h4>
										<div class="summary-amount">KSh 500,000.00</div>
										<small>Maximum eligible amount</small>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Active Loans -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header d-flex justify-content-between align-items-center">
							<h2 class="dashboard-card-title">Active Loans</h2>
							<a href="#" class="btn btn-sm btn-primary">Apply for New Loan</a>
						</div>
						<div class="dashboard-card-body">
							<!-- Development Loan Card -->
							<div class="loan-card mb-4">
								<div class="loan-header d-flex justify-content-between align-items-center">
									<div>
										<h3 class="loan-type">Development Loan</h3>
										<div class="loan-number">Loan #: DL-2023-00125</div>
									</div>
									<span class="badge bg-primary">Active</span>
								</div>
								<div class="loan-body">
									<div class="loan-amount">KSh 250,000.00</div>
									
									<div class="loan-progress mb-4">
										<div class="loan-progress-label">
											<span>Repayment Progress</span>
											<span>28%</span>
										</div>
										<div class="loan-progress-bar">
											<div class="loan-progress-value" style="width: 28%;"></div>
										</div>
									</div>
									
									<ul class="loan-details">
										<li>
											<span class="detail-label">Current Balance</span>
											<span class="detail-value">KSh 180,000.00</span>
										</li>
										<li>
											<span class="detail-label">Interest Rate</span>
											<span class="detail-value">12% p.a.</span>
										</li>
										<li>
											<span class="detail-label">Issue Date</span>
											<span class="detail-value">January 15, 2023</span>
										</li>
										<li>
											<span class="detail-label">Loan Term</span>
											<span class="detail-value">24 months</span>
										</li>
										<li>
											<span class="detail-label">Monthly Payment</span>
											<span class="detail-value">KSh 12,500.00</span>
										</li>
										<li>
											<span class="detail-label">Next Payment Due</span>
											<span class="detail-value">August 15, 2023</span>
										</li>
									</ul>
									
									<div class="row">
										<div class="col-sm-6 mb-2 mb-sm-0">
											<a href="#" class="btn btn-primary btn-sm w-100">Make Payment</a>
										</div>
										<div class="col-sm-6">
											<a href="#" class="btn btn-outline-primary btn-sm w-100">View Details</a>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Emergency Loan Card -->
							<div class="loan-card">
								<div class="loan-header d-flex justify-content-between align-items-center">
									<div>
										<h3 class="loan-type">Emergency Loan</h3>
										<div class="loan-number">Loan #: EL-2023-00089</div>
									</div>
									<span class="badge bg-primary">Active</span>
								</div>
								<div class="loan-body">
									<div class="loan-amount">KSh 50,000.00</div>
									
									<div class="loan-progress mb-4">
										<div class="loan-progress-label">
											<span>Repayment Progress</span>
											<span>0%</span>
										</div>
										<div class="loan-progress-bar">
											<div class="loan-progress-value" style="width: 0%;"></div>
										</div>
									</div>
									
									<ul class="loan-details">
										<li>
											<span class="detail-label">Current Balance</span>
											<span class="detail-value">KSh 50,000.00</span>
										</li>
										<li>
											<span class="detail-label">Interest Rate</span>
											<span class="detail-value">14% p.a.</span>
										</li>
										<li>
											<span class="detail-label">Issue Date</span>
											<span class="detail-value">May 10, 2023</span>
										</li>
										<li>
											<span class="detail-label">Loan Term</span>
											<span class="detail-value">12 months</span>
										</li>
										<li>
											<span class="detail-label">Monthly Payment</span>
											<span class="detail-value">KSh 5,000.00</span>
										</li>
										<li>
											<span class="detail-label">Next Payment Due</span>
											<span class="detail-value">August 10, 2023</span>
										</li>
									</ul>
									
									<div class="row">
										<div class="col-sm-6 mb-2 mb-sm-0">
											<a href="#" class="btn btn-primary btn-sm w-100">Make Payment</a>
										</div>
										<div class="col-sm-6">
											<a href="#" class="btn btn-outline-primary btn-sm w-100">View Details</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Loan History -->
					<div class="dashboard-card">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Loan History</h2>
						</div>
						<div class="dashboard-card-body">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Loan Type</th>
											<th>Amount</th>
											<th>Issue Date</th>
											<th>Completion Date</th>
											<th>Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Personal Loan</td>
											<td>KSh 150,000.00</td>
											<td>2022-01-10</td>
											<td>2022-12-10</td>
											<td><span class="badge bg-success">Completed</span></td>
											<td><a href="#" class="btn btn-sm btn-outline-primary">Details</a></td>
										</tr>
										<tr>
											<td>Emergency Loan</td>
											<td>KSh 30,000.00</td>
											<td>2021-07-15</td>
											<td>2022-01-15</td>
											<td><span class="badge bg-success">Completed</span></td>
											<td><a href="#" class="btn btn-sm btn-outline-primary">Details</a></td>
										</tr>
										<tr>
											<td>Business Loan</td>
											<td>KSh 200,000.00</td>
											<td>2020-05-20</td>
											<td>2021-11-20</td>
											<td><span class="badge bg-success">Completed</span></td>
											<td><a href="#" class="btn btn-sm btn-outline-primary">Details</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 