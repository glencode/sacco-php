<?php
/**
 * Template Name: Loan Application Page
 *
 * This is the template for the loan application page.
 *
 * @package Daystar
 */

// Ensure only logged-in members can access this page
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login?redirect_to=' . urlencode(home_url('/loan-application'))));
    exit;
}

$current_user = wp_get_current_user();

// Check if user is a member
if (!in_array('member', $current_user->roles)) {
    wp_redirect(home_url('/'));
    exit;
}

// Get member data
$user_id = $current_user->ID;
$member_number = get_user_meta($user_id, 'member_number', true);
$member_status = get_user_meta($user_id, 'member_status', true);

// Calculate loan eligibility
$max_loan_amount = daystar_calculate_loan_eligibility($user_id);

get_header();
?>

<div class="page-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Loan Application</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($member_status !== 'active') : ?>
                            <div class="alert alert-warning">
                                <p><strong>Account Status:</strong> <?php echo ucfirst(esc_html($member_status)); ?></p>
                                <p>Your account must be active to apply for a loan. Please contact the administrator for assistance.</p>
                            </div>
                        <?php else : ?>
                            <div class="loan-eligibility-summary mb-4">
                                <div class="alert alert-info">
                                    <h5>Loan Eligibility Summary</h5>
                                    <p>Based on your contributions and membership status, you are eligible for loans up to:</p>
                                    <p class="eligibility-amount">KES <?php echo number_format($max_loan_amount, 2); ?></p>
                                </div>
                            </div>
                            
                            <div class="loan-application-form">
                                <form id="loan-application-form" class="needs-validation" novalidate>
                                    <?php wp_nonce_field('daystar_loan_application_nonce', 'loan_application_nonce'); ?>
                                    
                                    <div class="form-group">
                                        <label for="loan-type">Loan Type <span class="required">*</span></label>
                                        <select class="form-control" id="loan-type" name="loan_type" required>
                                            <option value="">Select Loan Type</option>
                                            <option value="development">Development Loan (12% p.a.)</option>
                                            <option value="emergency">Emergency Loan (10% p.a.)</option>
                                            <option value="school-fees">School Fees Loan (8% p.a.)</option>
                                            <option value="business">Business Loan (14% p.a.)</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a loan type.</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="loan-amount">Loan Amount (KES) <span class="required">*</span></label>
                                        <input type="number" class="form-control" id="loan-amount" name="loan_amount" min="10000" max="<?php echo esc_attr($max_loan_amount); ?>" required>
                                        <div class="invalid-feedback">Please enter a valid loan amount.</div>
                                        <small class="form-text text-muted">Minimum: KES 10,000 | Maximum: KES <?php echo number_format($max_loan_amount, 2); ?></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="loan-term">Loan Term (Months) <span class="required">*</span></label>
                                        <select class="form-control" id="loan-term" name="loan_term" required>
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
                                    
                                    <div class="loan-calculation-summary mb-4" style="display: none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Loan Summary</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Monthly Payment:</strong> <span id="monthly-payment">KES 0.00</span></p>
                                                        <p><strong>Total Payment:</strong> <span id="total-payment">KES 0.00</span></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Total Interest:</strong> <span id="total-interest">KES 0.00</span></p>
                                                        <p><strong>Effective Rate:</strong> <span id="effective-rate">0.00%</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="loan-purpose">Purpose of Loan <span class="required">*</span></label>
                                        <textarea class="form-control" id="loan-purpose" name="loan_purpose" rows="3" required></textarea>
                                        <div class="invalid-feedback">Please provide the purpose of the loan.</div>
                                        <small class="form-text text-muted">Please provide a detailed explanation of how you plan to use the loan.</small>
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
                                                        <input type="text" class="form-control" id="guarantor1-member-no" name="guarantor1_member_no" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's member number.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor1-name">Full Name <span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="guarantor1-name" name="guarantor1_name" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's full name.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor1-phone">Phone Number <span class="required">*</span></label>
                                                        <input type="tel" class="form-control" id="guarantor1-phone" name="guarantor1_phone" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's phone number.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor1-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                                        <input type="number" class="form-control" id="guarantor1-amount" name="guarantor1_amount" required>
                                                        <div class="invalid-feedback">Please enter the amount to guarantee.</div>
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
                                                        <input type="text" class="form-control" id="guarantor2-member-no" name="guarantor2_member_no" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's member number.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor2-name">Full Name <span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="guarantor2-name" name="guarantor2_name" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's full name.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor2-phone">Phone Number <span class="required">*</span></label>
                                                        <input type="tel" class="form-control" id="guarantor2-phone" name="guarantor2_phone" required>
                                                        <div class="invalid-feedback">Please enter the guarantor's phone number.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guarantor2-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                                        <input type="number" class="form-control" id="guarantor2-amount" name="guarantor2_amount" required>
                                                        <div class="invalid-feedback">Please enter the amount to guarantee.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="loan-terms-agreement" name="terms_agreement" required>
                                            <label class="form-check-label" for="loan-terms-agreement">
                                                I agree to the <a href="#" data-toggle="modal" data-target="#loanTermsModal">Loan Terms and Conditions</a> <span class="required">*</span>
                                            </label>
                                            <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Loan Application</button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Loan Terms Modal -->
                            <div class="modal fade" id="loanTermsModal" tabindex="-1" role="dialog" aria-labelledby="loanTermsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="loanTermsModalLabel">Loan Terms and Conditions</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>1. Loan Eligibility</h6>
                                            <p>To be eligible for a loan, you must:</p>
                                            <ul>
                                                <li>Be an active member of Daystar Multi-Purpose Co-op Society</li>
                                                <li>Have been a member for at least 6 months</li>
                                                <li>Have made regular contributions as per the society's requirements</li>
                                                <li>Have a good repayment history (if you have had previous loans)</li>
                                                <li>Provide at least two guarantors who are active members of the society</li>
                                            </ul>
                                            
                                            <h6>2. Loan Types and Interest Rates</h6>
                                            <p>The society offers the following types of loans with their respective interest rates:</p>
                                            <ul>
                                                <li>Development Loan: 12% per annum on reducing balance</li>
                                                <li>Emergency Loan: 10% per annum on reducing balance</li>
                                                <li>School Fees Loan: 8% per annum on reducing balance</li>
                                                <li>Business Loan: 14% per annum on reducing balance</li>
                                            </ul>
                                            
                                            <h6>3. Loan Limits</h6>
                                            <p>The maximum loan amount you can borrow is determined by:</p>
                                            <ul>
                                                <li>Your total contributions (up to 3 times your total contributions)</li>
                                                <li>Your repayment capacity</li>
                                                <li>The type of loan you are applying for</li>
                                            </ul>
                                            
                                            <h6>4. Repayment Period</h6>
                                            <p>The repayment period varies depending on the loan type:</p>
                                            <ul>
                                                <li>Development Loan: Up to 48 months</li>
                                                <li>Emergency Loan: Up to 12 months</li>
                                                <li>School Fees Loan: Up to 12 months</li>
                                                <li>Business Loan: Up to 60 months</li>
                                            </ul>
                                            
                                            <h6>5. Guarantors</h6>
                                            <p>All loans must be guaranteed by at least two active members of the society. Guarantors:</p>
                                            <ul>
                                                <li>Must be active members of the society</li>
                                                <li>Must have sufficient shares to cover the guaranteed amount</li>
                                                <li>Will be liable for the loan in case of default</li>
                                            </ul>
                                            
                                            <h6>6. Loan Processing</h6>
                                            <p>The loan processing procedure is as follows:</p>
                                            <ul>
                                                <li>Submit a completed loan application form</li>
                                                <li>The loan application will be reviewed by the credit committee</li>
                                                <li>If approved, the loan will be disbursed to your registered bank account</li>
                                                <li>Processing time is typically 7-14 working days</li>
                                            </ul>
                                            
                                            <h6>7. Loan Repayment</h6>
                                            <p>Loan repayments:</p>
                                            <ul>
                                                <li>Must be made monthly as per the agreed schedule</li>
                                                <li>Can be made through M-Pesa, bank transfer, or direct debit</li>
                                                <li>Late payments will attract a penalty of 5% of the due amount</li>
                                            </ul>
                                            
                                            <h6>8. Early Repayment</h6>
                                            <p>You can repay your loan early without any penalty. Early repayment will reduce the total interest payable.</p>
                                            
                                            <h6>9. Default</h6>
                                            <p>In case of default:</p>
                                            <ul>
                                                <li>Your guarantors will be notified</li>
                                                <li>Your shares and deposits may be used to offset the loan</li>
                                                <li>Your guarantors' shares may be used to offset the remaining balance</li>
                                                <li>Legal action may be taken to recover the outstanding amount</li>
                                            </ul>
                                            
                                            <h6>10. Amendment of Terms</h6>
                                            <p>The society reserves the right to amend these terms and conditions at any time. Members will be notified of any changes.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="accept-terms" data-dismiss="modal">I Accept</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Calculate loan details when inputs change
    function calculateLoan() {
        var loanAmount = parseFloat($('#loan-amount').val());
        var loanTerm = parseInt($('#loan-term').val());
        var loanType = $('#loan-type').val();
        
        if (isNaN(loanAmount) || loanAmount <= 0 || isNaN(loanTerm) || loanTerm <= 0 || !loanType) {
            $('.loan-calculation-summary').hide();
            return;
        }
        
        // Get interest rate based on loan type
        var interestRate;
        switch (loanType) {
            case 'development':
                interestRate = 12;
                break;
            case 'emergency':
                interestRate = 10;
                break;
            case 'school-fees':
                interestRate = 8;
                break;
            case 'business':
                interestRate = 14;
                break;
            default:
                interestRate = 12;
        }
        
        // Calculate monthly payment
        var monthlyRate = (interestRate / 100) / 12;
        var monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
        var totalPayment = monthlyPayment * loanTerm;
        var totalInterest = totalPayment - loanAmount;
        var effectiveRate = (totalInterest / loanAmount) * (12 / loanTerm) * 100;
        
        // Update the summary
        $('#monthly-payment').text('KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total-payment').text('KES ' + totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#total-interest').text('KES ' + totalInterest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#effective-rate').text(effectiveRate.toFixed(2) + '%');
        
        // Show the summary
        $('.loan-calculation-summary').show();
        
        // Update guarantor amounts
        var suggestedGuarantorAmount = loanAmount / 2;
        $('#guarantor1-amount').val(suggestedGuarantorAmount);
        $('#guarantor2-amount').val(suggestedGuarantorAmount);
    }
    
    $('#loan-type, #loan-amount, #loan-term').on('change', calculateLoan);
    
    // Accept terms button
    $('#accept-terms').on('click', function() {
        $('#loan-terms-agreement').prop('checked', true);
    });
    
    // Form validation
    $('#loan-application-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this)[0];
        
        if (form.checkValidity() === false) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
        
        // Collect form data
        var formData = {
            action: 'daystar_submit_loan_application',
            nonce: $('#loan_application_nonce').val(),
            loan_type: $('#loan-type').val(),
            loan_amount: $('#loan-amount').val(),
            loan_term: $('#loan-term').val(),
            loan_purpose: $('#loan-purpose').val(),
            guarantor1_member_no: $('#guarantor1-member-no').val(),
            guarantor1_name: $('#guarantor1-name').val(),
            guarantor1_phone: $('#guarantor1-phone').val(),
            guarantor1_amount: $('#guarantor1-amount').val(),
            guarantor2_member_no: $('#guarantor2-member-no').val(),
            guarantor2_name: $('#guarantor2-name').val(),
            guarantor2_phone: $('#guarantor2-phone').val(),
            guarantor2_amount: $('#guarantor2-amount').val(),
            terms_agreement: $('#loan-terms-agreement').is(':checked') ? 1 : 0
        };
        
        // Submit the form via AJAX
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect to the dashboard
                        if (response.data.redirect_url) {
                            window.location.href = response.data.redirect_url;
                        }
                    });
                } else {
                    // Show error message
                    var errorMessage = 'An error occurred. Please try again.';
                    
                    if (response.data && response.data.errors) {
                        errorMessage = response.data.errors.join('<br>');
                    } else if (response.data) {
                        errorMessage = response.data;
                    }
                    
                    Swal.fire({
                        title: 'Error',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    
                    // Reset button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function() {
                // Show error message
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                
                // Reset button
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
});
</script>

<?php get_footer(); ?>
