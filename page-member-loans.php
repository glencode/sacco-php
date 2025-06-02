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

<style>
/* Color Palette Variables */
:root {
    --primary-dark: #626F47;    /* Dark green */
    --primary-medium: #A4B465;  /* Medium green */
    --primary-light: #F5ECD5;   /* Light cream */
    --accent: #F0BB78;          /* Warm beige/orange */
    --white: #ffffff;
    --text-dark: #2c3e50;
    --text-muted: #6c757d;
    --success: #28a745;
    --danger: #dc3545;
}

/* Header Styling */
.member-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    color: var(--white);
}

.member-dashboard-title {
    color: var(--white);
    font-weight: 600;
}

.member-id {
    color: var(--primary-light);
    opacity: 0.9;
}

/* Sidebar Styling */
.member-sidebar {
    background: var(--primary-light);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.list-group-item {
    border: none;
    background: transparent;
    color: var(--primary-dark);
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background: var(--accent);
    color: var(--primary-dark);
    transform: translateX(5px);
}

.list-group-item.active {
    background: var(--primary-dark);
    color: var(--white);
}

.list-group-item.text-danger {
    color: var(--danger) !important;
}

.list-group-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger) !important;
}

/* Dashboard Cards */
.dashboard-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--primary-light);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.dashboard-card-header {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--accent) 100%);
    padding: 1.5rem;
    border-bottom: 2px solid var(--primary-medium);
}

.dashboard-card-title {
    color: var(--primary-dark);
    font-weight: 600;
    margin: 0;
}

.dashboard-card-body {
    padding: 2rem;
}

/* Account Summary Items */
.account-summary-item {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary-light) 0%, rgba(244, 236, 213, 0.5) 100%);
    border-radius: 12px;
    border: 2px solid var(--accent);
    transition: all 0.3s ease;
}

.account-summary-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-color: var(--primary-medium);
}

.summary-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-dark);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: var(--white);
    font-size: 1.5rem;
}

.account-summary-item h4 {
    color: var(--primary-dark);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.summary-amount {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.account-summary-item small {
    color: var(--text-muted);
    font-size: 0.875rem;
}

/* Loan Cards */
.loan-card {
    background: var(--white);
    border: 2px solid var(--primary-light);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.loan-card:hover {
    border-color: var(--accent);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.loan-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-light);
}

.loan-type {
    color: var(--primary-dark);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.loan-number {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.loan-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
}

/* Progress Bar */
.loan-progress-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: var(--primary-dark);
    font-weight: 600;
}

.loan-progress-bar {
    height: 12px;
    background: var(--primary-light);
    border-radius: 6px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.loan-progress-value {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-medium) 0%, var(--accent) 100%);
    border-radius: 6px;
    transition: width 0.3s ease;
}

/* Loan Details */
.loan-details {
    list-style: none;
    padding: 0;
    margin: 1.5rem 0;
}

.loan-details li {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--primary-light);
}

.loan-details li:last-child {
    border-bottom: none;
}

.detail-label {
    color: var(--text-muted);
    font-weight: 500;
}

.detail-value {
    color: var(--primary-dark);
    font-weight: 600;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-medium) 0%, var(--accent) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-outline-primary {
    color: var(--primary-dark);
    border: 2px solid var(--primary-dark);
    background: transparent;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-dark);
    color: var(--white);
    transform: translateY(-2px);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Badges */
.badge {
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    font-size: 0.75rem;
}

.badge.bg-primary {
    background: var(--primary-dark) !important;
}

.badge.bg-success {
    background: var(--success) !important;
}

/* Table Styling */
.table {
    margin: 0;
}

.table th {
    background: var(--primary-light);
    color: var(--primary-dark);
    border: none;
    font-weight: 600;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--primary-light);
}

.table-hover tbody tr:hover {
    background: rgba(245, 236, 213, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .member-header {
        text-align: center;
    }
    
    .member-header .col-md-6:last-child {
        text-align: center !important;
        margin-top: 1rem;
    }
    
    .dashboard-card-body {
        padding: 1.5rem;
    }
    
    .loan-card {
        padding: 1rem;
    }
    
    .summary-amount {
        font-size: 1.5rem;
    }
    
    .loan-amount {
        font-size: 1.75rem;
    }
}

@media (max-width: 576px) {
    .account-summary-item {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .summary-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .dashboard-card-body {
        padding: 1rem;
    }
}
</style>

<main id="primary" class="site-main">

	<section class="member-header py-4">
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
					<div id="member-loans-section" class="col-lg-9 member-content-section">
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