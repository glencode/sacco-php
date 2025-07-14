<?php
/**
 * The template for displaying the Terms and Conditions page for Daystar Multi-Purpose Co-operative Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<style>
/* Enhanced CSS Variables - Matching Site Design System */
:root {
    /* Primary Oceanic Colors */
    --primary-blue: #006994;
    --primary-blue-light: rgba(0, 105, 148, 0.8);
    --primary-blue-dark: #082b4e;
    --accent-teal: #20B2AA;
    --accent-coral: #FF7F7F;
    --accent-seafoam: #40E0D0;
    --deep-ocean: #003366;
    --ocean-mist: #B0E0E6;
    --accent-gold: #FFD700;
    --accent-emerald: #50C878;
    
    /* Enhanced Glassmorphism Colors */
    --glass-white: rgba(255, 255, 255, 0.12);
    --glass-white-strong: rgba(255, 255, 255, 0.25);
    --glass-ocean: rgba(0, 105, 148, 0.15);
    --glass-ocean-strong: rgba(0, 105, 148, 0.25);
    --glass-teal: rgba(32, 178, 170, 0.12);
    --glass-dark: rgba(30, 41, 59, 0.85);
    --glass-light: rgba(248, 250, 252, 0.95);
    
    /* Enhanced Background Gradients */
    --bg-primary: linear-gradient(135deg, #006994 0%, #20B2AA 50%, #40E0D0 100%);
    --bg-secondary: linear-gradient(135deg, #40E0D0 0%, #006994 50%, #003366 100%);
    --bg-hero: linear-gradient(135deg, rgba(0, 105, 148, 0.95) 0%, rgba(32, 178, 170, 0.9) 50%, rgba(64, 224, 208, 0.85) 100%);
    --bg-ocean-depth: linear-gradient(135deg, #003366 0%, #006994 25%, #20B2AA 75%, #40E0D0 100%);
    --bg-card-gradient: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    
    /* Enhanced Shadows */
    --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-strong: 0 15px 50px rgba(0, 0, 0, 0.15);
    --shadow-glass: 0 8px 32px rgba(0, 0, 0, 0.1);
    --shadow-glow: 0 0 30px rgba(32, 178, 170, 0.3);
    --shadow-hover: 0 20px 60px rgba(0, 105, 148, 0.2);
    
    /* Enhanced Typography */
    --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    --font-display: 'Playfair Display', Georgia, serif;
    
    /* Enhanced Transitions */
    --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-medium: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-bounce: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Base Styles */
.terms-conditions-page {
    font-family: var(--font-primary);
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/oceanbackground.jpeg') no-repeat center center fixed;
    background-size: cover;
}

/* Light Overlay for Text Readability */
.terms-conditions-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(46, 45, 45, 0.85);
    backdrop-filter: blur(2px);
    pointer-events: none;
    z-index: 1;
}

/* Ensure content is above overlay */
.terms-conditions-page > * {
    position: relative;
    z-index: 2;
}

/* Enhanced Page Header */
.page-header {
    background: var(--bg-hero);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
    margin-top: 80px;
    text-align: center;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
    pointer-events: none;
    animation: headerGlow 15s ease-in-out infinite;
}

@keyframes headerGlow {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
}

.page-title {
    font-family: var(--font-display);
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    background: rgba(0, 0, 0, 0.3);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: inline-block;
    position: relative;
    z-index: 2;
}

.page-header .lead {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 2rem;
    font-weight: 500;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
    background: rgba(0, 0, 0, 0.3);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 2;
}

/* Enhanced Breadcrumb */
.breadcrumb {
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 12px 24px;
    margin-bottom: 0;
    position: relative;
    z-index: 2;
    justify-content: center;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition-fast);
}

.breadcrumb-item a:hover {
    color: var(--accent-gold);
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

/* Enhanced Section Styling */
.section {
    padding: 80px 0;
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    margin: 2rem 0;
    border-radius: 24px;
    box-shadow: var(--shadow-glass);
}

.section-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--primary-blue-dark);
    margin-bottom: 1.5rem;
    position: relative;
    text-align: center;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, var(--accent-teal), var(--accent-seafoam));
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(32, 178, 170, 0.3);
}

.section-subtitle {
    font-size: 1.25rem;
    color: var(--primary-blue);
    margin-bottom: 3rem;
    font-weight: 400;
    text-align: center;
}

/* Content Styling */
.terms-content {
    background: rgba(255, 255, 255, 0.9);
    padding: 3rem;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 105, 148, 0.1);
    box-shadow: var(--shadow-soft);
    margin-bottom: 2rem;
}

.terms-content h3 {
    color: var(--primary-blue-dark);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    border-bottom: 2px solid var(--accent-teal);
    padding-bottom: 0.5rem;
}

.terms-content h4 {
    color: var(--primary-blue);
    font-weight: 600;
    margin-bottom: 1rem;
    margin-top: 2rem;
    font-size: 1.25rem;
}

.terms-content p {
    color: #374151;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.terms-content ul, .terms-content ol {
    color: #374151;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.terms-content li {
    margin-bottom: 0.5rem;
}

.terms-content strong {
    color: var(--primary-blue-dark);
    font-weight: 600;
}

/* Highlight Box */
.highlight-box {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    padding: 2rem;
    border-radius: 16px;
    margin: 2rem 0;
    box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.highlight-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: var(--transition-slow);
}

.highlight-box:hover::before {
    left: 100%;
}

.highlight-box h4 {
    color: var(--primary-blue-dark);
    margin-bottom: 1rem;
    font-weight: 700;
}

/* Warning Box */
.warning-box {
    background: rgba(255, 127, 127, 0.1);
    border: 2px solid var(--accent-coral);
    border-radius: 16px;
    padding: 2rem;
    margin: 2rem 0;
}

.warning-box h4 {
    color: #dc2626;
    margin-bottom: 1rem;
    font-weight: 700;
}

.warning-box p {
    color: #374151;
    margin-bottom: 0;
}

/* Contact Info Box */
.contact-info-box {
    background: rgba(0, 105, 148, 0.1);
    border: 2px solid var(--accent-teal);
    border-radius: 16px;
    padding: 2rem;
    margin: 2rem 0;
    text-align: center;
}

.contact-info-box h4 {
    color: var(--primary-blue-dark);
    margin-bottom: 1rem;
    font-weight: 700;
}

.contact-info-box p {
    margin-bottom: 0.5rem;
}

.contact-info-box .contact-detail {
    color: var(--primary-blue);
    font-weight: 600;
}

/* Last Updated Badge */
.last-updated {
    background: rgba(32, 178, 170, 0.1);
    border: 1px solid var(--accent-teal);
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    display: inline-block;
    margin-bottom: 2rem;
    color: var(--primary-blue-dark);
    font-weight: 600;
    font-size: 0.9rem;
}

/* Table of Contents */
.table-of-contents {
    background: rgba(0, 105, 148, 0.05);
    border: 1px solid var(--accent-teal);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 3rem;
}

.table-of-contents h4 {
    color: var(--primary-blue-dark);
    margin-bottom: 1.5rem;
    font-weight: 700;
}

.table-of-contents ul {
    list-style: none;
    padding-left: 0;
}

.table-of-contents li {
    margin-bottom: 0.5rem;
}

.table-of-contents a {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition-fast);
}

.table-of-contents a:hover {
    color: var(--accent-teal);
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 80px 0 40px;
    }
    
    .section {
        padding: 60px 0;
        margin: 1rem 0;
    }
    
    .terms-content {
        padding: 2rem 1.5rem;
    }
}
</style>

<main id="primary" class="site-main terms-conditions-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h1 class="page-title">Terms & Conditions</h1>
                    <p class="lead">Membership terms, conditions, and policies governing Daystar Multi-Purpose Co-operative Society Ltd.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms and Conditions Content -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="last-updated">
                        <i class="fas fa-calendar-alt"></i> Last Updated: <?php echo date('F j, Y'); ?>
                    </div>

                    <!-- Table of Contents -->
                    <div class="table-of-contents">
                        <h4><i class="fas fa-list"></i> Table of Contents</h4>
                        <ul>
                            <li><a href="#acceptance">1. Acceptance of Terms</a></li>
                            <li><a href="#membership">2. Membership Requirements</a></li>
                            <li><a href="#rights-obligations">3. Member Rights and Obligations</a></li>
                            <li><a href="#financial-services">4. Financial Services</a></li>
                            <li><a href="#loan-terms">5. Loan Terms and Conditions</a></li>
                            <li><a href="#savings-deposits">6. Savings and Deposits</a></li>
                            <li><a href="#fees-charges">7. Fees and Charges</a></li>
                            <li><a href="#governance">8. Governance and Decision Making</a></li>
                            <li><a href="#termination">9. Membership Termination</a></li>
                            <li><a href="#dispute-resolution">10. Dispute Resolution</a></li>
                            <li><a href="#amendments">11. Amendments</a></li>
                            <li><a href="#governing-law">12. Governing Law</a></li>
                        </ul>
                    </div>
                    
                    <div class="terms-content">
                        <h3 id="acceptance">1. Acceptance of Terms</h3>
                        <p>By applying for membership in Daystar Multi-Purpose Co-operative Society Ltd. ("the Society"), you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions, along with:</p>
                        <ul>
                            <li>The Society's Constitution and By-laws</li>
                            <li>Credit Policy and lending guidelines</li>
                            <li>Privacy Policy and data protection measures</li>
                            <li>All applicable policies and procedures</li>
                            <li>Kenyan cooperative laws and regulations</li>
                        </ul>

                        <div class="highlight-box">
                            <h4><i class="fas fa-university"></i> Daystar University Exclusive</h4>
                            <p><strong>Important:</strong> Membership in this cooperative society is exclusively reserved for individuals with a direct connection to Daystar University. This includes current and former employees, faculty members, and their immediate family members.</p>
                        </div>

                        <h3 id="membership">2. Membership Requirements</h3>
                        
                        <h4>2.1 Eligibility Criteria</h4>
                        <p>To become a member, you must:</p>
                        <ul>
                            <li><strong>Age Requirement:</strong> Be at least 18 years old and of sound mind</li>
                            <li><strong>Daystar Connection:</strong> Be a current or former employee, faculty member, or have official association with Daystar University</li>
                            <li><strong>Documentation:</strong> Provide valid identification and proof of Daystar University connection</li>
                            <li><strong>Financial Commitment:</strong> Make the required initial investments and ongoing contributions</li>
                            <li><strong>Character:</strong> Demonstrate good character and financial responsibility</li>
                        </ul>

                        <h4>2.2 Initial Financial Requirements</h4>
                        <ul>
                            <li><strong>Registration Fee:</strong> KSh 1,000 (one-time, non-refundable)</li>
                            <li><strong>Share Capital:</strong> Minimum KSh 5,000 (250 shares at KSh 20 each)</li>
                            <li><strong>Monthly Contributions:</strong> Minimum KSh 2,000 per month</li>
                            <li><strong>Loan Eligibility:</strong> 6 months of consistent contributions required</li>
                        </ul>

                        <h4>2.3 Application Process</h4>
                        <ol>
                            <li>Complete membership application form</li>
                            <li>Submit required documentation and photographs</li>
                            <li>Pay registration fee and initial share capital</li>
                            <li>Attend new member orientation (if required)</li>
                            <li>Receive membership certificate and member number</li>
                        </ol>

                        <h3 id="rights-obligations">3. Member Rights and Obligations</h3>
                        
                        <h4>3.1 Member Rights</h4>
                        <p>As a member, you have the right to:</p>
                        <ul>
                            <li><strong>Democratic Participation:</strong> Vote in elections and on important Society matters</li>
                            <li><strong>Financial Services:</strong> Access loans, savings accounts, and other financial products</li>
                            <li><strong>Information Access:</strong> Receive annual reports, financial statements, and meeting minutes</li>
                            <li><strong>Dividend Participation:</strong> Share in annual profits through dividends</li>
                            <li><strong>Fair Treatment:</strong> Equal treatment regardless of the size of your investment</li>
                            <li><strong>Grievance Procedures:</strong> Access to complaint and dispute resolution mechanisms</li>
                        </ul>

                        <h4>3.2 Member Obligations</h4>
                        <p>As a member, you must:</p>
                        <ul>
                            <li><strong>Financial Commitments:</strong> Make timely monthly contributions and loan repayments</li>
                            <li><strong>Accurate Information:</strong> Provide truthful and current information</li>
                            <li><strong>Compliance:</strong> Follow all Society policies, procedures, and decisions</li>
                            <li><strong>Confidentiality:</strong> Respect the privacy of other members and Society information</li>
                            <li><strong>Participation:</strong> Attend Annual General Meetings when possible</li>
                            <li><strong>Notification:</strong> Inform the Society of changes in personal circumstances</li>
                        </ul>

                        <h3 id="financial-services">4. Financial Services</h3>
                        
                        <h4>4.1 Available Services</h4>
                        <p>The Society offers the following financial services to members:</p>
                        <ul>
                            <li><strong>Monthly Contributions:</strong> Regular member contributions with competitive interest rates</li>
                            <li><strong>Share Capital:</strong> Ownership shares that earn annual dividends</li>
                            <li><strong>Development Loans:</strong> Long-term financing for major projects</li>
                            <li><strong>School Fees Loans:</strong> Education financing for members' children</li>
                            <li><strong>Emergency Loans:</strong> Quick access to funds for urgent needs</li>
                            <li><strong>Special Loans:</strong> Customized financing solutions</li>
                            <li><strong>Super Saver Loans:</strong> Premium loans for high-contribution members</li>
                            <li><strong>Salary Advance:</strong> Short-term cash advances</li>
                        </ul>

                        <h4>4.2 Service Standards</h4>
                        <p>We commit to:</p>
                        <ul>
                            <li>Process loan applications within 5-10 working days</li>
                            <li>Provide transparent pricing and terms</li>
                            <li>Maintain accurate and timely account records</li>
                            <li>Offer competitive interest rates and fees</li>
                            <li>Ensure confidential handling of all transactions</li>
                        </ul>

                        <h3 id="loan-terms">5. Loan Terms and Conditions</h3>
                        
                        <h4>5.1 General Loan Requirements</h4>
                        <ul>
                            <li><strong>Membership Duration:</strong> Minimum 6 months with consistent contributions</li>
                            <li><strong>Contribution History:</strong> Total contributions of at least KSh 12,000</li>
                            <li><strong>Share Capital:</strong> Minimum KSh 5,000 in share capital</li>
                            <li><strong>Guarantors:</strong> Required for loans above certain thresholds</li>
                            <li><strong>Collateral:</strong> May be required for large loans</li>
                        </ul>

                        <h4>5.2 Interest Rates and Fees</h4>
                        <ul>
                            <li><strong>Development Loans:</strong> 12% per annum on reducing balance</li>
                            <li><strong>School Fees Loans:</strong> 12% per annum on reducing balance</li>
                            <li><strong>Emergency Loans:</strong> 12% per annum on reducing balance</li>
                            <li><strong>Special Loans:</strong> 5% per month on reducing balance</li>
                            <li><strong>Super Saver Loans:</strong> Preferential rates based on deposits</li>
                            <li><strong>Salary Advance:</strong> 10% one-time fee for members</li>
                        </ul>

                        <h4>5.3 Repayment Terms</h4>
                        <ul>
                            <li><strong>Payment Method:</strong> Monthly installments via payroll deduction or direct payment</li>
                            <li><strong>Grace Period:</strong> 7 days after due date before late fees apply</li>
                            <li><strong>Early Repayment:</strong> Allowed without penalty</li>
                            <li><strong>Default:</strong> Failure to pay for 3 consecutive months constitutes default</li>
                        </ul>

                        <div class="warning-box">
                            <h4><i class="fas fa-exclamation-triangle"></i> Important Loan Conditions</h4>
                            <p><strong>Loan Guarantee:</strong> By accepting a loan, you authorize the Society to deduct repayments from your salary through Daystar University's payroll system. You also agree that your shares and deposits may be used to offset outstanding loan balances in case of default.</p>
                        </div>

                        <h3 id="savings-deposits">6. Savings and Deposits</h3>
                        
                        <h4>6.1 Monthly Contributions</h4>
                        <ul>
                            <li><strong>Minimum Amount:</strong> KSh 2,000 per month</li>
                            <li><strong>Payment Method:</strong> Payroll deduction or direct deposit</li>
                            <li><strong>Interest Rate:</strong> Competitive rates determined annually</li>
                            <li><strong>Withdrawal:</strong> Available with appropriate notice</li>
                        </ul>

                        <h4>6.2 Share Capital</h4>
                        <ul>
                            <li><strong>Share Value:</strong> KSh 20 per share</li>
                            <li><strong>Minimum Holding:</strong> 250 shares (KSh 5,000)</li>
                            <li><strong>Dividends:</strong> Annual dividends based on Society performance</li>
                            <li><strong>Transferability:</strong> Shares are non-transferable to non-members</li>
                        </ul>

                        <h4>6.3 Withdrawal Procedures</h4>
                        <ul>
                            <li><strong>Notice Period:</strong> 30 days written notice for large withdrawals</li>
                            <li><strong>Processing Time:</strong> 5-7 working days for approved withdrawals</li>
                            <li><strong>Restrictions:</strong> Withdrawals may be limited if you have outstanding loans</li>
                            <li><strong>Emergency Access:</strong> Emergency withdrawals available with proper documentation</li>
                        </ul>

                        <h3 id="fees-charges">7. Fees and Charges</h3>
                        
                        <h4>7.1 Membership Fees</h4>
                        <ul>
                            <li><strong>Registration Fee:</strong> KSh 1,000 (one-time)</li>
                            <li><strong>Annual Membership Fee:</strong> KSh 500</li>
                            <li><strong>Statement Fees:</strong> KSh 100 per additional statement copy</li>
                        </ul>

                        <h4>7.2 Transaction Fees</h4>
                        <ul>
                            <li><strong>Loan Processing:</strong> 1-2% of loan amount</li>
                            <li><strong>Late Payment:</strong> 5% of overdue amount per month</li>
                            <li><strong>Bounced Cheque:</strong> KSh 1,000 per occurrence</li>
                            <li><strong>Account Closure:</strong> KSh 500 processing fee</li>
                        </ul>

                        <h4>7.3 Fee Changes</h4>
                        <p>The Society reserves the right to modify fees with 30 days written notice to members. Fee changes must be approved by the Board of Directors and communicated through official channels.</p>

                        <h3 id="governance">8. Governance and Decision Making</h3>
                        
                        <h4>8.1 Democratic Principles</h4>
                        <p>The Society operates on democratic principles where:</p>
                        <ul>
                            <li>Each member has one vote regardless of share capital</li>
                            <li>Major decisions are made at Annual General Meetings</li>
                            <li>Members elect the Board of Directors and Supervisory Committee</li>
                            <li>Financial reports are presented annually to members</li>
                        </ul>

                        <h4>8.2 Annual General Meeting</h4>
                        <ul>
                            <li><strong>Frequency:</strong> Held annually within 6 months of financial year end</li>
                            <li><strong>Notice:</strong> 21 days written notice to all members</li>
                            <li><strong>Quorum:</strong> As specified in the Society's Constitution</li>
                            <li><strong>Voting:</strong> In person or by authorized proxy</li>
                        </ul>

                        <h4>8.3 Board of Directors</h4>
                        <ul>
                            <li><strong>Composition:</strong> Elected members serving 3-year terms</li>
                            <li><strong>Responsibilities:</strong> Strategic oversight and policy development</li>
                            <li><strong>Meetings:</strong> Regular monthly meetings</li>
                            <li><strong>Accountability:</strong> Report to members at AGM</li>
                        </ul>

                        <h3 id="termination">9. Membership Termination</h3>
                        
                        <h4>9.1 Voluntary Termination</h4>
                        <p>Members may terminate membership by:</p>
                        <ul>
                            <li>Providing 60 days written notice</li>
                            <li>Settling all outstanding obligations</li>
                            <li>Completing withdrawal procedures</li>
                            <li>Returning all Society property</li>
                        </ul>

                        <h4>9.2 Involuntary Termination</h4>
                        <p>The Society may terminate membership for:</p>
                        <ul>
                            <li><strong>Loan Default:</strong> Failure to repay loans as agreed</li>
                            <li><strong>Misconduct:</strong> Behavior detrimental to the Society</li>
                            <li><strong>False Information:</strong> Providing fraudulent information</li>
                            <li><strong>Breach of Terms:</strong> Violation of these terms and conditions</li>
                            <li><strong>Inactivity:</strong> No transactions for 2 consecutive years</li>
                        </ul>

                        <h4>9.3 Settlement Upon Termination</h4>
                        <ul>
                            <li>Outstanding loans must be settled in full</li>
                            <li>Share capital will be refunded after clearance</li>
                            <li>Savings deposits will be returned with accrued interest</li>
                            <li>Final settlement within 90 days of clearance</li>
                        </ul>

                        <h3 id="dispute-resolution">10. Dispute Resolution</h3>
                        
                        <h4>10.1 Internal Resolution</h4>
                        <p>Disputes should first be addressed through:</p>
                        <ol>
                            <li><strong>Direct Discussion:</strong> With relevant staff or management</li>
                            <li><strong>Formal Complaint:</strong> Written complaint to the Manager</li>
                            <li><strong>Supervisory Committee:</strong> Appeal to member-elected committee</li>
                            <li><strong>Board Review:</strong> Final internal appeal to Board of Directors</li>
                        </ol>

                        <h4>10.2 External Resolution</h4>
                        <p>If internal resolution fails, disputes may be referred to:</p>
                        <ul>
                            <li>SASRA (Sacco Societies Regulatory Authority)</li>
                            <li>Cooperative Tribunal</li>
                            <li>Alternative Dispute Resolution mechanisms</li>
                            <li>Courts of law as a last resort</li>
                        </ul>

                        <h3 id="amendments">11. Amendments</h3>
                        
                        <h4>11.1 Amendment Process</h4>
                        <p>These Terms and Conditions may be amended by:</p>
                        <ul>
                            <li><strong>Board Proposal:</strong> Board of Directors proposes amendments</li>
                            <li><strong>Member Notice:</strong> 30 days notice to all members</li>
                            <li><strong>AGM Approval:</strong> Two-thirds majority vote at AGM</li>
                            <li><strong>Regulatory Approval:</strong> SASRA approval where required</li>
                        </ul>

                        <h4>11.2 Notification of Changes</h4>
                        <p>Members will be notified of amendments through:</p>
                        <ul>
                            <li>Written notices to registered addresses</li>
                            <li>Email notifications</li>
                            <li>Website updates</li>
                            <li>Notice boards at Society offices</li>
                        </ul>

                        <h3 id="governing-law">12. Governing Law</h3>
                        
                        <p>These Terms and Conditions are governed by:</p>
                        <ul>
                            <li><strong>The Constitution of Kenya</strong></li>
                            <li><strong>The Co-operative Societies Act</strong> and related regulations</li>
                            <li><strong>SASRA Regulations</strong> and prudential guidelines</li>
                            <li><strong>Banking and Financial Laws</strong> of Kenya</li>
                            <li><strong>The Society's Constitution</strong> and By-laws</li>
                        </ul>

                        <div class="highlight-box">
                            <h4><i class="fas fa-handshake"></i> Our Commitment to You</h4>
                            <p>As a member-owned cooperative, we are committed to serving your financial needs with integrity, transparency, and fairness. These terms and conditions are designed to protect both the Society and its members while ensuring sustainable growth and mutual prosperity.</p>
                        </div>

                        <div class="contact-info-box">
                            <h4><i class="fas fa-envelope"></i> Questions About These Terms?</h4>
                            <p><strong>Email:</strong> <span class="contact-detail">info@daystarmultipurpose.ac.ke</span></p>
                            <p><strong>Phone:</strong> <span class="contact-detail">+254 731 629 716 / +254 799 174 239</span></p>
                            <p><strong>Address:</strong> <span class="contact-detail">Daystar University – Athiriver Campus<br>P.O. Box 44400-00100, Nairobi</span></p>
                            <p><strong>Office Hours:</strong> <span class="contact-detail">Monday-Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 1:00 PM</span></p>
                        </div>

                        <p><strong>By continuing your membership with Daystar Multi-Purpose Co-operative Society Ltd., you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();