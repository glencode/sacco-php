<?php
/**
 * Template Name: Membership Page
 *
 * The template for displaying the Membership page.
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
	
	<section class="membership-intro-section py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10 entry-content text-center">
					<?php 
					// Display main page content first (could be an intro)
					the_content(); 
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="membership-benefits-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title"><?php esc_html_e('Why Join Us?', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Discover the advantages of becoming a member of our Sacco community.', 'sacco-php'); ?></p>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-piggy-bank"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Competitive Savings Products', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Access a variety of savings accounts with attractive interest rates to help you grow your money.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-hand-holding-usd"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Affordable Loan Options', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Get access to loans with favorable terms and quick processing to meet your financial needs.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-chart-line"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Financial Advisory', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Receive expert financial advice and guidance to help you make informed decisions and achieve your goals.', 'sacco-php'); ?></p>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-users"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Community Focused', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Be part of a supportive community that prioritizes member well-being and mutual growth.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-shield-alt"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Secure & Regulated', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Your savings are secure with us. We are licensed and regulated by SASRA, ensuring compliance and safety.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="benefit-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="benefit-icon display-4 text-primary mb-3"><i class="fas fa-laptop-house"></i></div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Convenient Services', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Access your accounts and our services easily through online and mobile banking platforms.', 'sacco-php'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="membership-eligibility-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title mb-3"><?php esc_html_e('Who Can Join?', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Our Sacco welcomes individuals who meet the following criteria. We are an inclusive community aimed at financial empowerment.', 'sacco-php'); ?></p>
                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php esc_html_e('Kenyan citizen with a valid National ID.', 'sacco-php'); ?></li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php esc_html_e('Minimum age of 18 years.', 'sacco-php'); ?></li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php esc_html_e('Salaried employees of recognized organizations.', 'sacco-php'); ?></li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php esc_html_e('Members of registered groups or chamas.', 'sacco-php'); ?></li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-primary me-2"></i><?php esc_html_e('Individuals with regular income from known sources.', 'sacco-php'); ?></li>
                    </ul>
                     <p class="mt-3 small text-muted"><?php esc_html_e('Specific eligibility may vary for certain products or services. Please contact us for more details.', 'sacco-php'); ?></p>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/membership-eligibility.jpg" alt="<?php esc_attr_e('Membership Eligibility', 'sacco-php'); ?>" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="membership-application-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 offset-md-2">
                    <h2 class="section-title"><?php esc_html_e('How to Join', 'sacco-php'); ?></h2>
                    <p class="lead"><?php esc_html_e('Follow these simple steps to become a member of our Sacco and start enjoying the benefits.', 'sacco-php'); ?></p>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                    <div class="step-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="step-number display-4 text-primary fw-bold mb-2">1</div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Download Form', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Get the membership application form from our website or any branch.', 'sacco-php'); ?></p>
                         <a href="<?php echo esc_url(home_url('/downloads/')); ?>" class="btn btn-sm btn-outline-primary mt-auto"><?php esc_html_e('Find Forms', 'sacco-php'); ?></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                    <div class="step-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="step-number display-4 text-primary fw-bold mb-2">2</div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Fill & Submit', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Complete the form and attach copies of your ID, KRA PIN, and passport photos.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                    <div class="step-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="step-number display-4 text-primary fw-bold mb-2">3</div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Pay Fee', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Pay the one-time membership registration fee as applicable.', 'sacco-php'); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                    <div class="step-card card text-center p-4 shadow-sm border-0 h-100">
                        <div class="step-number display-4 text-primary fw-bold mb-2">4</div>
                        <h3 class="h5 fw-bold"><?php esc_html_e('Start Saving', 'sacco-php'); ?></h3>
                        <p class="small text-muted"><?php esc_html_e('Begin your savings journey and access our wide range of financial solutions.', 'sacco-php'); ?></p>
                    </div>
                </div>
            </div>
             <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('Get Started Today', 'sacco-php'); ?>
                    </a>
                     <a href="<?php echo esc_url(home_url('/member-portal/')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
                        <?php esc_html_e('Member Login', 'sacco-php'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
	
	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<style>
.benefit-card:hover, .step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,.1) !important;
    transition: all .3s ease-in-out;
}
.list-group-item {
    border-left: 0;
    border-right: 0;
    padding-left: 0;
}
.list-group-item:first-child { border-top:0; }
.list-group-item:last-child { border-bottom:0; }
</style>

<?php
get_footer(); 