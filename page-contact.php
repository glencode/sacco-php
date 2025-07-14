<?php
/**
 * Template Name: Contact Page
 *
 * The template for displaying the contact page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main page-contact-content contact-bg-img">
    <!-- Animated Background Particles -->
    <div class="particles-container">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Contact Header with Creative Animation -->
    <header class="contact-hero-header py-5 mb-5">
        <style>
        .contact-hero-header {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(59, 130, 246, 0.85));
            border-radius: 0 0 3rem 3rem;
            position: relative;
            overflow: hidden;
        }
        .contact-hero-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(96,165,250,0.1) 0%, transparent 70%);
            animation: rotateGradient 20s linear infinite;
        }
        @keyframes rotateGradient {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .hero-title {
            color: #fff !important;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            font-weight: 900;
            font-size: 3.5rem;
            background: linear-gradient(45deg, #fff, #60a5fa, #8b5cf6);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientText 4s ease infinite;
        }
        @keyframes gradientText {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .hero-subtitle {
            color: #e2e8f0 !important;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-weight: 500;
            font-size: 1.3rem;
        }
        .breadcrumb-modern {
            background: rgba(30,41,59,0.9);
            border-radius: 2rem;
            padding: 1rem 2rem;
            margin: 2rem auto;
            display: inline-block;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .breadcrumb-modern a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .breadcrumb-modern a:hover {
            color: #fff;
        }
        .breadcrumb-modern .separator {
            margin: 0 1rem;
            color: #94a3b8;
        }
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(96,165,250,0.6);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .particle:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 60%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { top: 80%; left: 40%; animation-delay: 4s; }
        .particle:nth-child(4) { top: 40%; left: 60%; animation-delay: 1s; }
        .particle:nth-child(5) { top: 10%; left: 70%; animation-delay: 3s; }
        .particle:nth-child(6) { top: 70%; left: 10%; animation-delay: 5s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); opacity: 0.6; }
            50% { transform: translateY(-20px) scale(1.2); opacity: 1; }
        }
        .contact-bg-img {
            position: relative;
            min-height: 100vh;
            background: url('<?php echo get_template_directory_uri(); ?>/assets/images/contactusbg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .contact-bg-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30,41,59,0.75);
            z-index: 1;
        }
        .page-contact-content > * {
            position: relative;
            z-index: 2;
        }
        </style>
        <div class="container text-center">
            <h1 class="hero-title mb-3">Get In Touch</h1>
            <p class="hero-subtitle mb-4">We're here to help you achieve your financial goals</p>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="container text-center">
        <nav class="breadcrumb-modern" aria-label="breadcrumb">
            <a href="/">Home</a>
            <span class="separator">•</span>
            <span style="color: #fff;">Contact Us</span>
        </nav>
    </div>

    <div class="container my-5">
        <!-- Contact Methods Section -->
        <section class="contact-methods-section mb-5">
            <style>
            .contact-method-card {
                background: rgba(30, 41, 59, 0.95);
                border-radius: 2rem;
                padding: 2.5rem;
                text-align: center;
                position: relative;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                border: 1px solid rgba(96,165,250,0.2);
                backdrop-filter: blur(20px);
            }
            .contact-method-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(96,165,250,0.1), transparent);
                transition: left 0.6s ease;
            }
            .contact-method-card:hover::before {
                left: 100%;
            }
            .contact-method-card:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 20px 40px rgba(96,165,250,0.2);
                border-color: rgba(96,165,250,0.4);
            }
            .contact-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 1.5rem;
                background: linear-gradient(135deg, #60a5fa, #3b82f6);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: white;
                position: relative;
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(96,165,250,0.7); }
                70% { box-shadow: 0 0 0 10px rgba(96,165,250,0); }
                100% { box-shadow: 0 0 0 0 rgba(96,165,250,0); }
            }
            .contact-method-card h3 {
                color: #fff;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .contact-method-card p {
                color: #e2e8f0;
                margin-bottom: 0.5rem;
            }
            .contact-method-card a {
                color: #60a5fa;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.3s ease;
            }
            .contact-method-card a:hover {
                color: #fff;
            }
            </style>
            
            <div class="row g-4 mb-5">
                <?php
                // Query contact methods from custom post type or ACF fields
                $contact_methods = get_field('contact_methods'); // ACF repeater field
                
                if ($contact_methods && is_array($contact_methods)) :
                    foreach ($contact_methods as $method) :
                        $icon = $method['icon'] ?? 'fas fa-phone';
                        $title = $method['title'] ?? 'Contact Method';
                        $description = $method['description'] ?? '';
                        $link = $method['link'] ?? '';
                        $link_text = $method['link_text'] ?? '';
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <?php if ($link && $link_text) : ?>
                            <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($link_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                else : 
                    // Static fallback content
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>Call Us</h3>
                        <p>Speak directly with our customer service team</p>
                        <p><a href="tel:+254700123456">+254 700 123 456</a></p>
                        <p><a href="tel:+254720123456">+254 720 123 456</a></p>
                        <small style="color: #94a3b8;">Mon-Fri: 8AM-5PM</small>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>Send us a message and we'll respond within 24 hours</p>
                        <p><a href="mailto:info@daystarcoopsacco.com">info@daystarcoopsacco.com</a></p>
                        <p><a href="mailto:support@daystarcoopsacco.com">support@daystarcoopsacco.com</a></p>
                        <small style="color: #94a3b8;">Response within 24hrs</small>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Visit Us</h3>
                        <p>Come to our main office for personalized assistance</p>
                        <p>Daystar University Campus<br>Athi River, Kenya</p>
                        <a href="https://maps.google.com" target="_blank">Get Directions</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3>WhatsApp</h3>
                        <p>Quick support via WhatsApp messaging</p>
                        <p><a href="https://wa.me/254700123456">+254 700 123 456</a></p>
                        <small style="color: #94a3b8;">Available 24/7</small>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Live Chat</h3>
                        <p>Instant support through our website chat</p>
                        <button class="btn btn-outline-light btn-sm" onclick="openLiveChat()">Start Chat</button>
                        <small style="color: #94a3b8;">Mon-Fri: 8AM-8PM</small>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-method-card">
                        <div class="contact-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Mobile App</h3>
                        <p>Access support directly from our mobile app</p>
                        <a href="#" class="btn btn-outline-light btn-sm">Download App</a>
                        <small style="color: #94a3b8;">iOS & Android</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Contact Form and Map Section -->
        <section class="contact-form-map-section">
            <style>
            .contact-form-container {
                background: rgba(30, 41, 59, 0.95);
                border-radius: 2rem;
                padding: 3rem;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(96,165,250,0.2);
                position: relative;
                overflow: hidden;
            }
            .contact-form-container::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 100%;
                height: 200%;
                background: radial-gradient(circle, rgba(96,165,250,0.05) 0%, transparent 70%);
                animation: rotateGradient 15s linear infinite reverse;
            }
            .form-floating label {
                color: #94a3b8;
            }
            .form-control {
                background: rgba(15, 23, 42, 0.8);
                border: 1px solid rgba(96,165,250,0.3);
                color: #fff;
                border-radius: 1rem;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                background: rgba(15, 23, 42, 0.9);
                border-color: #60a5fa;
                box-shadow: 0 0 0 0.2rem rgba(96,165,250,0.25);
                color: #fff;
            }
            .form-control::placeholder {
                color: #64748b;
            }
            .btn-send-message {
                background: linear-gradient(135deg, #60a5fa, #3b82f6);
                border: none;
                border-radius: 1rem;
                padding: 1rem 2rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .btn-send-message::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.6s ease;
            }
            .btn-send-message:hover::before {
                left: 100%;
            }
            .btn-send-message:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(96,165,250,0.3);
            }
            .map-container {
                border-radius: 2rem;
                overflow: hidden;
                height: 400px;
                position: relative;
                background: rgba(30, 41, 59, 0.95);
                border: 1px solid rgba(96,165,250,0.2);
            }
            .map-container iframe {
                width: 100%;
                height: 100%;
                border: none;
                filter: grayscale(20%) contrast(1.2);
                transition: filter 0.3s ease;
            }
            .map-container:hover iframe {
                filter: grayscale(0%) contrast(1);
            }
            .section-title-creative {
                color: #fff;
                font-weight: 800;
                font-size: 2.5rem;
                text-align: center;
                margin-bottom: 3rem;
                position: relative;
            }
            .section-title-creative::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 4px;
                background: linear-gradient(90deg, #60a5fa, #8b5cf6);
                border-radius: 2px;
            }
            </style>
            
            <h2 class="section-title-creative">Send Us a Message</h2>
            
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="contact-form-container">
                        <?php
                        // Display form submission status messages
                        if (isset($_GET['form_status'])) {
                            $status = sanitize_key($_GET['form_status']);
                            $message_text = '';
                            $message_type = 'info';

                            if ($status === 'success') {
                                $message_text = 'Thank you for your message! We will get back to you shortly.';
                                $message_type = 'success';
                            } elseif ($status === 'error') {
                                $message_text = 'There was an error with your submission. Please check the required fields and try again.';
                                $message_type = 'danger';
                            } elseif ($status === 'mail_error') {
                                $message_text = 'Sorry, there was an issue sending your message. Please try again later or contact us directly.';
                                $message_type = 'warning';
                            }

                            if ($message_text) {
                                echo '<div class="alert alert-' . esc_attr($message_type) . ' mb-4" role="alert">' . esc_html($message_text) . '</div>';
                            }
                        }

                        $contact_form_shortcode = get_field('contact_form_shortcode');
                        if ($contact_form_shortcode && function_exists('wpcf7_contact_form')) {
                            echo do_shortcode(sanitize_text_field($contact_form_shortcode));
                        } else {
                            // Enhanced native form
                        ?>
                        <form id="saccoContactPageForm" class="contact-form-native" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                            <input type="hidden" name="action" value="contact_page_submission">
                            <?php wp_nonce_field('sacco_contact_page_form_nonce', 'contact_page_nonce'); ?>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contactName" name="contact_name" placeholder="Your Name" required>
                                        <label for="contactName">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="contactEmail" name="contact_email" placeholder="Email Address" required>
                                        <label for="contactEmail">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="contactPhone" name="contact_phone" placeholder="Phone Number">
                                        <label for="contactPhone">Phone Number (Optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="contactDepartment" name="contact_department" required>
                                            <option value="">Select Department</option>
                                            <option value="general">General Inquiry</option>
                                            <option value="loans">Loans Department</option>
                                            <option value="savings">Savings Department</option>
                                            <option value="membership">Membership</option>
                                            <option value="technical">Technical Support</option>
                                            <option value="complaints">Complaints</option>
                                        </select>
                                        <label for="contactDepartment">Department</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contactSubject" name="contact_subject" placeholder="Subject" required>
                                        <label for="contactSubject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="contactMessage" name="contact_message" placeholder="Your Message" style="height: 150px;" required></textarea>
                                        <label for="contactMessage">Your Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="contactPrivacy" name="contact_privacy" value="agree" required>
                                        <label class="form-check-label text-light" for="contactPrivacy">
                                            I agree to the <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank" class="text-info">privacy policy</a> and terms of service
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-send-message w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                            <div class="form-status mt-3"></div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <div class="map-container">
                        <?php 
                        $map_iframe_src = get_field('google_map_iframe_src');
                        if ($map_iframe_src) :
                            echo wp_kses($map_iframe_src, array(
                                'iframe' => array(
                                    'src' => array(),
                                    'width' => array(),
                                    'height' => array(),
                                    'style' => array(),
                                    'allowfullscreen' => array(),
                                    'loading' => array(),
                                    'referrerpolicy' => array()
                                )
                            ));
                        else :
                        ?>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.3585977242!2d36.70730246001141!3d-1.302862319334275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2sus!4v1623234084830!5m2!1sen!2sus" 
                            width="100%" 
                            height="100%" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Branches Section -->
        <?php
        $branches = get_field('branches');
        $branches_title = get_field('branches_section_title') ?: 'Our Branches';
        $branches_subtitle = get_field('branches_section_subtitle') ?: 'Visit any of our branches for personalized assistance';
        ?>
        <section class="branches-section mt-5">
            <style>
            .branch-card {
                background: rgba(30, 41, 59, 0.95);
                border-radius: 1.5rem;
                padding: 2rem;
                border: 1px solid rgba(96,165,250,0.2);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(20px);
            }
            .branch-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, #60a5fa, #8b5cf6, #ec4899);
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }
            .branch-card:hover::before {
                transform: scaleX(1);
            }
            .branch-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(96,165,250,0.2);
                border-color: rgba(96,165,250,0.4);
            }
            .branch-card h3 {
                color: #60a5fa;
                font-weight: 700;
                margin-bottom: 1.5rem;
            }
            .branch-card p {
                color: #e2e8f0;
                margin-bottom: 0.75rem;
            }
            .branch-card i {
                color: #60a5fa;
                width: 20px;
                margin-right: 0.75rem;
            }
            .branch-card .btn {
                border-radius: 1rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .branch-card .btn:hover {
                transform: translateY(-2px);
            }
            </style>
            
            <h2 class="section-title-creative"><?php echo esc_html($branches_title); ?></h2>
            <p class="text-center text-light mb-5 fs-5"><?php echo esc_html($branches_subtitle); ?></p>
            
            <div class="row g-4">
                <?php
                if ($branches && is_array($branches)) :
                    foreach ($branches as $branch) :
                        $name = $branch['branch_name'] ?? 'Branch Name';
                        $address = $branch['branch_address'] ?? '';
                        $phone = $branch['branch_phone'] ?? '';
                        $email = $branch['branch_email'] ?? '';
                        $hours1 = $branch['branch_working_hours_line1'] ?? '';
                        $hours2 = $branch['branch_working_hours_line2'] ?? '';
                        $map_link = $branch['branch_map_link'] ?? '';
                        $services = $branch['branch_services'] ?? '';
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="branch-card h-100">
                        <h3><?php echo esc_html($name); ?></h3>
                        <?php if ($address): ?>
                            <p><i class="fas fa-map-marker-alt"></i><?php echo esc_html($address); ?></p>
                        <?php endif; ?>
                        <?php if ($phone): ?>
                            <p><i class="fas fa-phone"></i><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-info"><?php echo esc_html($phone); ?></a></p>
                        <?php endif; ?>
                        <?php if ($email): ?>
                            <p><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr($email); ?>" class="text-info"><?php echo esc_html($email); ?></a></p>
                        <?php endif; ?>
                        <?php if ($hours1): ?>
                            <p><i class="fas fa-clock"></i><?php echo esc_html($hours1); ?></p>
                        <?php endif; ?>
                        <?php if ($hours2): ?>
                            <p><i class="fas fa-clock" style="visibility: hidden;"></i><?php echo esc_html($hours2); ?></p>
                        <?php endif; ?>
                        <?php if ($services): ?>
                            <p><i class="fas fa-cogs"></i><?php echo esc_html($services); ?></p>
                        <?php endif; ?>
                        <?php if ($map_link): ?>
                            <a href="<?php echo esc_url($map_link); ?>" class="btn btn-outline-info btn-sm mt-3" target="_blank">
                                <i class="fas fa-directions me-1"></i>Get Directions
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                else : 
                    // Static fallback branches
                    $fallback_branches = [
                        [
                            'name' => 'Main Branch - Daystar University',
                            'address' => 'Daystar University Campus, Athi River',
                            'phone' => '+254 700 123 456',
                            'email' => 'main@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:00 AM - 5:00 PM',
                            'hours2' => 'Sat: 9:00 AM - 1:00 PM',
                            'services' => 'Full Banking Services, Loans, Savings'
                        ],
                        [
                            'name' => 'Nairobi CBD Branch',
                            'address' => '123 Maendeleo Road, Nairobi CBD',
                            'phone' => '+254 710 987 654',
                            'email' => 'nairobi@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:30 AM - 4:30 PM',
                            'hours2' => 'Sat: 9:00 AM - 12:30 PM',
                            'services' => 'Banking, Customer Service, Consultations'
                        ],
                        [
                            'name' => 'Mombasa Branch',
                            'address' => '456 Biashara Street, Mombasa',
                            'phone' => '+254 720 112 233',
                            'email' => 'mombasa@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:00 AM - 5:00 PM',
                            'hours2' => 'Sat: Closed',
                            'services' => 'Loans, Savings, Money Transfer'
                        ],
                        [
                            'name' => 'Kisumu Branch',
                            'address' => '789 Ufanisi Avenue, Kisumu',
                            'phone' => '+254 730 445 566',
                            'email' => 'kisumu@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:00 AM - 4:30 PM',
                            'hours2' => 'Sat: 9:00 AM - 1:00 PM',
                            'services' => 'Full Banking Services, Mobile Banking'
                        ],
                        [
                            'name' => 'Nakuru Branch',
                            'address' => '321 Kenyatta Avenue, Nakuru',
                            'phone' => '+254 740 778 899',
                            'email' => 'nakuru@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:30 AM - 5:00 PM',
                            'hours2' => 'Sat: 9:00 AM - 12:00 PM',
                            'services' => 'Savings, Loans, Financial Advisory'
                        ],
                        [
                            'name' => 'Eldoret Branch',
                            'address' => '654 Uganda Road, Eldoret',
                            'phone' => '+254 750 334 455',
                            'email' => 'eldoret@daystarcoopsacco.com',
                            'hours1' => 'Mon-Fri: 8:00 AM - 5:00 PM',
                            'hours2' => 'Sat: 9:00 AM - 1:00 PM',
                            'services' => 'Agricultural Loans, Savings, Insurance'
                        ]
                    ];
                    foreach ($fallback_branches as $branch) :
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="branch-card h-100">
                        <h3><?php echo esc_html($branch['name']); ?></h3>
                        <p><i class="fas fa-map-marker-alt"></i><?php echo esc_html($branch['address']); ?></p>
                        <p><i class="fas fa-phone"></i><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $branch['phone'])); ?>" class="text-info"><?php echo esc_html($branch['phone']); ?></a></p>
                        <p><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr($branch['email']); ?>" class="text-info"><?php echo esc_html($branch['email']); ?></a></p>
                        <p><i class="fas fa-clock"></i><?php echo esc_html($branch['hours1']); ?></p>
                        <p><i class="fas fa-clock" style="visibility: hidden;"></i><?php echo esc_html($branch['hours2']); ?></p>
                        <p><i class="fas fa-cogs"></i><?php echo esc_html($branch['services']); ?></p>
                        <a href="https://maps.google.com" class="btn btn-outline-info btn-sm mt-3" target="_blank">
                            <i class="fas fa-directions me-1"></i>Get Directions
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="contact-faq-section mt-5">
            <style>
            .faq-item {
                background: rgba(30, 41, 59, 0.95);
                border-radius: 1rem;
                margin-bottom: 1rem;
                border: 1px solid rgba(96,165,250,0.2);
                overflow: hidden;
                transition: all 0.3s ease;
            }
            .faq-item:hover {
                border-color: rgba(96,165,250,0.4);
            }
            .faq-question {
                background: none;
                border: none;
                color: #fff;
                font-weight: 600;
                text-align: left;
                width: 100%;
                padding: 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .faq-question:hover {
                background: rgba(96,165,250,0.1);
            }
            .faq-answer {
                padding: 0 1.5rem 1.5rem;
                color: #e2e8f0;
                display: none;
            }
            .faq-icon {
                transition: transform 0.3s ease;
                color: #60a5fa;
            }
            .faq-item.active .faq-icon {
                transform: rotate(180deg);
            }
            .faq-item.active .faq-answer {
                display: block;
                animation: fadeIn 0.3s ease;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            </style>
            
            <h2 class="section-title-creative">Frequently Asked Questions</h2>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php
                    $faqs = get_field('contact_faqs');
                    if ($faqs && is_array($faqs)) :
                        foreach ($faqs as $index => $faq) :
                            $question = $faq['question'] ?? '';
                            $answer = $faq['answer'] ?? '';
                    ?>
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(<?php echo $index; ?>)">
                            <span><?php echo esc_html($question); ?></span>
                            <i class="fas fa-chevron-down faq-icon"></i>
                        </button>
                        <div class="faq-answer" id="faq-<?php echo $index; ?>">
                            <p><?php echo esc_html($answer); ?></p>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else :
                        // Static fallback FAQs
                        $fallback_faqs = [
                            ['question' => 'How can I become a member?', 'answer' => 'You can become a member by visiting any of our branches with a valid ID, filling out the membership form, and making the minimum required deposit.'],
                            ['question' => 'What are your loan interest rates?', 'answer' => 'Our loan interest rates vary depending on the type of loan. Development loans start at 12% per annum, while emergency loans have different rates. Contact us for specific rates.'],
                            ['question' => 'How long does loan processing take?', 'answer' => 'Loan processing typically takes 3-5 working days for regular loans and 24-48 hours for emergency loans, depending on the completeness of your documentation.'],
                            ['question' => 'Can I access my account online?', 'answer' => 'Yes, we offer online banking services through our website and mobile app. You can check balances, transfer funds, and apply for loans online.'],
                            ['question' => 'What documents do I need for a loan application?', 'answer' => 'You need a valid ID, recent payslips, bank statements, and any collateral documents depending on the loan type. Our staff will guide you through the specific requirements.']
                        ];
                        foreach ($fallback_faqs as $index => $faq) :
                    ?>
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(<?php echo $index; ?>)">
                            <span><?php echo esc_html($faq['question']); ?></span>
                            <i class="fas fa-chevron-down faq-icon"></i>
                        </button>
                        <div class="faq-answer" id="faq-<?php echo $index; ?>">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <script>
    function toggleFaq(index) {
        const faqItem = document.querySelector(`#faq-${index}`).parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
        }
    }

    function openLiveChat() {
        // Implement live chat functionality
        alert('Live chat feature coming soon!');
    }

    // Add form validation and AJAX submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('saccoContactPageForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Add custom validation or AJAX submission here
                console.log('Form submitted');
            });
        }
    });
    </script>
</main><!-- #main -->

<?php
get_footer();
?>