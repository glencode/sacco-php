<?php
/**
 * The template for displaying the Loan Calculator page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

require_once get_template_directory() . '/includes/loan-products.php';

// Get loan products for dynamic calculator
$loan_products = daystar_get_loan_products_for_frontend();

get_header();

// Enqueue enhanced calculator styles
wp_enqueue_style('loan-calculator-enhanced', get_template_directory_uri() . '/assets/css/pages/page-loan-calculator-enhanced.css', array(), '2.0.0');
wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
?>

<main id="primary" class="site-main calculator-page">
    <!-- Enhanced Hero Section -->
    <section class="calculator-hero">
        <!-- Floating Geometric Elements -->
        <div class="floating-elements">
            <div class="floating-element" style="top: 20%; left: 10%; width: 60px; height: 60px; animation-delay: 0s;"></div>
            <div class="floating-element" style="top: 60%; right: 15%; width: 40px; height: 40px; animation-delay: 2s;"></div>
            <div class="floating-element" style="bottom: 30%; left: 20%; width: 80px; height: 80px; animation-delay: 4s;"></div>
            <div class="floating-element" style="top: 40%; right: 30%; width: 30px; height: 30px; animation-delay: 1s;"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-10 mx-auto text-center">
                    <span class="daystar-badge" data-aos="fade-up">🧮 Smart Financial Planning Tool</span>
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">
                        Advanced Loan Calculator
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="400">
                        Experience the future of financial planning with our intelligent loan calculator. 
                        Get instant, accurate estimates with beautiful visualizations and comprehensive analysis.
                    </p>
                    
                    <!-- Enhanced Breadcrumb -->
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="600">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <i class="fas fa-home me-1"></i>Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-calculator me-1"></i>Loan Calculator
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Enhanced Statistics Grid -->
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="800">
                        <div class="stat-item">
                            <h3><?php echo count($loan_products); ?></h3>
                            <p>💼 Loan Products</p>
                        </div>
                        <div class="stat-item">
                            <h3>8%-15%</h3>
                            <p>📊 Interest Rates</p>
                        </div>
                        <div class="stat-item">
                            <h3>60</h3>
                            <p>📅 Max Months</p>
                        </div>
                        <div class="stat-item">
                            <h3>24/7</h3>
                            <p>🌐 Online Access</p>
                        </div>
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="1000">
                        <a href="#calculator" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-calculator me-2"></i>Start Calculating
                        </a>
                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-file-signature me-2"></i>Apply for Loan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="calculator-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="intro-content glass-card" data-aos="fade-up">
                        <div class="icon-section text-center">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h2 class="section-title text-center">Smart Financial Planning</h2>
                        <p class="lead text-center">
                            Make informed financial decisions with our comprehensive loan calculator. 
                            Get accurate estimates based on Daystar Co-op's actual loan terms and competitive interest rates.
                        </p>
                        
                        <!-- Feature Highlights -->
                        <div class="feature-highlights">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item">
                                        <div class="feature-icon">⚡</div>
                                        <h4>Instant Results</h4>
                                        <p>Get calculations in real-time as you adjust loan parameters</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item">
                                        <div class="feature-icon">📊</div>
                                        <h4>Visual Analytics</h4>
                                        <p>Beautiful charts and graphs to understand your loan breakdown</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item">
                                        <div class="feature-icon">🎯</div>
                                        <h4>Accurate Estimates</h4>
                                        <p>Based on actual Daystar Co-op rates and terms</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="calculator-intro-text">
                            <p>Our easy-to-use calculators help you determine loan repayments, interest costs, and total payment amounts for all our loan products. Whether you're planning a major purchase, need emergency funds, or looking to invest in development projects, our calculator provides the insights you need to make confident financial decisions.</p>
                        </div>
                        
                        <div class="daystar-notice notice-info mt-4">
                            <p><strong>Note:</strong> These calculators provide estimates based on our current rates and terms. Actual loan terms may vary based on individual circumstances and credit committee approval.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Calculator Section -->
    <section id="calculator" class="calculator-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Choose Your Loan Type</h2>
                        <p class="section-subtitle text-center mb-5">Select the loan product you're interested in to get started</p>
                        
                        <div class="loan-types-tabs">
                <ul class="nav nav-pills mb-4 justify-content-center" id="loanTypesTab" role="tablist">
                    <?php foreach ($loan_products as $index => $product) : 
                        $tab_id = strtolower(str_replace(' ', '-', $product['name']));
                        $is_active = $index === 0 ? 'active' : '';
                        $is_selected = $index === 0 ? 'true' : 'false';
                    ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $is_active; ?>" 
                                id="<?php echo $tab_id; ?>-tab" 
                                data-bs-toggle="pill" 
                                data-bs-target="#<?php echo $tab_id; ?>" 
                                data-product-id="<?php echo $product['id']; ?>"
                                type="button" 
                                role="tab" 
                                aria-controls="<?php echo $tab_id; ?>" 
                                aria-selected="<?php echo $is_selected; ?>">
                            <?php echo esc_html(str_replace(' Loan', '', $product['name'])); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
                
                <div class="tab-content" id="loanTypesTabContent">
                    <?php foreach ($loan_products as $index => $product) : 
                        $tab_id = strtolower(str_replace(' ', '-', $product['name']));
                        $is_active = $index === 0 ? 'show active' : '';
                        $form_id = $tab_id . '-form';
                        $slider_id = $tab_id . '-slider';
                    ?>
                    <!-- <?php echo esc_html($product['name']); ?> Calculator -->
                    <div class="tab-pane fade <?php echo $is_active; ?>" id="<?php echo $tab_id; ?>" role="tabpanel" aria-labelledby="<?php echo $tab_id; ?>-tab">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="loan-info-card fade-in">
                                    <h3><?php echo esc_html($product['name']); ?></h3>
                                    <p><?php echo esc_html($product['description']); ?></p>
                                    <ul class="loan-features">
                                        <li><strong>Amount Range:</strong> KSh <?php echo number_format($product['min_amount']); ?> - KSh <?php echo number_format($product['max_amount']); ?></li>
                                        <li><strong>Interest Rate:</strong> <?php echo $product['interest_rate']; ?>% 
                                            <?php 
                                            switch($product['interest_type']) {
                                                case 'reducing_balance':
                                                    echo 'per annum on reducing balance';
                                                    break;
                                                case 'monthly_reducing_balance':
                case 'monthly_reducing':
                case 'monthly_reducing':
                                                    echo 'per month on reducing balance';
                                                    break;
                                                case 'one_off_charge':
                                                    echo 'one-off charge';
                                                    break;
                                                default:
                                                    echo 'per annum';
                                            }
                                            ?>
                                        </li>
                                        <li><strong>Repayment Period:</strong> <?php echo $product['min_term']; ?> - <?php echo $product['max_term']; ?> months</li>
                                    </ul>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-outline-primary btn-sm">Apply Now</a>
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
                                                    <form id="<?php echo $form_id; ?>" class="loan-calculator-form" data-product-id="<?php echo $product['id']; ?>">
                                                        <div class="form-group mb-4">
                                                            <label for="<?php echo $tab_id; ?>Amount" class="form-label">Loan Amount (KSh)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">KSh</span>
                                                                <input type="number" 
                                                                       class="form-control loan-amount-input" 
                                                                       id="<?php echo $tab_id; ?>Amount" 
                                                                       min="<?php echo $product['min_amount']; ?>" 
                                                                       max="<?php echo $product['max_amount']; ?>" 
                                                                       value="<?php echo min(500000, $product['max_amount']); ?>" 
                                                                       required>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" 
                                                                       class="form-range loan-amount-slider" 
                                                                       id="<?php echo $tab_id; ?>AmountSlider" 
                                                                       min="<?php echo $product['min_amount']; ?>" 
                                                                       max="<?php echo $product['max_amount']; ?>" 
                                                                       step="<?php echo max(1000, $product['min_amount'] / 100); ?>" 
                                                                       value="<?php echo min(500000, $product['max_amount']); ?>">
                                                                <div class="range-labels">
                                                                    <span>KSh <?php echo number_format($product['min_amount']); ?></span>
                                                                    <span>KSh <?php echo number_format($product['max_amount']); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group mb-4">
                                                            <label for="<?php echo $tab_id; ?>Term" class="form-label">Loan Term (months)</label>
                                                            <div class="input-group">
                                                                <input type="number" 
                                                                       class="form-control loan-term-input" 
                                                                       id="<?php echo $tab_id; ?>Term" 
                                                                       min="<?php echo $product['min_term']; ?>" 
                                                                       max="<?php echo $product['max_term']; ?>" 
                                                                       value="<?php echo min(12, $product['max_term']); ?>" 
                                                                       required>
                                                                <span class="input-group-text">months</span>
                                                            </div>
                                                            <div class="range-slider mt-2">
                                                                <input type="range" 
                                                                       class="form-range loan-term-slider" 
                                                                       id="<?php echo $tab_id; ?>TermSlider" 
                                                                       min="<?php echo $product['min_term']; ?>" 
                                                                       max="<?php echo $product['max_term']; ?>" 
                                                                       step="1" 
                                                                       value="<?php echo min(12, $product['max_term']); ?>">
                                                                <div class="range-labels">
                                                                    <span><?php echo $product['min_term']; ?> month<?php echo $product['min_term'] > 1 ? 's' : ''; ?></span>
                                                                    <span><?php echo $product['max_term']; ?> months</span>
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
                                                                    <div class="summary-value" id="<?php echo $tab_id; ?>MonthlyPayment">KSh 0.00</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Interest</h4>
                                                                    <div class="summary-value" id="<?php echo $tab_id; ?>TotalInterest">KSh 0.00</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Total Payment</h4>
                                                                    <div class="summary-value" id="<?php echo $tab_id; ?>TotalPayment">KSh 0.00</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <div class="summary-item">
                                                                    <h4>Interest Rate</h4>
                                                                    <div class="summary-value"><?php echo $product['interest_rate']; ?>% 
                                                                        <?php echo in_array($product['interest_type'], ['monthly_reducing_balance', 'monthly_reducing']) ? 'p.m.' : 'p.a.'; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="chart-container mt-3">
                                                        <canvas id="<?php echo $tab_id; ?>LoanChart"></canvas>
                                                    </div>
                                                    
                                                    <div class="results-actions mt-3">
                                                        <button class="btn btn-outline-primary btn-sm amortization-btn" 
                                                                data-target="<?php echo $tab_id; ?>AmortizationContainer">
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
                                    
                                    <div class="amortization-table-container mt-4 fade-in" id="<?php echo $tab_id; ?>AmortizationContainer" style="display: none;">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0">Amortization Schedule</h3>
                                                <button type="button" class="btn-close close-amortization-btn" 
                                                        data-target="<?php echo $tab_id; ?>AmortizationContainer" 
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover amortization-table" id="<?php echo $tab_id; ?>AmortizationTable">
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
                    <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Comparison Section -->
    <section class="comparison-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Loan Comparison</h2>
                        <p class="section-subtitle text-center mb-5">Compare our different loan products to find the best fit for your needs</p>
                        
                        <div class="table-responsive">
                <table class="table loan-comparison-table">
                    <thead>
                        <tr>
                            <th>Loan Type</th>
                            <th>Amount Range</th>
                            <th>Interest Rate</th>
                            <th>Repayment Period</th>
                            <th>Key Requirements</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loan_products as $product) : ?>
                        <tr>
                            <th><?php echo esc_html($product['name']); ?></th>
                            <td>KSh <?php echo number_format($product['min_amount']); ?> - KSh <?php echo number_format($product['max_amount']); ?></td>
                            <td>
                                <?php echo $product['interest_rate']; ?>% 
                                <?php 
                                switch($product['interest_type']) {
                                    case 'reducing_balance':
                                        echo 'p.a. reducing balance';
                                        break;
                                    case 'monthly_reducing_balance':
                                        echo 'per month reducing balance';
                                        break;
                                    case 'one_off_charge':
                                        echo 'one-off charge';
                                        break;
                                    default:
                                        echo 'p.a.';
                                }
                                ?>
                            </td>
                            <td><?php echo $product['min_term']; ?> - <?php echo $product['max_term']; ?> months</td>
                            <td>
                                <?php 
                                $requirements = array();
                                if (isset($product['eligibility_rules']['requires_payslip']) && $product['eligibility_rules']['requires_payslip']) {
                                    $requirements[] = 'Payslip required';
                                }
                                if (isset($product['eligibility_rules']['requires_guarantors']) && $product['eligibility_rules']['requires_guarantors']) {
                                    $requirements[] = 'Guarantors required';
                                }
                                if (isset($product['eligibility_rules']['min_membership_months'])) {
                                    $requirements[] = $product['eligibility_rules']['min_membership_months'] . ' months membership';
                                }
                                if (isset($product['eligibility_rules']['min_share_capital'])) {
                                    $requirements[] = 'KSh ' . number_format($product['eligibility_rules']['min_share_capital']) . ' share capital';
                                }
                                echo esc_html(implode(', ', array_slice($requirements, 0, 3)));
                                if (count($requirements) > 3) echo '...';
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="daystar-notice notice-info mt-4">
                            <p><strong>Note:</strong> All loans require a minimum membership period of 6 months with consistent contributions of not less than KSh 12,000 (KSh 2,000 × 6 months) and minimum share capital of KSh 5,000 (250 shares worth KSh 200 each).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Frequently Asked Questions</h2>
                        <p class="section-subtitle text-center mb-5">Common questions about our loan calculators</p>
                        
                        <div class="accordion" id="calculatorFAQ">
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
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="cta-content" data-aos="fade-up">
                        <div class="text-center">
                            <h2 class="cta-title mb-4">Ready to Apply for a Loan?</h2>
                            <p class="cta-subtitle mb-4">Take the first step toward achieving your financial goals today.</p>
                            <div class="cta-buttons">
                                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-light btn-lg me-3">
                                    <i class="fas fa-file-signature me-2"></i>Apply Now
                                </a>
                                <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-phone me-2"></i>Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Enhanced Loan Calculator Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<!-- Wait for Chart.js to load before initializing -->
<script>
// Ensure Chart.js is loaded
function waitForChart(callback) {
    if (typeof Chart !== 'undefined') {
        callback();
    } else {
        setTimeout(() => waitForChart(callback), 100);
    }
}

// Initialize when Chart.js is ready
waitForChart(function() {
    console.log('Chart.js is ready, initializing calculator...');
    
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });

    // Pass loan products data to JavaScript
    const loanProducts = <?php echo json_encode($loan_products); ?>;

    // Enhanced smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add scroll effect to navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // Enhanced calculator functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, Chart.js available:', typeof Chart !== 'undefined');
        initializeCalculators();
    });
    
    function initializeCalculators() {
        // Wait for all elements to be rendered
        setTimeout(function() {
            // Initialize all loan calculators dynamically
            loanProducts.forEach(function(product, index) {
                // Match the PHP logic exactly: strtolower(str_replace(' ', '-', $product['name']))
                let tabId = product.name.toLowerCase().replace(/\s+/g, '-');
                
                initDynamicLoanCalculator(product, tabId, index === 0);
            });
        }, 1000); // Wait 1 second for all elements to be ready
    }
    
    // Function to initialize dynamic loan calculators
    function initDynamicLoanCalculator(product, tabId, isFirst) {
        const amountId = tabId + 'Amount';
        const amountSliderId = tabId + 'AmountSlider';
        const termId = tabId + 'Term';
        const termSliderId = tabId + 'TermSlider';
        const formId = tabId + '-form';
        const monthlyPaymentId = tabId + 'MonthlyPayment';
        const totalInterestId = tabId + 'TotalInterest';
        const totalPaymentId = tabId + 'TotalPayment';
        const chartId = tabId + 'LoanChart';
        const amortizationContainerId = tabId + 'AmortizationContainer';
        const amortizationTableId = tabId + 'AmortizationTable';
        
        const loanAmount = document.getElementById(amountId);
        const loanAmountSlider = document.getElementById(amountSliderId);
        const loanTerm = document.getElementById(termId);
        const loanTermSlider = document.getElementById(termSliderId);
        const loanForm = document.getElementById(formId);
        const monthlyPaymentEl = document.getElementById(monthlyPaymentId);
        const totalInterestEl = document.getElementById(totalInterestId);
        const totalPaymentEl = document.getElementById(totalPaymentId);
        const amortizationContainer = document.getElementById(amortizationContainerId);
        const amortizationTable = document.getElementById(amortizationTableId);
        
        let loanChart;
        
        // Skip if critical elements don't exist
        if (!loanAmount || !loanTerm || !loanForm) {
            // Try alternative selectors
            const altLoanAmount = document.querySelector(`#${tabId} .loan-amount-input`);
            const altLoanTerm = document.querySelector(`#${tabId} .loan-term-input`);
            const altLoanForm = document.querySelector(`#${tabId} .loan-calculator-form`);
            
            if (!altLoanAmount || !altLoanTerm || !altLoanForm) {
                return;
            }
            
            // Use alternative elements
            loanAmount = altLoanAmount;
            loanTerm = altLoanTerm;
            loanForm = altLoanForm;
        }
        
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
        
        // Calculate loan function
        function calculateLoan() {
            if (!loanAmount || !loanTerm || !monthlyPaymentEl || !totalInterestEl || !totalPaymentEl) {
                return;
            }
            
            // Get values from form
            const principal = parseFloat(loanAmount.value);
            const months = parseInt(loanTerm.value);
            
            if (isNaN(principal) || isNaN(months) || principal <= 0 || months <= 0) {
                return;
            }
            
            let monthlyPayment, totalPayment, totalInterest;
            
            // Calculate based on product interest type
            switch (product.interest_type) {
                case 'reducing_balance':
                    const monthlyRate = (product.interest_rate / 100) / 12;
                    if (monthlyRate > 0) {
                        monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
                        totalPayment = monthlyPayment * months;
                        totalInterest = totalPayment - principal;
                    } else {
                        monthlyPayment = principal / months;
                        totalPayment = principal;
                        totalInterest = 0;
                    }
                    break;
                    
                case 'monthly_reducing_balance':
                case 'monthly_reducing':
                    // For Special Loans - 5% per month
                    const monthlyRate2 = product.interest_rate / 100;
                    let balance = principal;
                    totalInterest = 0;
                    
                    for (let i = 1; i <= months; i++) {
                        const interestPayment = balance * monthlyRate2;
                        const principalPayment = principal / months;
                        balance -= principalPayment;
                        totalInterest += interestPayment;
                    }
                    
                    monthlyPayment = (principal / months) + (totalInterest / months);
                    totalPayment = principal + totalInterest;
                    break;
                    
                case 'one_off_charge':
                    // For Salary Advance - one-off percentage charge
                    let chargeRate = 10; // Default for members
                    if (product.charges) {
                        for (const charge of product.charges) {
                            if (charge.condition === 'member') {
                                chargeRate = charge.value;
                                break;
                            }
                        }
                    }
                    
                    const oneOffCharge = principal * (chargeRate / 100);
                    monthlyPayment = (principal + oneOffCharge) / months;
                    totalInterest = oneOffCharge;
                    totalPayment = principal + oneOffCharge;
                    break;
                    
                default:
                    // Flat rate calculation
                    totalInterest = principal * (product.interest_rate / 100) * (months / 12);
                    monthlyPayment = (principal + totalInterest) / months;
                    totalPayment = principal + totalInterest;
            }
            
            // Update results with smart text scaling
            if (monthlyPaymentEl) {
                monthlyPaymentEl.textContent = 'KSh ' + formatNumber(monthlyPayment.toFixed(2));
                applySmartTextScaling(monthlyPaymentEl);
            }
            if (totalInterestEl) {
                totalInterestEl.textContent = 'KSh ' + formatNumber(totalInterest.toFixed(2));
                applySmartTextScaling(totalInterestEl);
            }
            if (totalPaymentEl) {
                totalPaymentEl.textContent = 'KSh ' + formatNumber(totalPayment.toFixed(2));
                applySmartTextScaling(totalPaymentEl);
            }
            
            // Update chart
            updateChart(principal, totalInterest);
        }
        
        // Generate amortization table
        function generateAmortizationTable() {
            if (!amortizationTable || !loanAmount || !loanTerm) return;
            
            // Clear existing table
            const tbody = amortizationTable.querySelector('tbody');
            if (tbody) {
                tbody.innerHTML = '';
            }
            
            // Get values from form
            const principal = parseFloat(loanAmount.value);
            const months = parseInt(loanTerm.value);
            let balance = principal;
            
            // Generate schedule based on product type
            for (let i = 1; i <= months; i++) {
                let monthlyPayment, principalPayment, interestPayment;
                
                switch (product.interest_type) {
                    case 'reducing_balance':
                        const monthlyRate = (product.interest_rate / 100) / 12;
                        monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
                        interestPayment = balance * monthlyRate;
                        principalPayment = monthlyPayment - interestPayment;
                        break;
                        
                    case 'monthly_reducing_balance':
                    case 'monthly_reducing':
                        const monthlyRate2 = product.interest_rate / 100;
                        principalPayment = principal / months;
                        interestPayment = balance * monthlyRate2;
                        monthlyPayment = principalPayment + interestPayment;
                        break;
                        
                    case 'one_off_charge':
                        let chargeRate = 10;
                        if (product.charges) {
                            for (const charge of product.charges) {
                                if (charge.condition === 'member') {
                                    chargeRate = charge.value;
                                    break;
                                }
                            }
                        }
                        
                        principalPayment = principal / months;
                        interestPayment = (i === 1) ? principal * (chargeRate / 100) : 0;
                        monthlyPayment = principalPayment + interestPayment;
                        break;
                        
                    default:
                        const totalInterest = principal * (product.interest_rate / 100) * (months / 12);
                        monthlyPayment = (principal + totalInterest) / months;
                        principalPayment = principal / months;
                        interestPayment = totalInterest / months;
                }
                
                balance -= principalPayment;
                
                // Add row to table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>KSh ${formatNumber(monthlyPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(principalPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(interestPayment.toFixed(2))}</td>
                    <td>KSh ${formatNumber(Math.max(0, balance).toFixed(2))}</td>
                `;
                
                if (tbody) {
                    tbody.appendChild(row);
                } else {
                    amortizationTable.appendChild(row);
                }
            }
        }
        
        // Update chart
        function updateChart(principal, totalInterest) {
            const ctx = document.getElementById(chartId);
            if (!ctx) {
                return;
            }
            
            // Destroy existing chart if it exists
            if (loanChart) {
                loanChart.destroy();
            }
            
            // Ensure Chart.js is loaded
            if (typeof Chart === 'undefined') {
                return;
            }
            
            try {
                // Create new chart
                loanChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Principal Amount', 'Total Interest'],
                        datasets: [{
                            data: [principal, totalInterest],
                            backgroundColor: [
                                'rgba(0, 105, 148, 0.8)',
                                'rgba(255, 127, 127, 0.8)'
                            ],
                            borderColor: [
                                'rgba(0, 105, 148, 1)',
                                'rgba(255, 127, 127, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': KSh ' + formatNumber(value.toFixed(2)) + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 1000
                        }
                    }
                });
            } catch (error) {
                // Chart creation failed silently
            }
        }
        
        // Initial calculation
        if (isFirst) {
            // Wait a bit for elements to be ready
            setTimeout(calculateLoan, 500);
        }
        
        // Also trigger calculation when tab becomes active
        const tabButton = document.querySelector(`#${tabId}-tab`);
        if (tabButton) {
            tabButton.addEventListener('shown.bs.tab', function() {
                setTimeout(calculateLoan, 100);
            });
        }
    }
    
    // Global event handlers for amortization buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('amortization-btn')) {
            const targetId = e.target.getAttribute('data-target');
            const container = document.getElementById(targetId);
            if (container) {
                container.style.display = 'block';
                
                // Find the corresponding table and generate schedule
                const tableId = targetId.replace('Container', 'Table');
                const table = document.getElementById(tableId);
                if (table) {
                    // Find the product for this table
                    const tabId = targetId.replace('AmortizationContainer', '');
                    const product = loanProducts.find(p => {
                        const pTabId = p.name.toLowerCase().replace(/\s+/g, '-').replace('loan', '').trim();
                        return (pTabId.endsWith('-') ? pTabId.slice(0, -1) : pTabId) === tabId;
                    });
                    
                    if (product) {
                        generateAmortizationTableForProduct(product, tabId, table);
                    }
                }
            }
        }
        
        if (e.target.classList.contains('close-amortization-btn')) {
            const targetId = e.target.getAttribute('data-target');
            const container = document.getElementById(targetId);
            if (container) {
                container.style.display = 'none';
            }
        }
    });
    
    // Helper function to generate amortization table for a specific product
    function generateAmortizationTableForProduct(product, tabId, table) {
        const amountInput = document.getElementById(tabId + 'Amount');
        const termInput = document.getElementById(tabId + 'Term');
        
        if (!amountInput || !termInput) return;
        
        const principal = parseFloat(amountInput.value);
        const months = parseInt(termInput.value);
        let balance = principal;
        
        // Clear existing table
        const tbody = table.querySelector('tbody');
        if (tbody) {
            tbody.innerHTML = '';
        }
        
        // Generate schedule based on product type
        for (let i = 1; i <= months; i++) {
            let monthlyPayment, principalPayment, interestPayment;
            
            switch (product.interest_type) {
                case 'reducing_balance':
                    const monthlyRate = (product.interest_rate / 100) / 12;
                    monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
                    interestPayment = balance * monthlyRate;
                    principalPayment = monthlyPayment - interestPayment;
                    break;
                    
                case 'monthly_reducing_balance':
                case 'monthly_reducing':
                    const monthlyRate2 = product.interest_rate / 100;
                    principalPayment = principal / months;
                    interestPayment = balance * monthlyRate2;
                    monthlyPayment = principalPayment + interestPayment;
                    break;
                    
                case 'one_off_charge':
                    let chargeRate = 10;
                    if (product.charges) {
                        for (const charge of product.charges) {
                            if (charge.condition === 'member') {
                                chargeRate = charge.value;
                                break;
                            }
                        }
                    }
                    
                    principalPayment = principal / months;
                    interestPayment = (i === 1) ? principal * (chargeRate / 100) : 0;
                    monthlyPayment = principalPayment + interestPayment;
                    break;
                    
                default:
                    const totalInterest = principal * (product.interest_rate / 100) * (months / 12);
                    monthlyPayment = (principal + totalInterest) / months;
                    principalPayment = principal / months;
                    interestPayment = totalInterest / months;
            }
            
            balance -= principalPayment;
            
            // Add row to table
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${i}</td>
                <td>KSh ${formatNumber(monthlyPayment.toFixed(2))}</td>
                <td>KSh ${formatNumber(principalPayment.toFixed(2))}</td>
                <td>KSh ${formatNumber(interestPayment.toFixed(2))}</td>
                <td>KSh ${formatNumber(Math.max(0, balance).toFixed(2))}</td>
            `;
            
            if (tbody) {
                tbody.appendChild(row);
            } else {
                table.appendChild(row);
            }
        }
    }
    
    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Smart text scaling function
    function applySmartTextScaling(element) {
        if (!element) return;
        
        // Remove existing text length classes
        element.classList.remove('text-short', 'text-medium', 'text-long', 'text-very-long');
        
        const text = element.textContent || element.innerText;
        const textLength = text.length;
        
        // Apply classes based on text length
        if (textLength <= 10) {
            element.classList.add('text-short');
        } else if (textLength <= 15) {
            element.classList.add('text-medium');
        } else if (textLength <= 20) {
            element.classList.add('text-long');
        } else {
            element.classList.add('text-very-long');
        }
    }
    
    // Apply smart scaling to all existing summary values on page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const summaryValues = document.querySelectorAll('.summary-value');
            summaryValues.forEach(function(element) {
                applySmartTextScaling(element);
            });
        }, 1500);
    });
    
}); // End waitForChart
</script>

<?php
get_footer();
