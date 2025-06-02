<?php
/**
 * Template Name: Login Page
 *
 * The template for displaying the login and registration page.
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

	<section class="login-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row">
						<!-- Login Form -->
						<div class="col-lg-6 mb-4 mb-lg-0">
							<div class="auth-form-card">
								<h2>Member Login</h2>
								<?php if (isset($_GET['login_error'])) : ?>
									<div class="alert alert-danger">
										<?php echo esc_html(urldecode($_GET['login_error'])); ?>
									</div>
								<?php endif; ?>
								<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="login-form">
									<input type="hidden" name="action" value="sacco_login">
									<?php wp_nonce_field('sacco_login', 'sacco_login_nonce'); ?>
									
									<div class="mb-3">
										<label for="username" class="form-label">Username or Email</label>
										<input type="text" class="form-control" id="username" name="username" required>
									</div>
									
									<div class="mb-3">
										<label for="password" class="form-label">Password</label>
										<input type="password" class="form-control" id="password" name="password" required>
									</div>
									
									<div class="mb-3 form-check">
										<input type="checkbox" class="form-check-input" id="remember" name="remember">
										<label class="form-check-label" for="remember">Remember me</label>
									</div>
									
									<div class="mb-3">
										<button type="submit" class="btn btn-primary w-100">Login</button>
									</div>
									
									<div class="text-center">
										<p><a href="<?php echo esc_url(wp_lostpassword_url()); ?>">Forgot password?</a></p>
									</div>
								</form>
							</div>
						</div>
						
						<!-- Register Form -->
						<div class="col-lg-6">
							<div class="auth-form-card">
								<h2>New Member Registration</h2>
								<?php if (isset($_GET['register_error'])) : ?>
									<div class="alert alert-danger">
										<?php 
										$error = $_GET['register_error'];
										if ($error === 'passwords_mismatch') {
											echo 'Passwords do not match.';
										} else {
											echo esc_html(urldecode($error));
										}
										?>
									</div>
								<?php endif; ?>
								<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="register-form">
									<input type="hidden" name="action" value="sacco_register">
									<?php wp_nonce_field('sacco_register', 'sacco_register_nonce'); ?>
									
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="first_name" class="form-label">First Name</label>
											<input type="text" class="form-control" id="first_name" name="first_name" required>
										</div>
										<div class="col-md-6 mb-3">
											<label for="last_name" class="form-label">Last Name</label>
											<input type="text" class="form-control" id="last_name" name="last_name" required>
										</div>
									</div>
									
									<div class="mb-3">
										<label for="reg_username" class="form-label">Username</label>
										<input type="text" class="form-control" id="reg_username" name="username" required>
									</div>
									
									<div class="mb-3">
										<label for="email" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
									
									<div class="mb-3">
										<label for="reg_password" class="form-label">Password</label>
										<input type="password" class="form-control" id="reg_password" name="password" required>
									</div>
									
									<div class="mb-3">
										<label for="confirm_password" class="form-label">Confirm Password</label>
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
									</div>
									
									<div class="mb-3 form-check">
										<input type="checkbox" class="form-check-input" id="terms" name="terms" required>
										<label class="form-check-label" for="terms">I agree to the <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank">terms and conditions</a></label>
									</div>
									
									<div class="mb-3">
										<button type="submit" class="btn btn-primary w-100">Register</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="login-info-section py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-4 mb-4 mb-md-0">
							<div class="login-info-card">
								<div class="info-icon">
									<i class="fas fa-shield-alt"></i>
								</div>
								<h3>Secure Access</h3>
								<p>Your account is protected with the highest security standards to ensure your data remains safe.</p>
							</div>
						</div>
						<div class="col-md-4 mb-4 mb-md-0">
							<div class="login-info-card">
								<div class="info-icon">
									<i class="fas fa-laptop"></i>
								</div>
								<h3>Online Services</h3>
								<p>Access your accounts, check balances, view statements, and manage your finances 24/7.</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="login-info-card">
								<div class="info-icon">
									<i class="fas fa-headset"></i>
								</div>
								<h3>Help &amp; Support</h3>
								<p>Need assistance? Our customer support team is available to help you with your account.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<style>
	.auth-form-card {
		background-color: #fff;
		padding: 30px;
		border-radius: 10px;
		box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
		height: 100%;
	}
	
	.auth-form-card h2 {
		font-size: 1.8rem;
		margin-bottom: 25px;
		padding-bottom: 15px;
		border-bottom: 1px solid #eee;
	}
	
	.login-info-card {
		background-color: #fff;
		padding: 25px;
		border-radius: 10px;
		box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
		text-align: center;
		height: 100%;
	}
	
	.info-icon {
		font-size: 2.5rem;
		color: #5ca157;
		margin-bottom: 20px;
	}
	
	.login-info-card h3 {
		font-size: 1.4rem;
		margin-bottom: 15px;
	}
</style>

<?php
get_footer(); 