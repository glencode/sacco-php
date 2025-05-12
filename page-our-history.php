<?php
/**
 * Template Name: Our History Page
 *
 * The template for displaying the history of the SACCO.
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
	
	<section class="history-intro-section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="history-intro-content">
						<h2>Our Journey Through the Years</h2>
						<p class="lead">From humble beginnings to a leading financial institution serving thousands of members.</p>
						<div class="history-intro-text">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="history-intro-image">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
						<?php else : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/img/history-placeholder.jpg" alt="SACCO History" class="img-fluid rounded shadow">
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="history-timeline-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<h2 class="text-center mb-5">Our Timeline</h2>
					
					<div class="timeline">
						<!-- 1990s -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">1995</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>Foundation</h3>
									<p>Our SACCO was established with just 50 founding members who shared a vision of creating a cooperative financial institution to serve the community.</p>
									<?php if ( false ) : // Replace with actual condition to check for image ?>
										<img src="<?php echo get_template_directory_uri(); ?>/img/history-1995.jpg" alt="Foundation" class="img-fluid rounded mt-3">
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<!-- 2000s -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">2000</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>Growth Phase</h3>
									<p>Membership grew to over 500, and we expanded our service offerings to include various loan products and savings accounts tailored to our members' needs.</p>
								</div>
							</div>
						</div>
						
						<!-- 2005 -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">2005</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>First Office</h3>
									<p>We opened our first official office space, providing a dedicated location for member services and operations.</p>
									<?php if ( false ) : // Replace with actual condition to check for image ?>
										<img src="<?php echo get_template_directory_uri(); ?>/img/history-2005.jpg" alt="First Office" class="img-fluid rounded mt-3">
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<!-- 2010 -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">2010</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>Technology Adoption</h3>
									<p>Implemented our first computerized management system, allowing for more efficient operations and improved member service.</p>
								</div>
							</div>
						</div>
						
						<!-- 2015 -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">2015</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>SASRA Registration</h3>
									<p>Our SACCO received official registration from the SACCO Societies Regulatory Authority (SASRA), marking a significant milestone in our growth and compliance.</p>
									<?php if ( false ) : // Replace with actual condition to check for image ?>
										<img src="<?php echo get_template_directory_uri(); ?>/img/history-2015.jpg" alt="SASRA Registration" class="img-fluid rounded mt-3">
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<!-- 2018 -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">2018</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>Digital Transformation</h3>
									<p>Launched our mobile banking platform, giving members 24/7 access to their accounts and services from anywhere.</p>
								</div>
							</div>
						</div>
						
						<!-- Present -->
						<div class="timeline-item">
							<div class="timeline-dot"></div>
							<div class="timeline-date">Today</div>
							<div class="timeline-content card border-0 shadow-sm">
								<div class="card-body">
									<h3>Serving Thousands</h3>
									<p>Today, our SACCO serves over 10,000 members with a diverse range of financial products and services designed to meet evolving needs while maintaining our core cooperative values.</p>
									<?php if ( false ) : // Replace with actual condition to check for image ?>
										<img src="<?php echo get_template_directory_uri(); ?>/img/history-today.jpg" alt="Present Day" class="img-fluid rounded mt-3">
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; ?>
	
	<section class="history-milestones-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2>Key Achievements</h2>
					<p class="lead">Throughout our journey, we have achieved significant milestones that demonstrate our commitment to member service and financial excellence.</p>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-4">
					<div class="card milestone-card h-100 border-0 shadow-sm">
						<div class="card-body text-center p-4">
							<div class="milestone-icon mb-3">
								<i class="fas fa-award fa-3x text-primary"></i>
							</div>
							<h3>Best SACCO Award 2018</h3>
							<p>Recognized for excellence in member service and financial management at the annual SACCO leaders conference.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card milestone-card h-100 border-0 shadow-sm">
						<div class="card-body text-center p-4">
							<div class="milestone-icon mb-3">
								<i class="fas fa-users fa-3x text-primary"></i>
							</div>
							<h3>10,000+ Members</h3>
							<p>Reached the milestone of serving over ten thousand members across diverse demographics and sectors.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card milestone-card h-100 border-0 shadow-sm">
						<div class="card-body text-center p-4">
							<div class="milestone-icon mb-3">
								<i class="fas fa-hand-holding-usd fa-3x text-primary"></i>
							</div>
							<h3>1 Billion Asset Base</h3>
							<p>Achieved a significant financial milestone, demonstrating our stability and growth trajectory.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="history-founder-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="card founder-card border-0 shadow-sm">
						<div class="card-body p-0">
							<div class="row g-0">
								<div class="col-md-4">
									<img src="<?php echo get_template_directory_uri(); ?>/img/founder-placeholder.jpg" class="img-fluid founder-image rounded-start h-100 object-fit-cover" alt="Founding Chairperson">
								</div>
								<div class="col-md-8">
									<div class="p-4">
										<h3>From Our Founding Chairperson</h3>
										<div class="founder-quote mt-3">
											<blockquote class="blockquote">
												<p>"When we started this journey in 1995, we had a simple vision: to create a financial community where members support each other's growth. Today, seeing thousands of lives improved through our cooperative efforts brings immense joy and fulfillment. Our success is measured not by profits alone, but by the positive impact we've made in our members' lives."</p>
											</blockquote>
											<figcaption class="blockquote-footer mt-2">
												John Githongo, <cite title="Founding Chairperson">Founding Chairperson</cite>
											</figcaption>
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
	
	<section class="history-cta-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<h2>Be Part of Our Future</h2>
					<p class="lead mb-4">As we continue to write our story, we invite you to be part of our journey. Join our SACCO today and help us shape the next chapter of our history.</p>
					<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-primary me-2">Join Today</a>
					<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="btn btn-outline-primary">Learn More About Us</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<style>
/* Timeline Styling */
.timeline {
	position: relative;
	padding: 2rem 0;
}

.timeline::before {
	content: '';
	position: absolute;
	width: 4px;
	background: var(--bs-primary);
	top: 0;
	bottom: 0;
	left: 50%;
	transform: translateX(-50%);
}

.timeline-item {
	position: relative;
	margin-bottom: 3rem;
}

.timeline-dot {
	position: absolute;
	width: 20px;
	height: 20px;
	background: var(--bs-primary);
	border-radius: 50%;
	left: 50%;
	top: 10px;
	transform: translateX(-50%);
	z-index: 1;
}

.timeline-date {
	position: absolute;
	top: 0;
	left: 50%;
	transform: translateX(-160px);
	width: 120px;
	text-align: right;
	font-weight: bold;
	color: var(--bs-primary);
	font-size: 1.2rem;
}

.timeline-content {
	position: relative;
	width: calc(50% - 40px);
	margin-left: calc(50% + 40px);
}

.timeline-item:nth-child(even) .timeline-content {
	margin-left: 0;
	margin-right: calc(50% + 40px);
}

.timeline-item:nth-child(even) .timeline-date {
	left: 50%;
	transform: translateX(40px);
	text-align: left;
}

@media (max-width: 768px) {
	.timeline::before {
		left: 30px;
	}
	
	.timeline-dot {
		left: 30px;
	}
	
	.timeline-date {
		left: 0;
		top: -30px;
		transform: none;
		text-align: left;
	}
	
	.timeline-content,
	.timeline-item:nth-child(even) .timeline-content {
		width: calc(100% - 80px);
		margin-left: 80px;
		margin-right: 0;
	}
	
	.timeline-item:nth-child(even) .timeline-date {
		left: 0;
		transform: none;
	}
}
</style>

<?php
get_footer(); 
?> 