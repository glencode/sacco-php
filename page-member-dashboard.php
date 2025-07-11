<?php
/**
 * Template Name: Member Dashboard
 *
 * This is the template for the member dashboard page.
 *
 * @package Daystar
 */

require_once get_template_directory() . '/includes/auth-helper.php';
require_once get_template_directory() . '/includes/member-data.php';

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
        $loan_balance += (float)($loan->balance ?? $loan->amount); // Use balance if available, otherwise full amount
    }
}

// Get share capital from user meta (fallback to default)
$share_capital = get_user_meta($user_id, 'share_capital', true) ?: 50000;

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

<main id="primary" class="site-main dashboard-page">
    <div class="container">
        <div class="dashboard-header text-center">
            <h1 class="dashboard-title">Member Dashboard</h1>
        </div>
    
    <?php if ($member_status === 'pending'): ?>
    <!-- Pending Approval View -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card">
                    <div class="card-body text-center p-5">
                        <div class="pending-icon mb-4">
                            <i class="fas fa-clock fa-4x text-warning"></i>
                        </div>
                        <h2>Registration Pending Approval</h2>
                        <p class="lead mb-4">Thank you for registering with Daystar SACCO!</p>
                        
                        <div class="member-info mb-4">
                            <p><strong>Member Number:</strong> <?php echo esc_html($member_number); ?></p>
                            <p><strong>Registration Date:</strong> <?php echo esc_html(date('F j, Y', strtotime($registration_date))); ?></p>
                        </div>
                        
                        <div class="steps-container">
                            <h3 class="h5 mb-3">Next Steps:</h3>
                            <div class="steps">
                                <div class="step-item">
                                    <div class="step-icon">
                                        <i class="fas fa-file-upload"></i>
                                    </div>
                                    <h4 class="h6">Upload Documents</h4>
                                    <p class="small">Submit all required documents</p>
                                </div>
                                
                                <div class="step-item">
                                    <div class="step-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <h4 class="h6">Initial Contribution</h4>
                                    <p class="small">Make your initial contribution</p>
                                </div>
                                
                                <div class="step-item">
                                    <div class="step-icon">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <h4 class="h6">Verification</h4>
                                    <p class="small">Visit any branch for verification</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="documents-section mt-5">
                            <div class="row mb-3">
                                <div class="col">
                                    <h3 class="h5">Required Documents</h3>
                                </div>
                                <div class="col-auto">
                                    <div class="document-status">
                                        <?php 
                                        $doc_count = daystar_get_member_document_count($user_id);
                                        echo sprintf(
                                            '<span class="badge bg-%s">%d/5 Documents Uploaded</span>',
                                            $doc_count === 5 ? 'success' : 'warning',
                                            $doc_count
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="document-upload-card mb-3">
                                        <h4 class="h6">National ID/Passport</h4>
                                        <div class="upload-status mb-2">
                                            <?php
                                            $has_id = daystar_check_document_exists($user_id, 'National ID/Passport');
                                            if ($has_id) {
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i> Uploaded</span>';
                                            }
                                            ?>
                                        </div>
                                        <input type="file" class="form-control" id="id_upload" accept=".pdf,.jpg,.jpeg,.png">
                                        <button class="btn btn-primary btn-sm mt-2">Upload</button>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="document-upload-card mb-3">
                                        <h4 class="h6">Passport Photo</h4>
                                        <div class="upload-status mb-2">
                                            <?php
                                            $has_photo = daystar_check_document_exists($user_id, 'Passport Photo');
                                            if ($has_photo) {
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i> Uploaded</span>';
                                            }
                                            ?>
                                        </div>
                                        <input type="file" class="form-control" id="photo_upload" accept=".jpg,.jpeg,.png">
                                        <button class="btn btn-primary btn-sm mt-2">Upload</button>
                                    </div>
                                </div>
                            </div>

                            <div class="document-requirements alert alert-info">
                                <h5 class="h6">Document Requirements:</h5>
                                <ul class="mb-0">
                                    <li>Files must be clear and legible</li>
                                    <li>Maximum file size: 5MB</li>
                                    <li>Accepted formats: PDF, JPG, JPEG, PNG</li>
                                    <li>Original documents must be presented for verification</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="support-info mt-5">
                            <h3 class="h5">Need Assistance?</h3>
                            <p>Contact our support team:</p>
                            <p><i class="fas fa-phone"></i> <a href="tel:+254123456789">+254 123 456 789</a></p>
                            <p><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke">support@daystar.co.ke</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($member_status === 'rejected'): ?>
    <!-- Rejected Application View -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="status-icon mb-4">
                            <i class="fas fa-times-circle fa-4x text-danger"></i>
                        </div>
                        <h2>Application Not Approved</h2>
                        <p class="lead mb-4">We regret to inform you that your membership application has been reviewed and was not approved at this time.</p>
                        <p>Common reasons for non-approval include incomplete documentation or not meeting eligibility criteria. Please ensure all required documents were submitted correctly and that you meet our membership requirements.</p>
                        <p>If you have questions or believe this is an error, please contact our support team:</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke">support@daystar.co.ke</a></p>
                        <p><a href="<?php echo wp_logout_url(home_url('/login/')); ?>" class="btn btn-primary mt-3">Logout</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($member_status === 'suspended'): ?>
    <!-- Suspended Account View -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card">
                    <div class="card-body text-center p-5">
                        <div class="status-icon mb-4">
                            <i class="fas fa-ban fa-4x text-danger"></i>
                        </div>
                        <h2>Account Suspended</h2>
                        <p class="lead mb-4">Your account is currently suspended.</p>
                        <p>Please contact administrator for further assistance.</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:support@daystar.co.ke">support@daystar.co.ke</a></p>
                         <p><a href="<?php echo wp_logout_url(home_url('/login/')); ?>" class="btn btn-primary mt-3">Logout</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: // Primarily for 'active' status ?>
    <!-- Regular Dashboard View -->
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-xl-2 dashboard-sidebar">
                    <div class="sidebar">
                        <div class="sidebar-header">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Daystar Logo" class="sidebar-logo">
                            <button class="sidebar-toggle d-lg-none">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        
                        <ul class="sidebar-menu">
                            <li class="sidebar-item">
                                <a href="#dashboard-overview" class="sidebar-link active" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-tachometer-alt"></i>
                                    Dashboard
                            </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#contributions" class="sidebar-link" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-money-bill-wave"></i>
                                    Contributions
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#loans" class="sidebar-link" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-hand-holding-usd"></i>
                                    Loans
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#loan-application" class="sidebar-link" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-file-alt"></i>
                                    Apply for Loan
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#make-payment" class="sidebar-link" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-credit-card"></i>
                                    Make Payment
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#account-settings" class="sidebar-link" data-toggle="tab">
                                    <i class="sidebar-icon fa fa-cog"></i>
                                    Account Settings
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?php echo wp_logout_url(home_url('/')); ?>" class="sidebar-link">
                                    <i class="sidebar-icon fa fa-sign-out-alt"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9 col-xl-10 dashboard-content">
                    <!-- Header -->
                    <div class="dashboard-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h1 class="dashboard-title">Member Dashboard</h1>
                            </div>
                            <div class="col-auto">
                                <div class="member-nav">
                                    <div class="notification-bell">
                                        <i class="fa fa-bell"></i>
                                        <span class="notification-badge"><?php echo $unread_count; ?></span>
                                        
                                        <div class="notification-dropdown">
                                            <div class="notification-header">
                                                <h6>Notifications</h6>
                                                <a href="#" class="mark-all-read" onclick="markAllNotificationsRead()">Mark all as read</a>
                                            </div>
                                            <div class="notification-body">
                                                <?php if (!empty($notifications)) : ?>
                                                    <?php foreach ($notifications as $notification) : ?>
                                                        <div class="notification-item <?php echo $notification->is_read ? '' : 'unread'; ?>">
                                                            <div class="notification-icon bg-<?php echo $notification->type === 'contribution' ? 'primary' : ($notification->type === 'loan' ? 'success' : 'info'); ?>">
                                                                <i class="fa fa-<?php echo $notification->type === 'contribution' ? 'money-bill' : ($notification->type === 'loan' ? 'check-circle' : 'info-circle'); ?>"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <p><?php echo esc_html($notification->message); ?></p>
                                                                <small><?php echo human_time_diff(strtotime($notification->created_at), current_time('timestamp')) . ' ago'; ?></small>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="notification-item">
                                                        <div class="notification-content">
                                                            <p>No notifications yet.</p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="notification-footer">
                                                <a href="#notifications" class="view-all" data-toggle="tab">View all notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="member-profile-dropdown">
                                        <a href="#" class="member-nav-link dropdown-toggle" id="profileDropdown" data-toggle="dropdown">
                                            <div class="member-avatar">
                                                <?php echo get_avatar($current_user->ID, 40); ?>
                                            </div>
                                            <span class="member-name"><?php echo esc_html($current_user->display_name); ?></span>
                                        </a>
                                        
                                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                            <a class="dropdown-item" href="#account-settings" data-toggle="tab">
                                                <i class="fa fa-user"></i> My Profile
                                            </a>
                                            <a class="dropdown-item" href="#account-settings" data-toggle="tab">
                                                <i class="fa fa-cog"></i> Account Settings
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="<?php echo wp_logout_url(home_url('/')); ?>">
                                                <i class="fa fa-sign-out-alt"></i> Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dashboard Alerts -->
                    <div class="dashboard-alerts">
                        <?php if ($member_status === 'pending') : ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Account Pending Approval:</strong> Your membership is currently under review. Some features may be limited until your account is approved.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="tab-content dashboard-tab-content">
                        <!-- Dashboard Overview -->
                        <div class="tab-pane fade show active" id="dashboard-overview">
                            <!-- Member Info Card -->
                            <div class="glass-card member-info-card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Member Information</h5>
                                            <table class="table table-sm table-borderless member-info-table">
                                                <tr>
                                                    <th>Member Number:</th>
                                                    <td><?php echo esc_html($member_number); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Member Since:</th>
                                                    <td><?php echo esc_html($formatted_reg_date); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge badge-<?php echo $member_status === 'active' ? 'success' : 'warning'; ?>">
                                                            <?php echo ucfirst(esc_html($member_status)); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Monthly Contribution:</th>
                                                    <td>KES <?php echo number_format($monthly_contribution, 2); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title">Account Summary</h5>
                                            <div class="account-summary">
                                                <div class="summary-item">
                                                    <div class="summary-label">Total Contributions</div>
                                                    <div class="summary-value">KES <?php echo number_format($total_contributions, 2); ?></div>
                                                </div>
                                                <div class="summary-item">
                                                    <div class="summary-label">Share Capital</div>
                                                    <div class="summary-value">KES <?php echo number_format($share_capital, 2); ?></div>
                                                </div>
                                                <div class="summary-item">
                                                    <div class="summary-label">Total Loans</div>
                                                    <div class="summary-value">KES <?php echo number_format($total_loans, 2); ?></div>
                                                </div>
                                                <div class="summary-item">
                                                    <div class="summary-label">Loan Balance</div>
                                                    <div class="summary-value">KES <?php echo number_format($loan_balance, 2); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dashboard Stats -->
                            <div class="row">
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="glass-card dashboard-stat-card">
                                        <div class="card-body">
                                            <div class="stat-icon bg-primary">
                                                <i class="fa fa-money-bill-wave"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5 class="stat-title">Monthly Contribution</h5>
                                                <div class="stat-value">KES <?php echo number_format($monthly_contribution, 2); ?></div>
                                                <div class="stat-subtitle">Next due: June 1, 2025</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="glass-card dashboard-stat-card">
                                        <div class="card-body">
                                            <div class="stat-icon bg-success">
                                                <i class="fa fa-chart-line"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5 class="stat-title">Share Growth</h5>
                                                <div class="stat-value">12.5%</div>
                                                <div class="stat-subtitle">Last 12 months</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="glass-card dashboard-stat-card">
                                        <div class="card-body">
                                            <div class="stat-icon bg-info">
                                                <i class="fa fa-hand-holding-usd"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5 class="stat-title">Loan Eligibility</h5>
                                                <div class="stat-value">KES 200,000</div>
                                                <div class="stat-subtitle">Maximum amount</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="glass-card dashboard-stat-card">
                                        <div class="card-body">
                                            <div class="stat-icon bg-warning">
                                                <i class="fa fa-calendar-alt"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5 class="stat-title">Next Payment</h5>
                                                <div class="stat-value">KES 9,094.85</div>
                                                <div class="stat-subtitle">Due: June 15, 2025</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Charts Row -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="glass-card">
                                        <div class="card-header">
                                            <h5 class="card-title">Contribution History</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="contribution-chart" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="glass-card">
                                        <div class="card-header">
                                            <h5 class="card-title">Loan Balance</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="loan-balance-chart" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Activity -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <div class="activity-timeline">
                                        <div class="activity-item">
                                            <div class="activity-icon bg-success">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title">Monthly Contribution Received</div>
                                                <div class="activity-text">Your contribution of KES 5,000 has been received and processed.</div>
                                                <div class="activity-time">May 1, 2025 - 10:23 AM</div>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-primary">
                                                <i class="fa fa-file-alt"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title">Loan Application Approved</div>
                                                <div class="activity-text">Your application for a Development Loan of KES 100,000 has been approved.</div>
                                                <div class="activity-time">April 15, 2025 - 2:45 PM</div>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-info">
                                                <i class="fa fa-money-bill-wave"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title">Loan Disbursement</div>
                                                <div class="activity-text">Your loan amount of KES 100,000 has been disbursed to your account.</div>
                                                <div class="activity-time">April 17, 2025 - 9:30 AM</div>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-warning">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title">Loan Repayment</div>
                                                <div class="activity-text">Your loan repayment of KES 4,707.35 has been processed.</div>
                                                <div class="activity-time">May 15, 2025 - 11:15 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View All Activity</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contributions Tab -->
                        <div class="tab-pane fade" id="contributions">
                            <div class="glass-card">
                                <div class="card-header">
                                    <h5 class="card-title">Contribution History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="contribution-summary mb-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Total Contributions</h6>
                                                    <div class="summary-amount">KES <?php echo number_format($total_contributions, 2); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Monthly Contribution</h6>
                                                    <div class="summary-amount">KES <?php echo number_format($monthly_contribution, 2); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Next Contribution Due</h6>
                                                    <div class="summary-amount">June 1, 2025</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="contribution-history-table">
                                            <thead>
                                                <tr>
                                                    <th data-sort="date">Date</th>
                                                    <th data-sort="amount">Amount</th>
                                                    <th data-sort="method">Payment Method</th>
                                                    <th data-sort="reference">Reference</th>
                                                    <th data-sort="status">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($contributions as $contribution) : ?>
                                                    <tr>
                                                        <td><?php echo date('M j, Y', strtotime($contribution['date'])); ?></td>
                                                        <td>KES <?php echo number_format($contribution['amount'], 2); ?></td>
                                                        <td><?php echo esc_html($contribution['method']); ?></td>
                                                        <td><?php echo esc_html($contribution['reference']); ?></td>
                                                        <td>
                                                            <span class="badge badge-<?php echo $contribution['status'] === 'completed' ? 'success' : 'warning'; ?>">
                                                                <?php echo ucfirst(esc_html($contribution['status'])); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="#make-payment" class="btn btn-primary" data-toggle="tab">Make Contribution</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loans Tab -->
                        <div class="tab-pane fade" id="loans">
                            <div class="glass-card">
                                <div class="card-header">
                                    <h5 class="card-title">My Loans</h5>
                                </div>
                                <div class="card-body">
                                    <div class="loan-summary mb-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Total Loan Amount</h6>
                                                    <div class="summary-amount">KES <?php echo number_format($total_loans, 2); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Outstanding Balance</h6>
                                                    <div class="summary-amount">KES <?php echo number_format($loan_balance, 2); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="summary-box">
                                                    <h6>Next Payment Due</h6>
                                                    <div class="summary-amount">June 15, 2025</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($loans)) : ?>
                                        <?php foreach ($loans as $loan) : ?>
                                            <div class="loan-item mb-4">
                                                <div class="glass-card">
                                                    <div class="card-header">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0"><?php echo esc_html($loan['type']); ?> - <?php echo esc_html($loan['id']); ?></h6>
                                                            <span class="badge badge-<?php echo $loan['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                                <?php echo ucfirst(esc_html($loan['status'])); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <th>Loan Amount:</th>
                                                                        <td>KES <?php echo number_format($loan['amount'], 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Date Issued:</th>
                                                                        <td><?php echo date('M j, Y', strtotime($loan['date_issued'])); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Term:</th>
                                                                        <td><?php echo esc_html($loan['term']); ?> months</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Interest Rate:</th>
                                                                        <td><?php echo esc_html($loan['interest_rate']); ?>% p.a.</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <th>Monthly Payment:</th>
                                                                        <td>KES <?php echo number_format($loan['monthly_payment'], 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Outstanding Balance:</th>
                                                                        <td>KES <?php echo number_format($loan['balance'], 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Next Payment Due:</th>
                                                                        <td>June 15, 2025</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Payments Made:</th>
                                                                        <td>6 of <?php echo esc_html($loan['term']); ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="loan-progress mt-3">
                                                            <label>Repayment Progress</label>
                                                            <div class="progress">
                                                                <?php 
                                                                $progress = 100 - (($loan['balance'] / $loan['amount']) * 100);
                                                                ?>
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo esc_attr($progress); ?>%" aria-valuenow="<?php echo esc_attr($progress); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($progress); ?>%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-sm btn-outline-primary loan-details-toggle">View Details</button>
                                                        <a href="#make-payment" class="btn btn-sm btn-primary" data-toggle="tab">Make Payment</a>
                                                    </div>
                                                    
                                                    <div class="loan-application-details" style="display: none;">
                                                        <div class="card-body border-top">
                                                            <h6>Repayment Schedule</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Payment #</th>
                                                                            <th>Due Date</th>
                                                                            <th>Payment Amount</th>
                                                                            <th>Principal</th>
                                                                            <th>Interest</th>
                                                                            <th>Balance</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        // Generate sample repayment schedule
                                                                        $principal = $loan['amount'];
                                                                        $rate = $loan['interest_rate'] / 100 / 12;
                                                                        $payment = $loan['monthly_payment'];
                                                                        $date = new DateTime($loan['date_issued']);
                                                                        
                                                                        for ($i = 1; $i <= min(12, $loan['term']); $i++) {
                                                                            $date->modify('+1 month');
                                                                            $interest = $principal * $rate;
                                                                            $principal_payment = $payment - $interest;
                                                                            $principal -= $principal_payment;
                                                                            
                                                                            $status = $i <= 6 ? 'Paid' : 'Pending';
                                                                            $status_class = $i <= 6 ? 'success' : 'secondary';
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $i; ?></td>
                                                                                <td><?php echo $date->format('M j, Y'); ?></td>
                                                                                <td>KES <?php echo number_format($payment, 2); ?></td>
                                                                                <td>KES <?php echo number_format($principal_payment, 2); ?></td>
                                                                                <td>KES <?php echo number_format($interest, 2); ?></td>
                                                                                <td>KES <?php echo number_format($principal > 0 ? $principal : 0, 2); ?></td>
                                                                                <td><span class="badge badge-<?php echo $status_class; ?>"><?php echo $status; ?></span></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="alert alert-info">
                                            <p>You don't have any active loans at the moment.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <a href="#loan-application" class="btn btn-primary" data-toggle="tab">Apply for a Loan</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loan Application Tab -->
                        <div class="tab-pane fade" id="loan-application">
                            <div class="glass-card">
                                <div class="card-header">
                                    <h5 class="card-title">Loan Application</h5>
                                </div>
                                <div class="card-body">
                                    <?php if ($member_status !== 'active') : ?>
                                        <div class="alert alert-warning">
                                            <p>Your account must be active to apply for a loan. Please contact the administrator for assistance.</p>
                                        </div>
                                    <?php else : ?>
                                        <form id="new-loan-application-form" class="needs-validation" novalidate>
                                            <div class="form-group">
                                                <label for="loan-type">Loan Type <span class="required">*</span></label>
                                                <select class="form-control" id="loan-type" required>
                                                    <option value="">Select Loan Type</option>
                                                    <option value="development">Development Loan</option>
                                                    <option value="emergency">Emergency Loan</option>
                                                    <option value="school-fees">School Fees Loan</option>
                                                    <option value="business">Business Loan</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a loan type.</div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="loan-amount">Loan Amount (KES) <span class="required">*</span></label>
                                                <input type="number" class="form-control" id="loan-amount" min="10000" max="500000" required>
                                                <div class="invalid-feedback">Please enter a valid loan amount between KES 10,000 and KES 500,000.</div>
                                                <small class="form-text text-muted">Based on your contributions, you are eligible for a maximum loan of KES 200,000.</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="loan-term">Loan Term (Months) <span class="required">*</span></label>
                                                <select class="form-control" id="loan-term" required>
                                                    <option value="">Select Loan Term</option>
                                                    <option value="6">6 months</option>
                                                    <option value="12">12 months</option>
                                                    <option value="18">18 months</option>
                                                    <option value="24">24 months</option>
                                                    <option value="36">36 months</option>
                                                    <option value="48">48 months</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a loan term.</div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="loan-purpose">Purpose of Loan <span class="required">*</span></label>
                                                <textarea class="form-control" id="loan-purpose" rows="3" required></textarea>
                                                <div class="invalid-feedback">Please provide the purpose of the loan.</div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Guarantors <span class="required">*</span></label>
                                                <p class="text-muted">You need at least 2 guarantors who are active members of the co-op.</p>
                                                
                                                <div class="guarantor-form mb-3">
                                                    <h6>Guarantor 1</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor1-member-no">Member Number <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="guarantor1-member-no" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor1-name">Full Name <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="guarantor1-name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor1-phone">Phone Number <span class="required">*</span></label>
                                                                <input type="tel" class="form-control" id="guarantor1-phone" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor1-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                                                <input type="number" class="form-control" id="guarantor1-amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="guarantor-form">
                                                    <h6>Guarantor 2</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor2-member-no">Member Number <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="guarantor2-member-no" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor2-name">Full Name <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="guarantor2-name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor2-phone">Phone Number <span class="required">*</span></label>
                                                                <input type="tel" class="form-control" id="guarantor2-phone" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantor2-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                                                <input type="number" class="form-control" id="guarantor2-amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="loan-terms-agreement" required>
                                                    <label class="form-check-label" for="loan-terms-agreement">
                                                        I agree to the <a href="#" target="_blank">Loan Terms and Conditions</a> <span class="required">*</span>
                                                    </label>
                                                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Submit Loan Application</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Make Payment Tab -->
                        <div class="tab-pane fade" id="make-payment">
                            <div class="glass-card">
                                <div class="card-header">
                                    <h5 class="card-title">Make Payment</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form class="mpesa-payment-form">
                                                <div class="form-group">
                                                    <label for="payment-purpose">Payment Purpose <span class="required">*</span></label>
                                                    <select class="form-control" id="payment-purpose" required>
                                                        <option value="">Select Payment Purpose</option>
                                                        <option value="contribution">Monthly Contribution</option>
                                                        <option value="loan-repayment">Loan Repayment</option>
                                                        <option value="registration-fee">Registration Fee</option>
                                                        <option value="share-capital">Share Capital</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="mpesa-phone">M-Pesa Phone Number <span class="required">*</span></label>
                                                    <input type="tel" class="form-control" id="mpesa-phone" placeholder="+254XXXXXXXXX" required>
                                                    <small class="form-text text-muted">Enter the phone number registered with M-Pesa</small>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="mpesa-amount">Amount (KES) <span class="required">*</span></label>
                                                    <input type="number" class="form-control" id="mpesa-amount" min="100" required>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Make Payment</button>
                                            </form>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="payment-instructions">
                                                <h5>Payment Instructions</h5>
                                                <ol>
                                                    <li>Enter your M-Pesa registered phone number</li>
                                                    <li>Enter the amount you wish to pay</li>
                                                    <li>Click "Make Payment" button</li>
                                                    <li>You will receive an STK push on your phone</li>
                                                    <li>Enter your M-Pesa PIN to complete the transaction</li>
                                                </ol>
                                                
                                                <div class="alert alert-info">
                                                    <p><strong>Note:</strong> You can also make payments directly to our paybill number:</p>
                                                    <p>Paybill Number: <strong>123456</strong><br>
                                                    Account Number: <strong><?php echo esc_html($member_number); ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Settings Tab -->
                        <div class="tab-pane fade" id="account-settings">
                            <div class="glass-card">
                                <div class="card-header">
                                    <h5 class="card-title">Account Settings</h5>
                                    <ul class="nav nav-tabs card-header-tabs mt-3" id="account-settings-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab">Change Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="notifications-tab" data-toggle="tab" href="#notifications" role="tab">Notifications</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="account-settings-content">
                                        <!-- Profile Tab -->
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                            <form id="profile-form">
                                                <div class="form-group">
                                                    <label for="profile-first-name">First Name</label>
                                                    <input type="text" class="form-control" id="profile-first-name" value="<?php echo esc_attr($current_user->first_name); ?>">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="profile-last-name">Last Name</label>
                                                    <input type="text" class="form-control" id="profile-last-name" value="<?php echo esc_attr($current_user->last_name); ?>">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="profile-email">Email Address</label>
                                                    <input type="email" class="form-control" id="profile-email" value="<?php echo esc_attr($current_user->user_email); ?>">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="profile-phone">Phone Number</label>
                                                    <input type="tel" class="form-control" id="profile-phone" value="<?php echo esc_attr(get_user_meta($user_id, 'phone', true)); ?>">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="profile-address">Physical Address</label>
                                                    <textarea class="form-control" id="profile-address" rows="3"><?php echo esc_textarea(get_user_meta($user_id, 'physical_address', true)); ?></textarea>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </form>
                                        </div>
                                        
                                        <!-- Password Tab -->
                                        <div class="tab-pane fade" id="password" role="tabpanel">
                                            <form id="password-form">
                                                <div class="form-group">
                                                    <label for="current-password">Current Password</label>
                                                    <input type="password" class="form-control" id="current-password" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="new-password">New Password</label>
                                                    <input type="password" class="form-control" id="new-password" required>
                                                    <div class="password-strength-meter mt-2">Password strength</div>
                                                    <small class="form-text text-muted">Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters</small>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="confirm-new-password">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="confirm-new-password" required>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </form>
                                        </div>
                                        
                                        <!-- Notifications Tab -->
                                        <div class="tab-pane fade" id="notifications" role="tabpanel">
                                            <form id="notifications-form">
                                                <div class="form-group">
                                                    <label>Email Notifications</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="notify-contribution" checked>
                                                        <label class="custom-control-label" for="notify-contribution">Contribution Receipts</label>
                                                    </div>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="notify-loan" checked>
                                                        <label class="custom-control-label" for="notify-loan">Loan Updates</label>
                                                    </div>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="notify-payment" checked>
                                                        <label class="custom-control-label" for="notify-payment">Payment Reminders</label>
                                                    </div>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="notify-news">
                                                        <label class="custom-control-label" for="notify-news">News and Updates</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>SMS Notifications</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="sms-contribution" checked>
                                                        <label class="custom-control-label" for="sms-contribution">Contribution Receipts</label>
                                                    </div>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="sms-loan" checked>
                                                        <label class="custom-control-label" for="sms-loan">Loan Updates</label>
                                                    </div>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="sms-payment" checked>
                                                        <label class="custom-control-label" for="sms-payment">Payment Reminders</label>
                                                    </div>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                                            </form>
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
    <?php endif; ?>
</main>

<?php get_footer(); ?>
