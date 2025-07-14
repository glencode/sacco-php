<?php
/**
 * The template for displaying the Privacy Policy page for Daystar Multi-Purpose Co-operative Society Ltd.
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
.privacy-policy-page {
    font-family: var(--font-primary);
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/oceanbackground.jpeg') no-repeat center center fixed;
    background-size: cover;
}

/* Light Overlay for Text Readability */
.privacy-policy-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(59, 58, 58, 0.85);
    backdrop-filter: blur(2px);
    pointer-events: none;
    z-index: 1;
}

/* Ensure content is above overlay */
.privacy-policy-page > * {
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
.privacy-content {
    background: rgba(255, 255, 255, 0.9);
    padding: 3rem;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 105, 148, 0.1);
    box-shadow: var(--shadow-soft);
    margin-bottom: 2rem;
}

.privacy-content h3 {
    color: var(--primary-blue-dark);
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    border-bottom: 2px solid var(--accent-teal);
    padding-bottom: 0.5rem;
}

.privacy-content h4 {
    color: var(--primary-blue);
    font-weight: 600;
    margin-bottom: 1rem;
    margin-top: 2rem;
    font-size: 1.25rem;
}

.privacy-content p {
    color: #374151;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.privacy-content ul, .privacy-content ol {
    color: #374151;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.privacy-content li {
    margin-bottom: 0.5rem;
}

.privacy-content strong {
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

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 80px 0 40px;
    }
    
    .section {
        padding: 60px 0;
        margin: 1rem 0;
    }
    
    .privacy-content {
        padding: 2rem 1.5rem;
    }
}
</style>

<main id="primary" class="site-main privacy-policy-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h1 class="page-title">Privacy Policy</h1>
                    <p class="lead">Your privacy and data protection are our top priorities at Daystar Multi-Purpose Co-operative Society Ltd.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Policy Content -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="last-updated">
                        <i class="fas fa-calendar-alt"></i> Last Updated: <?php echo date('F j, Y'); ?>
                    </div>
                    
                    <div class="privacy-content">
                        <h3>1. Introduction</h3>
                        <p>Daystar Multi-Purpose Co-operative Society Ltd. ("we," "our," or "the Society") is committed to protecting the privacy and confidentiality of our members' personal and financial information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you become a member of our cooperative society or use our financial services.</p>
                        
                        <p>As a financial cooperative exclusively serving the Daystar University community, we understand the importance of maintaining the trust and confidence of our members through responsible data handling practices.</p>

                        <h3>2. Information We Collect</h3>
                        
                        <h4>2.1 Personal Information</h4>
                        <p>We collect personal information necessary for membership and financial services, including:</p>
                        <ul>
                            <li><strong>Identity Information:</strong> Full name, date of birth, national ID number, passport details</li>
                            <li><strong>Contact Information:</strong> Physical address, email address, phone numbers</li>
                            <li><strong>Employment Information:</strong> Daystar University employment details, position, department, employee ID</li>
                            <li><strong>Financial Information:</strong> Bank account details, salary information, credit history</li>
                            <li><strong>Family Information:</strong> Next of kin details, beneficiary information, dependent details for loan purposes</li>
                        </ul>

                        <h4>2.2 Financial Transaction Data</h4>
                        <p>We collect and maintain records of:</p>
                        <ul>
                            <li>Monthly contributions and share capital investments</li>
                            <li>Loan applications, approvals, and repayment history</li>
                            <li>Contribution history and balances</li>
                            <li>Dividend payments and interest earnings</li>
                            <li>Guarantor information and relationships</li>
                        </ul>

                        <h4>2.3 Technical Information</h4>
                        <p>When you use our online services or website, we may collect:</p>
                        <ul>
                            <li>IP addresses and device information</li>
                            <li>Browser type and version</li>
                            <li>Usage patterns and preferences</li>
                            <li>Login credentials and access logs</li>
                        </ul>

                        <h3>3. How We Use Your Information</h3>
                        
                        <h4>3.1 Primary Purposes</h4>
                        <p>We use your information to:</p>
                        <ul>
                            <li><strong>Membership Services:</strong> Process membership applications, maintain member records, and provide cooperative services</li>
                            <li><strong>Financial Services:</strong> Evaluate loan applications, process transactions, calculate interest and dividends</li>
                            <li><strong>Risk Management:</strong> Assess creditworthiness, prevent fraud, and ensure compliance with cooperative policies</li>
                            <li><strong>Communication:</strong> Send important notices, statements, and updates about your accounts and cooperative activities</li>
                            <li><strong>Legal Compliance:</strong> Meet regulatory requirements and legal obligations</li>
                        </ul>

                        <h4>3.2 Secondary Purposes</h4>
                        <p>With your consent, we may use your information for:</p>
                        <ul>
                            <li>Marketing new financial products and services</li>
                            <li>Conducting member satisfaction surveys</li>
                            <li>Inviting you to cooperative events and educational programs</li>
                            <li>Improving our services through data analysis</li>
                        </ul>

                        <h3>4. Information Sharing and Disclosure</h3>
                        
                        <h4>4.1 Within Daystar University Community</h4>
                        <p>We may share limited information with:</p>
                        <ul>
                            <li><strong>Daystar University:</strong> For payroll deduction arrangements and employment verification</li>
                            <li><strong>Other Members:</strong> Only guarantor relationships and basic contact information as necessary for loan processing</li>
                        </ul>

                        <h4>4.2 Third-Party Service Providers</h4>
                        <p>We may share information with trusted service providers who assist us in:</p>
                        <ul>
                            <li>Payment processing and banking services</li>
                            <li>Credit reference and verification services</li>
                            <li>IT support and data management</li>
                            <li>Audit and compliance services</li>
                        </ul>

                        <h4>4.3 Legal Requirements</h4>
                        <p>We may disclose your information when required by:</p>
                        <ul>
                            <li>Kenyan law and regulations</li>
                            <li>Court orders or legal proceedings</li>
                            <li>Regulatory authorities (SASRA, Central Bank of Kenya)</li>
                            <li>Law enforcement agencies for legitimate investigations</li>
                        </ul>

                        <div class="highlight-box">
                            <h4><i class="fas fa-shield-alt"></i> Important Note</h4>
                            <p><strong>We never sell, rent, or trade your personal information to third parties for marketing purposes.</strong> Your data is used exclusively for legitimate cooperative business purposes and legal compliance.</p>
                        </div>

                        <h3>5. Data Security Measures</h3>
                        
                        <h4>5.1 Physical Security</h4>
                        <ul>
                            <li>Secure office premises with controlled access</li>
                            <li>Locked filing cabinets for physical documents</li>
                            <li>Restricted access to member records</li>
                            <li>Secure disposal of confidential documents</li>
                        </ul>

                        <h4>5.2 Digital Security</h4>
                        <ul>
                            <li>Encrypted data transmission and storage</li>
                            <li>Regular security updates and patches</li>
                            <li>Multi-factor authentication for staff access</li>
                            <li>Regular data backups and recovery procedures</li>
                            <li>Firewall protection and intrusion detection</li>
                        </ul>

                        <h4>5.3 Staff Training</h4>
                        <ul>
                            <li>Regular privacy and security training for all staff</li>
                            <li>Confidentiality agreements for all employees</li>
                            <li>Clear data handling procedures and protocols</li>
                            <li>Regular audits of data access and usage</li>
                        </ul>

                        <h3>6. Your Rights and Choices</h3>
                        
                        <h4>6.1 Access Rights</h4>
                        <p>As a member, you have the right to:</p>
                        <ul>
                            <li>Access your personal information held by the Society</li>
                            <li>Request copies of your account statements and transaction history</li>
                            <li>Review your loan application and approval documents</li>
                            <li>Obtain information about how your data is being used</li>
                        </ul>

                        <h4>6.2 Correction Rights</h4>
                        <p>You can request corrections to:</p>
                        <ul>
                            <li>Inaccurate personal information</li>
                            <li>Outdated contact details</li>
                            <li>Employment information changes</li>
                            <li>Beneficiary and next of kin details</li>
                        </ul>

                        <h4>6.3 Communication Preferences</h4>
                        <p>You can choose:</p>
                        <ul>
                            <li>How you receive statements (email, SMS, or physical mail)</li>
                            <li>Whether to receive marketing communications</li>
                            <li>Frequency of non-essential communications</li>
                            <li>Language preferences for communications</li>
                        </ul>

                        <h3>7. Data Retention</h3>
                        
                        <p>We retain your information for different periods based on:</p>
                        <ul>
                            <li><strong>Active Membership:</strong> Throughout your membership period and for 7 years after termination</li>
                            <li><strong>Loan Records:</strong> For 7 years after final loan repayment</li>
                            <li><strong>Transaction Records:</strong> For 7 years as required by financial regulations</li>
                            <li><strong>Legal Requirements:</strong> As mandated by Kenyan law and cooperative regulations</li>
                        </ul>

                        <h3>8. Cookies and Website Usage</h3>
                        
                        <p>Our website uses cookies to:</p>
                        <ul>
                            <li>Remember your login preferences</li>
                            <li>Improve website functionality and user experience</li>
                            <li>Analyze website usage patterns</li>
                            <li>Ensure website security</li>
                        </ul>
                        
                        <p>You can control cookie settings through your browser preferences. However, disabling cookies may affect website functionality.</p>

                        <h3>9. Children's Privacy</h3>
                        
                        <p>Our services are designed for adults (18+ years). We do not knowingly collect personal information from children under 18, except:</p>
                        <ul>
                            <li>When required for loan applications (dependent information)</li>
                            <li>For beneficiary designation purposes</li>
                            <li>With explicit parental consent for junior savings accounts</li>
                        </ul>

                        <h3>10. Changes to This Privacy Policy</h3>
                        
                        <p>We may update this Privacy Policy to reflect:</p>
                        <ul>
                            <li>Changes in our services or operations</li>
                            <li>New legal or regulatory requirements</li>
                            <li>Improvements in our data protection practices</li>
                            <li>Member feedback and suggestions</li>
                        </ul>
                        
                        <p>We will notify members of significant changes through:</p>
                        <ul>
                            <li>Email notifications to registered email addresses</li>
                            <li>Notices on our website and member portal</li>
                            <li>Announcements during Annual General Meetings</li>
                            <li>Physical notices at our offices</li>
                        </ul>

                        <h3>11. Complaints and Concerns</h3>
                        
                        <p>If you have concerns about how we handle your personal information:</p>
                        <ol>
                            <li><strong>Contact Us Directly:</strong> Speak with our Member Services team</li>
                            <li><strong>Formal Complaint:</strong> Submit a written complaint to our Management</li>
                            <li><strong>Supervisory Committee:</strong> Escalate to our member-elected Supervisory Committee</li>
                            <li><strong>External Authorities:</strong> Contact SASRA or relevant data protection authorities</li>
                        </ol>

                        <div class="contact-info-box">
                            <h4><i class="fas fa-envelope"></i> Contact Our Privacy Officer</h4>
                            <p><strong>Email:</strong> <span class="contact-detail">privacy@daystarmultipurpose.ac.ke</span></p>
                            <p><strong>Phone:</strong> <span class="contact-detail">+254 731 629 716</span></p>
                            <p><strong>Address:</strong> <span class="contact-detail">Daystar University – Athiriver Campus<br>P.O. Box 44400-00100, Nairobi</span></p>
                            <p><strong>Office Hours:</strong> <span class="contact-detail">Monday-Friday: 8:00 AM - 5:00 PM</span></p>
                        </div>

                        <h3>12. Governing Law</h3>
                        
                        <p>This Privacy Policy is governed by:</p>
                        <ul>
                            <li>The Constitution of Kenya</li>
                            <li>The Co-operative Societies Act</li>
                            <li>The Data Protection Act, 2019</li>
                            <li>Banking regulations and guidelines</li>
                            <li>SASRA regulations and prudential guidelines</li>
                        </ul>

                        <div class="highlight-box">
                            <h4><i class="fas fa-handshake"></i> Our Commitment</h4>
                            <p>As a member-owned cooperative, we are accountable to you. Your trust is the foundation of our relationship, and we are committed to maintaining the highest standards of privacy and data protection in all our operations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();