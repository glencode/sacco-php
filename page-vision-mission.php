<?php
/**
 * Template Name: Vision & Mission Page
 *
 * The template for displaying the organization's vision and mission.
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
	
	<section class="vision-mission-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="vision-mission-content">
						<?php the_content(); ?>
						
						<div class="vision-block my-5">
							<div class="vision-icon text-center mb-4">
								<i class="fas fa-eye fa-3x text-primary"></i>
							</div>
							<h2 class="text-center">Our Vision</h2>
							<div class="card vision-card border-0 shadow-sm p-4 mb-4">
								<p class="vision-text lead text-center">
									To be the leading SACCO providing innovative financial solutions that empower our members to achieve economic prosperity.
								</p>
							</div>
						</div>
						
						<div class="mission-block my-5">
							<div class="mission-icon text-center mb-4">
								<i class="fas fa-bullseye fa-3x text-primary"></i>
							</div>
							<h2 class="text-center">Our Mission</h2>
							<div class="card mission-card border-0 shadow-sm p-4 mb-4">
								<p class="mission-text lead text-center">
									To mobilize resources and provide quality financial services that meet our members' needs while promoting their economic and social welfare.
								</p>
							</div>
						</div>
						
						<div class="core-values-block my-5">
							<h2 class="text-center mb-4">Our Core Values</h2>
							<div class="row g-4">
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-handshake fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Integrity</h3>
											<p class="value-text">We uphold the highest ethical standards in all our dealings.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-users fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Teamwork</h3>
											<p class="value-text">We collaborate to achieve common goals and serve our members better.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-chart-line fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Innovation</h3>
											<p class="value-text">We embrace new ideas and technologies to improve our services.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-balance-scale fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Accountability</h3>
											<p class="value-text">We take responsibility for our actions and decisions.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-hands-helping fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Member-Centric</h3>
											<p class="value-text">Our members are at the center of everything we do.</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card value-card h-100 border-0 shadow-sm">
										<div class="card-body text-center">
											<div class="value-icon mb-3">
												<i class="fas fa-seedling fa-2x text-primary"></i>
											</div>
											<h3 class="value-title">Growth</h3>
											<p class="value-text">We are committed to sustainable growth for our members and organization.</p>
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
	
	<section class="about-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 col-md-7">
					<h2 class="cta-title">Join Our Community Today</h2>
					<p class="cta-text mb-0">Become a member and be part of our vision to promote economic prosperity.</p>
				</div>
				<div class="col-lg-4 col-md-5 text-md-end mt-3 mt-md-0">
					<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-light">Become a Member</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?> 