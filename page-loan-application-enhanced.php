<?php
/**
 * Template Name: Enhanced Loan Application
 * Description: Comprehensive loan application form based on credit policy
 */

get_header(); ?>

<div class="loan-application-page">
    <!-- Hero Section -->
    <section class="loan-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-content">
                        <h1 class="hero-title">Loan Application</h1>
                        <p class="hero-subtitle">Apply for a loan that suits your needs</p>
                        <div class="breadcrumb-nav">
                            <a href="<?php echo home_url(); ?>">Home</a>
                            <span class="separator">/</span>
                            <a href="<?php echo home_url('/credit-policy'); ?>">Credit Policy</a>
                            <span class="separator">/</span>
                            <span class="current">Loan Application</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section class="application-form-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="application-form-container">
                        <div class="form-header">
                            <h2>Loan Application Form</h2>
                            <p>Please fill out all required fields to submit your loan application.</p>
                        </div>

                        <form id="loan-application-form" class="loan-form" method="post">
                            <?php wp_nonce_field('daystar_loan_application', 'loan_application_nonce'); ?>
                            
                            <!-- Step 1: Loan Type Selection -->
                            <div class="form-step active" id="step-1">
                                <h3 class="step-title">Step 1: Select Loan Type</h3>
                                
                                <div class="loan-types-selection">
                                    <div class="loan-type-option">
                                        <input type="radio" id="development-loan" name="loan_type" value="development" required>
                                        <label for="development-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <h4>Development Loan</h4>
                                            <p>For major projects like building, buying a car, or starting a business</p>
                                            <div class="loan-details">
                                                <span class="detail">Max: KSh 2,000,000</span>
                                                <span class="detail">Period: 36 months</span>
                                                <span class="detail">Rate: 12% p.a.</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="loan-type-option">
                                        <input type="radio" id="school-fees-loan" name="loan_type" value="school_fees">
                                        <label for="school-fees-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                            <h4>School Fees Loan</h4>
                                            <p>Solely for payment of school fees</p>
                                            <div class="loan-details">
                                                <span class="detail">Period: 12 months</span>
                                                <span class="detail">Rate: 12% p.a.</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="loan-type-option">
                                        <input type="radio" id="instant-loan" name="loan_type" value="instant">
                                        <label for="instant-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-bolt"></i>
                                            </div>
                                            <h4>Instant Loan</h4>
                                            <p>Priority processing within 24 hours</p>
                                            <div class="loan-details">
                                                <span class="detail">Max: KSh 50,000</span>
                                                <span class="detail">Period: 6 months</span>
                                                <span class="detail">Charge: 10% + 1% monthly</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="loan-type-option">
                                        <input type="radio" id="emergency-loan" name="loan_type" value="emergency">
                                        <label for="emergency-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-ambulance"></i>
                                            </div>
                                            <h4>Emergency Loan</h4>
                                            <p>For unforeseen circumstances with documentary evidence</p>
                                            <div class="loan-details">
                                                <span class="detail">Max: KSh 100,000</span>
                                                <span class="detail">Period: 12 months</span>
                                                <span class="detail">Rate: 12% p.a.</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="loan-type-option">
                                        <input type="radio" id="refinance-loan" name="loan_type" value="refinance">
                                        <label for="refinance-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-sync-alt"></i>
                                            </div>
                                            <h4>Refinance Loan</h4>
                                            <p>Consolidate existing development loan with new funds</p>
                                            <div class="loan-details">
                                                <span class="detail">Charge: 10% + 12% p.a.</span>
                                                <span class="detail">Period: Up to 36 months</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="loan-type-option">
                                        <input type="radio" id="super-saver-loan" name="loan_type" value="super_saver">
                                        <label for="super-saver-loan" class="loan-type-card">
                                            <div class="loan-icon">
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <h4>Super Saver Loan</h4>
                                            <p>For members with deposits exceeding KSh 1,000,000</p>
                                            <div class="loan-details">
                                                <span class="detail">Max: KSh 3,000,000</span>
                                                <span class="detail">Period: 48 months</span>
                                                <span class="detail">Rate: 12% p.a.</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Personal Information -->
                            <div class="form-step" id="step-2">
                                <h3 class="step-title">Step 2: Personal Information</h3>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="member_number">Member Number *</label>
                                        <input type="text" id="member_number" name="member_number" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="full_name">Full Name *</label>
                                        <input type="text" id="full_name" name="full_name" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_number">ID Number *</label>
                                        <input type="text" id="id_number" name="id_number" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number *</label>
                                        <input type="tel" id="phone_number" name="phone_number" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="employment_type">Employment Type *</label>
                                        <select id="employment_type" name="employment_type" required>
                                            <option value="">Select Employment Type</option>
                                            <option value="permanent">Permanent Staff</option>
                                            <option value="part_time">Part-Time</option>
                                            <option value="contract">Contract</option>
                                            <option value="lecturer">Lecturer</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="address">Physical Address *</label>
                                    <textarea id="address" name="address" rows="3" required></textarea>
                                </div>
                            </div>

                            <!-- Step 3: Loan Details -->
                            <div class="form-step" id="step-3">
                                <h3 class="step-title">Step 3: Loan Details</h3>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="loan_amount">Requested Amount (KSh) *</label>
                                        <input type="number" id="loan_amount" name="loan_amount" min="1000" required>
                                        <small class="form-help">Your eligibility is 3 times your deposits</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="repayment_period">Preferred Repayment Period (months) *</label>
                                        <select id="repayment_period" name="repayment_period" required>
                                            <option value="">Select Period</option>
                                            <option value="6">6 months</option>
                                            <option value="12">12 months</option>
                                            <option value="18">18 months</option>
                                            <option value="24">24 months</option>
                                            <option value="36">36 months</option>
                                            <option value="48">48 months</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="monthly_income">Monthly Net Income (KSh) *</label>
                                        <input type="number" id="monthly_income" name="monthly_income" min="0" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="current_deposits">Current Deposits (KSh) *</label>
                                        <input type="number" id="current_deposits" name="current_deposits" min="0" required>
                                    </div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="loan_purpose">Purpose of Loan *</label>
                                    <textarea id="loan_purpose" name="loan_purpose" rows="4" required placeholder="Please describe the purpose of this loan in detail..."></textarea>
                                </div>
                                
                                <!-- Emergency Loan Specific Fields -->
                                <div id="emergency-fields" class="conditional-fields" style="display: none;">
                                    <h4>Emergency Loan Documentation</h4>
                                    <div class="form-group full-width">
                                        <label for="emergency_documents">Supporting Documents *</label>
                                        <input type="file" id="emergency_documents" name="emergency_documents[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="form-help">Upload hospital bills, funeral notices, court documents, etc.</small>
                                    </div>
                                </div>
                                
                                <!-- School Fees Specific Fields -->
                                <div id="school-fees-fields" class="conditional-fields" style="display: none;">
                                    <h4>School Fees Documentation</h4>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="student_name">Student Name *</label>
                                            <input type="text" id="student_name" name="student_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="institution_name">Institution Name *</label>
                                            <input type="text" id="institution_name" name="institution_name">
                                        </div>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="fee_structure">Fee Structure/Invoice *</label>
                                        <input type="file" id="fee_structure" name="fee_structure" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Guarantors -->
                            <div class="form-step" id="step-4">
                                <h3 class="step-title">Step 4: Guarantors Information</h3>
                                <p class="step-description">Please provide details of at least 2 guarantors who are also society members.</p>
                                
                                <!-- Guarantor 1 -->
                                <div class="guarantor-section">
                                    <h4>Guarantor 1</h4>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="guarantor1_name">Full Name *</label>
                                            <input type="text" id="guarantor1_name" name="guarantor1_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor1_member_number">Member Number *</label>
                                            <input type="text" id="guarantor1_member_number" name="guarantor1_member_number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor1_phone">Phone Number *</label>
                                            <input type="tel" id="guarantor1_phone" name="guarantor1_phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor1_id">ID Number *</label>
                                            <input type="text" id="guarantor1_id" name="guarantor1_id" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Guarantor 2 -->
                                <div class="guarantor-section">
                                    <h4>Guarantor 2</h4>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="guarantor2_name">Full Name *</label>
                                            <input type="text" id="guarantor2_name" name="guarantor2_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor2_member_number">Member Number *</label>
                                            <input type="text" id="guarantor2_member_number" name="guarantor2_member_number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor2_phone">Phone Number *</label>
                                            <input type="tel" id="guarantor2_phone" name="guarantor2_phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="guarantor2_id">ID Number *</label>
                                            <input type="text" id="guarantor2_id" name="guarantor2_id" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 5: Documents & Declaration -->
                            <div class="form-step" id="step-5">
                                <h3 class="step-title">Step 5: Documents & Declaration</h3>
                                
                                <div class="documents-section">
                                    <h4>Required Documents</h4>
                                    <div class="form-group">
                                        <label for="payslip">Latest Payslip *</label>
                                        <input type="file" id="payslip" name="payslip" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_copy">Copy of ID *</label>
                                        <input type="file" id="id_copy" name="id_copy" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="additional_documents">Additional Supporting Documents</label>
                                        <input type="file" id="additional_documents" name="additional_documents[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="form-help">Any other relevant documents</small>
                                    </div>
                                </div>
                                
                                <div class="declaration-section">
                                    <h4>Declaration</h4>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="terms_agreement" name="terms_agreement" required>
                                        <label for="terms_agreement">I agree to the <a href="<?php echo home_url('/credit-policy'); ?>" target="_blank">Credit Policy terms and conditions</a> *</label>
                                    </div>
                                    
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="information_accuracy" name="information_accuracy" required>
                                        <label for="information_accuracy">I declare that all information provided is accurate and complete *</label>
                                    </div>
                                    
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="deduction_consent" name="deduction_consent" required>
                                        <label for="deduction_consent">I consent to automatic salary deductions for loan repayment *</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Navigation -->
                            <div class="form-navigation">
                                <button type="button" id="prev-step" class="btn btn-secondary" style="display: none;">Previous</button>
                                <button type="button" id="next-step" class="btn btn-primary">Next</button>
                                <button type="submit" id="submit-application" class="btn btn-success" style="display: none;">
                                    <i class="fas fa-paper-plane"></i> Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Loan Calculator Widget -->
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
                    
                    <!-- Eligibility Checker -->
                    <div class="sidebar-widget">
                        <h3>Check Eligibility</h3>
                        <div class="eligibility-checker">
                            <div class="calc-group">
                                <label for="deposits_amount">Your Deposits (KSh)</label>
                                <input type="number" id="deposits_amount" min="0">
                            </div>
                            <div class="calc-group">
                                <label for="membership_months">Membership Duration (months)</label>
                                <input type="number" id="membership_months" min="0">
                            </div>
                            <button type="button" id="check-eligibility" class="btn btn-info btn-block">Check Eligibility</button>
                            <div id="eligibility-result" class="eligibility-result"></div>
                        </div>
                    </div>
                    
                    <!-- Help & Support -->
                    <div class="sidebar-widget">
                        <h3>Need Help?</h3>
                        <div class="help-content">
                            <p>If you need assistance with your loan application, please contact us:</p>
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

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application Submitted Successfully!</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="success-content">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h4>Thank you for your application!</h4>
                    <p>Your loan application has been submitted successfully. You will receive a confirmation email shortly.</p>
                    <div class="application-details">
                        <p><strong>Application Reference:</strong> <span id="application-ref"></span></p>
                        <p><strong>Next Steps:</strong></p>
                        <ul>
                            <li>Your application will be reviewed by our loan officer</li>
                            <li>You will be contacted within 3-5 business days</li>
                            <li>Ensure all guarantors are available for verification</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <a href="<?php echo home_url('/member-dashboard'); ?>" class="btn btn-secondary">View Dashboard</a>
            </div>
        </div>
    </div>
</div>

<script>
// Loan Application Form JavaScript
jQuery(document).ready(function($) {
    let currentStep = 1;
    const totalSteps = 5;
    
    // Step navigation
    $('#next-step').click(function() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });
    
    $('#prev-step').click(function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });
    
    function showStep(step) {
        $('.form-step').removeClass('active');
        $('#step-' + step).addClass('active');
        
        // Update navigation buttons
        if (step === 1) {
            $('#prev-step').hide();
        } else {
            $('#prev-step').show();
        }
        
        if (step === totalSteps) {
            $('#next-step').hide();
            $('#submit-application').show();
        } else {
            $('#next-step').show();
            $('#submit-application').hide();
        }
        
        // Show/hide conditional fields
        showConditionalFields();
    }
    
    function validateCurrentStep() {
        const currentStepElement = $('#step-' + currentStep);
        const requiredFields = currentStepElement.find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            if (!this.checkValidity()) {
                $(this).addClass('error');
                isValid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields before proceeding.');
        }
        
        return isValid;
    }
    
    function showConditionalFields() {
        const loanType = $('input[name="loan_type"]:checked').val();
        
        $('.conditional-fields').hide();
        
        if (loanType === 'emergency') {
            $('#emergency-fields').show();
            $('#emergency_documents').prop('required', true);
        } else {
            $('#emergency_documents').prop('required', false);
        }
        
        if (loanType === 'school_fees') {
            $('#school-fees-fields').show();
            $('#student_name, #institution_name, #fee_structure').prop('required', true);
        } else {
            $('#student_name, #institution_name, #fee_structure').prop('required', false);
        }
    }
    
    // Loan type change handler
    $('input[name="loan_type"]').change(function() {
        showConditionalFields();
        updateInterestRate();
    });
    
    function updateInterestRate() {
        const loanType = $('input[name="loan_type"]:checked').val();
        let rate = 12; // Default rate
        
        switch(loanType) {
            case 'instant':
                rate = 10; // Plus 1% monthly
                break;
            case 'special':
                rate = 5; // Per month
                break;
            default:
                rate = 12;
        }
        
        $('#calc_rate').val(rate);
    }
    
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
    
    // Eligibility checker
    $('#check-eligibility').click(function() {
        const deposits = parseFloat($('#deposits_amount').val());
        const months = parseInt($('#membership_months').val());
        
        let eligibility = '';
        let maxLoan = 0;
        
        if (months < 6) {
            eligibility = '<div class="alert alert-danger">You need at least 6 months of membership to be eligible for a loan.</div>';
        } else if (deposits < 12000) {
            eligibility = '<div class="alert alert-warning">You need at least KSh 12,000 in contributions to be eligible.</div>';
        } else {
            maxLoan = deposits * 3;
            eligibility = `
                <div class="alert alert-success">
                    <h6>You are eligible for a loan!</h6>
                    <p><strong>Maximum loan amount:</strong> KSh ${maxLoan.toLocaleString('en-KE')}</p>
                    <p>Based on 3 times your deposits</p>
                </div>
            `;
        }
        
        $('#eligibility-result').html(eligibility);
    });
    
    // Form submission
    $('#loan-application-form').submit(function(e) {
        e.preventDefault();
        
        if (!validateCurrentStep()) {
            return;
        }
        
        // Show loading state
        $('#submit-application').html('<i class="fas fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(function() {
            const applicationRef = 'LA' + Date.now();
            $('#application-ref').text(applicationRef);
            $('#successModal').modal('show');
            
            // Reset form
            $('#loan-application-form')[0].reset();
            currentStep = 1;
            showStep(1);
            $('#submit-application').html('<i class="fas fa-paper-plane"></i> Submit Application').prop('disabled', false);
        }, 2000);
    });
    
    // Auto-populate loan amount in calculator
    $('#loan_amount').on('input', function() {
        $('#calc_amount').val($(this).val());
    });
    
    // Auto-populate deposits in eligibility checker
    $('#current_deposits').on('input', function() {
        $('#deposits_amount').val($(this).val());
    });
});
</script>

<?php get_footer(); ?>