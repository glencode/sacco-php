<?php
/**
 * The template for displaying the Member Dashboard for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main member-dashboard-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Member Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dashboard-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="section">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="dashboard-sidebar">
                        <div class="user-profile text-center mb-4">
                            <div class="user-avatar">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-avatar.jpg" alt="User Avatar" class="rounded-circle">
                            </div>
                            <h4 class="user-name mt-3 mb-1">John Doe</h4>
                            <p class="user-id mb-0">Member #: DST-2023-0001</p>
                        </div>
                        
                        <div class="dashboard-nav">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#overview" data-bs-toggle="tab">
                                        <i class="fas fa-tachometer-alt me-2" aria-hidden="true"></i> Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#savings" data-bs-toggle="tab">
                                        <i class="fas fa-piggy-bank me-2" aria-hidden="true"></i> Savings & Shares
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#loans" data-bs-toggle="tab">
                                        <i class="fas fa-hand-holding-usd me-2" aria-hidden="true"></i> Loans
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#transactions" data-bs-toggle="tab">
                                        <i class="fas fa-exchange-alt me-2" aria-hidden="true"></i> Transactions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#applications" data-bs-toggle="tab">
                                        <i class="fas fa-file-alt me-2" aria-hidden="true"></i> Applications
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#guarantors" data-bs-toggle="tab">
                                        <i class="fas fa-user-shield me-2" aria-hidden="true"></i> Guarantors
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#statements" data-bs-toggle="tab">
                                        <i class="fas fa-file-invoice me-2" aria-hidden="true"></i> Statements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings" data-bs-toggle="tab">
                                        <i class="fas fa-cog me-2" aria-hidden="true"></i> Settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="quick-actions mt-4">
                            <h5 class="sidebar-heading">Quick Actions</h5>
                            <div class="d-grid gap-2">
                                <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2" aria-hidden="true"></i> Apply for Loan
                                </a>
                                <a href="<?php echo esc_url(home_url('loan-calculator')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-calculator me-2" aria-hidden="true"></i> Loan Calculator
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview">
                            <div class="dashboard-welcome mb-4">
                                <h2>Welcome, John!</h2>
                                <p class="lead">Here's a summary of your account with Daystar Multi-Purpose Co-op Society Ltd.</p>
                            </div>
                            
                            <!-- Account Summary Cards -->
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-primary-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-wallet" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Total Savings</h3>
                                            <p class="summary-value">KSh 245,000</p>
                                            <p class="summary-change positive">
                                                <i class="fas fa-arrow-up" aria-hidden="true"></i> 12% from last month
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-success-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Share Capital</h3>
                                            <p class="summary-value">KSh 25,000</p>
                                            <p class="summary-change neutral">
                                                <i class="fas fa-equals" aria-hidden="true"></i> No change
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-warning-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Loan Balance</h3>
                                            <p class="summary-value">KSh 320,000</p>
                                            <p class="summary-change negative">
                                                <i class="fas fa-arrow-down" aria-hidden="true"></i> 5% from last month
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Activity -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Recent Activity</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="activity-list">
                                        <div class="activity-item">
                                            <div class="activity-icon bg-success-light">
                                                <i class="fas fa-arrow-down" aria-hidden="true"></i>
                                            </div>
                                            <div class="activity-details">
                                                <h4 class="activity-title">Monthly Contribution</h4>
                                                <p class="activity-desc">Regular savings deposit</p>
                                                <p class="activity-meta">
                                                    <span class="activity-date">May 28, 2025</span>
                                                    <span class="activity-amount positive">+KSh 5,000</span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-warning-light">
                                                <i class="fas fa-arrow-up" aria-hidden="true"></i>
                                            </div>
                                            <div class="activity-details">
                                                <h4 class="activity-title">Loan Repayment</h4>
                                                <p class="activity-desc">Development Loan #DL-2024-0042</p>
                                                <p class="activity-meta">
                                                    <span class="activity-date">May 15, 2025</span>
                                                    <span class="activity-amount negative">-KSh 15,000</span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-info-light">
                                                <i class="fas fa-file-alt" aria-hidden="true"></i>
                                            </div>
                                            <div class="activity-details">
                                                <h4 class="activity-title">Loan Application</h4>
                                                <p class="activity-desc">School Fees Loan application submitted</p>
                                                <p class="activity-meta">
                                                    <span class="activity-date">May 10, 2025</span>
                                                    <span class="activity-status pending">Pending Approval</span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <div class="activity-icon bg-success-light">
                                                <i class="fas fa-arrow-down" aria-hidden="true"></i>
                                            </div>
                                            <div class="activity-details">
                                                <h4 class="activity-title">Monthly Contribution</h4>
                                                <p class="activity-desc">Regular savings deposit</p>
                                                <p class="activity-meta">
                                                    <span class="activity-date">April 28, 2025</span>
                                                    <span class="activity-amount positive">+KSh 5,000</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#transactions" data-bs-toggle="tab" class="btn btn-link">View All Transactions</a>
                                </div>
                            </div>
                            
                            <!-- Loan Summary -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Active Loans</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Loan Type</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                    <th>Next Payment</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Development Loan</td>
                                                    <td>KSh 500,000</td>
                                                    <td>KSh 320,000</td>
                                                    <td>June 15, 2025</td>
                                                    <td><span class="badge bg-success">Current</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#loans" data-bs-toggle="tab" class="btn btn-link">View Loan Details</a>
                                </div>
                            </div>
                            
                            <!-- Announcements -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Announcements</h3>
                                </div>
                                <div class="card-body">
                                    <div class="announcement-item">
                                        <h4 class="announcement-title">Annual General Meeting</h4>
                                        <p class="announcement-date">Posted on: May 20, 2025</p>
                                        <div class="announcement-content">
                                            <p>The Annual General Meeting (AGM) for Daystar Multi-Purpose Co-op Society Ltd. will be held on July 15, 2025, at the Daystar University Auditorium from 9:00 AM to 1:00 PM.</p>
                                            <p>All members are encouraged to attend. Important agenda items include the election of new committee members and the declaration of dividends for the financial year 2024-2025.</p>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="announcement-item">
                                        <h4 class="announcement-title">New Loan Product: Education Advancement Loan</h4>
                                        <p class="announcement-date">Posted on: May 5, 2025</p>
                                        <div class="announcement-content">
                                            <p>We are pleased to announce the launch of our new Education Advancement Loan, specifically designed for members pursuing higher education or professional certifications.</p>
                                            <p>This loan offers competitive interest rates and flexible repayment terms of up to 48 months.</p>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-link">View All Announcements</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Savings & Shares Tab -->
                        <div class="tab-pane fade" id="savings">
                            <div class="dashboard-section-header mb-4">
                                <h2>Savings & Shares</h2>
                                <p class="lead">Manage your savings and share capital with Daystar Co-op.</p>
                            </div>
                            
                            <!-- Account Summary Cards -->
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-primary-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-wallet" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Regular Savings</h3>
                                            <p class="summary-value">KSh 245,000</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-success-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Share Capital</h3>
                                            <p class="summary-value">KSh 25,000</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="summary-card bg-info-light">
                                        <div class="summary-icon">
                                            <i class="fas fa-percentage" aria-hidden="true"></i>
                                        </div>
                                        <div class="summary-details">
                                            <h3 class="summary-title">Last Dividend</h3>
                                            <p class="summary-value">KSh 12,500</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Savings Chart -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Savings Growth</h3>
                                </div>
                                <div class="card-body">
                                    <div class="savings-chart-container">
                                        <canvas id="savingsChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Savings Transactions -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Savings Transactions</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>May 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 245,000</td>
                                                </tr>
                                                <tr>
                                                    <td>April 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 240,000</td>
                                                </tr>
                                                <tr>
                                                    <td>March 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 235,000</td>
                                                </tr>
                                                <tr>
                                                    <td>February 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 230,000</td>
                                                </tr>
                                                <tr>
                                                    <td>January 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 225,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <nav aria-label="Savings transactions pagination">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                            <!-- Savings Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Savings Actions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h4 class="card-title">Increase Monthly Contribution</h4>
                                                    <p class="card-text">You can increase your monthly contribution to grow your savings faster.</p>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#increaseContributionModal">Increase Contribution</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h4 class="card-title">Request Withdrawal</h4>
                                                    <p class="card-text">Request a withdrawal from your savings account.</p>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#withdrawalRequestModal">Request Withdrawal</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loans Tab -->
                        <div class="tab-pane fade" id="loans">
                            <div class="dashboard-section-header mb-4">
                                <h2>Loans</h2>
                                <p class="lead">Manage your loans and view repayment schedules.</p>
                            </div>
                            
                            <!-- Active Loans -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Active Loans</h3>
                                </div>
                                <div class="card-body">
                                    <div class="loan-details">
                                        <div class="loan-header">
                                            <h4>Development Loan #DL-2024-0042</h4>
                                            <span class="badge bg-success">Current</span>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Original Amount</span>
                                                    <span class="loan-stat-value">KSh 500,000</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Current Balance</span>
                                                    <span class="loan-stat-value">KSh 320,000</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Interest Rate</span>
                                                    <span class="loan-stat-value">12% p.a.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Monthly Payment</span>
                                                    <span class="loan-stat-value">KSh 15,000</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Disbursement Date</span>
                                                    <span class="loan-stat-value">Jan 15, 2024</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Next Payment Due</span>
                                                    <span class="loan-stat-value">June 15, 2025</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Payments Made</span>
                                                    <span class="loan-stat-value">12 of 36</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Maturity Date</span>
                                                    <span class="loan-stat-value">Jan 15, 2027</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="loan-progress mt-3">
                                            <label class="form-label d-flex justify-content-between">
                                                <span>Repayment Progress</span>
                                                <span>33% Complete</span>
                                            </label>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="loan-actions mt-4">
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repaymentScheduleModal">View Repayment Schedule</a>
                                            <a href="#" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#earlyRepaymentModal">Make Early Repayment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pending Loan Applications -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Pending Loan Applications</h3>
                                </div>
                                <div class="card-body">
                                    <div class="loan-application">
                                        <div class="loan-header">
                                            <h4>School Fees Loan #SFL-2025-0018</h4>
                                            <span class="badge bg-warning">Pending Approval</span>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Requested Amount</span>
                                                    <span class="loan-stat-value">KSh 150,000</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Requested Term</span>
                                                    <span class="loan-stat-value">12 months</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Application Date</span>
                                                    <span class="loan-stat-value">May 10, 2025</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="loan-stat">
                                                    <span class="loan-stat-label">Status</span>
                                                    <span class="loan-stat-value">Credit Committee Review</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="loan-actions mt-3">
                                            <a href="#" class="btn btn-primary">View Application Details</a>
                                            <a href="#" class="btn btn-outline-danger ms-2">Cancel Application</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Loan History -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Loan History</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Loan ID</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Disbursement Date</th>
                                                    <th>Maturity Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>EL-2023-0037</td>
                                                    <td>Emergency Loan</td>
                                                    <td>KSh 50,000</td>
                                                    <td>Mar 10, 2023</td>
                                                    <td>Mar 10, 2024</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>SFL-2022-0024</td>
                                                    <td>School Fees Loan</td>
                                                    <td>KSh 120,000</td>
                                                    <td>Jan 05, 2022</td>
                                                    <td>Jan 05, 2023</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transactions Tab -->
                        <div class="tab-pane fade" id="transactions">
                            <div class="dashboard-section-header mb-4">
                                <h2>Transactions</h2>
                                <p class="lead">View and filter all your transactions.</p>
                            </div>
                            
                            <!-- Transaction Filters -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Filter Transactions</h3>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="transactionType" class="form-label">Transaction Type</label>
                                            <select class="form-select" id="transactionType">
                                                <option value="all" selected>All Transactions</option>
                                                <option value="deposit">Deposits</option>
                                                <option value="withdrawal">Withdrawals</option>
                                                <option value="loan">Loan Transactions</option>
                                                <option value="dividend">Dividends</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dateFrom" class="form-label">Date From</label>
                                            <input type="date" class="form-control" id="dateFrom">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dateTo" class="form-label">Date To</label>
                                            <input type="date" class="form-control" id="dateTo">
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Transaction List -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Transaction History</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Reference</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>May 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td>DEP-2025-05-28</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 245,000</td>
                                                </tr>
                                                <tr>
                                                    <td>May 15, 2025</td>
                                                    <td>Loan Repayment</td>
                                                    <td>LR-DL-2024-0042-12</td>
                                                    <td class="text-danger">-KSh 15,000</td>
                                                    <td>KSh 240,000</td>
                                                </tr>
                                                <tr>
                                                    <td>April 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td>DEP-2025-04-28</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 240,000</td>
                                                </tr>
                                                <tr>
                                                    <td>April 15, 2025</td>
                                                    <td>Loan Repayment</td>
                                                    <td>LR-DL-2024-0042-11</td>
                                                    <td class="text-danger">-KSh 15,000</td>
                                                    <td>KSh 235,000</td>
                                                </tr>
                                                <tr>
                                                    <td>March 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td>DEP-2025-03-28</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 235,000</td>
                                                </tr>
                                                <tr>
                                                    <td>March 15, 2025</td>
                                                    <td>Loan Repayment</td>
                                                    <td>LR-DL-2024-0042-10</td>
                                                    <td class="text-danger">-KSh 15,000</td>
                                                    <td>KSh 230,000</td>
                                                </tr>
                                                <tr>
                                                    <td>February 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td>DEP-2025-02-28</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 230,000</td>
                                                </tr>
                                                <tr>
                                                    <td>February 15, 2025</td>
                                                    <td>Loan Repayment</td>
                                                    <td>LR-DL-2024-0042-09</td>
                                                    <td class="text-danger">-KSh 15,000</td>
                                                    <td>KSh 225,000</td>
                                                </tr>
                                                <tr>
                                                    <td>January 28, 2025</td>
                                                    <td>Monthly Contribution</td>
                                                    <td>DEP-2025-01-28</td>
                                                    <td class="text-success">+KSh 5,000</td>
                                                    <td>KSh 225,000</td>
                                                </tr>
                                                <tr>
                                                    <td>January 15, 2025</td>
                                                    <td>Loan Repayment</td>
                                                    <td>LR-DL-2024-0042-08</td>
                                                    <td class="text-danger">-KSh 15,000</td>
                                                    <td>KSh 220,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="#" class="btn btn-outline-primary">
                                                <i class="fas fa-download me-2" aria-hidden="true"></i> Export to Excel
                                            </a>
                                            <a href="#" class="btn btn-outline-primary ms-2">
                                                <i class="fas fa-file-pdf me-2" aria-hidden="true"></i> Download PDF
                                            </a>
                                        </div>
                                        <nav aria-label="Transaction history pagination">
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Applications Tab -->
                        <div class="tab-pane fade" id="applications">
                            <div class="dashboard-section-header mb-4">
                                <h2>Loan Applications</h2>
                                <p class="lead">Track the status of your loan applications.</p>
                            </div>
                            
                            <!-- Application Status -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Current Applications</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Application ID</th>
                                                    <th>Loan Type</th>
                                                    <th>Amount</th>
                                                    <th>Application Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>SFL-2025-0018</td>
                                                    <td>School Fees Loan</td>
                                                    <td>KSh 150,000</td>
                                                    <td>May 10, 2025</td>
                                                    <td>
                                                        <span class="badge bg-warning">Pending Approval</span>
                                                        <small class="d-block text-muted">Credit Committee Review</small>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Application History -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Application History</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Application ID</th>
                                                    <th>Loan Type</th>
                                                    <th>Amount</th>
                                                    <th>Application Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>DL-2024-0042</td>
                                                    <td>Development Loan</td>
                                                    <td>KSh 500,000</td>
                                                    <td>Jan 05, 2024</td>
                                                    <td><span class="badge bg-success">Approved & Disbursed</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>EL-2023-0037</td>
                                                    <td>Emergency Loan</td>
                                                    <td>KSh 50,000</td>
                                                    <td>Mar 02, 2023</td>
                                                    <td><span class="badge bg-success">Approved & Disbursed</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>SFL-2022-0024</td>
                                                    <td>School Fees Loan</td>
                                                    <td>KSh 120,000</td>
                                                    <td>Dec 20, 2021</td>
                                                    <td><span class="badge bg-success">Approved & Disbursed</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- New Application -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Start New Application</h3>
                                </div>
                                <div class="card-body">
                                    <p>Ready to apply for a new loan? Choose from our range of loan products designed to meet your financial needs.</p>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-home fa-3x mb-3 text-primary" aria-hidden="true"></i>
                                                    <h4>Development Loan</h4>
                                                    <p>For long-term development projects</p>
                                                    <a href="<?php echo esc_url(home_url('loan-application')); ?>?type=development" class="btn btn-primary">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-graduation-cap fa-3x mb-3 text-primary" aria-hidden="true"></i>
                                                    <h4>School Fees Loan</h4>
                                                    <p>For education expenses</p>
                                                    <a href="<?php echo esc_url(home_url('loan-application')); ?>?type=school-fees" class="btn btn-primary">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-ambulance fa-3x mb-3 text-primary" aria-hidden="true"></i>
                                                    <h4>Emergency Loan</h4>
                                                    <p>For unexpected urgent needs</p>
                                                    <a href="<?php echo esc_url(home_url('loan-application')); ?>?type=emergency" class="btn btn-primary">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="<?php echo esc_url(home_url('loan-application')); ?>" class="btn btn-outline-primary">View All Loan Products</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Guarantors Tab -->
                        <div class="tab-pane fade" id="guarantors">
                            <div class="dashboard-section-header mb-4">
                                <h2>Guarantors</h2>
                                <p class="lead">Manage your guarantors and guarantorship requests.</p>
                            </div>
                            
                            <!-- My Guarantors -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">My Guarantors</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Member Number</th>
                                                    <th>Loan ID</th>
                                                    <th>Amount Guaranteed</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jane Wanjiku</td>
                                                    <td>DST-2020-0015</td>
                                                    <td>DL-2024-0042</td>
                                                    <td>KSh 200,000</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Peter Kamau</td>
                                                    <td>DST-2019-0008</td>
                                                    <td>DL-2024-0042</td>
                                                    <td>KSh 150,000</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mary Njeri</td>
                                                    <td>DST-2021-0023</td>
                                                    <td>DL-2024-0042</td>
                                                    <td>KSh 150,000</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Loans I've Guaranteed -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Loans I've Guaranteed</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Member Name</th>
                                                    <th>Member Number</th>
                                                    <th>Loan ID</th>
                                                    <th>Amount Guaranteed</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>David Mwangi</td>
                                                    <td>DST-2022-0031</td>
                                                    <td>DL-2024-0039</td>
                                                    <td>KSh 100,000</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Sarah Ochieng</td>
                                                    <td>DST-2020-0018</td>
                                                    <td>SFL-2023-0052</td>
                                                    <td>KSh 50,000</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Guarantor Requests -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Guarantor Requests</h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <p class="mb-0">You have no pending guarantor requests at this time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statements Tab -->
                        <div class="tab-pane fade" id="statements">
                            <div class="dashboard-section-header mb-4">
                                <h2>Statements</h2>
                                <p class="lead">Generate and download your account statements.</p>
                            </div>
                            
                            <!-- Generate Statement -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Generate Statement</h3>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="statementType" class="form-label">Statement Type</label>
                                            <select class="form-select" id="statementType">
                                                <option value="all" selected>All Accounts</option>
                                                <option value="savings">Savings Account</option>
                                                <option value="loans">Loan Accounts</option>
                                                <option value="shares">Share Capital</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="statementFrom" class="form-label">From Date</label>
                                            <input type="date" class="form-control" id="statementFrom">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="statementTo" class="form-label">To Date</label>
                                            <input type="date" class="form-control" id="statementTo">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="statementFormat" class="form-label">Format</label>
                                            <select class="form-select" id="statementFormat">
                                                <option value="pdf" selected>PDF</option>
                                                <option value="excel">Excel</option>
                                                <option value="csv">CSV</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="statementDelivery" class="form-label">Delivery Method</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check me-4">
                                                    <input class="form-check-input" type="radio" name="statementDelivery" id="deliveryDownload" value="download" checked>
                                                    <label class="form-check-label" for="deliveryDownload">
                                                        Download
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="statementDelivery" id="deliveryEmail" value="email">
                                                    <label class="form-check-label" for="deliveryEmail">
                                                        Send to Email
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Generate Statement</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Recent Statements -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recent Statements</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Statement ID</th>
                                                    <th>Type</th>
                                                    <th>Period</th>
                                                    <th>Generated On</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ST-2025-05-001</td>
                                                    <td>All Accounts</td>
                                                    <td>Apr 01, 2025 - Apr 30, 2025</td>
                                                    <td>May 02, 2025</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download me-1" aria-hidden="true"></i> Download
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ST-2025-04-001</td>
                                                    <td>All Accounts</td>
                                                    <td>Mar 01, 2025 - Mar 31, 2025</td>
                                                    <td>Apr 02, 2025</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download me-1" aria-hidden="true"></i> Download
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ST-2025-03-001</td>
                                                    <td>All Accounts</td>
                                                    <td>Feb 01, 2025 - Feb 28, 2025</td>
                                                    <td>Mar 02, 2025</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download me-1" aria-hidden="true"></i> Download
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings">
                            <div class="dashboard-section-header mb-4">
                                <h2>Account Settings</h2>
                                <p class="lead">Manage your account preferences and security settings.</p>
                            </div>
                            
                            <!-- Personal Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Personal Information</h3>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="profileFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="profileFirstName" value="John" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="profileMiddleName" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" id="profileMiddleName" value="Mwangi" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="profileLastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="profileLastName" value="Doe" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="profileEmail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="profileEmail" value="john.doe@example.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="profilePhone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="profilePhone" value="0712345678">
                                        </div>
                                        <div class="col-12">
                                            <label for="profileAddress" class="form-label">Physical Address</label>
                                            <input type="text" class="form-control" id="profileAddress" value="123 Nairobi Way, Nairobi">
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Update Information</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Change Password -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Change Password</h3>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3">
                                        <div class="col-md-12">
                                            <label for="currentPassword" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="currentPassword">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="newPassword">
                                            <div class="form-text">
                                                Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirmPassword">
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Communication Preferences -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Communication Preferences</h3>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Notification Preferences</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifyEmail" checked>
                                                <label class="form-check-label" for="notifyEmail">
                                                    Email Notifications
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifySMS" checked>
                                                <label class="form-check-label" for="notifySMS">
                                                    SMS Notifications
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Notification Types</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifyTransactions" checked>
                                                <label class="form-check-label" for="notifyTransactions">
                                                    Transaction Alerts
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifyLoanUpdates" checked>
                                                <label class="form-check-label" for="notifyLoanUpdates">
                                                    Loan Application Updates
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifyPaymentReminders" checked>
                                                <label class="form-check-label" for="notifyPaymentReminders">
                                                    Payment Reminders
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="notifyPromotions" checked>
                                                <label class="form-check-label" for="notifyPromotions">
                                                    Promotions and Announcements
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Account Security -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Account Security</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h4>Two-Factor Authentication</h4>
                                        <p>Enhance your account security by enabling two-factor authentication.</p>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch me-3">
                                                <input class="form-check-input" type="checkbox" id="twoFactorToggle">
                                                <label class="form-check-label" for="twoFactorToggle">
                                                    Enable Two-Factor Authentication
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary" id="setupTwoFactorBtn" disabled>
                                                Set Up
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4>Login History</h4>
                                        <p>Review your recent login activity.</p>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Device</th>
                                                        <th>Location</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jun 01, 2025 10:15 AM</td>
                                                        <td>Chrome on Windows</td>
                                                        <td>Nairobi, Kenya</td>
                                                        <td><span class="badge bg-success">Successful</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>May 28, 2025 02:30 PM</td>
                                                        <td>Safari on iPhone</td>
                                                        <td>Nairobi, Kenya</td>
                                                        <td><span class="badge bg-success">Successful</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>May 25, 2025 09:45 AM</td>
                                                        <td>Chrome on Windows</td>
                                                        <td>Nairobi, Kenya</td>
                                                        <td><span class="badge bg-success">Successful</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end">
                                            <a href="#" class="btn btn-link">View Full Login History</a>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4>Account Actions</h4>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-outline-danger me-2">
                                                <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i> Sign Out of All Devices
                                            </a>
                                            <a href="#" class="btn btn-outline-danger">
                                                <i class="fas fa-lock me-2" aria-hidden="true"></i> Lock Account
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modals -->
<!-- Repayment Schedule Modal -->
<div class="modal fade" id="repaymentScheduleModal" tabindex="-1" aria-labelledby="repaymentScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="repaymentScheduleModalLabel">Loan Repayment Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loan-info mb-4">
                    <h6>Development Loan #DL-2024-0042</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Principal Amount:</strong> KSh 500,000</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Interest Rate:</strong> 12% p.a.</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Term:</strong> 36 months</p>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Due Date</th>
                                <th>Payment Amount</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Remaining Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Feb 15, 2024</td>
                                <td>KSh 15,000</td>
                                <td>KSh 10,000</td>
                                <td>KSh 5,000</td>
                                <td>KSh 490,000</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mar 15, 2024</td>
                                <td>KSh 15,000</td>
                                <td>KSh 10,100</td>
                                <td>KSh 4,900</td>
                                <td>KSh 479,900</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <!-- More rows would be here -->
                            <tr>
                                <td>12</td>
                                <td>Jan 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,200</td>
                                <td>KSh 3,800</td>
                                <td>KSh 320,000</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Feb 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,300</td>
                                <td>KSh 3,700</td>
                                <td>KSh 308,700</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Mar 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,400</td>
                                <td>KSh 3,600</td>
                                <td>KSh 297,300</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>Apr 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,500</td>
                                <td>KSh 3,500</td>
                                <td>KSh 285,800</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>May 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,600</td>
                                <td>KSh 3,400</td>
                                <td>KSh 274,200</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Jun 15, 2025</td>
                                <td>KSh 15,000</td>
                                <td>KSh 11,700</td>
                                <td>KSh 3,300</td>
                                <td>KSh 262,500</td>
                                <td><span class="badge bg-warning">Upcoming</span></td>
                            </tr>
                            <!-- More rows would be here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Download Schedule</button>
            </div>
        </div>
    </div>
</div>

<!-- Early Repayment Modal -->
<div class="modal fade" id="earlyRepaymentModal" tabindex="-1" aria-labelledby="earlyRepaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="earlyRepaymentModalLabel">Make Early Repayment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loan-info mb-4">
                    <h6>Development Loan #DL-2024-0042</h6>
                    <p><strong>Current Balance:</strong> KSh 320,000</p>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="repaymentType" class="form-label">Repayment Type</label>
                        <select class="form-select" id="repaymentType">
                            <option value="partial">Partial Repayment</option>
                            <option value="full">Full Settlement</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="partialAmountField">
                        <label for="repaymentAmount" class="form-label">Repayment Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">KSh</span>
                            <input type="number" class="form-control" id="repaymentAmount" min="1000" max="320000">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repaymentEffect" class="form-label">Effect on Loan</label>
                        <select class="form-select" id="repaymentEffect">
                            <option value="reduce_term">Reduce Loan Term (Keep Same Monthly Payment)</option>
                            <option value="reduce_payment">Reduce Monthly Payment (Keep Same Term)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repaymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="repaymentMethod">
                            <option value="savings">Deduct from Savings</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="bank">Bank Transfer</option>
                        </select>
                    </div>
                </form>
                
                <div class="alert alert-info mt-3">
                    <p class="mb-0"><strong>Note:</strong> Early repayments help reduce the total interest paid over the life of your loan. There are no penalties for early repayment.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Proceed with Repayment</button>
            </div>
        </div>
    </div>
</div>

<!-- Increase Contribution Modal -->
<div class="modal fade" id="increaseContributionModal" tabindex="-1" aria-labelledby="increaseContributionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="increaseContributionModalLabel">Increase Monthly Contribution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="current-info mb-4">
                    <p><strong>Current Monthly Contribution:</strong> KSh 5,000</p>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="newContributionAmount" class="form-label">New Monthly Contribution Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">KSh</span>
                            <input type="number" class="form-control" id="newContributionAmount" min="5000" value="5000">
                        </div>
                        <div class="form-text">Minimum contribution is KSh 2,000 per month.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contributionEffectiveDate" class="form-label">Effective From</label>
                        <input type="date" class="form-control" id="contributionEffectiveDate">
                    </div>
                </form>
                
                <div class="alert alert-info mt-3">
                    <p class="mb-0"><strong>Note:</strong> Increasing your monthly contribution helps you build your savings faster and increases your loan eligibility.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawal Request Modal -->
<div class="modal fade" id="withdrawalRequestModal" tabindex="-1" aria-labelledby="withdrawalRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawalRequestModalLabel">Request Withdrawal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="current-info mb-4">
                    <p><strong>Available Balance:</strong> KSh 245,000</p>
                    <p><strong>Maximum Withdrawable Amount:</strong> KSh 195,000</p>
                    <small class="text-muted">Note: A minimum balance of KSh 50,000 must be maintained if you have an active loan.</small>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label for="withdrawalAmount" class="form-label">Withdrawal Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">KSh</span>
                            <input type="number" class="form-control" id="withdrawalAmount" min="1000" max="195000">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdrawalReason" class="form-label">Reason for Withdrawal</label>
                        <select class="form-select" id="withdrawalReason">
                            <option value="" selected disabled>Select reason</option>
                            <option value="education">Education Expenses</option>
                            <option value="medical">Medical Expenses</option>
                            <option value="investment">Investment</option>
                            <option value="emergency">Emergency</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="otherReasonField" style="display: none;">
                        <label for="otherReason" class="form-label">Specify Other Reason</label>
                        <textarea class="form-control" id="otherReason" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdrawalMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="withdrawalMethod">
                            <option value="bank">Bank Transfer</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="bankDetailsFields">
                        <label for="bankName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control mb-2" id="bankName">
                        
                        <label for="accountName" class="form-label">Account Name</label>
                        <input type="text" class="form-control mb-2" id="accountName">
                        
                        <label for="accountNumber" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="accountNumber">
                    </div>
                </form>
                
                <div class="alert alert-warning mt-3">
                    <p class="mb-0"><strong>Note:</strong> Withdrawal requests are processed within 14 working days. Frequent withdrawals may affect your loan eligibility.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Charts
    if (document.getElementById('savingsChart')) {
        const ctx = document.getElementById('savingsChart').getContext('2d');
        const savingsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jun 2024', 'Jul 2024', 'Aug 2024', 'Sep 2024', 'Oct 2024', 'Nov 2024', 'Dec 2024', 'Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'May 2025'],
                datasets: [{
                    label: 'Savings Balance',
                    data: [200000, 205000, 210000, 215000, 220000, 225000, 230000, 225000, 230000, 235000, 240000, 245000],
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return 'KSh ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Balance: KSh ' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Withdrawal Reason Change Handler
    const withdrawalReason = document.getElementById('withdrawalReason');
    const otherReasonField = document.getElementById('otherReasonField');
    
    if (withdrawalReason) {
        withdrawalReason.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonField.style.display = 'block';
            } else {
                otherReasonField.style.display = 'none';
            }
        });
    }
    
    // Repayment Type Change Handler
    const repaymentType = document.getElementById('repaymentType');
    const partialAmountField = document.getElementById('partialAmountField');
    const repaymentEffect = document.getElementById('repaymentEffect');
    
    if (repaymentType) {
        repaymentType.addEventListener('change', function() {
            if (this.value === 'partial') {
                partialAmountField.style.display = 'block';
                document.getElementById('repaymentEffect').parentElement.style.display = 'block';
            } else {
                partialAmountField.style.display = 'none';
                document.getElementById('repaymentEffect').parentElement.style.display = 'none';
            }
        });
    }
    
    // Two-Factor Authentication Toggle
    const twoFactorToggle = document.getElementById('twoFactorToggle');
    const setupTwoFactorBtn = document.getElementById('setupTwoFactorBtn');
    
    if (twoFactorToggle && setupTwoFactorBtn) {
        twoFactorToggle.addEventListener('change', function() {
            setupTwoFactorBtn.disabled = !this.checked;
        });
    }
    
    // Withdrawal Method Change Handler
    const withdrawalMethod = document.getElementById('withdrawalMethod');
    const bankDetailsFields = document.getElementById('bankDetailsFields');
    
    if (withdrawalMethod && bankDetailsFields) {
        withdrawalMethod.addEventListener('change', function() {
            if (this.value === 'bank') {
                bankDetailsFields.style.display = 'block';
            } else {
                bankDetailsFields.style.display = 'none';
            }
        });
    }
});
</script>

<?php
get_footer();
