<?php
/**
 * Template Name: How to Join Page
 *
 * The template for displaying membership information and how to join Daystar Multi-Purpose Co-operative Society Ltd.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
.site-main {
    font-family: var(--font-primary);
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/how-to-joinbg.jpg') no-repeat center center fixed !important;
    background-size: cover !important;
}

/* Very Light Overlay for Text Readability */
.site-main::before {
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
.site-main > * {
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
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 3rem;
    font-weight: 400;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
}

/* Enhanced Card Styles - Very Light Transparent for Maximum Background Visibility */
.eligibility-card, .join-step, .benefit-card {
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

.eligibility-card:hover, .join-step:hover, .benefit-card:hover {
    transform: translateY(-8px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 15px 50px rgba(0, 105, 148, 0.15);
    border-color: rgba(32, 178, 170, 0.4);
}

/* Card Content Styling for Better Readability */
.eligibility-card h3, .join-step h3, .benefit-card h3,
.eligibility-card .card-title, .join-step .card-title, .benefit-card .card-title {
    color: #fff;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6);
    font-weight: 700;
}

.eligibility-card p, .join-step p, .benefit-card p,
.eligibility-card ul, .join-step ul, .benefit-card ul,
.eligibility-card li, .join-step li, .benefit-card li {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

/* Enhanced Icons */
.eligibility-icon, .benefit-icon {
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

.eligibility-card:hover .eligibility-icon, .benefit-card:hover .benefit-icon {
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

.join-step:hover .step-number {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 0 40px rgba(32, 178, 170, 0.5);
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

.btn-primary {
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
    color: #fff;
    box-shadow: var(--shadow-medium);
}

.btn-primary:hover {
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

.btn-light {
    background: rgba(255, 255, 255, 0.9);
    color: var(--primary-blue-dark);
    box-shadow: var(--shadow-medium);
}

.btn-light:hover {
    background: #fff;
    color: var(--primary-blue-dark);
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.4);
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

/* Enhanced Highlights */
.daystar-highlight {
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

.daystar-highlight::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: var(--transition-slow);
}

.daystar-highlight:hover::before {
    left: 100%;
}

.requirement-badge {
    background: linear-gradient(135deg, var(--primary-blue), var(--accent-teal));
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 105, 148, 0.3);
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

.alert-success {
    border-left: 4px solid var(--accent-emerald);
}

/* Enhanced Payment Items */
.payment-item {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    transition: var(--transition-medium);
    height: 100%;
    text-align: center;
}

.payment-item:hover {
    transform: translateY(-5px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.payment-item h5 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.payment-item p {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.payment-item small {
    color: rgba(255, 255, 255, 0.8);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

/* Enhanced Submission Methods */
.submission-method {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    transition: var(--transition-medium);
    height: 100%;
    text-align: center;
}

.submission-method:hover {
    transform: translateY(-5px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.submission-method h4 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.submission-method p {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.submission-method small {
    color: rgba(255, 255, 255, 0.8);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.submission-method i {
    color: var(--accent-teal);
    filter: drop-shadow(0 2px 5px rgba(32, 178, 170, 0.3));
}

/* Enhanced Requirements Card */
.requirements-card {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.requirement-item {
    text-align: center;
    padding: 2rem 1rem;
}

.requirement-icon {
    margin-bottom: 1.5rem;
}

.requirement-icon i {
    color: var(--accent-teal);
    filter: drop-shadow(0 2px 5px rgba(32, 178, 170, 0.3));
}

.amount-display {
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
    margin: 1rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
}

.amount-display .currency {
    font-size: 1.2rem;
    vertical-align: top;
}

.amount-display .period {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: normal;
}

.feature-highlight {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 1rem;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
}

/* Enhanced Contact Info */
.contact-info p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.contact-info i {
    margin-right: 0.5rem;
    color: var(--accent-gold);
    filter: drop-shadow(0 2px 5px rgba(255, 215, 0, 0.3));
}

/* Enhanced CTA Buttons */
.cta-buttons .btn {
    margin: 0.5rem;
}

/* Parallax fix for mobile */
@media (max-width: 991px) {
    .site-main {
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
    
    .eligibility-card, .join-step, .benefit-card {
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
    
    .payment-item, .submission-method {
        margin-bottom: 1rem;
    }
}
</style>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5 parallax-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<span class="university-badge">Daystar University Community</span>
					<h1 class="page-title"><?php the_title(); ?></h1>
					<p class="lead">Join Daystar Multi-Purpose Co-operative Society Ltd. - Your pathway to financial empowerment within the university community</p>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<?php
	while ( have_posts() ) :
		the_post();
	?>
	
	<section class="join-intro-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<h2>Become a Member of Daystar SACCO Today</h2>
					<p class="lead mb-4">Join our exclusive financial cooperative designed specifically for the Daystar University community - faculty, staff, and associated individuals.</p>
					
					<div class="daystar-highlight">
						<h3 style="margin-bottom: 1rem;">🎓 Exclusively for Daystar University Community</h3>
						<p style="margin-bottom: 0; font-size: 1.1rem;">This cooperative society serves only those with a direct connection to Daystar University - ensuring a close-knit, supportive financial community.</p>
					</div>
					
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-eligibility-section py-5 bg-light">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">Membership Eligibility</h2>
					<p class="section-subtitle">Who can join Daystar Multi-Purpose Co-operative Society?</p>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="eligibility-icon mb-3">
								<i class="fas fa-chalkboard-teacher"></i>
							</div>
							<h3 class="card-title">Faculty Members</h3>
							<ul class="eligibility-list text-start">
								<li>Full-time faculty members</li>
								<li>Part-time teaching staff</li>
								<li>Visiting professors and lecturers</li>
								<li>Research fellows and associates</li>
								<li>Adjunct faculty members</li>
							</ul>
							<span class="requirement-badge">Employment Letter Required</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="eligibility-icon mb-3">
								<i class="fas fa-users-cog"></i>
							</div>
							<h3 class="card-title">Administrative Staff</h3>
							<ul class="eligibility-list text-start">
								<li>Permanent administrative staff</li>
								<li>Contract employees</li>
								<li>Department heads and managers</li>
								<li>Support staff (security, maintenance)</li>
								<li>Student services personnel</li>
							</ul>
							<span class="requirement-badge">Staff ID Required</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card eligibility-card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="eligibility-icon mb-3">
								<i class="fas fa-user-friends"></i>
							</div>
							<h3 class="card-title">Associated Individuals</h3>
							<ul class="eligibility-list text-start">
								<li>Retired Daystar University employees</li>
								<li>Spouses of current staff/faculty</li>
								<li>Board members and trustees</li>
								<li>Long-term contractors</li>
								<li>Alumni in leadership positions</li>
							</ul>
							<span class="requirement-badge">Association Proof Required</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-process-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">How to Join Daystar SACCO</h2>
					<p class="section-subtitle">Follow these simple steps to become a member</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="join-process">
						<!-- Step 1 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">1</div>
									</div>
									<div class="col-md-10">
										<h3>Verify Your Daystar University Connection</h3>
										<p>Confirm your eligibility by gathering proof of your association with Daystar University:</p>
										<ul>
											<li><strong>Faculty:</strong> Employment letter, contract, or faculty ID</li>
											<li><strong>Staff:</strong> Staff ID, employment letter, or payslip</li>
											<li><strong>Associated:</strong> Retirement letter, spouse employment proof, or official documentation</li>
										</ul>
										<div class="alert alert-info mt-3">
											<strong>Note:</strong> All members must demonstrate a direct connection to Daystar University
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 2 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">2</div>
									</div>
									<div class="col-md-10">
										<h3>Complete Membership Application Form</h3>
										<p>Download and fill out the official Daystar SACCO membership application form with:</p>
										<ul>
											<li>Personal details and contact information</li>
											<li>Daystar University employment/association details</li>
											<li>Employee number (if applicable)</li>
											<li>Department and position information</li>
											<li>Next of kin details</li>
										</ul>
										<a href="<?php echo esc_url(home_url('/downloads/daystar-sacco-membership-form/')); ?>" class="btn btn-primary mt-2">Download Application Form</a>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 3 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">3</div>
									</div>
									<div class="col-md-10">
										<h3>Gather Required Documents</h3>
										<p>Prepare the following documents for submission:</p>
										<ul>
											<li>Copy of National ID or Passport</li>
											<li>Two recent passport-sized photographs</li>
											<li>Proof of Daystar University employment/association</li>
											<li>Recent payslip (for staff members)</li>
											<li>Completed membership application form</li>
											<li>Next of kin ID copy</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 4 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">4</div>
									</div>
									<div class="col-md-10">
										<h3>Make Initial Financial Commitments</h3>
										<p>Prepare the following payments to activate your membership:</p>
										<div class="row mt-3">
											<div class="col-md-6">
												<div class="payment-item p-3 border rounded">
													<h5><i class="fas fa-file-invoice-dollar text-primary"></i> Registration Fee</h5>
													<p class="mb-1"><strong>KSh 1,000</strong> (one-time, non-refundable)</p>
													<small class="text-muted">Covers application processing and account setup</small>
												</div>
											</div>
											<div class="col-md-6">
												<div class="payment-item p-3 border rounded">
													<h5><i class="fas fa-coins text-warning"></i> Share Capital</h5>
													<p class="mb-1"><strong>KSh 5,000 minimum</strong> (250 shares @ KSh 20 each)</p>
													<small class="text-muted">Your ownership stake in the cooperative</small>
												</div>
											</div>
										</div>
										<div class="alert alert-success mt-3">
											<strong>Payment Options:</strong> M-PESA, Bank Transfer, or Cash at SACCO office
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 5 -->
						<div class="join-step card border-0 shadow-sm mb-4">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">5</div>
									</div>
									<div class="col-md-10">
										<h3>Submit Your Application</h3>
										<p>Submit your completed application and documents:</p>
										<div class="row g-3 mt-2">
											<div class="col-md-6">
												<div class="submission-method p-3 border rounded text-center h-100">
													<i class="fas fa-building mb-2 text-primary fa-2x"></i>
													<h4 class="h5">Visit Our Office</h4>
													<p class="mb-2">Daystar University Campus<br>Athi River, Kenya</p>
													<small>Monday - Friday: 8:00 AM - 5:00 PM</small>
												</div>
											</div>
											<div class="col-md-6">
												<div class="submission-method p-3 border rounded text-center h-100">
													<i class="fas fa-envelope mb-2 text-primary fa-2x"></i>
													<h4 class="h5">Email Submission</h4>
													<p class="mb-2">membership@daystarcoopsacco.com</p>
													<small>Scanned copies accepted for initial review</small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Step 6 -->
						<div class="join-step card border-0 shadow-sm">
							<div class="card-body p-4">
								<div class="row align-items-center">
									<div class="col-md-2 text-center mb-3 mb-md-0">
										<div class="step-number">6</div>
									</div>
									<div class="col-md-10">
										<h3>Application Review and Approval</h3>
										<p>Your application will be processed as follows:</p>
										<ul>
											<li><strong>Initial Review:</strong> 2-3 working days for document verification</li>
											<li><strong>Committee Approval:</strong> Applications reviewed at monthly committee meetings</li>
											<li><strong>Membership Activation:</strong> Account setup and member number assignment</li>
											<li><strong>Welcome Package:</strong> Membership certificate, account details, and member handbook</li>
										</ul>
										<div class="alert alert-info mt-3">
											<strong>Timeline:</strong> Complete process typically takes 7-14 working days
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; ?>
	
	<section class="join-benefits-section py-5 bg-light">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title mb-3">Exclusive Benefits for Daystar Community</h2>
					<p class="section-subtitle">Special advantages designed for university staff and faculty</p>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-graduation-cap"></i>
							</div>
							<h3 class="card-title h4">School Fees Loans</h3>
							<p class="card-text">Special education loans at 10% annual interest for your children's school fees, with up to 24-month repayment terms.</p>
							<div class="feature-highlight">
								<strong>Up to KSh 500,000</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-user-tie"></i>
							</div>
							<h3 class="card-title h4">Special Loan Privileges</h3>
							<p class="card-text">Extended repayment periods up to 48 months for permanent staff members with preferential processing.</p>
							<div class="feature-highlight">
								<strong>Extended Terms Available</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-money-bill-wave"></i>
							</div>
							<h3 class="card-title h4">Salary Advance</h3>
							<p class="card-text">Quick salary advance facility for staff members, processed same day with simple 10% one-time fee.</p>
							<div class="feature-highlight">
								<strong>Up to KSh 100,000</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-heartbeat"></i>
							</div>
							<h3 class="card-title h4">Emergency Support</h3>
							<p class="card-text">Same-day emergency loans for urgent medical or family needs with minimal documentation requirements.</p>
							<div class="feature-highlight">
								<strong>Up to KSh 200,000</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-home"></i>
							</div>
							<h3 class="card-title h4">Development Loans</h3>
							<p class="card-text">Long-term development loans for home construction, business ventures, and major investments.</p>
							<div class="feature-highlight">
								<strong>Up to KSh 2,000,000</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="benefit-card card border-0 shadow-sm h-100">
						<div class="card-body p-4 text-center">
							<div class="benefit-icon mb-3">
								<i class="fas fa-chart-line"></i>
							</div>
							<h3 class="card-title h4">Competitive Returns</h3>
							<p class="card-text">Attractive annual dividends on share capital and competitive interest rates on savings deposits.</p>
							<div class="feature-highlight">
								<strong>Higher Than Banks</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-requirements-section py-5">
		<div class="container">
			<div class="row mb-4">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Monthly Commitment Requirements</h2>
					<p class="section-subtitle">What you need to maintain active membership</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="requirements-card card border-0 shadow-lg">
						<div class="card-body p-5">
							<div class="row text-center">
								<div class="col-md-6 mb-4">
									<div class="requirement-item">
										<div class="requirement-icon mb-3">
											<i class="fas fa-calendar-alt fa-3x" style="color: var(--daystar-navy);"></i>
										</div>
										<h4>Monthly Contributions</h4>
										<div class="amount-display">
											<span class="currency">KSh</span>
											<span class="amount">2,000</span>
											<span class="period">per month</span>
										</div>
										<p class="text-muted">Minimum monthly savings contribution required for all active members</p>
									</div>
								</div>
								<div class="col-md-6 mb-4">
									<div class="requirement-item">
										<div class="requirement-icon mb-3">
											<i class="fas fa-clock fa-3x" style="color: var(--daystar-gold);"></i>
										</div>
										<h4>Loan Eligibility Period</h4>
										<div class="amount-display">
											<span class="amount">6</span>
											<span class="period">months</span>
										</div>
										<p class="text-muted">Consistent contributions required before qualifying for loans</p>
									</div>
								</div>
							</div>
							<div class="alert alert-success text-center mt-4">
								<h5><i class="fas fa-info-circle"></i> Good to Know</h5>
								<p class="mb-0">After 6 months of consistent KSh 2,000 monthly contributions (totaling KSh 12,000), you become eligible for all loan products with amounts based on your savings and guarantor capacity.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="join-cta-section py-5" style="background: linear-gradient(90deg, var(--daystar-navy), var(--primary-blue)); color: white;">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<h2 class="text-white">Ready to Join the Daystar SACCO Family?</h2>
					<p class="lead mb-4">Take the first step toward financial empowerment within the Daystar University community.</p>
					<div class="cta-buttons">
						<a href="<?php echo esc_url(home_url('/register/')); ?>" class="btn btn-light btn-lg me-3">Start Application Online</a>
						<a href="<?php echo esc_url(home_url('/downloads/daystar-sacco-membership-form/')); ?>" class="btn btn-outline-light btn-lg">Download Form</a>
					</div>
					<div class="contact-info mt-4">
						<p class="mb-1"><i class="fas fa-map-marker-alt"></i> Daystar University Campus, Athi River</p>
						<p class="mb-1"><i class="fas fa-phone"></i> +254 700 123 456</p>
						<p class="mb-0"><i class="fas fa-envelope"></i> membership@daystarcoopsacco.com</p>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<style>
.amount-display {
    font-size: 2rem;
    font-weight: bold;
    color: var(--daystar-navy);
    margin: 1rem 0;
}

.amount-display .currency {
    font-size: 1.2rem;
    vertical-align: top;
}

.amount-display .period {
    font-size: 1rem;
    color: var(--primary-blue);
    font-weight: normal;
}

.feature-highlight {
    background: var(--daystar-gold);
    color: var(--daystar-navy);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 1rem;
}

.payment-item {
    height: 100%;
    transition: transform 0.2s;
}

.payment-item:hover {
    transform: translateY(-2px);
}

.requirements-card {
    background: linear-gradient(135deg, #fff, #f8fafc);
}

.cta-buttons .btn {
    margin: 0.5rem;
}

.contact-info p {
    font-size: 1.1rem;
}

.contact-info i {
    margin-right: 0.5rem;
    color: var(--daystar-gold);
}
</style>

<?php
get_footer(); 
?>