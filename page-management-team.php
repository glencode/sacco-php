<?php
/**
 * Template Name: Management Team Page
 *
 * The template for displaying the Management Team page.
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main management-team-page">
    <!-- Hero Section with Background Image -->
    <section class="management-hero">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title" data-aos="fade-up">Management Team</h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Experienced professionals driving operational excellence and strategic implementation
                    </p>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3 id="team-count">8</h3>
                                    <p>Management Team</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>4</h3>
                                    <p>Departments</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>15+</h3>
                                    <p>Years Average Experience</p>
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
    <section class="management-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="intro-content glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">About Our Management Team</h2>
                        <p class="lead text-center">
                            Our management team comprises seasoned professionals with extensive experience in financial services, 
                            cooperative management, and strategic leadership. They are responsible for the day-to-day operations, 
                            implementing board policies, and ensuring the society delivers exceptional value to our members.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Management Team Grid Section -->
    <section class="management-grid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card text-center" data-aos="fade-up">
                        <h2 class="section-title mb-0">Meet Our Management Team</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                // Query management team from custom post type
                $management_query = new WP_Query(array(
                    'post_type' => 'management_team',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                $management_members = array();
                if ($management_query->have_posts()) {
                    while ($management_query->have_posts()) {
                        $management_query->the_post();
                        $management_members[] = array(
                            'name' => get_the_title(),
                            'position' => get_post_meta(get_the_ID(), '_management_position', true),
                            'department' => get_post_meta(get_the_ID(), '_department', true),
                            'bio' => get_the_content(),
                            'qualifications' => get_post_meta(get_the_ID(), '_qualifications', true),
                            'experience' => get_post_meta(get_the_ID(), '_experience', true),
                            'responsibilities' => get_post_meta(get_the_ID(), '_responsibilities', true),
                            'email' => get_post_meta(get_the_ID(), '_email', true),
                            'phone' => get_post_meta(get_the_ID(), '_phone', true),
                            'linkedin' => get_post_meta(get_the_ID(), '_linkedin_url', true),
                            'join_date' => get_post_meta(get_the_ID(), '_join_date', true),
                            'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : ''
                        );
                    }
                    wp_reset_postdata();
                }

                // Static fallback data if no CPT entries
                if (empty($management_members)) {
                    $management_members = [
                        [
                            'name' => 'Mr. Joseph Mwangi',
                            'position' => 'Chief Executive Officer',
                            'department' => 'Executive',
                            'bio' => 'Joseph leads the strategic direction and overall operations of the SACCO, bringing over 18 years of experience in financial services and cooperative management.',
                            'qualifications' => 'MBA Finance, Bachelor of Commerce, CPA(K), Certified Cooperative Manager',
                            'experience' => '18+ years in financial services, Former Deputy CEO at leading SACCO, Expert in strategic planning and organizational development',
                            'responsibilities' => 'Overall strategic leadership, Board liaison, Stakeholder management, Organizational development',
                            'email' => 'ceo@daystarcoopsacco.com',
                            'phone' => '+254 700 100 001',
                            'linkedin' => '',
                            'join_date' => '2019-01-15',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mrs. Catherine Njeri',
                            'position' => 'General Manager',
                            'department' => 'Operations',
                            'bio' => 'Catherine oversees daily operations and ensures efficient service delivery to our members across all branches and service points.',
                            'qualifications' => 'Master of Business Administration, Bachelor of Arts, Diploma in Cooperative Management',
                            'experience' => '15+ years in cooperative management, Former Operations Manager at financial institution, Specialist in process optimization',
                            'responsibilities' => 'Daily operations oversight, Branch management, Service delivery optimization, Staff coordination',
                            'email' => 'gm@daystarcoopsacco.com',
                            'phone' => '+254 700 100 002',
                            'linkedin' => '',
                            'join_date' => '2019-03-01',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mr. David Kimani',
                            'position' => 'Finance Manager',
                            'department' => 'Finance',
                            'bio' => 'David manages the financial operations, budgeting, and financial reporting, ensuring sound financial management practices.',
                            'qualifications' => 'CPA(K), Bachelor of Commerce (Finance), ACCA Part Qualified',
                            'experience' => '12+ years in financial management, Former Senior Accountant at multinational company, Expert in financial analysis and reporting',
                            'responsibilities' => 'Financial planning and analysis, Budget management, Financial reporting, Compliance oversight',
                            'email' => 'finance@daystarcoopsacco.com',
                            'phone' => '+254 700 100 003',
                            'linkedin' => '',
                            'join_date' => '2020-01-10',
                            'image' => ''
                        ],
                        [
                            'name' => 'Ms. Grace Wambui',
                            'position' => 'Credit Manager',
                            'department' => 'Credit',
                            'bio' => 'Grace leads the credit department, overseeing loan processing, risk assessment, and portfolio management.',
                            'qualifications' => 'Bachelor of Commerce (Finance), Diploma in Credit Management, Certified Risk Analyst',
                            'experience' => '10+ years in credit management, Former Credit Officer at leading bank, Specialist in loan portfolio management',
                            'responsibilities' => 'Credit policy implementation, Loan processing oversight, Risk assessment, Portfolio management',
                            'email' => 'credit@daystarcoopsacco.com',
                            'phone' => '+254 700 100 004',
                            'linkedin' => '',
                            'join_date' => '2020-06-15',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mr. Peter Ochieng',
                            'position' => 'IT Manager',
                            'department' => 'Information Technology',
                            'bio' => 'Peter manages the technology infrastructure and digital transformation initiatives, ensuring secure and efficient IT operations.',
                            'qualifications' => 'Bachelor of Science (Computer Science), Cisco Certified Network Professional, Project Management Professional',
                            'experience' => '8+ years in IT management, Former Systems Administrator, Expert in banking technology and cybersecurity',
                            'responsibilities' => 'IT infrastructure management, Digital transformation, Cybersecurity, System maintenance',
                            'email' => 'it@daystarcoopsacco.com',
                            'phone' => '+254 700 100 005',
                            'linkedin' => '',
                            'join_date' => '2021-02-01',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mrs. Mary Wanjiku',
                            'position' => 'Human Resources Manager',
                            'department' => 'Human Resources',
                            'bio' => 'Mary leads human resources functions, focusing on talent management, staff development, and organizational culture.',
                            'qualifications' => 'Master of Arts (Human Resource Management), Bachelor of Arts (Psychology), CHRP(K)',
                            'experience' => '14+ years in human resources, Former HR Business Partner, Expert in talent development and organizational psychology',
                            'responsibilities' => 'Talent management, Staff development, Performance management, HR policy implementation',
                            'email' => 'hr@daystarcoopsacco.com',
                            'phone' => '+254 700 100 006',
                            'linkedin' => '',
                            'join_date' => '2019-09-01',
                            'image' => ''
                        ],
                        [
                            'name' => 'Mr. Samuel Kiprotich',
                            'position' => 'Marketing Manager',
                            'department' => 'Marketing',
                            'bio' => 'Samuel drives marketing initiatives, member acquisition, and brand development to enhance the SACCO\'s market presence.',
                            'qualifications' => 'Bachelor of Commerce (Marketing), Diploma in Digital Marketing, Certified Marketing Professional',
                            'experience' => '9+ years in marketing, Former Marketing Executive at financial services company, Expert in digital marketing and brand management',
                            'responsibilities' => 'Marketing strategy, Brand management, Member acquisition, Digital marketing campaigns',
                            'email' => 'marketing@daystarcoopsacco.com',
                            'phone' => '+254 700 100 007',
                            'linkedin' => '',
                            'join_date' => '2021-05-01',
                            'image' => ''
                        ],
                        [
                            'name' => 'Ms. Ruth Akinyi',
                            'position' => 'Customer Service Manager',
                            'department' => 'Customer Service',
                            'bio' => 'Ruth ensures exceptional customer service delivery and manages member relations to enhance satisfaction and loyalty.',
                            'qualifications' => 'Bachelor of Arts (Communication), Diploma in Customer Relations Management, Certified Customer Experience Professional',
                            'experience' => '11+ years in customer service, Former Customer Relations Manager, Expert in service excellence and member engagement',
                            'responsibilities' => 'Customer service excellence, Member relations, Service quality assurance, Complaint resolution',
                            'email' => 'customerservice@daystarcoopsacco.com',
                            'phone' => '+254 700 100 008',
                            'linkedin' => '',
                            'join_date' => '2020-08-01',
                            'image' => ''
                        ]
                    ];
                }

                foreach ($management_members as $index => $member): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="management-card">
                        <div class="management-image">
                            <?php if (!empty($member['image'])): ?>
                                <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                            <?php else: ?>
                                <div class="management-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            <?php endif; ?>
                            <div class="management-overlay">
                                <div class="management-contact">
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
                        <div class="management-info">
                            <h4 class="management-name"><?php echo esc_html($member['name']); ?></h4>
                            <p class="management-position"><?php echo esc_html($member['position']); ?></p>
                            <?php if (!empty($member['department'])): ?>
                                <p class="management-department"><?php echo esc_html($member['department']); ?> Department</p>
                            <?php endif; ?>
                            <div class="management-meta">
                                <?php if (!empty($member['join_date'])): ?>
                                    <span class="join-date">
                                        <i class="fas fa-calendar-alt"></i> 
                                        Since <?php echo date('M Y', strtotime($member['join_date'])); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <p class="management-bio"><?php echo esc_html(wp_trim_words($member['bio'], 25, '...')); ?></p>
                            
                            <!-- Expandable Details -->
                            <div class="management-details">
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

    <!-- Organizational Structure Section -->
    <section class="org-structure">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">Organizational Structure</h2>
                        <div class="org-chart">
                            <div class="org-level">
                                <div class="org-box ceo">
                                    <i class="fas fa-crown"></i>
                                    <h5>Chief Executive Officer</h5>
                                    <p>Strategic Leadership</p>
                                </div>
                            </div>
                            <div class="org-level">
                                <div class="org-box gm">
                                    <i class="fas fa-cogs"></i>
                                    <h5>General Manager</h5>
                                    <p>Operations Oversight</p>
                                </div>
                            </div>
                            <div class="org-level departments">
                                <div class="org-box finance">
                                    <i class="fas fa-chart-line"></i>
                                    <h5>Finance</h5>
                                </div>
                                <div class="org-box credit">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <h5>Credit</h5>
                                </div>
                                <div class="org-box it">
                                    <i class="fas fa-laptop-code"></i>
                                    <h5>IT</h5>
                                </div>
                                <div class="org-box hr">
                                    <i class="fas fa-users"></i>
                                    <h5>HR</h5>
                                </div>
                                <div class="org-box marketing">
                                    <i class="fas fa-bullhorn"></i>
                                    <h5>Marketing</h5>
                                </div>
                                <div class="org-box customer">
                                    <i class="fas fa-headset"></i>
                                    <h5>Customer Service</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Management Responsibilities Section -->
    <section class="management-responsibilities">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-5">Management Responsibilities</h2>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="responsibility-item">
                                    <div class="responsibility-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h4>Strategic Implementation</h4>
                                    <p>Execute board-approved strategies and policies to achieve organizational objectives and member satisfaction.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                                <div class="responsibility-item">
                                    <div class="responsibility-icon">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <h4>Operations Management</h4>
                                    <p>Oversee daily operations, ensure service quality, and maintain operational efficiency across all departments.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="responsibility-item">
                                    <div class="responsibility-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h4>Risk Management</h4>
                                    <p>Identify, assess, and mitigate operational risks while ensuring compliance with regulatory requirements.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                                <div class="responsibility-item">
                                    <div class="responsibility-icon">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <h4>Team Leadership</h4>
                                    <p>Lead and develop staff, foster a positive work culture, and ensure professional growth opportunities.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Management Section -->
    <section class="contact-management">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title mb-4 text-center">Connect with Management</h2>
                        <p class="lead mb-4 text-center">
                            Our management team is committed to serving our members and stakeholders. 
                            Reach out to us for any operational matters or feedback.
                        </p>
                        <div class="contact-options text-center" data-aos="fade-up" data-aos-delay="400">
                            <a href="mailto:management@daystarcoopsacco.com" class="btn btn-primary btn-lg me-3 mb-3">
                                <i class="fas fa-envelope me-2"></i>Email Management
                            </a>
                            <a href="tel:+254700100000" class="btn btn-outline-primary btn-lg mb-3">
                                <i class="fas fa-phone me-2"></i>Call Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<script>
// Update team count dynamically
document.addEventListener('DOMContentLoaded', function() {
    const teamCount = document.querySelectorAll('.management-card').length;
    const teamCountElement = document.getElementById('team-count');
    if (teamCountElement) {
        teamCountElement.textContent = teamCount;
    }
    
    // Toggle details functionality
    const toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.management-card');
            const details = card.querySelector('.management-details');
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