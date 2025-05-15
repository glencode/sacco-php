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
		<section class="hero-section position-relative">
			<div class="hero-slider swiper">
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
						<div class="slide-overlay"></div>
						<div class="slide-content-wrap">
							<div class="container">
								<div class="row">
									<div class="col-lg-8 col-md-10">
										<div class="slide-content glass-effect p-4 rounded-lg">
											<h2 class="slide-title gradient-text mb-4"><?php the_title(); ?></h2>
											<div class="slide-subtitle text-white">
												<?php the_content(); ?>
											</div>
											<?php if (empty($slide_link_url) && $slide_button_text && $slide_button_url) : ?>
											<div class="slide-buttons mt-4">
												<a href="<?php echo esc_url($slide_button_url); ?>" class="btn glass-button btn-light btn-lg floating-element">
													<?php echo esc_html($slide_button_text); ?>
												</a>
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
		</section>
		
		<!-- Quick Links/Actions Section -->
		<?php 
		$quick_actions_title = get_field('home_quick_actions_title') ?: esc_html__('How Can We Help You?', 'sacco-php');
		$quick_actions_subtitle = get_field('home_quick_actions_subtitle') ?: esc_html__('Quick access to our most popular services and information.', 'sacco-php');
		$quick_action_cards = get_field('home_quick_action_cards');
		?>
		<section class="quick-actions-section py-5 position-relative overflow-hidden">
			<div class="shape-divider">
				<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
					<path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
				</svg>
			</div>
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title gradient-text"><?php echo esc_html($quick_actions_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($quick_actions_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php 
					if ($quick_action_cards && is_array($quick_action_cards)) :
						foreach ($quick_action_cards as $card) :
							$icon = !empty($card['icon_class']) ? $card['icon_class'] : 'fa-info-circle';
							$title = !empty($card['title']) ? $card['title'] : esc_html__('Action Title', 'sacco-php');
							$text = !empty($card['text']) ? $card['text'] : esc_html__('Brief description of the action or link.', 'sacco-php');
							$button_text = !empty($card['button_text']) ? $card['button_text'] : esc_html__('Learn More', 'sacco-php');
							$button_url = !empty($card['button_url']) ? $card['button_url'] : '#';
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="quick-action-card glass-card h-100 text-center p-4">
							<div class="quick-action-icon mb-3 text-primary floating-element">
								<i class="fas <?php echo esc_attr($icon); ?> fa-3x"></i>
							</div>
							<h3 class="quick-action-title h5"><?php echo esc_html($title); ?></h3>
							<p class="quick-action-text small text-muted"><?php echo esc_html($text); ?></p>
							<a href="<?php echo esc_url($button_url); ?>" class="btn glass-button btn-primary btn-sm mt-auto"><?php echo esc_html($button_text); ?></a>
						</div>
					</div>
					<?php 
						endforeach;
					else : // Fallback static content if ACF fields are not set or empty
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="quick-action-card card h-100 text-center p-4 shadow-sm">
							<div class="quick-action-icon mb-3 text-primary">
								<i class="fas fa-user-plus fa-3x"></i>
							</div>
							<h3 class="quick-action-title h5"><?php esc_html_e('Become a Member', 'sacco-php'); ?></h3>
							<p class="quick-action-text small text-muted"><?php esc_html_e('Join our Sacco community and enjoy exclusive benefits.', 'sacco-php'); ?></p>
							<a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn btn-primary btn-sm mt-auto"><?php esc_html_e('Join Now', 'sacco-php'); ?></a>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- Why Choose Us Section (formerly Philosophy) -->
		<?php
		$why_choose_us_title = get_field('home_why_choose_us_title') ?: (get_field('home_philosophy_title') ?: esc_html__('Why Choose Us?', 'sacco-php'));
		$why_choose_us_subtitle = get_field('home_why_choose_us_subtitle') ?: (get_field('home_philosophy_subtitle') ?: esc_html__('Dedicated to your financial success and well-being.', 'sacco-php'));
		$why_choose_us_cards = get_field('home_why_choose_us_cards') ?: get_field('home_philosophy_cards');
		?>
		<section class="why-choose-us-section philosophy-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($why_choose_us_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($why_choose_us_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php 
					if ($why_choose_us_cards && is_array($why_choose_us_cards)) :
						foreach ($why_choose_us_cards as $card) :
							$icon = !empty($card['icon']) ? $card['icon'] : 'fa-check-circle';
							$title = !empty($card['title']) ? $card['title'] : esc_html__('Our Value', 'sacco-php');
							$description = !empty($card['description']) ? $card['description'] : esc_html__('Description of our value.', 'sacco-php');
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="philosophy-card card h-100 text-center p-4 shadow-sm">
							<div class="philosophy-icon mb-3 text-primary">
								<i class="fas <?php echo esc_attr($icon); ?> fa-3x"></i>
							</div>
							<h3 class="philosophy-title h5"><?php echo esc_html($title); ?></h3>
							<p class="philosophy-desc small text-muted"><?php echo esc_html($description); ?></p>
						</div>
					</div>
					<?php 
						endforeach;
					else : // Fallback static content if ACF fields are not set or empty
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="philosophy-card card h-100 text-center p-4 shadow-sm">
							<div class="philosophy-icon mb-3 text-primary">
								<i class="fas fa-handshake fa-3x"></i>
							</div>
							<h3 class="philosophy-title h5"><?php esc_html_e('Member-Centric Approach', 'sacco-php'); ?></h3>
							<p class="philosophy-desc small text-muted"><?php esc_html_e('We prioritize your needs, offering personalized financial solutions and excellent customer service.', 'sacco-php'); ?></p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="philosophy-card card h-100 text-center p-4 shadow-sm">
							<div class="philosophy-icon mb-3 text-primary">
								<i class="fas fa-piggy-bank fa-3x"></i>
							</div>
							<h3 class="philosophy-title h5"><?php esc_html_e('Competitive Products', 'sacco-php'); ?></h3>
							<p class="philosophy-desc small text-muted"><?php esc_html_e('Access a wide range of savings and loan products with attractive rates and flexible terms.', 'sacco-php'); ?></p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
						<div class="philosophy-card card h-100 text-center p-4 shadow-sm">
							<div class="philosophy-icon mb-3 text-primary">
								<i class="fas fa-shield-alt fa-3x"></i>
							</div>
							<h3 class="philosophy-title h5"><?php esc_html_e('Secure & Trusted', 'sacco-php'); ?></h3>
							<p class="philosophy-desc small text-muted"><?php esc_html_e('Your finances are safe with us. We are a regulated institution committed to transparency.', 'sacco-php'); ?></p>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		
		<!-- Stats Section -->
		<?php
		$stats_section_title = get_field('home_stats_section_title') ?: esc_html__('Our Impact in Numbers', 'sacco-php');
		$stats_section_subtitle = get_field('home_stats_section_subtitle') ?: esc_html__('Key figures that highlight our commitment and success.', 'sacco-php');
		$stats_items = get_field('home_stats_items');
		?>
		<section class="stats-section py-5 position-relative animated-gradient text-white">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<?php if ($stats_section_title) : ?>
							<h2 class="section-title"><?php echo esc_html($stats_section_title); ?></h2>
						<?php endif; ?>
						<?php if ($stats_section_subtitle) : ?>
							<p class="section-subtitle"><?php echo esc_html($stats_section_subtitle); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php 
					if ($stats_items && is_array($stats_items)) :
						$stat_col_class = count($stats_items) >= 4 ? 'col-lg-3 col-md-6' : 'col-md-4';
						foreach ($stats_items as $stat) :
							$icon = !empty($stat['icon']) ? $stat['icon'] : 'fa-star';
							$number = !empty($stat['number']) ? $stat['number'] : '0';
							$title = !empty($stat['title']) ? $stat['title'] : esc_html__('Stat Title', 'sacco-php');
					?>
					<div class="<?php echo esc_attr($stat_col_class); ?> text-center mb-4 mb-lg-0">
						<div class="stat-item glass-effect p-4 rounded h-100">
							<div class="stat-icon text-white mb-3 floating-element">
								<i class="fas <?php echo esc_attr($icon); ?> fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="<?php echo esc_attr($number); ?>">0</h3>
							<p class="stat-title mb-0"><?php echo esc_html($title); ?></p>
						</div>
					</div>
					<?php 
						endforeach;
					else: // Fallback static stats
					?>
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0">
						<div class="stat-item p-4 border rounded bg-white shadow-sm">
							<div class="stat-icon text-primary mb-3">
								<i class="fas fa-users fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="10000">0</h3>
							<p class="stat-title text-muted mb-0">Happy Members</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0">
						<div class="stat-item p-4 border rounded bg-white shadow-sm">
							<div class="stat-icon text-primary mb-3">
								<i class="fas fa-money-bill-wave fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="250">0</h3>
							<p class="stat-title text-muted mb-0">Million in Assets</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0">
						<div class="stat-item p-4 border rounded bg-white shadow-sm">
							<div class="stat-icon text-primary mb-3">
								<i class="fas fa-award fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="15">0</h3>
							<p class="stat-title text-muted mb-0">Years of Service</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center">
						<div class="stat-item p-4 border rounded bg-white shadow-sm">
							<div class="stat-icon text-primary mb-3">
								<i class="fas fa-landmark fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="5">0</h3>
							<p class="stat-title text-muted mb-0">Branches</p>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- Products Section -->
		<?php 
		$products_title = get_field('home_products_section_title') ?: esc_html__('Our Financial Solutions', 'sacco-php');
		$products_subtitle = get_field('home_products_section_subtitle') ?: esc_html__('Tailored products to meet your diverse financial needs.', 'sacco-php');
		$featured_products = get_field('home_products_featured_items'); // ACF Relationship field

		?>
		<section class="products-section py-5">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><?php echo esc_html($products_title); ?></h2>
						<p class="section-subtitle"><?php echo esc_html($products_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php
					if ( $featured_products ) :
						foreach ( $featured_products as $post ) : // $post is already a post object or ID
							setup_postdata( $post );
							sacco_php_display_home_product_card(get_the_ID());
						endforeach;
						wp_reset_postdata();
					else: // Fallback to random products if ACF field is empty
						$args = array(
							'post_type'      => array('product', 'loan', 'savings'),
							'posts_per_page' => 4,
							'orderby'        => 'rand',
						); 
						$home_products = new WP_Query( $args );
						if ( $home_products->have_posts() ) :
							while ( $home_products->have_posts() ) : $home_products->the_post();
								sacco_php_display_home_product_card(get_the_ID());
							endwhile;
							wp_reset_postdata();
						else :
							for ($i=1; $i <=3; $i++) { // Placeholder cards if no products
								echo '<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch"><div class="card product-card-home h-100 shadow-sm border-0"><div class="product-card-home-icon-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;"><i class="fas fa-box-open fa-3x text-primary"></i></div><div class="card-body d-flex flex-column p-4"><h3 class="card-title h5"><a href="#" class="text-decoration-none stretched-link">'.esc_html__('Sample Product '. $i, 'sacco-php').'</a></h3><p class="card-text small text-muted flex-grow-1">'.esc_html__('This is a brief description of a sample financial product offering great benefits.', 'sacco-php').'</p></div></div></div>';
							}
						endif;
					endif;
					?>
				</div>
				<div class="row mt-4">
					<div class="col-12 text-center">
						<a href="<?php echo esc_url(home_url('/products-services/')); ?>" class="btn btn-outline-primary"><?php esc_html_e('View All Products & Services', 'sacco-php'); ?></a>
					</div>
				</div>
			</div>
		</section>

		<!-- Mobile Banking / App CTA Section -->
		<?php 
		$mobile_app_enable = get_field('home_mobile_app_enable');
		if( $mobile_app_enable || is_customize_preview() ) :
			$mobile_app_title = get_field('home_mobile_app_title') ?: esc_html__('Access Your Accounts on the Go', 'sacco-php');
			$mobile_app_subtitle = get_field('home_mobile_app_subtitle') ?: esc_html__('Download our mobile app for easy and secure banking.', 'sacco-php');
			$mobile_app_description = get_field('home_mobile_app_description') ?: esc_html__('Manage your finances anytime, anywhere. Check balances, transfer funds, pay bills, and much more, all from the convenience of your smartphone.', 'sacco-php');
			$mobile_app_image = get_field('home_mobile_app_image');
			$google_play_url = get_field('home_mobile_app_google_play_url');
			$google_play_image = get_field('home_mobile_app_google_play_image');
			$apple_store_url = get_field('home_mobile_app_apple_store_url');
			$apple_store_image = get_field('home_mobile_app_apple_store_image');
		?>
		<section class="mobile-app-cta-section py-5 position-relative overflow-hidden animated-gradient">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 <?php echo $mobile_app_image ? 'order-lg-2' : ''; ?> text-center text-lg-start">
						<div class="glass-effect p-5 rounded-lg">
							<h2 class="section-title text-white mb-4"><?php echo esc_html($mobile_app_title); ?></h2>
							<p class="section-subtitle text-white fs-5 mb-4"><?php echo esc_html($mobile_app_subtitle); ?></p>
							<p class="text-white mb-5"><?php echo nl2br(esc_html($mobile_app_description)); ?></p>
							<div class="app-store-badges">
								<?php if ($google_play_url && $google_play_image) : ?>
									<a href="<?php echo esc_url($google_play_url); ?>" target="_blank" class="me-3 floating-element">
										<img src="<?php echo esc_url($google_play_image['url']); ?>" alt="<?php echo esc_attr($google_play_image['alt'] ?: 'Get it on Google Play'); ?>" class="img-fluid app-badge glass-effect">
									</a>
								<?php elseif ($google_play_url) : ?>
									<a href="<?php echo esc_url($google_play_url); ?>" target="_blank" class="btn glass-button btn-light btn-lg me-3 floating-element">
										<i class="fab fa-google-play me-2"></i> Google Play
									</a>
								<?php endif; ?>
								<?php if ($apple_store_url && $apple_store_image) : ?>
									<a href="<?php echo esc_url($apple_store_url); ?>" target="_blank" class="floating-element">
										<img src="<?php echo esc_url($apple_store_image['url']); ?>" alt="<?php echo esc_attr($apple_store_image['alt'] ?: 'Download on the App Store'); ?>" class="img-fluid app-badge glass-effect">
									</a>
								<?php elseif ($apple_store_url) : ?>
									<a href="<?php echo esc_url($apple_store_url); ?>" target="_blank" class="btn glass-button btn-light btn-lg floating-element">
										<i class="fab fa-app-store-ios me-2"></i> App Store
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php if ($mobile_app_image) : ?>
						<div class="col-lg-6 <?php echo $mobile_app_image ? 'order-lg-1' : ''; ?> text-center">
							<img src="<?php echo esc_url($mobile_app_image['url']); ?>" 
								 alt="<?php echo esc_attr($mobile_app_image['alt'] ?: 'Sacco Mobile App'); ?>" 
								 class="img-fluid mobile-app-image floating-element">
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="shape-divider">
				<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
					<path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
				</svg>
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
		<section class="testimonials-section py-5 position-relative overflow-hidden">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title gradient-text"><?php echo esc_html($testimonials_title); ?></h2>
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
										$author_role = get_post_meta(get_the_ID(), '_testimonial_role', true);
								?>
								<div class="swiper-slide">
									<div class="testimonial-card-home glass-card p-4 h-100">
										<div class="testimonial-icon display-4 text-primary mb-3 floating-element"><i class="fas fa-quote-left"></i></div>
										<div class="testimonial-text mb-3 fst-italic"><?php echo wp_kses_post(get_the_content()); ?></div>
										<div class="testimonial-author d-flex align-items-center">
											<?php if(has_post_thumbnail()): ?>
											<div class="testimonial-image me-3">
												<?php the_post_thumbnail('thumbnail', array('class' => 'rounded-circle morphic-shadow')); ?>
											</div>
											<?php endif; ?>
											<div class="testimonial-meta">
												<h5 class="testimonial-author-name h6 mb-0 gradient-text"><?php the_title(); ?></h5>
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
		<section class="cta-section py-5 text-white text-center position-relative animated-gradient overflow-hidden">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-effect p-5 rounded-lg">
                    <?php if ($cta_supertitle): ?>
                        <p class="cta-supertitle text-uppercase letter-spacing-1 mb-2">
                            <?php echo esc_html($cta_supertitle); ?>
                        </p>
                    <?php endif; ?>
                    <h2 class="cta-title display-5 fw-bold mb-3">
                        <?php echo esc_html($cta_title); ?>
                    </h2>
                    <p class="cta-text lead mb-4">
                        <?php echo esc_html($cta_text); ?>
                    </p>
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url($cta_button_url); ?>" 
                           class="btn glass-button btn-light btn-lg px-4 me-md-2 floating-element">
                            <?php echo esc_html($cta_button_text); ?>
                        </a>
                        <?php if ($cta_secondary_button_text && $cta_secondary_button_url): ?>
                            <a href="<?php echo esc_url($cta_secondary_button_url); ?>" 
                               class="btn glass-button btn-outline-light btn-lg px-4">
                                <?php echo esc_html($cta_secondary_button_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-divider" style="transform: rotate(180deg)">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>
</section>

	</main><!-- #main -->

<?php
get_footer();