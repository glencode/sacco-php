<?php
/**
 * The template for displaying the homepage.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

	<main id="primary" class="site-main">

		<!-- Hero Slider Section -->
		<section class="hero-section">
			<div class="hero-slider swiper">
				<div class="floating-quick-nav bg-white rounded-3 shadow-lg py-3">
					<div class="container">
						<div class="row g-3">
							<div class="col-6 col-md-3">
								<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="quick-nav-item">
									<i class="fas fa-hand-holding-usd fa-lg"></i>
									<span><?php esc_html_e('Quick Loan', 'sacco-php'); ?></span>
								</a>
							</div>
							<div class="col-6 col-md-3">
								<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="quick-nav-item">
									<i class="fas fa-calculator fa-lg"></i>
									<span><?php esc_html_e('Loan Calculator', 'sacco-php'); ?></span>
								</a>
							</div>
							<div class="col-6 col-md-3">
								<a href="<?php echo esc_url(home_url('/online-banking/')); ?>" class="quick-nav-item">
									<i class="fas fa-laptop fa-lg"></i>
									<span><?php esc_html_e('Online Banking', 'sacco-php'); ?></span>
								</a>
							</div>
							<div class="col-6 col-md-3">
								<a href="<?php echo esc_url(home_url('/how-to-join/')); ?>" class="quick-nav-item">
									<i class="fas fa-user-plus fa-lg"></i>
									<span><?php esc_html_e('Join Now', 'sacco-php'); ?></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="swiper-wrapper">
					<?php
					// Get slides from custom post type
					$slides = new WP_Query(array(
						'post_type' => 'slide',
						'posts_per_page' => -1,
						'orderby' => 'menu_order',
						'order' => 'ASC',
					));
					
					if ($slides->have_posts()) :
						while ($slides->have_posts()) : $slides->the_post();
							$slide_bg = get_the_post_thumbnail_url(get_the_ID(), 'full');
							if (!$slide_bg) {
								$slide_bg = get_template_directory_uri() . '/assets/img/default-slide.jpg';
							}

							$slide_link_url = get_post_meta(get_the_ID(), '_slide_link_url', true);
							$slide_button_text = get_post_meta(get_the_ID(), '_slide_button_text', true);
							$slide_button_url = get_post_meta(get_the_ID(), '_slide_button_url', true);
							
							$slide_tag_open = $slide_link_url ? '<a href="' . esc_url($slide_link_url) . '" class="swiper-slide-link">' : '';
							$slide_tag_close = $slide_link_url ? '</a>' : '';
					?>
					<?php echo $slide_tag_open; ?>
					<div class="swiper-slide" style="background-image: url('<?php echo esc_url($slide_bg); ?>');">
						<div class="slide-content-wrap">
							<div class="container">
								<div class="row">
									<div class="col-lg-8 col-md-10">
										<div class="slide-content">
											<h2 class="slide-title"><?php the_title(); ?></h2>
											<div class="slide-subtitle">
												<?php the_content(); ?>
											</div>
											<?php
											// Display button only if there's no whole slide link, or if specifically designed to coexist
											if (empty($slide_link_url) && $slide_button_text && $slide_button_url) :
											?>
											<div class="slide-buttons">
												<a href="<?php echo esc_url($slide_button_url); ?>" class="btn btn-primary"><?php echo esc_html($slide_button_text); ?></a>
											</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php echo $slide_tag_close; ?>
					<?php
						endwhile;
						wp_reset_postdata();
					else :
						// Default slide if no custom slides created
					?>
					<div class="swiper-slide" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/default-slide.jpg');">
						<div class="slide-content-wrap">
							<div class="container">
								<div class="row">
									<div class="col-lg-8 col-md-10">
										<div class="slide-content">
											<h2 class="slide-title"><?php echo esc_html(get_theme_mod('default_slide_title', 'Welcome to Our Sacco')); ?></h2>
											<div class="slide-subtitle">
												<p><?php echo esc_html(get_theme_mod('default_slide_subtitle', 'Empowering your financial journey.')); ?></p>
											</div>
											<div class="slide-buttons">
												<a href="<?php echo esc_url(get_theme_mod('default_slide_button_url', '#about-us')); ?>" class="btn btn-primary"><?php echo esc_html(get_theme_mod('default_slide_button_text', 'Learn More')); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<!-- Navigation buttons -->
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
				<!-- Pagination -->
				<div class="swiper-pagination"></div>
			</div>
			
			<!-- Add Scroll Down Button -->
			<div class="scroll-down-btn">
				<a href="#features" class="scroll-link">
					<i class="fas fa-chevron-down"></i>
					<span class="sr-only">Scroll to next section</span>
				</a>
			</div>
		</section>

		<!-- Key Features Section -->
		<section id="features" class="key-features-section py-5">
			<div class="container">
				<div class="row text-center mb-5">
					<div class="col-lg-8 mx-auto">
						<h2 class="section-title" data-aos="fade-up">Our Key Features</h2>
						<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
							Discover the benefits that make us your trusted financial partner
						</p>
					</div>
				</div>
				<div class="row g-4">
					<div class="col-lg-3 col-md-6">
						<div class="feature-card h-100" data-aos="fade-up" data-aos-delay="0">
							<div class="feature-icon">
								<i class="fas fa-shield-alt"></i>
							</div>
							<h3><?php esc_html_e('Secure & Licensed', 'sacco-php'); ?></h3>
							<p><?php esc_html_e('Licensed by SASRA with protected deposits', 'sacco-php'); ?></p>
							<div class="feature-hover">
								<a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="btn btn-sm btn-outline-primary mt-3">Learn More</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="feature-card h-100" data-aos="fade-up" data-aos-delay="100">
							<div class="feature-icon">
								<i class="fas fa-percentage"></i>
							</div>
							<h3><?php esc_html_e('Best Rates', 'sacco-php'); ?></h3>
							<p><?php esc_html_e('Competitive interest rates on savings and loans', 'sacco-php'); ?></p>
							<div class="feature-hover">
								<a href="<?php echo esc_url(home_url('/products-services/')); ?>" class="btn btn-sm btn-outline-primary mt-3">View Rates</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="feature-card h-100" data-aos="fade-up" data-aos-delay="200">
							<div class="feature-icon">
								<i class="fas fa-mobile-alt"></i>
							</div>
							<h3><?php esc_html_e('Digital Banking', 'sacco-php'); ?></h3>
							<p><?php esc_html_e('24/7 access through our mobile app', 'sacco-php'); ?></p>
							<div class="feature-hover">
								<a href="<?php echo esc_url(home_url('/online-banking/')); ?>" class="btn btn-sm btn-outline-primary mt-3">Get Started</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="feature-card h-100" data-aos="fade-up" data-aos-delay="300">
							<div class="feature-icon">
								<i class="fas fa-handshake"></i>
							</div>
							<h3><?php esc_html_e('Member Support', 'sacco-php'); ?></h3>
							<p><?php esc_html_e('Dedicated support team for all members', 'sacco-php'); ?></p>
							<div class="feature-hover">
								<a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="btn btn-sm btn-outline-primary mt-3">Contact Us</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Stats Section -->
		<section class="stats-section py-5 bg-light">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title">Our Impact in Numbers</h2>
						<p class="section-subtitle">Growing stronger together with our members</p>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-3 col-md-6 mb-4">
						<div class="stat-card text-center" data-aos="fade-up" data-aos-delay="0">
							<div class="stat-icon bg-primary-soft mb-3">
								<i class="fas fa-users fa-2x text-primary"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold mb-2" data-value="25000">0</h3>
							<p class="stat-label">Active Members</p>
							<div class="stat-progress">
								<div class="progress" style="height: 4px;">
									<div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 mb-4">
						<div class="stat-card text-center" data-aos="fade-up" data-aos-delay="100">
							<div class="stat-icon bg-success-soft mb-3">
								<i class="fas fa-money-bill-wave fa-2x text-success"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold mb-2" data-value="800">0</h3>
							<p class="stat-label">Million in Assets</p>
							<div class="stat-progress">
								<div class="progress" style="height: 4px;">
									<div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 mb-4">
						<div class="stat-card text-center" data-aos="fade-up" data-aos-delay="200">
							<div class="stat-icon bg-info-soft mb-3">
								<i class="fas fa-chart-line fa-2x text-info"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold mb-2" data-value="25">0</h3>
							<p class="stat-label">Years of Service</p>
							<div class="stat-progress">
								<div class="progress" style="height: 4px;">
									<div class="progress-bar bg-info" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 mb-4">
						<div class="stat-card text-center" data-aos="fade-up" data-aos-delay="300">
							<div class="stat-icon bg-warning-soft mb-3">
								<i class="fas fa-award fa-2x text-warning"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold mb-2" data-value="15">0</h3>
							<p class="stat-label">Branch Locations</p>
							<div class="stat-progress">
								<div class="progress" style="height: 4px;">
									<div class="progress-bar bg-warning" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Quick Links/Actions Section -->
		<section class="quick-actions-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title" data-aos="fade-up">How Can We Help You Today?</h2>
						<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Quick access to our most popular services and resources</p>
					</div>
				</div>
				<div class="row justify-content-center g-4">
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
						<div class="quick-action-card">
							<div class="quick-action-icon">
								<i class="fas fa-hand-holding-usd"></i>
							</div>
							<h3>Apply for a Loan</h3>
							<p>Get quick access to flexible loan options with competitive rates</p>
							<div class="quick-action-features">
								<ul class="list-unstyled">
									<li><i class="fas fa-check-circle text-success"></i> Fast approval process</li>
									<li><i class="fas fa-check-circle text-success"></i> Competitive interest rates</li>
									<li><i class="fas fa-check-circle text-success"></i> Flexible repayment terms</li>
								</ul>
							</div>
							<a href="<?php echo esc_url(home_url('/loan-application/')); ?>" class="btn btn-primary mt-3">Apply Now</a>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
						<div class="quick-action-card">
							<div class="quick-action-icon">
								<i class="fas fa-piggy-bank"></i>
							</div>
							<h3>Start Saving</h3>
							<p>Explore our range of savings products designed for your goals</p>
							<div class="quick-action-features">
								<ul class="list-unstyled">
									<li><i class="fas fa-check-circle text-success"></i> High interest returns</li>
									<li><i class="fas fa-check-circle text-success"></i> Multiple savings options</li>
									<li><i class="fas fa-check-circle text-success"></i> Easy account management</li>
								</ul>
							</div>
							<a href="<?php echo esc_url(home_url('/savings-accounts/')); ?>" class="btn btn-primary mt-3">Learn More</a>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
						<div class="quick-action-card">
							<div class="quick-action-icon">
								<i class="fas fa-calculator"></i>
							</div>
							<h3>Financial Calculators</h3>
							<p>Plan your finances with our easy-to-use calculators</p>
							<div class="quick-action-features">
								<ul class="list-unstyled">
									<li><i class="fas fa-check-circle text-success"></i> Loan calculator</li>
									<li><i class="fas fa-check-circle text-success"></i> Savings calculator</li>
									<li><i class="fas fa-check-circle text-success"></i> Retirement planning</li>
								</ul>
							</div>
							<div class="btn-group w-100" role="group">
								<a href="<?php echo esc_url(home_url('/loan-calculator/')); ?>" class="btn btn-outline-primary mt-3">Loan Calculator</a>
								<a href="<?php echo esc_url(home_url('/savings-calculator/')); ?>" class="btn btn-outline-primary mt-3">Savings Calculator</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Why Choose Us Section -->
		<?php
		// Get Why Choose Us section content from ACF or fall back to defaults
		$why_choose_us_title = get_field('why_choose_us_title') ?: esc_html__('Why Choose Us', 'sacco-php');
		$why_choose_us_subtitle = get_field('why_choose_us_subtitle') ?: esc_html__('Discover the advantages of banking with us', 'sacco-php');
		$why_choose_us_cards = get_field('why_choose_us_cards');

		// Fallback cards if none are set in ACF
		if (!$why_choose_us_cards || !is_array($why_choose_us_cards)) {
			$why_choose_us_cards = array(
				array(
					'icon' => 'fa-shield-alt',
					'title' => esc_html__('Secure & Licensed', 'sacco-php'),
					'description' => esc_html__('We are fully licensed and regulated, ensuring your finances are in safe hands.', 'sacco-php')
				),
				array(
					'icon' => 'fa-percentage',
					'title' => esc_html__('Competitive Rates', 'sacco-php'),
					'description' => esc_html__('Enjoy attractive interest rates on savings and favorable loan terms.', 'sacco-php')
				),
				array(
					'icon' => 'fa-handshake',
					'title' => esc_html__('Member-Focused', 'sacco-php'),
					'description' => esc_html__('Your success is our priority. We\'re committed to helping you achieve your financial goals.', 'sacco-php')
				)
			);
		}
		?>
		<section class="why-choose-us-section philosophy-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($why_choose_us_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($why_choose_us_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center g-4">
					<?php 
					if ($why_choose_us_cards && is_array($why_choose_us_cards)) :
						foreach ($why_choose_us_cards as $index => $card) :
							$icon = !empty($card['icon']) ? $card['icon'] : 'fa-check-circle';
							$title = !empty($card['title']) ? $card['title'] : esc_html__('Our Value', 'sacco-php');
							$description = !empty($card['description']) ? $card['description'] : esc_html__('Description of our value.', 'sacco-php');
					?>
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
						<div class="philosophy-card text-center h-100">
							<div class="philosophy-icon">
								<i class="fas <?php echo esc_attr($icon); ?>"></i>
							</div>
							<h3 class="philosophy-title"><?php echo esc_html($title); ?></h3>
							<p class="philosophy-desc"><?php echo esc_html($description); ?></p>
						</div>
					</div>
					<?php 
						endforeach;
					endif; 
					?>
				</div>
			</div>
		</section>
		
		<!-- Products Section -->
		<?php
		$products_title = get_field('home_products_title') ?: esc_html__('Our Financial Products', 'sacco-php');
		$products_subtitle = get_field('home_products_subtitle') ?: esc_html__('Explore our range of savings and loan products designed for your needs', 'sacco-php');
		$featured_products = get_field('home_featured_products');
		?>
		<section class="products-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title" data-aos="fade-up"><?php echo esc_html($products_title); ?></h2>
						<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html($products_subtitle); ?></p>
					</div>
				</div>
				<div class="row g-4">
					<?php
					if ($featured_products) :
						foreach ($featured_products as $post) :
							setup_postdata($post);
							$product_type = get_post_type();
							$icon_class = '';
							switch ($product_type) {
								case 'savings':
									$icon_class = 'fa-piggy-bank';
									$card_color = 'primary';
									break;
								case 'loan':
									$icon_class = 'fa-hand-holding-usd';
									$card_color = 'success';
									break;
								default:
									$icon_class = 'fa-star';
									$card_color = 'info';
							}
					?>
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $loop_index * 100; ?>">
						<div class="product-card h-100">
							<div class="product-card-header bg-<?php echo $card_color; ?>-soft p-4">
								<div class="product-icon">
									<i class="fas <?php echo $icon_class; ?> text-<?php echo $card_color; ?>"></i>
								</div>
								<h3 class="product-title h5 mb-0">
									<a href="<?php the_permalink(); ?>" class="stretched-link"><?php the_title(); ?></a>
								</h3>
							</div>
							<div class="product-card-body p-4">
								<div class="product-excerpt mb-3">
									<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
								</div>
								<div class="product-features">
									<?php
									$features = get_field('product_features');
									if ($features) :
									?>
									<ul class="list-unstyled mb-0">
										<?php foreach (array_slice($features, 0, 3) as $feature) : ?>
										<li><i class="fas fa-check-circle text-<?php echo $card_color; ?> me-2"></i><?php echo esc_html($feature['feature']); ?></li>
										<?php endforeach; ?>
									</ul>
									<?php endif; ?>
								</div>
							</div>
							<div class="product-card-footer p-4 pt-0">
								<div class="d-grid">
									<a href="<?php the_permalink(); ?>" class="btn btn-outline-<?php echo $card_color; ?>">Learn More</a>
								</div>
							</div>
						</div>
					</div>
					<?php
						endforeach;
						wp_reset_postdata();
					else :
						// Fallback if no products are set
						$product_types = array(
							array('title' => 'Regular Savings', 'icon' => 'fa-piggy-bank', 'color' => 'primary', 'features' => array('Competitive interest rates', 'Easy access to funds', 'No minimum balance')),
							array('title' => 'Personal Loans', 'icon' => 'fa-hand-holding-usd', 'color' => 'success', 'features' => array('Quick approval process', 'Flexible terms', 'Competitive rates')),
							array('title' => 'Investment Plans', 'icon' => 'fa-chart-line', 'color' => 'info', 'features' => array('High returns', 'Long-term growth', 'Professional management'))
						);
						foreach ($product_types as $index => $product) :
					?>
					<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
						<div class="product-card h-100">
							<div class="product-card-header bg-<?php echo $product['color']; ?>-soft p-4">
								<div class="product-icon">
									<i class="fas <?php echo $product['icon']; ?> text-<?php echo $product['color']; ?>"></i>
								</div>
								<h3 class="product-title h5 mb-0">
									<a href="#" class="stretched-link"><?php echo esc_html($product['title']); ?></a>
								</h3>
							</div>
							<div class="product-card-body p-4">
								<div class="product-excerpt mb-3">
									<?php echo esc_html__('Experience the best financial solutions tailored to your needs.', 'sacco-php'); ?>
								</div>
								<div class="product-features">
									<ul class="list-unstyled mb-0">
										<?php foreach ($product['features'] as $feature) : ?>
										<li><i class="fas fa-check-circle text-<?php echo $product['color']; ?> me-2"></i><?php echo esc_html($feature); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<div class="product-card-footer p-4 pt-0">
								<div class="d-grid">
									<a href="#" class="btn btn-outline-<?php echo $product['color']; ?>">Learn More</a>
								</div>
							</div>
						</div>
					</div>
					<?php
						endforeach;
					endif;
					?>
				</div>
				<div class="row mt-5">
					<div class="col-12 text-center">
						<a href="<?php echo esc_url(home_url('/products-services/')); ?>" class="btn btn-primary btn-lg">View All Products & Services</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Mobile Banking / App CTA Section -->
		<?php 
		$mobile_app_enable = get_field('home_mobile_app_enable');
		if ($mobile_app_enable || is_customize_preview()) : // Show if enabled or in customizer
			$mobile_app_title = get_field('home_mobile_app_title') ?: esc_html__('Access Your Accounts on the Go', 'sacco-php');
			$mobile_app_subtitle = get_field('home_mobile_app_subtitle') ?: esc_html__('Download our mobile app for easy and secure banking.', 'sacco-php');
			$mobile_app_description = get_field('home_mobile_app_description') ?: esc_html__('Manage your finances anytime, anywhere. Check balances, transfer funds, pay bills, and much more, all from the convenience of your smartphone.', 'sacco-php');
			$mobile_app_image = get_field('home_mobile_app_image');
			$google_play_url = get_field('home_mobile_app_google_play_url');
			$google_play_image = get_field('home_mobile_app_google_play_image');
			$apple_store_url = get_field('home_mobile_app_apple_store_url');
			$apple_store_image = get_field('home_mobile_app_apple_store_image');
		?>
			<section class="mobile-app-cta-section py-5">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-6 <?php echo $mobile_app_image ? 'order-lg-2' : ''; ?> text-center text-lg-start mb-4 mb-lg-0">
							<h2 class="section-title"><?php echo esc_html($mobile_app_title); ?></h2>
							<p class="section-subtitle fs-5"><?php echo esc_html($mobile_app_subtitle); ?></p>
							<p><?php echo nl2br(esc_html($mobile_app_description)); ?></p>
							<div class="app-store-badges mt-4">
								<?php if ($google_play_url && $google_play_image) : ?>
									<a href="<?php echo esc_url($google_play_url); ?>" target="_blank" class="me-2">
										<img src="<?php echo esc_url($google_play_image['url']); ?>" 
											 alt="<?php echo esc_attr($google_play_image['alt'] ?: 'Get it on Google Play'); ?>" 
											 class="img-fluid app-badge">
									</a>
								<?php elseif ($google_play_url) : ?>
									<a href="<?php echo esc_url($google_play_url); ?>" target="_blank" class="btn btn-dark me-2">
										<i class="fab fa-google-play"></i> Google Play
									</a>
								<?php endif; ?>

								<?php if ($apple_store_url && $apple_store_image) : ?>
									<a href="<?php echo esc_url($apple_store_url); ?>" target="_blank">
										<img src="<?php echo esc_url($apple_store_image['url']); ?>" 
											 alt="<?php echo esc_attr($apple_store_image['alt'] ?: 'Download on the App Store'); ?>" 
											 class="img-fluid app-badge">
									</a>
								<?php elseif ($apple_store_url) : ?>
									<a href="<?php echo esc_url($apple_store_url); ?>" target="_blank" class="btn btn-dark">
										<i class="fab fa-app-store-ios"></i> App Store
									</a>
								<?php endif; ?>

								<?php if (empty($google_play_url) && empty($apple_store_url) && is_customize_preview()) : ?>
									<a href="#" class="btn btn-dark me-2">
										<i class="fab fa-google-play"></i> Google Play (Sample)
									</a>
									<a href="#" class="btn btn-dark">
										<i class="fab fa-app-store-ios"></i> App Store (Sample)
									</a>
								<?php endif; ?>
							</div>
						</div>
						<?php if ($mobile_app_image) : ?>
							<div class="col-lg-6 <?php echo $mobile_app_image ? 'order-lg-1' : ''; ?> text-center">
								<img src="<?php echo esc_url($mobile_app_image['url']); ?>" 
									 alt="<?php echo esc_attr($mobile_app_image['alt'] ?: 'Sacco Mobile App'); ?>" 
									 class="img-fluid rounded shadow-lg mobile-app-image">
							</div>
						<?php elseif (is_customize_preview()): // Fallback image for customizer ?>
							<div class="col-lg-6 <?php echo $mobile_app_image ? 'order-lg-1' : ''; ?> text-center">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/default-phone-mockup.png" 
									 alt="Sacco Mobile App Preview" 
									 class="img-fluid rounded shadow-lg mobile-app-image">
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<!-- News & Updates Section -->
		<?php 
		$news_title = get_field('home_news_title') ?: esc_html__('News & Updates', 'sacco-php');
		$news_subtitle = get_field('home_news_subtitle') ?: esc_html__('Stay informed with our latest articles and announcements.', 'sacco-php');
		?>
		<section class="news-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($news_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($news_subtitle); ?></p>
					</div>
				</div>
				<div class="row">
					<?php
					$latest_posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
					if ( $latest_posts->have_posts() ) :
						while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="card news-card h-100 shadow-sm border-0">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="news-card-img-link">
									<?php the_post_thumbnail('medium_large', array('class' => 'card-img-top news-card-img')); ?>
								</a>
							<?php endif; ?>
							<div class="card-body d-flex flex-column">
								<h3 class="card-title h5"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h3>
								<div class="news-meta small text-muted mb-2">
									<span class="date"><i class="fas fa-calendar-alt me-1"></i><?php echo get_the_date(); ?></span>
								</div>
								<div class="news-excerpt small text-muted flex-grow-1"><?php the_excerpt(); ?></div>
								<a href="<?php the_permalink(); ?>" class="btn btn-link p-0 mt-auto align-self-start"><?php esc_html_e('Read More', 'sacco-php'); ?> &raquo;</a>
							</div>
						</div>
					</div>
					<?php
						endwhile; 
						wp_reset_postdata(); 
					else : 
					?>
					<div class="col-12"><p class="text-center"><?php esc_html_e('No news articles found.', 'sacco-php'); ?></p></div>
					<?php endif; ?>
				</div>
				<div class="row mt-4">
					<div class="col-12 text-center">
						<?php $blog_page_url = get_permalink( get_option( 'page_for_posts' ) ); ?>
						<?php if ($blog_page_url): ?>
							<a href="<?php echo esc_url( $blog_page_url ); ?>" class="btn btn-outline-primary"><?php esc_html_e('View All News', 'sacco-php'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<!-- Testimonials Section -->
		<?php 
		$testimonials_title = get_field('home_testimonials_title') ?: esc_html__('What Our Members Say', 'sacco-php');
		$testimonials_subtitle = get_field('home_testimonials_subtitle') ?: esc_html__('Real stories from satisfied members of our Sacco family.', 'sacco-php');
		$testimonials = new WP_Query(array('post_type' => 'testimonial', 'posts_per_page' => 5, 'orderby' => 'rand'));

		?>
		<section class="testimonials-section py-5 bg-light">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($testimonials_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($testimonials_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-10">
						<div class="testimonials-slider swiper">
							<div class="swiper-wrapper">
								<?php
								if ( $testimonials->have_posts() ) :
									while ( $testimonials->have_posts() ) : $testimonials->the_post();
										$author_role = get_post_meta(get_the_ID(), '_testimonial_role', true); // Assuming you have a meta field for role
								?>
								<div class="swiper-slide">
									<div class="testimonial-card-home card shadow-sm p-4 h-100">
										<div class="testimonial-icon display-4 text-primary mb-3"><i class="fas fa-quote-left"></i></div>
										<div class="testimonial-text mb-3 fst-italic text-muted"><?php echo wp_kses_post(get_the_content()); ?></div>
										<div class="testimonial-author d-flex align-items-center">
											<?php if(has_post_thumbnail()): ?>
											<div class="testimonial-image me-3">
												<?php the_post_thumbnail('thumbnail', array('class' => 'rounded-circle')); ?>
											</div>
											<?php endif; ?>
											<div class="testimonial-meta">
												<h5 class="testimonial-author-name h6 mb-0"><?php the_title(); ?></h5>
												<?php if ($author_role) : ?>
													<small class="testimonial-author-role text-muted"><?php echo esc_html($author_role); ?></small>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
								<?php
									endwhile; 
									wp_reset_postdata(); 
								else: // Fallback for customizer if no testimonials
									for ($i=1; $i <=3; $i++) :
								?>
								<div class="swiper-slide">
									<div class="testimonial-card-home card shadow-sm p-4 h-100">
										<div class="testimonial-icon display-4 text-primary mb-3"><i class="fas fa-quote-left"></i></div>
										<div class="testimonial-text mb-3 fst-italic text-muted"><?php esc_html_e('This Sacco has been instrumental in my financial growth. Highly recommended!', 'sacco-php'); ?></div>
										<div class="testimonial-author d-flex align-items-center">
											<div class="testimonial-image me-3"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/default-avatar.png" alt="Member <?php echo $i; ?>" class="rounded-circle" width="50" height="50"></div>
											<div class="testimonial-meta">
												<h5 class="testimonial-author-name h6 mb-0"><?php esc_html_e('Member Name '. $i, 'sacco-php'); ?></h5>
												<small class="testimonial-author-role text-muted"><?php esc_html_e('Satisfied Member', 'sacco-php'); ?></small>
											</div>
										</div>
									</div>
								</div>
								<?php 
									endfor; 
								endif; 
								?>
							</div>
							<div class="swiper-pagination testimonials-pagination"></div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Partners Section -->
		<?php 
		$partners_enable = get_field('home_partners_enable');
		if( $partners_enable || is_customize_preview() ) :
			$partners_title = get_field('home_partners_title') ?: esc_html__('Our Valued Partners', 'sacco-php');
			$partners_subtitle = get_field('home_partners_subtitle') ?: esc_html__('Collaborating with organizations to serve you better.', 'sacco-php');
			$partners_query = new WP_Query(array('post_type' => 'partner', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC'));

			if ( $partners_query->have_posts() || is_customize_preview() ) :
		?>
		<section class="partners-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($partners_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($partners_subtitle); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="partners-slider swiper">
							<div class="swiper-wrapper">
								<?php
								if ( $partners_query->have_posts() ) :
									while ( $partners_query->have_posts() ) : $partners_query->the_post();
										$partner_logo_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
										$partner_link = get_post_meta(get_the_ID(), '_partner_website_url', true); // Assuming a meta field for partner link
										if ($partner_logo_url) :
								?>
								<div class="swiper-slide text-center">
									<div class="partner-item">
										<?php if ($partner_link) : ?><a href="<?php echo esc_url($partner_link); ?>" target="_blank" rel="noopener noreferrer"><?php endif; ?>
										<img src="<?php echo esc_url($partner_logo_url); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid partner-logo">
										<?php if ($partner_link) : ?></a><?php endif; ?>
									</div>
								</div>
								<?php 
										endif; 
									endwhile;
									wp_reset_postdata();
								else : // Fallback for customizer
									for ($i=1; $i <= 5; $i++) :
								?>
								<div class="swiper-slide text-center">
									<div class="partner-item">
										<img src="https://via.placeholder.com/150x80.png?text=Partner<?php echo $i; ?>" alt="Partner <?php echo $i; ?> Logo" class="img-fluid partner-logo">
									</div>
								</div>
								<?php endfor; ?>
								<?php endif; ?>
							</div>
							<div class="swiper-pagination partners-pagination"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php 
			endif; 
		endif; 
		?>

		<!-- Call to Action Section -->
		<?php 
		$cta_supertitle = get_field('home_cta_supertitle');
		$cta_title = get_field('home_cta_title') ?: esc_html__('Ready to Take the Next Step?', 'sacco-php');
		$cta_text = get_field('home_cta_text') ?: esc_html__('Join thousands of satisfied members and start your journey towards financial empowerment today. Our team is here to assist you.', 'sacco-php');
		$cta_button_text = get_field('home_cta_button_text') ?: esc_html__('Become a Member', 'sacco-php');
		$cta_button_url = get_field('home_cta_button_url') ?: home_url('/membership/');
		$cta_secondary_button_text = get_field('home_cta_secondary_button_text');
		$cta_secondary_button_url = get_field('home_cta_secondary_button_url');
		?>
		<section class="cta-section py-5 text-white text-center" style="background-color: var(--bs-primary, #007bff);">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<?php if ($cta_supertitle): ?><p class="cta-supertitle text-uppercase letter-spacing-1"><?php echo esc_html($cta_supertitle); ?></p><?php endif; ?>
						<h2 class="cta-title display-5 fw-bold mb-3"><?php echo esc_html($cta_title); ?></h2>
						<p class="cta-text lead mb-4"><?php echo esc_html($cta_text); ?></p>
						<a href="<?php echo esc_url($cta_button_url); ?>" class="btn btn-light btn-lg px-4 me-md-2"><?php echo esc_html($cta_button_text); ?></a>
						<?php if ($cta_secondary_button_text && $cta_secondary_button_url): ?>
							<a href="<?php echo esc_url($cta_secondary_button_url); ?>" class="btn btn-outline-light btn-lg px-4"><?php echo esc_html($cta_secondary_button_text); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();