<?php
/**
 * Template Name: Password Recovery
 *
 * This is the template for the password recovery page.
 *
 * @package Daystar
 */

get_header();
?>

<div class="page-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title text-center">Password Recovery</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if user is already logged in
                        if (is_user_logged_in()) {
                            $current_user = wp_get_current_user();
                            ?>
                            <div class="alert alert-info">
                                <p>You are already logged in as <?php echo esc_html($current_user->display_name); ?>.</p>
                                <p><a href="<?php echo esc_url(home_url('/member-dashboard')); ?>" class="btn btn-primary">Go to Dashboard</a> or <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn btn-outline-secondary">Logout</a></p>
                            </div>
                            <?php
                        } else {
                            // Check for form submission
                            $action = isset($_GET['action']) ? $_GET['action'] : '';
                            
                            if ($action === 'reset_success') {
                                ?>
                                <div class="alert alert-success">
                                    <p>Password reset instructions have been sent to your email address. Please check your inbox.</p>
                                </div>
                                <?php
                            } elseif ($action === 'rp') {
                                // Password reset form
                                $rp_key = isset($_GET['key']) ? $_GET['key'] : '';
                                $rp_login = isset($_GET['login']) ? $_GET['login'] : '';
                                
                                if (empty($rp_key) || empty($rp_login)) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <p>Invalid password reset link. Please try again.</p>
                                    </div>
                                    <?php
                                } else {
                                    // Check if the reset key is valid
                                    $user = check_password_reset_key($rp_key, $rp_login);
                                    
                                    if (is_wp_error($user)) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <p>This password reset link has expired or is invalid. Please request a new link.</p>
                                        </div>
                                        <?php
                                    } else {
                                        // Display the reset password form
                                        ?>
                                        <form class="password-reset-form" method="post" action="<?php echo esc_url(site_url('wp-login.php?action=resetpass')); ?>">
                                            <input type="hidden" name="rp_key" value="<?php echo esc_attr($rp_key); ?>">
                                            <input type="hidden" name="rp_login" value="<?php echo esc_attr($rp_login); ?>">
                                            
                                            <div class="form-group">
                                                <label for="new-password">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="pass1" id="new-password" class="form-control" required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="password-strength-meter mt-2">Password strength</div>
                                                <small class="form-text text-muted">Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="confirm-password">Confirm New Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="pass2" id="confirm-password" class="form-control" required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary password-toggle" tabindex="-1">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <button type="submit" name="wp-submit" class="btn btn-primary btn-block">Reset Password</button>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                            } else {
                                // Display the password recovery request form
                                ?>
                                <p class="mb-4">Enter your email address or username and we'll send you a link to reset your password.</p>
                                
                                <form class="password-recovery-form" method="post" action="<?php echo esc_url(wp_lostpassword_url()); ?>">
                                    <div class="form-group">
                                        <label for="recovery-email">Email Address or Username</label>
                                        <input type="text" name="user_login" id="recovery-email" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" name="wp-submit" class="btn btn-primary btn-block">Reset Password</button>
                                    </div>
                                    
                                    <div class="login-links text-center mt-4">
                                        <p>Remember your password? <a href="<?php echo esc_url(home_url('/login')); ?>">Log In</a></p>
                                        <p>Don't have an account? <a href="<?php echo esc_url(home_url('/register')); ?>">Register Now</a></p>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
