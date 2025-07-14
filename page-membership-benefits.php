<?php
/**
 * Template Name: Membership Benefits Page
 *
 * The template for displaying the benefits of Daystar Multi-Purpose Co-operative Society Ltd. membership.
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
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/membership-benefitsbg.jpg') no-repeat center center fixed !important;
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

/* Enhanced Section Content for Better Visibility */
.benefits-intro-content {
    background: rgba(0, 0, 0, 0.2);
    padding: 2rem;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.benefits-intro-content h2 {
    color: #fff;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.benefits-intro-content .lead {
    color: rgba(255, 255, 255, 0.95);
    font-weight: 500;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
    margin-bottom: 1.5rem;
}

.benefits-intro-content p {
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    line-height: 1.7;
}

/* Enhanced Card Styles - Very Light Transparent for Maximum Background Visibility */
.benefit-card, .testimonial-card, .loan-product-card {
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

.benefit-card:hover, .testimonial-card:hover, .loan-product-card:hover {
    transform: translateY(-8px);
    background: rgba(0, 0, 0, 0.15) !important;
    box-shadow: 0 15px 50px rgba(0, 105, 148, 0.15);
    border-color: rgba(32, 178, 170, 0.4);
}

/* Card Content Styling for Better Readability */
.benefit-card h3, .testimonial-card h3, .loan-product-card h3,
.benefit-card h4, .testimonial-card h4, .loan-product-card h4 {
    color: #fff;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6);
    font-weight: 700;
}

.benefit-card p, .testimonial-card p, .loan-product-card p,
.benefit-card ul, .testimonial-card ul, .loan-product-card ul,
.benefit-card li, .testimonial-card li, .loan-product-card li {
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

/* Enhanced Icons */
.benefit-icon {
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

.benefit-card:hover .benefit-icon {
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

/* Enhanced Loan Product Cards */
.loan-rate {
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
}

.loan-amount {
    color: var(--accent-gold);
    font-weight: bold;
    font-size: 1.2rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.benefit-highlight {
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

.btn-primary, .btn-light, .btn-lg, .btn-gradient {
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
    color: #fff;
    box-shadow: var(--shadow-medium);
}

.btn-primary:hover, .btn-light:hover, .btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 105, 148, 0.4);
    color: #fff;
}

/* Enhanced Table Styles */
.comparison-table {
    background: rgba(0, 0, 0, 0.1) !important;
    backdrop-filter: blur(8px);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.comparison-table thead {
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
    color: #fff;
}

.comparison-table th,
.comparison-table td {
    padding: 1.5rem 1rem;
    border: none;
    text-align: center;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.95);
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

.comparison-table tbody tr {
    transition: var(--transition-fast);
}

.comparison-table tbody tr:hover {
    background: rgba(32, 178, 170, 0.1);
    transform: scale(1.01);
}

.comparison-table tbody tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.02);
}

.daystar-advantage {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    font-weight: bold;
    padding: 0.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
}

/* Enhanced Testimonials */
.testimonial-quote {
    margin-bottom: 1.5rem;
}

.testimonial-quote i {
    color: var(--accent-gold);
    opacity: 0.5;
    filter: drop-shadow(0 2px 5px rgba(255, 215, 0, 0.3));
}

.testimonial-content {
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.testimonial-text {
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

.testimonial-avatar {
    width: 60px;
    height: 60px;
    background: var(--accent-gold);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue-dark);
    font-size: 1.5rem;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
}

.testimonial-info h5 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 0.25rem;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.testimonial-info p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin: 0;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}

/* Enhanced CTA Section */
.benefits-cta-section {
    background: var(--bg-hero);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    margin-top: 48px;
}

.benefits-cta-section::before {
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

.benefits-cta-section h2 {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.benefits-cta-section p {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
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
    
    .benefit-card, .testimonial-card, .loan-product-card {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .btn:last-child {
        margin-bottom: 0;
    }
    
    .testimonial-author {
        flex-direction: column;
        text-align: center;
    }
    
    .testimonial-avatar {
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
					<p class="lead">Discover the exclusive financial benefits designed specifically for the Daystar University community</p>
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
	
	<section class="benefits-intro-section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="benefits-intro-content">
						<h2>Why Join Daystar Multi-Purpose Co-operative Society?</h2>
						<p class="lead">As a member of the Daystar University community, you deserve financial services that understand your unique needs and circumstances.</p>
						<p>Our cooperative society is exclusively designed for Daystar University faculty, staff, and associated individuals, offering tailored financial solutions that support your academic career, family needs, and long-term financial goals.</p>
						<p><strong>Member-Owned:</strong> Unlike commercial banks, you own a share of our cooperative, giving you voting rights and a say in how we operate.</p>
						<?php the_content(); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="benefits-intro-image">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar-community-benefits.jpg" alt="Daystar SACCO Benefits" class="img-fluid rounded shadow">
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="loan-products-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Exclusive Loan Products for Daystar Community</h2>
					<p class="section-subtitle">Specially designed financial solutions for university staff and faculty</p>
				</div>
			</div>
			
			<div class="row g-4">
				<!-- School Fees Loans -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-graduation-cap fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">School Fees Loans</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">10%</div>
							<small>Annual Interest Rate</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Up to KSh 500,000</span></li>
							<li><i class="fas fa-check text-success"></i> 24-month repayment period</li>
							<li><i class="fas fa-check text-success"></i> Quick 3-7 day processing</li>
							<li><i class="fas fa-check text-success"></i> Minimal documentation</li>
							<li><i class="fas fa-check text-success"></i> School invoice required</li>
						</ul>
						<div class="benefit-highlight">Perfect for Children's Education</div>
					</div>
				</div>
				
				<!-- Special Loans -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-user-tie fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">Special Loan Privileges</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">5%</div>
							<small>Monthly Interest Rate</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Extended 48-month terms</span></li>
							<li><i class="fas fa-check text-success"></i> Higher loan limits</li>
							<li><i class="fas fa-check text-success"></i> Preferential processing</li>
							<li><i class="fas fa-check text-success"></i> Payroll deduction option</li>
							<li><i class="fas fa-check text-success"></i> Committee approval flexibility</li>
						</ul>
						<div class="benefit-highlight">Exclusive for Permanent Staff</div>
					</div>
				</div>
				
				<!-- Emergency Loans -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-heartbeat fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">Emergency Loans</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">15%</div>
							<small>Annual Interest Rate</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Up to KSh 200,000</span></li>
							<li><i class="fas fa-check text-success"></i> Same-day processing</li>
							<li><i class="fas fa-check text-success"></i> 12-month repayment</li>
							<li><i class="fas fa-check text-success"></i> Medical emergencies</li>
							<li><i class="fas fa-check text-success"></i> Family urgent needs</li>
						</ul>
						<div class="benefit-highlight">When You Need It Most</div>
					</div>
				</div>
				
				<!-- Development Loans -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-home fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">Development Loans</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">12%</div>
							<small>Annual Interest Rate</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Up to KSh 2,000,000</span></li>
							<li><i class="fas fa-check text-success"></i> 36-month repayment</li>
							<li><i class="fas fa-check text-success"></i> Home construction</li>
							<li><i class="fas fa-check text-success"></i> Business ventures</li>
							<li><i class="fas fa-check text-success"></i> Project proposal required</li>
						</ul>
						<div class="benefit-highlight">Build Your Future</div>
					</div>
				</div>
				
				<!-- Salary Advance -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-money-bill-wave fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">Salary Advance</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">10%</div>
							<small>One-time Fee</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Up to KSh 100,000</span></li>
							<li><i class="fas fa-check text-success"></i> Same-day processing</li>
							<li><i class="fas fa-check text-success"></i> 30-day repayment</li>
							<li><i class="fas fa-check text-success"></i> Staff members only</li>
							<li><i class="fas fa-check text-success"></i> Payslip required</li>
						</ul>
						<div class="benefit-highlight">Quick Cash Solution</div>
					</div>
				</div>
				
				<!-- Super Saver Loans -->
				<div class="col-md-6 col-lg-4">
					<div class="loan-product-card">
						<div class="text-center mb-3">
							<i class="fas fa-piggy-bank fa-3x" style="color: var(--daystar-navy);"></i>
						</div>
						<h4 class="text-center">Super Saver Loans</h4>
						<div class="text-center mb-3">
							<div class="loan-rate">8%</div>
							<small>Annual Interest Rate</small>
						</div>
						<ul class="list-unstyled">
							<li><i class="fas fa-check text-success"></i> <span class="loan-amount">Up to KSh 800,000</span></li>
							<li><i class="fas fa-check text-success"></i> 60-month repayment</li>
							<li><i class="fas fa-check text-success"></i> Lowest interest rates</li>
							<li><i class="fas fa-check text-success"></i> 24+ months membership</li>
							<li><i class="fas fa-check text-success"></i> Consistent savers</li>
						</ul>
						<div class="benefit-highlight">Reward for Loyalty</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="key-benefits-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Key Membership Benefits</h2>
					<p class="section-subtitle">Why Daystar SACCO is the right choice for university community</p>
				</div>
			</div>
			
			<div class="row g-4">
				<!-- Financial Benefits -->
				<div class="col-md-6">
					<div class="benefit-card">
						<div class="text-center mb-3">
							<div class="benefit-icon">
								<i class="fas fa-coins"></i>
							</div>
						</div>
						<h3 class="text-center">Superior Financial Returns</h3>
						<ul class="benefit-list">
							<li><strong>Annual Dividends:</strong> Competitive returns on your share capital based on cooperative performance</li>
							<li><strong>Lower Loan Rates:</strong> Interest rates 2-5% lower than traditional banks</li>
							<li><strong>No Hidden Fees:</strong> Transparent fee structure with minimal charges</li>
							<li><strong>Profit Sharing:</strong> As a member-owner, you share in the cooperative's success</li>
							<li><strong>Flexible Terms:</strong> Loan repayment schedules designed for university staff needs</li>
						</ul>
					</div>
				</div>
				
				<!-- University-Specific Benefits -->
				<div class="col-md-6">
					<div class="benefit-card">
						<div class="text-center mb-3">
							<div class="benefit-icon">
								<i class="fas fa-university"></i>
							</div>
						</div>
						<h3 class="text-center">University Community Focus</h3>
						<ul class="benefit-list">
							<li><strong>Academic Calendar Alignment:</strong> Loan schedules that understand university payment cycles</li>
							<li><strong>Education Support:</strong> Specialized school fees loans for faculty and staff children</li>
							<li><strong>Career Understanding:</strong> Financial products designed for academic professionals</li>
							<li><strong>Sabbatical Support:</strong> Flexible arrangements for faculty on sabbatical leave</li>
							<li><strong>Retirement Planning:</strong> Specialized savings products for university employees</li>
						</ul>
					</div>
				</div>
				
				<!-- Convenience & Technology -->
				<div class="col-md-6">
					<div class="benefit-card">
						<div class="text-center mb-3">
							<div class="benefit-icon">
								<i class="fas fa-mobile-alt"></i>
							</div>
						</div>
						<h3 class="text-center">Modern Banking Convenience</h3>
						<ul class="benefit-list">
							<li><strong>Online Banking:</strong> 24/7 access to your accounts through secure web portal</li>
							<!-- <li><strong>Mobile App:</strong> Manage finances on-the-go with our mobile application</li> -->
							<li><strong>Campus Accessibility:</strong> Convenient office location on Daystar University campus</li>
							<li><strong>Digital Loan Applications:</strong> Apply for loans online with quick processing</li>
							<li><strong>SMS Notifications:</strong> Real-time updates on account activities and loan status</li>
						</ul>
					</div>
				</div>
				
				<!-- Community & Governance -->
				<div class="col-md-6">
					<div class="benefit-card">
						<div class="text-center mb-3">
							<div class="benefit-icon">
								<i class="fas fa-users"></i>
							</div>
						</div>
						<h3 class="text-center">Democratic Ownership</h3>
						<ul class="benefit-list">
							<li><strong>Voting Rights:</strong> One member, one vote in all cooperative decisions</li>
							<li><strong>Board Eligibility:</strong> Opportunity to serve on the Board of Directors</li>
							<li><strong>Annual General Meetings:</strong> Participate in governance and policy decisions</li>
							<li><strong>Transparent Operations:</strong> Regular financial reports and open communication</li>
							<li><strong>Community Impact:</strong> Support fellow Daystar community members</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endwhile; ?>

	<!-- Enhanced Dynamic Testimonials Section -->
	<section class="section testimonials-section bg-light">
		<div class="container">
			<div class="text-center mb-5 fade-in">
				<h2 class="section-title">Member Testimonials</h2>
				<p class="section-subtitle">What our members say about our Membership Benefits</p>
			</div>
			
			<?php
			// Query testimonials from custom post type - Membership Benefits specific
			$testimonials_query = new WP_Query(array(
				'post_type' => 'testimonial',
				'posts_per_page' => 8,
				'post_status' => 'publish',
				'orderby' => 'rand', // Random order for variety
				'tax_query' => array(
					array(
						'taxonomy' => 'testimonial_category',
						'field' => 'slug',
						'terms' => array('membership-benefits'),
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
									<p>"Being a member of Daystar SACCO has transformed my financial life. The competitive rates, member ownership, and community focus make it the perfect choice for university staff."</p>
								</div>
								<div class="testimonial-author">
									<div class="testimonial-author-img">
										<div class="testimonial-avatar">
											<i class="fas fa-user"></i>
										</div>
									</div>
									<div class="testimonial-author-info">
										<h5>Dr. Sarah Kamau</h5>
										<p class="position">Faculty Member</p>
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
	
	<section class="benefits-comparison-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Daystar SACCO vs. Commercial Banks</h2>
					<p class="section-subtitle">See why our cooperative is the better choice for the Daystar community</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="table-responsive">
						<table class="table comparison-table">
							<thead>
								<tr>
									<th scope="col" class="feature-column">Feature</th>
									<th scope="col" class="text-center">Daystar SACCO</th>
									<th scope="col" class="text-center">Commercial Banks</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">School Fees Loan Interest</th>
									<td class="text-center"><span class="daystar-advantage">10% p.a.</span></td>
									<td class="text-center">14-18% p.a.</td>
								</tr>
								<tr>
									<th scope="row">Emergency Loan Processing</th>
									<td class="text-center"><span class="daystar-advantage">Same Day</span></td>
									<td class="text-center">3-7 days</td>
								</tr>
								<tr>
									<th scope="row">Annual Dividends</th>
									<td class="text-center"><span class="daystar-advantage">Based on Performance</span></td>
									<td class="text-center">Not Applicable</td>
								</tr>
								<tr>
									<th scope="row">Loan Processing Fees</th>
									<td class="text-center"><span class="daystar-advantage">1.5-2.5%</span></td>
									<td class="text-center">3-5%</td>
								</tr>
								<tr>
									<th scope="row">Membership Requirements</th>
									<td class="text-center"><span class="daystar-advantage">Daystar Community Only</span></td>
									<td class="text-center">General Public</td>
								</tr>
								<tr>
									<th scope="row">Ownership Structure</th>
									<td class="text-center"><span class="daystar-advantage">Member-Owned Cooperative</span></td>
									<td class="text-center">Shareholder-Owned</td>
								</tr>
								<tr>
									<th scope="row">Profit Distribution</th>
									<td class="text-center"><span class="daystar-advantage">Annual Dividends to Members</span></td>
									<td class="text-center">Profits to External Shareholders</td>
								</tr>
								<tr>
									<th scope="row">Decision Making</th>
									<td class="text-center"><span class="daystar-advantage">Democratic (One Member, One Vote)</span></td>
									<td class="text-center">Based on Share Ownership</td>
								</tr>
								<tr>
									<th scope="row">Community Focus</th>
									<td class="text-center"><span class="daystar-advantage">Daystar University Specific</span></td>
									<td class="text-center">General Market</td>
								</tr>
								<tr>
									<th scope="row">Staff Loan Privileges</th>
									<td class="text-center"><span class="daystar-advantage">Extended Terms (48 months)</span></td>
									<td class="text-center">Standard Terms Only</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="benefits-cta-section py-5" style="background: linear-gradient(90deg, var(--daystar-navy), var(--primary-blue)); color: white;">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8">
					<h2 class="text-white mb-3">Ready to Experience These Exclusive Benefits?</h2>
					<p class="lead mb-lg-0">Join the Daystar Multi-Purpose Co-operative Society and start enjoying financial services designed specifically for the university community.</p>
				</div>
				<div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
					<a href="<?php echo esc_url(home_url('/how-to-join/')); ?>" class="btn btn-light btn-lg">Become a Member</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?>