<?php
/**
 * The template for displaying the Loan Calculator page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
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
                            <li class="breadcrumb-item active" aria-current="page">Loan Calculator</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calculator Introduction Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Plan Your Finances</h2>
                        <p class="lead">Use our loan calculators to estimate your monthly payments and plan your finances effectively.</p>
                        <p>Our easy-to-use calculators help you determine loan repayments, interest costs, and total payment amounts for all our loan products. Make informed financial decisions with accurate calculations based on Daystar Co-op's actual loan terms and interest rates.</p>
                        <div class="daystar-notice notice-info mt-4">
                            <p><strong>Note:</strong> These calculators provide estimates based on our current rates and terms. Actual loan terms may vary based on individual circumstances and credit committee approval.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="calculator-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/calculator-illustration.jpg" alt="Loan Calculator" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Type Selector Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Choose Your Loan Type</h2>
                <p class="section-subtitle">Select the loan product you're interested in</p>
            </div>
            
            <div class="loan-types-tabs fade-in">
                <ul class="nav nav-pills mb-4 justify-content-center" id="loanTypesTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="development-tab" data-bs-toggle="pill" data-bs-target="#development" type="button" role="tab" aria-controls="development" aria-selected="true">Development</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="school-tab" data-bs-toggle="pill" data-bs-target="#school" type="button" role="tab" aria-controls="school" aria-selected="false">School Fees</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="emergency-tab" data-bs-toggle="pill" data-bs-target="#emergency" type="button" role="tab" aria-controls="emergency" aria-selected="false">Emergency</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="special-tab" data-bs-toggle="pill" data-bs-target="#special" type="button" role="tab" aria-controls="special" aria-selected="false">Special</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="supersaver-tab" data-bs-toggle="pill" data-bs-target="#supersaver" type="button" role="tab" aria-controls="supersaver" aria-selected="false">Super Saver</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="salary-tab" data-bs-toggle="pill" data-bs-target="#salary" type="button" role="tab" aria-controls="salary" aria-selected="false">Salary Advance</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="loanTypesTabContent">
                    <!-- Development Loan Calculator -->
                    <div class="tab-pane fade show active" id="development" role="tabpanel" aria-labelledby="development-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>Development Loan</h3>
                                    <p>For your long-term development projects and investments.</p>
                                    <ul class="loan-features">
                                        <li><strong>Maximum Amount:</strong> KSh 2,000,000</li>
                                        <li><strong>Interest Rate:</strong> 12% per annum on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> Up to 36 months</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('development-loans')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="calculator-card fade-in">
                                                <div class="calculator-header">
                                                    <h3>Calculate Your Loan</h3>
                                                </div>
                                                
                                                <div class="calculator-body">
                                                    <form id="developmentLoanForm">
                                                        <div class="form-group mb-4">
                                                            <label for="developmentAmount" class="form-label">Loan Amount (KSh)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">KSh</span>
                                                                <input type="number" class="form-control" id="developmentAmount" min="10000" max="2000000" value="500000" required>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" class="form-range" id="developmentAmountSlider" min="10000" max="2000000" step="10000" value="500000">
                                                                <div class="range-labels">
                                                                    <span>KSh 10,000</span>
                                                                    <span>KSh 2,000,000</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group mb-4">
                                                            <label for="developmentTerm" class="form-label">Loan Term (months)</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="developmentTerm" min="1" max="36" value="24" required>
                                                                <span class="input-group-text">months</span>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" class="form-range" id="developmentTermSlider" min="1" max="36" step="1" value="24">
                                                                <div class="range-labels">
                                                                    <span>1 month</span>
                                                                    <span>36 months</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary w-100">Calculate</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="results-card fade-in">
                                                <div class="results-header">
                                                    <h3>Loan Summary</h3>
                                                </div>
                                                
                                                <div class="results-body">
                                                    <div class="results-summary">
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Monthly Payment</h4>
                                                                    <div class="summary-value" id="developmentMonthlyPayment">KSh 23,433.33</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Interest</h4>
                                                                    <div class="summary-value" id="developmentTotalInterest">KSh 62,400.00</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Payment</h4>
                                                                    <div class="summary-value" id="developmentTotalPayment">KSh 562,400.00</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Interest Rate</h4>
                                                                    <div class="summary-value">12% p.a.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="chart-container mt-3">
                                                        <canvas id="developmentLoanChart"></canvas>
                                                    </div>
                                                    
                                                    <div class="results-actions mt-3">
                                                        <button class="btn btn-outline-primary btn-sm" id="developmentAmortizationBtn">
                                                            <i class="fas fa-table me-1" aria-hidden="true"></i> View Schedule
                                                        </button>
                                                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary btn-sm ms-2">
                                                            <i class="fas fa-file-signature me-1" aria-hidden="true"></i> Apply Now
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="amortization-table-container mt-4 fade-in" id="developmentAmortizationContainer" style="display: none;">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0">Amortization Schedule</h3>
                                                <button type="button" class="btn-close" id="closeDevAmortizationBtn" aria-label="Close"></button>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover" id="developmentAmortizationTable">
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
                    </div>
                    
                    <!-- School Fees Loan Calculator -->
                    <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="school-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>School Fees Loan</h3>
                                    <p>Invest in education with our affordable school fees financing.</p>
                                    <ul class="loan-features">
                                        <li><strong>Interest Rate:</strong> 12% per annum on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> Up to 12 months</li>
                                        <li><strong>Requirements:</strong> Fee structure or admission letter</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('school-fees-loans')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="calculator-card fade-in">
                                                <div class="calculator-header">
                                                    <h3>Calculate Your Loan</h3>
                                                </div>
                                                
                                                <div class="calculator-body">
                                                    <form id="schoolFeesLoanForm">
                                                        <div class="form-group mb-4">
                                                            <label for="schoolFeesAmount" class="form-label">Loan Amount (KSh)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">KSh</span>
                                                                <input type="number" class="form-control" id="schoolFeesAmount" min="10000" max="500000" value="100000" required>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" class="form-range" id="schoolFeesAmountSlider" min="10000" max="500000" step="5000" value="100000">
                                                                <div class="range-labels">
                                                                    <span>KSh 10,000</span>
                                                                    <span>KSh 500,000</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group mb-4">
                                                            <label for="schoolFeesTerm" class="form-label">Loan Term (months)</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="schoolFeesTerm" min="1" max="12" value="12" required>
                                                                <span class="input-group-text">months</span>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" class="form-range" id="schoolFeesTermSlider" min="1" max="12" step="1" value="12">
                                                                <div class="range-labels">
                                                                    <span>1 month</span>
                                                                    <span>12 months</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary w-100">Calculate</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="results-card fade-in">
                                                <div class="results-header">
                                                    <h3>Loan Summary</h3>
                                                </div>
                                                
                                                <div class="results-body">
                                                    <div class="results-summary">
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Monthly Payment</h4>
                                                                    <div class="summary-value" id="schoolFeesMonthlyPayment">KSh 8,884.88</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Interest</h4>
                                                                    <div class="summary-value" id="schoolFeesTotalInterest">KSh 6,618.56</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Payment</h4>
                                                                    <div class="summary-value" id="schoolFeesTotalPayment">KSh 106,618.56</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Interest Rate</h4>
                                                                    <div class="summary-value">12% p.a.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="chart-container mt-3">
                                                        <canvas id="schoolFeesLoanChart"></canvas>
                                                    </div>
                                                    
                                                    <div class="results-actions mt-3">
                                                        <button class="btn btn-outline-primary btn-sm" id="schoolFeesAmortizationBtn">
                                                            <i class="fas fa-table me-1" aria-hidden="true"></i> View Schedule
                                                        </button>
                                                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary btn-sm ms-2">
                                                            <i class="fas fa-file-signature me-1" aria-hidden="true"></i> Apply Now
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="amortization-table-container mt-4 fade-in" id="schoolFeesAmortizationContainer" style="display: none;">
                                        <!-- School Fees Amortization Table (similar structure to Development Loan) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Emergency Loan Calculator -->
                    <div class="tab-pane fade" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>Emergency Loan</h3>
                                    <p>Quick financial assistance for unexpected situations.</p>
                                    <ul class="loan-features">
                                        <li><strong>Maximum Amount:</strong> KSh 100,000</li>
                                        <li><strong>Repayment Period:</strong> Up to 12 months</li>
                                        <li><strong>Eligible Emergencies:</strong> Hospitalization, funeral expenses, court fines, etc.</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('emergency-loans')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <!-- Emergency Loan Calculator (similar structure to Development Loan) -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Loan Calculator -->
                    <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>Special Loan</h3>
                                    <p>Character-based loans without payslip consideration.</p>
                                    <ul class="loan-features">
                                        <li><strong>Maximum Amount:</strong> KSh 200,000</li>
                                        <li><strong>Interest Rate:</strong> 5% per month on reducing balance</li>
                                        <li><strong>Repayment Period:</strong> 4-6 months (based on amount)</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('special-loans')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <!-- Special Loan Calculator (similar structure to Development Loan) -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Super Saver Loan Calculator -->
                    <div class="tab-pane fade" id="supersaver" role="tabpanel" aria-labelledby="supersaver-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>Super Saver Loan</h3>
                                    <p>Premium loans for our high-deposit members.</p>
                                    <ul class="loan-features">
                                        <li><strong>Maximum Amount:</strong> KSh 3,000,000</li>
                                        <li><strong>Repayment Period:</strong> Up to 48 months</li>
                                        <li><strong>Eligibility:</strong> Deposits of more than KSh 1,000,000</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('super-saver-loans')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <!-- Super Saver Loan Calculator (similar structure to Development Loan) -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Salary Advance Calculator -->
                    <div class="tab-pane fade" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3>Salary Advance</h3>
                                    <p>Short-term financial assistance for immediate needs.</p>
                                    <ul class="loan-features">
                                        <li><strong>Repayment Period:</strong> Maximum 3 months</li>
                                        <li><strong>Interest Fee:</strong> 10% one-off charge for first month (members)</li>
                                        <li><strong>Non-members:</strong> 12.5% for one month</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('salary-advance')); ?>" class="btn btn-outline-primary btn-sm">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="calculator-container">
                                    <!-- Salary Advance Calculator (similar structure to Development Loan) -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Comparison Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Loan Comparison</h2>
                <p class="section-subtitle">Compare our different loan products to find the best fit for your needs</p>
            </div>
            
            <div class="table-responsive fade-in">
                <table class="table loan-comparison-table">
                    <thead>
                        <tr>
                            <th>Loan Type</th>
                            <th>Maximum Amount</th>
                            <th>Interest Rate</th>
                            <th>Repayment Period</th>
                            <th>Key Requirements</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Development Loan</th>
                            <td>KSh 2,000,000</td>
                            <td>12% p.a. reducing balance</td>
                            <td>Up to 36 months</td>
                            <td>Pay slip, no outstanding development loan</td>
                        </tr>
                        <tr>
                            <th>School Fees Loan</th>
                            <td>Varies</td>
                            <td>12% p.a. reducing balance</td>
                            <td>Up to 12 months</td>
                            <td>Fee structure/admission letter, no outstanding school fees loan</td>
                        </tr>
                        <tr>
                            <th>Emergency Loan</th>
                            <td>KSh 100,000</td>
                            <td>12% p.a. reducing balance</td>
                            <td>Up to 12 months</td>
                            <td>Documentary evidence of emergency, no outstanding emergency loan</td>
                        </tr>
                        <tr>
                            <th>Special Loan</th>
                            <td>KSh 200,000</td>
                            <td>5% per month reducing balance</td>
                            <td>4-6 months (based on amount)</td>
                            <td>Postdated cheques, good credit history</td>
                        </tr>
                        <tr>
                            <th>Super Saver Loan</th>
                            <td>KSh 3,000,000</td>
                            <td>12% p.a. reducing balance</td>
                            <td>Up to 48 months</td>
                            <td>Deposits of more than KSh 1,000,000</td>
                        </tr>
                        <tr>
                            <th>Salary Advance</th>
                            <td>Varies</td>
                            <td>10% one-off (members)<br>12.5% one-off (non-members)</td>
                            <td>Up to 3 months</td>
                            <td>Proof of capacity to repay</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="daystar-notice notice-info mt-4 fade-in">
                <p><strong>Note:</strong> All loans require a minimum membership period of 6 months with consistent contributions of not less than KSh 12,000 (KSh 2,000 × 6 months) and minimum share capital of KSh 5,000 (250 shares worth KSh 200 each).</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about our loan calculators</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion fade-in" id="calculatorFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How accurate are these loan calculators?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#calculatorFAQ">
                                <div class="accordion-body">
                                    <p>Our calculators provide estimates based on the current interest rates and terms for each loan product. The calculations use the reducing balance method, which is how Daystar Co-op computes interest. While these estimates are generally accurate, the actual loan terms may vary based on individual circumstances, credit committee approval, and any changes to our loan policies.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What is the reducing balance method?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#calculatorFAQ">
                                <div class="accordion-body">
                                    <p>The reducing balance method calculates interest based on the outstanding principal amount, which decreases with each payment. This means you pay less interest over time as your principal decreases. This method is more favorable to borrowers compared to the flat rate method, where interest is calculated on the initial loan amount throughout the loan term.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Are there any fees not included in these calculations?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#calculatorFAQ">
                                <div class="accordion-body">
                                    <p>The calculators focus on the principal and interest components of your loan. Additional fees that may apply include:</p>
                                    <ul>
                                        <li>Loan application fees</li>
                                        <li>Processing fees</li>
                                        <li>Insurance fees (if applicable)</li>
                                        <li>Late payment penalties</li>
                                    </ul>
                                    <p>For a complete breakdown of all applicable fees, please contact our loan officers or refer to the specific loan product pages.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I save or print my calculation results?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#calculatorFAQ">
                                <div class="accordion-body">
                                    <p>Yes, you can print your calculation results by clicking the "Print Results" button that appears after calculating your loan. This will print the loan summary and amortization schedule if it's currently displayed. You can also take a screenshot of your results for future reference.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    What is an amortization schedule?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#calculatorFAQ">
                                <div class="accordion-body">
                                    <p>An amortization schedule is a table showing the breakdown of each loan payment into principal and interest components over the life of the loan. It helps you understand:</p>
                                    <ul>
                                        <li>How much of each payment goes toward the principal</li>
                                        <li>How much goes toward interest</li>
                                        <li>How your loan balance decreases over time</li>
                                        <li>The total amount you'll pay in interest</li>
                                    </ul>
                                    <p>You can view the amortization schedule for any loan calculation by clicking the "View Schedule" button after calculating your loan.</p>
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
                        <p class="cta-subtitle">Take the first step toward achieving your financial goals today.</p>
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
    // Development Loan Calculator
    initLoanCalculator(
        'development',
        'developmentAmount',
        'developmentAmountSlider',
        'developmentTerm',
        'developmentTermSlider',
        'developmentLoanForm',
        'developmentMonthlyPayment',
        'developmentTotalInterest',
        'developmentTotalPayment',
        'developmentLoanChart',
        'developmentAmortizationBtn',
        'developmentAmortizationContainer',
        'closeDevAmortizationBtn',
        'developmentAmortizationTable',
        0.12 // 12% annual interest rate
    );
    
    // School Fees Loan Calculator
    initLoanCalculator(
        'schoolFees',
        'schoolFeesAmount',
        'schoolFeesAmountSlider',
        'schoolFeesTerm',
        'schoolFeesTermSlider',
        'schoolFeesLoanForm',
        'schoolFeesMonthlyPayment',
        'schoolFeesTotalInterest',
        'schoolFeesTotalPayment',
        'schoolFeesLoanChart',
        'schoolFeesAmortizationBtn',
        'schoolFeesAmortizationContainer',
        'closeSchoolFeesAmortizationBtn',
        'schoolFeesAmortizationTable',
        0.12 // 12% annual interest rate
    );
    
    // Function to initialize loan calculators
    function initLoanCalculator(
        prefix,
        amountId,
        amountSliderId,
        termId,
        termSliderId,
        formId,
        monthlyPaymentId,
        totalInterestId,
        totalPaymentId,
        chartId,
        amortizationBtnId,
        amortizationContainerId,
        closeAmortizationBtnId,
        amortizationTableId,
        annualInterestRate
    ) {
        const loanAmount = document.getElementById(amountId);
        const loanAmountSlider = document.getElementById(amountSliderId);
        const loanTerm = document.getElementById(termId);
        const loanTermSlider = document.getElementById(termSliderId);
        const loanForm = document.getElementById(formId);
        const monthlyPaymentEl = document.getElementById(monthlyPaymentId);
        const totalInterestEl = document.getElementById(totalInterestId);
        const totalPaymentEl = document.getElementById(totalPaymentId);
        const amortizationBtn = document.getElementById(amortizationBtnId);
        const amortizationContainer = document.getElementById(amortizationContainerId);
        const closeAmortizationBtn = document.getElementById(closeAmortizationBtnId);
        const amortizationTable = document.getElementById(amortizationTableId);
        
        let loanChart;
        
        // Skip if elements don't exist
        if (!loanAmount || !loanTerm || !loanForm) return;
        
        // Sync input fields with sliders
        if (loanAmount && loanAmountSlider) {
            loanAmount.addEventListener('input', function() {
                loanAmountSlider.value = this.value;
                calculateLoan();
            });
            
            loanAmountSlider.addEventListener('input', function() {
                loanAmount.value = this.value;
                calculateLoan();
            });
        }
        
        if (loanTerm && loanTermSlider) {
            loanTerm.addEventListener('input', function() {
                loanTermSlider.value = this.value;
                calculateLoan();
            });
            
            loanTermSlider.addEventListener('input', function() {
                loanTerm.value = this.value;
                calculateLoan();
            });
        }
        
        // Calculate loan on form submit
        if (loanForm) {
            loanForm.addEventListener('submit', function(e) {
                e.preventDefault();
                calculateLoan();
            });
        }
        
        // View amortization schedule
        if (amortizationBtn && amortizationContainer) {
            amortizationBtn.addEventListener('click', function() {
                amortizationContainer.style.display = 'block';
                generateAmortizationTable();
            });
        }
        
        // Close amortization schedule
        if (closeAmortizationBtn && amortizationContainer) {
            closeAmortizationBtn.addEventListener('click', function() {
                amortizationContainer.style.display = 'none';
            });
        }
        
        // Calculate loan function
        function calculateLoan() {
            if (!loanAmount || !loanTerm || !monthlyPaymentEl || !totalInterestEl || !totalPaymentEl) return;
            
            // Get values from form
            const principal = parseFloat(loanAmount.value);
            const months = parseInt(loanTerm.value);
            
            // Calculate for reducing balance
            const monthlyRate = annualInterestRate / 12;
            const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - principal;
            
            // Update results
            monthlyPaymentEl.textContent = 'KSh ' + formatNumber(monthlyPayment.toFixed(2));
            totalInterestEl.textContent = 'KSh ' + formatNumber(totalInterest.toFixed(2));
            totalPaymentEl.textContent = 'KSh ' + formatNumber(totalPayment.toFixed(2));
            
            // Update chart
            updateChart(principal, totalInterest);
        }
        
        // Generate amortization table
        function generateAmortizationTable() {
            if (!amortizationTable || !loanAmount || !loanTerm) return;
            
            // Clear existing table
            amortizationTable.innerHTML = '';
            
            // Get values from form
            const principal = parseFloat(loanAmount.value);
            const months = parseInt(loanTerm.value);
            
            const monthlyRate = annualInterestRate / 12;
            let balance = principal;
            let totalInterest = 0;
            
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
                amortizationTable.appendChild(row);
            }
        }
        
        // Update chart
        function updateChart(principal, totalInterest) {
            const ctx = document.getElementById(chartId);
            if (!ctx) return;
            
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
                        backgroundColor: ['#00447c', '#f7b731'],
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
        
        // Initial calculation
        calculateLoan();
    }
    
    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
});
</script>

<?php
get_footer();
