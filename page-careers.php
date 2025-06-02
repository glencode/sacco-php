<?php
/**
 * Template Name: Careers Page
 *
 * The template for displaying the Careers page.
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
					} else {
						// Basic breadcrumbs fallback
						?>
						<div class="breadcrumbs">
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sacco-php'); ?></a> &gt; 
							<?php the_title(); ?>
						</div>
						<?php
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
	
	<section class="careers-intro-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10 entry-content text-center">
					<?php 
					// Display main page content (e.g., intro to careers at the Sacco)
					the_content(); 
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="careers-why-work-here-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title"><?php esc_html_e('Why Work With Us?', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Join a dynamic team dedicated to financial empowerment and community growth.', 'sacco-php'); ?></p>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="reason-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="reason-icon display-4 text-primary mb-3"><i class="fas fa-users-cog"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Impactful Work', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Contribute to providing essential financial services that make a real difference in members\' lives.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="reason-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="reason-icon display-4 text-primary mb-3"><i class="fas fa-chart-bar"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Career Growth', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('We offer opportunities for professional development and career advancement within the organization.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="reason-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="reason-icon display-4 text-primary mb-3"><i class="fas fa-hands-helping"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Supportive Culture', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Be part of a collaborative and inclusive work environment that values teamwork and innovation.', 'sacco-php'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="careers-openings-section py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title"><?php esc_html_e('Current Openings', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Explore exciting career opportunities available at our Sacco. We are always looking for talented individuals to join our team.', 'sacco-php'); ?></p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php 
                    // Placeholder for job listings. This could be a loop from a CPT or ACF Repeater later.
                    // For now, a simple message if no content is added via editor, or display editor content.
                    $job_listings_content = get_post_meta(get_the_ID(), 'job_listings_placeholder_content', true);
                    $main_content_for_check = get_the_content(); // Get content once for checking

                    if (empty($job_listings_content) && !has_blocks($main_content_for_check) && trim($main_content_for_check) === '') { // If no specific block content, no custom field, and main content is empty
                    ?>
                        <div class="alert alert-info text-center" role="alert">
                            <p class="mb-0"><?php esc_html_e('There are currently no open positions. Please check back later or submit your CV for future consideration.', 'sacco-php'); ?></p>
                        </div>
                    <?php
                    } else if (!empty($job_listings_content)) {
                        echo '<div>' . wp_kses_post($job_listings_content) . '</div>'; // Example of custom field display
                    } else { // Fallback to display whatever is in the main content editor
                        the_content();
                    }
                    ?>
				</div>
            </div>
        </div>
    </section>

    <section class="careers-application-process-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title"><?php esc_html_e('How to Apply', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Interested in joining our team? Here\'s how you can apply for open positions or submit a general application.', 'sacco-php'); ?></p>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-md-8 text-center">
                    <p><?php esc_html_e('To apply for a specific position, please follow the instructions in the job posting. For general applications, you can email your CV and a cover letter to:', 'sacco-php'); ?></p>
                    <p class="h4"><a href="mailto:careers@example.com">careers@example.com</a></p> <?php // Replace with actual careers email ?>
                    <p class="mt-3 text-muted"><?php esc_html_e('We thank all applicants for their interest; however, only those selected for an interview will be contacted.', 'sacco-php'); ?></p>
                </div>
            </div>
        </div>
    </section>
	
	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<style>
.reason-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,.1) !important;
    transition: all .3s ease-in-out;
}
</style>

<?php
get_footer(); 