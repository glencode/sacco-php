<?php
/**
 * Template Name: Delegates Page
 *
 * The template for displaying the Sacco delegates information.
 *
 * @package sacco-php
 */

get_header();

// Get custom fields for dynamic content
$hero_title = get_field('delegates_hero_title') ?: 'Our Delegates';
$hero_subtitle = get_field('delegates_hero_subtitle') ?: 'Meet the dedicated representatives who serve our members with integrity and commitment';
$intro_text = get_field('delegates_intro_text') ?: 'Our delegates are elected representatives who play a crucial role in the governance and decision-making processes of our SACCO. They represent the interests of our members and ensure transparency in all operations.';

// Get delegates data (repeater field or fallback to static data)
$delegates = get_field('delegates_list');
if (!$delegates) {
    // Static fallback data
    $delegates = [
        [
            'name' => 'John Kamau',
            'position' => 'Chairman of Delegates',
            'region' => 'Central Region',
            'experience' => '8 years',
            'bio' => 'John has been serving as a delegate for over 8 years, bringing extensive experience in financial management and community leadership.',
            'image' => '',
            'email' => 'j.kamau@daystar-sacco.com',
            'phone' => '+254 700 123 456'
        ],
        [
            'name' => 'Mary Wanjiku',
            'position' => 'Vice Chairperson',
            'region' => 'Nairobi Region',
            'experience' => '6 years',
            'bio' => 'Mary is a seasoned professional with a background in cooperative management and member advocacy.',
            'image' => '',
            'email' => 'm.wanjiku@daystar-sacco.com',
            'phone' => '+254 700 234 567'
        ],
        [
            'name' => 'Peter Ochieng',
            'position' => 'Secretary',
            'region' => 'Western Region',
            'experience' => '5 years',
            'bio' => 'Peter brings valuable insights from his experience in rural development and cooperative governance.',
            'image' => '',
            'email' => 'p.ochieng@daystar-sacco.com',
            'phone' => '+254 700 345 678'
        ],
        [
            'name' => 'Grace Muthoni',
            'position' => 'Treasurer',
            'region' => 'Eastern Region',
            'experience' => '7 years',
            'bio' => 'Grace has extensive experience in financial oversight and has been instrumental in ensuring fiscal responsibility.',
            'image' => '',
            'email' => 'g.muthoni@daystar-sacco.com',
            'phone' => '+254 700 456 789'
        ],
        [
            'name' => 'David Kiprop',
            'position' => 'Member',
            'region' => 'Rift Valley Region',
            'experience' => '4 years',
            'bio' => 'David represents the interests of members in the Rift Valley region and advocates for inclusive financial services.',
            'image' => '',
            'email' => 'd.kiprop@daystar-sacco.com',
            'phone' => '+254 700 567 890'
        ],
        [
            'name' => 'Sarah Nyong\'o',
            'position' => 'Member',
            'region' => 'Coast Region',
            'experience' => '3 years',
            'bio' => 'Sarah brings fresh perspectives and innovative ideas to the delegates assembly.',
            'image' => '',
            'email' => 's.nyongo@daystar-sacco.com',
            'phone' => '+254 700 678 901'
        ]
    ];
}

// Get meeting information
$next_meeting = get_field('next_delegates_meeting');
$meeting_schedule = get_field('delegates_meeting_schedule') ?: 'Quarterly meetings are held in March, June, September, and December';
?>

<main id="primary" class="site-main delegates-page">
    <!-- Hero Section with Background Image -->
    <section class="delegates-hero">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title" data-aos="fade-up"><?php echo esc_html($hero_title); ?></h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200"><?php echo esc_html($hero_subtitle); ?></p>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3><?php echo count($delegates); ?></h3>
                                    <p>Active Delegates</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>5</h3>
                                    <p>Regions Represented</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item">
                                    <h3>4</h3>
                                    <p>Meetings Per Year</p>
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
    <section class="delegates-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="intro-content glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">About Our Delegates</h2>
                        <p class="lead text-center"><?php echo esc_html($intro_text); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delegates Grid Section -->
    <section class="delegates-grid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card text-center" data-aos="fade-up">
                        <h2 class="section-title mb-0">Meet Our Delegates</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($delegates as $index => $delegate): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="delegate-card">
                        <div class="delegate-image">
                            <?php if (!empty($delegate['image'])): ?>
                                <img src="<?php echo esc_url($delegate['image']['url']); ?>" alt="<?php echo esc_attr($delegate['name']); ?>">
                            <?php else: ?>
                                <div class="delegate-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <div class="delegate-overlay">
                                <div class="delegate-contact">
                                    <?php if (!empty($delegate['email'])): ?>
                                        <a href="mailto:<?php echo esc_attr($delegate['email']); ?>" class="contact-btn">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($delegate['phone'])): ?>
                                        <a href="tel:<?php echo esc_attr($delegate['phone']); ?>" class="contact-btn">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="delegate-info">
                            <h4 class="delegate-name"><?php echo esc_html($delegate['name']); ?></h4>
                            <p class="delegate-position"><?php echo esc_html($delegate['position']); ?></p>
                            <div class="delegate-meta">
                                <span class="region"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($delegate['region']); ?></span>
                                <span class="experience"><i class="fas fa-clock"></i> <?php echo esc_html($delegate['experience']); ?></span>
                            </div>
                            <p class="delegate-bio"><?php echo esc_html($delegate['bio']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Meeting Information Section -->
    <section class="delegates-meetings">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="meeting-info glass-card" data-aos="fade-up">
                        <h2 class="section-title text-center mb-4">Delegates Meetings</h2>
                        <div class="meeting-schedule">
                            <div class="schedule-item">
                                <h4><i class="fas fa-calendar-alt"></i> Meeting Schedule</h4>
                                <p><?php echo esc_html($meeting_schedule); ?></p>
                            </div>
                            <?php if ($next_meeting): ?>
                            <div class="schedule-item">
                                <h4><i class="fas fa-clock"></i> Next Meeting</h4>
                                <p><strong>Date:</strong> <?php echo esc_html($next_meeting['date']); ?></p>
                                <p><strong>Time:</strong> <?php echo esc_html($next_meeting['time']); ?></p>
                                <p><strong>Venue:</strong> <?php echo esc_html($next_meeting['venue']); ?></p>
                                <?php if (!empty($next_meeting['agenda'])): ?>
                                <p><strong>Agenda:</strong> <?php echo esc_html($next_meeting['agenda']); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <div class="schedule-item">
                                <h4><i class="fas fa-clock"></i> Next Meeting</h4>
                                <p><strong>Date:</strong> March 15, 2024</p>
                                <p><strong>Time:</strong> 10:00 AM - 2:00 PM</p>
                                <p><strong>Venue:</strong> Daystar SACCO Head Office, Conference Room</p>
                                <p><strong>Agenda:</strong> Quarterly financial review, member feedback discussion, and strategic planning for Q2 2024</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Responsibilities Section -->
    <section class="delegates-responsibilities py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title text-center mb-5" data-aos="fade-up">Delegate Responsibilities</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="responsibility-item">
                        <div class="responsibility-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Member Representation</h4>
                        <p>Advocate for member interests and ensure their voices are heard in decision-making processes.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="responsibility-item">
                        <div class="responsibility-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>Oversight</h4>
                        <p>Monitor SACCO operations and ensure compliance with regulations and best practices.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="responsibility-item">
                        <div class="responsibility-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4>Governance</h4>
                        <p>Participate in policy formulation and strategic planning for the SACCO's growth.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="responsibility-item">
                        <div class="responsibility-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Community Liaison</h4>
                        <p>Bridge the gap between the SACCO management and the community we serve.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Delegates Section -->
    <section class="contact-delegates">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="glass-card" data-aos="fade-up">
                        <h2 class="section-title mb-4 text-center">Get in Touch with Our Delegates</h2>
                        <p class="lead mb-4 text-center" data-aos="fade-up" data-aos-delay="200">
                            Have questions or concerns? Our delegates are here to listen and represent your interests.
                        </p>
                        <div class="contact-options text-center" data-aos="fade-up" data-aos-delay="400">
                            <a href="mailto:delegates@daystar-sacco.com" class="btn btn-primary btn-lg me-3 mb-3">
                                <i class="fas fa-envelope me-2"></i>Email Delegates
                            </a>
                            <a href="tel:+254700000000" class="btn btn-outline-primary btn-lg mb-3">
                                <i class="fas fa-phone me-2"></i>Call Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer(); 