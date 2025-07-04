<?php
/**
 * Template Name: Supervisory Committee Page
 *
 * The template for displaying the Supervisory Committee page.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main supervisory-committee-page">
    <!-- Hero Section with Background Image -->
    <section class="supervisory-hero">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title" data-aos="fade-up">Supervisory Committee</h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Independent oversight ensuring transparency, accountability, and member protection
                    </p>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 id="committee-count">5</h3>
                                    <p>Committee Members</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>12</h3>
                                    <p>Meetings Per Year</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>100%</h3>
                                    <p>Independent Oversight</p>
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
    </section>

    <!-- Introduction Section -->
    <section class="supervisory-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="intro-content glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">About the Supervisory Committee</h2>
                        <p class="lead text-center">
                            The Supervisory Committee serves as an independent oversight body that ensures the SACCO operates 
                            in accordance with cooperative principles, regulatory requirements, and member interests. The committee 
                            provides checks and balances, conducts audits, and ensures transparency in all operations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Committee Members Grid Section -->
    <section class="supervisory-grid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card text-center" data-aos="fade-up">
                        <h2 class="section-title mb-0">Meet Our Committee Members</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                // Query supervisory committee from custom post type
                $committee_query = new WP_Query(array(
                    'post_type' => 'supervisory_committee',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                $committee_members = array();
                if ($committee_query->have_posts()) {
                    while ($committee_query->have_posts()) {
                        $committee_query->the_post();
                        $committee_members[] = array(
                            'name' => get_the_title(),
                            'position' => get_post_meta(get_the_ID(), '_committee_position', true),
                            'bio' => get_the_content(),
                            'qualifications' => get_post_meta(get_the_ID(), '_qualifications', true),
                            'experience' => get_post_meta(get_the_ID(), '_experience', true),
                            'responsibilities' => get_post_meta(get_the_ID(), '_responsibilities', true),
                            'email' => get_post_meta(get_the_ID(), '_email', true),
                            'phone' => get_post_meta(get_the_ID(), '_phone', true),
                            'linkedin' => get_post_meta(get_the_ID(), '_linkedin_url', true),
                            'tenure_start' => get_post_meta(get_the_ID(), '_tenure_start', true),
                            'tenure_end' => get_post_meta(get_the_ID(), '_tenure_end', true),
                            'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : ''
                        );
                    }
                    wp_reset_postdata();
                }

                // Static fallback data if no CPT entries
                if (empty($committee_members)) {
                    $committee_members = [
                        [
                            'name' => 'Dr. Margaret Wanjiru',
                            'position' => 'Chairperson',
                            'bio' => 'Dr. Wanjiru brings extensive experience in audit and governance, ensuring the highest standards of oversight and accountability in the SACCO\'s operations.',
                            'qualifications' => 'PhD in Accounting, CPA(K), CIA (Certified Internal Auditor), Master of Commerce',
                            'experience' => '20+ years in audit and governance, Former Chief Internal Auditor at multinational corporation, Expert in cooperative governance and risk management',
                            'responsibilities' => 'Committee leadership, Audit oversight, Governance compliance, Risk assessment coordination',
                            'email' => 'supervisory.chair@daystarcoopsacco.com',
                            'phone' => '+254 700 200 001',
                            'linkedin' => '',
                            'tenure_start' => '2021-01-01',
                            'tenure_end' => '',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mr. Francis Kiprotich',
                            'position' => 'Vice Chairperson',
                            'bio' => 'Francis specializes in financial oversight and regulatory compliance, ensuring the SACCO adheres to all statutory requirements and best practices.',
                            'qualifications' => 'Master of Business Administration, Bachelor of Commerce (Accounting), ACCA, Certified Fraud Examiner',
                            'experience' => '16+ years in financial oversight, Former Senior Auditor at Big Four firm, Specialist in cooperative regulations and compliance',
                            'responsibilities' => 'Financial oversight, Compliance monitoring, Fraud prevention, Regulatory liaison',
                            'email' => 'supervisory.vice@daystarcoopsacco.com',
                            'phone' => '+254 700 200 002',
                            'linkedin' => '',
                            'tenure_start' => '2021-01-01',
                            'tenure_end' => '',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mrs. Rose Muthoni',
                            'position' => 'Secretary',
                            'bio' => 'Rose ensures proper documentation and communication of committee activities, maintaining transparency and accountability in all supervisory functions.',
                            'qualifications' => 'Bachelor of Arts (Secretarial Studies), Diploma in Records Management, Certified Corporate Secretary',
                            'experience' => '12+ years in corporate governance, Former Company Secretary, Expert in board governance and documentation',
                            'responsibilities' => 'Meeting documentation, Communication coordination, Records management, Transparency oversight',
                            'email' => 'supervisory.secretary@daystarcoopsacco.com',
                            'phone' => '+254 700 200 003',
                            'linkedin' => '',
                            'tenure_start' => '2021-06-01',
                            'tenure_end' => '',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mr. John Omondi',
                            'position' => 'Member',
                            'bio' => 'John brings legal expertise to the committee, ensuring all operations comply with cooperative law and protecting member rights.',
                            'qualifications' => 'LLB, LLM (Corporate Law), Advocate of the High Court of Kenya, Certified Mediator',
                            'experience' => '14+ years in legal practice, Former Legal Counsel for cooperative societies, Expert in cooperative law and member rights',
                            'responsibilities' => 'Legal compliance, Member rights protection, Dispute resolution, Policy review',
                            'email' => 'supervisory.legal@daystarcoopsacco.com',
                            'phone' => '+254 700 200 004',
                            'linkedin' => '',
                            'tenure_start' => '2021-03-01',
                            'tenure_end' => '',
                            'image' => ''
                        ],
                        [
                            'name' => 'Ms. Elizabeth Nyokabi',
                            'position' => 'Member',
                            'bio' => 'Elizabeth focuses on operational audits and process improvement, ensuring efficiency and effectiveness in service delivery to members.',
                            'qualifications' => 'Bachelor of Commerce (Finance), Certified Internal Auditor, Diploma in Quality Management',
                            'experience' => '10+ years in internal audit, Former Operations Auditor, Specialist in process improvement and quality assurance',
                            'responsibilities' => 'Operational audits, Process improvement, Quality assurance, Performance monitoring',
                            'email' => 'supervisory.operations@daystarcoopsacco.com',
                            'phone' => '+254 700 200 005',
                            'linkedin' => '',
                            'tenure_start' => '2021-09-01',
                            'tenure_end' => '',
                            'image' => ''
                        ]
                    ];
                }

                foreach ($committee_members as $index => $member): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="committee-card">
                        <div class="committee-image">
                            <?php if (!empty($member['image'])): ?>
                                <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                            <?php else: ?>
                                <div class="committee-avatar">
                                    <i class="fas fa-search"></i>
                                </div>
                            <?php endif; ?>
                            <div class="committee-overlay">
                                <div class="committee-contact">
                                    <?php if (!empty($member['email'])): ?>
                                        <a href="mailto:<?php echo esc_attr($member['email']); ?>" class="contact-btn">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['phone'])): ?>
                                        <a href="tel:<?php echo esc_attr($member['phone']); ?>" class="contact-btn">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['linkedin'])): ?>
                                        <a href="<?php echo esc_url($member['linkedin']); ?>" target="_blank" class="contact-btn">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="committee-info">
                            <h4 class="committee-name"><?php echo esc_html($member['name']); ?></h4>
                            <p class="committee-position"><?php echo esc_html($member['position']); ?></p>
                            <div class="committee-meta">
                                <?php if (!empty($member['tenure_start'])): ?>
                                    <span class="tenure">
                                        <i class="fas fa-calendar-alt"></i> 
                                        Since <?php echo date('M Y', strtotime($member['tenure_start'])); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <p class="committee-bio"><?php echo esc_html(wp_trim_words($member['bio'], 25, '...')); ?></p>
                            
                            <!-- Expandable Details -->
                            <div class="committee-details">
                                <?php if (!empty($member['qualifications'])): ?>
                                    <div class="detail-section">
                                        <h6><i class="fas fa-graduation-cap"></i> Qualifications</h6>
                                        <p><?php echo esc_html($member['qualifications']); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($member['experience'])): ?>
                                    <div class="detail-section">
                                        <h6><i class="fas fa-briefcase"></i> Experience</h6>
                                        <p><?php echo esc_html($member['experience']); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($member['responsibilities'])): ?>
                                    <div class="detail-section">
                                        <h6><i class="fas fa-tasks"></i> Key Responsibilities</h6>
                                        <p><?php echo esc_html($member['responsibilities']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <button class="btn btn-outline-primary btn-sm toggle-details">
                                <span class="show-text">Show Details</span>
                                <span class="hide-text">Hide Details</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Committee Functions Section -->
    <section class="committee-functions">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Committee Functions</h2>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="function-item">
                                    <div class="function-icon">
                                        <i class="fas fa-search-dollar"></i>
                                    </div>
                                    <h4>Financial Audits</h4>
                                    <p>Conduct regular financial audits to ensure accuracy, transparency, and compliance with accounting standards.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                                <div class="function-item">
                                    <div class="function-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h4>Compliance Monitoring</h4>
                                    <p>Monitor adherence to cooperative laws, regulations, and internal policies to ensure legal compliance.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="function-item">
                                    <div class="function-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h4>Member Protection</h4>
                                    <p>Safeguard member interests and ensure fair treatment in all SACCO operations and decisions.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                                <div class="function-item">
                                    <div class="function-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <h4>Report Generation</h4>
                                    <p>Prepare comprehensive reports on findings and recommendations for board and member review.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Audit Schedule Section -->
    <section class="audit-schedule">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">Audit Schedule & Activities</h2>
                        <div class="schedule-grid">
                            <div class="schedule-item">
                                <div class="schedule-icon">
                                    <i class="fas fa-calendar-week"></i>
                                </div>
                                <h4>Monthly Reviews</h4>
                                <p>Monthly financial reviews and operational assessments to ensure ongoing compliance and performance.</p>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h4>Quarterly Audits</h4>
                                <p>Comprehensive quarterly audits covering financial statements, loan portfolios, and risk management.</p>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h4>Annual Assessment</h4>
                                <p>Annual comprehensive assessment and report to the Annual General Meeting on SACCO performance.</p>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h4>Special Investigations</h4>
                                <p>Ad-hoc investigations and audits when concerns are raised or irregularities are suspected.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Powers and Authority Section -->
    <section class="powers-authority">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">Powers and Authority</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h4><i class="fas fa-gavel"></i> Investigative Powers</h4>
                                <ul>
                                    <li>Access to all financial records and documents</li>
                                    <li>Authority to interview staff and management</li>
                                    <li>Power to engage external auditors when necessary</li>
                                    <li>Right to inspect all SACCO premises and operations</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fas fa-balance-scale"></i> Reporting Authority</h4>
                                <ul>
                                    <li>Direct reporting to the Annual General Meeting</li>
                                    <li>Authority to recommend corrective actions</li>
                                    <li>Power to escalate serious issues to regulators</li>
                                    <li>Right to publish findings and recommendations</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Committee Section -->
    <section class="contact-committee">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title mb-4 text-center">Report to the Committee</h2>
                        <p class="lead mb-4 text-center">
                            Members can report concerns, irregularities, or suggestions directly to the Supervisory Committee. 
                            All reports are treated with confidentiality and investigated thoroughly.
                        </p>
                        <div class="contact-options text-center" data-aos="fade-up" data-aos-delay="400">
                            <a href="mailto:supervisory@daystarcoopsacco.com" class="btn btn-primary btn-lg me-3 mb-3">
                                <i class="fas fa-envelope me-2"></i>Email Committee
                            </a>
                            <a href="tel:+254700200000" class="btn btn-outline-primary btn-lg mb-3">
                                <i class="fas fa-phone me-2"></i>Call Hotline
                            </a>
                        </div>
                        <div class="whistleblower-notice">
                            <p><i class="fas fa-shield-alt"></i> <strong>Whistleblower Protection:</strong> 
                            All reports are handled confidentially and reporters are protected from retaliation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<script>
// Update committee count dynamically
document.addEventListener('DOMContentLoaded', function() {
    const committeeCount = document.querySelectorAll('.committee-card').length;
    const committeeCountElement = document.getElementById('committee-count');
    if (committeeCountElement) {
        committeeCountElement.textContent = committeeCount;
    }
    
    // Toggle details functionality
    const toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.committee-card');
            const details = card.querySelector('.committee-details');
            const icon = this.querySelector('i');
            
            if (details.style.display === 'none' || !details.style.display) {
                details.style.display = 'block';
                this.classList.add('active');
                icon.style.transform = 'rotate(180deg)';
                this.querySelector('.show-text').style.display = 'none';
                this.querySelector('.hide-text').style.display = 'inline';
            } else {
                details.style.display = 'none';
                this.classList.remove('active');
                icon.style.transform = 'rotate(0deg)';
                this.querySelector('.show-text').style.display = 'inline';
                this.querySelector('.hide-text').style.display = 'none';
            }
        });
    });
});
</script>

<?php
get_footer();
?>