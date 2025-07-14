<?php
/**
 * Basic Loan Application Form Template Part
 */

// Get member's eligibility
$max_loan_amount = daystar_calculate_loan_eligibility($user_id);
?>

<div class="basic-loan-application">
    <!-- Eligibility Summary -->
    <div class="eligibility-summary mb-4">
        <div class="alert alert-info">
            <h5>Loan Eligibility Summary</h5>
            <p>Based on your contributions and membership status, you are eligible for loans up to:</p>
            <p class="eligibility-amount"><strong>KES <?php echo number_format($max_loan_amount, 2); ?></strong></p>
        </div>
    </div>
    
    <!-- Basic Application Form -->
    <form id="basic-loan-application-form" class="needs-validation" novalidate>
        <?php wp_nonce_field('daystar_loan_application_nonce', 'nonce'); ?>
        
        <div class="card">
            <div class="card-header">
                <h3>Basic Loan Application</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basic-loan-type">Loan Type <span class="required">*</span></label>
                            <select class="form-control" id="basic-loan-type" name="loan_type" required>
                                <option value="">Select Loan Type</option>
                                <option value="development">Development Loan (12% p.a.)</option>
                                <option value="emergency">Emergency Loan (10% p.a.)</option>
                                <option value="school_fees">School Fees Loan (8% p.a.)</option>
                                <option value="business">Business Loan (14% p.a.)</option>
                            </select>
                            <div class="invalid-feedback">Please select a loan type.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basic-loan-amount">Loan Amount (KES) <span class="required">*</span></label>
                            <input type="number" class="form-control" id="basic-loan-amount" name="loan_amount" 
                                   min="10000" max="<?php echo esc_attr($max_loan_amount); ?>" required>
                            <div class="invalid-feedback">Please enter a valid loan amount.</div>
                            <small class="form-text text-muted">Maximum: KES <?php echo number_format($max_loan_amount, 2); ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basic-loan-term">Loan Term (Months) <span class="required">*</span></label>
                            <select class="form-control" id="basic-loan-term" name="loan_term" required>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basic-monthly-payment">Estimated Monthly Payment</label>
                            <input type="text" class="form-control" id="basic-monthly-payment" readonly>
                            <small class="form-text text-muted">Calculated automatically</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="basic-loan-purpose">Purpose of Loan <span class="required">*</span></label>
                    <textarea class="form-control" id="basic-loan-purpose" name="loan_purpose" rows="3" required></textarea>
                    <div class="invalid-feedback">Please provide the purpose of the loan.</div>
                </div>
                
                <!-- Loan Summary -->
                <div class="loan-summary" id="basic-loan-summary" style="display: none;">
                    <h5>Loan Summary</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="summary-item">
                                <label>Monthly Payment</label>
                                <div class="summary-value" id="basic-summary-monthly">KES 0</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-item">
                                <label>Total Interest</label>
                                <div class="summary-value" id="basic-summary-interest">KES 0</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-item">
                                <label>Total Payment</label>
                                <div class="summary-value" id="basic-summary-total">KES 0</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-item">
                                <label>Processing Fee</label>
                                <div class="summary-value" id="basic-summary-fee">KES 0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Guarantors Section -->
        <div class="card">
            <div class="card-header">
                <h4>Guarantors Information</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">You need at least 2 guarantors who are active members of the SACCO.</p>
                
                <!-- Guarantor 1 -->
                <div class="guarantor-section mb-4">
                    <h5>Guarantor 1</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor1-member-no">Member Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="basic-guarantor1-member-no" name="guarantor1_member_no" required>
                                <div class="invalid-feedback">Please enter the guarantor's member number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor1-name">Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="basic-guarantor1-name" name="guarantor1_name" required>
                                <div class="invalid-feedback">Please enter the guarantor's full name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor1-phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="basic-guarantor1-phone" name="guarantor1_phone" required>
                                <div class="invalid-feedback">Please enter the guarantor's phone number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor1-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="basic-guarantor1-amount" name="guarantor1_amount" required>
                                <div class="invalid-feedback">Please enter the amount to guarantee.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Guarantor 2 -->
                <div class="guarantor-section">
                    <h5>Guarantor 2</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor2-member-no">Member Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="basic-guarantor2-member-no" name="guarantor2_member_no" required>
                                <div class="invalid-feedback">Please enter the guarantor's member number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor2-name">Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="basic-guarantor2-name" name="guarantor2_name" required>
                                <div class="invalid-feedback">Please enter the guarantor's full name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor2-phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="basic-guarantor2-phone" name="guarantor2_phone" required>
                                <div class="invalid-feedback">Please enter the guarantor's phone number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basic-guarantor2-amount">Amount to Guarantee (KES) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="basic-guarantor2-amount" name="guarantor2_amount" required>
                                <div class="invalid-feedback">Please enter the amount to guarantee.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Terms and Conditions -->
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="basic-terms-agreement" name="terms_agreement" required>
                        <label class="form-check-label" for="basic-terms-agreement">
                            I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Loan Terms and Conditions</a> <span class="required">*</span>
                        </label>
                        <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Submit Basic Application</button>
            <div class="mt-3">
                <small class="text-muted">Your application will be reviewed within 7-14 working days.</small>
            </div>
        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Calculate loan details when inputs change
    function calculateBasicLoan() {
        var loanAmount = parseFloat($('#basic-loan-amount').val());
        var loanTerm = parseInt($('#basic-loan-term').val());
        var loanType = $('#basic-loan-type').val();
        
        if (isNaN(loanAmount) || loanAmount <= 0 || isNaN(loanTerm) || loanTerm <= 0 || !loanType) {
            $('#basic-loan-summary').hide();
            return;
        }
        
        // Get interest rate based on loan type
        var interestRates = {
            'development': 12,
            'emergency': 10,
            'school_fees': 8,
            'business': 14
        };
        
        var interestRate = interestRates[loanType] || 12;
        var processingFeeRate = {
            'development': 0.02,
            'emergency': 0.01,
            'school_fees': 0.01,
            'business': 0.025
        };
        
        // Calculate monthly payment
        var monthlyRate = (interestRate / 100) / 12;
        var monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
        var totalPayment = monthlyPayment * loanTerm;
        var totalInterest = totalPayment - loanAmount;
        var processingFee = loanAmount * (processingFeeRate[loanType] || 0.02);
        
        // Update the summary
        $('#basic-monthly-payment').val('KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#basic-summary-monthly').text('KES ' + monthlyPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#basic-summary-interest').text('KES ' + totalInterest.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#basic-summary-total').text('KES ' + totalPayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#basic-summary-fee').text('KES ' + processingFee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        
        // Show the summary
        $('#basic-loan-summary').show();
        
        // Update guarantor amounts
        var suggestedGuarantorAmount = loanAmount / 2;
        $('#basic-guarantor1-amount').val(suggestedGuarantorAmount);
        $('#basic-guarantor2-amount').val(suggestedGuarantorAmount);
    }
    
    $('#basic-loan-type, #basic-loan-amount, #basic-loan-term').on('change', calculateBasicLoan);
    
    // Form validation
    $('#basic-loan-application-form').on('submit', function(e) {
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
        
        // The actual submission is handled by the parent page
        submitBasicApplication();
        
        // Reset button state (will be handled by success/error callbacks)
        setTimeout(function() {
            submitBtn.prop('disabled', false).text(originalText);
        }, 5000);
    });
});
</script>