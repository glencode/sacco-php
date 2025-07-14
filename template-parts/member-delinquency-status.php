<?php
/**
 * Template part for displaying member delinquency status
 * Can be included in member dashboard pages
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get current user
$user_id = get_current_user_id();
if (!$user_id) {
    return;
}

// Get delinquency status
$delinquency_status = daystar_get_member_delinquency_status($user_id);
?>

<div class="member-delinquency-status">
    <?php if ($delinquency_status['is_blacklisted']) : ?>
        <div class="alert alert-danger">
            <h4><i class="fas fa-ban"></i> Account Blacklisted</h4>
            <p><strong>Your account has been blacklisted.</strong></p>
            <p>Reason: <?php echo esc_html($delinquency_status['blacklist_info']->reason); ?></p>
            <p>Date: <?php echo date('F j, Y', strtotime($delinquency_status['blacklist_info']->blacklist_date)); ?></p>
            <p>Please contact the office immediately to resolve this matter.</p>
        </div>
    <?php elseif ($delinquency_status['delinquent_count'] > 0) : ?>
        <div class="alert alert-warning">
            <h4><i class="fas fa-exclamation-triangle"></i> Payment Overdue</h4>
            <p><strong>You have <?php echo $delinquency_status['delinquent_count']; ?> loan(s) with overdue payments.</strong></p>
            <p><?php echo daystar_get_delinquency_status_message($delinquency_status['worst_status'], $delinquency_status['max_days_overdue']); ?></p>
            
            <?php if ($delinquency_status['estimated_overdue_amount'] > 0) : ?>
                <p>Estimated overdue amount: <strong>KSh <?php echo number_format($delinquency_status['estimated_overdue_amount'], 2); ?></strong></p>
            <?php endif; ?>
            
            <div class="delinquent-loans-list">
                <h5>Overdue Loans:</h5>
                <ul>
                    <?php foreach ($delinquency_status['delinquent_loans'] as $loan) : ?>
                        <li>
                            <strong><?php echo esc_html($loan->loan_type); ?></strong> 
                            (ID: <?php echo $loan->id; ?>) - 
                            <?php echo $loan->days_overdue; ?> days overdue
                            <span class="status-badge <?php echo daystar_get_delinquency_status_class($loan->delinquency_status); ?>">
                                <?php echo esc_html(str_replace('_', ' ', $loan->delinquency_status)); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="action-buttons mt-3">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">Contact Office</a>
                <a href="<?php echo esc_url(home_url('/loan-dashboard')); ?>" class="btn btn-secondary">View Loan Details</a>
            </div>
        </div>
    <?php elseif ($delinquency_status['total_loans'] > 0) : ?>
        <div class="alert alert-success">
            <h4><i class="fas fa-check-circle"></i> Payments Up to Date</h4>
            <p>All your loan payments are current. Thank you for your timely payments!</p>
        </div>
    <?php endif; ?>
</div>

<style>
.member-delinquency-status {
    margin: 20px 0;
}

.member-delinquency-status .alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.delinquent-loans-list {
    margin: 15px 0;
}

.delinquent-loans-list ul {
    list-style: none;
    padding: 0;
}

.delinquent-loans-list li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.status-badge {
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
    margin-left: 10px;
}

.status-current {
    background-color: #d4edda;
    color: #155724;
}

.status-warning {
    background-color: #fff3cd;
    color: #856404;
}

.status-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.status-critical {
    background-color: #f5c6cb;
    color: #721c24;
}

.status-severe {
    background-color: #d1ecf1;
    color: #0c5460;
}

.status-blacklisted {
    background-color: #343a40;
    color: #ffffff;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.btn-primary {
    background-color: #007cba;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
    text-decoration: none;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .btn {
        text-align: center;
    }
}
</style>