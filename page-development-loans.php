<?php
/**
 * The template for displaying the Development Loans page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main loan-product-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Development Loans</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Development Loans</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/development-loan-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Overview Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <span class="daystar-badge badge-primary">Maximum KSh 2,000,000</span>
                        <h2 class="section-title text-start">Development Loans</h2>
                        <p class="lead">Invest in your long-term development projects with our affordable financing solutions.</p>
                        <p>Our Development Loan is designed to help you achieve your long-term goals, whether you're building a home, starting a business, or making a significant investment. With competitive interest rates and flexible repayment terms, we make it easier for you to turn your dreams into reality.</p>
                        <div class="mt-4">
                            <a href="#apply" class="btn btn-primary me-3">Apply Now</a>
                            <a href="#calculator" class="btn btn-outline-primary">Calculate Repayments</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="loan-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/development-loan-hero.jpg" alt="Development Loan" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Features Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Key Features & Benefits</h2>
                <p class="section-subtitle">Why choose our Development Loan</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-percentage" aria-hidden="true"></i>
                        </div>
                        <h3>Competitive Interest Rate</h3>
                        <p>12% per annum on reducing balance, ensuring you pay less interest over time as your principal decreases.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Flexible Repayment Period</h3>
                        <p>Repay your loan over a period of up to 36 months, allowing you to manage your cash flow effectively.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>High Loan Limit</h3>
                        <p>Borrow up to KSh 2,000,000 to fund substantial development projects and investments.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Flexible Security Options</h3>
                        <p>Secure your loan with your shares, guarantors, or a combination of both for added flexibility.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-signature" aria-hidden="true"></i>
                        </div>
                        <h3>Simple Application Process</h3>
                        <p>Straightforward application process with minimal documentation requirements for faster approval.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>No Hidden Fees</h3>
                        <p>Transparent fee structure with no hidden charges, ensuring you know exactly what you're paying.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 order-lg-2">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Eligibility Criteria</h2>
                        <p class="lead">To qualify for a Development Loan, you must meet the following requirements:</p>
                        
                        <div class="eligibility-list">
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-user-check" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Membership Duration</h4>
                                    <p>Be a member of Daystar Co-op for at least 6 months with consistent contributions.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-coins" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Minimum Contribution</h4>
                                    <p>Have contributed not less than KSh 12,000 (KSh 2,000 × 6 months).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Share Capital</h4>
                                    <p>Own a minimum of KSh 5,000 as share capital (250 shares worth KSh 200 each).</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>No Outstanding Development Loan</h4>
                                    <p>Must not have any outstanding development loan at the time of application.</p>
                                </div>
                            </div>
                            
                            <div class="eligibility-item">
                                <div class="eligibility-icon">
                                    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                </div>
                                <div class="eligibility-content">
                                    <h4>Repayment Capacity</h4>
                                    <p>Your pay slip must demonstrate the ability to support loan repayments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="loan-eligibility-checker fade-in">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0">Eligibility Checker</h3>
                            </div>
                            <div class="card-body">
                                <p>Check if you're eligible for a Development Loan by answering a few simple questions:</p>
                                <form id="eligibilityCheckerForm">
                                    <div class="mb-3">
                                        <label class="form-label">Have you been a member for at least 6 months?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="membershipDuration" id="membershipYes" value="yes">
                                            <label class="form-check-label" for="membershipYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="membershipDuration" id="membershipNo" value="no">
                                            <label class="form-check-label" for="membershipNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Have you contributed at least KSh 12,000 in total?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contribution" id="contributionYes" value="yes">
                                            <label class="form-check-label" for="contributionYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contribution" id="contributionNo" value="no">
                                            <label class="form-check-label" for="contributionNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Do you have at least KSh 5,000 in share capital?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shareCapital" id="shareCapitalYes" value="yes">
                                            <label class="form-check-label" for="shareCapitalYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="shareCapital" id="shareCapitalNo" value="no">
                                            <label class="form-check-label" for="shareCapitalNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Do you have any outstanding development loans?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="outstandingLoan" id="outstandingLoanYes" value="yes">
                                            <label class="form-check-label" for="outstandingLoanYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="outstandingLoan" id="outstandingLoanNo" value="no">
                                            <label class="form-check-label" for="outstandingLoanNo">No</label>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">Check Eligibility</button>
                                </form>
                                
                                <div id="eligibilityResult" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Calculator Section -->
    <section id="calculator" class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Development Loan Calculator</h2>
                <p class="section-subtitle">Estimate your monthly payments and total interest</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="calculator-card fade-in">
                        <div class="calculator-header">
                            <h3>Calculate Your Loan</h3>
                            <p>Adjust the sliders to see how different loan amounts and terms affect your repayments</p>
                        </div>
                        
                        <div class="calculator-body">
                            <form id="loanCalculatorForm">
                                <div class="form-group mb-4">
                                    <label for="loanAmount" class="form-label">Loan Amount (KSh)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control" id="loanAmount" min="10000" max="2000000" value="500000" required>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanAmountSlider" min="10000" max="2000000" step="10000" value="500000">
                                        <div class="range-labels">
                                            <span>KSh 10,000</span>
                                            <span>KSh 2,000,000</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="loanTerm" class="form-label">Loan Term (months)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="loanTerm" min="1" max="36" value="24" required>
                                        <span class="input-group-text">months</span>
                                    </div>
                                    <div class="range-slider mt-2">
                                        <input type="range" class="form-range" id="loanTermSlider" min="1" max="36" step="1" value="24">
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
                
                <div class="col-lg-6">
                    <div class="results-card fade-in">
                        <div class="results-header">
                            <h3>Loan Summary</h3>
                            <p>Your estimated loan repayment details</p>
                        </div>
                        
                        <div class="results-body">
                            <div class="results-summary">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Monthly Payment</h4>
                                            <div class="summary-value" id="monthlyPayment">KSh 23,433.33</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Interest</h4>
                                            <div class="summary-value" id="totalInterest">KSh 62,400.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Total Payment</h4>
                                            <div class="summary-value" id="totalPayment">KSh 562,400.00</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="summary-item">
                                            <h4>Interest Rate</h4>
                                            <div class="summary-value">12% p.a.</div>
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
    </section>

    <!-- Application Process Section -->
    <section id="apply" class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Application Process</h2>
                <p class="section-subtitle">Follow these simple steps to apply for your Development Loan</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Check Eligibility</h3>
                            <p class="step-description">Ensure you meet all the eligibility criteria before applying.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Complete Application</h3>
                            <p class="step-description">Fill out the loan application form with all required details.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Submit Documents</h3>
                            <p class="step-description">Provide necessary documentation including pay slips and ID.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Loan Approval</h3>
                            <p class="step-description">Receive notification of approval and loan disbursement.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary btn-lg">Apply for a Development Loan</a>
            </div>
        </div>
    </section>

    <!-- Required Documents Section -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Required Documents</h2>
                        <p class="lead">Please prepare the following documents for your loan application:</p>
                        
                        <ul class="document-list">
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Completed loan application form
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Copy of national ID or passport
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Recent pay slips (last 3 months)
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Bank statements (last 3 months)
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Guarantor forms (if applicable)
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                Project proposal or quotation (for large loans)
                            </li>
                        </ul>
                        
                        <div class="mt-4">
                            <a href="<?php echo esc_url(home_url('downloads')); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-download me-2" aria-hidden="true"></i> Download Application Forms
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="document-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/documents-illustration.jpg" alt="Required Documents" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about our Development Loans</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion fade-in" id="developmentLoanFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How long does it take to process a Development Loan?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#developmentLoanFAQ">
                                <div class="accordion-body">
                                    <p>Development Loan applications are typically processed within 7-14 working days from the date of submission, provided all required documentation is complete and in order. You will receive notification of the loan approval status within 3 days after the credit committee meeting.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can I repay my Development Loan early?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#developmentLoanFAQ">
                                <div class="accordion-body">
                                    <p>Yes, you can repay your Development Loan early without any prepayment penalties. Early repayment will reduce the total interest paid over the life of the loan. To make an early repayment, simply contact our office or submit a request through your member portal.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How many guarantors do I need for a Development Loan?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#developmentLoanFAQ">
                                <div class="accordion-body">
                                    <p>The number of guarantors required depends on the loan amount:</p>
                                    <ul>
                                        <li>For loans up to KSh 500,000: Minimum 2 guarantors</li>
                                        <li>For loans between KSh 500,001 and KSh 1,000,000: Minimum 3 guarantors</li>
                                        <li>For loans between KSh 1,000,001 and KSh 2,000,000: Minimum 4 guarantors</li>
                                    </ul>
                                    <p>All guarantors must be active members of Daystar Co-op with sufficient shares to cover the guaranteed amount.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    What happens if I miss a loan repayment?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#developmentLoanFAQ">
                                <div class="accordion-body">
                                    <p>If you miss a loan repayment, the following will apply:</p>
                                    <ul>
                                        <li>A late payment fee will be charged</li>
                                        <li>The loan will be classified as delinquent after 30 days</li>
                                        <li>After 60 days, recovery procedures will be initiated, which may include contacting guarantors</li>
                                        <li>Continued delinquency may result in blacklisting</li>
                                    </ul>
                                    <p>If you anticipate difficulty making a payment, please contact us immediately to discuss possible arrangements.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Can I apply for another loan while repaying a Development Loan?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#developmentLoanFAQ">
                                <div class="accordion-body">
                                    <p>While you cannot have multiple Development Loans simultaneously, you may be eligible for other loan products such as Emergency Loans or School Fees Loans while repaying a Development Loan, provided:</p>
                                    <ul>
                                        <li>Your current loan repayments are up to date</li>
                                        <li>Your pay slip can support the additional loan repayment</li>
                                        <li>You meet all other eligibility criteria for the additional loan</li>
                                    </ul>
                                    <p>Each application is assessed on a case-by-case basis by the credit committee.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <p>Have more questions? <a href="<?php echo esc_url(home_url('contact-us')); ?>">Contact our loan officers</a> for personalized assistance.</p>
            </div>
        </div>
    </section>

    <!-- Enhanced Dynamic Testimonials Section -->
    <section class="section testimonials-section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Member Testimonials</h2>
                <p class="section-subtitle">What our members say about our Development Loans</p>
            </div>
            
            <?php
            // Query testimonials from custom post type - Development Loans specific
            $testimonials_query = new WP_Query(array(
                'post_type' => 'testimonial',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'rand', // Random order for variety
                'tax_query' => array(
                    array(
                        'taxonomy' => 'testimonial_category',
                        'field' => 'slug',
                        'terms' => array('development-loans'),
                        'operator' => 'IN'
                    )
                )
            ));
            
            // Fallback to all testimonials if no categorized ones found
            if (!$testimonials_query->have_posts()) {
                $testimonials_query = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => 8,
                    'post_status' => 'publish',
                    'orderby' => 'rand'
                ));
            }
            
            if ($testimonials_query->have_posts()) : ?>
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                            // Get custom fields using WordPress native functions
                            $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                            $member_since = get_post_meta(get_the_ID(), '_member_since', true);
                            $position = get_post_meta(get_the_ID(), '_position', true);
                            $member_type = get_post_meta(get_the_ID(), '_member_type', true);
                            
                            // Set defaults if fields are empty
                            $rating = $rating ? floatval($rating) : 5;
                            $member_since = $member_since ? $member_since : '';
                            $position = $position ? $position : '';
                            $member_type = $member_type ? $member_type : 'Member';
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card enhanced">
                                <div class="testimonial-quote-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <?php if ($i <= floor($rating)) : ?>
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php elseif ($i <= $rating) : ?>
                                            <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                        <?php else : ?>
                                            <i class="far fa-star" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-content">
                                    <p>"<?php echo wp_trim_words(get_the_content(), 40, '...'); ?>"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title(), 'class' => 'testimonial-img')); ?>
                                        <?php else : ?>
                                            <div class="testimonial-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5><?php the_title(); ?></h5>
                                        <?php if ($position) : ?>
                                            <p class="position"><?php echo esc_html($position); ?></p>
                                        <?php endif; ?>
                                        <?php if ($member_type && $member_type !== 'Member') : ?>
                                            <p class="member-type"><?php echo esc_html($member_type); ?></p>
                                        <?php endif; ?>
                                        <?php if ($member_since) : ?>
                                            <p class="member-since">Member since <?php echo esc_html($member_since); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="testimonials-navigation">
                        <div class="swiper-button-prev testimonials-prev">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="swiper-button-next testimonials-next">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination testimonials-pagination"></div>
                </div>
            <?php else : ?>
                <!-- Fallback static testimonials if no dynamic content -->
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-card enhanced">
                                <div class="testimonial-quote-icon">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="testimonial-content">
                                    <p>"The Development Loan from Daystar SACCO enabled me to build my dream home. The process was smooth and the interest rates were very competitive compared to commercial banks."</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="testimonial-author-img">
                                        <div class="testimonial-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-author-info">
                                        <h5>John Kamau</h5>
                                        <p class="position">Senior Lecturer</p>
                                        <p class="member-since">Member since 2018</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="testimonials-navigation">
                        <div class="swiper-button-prev testimonials-prev">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="swiper-button-next testimonials-next">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination testimonials-pagination"></div>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Ready to Apply for a Development Loan?</h2>
                        <p class="cta-subtitle">Take the first step toward achieving your development goals today.</p>
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
    
    // Eligibility Checker
    const eligibilityCheckerForm = document.getElementById('eligibilityCheckerForm');
    const eligibilityResult = document.getElementById('eligibilityResult');
    
    if (eligibilityCheckerForm) {
        eligibilityCheckerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const membershipDuration = document.querySelector('input[name="membershipDuration"]:checked')?.value;
            const contribution = document.querySelector('input[name="contribution"]:checked')?.value;
            const shareCapital = document.querySelector('input[name="shareCapital"]:checked')?.value;
            const outstandingLoan = document.querySelector('input[name="outstandingLoan"]:checked')?.value;
            
            if (!membershipDuration || !contribution || !shareCapital || !outstandingLoan) {
                eligibilityResult.innerHTML = '<div class="alert alert-warning">Please answer all questions to check your eligibility.</div>';
                eligibilityResult.style.display = 'block';
                return;
            }
            
            if (membershipDuration === 'yes' && contribution === 'yes' && shareCapital === 'yes' && outstandingLoan === 'no') {
                eligibilityResult.innerHTML = '<div class="alert alert-success"><strong>Congratulations!</strong> Based on your responses, you appear to be eligible for a Development Loan. Please proceed with your application.</div>';
            } else {
                let reasons = [];
                if (membershipDuration === 'no') reasons.push('You must be a member for at least 6 months');
                if (contribution === 'no') reasons.push('You must have contributed at least KSh 12,000');
                if (shareCapital === 'no') reasons.push('You must have at least KSh 5,000 in share capital');
                if (outstandingLoan === 'yes') reasons.push('You must not have any outstanding development loans');
                
                let reasonsHtml = reasons.map(reason => `<li>${reason}</li>`).join('');
                eligibilityResult.innerHTML = `<div class="alert alert-danger"><strong>You may not be eligible at this time.</strong> Reasons:<ul>${reasonsHtml}</ul>Please contact our office for more information.</div>`;
            }
            
            eligibilityResult.style.display = 'block';
        });
    }
    
    // Loan Calculator
    const loanForm = document.getElementById('loanCalculatorForm');
    const loanAmount = document.getElementById('loanAmount');
    const loanAmountSlider = document.getElementById('loanAmountSlider');
    const loanTerm = document.getElementById('loanTerm');
    const loanTermSlider = document.getElementById('loanTermSlider');
    
    // Get result elements
    const monthlyPaymentEl = document.getElementById('monthlyPayment');
    const totalInterestEl = document.getElementById('totalInterest');
    const totalPaymentEl = document.getElementById('totalPayment');
    
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
    if (viewAmortizationBtn) {
        viewAmortizationBtn.addEventListener('click', function() {
            amortizationTableContainer.style.display = 'block';
            generateAmortizationTable();
        });
    }
    
    // Close amortization schedule
    if (closeAmortizationBtn) {
        closeAmortizationBtn.addEventListener('click', function() {
            amortizationTableContainer.style.display = 'none';
        });
    }
    
    // Print results
    if (printResultsBtn) {
        printResultsBtn.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Calculate loan function
    function calculateLoan() {
        if (!loanAmount || !loanTerm || !monthlyPaymentEl || !totalInterestEl || !totalPaymentEl) return;
        
        // Get values from form
        const principal = parseFloat(loanAmount.value);
        const annualRate = 0.12; // 12% per annum
        const months = parseInt(loanTerm.value);
        
        // Calculate for reducing balance
        const monthlyRate = annualRate / 12;
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
        if (!amortizationTableBody || !loanAmount || !loanTerm) return;
        
        // Clear existing table
        amortizationTableBody.innerHTML = '';
        
        // Get values from form
        const principal = parseFloat(loanAmount.value);
        const annualRate = 0.12; // 12% per annum
        const months = parseInt(loanTerm.value);
        
        const monthlyRate = annualRate / 12;
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
            amortizationTableBody.appendChild(row);
        }
    }
    
    // Update chart
    function updateChart(principal, totalInterest) {
        const ctx = document.getElementById('loanChart');
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
