<?php
/**
 * The template for displaying the FAQs page for Daystar Multi-Purpose Co-operative Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<style>
/* Enhanced CSS Variables - Matching Site Design System */
:root {
    /* Primary Oceanic Colors */
    --primary-blue: #006994;
    --primary-blue-light: rgba(0, 105, 148, 0.8);
    --primary-blue-dark: #082b4e;
    --accent-teal: #20B2AA;
    --accent-coral: #FF7F7F;
    --accent-seafoam: #40E0D0;
    --deep-ocean: #003366;
    --ocean-mist: #B0E0E6;
    --accent-gold: #FFD700;
    --accent-emerald: #50C878;
    
    /* Enhanced Glassmorphism Colors */
    --glass-white: rgba(255, 255, 255, 0.12);
    --glass-white-strong: rgba(255, 255, 255, 0.25);
    --glass-ocean: rgba(0, 105, 148, 0.15);
    --glass-ocean-strong: rgba(0, 105, 148, 0.25);
    --glass-teal: rgba(32, 178, 170, 0.12);
    --glass-dark: rgba(30, 41, 59, 0.85);
    --glass-light: rgba(248, 250, 252, 0.95);
    
    /* Enhanced Background Gradients */
    --bg-primary: linear-gradient(135deg, #006994 0%, #20B2AA 50%, #40E0D0 100%);
    --bg-secondary: linear-gradient(135deg, #40E0D0 0%, #006994 50%, #003366 100%);
    --bg-hero: linear-gradient(135deg, rgba(0, 105, 148, 0.95) 0%, rgba(32, 178, 170, 0.9) 50%, rgba(64, 224, 208, 0.85) 100%);
    --bg-ocean-depth: linear-gradient(135deg, #003366 0%, #006994 25%, #20B2AA 75%, #40E0D0 100%);
    --bg-card-gradient: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    
    /* Enhanced Shadows */
    --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-strong: 0 15px 50px rgba(0, 0, 0, 0.15);
    --shadow-glass: 0 8px 32px rgba(0, 0, 0, 0.1);
    --shadow-glow: 0 0 30px rgba(32, 178, 170, 0.3);
    --shadow-hover: 0 20px 60px rgba(0, 105, 148, 0.2);
    
    /* Enhanced Typography */
    --font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    --font-display: 'Playfair Display', Georgia, serif;
    
    /* Enhanced Transitions */
    --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-medium: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-bounce: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Base Styles */
.faqs-page {
    font-family: var(--font-primary);
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    background: url('<?php echo get_template_directory_uri(); ?>/assets/images/oceanbackground.jpeg') no-repeat center center fixed;
    background-size: cover;
}

/* Light Overlay for Text Readability */
.faqs-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(51, 49, 49, 0.85);
    backdrop-filter: blur(2px);
    pointer-events: none;
    z-index: 1;
}

/* Ensure content is above overlay */
.faqs-page > * {
    position: relative;
    z-index: 2;
}

/* Enhanced Page Header */
.page-header {
    background: var(--bg-hero);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
    margin-top: 80px;
    text-align: center;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
    pointer-events: none;
    animation: headerGlow 15s ease-in-out infinite;
}

@keyframes headerGlow {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
}

.page-title {
    font-family: var(--font-display);
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    background: rgba(0, 0, 0, 0.3);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: inline-block;
    position: relative;
    z-index: 2;
}

.page-header .lead {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 2rem;
    font-weight: 500;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
    background: rgba(0, 0, 0, 0.3);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 2;
}

/* Enhanced Breadcrumb */
.breadcrumb {
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 12px 24px;
    margin-bottom: 0;
    position: relative;
    z-index: 2;
    justify-content: center;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition-fast);
}

.breadcrumb-item a:hover {
    color: var(--accent-gold);
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

/* Enhanced Section Styling */
.section {
    padding: 80px 0;
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    margin: 2rem 0;
    border-radius: 24px;
    box-shadow: var(--shadow-glass);
}

.section-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--primary-blue-dark);
    margin-bottom: 1.5rem;
    position: relative;
    text-align: center;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, var(--accent-teal), var(--accent-seafoam));
    border-radius: 2px;
    box-shadow: 0 2px 10px rgba(32, 178, 170, 0.3);
}

.section-subtitle {
    font-size: 1.25rem;
    color: var(--primary-blue);
    margin-bottom: 3rem;
    font-weight: 400;
    text-align: center;
}

/* FAQ Categories */
.faq-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
}

.faq-category-btn {
    background: rgba(0, 105, 148, 0.1);
    border: 2px solid var(--accent-teal);
    color: var(--primary-blue-dark);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition-medium);
    cursor: pointer;
}

.faq-category-btn:hover,
.faq-category-btn.active {
    background: var(--accent-teal);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

/* FAQ Accordion */
.faq-accordion {
    max-width: 900px;
    margin: 0 auto;
}

.faq-item {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 105, 148, 0.1);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    transition: var(--transition-medium);
}

.faq-item:hover {
    box-shadow: var(--shadow-medium);
    transform: translateY(-2px);
}

.faq-question {
    background: none;
    border: none;
    width: 100%;
    padding: 2rem;
    text-align: left;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-blue-dark);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: var(--transition-fast);
}

.faq-question:hover {
    background: rgba(0, 105, 148, 0.05);
}

.faq-question .faq-icon {
    font-size: 1.2rem;
    color: var(--accent-teal);
    transition: var(--transition-medium);
}

.faq-item.active .faq-icon {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 2rem 2rem;
    color: #374151;
    line-height: 1.7;
    display: none;
}

.faq-item.active .faq-answer {
    display: block;
    animation: fadeInDown 0.3s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.faq-answer p {
    margin-bottom: 1rem;
}

.faq-answer ul, .faq-answer ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.faq-answer li {
    margin-bottom: 0.5rem;
}

.faq-answer strong {
    color: var(--primary-blue-dark);
    font-weight: 600;
}

/* Search Box */
.faq-search {
    max-width: 600px;
    margin: 0 auto 3rem;
    position: relative;
}

.faq-search input {
    width: 100%;
    padding: 1rem 1.5rem 1rem 3rem;
    border: 2px solid var(--accent-teal);
    border-radius: 50px;
    font-size: 1.1rem;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
}

.faq-search input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.2);
}

.faq-search .search-icon {
    position: absolute;
    left: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--accent-teal);
    font-size: 1.2rem;
}

/* Contact CTA */
.contact-cta {
    background: linear-gradient(135deg, var(--accent-gold), #FFA500);
    color: var(--primary-blue-dark);
    padding: 3rem;
    border-radius: 24px;
    text-align: center;
    margin-top: 4rem;
    box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.contact-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: var(--transition-slow);
}

.contact-cta:hover::before {
    left: 100%;
}

.contact-cta h3 {
    color: var(--primary-blue-dark);
    margin-bottom: 1rem;
    font-weight: 700;
}

.contact-cta p {
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.contact-cta .btn {
    background: var(--primary-blue-dark);
    color: #fff;
    padding: 1rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-medium);
    display: inline-block;
    margin: 0 0.5rem;
}

.contact-cta .btn:hover {
    background: var(--primary-blue);
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    color: #fff;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 80px 0 40px;
    }
    
    .section {
        padding: 60px 0;
        margin: 1rem 0;
    }
    
    .faq-categories {
        flex-direction: column;
        align-items: center;
    }
    
    .faq-category-btn {
        width: 100%;
        max-width: 300px;
        text-align: center;
    }
    
    .faq-question {
        padding: 1.5rem;
        font-size: 1rem;
    }
    
    .faq-answer {
        padding: 0 1.5rem 1.5rem;
    }
    
    .contact-cta {
        padding: 2rem;
    }
    
    .contact-cta .btn {
        display: block;
        margin: 0.5rem 0;
    }
}
</style>

<main id="primary" class="site-main faqs-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <h1 class="page-title">Frequently Asked Questions</h1>
                    <p class="lead">Find answers to common questions about Daystar Multi-Purpose Co-operative Society Ltd.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Content -->
    <section class="section">
        <div class="container">
            <!-- Search Box -->
            <div class="faq-search">
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" id="faqSearch" placeholder="Search for answers..." onkeyup="searchFAQs()">
            </div>

            <!-- FAQ Categories -->
            <div class="faq-categories">
                <button class="faq-category-btn active" onclick="filterFAQs('all')">All Questions</button>
                <button class="faq-category-btn" onclick="filterFAQs('membership')">Membership</button>
                <button class="faq-category-btn" onclick="filterFAQs('loans')">Loans</button>
                <button class="faq-category-btn" onclick="filterFAQs('contributions')">Contributions</button>
                <button class="faq-category-btn" onclick="filterFAQs('services')">Services</button>
                <button class="faq-category-btn" onclick="filterFAQs('policies')">Policies</button>
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion">
                
                <?php
                // Get dynamic FAQs from custom post type
                $dynamic_faqs_query = new WP_Query(array(
                    'post_type' => 'faq',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_key' => '_faq_order',
                    'orderby' => array(
                        'meta_value_num' => 'ASC',
                        'date' => 'DESC'
                    ),
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => '_faq_order',
                            'compare' => 'EXISTS'
                        ),
                        array(
                            'key' => '_faq_order',
                            'compare' => 'NOT EXISTS'
                        )
                    )
                ));

                $has_dynamic_faqs = $dynamic_faqs_query->have_posts();
                
                if ($has_dynamic_faqs) :
                    // Display dynamic FAQs from custom post type
                    while ($dynamic_faqs_query->have_posts()) : $dynamic_faqs_query->the_post();
                        $faq_categories = wp_get_post_terms(get_the_ID(), 'faq_category');
                        $category_slugs = array();
                        $category_names = array();
                        
                        if (!empty($faq_categories)) {
                            foreach ($faq_categories as $category) {
                                $category_slugs[] = $category->slug;
                                $category_names[] = $category->name;
                            }
                        }
                        
                        // Default to 'general' category if none assigned
                        if (empty($category_slugs)) {
                            $category_slugs[] = 'general';
                        }
                        
                        $faq_featured = get_post_meta(get_the_ID(), '_faq_featured', true);
                        $faq_keywords = get_post_meta(get_the_ID(), '_faq_keywords', true);
                        $featured_class = $faq_featured ? ' featured-faq' : '';
                        
                        // Map category slugs to display categories
                        $display_categories = array();
                        foreach ($category_slugs as $slug) {
                            switch ($slug) {
                                case 'membership':
                                case 'member':
                                case 'join':
                                    $display_categories[] = 'membership';
                                    break;
                                case 'loan':
                                case 'loans':
                                case 'lending':
                                    $display_categories[] = 'loans';
                                    break;
                                case 'saving':
                                case 'savings':
                                case 'deposit':
                                case 'contribution':
                                case 'contributions':
                                    $display_categories[] = 'contributions';
                                    break;
                                case 'service':
                                case 'services':
                                    $display_categories[] = 'services';
                                    break;
                                case 'policy':
                                case 'policies':
                                case 'rule':
                                case 'rules':
                                    $display_categories[] = 'policies';
                                    break;
                                default:
                                    $display_categories[] = 'general';
                                    break;
                            }
                        }
                        
                        $data_categories = implode(' ', array_unique($display_categories));
                ?>
                
                <div class="faq-item<?php echo $featured_class; ?>" data-category="<?php echo esc_attr($data_categories); ?>" data-keywords="<?php echo esc_attr($faq_keywords); ?>">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span><?php the_title(); ?></span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <?php the_content(); ?>
                        <?php if (!empty($category_names)) : ?>
                            <div class="faq-meta">
                                <small><strong>Categories:</strong> <?php echo implode(', ', $category_names); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback to static FAQs when no dynamic content exists
                ?>
                
                <!-- Static Fallback FAQs -->
                <div class="faq-item" data-category="membership">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Who can become a member of Daystar Multi-Purpose Co-operative Society?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Membership is exclusively for individuals with a direct connection to Daystar University, including:</p>
                        <ul>
                            <li><strong>Current Employees:</strong> All full-time and part-time staff members</li>
                            <li><strong>Faculty Members:</strong> Professors, lecturers, and teaching staff</li>
                            <li><strong>Retired Staff:</strong> Former Daystar University employees</li>
                            <li><strong>Immediate Family:</strong> Spouses and children of current/former staff</li>
                            <li><strong>Board Members:</strong> University trustees and board members</li>
                        </ul>
                        <p>You must provide proof of your connection to Daystar University during the application process.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="membership">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What are the minimum requirements to join?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>To become a member, you need:</p>
                        <ul>
                            <li><strong>Age:</strong> Must be at least 18 years old</li>
                            <li><strong>Registration Fee:</strong> KSh 1,000 (one-time, non-refundable)</li>
                            <li><strong>Share Capital:</strong> Minimum KSh 5,000 (250 shares at KSh 20 each)</li>
                            <li><strong>Monthly Contributions:</strong> Minimum KSh 2,000 per month</li>
                            <li><strong>Documentation:</strong> Valid ID, photos, and proof of Daystar connection</li>
                        </ul>
                        <p>You must maintain consistent monthly contributions to remain an active member.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="membership">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How long does it take to become eligible for loans?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>You become eligible for loans after:</p>
                        <ul>
                            <li><strong>6 months</strong> of consistent membership</li>
                            <li><strong>Total contributions</strong> of at least KSh 12,000 (KSh 2,000 × 6 months)</li>
                            <li><strong>Minimum share capital</strong> of KSh 5,000</li>
                            <li><strong>Good standing</strong> with no outstanding obligations</li>
                        </ul>
                        <p>Emergency loans may be available for urgent situations even before the 6-month period, subject to approval.</p>
                    </div>
                </div>

                <!-- Loans FAQs -->
                <div class="faq-item" data-category="loans">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What types of loans do you offer?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We offer several loan products tailored to different needs:</p>
                        <ul>
                            <li><strong>Development Loans:</strong> Up to KSh 2,000,000 for long-term projects (12% annual interest)</li>
                            <li><strong>School Fees Loans:</strong> Education financing with flexible terms (12% annual interest)</li>
                            <li><strong>Emergency Loans:</strong> Up to KSh 100,000 for urgent needs (12% annual interest)</li>
                            <li><strong>Special Loans:</strong> Up to KSh 200,000 with character-based assessment (5% monthly)</li>
                            <li><strong>Super Saver Loans:</strong> Up to KSh 3,000,000 for high-deposit members (preferential rates)</li>
                            <li><strong>Salary Advance:</strong> Short-term advances with 10% one-time fee</li>
                        </ul>
                        <p>All loans use the reducing balance method for interest calculation.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="loans">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How much can I borrow and what determines my loan limit?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Your loan limit is determined by several factors:</p>
                        <ul>
                            <li><strong>Savings History:</strong> Your total contributions and consistency</li>
                            <li><strong>Share Capital:</strong> Amount invested in cooperative shares</li>
                            <li><strong>Salary Level:</strong> Your monthly income and ability to repay</li>
                            <li><strong>Guarantors:</strong> Availability of qualified guarantors</li>
                            <li><strong>Credit History:</strong> Previous loan repayment record</li>
                            <li><strong>Loan Type:</strong> Different products have different maximum limits</li>
                        </ul>
                        <p>Generally, you can borrow up to 3-4 times your total savings, depending on the loan type and your financial profile.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="loans">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What documents do I need for a loan application?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Required documents include:</p>
                        <ul>
                            <li><strong>Application Form:</strong> Completed and signed loan application</li>
                            <li><strong>Payslips:</strong> Last 3 months' salary slips</li>
                            <li><strong>Bank Statements:</strong> Last 6 months' bank statements</li>
                            <li><strong>Guarantor Forms:</strong> Completed guarantor forms with their details</li>
                            <li><strong>Project Documents:</strong> For development loans (quotations, plans, etc.)</li>
                            <li><strong>School Documents:</strong> For education loans (fee structures, admission letters)</li>
                            <li><strong>Emergency Proof:</strong> For emergency loans (medical bills, etc.)</li>
                        </ul>
                        <p>Additional documents may be required depending on the loan type and amount.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="loans">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How long does loan processing take?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Processing times vary by loan type:</p>
                        <ul>
                            <li><strong>Emergency Loans:</strong> Same day to 24 hours</li>
                            <li><strong>Salary Advance:</strong> Same day processing</li>
                            <li><strong>School Fees Loans:</strong> 2-3 working days</li>
                            <li><strong>Development Loans:</strong> 5-10 working days</li>
                            <li><strong>Special Loans:</strong> 3-5 working days</li>
                            <li><strong>Super Saver Loans:</strong> 5-7 working days</li>
                        </ul>
                        <p>Processing time depends on completeness of documentation, loan amount, and credit committee schedule.</p>
                    </div>
                </div>

                <!-- Contributions FAQs -->
                <div class="faq-item" data-category="contributions">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do monthly contributions work?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Monthly contributions are the foundation of your membership:</p>
                        <ul>
                            <li><strong>Minimum Amount:</strong> KSh 2,000 per month</li>
                            <li><strong>Payment Method:</strong> Automatic payroll deduction (preferred) or direct payment</li>
                            <li><strong>Due Date:</strong> End of each month</li>
                            <li><strong>Interest Earned:</strong> Competitive annual interest rates</li>
                            <li><strong>Flexibility:</strong> You can contribute more than the minimum</li>
                        </ul>
                        <p>Consistent contributions improve your loan eligibility and earning potential.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="contributions">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What are shares and how do they work?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Shares represent your ownership in the cooperative:</p>
                        <ul>
                            <li><strong>Share Value:</strong> KSh 20 per share</li>
                            <li><strong>Minimum Holding:</strong> 250 shares (KSh 5,000)</li>
                            <li><strong>Ownership Rights:</strong> Voting rights in cooperative decisions</li>
                            <li><strong>Dividends:</strong> Annual dividends based on cooperative performance</li>
                            <li><strong>Loan Security:</strong> Can be used as collateral for loans</li>
                            <li><strong>Transferability:</strong> Non-transferable to non-members</li>
                        </ul>
                        <p>The more shares you own, the greater your stake in the cooperative's success.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="contributions">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Can I withdraw my contributions anytime?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Withdrawal policies depend on the type of contributions:</p>
                        <ul>
                            <li><strong>Regular Contributions:</strong> Available with 30 days notice for large amounts</li>
                            <li><strong>Share Capital:</strong> Can be withdrawn upon membership termination</li>
                            <li><strong>Emergency Withdrawals:</strong> Available with proper documentation</li>
                            <li><strong>Restrictions:</strong> Withdrawals may be limited if you have outstanding loans</li>
                            <li><strong>Processing Time:</strong> 5-7 working days for approved withdrawals</li>
                        </ul>
                        <p>We encourage maintaining your contributions for better loan eligibility and higher returns.</p>
                    </div>
                </div>

                <!-- Services FAQs -->
                <div class="faq-item" data-category="services">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Do you offer online banking services?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>We provide several digital services:</p>
                        <ul>
                            <li><strong>Member Portal:</strong> Online access to account statements and loan status</li>
                            <li><strong>Mobile Banking:</strong> SMS notifications for transactions</li>
                            <li><strong>Loan Calculator:</strong> Online tools to estimate loan repayments</li>
                            <li><strong>Application Forms:</strong> Downloadable forms from our website</li>
                            <li><strong>Email Statements:</strong> Electronic delivery of monthly statements</li>
                        </ul>
                        <p>We're continuously improving our digital services to better serve our members.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="services">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What are your office hours and location?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our office details:</p>
                        <ul>
                            <li><strong>Location:</strong> Daystar University – Athiriver Campus</li>
                            <li><strong>Address:</strong> P.O. Box 44400-00100, Nairobi</li>
                            <li><strong>Weekdays:</strong> Monday-Friday, 8:00 AM - 5:00 PM</li>
                            <li><strong>Saturday:</strong> 9:00 AM - 1:00 PM</li>
                            <li><strong>Phone:</strong> +254 731 629 716 / +254 799 174 239</li>
                            <li><strong>Email:</strong> daystarmultipurpose@daystar.ac.ke</li>
                        </ul>
                        <p>We're closed on Sundays and public holidays.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="services">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I update my personal information?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>To update your information:</p>
                        <ul>
                            <li><strong>Visit Our Office:</strong> Bring required documents for verification</li>
                            <li><strong>Written Request:</strong> Submit a formal request with supporting documents</li>
                            <li><strong>Required Documents:</strong> Updated ID, proof of address, employment changes</li>
                            <li><strong>Processing Time:</strong> 2-3 working days for most updates</li>
                            <li><strong>Important Updates:</strong> Contact details, beneficiary information, employment status</li>
                        </ul>
                        <p>Keeping your information current ensures smooth service delivery and communication.</p>
                    </div>
                </div>

                <!-- Policies FAQs -->
                <div class="faq-item" data-category="policies">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What happens if I default on a loan?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our loan recovery process includes:</p>
                        <ul>
                            <li><strong>Grace Period:</strong> 7 days after due date before late fees apply</li>
                            <li><strong>Reminders:</strong> SMS and email notifications for overdue payments</li>
                            <li><strong>Late Fees:</strong> 5% of overdue amount per month</li>
                            <li><strong>Guarantor Contact:</strong> Guarantors are notified and may be required to pay</li>
                            <li><strong>Share Offset:</strong> Outstanding amounts may be deducted from your shares</li>
                            <li><strong>Legal Action:</strong> As a last resort for persistent defaulters</li>
                        </ul>
                        <p>We work with members to find solutions before taking drastic measures.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="policies">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How are dividends calculated and distributed?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Dividend distribution process:</p>
                        <ul>
                            <li><strong>Annual Basis:</strong> Dividends are declared annually after financial year-end</li>
                            <li><strong>Performance Based:</strong> Depends on cooperative's financial performance</li>
                            <li><strong>Share Proportion:</strong> Distributed based on your share capital holding</li>
                            <li><strong>Member Approval:</strong> Dividend rates approved at Annual General Meeting</li>
                            <li><strong>Distribution Method:</strong> Credited to your account or paid directly</li>
                            <li><strong>Tax Implications:</strong> Subject to applicable tax regulations</li>
                        </ul>
                        <p>Higher share capital holdings result in higher dividend payments.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="policies">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Can I terminate my membership? What's the process?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Membership termination process:</p>
                        <ul>
                            <li><strong>Written Notice:</strong> 60 days written notice required</li>
                            <li><strong>Loan Clearance:</strong> All outstanding loans must be settled</li>
                            <li><strong>Share Refund:</strong> Share capital refunded after clearance</li>
                            <li><strong>Savings Withdrawal:</strong> Regular savings returned with accrued interest</li>
                            <li><strong>Final Settlement:</strong> Completed within 90 days of clearance</li>
                            <li><strong>Exit Interview:</strong> Optional feedback session</li>
                        </ul>
                        <p>We encourage members to discuss concerns before deciding to terminate membership.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="policies">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I file a complaint or grievance?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our complaint resolution process:</p>
                        <ol>
                            <li><strong>Direct Discussion:</strong> Speak with relevant staff or supervisor</li>
                            <li><strong>Formal Complaint:</strong> Written complaint to the Manager</li>
                            <li><strong>Supervisory Committee:</strong> Appeal to member-elected committee</li>
                            <li><strong>Board Review:</strong> Final internal appeal to Board of Directors</li>
                            <li><strong>External Bodies:</strong> SASRA or Cooperative Tribunal if needed</li>
                        </ol>
                        <p>We aim to resolve all complaints within 14 days of receipt.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="membership">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>What makes Daystar SACCO different from other financial institutions?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Our unique advantages include:</p>
                        <ul>
                            <li><strong>Member Ownership:</strong> You're a co-owner, not just a customer</li>
                            <li><strong>University Focus:</strong> Tailored services for academic community</li>
                            <li><strong>Competitive Rates:</strong> Better rates than most commercial banks</li>
                            <li><strong>Payroll Integration:</strong> Seamless deductions through Daystar University</li>
                            <li><strong>Community Support:</strong> Supporting the Daystar University family</li>
                            <li><strong>Democratic Governance:</strong> Members vote on important decisions</li>
                            <li><strong>Profit Sharing:</strong> Annual dividends based on performance</li>
                        </ul>
                        <p>We're more than a financial institution – we're a community working together for mutual prosperity.</p>
                    </div>
                </div>
                
                <?php endif; // End fallback static FAQs ?>

            </div>

            <!-- Contact CTA -->
            <div class="contact-cta">
                <h3><i class="fas fa-question-circle"></i> Still Have Questions?</h3>
                <p>Can't find the answer you're looking for? Our friendly team is here to help you with any questions about membership, loans, or our services.</p>
                <a href="<?php echo esc_url(home_url('contact')); ?>" class="btn">Contact Us</a>
                <a href="tel:+254731629716" class="btn">Call Us</a>
                <a href="mailto:daystarmultipurpose@daystar.ac.ke" class="btn">Email Us</a>
            </div>
        </div>
    </section>
</main>

<script>
// FAQ Toggle Function
function toggleFAQ(element) {
    const faqItem = element.parentElement;
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

// FAQ Category Filter
function filterFAQs(category) {
    const faqItems = document.querySelectorAll('.faq-item');
    const categoryBtns = document.querySelectorAll('.faq-category-btn');
    
    // Update active button
    categoryBtns.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Show/hide FAQ items
    faqItems.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
        // Close all items when filtering
        item.classList.remove('active');
    });
}

// FAQ Search Function
function searchFAQs() {
    const searchTerm = document.getElementById('faqSearch').value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question span').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
        
        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
        
        // Close all items when searching
        item.classList.remove('active');
    });
    
    // Reset category filter when searching
    if (searchTerm) {
        document.querySelectorAll('.faq-category-btn').forEach(btn => {
            btn.classList.remove('active');
        });
    }
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Show all FAQs by default
    filterFAQs('all');
});
</script>

<?php
get_footer();