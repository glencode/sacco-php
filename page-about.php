<?php
/**
 * Template Name: About Page
 *
 * The template for displaying the about page.
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

	<?php
	while ( have_posts() ) :
		the_post();
	?>
	
	<section class="about-intro-section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="about-intro-content">
						<?php 
						$supertitle = get_field('about_intro_supertitle') ?: esc_html__( 'About Us', 'sacco-php' );
						$intro_title = get_field('about_intro_title') ?: 'Welcome to ' . get_bloginfo('name'); 
						$lead_text = get_field('about_intro_lead_text') ?: esc_html__( 'We are dedicated to providing innovative financial solutions that empower our members to achieve their financial goals.', 'sacco-php' );
						?>
						<h5 class="text-primary fw-bold text-uppercase mb-2"><?php echo esc_html($supertitle); ?></h5>
						<h2 class="display-5 fw-bold mb-3"><?php echo esc_html($intro_title); ?></h2>
						<p class="lead mb-4"><?php echo esc_html($lead_text); ?></p>
						<div class="about-intro-text entry-content">
							<?php the_content(); // Main content from WP editor ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="about-intro-image text-center">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow-lg' ) ); ?>
						<?php else : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/default-about.jpg" alt="About <?php bloginfo('name'); ?>" class="img-fluid rounded shadow-lg">
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php endwhile; // End of the loop. ?>
	
	<section class="about-values-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title"><?php echo esc_html(get_field('core_values_title') ?: 'Our Core Values'); ?></h2>
					<p class="section-subtitle"><?php echo esc_html(get_field('core_values_subtitle') ?: 'The principles that guide us in serving our members'); ?></p>
				</div>
			</div>
			<div class="row gy-4">
				<?php
				$core_values = get_field('core_values');
				if ($core_values && is_array($core_values)) :
					foreach ($core_values as $value) :
						$icon = isset($value['value_icon']) && $value['value_icon'] ? $value['value_icon'] : 'fa-check-circle';
						$title = isset($value['value_title']) && $value['value_title'] ? $value['value_title'] : 'Our Value';
						$description = isset($value['value_description']) && $value['value_description'] ? $value['value_description'] : 'Description of our value.';
				?>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch">
					<div class="value-card card h-100 text-center p-4 shadow-sm border-0">
						<div class="value-icon display-4 text-primary mb-3">
							<i class="fas <?php echo esc_attr($icon); ?>"></i>
						</div>
						<h3 class="h5 fw-bold"><?php echo esc_html($title); ?></h3>
						<p class="small text-muted"><?php echo esc_html($description); ?></p>
					</div>
				</div>
				<?php 
					endforeach;
				else : // Fallback static values
				?>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch">
					<div class="value-card card h-100 text-center p-4 shadow-sm border-0">
						<div class="value-icon display-4 text-primary mb-3"><i class="fas fa-handshake"></i></div>
						<h3 class="h5 fw-bold">Integrity</h3>
						<p class="small text-muted">We conduct our business with the highest standards of ethics, honesty, and transparency in all our dealings.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch">
					<div class="value-card card h-100 text-center p-4 shadow-sm border-0">
						<div class="value-icon display-4 text-primary mb-3"><i class="fas fa-users"></i></div>
						<h3 class="h5 fw-bold">Member-Centric</h3>
						<p class="small text-muted">Our members are at the heart of everything we do. We strive to understand and meet their unique needs.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 d-flex align-items-stretch">
					<div class="value-card card h-100 text-center p-4 shadow-sm border-0">
						<div class="value-icon display-4 text-primary mb-3"><i class="fas fa-chart-line"></i></div>
						<h3 class="h5 fw-bold">Innovation</h3>
						<p class="small text-muted">We continuously seek new and better ways to serve our members and improve our products and services.</p>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	
	<section class="about-team-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<h2 class="section-title"><?php echo esc_html(get_field('leadership_team_title') ?: 'Our Leadership Team'); ?></h2>
					<p class="section-subtitle"><?php echo esc_html(get_field('leadership_team_subtitle') ?: 'Meet the dedicated team behind ' . get_bloginfo('name')); ?></p>
				</div>
			</div>
			<div class="row gy-4 justify-content-center">
				<?php
				$team_members = get_field('leadership_team_members');
				if ($team_members && is_array($team_members)) :
					foreach ($team_members as $member) :
						$image_url = isset($member['member_image']) && $member['member_image'] ? wp_get_attachment_image_url($member['member_image'], 'medium') : get_template_directory_uri() . '/assets/img/team-placeholder.jpg';
						$name = isset($member['member_name']) && $member['member_name'] ? $member['member_name'] : 'Team Member';
						$position = isset($member['member_position']) && $member['member_position'] ? $member['member_position'] : 'Position';
						$linkedin = isset($member['member_linkedin_url']) ? $member['member_linkedin_url'] : '';
						$twitter = isset($member['member_twitter_url']) ? $member['member_twitter_url'] : '';
						// $bio_summary = isset($member['member_bio_summary']) ? $member['member_bio_summary'] : ''; // For future use
				?>
				<div class="col-lg-3 col-md-6 d-flex align-items-stretch">
					<div class="team-card card h-100 text-center shadow-sm border-0 overflow-hidden">
						<div class="team-image-wrap ratio ratio-1x1">
							<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" class="team-image img-fluid object-fit-cover">
						</div>
						<div class="team-info card-body p-3">
							<h3 class="h5 fw-bold mb-1"><?php echo esc_html($name); ?></h3>
							<p class="team-position text-primary small mb-2"><?php echo esc_html($position); ?></p>
							<?php if ($linkedin || $twitter) : ?>
							<div class="team-social mt-2">
								<?php if ($linkedin) : ?><a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm border-0 me-1"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
								<?php if ($twitter) : ?><a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm border-0"><i class="fab fa-twitter"></i></a><?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php 
					endforeach;
				else : // Fallback static team members
					for ($i = 0; $i < 4; $i++) : // Display 4 placeholder cards
				?>
				<div class="col-lg-3 col-md-6 d-flex align-items-stretch">
					<div class="team-card card h-100 text-center shadow-sm border-0 overflow-hidden">
						<div class="team-image-wrap ratio ratio-1x1">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/team-placeholder.jpg" alt="Team Member" class="team-image img-fluid object-fit-cover">
						</div>
						<div class="team-info card-body p-3">
							<h3 class="h5 fw-bold mb-1">Team Member <?php echo $i+1; ?></h3>
							<p class="team-position text-primary small mb-2">Position</p>
							<div class="team-social mt-2">
								<a href="#" class="btn btn-outline-secondary btn-sm border-0 me-1"><i class="fab fa-linkedin-in"></i></a>
								<a href="#" class="btn btn-outline-secondary btn-sm border-0"><i class="fab fa-twitter"></i></a>
							</div>
						</div>
					</div>
				</div>
				<?php endfor; ?>
				<?php endif; ?>
			</div>
			<?php 
			// Link to dedicated management/board pages if they exist
			$management_page = get_page_by_path('management-team'); // slug for management page
			$board_page = get_page_by_path('board-of-directors'); // slug for board page
			if ($management_page || $board_page) : ?>
			<div class="row mt-5">
				<div class="col-12 text-center">
					<?php if ($management_page): ?>
						<a href="<?php echo esc_url(get_permalink($management_page->ID)); ?>" class="btn btn-outline-primary me-2">Meet The Management</a>
					<?php endif; ?>
					<?php if ($board_page): ?>
						<a href="<?php echo esc_url(get_permalink($board_page->ID)); ?>" class="btn btn-outline-primary">Meet The Board</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</section>
	
	<section class="about-cta-section py-5 bg-primary text-white">
		<div class="container">
			<div class="row align-items-center text-center text-md-start">
				<div class="col-lg-8 col-md-7">
					<h2 class="cta-title mb-3"><?php echo esc_html(get_field('about_cta_title') ?: 'Join Our Community Today'); ?></h2>
					<p class="cta-text lead mb-md-0"><?php echo esc_html(get_field('about_cta_text') ?: 'Become a member and take advantage of our financial products and services.'); ?></p>
				</div>
				<div class="col-lg-4 col-md-5 text-md-end mt-4 mt-md-0">
					<a href="<?php echo esc_url(get_field('about_cta_button_url') ?: home_url('/membership/')); ?>" class="btn btn-light btn-lg shadow-sm">
						<?php echo esc_html(get_field('about_cta_button_text') ?: 'Become a Member'); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 