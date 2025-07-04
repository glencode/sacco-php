<?php
/**
 * Template Name: Board of Directors Page
 *
 * The template for displaying the Board of Directors page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main page-board-content board-bg-img">
    <!-- Parallax Background -->
    <div class="parallax-container">
        <div class="parallax-layer parallax-layer-1"></div>
        <div class="parallax-layer parallax-layer-2"></div>
        <div class="parallax-layer parallax-layer-3"></div>
    </div>

    <!-- Board of Directors Header -->
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
                    <h1 class="display-title display-4 mb-2">Board of Directors</h1>
                    <p class="content-text lead mb-0">Leadership. Vision. Excellence.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="glass-card d-inline-block px-3 py-2">
                        <i class="fas fa-users-cog text-primary me-2"></i>
                        <span class="content-text">Governance & Leadership</span>
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
            <span>Board of Directors</span>
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
                .board-bg-img {
                    position: relative;
                    min-height: 100vh;
                    width: 100vw;
                    left: 0;
                    top: 0;
                    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/boardofdirectorsbg.jpg') no-repeat center center fixed;
                    background-size: cover;
                    z-index: 1;
                }
                .board-bg-img:before {
                    content: '';
                    position: absolute;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(30,41,59,0.60); /* dark overlay for readability */
                    z-index: 2;
                }
                .page-board-content > * {
                    position: relative;
                    z-index: 3;
                }
                .board-member-card {
                    background: rgba(30, 41, 59, 0.92);
                    border-radius: 1.25rem;
                    box-shadow: 0 4px 24px rgba(30,41,59,0.12);
                    border: 1px solid rgba(255,255,255,0.10);
                    margin-bottom: 2rem;
                    overflow: hidden;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .board-member-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 8px 32px rgba(30,41,59,0.20);
                }
                .board-member-photo {
                    width: 100%;
                    height: 250px;
                    object-fit: cover;
                    border-radius: 1rem 1rem 0 0;
                }
                .board-member-info {
                    padding: 1.5rem;
                }
                .board-member-name {
                    color: #fff;
                    font-weight: 800;
                    font-size: 1.3rem;
                    margin-bottom: 0.5rem;
                }
                .board-member-position {
                    color: #60a5fa;
                    font-weight: 600;
                    font-size: 1.1rem;
                    margin-bottom: 1rem;
                }
                .board-member-bio {
                    color: #f8fafc;
                    font-size: 1rem;
                    line-height: 1.6;
                    margin-bottom: 1rem;
                }
                .board-member-details {
                    border-top: 1px solid rgba(255,255,255,0.10);
                    padding-top: 1rem;
                    margin-top: 1rem;
                }
                .board-member-details h6 {
                    color: #60a5fa;
                    font-weight: 700;
                    margin-bottom: 0.5rem;
                    font-size: 0.9rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .board-member-details p {
                    color: #f8fafc;
                    font-size: 0.95rem;
                    margin-bottom: 0.75rem;
                }
                .board-member-contact {
                    display: flex;
                    gap: 1rem;
                    margin-top: 1rem;
                }
                .board-member-contact a {
                    color: #60a5fa;
                    font-size: 1.2rem;
                    transition: color 0.3s ease;
                }
                .board-member-contact a:hover {
                    color: #fff;
                }
                .board-intro-section {
                    background: rgba(30, 41, 59, 0.92);
                    border-radius: 1.25rem;
                    box-shadow: 0 4px 24px rgba(30,41,59,0.12);
                    border: 1px solid rgba(255,255,255,0.10);
                    padding: 2rem;
                    margin-bottom: 3rem;
                }
                .board-intro-section .section-title {
                    color: #60a5fa;
                    font-weight: 800;
                    text-align: center;
                    margin-bottom: 1.5rem;
                }
                .board-intro-section p {
                    color: #f8fafc;
                    font-size: 1.12rem;
                    line-height: 1.7;
                    text-align: center;
                }
                </style>

                <!-- Introduction Section -->
                <section class="board-intro-section fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-users-cog text-primary"></i></div>
                    <h2 class="section-title">Our Leadership Team</h2>
                    <p>The Board of Directors of Daystar Multipurpose Co-operative Society Ltd comprises experienced professionals committed to providing strategic leadership and governance. Our board members bring diverse expertise in finance, business management, cooperative governance, and community development, ensuring the society operates with integrity, transparency, and in the best interests of our members.</p>
                </section>

                <!-- Dynamic Board Members Section -->
                <?php
                // Query board directors from custom post type
                $board_query = new WP_Query(array(
                    'post_type' => 'board_director',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ($board_query->have_posts()) : ?>
                    <section id="board-members" class="fade-in-up">
                        <div class="row">
                            <?php while ($board_query->have_posts()) : $board_query->the_post();
                                $position = get_post_meta(get_the_ID(), '_board_position', true);
                                $qualifications = get_post_meta(get_the_ID(), '_qualifications', true);
                                $experience = get_post_meta(get_the_ID(), '_experience', true);
                                $email = get_post_meta(get_the_ID(), '_email', true);
                                $phone = get_post_meta(get_the_ID(), '_phone', true);
                                $linkedin = get_post_meta(get_the_ID(), '_linkedin_url', true);
                                $tenure_start = get_post_meta(get_the_ID(), '_tenure_start', true);
                                $tenure_end = get_post_meta(get_the_ID(), '_tenure_end', true);
                            ?>
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', array('class' => 'board-member-photo', 'alt' => get_the_title())); ?>
                                    <?php else : ?>
                                        <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #60a5fa, #3b82f6);">
                                            <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="board-member-info">
                                        <h3 class="board-member-name"><?php the_title(); ?></h3>
                                        <?php if ($position) : ?>
                                            <p class="board-member-position"><?php echo esc_html($position); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (get_the_content()) : ?>
                                            <div class="board-member-bio">
                                                <?php echo wp_trim_words(get_the_content(), 30, '...'); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="board-member-details">
                                            <?php if ($qualifications) : ?>
                                                <h6>Qualifications</h6>
                                                <p><?php echo esc_html($qualifications); ?></p>
                                            <?php endif; ?>
                                            
                                            <?php if ($experience) : ?>
                                                <h6>Experience</h6>
                                                <p><?php echo esc_html($experience); ?></p>
                                            <?php endif; ?>
                                            
                                            <?php if ($tenure_start) : ?>
                                                <h6>Tenure</h6>
                                                <p>
                                                    <?php echo date('F Y', strtotime($tenure_start)); ?>
                                                    <?php if ($tenure_end) : ?>
                                                        - <?php echo date('F Y', strtotime($tenure_end)); ?>
                                                    <?php else : ?>
                                                        - Present
                                                    <?php endif; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($email || $phone || $linkedin) : ?>
                                            <div class="board-member-contact">
                                                <?php if ($email) : ?>
                                                    <a href="mailto:<?php echo esc_attr($email); ?>" title="Email"><i class="fas fa-envelope"></i></a>
                                                <?php endif; ?>
                                                <?php if ($phone) : ?>
                                                    <a href="tel:<?php echo esc_attr($phone); ?>" title="Phone"><i class="fas fa-phone"></i></a>
                                                <?php endif; ?>
                                                <?php if ($linkedin) : ?>
                                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </section>
                <?php else : ?>
                    <!-- Static Fallback Content -->
                    <section id="board-members" class="fade-in-up">
                        <div class="row">
                            <!-- Chairman -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #60a5fa, #3b82f6);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Dr. James Mwangi</h3>
                                        <p class="board-member-position">Chairman</p>
                                        <div class="board-member-bio">
                                            Dr. Mwangi brings over 20 years of experience in cooperative governance and financial management. He has been instrumental in driving the strategic vision of the society.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>PhD in Business Administration, MBA Finance, CPA(K)</p>
                                            <h6>Experience</h6>
                                            <p>Former CEO of a leading SACCO, Board member of multiple financial institutions, Expert in cooperative governance and strategic planning</p>
                                            <h6>Tenure</h6>
                                            <p>January 2020 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:chairman@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000001" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vice Chairman -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #10b981, #059669);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Mrs. Grace Wanjiku</h3>
                                        <p class="board-member-position">Vice Chairman</p>
                                        <div class="board-member-bio">
                                            Mrs. Wanjiku is a seasoned financial expert with extensive experience in risk management and regulatory compliance in the cooperative sector.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>Master of Commerce (Finance), CPA(K), Certified Risk Manager</p>
                                            <h6>Experience</h6>
                                            <p>15+ years in financial services, Former Head of Risk at a major bank, Specialist in cooperative financial regulations</p>
                                            <h6>Tenure</h6>
                                            <p>March 2020 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:vicechairman@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000002" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secretary -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Mr. Peter Kamau</h3>
                                        <p class="board-member-position">Secretary</p>
                                        <div class="board-member-bio">
                                            Mr. Kamau is a legal expert specializing in cooperative law and corporate governance, ensuring compliance with all regulatory requirements.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>LLB, LLM (Corporate Law), Advocate of the High Court of Kenya</p>
                                            <h6>Experience</h6>
                                            <p>12+ years in legal practice, Specialist in cooperative law, Former legal counsel for cooperative societies</p>
                                            <h6>Tenure</h6>
                                            <p>June 2020 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:secretary@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000003" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Treasurer -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Ms. Sarah Njeri</h3>
                                        <p class="board-member-position">Treasurer</p>
                                        <div class="board-member-bio">
                                            Ms. Njeri oversees the financial operations and ensures sound financial management practices across all society activities.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>Bachelor of Commerce (Accounting), CPA(K), ACCA</p>
                                            <h6>Experience</h6>
                                            <p>18+ years in accounting and finance, Former Finance Manager at leading corporations, Expert in financial planning and analysis</p>
                                            <h6>Tenure</h6>
                                            <p>January 2021 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:treasurer@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000004" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Member 1 -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Dr. Mary Wambui</h3>
                                        <p class="board-member-position">Board Member</p>
                                        <div class="board-member-bio">
                                            Dr. Wambui brings valuable insights from the education sector and has been a strong advocate for member welfare and development programs.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>PhD in Education Management, MEd, BEd</p>
                                            <h6>Experience</h6>
                                            <p>25+ years in education sector, Former University Dean, Expert in organizational development and human resources</p>
                                            <h6>Tenure</h6>
                                            <p>September 2020 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:member1@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000005" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Member 2 -->
                            <div class="col-lg-6 mb-4">
                                <div class="board-member-card">
                                    <div class="board-member-photo d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                        <i class="fas fa-user fa-4x text-white opacity-50"></i>
                                    </div>
                                    <div class="board-member-info">
                                        <h3 class="board-member-name">Mr. David Ochieng</h3>
                                        <p class="board-member-position">Board Member</p>
                                        <div class="board-member-bio">
                                            Mr. Ochieng is a technology and innovation expert who has been driving the society's digital transformation initiatives.
                                        </div>
                                        <div class="board-member-details">
                                            <h6>Qualifications</h6>
                                            <p>MSc Information Technology, BSc Computer Science, PMP</p>
                                            <h6>Experience</h6>
                                            <p>14+ years in IT and project management, Former IT Director, Specialist in digital banking and fintech solutions</p>
                                            <h6>Tenure</h6>
                                            <p>February 2021 - Present</p>
                                        </div>
                                        <div class="board-member-contact">
                                            <a href="mailto:member2@daystarcoopsacco.com" title="Email"><i class="fas fa-envelope"></i></a>
                                            <a href="tel:+254700000006" title="Phone"><i class="fas fa-phone"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>

                <!-- Board Responsibilities Section -->
                <section id="responsibilities" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-tasks text-primary"></i></div>
                    <h2 class="section-title text-center">Board Responsibilities</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="content-text">
                                <li><strong>Strategic Planning:</strong> Developing and overseeing the implementation of the society's strategic plans and policies</li>
                                <li><strong>Financial Oversight:</strong> Ensuring sound financial management and monitoring the society's financial performance</li>
                                <li><strong>Risk Management:</strong> Identifying, assessing, and managing risks that could affect the society's operations</li>
                                <li><strong>Regulatory Compliance:</strong> Ensuring compliance with all applicable laws, regulations, and cooperative principles</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="content-text">
                                <li><strong>Member Welfare:</strong> Protecting and promoting the interests of all society members</li>
                                <li><strong>Governance:</strong> Maintaining high standards of corporate governance and transparency</li>
                                <li><strong>Performance Monitoring:</strong> Evaluating management performance and ensuring accountability</li>
                                <li><strong>Stakeholder Relations:</strong> Managing relationships with regulators, partners, and other stakeholders</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Board Meetings Section -->
                <section id="meetings" class="glass-card p-4 mb-4 fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-calendar-alt text-info"></i></div>
                    <h2 class="section-title text-center">Board Meetings</h2>
                    <p class="content-text">The Board of Directors meets regularly to ensure effective governance and oversight of the society's operations. Our meeting schedule includes:</p>
                    <ul class="content-text">
                        <li><strong>Regular Meetings:</strong> Monthly board meetings held on the first Friday of each month</li>
                        <li><strong>Special Meetings:</strong> Called as needed to address urgent matters or strategic decisions</li>
                        <li><strong>Annual General Meeting:</strong> Annual meeting with all members to present reports and elect board members</li>
                        <li><strong>Committee Meetings:</strong> Various committee meetings including Audit, Credit, and Risk Management committees</li>
                    </ul>
                    <p class="content-text"><span class="highlight">All meetings are conducted with full transparency and detailed minutes are maintained for member access.</span></p>
                </section>

                <!-- Contact Board Section -->
                <section class="glass-card p-4 mt-5 text-center fade-in-up">
                    <div class="icon-section text-center"><i class="fas fa-envelope text-primary"></i></div>
                    <h2 class="section-title mb-3">Contact the Board</h2>
                    <p class="content-text mb-4">Members are encouraged to communicate with the Board of Directors regarding any matters of concern or suggestions for improvement. <span class="highlight">Your voice matters in shaping our society's future.</span></p>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 h-100">
                                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                <h5 class="content-text mb-1">Email</h5>
                                <p class="content-text small">board@daystarcoopsacco.com</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 h-100">
                                <i class="fas fa-phone fa-2x text-success mb-2"></i>
                                <h5 class="content-text mb-1">Phone</h5>
                                <p class="content-text small">+254 700 000 000</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="glass-card p-3 h-100">
                                <i class="fas fa-map-marker-alt fa-2x text-warning mb-2"></i>
                                <h5 class="content-text mb-1">Office</h5>
                                <p class="content-text small">Daystar University Campus</p>
                            </div>
                        </div>
                    </div>
                    <a href="/contact-us" class="btn btn-primary btn-lg mt-3">Contact Us</a>
                </section>
            </div>

            <!-- Sidebar: Modern Quick Links -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <nav class="modern-quick-links glass-card p-4 text-center">
                    <h5 class="section-title mb-4">Board Information</h5>
                    <a href="#board-members" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-primary text-white"><i class="fas fa-users"></i></span>
                        <span class="tab-label">Board Members</span>
                    </a>
                    <a href="#responsibilities" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-info text-white"><i class="fas fa-tasks"></i></span>
                        <span class="tab-label">Responsibilities</span>
                    </a>
                    <a href="#meetings" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-success text-white"><i class="fas fa-calendar-alt"></i></span>
                        <span class="tab-label">Meetings</span>
                    </a>
                    <a href="/management-team" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-warning text-white"><i class="fas fa-user-tie"></i></span>
                        <span class="tab-label">Management Team</span>
                    </a>
                    <a href="/supervisory-committee" class="quick-link-tab mb-3">
                        <span class="icon-circle bg-danger text-white"><i class="fas fa-search"></i></span>
                        <span class="tab-label">Supervisory Committee</span>
                    </a>
                    <a href="/about-us" class="quick-link-tab">
                        <span class="icon-circle bg-secondary text-white"><i class="fas fa-info-circle"></i></span>
                        <span class="tab-label">About Us</span>
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