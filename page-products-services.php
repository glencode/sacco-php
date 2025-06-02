<?php
/**
 * Template Name: Products & Services Page
 *
 * The template for displaying the Products and Services overview.
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

	<section class="products-services-intro py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 mb-4 mb-lg-0">
					<div class="intro-content">
						<h2 class="mb-4"><?php echo esc_html(get_field('products_intro_title') ?: 'Financial Solutions Tailored for You'); ?></h2>
						<?php 
                        if (get_the_content()) {
                            the_content(); 
                        } else {
                            echo '<p class="lead">At our SACCO, we offer a comprehensive range of financial products and services designed to meet your needs at every stage of life. From flexible savings options to competitive loans, we are committed to helping you achieve financial success.</p>';
                            echo '<p>Our financial experts are always available to guide you through our offerings and help you make informed decisions about your financial future.</p>';
                        }
                        ?>
						<div class="mt-4">
							<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-primary me-2 mb-2">Become a Member</a>
							<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-outline-primary mb-2">Talk to an Advisor</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="intro-image">
							<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded shadow' ) ); ?>
						</div>
					<?php else : ?>
						<div class="intro-image">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/products-services-header.jpg" alt="Our Financial Solutions" class="img-fluid rounded shadow">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Helper function to display product cards (to avoid repetition)
	if (!function_exists('sacco_php_display_product_card')) {
		function sacco_php_display_product_card($post_id, $icon_class = 'fa-piggy-bank') {
			$title = get_the_title($post_id);
			$permalink = get_permalink($post_id);
			$excerpt = get_the_excerpt($post_id);
			if (empty($excerpt)) {
				$excerpt = wp_trim_words(get_the_content(null, false, $post_id), 20, '...');
			}
			// Example of getting a meta field, adjust as needed
			// $interest_rate = get_post_meta($post_id, 'interest_rate', true);
			$features_raw = get_post_meta($post_id, 'features', true);
			$features_list = !empty($features_raw) ? explode("\n", $features_raw) : array();

			echo '<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">';
			echo '<div class="product-card card h-100 border-0 shadow-sm w-100">';
			echo '<div class="card-body p-4 d-flex flex-column">';
			echo '<div class="product-icon mb-3 text-primary"><i class="fas ' . esc_attr($icon_class) . ' fa-2x"></i></div>';
			echo '<h3 class="card-title h4">' . esc_html($title) . '</h3>';
			echo '<p class="card-text">' . esc_html($excerpt) . '</p>';
			
			if (!empty($features_list)) {
				echo '<ul class="feature-list mb-4 mt-auto">';
				foreach ($features_list as $feature) {
					if (!empty(trim($feature))) {
						 echo '<li><i class="fas fa-check-circle text-primary me-2"></i>' . esc_html(trim($feature)) . '</li>';
					}
				}
				echo '</ul>';
			}
			
			echo '</div>'; // end card-body
			echo '<div class="card-footer bg-white border-0 p-4 pt-0">';
			echo '<a href="' . esc_url($permalink) . '" class="btn btn-outline-primary w-100">Learn More</a>';
			echo '</div>'; // end card-footer
			echo '</div>'; // end product-card
			echo '</div>'; // end col
		}
	}

	// Define categories for BOSA and FOSA (slugs - these need to be created in WP Admin)
	$bosa_savings_category_slug = 'bosa-savings'; 
	$fosa_savings_category_slug = 'fosa-savings';
	$bosa_loans_category_slug = 'bosa-loans';
	$fosa_loans_category_slug = 'fosa-loans';

	$product_sections = [
		[
			'title' => 'BOSA Savings Products',
			'subtitle' => 'Core savings solutions for long-term growth and share capital.',
			'post_type' => 'savings',
			'category_slug' => $bosa_savings_category_slug,
			'icon' => 'fa-landmark', // Example icon
			'bg_class' => 'bg-light'
		],
		[
			'title' => 'FOSA Savings Products',
			'subtitle' => 'Transactional and accessible savings accounts for your daily needs.',
			'post_type' => 'savings',
			'category_slug' => $fosa_savings_category_slug,
			'icon' => 'fa-wallet',
			'bg_class' => ''
		],
		[
			'title' => 'BOSA Loan Products',
			'subtitle' => 'Empowering your development and major projects with our core loan offerings.',
			'post_type' => 'loan',
			'category_slug' => $bosa_loans_category_slug,
			'icon' => 'fa-university',
			'bg_class' => 'bg-light'
		],
		[
			'title' => 'FOSA Loan Products',
			'subtitle' => 'Quick and accessible loans for your immediate financial needs.',
			'post_type' => 'loan',
			'category_slug' => $fosa_loans_category_slug,
			'icon' => 'fa-hand-holding-usd',
			'bg_class' => ''
		],
	];

	foreach ($product_sections as $section) {
		$args = array(
			'post_type' => $section['post_type'],
			'posts_per_page' => 6, // Show up to 6 products per section, adjust as needed
			'tax_query' => array(
				array(
					'taxonomy' => ($section['post_type'] === 'savings') ? 'savings_category' : 'loan_category',
					'field'    => 'slug',
					'terms'    => $section['category_slug'],
				),
			),
		);
		$products_query = new WP_Query($args);

		if ($products_query->have_posts()) :
	?>
	<section class="products-section py-5 <?php echo esc_attr($section['bg_class']); ?>">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title"><?php echo esc_html($section['title']); ?></h2>
					<p class="section-subtitle"><?php echo esc_html($section['subtitle']); ?></p>
				</div>
			</div>
			<div class="row">
				<?php
				while ($products_query->have_posts()) : $products_query->the_post();
					sacco_php_display_product_card(get_the_ID(), $section['icon']);
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<?php 
			// Optional: Link to archive page if more products exist
			$archive_link = get_post_type_archive_link($section['post_type']);
			$term_link = get_term_link($section['category_slug'], ($section['post_type'] === 'savings') ? 'savings_category' : 'loan_category');
			if ($archive_link && $products_query->found_posts > $section['posts_per_page'] && !is_wp_error($term_link)) {
				echo '<div class="row mt-4"><div class="col-12 text-center"><a href="' . esc_url($term_link) . '" class="btn btn-secondary">View All ' . esc_html($section['title']) . '</a></div></div>';
			}
			?>
		</div>
	</section>
	<?php
		endif; // end if products_query have_posts
	} // end foreach product_section
	?>

	<section class="product-calculators-cta py-5 bg-primary text-white">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-6 mb-3 mb-md-0">
					<h3 class="h4">Try Our Savings Calculator</h3>
					<p>Estimate your savings growth and plan for your goals effectively.</p>
					<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-light">Savings Calculator</a>
				</div>
				<div class="col-md-6">
					<h3 class="h4">Try Our Loan Calculator</h3>
					<p>Calculate potential loan repayments and understand your borrowing capacity.</p>
					<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-light">Loan Calculator</a>
				</div>
			</div>
		</div>
	</section>

	<?php 
	// Why Choose Us Section - This could be a reusable template part or ACF block
	// For now, keeping it simple as in the original, but consider dynamic population
	$why_choose_us_title = get_field('why_choose_us_title') ?: 'Why Choose Harambee SACCO?';
	$why_choose_us_subtitle = get_field('why_choose_us_subtitle') ?: 'Your trusted partner in financial growth and stability.';
	?>
	<section class="why-choose-us-section py-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title"><?php echo esc_html($why_choose_us_title); ?></h2>
					<p class="section-subtitle"><?php echo esc_html($why_choose_us_subtitle); ?></p>
				</div>
			</div>
			<div class="row">
				<?php 
				// Example static items - ideally make these dynamic (e.g., from a CPT or ACF Repeater)
				$choose_us_items = array(
					array('icon' => 'fa-shield-alt', 'title' => 'Secure & Regulated', 'text' => 'We are regulated by SASRA, ensuring your funds are safe and operations are transparent.'),
					array('icon' => 'fa-users', 'title' => 'Member-Focused', 'text' => 'Our members are our priority. We provide personalized services and support.'),
					array('icon' => 'fa-chart-line', 'title' => 'Competitive Rates', 'text' => 'Enjoy attractive interest rates on savings and affordable terms on loans.'),
					array('icon' => 'fa-cogs', 'title' => 'Innovative Solutions', 'text' => 'We leverage technology to offer convenient and modern banking solutions.')
				);
				foreach($choose_us_items as $item) : ?>
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="choose-us-card text-center p-4 border rounded h-100">
						<div class="choose-us-icon text-primary mb-3">
							<i class="fas <?php echo esc_attr($item['icon']); ?> fa-3x"></i>
						</div>
						<h3 class="h5"><?php echo esc_html($item['title']); ?></h3>
						<p><?php echo esc_html($item['text']); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php 
	// Testimonials Section - This should ideally use the Testimonial CPT
	$testimonials_query = new WP_Query(array(
		'post_type' => 'testimonial', // Make sure 'testimonial' CPT is registered
		'posts_per_page' => 3,
		'orderby' => 'rand'
	));

	if ($testimonials_query->have_posts()) :
	?>
	<section class="testimonials-section py-5 bg-light">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 text-center">
					<h2 class="section-title">What Our Members Say</h2>
				</div>
			</div>
			<div class="row">
				<?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>
				<div class="col-md-4 mb-4 d-flex align-items-stretch">
					<div class="testimonial-card card h-100 border-0 shadow-sm">
						<div class="card-body p-4 text-center">
							<?php if(has_post_thumbnail()): ?>
								<?php the_post_thumbnail('thumbnail', array('class' => 'testimonial-image rounded-circle mb-3 mx-auto', 'style' => 'width: 80px; height: 80px; object-fit: cover;')); ?>
							<?php else: ?>
								<i class="fas fa-user-circle fa-3x text-muted mb-3"></i>
							<?php endif; ?>
							<p class="testimonial-text fst-italic">"<?php echo get_the_excerpt(); ?>"</p>
							<h5 class="testimonial-author mt-3 mb-0"><?php the_title(); ?></h5>
						</div>
					</div>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="cta-section py-5">
		<div class="container text-center">
			<h2 class="mb-4">Ready to Take Control of Your Finances?</h2>
			<p class="lead mb-4">Join thousands of satisfied members who are building a brighter financial future with us.</p>
			<a href="<?php echo esc_url(home_url('/membership/how-to-join/')); ?>" class="btn btn-primary btn-lg me-2 mb-2">Join Harambee SACCO</a>
			<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-outline-secondary btn-lg mb-2">Contact Us</a>
		</div>
	</section>

</main><!-- #main -->

<?php get_footer(); ?> 