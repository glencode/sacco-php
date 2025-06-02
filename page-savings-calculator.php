<?php
/**
 * Template Name: Savings Calculator
 *
 * The template for the savings calculator.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<style>
/* Color Palette Variables */
:root {
	--primary-dark: #5A827E;
	--primary-medium: #84AE92;
	--primary-light: #B9D4AA;
	--primary-lightest: #FAFFCA;
	--text-dark: #2c3e50;
	--text-light: #ffffff;
	--shadow: rgba(90, 130, 126, 0.15);
}

/* Override existing styles with new color palette */
.bg-primary {
	background-color: var(--primary-dark) !important;
}

.btn-primary {
	background-color: var(--primary-medium);
	border-color: var(--primary-medium);
	color: var(--text-light);
}

.btn-primary:hover {
	background-color: var(--primary-dark);
	border-color: var(--primary-dark);
}

.btn-outline-primary {
	color: var(--primary-dark);
	border-color: var(--primary-medium);
}

.btn-outline-primary:hover {
	background-color: var(--primary-medium);
	border-color: var(--primary-medium);
	color: var(--text-light);
}

.calculator-card {
	background: var(--text-light);
	border-radius: 15px;
	box-shadow: 0 10px 30px var(--shadow);
	overflow: hidden;
}

.calculator-header {
	background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
	color: var(--text-light);
	padding: 2rem;
	text-align: center;
}

.calculator-header h2 {
	margin-bottom: 0.5rem;
	font-weight: 600;
}

.calculator-body {
	padding: 2rem;
}

.form-control:focus {
	border-color: var(--primary-medium);
	box-shadow: 0 0 0 0.2rem rgba(132, 174, 146, 0.25);
}

.form-range::-webkit-slider-thumb {
	background-color: var(--primary-medium);
}

.form-range::-moz-range-thumb {
	background-color: var(--primary-medium);
	border: none;
}

.result-box {
	background: linear-gradient(135deg, var(--primary-lightest), var(--primary-light));
	border-radius: 10px;
	padding: 1.5rem;
	text-align: center;
	border: 1px solid var(--primary-light);
}

.result-title {
	color: var(--primary-dark);
	font-size: 0.9rem;
	font-weight: 600;
	margin-bottom: 0.5rem;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.result-value {
	color: var(--primary-dark);
	font-size: 1.5rem;
	font-weight: 700;
}

.chart-container {
	background: var(--primary-lightest);
	border-radius: 10px;
	padding: 1rem;
	border: 1px solid var(--primary-light);
}

.table-striped tbody tr:nth-of-type(odd) {
	background-color: rgba(185, 212, 170, 0.1);
}

.table th {
	background-color: var(--primary-light);
	color: var(--primary-dark);
	border: none;
	font-weight: 600;
}

.comparison-table th {
	background-color: var(--primary-medium);
	color: var(--text-light);
}

.comparison-table tbody tr:hover {
	background-color: rgba(185, 212, 170, 0.2);
}

.sidebar-card {
	background: var(--text-light);
	border-radius: 15px;
	padding: 2rem;
	box-shadow: 0 5px 20px var(--shadow);
	border: 1px solid var(--primary-light);
}

.sidebar-card h3 {
	color: var(--primary-dark);
	margin-bottom: 1rem;
	font-weight: 600;
}

.loan-options-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.loan-options-list li {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 0.75rem 0;
	border-bottom: 1px solid var(--primary-light);
}

.loan-options-list li:last-child {
	border-bottom: none;
}

.loan-options-list a {
	color: var(--primary-dark);
	text-decoration: none;
	font-weight: 500;
}

.loan-options-list a:hover {
	color: var(--primary-medium);
}

.loan-options-list span {
	background: var(--primary-light);
	color: var(--primary-dark);
	padding: 0.25rem 0.75rem;
	border-radius: 20px;
	font-size: 0.85rem;
	font-weight: 600;
}

.tip-item {
	display: flex;
	align-items: flex-start;
	margin-bottom: 1.5rem;
	padding: 1rem;
	background: var(--primary-lightest);
	border-radius: 10px;
	border-left: 4px solid var(--primary-medium);
}

.tip-icon {
	background: var(--primary-medium);
	color: var(--text-light);
	width: 40px;
	height: 40px;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-right: 1rem;
	flex-shrink: 0;
}

.tip-content h4 {
	color: var(--primary-dark);
	margin-bottom: 0.5rem;
	font-size: 1rem;
	font-weight: 600;
}

.tip-content p {
	color: var(--text-dark);
	margin: 0;
	font-size: 0.9rem;
}

.calculator-note {
	background: var(--primary-lightest);
	border: 1px solid var(--primary-light);
	border-radius: 10px;
	padding: 1rem;
}

.calculator-note p {
	margin: 0;
	color: var(--primary-dark);
	font-size: 0.9rem;
}

.calculator-note i {
	color: var(--primary-medium);
	margin-right: 0.5rem;
}

/* Form Labels */
.form-label {
	color: var(--primary-dark);
	font-weight: 500;
	margin-bottom: 0.5rem;
}

/* Small text under sliders */
small {
	color: var(--primary-dark);
	opacity: 0.8;
}

/* Breadcrumbs */
#breadcrumbs {
	color: rgba(255, 255, 255, 0.8) !important;
}

#breadcrumbs a {
	color: var(--text-light) !important;
}
</style>

<main id="primary" class="site-main">

	<section class="page-header bg-primary text-white py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs text-white">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="calculator-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="calculator-card">
						<div class="calculator-header">
							<h2>Savings Growth Calculator</h2>
							<p>Calculate how your savings will grow over time and see a detailed breakdown of your future wealth</p>
						</div>
						<div class="calculator-body">
							<form id="savings-calculator-form">
								<!-- Savings Information Inputs -->
								<div class="row mb-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<label for="initial-deposit" class="form-label">Initial Deposit (KSh)</label>
										<input type="number" class="form-control" id="initial-deposit" value="50000" min="0" max="10000000" step="1000">
										<input type="range" class="form-range mt-2" id="initial-deposit-range" min="0" max="10000000" step="1000" value="50000">
										<div class="d-flex justify-content-between">
											<small>KSh 0</small>
											<small>KSh 10,000,000</small>
										</div>
									</div>
									<div class="col-md-6">
										<label for="monthly-deposit" class="form-label">Monthly Deposit (KSh)</label>
										<input type="number" class="form-control" id="monthly-deposit" value="5000" min="0" max="500000" step="500">
										<input type="range" class="form-range mt-2" id="monthly-deposit-range" min="0" max="500000" step="500" value="5000">
										<div class="d-flex justify-content-between">
											<small>KSh 0</small>
											<small>KSh 500,000</small>
										</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<label for="savings-term" class="form-label">Savings Period (Months)</label>
										<input type="number" class="form-control" id="savings-term" value="60" min="1" max="360" step="1">
										<input type="range" class="form-range mt-2" id="savings-term-range" min="1" max="360" step="1" value="60">
										<div class="d-flex justify-content-between">
											<small>1 month</small>
											<small>360 months</small>
										</div>
									</div>
									<div class="col-md-6">
										<label for="interest-rate" class="form-label">Interest Rate (% per annum)</label>
										<input type="number" class="form-control" id="interest-rate" value="5" min="0" max="20" step="0.1">
										<input type="range" class="form-range mt-2" id="interest-rate-range" min="0" max="20" step="0.1" value="5">
										<div class="d-flex justify-content-between">
											<small>0%</small>
											<small>20%</small>
										</div>
									</div>
								</div>
								
								<!-- Results Section -->
								<div class="calculator-results mb-4">
									<div class="row">
										<div class="col-md-4 mb-3">
											<div class="result-box">
												<div class="result-title">Future Value</div>
												<div class="result-value" id="future-value">KSh 0.00</div>
											</div>
										</div>
										<div class="col-md-4 mb-3">
											<div class="result-box">
												<div class="result-title">Total Deposits</div>
												<div class="result-value" id="total-deposits">KSh 0.00</div>
											</div>
										</div>
										<div class="col-md-4 mb-3">
											<div class="result-box">
												<div class="result-title">Interest Earned</div>
												<div class="result-value" id="interest-earned">KSh 0.00</div>
											</div>
										</div>
									</div>
								</div>
								
								<!-- Visualization -->
								<div class="chart-container mb-4">
									<canvas id="savings-chart" height="250"></canvas>
								</div>
								
								<!-- Savings Schedule Toggle -->
								<div class="text-center mb-4">
									<button type="button" class="btn btn-outline-primary" id="show-schedule-btn">
										<i class="fas fa-table"></i> View Savings Schedule
									</button>
								</div>
								
								<!-- Savings Schedule (Hidden by Default) -->
								<div id="savings-schedule" class="mb-4" style="display: none;">
									<h3 class="mb-3">Savings Growth Schedule</h3>
									<div class="table-responsive">
										<table class="table table-striped table-hover" id="savings-schedule-table">
											<thead>
												<tr>
													<th>Period</th>
													<th>Balance</th>
													<th>Total Deposits</th>
													<th>Interest Earned</th>
												</tr>
											</thead>
											<tbody>
												<!-- To be populated by JavaScript -->
											</tbody>
										</table>
									</div>
								</div>
								
								<!-- Savings Comparison -->
								<div class="savings-comparison">
									<h3 class="mb-3">Compare Savings Products</h3>
									<p class="mb-3">See how different savings products affect your future wealth.</p>
									
									<div class="table-responsive">
										<table class="table table-bordered comparison-table">
											<thead>
												<tr>
													<th>Product</th>
													<th>Interest Rate</th>
													<th>Future Value</th>
													<th>Interest Earned</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Regular Savings</td>
													<td>3.0%</td>
													<td id="regular-savings-value">KSh 0.00</td>
													<td id="regular-savings-interest">KSh 0.00</td>
												</tr>
												<tr>
													<td>Premium Savings</td>
													<td>5.0%</td>
													<td id="premium-savings-value">KSh 0.00</td>
													<td id="premium-savings-interest">KSh 0.00</td>
												</tr>
												<tr>
													<td>Fixed Deposit</td>
													<td>7.0%</td>
													<td id="fixed-deposit-value">KSh 0.00</td>
													<td id="fixed-deposit-interest">KSh 0.00</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								
								<!-- CTA Buttons -->
								<div class="row mt-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<a href="<?php echo esc_url(home_url('/savings/')); ?>" class="btn btn-outline-primary w-100">View Our Savings Products</a>
									</div>
									<div class="col-md-6">
										<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary w-100">Open a Savings Account</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="calculator-note mt-3">
						<p><i class="fas fa-info-circle"></i> This calculator provides estimates for informational purposes only. Actual returns may vary based on market conditions, fees, and other factors.</p>
					</div>
				</div>
				
				<div class="col-lg-4 mt-4 mt-lg-0">
					<div class="sidebar-card mb-4">
						<h3>Savings Options</h3>
						<p>Explore our different savings products to find the best solution for your financial goals.</p>
						<ul class="loan-options-list">
							<li>
								<a href="#">Regular Savings Account</a>
								<span>3% p.a.</span>
							</li>
							<li>
								<a href="#">Premium Savings Account</a>
								<span>5% p.a.</span>
							</li>
							<li>
								<a href="#">Fixed Deposit Account</a>
								<span>7% p.a.</span>
							</li>
							<li>
								<a href="#">Junior Savings Account</a>
								<span>4% p.a.</span>
							</li>
							<li>
								<a href="#">Retirement Savings Plan</a>
								<span>6% p.a.</span>
							</li>
							<li>
								<a href="#">Holiday Savings Account</a>
								<span>3.5% p.a.</span>
							</li>
						</ul>
						<a href="<?php echo esc_url(home_url('/savings/')); ?>" class="btn btn-outline-primary w-100 mt-3">View All Savings Products</a>
					</div>
					
					<div class="sidebar-card mb-4">
						<h3>Tips for Saving</h3>
						<div class="tips-list">
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-piggy-bank"></i>
								</div>
								<div class="tip-content">
									<h4>Start early, save regularly</h4>
									<p>The power of compound interest works best over time. Even small regular deposits add up.</p>
								</div>
							</div>
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-chart-line"></i>
								</div>
								<div class="tip-content">
									<h4>Set clear savings goals</h4>
									<p>Define what you're saving for and by when. Specific goals make saving more effective.</p>
								</div>
							</div>
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-lock"></i>
								</div>
								<div class="tip-content">
									<h4>Automate your savings</h4>
									<p>Set up automatic transfers on payday to ensure consistent saving before spending.</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class="sidebar-card">
						<h3>Need Help?</h3>
						<p>Our financial advisors are available to help you choose the right savings product for your needs.</p>
						<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary w-100">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
	// Add JavaScript to show/hide savings schedule
	document.addEventListener('DOMContentLoaded', function() {
		const scheduleButton = document.getElementById('show-schedule-btn');
		const scheduleSection = document.getElementById('savings-schedule');
		
		scheduleButton.addEventListener('click', function() {
			if (scheduleSection.style.display === 'none') {
				scheduleSection.style.display = 'block';
				scheduleButton.innerHTML = '<i class="fas fa-times"></i> Hide Savings Schedule';
			} else {
				scheduleSection.style.display = 'none';
				scheduleButton.innerHTML = '<i class="fas fa-table"></i> View Savings Schedule';
			}
		});
	});
</script>

<?php
get_footer();