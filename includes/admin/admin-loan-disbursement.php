<?php
/**
 * Admin Loan Disbursement Interface
 * 
 * Provides admin interface for managing loan disbursements including:
 * - Viewing approved loans ready for disbursement
 * - Initiating disbursements via different methods
 * - Uploading payment evidence
 * - Recording digital confirmations
 * - Tracking disbursement status
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/loan-disbursement.php';

/**
 * Admin Loan Disbursement Page
 */
function daystar_admin_loan_disbursement_page() {
    global $wpdb;
    
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'initiate_disbursement':
                    handle_initiate_disbursement();
                    break;
                case 'upload_evidence':
                    handle_upload_evidence();
                    break;
                case 'confirm_receipt':
                    handle_confirm_receipt();
                    break;
            }
        }
    }
    
    // Get current view
    $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'pending';
    $loan_id = isset($_GET['loan_id']) ? intval($_GET['loan_id']) : 0;
    
    ?>
    <div class="wrap">
        <h1>Loan Disbursement Management</h1>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
        
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-admin-disbursement&view=pending" 
               class="nav-tab <?php echo $view === 'pending' ? 'nav-tab-active' : ''; ?>">
                Pending Disbursement
            </a>
            <a href="?page=daystar-admin-disbursement&view=disbursed" 
               class="nav-tab <?php echo $view === 'disbursed' ? 'nav-tab-active' : ''; ?>">
                Disbursed Loans
            </a>
            <a href="?page=daystar-admin-disbursement&view=reports" 
               class="nav-tab <?php echo $view === 'reports' ? 'nav-tab-active' : ''; ?>">
                Disbursement Reports
            </a>
        </nav>
        
        <div class="tab-content">
            <?php
            switch ($view) {
                case 'pending':
                    display_pending_disbursements();
                    break;
                case 'disbursed':
                    display_disbursed_loans();
                    break;
                case 'reports':
                    display_disbursement_reports();
                    break;
                case 'disbursement_details':
                    if ($loan_id) {
                        display_disbursement_details($loan_id);
                    }
                    break;
                default:
                    display_pending_disbursements();
            }
            ?>
        </div>
    </div>
    
    <style>
    .disbursement-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .disbursement-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .disbursement-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-label {
        font-weight: bold;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    
    .detail-value {
        font-size: 14px;
        color: #333;
    }
    
    .disbursement-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-approved { background: #d4edda; color: #155724; }
    .status-disbursed { background: #cce5ff; color: #004085; }
    .status-pending { background: #fff3cd; color: #856404; }
    
    .disbursement-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-top: 20px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .evidence-upload {
        border: 2px dashed #ddd;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        margin: 15px 0;
    }
    
    .evidence-upload.dragover {
        border-color: #007cba;
        background: #f0f8ff;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Handle disbursement method change
        $('.disbursement-method').on('change', function() {
            var method = $(this).val();
            var container = $(this).closest('.disbursement-form');
            
            container.find('.method-specific').hide();
            container.find('.method-' + method).show();
        });
        
        // Handle file upload
        $('.evidence-upload').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        }).on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        }).on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            
            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                $(this).find('input[type="file"]')[0].files = files;
                $(this).find('.upload-text').text('File selected: ' + files[0].name);
            }
        });
        
        // Handle evidence file selection
        $('input[type="file"]').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).closest('.evidence-upload').find('.upload-text').text('File selected: ' + fileName);
        });
        
        // Auto-refresh M-Pesa status
        $('.mpesa-status-check').each(function() {
            var button = $(this);
            var transactionId = button.data('transaction-id');
            
            if (transactionId) {
                setInterval(function() {
                    checkMpesaStatus(transactionId, button);
                }, 30000); // Check every 30 seconds
            }
        });
        
        function checkMpesaStatus(transactionId, button) {
            $.post(ajaxurl, {
                action: 'check_mpesa_disbursement_status',
                transaction_id: transactionId,
                nonce: '<?php echo wp_create_nonce('loan_disbursement_nonce'); ?>'
            }, function(response) {
                if (response.success && response.status === 'completed') {
                    button.closest('.status-indicator').html('<span class="status-badge status-disbursed">Completed</span>');
                    location.reload();
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Display pending disbursements
 */
function display_pending_disbursements() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    $pending_loans = $wpdb->get_results("
        SELECT l.*, u.display_name, u.user_email,
               um1.meta_value as member_number,
               um2.meta_value as phone_number,
               um3.meta_value as bank_name,
               um4.meta_value as bank_account_number
        FROM $loans_table l
        LEFT JOIN {$wpdb->users} u ON l.user_id = u.ID
        LEFT JOIN {$wpdb->usermeta} um1 ON (l.user_id = um1.user_id AND um1.meta_key = 'member_number')
        LEFT JOIN {$wpdb->usermeta} um2 ON (l.user_id = um2.user_id AND um2.meta_key = 'phone_number')
        LEFT JOIN {$wpdb->usermeta} um3 ON (l.user_id = um3.user_id AND um3.meta_key = 'bank_name')
        LEFT JOIN {$wpdb->usermeta} um4 ON (l.user_id = um4.user_id AND um4.meta_key = 'bank_account_number')
        WHERE l.status = 'approved' AND l.disbursed_date IS NULL
        ORDER BY l.approved_date ASC
    ");
    
    if (empty($pending_loans)) {
        echo '<div class="notice notice-info"><p>No loans pending disbursement.</p></div>';
        return;
    }
    
    foreach ($pending_loans as $loan) {
        display_loan_disbursement_card($loan);
    }
}

/**
 * Display disbursed loans
 */
function display_disbursed_loans() {
    global $wpdb;
    
    $loans_table = $wpdb->prefix . 'daystar_loans';
    $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
    
    $disbursed_loans = $wpdb->get_results("
        SELECT l.*, u.display_name, u.user_email,
               um1.meta_value as member_number,
               d.disbursement_method, d.disbursement_reference, d.status as disbursement_status,
               d.evidence_path, d.recipient_confirmation
        FROM $loans_table l
        LEFT JOIN {$wpdb->users} u ON l.user_id = u.ID
        LEFT JOIN {$wpdb->usermeta} um1 ON (l.user_id = um1.user_id AND um1.meta_key = 'member_number')
        LEFT JOIN $disbursements_table d ON l.id = d.loan_id
        WHERE l.status = 'disbursed' AND l.disbursed_date IS NOT NULL
        ORDER BY l.disbursed_date DESC
        LIMIT 50
    ");
    
    if (empty($disbursed_loans)) {
        echo '<div class="notice notice-info"><p>No disbursed loans found.</p></div>';
        return;
    }
    
    ?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Member</th>
                <th>Amount</th>
                <th>Disbursement Method</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disbursed_loans as $loan): ?>
            <tr>
                <td>LOAN-<?php echo str_pad($loan->id, 6, '0', STR_PAD_LEFT); ?></td>
                <td>
                    <?php echo esc_html($loan->display_name); ?><br>
                    <small><?php echo esc_html($loan->member_number); ?></small>
                </td>
                <td>KES <?php echo number_format($loan->amount, 2); ?></td>
                <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $loan->disbursement_method))); ?></td>
                <td><?php echo esc_html($loan->disbursement_reference); ?></td>
                <td><?php echo date('M j, Y', strtotime($loan->disbursed_date)); ?></td>
                <td>
                    <span class="status-badge status-<?php echo esc_attr($loan->disbursement_status); ?>">
                        <?php echo esc_html(ucfirst($loan->disbursement_status)); ?>
                    </span>
                    <?php if ($loan->recipient_confirmation): ?>
                        <br><small style="color: green;">✓ Confirmed</small>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?page=daystar-admin-disbursement&view=disbursement_details&loan_id=<?php echo $loan->id; ?>" 
                       class="button button-small">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

/**
 * Display loan disbursement card
 */
function display_loan_disbursement_card($loan) {
    ?>
    <div class="disbursement-card">
        <div class="disbursement-header">
            <div>
                <h3>LOAN-<?php echo str_pad($loan->id, 6, '0', STR_PAD_LEFT); ?></h3>
                <span class="status-badge status-approved">Ready for Disbursement</span>
            </div>
            <div>
                <strong>KES <?php echo number_format($loan->amount, 2); ?></strong>
            </div>
        </div>
        
        <div class="disbursement-details">
            <div class="detail-item">
                <span class="detail-label">Member</span>
                <span class="detail-value"><?php echo esc_html($loan->display_name); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Member Number</span>
                <span class="detail-value"><?php echo esc_html($loan->member_number); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Loan Type</span>
                <span class="detail-value"><?php echo esc_html($loan->loan_type); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Term</span>
                <span class="detail-value"><?php echo $loan->term_months; ?> months</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Monthly Payment</span>
                <span class="detail-value">KES <?php echo number_format($loan->monthly_payment, 2); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Approved Date</span>
                <span class="detail-value"><?php echo date('M j, Y', strtotime($loan->approved_date)); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone</span>
                <span class="detail-value"><?php echo esc_html($loan->phone_number ?: 'Not provided'); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Bank Account</span>
                <span class="detail-value">
                    <?php if ($loan->bank_name && $loan->bank_account_number): ?>
                        <?php echo esc_html($loan->bank_name); ?><br>
                        <?php echo esc_html($loan->bank_account_number); ?>
                    <?php else: ?>
                        Not provided
                    <?php endif; ?>
                </span>
            </div>
        </div>
        
        <div class="disbursement-form">
            <h4>Initiate Disbursement</h4>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('loan_disbursement_nonce'); ?>
                <input type="hidden" name="action" value="initiate_disbursement">
                <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>">
                
                <div class="form-row">
                    <div>
                        <label for="disbursement_method_<?php echo $loan->id; ?>">Disbursement Method</label>
                        <select name="disbursement_method" id="disbursement_method_<?php echo $loan->id; ?>" 
                                class="disbursement-method" required>
                            <option value="">Select Method</option>
                            <?php if ($loan->phone_number): ?>
                                <option value="mpesa">M-Pesa</option>
                            <?php endif; ?>
                            <?php if ($loan->bank_name && $loan->bank_account_number): ?>
                                <option value="bank_transfer">Bank Transfer</option>
                            <?php endif; ?>
                            <option value="cash">Cash Collection</option>
                        </select>
                    </div>
                    <div>
                        <label for="disbursement_notes_<?php echo $loan->id; ?>">Notes (Optional)</label>
                        <input type="text" name="disbursement_notes" id="disbursement_notes_<?php echo $loan->id; ?>" 
                               placeholder="Additional notes">
                    </div>
                </div>
                
                <!-- M-Pesa specific fields -->
                <div class="method-specific method-mpesa" style="display: none;">
                    <div class="form-row">
                        <div>
                            <label>M-Pesa Number</label>
                            <input type="text" name="mpesa_number" value="<?php echo esc_attr($loan->phone_number); ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <!-- Bank Transfer specific fields -->
                <div class="method-specific method-bank_transfer" style="display: none;">
                    <div class="form-row">
                        <div>
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" value="<?php echo esc_attr($loan->bank_name); ?>" readonly>
                        </div>
                        <div>
                            <label>Account Number</label>
                            <input type="text" name="account_number" value="<?php echo esc_attr($loan->bank_account_number); ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <!-- Cash specific fields -->
                <div class="method-specific method-cash" style="display: none;">
                    <div class="form-row">
                        <div>
                            <label for="collection_location_<?php echo $loan->id; ?>">Collection Location</label>
                            <select name="collection_location" id="collection_location_<?php echo $loan->id; ?>">
                                <option value="main_office">Main Office</option>
                                <option value="branch_office">Branch Office</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="disbursement-actions">
                    <button type="submit" class="button button-primary">Initiate Disbursement</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Display disbursement details
 */
function display_disbursement_details($loan_id) {
    global $wpdb;
    
    $loan = $wpdb->get_row($wpdb->prepare("
        SELECT l.*, u.display_name, u.user_email,
               um1.meta_value as member_number
        FROM {$wpdb->prefix}daystar_loans l
        LEFT JOIN {$wpdb->users} u ON l.user_id = u.ID
        LEFT JOIN {$wpdb->usermeta} um1 ON (l.user_id = um1.user_id AND um1.meta_key = 'member_number')
        WHERE l.id = %d
    ", $loan_id));
    
    if (!$loan) {
        echo '<div class="notice notice-error"><p>Loan not found.</p></div>';
        return;
    }
    
    $disbursement = get_loan_disbursement_details($loan_id);
    
    ?>
    <div class="disbursement-card">
        <div class="disbursement-header">
            <div>
                <h3>Disbursement Details - LOAN-<?php echo str_pad($loan->id, 6, '0', STR_PAD_LEFT); ?></h3>
                <a href="?page=daystar-admin-disbursement&view=disbursed" class="button">← Back to List</a>
            </div>
        </div>
        
        <div class="disbursement-details">
            <div class="detail-item">
                <span class="detail-label">Member</span>
                <span class="detail-value"><?php echo esc_html($loan->display_name); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Amount</span>
                <span class="detail-value">KES <?php echo number_format($loan->amount, 2); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Disbursement Date</span>
                <span class="detail-value"><?php echo date('M j, Y g:i A', strtotime($loan->disbursed_date)); ?></span>
            </div>
            <?php if ($disbursement): ?>
                <div class="detail-item">
                    <span class="detail-label">Method</span>
                    <span class="detail-value"><?php echo esc_html(ucfirst(str_replace('_', ' ', $disbursement->disbursement_method))); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Reference</span>
                    <span class="detail-value"><?php echo esc_html($disbursement->disbursement_reference); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        <span class="status-badge status-<?php echo esc_attr($disbursement->status); ?>">
                            <?php echo esc_html(ucfirst($disbursement->status)); ?>
                        </span>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($disbursement && !$disbursement->evidence_path): ?>
        <div class="disbursement-form">
            <h4>Upload Payment Evidence</h4>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('loan_disbursement_nonce'); ?>
                <input type="hidden" name="action" value="upload_evidence">
                <input type="hidden" name="loan_id" value="<?php echo $loan_id; ?>">
                
                <div class="evidence-upload">
                    <input type="file" name="evidence_file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required>
                    <p class="upload-text">Drag and drop file here or click to select</p>
                    <small>Supported formats: JPG, PNG, PDF, DOC, DOCX (Max 5MB)</small>
                </div>
                
                <button type="submit" class="button button-primary">Upload Evidence</button>
            </form>
        </div>
        <?php endif; ?>
        
        <?php if ($disbursement && $disbursement->evidence_path && !$disbursement->recipient_confirmation): ?>
        <div class="disbursement-form">
            <h4>Confirm Receipt</h4>
            <form method="post">
                <?php wp_nonce_field('loan_disbursement_nonce'); ?>
                <input type="hidden" name="action" value="confirm_receipt">
                <input type="hidden" name="loan_id" value="<?php echo $loan_id; ?>">
                
                <div class="form-row">
                    <div>
                        <label for="confirmation_type">Confirmation Type</label>
                        <select name="confirmation_type" id="confirmation_type" required>
                            <option value="digital_acknowledgment">Digital Acknowledgment</option>
                            <option value="phone_confirmation">Phone Confirmation</option>
                            <option value="in_person_confirmation">In-Person Confirmation</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div>
                        <label for="confirmation_details">Confirmation Details</label>
                        <textarea name="confirmation_details" id="confirmation_details" rows="3" 
                                  placeholder="Enter confirmation details..."></textarea>
                    </div>
                </div>
                
                <button type="submit" class="button button-primary">Confirm Receipt</button>
            </form>
        </div>
        <?php endif; ?>
        
        <?php if ($disbursement && $disbursement->evidence_path): ?>
        <div class="disbursement-form">
            <h4>Payment Evidence</h4>
            <p><a href="<?php echo wp_upload_dir()['baseurl'] . '/' . $disbursement->evidence_path; ?>" 
                  target="_blank" class="button">View Evidence File</a></p>
        </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Display disbursement reports
 */
function display_disbursement_reports() {
    global $wpdb;
    
    $disbursements_table = $wpdb->prefix . 'daystar_loan_disbursements';
    $loans_table = $wpdb->prefix . 'daystar_loans';
    
    // Get summary statistics
    $stats = $wpdb->get_row("
        SELECT 
            COUNT(*) as total_disbursements,
            SUM(l.amount) as total_amount,
            COUNT(CASE WHEN d.status = 'completed' THEN 1 END) as completed_disbursements,
            COUNT(CASE WHEN d.status = 'pending' THEN 1 END) as pending_disbursements
        FROM $disbursements_table d
        LEFT JOIN $loans_table l ON d.loan_id = l.id
        WHERE d.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    
    ?>
    <div class="disbursement-card">
        <h3>Disbursement Summary (Last 30 Days)</h3>
        <div class="disbursement-details">
            <div class="detail-item">
                <span class="detail-label">Total Disbursements</span>
                <span class="detail-value"><?php echo number_format($stats->total_disbursements); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Amount</span>
                <span class="detail-value">KES <?php echo number_format($stats->total_amount, 2); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Completed</span>
                <span class="detail-value"><?php echo number_format($stats->completed_disbursements); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Pending</span>
                <span class="detail-value"><?php echo number_format($stats->pending_disbursements); ?></span>
            </div>
        </div>
    </div>
    
    <?php
    // Get disbursement method breakdown
    $method_stats = $wpdb->get_results("
        SELECT 
            d.disbursement_method,
            COUNT(*) as count,
            SUM(l.amount) as total_amount
        FROM $disbursements_table d
        LEFT JOIN $loans_table l ON d.loan_id = l.id
        WHERE d.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY d.disbursement_method
        ORDER BY count DESC
    ");
    
    if ($method_stats): ?>
    <div class="disbursement-card">
        <h3>Disbursement Methods Breakdown</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Count</th>
                    <th>Total Amount</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($method_stats as $stat): ?>
                <tr>
                    <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $stat->disbursement_method))); ?></td>
                    <td><?php echo number_format($stat->count); ?></td>
                    <td>KES <?php echo number_format($stat->total_amount, 2); ?></td>
                    <td><?php echo round(($stat->count / $stats->total_disbursements) * 100, 1); ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif;
}

/**
 * Handle initiate disbursement form submission
 */
function handle_initiate_disbursement() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'loan_disbursement_nonce')) {
        wp_die('Security check failed');
    }
    
    $loan_id = intval($_POST['loan_id']);
    $method = sanitize_text_field($_POST['disbursement_method']);
    $notes = sanitize_textarea_field($_POST['disbursement_notes']);
    
    $details = array();
    if (isset($_POST['collection_location'])) {
        $details['collection_location'] = sanitize_text_field($_POST['collection_location']);
    }
    if ($notes) {
        $details['notes'] = $notes;
    }
    
    $result = LoanDisbursementHandler::initiate_disbursement($loan_id, $method, $details);
    
    if ($result['success']) {
        wp_redirect(add_query_arg('message', urlencode($result['message']), $_SERVER['REQUEST_URI']));
    } else {
        wp_redirect(add_query_arg('error', urlencode($result['message']), $_SERVER['REQUEST_URI']));
    }
    exit;
}

/**
 * Handle upload evidence form submission
 */
function handle_upload_evidence() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'loan_disbursement_nonce')) {
        wp_die('Security check failed');
    }
    
    $loan_id = intval($_POST['loan_id']);
    
    if (!isset($_FILES['evidence_file'])) {
        wp_redirect(add_query_arg('error', 'No file uploaded', $_SERVER['REQUEST_URI']));
        exit;
    }
    
    $result = LoanDisbursementHandler::upload_disbursement_evidence($loan_id, $_FILES['evidence_file']);
    
    if ($result['success']) {
        wp_redirect(add_query_arg('message', urlencode($result['message']), $_SERVER['REQUEST_URI']));
    } else {
        wp_redirect(add_query_arg('error', urlencode($result['message']), $_SERVER['REQUEST_URI']));
    }
    exit;
}

/**
 * Handle confirm receipt form submission
 */
function handle_confirm_receipt() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'loan_disbursement_nonce')) {
        wp_die('Security check failed');
    }
    
    $loan_id = intval($_POST['loan_id']);
    $confirmation_data = array(
        'type' => sanitize_text_field($_POST['confirmation_type']),
        'details' => sanitize_textarea_field($_POST['confirmation_details'])
    );
    
    $result = LoanDisbursementHandler::record_digital_confirmation($loan_id, $confirmation_data);
    
    if ($result) {
        wp_redirect(add_query_arg('message', 'Receipt confirmation recorded successfully', $_SERVER['REQUEST_URI']));
    } else {
        wp_redirect(add_query_arg('error', 'Failed to record confirmation', $_SERVER['REQUEST_URI']));
    }
    exit;
}