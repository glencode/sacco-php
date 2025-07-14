<?php
/**
 * Template Name: Credit Policy
 *
 * This is the template for displaying the current credit policy.
 * Enhanced with comprehensive security and access control.
 *
 * @package Daystar
 */

// Enhanced security check with audit logging
daystar_check_enhanced_member_access(['view_policy_documents', 'manage_credit_policy']);

// Additional role-based access control for credit policy
$current_user = daystar_check_credit_policy_access();

// Validate session security
daystar_validate_session_security();

// Include policy management functions
require_once get_template_directory() . '/includes/policy-management.php';

// Handle PDF download request with security validation
if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
    // Verify CSRF token for download
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'download_policy_pdf')) {
        // Log security violation
        Daystar_Security_Access_Control::log_action(
            'policy_download_security_violation',
            'policy',
            null,
            array(
                'user_id' => get_current_user_id(),
                'attempted_download' => 'pdf',
                'missing_nonce' => !isset($_GET['_wpnonce']),
                'invalid_nonce' => isset($_GET['_wpnonce'])
            ),
            'warning'
        );
        
        wp_die('Security verification failed. Please try again.', 'Security Error', array('response' => 403));
    }
    
    // Log policy download
    Daystar_Security_Access_Control::log_action(
        'policy_pdf_downloaded',
        'policy',
        null,
        array(
            'user_id' => get_current_user_id(),
            'download_type' => 'pdf',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ),
        'info'
    );
    
    PolicyManagementHandler::ajax_download_policy_pdf();
    exit;
}

// Log policy access
Daystar_Security_Access_Control::log_action(
    'credit_policy_accessed',
    'policy',
    null,
    array(
        'user_id' => $current_user->ID,
        'user_roles' => $current_user->roles,
        'access_time' => current_time('mysql'),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ),
    'info'
);

// Get current published policy with caching for performance
$cache_key = 'current_credit_policy_' . get_current_user_id();
$current_policy = Daystar_Performance_Optimizer::get_instance()->get_cached_data($cache_key, 'daystar_policies');

if ($current_policy === false) {
    $current_policy = get_current_credit_policy();
    Daystar_Performance_Optimizer::get_instance()->set_cached_data($cache_key, $current_policy, 'daystar_policies', 1800);
}

get_header();
?>

<main id="primary" class="site-main policy-page" role="main" aria-label="Credit Policy Content">
    <!-- Skip to content link for accessibility -->
    <a class="skip-link screen-reader-text" href="#policy-content">Skip to policy content</a>
    
    <div class="container">
        <!-- Breadcrumb navigation for better UX -->
        <nav aria-label="Breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('/about/'); ?>">About</a></li>
                <li class="breadcrumb-item active" aria-current="page">Credit Policy</li>
            </ol>
        </nav>
        
        <div class="policy-header text-center mb-5">
            <h1 class="policy-title" id="main-heading">Credit Policy</h1>
            <p class="lead">Daystar Multi-Purpose Co-operative Society Ltd.</p>
            
            <!-- Accessibility toolbar -->
            <div class="accessibility-controls" role="toolbar" aria-label="Accessibility options">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="DaystarUX.toggleLargeText()" aria-label="Toggle large text">
                    <i class="fas fa-font" aria-hidden="true"></i> Large Text
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="DaystarUX.toggleHighContrast()" aria-label="Toggle high contrast">
                    <i class="fas fa-adjust" aria-hidden="true"></i> High Contrast
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()" aria-label="Print policy">
                    <i class="fas fa-print" aria-hidden="true"></i> Print
                </button>
            </div>
        </div>
        
        <?php if (!$current_policy): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="alert alert-warning text-center">
                        <h4>Policy Not Available</h4>
                        <p>The credit policy is currently being updated. Please check back later or contact our support team for assistance.</p>
                        <p>
                            <strong>Contact Information:</strong><br>
                            Phone: +254 123 456 789<br>
                            Email: support@daystar.co.ke
                        </p>
                    </div>
                </div>
            </div<?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Policy Content -->
                    <article class="policy-content-card" id="policy-content" role="article" aria-labelledby="main-heading">
                        <!-- Progress indicator for reading -->
                        <div class="reading-progress" role="progressbar" aria-label="Reading progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" id="reading-progress-bar"></div>
                        </div>
                        
                        <header class="policy-meta mb-4" role="banner">
                            <h2 class="sr-only">Policy Information</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Version:</strong> 
                                        <span aria-label="Version <?php echo esc_attr($current_policy->version_number); ?>">
                                            <?php echo esc_html($current_policy->version_number); ?>
                                        </span>
                                    </div>
                                    <div class="meta-item">
                                        <strong>Effective Date:</strong> 
                                        <time datetime="<?php echo esc_attr($current_policy->effective_date); ?>">
                                            <?php echo date('F j, Y', strtotime($current_policy->effective_date)); ?>
                                        </time>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Published:</strong> 
                                        <time datetime="<?php echo esc_attr($current_policy->published_date); ?>">
                                            <?php echo date('F j, Y', strtotime($current_policy->published_date)); ?>
                                        </time>
                                    </div>
                                    <div class="meta-item">
                                        <strong>Status:</strong> 
                                        <span class="badge badge-success" role="status" aria-label="Current active policy">Current Policy</span>
                                    </div>
                                </div>
                            </div>
                        </header>
                        
                        <!-- Estimated reading time -->
                        <div class="reading-info mb-3">
                            <small class="text-muted">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                Estimated reading time: <span id="reading-time">5 minutes</span>
                            </small>
                        </div>
                        
                        <div class="policy-content" role="main" tabindex="0">
                            <?php echo wp_kses_post(nl2br($current_policy->content)); ?>
                        </div>
                        
                        <!-- Policy feedback section -->
                        <footer class="policy-feedback mt-4" role="contentinfo">
                            <h3>Was this policy helpful?</h3>
                            <div class="feedback-buttons" role="group" aria-label="Policy feedback">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="submitPolicyFeedback('helpful')" aria-label="Mark policy as helpful">
                                    <i class="fas fa-thumbs-up" aria-hidden="true"></i> Helpful
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="submitPolicyFeedback('not-helpful')" aria-label="Mark policy as not helpful">
                                    <i class="fas fa-thumbs-down" aria-hidden="true"></i> Not Helpful
                                </button>
                            </div>
                            <div id="feedback-message" class="mt-2" role="status" aria-live="polite"></div>
                        </footer>
                    </article>
                </div>
                
                <div class="col-lg-4">
                    <!-- Policy Actions Sidebar -->
                    <div class="policy-sidebar">
                        <div class="sidebar-card">
                            <h4>Policy Documents</h4>
                            <div class="document-actions">
                                <a href="<?php echo esc_url(add_query_arg(array('download' => 'pdf', '_wpnonce' => wp_create_nonce('download_policy_pdf')))); ?>" class="btn btn-primary btn-block mb-3" target="_blank">
                                    <i class="fas fa-download"></i> Download PDF Copy
                                </a>
                                <button onclick="window.print()" class="btn btn-outline-secondary btn-block mb-3">
                                    <i class="fas fa-print"></i> Print Policy
                                </button>
                                <button onclick="sharePolicy()" class="btn btn-outline-info btn-block">
                                    <i class="fas fa-share"></i> Share Policy
                                </button>
                            </div>
                        </div>
                        
                        <div class="sidebar-card">
                            <h4>Quick Navigation</h4>
                            <div class="policy-toc">
                                <ul class="list-unstyled">
                                    <li><a href="#introduction">Introduction</a></li>
                                    <li><a href="#eligibility">Loan Eligibility</a></li>
                                    <li><a href="#application">Application Process</a></li>
                                    <li><a href="#approval">Approval Criteria</a></li>
                                    <li><a href="#disbursement">Disbursement</a></li>
                                    <li><a href="#repayment">Repayment Terms</a></li>
                                    <li><a href="#recovery">Recovery Procedures</a></li>
                                    <li><a href="#appeals">Appeals Process</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="sidebar-card">
                            <h4>Need Help?</h4>
                            <div class="help-content">
                                <p>If you have questions about our credit policy, we're here to help:</p>
                                <ul class="contact-list">
                                    <li>
                                        <i class="fas fa-phone"></i>
                                        <a href="tel:+254123456789">+254 123 456 789</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:support@daystar.co.ke">support@daystar.co.ke</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Visit any branch location
                                    </li>
                                </ul>
                                
                                <?php if (is_user_logged_in()): ?>
                                    <div class="member-actions mt-3">
                                        <a href="<?php echo home_url('/member-dashboard/'); ?>" class="btn btn-sm btn-outline-primary">
                                            Member Dashboard
                                        </a>
                                        <a href="<?php echo home_url('/loan-application/'); ?>" class="btn btn-sm btn-primary">
                                            Apply for Loan
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="guest-actions mt-3">
                                        <a href="<?php echo home_url('/login/'); ?>" class="btn btn-sm btn-outline-primary">
                                            Member Login
                                        </a>
                                        <a href="<?php echo home_url('/register/'); ?>" class="btn btn-sm btn-primary">
                                            Become a Member
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="sidebar-card">
                            <h4>Policy Updates</h4>
                            <div class="update-info">
                                <p>Stay informed about policy changes:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-bell text-primary"></i> Automatic email notifications</li>
                                    <li><i class="fas fa-mobile-alt text-primary"></i> SMS alerts for major changes</li>
                                    <li><i class="fas fa-globe text-primary"></i> Website announcements</li>
                                </ul>
                                
                                <?php if (is_user_logged_in()): ?>
                                    <small class="text-muted">
                                        As a member, you'll automatically receive notifications about policy updates.
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">
                                        <a href="<?php echo home_url('/register/'); ?>">Become a member</a> to receive automatic policy update notifications.
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.policy-page {
    padding: 2rem 0;
    background: #f8f9fa;
}

.policy-title {
    color: #2271b1;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.policy-content-card {
    background: #fff;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.policy-meta {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    border-left: 4px solid #2271b1;
}

.meta-item {
    margin-bottom: 0.5rem;
}

.policy-content {
    line-height: 1.8;
    font-size: 1rem;
}

.policy-content h1,
.policy-content h2,
.policy-content h3,
.policy-content h4 {
    color: #2271b1;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.policy-content h1 {
    border-bottom: 2px solid #2271b1;
    padding-bottom: 0.5rem;
}

.policy-content h2 {
    border-bottom: 1px solid #ddd;
    padding-bottom: 0.3rem;
}

.policy-content ul,
.policy-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.policy-content li {
    margin-bottom: 0.5rem;
}

.policy-sidebar {
    position: sticky;
    top: 2rem;
}

.sidebar-card {
    background: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.sidebar-card h4 {
    color: #2271b1;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.document-actions .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.policy-toc a {
    color: #666;
    text-decoration: none;
    padding: 0.3rem 0;
    display: block;
    border-bottom: 1px solid #eee;
    transition: color 0.3s;
}

.policy-toc a:hover {
    color: #2271b1;
    text-decoration: none;
}

.contact-list {
    list-style: none;
    padding: 0;
}

.contact-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.contact-list i {
    color: #2271b1;
    width: 1rem;
}

.contact-list a {
    color: #666;
    text-decoration: none;
}

.contact-list a:hover {
    color: #2271b1;
    text-decoration: none;
}

.member-actions .btn,
.guest-actions .btn {
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.update-info ul li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.badge {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

/* Print styles */
@media print {
    .policy-sidebar,
    .site-header,
    .site-footer {
        display: none !important;
    }
    
    .policy-content-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .policy-page {
        background: #fff;
    }
    
    .container {
        max-width: none;
        padding: 0;
    }
    
    .col-lg-8 {
        width: 100%;
        max-width: none;
    }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .policy-content-card {
        padding: 1rem;
    }
    
    .policy-meta .row {
        flex-direction: column;
    }
    
    .sidebar-card {
        padding: 1rem;
    }
    
    .document-actions .btn {
        font-size: 0.9rem;
        padding: 0.5rem;
    }
}
</style>

<script>
// Enhanced policy page functionality with performance and UX improvements
document.addEventListener('DOMContentLoaded', function() {
    initializePolicyPage();
});

function initializePolicyPage() {
    // Initialize reading progress
    initReadingProgress();
    
    // Calculate and display reading time
    calculateReadingTime();
    
    // Initialize smooth scrolling for TOC
    initSmoothScrolling();
    
    // Initialize keyboard navigation
    initKeyboardNavigation();
    
    // Track user engagement
    trackUserEngagement();
    
    // Initialize lazy loading for images
    initLazyLoading();
}

function initReadingProgress() {
    const progressBar = document.getElementById('reading-progress-bar');
    const content = document.querySelector('.policy-content');
    
    if (!progressBar || !content) return;
    
    function updateProgress() {
        const contentTop = content.offsetTop;
        const contentHeight = content.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;
        
        const progress = Math.min(
            Math.max((scrollTop - contentTop + windowHeight) / contentHeight * 100, 0),
            100
        );
        
        progressBar.style.width = progress + '%';
        progressBar.parentElement.setAttribute('aria-valuenow', Math.round(progress));
    }
    
    // Throttled scroll handler for performance
    let ticking = false;
    function handleScroll() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateProgress();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', handleScroll);
    updateProgress(); // Initial calculation
}

function calculateReadingTime() {
    const content = document.querySelector('.policy-content');
    const readingTimeElement = document.getElementById('reading-time');
    
    if (!content || !readingTimeElement) return;
    
    const text = content.textContent || content.innerText;
    const wordsPerMinute = 200; // Average reading speed
    const wordCount = text.trim().split(/\s+/).length;
    const readingTime = Math.ceil(wordCount / wordsPerMinute);
    
    readingTimeElement.textContent = readingTime + (readingTime === 1 ? ' minute' : ' minutes');
}

function initSmoothScrolling() {
    const tocLinks = document.querySelectorAll('.policy-toc a');
    
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                // Announce navigation to screen readers
                announceToScreenReader('Navigating to ' + this.textContent);
                
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Set focus for keyboard users
                targetElement.setAttribute('tabindex', '-1');
                targetElement.focus();
                
                // Track navigation
                if (typeof DaystarUX !== 'undefined') {
                    DaystarUX.trackInteraction('toc_navigation', {
                        target: targetId,
                        source: 'table_of_contents'
                    });
                }
            }
        });
    });
}

function initKeyboardNavigation() {
    document.addEventListener('keydown', function(e) {
        // Alt + T for table of contents
        if (e.altKey && e.key === 't') {
            e.preventDefault();
            const toc = document.querySelector('.policy-toc');
            if (toc) {
                const firstLink = toc.querySelector('a');
                if (firstLink) {
                    firstLink.focus();
                    announceToScreenReader('Table of contents focused');
                }
            }
        }
        
        // Alt + C for policy content
        if (e.altKey && e.key === 'c') {
            e.preventDefault();
            const content = document.querySelector('.policy-content');
            if (content) {
                content.focus();
                announceToScreenReader('Policy content focused');
            }
        }
        
        // Alt + F for feedback section
        if (e.altKey && e.key === 'f') {
            e.preventDefault();
            const feedback = document.querySelector('.policy-feedback');
            if (feedback) {
                feedback.scrollIntoView({ behavior: 'smooth' });
                const firstButton = feedback.querySelector('button');
                if (firstButton) {
                    firstButton.focus();
                    announceToScreenReader('Feedback section focused');
                }
            }
        }
    });
}

function trackUserEngagement() {
    let startTime = Date.now();
    let maxScroll = 0;
    
    // Track scroll depth
    function trackScroll() {
        const scrollPercent = Math.round(
            (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100
        );
        
        if (scrollPercent > maxScroll) {
            maxScroll = scrollPercent;
        }
    }
    
    window.addEventListener('scroll', trackScroll);
    
    // Track time spent and engagement on page unload
    window.addEventListener('beforeunload', function() {
        const timeSpent = Date.now() - startTime;
        
        if (typeof DaystarUX !== 'undefined') {
            DaystarUX.trackInteraction('policy_engagement', {
                time_spent: timeSpent,
                max_scroll_depth: maxScroll,
                page: 'credit_policy'
            });
        }
    });
}

function initLazyLoading() {
    // Lazy load images for better performance
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(function(img) {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        images.forEach(function(img) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
}

function sharePolicy() {
    if (navigator.share) {
        navigator.share({
            title: 'Daystar SACCO Credit Policy',
            text: 'Check out the current credit policy from Daystar Multi-Purpose Co-operative Society',
            url: window.location.href
        }).then(function() {
            showNotification('Policy shared successfully', 'success');
        }).catch(function(error) {
            console.log('Error sharing:', error);
            fallbackShare();
        });
    } else {
        fallbackShare();
    }
}

function fallbackShare() {
    const url = window.location.href;
    
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showNotification('Policy URL copied to clipboard!', 'success');
        }).catch(function() {
            promptShare(url);
        });
    } else {
        promptShare(url);
    }
}

function promptShare(url) {
    const textArea = document.createElement('textarea');
    textArea.value = url;
    document.body.appendChild(textArea);
    textArea.select();
    
    try {
        document.execCommand('copy');
        showNotification('Policy URL copied to clipboard!', 'success');
    } catch (err) {
        prompt('Copy this URL to share the policy:', url);
    }
    
    document.body.removeChild(textArea);
}

function submitPolicyFeedback(type) {
    const feedbackMessage = document.getElementById('feedback-message');
    const buttons = document.querySelectorAll('.feedback-buttons button');
    
    // Disable buttons to prevent multiple submissions
    buttons.forEach(button => button.disabled = true);
    
    // Show loading state
    feedbackMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting feedback...';
    
    // Simulate API call (replace with actual implementation)
    setTimeout(function() {
        // Track feedback
        if (typeof DaystarUX !== 'undefined') {
            DaystarUX.trackInteraction('policy_feedback', {
                feedback_type: type,
                policy_version: document.querySelector('[aria-label*="Version"]')?.textContent || 'unknown'
            });
        }
        
        // Show success message
        const message = type === 'helpful' 
            ? '<i class="fas fa-check text-success"></i> Thank you for your feedback! We\'re glad this policy was helpful.'
            : '<i class="fas fa-info-circle text-info"></i> Thank you for your feedback! We\'ll work to improve this policy.';
        
        feedbackMessage.innerHTML = message;
        
        // Re-enable buttons after a delay
        setTimeout(function() {
            buttons.forEach(button => button.disabled = false);
        }, 3000);
        
    }, 1000);
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(function() {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function announceToScreenReader(message) {
    const announcement = document.createElement('div');
    announcement.setAttribute('aria-live', 'polite');
    announcement.setAttribute('aria-atomic', 'true');
    announcement.className = 'sr-only';
    announcement.textContent = message;
    
    document.body.appendChild(announcement);
    
    // Remove after announcement
    setTimeout(function() {
        document.body.removeChild(announcement);
    }, 1000);
}

// Performance monitoring for this page
if (typeof DaystarUX !== 'undefined') {
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        
        DaystarUX.trackInteraction('page_performance', {
            page: 'credit_policy',
            load_time: loadTime,
            dom_elements: document.querySelectorAll('*').length,
            images: document.querySelectorAll('img').length
        });
    });
}
</script>

<?php get_footer(); ?>