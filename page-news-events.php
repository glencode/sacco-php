<?php
/**
 * Template Name: News & Events Page
 *
 * The template for displaying news and upcoming events.
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

	<section class="news-events-intro py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<h2>Stay Updated with Our Latest News & Events</h2>
					<p class="lead mb-0">Keep up with the latest happenings at our SACCO, including announcements, achievements, and upcoming events.</p>
					<?php
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
					?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="news-events-tabs-section py-5 bg-light">
		<div class="container">
			<!-- Nav tabs -->
			<ul class="nav nav-pills nav-justified mb-5" id="newsEventsTabs" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="latest-news-tab" data-bs-toggle="tab" data-bs-target="#latest-news" type="button" role="tab" aria-controls="latest-news" aria-selected="true">
						<i class="fas fa-newspaper me-2"></i>Latest News
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="upcoming-events-tab" data-bs-toggle="tab" data-bs-target="#upcoming-events" type="button" role="tab" aria-controls="upcoming-events" aria-selected="false">
						<i class="fas fa-calendar-alt me-2"></i>Upcoming Events
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="photo-gallery-tab" data-bs-toggle="tab" data-bs-target="#photo-gallery" type="button" role="tab" aria-controls="photo-gallery" aria-selected="false">
						<i class="fas fa-images me-2"></i>Photo Gallery
					</button>
				</li>
			</ul>
			
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Latest News -->
				<div class="tab-pane fade show active" id="latest-news" role="tabpanel" aria-labelledby="latest-news-tab">
					<div class="row g-4">
						<!-- News Item 1 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-1.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> May 15, 2023</span>
										<span class="news-category badge bg-primary">Announcement</span>
									</div>
									<h3 class="card-title h4">Annual General Meeting Results</h3>
									<p class="card-text">We are pleased to announce the results of our 2023 Annual General Meeting, where members approved a 10% dividend on shares and 6% interest on deposits.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
						
						<!-- News Item 2 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-2.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> Apr 28, 2023</span>
										<span class="news-category badge bg-success">New Service</span>
									</div>
									<h3 class="card-title h4">Introducing Mobile Banking App</h3>
									<p class="card-text">We're excited to launch our new mobile banking application, giving members 24/7 access to their accounts, loan applications, and more from their smartphones.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
						
						<!-- News Item 3 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-3.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> Apr 10, 2023</span>
										<span class="news-category badge bg-info">Achievement</span>
									</div>
									<h3 class="card-title h4">SACCO Reaches 10,000 Members</h3>
									<p class="card-text">We are proud to announce that our SACCO has reached the milestone of 10,000 members, a testament to the trust and confidence placed in our financial services.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
						
						<!-- News Item 4 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-4.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> Mar 22, 2023</span>
										<span class="news-category badge bg-warning text-dark">Product Update</span>
									</div>
									<h3 class="card-title h4">New Education Loan Product</h3>
									<p class="card-text">In response to member feedback, we've launched an enhanced education loan product with lower interest rates and longer repayment periods for all levels of education.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
						
						<!-- News Item 5 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-5.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> Feb 14, 2023</span>
										<span class="news-category badge bg-danger">Notice</span>
									</div>
									<h3 class="card-title h4">Branch Office Relocation</h3>
									<p class="card-text">Our downtown branch office will be relocating to a larger, more accessible location at Capital Tower, 3rd Floor, Kimathi Street, effective March 1, 2023.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
						
						<!-- News Item 6 -->
						<div class="col-md-6 col-xl-4">
							<div class="card news-card h-100 border-0 shadow-sm">
								<img src="<?php echo get_template_directory_uri(); ?>/img/news-placeholder-6.jpg" class="card-img-top" alt="News Image">
								<div class="card-body">
									<div class="news-meta d-flex justify-content-between mb-2">
										<span class="news-date text-muted"><i class="far fa-calendar-alt me-1"></i> Jan 30, 2023</span>
										<span class="news-category badge bg-secondary">Community</span>
									</div>
									<h3 class="card-title h4">Community Development Initiative</h3>
									<p class="card-text">Our SACCO has partnered with local schools to provide financial literacy education to students and support educational infrastructure development in the community.</p>
									<a href="#" class="btn btn-outline-primary mt-2">Read More</a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Pagination -->
					<div class="row mt-5">
						<div class="col-12">
							<nav aria-label="News pagination">
								<ul class="pagination justify-content-center">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
									</li>
									<li class="page-item active"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				
				<!-- Upcoming Events -->
				<div class="tab-pane fade" id="upcoming-events" role="tabpanel" aria-labelledby="upcoming-events-tab">
					<div class="row g-4">
						<!-- Event 1 -->
						<div class="col-md-6">
							<div class="card event-card border-0 shadow-sm">
								<div class="row g-0">
									<div class="col-md-4">
										<div class="event-date-box d-flex flex-column align-items-center justify-content-center h-100">
											<span class="event-month">JUN</span>
											<span class="event-day display-4 fw-bold">15</span>
											<span class="event-year">2023</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h3 class="card-title h4">Annual General Meeting 2023</h3>
											<p class="event-time mb-2"><i class="far fa-clock me-2"></i>9:00 AM - 1:00 PM</p>
											<p class="event-location mb-3"><i class="fas fa-map-marker-alt me-2"></i>Grand Ballroom, Hilton Hotel</p>
											<p class="card-text">Join us for our Annual General Meeting where we'll review our performance, announce dividends, and elect new board members.</p>
											<a href="#" class="btn btn-primary mt-2">Register to Attend</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Event 2 -->
						<div class="col-md-6">
							<div class="card event-card border-0 shadow-sm">
								<div class="row g-0">
									<div class="col-md-4">
										<div class="event-date-box d-flex flex-column align-items-center justify-content-center h-100">
											<span class="event-month">JUL</span>
											<span class="event-day display-4 fw-bold">08</span>
											<span class="event-year">2023</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h3 class="card-title h4">Financial Wellness Workshop</h3>
											<p class="event-time mb-2"><i class="far fa-clock me-2"></i>2:00 PM - 5:00 PM</p>
											<p class="event-location mb-3"><i class="fas fa-map-marker-alt me-2"></i>Training Center, SACCO Head Office</p>
											<p class="card-text">Learn strategies for effective budgeting, debt management, and investment planning from our financial experts.</p>
											<a href="#" class="btn btn-primary mt-2">Reserve a Seat</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Event 3 -->
						<div class="col-md-6">
							<div class="card event-card border-0 shadow-sm">
								<div class="row g-0">
									<div class="col-md-4">
										<div class="event-date-box d-flex flex-column align-items-center justify-content-center h-100">
											<span class="event-month">AUG</span>
											<span class="event-day display-4 fw-bold">22</span>
											<span class="event-year">2023</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h3 class="card-title h4">Business Development Seminar</h3>
											<p class="event-time mb-2"><i class="far fa-clock me-2"></i>9:00 AM - 4:00 PM</p>
											<p class="event-location mb-3"><i class="fas fa-map-marker-alt me-2"></i>Entrepreneurship Center, University of Nairobi</p>
											<p class="card-text">A comprehensive seminar for entrepreneurs focusing on business growth strategies, access to finance, and market expansion.</p>
											<a href="#" class="btn btn-primary mt-2">Register to Attend</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Event 4 -->
						<div class="col-md-6">
							<div class="card event-card border-0 shadow-sm">
								<div class="row g-0">
									<div class="col-md-4">
										<div class="event-date-box d-flex flex-column align-items-center justify-content-center h-100">
											<span class="event-month">SEP</span>
											<span class="event-day display-4 fw-bold">05</span>
											<span class="event-year">2023</span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h3 class="card-title h4">New Member Orientation</h3>
											<p class="event-time mb-2"><i class="far fa-clock me-2"></i>10:00 AM - 12:00 PM</p>
											<p class="event-location mb-3"><i class="fas fa-map-marker-alt me-2"></i>Conference Room, SACCO Head Office</p>
											<p class="card-text">An introduction to SACCO services and benefits for new members, including how to maximize your membership.</p>
											<a href="#" class="btn btn-primary mt-2">Reserve a Seat</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row mt-5">
						<div class="col-md-12 text-center">
							<p class="mb-4">Want to stay informed about our upcoming events?</p>
							<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscribeModal">
								<i class="far fa-envelope me-2"></i>Subscribe to Event Notifications
							</a>
						</div>
					</div>
				</div>
				
				<!-- Photo Gallery -->
				<div class="tab-pane fade" id="photo-gallery" role="tabpanel" aria-labelledby="photo-gallery-tab">
					<div class="row">
						<div class="col-md-12 mb-4">
							<h3 class="text-center mb-4">Recent Events Gallery</h3>
							<p class="text-center mb-5">Browse photos from our recent events and activities</p>
						</div>
					</div>
					
					<div class="row g-4">
						<!-- Gallery categories -->
						<div class="col-12 mb-4">
							<div class="gallery-filter text-center">
								<button class="btn btn-outline-primary active me-2 mb-2" data-filter="all">All</button>
								<button class="btn btn-outline-primary me-2 mb-2" data-filter="agm">Annual General Meeting</button>
								<button class="btn btn-outline-primary me-2 mb-2" data-filter="workshops">Workshops</button>
								<button class="btn btn-outline-primary me-2 mb-2" data-filter="community">Community Events</button>
								<button class="btn btn-outline-primary mb-2" data-filter="office">Office Events</button>
							</div>
						</div>
					</div>
					
					<div class="row g-4 gallery-container">
						<!-- Photo 1 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="agm">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-1.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-1.jpg" class="card-img-top gallery-img" alt="AGM Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">Annual General Meeting 2022</h4>
									<p class="card-text">Members gathering for the annual meeting at Hilton Hotel.</p>
								</div>
							</div>
						</div>
						
						<!-- Photo 2 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="workshops">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-2.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-2.jpg" class="card-img-top gallery-img" alt="Workshop Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">Financial Literacy Workshop</h4>
									<p class="card-text">Members participating in our financial education workshop.</p>
								</div>
							</div>
						</div>
						
						<!-- Photo 3 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="community">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-3.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-3.jpg" class="card-img-top gallery-img" alt="Community Event Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">Community Tree Planting</h4>
									<p class="card-text">SACCO members participating in environmental conservation efforts.</p>
								</div>
							</div>
						</div>
						
						<!-- Photo 4 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="office">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-4.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-4.jpg" class="card-img-top gallery-img" alt="Office Event Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">New Branch Opening</h4>
									<p class="card-text">Ribbon cutting ceremony at our new branch location.</p>
								</div>
							</div>
						</div>
						
						<!-- Photo 5 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="workshops">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-5.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-5.jpg" class="card-img-top gallery-img" alt="Workshop Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">Entrepreneurship Seminar</h4>
									<p class="card-text">Business development workshop for SACCO members.</p>
								</div>
							</div>
						</div>
						
						<!-- Photo 6 -->
						<div class="col-md-6 col-lg-4 gallery-item" data-category="community">
							<div class="card gallery-card border-0 shadow-sm">
								<a href="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-6.jpg" class="gallery-link">
									<img src="<?php echo get_template_directory_uri(); ?>/img/gallery-placeholder-6.jpg" class="card-img-top gallery-img" alt="Community Event Photo">
									<div class="gallery-overlay">
										<span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
									</div>
								</a>
								<div class="card-body">
									<h4 class="card-title h5">School Donation Drive</h4>
									<p class="card-text">SACCO members donating educational materials to local schools.</p>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Load More Button -->
					<div class="row mt-5">
						<div class="col-12 text-center">
							<button class="btn btn-primary">Load More Photos</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Newsletter Subscription -->
	<section class="newsletter-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-5 mb-4 mb-lg-0">
					<h2 class="text-white">Stay Updated</h2>
					<p class="lead mb-0">Subscribe to our newsletter to receive latest news and updates directly to your inbox.</p>
				</div>
				<div class="col-lg-7">
					<div class="newsletter-form">
						<form action="#" method="post" class="d-flex flex-column flex-md-row gap-md-2">
							<div class="form-group flex-grow-1 mb-3 mb-md-0">
								<input type="email" class="form-control form-control-lg" placeholder="Your Email Address" required>
							</div>
							<button type="submit" class="btn btn-light">Subscribe</button>
						</form>
						<small class="form-text text-white-50 mt-2">We respect your privacy and will never share your information.</small>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<!-- Subscribe Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="subscribeModalLabel">Subscribe to Event Notifications</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="#" method="post">
					<div class="mb-3">
						<label for="subscribeName" class="form-label">Full Name</label>
						<input type="text" class="form-control" id="subscribeName" placeholder="Enter your full name" required>
					</div>
					<div class="mb-3">
						<label for="subscribeEmail" class="form-label">Email Address</label>
						<input type="email" class="form-control" id="subscribeEmail" placeholder="Enter your email address" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Event Categories of Interest</label>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="allEvents" checked>
							<label class="form-check-label" for="allEvents">
								All Events
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="generalMeetings">
							<label class="form-check-label" for="generalMeetings">
								General Meetings
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="workshops">
							<label class="form-check-label" for="workshops">
								Workshops & Seminars
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="communityEvents">
							<label class="form-check-label" for="communityEvents">
								Community Events
							</label>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Subscribe</button>
			</div>
		</div>
	</div>
</div>

<style>
/* Event Date Box */
.event-date-box {
	background-color: var(--bs-primary);
	color: white;
	padding: 1rem;
	height: 100%;
}

.event-month, .event-year {
	font-size: 1.2rem;
	font-weight: 500;
}

.event-day {
	line-height: 1;
}

/* Gallery Styles */
.gallery-card {
	transition: all 0.3s ease;
	overflow: hidden;
}

.gallery-card:hover {
	transform: translateY(-5px);
}

.gallery-link {
	display: block;
	position: relative;
	overflow: hidden;
}

.gallery-img {
	transition: all 0.5s ease;
}

.gallery-overlay {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5);
	display: flex;
	align-items: center;
	justify-content: center;
	opacity: 0;
	transition: all 0.3s ease;
}

.gallery-icon {
	color: white;
	font-size: 2rem;
}

.gallery-link:hover .gallery-overlay {
	opacity: 1;
}

.gallery-link:hover .gallery-img {
	transform: scale(1.1);
}

.gallery-filter .btn {
	margin-right: 0.5rem;
	margin-bottom: 0.5rem;
}

/* News Card */
.news-card {
	transition: all 0.3s ease;
}

.news-card:hover {
	transform: translateY(-5px);
}

@media (max-width: 767.98px) {
	.event-date-box {
		padding: 0.5rem;
	}
	
	.event-month, .event-year {
		font-size: 1rem;
	}
	
	.event-day {
		font-size: 2rem;
	}
}
</style>

<?php
get_footer(); 
?> 