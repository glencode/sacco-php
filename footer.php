<?php
/**
 * The footer for Daystar Multi-Purpose Co-op Society Ltd. website
 *
 * @package daystar-coop
 */
?>

</div><!-- #content -->

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- About Column -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="footer-logo mb-4">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/daystar multipurpose logo.png" alt="Daystar Multi-Purpose Co-op Society Ltd." class="img-fluid" style="max-height: 60px;">
                </div>
                <p>Daystar Multi-Purpose Co-op Society Ltd. is dedicated to empowering our members through financial solutions that promote economic growth and stability.</p>
                <ul class="social-links mt-3">
                    <li><a href="#" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                    <li><a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            
            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('about-us')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('products-services')); ?>">Products & Services</a></li>
                    <li><a href="<?php echo esc_url(home_url('membership')); ?>">Membership</a></li>
                    <li><a href="<?php echo esc_url(home_url('loan-calculator')); ?>">Loan Calculator</a></li>
                    <li><a href="<?php echo esc_url(home_url('faqs')); ?>">FAQs</a></li>
                    <li><a href="<?php echo esc_url(home_url('contact-us')); ?>">Contact Us</a></li>
                </ul>
            </div>
            
            <!-- Loan Products Column -->
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h4>Loan Products</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('development-loans')); ?>">Development Loans</a></li>
                    <li><a href="<?php echo esc_url(home_url('school-fees-loans')); ?>">School Fees Loans</a></li>
                    <li><a href="<?php echo esc_url(home_url('emergency-loans')); ?>">Emergency Loans</a></li>
                    <li><a href="<?php echo esc_url(home_url('special-loans')); ?>">Special Loans</a></li>
                    <li><a href="<?php echo esc_url(home_url('super-saver-loans')); ?>">Super Saver Loans</a></li>
                    <li><a href="<?php echo esc_url(home_url('salary-advance')); ?>">Salary Advance</a></li>
                </ul>
            </div>
            
            <!-- Contact Information Column -->
            <div class="col-lg-4 col-md-4">
                <h4>Contact Information</h4>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Daystar University – Athiriver campus<br>P.O. Box 44400-00100<br>Nairobi, Kenya</p>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-phone-alt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Airtel: 0731-629-716<br>Safaricom: 0799-174-239<br>Ext 673 or 0709-972-673</p>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>daystarmultipurpose@daystar.ac.ke</p>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 1:00 PM<br>Sunday & Public Holidays: Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p>&copy; <?php echo date('Y'); ?> Daystar Multi-Purpose Co-op Society Ltd. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>
                        <a href="<?php echo esc_url(home_url('privacy-policy')); ?>">Privacy Policy</a> | 
                        <a href="<?php echo esc_url(home_url('terms-conditions')); ?>">Terms & Conditions</a> | 
                        <a href="<?php echo esc_url(home_url('credit-policy')); ?>">Credit Policy</a>
                    </p>
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
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/enhancements.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
