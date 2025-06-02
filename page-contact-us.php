<?php
/**
 * Template Name: Contact Us Page
 *
 * The template for displaying the Contact Us page.
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

	<section class="contact-intro py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2 class="section-title">Get In Touch With Us</h2>
					<p class="section-subtitle">We're here to answer your questions and provide the support you need</p>
					<?php the_content(); ?>
				</div>
			</div>
			
			<div class="row mb-5">
				<div class="col-md-4 mb-4 mb-md-0">
					<div class="contact-card text-center p-4 h-100 border rounded bg-white shadow-sm">
						<div class="contact-icon mb-3 text-primary">
							<i class="fas fa-phone-alt fa-3x"></i>
						</div>
						<h3 class="h4 mb-3">Call Us</h3>
						<p class="mb-2">Customer Service</p>
						<p class="mb-2"><a href="tel:+254700000000" class="text-decoration-none">+254 700 000 000</a></p>
						<p class="mb-2">Loans Department</p>
						<p class="mb-2"><a href="tel:+254711000000" class="text-decoration-none">+254 711 000 000</a></p>
						<p class="mb-2">24/7 Support Line</p>
						<p class="mb-0"><a href="tel:+254722000000" class="text-decoration-none">+254 722 000 000</a></p>
					</div>
				</div>
				
				<div class="col-md-4 mb-4 mb-md-0">
					<div class="contact-card text-center p-4 h-100 border rounded bg-white shadow-sm">
						<div class="contact-icon mb-3 text-primary">
							<i class="fas fa-envelope fa-3x"></i>
						</div>
						<h3 class="h4 mb-3">Email Us</h3>
						<p class="mb-2">General Inquiries</p>
						<p class="mb-2"><a href="mailto:info@sacconame.co.ke" class="text-decoration-none">info@sacconame.co.ke</a></p>
						<p class="mb-2">Member Services</p>
						<p class="mb-2"><a href="mailto:members@sacconame.co.ke" class="text-decoration-none">members@sacconame.co.ke</a></p>
						<p class="mb-2">Loans Department</p>
						<p class="mb-0"><a href="mailto:loans@sacconame.co.ke" class="text-decoration-none">loans@sacconame.co.ke</a></p>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="contact-card text-center p-4 h-100 border rounded bg-white shadow-sm">
						<div class="contact-icon mb-3 text-primary">
							<i class="fas fa-clock fa-3x"></i>
						</div>
						<h3 class="h4 mb-3">Business Hours</h3>
						<div class="hours-item d-flex justify-content-between mb-2">
							<span>Monday - Friday:</span>
							<span>8:00 AM - 5:00 PM</span>
						</div>
						<div class="hours-item d-flex justify-content-between mb-2">
							<span>Saturday:</span>
							<span>9:00 AM - 1:00 PM</span>
						</div>
						<div class="hours-item d-flex justify-content-between mb-2">
							<span>Sunday & Holidays:</span>
							<span>Closed</span>
						</div>
						<p class="mt-3 mb-0"><small class="text-muted">*Hours may vary for different branches</small></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-form-section py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mb-5 mb-lg-0">
					<h2 class="mb-4">Send Us a Message</h2>
					<p class="mb-4">Fill out the form below and our team will get back to you as soon as possible.</p>
					
					<div class="contact-form">
						<?php 
						// Check if Contact Form 7 is active
						if ( function_exists( 'wpcf7_contact_form' ) ) {
							// You can replace the ID with your actual Contact Form 7 form ID
							echo do_shortcode( '[contact-form-7 id="123" title="Contact Form"]' );
						} else {
							// Fallback form if Contact Form 7 is not activated
						?>
							<form id="contactForm" action="" method="post">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="name" class="form-label">Full Name</label>
										<input type="text" class="form-control" id="name" name="name" required>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
								</div>
								<div class="mb-3">
									<label for="phone" class="form-label">Phone Number</label>
									<input type="tel" class="form-control" id="phone" name="phone" required>
								</div>
								<div class="mb-3">
									<label for="subject" class="form-label">Subject</label>
									<input type="text" class="form-control" id="subject" name="subject" required>
								</div>
								<div class="mb-3">
									<label for="department" class="form-label">Department</label>
									<select class="form-select" id="department" name="department">
										<option value="General Inquiry">General Inquiry</option>
										<option value="Member Services">Member Services</option>
										<option value="Loans">Loans</option>
										<option value="Savings">Savings</option>
										<option value="Management">Management</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="message" class="form-label">Message</label>
									<textarea class="form-control" id="message" name="message" rows="5" required></textarea>
								</div>
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="privacyConsent" required>
									<label class="form-check-label" for="privacyConsent">I consent to having this website store my submitted information so they can respond to my inquiry.</label>
								</div>
								<button type="submit" class="btn btn-primary">Send Message</button>
							</form>
						<?php } ?>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="contact-map h-100">
						<h2 class="mb-4">Visit Our Main Office</h2>
						<p class="mb-4">Our headquarters is located in the heart of the city, easily accessible via public transport.</p>
						
						<div class="office-address mb-4">
							<h3 class="h5 mb-3">Head Office Address</h3>
							<address class="mb-0">
								SACCO Towers, 3rd Floor<br>
								123 Kimathi Street, CBD<br>
								P.O. Box 12345-00100<br>
								Nairobi, Kenya
							</address>
						</div>
						
						<div class="map-container rounded overflow-hidden mb-4">
							<!-- Replace with your Google Maps embed code -->
							<div class="embed-responsive embed-responsive-16by9">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8177928497656!2d36.81992601475864!3d-1.2834801990649396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d951f8ffff%3A0xc6adf04771a1e9e2!2sNairobi%20CBD%2C%20Nairobi!5e0!3m2!1sen!2ske!4v1652854245123!5m2!1sen!2ske" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>
						</div>
						
						<div class="get-directions">
							<a href="https://goo.gl/maps/8FwoQJjWNMcXQpXG6" target="_blank" class="btn btn-outline-primary">
								<i class="fas fa-directions me-2"></i> Get Directions
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="branches-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Our Branch Network</h2>
					<p class="section-subtitle">Visit any of our conveniently located branches across the country</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Nairobi CBD Branch</h3>
							<address class="card-text mb-3">
								SACCO Towers, 3rd Floor<br>
								123 Kimathi Street, CBD<br>
								Nairobi
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 123 456</p>
							<p class="mb-2"><strong>Email:</strong> nairobi@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="https://goo.gl/maps/8FwoQJjWNMcXQpXG6" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Westlands Branch</h3>
							<address class="card-text mb-3">
								The Mall, Ground Floor<br>
								456 Waiyaki Way, Westlands<br>
								Nairobi
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 234 567</p>
							<p class="mb-2"><strong>Email:</strong> westlands@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Mombasa Branch</h3>
							<address class="card-text mb-3">
								Ocean Plaza, 1st Floor<br>
								789 Moi Avenue<br>
								Mombasa
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 345 678</p>
							<p class="mb-2"><strong>Email:</strong> mombasa@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Kisumu Branch</h3>
							<address class="card-text mb-3">
								Lakeside Mall, 2nd Floor<br>
								101 Oginga Odinga Road<br>
								Kisumu
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 456 789</p>
							<p class="mb-2"><strong>Email:</strong> kisumu@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Nakuru Branch</h3>
							<address class="card-text mb-3">
								Eagle Center, Ground Floor<br>
								202 Kenyatta Avenue<br>
								Nakuru
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 567 890</p>
							<p class="mb-2"><strong>Email:</strong> nakuru@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="branch-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<h3 class="card-title h5">Eldoret Branch</h3>
							<address class="card-text mb-3">
								Summit Plaza, 1st Floor<br>
								303 Uganda Road<br>
								Eldoret
							</address>
							<p class="mb-2"><strong>Phone:</strong> +254 700 678 901</p>
							<p class="mb-2"><strong>Email:</strong> eldoret@sacconame.co.ke</p>
							<p class="mb-0"><strong>Hours:</strong> Mon-Fri 8am-5pm, Sat 9am-1pm</p>
						</div>
						<div class="card-footer bg-white border-0 p-4 pt-0">
							<a href="#" class="btn btn-sm btn-outline-primary">Branch Details</a>
							<a href="#" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
								<i class="fas fa-map-marker-alt me-1"></i> Map
							</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row mt-4">
				<div class="col-12 text-center">
					<a href="<?php echo esc_url(home_url('/branch-locator/')); ?>" class="btn btn-primary">
						<i class="fas fa-search-location me-2"></i> Find Your Nearest Branch
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-other py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center mb-5">
					<h2 class="section-title">Other Ways to Reach Us</h2>
					<p class="section-subtitle">Connect with us through your preferred channel</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fab fa-whatsapp fa-3x"></i>
							</div>
							<h3 class="h5">WhatsApp</h3>
							<p class="mb-3">Chat with our customer service team instantly.</p>
							<a href="https://wa.me/254700000000" class="btn btn-outline-primary" target="_blank">WhatsApp Us</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fas fa-comments fa-3x"></i>
							</div>
							<h3 class="h5">Live Chat</h3>
							<p class="mb-3">Connect with a support agent in real-time on our website.</p>
							<button id="startChatButton" class="btn btn-outline-primary">Start Chat</button>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fas fa-headset fa-3x"></i>
							</div>
							<h3 class="h5">Callback Request</h3>
							<p class="mb-3">Request a call back from our team at your convenience.</p>
							<button id="requestCallbackButton" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#callbackModal">Request Callback</button>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fab fa-facebook fa-3x"></i>
							</div>
							<h3 class="h5">Facebook</h3>
							<p class="mb-3">Connect with us and follow our updates on Facebook.</p>
							<a href="https://www.facebook.com/sacconame" class="btn btn-outline-primary" target="_blank">Visit Our Page</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fab fa-twitter fa-3x"></i>
							</div>
							<h3 class="h5">Twitter</h3>
							<p class="mb-3">Follow us for updates and send us direct messages.</p>
							<a href="https://twitter.com/sacconame" class="btn btn-outline-primary" target="_blank">Follow Us</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="contact-option-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<div class="option-icon mb-3 text-primary">
								<i class="fab fa-instagram fa-3x"></i>
							</div>
							<h3 class="h5">Instagram</h3>
							<p class="mb-3">Follow our Instagram for visual updates and stories.</p>
							<a href="https://www.instagram.com/sacconame" class="btn btn-outline-primary" target="_blank">Follow Us</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Callback Request Modal -->
	<div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="callbackModalLabel">Request a Callback</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="callbackForm">
						<div class="mb-3">
							<label for="callbackName" class="form-label">Your Name</label>
							<input type="text" class="form-control" id="callbackName" required>
						</div>
						<div class="mb-3">
							<label for="callbackPhone" class="form-label">Phone Number</label>
							<input type="tel" class="form-control" id="callbackPhone" required>
						</div>
						<div class="mb-3">
							<label for="callbackPreferredTime" class="form-label">Preferred Time</label>
							<select class="form-select" id="callbackPreferredTime">
								<option value="morning">Morning (8AM - 12PM)</option>
								<option value="afternoon">Afternoon (12PM - 3PM)</option>
								<option value="evening">Evening (3PM - 5PM)</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="callbackReason" class="form-label">Reason for Callback</label>
							<select class="form-select" id="callbackReason">
								<option value="General Inquiry">General Inquiry</option>
								<option value="Account Services">Account Services</option>
								<option value="Loan Information">Loan Information</option>
								<option value="Savings Products">Savings Products</option>
								<option value="Membership">Membership</option>
								<option value="Other">Other</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="callbackMessage" class="form-label">Additional Information</label>
							<textarea class="form-control" id="callbackMessage" rows="3"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Submit Request</button>
				</div>
			</div>
		</div>
	</div>

	<section class="faq-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">Frequently Asked Questions</h2>
					<p class="section-subtitle">Find quick answers to common questions</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="accordion" id="contactFaqAccordion">
						<!-- FAQ Item 1 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									How long does it take to get a response to my inquiry?
								</button>
							</h3>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body">
									<p>We aim to respond to all inquiries within 24 hours during business days. For urgent matters, we recommend calling our customer service line for immediate assistance.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 2 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									What information do I need to provide when contacting customer service?
								</button>
							</h3>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body">
									<p>For general inquiries, basic contact information is sufficient. However, if you are inquiring about your account, please have your membership number ready for verification purposes. We may also ask security questions to confirm your identity.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 3 -->
						<div class="accordion-item mb-3 border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingThree">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Can I schedule an appointment with a financial advisor?
								</button>
							</h3>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body">
									<p>Yes, you can schedule an appointment with our financial advisors. Please call our customer service line or use the contact form specifying that you would like to meet with a financial advisor. You can also visit any of our branches in person to schedule an appointment.</p>
								</div>
							</div>
						</div>
						
						<!-- FAQ Item 4 -->
						<div class="accordion-item border rounded overflow-hidden">
							<h3 class="accordion-header" id="headingFour">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									How can I report an issue with my account or a transaction?
								</button>
							</h3>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#contactFaqAccordion">
								<div class="accordion-body">
									<p>To report an issue with your account or a transaction, please contact our customer service team immediately by phone at +254 700 000 000 or email at support@sacconame.co.ke. For urgent matters, calling is the fastest way to get assistance. Please provide as much detail as possible about the issue, including dates, amounts, and any reference numbers associated with the transaction.</p>
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
					<h2 class="text-white">Have Questions About Our Products?</h2>
					<p class="lead mb-0">Our team is ready to provide the information you need to make informed financial decisions.</p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-light btn-lg">Join Today</a>
					<button class="btn btn-outline-light btn-lg ms-2" data-bs-toggle="modal" data-bs-target="#callbackModal">Request Callback</button>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php get_footer(); ?> 