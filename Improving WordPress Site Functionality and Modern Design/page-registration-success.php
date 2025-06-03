<?php
/**
 * Template Name: Registration Success
 *
 * This is the template for the registration success page.
 *
 * @package Daystar
 */

get_header();

// Get member number from URL parameter
$member_number = isset($_GET['member']) ? sanitize_text_field($_GET['member']) : '';
?>

<div class="page-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card success-card">
                    <div class="card-body text-center">
                        <div class="success-icon mb-4">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        
                        <h2 class="card-title">Registration Successful!</h2>
                        
                        <p class="lead mb-4">Thank you for registering with Daystar Multi-Purpose Co-op Society.</p>
                        
                        <?php if (!empty($member_number)) : ?>
                            <div class="member-number-container mb-4">
                                <h4>Your Member Number</h4>
                                <div class="member-number"><?php echo esc_html($member_number); ?></div>
                                <p class="text-muted">Please save this number for future reference</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="registration-info mb-4">
                            <h4>What Happens Next?</h4>
                            <ol class="text-left">
                                <li>Your registration is currently <strong>pending approval</strong> by our administrators.</li>
                                <li>You will receive an email notification once your registration has been approved.</li>
                                <li>After approval, you can log in to your member dashboard.</li>
                                <li>Please make your initial contribution as indicated during registration.</li>
                            </ol>
                        </div>
                        
                        <div class="contact-info mb-4">
                            <h4>Need Help?</h4>
                            <p>If you have any questions or need assistance, please contact our support team:</p>
                            <p><i class="fa fa-envelope"></i> <a href="mailto:support@daystar.co.ke">support@daystar.co.ke</a></p>
                            <p><i class="fa fa-phone"></i> <a href="tel:+254123456789">+254 123 456 789</a></p>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Go to Homepage</a>
                            <a href="<?php echo esc_url(home_url('/login')); ?>" class="btn btn-outline-secondary">Go to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
