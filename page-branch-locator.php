<?php
/**
 * Template Name: Branch Locator Page
 *
 * The template for displaying the Branch Locator page.
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

	<section class="branch-locator-intro py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2 class="section-title">Find Our Branches & ATMs</h2>
					<p class="section-subtitle">Locate our branches and ATMs across the country for convenient access to our services</p>
					<?php the_content(); ?>
				</div>
			</div>
			
			<div class="row mb-5">
				<div class="col-md-6 offset-md-3">
					<div class="branch-search card border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="h5 mb-3">Search Branches</h3>
							<form id="branchSearchForm" class="branch-search-form">
								<div class="input-group mb-3">
									<input type="text" class="form-control" id="locationSearch" placeholder="Enter city, area or postal code">
									<button class="btn btn-primary" type="submit">
										<i class="fas fa-search"></i> Search
									</button>
								</div>
								<div class="mb-3">
									<label class="form-label">Filter by:</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" id="filterBranches" value="branches" checked>
										<label class="form-check-label" for="filterBranches">Branches</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" id="filterATMs" value="atms" checked>
										<label class="form-check-label" for="filterATMs">ATMs</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" id="filterAgents" value="agents">
										<label class="form-check-label" for="filterAgents">Agents</label>
									</div>
								</div>
								<div class="d-flex justify-content-between align-items-center">
									<button type="button" class="btn btn-sm btn-outline-primary" id="useMyLocation">
										<i class="fas fa-map-marker-alt"></i> Use My Location
									</button>
									<span class="small text-muted">or select from the map below</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="branch-map-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 mb-4 mb-lg-0">
					<div class="branch-list-container">
						<div class="d-flex justify-content-between mb-3">
							<h3 class="h5">Branch List</h3>
							<div class="branch-count">
								<span class="badge bg-primary" id="branchCount">6</span> Locations
							</div>
						</div>
						
						<div class="branch-list-wrapper overflow-auto" style="max-height: 600px;">
							<div class="branch-list" id="branchList">
								<!-- Branch Item 1 -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="1" data-branch-type="branch">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">Nairobi CBD Branch</h4>
											<span class="branch-type badge bg-primary">Branch</span>
										</div>
										<address class="branch-address mb-2 small">
											SACCO Towers, 3rd Floor<br>
											123 Kimathi Street<br>
											Nairobi
										</address>
										<div class="branch-contact mb-2 small">
											<p class="mb-1"><i class="fas fa-phone-alt me-1"></i> +254 700 123 456</p>
											<p class="mb-0"><i class="fas fa-envelope me-1"></i> nairobi@sacconame.co.ke</p>
										</div>
										<div class="branch-hours small mb-2">
											<p class="mb-1"><strong>Hours:</strong></p>
											<p class="mb-1">Mon-Fri: 8:00 AM - 5:00 PM</p>
											<p class="mb-0">Sat: 9:00 AM - 1:00 PM</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="1">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="1">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
								
								<!-- Branch Item 2 -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="2" data-branch-type="branch">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">Westlands Branch</h4>
											<span class="branch-type badge bg-primary">Branch</span>
										</div>
										<address class="branch-address mb-2 small">
											The Mall, Ground Floor<br>
											456 Waiyaki Way, Westlands<br>
											Nairobi
										</address>
										<div class="branch-contact mb-2 small">
											<p class="mb-1"><i class="fas fa-phone-alt me-1"></i> +254 700 234 567</p>
											<p class="mb-0"><i class="fas fa-envelope me-1"></i> westlands@sacconame.co.ke</p>
										</div>
										<div class="branch-hours small mb-2">
											<p class="mb-1"><strong>Hours:</strong></p>
											<p class="mb-1">Mon-Fri: 8:00 AM - 5:00 PM</p>
											<p class="mb-0">Sat: 9:00 AM - 1:00 PM</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="2">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="2">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
								
								<!-- Branch Item 3 -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="3" data-branch-type="branch">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">Mombasa Branch</h4>
											<span class="branch-type badge bg-primary">Branch</span>
										</div>
										<address class="branch-address mb-2 small">
											Ocean Plaza, 1st Floor<br>
											789 Moi Avenue<br>
											Mombasa
										</address>
										<div class="branch-contact mb-2 small">
											<p class="mb-1"><i class="fas fa-phone-alt me-1"></i> +254 700 345 678</p>
											<p class="mb-0"><i class="fas fa-envelope me-1"></i> mombasa@sacconame.co.ke</p>
										</div>
										<div class="branch-hours small mb-2">
											<p class="mb-1"><strong>Hours:</strong></p>
											<p class="mb-1">Mon-Fri: 8:00 AM - 5:00 PM</p>
											<p class="mb-0">Sat: 9:00 AM - 1:00 PM</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="3">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="3">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
								
								<!-- ATM Item 1 -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="4" data-branch-type="atm">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">CBD ATM</h4>
											<span class="branch-type badge bg-success">ATM</span>
										</div>
										<address class="branch-address mb-2 small">
											SACCO Towers, Ground Floor<br>
											123 Kimathi Street<br>
											Nairobi
										</address>
										<div class="branch-hours small mb-2">
											<p class="mb-0">Available 24/7</p>
										</div>
										<div class="branch-features small mb-2">
											<p class="mb-1"><strong>Features:</strong></p>
											<p class="mb-0">Cash Withdrawal, Balance Check, Mini Statement</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="4">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="4">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
								
								<!-- ATM Item 2 -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="5" data-branch-type="atm">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">Westlands ATM</h4>
											<span class="branch-type badge bg-success">ATM</span>
										</div>
										<address class="branch-address mb-2 small">
											The Mall, Ground Floor<br>
											456 Waiyaki Way, Westlands<br>
											Nairobi
										</address>
										<div class="branch-hours small mb-2">
											<p class="mb-0">Available 24/7</p>
										</div>
										<div class="branch-features small mb-2">
											<p class="mb-1"><strong>Features:</strong></p>
											<p class="mb-0">Cash Withdrawal, Balance Check, Mini Statement, Cash Deposit</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="5">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="5">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
								
								<!-- Agent Item -->
								<div class="branch-item card mb-3 border-0 shadow-sm" data-branch-id="6" data-branch-type="agent">
									<div class="card-body p-3">
										<div class="d-flex justify-content-between mb-2">
											<h4 class="branch-name h6 mb-0">City Center Agent</h4>
											<span class="branch-type badge bg-warning text-dark">Agent</span>
										</div>
										<address class="branch-address mb-2 small">
											Sunshine Plaza, Shop 5<br>
											Tom Mboya Street<br>
											Nairobi
										</address>
										<div class="branch-contact mb-2 small">
											<p class="mb-1"><i class="fas fa-phone-alt me-1"></i> +254 711 123 456</p>
										</div>
										<div class="branch-hours small mb-2">
											<p class="mb-1"><strong>Hours:</strong></p>
											<p class="mb-1">Mon-Sat: 8:00 AM - 6:00 PM</p>
											<p class="mb-0">Sun: 10:00 AM - 2:00 PM</p>
										</div>
										<div class="branch-features small mb-2">
											<p class="mb-1"><strong>Services:</strong></p>
											<p class="mb-0">Deposits, Withdrawals, Bills Payment</p>
										</div>
										<div class="branch-actions mt-3">
											<button class="btn btn-sm btn-outline-primary me-2 view-on-map" data-branch-id="6">
												<i class="fas fa-map-marker-alt me-1"></i> View on Map
											</button>
											<a href="#" class="btn btn-sm btn-outline-secondary branch-details-link" data-branch-id="6">
												<i class="fas fa-info-circle me-1"></i> Details
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-8">
					<div class="branch-map-container">
						<div class="branch-map rounded overflow-hidden shadow-sm" id="branchMap" style="height: 600px;">
							<!-- Google Maps will be loaded here -->
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63831.62209420057!2d36.78522543135071!3d-1.2860710573872278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi!5e0!3m2!1sen!2ske!4v1684850363190!5m2!1sen!2ske" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="branch-details-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Branch Information</h2>
					<p class="section-subtitle">Learn more about the facilities and services offered at our branches</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 mb-4">
					<div class="branch-services card h-100 border-0 shadow-sm">
						<div class="card-header bg-primary text-white py-3">
							<h3 class="card-title h5 mb-0">Branch Services</h3>
						</div>
						<div class="card-body p-4">
							<div class="row">
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-money-check-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Account Services</h4>
											<p class="small mb-0">Account opening, updates, and management</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-hand-holding-usd"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Loan Services</h4>
											<p class="small mb-0">Applications, disbursements, and repayments</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-piggy-bank"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Savings Services</h4>
											<p class="small mb-0">Deposits, withdrawals, and transfers</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-file-invoice"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Bill Payments</h4>
											<p class="small mb-0">Utilities, school fees, and more</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-exchange-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Money Transfer</h4>
											<p class="small mb-0">Local and international transfers</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-user-tie"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Financial Advisory</h4>
											<p class="small mb-0">Consultations and planning services</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-shield-alt"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Insurance Services</h4>
											<p class="small mb-0">Policy applications and claims</p>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="service-item d-flex align-items-center">
										<div class="service-icon me-3 text-primary">
											<i class="fas fa-id-card"></i>
										</div>
										<div>
											<h4 class="h6 mb-1">Membership Services</h4>
											<p class="small mb-0">Registration and updates</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 mb-4">
					<div class="branch-facilities card h-100 border-0 shadow-sm">
						<div class="card-header bg-primary text-white py-3">
							<h3 class="card-title h5 mb-0">Branch Facilities</h3>
						</div>
						<div class="card-body p-4">
							<div class="row">
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-wifi"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Free Wi-Fi</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-parking"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Parking Available</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-wheelchair"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Wheelchair Accessible</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-laptop"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Digital Service Kiosks</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-credit-card"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">ATM Services</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-child"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Children's Play Area</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-mug-hot"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Coffee/Tea Station</h4>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 mb-4">
									<div class="facility-item d-flex align-items-center">
										<div class="facility-icon me-3 text-primary">
											<i class="fas fa-lock"></i>
										</div>
										<div>
											<h4 class="h6 mb-0">Safe Deposit Boxes</h4>
										</div>
									</div>
								</div>
							</div>
							
							<div class="mt-3">
								<p class="small text-muted mb-0">* Facilities may vary by branch. Check branch details for specific information.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="branch-faqs py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Frequently Asked Questions</h2>
					<p class="section-subtitle">Answers to common questions about our branches and services</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="accordion" id="branchFaqAccordion">
						<!-- FAQ Item 1 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									What documents do I need to bring when visiting a branch?
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#branchFaqAccordion">
								<div class="accordion-body">
									<p>When visiting our branches, please bring a valid identification document (National ID, Passport, or Driver's License). For specific services like account opening or loan applications, you may need additional documents such as proof of residence, employment details, or financial statements. It's recommended to call ahead and confirm the exact requirements for your specific needs.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 2 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Can I access all SACCO services at any branch?
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#branchFaqAccordion">
								<div class="accordion-body">
									<p>Yes, our core services are available at all branches, including account opening, deposits, withdrawals, loan applications, and bill payments. However, some specialized services may only be available at specific branches. For example, mortgage consultations might be limited to larger branches with specialized staff. You can check the specific branch details on our locator to see what services are offered at each location.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 3 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									What ATM services are available at your ATMs?
								</button>
							</h3>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#branchFaqAccordion">
								<div class="accordion-body">
									<p>Our ATMs offer a range of services including cash withdrawals, account balance inquiries, mini-statements, and PIN changes. Many of our newer ATMs also support cash deposits and funds transfers between accounts. Our ATMs are part of the national ATM network, allowing you to use other bank ATMs for a small fee. For security reasons, daily withdrawal limits apply and are indicated at each ATM.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 4 -->
						<div class="accordion-item border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									What services do SACCO agents provide?
								</button>
							</h3>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#branchFaqAccordion">
								<div class="accordion-body">
									<p>Our SACCO agents provide convenient access to basic banking services in areas where we don't have physical branches. Services typically include deposits, withdrawals, bill payments, and balance inquiries. Agents operate within set transaction limits for security purposes. While agents cannot open accounts or process loans, they can provide information and direct you to the nearest branch for more complex services. All our agents are carefully selected and trained to maintain our service standards.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 mb-4 mb-lg-0">
					<h2 class="text-white">Can't Find a Branch Near You?</h2>
					<p class="lead mb-0">Access our services 24/7 through our mobile and online banking platforms.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/digital-banking/')); ?>" class="btn btn-light btn-lg me-2 mb-2 mb-lg-0">Online Banking</a>
					<a href="<?php echo esc_url(home_url('/download-app/')); ?>" class="btn btn-outline-light btn-lg">Download Our App</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Branch search functionality
    const searchForm = document.getElementById('branchSearchForm');
    const branchList = document.getElementById('branchList');
    const branchItems = document.querySelectorAll('.branch-item');
    const branchCount = document.getElementById('branchCount');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const searchInput = document.getElementById('locationSearch').value.toLowerCase();
            const filterBranches = document.getElementById('filterBranches').checked;
            const filterATMs = document.getElementById('filterATMs').checked;
            const filterAgents = document.getElementById('filterAgents').checked;
            
            let visibleCount = 0;
            
            branchItems.forEach(function(item) {
                const branchName = item.querySelector('.branch-name').textContent.toLowerCase();
                const branchAddress = item.querySelector('.branch-address').textContent.toLowerCase();
                const branchType = item.getAttribute('data-branch-type');
                
                // Check if branch type is filtered
                let typeMatch = false;
                if ((branchType === 'branch' && filterBranches) ||
                    (branchType === 'atm' && filterATMs) ||
                    (branchType === 'agent' && filterAgents)) {
                    typeMatch = true;
                }
                
                // Check if search term matches
                const searchMatch = searchInput === '' || 
                                   branchName.includes(searchInput) || 
                                   branchAddress.includes(searchInput);
                
                if (typeMatch && searchMatch) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update count
            branchCount.textContent = visibleCount;
        });
    }
    
    // Filter checkboxes functionality
    const filterCheckboxes = document.querySelectorAll('.form-check-input');
    filterCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Trigger a search when filters change
            const event = new Event('submit');
            searchForm.dispatchEvent(event);
        });
    });
    
    // Handle "Use My Location" button
    const useLocationButton = document.getElementById('useMyLocation');
    if (useLocationButton) {
        useLocationButton.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Here you would typically send these coordinates to your backend or a mapping API
                    // to find the nearest branches, then update the list accordingly
                    alert('Located! Latitude: ' + position.coords.latitude + ', Longitude: ' + position.coords.longitude);
                    
                    // For demo purposes, we'll just show an alert
                    // In a real implementation, you would:
                    // 1. Send the coordinates to your server
                    // 2. Find the nearest branches
                    // 3. Update the branch list
                    // 4. Center the map on the user's location
                });
            } else {
                alert('Geolocation is not supported by your browser');
            }
        });
    }
    
    // Handle "View on Map" buttons
    const viewOnMapButtons = document.querySelectorAll('.view-on-map');
    viewOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const branchId = this.getAttribute('data-branch-id');
            
            // In a real implementation, you would:
            // 1. Get the branch's coordinates
            // 2. Center the map on those coordinates
            // 3. Open the branch's info window on the map
            
            // For demo purposes, we'll just show an alert
            alert('Showing branch ID ' + branchId + ' on the map');
            
            // Also highlight the selected branch in the list
            branchItems.forEach(function(item) {
                if (item.getAttribute('data-branch-id') === branchId) {
                    item.classList.add('border-primary');
                    item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    item.classList.remove('border-primary');
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?> 