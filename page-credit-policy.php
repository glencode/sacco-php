<?php
/**
 * Template Name: Credit Policy
 * Description: Daystar Multi-Purpose Co-op Society Credit Policy Page
 */

get_header(); ?>

<main id="primary" class="site-main page-credit-policy-content credit-policy-bg-img">
    <!-- Animated Background Elements -->
    <div class="floating-elements">
        <div class="floating-icon" style="top: 10%; left: 5%; animation-delay: 0s;">
            <i class="fas fa-coins"></i>
        </div>
        <div class="floating-icon" style="top: 20%; right: 10%; animation-delay: 2s;">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="floating-icon" style="top: 60%; left: 8%; animation-delay: 4s;">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="floating-icon" style="top: 80%; right: 15%; animation-delay: 6s;">
            <i class="fas fa-shield-alt"></i>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="credit-policy-hero py-5 mb-5" style="margin-top: 80px;">
        <style>
        .credit-policy-bg-img {
            position: relative;
            min-height: 100vh;
            background: url('<?php echo get_template_directory_uri(); ?>/assets/images/creditpolicybg.jpeg') no-repeat center center fixed;
            background-size: cover;
        }
        .credit-policy-bg-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.85);
            z-index: 1;
        }
        .page-credit-policy-content > * {
            position: relative;
            z-index: 2;
        }
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .floating-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(96,165,250,0.3);
            animation: floatUpDown 8s ease-in-out infinite;
        }
        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.7; }
        }
        .credit-policy-hero {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(59, 130, 246, 0.85));
            border-radius: 0 0 3rem 3rem;
            position: relative;
            overflow: hidden;
        }
        .credit-policy-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(96,165,250,0.1) 0%, transparent 70%);
            animation: rotateGradient 25s linear infinite;
        }
        @keyframes rotateGradient {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .hero-title {
            color: #fff !important;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            font-weight: 900;
            font-size: 3.5rem;
            background: linear-gradient(45deg, #fff, #60a5fa, #8b5cf6);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientText 4s ease infinite;
        }
        @keyframes gradientText {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .hero-subtitle {
            color: #e2e8f0 !important;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-weight: 500;
            font-size: 1.3rem;
        }
        .breadcrumb-modern {
            background: rgba(30,41,59,0.9);
            border-radius: 2rem;
            padding: 1rem 2rem;
            margin: 2rem auto;
            display: inline-block;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .breadcrumb-modern a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .breadcrumb-modern a:hover {
            color: #fff;
        }
        .breadcrumb-modern .separator {
            margin: 0 1rem;
            color: #94a3b8;
        }
        </style>
        <div class="container text-center">
            <h1 class="hero-title mb-3">Credit Policy</h1>
            <p class="hero-subtitle mb-4">Comprehensive lending guidelines for Daystar Multipurpose Co-operative Society</p>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="container text-center">
        <nav class="breadcrumb-modern" aria-label="breadcrumb">
            <a href="/">Home</a>
            <span class="separator">•</span>
            <span style="color: #fff;">Credit Policy</span>
        </nav>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 mb-4">
                <div class="policy-sidebar">
                    <style>
                    .policy-sidebar {
                        background: rgba(30, 41, 59, 0.95);
                        border-radius: 1.5rem;
                        padding: 2rem;
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(96,165,250,0.2);
                        position: sticky;
                        top: 100px;
                    }
                    .sidebar-title {
                        color: #60a5fa;
                        font-weight: 700;
                        margin-bottom: 1.5rem;
                        text-align: center;
                        font-size: 1.2rem;
                    }
                    .toc-list {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }
                    .toc-list li {
                        margin-bottom: 0.75rem;
                    }
                    .toc-list a {
                        color: #e2e8f0;
                        text-decoration: none;
                        padding: 0.75rem 1rem;
                        border-radius: 0.75rem;
                        display: block;
                        transition: all 0.3s ease;
                        border-left: 3px solid transparent;
                        font-weight: 500;
                    }
                    .toc-list a:hover {
                        background: rgba(96,165,250,0.1);
                        color: #60a5fa;
                        border-left-color: #60a5fa;
                        transform: translateX(5px);
                    }
                    .toc-list a.active {
                        background: rgba(96,165,250,0.2);
                        color: #60a5fa;
                        border-left-color: #60a5fa;
                    }
                    </style>
                    <h3 class="sidebar-title">Table of Contents</h3>
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

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="policy-content">
                    <style>
                    .policy-section {
                        background: rgba(30, 41, 59, 0.95);
                        border-radius: 1.5rem;
                        padding: 2.5rem;
                        margin-bottom: 2rem;
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(96,165,250,0.2);
                        position: relative;
                        overflow: hidden;
                        transition: all 0.3s ease;
                    }
                    .policy-section::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        height: 4px;
                        background: linear-gradient(90deg, #60a5fa, #8b5cf6, #ec4899);
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }
                    .policy-section:hover::before {
                        opacity: 1;
                    }
                    .policy-section:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 20px 40px rgba(96,165,250,0.15);
                        border-color: rgba(96,165,250,0.4);
                    }
                    .section-title {
                        color: #fff;
                        font-weight: 800;
                        font-size: 2rem;
                        margin-bottom: 1.5rem;
                        position: relative;
                    }
                    .section-title::after {
                        content: '';
                        position: absolute;
                        bottom: -8px;
                        left: 0;
                        width: 60px;
                        height: 3px;
                        background: linear-gradient(90deg, #60a5fa, #8b5cf6);
                        border-radius: 2px;
                    }
                    .principle-card, .condition-card, .repayment-card {
                        background: rgba(15, 23, 42, 0.8);
                        border-radius: 1rem;
                        padding: 1.5rem;
                        margin-bottom: 1.5rem;
                        border: 1px solid rgba(96,165,250,0.1);
                        transition: all 0.3s ease;
                    }
                    .principle-card:hover, .condition-card:hover, .repayment-card:hover {
                        background: rgba(15, 23, 42, 0.9);
                        border-color: rgba(96,165,250,0.3);
                        transform: translateY(-2px);
                    }
                    .principle-card h3, .condition-card h3, .repayment-card h3 {
                        color: #60a5fa;
                        font-weight: 700;
                        margin-bottom: 1rem;
                        font-size: 1.3rem;
                    }
                    .policy-list {
                        color: #e2e8f0;
                        padding-left: 1.5rem;
                    }
                    .policy-list li {
                        margin-bottom: 0.75rem;
                        line-height: 1.6;
                    }
                    .policy-list strong {
                        color: #60a5fa;
                        font-weight: 700;
                    }
                    .condition-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                        gap: 1.5rem;
                    }
                    .rates-table {
                        overflow-x: auto;
                        border-radius: 1rem;
                        background: rgba(15, 23, 42, 0.8);
                        border: 1px solid rgba(96,165,250,0.2);
                    }
                    .policy-table {
                        width: 100%;
                        border-collapse: collapse;
                        color: #e2e8f0;
                    }
                    .policy-table th {
                        background: rgba(96,165,250,0.2);
                        color: #fff;
                        padding: 1rem;
                        font-weight: 700;
                        text-align: left;
                        border-bottom: 2px solid rgba(96,165,250,0.3);
                    }
                    .policy-table td {
                        padding: 1rem;
                        border-bottom: 1px solid rgba(96,165,250,0.1);
                        vertical-align: top;
                    }
                    .policy-table tr:hover {
                        background: rgba(96,165,250,0.05);
                    }
                    .procedure-steps {
                        display: flex;
                        flex-direction: column;
                        gap: 1.5rem;
                    }
                    .step {
                        display: flex;
                        align-items: flex-start;
                        gap: 1.5rem;
                        background: rgba(15, 23, 42, 0.8);
                        border-radius: 1rem;
                        padding: 1.5rem;
                        border: 1px solid rgba(96,165,250,0.1);
                        transition: all 0.3s ease;
                        position: relative;
                    }
                    .step:hover {
                        background: rgba(15, 23, 42, 0.9);
                        border-color: rgba(96,165,250,0.3);
                        transform: translateX(10px);
                    }
                    .step-number {
                        background: linear-gradient(135deg, #60a5fa, #3b82f6);
                        color: white;
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 800;
                        font-size: 1.2rem;
                        flex-shrink: 0;
                        box-shadow: 0 4px 15px rgba(96,165,250,0.3);
                    }
                    .step-content h3 {
                        color: #60a5fa;
                        font-weight: 700;
                        margin-bottom: 0.5rem;
                    }
                    .step-content p {
                        color: #e2e8f0;
                        margin: 0;
                        line-height: 1.6;
                    }
                    .loan-types-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                        gap: 1.5rem;
                    }
                    .loan-type-card {
                        background: rgba(15, 23, 42, 0.8);
                        border-radius: 1rem;
                        padding: 1.5rem;
                        border: 1px solid rgba(96,165,250,0.1);
                        transition: all 0.3s ease;
                        position: relative;
                        overflow: hidden;
                    }
                    .loan-type-card::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        height: 3px;
                        background: linear-gradient(90deg, #60a5fa, #8b5cf6);
                        transform: scaleX(0);
                        transition: transform 0.3s ease;
                    }
                    .loan-type-card:hover::before {
                        transform: scaleX(1);
                    }
                    .loan-type-card:hover {
                        background: rgba(15, 23, 42, 0.9);
                        border-color: rgba(96,165,250,0.3);
                        transform: translateY(-5px);
                        box-shadow: 0 10px 25px rgba(96,165,250,0.15);
                    }
                    .loan-type-card h3 {
                        color: #60a5fa;
                        font-weight: 700;
                        margin-bottom: 1rem;
                        font-size: 1.3rem;
                    }
                    .loan-details p {
                        color: #e2e8f0;
                        margin-bottom: 0.75rem;
                        line-height: 1.6;
                    }
                    .loan-details strong {
                        color: #60a5fa;
                        font-weight: 700;
                    }
                    .special-loan-amounts ul {
                        color: #e2e8f0;
                        padding-left: 1.5rem;
                        margin: 1rem 0;
                    }
                    .special-loan-amounts li {
                        margin-bottom: 0.5rem;
                    }
                    .delinquency-info {
                        background: rgba(15, 23, 42, 0.8);
                        border-radius: 1rem;
                        padding: 1.5rem;
                        border: 1px solid rgba(96,165,250,0.1);
                    }
                    .delinquency-info p {
                        color: #e2e8f0;
                        margin-bottom: 1rem;
                        line-height: 1.6;
                    }
                    .delinquency-categories {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 1rem;
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }
                    .delinquency-categories li {
                        background: rgba(96,165,250,0.1);
                        color: #60a5fa;
                        padding: 0.75rem 1rem;
                        border-radius: 0.5rem;
                        text-align: center;
                        font-weight: 600;
                        border: 1px solid rgba(96,165,250,0.2);
                        transition: all 0.3s ease;
                    }
                    .delinquency-categories li:hover {
                        background: rgba(96,165,250,0.2);
                        transform: translateY(-2px);
                    }
                    </style>

                    <!-- General Principles -->
                    <section id="general-principles" class="policy-section">
                        <h2 class="section-title">General Principles of Lending</h2>
                        
                        <div class="principle-card">
                            <h3><i class="fas fa-users me-2"></i>Member Eligibility and Equality</h3>
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
                        <h2 class="section-title">Loan Conditions and Limits</h2>
                        
                        <div class="condition-grid">
                            <div class="condition-card">
                                <h3><i class="fas fa-calculator me-2"></i>Loan Eligibility</h3>
                                <p>A member's loan eligibility is <strong>three times their deposits</strong>, regardless of their employment type (part-time, contract, or permanent).</p>
                            </div>
                            
                            <div class="condition-card">
                                <h3><i class="fas fa-chart-bar me-2"></i>Maximum Limits</h3>
                                <ul class="policy-list">
                                    <li>Development loans: <strong>KSh 2,000,000</strong></li>
                                    <li>Super saver loans: <strong>KSh 3,000,000</strong></li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Interest Rates -->
                    <section id="interest-rates" class="policy-section">
                        <h2 class="section-title">Interest Rates and Fees</h2>
                        
                        <div class="rates-table">
                            <table class="policy-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-tag me-2"></i>Loan Type</th>
                                        <th><i class="fas fa-percentage me-2"></i>Interest Rate</th>
                                        <th><i class="fas fa-money-bill me-2"></i>Additional Fees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Standard Loans</strong></td>
                                        <td>12% per annum (reducing balance)</td>
                                        <td>Processing: KSh 200<br>Sinking Fund: 1%<br>Appraisal: 1%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Special Loans</strong></td>
                                        <td>5% per month (reducing balance)</td>
                                        <td>No additional fees</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Salary Advances</strong></td>
                                        <td>10% for one month<br>5% compounded for longer periods</td>
                                        <td>No additional fees</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Application Procedure -->
                    <section id="application-procedure" class="policy-section">
                        <h2 class="section-title">Procedure for Loan Application and Approval</h2>
                        
                        <div class="procedure-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h3>Application Submission</h3>
                                    <p>A member must completely fill out a loan application form. For Development or Refinance Loans, forms must be submitted by the <strong>30th of each month</strong>.</p>
                                </div>
                            </div>
                            
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h3>Verification Process</h3>
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
                        <h2 class="section-title">Types of Loans Available</h2>
                        
                        <div class="loan-types-grid">
                            <!-- Normal/Development Loans -->
                            <div class="loan-type-card">
                                <h3><i class="fas fa-building me-2"></i>Normal/Development Loans</h3>
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
                                <h3><i class="fas fa-graduation-cap me-2"></i>School Fees Loan</h3>
                                <div class="loan-details">
                                    <p><strong>Purpose:</strong> Solely for payment of school fees; documentary proof may be required</p>
                                    <p><strong>Repayment Period:</strong> 12 months</p>
                                    <p><strong>Interest Rate:</strong> 12% per annum on reducing balance</p>
                                    <p><strong>Requirements:</strong> Must be fully guaranteed and supported by a payslip</p>
                                </div>
                            </div>
                            
                            <!-- Emergency Loan -->
                            <div class="loan-type-card">
                                <h3><i class="fas fa-ambulance me-2"></i>Emergency Loan</h3>
                                <div class="loan-details">
                                    <p><strong>Purpose:</strong> For unforeseen circumstances like hospitalization, funerals, or court fines, which must be justified with documentary evidence</p>
                                    <p><strong>Maximum Loan:</strong> KSh 100,000, but may vary in needier cases</p>
                                    <p><strong>Repayment Period:</strong> 12 months</p>
                                    <p><strong>Requirements:</strong> Member must not have an outstanding emergency loan</p>
                                </div>
                            </div>
                            
                            <!-- Special Loan -->
                            <div class="loan-type-card">
                                <h3><i class="fas fa-star me-2"></i>Special Loan</h3>
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
                                <h3><i class="fas fa-gem me-2"></i>Super Saver Loans</h3>
                                <div class="loan-details">
                                    <p><strong>Eligibility:</strong> For members with deposits exceeding KSh 1,000,000</p>
                                    <p><strong>Maximum Loan:</strong> KSh 3,000,000</p>
                                    <p><strong>Repayment Period:</strong> 48 months for loans over KSh 1,000,000</p>
                                    <p><strong>Interest Rate:</strong> 12% per annum on reducing balance</p>
                                </div>
                            </div>
                            
                            <!-- Salary Advance -->
                            <div class="loan-type-card">
                                <h3><i class="fas fa-money-check-alt me-2"></i>Salary Advance</h3>
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
                        <h2 class="section-title">Loan Repayments</h2>
                        
                        <div class="condition-grid">
                            <div class="repayment-card">
                                <h3><i class="fas fa-calendar-check me-2"></i>Repayment Schedule</h3>
                                <p>Deductions for loan repayments begin no later than the month following the loan's disbursement.</p>
                            </div>
                            
                            <div class="repayment-card">
                                <h3><i class="fas fa-fast-forward me-2"></i>Early Repayment</h3>
                                <p>A member may repay their loan in whole or in part prior to its maturity date.</p>
                            </div>
                            
                            <div class="repayment-card">
                                <h3><i class="fas fa-credit-card me-2"></i>Payment Methods</h3>
                                <p>Repayments can be made from other legal sources besides salary by depositing the funds into the society's bank account or via Paybill and providing proof of payment.</p>
                            </div>
                            
                            <div class="repayment-card">
                                <h3><i class="fas fa-clock me-2"></i>Maximum Periods</h3>
                                <ul class="policy-list">
                                    <li>Part-Timers and Permanent staff: <strong>36 months</strong></li>
                                    <li>Others: <strong>24 months</strong></li>
                                    <li>Supersavers: <strong>48 months</strong></li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Delinquency -->
                    <section id="delinquency" class="policy-section">
                        <h2 class="section-title">Loan Delinquency and Recovery</h2>
                        
                        <div class="delinquency-info">
                            <p>The society manager prepares a monthly list of delinquent loans categorized by age:</p>
                            <ul class="delinquency-categories">
                                <li><i class="fas fa-exclamation-triangle me-2"></i>0-30 days overdue</li>
                                <li><i class="fas fa-exclamation-circle me-2"></i>31-60 days overdue</li>
                                <li><i class="fas fa-times-circle me-2"></i>61-90 days overdue</li>
                                <li><i class="fas fa-ban me-2"></i>Over 90 days overdue</li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <section class="quick-actions-section py-5">
        <style>
        .quick-actions-section {
            background: rgba(30, 41, 59, 0.95);
            border-radius: 2rem 2rem 0 0;
            margin-top: 3rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(96,165,250,0.2);
            border-bottom: none;
        }
        .actions-title {
            color: #fff;
            font-weight: 800;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        .actions-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #60a5fa, #8b5cf6);
            border-radius: 2px;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .action-card {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            text-decoration: none;
            color: #e2e8f0;
            border: 1px solid rgba(96,165,250,0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(96,165,250,0.1), transparent);
            transition: left 0.6s ease;
        }
        .action-card:hover::before {
            left: 100%;
        }
        .action-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(96,165,250,0.2);
            border-color: rgba(96,165,250,0.4);
            color: #fff;
            text-decoration: none;
        }
        .action-card i {
            font-size: 3rem;
            color: #60a5fa;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .action-card:hover i {
            transform: scale(1.1);
            color: #8b5cf6;
        }
        .action-card h3 {
            color: #60a5fa;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }
        .action-card:hover h3 {
            color: #fff;
        }
        .action-card p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        </style>
        <div class="container">
            <h2 class="actions-title">Quick Actions</h2>
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
    </section>

    <script>
    // Smooth scrolling for table of contents
    document.addEventListener('DOMContentLoaded', function() {
        const tocLinks = document.querySelectorAll('.toc-list a');
        const sections = document.querySelectorAll('.policy-section');
        
        // Smooth scroll for TOC links
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Update active TOC link on scroll
        function updateActiveTocLink() {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        }
        
        window.addEventListener('scroll', updateActiveTocLink);
        updateActiveTocLink(); // Initial call
    });
    </script>
</main>

<?php get_footer(); ?>