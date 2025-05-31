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

		<!-- Hero Slider Section with Parallax -->
		<!-- Navigation Bar -->
    <!-- <nav <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"> -->
     <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" 
       alt="Logo" class="navbar-logo" style="height: 40px;">
         </a>
			<span class="brand-text">Daystar Multi-Purpose Co-op Society Ltd.</span>
		</a>
		
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
						Services
					</a>
					<ul class="dropdown-menu glass-dropdown">
						<li><a class="dropdown-item" href="<?php echo esc_url(home_url('loans')); ?>">Loans</a></li>
						<li><a class="dropdown-item" href="<?php echo esc_url(home_url('savings')); ?>">Savings</a></li>
						<li><a class="dropdown-item" href="<?php echo esc_url(home_url('investments')); ?>">Investments</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo esc_url(home_url('about')); ?>">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo esc_url(home_url('contact')); ?>">Contact</a>
				</li>
				<li class="nav-item">
					<a class="btn btn-primary nav-btn" href="<?php echo esc_url(home_url('member-dashboard')); ?>">
						Login
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
	<div class="hero-background">
		<div class="bg-image active" style="background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');"></div>
		<div class="hero-overlay"></div>
	</div>
	
	<!-- Quick Navigation Cards -->
	<div class="quick-nav-section">
    <div class="container">
        <div class="quick-nav-grid">

            <!-- Quick Loan Card -->
            <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="quick-nav-card">
                <div class="card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-content">
                    <h4>Quick Loan</h4>
                    <p>Apply instantly</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Loan Calculator Card -->
            <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="quick-nav-card">
                <div class="card-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="card-content">
                    <h4>Calculator</h4>
                    <p>Plan payments</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <!-- Online Banking Card -->
            <!-- <a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="quick-nav-card">
                <div class="card-icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <div class="card-content">
                    <h4>Online Banking</h4>
                    <p>Access account</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a> -->

            <!-- Join Now Card -->
            <a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="quick-nav-card">
                <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-content">
                    <h4>Join Now</h4>
                    <p>Become member</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

        </div>
    </div>
</div>

	
	<!-- Main Hero Content -->
	<div class="hero-content">
		<div class="container">
			<div class="row align-items-center min-vh-100">
				<div class="col-lg-6">
					<div class="hero-text">
						<h1 class="hero-title">
							<span class="text-gradient">Empowering</span> Your<br>
							Financial Future
						</h1>
						<p class="hero-subtitle">
							Join thousands of members who trust us with their financial goals. 
							Experience secure banking with competitive rates and personalized service.
						</p>
						<div class="hero-actions">
							<a href="<?php echo esc_url(home_url('how-to-join')); ?>" class="btn btn-primary btn-lg">
								Get Started
								<i class="fas fa-arrow-right ms-2"></i>
							</a>
							<a href="<?php echo esc_url(home_url('about')); ?>" class="btn btn-outline-light btn-lg">
								Learn More
							</a>
						</div>
						
						<!-- Trust Indicators -->
						<div class="trust-indicators">
							<div class="trust-item">
								<div class="trust-number">50K+</div>
								<div class="trust-label">Happy Members</div>
							</div>
							<div class="trust-item">
								<div class="trust-number">4.9★</div>
								<div class="trust-label">Rating</div>
							</div>
							<div class="trust-item">
								<div class="trust-number">$2B+</div>
								<div class="trust-label">Assets</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="hero-visual">
						<div class="main-image">
							<img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
							     alt="Financial Growth" class="img-fluid">
						</div>
						<div class="floating-cards">
							<div class="float-card card-1">
								<i class="fas fa-shield-alt"></i>
								<span>100% Secure</span>
							</div>
							<div class="float-card card-2">
								<i class="fas fa-chart-line"></i>
								<span>Growth Focused</span>
							</div>
							<div class="float-card card-3">
								<i class="fas fa-clock"></i>
								<span>24/7 Support</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Scroll Indicator -->
	<div class="scroll-indicator">
		<div class="scroll-mouse">
			<div class="scroll-wheel"></div>
		</div>
		<span>Scroll to explore</span>
	</div>
</section>

<style>
/* Base Styles */
* {
	box-sizing: border-box;
}

body {
	margin: 0;
	padding: 0;
	font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Navigation Styles */
.glass-nav {
	background: rgba(255, 255, 255, 0.1) !important;
	backdrop-filter: blur(20px);
	border-bottom: 1px solid rgba(255, 255, 255, 0.1);
	padding: 1rem 0;
	transition: all 0.3s ease;
}

.glass-nav.scrolled {
	background: rgba(0, 0, 0, 0.9) !important;
}

.navbar-brand {
	display: flex;
	align-items: center;
	font-weight: 700;
	font-size: 1.5rem;
	text-decoration: none;
	color: white !important;
}

.navbar-logo {
	height: 40px;
	width: auto;
	margin-right: 12px;
	border-radius: 8px;
}

.brand-text {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

.navbar-nav .nav-link {
	color: rgba(255, 255, 255, 0.9) !important;
	font-weight: 500;
	margin: 0 8px;
	padding: 8px 16px !important;
	border-radius: 8px;
	transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover {
	color: white !important;
	background: rgba(255, 255, 255, 0.1);
}

.nav-btn {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	border: none;
	padding: 10px 20px !important;
	border-radius: 25px;
	font-weight: 600;
	margin-left: 15px;
}

.nav-btn:hover {
	transform: translateY(-2px);
	box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.glass-dropdown {
	background: rgba(0, 0, 0, 0.9);
	backdrop-filter: blur(20px);
	border: 1px solid rgba(255, 255, 255, 0.1);
	border-radius: 12px;
}

.glass-dropdown .dropdown-item {
	color: rgba(255, 255, 255, 0.9);
	padding: 10px 20px;
	transition: all 0.3s ease;
}

.glass-dropdown .dropdown-item:hover {
	background: rgba(255, 255, 255, 0.1);
	color: white;
}

/* Hero Section */
.hero-section {
	min-height: 100vh;
	position: relative;
	display: flex;
	flex-direction: column;
}

.hero-background {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: -2;
}

.bg-image {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-size: cover;
	background-position: center;
	background-attachment: fixed;
}

.hero-overlay {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
	z-index: -1;
}

/* Quick Navigation */
.quick-nav-section {
	padding: 120px 0 60px;
	position: relative;
	z-index: 5;
}

.quick-nav-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
	gap: 20px;
	max-width: 1000px;
	margin: 0 auto;
}

.quick-nav-card {
	display: flex;
	align-items: center;
	padding: 20px 25px;
	background: rgba(255, 255, 255, 0.1);
	backdrop-filter: blur(15px);
	border: 1px solid rgba(255, 255, 255, 0.2);
	border-radius: 16px;
	color: white;
	text-decoration: none;
	transition: all 0.3s ease;
	position: relative;
	overflow: hidden;
}

.quick-nav-card::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
	transition: left 0.6s ease;
}

.quick-nav-card:hover::before {
	left: 100%;
}

.quick-nav-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 15px 35px rgba(0,0,0,0.2);
	background: rgba(255, 255, 255, 0.2);
	color: white;
	text-decoration: none;
}

.card-icon {
	font-size: 1.8rem;
	margin-right: 20px;
	min-width: 50px;
	text-align: center;
	color: #667eea;
}

.card-content h4 {
	margin: 0 0 5px 0;
	font-size: 1.1rem;
	font-weight: 600;
}

.card-content p {
	margin: 0;
	font-size: 0.9rem;
	opacity: 0.8;
}

.card-arrow {
	margin-left: auto;
	opacity: 0;
	transform: translateX(-10px);
	transition: all 0.3s ease;
}

.quick-nav-card:hover .card-arrow {
	opacity: 1;
	transform: translateX(0);
}

/* Hero Content */
.hero-content {
	flex: 1;
	display: flex;
	align-items: center;
	padding: 40px 0;
	position: relative;
	z-index: 5;
}

.hero-text {
	padding-right: 2rem;
}

.hero-title {
	font-size: 3.2rem;
	font-weight: 700;
	line-height: 1.1;
	margin-bottom: 1.5rem;
	color: white;
	animation: slideInUp 0.8s ease-out;
}

.text-gradient {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

.hero-subtitle {
	font-size: 1.2rem;
	color: rgba(255, 255, 255, 0.9);
	margin-bottom: 2.5rem;
	line-height: 1.6;
	animation: slideInUp 0.8s ease-out 0.2s both;
}

.hero-actions {
	margin-bottom: 3rem;
	animation: slideInUp 0.8s ease-out 0.4s both;
}

.hero-actions .btn {
	padding: 14px 32px;
	font-weight: 600;
	border-radius: 50px;
	margin-right: 20px;
	margin-bottom: 15px;
	transition: all 0.3s ease;
	text-decoration: none;
	display: inline-block;
}

.btn-primary {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	border: none;
	color: white;
	box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
	transform: translateY(-3px);
	box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
	color: white;
}

.btn-outline-light {
	border: 2px solid rgba(255, 255, 255, 0.7);
	background: transparent;
	color: white;
}

.btn-outline-light:hover {
	background: rgba(255, 255, 255, 0.1);
	border-color: white;
	transform: translateY(-3px);
	color: white;
}

/* Trust Indicators */
.trust-indicators {
	display: flex;
	gap: 2rem;
	animation: slideInUp 0.8s ease-out 0.6s both;
}

.trust-item {
	text-align: center;
}

.trust-number {
	font-size: 1.8rem;
	font-weight: 700;
	color: #667eea;
	margin-bottom: 5px;
}

.trust-label {
	font-size: 0.9rem;
	color: rgba(255, 255, 255, 0.8);
}

/* Hero Visual */
.hero-visual {
	position: relative;
	text-align: center;
	animation: slideInRight 0.8s ease-out 0.3s both;
}

.main-image img {
	border-radius: 20px;
	box-shadow: 0 25px 50px rgba(0,0,0,0.3);
	max-width: 100%;
	height: auto;
}

.floating-cards {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	pointer-events: none;
}

.float-card {
	position: absolute;
	background: rgba(255, 255, 255, 0.95);
	backdrop-filter: blur(10px);
	padding: 12px 16px;
	border-radius: 12px;
	box-shadow: 0 8px 25px rgba(0,0,0,0.15);
	display: flex;
	align-items: center;
	gap: 8px;
	color: #333;
	font-weight: 600;
	font-size: 0.9rem;
	animation: float 6s ease-in-out infinite;
}

.float-card i {
	color: #667eea;
}

.card-1 {
	top: 20%;
	right: -10%;
	animation-delay: 0s;
}

.card-2 {
	bottom: 30%;
	left: -15%;
	animation-delay: 2s;
}

.card-3 {
	top: 60%;
	right: -5%;
	animation-delay: 4s;
}

/* Scroll Indicator */
.scroll-indicator {
	position: absolute;
	bottom: 30px;
	left: 50%;
	transform: translateX(-50%);
	text-align: center;
	color: rgba(255, 255, 255, 0.7);
	font-size: 0.9rem;
}

.scroll-mouse {
	width: 24px;
	height: 40px;
	border: 2px solid rgba(255, 255, 255, 0.7);
	border-radius: 12px;
	margin: 0 auto 8px;
	position: relative;
}

.scroll-wheel {
	width: 4px;
	height: 8px;
	background: rgba(255, 255, 255, 0.7);
	border-radius: 2px;
	position: absolute;
	top: 8px;
	left: 50%;
	transform: translateX(-50%);
	animation: scroll-wheel 2s infinite;
}

/* Animations */
@keyframes slideInUp {
	from {
		opacity: 0;
		transform: translateY(30px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}

@keyframes slideInRight {
	from {
		opacity: 0;
		transform: translateX(30px);
	}
	to {
		opacity: 1;
		transform: translateX(0);
	}
}

@keyframes float {
	0%, 100% {
		transform: translateY(0px);
	}
	50% {
		transform: translateY(-15px);
	}
}

@keyframes scroll-wheel {
	0% {
		opacity: 0;
		top: 8px;
	}
	50% {
		opacity: 1;
	}
	100% {
		opacity: 0;
		top: 20px;
	}
}

/* Responsive Design */
@media (max-width: 1200px) {
	.hero-title {
		font-size: 2.8rem;
	}
	
	.trust-indicators {
		gap: 1.5rem;
	}
}

@media (max-width: 992px) {
	.hero-text {
		padding-right: 0;
		margin-bottom: 3rem;
		text-align: center;
	}
	
	.hero-title {
		font-size: 2.5rem;
	}
	
	.trust-indicators {
		justify-content: center;
	}
	
	.quick-nav-grid {
		grid-template-columns: repeat(2, 1fr);
	}
}

@media (max-width: 768px) {
	.quick-nav-section {
		padding: 100px 0 40px;
	}
	
	.quick-nav-grid {
		grid-template-columns: 1fr;
		gap: 15px;
	}
	
	.hero-title {
		font-size: 2.2rem;
	}
	
	.hero-subtitle {
		font-size: 1.1rem;
	}
	
	.hero-actions .btn {
		display: block;
		width: 100%;
		margin-right: 0;
		margin-bottom: 15px;
	}
	
	.trust-indicators {
		flex-direction: column;
		gap: 1rem;
	}
	
	.bg-image {
		background-attachment: scroll;
	}
}

@media (max-width: 576px) {
	.container {
		padding: 0 20px;
	}
	
	.hero-title {
		font-size: 1.9rem;
	}
	
	.quick-nav-card {
		padding: 15px 20px;
	}
	
	.card-content h4 {
		font-size: 1rem;
	}
	
	.trust-number {
		font-size: 1.5rem;
	}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Navbar scroll effect
	const navbar = document.querySelector('.glass-nav');
	
	window.addEventListener('scroll', function() {
		if (window.scrollY > 50) {
			navbar.classList.add('scrolled');
		} else {
			navbar.classList.remove('scrolled');
		}
	});
	
	// Background image rotation
	const bgImages = [
		'https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
		'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=2126&q=80',
		'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80'
	];
	let currentBg = 0;
	
	setInterval(() => {
		currentBg = (currentBg + 1) % bgImages.length;
		document.querySelector('.bg-image').style.backgroundImage = `url('${bgImages[currentBg]}')`;
	}, 8000);
});
</script>
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
					<div class="swiper-slide parallax-bg" data-swiper-parallax="-30%" style="background-image: url('<?php echo esc_url($slide_bg); ?>');">
						<div class="slide-overlay"></div>
						<div class="slide-content-wrap">
							<div class="container">
								<div class="row">
									<div class="col-lg-8 col-md-10">
										<div class="slide-content glass-effect glass-morph p-4 rounded-lg" data-swiper-parallax="-100">
											<h2 class="slide-title gradient-text mb-4" data-swiper-parallax="-300"><?php the_title(); ?></h2>
											<div class="slide-subtitle text-white" data-swiper-parallax="-200">
												<?php the_content(); ?>
											</div>
											<?php if (empty($slide_link_url) && $slide_button_text && $slide_button_url) : ?>
											<div class="slide-buttons mt-4" data-swiper-parallax="-100">
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
					<div class="swiper-slide parallax-bg" data-swiper-parallax="-30%" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/default-slide.jpg');">
						<div class="slide-overlay"></div>
						<div class="slide-content-wrap">
							<div class="container">
								<div class="row justify-content-center">
									<div class="col-lg-10 text-center">
										<div class="slide-content glass-morph" data-swiper-parallax="-100">
											<h2 class="slide-title" data-swiper-parallax="-300"><?php echo esc_html(get_theme_mod('default_slide_title', 'Welcome to Our Sacco')); ?></h2>
											<div class="slide-subtitle" data-swiper-parallax="-200">
												<p><?php echo esc_html(get_theme_mod('default_slide_subtitle', 'Empowering your financial journey.')); ?></p>
											</div>
											<div class="slide-buttons" data-swiper-parallax="-100">
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
				<a href="#quick-actions" class="scroll-link">
					<i class="fas fa-chevron-down"></i>
					<span class="sr-only">Scroll to next section</span>
				</a>
			</div>
		</section>
		
		<!-- Quick Links/Actions Section -->
		<?php 
		$quick_actions_title = get_field('home_quick_actions_title') ?: esc_html__('How Can We Help You?', 'sacco-php');
		$quick_actions_subtitle = get_field('home_quick_actions_subtitle') ?: esc_html__('Quick access to our most popular services and information.', 'sacco-php');
		$quick_action_cards = get_field('home_quick_action_cards');
		?>
		<section id="quick-actions" class="quick-actions-section py-5 position-relative overflow-hidden">
			<div class="shape-divider">
				<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
					<path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
				</svg>
			</div>
			<div class="container">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title gradient-text" data-aos="fade-up"><?php echo esc_html($quick_actions_title); ?></h2>
						<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html($quick_actions_subtitle); ?></p>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php 
					if ($quick_action_cards && is_array($quick_action_cards)) :
						foreach ($quick_action_cards as $index => $card) :
							$icon = !empty($card['icon_class']) ? $card['icon_class'] : 'fa-info-circle';
							$title = !empty($card['title']) ? $card['title'] : esc_html__('Action Title', 'sacco-php');
							$text = !empty($card['text']) ? $card['text'] : esc_html__('Brief description of the action or link.', 'sacco-php');
							$button_text = !empty($card['button_text']) ? $card['button_text'] : esc_html__('Learn More', 'sacco-php');
							$button_url = !empty($card['button_url']) ? $card['button_url'] : '#';
					?>
					<div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
						<div class="quick-action-card glass-card glass-morph h-100 text-center p-4">
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
					endif;
					?>
				</div>
			</div>
		</section>

		<!-- Parallax Banner Section -->
		<section class="parallax-banner py-0">
			<div class="parallax-background" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/parallax-finance.jpg');">
				<div class="parallax-overlay"></div>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8 text-center">
							<div class="parallax-content glass-morph p-5">
								<h2 class="text-white mb-4">Financial Solutions for Every Stage of Life</h2>
								<p class="text-white mb-4">Whether you're saving for your first home, planning for education, or preparing for retirement, we're here to help you achieve your financial goals.</p>
								<a href="<?php echo esc_url(home_url('/financial-planning/')); ?>" class="btn glass-button btn-light btn-lg">Learn More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Stats Section (Resolved merge conflict) -->
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
							<h2 class="section-title" data-aos="fade-up"><?php echo esc_html($stats_section_title); ?></h2>
						<?php endif; ?>
						<?php if ($stats_section_subtitle) : ?>
							<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html($stats_section_subtitle); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row justify-content-center">
					<?php 
					if ($stats_items && is_array($stats_items)) :
						$stat_col_class = count($stats_items) >= 4 ? 'col-lg-3 col-md-6' : 'col-md-4';
						foreach ($stats_items as $index => $stat) :
							$icon = !empty($stat['icon']) ? $stat['icon'] : 'fa-star';
							$number = !empty($stat['number']) ? $stat['number'] : '0';
							$title = !empty($stat['title']) ? $stat['title'] : esc_html__('Stat Title', 'sacco-php');
					?>
					<div class="<?php echo esc_attr($stat_col_class); ?> text-center mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
						<div class="stat-item glass-effect glass-morph p-4 rounded h-100">
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
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0" data-aos="fade-up">
						<div class="stat-item glass-morph p-4 rounded">
							<div class="stat-icon text-white mb-3">
								<i class="fas fa-users fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="10000">0</h3>
							<p class="stat-title mb-0">Happy Members</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
						<div class="stat-item glass-morph p-4 rounded">
							<div class="stat-icon text-white mb-3">
								<i class="fas fa-money-bill-wave fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="250">0</h3>
							<p class="stat-title mb-0">Million in Assets</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
						<div class="stat-item glass-morph p-4 rounded">
							<div class="stat-icon text-white mb-3">
								<i class="fas fa-award fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="15">0</h3>
							<p class="stat-title mb-0">Years of Service</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
						<div class="stat-item glass-morph p-4 rounded">
							<div class="stat-icon text-white mb-3">
								<i class="fas fa-landmark fa-3x"></i>
							</div>
							<h3 class="stat-number display-4 fw-bold" data-count="5">0</h3>
							<p class="stat-title mb-0">Branches</p>
						</div>
					</div>
					<?php endif; ?>
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
						<div class="quick-action-card glass-morph">
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
						<div class="quick-action-card glass-morph">
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
						<div class="quick-action-card glass-morph">
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