<?php
/**
 * The template for displaying the Contact Us page - Improved Version
 *
 * This is the improved Contact page template that uses the consolidated CSS,
 * standardized header/footer, and improves structure and accessibility.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main contact-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact-header-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="contact-card fade-in">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Visit Us</h3>
                        <p>Main Office: 123 Financial Street<br>Suite 100, Nairobi<br>Kenya</p>
                        <a href="https://goo.gl/maps/123" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer">Get Directions</a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="contact-card fade-in">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt" aria-hidden="true"></i>
                        </div>
                        <h3>Call Us</h3>
                        <p>Main: <a href="tel:+254700000000">+254 700 000 000</a><br>
                        Support: <a href="tel:+254711000000">+254 711 000 000</a><br>
                        Toll-free: <a href="tel:+254800000000">0800 000 000</a></p>
                        <p class="small text-muted">Monday-Friday: 8:00 AM - 5:00 PM</p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="contact-card fade-in">
                        <div class="contact-icon">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>General Inquiries:<br><a href="mailto:info@saccowebsite.com">info@saccowebsite.com</a></p>
                        <p>Member Support:<br><a href="mailto:support@saccowebsite.com">support@saccowebsite.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="contact-form-wrapper fade-in">
                        <h2 class="section-title">Send Us a Message</h2>
                        <p class="mb-4">Have a question or feedback? Fill out the form below and we'll get back to you as soon as possible.</p>
                        
                        <form id="contactForm" class="contact-form" action="#" method="post">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Please enter your name</div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="" selected disabled>Select a subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Membership">Membership</option>
                                    <option value="Loans">Loans</option>
                                    <option value="Savings">Savings</option>
                                    <option value="Technical Support">Technical Support</option>
                                    <option value="Feedback">Feedback</option>
                                </select>
                                <div class="invalid-feedback">Please select a subject</div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                <div class="invalid-feedback">Please enter your message</div>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                                <label class="form-check-label" for="consent">
                                    I consent to having this website store my submitted information so they can respond to my inquiry.
                                </label>
                                <div class="invalid-feedback">You must agree before submitting</div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                                <div class="form-message mt-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="map-wrapper fade-in">
                        <h2 class="section-title">Our Locations</h2>
                        <p class="mb-4">Visit us at any of our branch locations across the country.</p>
                        
                        <div class="map-container">
                            <div id="map" class="contact-map">
                                <!-- Map will be loaded here via JavaScript -->
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/map-placeholder.jpg" alt="Map of our locations" class="img-fluid">
                            </div>
                        </div>
                        
                        <div class="branch-selector mt-4">
                            <h3 class="h5 mb-3">Select a Branch</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="branch-card" data-location="nairobi">
                                        <h4 class="h6">Nairobi Main Branch</h4>
                                        <p class="small mb-0">123 Financial Street, Suite 100</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="branch-card" data-location="mombasa">
                                        <h4 class="h6">Mombasa Branch</h4>
                                        <p class="small mb-0">45 Ocean Road, 2nd Floor</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="branch-card" data-location="kisumu">
                                        <h4 class="h6">Kisumu Branch</h4>
                                        <p class="small mb-0">78 Lake Avenue, Ground Floor</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="branch-card" data-location="nakuru">
                                        <h4 class="h6">Nakuru Branch</h4>
                                        <p class="small mb-0">12 Central Plaza, 3rd Floor</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Quick answers to common questions</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="accordion fade-in" id="faqAccordion1">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What are your business hours?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">
                                    Our main office and branches are open Monday through Friday from 8:00 AM to 5:00 PM. We are closed on weekends and public holidays. Our online banking services are available 24/7.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How long does it take to get a response?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">
                                    We strive to respond to all inquiries within 24 business hours. For urgent matters, we recommend calling our customer service line directly.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How do I report a technical issue with online banking?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion1">
                                <div class="accordion-body">
                                    For technical issues with our online banking platform, please contact our technical support team at support@saccowebsite.com or call our dedicated support line at +254 711 000 000.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="accordion fade-in" id="faqAccordion2">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How do I schedule an appointment?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">
                                    You can schedule an appointment by calling our main office, using our online appointment booking system in the member portal, or by visiting any of our branches in person.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Do you have a mobile app?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">
                                    Yes, we have a mobile app available for both iOS and Android devices. You can download it from the App Store or Google Play Store by searching for "SACCO Mobile Banking".
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    How can I provide feedback about your services?
                                </button>
                            </h3>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion2">
                                <div class="accordion-body">
                                    We value your feedback! You can provide feedback through our contact form on this page, by emailing feedback@saccowebsite.com, or by filling out a feedback form at any of our branch locations.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 fade-in">
                <a href="<?php echo esc_url(home_url('faq')); ?>" class="btn btn-outline-primary">View All FAQs</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Join Our Newsletter</h2>
                        <p class="cta-subtitle">Stay updated with our latest news, financial tips, and special offers.</p>
                    </div>
                    <div class="col-lg-4">
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address" aria-label="Email address" required>
                                <button class="btn btn-gradient" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Contact Form Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (!this.checkValidity()) {
                event.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            // Form is valid, show success message
            const formMessage = this.querySelector('.form-message');
            formMessage.innerHTML = '<div class="alert alert-success">Thank you for your message! We will get back to you soon.</div>';
            
            // Reset form
            this.reset();
            this.classList.remove('was-validated');
            
            // In a real implementation, you would send the form data to the server here
        });
    }
    
    // Branch selector functionality
    const branchCards = document.querySelectorAll('.branch-card');
    
    if (branchCards.length > 0) {
        branchCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                branchCards.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked card
                this.classList.add('active');
                
                // In a real implementation, you would update the map based on the selected branch
                const location = this.getAttribute('data-location');
                console.log('Selected branch:', location);
                
                // Simulate map update with a message
                const map = document.getElementById('map');
                if (map) {
                    map.innerHTML = `<div class="map-placeholder"><p>Map showing ${location} branch location</p></div>`;
                }
            });
        });
    }
});
</script>

<?php
get_footer();
