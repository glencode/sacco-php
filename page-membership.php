<?php
/**
 * The template for displaying the Membership page for Daystar Multi-Purpose Co-operative Society Ltd.
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

/* Base Styles - Background set via inline styles */
.membership-page {
    font-family: var(--font-primary);
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/membership-overview.jpg') no-repeat center center fixed !important;
    background-size: cover !important;
}

/* Very Light Overlay for Text Readability */
.membership-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.05);
    pointer-events: none;
    z-index: 1;
}

/* Ensure content is above overlay */
.membership-page > * {
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

.page-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(180deg, transparent 0%, rgba(248, 250, 252, 0.1) 100%);
    pointer-events: none;
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

.page-header-image {
    position: relative;
    z-index: 2;
}

.page-header-image img {
    max-width: 120px;
    height: auto;
    filter: drop-shadow(0 8px 25px rgba(255, 255, 255, 0.2));
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(2deg); }
    66% { transform: translateY(5px) rotate(-1deg); }
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

/* Enhanced Section Styling - Uniform Transparent Background */
.section {
    padding: 100px 0;
    position: relative;
    background: rgba(0, 0, 0, 0.05) !important;
    backdrop-filter: blur(3px);
}

.section.bg-light {
    background: rgba(0, 0, 0, 0.05) !important;
    backdrop-filter: blur(3px);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.section-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1.5rem;
    position: relative;
    text-align: center;
    text-shadow: 0 2px 15px rgba(0, 0, 0, 0.7);
}

.section-title.text-start {
    text-align: left;
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

.section-title.text-start::after {
    left: 0;
    transform: none;
}

.section-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 3rem;
    font-weight: 400;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
}

/* Enhanced Section Content for Better Visibility */
.section-content {
    background: rgba(0, 0, 0, 0.2);
    padding: 2rem;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.section-content .lead {
    color: rgba(255, 255, 255, 0.95);
    font-weight: 500;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
    margin-bottom: 1.5rem;
}

.section-content p {
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    line-height: 1.7;
}

/* Enhanced Card Styles - Very Light Transparent for Maximum Background Visibility */
.feature-card, .benefit-card, .testimonial-card {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 2.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease, background 0.3s ease;
    position: relative;
    height: 100%;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    will-change: transform;
}

.feature-card:hover, .benefit-card:hover, .testimonial-card:hover {
    transform: translateY(-8px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 15px 50px rgba(0, 105, 148, 0.15);
    border-color: rgba(32, 178, 170, 0.4);
}

/* Card Content Styling for Better Readability */
.feature-card h3, .benefit-card h3, .testimonial-card h3 {
    color: #fff;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6);
    font-weight: 700;
}

.feature-card p, .benefit-card p, .testimonial-card p,
.feature-card ul, .benefit-card ul, .testimonial-card ul,
.feature-card li, .benefit-card li, .testimonial-card li {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

/* Enhanced Icons */
.benefit-icon, .feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-blue), var(--accent-teal));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
    font-size: 2rem;
    color: #fff;
    box-shadow: var(--shadow-glow);
    position: relative;
    z-index: 2;
    transition: var(--transition-medium);
}

.feature-card:hover .feature-icon, .benefit-card:hover .benefit-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 0 40px rgba(32, 178, 170, 0.5);
}

.university-badge {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-soft);
    display: inline-block;
}

/* Enhanced Button Styles */
.btn {
    font-family: var(--font-primary);
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 50px;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: var(--transition-medium);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    cursor: pointer;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition-medium);
}

.btn:hover::before {
    left: 100%;
}

.btn-primary, .btn-gradient {
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
    color: #fff;
    box-shadow: var(--shadow-medium);
}

.btn-primary:hover, .btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 105, 148, 0.4);
    color: #fff;
}

.btn-outline-primary {
    background: rgba(255, 255, 255, 0.1);
    color: var(--primary-blue);
    border: 2px solid var(--primary-blue);
    backdrop-filter: blur(20px);
}

.btn-outline-primary:hover {
    background: var(--primary-blue);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.btn-outline-light {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border: 2px solid #fff;
    backdrop-filter: blur(20px);
}

.btn-outline-light:hover {
    background: #fff;
    color: var(--primary-blue-dark);
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

/* Enhanced CTA Section */
.cta-section {
    background: var(--bg-hero);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    margin-top: 48px;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 70% 60%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
    pointer-events: none;
    animation: ctaGlow 12s ease-in-out infinite;
}

@keyframes ctaGlow {
    0%, 100% { opacity: 0.8; }
    50% { opacity: 1; }
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.cta-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

/* Enhanced Highlights */
.eligibility-highlight {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    padding: 1.5rem;
    border-radius: 16px;
    text-align: center;
    font-weight: 600;
    margin: 2rem 0;
    box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.eligibility-highlight::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: var(--transition-slow);
}

.eligibility-highlight:hover::before {
    left: 100%;
}

/* Enhanced Alert Styles */
.alert {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.alert-info {
    border-left: 4px solid var(--accent-teal);
}

/* Enhanced Step Items */
.step-item {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 2rem 1rem;
    text-align: center;
    transition: var(--transition-medium);
    height: 100%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.step-item:hover {
    transform: translateY(-5px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.step-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-blue), var(--accent-teal));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: #fff;
    box-shadow: var(--shadow-glow);
    transition: var(--transition-medium);
}

.step-item:hover .step-number {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 0 40px rgba(32, 178, 170, 0.5);
}

.step-title {
    color: #fff;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.3rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.step-description {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

/* Enhanced Testimonials */
.testimonial-rating {
    margin-bottom: 1.5rem;
}

.testimonial-rating i {
    color: var(--accent-gold);
    font-size: 1.2rem;
    margin: 0 0.2rem;
    filter: drop-shadow(0 2px 5px rgba(255, 215, 0, 0.3));
}

.testimonial-content {
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.testimonial-content p {
    font-style: italic;
    color: rgba(255, 255, 255, 0.95);
    line-height: 1.7;
    font-size: 1.1rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 2;
}

.testimonial-author-info h5 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 0.25rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.testimonial-author-info p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin: 0;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

/* Parallax fix for mobile */
@media (max-width: 991px) {
    .membership-page {
        background-attachment: scroll;
    }
}

/* Enhanced Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 80px 0 40px;
    }
    
    .section {
        padding: 60px 0;
    }
    
    .feature-card, .benefit-card, .testimonial-card {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .step-number {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .btn:last-child {
        margin-bottom: 0;
    }
}
</style>

<main id="primary" class="site-main membership-page">
    <!-- Page Header with Parallax -->
    <section class="page-header bg-gradient parallax-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="university-badge">Daystar University Community</span>
                    <h1 class="page-title">Membership</h1>
                    <p class="lead mb-4">Join the Daystar Multi-Purpose Co-operative Society Ltd. - A financial cooperative exclusively serving the Daystar University community</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Membership</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-logo.svg" alt="Daystar University" aria-hidden="true" style="max-height: 120px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Overview Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Exclusively for Daystar University Community</h2>
                        <p class="lead">Daystar Multi-Purpose Co-operative Society Ltd. is a member-owned financial cooperative established to serve the financial needs of Daystar University staff, faculty, and associated individuals.</p>
                        <p>As a member of our cooperative, you become a co-owner with voting rights and access to our comprehensive range of financial products and services. Our cooperative operates on the principles of mutual support, democratic governance, and community development.</p>
                        <p><strong>Our Mission:</strong> To empower the Daystar University community through accessible, affordable, and innovative financial solutions that promote economic growth and financial security.</p>
                        <div class="mt-4">
                            <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary me-3">How to Join</a>
                            <a href="<?php echo esc_url(home_url('membership-benefits')); ?>" class="btn btn-outline-primary">View Benefits</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="membership-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-campus-community.jpg" alt="Daystar University Campus Community" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Who Can Join?</h2>
                <p class="section-subtitle">Membership is exclusively for the Daystar University community</p>
            </div>
            
            <div class="eligibility-highlight fade-in">
                <h3 style="margin-bottom: 1rem;">🎓 Daystar University Community Members Only</h3>
                <p style="margin-bottom: 0; font-size: 1.1rem;">This cooperative society is specifically established for and limited to individuals with a direct connection to Daystar University.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                        </div>
                        <h3>Faculty Members</h3>
                        <ul style="text-align: left; padding-left: 1.5rem;">
                            <li>Full-time faculty members</li>
                            <li>Part-time teaching staff</li>
                            <li>Visiting professors and lecturers</li>
                            <li>Research fellows and associates</li>
                            <li>Adjunct faculty</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog" aria-hidden="true"></i>
                        </div>
                        <h3>Administrative Staff</h3>
                        <ul style="text-align: left; padding-left: 1.5rem;">
                            <li>Permanent administrative staff</li>
                            <li>Contract employees</li>
                            <li>Department heads and managers</li>
                            <li>Support staff (security, maintenance, etc.)</li>
                            <li>Student services personnel</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-user-friends" aria-hidden="true"></i>
                        </div>
                        <h3>Associated Individuals</h3>
                        <ul style="text-align: left; padding-left: 1.5rem;">
                            <li>Retired Daystar University employees</li>
                            <li>Spouses of current staff/faculty</li>
                            <li>Board members and trustees</li>
                            <li>Long-term contractors and consultants</li>
                            <li>Alumni in leadership positions</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-4 fade-in" style="background: #e0f2fe; border: 1px solid var(--primary-blue); border-radius: 10px; padding: 1.5rem;">
                <h5 style="color: var(--daystar-navy);"><i class="fas fa-info-circle"></i> Important Note</h5>
                <p style="margin-bottom: 0;">All prospective members must provide proof of their association with Daystar University. This includes employment letters, contracts, or official documentation confirming your relationship with the institution.</p>
            </div>
        </div>
    </section>

    <!-- Membership Requirements Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Membership Requirements</h2>
                <p class="section-subtitle">What you need to become a member of Daystar SACCO</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-university" aria-hidden="true"></i>
                        </div>
                        <h3>Daystar University Connection</h3>
                        <p>Must be a current or former employee, faculty member, or have an official association with Daystar University. Proof of employment or association required.</p>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-coins" aria-hidden="true"></i>
                        </div>
                        <h3>Share Capital Investment</h3>
                        <p>Minimum share capital of <strong>KSh 5,000</strong> (250 shares at KSh 20 each). Shares represent your ownership in the cooperative and earn annual dividends.</p>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check" aria-hidden="true"></i>
                        </div>
                        <h3>Monthly Contributions</h3>
                        <p>Minimum monthly contribution of <strong>KSh 2,000</strong>. Consistent contributions for at least 6 months required for loan eligibility.</p>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract" aria-hidden="true"></i>
                        </div>
                        <h3>Documentation</h3>
                        <p>Valid ID/passport, recent photos, proof of Daystar University employment/association, and completed membership application form.</p>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                        </div>
                        <h3>Registration Fee</h3>
                        <p>One-time non-refundable registration fee of <strong>KSh 1,000</strong> to process your membership application and setup your account.</p>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-user-check" aria-hidden="true"></i>
                        </div>
                        <h3>Age Requirement</h3>
                        <p>Must be at least 18 years old and of sound mind. For staff members under 18, special provisions may apply with parental consent.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Benefits for Daystar Community -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Special Benefits for Daystar Community</h2>
                <p class="section-subtitle">Exclusive advantages designed for university staff and faculty</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Education Support Loans</h3>
                                <p>Special school fees loans at 10% annual interest for your children's education, with flexible repayment terms up to 24 months.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Special Loan Privileges</h3>
                                <p>Extended repayment periods up to 48 months for permanent staff, with preferential rates and streamlined approval processes.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Salary Advance Facility</h3>
                                <p>Quick salary advance up to KSh 100,000 for staff members, processed same day with simple 10% one-time fee.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-heartbeat" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Emergency Support</h3>
                                <p>Emergency loans up to KSh 200,000 processed same day for urgent medical or family needs, with minimal documentation.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-home" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Development Loans</h3>
                                <p>Long-term development loans up to KSh 2,000,000 for home construction, business ventures, and major investments.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="benefit-card fade-in">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <div class="benefit-icon">
                                    <i class="fas fa-piggy-bank" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3>Competitive Returns</h3>
                                <p>Attractive annual dividends on share capital based on cooperative performance and member contributions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Journey Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Your Membership Journey</h2>
                <p class="section-subtitle">From application to full membership benefits</p>
            </div>
            
            <div class="membership-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item" style="background: var(--primary-light); border-radius: 14px; padding: 24px 16px; text-align: center; height: 100%;">
                            <div class="step-number" style="background: var(--daystar-navy); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; font-weight: bold;">1</div>
                            <h3 class="step-title">Verify Eligibility</h3>
                            <p class="step-description">Confirm your connection to Daystar University and gather required documentation including employment verification.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item" style="background: var(--primary-light); border-radius: 14px; padding: 24px 16px; text-align: center; height: 100%;">
                            <div class="step-number" style="background: var(--daystar-navy); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; font-weight: bold;">2</div>
                            <h3 class="step-title">Submit Application</h3>
                            <p class="step-description">Complete membership application form and submit with all required documents and registration fee.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item" style="background: var(--primary-light); border-radius: 14px; padding: 24px 16px; text-align: center; height: 100%;">
                            <div class="step-number" style="background: var(--daystar-navy); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; font-weight: bold;">3</div>
                            <h3 class="step-title">Initial Investment</h3>
                            <p class="step-description">Make your initial share capital investment of KSh 5,000 and begin monthly contributions of KSh 2,000.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item" style="background: var(--primary-light); border-radius: 14px; padding: 24px 16px; text-align: center; height: 100%;">
                            <div class="step-number" style="background: var(--daystar-navy); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; font-weight: bold;">4</div>
                            <h3 class="step-title">Full Benefits</h3>
                            <p class="step-description">After 6 months of consistent contributions, access all loan products and enjoy full membership privileges.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary btn-lg">Start Your Application</a>
            </div>
        </div>
    </section>

    <!-- Testimonials from Daystar Community -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">What Our Daystar Community Says</h2>
                <p class="section-subtitle">Real experiences from faculty and staff members</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating" style="color: var(--daystar-gold); margin-bottom: 1rem;">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"As a faculty member, the school fees loan has been invaluable for my children's education. The 10% interest rate and flexible terms made it possible for me to provide quality education without financial strain."</p>
                        </div>
                        <div class="testimonial-author" style="display: flex; align-items: center; margin-top: 1.5rem;">
                            <div class="testimonial-author-img" style="margin-right: 1rem;">
                                <div style="width: 60px; height: 60px; background: var(--daystar-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--daystar-navy); font-size: 1.5rem; font-weight: bold;">DK</div>
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Dr. Sarah Kamau</h5>
                                <p>Faculty Member, School of Business<br><small>Member since 2018</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating" style="color: var(--daystar-gold); margin-bottom: 1rem;">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The development loan helped me build my family home. As a permanent staff member, I qualified for the extended 48-month repayment period, which made the monthly payments very manageable."</p>
                        </div>
                        <div class="testimonial-author" style="display: flex; align-items: center; margin-top: 1.5rem;">
                            <div class="testimonial-author-img" style="margin-right: 1rem;">
                                <div style="width: 60px; height: 60px; background: var(--daystar-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--daystar-navy); font-size: 1.5rem; font-weight: bold;">JM</div>
                            </div>
                            <div class="testimonial-author-info">
                                <h5>James Mwangi</h5>
                                <p>Administrative Staff, Finance Department<br><small>Member since 2016</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card fade-in">
                        <div class="testimonial-rating" style="color: var(--daystar-gold); margin-bottom: 1rem;">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>"The emergency loan was processed the same day when I had a medical emergency. The understanding and quick response from our SACCO made all the difference during a difficult time."</p>
                        </div>
                        <div class="testimonial-author" style="display: flex; align-items: center; margin-top: 1.5rem;">
                            <div class="testimonial-author-img" style="margin-right: 1rem;">
                                <div style="width: 60px; height: 60px; background: var(--daystar-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--daystar-navy); font-size: 1.5rem; font-weight: bold;">MO</div>
                            </div>
                            <div class="testimonial-author-info">
                                <h5>Mary Ochieng</h5>
                                <p>Support Staff, Student Services<br><small>Member since 2019</small></p>
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
                        <h2 class="cta-title">Ready to Join the Daystar SACCO Family?</h2>
                        <p class="cta-subtitle">Take the first step toward financial empowerment within the Daystar University community.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-gradient btn-lg">Join Now</a>
                        <a href="<?php echo esc_url(home_url('contact')); ?>" class="btn btn-outline-light btn-lg ms-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();