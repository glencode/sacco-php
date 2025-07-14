<?php
/**
 * Template Name: Secure Loan Application
 * 
 * Demonstrates the implementation of comprehensive security measures
 * including RBAC, input validation, CSRF protection, and audit logging
 * 
 * @package Daystar_SACCO
 */

// Enhanced security check with specific capabilities
daystar_check_enhanced_member_access(['apply_for_loans']);

// Validate session security
daystar_validate_session_security();

// Check rate limiting for loan applications
$user_id = get_current_user_id();
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
if (!Daystar_Security_Config::check_rate_limit('loan_application', $user_id . '_' . $ip_address, 5, 3600)) {
    // Log rate limit violation
    Daystar_Security_Access_Control::log_action(
        'loan_application_rate_limit_exceeded',
        'security',
        null,
        array(
            'user_id' => $user_id,
            'ip_address' => $ip_address,
            'limit' => 5,
            'window' => 3600
        ),
        'warning'
    );
    
    wp_die('Too many loan application attempts. Please try again later.', 'Rate Limit Exceeded', array('response' => 429));
}

get_header();

// Get current user data
$current_user = wp_get_current_user();
$member_number = get_user_meta($user_id, 'member_number', true);

// Check if user has completed profile
$profile_complete = !empty($member_number) && 
                   !empty(get_user_meta($user_id, 'phone', true)) && 
                   !empty(get_user_meta($user_id, 'national_id', true));

if (!$profile_complete) {
    // Log incomplete profile access
    Daystar_Security_Access_Control::log_action(
        'loan_application_incomplete_profile',
        'member',
        $user_id,
        array(
            'missing_member_number' => empty($member_number),
            'missing_phone' => empty(get_user_meta($user_id, 'phone', true)),
            'missing_national_id' => empty(get_user_meta($user_id, 'national_id', true))
        ),
        'warning'
    );
}
?>

<main id="primary" class="site-main secure-loan-application">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="application-header text-center mb-5">
                    <h1 class="page-title">Secure Loan Application</h1>
                    <p class="lead">Apply for a loan with enhanced security and validation</p>
                    <div class="security-indicators">
                        <span class="badge badge-success"><i class="fas fa-shield-alt"></i> SSL Encrypted</span>
                        <span class="badge badge-info"><i class="fas fa-user-check"></i> Authenticated</span>
                        <span class="badge badge-warning"><i class="fas fa-audit"></i> Audit Logged</span>
                    </div>
                </div>

                <?php if (!$profile_complete): ?>
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Profile Incomplete</h5>
                        <p>Please complete your profile before applying for a loan. Missing information may delay your application.</p>
                        <a href="<?php echo home_url('/member-profile/'); ?>" class="btn btn-warning">Complete Profile</a>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="application-form-card">
                            <div class="card-header">
                                <h3><i class="fas fa-file-alt"></i> Loan Application Form</h3>
                                <small class="text-muted">All fields marked with * are required</small>
                            </div>
                            <div class="card-body">
                                <?php daystar_secure_form_start('loan_application', 'POST', array('id' => 'secure-loan-form', 'class' => 'needs-validation', 'novalidate' => true)); ?>
                                
                                    <!-- Member Information (Read-only) -->
                                    <div class="form-section">
                                        <h4>Member Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Member Number</label>
                                                    <input type="text" class="form-control" value="<?php echo esc_attr($member_number); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" value="<?php echo esc_attr($current_user->display_name); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Loan Details -->
                                    <div class="form-section">
                                        <h4>Loan Details</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="loan_type">Loan Type *</label>
                                                    <select class="form-control" id="loan_type" name="loan_type" required>
                                                        <option value="">Select Loan Type</option>
                                                        <option value="Development Loan">Development Loan</option>
                                                        <option value="School Fees Loan">School Fees Loan</option>
                                                        <option value="Emergency Loan">Emergency Loan</option>
                                                        <option value="Special Loan">Special Loan</option>
                                                        <option value="Super Saver Loan">Super Saver Loan</option>
                                                        <option value="Salary Advance">Salary Advance</option>
                                                                                                            </select>
                                                    <div class="invalid-feedback">Please select a loan type.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="loan_amount">Loan Amount (KES) *</label>
                                                    <input type="number" class="form-control" id="loan_amount" name="loan_amount" 
                                                           min="1000" max="5000000" step="100" required>
                                                    <div class="invalid-feedback">Please enter a valid loan amount (KES 1,000 - 5,000,000).</div>
                                                    <small class="form-text text-muted">Minimum: KES 1,000 | Maximum: KES 5,000,000</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="term_months">Repayment Period (Months) *</label>
                                                    <select class="form-control" id="term_months" name="term_months" required>
                                                        <option value="">Select Period</option>
                                                        <?php for ($i = 1; $i <= 48; $i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Month<?php echo $i > 1 ? 's' : ''; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a repayment period.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="interest_rate">Interest Rate</label>
                                                    <input type="text" class="form-control" id="interest_rate" value="12% per annum" readonly>
                                                    <small class="form-text text-muted">Standard rate - may vary by loan type</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Loan Purpose -->
                                    <div class="form-section">
                                        <h4>Loan Purpose</h4>
                                        <div class="form-group">
                                            <label for="purpose">Purpose of Loan *</label>
                                            <textarea class="form-control" id="purpose" name="purpose" rows="4" 
                                                      maxlength="1000" required placeholder="Please describe the purpose of this loan..."></textarea>
                                            <div class="invalid-feedback">Please describe the purpose of the loan.</div>
                                            <small class="form-text text-muted">Maximum 1000 characters</small>
                                        </div>
                                    </div>

                                    <!-- Security and Guarantors -->
                                    <div class="form-section">
                                        <h4>Security & Guarantors</h4>
                                        <div class="form-group">
                                            <label>Guarantor Information</label>
                                            <div id="guarantors-container">
                                                <div class="guarantor-row">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="guarantors[0][member_number]" 
                                                                   placeholder="Guarantor Member Number">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="number" class="form-control" name="guarantors[0][amount]" 
                                                                   placeholder="Guaranteed Amount" min="0" step="100">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-outline-danger remove-guarantor">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-guarantor">
                                                <i class="fas fa-plus"></i> Add Guarantor
                                            </button>
                                        </div>
                                    </div>

                                    <!-- File Uploads -->
                                    <div class="form-section">
                                        <h4>Supporting Documents</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="payslip">Latest Payslip</label>
                                                    <input type="file" class="form-control-file" id="payslip" name="payslip" 
                                                           accept=".pdf,.jpg,.jpeg,.png">
                                                    <small class="form-text text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_copy">National ID Copy</label>
                                                    <input type="file" class="form-control-file" id="id_copy" name="id_copy" 
                                                           accept=".pdf,.jpg,.jpeg,.png">
                                                    <small class="form-text text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="form-section">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="terms_agreement" name="terms_agreement" required>
                                                <label class="custom-control-label" for="terms_agreement">
                                                    I agree to the <a href="<?php echo home_url('/credit-policy/'); ?>" target="_blank">Credit Policy</a> 
                                                    and <a href="<?php echo home_url('/terms-conditions/'); ?>" target="_blank">Terms & Conditions</a> *
                                                </label>
                                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="data_consent" name="data_consent" required>
                                                <label class="custom-control-label" for="data_consent">
                                                    I consent to the processing of my personal data for loan assessment purposes *
                                                </label>
                                                <div class="invalid-feedback">Data processing consent is required.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary btn-lg" id="submit-application">
                                            <i class="fas fa-paper-plane"></i> Submit Secure Application
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-lg ml-2" onclick="window.history.back()">
                                            <i class="fas fa-arrow-left"></i> Cancel
                                        </button>
                                    </div>

                                <?php daystar_secure_form_end(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Security Information Sidebar -->
                        <div class="security-info-card">
                            <h4><i class="fas fa-shield-alt"></i> Security Features</h4>
                            <ul class="security-features">
                                <li><i class="fas fa-check text-success"></i> End-to-end encryption</li>
                                <li><i class="fas fa-check text-success"></i> CSRF protection</li>
                                <li><i class="fas fa-check text-success"></i> Input validation & sanitization</li>
                                <li><i class="fas fa-check text-success"></i> Audit logging</li>
                                <li><i class="fas fa-check text-success"></i> Rate limiting</li>
                                <li><i class="fas fa-check text-success"></i> Session security</li>
                            </ul>
                        </div>

                        <!-- Application Guidelines -->
                        <div class="guidelines-card">
                            <h4><i class="fas fa-info-circle"></i> Application Guidelines</h4>
                            <div class="guidelines-content">
                                <h6>Before You Apply:</h6>
                                <ul>
                                    <li>Ensure your profile is complete</li>
                                    <li>Check your eligibility</li>
                                    <li>Prepare required documents</li>
                                    <li>Review the credit policy</li>
                                </ul>
                                
                                <h6>Processing Time:</h6>
                                <ul>
                                    <li>Initial review: 2-3 business days</li>
                                    <li>Committee approval: 5-7 business days</li>
                                    <li>Disbursement: 1-2 business days</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Support -->
                        <div class="support-card">
                            <h4><i class="fas fa-headset"></i> Need Help?</h4>
                            <p>Our support team is here to assist you with your loan application.</p>
                            <div class="contact-info">
                                <p><i class="fas fa-phone"></i> +254 123 456 789</p>
                                <p><i class="fas fa-envelope"></i> loans@daystar.co.ke</p>
                                <p><i class="fas fa-clock"></i> Mon-Fri: 8AM-5PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.secure-loan-application {
    padding: 2rem 0;
    background: #f8f9fa;
}

.application-header {
    margin-bottom: 2rem;
}

.security-indicators .badge {
    margin: 0 0.25rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
}

.application-form-card,
.security-info-card,
.guidelines-card,
.support-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.application-form-card .card-header {
    background: #2271b1;
    color: #fff;
    padding: 1rem 1.5rem;
    border-radius: 8px 8px 0 0;
}

.application-form-card .card-body {
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h4 {
    color: #2271b1;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.guarantor-row {
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 5px;
}

.form-actions {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.security-info-card,
.guidelines-card,
.support-card {
    padding: 1.5rem;
}

.security-info-card h4,
.guidelines-card h4,
.support-card h4 {
    color: #2271b1;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.security-features {
    list-style: none;
    padding: 0;
}

.security-features li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.security-features li:last-child {
    border-bottom: none;
}

.guidelines-content h6 {
    color: #495057;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.guidelines-content ul {
    margin-bottom: 1rem;
}

.contact-info p {
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.contact-info i {
    color: #2271b1;
    width: 1rem;
}

/* Form validation styles */
.was-validated .form-control:valid {
    border-color: #28a745;
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

/* Loading state */
.btn.loading {
    position: relative;
    color: transparent;
}

.btn.loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .application-form-card .card-body {
        padding: 1rem;
    }
    
    .form-actions .btn {
        display: block;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .guarantor-row .row {
        flex-direction: column;
    }
    
    .guarantor-row .col-md-2 {
        margin-top: 0.5rem;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Form validation
    $('#secure-loan-form').on('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity() === false) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }
        
        // Show loading state
        const submitBtn = $('#submit-application');
        submitBtn.addClass('loading').prop('disabled', true);
        
        // Prepare form data
        const formData = new FormData(this);
        formData.append('action', 'secure_loan_application');
        
        // Submit via AJAX
        $.ajax({
            url: daystar_security.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    alert('Loan application submitted successfully! Application Number: ' + response.data.application_number);
                    window.location.href = '<?php echo home_url('/member-dashboard/'); ?>';
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function() {
                alert('An error occurred while submitting your application. Please try again.');
            },
            complete: function() {
                submitBtn.removeClass('loading').prop('disabled', false);
            }
        });
    });
    
    // Add guarantor functionality
    let guarantorCount = 1;
    $('#add-guarantor').on('click', function() {
        const guarantorHtml = `
            <div class="guarantor-row">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="guarantors[${guarantorCount}][member_number]" 
                               placeholder="Guarantor Member Number">
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" name="guarantors[${guarantorCount}][amount]" 
                               placeholder="Guaranteed Amount" min="0" step="100">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger remove-guarantor">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#guarantors-container').append(guarantorHtml);
        guarantorCount++;
    });
    
    // Remove guarantor functionality
    $(document).on('click', '.remove-guarantor', function() {
        if ($('.guarantor-row').length > 1) {
            $(this).closest('.guarantor-row').remove();
        }
    });
    
    // Loan amount formatting
    $('#loan_amount').on('input', function() {
        const value = $(this).val();
        if (value) {
            $(this).next('.form-text').text(`Amount: KES ${parseInt(value).toLocaleString()}`);
        }
    });
    
    // Character counter for purpose
    $('#purpose').on('input', function() {
        const remaining = 1000 - $(this).val().length;
        $(this).next().next('.form-text').text(`${remaining} characters remaining`);
    });
});
</script>

<?php get_footer(); ?>