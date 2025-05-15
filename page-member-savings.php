<?php
/**
 * Template Name: Member Savings
 *
 * The template for displaying the member savings information.
 *
 * @package sacco-php
 */

get_header();

// Get current user
$current_user = wp_get_current_user();
?>

<main id="primary" class="site-main">

    <section class="member-header bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="member-dashboard-title">My Savings</h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Welcome, <?php echo esc_html($current_user->display_name); ?>!</p>
                    <p class="mb-0 member-id">Member ID: <?php echo esc_html(get_user_meta($current_user->ID, 'member_id', true) ?: 'MEM' . str_pad($current_user->ID, 6, '0', STR_PAD_LEFT)); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="member-dashboard-section py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="member-sidebar">
                        <div class="list-group">
                            <a href="<?php echo esc_url(home_url('member-dashboard')); ?>" class="list-group-item list-group-item-action">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="<?php echo esc_url(home_url('member-profile')); ?>" class="list-group-item list-group-item-action">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <a href="<?php echo esc_url(home_url('member-savings')); ?>" class="list-group-item list-group-item-action active">
                                <i class="fas fa-piggy-bank"></i> My Savings
                            </a>
                            <a href="<?php echo esc_url(home_url('member-loans')); ?>" class="list-group-item list-group-item-action">
                                <i class="fas fa-hand-holding-usd"></i> My Loans
                            </a>
                            <a href="<?php echo esc_url(home_url('member-transactions')); ?>" class="list-group-item list-group-item-action">
                                <i class="fas fa-exchange-alt"></i> Transactions
                            </a>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="list-group-item list-group-item-action text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="member-content-wrapper">
                        <div id="member-savings-section" class="member-content-section">
                            <!-- Savings Summary -->
                            <div class="dashboard-card mb-4">
                                <div class="dashboard-card-header">
                                    <h2 class="dashboard-card-title">Savings Summary</h2>
                                </div>
                                <div class="dashboard-card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-4 mb-md-0">
                                            <div class="account-summary-item text-center">
                                                <div class="summary-icon">
                                                    <i class="fas fa-piggy-bank"></i>
                                                </div>
                                                <h4>Total Savings</h4>
                                                <div class="summary-amount">KSh 125,000.00</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4 mb-md-0">
                                            <div class="account-summary-item text-center">
                                                <div class="summary-icon">
                                                    <i class="fas fa-coins"></i>
                                                </div>
                                                <h4>Total Shares</h4>
                                                <div class="summary-amount">KSh 75,000.00</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="account-summary-item text-center">
                                                <div class="summary-icon">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                                <h4>Interest Earned YTD</h4>
                                                <div class="summary-amount">KSh 3,750.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Savings Accounts -->
                            <div class="dashboard-card mb-4">
                                <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                                    <h2 class="dashboard-card-title">My Savings Accounts</h2>
                                    <a href="#" class="btn btn-sm btn-primary">Open New Account</a>
                                </div>
                                <div class="dashboard-card-body">
                                    <!-- Regular Savings Account -->
                                    <div class="savings-account-card mb-4">
                                        <div class="savings-account-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <h3 class="savings-account-type">Regular Savings Account</h3>
                                                <div class="savings-account-number">Account #: SA-2015-00125</div>
                                            </div>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                        <div class="savings-account-body">
                                            <div class="savings-account-amount">KSh 85,000.00</div>
                                            
                                            <ul class="savings-account-details">
                                                <li>
                                                    <span class="detail-label">Account Type</span>
                                                    <span class="detail-value">Regular Savings</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Interest Rate</span>
                                                    <span class="detail-value">5% p.a.</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Opening Date</span>
                                                    <span class="detail-value">January 15, 2015</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Last Transaction</span>
                                                    <span class="detail-value">Deposit - KSh 10,000.00 (July 15, 2023)</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Interest Earned YTD</span>
                                                    <span class="detail-value">KSh 2,500.00</span>
                                                </li>
                                            </ul>
                                            
                                            <div class="row">
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-primary btn-sm w-100">Deposit</a>
                                                </div>
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Withdraw</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Statements</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Holiday Savings Account -->
                                    <div class="savings-account-card mb-4">
                                        <div class="savings-account-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <h3 class="savings-account-type">Holiday Savings Account</h3>
                                                <div class="savings-account-number">Account #: HS-2020-00089</div>
                                            </div>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                        <div class="savings-account-body">
                                            <div class="savings-account-amount">KSh 40,000.00</div>
                                            
                                            <ul class="savings-account-details">
                                                <li>
                                                    <span class="detail-label">Account Type</span>
                                                    <span class="detail-value">Holiday Savings</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Interest Rate</span>
                                                    <span class="detail-value">6% p.a.</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Opening Date</span>
                                                    <span class="detail-value">March 10, 2020</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Last Transaction</span>
                                                    <span class="detail-value">Deposit - KSh 5,000.00 (July 1, 2023)</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Interest Earned YTD</span>
                                                    <span class="detail-value">KSh 1,250.00</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Maturity Date</span>
                                                    <span class="detail-value">December 1, 2023</span>
                                                </li>
                                            </ul>
                                            
                                            <div class="row">
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-primary btn-sm w-100">Deposit</a>
                                                </div>
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Withdraw</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Statements</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Share Capital Account -->
                                    <div class="savings-account-card">
                                        <div class="savings-account-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <h3 class="savings-account-type">Share Capital Account</h3>
                                                <div class="savings-account-number">Account #: SC-2015-00125</div>
                                            </div>
                                            <span class="badge bg-success">Active</span>
                                        </div>
                                        <div class="savings-account-body">
                                            <div class="savings-account-amount">KSh 75,000.00</div>
                                            
                                            <ul class="savings-account-details">
                                                <li>
                                                    <span class="detail-label">Account Type</span>
                                                    <span class="detail-value">Share Capital</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Number of Shares</span>
                                                    <span class="detail-value">750 shares</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Share Value</span>
                                                    <span class="detail-value">KSh 100.00 per share</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Last Dividend</span>
                                                    <span class="detail-value">KSh 6,000.00 (December 31, 2022)</span>
                                                </li>
                                                <li>
                                                    <span class="detail-label">Dividend Rate</span>
                                                    <span class="detail-value">10% (2022)</span>
                                                </li>
                                            </ul>
                                            
                                            <div class="row">
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-primary btn-sm w-100">Buy Shares</a>
                                                </div>
                                                <div class="col-sm-4 mb-2 mb-sm-0">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Transfer Shares</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Statements</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Transactions -->
                            <div class="dashboard-card">
                                <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                                    <h2 class="dashboard-card-title">Recent Savings Transactions</h2>
                                    <a href="<?php echo esc_url(home_url('member-transactions')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="dashboard-card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Account</th>
                                                    <th>Description</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2023-07-15</td>
                                                    <td>Regular Savings</td>
                                                    <td>Salary Deposit</td>
                                                    <td><span class="badge bg-success">Credit</span></td>
                                                    <td>KSh 10,000.00</td>
                                                    <td>KSh 85,000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>2023-07-05</td>
                                                    <td>Regular Savings</td>
                                                    <td>Interest Earned</td>
                                                    <td><span class="badge bg-success">Credit</span></td>
                                                    <td>KSh 1,250.00</td>
                                                    <td>KSh 75,000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>2023-07-01</td>
                                                    <td>Holiday Savings</td>
                                                    <td>Monthly Deposit</td>
                                                    <td><span class="badge bg-success">Credit</span></td>
                                                    <td>KSh 5,000.00</td>
                                                    <td>KSh 40,000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>2023-06-15</td>
                                                    <td>Regular Savings</td>
                                                    <td>Salary Deposit</td>
                                                    <td><span class="badge bg-success">Credit</span></td>
                                                    <td>KSh 10,000.00</td>
                                                    <td>KSh 73,750.00</td>
                                                </tr>
                                                <tr>
                                                    <td>2023-06-10</td>
                                                    <td>Regular Savings</td>
                                                    <td>ATM Withdrawal</td>
                                                    <td><span class="badge bg-danger">Debit</span></td>
                                                    <td>KSh 5,000.00</td>
                                                    <td>KSh 63,750.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();