<?php
/**
 * Template Name: Loan Dashboard
 * Description: Member loan management dashboard
 */

// Redirect to login if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

get_header(); 

// Get current user info
$current_user = wp_get_current_user();
$member_number = get_user_meta($current_user->ID, 'member_number', true);

// Mock data for demonstration - replace with actual database queries
$member_data = array(
    'deposits' => 150000,
    'shares' => 25000,
    'loan_limit' => 450000, // 3 times deposits
    'outstanding_loans' => 120000,
    'available_credit' => 330000
);

$loan_applications = array(
    array(
        'id' => 'LA2024001',
        'type' => 'Development Loan',
        'amount' => 200000,
        'status' => 'Under Review',
        'date_applied' => '2024-01-15',
        'expected_decision' => '2024-01-22'
    ),
    array(
        'id' => 'LA2024002',
        'type' => 'School Fees Loan',
        'amount' => 50000,
        'status' => 'Approved',
        'date_applied' => '2024-01-10',
        'disbursement_date' => '2024-01-18'
    )
);

$active_loans = array(
    array(
        'id' => 'LN2023045',
        'type' => 'Development Loan',
        'original_amount' => 300000,
        'outstanding_balance' => 120000,
        'monthly_payment' => 15000,
        'next_payment_date' => '2024-02-01',
        'remaining_months' => 8,
        'interest_rate' => 12
    )
);

$payment_history = array(
    array(
        'date' => '2024-01-01',
        'amount' => 15000,
        'principal' => 13800,
        'interest' => 1200,
        'balance' => 135000
    ),
    array(
        'date' => '2023-12-01',
        'amount' => 15000,
        'principal' => 13650,
        'interest' => 1350,
        'balance' => 148650
    )
);
?>

<div class="loan-dashboard-page">
    <!-- Dashboard Header -->
    <section class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-content">
                        <div class="user-welcome">
                            <h1>Welcome back, <?php echo esc_html($current_user->display_name); ?>!</h1>
                            <p class="member-info">Member #<?php echo esc_html($member_number ?: 'N/A'); ?> | Loan Dashboard</p>
                        </div>
                        <div class="quick-actions">
                            <a href="<?php echo home_url('/loan-application-enhanced'); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Apply for Loan
                            </a>
                            <a href="<?php echo home_url('/credit-policy'); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-book"></i> Credit Policy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Financial Overview -->
    <section class="financial-overview">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-title">Financial Overview</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="overview-card deposits">
                        <div class="card-icon">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <div class="card-content">
                            <h3>Total Deposits</h3>
                            <p class="amount">KSh <?php echo number_format($member_data['deposits']); ?></p>
                            <small class="growth">+5.2% this month</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="overview-card shares">
                        <div class="card-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="card-content">
                            <h3>Share Capital</h3>
                            <p class="amount">KSh <?php echo number_format($member_data['shares']); ?></p>
                            <small class="shares-count">125 shares @ KSh 200</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="overview-card credit-limit">
                        <div class="card-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="card-content">
                            <h3>Loan Limit</h3>
                            <p class="amount">KSh <?php echo number_format($member_data['loan_limit']); ?></p>
                            <small class="calculation">3x your deposits</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="overview-card available-credit">
                        <div class="card-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="card-content">
                            <h3>Available Credit</h3>
                            <p class="amount">KSh <?php echo number_format($member_data['available_credit']); ?></p>
                            <small class="utilization"><?php echo round(($member_data['outstanding_loans'] / $member_data['loan_limit']) * 100, 1); ?>% utilized</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Content -->
    <section class="dashboard-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Loan Applications -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h3>Recent Loan Applications</h3>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="applications-list">
                            <?php foreach ($loan_applications as $application): ?>
                            <div class="application-item">
                                <div class="application-info">
                                    <div class="application-header">
                                        <h4><?php echo esc_html($application['type']); ?></h4>
                                        <span class="status status-<?php echo strtolower(str_replace(' ', '-', $application['status'])); ?>">
                                            <?php echo esc_html($application['status']); ?>
                                        </span>
                                    </div>
                                    <div class="application-details">
                                        <p><strong>Application ID:</strong> <?php echo esc_html($application['id']); ?></p>
                                        <p><strong>Amount:</strong> KSh <?php echo number_format($application['amount']); ?></p>
                                        <p><strong>Date Applied:</strong> <?php echo date('M j, Y', strtotime($application['date_applied'])); ?></p>
                                        <?php if (isset($application['expected_decision'])): ?>
                                        <p><strong>Expected Decision:</strong> <?php echo date('M j, Y', strtotime($application['expected_decision'])); ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($application['disbursement_date'])): ?>
                                        <p><strong>Disbursement Date:</strong> <?php echo date('M j, Y', strtotime($application['disbursement_date'])); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="application-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewApplication('<?php echo $application['id']; ?>')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <?php if ($application['status'] === 'Under Review'): ?>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="editApplication('<?php echo $application['id']; ?>')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Active Loans -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h3>Active Loans</h3>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="loans-list">
                            <?php foreach ($active_loans as $loan): ?>
                            <div class="loan-item">
                                <div class="loan-header">
                                    <h4><?php echo esc_html($loan['type']); ?></h4>
                                    <span class="loan-id"><?php echo esc_html($loan['id']); ?></span>
                                </div>
                                <div class="loan-progress">
                                    <div class="progress-info">
                                        <span>Outstanding Balance</span>
                                        <span>KSh <?php echo number_format($loan['outstanding_balance']); ?></span>
                                    </div>
                                    <div class="progress-bar">
                                        <?php 
                                        $progress = (($loan['original_amount'] - $loan['outstanding_balance']) / $loan['original_amount']) * 100;
                                        ?>
                                        <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                                    </div>
                                    <div class="progress-details">
                                        <small><?php echo round($progress, 1); ?>% paid (KSh <?php echo number_format($loan['original_amount'] - $loan['outstanding_balance']); ?> of KSh <?php echo number_format($loan['original_amount']); ?>)</small>
                                    </div>
                                </div>
                                <div class="loan-details">
                                    <div class="detail-item">
                                        <span class="label">Monthly Payment:</span>
                                        <span class="value">KSh <?php echo number_format($loan['monthly_payment']); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">Next Payment:</span>
                                        <span class="value"><?php echo date('M j, Y', strtotime($loan['next_payment_date'])); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">Remaining Months:</span>
                                        <span class="value"><?php echo $loan['remaining_months']; ?> months</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="label">Interest Rate:</span>
                                        <span class="value"><?php echo $loan['interest_rate']; ?>% p.a.</span>
                                    </div>
                                </div>
                                <div class="loan-actions">
                                    <button class="btn btn-sm btn-primary" onclick="makePayment('<?php echo $loan['id']; ?>')">
                                        <i class="fas fa-credit-card"></i> Make Payment
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewLoanDetails('<?php echo $loan['id']; ?>')">
                                        <i class="fas fa-chart-line"></i> View Details
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h3>Recent Payment History</h3>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="payment-history-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payment_history as $payment): ?>
                                    <tr>
                                        <td><?php echo date('M j, Y', strtotime($payment['date'])); ?></td>
                                        <td>KSh <?php echo number_format($payment['amount']); ?></td>
                                        <td>KSh <?php echo number_format($payment['principal']); ?></td>
                                        <td>KSh <?php echo number_format($payment['interest']); ?></td>
                                        <td>KSh <?php echo number_format($payment['balance']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Quick Calculator -->
                    <div class="sidebar-widget">
                        <h3>Loan Calculator</h3>
                        <div class="calculator-widget">
                            <div class="calc-group">
                                <label for="calc_amount">Loan Amount (KSh)</label>
                                <input type="number" id="calc_amount" min="1000" value="100000">
                            </div>
                            <div class="calc-group">
                                <label for="calc_period">Period (months)</label>
                                <input type="number" id="calc_period" min="1" max="48" value="12">
                            </div>
                            <div class="calc-group">
                                <label for="calc_rate">Interest Rate (%)</label>
                                <input type="number" id="calc_rate" step="0.1" value="12" readonly>
                            </div>
                            <button type="button" id="calculate-loan" class="btn btn-primary btn-block">Calculate</button>
                            <div id="calculation-result" class="calc-result"></div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="sidebar-widget">
                        <h3>Notifications</h3>
                        <div class="notifications-list">
                            <div class="notification-item unread">
                                <div class="notification-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="notification-content">
                                    <p><strong>Loan Approved!</strong></p>
                                    <p>Your school fees loan application has been approved.</p>
                                    <small>2 hours ago</small>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                </div>
                                <div class="notification-content">
                                    <p><strong>Payment Due</strong></p>
                                    <p>Your loan payment of KSh 15,000 is due on Feb 1, 2024.</p>
                                    <small>1 day ago</small>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-info-circle text-info"></i>
                                </div>
                                <div class="notification-content">
                                    <p><strong>Policy Update</strong></p>
                                    <p>New credit policy updates are now available.</p>
                                    <small>3 days ago</small>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-block">View All Notifications</a>
                    </div>

                    <!-- Support -->
                    <div class="sidebar-widget">
                        <h3>Need Help?</h3>
                        <div class="support-content">
                            <p>Contact our loan support team for assistance:</p>
                            <ul class="contact-list">
                                <li><i class="fas fa-phone"></i> +254 700 000 000</li>
                                <li><i class="fas fa-envelope"></i> loans@daystar.ac.ke</li>
                                <li><i class="fas fa-clock"></i> Mon-Fri: 8AM-5PM</li>
                            </ul>
                            <a href="<?php echo home_url('/contact-us'); ?>" class="btn btn-outline-primary btn-block">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make Loan Payment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="form-group">
                        <label for="payment_amount">Payment Amount (KSh)</label>
                        <input type="number" id="payment_amount" name="payment_amount" class="form-control" required>
                        <small class="form-text text-muted">Minimum payment: KSh 15,000</small>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="form-control" required>
                            <option value="">Select Payment Method</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="salary_deduction">Salary Deduction</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_reference">Reference/Transaction ID</label>
                        <input type="text" id="payment_reference" name="payment_reference" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitPayment()">Submit Payment</button>
            </div>
        </div>
    </div>
</div>

<script>
// Dashboard JavaScript
jQuery(document).ready(function($) {
    // Loan calculator
    $('#calculate-loan').click(function() {
        const amount = parseFloat($('#calc_amount').val());
        const period = parseInt($('#calc_period').val());
        const rate = parseFloat($('#calc_rate').val()) / 100 / 12; // Monthly rate
        
        if (amount && period && rate) {
            const monthlyPayment = (amount * rate * Math.pow(1 + rate, period)) / (Math.pow(1 + rate, period) - 1);
            const totalPayment = monthlyPayment * period;
            const totalInterest = totalPayment - amount;
            
            $('#calculation-result').html(`
                <div class="calc-results">
                    <h5>Calculation Results</h5>
                    <p><strong>Monthly Payment:</strong> KSh ${monthlyPayment.toLocaleString('en-KE', {maximumFractionDigits: 2})}</p>
                    <p><strong>Total Payment:</strong> KSh ${totalPayment.toLocaleString('en-KE', {maximumFractionDigits: 2})}</p>
                    <p><strong>Total Interest:</strong> KSh ${totalInterest.toLocaleString('en-KE', {maximumFractionDigits: 2})}</p>
                </div>
            `);
        }
    });
    
    // Mark notifications as read when clicked
    $('.notification-item.unread').click(function() {
        $(this).removeClass('unread');
        // AJAX call to mark as read in database
    });
});

// Application and loan management functions
function viewApplication(applicationId) {
    // Implement application viewing logic
    alert('Viewing application: ' + applicationId);
}

function editApplication(applicationId) {
    // Implement application editing logic
    alert('Editing application: ' + applicationId);
}

function viewLoanDetails(loanId) {
    // Implement loan details viewing logic
    alert('Viewing loan details: ' + loanId);
}

function makePayment(loanId) {
    // Show payment modal
    jQuery('#paymentModal').modal('show');
    jQuery('#paymentModal').data('loan-id', loanId);
}

function submitPayment() {
    const loanId = jQuery('#paymentModal').data('loan-id');
    const amount = jQuery('#payment_amount').val();
    const method = jQuery('#payment_method').val();
    const reference = jQuery('#payment_reference').val();
    
    if (!amount || !method) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Implement payment submission logic
    alert('Payment submitted for loan: ' + loanId + ', Amount: KSh ' + amount);
    jQuery('#paymentModal').modal('hide');
}
</script>

<?php get_footer(); ?>