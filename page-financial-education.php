<?php
/**
 * Template Name: Financial Education Page
 *
 * The template for displaying the Financial Education page.
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

	<section class="financial-education-intro py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="intro-content">
						<h2 class="mb-4">Empowering Financial Literacy</h2>
						<?php the_content(); ?>
						
						<?php if (!the_content()) : ?>
							<p class="lead">At our SACCO, we believe that financial education is the foundation of a successful financial future. Our financial literacy program is designed to equip our members with the knowledge and tools they need to make informed financial decisions.</p>
							<p>Whether you're looking to understand basic financial concepts, learn about savings and investments, or plan for major life events, our educational resources are here to help you every step of the way.</p>
						<?php endif; ?>
						
						<div class="mt-4">
							<a href="#workshops" class="btn btn-primary me-2 mb-2">Browse Workshops</a>
							<a href="#resources" class="btn btn-outline-primary mb-2">Explore Resources</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="intro-image">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
						</div>
					<?php else : ?>
						<div class="intro-image">
							<img src="<?php echo get_template_directory_uri(); ?>/img/financial-education-header.jpg" alt="Financial Education" class="img-fluid rounded shadow">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section id="topics" class="education-topics py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Financial Education Topics</h2>
					<p class="section-subtitle">Explore our comprehensive curriculum covering all aspects of personal finance</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-piggy-bank fa-2x"></i>
							</div>
							<h3 class="card-title h4">Budgeting Basics</h3>
							<p class="card-text">Learn how to create and maintain a budget that works for your lifestyle and financial goals.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Creating a practical budget</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Tracking expenses effectively</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Managing income and expenses</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Tools and apps for budgeting</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/budgeting-basics/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-chart-line fa-2x"></i>
							</div>
							<h3 class="card-title h4">Saving & Investing</h3>
							<p class="card-text">Discover strategies for growing your wealth through saving and investments suited to your risk tolerance.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Building emergency funds</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Introduction to investments</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Risk assessment and management</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Long-term wealth building</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/saving-investing/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-hand-holding-usd fa-2x"></i>
							</div>
							<h3 class="card-title h4">Debt Management</h3>
							<p class="card-text">Master techniques for managing debt effectively and developing a strategy to become debt-free.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Understanding good vs. bad debt</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Debt repayment strategies</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Credit score improvement</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Avoiding debt traps</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/debt-management/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-home fa-2x"></i>
							</div>
							<h3 class="card-title h4">Home Ownership</h3>
							<p class="card-text">Navigate the journey to home ownership, from saving for a deposit to understanding mortgage options.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Preparing to buy a home</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Understanding mortgage types</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Hidden costs of home ownership</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Property investment basics</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/home-ownership/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-graduation-cap fa-2x"></i>
							</div>
							<h3 class="card-title h4">Education Planning</h3>
							<p class="card-text">Plan and prepare financially for education costs for yourself or your children's future.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Estimating education costs</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Savings strategies for education</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Education loans and financing</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Scholarships and grants</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/education-planning/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="topic-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="topic-icon mb-3 text-primary">
								<i class="fas fa-heartbeat fa-2x"></i>
							</div>
							<h3 class="card-title h4">Retirement Planning</h3>
							<p class="card-text">Prepare for a secure and comfortable retirement with effective long-term financial planning strategies.</p>
							<ul class="feature-list mb-0">
								<li><i class="fas fa-check-circle text-primary me-2"></i> Retirement needs assessment</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Pension schemes and options</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Alternative retirement investments</li>
								<li><i class="fas fa-check-circle text-primary me-2"></i> Retirement income strategies</li>
							</ul>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/retirement-planning/')); ?>" class="btn btn-outline-primary w-100">Learn More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="workshops" class="workshops-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Financial Workshops & Seminars</h2>
					<p class="section-subtitle">Join our expert-led sessions to enhance your financial knowledge</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 mb-4">
					<div class="workshop-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between mb-3">
								<span class="badge bg-primary">Upcoming</span>
								<span class="workshop-date text-muted"><i class="far fa-calendar-alt me-1"></i> June 15, 2023</span>
							</div>
							<h3 class="card-title h4">Financial Wellness Workshop</h3>
							<p class="card-text">A comprehensive introduction to personal financial management covering budgeting, saving, and basic investment concepts.</p>
							<div class="workshop-details mb-3">
								<p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i> Main Branch, Nairobi</p>
								<p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> 9:00 AM - 12:00 PM</p>
								<p><i class="fas fa-user text-primary me-2"></i> Facilitator: John Doe, Financial Advisor</p>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/events/financial-wellness-workshop/')); ?>" class="btn btn-primary me-2">Register Now</a>
							<a href="<?php echo esc_url(home_url('/events/financial-wellness-workshop/')); ?>" class="btn btn-outline-primary">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 mb-4">
					<div class="workshop-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between mb-3">
								<span class="badge bg-primary">Upcoming</span>
								<span class="workshop-date text-muted"><i class="far fa-calendar-alt me-1"></i> June 22, 2023</span>
							</div>
							<h3 class="card-title h4">Investment Strategies for Beginners</h3>
							<p class="card-text">Learn about different investment options, understanding risk, and how to start building an investment portfolio.</p>
							<div class="workshop-details mb-3">
								<p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i> Westlands Branch, Nairobi</p>
								<p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> 2:00 PM - 5:00 PM</p>
								<p><i class="fas fa-user text-primary me-2"></i> Facilitator: Jane Smith, Investment Specialist</p>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/events/investment-strategies-workshop/')); ?>" class="btn btn-primary me-2">Register Now</a>
							<a href="<?php echo esc_url(home_url('/events/investment-strategies-workshop/')); ?>" class="btn btn-outline-primary">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 mb-4">
					<div class="workshop-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between mb-3">
								<span class="badge bg-secondary">Virtual</span>
								<span class="workshop-date text-muted"><i class="far fa-calendar-alt me-1"></i> June 29, 2023</span>
							</div>
							<h3 class="card-title h4">Home Buying Seminar</h3>
							<p class="card-text">Everything you need to know about preparing for home ownership, from saving for a deposit to understanding mortgage options.</p>
							<div class="workshop-details mb-3">
								<p class="mb-1"><i class="fas fa-laptop text-primary me-2"></i> Online Webinar</p>
								<p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> 6:00 PM - 8:00 PM</p>
								<p><i class="fas fa-user text-primary me-2"></i> Facilitator: Michael Johnson, Mortgage Specialist</p>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/events/home-buying-seminar/')); ?>" class="btn btn-primary me-2">Register Now</a>
							<a href="<?php echo esc_url(home_url('/events/home-buying-seminar/')); ?>" class="btn btn-outline-primary">Learn More</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 mb-4">
					<div class="workshop-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between mb-3">
								<span class="badge bg-secondary">Virtual</span>
								<span class="workshop-date text-muted"><i class="far fa-calendar-alt me-1"></i> July 6, 2023</span>
							</div>
							<h3 class="card-title h4">Retirement Planning Workshop</h3>
							<p class="card-text">Plan for a secure retirement by understanding pension schemes, retirement products, and long-term investment strategies.</p>
							<div class="workshop-details mb-3">
								<p class="mb-1"><i class="fas fa-laptop text-primary me-2"></i> Online Webinar</p>
								<p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> 10:00 AM - 12:00 PM</p>
								<p><i class="fas fa-user text-primary me-2"></i> Facilitator: Sarah Ngugi, Retirement Planning Expert</p>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/events/retirement-planning-workshop/')); ?>" class="btn btn-primary me-2">Register Now</a>
							<a href="<?php echo esc_url(home_url('/events/retirement-planning-workshop/')); ?>" class="btn btn-outline-primary">Learn More</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-4">
				<div class="col-12 text-center">
					<a href="<?php echo esc_url(home_url('/events/')); ?>" class="btn btn-primary">View All Workshops</a>
				</div>
			</div>
		</div>
	</section>

	<section id="resources" class="resources-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Educational Resources</h2>
					<p class="section-subtitle">Explore our library of financial literacy materials</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 mb-4">
					<div class="resources-card card h-100 border-0 shadow-sm">
						<div class="card-header bg-primary text-white py-3">
							<h3 class="card-title h5 mb-0">Articles & Guides</h3>
						</div>
						<div class="card-body p-4">
							<div class="resource-list">
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-file-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Budgeting 101: Getting Started</h4>
											<p class="small mb-0 text-muted">Learn the basics of creating a workable budget</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-file-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Emergency Fund Essentials</h4>
											<p class="small mb-0 text-muted">Why you need one and how to build it</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-file-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Understanding Credit Scores</h4>
											<p class="small mb-0 text-muted">How they work and why they matter</p>
										</div>
									</a>
								</div>
								<div class="resource-item">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-file-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Investment Options Explained</h4>
											<p class="small mb-0 text-muted">A guide for beginners</p>
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/articles/')); ?>" class="btn btn-outline-primary w-100">Browse All Articles</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 mb-4">
					<div class="resources-card card h-100 border-0 shadow-sm">
						<div class="card-header bg-primary text-white py-3">
							<h3 class="card-title h5 mb-0">Videos & Tutorials</h3>
						</div>
						<div class="card-body p-4">
							<div class="resource-list">
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-play-circle"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">How to Create a Monthly Budget</h4>
											<p class="small mb-0 text-muted">Step-by-step video guide (15 min)</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-play-circle"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Debt Reduction Strategies</h4>
											<p class="small mb-0 text-muted">Expert tips for paying down debt (20 min)</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-play-circle"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Saving for Your First Home</h4>
											<p class="small mb-0 text-muted">Financial planning tutorial (18 min)</p>
										</div>
									</a>
								</div>
								<div class="resource-item">
									<a href="#" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-play-circle"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Introduction to Investments</h4>
											<p class="small mb-0 text-muted">Understanding your options (22 min)</p>
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/videos/')); ?>" class="btn btn-outline-primary w-100">Watch All Videos</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 mb-4">
					<div class="resources-card card h-100 border-0 shadow-sm">
						<div class="card-header bg-primary text-white py-3">
							<h3 class="card-title h5 mb-0">Financial Tools & Calculators</h3>
						</div>
						<div class="card-body p-4">
							<div class="resource-list">
								<div class="resource-item mb-3">
									<a href="<?php echo esc_url(home_url('/calculators/budget-calculator/')); ?>" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-calculator"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Budget Calculator</h4>
											<p class="small mb-0 text-muted">Plan and track your monthly budget</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="<?php echo esc_url(home_url('/calculators/loan-calculator/')); ?>" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-calculator"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Loan Calculator</h4>
											<p class="small mb-0 text-muted">Estimate your loan payments</p>
										</div>
									</a>
								</div>
								<div class="resource-item mb-3">
									<a href="<?php echo esc_url(home_url('/calculators/savings-calculator/')); ?>" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-calculator"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Savings Goal Calculator</h4>
											<p class="small mb-0 text-muted">Plan for future financial needs</p>
										</div>
									</a>
								</div>
								<div class="resource-item">
									<a href="<?php echo esc_url(home_url('/calculators/retirement-calculator/')); ?>" class="d-flex text-decoration-none text-dark">
										<div class="resource-icon me-3 text-primary">
											<i class="fas fa-calculator"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Retirement Calculator</h4>
											<p class="small mb-0 text-muted">Estimate your retirement needs</p>
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="<?php echo esc_url(home_url('/financial-education/calculators/')); ?>" class="btn btn-outline-primary w-100">Access All Calculators</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="financial-coaches py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Meet Our Financial Coaches</h2>
					<p class="section-subtitle">Expert guidance from certified financial educators</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="coach-card card border-0 shadow-sm">
						<img src="<?php echo get_template_directory_uri(); ?>/img/coach1.jpg" class="card-img-top" alt="Financial Coach">
						<div class="card-body p-4 text-center">
							<h3 class="card-title h5">John Doe</h3>
							<p class="text-muted mb-3">Senior Financial Advisor</p>
							<p class="card-text mb-3">Specializes in budgeting, debt management, and personal finance basics.</p>
							<a href="<?php echo esc_url(home_url('/financial-education/coaches/john-doe/')); ?>" class="btn btn-sm btn-outline-primary">Meet John</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="coach-card card border-0 shadow-sm">
						<img src="<?php echo get_template_directory_uri(); ?>/img/coach2.jpg" class="card-img-top" alt="Financial Coach">
						<div class="card-body p-4 text-center">
							<h3 class="card-title h5">Jane Smith</h3>
							<p class="text-muted mb-3">Investment Specialist</p>
							<p class="card-text mb-3">Expert in investment strategies, retirement planning, and wealth building.</p>
							<a href="<?php echo esc_url(home_url('/financial-education/coaches/jane-smith/')); ?>" class="btn btn-sm btn-outline-primary">Meet Jane</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="coach-card card border-0 shadow-sm">
						<img src="<?php echo get_template_directory_uri(); ?>/img/coach3.jpg" class="card-img-top" alt="Financial Coach">
						<div class="card-body p-4 text-center">
							<h3 class="card-title h5">Michael Johnson</h3>
							<p class="text-muted mb-3">Mortgage & Housing Expert</p>
							<p class="card-text mb-3">Specializes in home buying, mortgages, and property investment.</p>
							<a href="<?php echo esc_url(home_url('/financial-education/coaches/michael-johnson/')); ?>" class="btn btn-sm btn-outline-primary">Meet Michael</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="coach-card card border-0 shadow-sm">
						<img src="<?php echo get_template_directory_uri(); ?>/img/coach4.jpg" class="card-img-top" alt="Financial Coach">
						<div class="card-body p-4 text-center">
							<h3 class="card-title h5">Sarah Ngugi</h3>
							<p class="text-muted mb-3">Retirement Planning Expert</p>
							<p class="card-text mb-3">Focuses on retirement savings, pension schemes, and long-term planning.</p>
							<a href="<?php echo esc_url(home_url('/financial-education/coaches/sarah-ngugi/')); ?>" class="btn btn-sm btn-outline-primary">Meet Sarah</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-4">
				<div class="col-12 text-center">
					<a href="<?php echo esc_url(home_url('/financial-education/book-consultation/')); ?>" class="btn btn-primary">Book a One-on-One Consultation</a>
				</div>
			</div>
		</div>
	</section>

	<section class="success-stories py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Success Stories</h2>
					<p class="section-subtitle">How financial education helped our members achieve their goals</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 mb-4">
					<div class="story-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex align-items-center mb-4">
								<div class="story-avatar me-3">
									<img src="<?php echo get_template_directory_uri(); ?>/img/testimonial1.jpg" class="rounded-circle" width="60" height="60" alt="Member">
								</div>
								<div>
									<h3 class="card-title h5 mb-1">Mary Wanjiku</h3>
									<p class="text-muted mb-0">SACCO Member for 5 years</p>
								</div>
							</div>
							<blockquote class="blockquote mb-0">
								<p>"After attending the budgeting workshop, I finally managed to create a working budget that allowed me to save consistently. Within two years, I saved enough for a down payment on my first home!"</p>
								<footer class="blockquote-footer mt-2">Attended Budgeting Basics Workshop</footer>
							</blockquote>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 mb-4">
					<div class="story-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex align-items-center mb-4">
								<div class="story-avatar me-3">
									<img src="<?php echo get_template_directory_uri(); ?>/img/testimonial2.jpg" class="rounded-circle" width="60" height="60" alt="Member">
								</div>
								<div>
									<h3 class="card-title h5 mb-1">David Mwangi</h3>
									<p class="text-muted mb-0">SACCO Member for 3 years</p>
								</div>
							</div>
							<blockquote class="blockquote mb-0">
								<p>"The debt management program helped me create a plan to become debt-free in just 18 months. Now I'm focusing on building my emergency fund and saving for my children's education."</p>
								<footer class="blockquote-footer mt-2">Participated in Debt Management Program</footer>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 text-center mt-4">
					<a href="<?php echo esc_url(home_url('/financial-education/success-stories/')); ?>" class="btn btn-outline-primary">Read More Success Stories</a>
				</div>
			</div>
		</div>
	</section>

	<section class="cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2 class="text-white">Ready to Improve Your Financial Knowledge?</h2>
					<p class="lead mb-0">Join our next workshop or browse our educational resources to start your journey toward financial wellness.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="#workshops" class="btn btn-light btn-lg me-2 mb-2 mb-lg-0">Register for a Workshop</a>
					<a href="<?php echo esc_url(home_url('/financial-education/newsletter/')); ?>" class="btn btn-outline-light btn-lg">Subscribe to Newsletter</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php get_footer(); ?> 