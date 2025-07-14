<?php
/**
 * Template Name: Our History Page
 *
 * The template for displaying the history of the SACCO.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main history-page">
    <!-- Parallax Background -->
    <div class="parallax-container">
        <div class="parallax-layer parallax-layer-1"></div>
        <div class="parallax-layer parallax-layer-2"></div>
        <div class="parallax-layer parallax-layer-3"></div>
    </div>

    <!-- Hero Section -->
    <header class="history-hero">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title" data-aos="fade-up">Our History</h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        A journey of growth, innovation, and unwavering commitment to our members
                    </p>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-count="34">0</h3>
                                    <p>Years of Service</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-count="2500">0</h3>
                                    <p>Daystar Staff Served</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-count="500000000">0</h3>
                                    <p>Assets (KSh)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="container">
        <nav class="breadcrumb my-0" aria-label="breadcrumb">
            <a href="/">Home</a>
            <span class="separator">/</span>
            <span>Our History</span>
        </nav>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>
    
    <!-- Introduction Section -->
    <section class="history-intro-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card intro-content" data-aos="fade-up">
                        <div class="icon-section text-center">
                            <i class="fas fa-history text-primary"></i>
                        </div>
                        <h2 class="section-title text-center">Our Journey Through Time</h2>
                        <p class="lead text-center">
                            From humble beginnings in 1990 as a Housing Co-operative Society to becoming a Multi-purpose Co-operative Society in 1991, 
                            our story is one of resilience, innovation, and unwavering commitment to improving the welfare of Daystar staff through pooled resources.
                        </p>
                        <div class="history-intro-text">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Interactive Timeline Section -->
    <section class="history-timeline-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Our Timeline</h2>
                        
                        <div class="timeline-container">
                            <div class="timeline">
                                <!-- Foundation Era -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                                    <div class="timeline-dot">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="timeline-date">1990</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Housing Co-operative Society</h3>
                                                <span class="timeline-badge foundation">Genesis</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Daystar Multi-purpose Co-operative Society Ltd started as a Housing Co-operative Society Ltd in 1990. The founding members recognized the need for collective financial empowerment within the Daystar University community, focusing initially on housing solutions for staff members.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-home"></i>
                                                        <span>Housing Focus</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-university"></i>
                                                        <span>Daystar Staff Initiative</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Transformation -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="150">
                                    <div class="timeline-dot">
                                        <i class="fas fa-seedling"></i>
                                    </div>
                                    <div class="timeline-date">1991</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Multi-purpose Transformation</h3>
                                                <span class="timeline-badge transformation">Evolution</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>In 1991, the society was transformed into a Multi-purpose Co-operative Society Ltd, expanding its scope to deal with Savings (Shares/Deposits) and Credit (Loans to Members). This marked the beginning of our comprehensive financial services approach.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-coins"></i>
                                                        <span>Savings & Credit</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-expand-arrows-alt"></i>
                                                        <span>Multi-purpose Services</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Growth Phase -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                                    <div class="timeline-dot">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="timeline-date">2000</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Rapid Growth & Expansion</h3>
                                                <span class="timeline-badge growth">Growth</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Our membership soared to over 500 as word spread about our competitive rates and member-focused approach. We diversified our loan products and introduced specialized savings accounts, laying the foundation for comprehensive financial services.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span>500+ Members</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-coins"></i>
                                                        <span>Diversified Products</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Infrastructure Development -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                                    <div class="timeline-dot">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="timeline-date">2005</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>First Dedicated Office</h3>
                                                <span class="timeline-badge infrastructure">Infrastructure</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>A milestone moment as we opened our first dedicated office space, providing members with a professional environment for all their financial needs. This marked our transition from a small cooperative to a structured financial institution.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-home"></i>
                                                        <span>Dedicated Office Space</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-handshake"></i>
                                                        <span>Professional Services</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Technology Integration -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="400">
                                    <div class="timeline-dot">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    <div class="timeline-date">2010</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Digital Revolution</h3>
                                                <span class="timeline-badge technology">Technology</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>We embraced the digital age by implementing our first computerized management system. This technological leap enhanced operational efficiency, improved record-keeping, and provided members with faster, more reliable services.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-computer"></i>
                                                        <span>Computerized Systems</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                        <span>Enhanced Efficiency</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Regulatory Compliance -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="500">
                                    <div class="timeline-dot">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="timeline-date">2015</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>SASRA Registration</h3>
                                                <span class="timeline-badge compliance">Compliance</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>A proud moment as we achieved official registration with the SACCO Societies Regulatory Authority (SASRA). This certification validated our commitment to transparency, good governance, and regulatory compliance, strengthening member confidence.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-shield-alt"></i>
                                                        <span>SASRA Certified</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-balance-scale"></i>
                                                        <span>Regulatory Compliance</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Digital Banking -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="600">
                                    <div class="timeline-dot">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="timeline-date">2018</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Mobile Banking Launch</h3>
                                                <span class="timeline-badge digital">Digital Era</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>We launched our comprehensive mobile banking platform, revolutionizing how members interact with their finances. 24/7 access, instant transactions, and real-time account monitoring became the new standard for member convenience.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-clock"></i>
                                                        <span>24/7 Access</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>Instant Transactions</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Present Day -->
                                <div class="timeline-item" data-aos="fade-up" data-aos-delay="700">
                                    <div class="timeline-dot">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="timeline-date">2024</div>
                                    <div class="timeline-content">
                                        <div class="timeline-card">
                                            <div class="timeline-header">
                                                <h3>Leading the Future</h3>
                                                <span class="timeline-badge present">Present</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Today, we proudly serve over 10,000 members with a comprehensive suite of financial products and services. Our commitment to innovation, member satisfaction, and community development continues to drive us forward as we shape the future of cooperative banking.</p>
                                                <div class="timeline-highlights">
                                                    <div class="highlight-item">
                                                        <i class="fas fa-users"></i>
                                                        <span>10,000+ Members</span>
                                                    </div>
                                                    <div class="highlight-item">
                                                        <i class="fas fa-rocket"></i>
                                                        <span>Continuous Innovation</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
    
    <!-- Achievements Gallery -->
    <section class="achievements-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Milestones & Achievements</h2>
                        <div class="achievements-grid">
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="100">
                                <div class="achievement-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>Best SACCO Award 2018</h3>
                                    <p>Recognized for excellence in member service and financial management at the annual SACCO leaders conference.</p>
                                    <div class="achievement-year">2018</div>
                                </div>
                            </div>
                            
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="200">
                                <div class="achievement-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>10,000+ Members Milestone</h3>
                                    <p>Reached the significant milestone of serving over ten thousand members across diverse demographics and sectors.</p>
                                    <div class="achievement-year">2022</div>
                                </div>
                            </div>
                            
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="300">
                                <div class="achievement-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>1 Billion Asset Base</h3>
                                    <p>Achieved a significant financial milestone, demonstrating our stability and sustainable growth trajectory.</p>
                                    <div class="achievement-year">2023</div>
                                </div>
                            </div>
                            
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="400">
                                <div class="achievement-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>SASRA Compliance Excellence</h3>
                                    <p>Maintained exemplary regulatory compliance and governance standards, earning recognition from SASRA.</p>
                                    <div class="achievement-year">2024</div>
                                </div>
                            </div>
                            
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="500">
                                <div class="achievement-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>Education Support Program</h3>
                                    <p>Launched comprehensive education financing program, supporting over 1,000 students in their academic journey.</p>
                                    <div class="achievement-year">2021</div>
                                </div>
                            </div>
                            
                            <div class="achievement-card" data-aos="zoom-in" data-aos-delay="600">
                                <div class="achievement-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="achievement-content">
                                    <h3>Community Impact Award</h3>
                                    <p>Honored for outstanding community development initiatives and social responsibility programs.</p>
                                    <div class="achievement-year">2020</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Leadership Legacy Section -->
    <section class="leadership-legacy-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Leadership Legacy</h2>
                        <div class="legacy-content">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <div class="legacy-image">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/legacyfounderbg.jpg" 
                                             alt="Founding Leadership" class="img-fluid rounded-circle shadow">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="legacy-quote">
                                        <div class="quote-icon">
                                            <i class="fas fa-quote-left"></i>
                                        </div>
                                        <blockquote class="blockquote">
                                            <p>"When we started Daystar Multi-purpose Co-operative Society as a Housing Co-operative in 1990, we envisioned more than just a financial institution. We dreamed of creating a community where Daystar staff support each other's growth, where pooled resources lead to improved welfare, and where cooperative principles drive sustainable prosperity for all members."</p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer mt-3">
                                            <strong>John Githongo</strong>, <cite title="Founding Chairperson">Founding Chairperson</cite>
                                        </figcaption>
                                        <div class="legacy-stats mt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="legacy-stat">
                                                        <h4>29</h4>
                                                        <p>Years of Leadership</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="legacy-stat">
                                                        <h4>50→10K</h4>
                                                        <p>Member Growth</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Future Vision Section -->
    <section class="future-vision-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <div class="icon-section text-center">
                            <i class="fas fa-rocket text-primary"></i>
                        </div>
                        <h2 class="section-title text-center">Shaping Tomorrow</h2>
                        <p class="lead text-center mb-5">
                            As we look to the future, our commitment to innovation, member satisfaction, and community development remains unwavering. Join us as we continue to write the next chapter of our remarkable journey.
                        </p>
                        
                        <div class="future-goals">
                            <div class="row">
                                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                                    <div class="goal-card">
                                        <div class="goal-icon">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </div>
                                        <h4>Expand Reach</h4>
                                        <p>Extend our services to more communities while maintaining our personal touch and member-focused approach.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                                    <div class="goal-card">
                                        <div class="goal-icon">
                                            <i class="fas fa-lightbulb"></i>
                                        </div>
                                        <h4>Innovate Solutions</h4>
                                        <p>Continuously develop cutting-edge financial products and digital solutions to meet evolving member needs.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                                    <div class="goal-card">
                                        <div class="goal-icon">
                                            <i class="fas fa-hands-helping"></i>
                                        </div>
                                        <h4>Strengthen Community</h4>
                                        <p>Deepen our impact on community development and social responsibility initiatives across Kenya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-5">
                            <h3 class="mb-4">Be Part of Our Continuing Story</h3>
                            <div class="cta-buttons">
                                <a href="<?php echo esc_url(home_url('/how-to-join/')); ?>" class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-user-plus me-2"></i>Join Our Community
                                </a>
                                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-info-circle me-2"></i>Learn More About Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer(); 
?> 