<?php
/**
 * The template for displaying the Loan Calculator page - Improved Version
 *
 * This is the improved Loan Calculator page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main calculator-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Loan Calculator</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('tools')); ?>">Financial Tools</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Loan Calculator</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calculator Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="calculator-card fade-in">
                        <div class="calculator-header">
                            <h2>Loan Calculator</h2>
                            <p>Calculate your monthly payments and total interest</p>
                        </div>
                        
                        <div class="calculator-body">
                            <form id="loanCalculatorForm">
                                <div class="form-group mb-4">
                                    <label for="loanAmount" class="form-label">Loan Amount (KSh)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control" id="loanAmount" min="1000" max="10000000" value="100000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="1000" max="10000000" step="1000" value="100000">
                                        <div class="range-labels">
                                            <span>KSh 1,000</span>
                                            <span>KSh 10,000,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="interestRate" class="form-label">Interest Rate (% per year)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="interestRate" min="1" max="30" step="0.1" value="12" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="interestRateSlider" min="1" max="30" step="0.1" value="12">
                                        <div class="range-labels">
                                            <span>1%</span>
                                            <span>30%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="1" max="360" value="36" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="1" max="360" step="1" value="36">
                                        <div class="range-labels">
                                            <span>1 month</span>
                                            <span>30 years</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label">Repayment Method</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="repaymentMethod" id="reducingBalance" value="reducing" checked>
                                        <label class="form-check-label" for="reducingBalance">
                                            Reducing Balance
                                            <i class="fas fa-info-circle ms-1 text-muted" data-bs-toggle="tooltip" title="Interest is calculated on the remaining loan balance, resulting in decreasing interest payments over time."></i>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="repaymentMethod" id="flatRate" value="flat">
                                        <label class="form-check-label" for="flatRate">
                                            Flat Rate
                                            <i class="fas fa-info-circle ms-1 text-muted" data-bs-toggle="tooltip" title="Interest is calculated on the initial loan amount throughout the loan term, resulting in consistent interest payments."></i>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">Calculate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="results-card fade-in">
                        <div class="results-header">
                            <h2>Loan Summary</h2>
                            <p>Your estimated loan repayment details</p>
                        </div>
                        
                        <div class="results-body">
                            <div class="results-summary">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h3>Monthly Payment</h3>
                                            <div class="summary-value" id="monthlyPayment">KSh 3,321.67</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h3>Total Interest</h3>
                                            <div class="summary-value" id="totalInterest">KSh 19,580.12</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h3>Total Payment</h3>
                                            <div class="summary-value" id="totalPayment">KSh 119,580.12</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h3>Effective Interest Rate</h3>
                                            <div class="summary-value" id="effectiveRate">12.68%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chart-container mt-4">
                                <canvas id="loanChart"></canvas>
                            </div>
                            
                            <div class="results-actions mt-4">
                                <button class="btn btn-outline-primary me-2" id="viewAmortizationBtn">
                                    <i class="fas fa-table me-2" aria-hidden="true"></i> View Amortization Schedule
                                </button>
                                <button class="btn btn-outline-secondary" id="printResultsBtn">
                                    <i class="fas fa-print me-2" aria-hidden="true"></i> Print Results
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="amortization-table-container mt-4 fade-in" style="display: none;">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Amortization Schedule</h3>
                                <button type="button" class="btn-close" id="closeAmortizationBtn" aria-label="Close"></button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="amortizationTable">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Payment</th>
                                                <th>Principal</th>
                                                <th>Interest</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table rows will be populated by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Types Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Our Loan Products</h2>
                <p class="section-subtitle">Explore our range of loan options to find the right fit for your needs</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </div>
                        <h3>Mortgage Loan</h3>
                        <ul class="product-features">
                            <li>Up to KSh 50 million</li>
                            <li>Interest rate from 12% p.a.</li>
                            <li>Up to 25 years repayment period</li>
                            <li>Flexible terms available</li>
                        </ul>
                        <a href="<?php echo esc_url(home_url('loans/mortgage')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-car" aria-hidden="true"></i>
                        </div>
                        <h3>Auto Loan</h3>
                        <ul class="product-features">
                            <li>Up to KSh 3 million</li>
                            <li>Interest rate from 14% p.a.</li>
                            <li>Up to 5 years repayment period</li>
                            <li>Quick approval process</li>
                        </ul>
                        <a href="<?php echo esc_url(home_url('loans/auto')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>Personal Loan</h3>
                        <ul class="product-features">
                            <li>Up to KSh 1 million</li>
                            <li>Interest rate from 16% p.a.</li>
                            <li>Up to 5 years repayment period</li>
                            <li>Minimal documentation required</li>
                        </ul>
                        <a href="<?php echo esc_url(home_url('loans/personal')); ?>" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('products-services#loans')); ?>" class="btn btn-primary">View All Loan Products</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about our loan products</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion fade-in" id="loanFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What is the difference between reducing balance and flat rate interest?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#loanFAQ">
                                <div class="accordion-body">
                                    <p>With <strong>reducing balance</strong> interest, the interest is calculated on the remaining loan balance, which decreases as you make payments. This means your interest payments decrease over time, while the principal portion increases.</p>
                                    <p>With <strong>flat rate</strong> interest, the interest is calculated on the initial loan amount throughout the entire loan term, regardless of how much you've paid back. This results in higher overall interest payments compared to reducing balance.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How is my monthly payment calculated?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#loanFAQ">
                                <div class="accordion-body">
                                    <p>For reducing balance loans, we use the following formula:</p>
                                    <p><strong>Monthly Payment = P × r × (1 + r)^n / ((1 + r)^n - 1)</strong></p>
                                    <p>Where:</p>
                                    <ul>
                                        <li>P = Principal (loan amount)</li>
                                        <li>r = Monthly interest rate (annual rate ÷ 12)</li>
                                        <li>n = Total number of payments (loan term in months)</li>
                                    </ul>
                                    <p>For flat rate loans, we use:</p>
                                    <p><strong>Monthly Payment = (P + (P × r × n/12)) / n</strong></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What fees are not included in this calculator?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#loanFAQ">
                                <div class="accordion-body">
                                    <p>This calculator provides a basic estimate of your loan payments. It does not include:</p>
                                    <ul>
                                        <li>Loan processing fees (typically 1-3% of the loan amount)</li>
                                        <li>Insurance premiums</li>
                                        <li>Legal fees</li>
                                        <li>Valuation fees (for secured loans)</li>
                                        <li>Early repayment penalties</li>
                                    </ul>
                                    <p>For a comprehensive cost estimate, please contact our loan officers.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I pay off my loan early?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#loanFAQ">
                                <div class="accordion-body">
                                    <p>Yes, you can pay off your loan early. However, some loan products may have early repayment penalties, typically ranging from 1-3% of the remaining balance. Personal loans and auto loans generally have no early repayment penalties, while mortgage loans may have penalties during the first few years.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    How accurate is this calculator?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#loanFAQ">
                                <div class="accordion-body">
                                    <p>This calculator provides estimates based on the information you provide. Actual loan terms, interest rates, and payments may vary based on your credit history, income, and other factors. The calculator is intended for planning purposes only and does not represent a loan offer or guarantee of terms.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Ready to Apply for a Loan?</h2>
                        <p class="cta-subtitle">Our loan officers are ready to help you choose the right loan product for your needs.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-gradient btn-lg">Apply Now</a>
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Loan Calculator Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Get form elements
    const loanForm = document.getElementById('loanCalculatorForm');
    const loanAmount = document.getElementById('loanAmount');
    const loanAmountSlider = document.getElementById('loanAmountSlider');
    const interestRate = document.getElementById('interestRate');
    const interestRateSlider = document.getElementById('interestRateSlider');
    const loanTerm = document.getElementById('loanTerm');
    const loanTermSlider = document.getElementById('loanTermSlider');
    
    // Get result elements
    const monthlyPaymentEl = document.getElementById('monthlyPayment');
    const totalInterestEl = document.getElementById('totalInterest');
    const totalPaymentEl = document.getElementById('totalPayment');
    const effectiveRateEl = document.getElementById('effectiveRate');
    
    // Amortization table elements
    const viewAmortizationBtn = document.getElementById('viewAmortizationBtn');
    const closeAmortizationBtn = document.getElementById('closeAmortizationBtn');
    const amortizationTableContainer = document.querySelector('.amortization-table-container');
    const amortizationTableBody = document.querySelector('#amortizationTable tbody');
    
    // Print results button
    const printResultsBtn = document.getElementById('printResultsBtn');
    
    // Chart variables
    let loanChart;
    
    // Sync input fields with sliders
    loanAmount.addEventListener('input', function() {
        loanAmountSlider.value = this.value;
        calculateLoan();
    });
    
    loanAmountSlider.addEventListener('input', function() {
        loanAmount.value = this.value;
        calculateLoan();
    });
    
    interestRate.addEventListener('input', function() {
        interestRateSlider.value = this.value;
        calculateLoan();
    });
    
    interestRateSlider.addEventListener('input', function() {
        interestRate.value = this.value;
        calculateLoan();
    });
    
    loanTerm.addEventListener('input', function() {
        loanTermSlider.value = this.value;
        calculateLoan();
    });
    
    loanTermSlider.addEventListener('input', function() {
        loanTerm.value = this.value;
        calculateLoan();
    });
    
    // Calculate loan on form submit
    loanForm.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateLoan();
    });
    
    // Calculate loan on repayment method change
    document.querySelectorAll('input[name="repaymentMethod"]').forEach(function(radio) {
        radio.addEventListener('change', calculateLoan);
    });
    
    // View amortization schedule
    viewAmortizationBtn.addEventListener('click', function() {
        amortizationTableContainer.style.display = 'block';
        generateAmortizationTable();
    });
    
    // Close amortization schedule
    closeAmortizationBtn.addEventListener('click', function() {
        amortizationTableContainer.style.display = 'none';
    });
    
    // Print results
    printResultsBtn.addEventListener('click', function() {
        window.print();
    });
    
    // Calculate loan function
    function calculateLoan() {
        // Get values from form
        const principal = parseFloat(loanAmount.value);
        const annualRate = parseFloat(interestRate.value) / 100;
        const months = parseInt(loanTerm.value);
        const repaymentMethod = document.querySelector('input[name="repaymentMethod"]:checked').value;
        
        let monthlyPayment, totalInterest, totalPayment, effectiveRate;
        
        if (repaymentMethod === 'reducing') {
            // Calculate for reducing balance
            const monthlyRate = annualRate / 12;
            monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
            totalPayment = monthlyPayment * months;
            totalInterest = totalPayment - principal;
        } else {
            // Calculate for flat rate
            const totalInterestFlat = principal * annualRate * (months / 12);
            totalPayment = principal + totalInterestFlat;
            monthlyPayment = totalPayment / months;
            totalInterest = totalInterestFlat;
        }
        
        // Calculate effective interest rate
        effectiveRate = ((Math.pow((1 + (totalInterest / principal) / (months / 12)), 12 / (months / 12))) - 1) * 100;
        
        // Update results
        monthlyPaymentEl.textContent = 'KSh ' + formatNumber(monthlyPayment.toFixed(2));
        totalInterestEl.textContent = 'KSh ' + formatNumber(totalInterest.toFixed(2));
        totalPaymentEl.textContent = 'KSh ' + formatNumber(totalPayment.toFixed(2));
        effectiveRateEl.textContent = effectiveRate.toFixed(2) + '%';
        
        // Update chart
        updateChart(principal, totalInterest);
    }
    
    // Generate amortization table
    function generateAmortizationTable() {
        // Clear existing table
        amortizationTableBody.innerHTML = '';
        
        // Get values from form
        const principal = parseFloat(loanAmount.value);
        const annualRate = parseFloat(interestRate.value) / 100;
        const months = parseInt(loanTerm.value);
        const repaymentMethod = document.querySelector('input[name="repaymentMethod"]:checked').value;
        
        const monthlyRate = annualRate / 12;
        let balance = principal;
        let totalInterest = 0;
        
        if (repaymentMethod === 'reducing') {
            // Calculate for reducing balance
            const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
            
            for (let i = 1; i <= months; i++) {
                const interestPayment = balance * monthlyRate;
                const principalPayment = monthlyPayment - interestPayment;
                
                balance -= principalPayment;
                totalInterest += interestPayment;
                
                // Add row to table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>KSh ${formatNumber(monthlyPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(principalPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(interestPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(Math.max(0, balance).toFixed(2))}</td>
                `;
                amortizationTableBody.appendChild(row);
            }
        } else {
            // Calculate for flat rate
            const totalInterestFlat = principal * annualRate * (months / 12);
            const totalPayment = principal + totalInterestFlat;
            const monthlyPayment = totalPayment / months;
            const monthlyPrincipal = principal / months;
            const monthlyInterest = totalInterestFlat / months;
            
            for (let i = 1; i <= months; i++) {
                balance -= monthlyPrincipal;
                
                // Add row to table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>KSh ${formatNumber(monthlyPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(monthlyPrincipal.toFixed(2))}</td>
                    <td>KSh ${formatNumber(monthlyInterest.toFixed(2))}</td>
                    <td>KSh ${formatNumber(Math.max(0, balance).toFixed(2))}</td>
                `;
                amortizationTableBody.appendChild(row);
            }
        }
    }
    
    // Update chart
    function updateChart(principal, totalInterest) {
        const ctx = document.getElementById('loanChart').getContext('2d');
        
        // Destroy existing chart if it exists
        if (loanChart) {
            loanChart.destroy();
        }
        
        // Create new chart
        loanChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal', 'Interest'],
                datasets: [{
                    data: [principal, totalInterest],
                    backgroundColor: ['#667eea', '#764ba2'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return label + ': KSh ' + formatNumber(value.toFixed(2));
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Initial calculation
    calculateLoan();
});
</script>

<?php
get_footer();
