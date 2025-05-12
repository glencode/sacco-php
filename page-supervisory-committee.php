<?php
/**
 * Template Name: Supervisory Committee Page
 *
 * The template for displaying the Supervisory Committee.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5">
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
	
	<section class="supervisory-intro-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="supervisory-intro mb-5">
						<?php the_content(); ?>
						
						<div class="supervisory-role-card card border-0 shadow-sm p-4 mb-5">
							<h3 class="text-center mb-4">Role of the Supervisory Committee</h3>
							<div class="row">
								<div class="col-md-6">
									<ul class="mb-0">
										<li>Overseeing and evaluating the SACCO's financial operations</li>
										<li>Ensuring compliance with all relevant laws, regulations, and internal policies</li>
										<li>Reviewing internal controls and risk management procedures</li>
										<li>Monitoring the accuracy of financial records and reports</li>
									</ul>
								</div>
								<div class="col-md-6">
									<ul class="mb-0">
										<li>Conducting or coordinating regular audits of SACCO operations</li>
										<li>Investigating any complaints or irregularities</li>
										<li>Reporting findings and recommendations to the Board of Directors</li>
										<li>Ensuring transparency in all SACCO activities</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="committee-members-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<h2 class="text-center mb-5">Meet Our Supervisory Committee</h2>
					
					<!-- Committee Chairperson -->
					<div class="card committee-member-card mb-5 border-0 shadow-sm">
						<div class="row g-0">
							<div class="col-md-4">
								<img src="<?php echo get_template_directory_uri(); ?>/img/team-placeholder.jpg" class="img-fluid rounded-start h-100 object-fit-cover" alt="Committee Chairperson">
							</div>
							<div class="col-md-8">
								<div class="card-body p-4">
									<h3 class="card-title">Thomas Mwangi</h3>
									<h4 class="card-subtitle mb-2 text-primary">Committee Chairperson</h4>
									<p class="card-text mb-4">Thomas has extensive experience in financial oversight and audit processes. He leads the committee with a focus on maintaining the highest standards of financial integrity and member protection.</p>
									<div class="qualification-list">
										<h5 class="mb-3">Qualifications:</h5>
										<ul>
											<li>Certified Public Accountant (CPA)</li>
											<li>Master's in Audit and Compliance</li>
											<li>15 years experience in financial oversight</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row g-4">
						<!-- Committee Member 1 -->
						<div class="col-md-6 mb-4">
							<div class="card committee-member-card h-100 border-0 shadow-sm">
								<div class="row g-0 h-100">
									<div class="col-lg-5">
										<img src="<?php echo get_template_directory_uri(); ?>/img/team-placeholder.jpg" class="img-fluid rounded-start h-100 object-fit-cover" alt="Committee Member">
									</div>
									<div class="col-lg-7">
										<div class="card-body p-3">
											<h4 class="card-title">Alice Njeri</h4>
											<h5 class="card-subtitle mb-2 text-primary">Committee Secretary</h5>
											<p class="card-text">Alice has a background in risk management and ensures meticulous documentation of all committee activities and findings.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Committee Member 2 -->
						<div class="col-md-6 mb-4">
							<div class="card committee-member-card h-100 border-0 shadow-sm">
								<div class="row g-0 h-100">
									<div class="col-lg-5">
										<img src="<?php echo get_template_directory_uri(); ?>/img/team-placeholder.jpg" class="img-fluid rounded-start h-100 object-fit-cover" alt="Committee Member">
									</div>
									<div class="col-lg-7">
										<div class="card-body p-3">
											<h4 class="card-title">Daniel Ochieng</h4>
											<h5 class="card-subtitle mb-2 text-primary">Member</h5>
											<p class="card-text">Daniel specializes in internal controls and compliance, bringing his expertise to strengthen the SACCO's governance framework.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Committee Member 3 -->
						<div class="col-md-6 mb-4">
							<div class="card committee-member-card h-100 border-0 shadow-sm">
								<div class="row g-0 h-100">
									<div class="col-lg-5">
										<img src="<?php echo get_template_directory_uri(); ?>/img/team-placeholder.jpg" class="img-fluid rounded-start h-100 object-fit-cover" alt="Committee Member">
									</div>
									<div class="col-lg-7">
										<div class="card-body p-3">
											<h4 class="card-title">Esther Wambui</h4>
											<h5 class="card-subtitle mb-2 text-primary">Member</h5>
											<p class="card-text">Esther has a background in legal compliance and helps ensure all SACCO activities comply with regulatory requirements.</p>
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
	
	<section class="committee-work-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<h2 class="text-center mb-4">Our Work Process</h2>
					<p class="text-center mb-5">The Supervisory Committee operates independently to ensure the financial stability and integrity of the SACCO's operations. Here's how we work:</p>
					
					<div class="row">
						<div class="col-md-4 mb-4">
							<div class="work-step card border-0 shadow-sm h-100">
								<div class="card-body text-center p-4">
									<div class="step-icon mb-3">
										<i class="fas fa-search fa-2x text-primary"></i>
									</div>
									<h3>Regular Audits</h3>
									<p class="mb-0">We conduct quarterly audits of the SACCO's financial records, transactions, and operations to ensure accuracy and compliance.</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-4">
							<div class="work-step card border-0 shadow-sm h-100">
								<div class="card-body text-center p-4">
									<div class="step-icon mb-3">
										<i class="fas fa-clipboard-check fa-2x text-primary"></i>
									</div>
									<h3>Compliance Review</h3>
									<p class="mb-0">We verify that all activities comply with SACCO by-laws, policies, and regulatory requirements to protect member interests.</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-4">
							<div class="work-step card border-0 shadow-sm h-100">
								<div class="card-body text-center p-4">
									<div class="step-icon mb-3">
										<i class="fas fa-file-alt fa-2x text-primary"></i>
									</div>
									<h3>Reporting</h3>
									<p class="mb-0">We present our findings and recommendations to the Board of Directors and members at the Annual General Meeting.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="committee-cta-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<h2 class="mb-4">Member Confidence Through Oversight</h2>
					<p class="lead mb-4">The Supervisory Committee works diligently to ensure your trust in our SACCO is well-placed. We maintain a direct line of communication with members to address any concerns.</p>
					<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-primary">Contact the Committee</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?> 