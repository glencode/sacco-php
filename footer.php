<?php
/**
 * The footer for Daystar Multi-Purpose Co-op Society Ltd. website
 *
 * @package daystar-coop
 */
?>

</div><!-- #content -->

<!-- Modern Professional Footer -->
<footer class="modern-footer">
    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="container">
            <div class="row g-4">
                <!-- Brand & About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <h2 class="brand-name">
                            <span class="brand-primary">DAYSTAR</span>
                            <span class="brand-secondary">MULTI-PURPOSE</span>
                        </h2>
                        <div class="brand-tagline">Co-operative Society Ltd</div>
                    </div>
                    <p class="footer-description">
                        Empowering members through accessible loan solutions and financial services. 
                        Your trusted partner for development, education, and emergency financing.
                    </p>
                    <div class="social-media-section">
                        <h6 class="social-title">Connect With Us</h6>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link twitter" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link linkedin" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link youtube" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Navigation -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Quick Links</h5>
                        <ul class="footer-nav">
                            <li><a href="<?php echo esc_url(home_url('about')); ?>">About Us</a></li>
                            <li><a href="<?php echo esc_url(home_url('products-services')); ?>">All Products & Services</a></li>
                            <li><a href="<?php echo esc_url(home_url('membership')); ?>">Membership</a></li>
                            <li><a href="<?php echo esc_url(home_url('loan-calculator')); ?>">Loan Calculator</a></li>
                            <li><a href="<?php echo esc_url(home_url('contact')); ?>">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Financial Products -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Loan Products</h5>
                        <ul class="footer-nav">
                            <li><a href="<?php echo esc_url(home_url('development-loans')); ?>">Development Loans</a></li>
                            <li><a href="<?php echo esc_url(home_url('school-fees-loans')); ?>">School Fees Loans</a></li>
                            <li><a href="<?php echo esc_url(home_url('emergency-loans')); ?>">Emergency Loans</a></li>
                            <li><a href="<?php echo esc_url(home_url('special-loans')); ?>">Special Loans</a></li>
                            <li><a href="<?php echo esc_url(home_url('super-saver-loans')); ?>">Super Saver Loans</a></li>
                            <li><a href="<?php echo esc_url(home_url('salary-advance')); ?>">Salary Advance</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact & Location -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">Get In Touch</h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">Location</span>
                                    <p>Daystar University – Athiriver Campus<br>P.O. Box 44400-00100, Nairobi</p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">Phone</span>
                                    <p>+254 731 629 716<br>+254 799 174 239</p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">Email</span>
                                    <p>daystarmultipurpose@daystar.ac.ke</p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-details">
                                    <span class="contact-label">Hours</span>
                                    <p>Mon-Fri: 8:00 AM - 5:00 PM<br>Sat: 9:00 AM - 1:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> Daystar Multi-Purpose Co-operative Society Ltd. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-legal">
                        <a href="<?php echo esc_url(home_url('privacy-policy')); ?>">Privacy Policy</a>
                        <a href="<?php echo esc_url(home_url('terms-conditions')); ?>">Terms of Service</a>
                        <a href="<?php echo esc_url(home_url('credit-policy')); ?>">Credit Policy</a>
                        <a href="<?php echo esc_url(home_url('faqs')); ?>">FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" aria-label="Back to top">
    <i class="fas fa-arrow-up" aria-hidden="true"></i>
</a>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (required for some custom functionality) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Custom JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>

<script>
    // Initialize animations
    document.addEventListener('DOMContentLoaded', function() {
        // Preloader
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
        }, 500);
        
        // Fade-in animations
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });
        
        fadeElements.forEach(element => {
            observer.observe(element);
        });
        
        // Back to top button
        const backToTopButton = document.querySelector('.back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?php wp_footer(); ?>

</body>
</html>
