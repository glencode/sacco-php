<?php
/**
 * Template Name: Loan Calculator
 *
 * The template for the loan calculator.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

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
							<h2>Loan Repayment Calculator</h2>
							<p>Calculate your loan repayments and see a detailed breakdown of your payments</p>
						</div>
						<div class="calculator-body">
							<form id="loan-calculator-form">
								<!-- Loan Type Selection -->
								<div class="row mb-4">
									<div class="col-md-12">
										<label for="calculator_loan_type_select" class="form-label">Select Loan Type</label>
										<select class="form-select" id="calculator_loan_type_select" name="calculator_loan_type_select">
											<option value="">-- Select Loan Product --</option>
											<?php
											$loan_products_args = array(
												'post_type' => 'loan',
												'post_status' => 'publish',
												'posts_per_page' => -1, // Get all loan products
												'orderby' => 'title',
												'order' => 'ASC',
											);
											$loan_products = get_posts($loan_products_args);
											if ($loan_products) {
												foreach ($loan_products as $loan_product) {
													echo '<option value="' . esc_attr($loan_product->ID) . '">' . esc_html($loan_product->post_title) . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

								<!-- Loan Information Inputs -->
								<div class="row mb-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<label for="loan-amount" class="form-label">Loan Amount (KSh)</label>
										<input type="number" class="form-control" id="loan-amount" value="500000" min="10000" max="10000000" step="10000">
										<input type="range" class="form-range mt-2" id="loan-amount-range" min="10000" max="10000000" step="10000" value="500000">
										<div class="d-flex justify-content-between">
											<small>KSh 10,000</small>
											<small>KSh 10,000,000</small>
										</div>
									</div>
									<div class="col-md-6">
										<label for="loan-term" class="form-label">Loan Term (Months)</label>
										<input type="number" class="form-control" id="loan-term" value="36" min="1" max="84" step="1">
										<input type="range" class="form-range mt-2" id="loan-term-range" min="1" max="84" step="1" value="36">
										<div class="d-flex justify-content-between">
											<small>1 month</small>
											<small>84 months</small>
										</div>
									</div>
								</div>
								
								<div class="row mb-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<label for="interest-rate" class="form-label">Interest Rate (% per annum)</label>
										<input type="number" class="form-control" id="interest-rate" value="14" min="1" max="30" step="0.1">
										<input type="range" class="form-range mt-2" id="interest-rate-range" min="1" max="30" step="0.1" value="14">
										<div class="d-flex justify-content-between">
											<small>1%</small>
											<small>30%</small>
										</div>
									</div>
									<div class="col-md-6">
										<label for="start-date" class="form-label">Start Date</label>
										<input type="date" class="form-control" id="start-date">
										<div class="form-check mt-3">
											<input class="form-check-input" type="checkbox" id="processing-fee-check" checked>
											<label class="form-check-label" for="processing-fee-check">
												Include processing fee (2%)
											</label>
										</div>
									</div>
								</div>
								
								<!-- Results Section -->
								<div class="calculator-results mb-4">
									<div class="row">
										<div class="col-md-6 mb-3">
											<div class="result-box">
												<div class="result-title">Monthly Payment</div>
												<div class="result-value" id="monthly-payment">KSh 0.00</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="result-box">
												<div class="result-title">Total Interest</div>
												<div class="result-value" id="total-interest">KSh 0.00</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="result-box">
												<div class="result-title">Processing Fee</div>
												<div class="result-value" id="processing-fee">KSh 0.00</div>
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<div class="result-box">
												<div class="result-title">Total Repayment</div>
												<div class="result-value" id="total-repayment">KSh 0.00</div>
											</div>
										</div>
									</div>
								</div>
								
								<!-- Visualization -->
								<div class="chart-container mb-4">
									<canvas id="payment-chart" height="250"></canvas>
								</div>
								
								<!-- Amortization Schedule Toggle -->
								<div class="text-center mb-4">
									<button type="button" class="btn btn-outline-primary" id="show-schedule-btn">
										<i class="fas fa-table"></i> View Amortization Schedule
									</button>
								</div>
								
								<!-- Amortization Schedule (Hidden by Default) -->
								<div id="amortization-schedule" class="mb-4" style="display: none;">
									<h3 class="mb-3">Amortization Schedule</h3>
									<div class="table-responsive">
										<table class="table table-striped table-hover" id="amortization-table">
											<thead>
												<tr>
													<th>Payment #</th>
													<th>Date</th>
													<th>Payment</th>
													<th>Principal</th>
													<th>Interest</th>
													<th>Balance</th>
												</tr>
											</thead>
											<tbody>
												<!-- To be populated by JavaScript -->
											</tbody>
										</table>
									</div>
								</div>
								
								<!-- Loan Comparison -->
								<div class="loan-comparison">
									<h3 class="mb-3">Compare Loan Terms</h3>
									<p class="mb-3">See how different loan terms affect your monthly payment and total interest.</p>
									
									<div class="table-responsive">
										<table class="table table-bordered comparison-table">
											<thead>
												<tr>
													<th>Term</th>
													<th>Monthly Payment</th>
													<th>Total Interest</th>
													<th>Total Cost</th>
												</tr>
											</thead>
											<tbody id="comparison-table-body">
												<!-- To be populated by JavaScript -->
											</tbody>
										</table>
									</div>
								</div>
								
								<!-- CTA Buttons -->
								<div class="row mt-4">
									<div class="col-md-6 mb-3 mb-md-0">
										<a href="<?php echo esc_url(home_url('/loans/')); ?>" class="btn btn-outline-primary w-100">View Our Loans</a>
									</div>
									<div class="col-md-6">
										<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-primary w-100">Apply for a Loan</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="calculator-note mt-3">
						<p><i class="fas fa-info-circle"></i> This calculator provides estimates for informational purposes only. Actual loan terms and rates may vary based on your credit history, income, and other factors.</p>
					</div>
				</div>
				
				<div class="col-lg-4 mt-4 mt-lg-0">
					<div class="sidebar-card mb-4">
						<h3>Loan Options</h3>
						<p>Explore our different loan products to find the best solution for your financial needs.</p>
						<ul class="loan-options-list">
							<li>
								<a href="#">Personal Loan</a>
								<span>From 14% p.a.</span>
							</li>
							<li>
								<a href="#">Business Loan</a>
								<span>From 16% p.a.</span>
							</li>
							<li>
								<a href="#">Emergency Loan</a>
								<span>From 15% p.a.</span>
							</li>
							<li>
								<a href="#">Education Loan</a>
								<span>From 12% p.a.</span>
							</li>
							<li>
								<a href="#">Home Improvement Loan</a>
								<span>From 13% p.a.</span>
							</li>
							<li>
								<a href="#">Vehicle Loan</a>
								<span>From 11% p.a.</span>
							</li>
						</ul>
						<a href="<?php echo esc_url(home_url('/loans/')); ?>" class="btn btn-outline-primary w-100 mt-3">View All Loans</a>
					</div>
					
					<div class="sidebar-card mb-4">
						<h3>Tips for Borrowing</h3>
						<div class="tips-list">
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-hand-holding-usd"></i>
								</div>
								<div class="tip-content">
									<h4>Borrow only what you need</h4>
									<p>Don't take out more than you can comfortably repay. Consider your monthly budget.</p>
								</div>
							</div>
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-calendar-check"></i>
								</div>
								<div class="tip-content">
									<h4>Choose the right term</h4>
									<p>Shorter terms mean higher payments but less interest. Balance what works for your budget.</p>
								</div>
							</div>
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-coins"></i>
								</div>
								<div class="tip-content">
									<h4>Consider extra payments</h4>
									<p>When possible, make additional payments to reduce the principal and save on interest.</p>
								</div>
							</div>
							<div class="tip-item">
								<div class="tip-icon">
									<i class="fas fa-file-invoice-dollar"></i>
								</div>
								<div class="tip-content">
									<h4>Understand all fees</h4>
									<p>Be aware of all costs including processing fees, insurance, and any potential penalties.</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class="need-help-card">
						<h3>Need Help?</h3>
						<p>Our financial advisors are here to help you make informed decisions about your loan options.</p>
						<div class="contact-info">
							<div class="contact-item">
								<i class="fas fa-phone-alt"></i>
								<span>+254 700 123 456</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-envelope"></i>
								<span>loans@harambeesacco.com</span>
							</div>
							<div class="contact-item">
								<i class="fas fa-map-marker-alt"></i>
								<span>Visit any of our branches</span>
							</div>
						</div>
						<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary w-100 mt-3">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="cta-section bg-primary text-white py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2>Ready to Apply for a Loan?</h2>
					<p class="mb-0">Use our online application process to get started. It's quick, easy, and secure.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-light btn-lg">Apply Now</a>
					<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const loanAmountInput = document.getElementById('loan-amount');
    const loanAmountRange = document.getElementById('loan-amount-range');
    const loanTermInput = document.getElementById('loan-term');
    const loanTermRange = document.getElementById('loan-term-range');
    const interestRateInput = document.getElementById('interest-rate');
    const interestRateRange = document.getElementById('interest-rate-range');
    const startDateInput = document.getElementById('start-date');
    const processingFeeCheck = document.getElementById('processing-fee-check');
    
    const monthlyPaymentOutput = document.getElementById('monthly-payment');
    const totalInterestOutput = document.getElementById('total-interest');
    const processingFeeOutput = document.getElementById('processing-fee');
    const totalRepaymentOutput = document.getElementById('total-repayment');
    
    const showScheduleBtn = document.getElementById('show-schedule-btn');
    const amortizationSchedule = document.getElementById('amortization-schedule');
    const amortizationTable = document.getElementById('amortization-table').querySelector('tbody');
    const comparisonTableBody = document.getElementById('comparison-table-body');
    
    // Set today's date as default
    const today = new Date();
    startDateInput.value = today.toISOString().substr(0, 10);
    
    // Sync range and number inputs
    loanAmountRange.addEventListener('input', function() {
        loanAmountInput.value = this.value;
        calculateLoan();
    });
    
    loanAmountInput.addEventListener('input', function() {
        loanAmountRange.value = this.value;
        calculateLoan();
    });
    
    loanTermRange.addEventListener('input', function() {
        loanTermInput.value = this.value;
        calculateLoan();
    });
    
    loanTermInput.addEventListener('input', function() {
        loanTermRange.value = this.value;
        calculateLoan();
    });
    
    interestRateRange.addEventListener('input', function() {
        interestRateInput.value = this.value;
        calculateLoan();
    });
    
    interestRateInput.addEventListener('input', function() {
        interestRateRange.value = this.value;
        calculateLoan();
    });
    
    // Other input change handlers
    startDateInput.addEventListener('change', calculateLoan);
    processingFeeCheck.addEventListener('change', calculateLoan);
    
    // Toggle amortization schedule
    showScheduleBtn.addEventListener('click', function() {
        if (amortizationSchedule.style.display === 'none') {
            amortizationSchedule.style.display = 'block';
            this.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Amortization Schedule';
        } else {
            amortizationSchedule.style.display = 'none';
            this.innerHTML = '<i class="fas fa-table"></i> View Amortization Schedule';
        }
    });
    
    // Initialize chart
    let paymentChart;
    function initChart(principal, interest) {
        const ctx = document.getElementById('payment-chart').getContext('2d');
        
        if (paymentChart) {
            paymentChart.destroy();
        }
        
        paymentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Principal', 'Interest'],
                datasets: [{
                    data: [principal, interest],
                    backgroundColor: ['#5ca157', '#ff6b6b'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label;
                                let value = context.raw;
                                return `${label}: KSh ${value.toLocaleString('en-US', {maximumFractionDigits: 2})}`;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Calculate loan function
    function calculateLoan() {
        // Get values
        const loanAmount = parseFloat(loanAmountInput.value);
        const loanTerm = parseInt(loanTermInput.value);
        const interestRate = parseFloat(interestRateInput.value);
        const includeProcessingFee = processingFeeCheck.checked;
        
        // Validate inputs
        if (isNaN(loanAmount) || isNaN(loanTerm) || isNaN(interestRate) || loanAmount <= 0 || loanTerm <= 0 || interestRate <= 0) {
            return;
        }
        
        // Calculate monthly payment (PMT formula)
        const monthlyRate = interestRate / 100 / 12;
        let monthlyPayment;
        
        if (monthlyRate === 0) {
            monthlyPayment = loanAmount / loanTerm;
        } else {
            monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -loanTerm));
        }
        
        // Calculate total payment, interest, and processing fee
        const totalPayment = monthlyPayment * loanTerm;
        const totalInterest = totalPayment - loanAmount;
        const processingFee = includeProcessingFee ? loanAmount * 0.02 : 0;
        const totalCost = totalPayment + processingFee;
        
        // Update output
        monthlyPaymentOutput.textContent = `KSh ${monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        totalInterestOutput.textContent = `KSh ${totalInterest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        processingFeeOutput.textContent = `KSh ${processingFee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        totalRepaymentOutput.textContent = `KSh ${totalCost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        
        // Update chart
        initChart(loanAmount, totalInterest);
        
        // Generate amortization schedule
        generateAmortizationSchedule(loanAmount, monthlyRate, monthlyPayment, loanTerm);
        
        // Generate loan comparison table
        generateLoanComparison(loanAmount, interestRate, processingFee);
    }
    
    // Generate amortization schedule
    function generateAmortizationSchedule(principal, monthlyRate, monthlyPayment, term) {
        // Clear table
        amortizationTable.innerHTML = '';
        
        let balance = principal;
        let startDate = new Date(startDateInput.value);
        
        for (let i = 1; i <= term; i++) {
            const interest = balance * monthlyRate;
            const principalPayment = monthlyPayment - interest;
            balance -= principalPayment;
            
            // Format date
            const paymentDate = new Date(startDate);
            paymentDate.setMonth(startDate.getMonth() + i);
            const formattedDate = paymentDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            
            // Create row
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${i}</td>
                <td>${formattedDate}</td>
                <td>KSh ${monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>KSh ${principalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>KSh ${interest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>KSh ${Math.max(0, balance).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
            `;
            
            amortizationTable.appendChild(row);
        }
    }
    
    // Generate loan comparison table
    function generateLoanComparison(principal, interestRate, processingFee) {
        // Clear table
        comparisonTableBody.innerHTML = '';
        
        // Generate comparison for different terms
        const terms = [12, 24, 36, 48, 60];
        const currentTerm = parseInt(loanTermInput.value);
        
        terms.forEach(term => {
            const monthlyRate = interestRate / 100 / 12;
            let monthlyPayment;
            
            if (monthlyRate === 0) {
                monthlyPayment = principal / term;
            } else {
                monthlyPayment = (principal * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -term));
            }
            
            const totalPayment = monthlyPayment * term;
            const totalInterest = totalPayment - principal;
            const totalCost = totalPayment + processingFee;
            
            // Create row
            const row = document.createElement('tr');
            if (term === currentTerm) {
                row.classList.add('table-success');
            }
            
            row.innerHTML = `
                <td>${term} months</td>
                <td>KSh ${monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>KSh ${totalInterest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>KSh ${totalCost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
            `;
            
            comparisonTableBody.appendChild(row);
        });
    }
    
    // Initial calculation
    calculateLoan();
});
</script>

<style>
/* Calculator Results */
.result-box {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    height: 100%;
}

.result-title {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.result-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3624;
}

/* Chart Container */
.chart-container {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
}

/* Amortization Table */
.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

/* Sidebar Cards */
.sidebar-card, .need-help-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    padding: 25px;
}

.sidebar-card h3, .need-help-card h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #2c3624;
}

/* Loan Options List */
.loan-options-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

.loan-options-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #efefef;
}

.loan-options-list li:last-child {
    border-bottom: none;
}

.loan-options-list a {
    color: #2c3624;
    text-decoration: none;
    transition: all 0.2s ease;
}

.loan-options-list a:hover {
    color: #5ca157;
}

.loan-options-list span {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Tips List */
.tips-list {
    margin-bottom: 0;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

.tip-item:last-child {
    margin-bottom: 0;
}

.tip-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e6f3e6;
    color: #5ca157;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.tip-content h4 {
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #2c3624;
}

.tip-content p {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
}

/* Contact Info */
.contact-info {
    margin: 15px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.contact-item:last-child {
    margin-bottom: 0;
}

.contact-item i {
    width: 20px;
    color: #5ca157;
    margin-right: 10px;
}

/* Calculator Notes */
.calculator-note {
    background-color: #f8f9fa;
    border-left: 4px solid #5ca157;
    padding: 15px;
    border-radius: 0 5px 5px 0;
}

.calculator-note p {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0;
}

.calculator-note i {
    color: #5ca157;
}

/* Comparison Table */
.comparison-table {
    margin-bottom: 0;
}

.comparison-table th {
    background-color: #f8f9fa;
    color: #2c3624;
}

/* Responsive Styles */
@media (max-width: 767.98px) {
    .result-box {
        text-align: center;
    }
    
    .result-value {
        font-size: 1.3rem;
    }
    
    .sidebar-card, .need-help-card {
        padding: 20px;
    }
}
</style>

<?php
get_footer(); 