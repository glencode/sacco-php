<?php
/**
 * Template Name: Credit Policy
 * Description: Daystar Multi-Purpose Co-op Society Credit Policy Page
 */

get_header(); ?>

<div class="credit-policy-page">
    <!-- Hero Section -->
    <section class="credit-policy-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-content">
                        <h1 class="hero-title">Credit Policy</h1>
                        <p class="hero-subtitle">Daystar Multi-Purpose Co-operative Society Ltd.</p>
                        <div class="breadcrumb-nav">
                            <a href="<?php echo home_url(); ?>">Home</a>
                            <span class="separator">/</span>
                            <span class="current">Credit Policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Policy Content -->
    <section class="policy-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Table of Contents -->
                    <div class="policy-toc">
                        <h3>Table of Contents</h3>
                        <ul class="toc-list">
                            <li><a href="#general-principles">General Principles</a></li>
                            <li><a href="#member-eligibility">Member Eligibility</a></li>
                            <li><a href="#loan-conditions">Loan Conditions</a></li>
                            <li><a href="#interest-rates">Interest Rates & Fees</a></li>
                            <li><a href="#application-procedure">Application Procedure</a></li>
                            <li><a href="#loan-types">Types of Loans</a></li>
                            <li><a href="#repayment">Loan Repayments</a></li>
                            <li><a href="#delinquency">Delinquency & Recovery</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-9">
                    <div class="policy-sections">
                        <!-- General Principles -->
                        <section id="general-principles" class="policy-section">
                            <h2>General Principles of Lending</h2>
                            
                            <div class="principle-card">
                                <h3>Member Eligibility and Equality</h3>
                                <ul class="policy-list">
                                    <li>All members are to be treated equally regarding loans, subject to the policy's rules.</li>
                                    <li>To be eligible for a loan, an individual must have been a society member for at least <strong>six months</strong>.</li>
                                    <li>The member must have made consistent contributions totaling not less than <strong>KSh 12,000</strong> over those six months.</li>
                                    <li>A minimum share capital of <strong>KSh 5,000</strong>, or 250 shares worth KSh 200 each, is required. These shares are only transferable if one ceases to be a member.</li>
                                </ul>
                            </div>
                        </section>

                        <!-- Loan Conditions -->
                        <section id="loan-conditions" class="policy-section">
                            <h2>Loan Conditions and Limits</h2>
                            
                            <div class="condition-grid">
                                <div class="condition-card">
                                    <h3>Loan Eligibility</h3>
                                    <p>A member's loan eligibility is <strong>three times their deposits</strong>, regardless of their employment type (part-time, contract, or permanent).</p>
                                </div>
                                
                                <div class="condition-card">
                                    <h3>Maximum Limits</h3>
                                    <ul>
                                        <li>Development loans: <strong>KSh 2,000,000</strong></li>
                                        <li>Super saver loans: <strong>KSh 3,000,000</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- Interest Rates -->
                        <section id="interest-rates" class="policy-section">
                            <h2>Interest Rates and Fees</h2>
                            
                            <div class="rates-table">
                                <table class="policy-table">
                                    <thead>
                                        <tr>
                                            <th>Loan Type</th>
                                            <th>Interest Rate</th>
                                            <th>Additional Fees</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Standard Loans</td>
                                            <td>12% per annum (reducing balance)</td>
                                            <td>Processing: KSh 200<br>Sinking Fund: 1%<br>Appraisal: 1%</td>
                                        </tr>
                                        <tr>
                                            <td>Special Loans</td>
                                            <td>5% per month (reducing balance)</td>
                                            <td>No additional fees</td>
                                        </tr>
                                        <tr>
                                            <td>Salary Advances</td>
                                            <td>10% for one month<br>5% compounded for longer periods</td>
                                            <td>No additional fees</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Repayment Periods -->
                        <section id="repayment-periods" class="policy-section">
                            <h2>Repayment Periods and Income Calculation</h2>
                            
                            <div class="repayment-info">
                                <div class="repayment-card">
                                    <h3>Maximum Repayment Periods</h3>
                                    <ul>
                                        <li>Part-Timers and Permanent staff: <strong>36 months</strong></li>
                                        <li>Others: <strong>24 months</strong></li>
                                        <li>Supersavers: <strong>48 months</strong></li>
                                    </ul>
                                </div>
                                
                                <div class="repayment-card">
                                    <h3>Income Calculation</h3>
                                    <ul>
                                        <li>Lecturers: Constant amount of <strong>KSh 10,000</strong> added for part-time teaching</li>
                                        <li>Permanent staff: <strong>50%</strong> of net after-tax Responsibility, Telephone, and H.O.D allowances considered</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- Application Procedure -->
                        <section id="application-procedure" class="policy-section">
                            <h2>Procedure for Loan Application and Approval</h2>
                            
                            <div class="procedure-steps">
                                <div class="step">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h3>Application</h3>
                                        <p>A member must completely fill out a loan application form. For Development or Refinance Loans, forms must be submitted by the <strong>30th of each month</strong>.</p>
                                    </div>
                                </div>
                                
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h3>Verification</h3>
                                        <p>A loan officer verifies that the form is complete; incomplete forms are returned. Accepted forms are registered, and the applicant receives a waiting number.</p>
                                    </div>
                                </div>
                                
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h3>Committee Review</h3>
                                        <p>The loan officer forwards the applications to the credit committee. The committee considers the applicant's character, capacity to repay, capital, and collateral.</p>
                                    </div>
                                </div>
                                
                                <div class="step">
                                    <div class="step-number">4</div>
                                    <div class="step-content">
                                        <h3>Recommendation and Authorization</h3>
                                        <p>The credit committee recommends successful applicants to the Central Management Committee (CMC) for approval. The CMC authorizes the treasurer to facilitate payment.</p>
                                    </div>
                                </div>
                                
                                <div class="step">
                                    <div class="step-number">5</div>
                                    <div class="step-content">
                                        <h3>Disbursement</h3>
                                        <p>Before receiving the funds, the loanee must personally sign the deduction form.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Loan Types -->
                        <section id="loan-types" class="policy-section">
                            <h2>Types of Loans Available</h2>
                            
                            <div class="loan-types-grid">
                                <!-- Normal/Development Loans -->
                                <div class="loan-type-card">
                                    <h3>Normal/Development Loans</h3>
                                    <div class="loan-details">
                                        <p><strong>Purpose:</strong> For major projects like building, buying a car, or starting a business.</p>
                                        <p><strong>Maximum Loan:</strong> KSh 2,000,000</p>
                                        <p><strong>Repayment Period:</strong> 36 months</p>
                                        <p><strong>Interest Rate:</strong> 12% per annum (1% per month) on a reducing balance</p>
                                        <p><strong>Requirements:</strong> Must be fully guaranteed and supported by the member's payslip</p>
                                    </div>
                                </div>
                                
                                <!-- School Fees Loan -->
                                <div class="loan-type-card">
                                    <h3>School Fees Loan</h3>
                                    <div class="loan-details">
                                        <p><strong>Purpose:</strong> Solely for payment of school fees; documentary proof may be required</p>
                                        <p><strong>Repayment Period:</strong> 12 months</p>
                                        <p><strong>Requirements:</strong> Must be fully guaranteed and supported by a payslip</p>
                                    </div>
                                </div>
                                
                                <!-- Instant Loan -->
                                <div class="loan-type-card">
                                    <h3>Instant Loan</h3>
                                    <div class="loan-details">
                                        <p><strong>Purpose:</strong> Given priority processing within 24 hours</p>
                                        <p><strong>Maximum Loan:</strong> KSh 50,000</p>
                                        <p><strong>Charges:</strong> 10% instant charge on the loan value, plus 1% per month reducing balance interest</p>
                                        <p><strong>Repayment Period:</strong> 6 months</p>
                                    </div>
                                </div>
                                
                                <!-- Refinance Loan -->
                                <div class="loan-type-card">
                                    <h3>Refinance Loan</h3>
                                    <div class="loan-details">
                                        <p><strong>Purpose:</strong> To consolidate an existing development loan with new funds</p>
                                        <p><strong>Charges:</strong> 10% refinance charge on the new loan, plus normal 12% p.a. interest</p>
                                        <p><strong>Requirements:</strong> Member must have paid the existing loan for at least 6 months</p>
                                        <p><strong>Repayment Period:</strong> Up to 36 months (or 48 for Super Savers)</p>
                                    </div>
                                </div>
                                
                                <!-- Emergency Loan -->
                                <div class="loan-type-card">
                                    <h3>Emergency Loan</h3>
                                    <div class="loan-details">
                                        <p><strong>Purpose:</strong> For unforeseen circumstances like hospitalization, funerals, or court fines, which must be justified with documentary evidence</p>
                                        <p><strong>Maximum Loan:</strong> KSh 100,000, but may vary in needier cases</p>
                                        <p><strong>Repayment Period:</strong> 12 months</p>
                                        <p><strong>Requirements:</strong> Member must not have an outstanding emergency loan</p>
                                    </div>
                                </div>
                                
                                <!-- Special Loan -->
                                <div class="loan-type-card">
                                    <h3>Special Loan</h3>
                                    <div class="loan-details">
                                        <p><strong>Criteria:</strong> Granted based on a member's character and history, without consideration of a payslip</p>
                                        <p><strong>Interest Rate:</strong> 5% per month on a reducing balance</p>
                                        <p><strong>Requirements:</strong> Requires post-dated cheques as a guarantee instead of shares</p>
                                        <div class="special-loan-amounts">
                                            <ul>
                                                <li>Up to KSh 100,000: 4 months repayment</li>
                                                <li>KSh 100,000 to KSh 159,000: 5 months repayment</li>
                                                <li>KSh 160,000 to KSh 200,000: 6 months repayment</li>
                                            </ul>
                                        </div>
                                        <p><strong>Penalties:</strong> KSh 1,000 charge for deferring a cheque and KSh 3,000 for bounced cheques</p>
                                    </div>
                                </div>
                                
                                <!-- Super Saver Loans -->
                                <div class="loan-type-card">
                                    <h3>Super Saver Loans</h3>
                                    <div class="loan-details">
                                        <p><strong>Eligibility:</strong> For members with deposits exceeding KSh 1,000,000</p>
                                        <p><strong>Maximum Loan:</strong> KSh 3,000,000</p>
                                        <p><strong>Repayment Period:</strong> 48 months for loans over KSh 1,000,000</p>
                                    </div>
                                </div>
                                
                                <!-- Salary Advance -->
                                <div class="loan-type-card">
                                    <h3>Salary Advance</h3>
                                    <div class="loan-details">
                                        <p><strong>Eligibility:</strong> Given to members and non-members. Non-members are charged 12.5% for one month</p>
                                        <p><strong>Repayment Period:</strong> Maximum of three months</p>
                                        <p><strong>Charges:</strong> 10% one-off charge for the first month, with 5% compounded for subsequent months</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Loan Repayments -->
                        <section id="repayment" class="policy-section">
                            <h2>Loan Repayments</h2>
                            
                            <div class="repayment-details">
                                <div class="repayment-card">
                                    <h3>Repayment Schedule</h3>
                                    <p>Deductions for loan repayments begin no later than the month following the loan's disbursement.</p>
                                </div>
                                
                                <div class="repayment-card">
                                    <h3>Early Repayment</h3>
                                    <p>A member may repay their loan in whole or in part prior to its maturity date.</p>
                                </div>
                                
                                <div class="repayment-card">
                                    <h3>Payment Methods</h3>
                                    <p>Repayments can be made from other legal sources besides salary by depositing the funds into the society's bank account or via Paybill and providing proof of payment.</p>
                                </div>
                            </div>
                        </section>

                        <!-- Delinquency -->
                        <section id="delinquency" class="policy-section">
                            <h2>Loan Delinquency and Recovery</h2>
                            
                            <div class="delinquency-info">
                                <p>The society manager prepares a monthly list of delinquent loans categorized by age:</p>
                                <ul class="delinquency-categories">
                                    <li>0-30 days overdue</li>
                                    <li>31-60 days overdue</li>
                                    <li>61-90 days overdue</li>
                                    <li>Over 90 days overdue</li>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Quick Actions</h2>
                    <div class="actions-grid">
                        <a href="<?php echo home_url('/loan-application'); ?>" class="action-card">
                            <i class="fas fa-file-alt"></i>
                            <h3>Apply for Loan</h3>
                            <p>Start your loan application process</p>
                        </a>
                        
                        <a href="<?php echo home_url('/loan-calculator'); ?>" class="action-card">
                            <i class="fas fa-calculator"></i>
                            <h3>Loan Calculator</h3>
                            <p>Calculate your loan eligibility</p>
                        </a>
                        
                        <a href="<?php echo home_url('/contact-us'); ?>" class="action-card">
                            <i class="fas fa-phone"></i>
                            <h3>Contact Us</h3>
                            <p>Get help with your loan queries</p>
                        </a>
                        
                        <a href="<?php echo home_url('/member-dashboard'); ?>" class="action-card">
                            <i class="fas fa-user"></i>
                            <h3>Member Portal</h3>
                            <p>Access your account information</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>