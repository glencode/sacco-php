<?php
/**
 * Template Name: Contact Page
 *
 * The template for displaying the contact page.
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
					<h1 class="page-title"><?php echo esc_html(get_field('contact_page_title') ?: get_the_title()); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-section py-5">
		<div class="container">
			<?php 
			$contact_intro_title = get_field('contact_page_intro_title') ?: esc_html__('We\'re Here to Help', 'sacco-php');
			$contact_intro_subtitle = get_field('contact_page_intro_subtitle') ?: esc_html__('Have questions or need assistance? Reach out to us through any of the channels below.', 'sacco-php');
			if($contact_intro_title || $contact_intro_subtitle) : ?>
			<div class="row mb-5">
				<div class="col-lg-8 offset-lg-2 text-center">
					<?php if($contact_intro_title): ?><h2 class="section-title"><?php echo esc_html($contact_intro_title); ?></h2><?php endif; ?>
					<?php if($contact_intro_subtitle): ?><p class="lead"><?php echo esc_html($contact_intro_subtitle); ?></p><?php endif; ?>
				</div>
			</div>
			<?php endif; ?>

			<?php
			// Display form submission status messages
			if (isset($_GET['form_status'])) {
				$status = sanitize_key($_GET['form_status']);
				$message_text = '';
				$message_type = 'info';

				if ($status === 'success') {
					$message_text = esc_html__('Thank you for your message! We will get back to you shortly.', 'sacco-php');
					$message_type = 'success';
				} elseif ($status === 'error') {
					$message_text = esc_html__('There was an error with your submission. Please check the required fields and try again.', 'sacco-php');
					$message_type = 'danger';
				} elseif ($status === 'mail_error') {
					$message_text = esc_html__('Sorry, there was an issue sending your message. Please try again later or contact us directly.', 'sacco-php');
					$message_type = 'warning';
				}

				if ($message_text) {
					echo '<div class="row mb-4"><div class="col-md-12"><div class="alert alert-' . esc_attr($message_type) . '" role="alert">' . $message_text . '</div></div></div>';
				}
			}
			?>

			<div class="row mb-5 gy-4">
				<div class="col-md-4 d-flex align-items-stretch">
					<div class="contact-info-card text-center p-4 border rounded shadow-sm w-100">
						<div class="contact-info-icon display-4 text-primary mb-3">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<h3 class="h5 fw-bold">Visit Us</h3>
						<p class="mb-0"><?php echo nl2br(esc_html(get_field('contact_address') ?: "Sacco Headquarters\n123 Maendeleo Road\nNairobi, Kenya")); ?></p>
					</div>
				</div>
				<div class="col-md-4 d-flex align-items-stretch">
					<div class="contact-info-card text-center p-4 border rounded shadow-sm w-100">
						<div class="contact-info-icon display-4 text-primary mb-3">
							<i class="fas fa-phone-alt"></i>
						</div>
						<h3 class="h5 fw-bold">Call Us</h3>
						<?php 
						$phone_numbers = get_field('contact_phone_numbers');
						if ($phone_numbers && is_array($phone_numbers)):
							foreach($phone_numbers as $phone) {
								if(isset($phone['phone_number']) && $phone['phone_number']) {
									 echo '<p class="mb-0"><a href="tel:' . esc_attr(preg_replace('/[^0-9+]/ ','',$phone['phone_number'])) . '">' . esc_html($phone['phone_number']) . '</a></p>';
								}
							}
						else:
							echo '<p class="mb-0"><a href="tel:+254700123456">+254 700 123 456</a></p>';
							echo '<p class="mb-0"><a href="tel:+254720123456">+254 720 123 456</a></p>';
						endif;
						?>
					</div>
				</div>
				<div class="col-md-4 d-flex align-items-stretch">
					<div class="contact-info-card text-center p-4 border rounded shadow-sm w-100">
						<div class="contact-info-icon display-4 text-primary mb-3">
							<i class="fas fa-envelope"></i>
						</div>
						<h3 class="h5 fw-bold">Email Us</h3>
						<?php 
						$email_addresses = get_field('contact_email_addresses');
						if ($email_addresses && is_array($email_addresses)):
							foreach($email_addresses as $email_addr) {
								if(isset($email_addr['email_address']) && $email_addr['email_address']) {
									 echo '<p class="mb-0"><a href="mailto:' . esc_attr($email_addr['email_address']) . '">' . esc_html($email_addr['email_address']) . '</a></p>';
								}
							}
						else:
							echo '<p class="mb-0"><a href="mailto:info@sacco.com">info@sacco.com</a></p>';
							echo '<p class="mb-0"><a href="mailto:support@sacco.com">support@sacco.com</a></p>';
						endif;
						?>
					</div>
				</div>
			</div>
			
			<div class="row gy-5">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="contact-form-card p-4 p-md-5 border rounded shadow-sm">
						<h2 class="mb-4 text-center text-md-start">Send Us a Message</h2>
						
						<div class="contact-form">
							<?php
							$contact_form_shortcode = get_field('contact_form_shortcode');
							if ( $contact_form_shortcode && function_exists('wpcf7_contact_form') ) {
								echo do_shortcode(sanitize_text_field($contact_form_shortcode));
							} elseif (shortcode_exists('wpforms')) { // Fallback for WPForms if CF7 not used or shortcode not set
                                echo do_shortcode('[wpforms id="your_wpforms_id" title="false" description="false"]'); // Replace your_wpforms_id
                            } else {
								// Fallback native form - can be connected to handle_contact_form_submission AJAX
							?>
							<form id="saccoContactPageForm" class="contact-form-native" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type="hidden" name="action" value="contact_page_submission"> <!-- Action for admin-post.php -->
                                <?php wp_nonce_field('sacco_contact_page_form_nonce', 'contact_page_nonce'); ?>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="contactName" class="form-label">Your Name</label>
										<input type="text" class="form-control" id="contactName" name="contact_name" required>
									</div>
									<div class="col-md-6 mb-3">
										<label for="contactEmail" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="contactEmail" name="contact_email" required>
									</div>
								</div>
								<div class="mb-3">
									<label for="contactSubject" class="form-label">Subject</label>
									<input type="text" class="form-control" id="contactSubject" name="contact_subject" required>
								</div>
								<div class="mb-3">
									<label for="contactMessage" class="form-label">Message</label>
									<textarea class="form-control" id="contactMessage" name="contact_message" rows="5" required></textarea>
								</div>
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="contactPrivacy" name="contact_privacy" value="agree" required>
									<label class="form-check-label" for="contactPrivacy">I agree to the <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank">privacy policy</a></label>
								</div>
								<button type="submit" class="btn btn-primary w-100">Send Message</button>
                                <div class="form-status mt-3"></div> <!-- For AJAX messages -->
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="contact-map-card p-4 p-md-5 border rounded shadow-sm h-100">
						<h2 class="mb-4 text-center text-md-start">Find Us On The Map</h2>
						<div class="contact-map ratio ratio-16x9">
							<?php 
							$map_iframe_src = get_field('google_map_iframe_src');
							if ($map_iframe_src) :
								// Basic sanitization for iframe src - a more robust solution might be needed depending on expected input
								// For now, assuming a valid Google Maps embed URL is provided.
								echo $map_iframe_src; // Already an iframe string
							else :
							?>
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.3585977242!2d36.70730246001141!3d-1.302862319334275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2sus!4v1623234084830!5m2!1sen!2sus" width="100%" height="100%" style="border:0; border-radius: 0.25rem;" allowfullscreen="" loading="lazy"></iframe>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php
	$branches_title = get_field('branches_section_title') ?: esc_html__('Our Branches', 'sacco-php');
	$branches_subtitle = get_field('branches_section_subtitle') ?: esc_html__('Visit any of our branches for personalized assistance', 'sacco-php');
	$branches = get_field('branches');

	if ($branches_title || $branches_subtitle || ($branches && is_array($branches))) : // Only show section if there's title or branches
	?>
	<section class="branches-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<?php if ($branches_title): ?><h2 class="section-title"><?php echo esc_html($branches_title); ?></h2><?php endif; ?>
					<?php if ($branches_subtitle): ?><p class="section-subtitle"><?php echo esc_html($branches_subtitle); ?></p><?php endif; ?>
				</div>
			</div>
			
			<div class="row gy-4 justify-content-center">
				<?php
				if ($branches && is_array($branches)) :
					foreach ($branches as $branch) :
						$name = isset($branch['branch_name']) ? $branch['branch_name'] : 'Branch Name';
						$address = isset($branch['branch_address']) ? $branch['branch_address'] : '';
						$phone = isset($branch['branch_phone']) ? $branch['branch_phone'] : '';
						$hours1 = isset($branch['branch_working_hours_line1']) ? $branch['branch_working_hours_line1'] : '';
						$hours2 = isset($branch['branch_working_hours_line2']) ? $branch['branch_working_hours_line2'] : '';
						$map_link = isset($branch['branch_map_link']) ? $branch['branch_map_link'] : '';
				?>
				<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
					<div class="branch-card card h-100 p-4 shadow-sm border-0">
						<h3 class="h5 fw-bold text-primary mb-3"><?php echo esc_html($name); ?></h3>
						<?php if ($address): ?><p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i><?php echo esc_html($address); ?></p><?php endif; ?>
						<?php if ($phone): ?><p class="mb-1"><i class="fas fa-phone-alt me-2 text-muted"></i><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/ ','',$phone)); ?>"><?php echo esc_html($phone); ?></a></p><?php endif; ?>
						<?php if ($hours1): ?><p class="mb-1"><i class="far fa-clock me-2 text-muted"></i><?php echo esc_html($hours1); ?></p><?php endif; ?>
						<?php if ($hours2): ?><p class="mb-1"><i class="far fa-clock me-2 text-muted" style="visibility: hidden;"></i><?php echo esc_html($hours2); ?></p><?php endif; ?>
						<?php if ($map_link): ?><a href="<?php echo esc_url($map_link); ?>" class="btn btn-outline-primary btn-sm mt-3" target="_blank" rel="noopener noreferrer">Get Directions</a><?php endif; ?>
					</div>
				</div>
				<?php 
					endforeach;
				else : // Fallback static branches
					$fallback_branches = [
						['name' => 'Nairobi Main Branch', 'address' => '123 Maendeleo Road, Nairobi', 'phone' => '+254 700 123 456', 'hours1' => 'Mon-Fri: 8:00 AM - 5:00 PM', 'hours2' => 'Sat: 9:00 AM - 1:00 PM'],
						['name' => 'Mombasa Branch', 'address' => '456 Biashara St, Mombasa', 'phone' => '+254 710 987 654', 'hours1' => 'Mon-Fri: 8:30 AM - 4:30 PM', 'hours2' => 'Sat: 9:00 AM - 12:30 PM'],
						['name' => 'Kisumu Branch', 'address' => '789 Ufanisi Ave, Kisumu', 'phone' => '+254 720 112 233', 'hours1' => 'Mon-Fri: 8:00 AM - 5:00 PM', 'hours2' => 'Sat: Closed'],
					];
					foreach ($fallback_branches as $branch) :
				?>
				<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
					<div class="branch-card card h-100 p-4 shadow-sm border-0">
						<h3 class="h5 fw-bold text-primary mb-3"><?php echo esc_html($branch['name']); ?></h3>
						<p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i><?php echo esc_html($branch['address']); ?></p>
						<p class="mb-1"><i class="fas fa-phone-alt me-2 text-muted"></i><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/ ','',$branch['phone'])); ?>"><?php echo esc_html($branch['phone']); ?></a></p>
						<p class="mb-1"><i class="far fa-clock me-2 text-muted"></i><?php echo esc_html($branch['hours1']); ?></p>
						<?php if ($branch['hours2']):?><p class="mb-1"><i class="far fa-clock me-2 text-muted" style="visibility: hidden;"></i><?php echo esc_html($branch['hours2']); ?></p><?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; // End if for branches section ?>

	<?php
	// If there's content in the contact page, display it AFTER the structured sections
	if (have_posts()) : // Reset loop to check for main page content
		while (have_posts()) :
			the_post();
			if (get_the_content()) : // Only show section if there is content
	?>
	<section class="contact-content-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
				</div>
			</div>
		</div>
	</section>
	<?php endif; endwhile; endif; ?>

</main><!-- #main -->

<?php
get_footer(); 