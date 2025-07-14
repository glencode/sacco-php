<?php
/**
 * Template Name: Loan Appeal
 * Page for submitting loan appeals
 */

// Redirect if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

// Include loan appeals functions
require_once get_template_directory() . '/includes/loan-appeals.php';

$user_id = get_current_user_id();
$appealable_loans = daystar_get_member_appealable_loans($user_id);
$appeal_history = daystar_get_member_appeal_history($user_id);

get_header();
?>

<div class="loan-appeal-page">
    <div class="container">
        <div class="page-header">
            <h1>Loan Appeal</h1>
            <p class="page-description">
                If your loan application was declined, you may submit an appeal within 15 days of the decision. 
                Your appeal will be reviewed by a joint committee of the Executive Committee and Credit Committee.
            </p>
        </div>

        <?php if (!empty($appealable_loans)) : ?>
            <div class="appeal-submission-section">
                <h2>Submit New Appeal</h2>
                <div class="appeal-info-box">
                    <h4>Important Information:</h4>
                    <ul>
                        <li>Appeals must be submitted within <strong>15 days</strong> of loan rejection</li>
                        <li>Provide detailed reasons for your appeal</li>
                        <li>The joint committee will review your appeal within 30 days</li>
                        <li>You will be notified of the decision via your dashboard and email</li>
                    </ul>
                </div>

                <form id="loan-appeal-form" class="appeal-form">
                    <div class="form-group">
                        <label for="loan_selection">Select Loan to Appeal:</label>
                        <select id="loan_selection" name="loan_id" required>
                            <option value="">Choose a loan application...</option>
                            <?php foreach ($appealable_loans as $loan) : ?>
                                <option value="<?php echo $loan->id; ?>" 
                                        data-amount="<?php echo $loan->amount; ?>"
                                        data-type="<?php echo $loan->loan_type; ?>"
                                        data-deadline="<?php echo $loan->appeal_deadline; ?>"
                                        data-days-remaining="<?php echo $loan->days_remaining; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $loan->loan_type)); ?> - 
                                    KES <?php echo number_format($loan->amount, 2); ?> 
                                    (<?php echo $loan->days_remaining; ?> days remaining to appeal)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="loan-details" class="loan-details" style="display: none;">
                        <h4>Loan Application Details</h4>
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="label">Loan Type:</span>
                                <span id="detail-type"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Amount:</span>
                                <span id="detail-amount"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Appeal Deadline:</span>
                                <span id="detail-deadline"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Days Remaining:</span>
                                <span id="detail-days-remaining"></span>
                            </div>
                        </div>
                        <div class="rejection-reason">
                            <span class="label">Original Rejection Reason:</span>
                            <div id="rejection-reason-text"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason_for_appeal">Reason for Appeal: <span class="required">*</span></label>
                        <textarea id="reason_for_appeal" name="reason_for_appeal" rows="8" required
                                  placeholder="Please provide detailed reasons why you believe the loan decision should be reconsidered. Include any new information, changed circumstances, or clarifications that support your appeal."></textarea>
                        <div class="character-count">
                            <span id="char-count">0</span> / 2000 characters
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="supporting_documents">Supporting Documents (Optional):</label>
                        <input type="file" id="supporting_documents" name="supporting_documents[]" 
                               multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="help-text">
                            Upload any supporting documents (payslips, bank statements, etc.) that support your appeal. 
                            Maximum 5 files, 2MB each.
                        </small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Appeal</button>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="no-appealable-loans">
                <div class="info-box">
                    <h3>No Appealable Loans</h3>
                    <p>You currently have no rejected loan applications that are eligible for appeal.</p>
                    <p>Appeals can only be submitted for:</p>
                    <ul>
                        <li>Rejected loan applications</li>
                        <li>Within 15 days of the rejection decision</li>
                        <li>Applications that haven't been appealed before</li>
                    </ul>
                    <a href="<?php echo home_url('/loan-application-consolidated'); ?>" class="btn btn-primary">
                        Apply for New Loan
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($appeal_history)) : ?>
            <div class="appeal-history-section">
                <h2>Your Appeal History</h2>
                <div class="appeals-table-container">
                    <table class="appeals-table">
                        <thead>
                            <tr>
                                <th>Appeal Date</th>
                                <th>Loan Details</th>
                                <th>Status</th>
                                <th>Resolution</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appeal_history as $appeal) : ?>
                                <tr>
                                    <td>
                                        <?php echo date('M j, Y', strtotime($appeal->appeal_date)); ?>
                                        <br><small><?php echo date('g:i A', strtotime($appeal->appeal_date)); ?></small>
                                    </td>
                                    <td>
                                        <strong><?php echo ucfirst(str_replace('_', ' ', $appeal->loan_type)); ?></strong>
                                        <br>KES <?php echo number_format($appeal->amount, 2); ?>
                                        <br><small><?php echo esc_html($appeal->purpose); ?></small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $appeal->status; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $appeal->status)); ?>
                                        </span>
                                        <?php if ($appeal->committee_hearing_date) : ?>
                                            <br><small>Hearing: <?php echo date('M j, Y', strtotime($appeal->committee_hearing_date)); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($appeal->resolution_details) : ?>
                                            <div class="resolution-text">
                                                <?php echo esc_html($appeal->resolution_details); ?>
                                            </div>
                                            <?php if ($appeal->resolved_date) : ?>
                                                <small>Resolved: <?php echo date('M j, Y', strtotime($appeal->resolved_date)); ?></small>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <em>Pending resolution</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-small" 
                                                onclick="viewAppealDetails(<?php echo $appeal->id; ?>)">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Appeal Details Modal -->
<div id="appeal-details-modal" class="modal" style="display: none;">
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Appeal Details</h3>
                <button type="button" class="modal-close" onclick="closeAppealModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="appeal-details-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAppealModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.loan-appeal-page {
    padding: 40px 0;
    background: #f8fafc;
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #1d4ed8;
    margin-bottom: 15px;
}

.page-description {
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.appeal-submission-section,
.appeal-history-section {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.appeal-submission-section h2,
.appeal-history-section h2 {
    color: #1d4ed8;
    margin-bottom: 20px;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}

.appeal-info-box {
    background: #dbeafe;
    border: 1px solid #3b82f6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
}

.appeal-info-box h4 {
    color: #1e40af;
    margin: 0 0 15px 0;
}

.appeal-info-box ul {
    margin: 0;
    padding-left: 20px;
}

.appeal-info-box li {
    margin-bottom: 8px;
    color: #1e40af;
}

.appeal-form .form-group {
    margin-bottom: 25px;
}

.appeal-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #374151;
}

.required {
    color: #dc2626;
}

.appeal-form select,
.appeal-form textarea,
.appeal-form input[type="file"] {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.appeal-form select:focus,
.appeal-form textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.loan-details {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin: 15px 0;
}

.loan-details h4 {
    margin: 0 0 15px 0;
    color: #1d4ed8;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item .label {
    font-weight: bold;
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.rejection-reason {
    border-top: 1px solid #e5e7eb;
    padding-top: 15px;
}

.rejection-reason .label {
    font-weight: bold;
    color: #6b7280;
    margin-bottom: 10px;
    display: block;
}

.character-count {
    text-align: right;
    font-size: 0.9rem;
    color: #6b7280;
    margin-top: 5px;
}

.help-text {
    color: #6b7280;
    font-size: 0.9rem;
    margin-top: 5px;
    display: block;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: #1d4ed8;
    color: white;
}

.btn-primary:hover {
    background: #1e40af;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-small {
    padding: 8px 16px;
    font-size: 0.9rem;
}

.no-appealable-loans {
    text-align: center;
    padding: 60px 20px;
}

.info-box {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
}

.info-box h3 {
    color: #1d4ed8;
    margin-bottom: 20px;
}

.info-box ul {
    text-align: left;
    margin: 20px 0;
}

.appeals-table-container {
    overflow-x: auto;
}

.appeals-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.appeals-table th,
.appeals-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: top;
}

.appeals-table th {
    background: #f9fafb;
    font-weight: bold;
    color: #374151;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-under_review {
    background: #dbeafe;
    color: #1e40af;
}

.status-approved {
    background: #d1fae5;
    color: #065f46;
}

.status-rejected {
    background: #fef2f2;
    color: #dc2626;
}

.resolution-text {
    max-width: 300px;
    line-height: 1.4;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 12px;
    max-width: 800px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 20px 30px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #1d4ed8;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #6b7280;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid #e5e7eb;
    text-align: right;
}

@media (max-width: 768px) {
    .loan-appeal-page {
        padding: 20px 0;
    }
    
    .appeal-submission-section,
    .appeal-history-section {
        padding: 20px;
        margin: 0 10px 20px;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .appeals-table {
        font-size: 0.9rem;
    }
    
    .appeals-table th,
    .appeals-table td {
        padding: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loanSelection = document.getElementById('loan_selection');
    const loanDetails = document.getElementById('loan-details');
    const reasonTextarea = document.getElementById('reason_for_appeal');
    const charCount = document.getElementById('char-count');
    const appealForm = document.getElementById('loan-appeal-form');

    // Handle loan selection change
    loanSelection.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            // Show loan details
            document.getElementById('detail-type').textContent = selectedOption.dataset.type.replace('_', ' ').toUpperCase();
            document.getElementById('detail-amount').textContent = 'KES ' + parseFloat(selectedOption.dataset.amount).toLocaleString();
            document.getElementById('detail-deadline').textContent = new Date(selectedOption.dataset.deadline).toLocaleDateString();
            document.getElementById('detail-days-remaining').textContent = selectedOption.dataset.daysRemaining + ' days';
            
            loanDetails.style.display = 'block';
            
            // Load rejection reason via AJAX
            loadRejectionReason(selectedOption.value);
        } else {
            loanDetails.style.display = 'none';
        }
    });

    // Character count for textarea
    reasonTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count;
        
        if (count > 2000) {
            charCount.style.color = '#dc2626';
            this.value = this.value.substring(0, 2000);
            charCount.textContent = '2000';
        } else {
            charCount.style.color = '#6b7280';
        }
    });

    // Handle form submission
    appealForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('action', 'submit_loan_appeal');
        formData.append('loan_id', loanSelection.value);
        formData.append('reason_for_appeal', reasonTextarea.value);
        formData.append('nonce', '<?php echo wp_create_nonce('submit_loan_appeal'); ?>');
        
        // Disable submit button
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Appeal submitted successfully! You will be notified of the outcome.');
                location.reload();
            } else {
                alert('Error: ' + data.data);
            }
        })
        .catch(error => {
            alert('Error submitting appeal: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
});

function loadRejectionReason(loanId) {
    // This would load the rejection reason via AJAX
    // For now, show a placeholder
    document.getElementById('rejection-reason-text').innerHTML = '<em>Loading rejection reason...</em>';
    
    // AJAX call to get rejection reason
    const formData = new FormData();
    formData.append('action', 'get_loan_rejection_reason');
    formData.append('loan_id', loanId);
    formData.append('nonce', '<?php echo wp_create_nonce('get_loan_rejection_reason'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('rejection-reason-text').textContent = data.data || 'No specific reason provided.';
        } else {
            document.getElementById('rejection-reason-text').innerHTML = '<em>Unable to load rejection reason.</em>';
        }
    })
    .catch(error => {
        document.getElementById('rejection-reason-text').innerHTML = '<em>Error loading rejection reason.</em>';
    });
}

function viewAppealDetails(appealId) {
    // Show appeal details in modal
    document.getElementById('appeal-details-modal').style.display = 'block';
    document.getElementById('appeal-details-content').innerHTML = '<div style="text-align: center; padding: 40px;">Loading appeal details...</div>';
    
    // Load appeal details via AJAX
    const formData = new FormData();
    formData.append('action', 'get_appeal_details');
    formData.append('appeal_id', appealId);
    formData.append('nonce', '<?php echo wp_create_nonce('get_appeal_details'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('appeal-details-content').innerHTML = data.data;
        } else {
            document.getElementById('appeal-details-content').innerHTML = '<div style="text-align: center; color: #dc2626;">Error loading appeal details.</div>';
        }
    })
    .catch(error => {
        document.getElementById('appeal-details-content').innerHTML = '<div style="text-align: center; color: #dc2626;">Error: ' + error.message + '</div>';
    });
}

function closeAppealModal() {
    document.getElementById('appeal-details-modal').style.display = 'none';
}

// Close modal when clicking overlay
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeAppealModal();
    }
});
</script>

<?php get_footer(); ?>