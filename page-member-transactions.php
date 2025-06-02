<?php
/**
 * Template Name: Member Transactions
 *
 * The template for displaying the member transaction history.
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
					<h1 class="member-dashboard-title">My Transactions</h1>
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
							<a href="<?php echo esc_url(home_url('member-loans')); ?>" class="list-group-item list-group-item-action">
								<i class="fas fa-hand-holding-usd"></i> My Loans
							</a>
							<a href="<?php echo esc_url(home_url('member-transactions')); ?>" class="list-group-item list-group-item-action active">
								<i class="fas fa-exchange-alt"></i> Transactions
							</a>
							<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="list-group-item list-group-item-action text-danger">
								<i class="fas fa-sign-out-alt"></i> Logout
							</a>
						</div>
					</div>
				</div>
				
				<!-- Main Content -->
					<div id="member-transactions-section" class="col-lg-9 member-content-section">
					<!-- Transaction Filters -->
					<div class="dashboard-card mb-4">
						<div class="dashboard-card-header">
							<h2 class="dashboard-card-title">Filter Transactions</h2>
						</div>
						<div class="dashboard-card-body">
							<form id="transaction-filter-form">
								<div class="row">
									<div class="col-md-3 mb-3">
										<label for="account-filter" class="form-label">Account</label>
										<select id="account-filter" class="form-select">
											<option value="">All Accounts</option>
											<option value="savings">Regular Savings</option>
											<option value="holiday">Holiday Savings</option>
											<option value="shares">Share Capital</option>
											<option value="loan">Loan Accounts</option>
										</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="type-filter" class="form-label">Transaction Type</label>
										<select id="type-filter" class="form-select">
											<option value="">All Types</option>
											<option value="deposit">Deposits</option>
											<option value="withdrawal">Withdrawals</option>
											<option value="transfer">Transfers</option>
											<option value="loan">Loan Transactions</option>
											<option value="interest">Interest</option>
											<option value="fee">Fees</option>
											<option value="dividend">Dividends</option>
										</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="date-from" class="form-label">Date From</label>
										<input type="date" id="date-from" class="form-control" value="<?php echo date('Y-m-d', strtotime('-3 months')); ?>">
									</div>
									<div class="col-md-3 mb-3">
										<label for="date-to" class="form-label">Date To</label>
										<input type="date" id="date-to" class="form-control" value="<?php echo date('Y-m-d'); ?>">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="search-filter" class="form-label">Search</label>
										<input type="text" id="search-filter" class="form-control" placeholder="Search by description or reference...">
									</div>
									<div class="col-md-3 mb-3">
										<label for="amount-min" class="form-label">Min Amount</label>
										<input type="number" id="amount-min" class="form-control" placeholder="Min KSh">
									</div>
									<div class="col-md-3 mb-3">
										<label for="amount-max" class="form-label">Max Amount</label>
										<input type="number" id="amount-max" class="form-control" placeholder="Max KSh">
									</div>
								</div>
								<div class="row">
									<div class="col-12 d-flex justify-content-end">
										<button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
										<button type="submit" class="btn btn-primary">Apply Filters</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<!-- Transaction List -->
					<div class="dashboard-card">
						<div class="dashboard-card-header d-flex justify-content-between align-items-center">
							<h2 class="dashboard-card-title">Transaction History</h2>
							<div class="btn-group">
								<button class="btn btn-sm btn-outline-primary" id="download-pdf">
									<i class="fas fa-file-pdf"></i> PDF
								</button>
								<button class="btn btn-sm btn-outline-primary" id="download-csv">
									<i class="fas fa-file-csv"></i> CSV
								</button>
								<button class="btn btn-sm btn-outline-primary" id="print-statement">
									<i class="fas fa-print"></i> Print
								</button>
							</div>
						</div>
						<div class="dashboard-card-body">
							<div class="table-responsive">
								<table class="table table-hover transaction-table">
									<thead>
										<tr>
											<th>Date</th>
											<th>Description</th>
											<th>Reference</th>
											<th>Account</th>
											<th>Type</th>
											<th>Amount</th>
											<th>Balance</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>2023-07-15</td>
											<td>Salary Deposit</td>
											<td>MPESA-34598701</td>
											<td>Regular Savings</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 45,000.00</td>
											<td>KSh 125,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-07-10</td>
											<td>Loan Repayment</td>
											<td>LN-REP-45678</td>
											<td>Development Loan</td>
											<td><span class="badge bg-danger">Debit</span></td>
											<td>KSh 12,500.00</td>
											<td>KSh 180,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-07-05</td>
											<td>Interest Earned</td>
											<td>INT-REG-JUL23</td>
											<td>Regular Savings</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 1,250.00</td>
											<td>KSh 85,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-07-01</td>
											<td>Shares Purchase</td>
											<td>SHR-PUR-70123</td>
											<td>Share Capital</td>
											<td><span class="badge bg-primary">Transfer</span></td>
											<td>KSh 5,000.00</td>
											<td>KSh 75,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-07-01</td>
											<td>Holiday Savings Deposit</td>
											<td>MPESA-34566701</td>
											<td>Holiday Savings</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 5,000.00</td>
											<td>KSh 40,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-06-30</td>
											<td>ATM Withdrawal</td>
											<td>ATM-XYZ-80125</td>
											<td>Regular Savings</td>
											<td><span class="badge bg-danger">Debit</span></td>
											<td>KSh 15,000.00</td>
											<td>KSh 80,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-06-15</td>
											<td>Salary Deposit</td>
											<td>MPESA-34565701</td>
											<td>Regular Savings</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 45,000.00</td>
											<td>KSh 95,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-06-10</td>
											<td>Loan Repayment</td>
											<td>LN-REP-45632</td>
											<td>Development Loan</td>
											<td><span class="badge bg-danger">Debit</span></td>
											<td>KSh 12,500.00</td>
											<td>KSh 192,500.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-06-05</td>
											<td>Interest Earned</td>
											<td>INT-REG-JUN23</td>
											<td>Regular Savings</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 1,200.00</td>
											<td>KSh 80,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
										<tr>
											<td>2023-06-02</td>
											<td>Emergency Loan Disbursement</td>
											<td>LN-DISB-89015</td>
											<td>Emergency Loan</td>
											<td><span class="badge bg-success">Credit</span></td>
											<td>KSh 50,000.00</td>
											<td>KSh 50,000.00</td>
											<td><span class="badge bg-success">Completed</span></td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<!-- Pagination -->
							<nav aria-label="Transaction pagination" class="mt-4">
								<ul class="pagination justify-content-center">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
									</li>
									<li class="page-item active" aria-current="page">
										<a class="page-link" href="#">1</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">2</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">3</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Filter form handling
		const filterForm = document.getElementById('transaction-filter-form');
		filterForm.addEventListener('submit', function(e) {
			e.preventDefault();
			// In a real application, this would make an AJAX call to fetch filtered transactions
			alert('Filters applied! In a real application, this would refresh the transaction list.');
		});
		
		// Print statement button
		const printButton = document.getElementById('print-statement');
		printButton.addEventListener('click', function() {
			window.print();
		});
		
		// Download buttons (just simulated in this demo)
		const pdfButton = document.getElementById('download-pdf');
		const csvButton = document.getElementById('download-csv');
		
		pdfButton.addEventListener('click', function() {
			alert('In a real application, this would generate and download a PDF of your transactions.');
		});
		
		csvButton.addEventListener('click', function() {
			alert('In a real application, this would generate and download a CSV of your transactions.');
		});
	});
</script>

<?php
get_footer(); 
?>