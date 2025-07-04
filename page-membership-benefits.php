<?php
/**
 * Template Name: Membership Benefits Page
 *
 * The template for displaying the benefits of SACCO membership.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<style>
:root {
    --primary-dark: #213448;
    --primary-blue: #547792;
    --primary-light: #94b4c1;
    --accent-yellow: #ecefca;
}
body, .site-main {
    background: var(--accent-yellow);
    color: var(--primary-dark);
}

/* Parallax Section */
.parallax-bg {
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
}
.page-header.bg-light.parallax-bg {
    background-image: linear-gradient(rgba(33,52,72,0.7), rgba(84,119,146,0.7)), url('<?php echo get_template_directory_uri(); ?>/img/benefits-placeholder.jpg');
    color: #fff;
}

.section-title, .page-title {
    color: var(--primary-dark);
    font-weight: 700;
    letter-spacing: 1px;
}
.section-subtitle {
    color: var(--primary-blue);
}

/* Card Styles */
.benefit-card, .testimonial-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(33,52,72,0.08);
    border: 1px solid var(--primary-light);
    transition: transform 0.2s, box-shadow 0.2s;
}
.benefit-card:hover, .testimonial-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 8px 32px rgba(33,52,72,0.16);
}
.benefit-icon {
    color: var(--primary-blue);
    background: var(--accent-yellow);
    border-radius: 50%;
    padding: 16px;
    display: inline-block;
}

/* Button Styles */
.btn-primary, .btn-light, .btn-lg, .btn-gradient {
    background: linear-gradient(90deg, var(--primary-blue), var(--primary-dark));
    color: #fff !important;
    border: none;
    border-radius: 30px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(33,52,72,0.10);
}
.btn-primary:hover, .btn-light:hover, .btn-gradient:hover {
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-blue));
    color: #ecefca !important;
    transform: translateY(-2px) scale(1.04);
}

/* Table Styles */
.comparison-table {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(33,52,72,0.08);
}
.comparison-table th, .comparison-table td {
    padding: 1rem;
    vertical-align: middle;
}
.comparison-table thead {
    background: var(--primary-blue);
    color: #fff;
}
.comparison-table tbody tr:nth-child(even) {
    background: var(--accent-yellow);
}

/* Parallax fix for mobile */
@media (max-width: 991px) {
    .parallax-bg {
        background-attachment: scroll;
    }
}
</style>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5 parallax-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
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
						<h2>Why Join Our SACCO?</h2>
						<p class="lead">Our members enjoy a wide range of financial and social benefits that help them achieve their goals and secure their future.</p>
						<?php the_content(); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="benefits-intro-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
						<?php else : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/img/benefits-placeholder.jpg" alt="SACCO Benefits" class="img-fluid rounded shadow">
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="key-benefits-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">Key Membership Benefits</h2>
					<p class="section-subtitle">Being a member of our SACCO offers these exclusive advantages</p>
				</div>
			</div>
			
			<div class="row g-4">
				<!-- Financial Benefits -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-money-bill-wave fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Financial Benefits</h3>
							<ul class="benefit-list">
								<li>Competitive interest rates on loans (lower than commercial banks)</li>
								<li>Higher returns on savings and deposits</li>
								<li>Annual dividends on share capital</li>
								<li>Lower transaction fees compared to traditional banking</li>
								<li>Flexible repayment options tailored to your financial situation</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Access to Credit -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-hand-holding-usd fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Access to Credit</h3>
							<ul class="benefit-list">
								<li>Multiple loan products designed for different needs</li>
								<li>Faster loan processing and approval compared to banks</li>
								<li>Loan eligibility based on savings rather than credit history</li>
								<li>Emergency loans available for urgent financial needs</li>
								<li>Business and development loans to support your growth</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Financial Education -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-graduation-cap fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Financial Education</h3>
							<ul class="benefit-list">
								<li>Regular financial literacy workshops and seminars</li>
								<li>Investment advisory services</li>
								<li>Retirement planning assistance</li>
								<li>Personal finance management training</li>
								<li>Business development and entrepreneurship mentoring</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Convenience & Technology -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-mobile-alt fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Convenience & Technology</h3>
							<ul class="benefit-list">
								<li>24/7 access to accounts through our secure online portal</li>
								<li>Mobile banking app for account management on the go</li>
								<li>Digital loan applications and approvals</li>
								<li>SMS notifications for account activities</li>
								<li>Electronic funds transfer and bill payment services</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Community & Network -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-users fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Community & Network</h3>
							<ul class="benefit-list">
								<li>Networking opportunities with other members</li>
								<li>Business referrals within the SACCO community</li>
								<li>Participation in community development initiatives</li>
								<li>Access to member-exclusive events and gatherings</li>
								<li>Shared knowledge and resources among members</li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- Ownership & Governance -->
				<div class="col-md-6">
					<div class="card benefit-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="benefit-icon mb-3 text-center">
								<i class="fas fa-vote-yea fa-3x text-primary"></i>
							</div>
							<h3 class="card-title text-center">Ownership & Governance</h3>
							<ul class="benefit-list">
								<li>Democratic control through "one member, one vote" principle</li>
								<li>Eligibility to stand for election to the Board of Directors</li>
								<li>Participation in Annual General Meetings</li>
								<li>Ability to influence SACCO policies and direction</li>
								<li>Transparency in all SACCO operations and financial reporting</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endwhile; ?>

	<section class="member-testimonials-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">What Our Members Say</h2>
					<p class="section-subtitle">Real experiences from our SACCO members</p>
				</div>
			</div>
			
			<div class="row g-4">
				<!-- Testimonial 1 -->
				<div class="col-md-6 col-lg-4">
					<div class="card testimonial-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="testimonial-quote mb-3">
								<i class="fas fa-quote-left fa-2x text-primary opacity-50"></i>
							</div>
							<p class="testimonial-text mb-4">Joining this SACCO was one of the best financial decisions I've made. I was able to secure a home development loan with favorable terms that no bank would offer me. The process was straightforward, and the staff were incredibly helpful throughout.</p>
							<div class="testimonial-author d-flex align-items-center">
								<div class="testimonial-avatar me-3">
									<img src="<?php echo get_template_directory_uri(); ?>/img/testimonial-placeholder.jpg" alt="Member" class="rounded-circle" width="60" height="60">
								</div>
								<div class="testimonial-info">
									<h4 class="h5 mb-1">James Mwangi</h4>
									<p class="mb-0 text-muted small">Member since 2015</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Testimonial 2 -->
				<div class="col-md-6 col-lg-4">
					<div class="card testimonial-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="testimonial-quote mb-3">
								<i class="fas fa-quote-left fa-2x text-primary opacity-50"></i>
							</div>
							<p class="testimonial-text mb-4">As a small business owner, the financial education workshops provided by the SACCO have been invaluable. They helped me improve my business management practices, and I was able to grow my enterprise with a business loan that had much better terms than commercial options.</p>
							<div class="testimonial-author d-flex align-items-center">
								<div class="testimonial-avatar me-3">
									<img src="<?php echo get_template_directory_uri(); ?>/img/testimonial-placeholder.jpg" alt="Member" class="rounded-circle" width="60" height="60">
								</div>
								<div class="testimonial-info">
									<h4 class="h5 mb-1">Grace Achieng</h4>
									<p class="mb-0 text-muted small">Member since 2018</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Testimonial 3 -->
				<div class="col-md-6 col-lg-4">
					<div class="card testimonial-card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="testimonial-quote mb-3">
								<i class="fas fa-quote-left fa-2x text-primary opacity-50"></i>
							</div>
							<p class="testimonial-text mb-4">I've been a member for over 10 years and have seen my savings grow significantly through the competitive interest rates and annual dividends. The mobile app makes managing my finances convenient, and I appreciate how transparent the SACCO is with its operations.</p>
							<div class="testimonial-author d-flex align-items-center">
								<div class="testimonial-avatar me-3">
									<img src="<?php echo get_template_directory_uri(); ?>/img/testimonial-placeholder.jpg" alt="Member" class="rounded-circle" width="60" height="60">
								</div>
								<div class="testimonial-info">
									<h4 class="h5 mb-1">Peter Kariuki</h4>
									<p class="mb-0 text-muted small">Member since 2010</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="benefits-comparison-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title">SACCO vs. Traditional Banking</h2>
					<p class="section-subtitle">See how our SACCO compares to conventional banking options</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="table-responsive">
						<table class="table comparison-table bg-white border">
							<thead class="bg-primary text-white">
								<tr>
									<th scope="col" class="feature-column">Feature</th>
									<th scope="col" class="text-center">Our SACCO</th>
									<th scope="col" class="text-center">Traditional Banks</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Loan Interest Rates</th>
									<td class="text-center text-success">Lower (10-14% p.a.)</td>
									<td class="text-center">Higher (14-24% p.a.)</td>
								</tr>
								<tr>
									<th scope="row">Savings Returns</th>
									<td class="text-center text-success">Higher (6-10% p.a.)</td>
									<td class="text-center">Lower (1-5% p.a.)</td>
								</tr>
								<tr>
									<th scope="row">Loan Processing Time</th>
									<td class="text-center text-success">Faster (1-5 days)</td>
									<td class="text-center">Longer (7+ days)</td>
								</tr>
								<tr>
									<th scope="row">Transaction Fees</th>
									<td class="text-center text-success">Minimal</td>
									<td class="text-center">Multiple fees</td>
								</tr>
								<tr>
									<th scope="row">Customer Service</th>
									<td class="text-center text-success">Personalized</td>
									<td class="text-center">Standardized</td>
								</tr>
								<tr>
									<th scope="row">Ownership</th>
									<td class="text-center text-success">Member-owned cooperative</td>
									<td class="text-center">Shareholder-owned company</td>
								</tr>
								<tr>
									<th scope="row">Profit Distribution</th>
									<td class="text-center text-success">Returns to members as dividends</td>
									<td class="text-center">Returns to external shareholders</td>
								</tr>
								<tr>
									<th scope="row">Governance</th>
									<td class="text-center text-success">Democratic (one member, one vote)</td>
									<td class="text-center">Based on share ownership</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="benefits-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8">
					<h2 class="text-white mb-3">Ready to Experience These Benefits?</h2>
					<p class="lead mb-lg-0">Join our growing community of members and start enjoying the financial advantages today.</p>
				</div>
				<div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
					<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-light btn-lg">Become a Member</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?>