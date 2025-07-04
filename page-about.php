<?php
/*
Template Name: About Us Page
*/
get_header(); ?>

<main id="primary" class="site-main page-about-content aboutus-bg-img">
    <!-- Parallax Background -->
    <div class="parallax-container">
        <div class="parallax-layer parallax-layer-1"></div>
        <div class="parallax-layer parallax-layer-2"></div>
        <div class="parallax-layer parallax-layer-3"></div>
    </div>

    <!-- About Us Header -->
    <header class="glass-header py-5 mb-5" style="margin-top: 80px;">
        <style>
        .glass-header .display-title {
            color: #fff !important;
            text-shadow: 0 2px 12px rgba(0,0,0,0.45), 0 1px 0 #222;
            font-weight: 800;
        }
        .glass-header .content-text.lead {
            color: #fff !important;
            text-shadow: 0 2px 8px rgba(0,0,0,0.35), 0 1px 0 #222;
            font-weight: 500;
        }
        .glass-header .glass-card {
            background: rgba(30, 41, 59, 0.92);
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(30,41,59,0.12);
            border: 1px solid rgba(255,255,255,0.10);
        }
        .glass-header .glass-card .content-text {
            color: #fff !important;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0,0,0,0.35), 0 1px 0 #222;
        }
        .glass-header .glass-card i {
            color: #60a5fa !important;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.25));
        }
        .breadcrumb {
            background: rgba(30,41,59,0.85);
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            margin-bottom: 2rem;
            color: #fff;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .breadcrumb a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb .separator {
            margin: 0 0.5em;
            color: #fff;
        }
        </style>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-title display-4 mb-2">About Us</h1>
                    <p class="content-text lead mb-0">Empowering Members. Building Community. Shaping the Future.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="glass-card d-inline-block px-3 py-2">
                        <i class="fas fa-users text-primary me-2"></i>
                        <span class="content-text">Daystar Multipurpose Co-operative Society Ltd</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="container">
        <nav class="breadcrumb my-0" aria-label="breadcrumb">
            <a href="/">Home</a>
            <span class="separator">/</span>
            <span>About Us</span>
        </nav>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <style>
                .glass-card {
                    background: rgba(30, 41, 59, 0.92); /* dark glass effect */
                    border-radius: 1.25rem;
                    box-shadow: 0 4px 24px rgba(30,41,59,0.12);
                    border: 1px solid rgba(255,255,255,0.10);
                    margin-bottom: 2rem;
                }
                .glass-card .section-title {
                    color: #fff;
                    font-weight: 800;
                    letter-spacing: 0.5px;
                }
                .glass-card p, .glass-card ul, .glass-card li {
                    color: #f8fafc;
                    font-size: 1.12rem;
                }
                .glass-card ul {
                    padding-left: 1.2em;
                }
                .glass-card li {
                    margin-bottom: 0.5em;
                }
                .glass-card strong {
                    color: #60a5fa;
                    font-weight: 700;
                }
                .glass-card .icon-section {
                    margin-bottom: 1.5rem;
                }
                .glass-card .icon-section i {
                    font-size: 2.2rem;
                    margin-bottom: 0.5rem;
                }
                .glass-card .highlight {
                    background: rgba(59,130,246,0.18);
                    border-radius: 0.5em;
                    padding: 0.1em 0.5em;
                    color: #fff;
                    font-weight: 700;
                }
                .glass-card.text-center .section-title {
                    color: #60a5fa;
                }
                .aboutus-bg-img {
                    position: relative;
                    min-height: 100vh;
                    width: 100vw;
                    left: 0;
                    top: 0;
                    background: url('/wp-content/themes/daystar-theme4/assets/images/aboutusbackgroundimg.jpg') no-repeat center center fixed;
                    background-size: cover;
                    z-index: 1;
                }
                .aboutus-bg-img:before {
                    content: '';
                    position: absolute;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(30,41,59,0.60); /* dark overlay for readability */
                    z-index: 2;
                }
                .page-about-content > * {
                    position: relative;
                    z-index: 3;
                }
                </style>
                <!-- Mission Section -->
                <section id="mission" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-bullseye text-primary"></i></div>
                    <h2 class="section-title text-center">Our Mission</h2>
                    <p class="content-text">To empower our members by providing innovative, accessible, and sustainable financial solutions that foster personal growth, economic development, and community well-being. We are dedicated to nurturing a culture of trust, collaboration, and continuous improvement, ensuring every member has the opportunity to thrive and achieve their goals.</p>
                </section>

                <!-- Vision Section -->
                <section id="vision" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-eye text-info"></i></div>
                    <h2 class="section-title text-center">Our Vision</h2>
                    <p class="content-text">To be the leading co-operative society, recognized for excellence, integrity, and positive impact in the lives of our members and the broader community. We envision a future where financial empowerment and social responsibility go hand in hand, creating lasting value for generations to come.</p>
                </section>

                <!-- Values Section -->
                <section id="values" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-heart text-danger"></i></div>
                    <h2 class="section-title text-center">Our Core Values</h2>
                    <ul class="content-text">
                        <li><strong>Integrity:</strong> We uphold the highest standards of honesty and transparency in all our dealings, building trust with every interaction.</li>
                        <li><strong>Inclusivity:</strong> We embrace diversity and ensure equal opportunities for all members, fostering a sense of belonging and respect.</li>
                        <li><strong>Innovation:</strong> We continuously seek creative solutions to meet our members' evolving needs, staying ahead in a dynamic world.</li>
                        <li><strong>Service:</strong> We are committed to delivering exceptional service and value to our members, always putting their interests first.</li>
                        <li><strong>Community:</strong> We believe in collective growth and giving back to society, making a meaningful difference together.</li>
                    </ul>
                </section>

                <!-- Impact Section -->
                <section id="impact" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-globe-africa text-success"></i></div>
                    <h2 class="section-title text-center">Our Impact</h2>
                    <p class="content-text">Over the years, Daystar Multipurpose Co-operative Society Ltd has transformed lives by supporting education, entrepreneurship, and community development. Our members have accessed affordable loans, grown their businesses, and improved their families' quality of life. We actively participate in local initiatives, sponsor educational programs, and champion financial literacy for all ages. <span class="highlight">Together, we are building a brighter, more inclusive future.</span></p>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 text-center h-100">
                                <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                                <h5 class="content-text mb-1">Education Support</h5>
                                <p class="content-text small">Scholarships, school fee loans, and mentorship for members' children, opening doors to new opportunities.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 text-center h-100">
                                <i class="fas fa-briefcase fa-2x text-success mb-2"></i>
                                <h5 class="content-text mb-1">Business Growth</h5>
                                <p class="content-text small">Microloans, business advisory, and networking for entrepreneurs, fueling innovation and local enterprise.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 text-center h-100">
                                <i class="fas fa-hands-helping fa-2x text-warning mb-2"></i>
                                <h5 class="content-text mb-1">Community Outreach</h5>
                                <p class="content-text small">Charity drives, health camps, and local partnerships, making a tangible impact where it matters most.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Member Benefits Section -->
                <section id="benefits" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-gift text-warning"></i></div>
                    <h2 class="section-title text-center">Member Benefits</h2>
                    <ul class="content-text">
                        <li><strong>Affordable Loans:</strong> Access to low-interest loans tailored to your needs, with flexible repayment options and quick approvals.</li>
                        <li><strong>Attractive Savings:</strong> Competitive returns and flexible savings plans to help you achieve your financial goals.</li>
                        <li><strong>Financial Security:</strong> Insurance and emergency funds for peace of mind, protecting you and your loved ones.</li>
                        <li><strong>Exclusive Events:</strong> Invitations to member-only seminars, workshops, and networking events for personal and professional growth.</li>
                        <li><strong>Personalized Support:</strong> Dedicated customer service and financial advisory, guiding you every step of the way.</li>
                        <li><strong>Voting Rights:</strong> Have a say in the society’s direction and leadership, ensuring your voice is heard.</li>
                        <li><strong>Digital Access:</strong> Manage your finances anytime, anywhere with our secure online and mobile platforms.</li>
                    </ul>
                </section>

                <!-- Unique Features Section -->
                <section id="unique" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-star text-secondary"></i></div>
                    <h2 class="section-title text-center">What Makes Us Unique</h2>
                    <ul class="content-text">
                        <li><strong>Member-Driven:</strong> Every decision is made with our members’ best interests at heart, fostering a true sense of ownership.</li>
                        <li><strong>Tech-Enabled:</strong> Modern online and mobile banking for easy access anywhere, anytime, with robust security.</li>
                        <li><strong>Transparent Governance:</strong> Open communication and regular reporting to all members, building trust and accountability.</li>
                        <li><strong>Social Responsibility:</strong> Commitment to ethical practices and community betterment, making a difference beyond financial services.</li>
                        <li><strong>Continuous Growth:</strong> We invest in new products and services to meet changing needs, always striving for excellence.</li>
                        <li><strong>Empowered Community:</strong> We believe in the power of collective action, supporting each other to reach new heights.</li>
                    </ul>
                </section>

                <!-- Call to Action -->
                <section class="glass-card p-4 mt-5 text-center fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-hands-helping text-primary"></i></div>
                    <h2 class="section-title mb-3">Join Us</h2>
                    <p class="content-text mb-4">Become part of a vibrant community that values your growth and success. Whether you are looking for financial solutions, personal development, or a sense of belonging, Daystar Multipurpose Co-operative Society Ltd is here for you. <span class="highlight">Your journey to a brighter future starts here.</span></p>
                    <a href="/page-how-to-join" class="btn btn-primary btn-lg">Learn How to Join</a>
                </section>
            </div>
            <!-- Sidebar: Modern Quick Links -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <nav class="modern-quick-links glass-card p-4 text-center">
                    <h5 class="section-title mb-4">Explore</h5>
                    <a href="#mission" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-primary text-white"><i class="fas fa-bullseye"></i></span>
                        <span class="tab-label">Our Mission</span>
                    </a>
                    <a href="#vision" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-info text-white"><i class="fas fa-eye"></i></span>
                        <span class="tab-label">Our Vision</span>
                    </a>
                    <a href="#values" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-danger text-white"><i class="fas fa-heart"></i></span>
                        <span class="tab-label">Our Values</span>
                    </a>
                    <a href="#impact" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-success text-white"><i class="fas fa-globe-africa"></i></span>
                        <span class="tab-label">Our Impact</span>
                    </a>
                    <a href="#benefits" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-warning text-white"><i class="fas fa-gift"></i></span>
                        <span class="tab-label">Member Benefits</span>
                    </a>
                    <a href="#unique" class="quick-link-tab">
                        <span class="icon-circle bg-secondary text-white"><i class="fas fa-star"></i></span>
                        <span class="tab-label">What Makes Us Unique</span>
                    </a>
                </nav>
                <style>
                .modern-quick-links {
                    border-radius: 1.5rem;
                    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                    background: rgba(30, 41, 59, 0.92); /* dark glass effect */
                }
                .modern-quick-links h5.section-title {
                    color: #fff;
                    letter-spacing: 1px;
                }
                .quick-link-tab {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    padding: 0.75rem 1rem;
                    border-radius: 2rem;
                    background: rgba(255,255,255,0.10);
                    margin-bottom: 0.75rem;
                    text-decoration: none;
                    color: #f8fafc;
                    font-weight: 600;
                    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    border: 1px solid rgba(255,255,255,0.08);
                }
                .quick-link-tab:hover {
                    background: rgba(59,130,246,0.18);
                    color: #fff;
                    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
                }
                .icon-circle {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 2.5rem;
                    height: 2.5rem;
                    border-radius: 50%;
                    font-size: 1.3rem;
                    margin-right: 0.5rem;
                    background: rgba(255,255,255,0.18);
                    color: #fff;
                }
                .tab-label {
                    font-size: 1.08rem;
                    color: #f8fafc;
                    letter-spacing: 0.5px;
                }
                @media (max-width: 991px) {
                    .modern-quick-links { margin-bottom: 2rem; }
                }
                </style>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="floating-action">
        <i class="fas fa-question"></i>
    </div>
</main><!-- #main -->

<?php get_footer(); ?>