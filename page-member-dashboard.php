<?php
/**
 * Template Name: Member Dashboard
 *
 * Modern redesigned member dashboard with oceanic theme and glassmorphism effects
 *
 * @package Daystar
 */

require_once get_template_directory() . '/includes/auth-helper.php';
require_once get_template_directory() . '/includes/member-data.php';
require_once get_template_directory() . '/includes/share-transfer.php';

// Do access check before any output
$current_user = daystar_check_member_access();

// Get real member data
$user_id = $current_user->ID;
$member_number = get_user_meta($user_id, 'member_number', true);
$member_status = get_user_meta($user_id, 'member_status', true);
$registration_date = get_user_meta($user_id, 'registration_date', true);
$initial_contribution = get_user_meta($user_id, 'initial_contribution', true);
$monthly_contribution = get_user_meta($user_id, 'monthly_contribution', true);

// Format dates
$formatted_reg_date = date('F j, Y', strtotime($registration_date));

// Get real contribution and loan data
$contributions = daystar_get_member_contributions($user_id);
$loans = daystar_get_member_loans($user_id);
$account_balance = daystar_get_member_balance($user_id);

// Calculate totals for dashboard display
$total_contributions = 0;
if ($contributions) {
    foreach ($contributions as $contribution) {
        if ($contribution->status === 'completed') {
            $total_contributions += (float)$contribution->amount;
        }
    }
}

$total_loans = 0;
$loan_balance = 0;
if ($loans) {
    foreach ($loans as $loan) {
        $total_loans += (float)$loan->amount;
        $loan_balance += (float)($loan->balance ?? $loan->amount);
    }
}

// Get share capital and loan eligibility
$share_capital = daystar_get_member_share_capital($user_id);
$regular_contributions = daystar_get_member_regular_contributions($user_id);
$loan_eligibility = daystar_get_general_loan_eligibility($user_id);

// Ensure all variables have default values
$total_contributions = $total_contributions ?: 0;
$total_loans = $total_loans ?: 0;
$loan_balance = $loan_balance ?: 0;
$monthly_contribution = $monthly_contribution ?: 0;
$initial_contribution = $initial_contribution ?: 0;

// Get notifications
$notifications = daystar_get_member_notifications($user_id, 5);
$unread_count = daystar_get_unread_notifications_count($user_id);

get_header();
?>

<main id="primary" class="site-main member-dashboard-modern" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/member-dashboardbg.jpg') no-repeat center center fixed !important; background-size: cover !important;">
    <!-- Parallax Background -->
    <div class="parallax-container">
        <div class="parallax-layer parallax-layer-1"></div>
        <div class="parallax-layer parallax-layer-2"></div>
        <div class="parallax-layer parallax-layer-3"></div>
    </div>

    <!-- Dashboard Header -->
    <header class="dashboard-hero-header py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-content">
                        <!-- Dynamic Greeting -->
                        <div class="greeting-section mb-3">
                            <div class="time-indicator">
                                <i id="time-icon" class="fas fa-sun"></i>
                                <span id="current-time" class="time-display"></span>
                            </div>
                            <h1 id="dynamic-greeting" class="display-title display-4 mb-2 text-white">
                                Good Morning, <?php echo esc_html($current_user->display_name); ?>
                            </h1>
                        </div>
                        
                        <!-- Dynamic Subtitle -->
                        <div class="subtitle-section">
                            <p id="dynamic-subtitle" class="content-text lead mb-3 text-white">
                                Ready to manage your finances today?
                            </p>
                            
                            <!-- Quick Stats Summary -->
                            <div class="quick-summary d-flex flex-wrap gap-3">
                                <div class="summary-item">
                                    <i class="fas fa-wallet text-info me-2"></i>
                                    <span class="summary-label">Balance:</span>
                                    <span class="summary-value">KES <?php echo number_format($total_contributions, 0); ?></span>
                                </div>
                                <div class="summary-item">
                                    <i class="fas fa-chart-line text-success me-2"></i>
                                    <span class="summary-label">Growth:</span>
                                    <span class="summary-value">+12.5%</span>
                                </div>
                                <?php if ($loan_balance > 0): ?>
                                <div class="summary-item">
                                    <i class="fas fa-credit-card text-warning me-2"></i>
                                    <span class="summary-label">Loans:</span>
                                    <span class="summary-value">KES <?php echo number_format($loan_balance, 0); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="header-cards">
                        <!-- Enhanced Member Status Card -->
                        <div class="member-status-card glass-card mb-3 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="member-avatar">
                                    <div class="avatar-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="member-status-badge">
                                    <span class="badge badge-<?php echo $member_status === 'active' ? 'success' : 'warning'; ?>">
                                        <i class="fas fa-<?php echo $member_status === 'active' ? 'check-circle' : 'clock'; ?> me-1"></i>
                                        <?php echo ucfirst(esc_html($member_status)); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="member-details">
                                <h6 class="member-name mb-1"><?php echo esc_html($current_user->display_name); ?></h6>
                                <p class="member-number text-muted mb-2">Member #<?php echo esc_html($member_number); ?></p>
                                <div class="member-since">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Member since <?php echo date('M Y', strtotime($registration_date)); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Weather/Date Card -->
                        <div class="date-weather-card glass-card p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="date-info">
                                    <div class="current-date" id="current-date"></div>
                                    <div class="current-day text-muted" id="current-day"></div>
                                </div>
                                <div class="weather-icon">
                                    <i class="fas fa-cloud-sun text-warning"></i>
                                    <small class="text-muted d-block">Nairobi</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <div class="container">
        <nav class="breadcrumb-modern my-0" aria-label="breadcrumb">
            <a href="/" class="breadcrumb-link">
                <i class="fas fa-home me-2"></i>Home
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Member Dashboard</span>
        </nav>
    </div>

    <div class="container my-5">
        <?php if ($member_status === 'pending'): ?>
        <!-- Pending Approval View -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card p-5 text-center">
                    <div class="pending-icon mb-4">
                        <i class="fas fa-clock fa-4x text-warning"></i>
                    </div>
                    <h2 class="text-white">Registration Pending Approval</h2>
                    <p class="lead mb-4 text-white">Thank you for registering with Daystar SACCO!</p>
                    
                    <div class="member-info mb-4">
                        <p class="text-white"><strong>Member Number:</strong> <?php echo esc_html($member_number); ?></p>
                        <p class="text-white"><strong>Registration Date:</strong> <?php echo esc_html($formatted_reg_date); ?></p>
                    </div>
                    
                    <div class="support-info mt-5">
                        <h3 class="h5 text-white">Need Assistance?</h3>
                        <p class="text-white">Contact our support team:</p>
                        <p class="text-white"><i class="fas fa-phone"></i> <a href="tel:+254123456789" class="text-info">+254 123 456 789</a></p>
                        <p class="text-white"><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke" class="text-info">support@daystar.co.ke</a></p>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif ($member_status === 'rejected'): ?>
        <!-- Rejected Application View -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card p-5 text-center">
                    <div class="status-icon mb-4">
                        <i class="fas fa-times-circle fa-4x text-danger"></i>
                    </div>
                    <h2 class="text-white">Application Not Approved</h2>
                    <p class="lead mb-4 text-white">We regret to inform you that your membership application was not approved at this time.</p>
                    <p class="text-white">Please contact our support team for more information:</p>
                    <p class="text-white"><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke" class="text-info">support@daystar.co.ke</a></p>
                    <a href="<?php echo wp_logout_url(home_url('/login/')); ?>" class="btn btn-primary mt-3">Logout</a>
                </div>
            </div>
        </div>

        <?php elseif ($member_status === 'suspended'): ?>
        <!-- Suspended Account View -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card p-5 text-center">
                    <div class="status-icon mb-4">
                        <i class="fas fa-ban fa-4x text-danger"></i>
                    </div>
                    <h2 class="text-white">Account Suspended</h2>
                    <p class="lead mb-4 text-white">Your account is currently suspended.</p>
                    <p class="text-white">Please contact administrator for assistance.</p>
                    <p class="text-white"><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke" class="text-info">support@daystar.co.ke</a></p>
                    <a href="<?php echo wp_logout_url(home_url('/login/')); ?>" class="btn btn-primary mt-3">Logout</a>
                </div>
            </div>
        </div>

        <?php else: // Active status ?>
        <!-- Modern Dashboard Layout -->
        <div class="row">
            <!-- Main Content Area -->
            <div class="col-lg-9">
                <!-- Quick Stats Overview -->
                <section class="dashboard-stats-section mb-5">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="glass-card stat-card text-center p-4 h-100">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-wallet text-primary"></i>
                                </div>
                                <h5 class="stat-title">Total Contributions</h5>
                                <div class="stat-value text-primary">KES <?php echo number_format($total_contributions, 2); ?></div>
                                <small class="text-muted">Since <?php echo esc_html($formatted_reg_date); ?></small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="glass-card stat-card text-center p-4 h-100">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-chart-line text-success"></i>
                                </div>
                                <h5 class="stat-title">Share Capital</h5>
                                <div class="stat-value text-success">KES <?php echo number_format($share_capital, 2); ?></div>
                                <small class="text-<?php echo $loan_eligibility['share_capital']['met'] ? 'success' : 'warning'; ?>">
                                    <?php echo $loan_eligibility['share_capital']['met'] ? 'Meets requirement' : 'Below minimum'; ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="glass-card stat-card text-center p-4 h-100">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-hand-holding-usd text-info"></i>
                                </div>
                                <h5 class="stat-title">Loan Eligibility</h5>
                                <div class="stat-value text-info">KES <?php echo number_format($loan_eligibility['max_loan_amount'], 2); ?></div>
                                <small class="text-<?php echo $loan_eligibility['is_eligible'] ? 'success' : 'warning'; ?>">
                                    <?php echo $loan_eligibility['is_eligible'] ? 'Eligible' : 'Not Eligible'; ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="glass-card stat-card text-center p-4 h-100">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-credit-card text-warning"></i>
                                </div>
                                <h5 class="stat-title">Outstanding Loans</h5>
                                <div class="stat-value text-warning">KES <?php echo number_format($loan_balance, 2); ?></div>
                                <small class="text-muted"><?php echo count($loans); ?> active loan(s)</small>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Member Information Section -->
                <section class="member-info-section mb-5">
                    <div class="glass-card p-4">
                        <div class="section-header mb-4">
                            <h3 class="section-title">
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                Member Information
                            </h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <h6 class="info-label">Personal Details</h6>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-key">Member Number:</span>
                                            <span class="info-value"><?php echo esc_html($member_number); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Full Name:</span>
                                            <span class="info-value"><?php echo esc_html($current_user->display_name); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Email:</span>
                                            <span class="info-value"><?php echo esc_html($current_user->user_email); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Member Since:</span>
                                            <span class="info-value"><?php echo esc_html($formatted_reg_date); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-group">
                                    <h6 class="info-label">Account Status</h6>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-key">Status:</span>
                                            <span class="info-value">
                                                <span class="badge badge-<?php echo $member_status === 'active' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst(esc_html($member_status)); ?>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Monthly Contribution:</span>
                                            <span class="info-value">KES <?php echo number_format($monthly_contribution, 2); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Initial Contribution:</span>
                                            <span class="info-value">KES <?php echo number_format($initial_contribution, 2); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-key">Next Payment Due:</span>
                                            <span class="info-value text-warning">June 1, 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Quick Actions Section -->
                <section class="quick-actions-section mb-5">
                    <div class="glass-card p-4">
                        <div class="section-header mb-4">
                            <h3 class="section-title">
                                <i class="fas fa-bolt text-warning me-2"></i>
                                Quick Actions
                            </h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <a href="/page-payment" class="action-card glass-card p-3 text-decoration-none h-100 d-block">
                                    <div class="action-icon mb-2">
                                        <i class="fas fa-credit-card text-primary"></i>
                                    </div>
                                    <h6 class="action-title">Make Payment</h6>
                                    <p class="action-desc small text-muted mb-0">Pay contributions or loan installments</p>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-lg-3 mb-3">
                                <a href="/page-loan-application-consolidated" class="action-card glass-card p-3 text-decoration-none h-100 d-block">
                                    <div class="action-icon mb-2">
                                        <i class="fas fa-file-alt text-success"></i>
                                    </div>
                                    <h6 class="action-title">Apply for Loan</h6>
                                    <p class="action-desc small text-muted mb-0">Submit a new loan application</p>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-lg-3 mb-3">
                                <a href="/page-loan-dashboard" class="action-card glass-card p-3 text-decoration-none h-100 d-block">
                                    <div class="action-icon mb-2">
                                        <i class="fas fa-history text-info"></i>
                                    </div>
                                    <h6 class="action-title">View History</h6>
                                    <p class="action-desc small text-muted mb-0">Check contribution and loan history</p>
                                </a>
                            </div>
                            
                            <div class="col-md-6 col-lg-3 mb-3">
                                <a href="/page-member-profile" class="action-card glass-card p-3 text-decoration-none h-100 d-block">
                                    <div class="action-icon mb-2">
                                        <i class="fas fa-cog text-secondary"></i>
                                    </div>
                                    <h6 class="action-title">Account Settings</h6>
                                    <p class="action-desc small text-muted mb-0">Update your profile and preferences</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Recent Activity Section -->
                <section class="recent-activity-section mb-5">
                    <div class="glass-card p-4">
                        <div class="section-header mb-4">
                            <h3 class="section-title">
                                <i class="fas fa-clock text-info me-2"></i>
                                Recent Activity
                            </h3>
                        </div>
                        
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="activity-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">Monthly Contribution Received</h6>
                                    <p class="activity-desc">Your contribution of KES <?php echo number_format($monthly_contribution, 2); ?> has been received and processed.</p>
                                    <small class="activity-time text-muted">May 1, 2025 - 10:23 AM</small>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="activity-icon bg-primary">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">Account Status Updated</h6>
                                    <p class="activity-desc">Your membership status has been updated to active.</p>
                                    <small class="activity-time text-muted">April 15, 2025 - 2:45 PM</small>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="activity-icon bg-info">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">Welcome to Daystar SACCO</h6>
                                    <p class="activity-desc">Your membership registration has been completed successfully.</p>
                                    <small class="activity-time text-muted"><?php echo esc_html($formatted_reg_date); ?> - 9:30 AM</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="/page-loan-dashboard" class="btn btn-outline-primary">View All Activity</a>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Navigation Menu -->
                <nav class="dashboard-navigation glass-card p-4 mb-4">
                    <h5 class="nav-title mb-4">
                        <i class="fas fa-compass text-primary me-2"></i>
                        Dashboard Menu
                    </h5>
                    
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="/page-member-dashboard" class="nav-link active">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/page-loan-dashboard" class="nav-link">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                Contributions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/page-loan-dashboard" class="nav-link">
                                <i class="fas fa-hand-holding-usd me-2"></i>
                                My Loans
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/page-loan-application-consolidated" class="nav-link">
                                <i class="fas fa-file-alt me-2"></i>
                                Apply for Loan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/page-payment" class="nav-link">
                                <i class="fas fa-credit-card me-2"></i>
                                Make Payment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/page-member-profile" class="nav-link">
                                <i class="fas fa-cog me-2"></i>
                                Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo wp_logout_url(home_url('/')); ?>" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Notifications Panel -->
                <div class="notifications-panel glass-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="panel-title mb-0">
                            <i class="fas fa-bell text-warning me-2"></i>
                            Notifications
                        </h6>
                        <?php if ($unread_count > 0): ?>
                            <span class="badge badge-warning"><?php echo $unread_count; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="notifications-list">
                        <?php if (!empty($notifications)) : ?>
                            <?php foreach (array_slice($notifications, 0, 3) as $notification) : ?>
                                <div class="notification-item <?php echo $notification->is_read ? '' : 'unread'; ?> mb-3">
                                    <div class="d-flex">
                                        <div class="notification-icon me-2">
                                            <i class="fas fa-<?php 
                                                echo $notification->type === 'contribution' ? 'money-bill' : 
                                                    ($notification->type === 'loan' ? 'check-circle' : 'info-circle'); 
                                            ?> text-<?php 
                                                echo $notification->type === 'contribution' ? 'primary' : 
                                                    ($notification->type === 'loan' ? 'success' : 'info'); 
                                            ?>"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="notification-text small mb-1"><?php echo esc_html($notification->message); ?></p>
                                            <small class="notification-time text-muted"><?php echo human_time_diff(strtotime($notification->created_at), current_time('timestamp')) . ' ago'; ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-muted small">No notifications yet.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="/page-loan-dashboard" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>

                <!-- Support Contact -->
                <div class="support-contact glass-card p-4">
                    <h6 class="support-title mb-3">
                        <i class="fas fa-headset text-success me-2"></i>
                        Need Help?
                    </h6>
                    
                    <div class="contact-info">
                        <div class="contact-item mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <a href="tel:+254123456789" class="contact-link">+254 123 456 789</a>
                        </div>
                        <div class="contact-item mb-2">
                            <i class="fas fa-envelope text-info me-2"></i>
                            <a href="mailto:support@daystar.co.ke" class="contact-link">support@daystar.co.ke</a>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span class="contact-text">Mon-Fri: 8AM-5PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Custom Styles for Modern Dashboard -->
    <style>
    /* Modern Dashboard Styles */
    .member-dashboard-modern {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(135deg, #006994 0%, #20B2AA 100%);
        overflow-x: hidden;
    }

    .member-dashboard-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 25% 25%, rgba(32, 178, 170, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(0, 105, 148, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(64, 224, 208, 0.05) 0%, transparent 70%);
        pointer-events: none;
        z-index: 1;
    }

    .member-dashboard-modern > * {
        position: relative;
        z-index: 2;
    }

    /* Dashboard Header */
    .dashboard-hero-header {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .dashboard-hero-header .display-title {
        color: #fff !important;
        text-shadow: 0 2px 12px rgba(0,0,0,0.45);
        font-weight: 800;
    }

    .dashboard-hero-header .content-text {
        color: rgba(255, 255, 255, 0.9) !important;
        text-shadow: 0 2px 8px rgba(0,0,0,0.35);
        font-weight: 500;
    }

    /* Enhanced Header Styles */
    .time-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .time-display {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
    }

    #time-icon {
        font-size: 1.2rem;
        color: #FFD700;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .quick-summary {
        margin-top: 1rem;
    }

    .summary-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }

    .summary-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .summary-label {
        font-weight: 500;
        margin-right: 0.25rem;
    }

    .summary-value {
        font-weight: 700;
        color: #fff;
    }

    /* Enhanced Member Status Card */
    .member-status-card {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .member-status-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .member-avatar .avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #006994, #20B2AA);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 105, 148, 0.3);
    }

    .member-name {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .member-number {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .member-since {
        font-size: 0.8rem;
    }

    /* Date Weather Card */
    .date-weather-card {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .date-weather-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .current-date {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
    }

    .current-day {
        font-size: 0.85rem;
        font-weight: 500;
    }

    .weather-icon {
        text-align: center;
    }

    .weather-icon i {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    /* Header Cards Container */
    .header-cards {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Responsive Header */
    @media (max-width: 991px) {
        .header-cards {
            flex-direction: row;
            margin-top: 2rem;
        }
        
        .member-status-card,
        .date-weather-card {
            flex: 1;
        }
        
        .quick-summary {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .header-cards {
            flex-direction: column;
        }
        
        .quick-summary {
            flex-direction: column;
            align-items: center;
            gap: 0.75rem !important;
        }
        
        .summary-item {
            width: 100%;
            text-align: center;
        }
        
        .time-indicator {
            justify-content: center;
        }
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        background: rgba(30,41,59,0.55);
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        margin-bottom: 2rem;
        color: #fff;
        font-size: 1.05rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .breadcrumb-link {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb-link:hover {
        text-decoration: underline;
        color: #40E0D0;
    }

    .breadcrumb-separator {
        margin: 0 0.5em;
        color: #fff;
    }

    .breadcrumb-current {
        color: #fff;
    }

    /* Glass Cards */
    .glass-card {
        background: rgba(30, 41, 59, 0.65) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        color: #f8fafc;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .glass-card .section-title,
    .glass-card h3,
    .glass-card h4,
    .glass-card h5,
    .glass-card h6 {
        color: #fff;
        font-weight: 700;
    }

    .glass-card p,
    .glass-card .info-value,
    .glass-card .stat-value {
        color: #f8fafc;
    }

    /* Stat Cards */
    .stat-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 45px rgba(0, 105, 148, 0.3);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-icon i {
        font-size: 1.5rem;
        color: #60a5fa;
    }

    .stat-title {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .stat-value {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-key {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    .info-value {
        color: #fff;
        font-weight: 600;
    }

    .info-label {
        color: #60a5fa;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    /* Action Cards */
    .action-card {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
        text-decoration: none !important;
        color: #f8fafc !important;
    }

    .action-card:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 105, 148, 0.2);
        color: #fff !important;
        text-decoration: none !important;
    }

    .action-icon {
        text-align: center;
    }

    .action-icon i {
        font-size: 1.8rem;
    }

    .action-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .action-desc {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Activity Timeline */
    .activity-timeline {
        position: relative;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .activity-icon.bg-success {
        background: linear-gradient(135deg, #56ab2f, #a8e6cf);
    }

    .activity-icon.bg-primary {
        background: linear-gradient(135deg, #006994, #20B2AA);
    }

    .activity-icon.bg-info {
        background: linear-gradient(135deg, #40E0D0, #006994);
    }

    .activity-icon i {
        color: white;
        font-size: 1rem;
    }

    .activity-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .activity-desc {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .activity-time {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.8rem;
    }

    /* Navigation */
    .dashboard-navigation {
        background: rgba(30, 41, 59, 0.95) !important;
    }

    .nav-title {
        color: #fff;
        font-weight: 700;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.5rem;
    }

    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 0.5rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.8) !important;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-link:hover,
    .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: #fff !important;
        transform: translateX(5px);
        text-decoration: none;
    }

    .nav-link.active {
        background: linear-gradient(135deg, #006994, #20B2AA);
        box-shadow: 0 4px 15px rgba(0, 105, 148, 0.3);
    }

    /* Notifications Panel */
    .notifications-panel {
        background: rgba(30, 41, 59, 0.95) !important;
    }

    .panel-title {
        color: #fff;
        font-weight: 600;
    }

    .notification-item {
        padding: 0.75rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .notification-item.unread {
        background: rgba(96, 165, 250, 0.1);
        border-color: rgba(96, 165, 250, 0.3);
    }

    .notification-text {
        color: #f8fafc;
        margin-bottom: 0.25rem;
    }

    .notification-time {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Support Contact */
    .support-contact {
        background: rgba(30, 41, 59, 0.95) !important;
    }

    .support-title {
        color: #fff;
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
    }

    .contact-link {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-link:hover {
        color: #40E0D0;
        text-decoration: underline;
    }

    .contact-text {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    /* Badges */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .badge-success {
        background: linear-gradient(135deg, #56ab2f, #a8e6cf);
        color: white;
    }

    .badge-warning {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
        color: white;
    }

    .badge-primary {
        background: linear-gradient(135deg, #006994, #20B2AA);
        color: white;
    }

    /* Buttons */
    .btn {
        border-radius: 25px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #006994, #20B2AA);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 105, 148, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 105, 148, 0.4);
        background: linear-gradient(135deg, #20B2AA, #006994);
        color: white;
    }

    .btn-outline-primary {
        border: 2px solid rgba(96, 165, 250, 0.5);
        color: #60a5fa;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: rgba(96, 165, 250, 0.1);
        border-color: #60a5fa;
        color: #60a5fa;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .member-dashboard-modern {
            padding: 1rem 0;
        }
        
        .dashboard-hero-header .display-title {
            font-size: 2rem;
        }
        
        .stat-card {
            margin-bottom: 1rem;
        }
        
        .action-card {
            margin-bottom: 1rem;
        }
        
        .glass-card {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb-modern {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .stat-value {
            font-size: 1.25rem;
        }
        
        .action-icon i {
            font-size: 1.5rem;
        }
    }

    /* Animation Classes */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

    <!-- JavaScript for Dashboard Functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamic Header Functionality
        function updateDynamicHeader() {
            const now = new Date();
            const hour = now.getHours();
            const timeIcon = document.getElementById('time-icon');
            const greeting = document.getElementById('dynamic-greeting');
            const subtitle = document.getElementById('dynamic-subtitle');
            const currentTime = document.getElementById('current-time');
            const currentDate = document.getElementById('current-date');
            const currentDay = document.getElementById('current-day');
            
            // Update time display
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            if (currentTime) currentTime.textContent = timeString;
            
            // Update date display
            const dateString = now.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric' 
            });
            const dayString = now.toLocaleDateString('en-US', { 
                weekday: 'long' 
            });
            if (currentDate) currentDate.textContent = dateString;
            if (currentDay) currentDay.textContent = dayString;
            
            // Dynamic greeting based on time
            let greetingText = '';
            let iconClass = '';
            let subtitleText = '';
            
            if (hour >= 5 && hour < 12) {
                greetingText = 'Good Morning';
                iconClass = 'fas fa-sun';
                subtitleText = 'Ready to start your financial journey today?';
            } else if (hour >= 12 && hour < 17) {
                greetingText = 'Good Afternoon';
                iconClass = 'fas fa-sun';
                subtitleText = 'How\'s your day going? Let\'s check your finances.';
            } else if (hour >= 17 && hour < 21) {
                greetingText = 'Good Evening';
                iconClass = 'fas fa-moon';
                subtitleText = 'Winding down? Perfect time to review your progress.';
            } else {
                greetingText = 'Good Evening';
                iconClass = 'fas fa-moon';
                subtitleText = 'Working late? Your finances are in good hands.';
            }
            
            // Update elements
            if (timeIcon) {
                timeIcon.className = iconClass;
                timeIcon.style.color = hour >= 17 ? '#FFD700' : '#FFA500';
            }
            
            if (greeting) {
                const userName = greeting.textContent.split(', ')[1];
                greeting.textContent = `${greetingText}, ${userName}`;
            }
            
            if (subtitle) {
                subtitle.textContent = subtitleText;
            }
        }
        
        // Initialize dynamic header
        updateDynamicHeader();
        
        // Update time every minute
        setInterval(updateDynamicHeader, 60000);
        
        // Add animation classes to cards
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in-up');
            }, index * 100);
        });
        
        // Notification interactions
        const notificationItems = document.querySelectorAll('.notification-item');
        notificationItems.forEach(item => {
            item.addEventListener('click', function() {
                this.classList.remove('unread');
            });
        });
        
        // Action card hover effects
        const actionCards = document.querySelectorAll('.action-card');
        actionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Summary item hover effects
        const summaryItems = document.querySelectorAll('.summary-item');
        summaryItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
                this.style.boxShadow = '0 4px 15px rgba(255, 255, 255, 0.2)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = 'none';
            });
        });
        
        // Header cards hover effects
        const headerCards = document.querySelectorAll('.member-status-card, .date-weather-card');
        headerCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Add subtle parallax effect to header
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const header = document.querySelector('.dashboard-hero-header');
            if (header) {
                header.style.transform = `translateY(${scrolled * 0.1}px)`;
            }
        });
    });
    </script>
</main>

<?php get_footer(); ?>