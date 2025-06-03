<?php
/**
 * The template for displaying the Loan Application page for Daystar Multi-Purpose Co-op Society Ltd.
 *
 * @package daystar-coop
 */

get_header();
?>

<main id="primary" class="site-main loan-application-page">
    <!-- Page Header -->
    <section class="page-header bg-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Loan Application</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Loan Application</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="page-header-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/application-icon.svg" alt="" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Introduction Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="section-content fade-in">
                        <h2 class="section-title text-start">Apply for a Loan</h2>
                        <p class="lead">Complete your loan application online with our simple and secure process.</p>
                        <p>Daystar Multi-Purpose Co-op Society Ltd. offers a variety of loan products designed to meet your financial needs. Whether you're looking to fund a development project, pay school fees, or handle an emergency, we're here to help.</p>
                        <p>Before applying, please ensure you meet the eligibility criteria and have all required documents ready for submission.</p>
                        <div class="daystar-notice notice-info mt-4">
                            <p><strong>Note:</strong> To be eligible for loans, you must be a member for at least 6 months with consistent contributions totaling not less than KSh 12,000 (KSh 2,000 × 6 months) and have a minimum share capital of KSh 5,000.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="application-image fade-in">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loan-application-hero.jpg" alt="Loan Application" class="img-fluid rounded-lg shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Type Selector Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Select Loan Type</h2>
                <p class="section-subtitle">Choose the loan product you wish to apply for</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </div>
                        <h3>Development Loan</h3>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">per annum on reducing balance</span>
                        </div>
                        <ul class="product-features">
                            <li>Maximum amount: KSh 2,000,000</li>
                            <li>Repayment period: Up to 36 months</li>
                            <li>For long-term development projects</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="development">Apply Now</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <h3>School Fees Loan</h3>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">per annum on reducing balance</span>
                        </div>
                        <ul class="product-features">
                            <li>Repayment period: Up to 12 months</li>
                            <li>Requires fee structure/admission letter</li>
                            <li>For education expenses</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="school-fees">Apply Now</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-ambulance" aria-hidden="true"></i>
                        </div>
                        <h3>Emergency Loan</h3>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">per annum on reducing balance</span>
                        </div>
                        <ul class="product-features">
                            <li>Maximum amount: KSh 100,000</li>
                            <li>Repayment period: Up to 12 months</li>
                            <li>For unexpected urgent needs</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="emergency">Apply Now</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h3>Special Loan</h3>
                        <div class="product-rate">
                            <span class="rate-value">5%</span>
                            <span class="rate-label">per month on reducing balance</span>
                        </div>
                        <ul class="product-features">
                            <li>Maximum amount: KSh 200,000</li>
                            <li>Repayment period: 4-6 months</li>
                            <li>No payslip consideration</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="special">Apply Now</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-coins" aria-hidden="true"></i>
                        </div>
                        <h3>Super Saver Loan</h3>
                        <div class="product-rate">
                            <span class="rate-value">12%</span>
                            <span class="rate-label">per annum on reducing balance</span>
                        </div>
                        <ul class="product-features">
                            <li>Maximum amount: KSh 3,000,000</li>
                            <li>Repayment period: Up to 48 months</li>
                            <li>For members with deposits > KSh 1M</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="super-saver">Apply Now</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card fade-in">
                        <div class="product-icon">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                        </div>
                        <h3>Salary Advance</h3>
                        <div class="product-rate">
                            <span class="rate-value">10%</span>
                            <span class="rate-label">one-off charge for first month</span>
                        </div>
                        <ul class="product-features">
                            <li>Repayment period: Up to 3 months</li>
                            <li>Quick processing</li>
                            <li>For short-term financial needs</li>
                        </ul>
                        <a href="#application-form" class="btn btn-primary w-100 loan-type-btn" data-loan-type="salary-advance">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form Section -->
    <section id="application-form" class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Loan Application Form</h2>
                <p class="section-subtitle">Please fill out all required fields</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="application-form-container fade-in">
                        <form id="loanApplicationForm" class="needs-validation" novalidate>
                            <!-- Loan Type Information (Hidden) -->
                            <input type="hidden" id="loanTypeInput" name="loan_type" value="">
                            
                            <!-- Loan Type Display -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Selected Loan Type</h3>
                                </div>
                                <div class="card-body">
                                    <div id="selectedLoanType" class="alert alert-info">
                                        Please select a loan type from the options above.
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Personal Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Personal Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="memberNumber" class="form-label">Member Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="memberNumber" name="member_number" required>
                                            <div class="invalid-feedback">
                                                Please enter your member number.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="idNumber" class="form-label">National ID/Passport Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="idNumber" name="id_number" required>
                                            <div class="invalid-feedback">
                                                Please enter your ID or passport number.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                                            <div class="invalid-feedback">
                                                Please enter your first name.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="middleName" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" id="middleName" name="middle_name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                                            <div class="invalid-feedback">
                                                Please enter your last name.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phoneNumber" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phoneNumber" name="phone_number" placeholder="e.g., 0700123456" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid phone number.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="department" class="form-label">Department/Faculty <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="department" name="department" required>
                                            <div class="invalid-feedback">
                                                Please enter your department or faculty.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="employmentStatus" class="form-label">Employment Status <span class="text-danger">*</span></label>
                                            <select class="form-select" id="employmentStatus" name="employment_status" required>
                                                <option value="" selected disabled>Select employment status</option>
                                                <option value="permanent">Permanent</option>
                                                <option value="contract">Contract</option>
                                                <option value="part_time">Part-time</option>
                                                <option value="retired">Retired</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select your employment status.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Loan Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Loan Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="loanAmount" class="form-label">Loan Amount (KSh) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">KSh</span>
                                                <input type="number" class="form-control" id="loanAmount" name="loan_amount" min="1000" required>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid loan amount.
                                            </div>
                                            <div class="form-text" id="loanAmountHelp">
                                                Maximum amount varies by loan type.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="repaymentPeriod" class="form-label">Repayment Period (months) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="repaymentPeriod" name="repayment_period" min="1" required>
                                                <span class="input-group-text">months</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid repayment period.
                                            </div>
                                            <div class="form-text" id="repaymentPeriodHelp">
                                                Maximum period varies by loan type.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="loanPurpose" class="form-label">Purpose of Loan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="loanPurpose" name="loan_purpose" rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Please describe the purpose of your loan.
                                        </div>
                                    </div>
                                    
                                    <div id="schoolFeesFields" class="loan-specific-fields" style="display: none;">
                                        <div class="mb-3">
                                            <label for="schoolName" class="form-label">School/Institution Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="schoolName" name="school_name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="feeStructure" class="form-label">Fee Structure/Admission Letter <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="feeStructure" name="fee_structure">
                                            <div class="form-text">
                                                Upload fee structure or admission letter (PDF or image, max 2MB).
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="emergencyFields" class="loan-specific-fields" style="display: none;">
                                        <div class="mb-3">
                                            <label for="emergencyType" class="form-label">Type of Emergency <span class="text-danger">*</span></label>
                                            <select class="form-select" id="emergencyType" name="emergency_type">
                                                <option value="" selected disabled>Select emergency type</option>
                                                <option value="medical">Medical Emergency</option>
                                                <option value="funeral">Funeral Expenses</option>
                                                <option value="legal">Legal/Court Fines</option>
                                                <option value="other">Other Emergency</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="emergencyEvidence" class="form-label">Supporting Documentation <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="emergencyEvidence" name="emergency_evidence">
                                            <div class="form-text">
                                                Upload evidence of emergency (PDF or image, max 2MB).
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="specialLoanFields" class="loan-specific-fields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Postdated Cheques Confirmation <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chequeConfirmation" name="cheque_confirmation">
                                                <label class="form-check-label" for="chequeConfirmation">
                                                    I confirm that I will provide postdated cheques as security for this loan.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="superSaverFields" class="loan-specific-fields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Deposit Confirmation <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="depositConfirmation" name="deposit_confirmation">
                                                <label class="form-check-label" for="depositConfirmation">
                                                    I confirm that I have deposits of more than KSh 1,000,000 in my account.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Guarantor Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Guarantor Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="daystar-notice notice-info mb-4">
                                        <p><strong>Note:</strong> The number of guarantors required depends on the loan amount:</p>
                                        <ul class="mb-0">
                                            <li>For loans up to KSh 500,000: Minimum 2 guarantors</li>
                                            <li>For loans between KSh 500,001 and KSh 1,000,000: Minimum 3 guarantors</li>
                                            <li>For loans above KSh 1,000,000: Minimum 4 guarantors</li>
                                        </ul>
                                    </div>
                                    
                                    <div id="guarantorsContainer">
                                        <!-- Guarantor 1 -->
                                        <div class="guarantor-section mb-4">
                                            <h4>Guarantor 1</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor1MemberNumber" class="form-label">Member Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="guarantor1MemberNumber" name="guarantor1_member_number" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor1Name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="guarantor1Name" name="guarantor1_name" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor1Phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" id="guarantor1Phone" name="guarantor1_phone" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor1Email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="guarantor1Email" name="guarantor1_email" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="guarantor1Amount" class="form-label">Amount Guaranteed (KSh) <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">KSh</span>
                                                    <input type="number" class="form-control" id="guarantor1Amount" name="guarantor1_amount" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Guarantor 2 -->
                                        <div class="guarantor-section mb-4">
                                            <h4>Guarantor 2</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor2MemberNumber" class="form-label">Member Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="guarantor2MemberNumber" name="guarantor2_member_number" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor2Name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="guarantor2Name" name="guarantor2_name" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor2Phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" id="guarantor2Phone" name="guarantor2_phone" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="guarantor2Email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="guarantor2Email" name="guarantor2_email" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="guarantor2Amount" class="form-label">Amount Guaranteed (KSh) <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">KSh</span>
                                                    <input type="number" class="form-control" id="guarantor2Amount" name="guarantor2_amount" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="button" id="addGuarantorBtn" class="btn btn-outline-primary">
                                            <i class="fas fa-plus me-2" aria-hidden="true"></i> Add Another Guarantor
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Supporting Documents -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Supporting Documents</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="payslip" class="form-label">Recent Pay Slip <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="payslip" name="payslip" required>
                                        <div class="form-text">
                                            Upload your most recent pay slip (PDF or image, max 2MB).
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="idCopy" class="form-label">National ID/Passport Copy <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="idCopy" name="id_copy" required>
                                        <div class="form-text">
                                            Upload a clear copy of your ID or passport (PDF or image, max 2MB).
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="bankStatement" class="form-label">Bank Statement (Last 3 Months) <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="bankStatement" name="bank_statement" required>
                                        <div class="form-text">
                                            Upload your bank statement for the last 3 months (PDF, max 5MB).
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="additionalDocuments" class="form-label">Additional Supporting Documents</label>
                                        <input type="file" class="form-control" id="additionalDocuments" name="additional_documents" multiple>
                                        <div class="form-text">
                                            Upload any additional documents to support your application (PDF or image, max 5MB each).
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Declarations -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Terms and Declarations</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="termsAgreement" name="terms_agreement" required>
                                            <label class="form-check-label" for="termsAgreement">
                                                I have read and agree to the <a href="<?php echo esc_url(home_url('terms-conditions')); ?>" target="_blank">Terms and Conditions</a> of Daystar Multi-Purpose Co-op Society Ltd.
                                            </label>
                                            <div class="invalid-feedback">
                                                You must agree to the terms and conditions.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="infoAccuracy" name="info_accuracy" required>
                                            <label class="form-check-label" for="infoAccuracy">
                                                I declare that the information provided in this application is true and accurate to the best of my knowledge.
                                            </label>
                                            <div class="invalid-feedback">
                                                You must confirm the accuracy of your information.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="deductionAuth" name="deduction_auth" required>
                                            <label class="form-check-label" for="deductionAuth">
                                                I authorize Daystar Multi-Purpose Co-op Society Ltd. to deduct the monthly loan repayments from my salary.
                                            </label>
                                            <div class="invalid-feedback">
                                                You must authorize salary deductions for loan repayments.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Loan Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Process Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">What Happens Next?</h2>
                <p class="section-subtitle">The loan application process</p>
            </div>
            
            <div class="application-steps fade-in">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Application Review</h3>
                            <p class="step-description">Your application is reviewed for completeness and eligibility.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <h3 class="step-title">Credit Committee</h3>
                            <p class="step-description">The credit committee evaluates and approves eligible applications.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Notification</h3>
                            <p class="step-description">You receive notification of approval within 3 days of committee meeting.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Disbursement</h3>
                            <p class="step-description">Approved loans are disbursed via your preferred payment method.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="daystar-notice notice-info mt-4 fade-in">
                <p><strong>Processing Time:</strong> Loan applications are typically processed within 7-14 working days from the date of submission, provided all required documentation is complete and in order.</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="text-center mb-5 fade-in">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Common questions about loan applications</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion fade-in" id="applicationFAQ">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Can I apply for multiple loans simultaneously?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#applicationFAQ">
                                <div class="accordion-body">
                                    <p>You cannot have multiple loans of the same type simultaneously. For example, you cannot have two Development Loans at the same time. However, you may be eligible for different types of loans concurrently (e.g., a Development Loan and a School Fees Loan), provided:</p>
                                    <ul>
                                        <li>Your current loan repayments are up to date</li>
                                        <li>Your pay slip can support the additional loan repayment</li>
                                        <li>You meet all other eligibility criteria for the additional loan</li>
                                    </ul>
                                    <p>Each application is assessed on a case-by-case basis by the credit committee.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What happens if my loan application is rejected?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#applicationFAQ">
                                <div class="accordion-body">
                                    <p>If your loan application is rejected, you will receive a notification explaining the reasons for the rejection. Common reasons include:</p>
                                    <ul>
                                        <li>Insufficient membership period or contributions</li>
                                        <li>Inadequate repayment capacity</li>
                                        <li>Incomplete or inaccurate documentation</li>
                                        <li>Outstanding loans of the same type</li>
                                        <li>Poor credit history with the cooperative</li>
                                    </ul>
                                    <p>You can address the issues and reapply after a period of 30 days. Our loan officers are available to provide guidance on how to improve your application for future consideration.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How are guarantors affected if I default on my loan?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#applicationFAQ">
                                <div class="accordion-body">
                                    <p>Guarantors play a crucial role in securing your loan. If you default on your loan repayments:</p>
                                    <ol>
                                        <li>The cooperative will first attempt to recover the outstanding amount from your shares and deposits.</li>
                                        <li>If your shares and deposits are insufficient, guarantors will be liable for the amount they guaranteed.</li>
                                        <li>The cooperative may recover the guaranteed amount from the guarantors' shares, deposits, or through salary deductions.</li>
                                    </ol>
                                    <p>It's important to maintain open communication with both the cooperative and your guarantors if you anticipate any difficulty in making repayments.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I repay my loan early?
                                </button>
                            </h3>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#applicationFAQ">
                                <div class="accordion-body">
                                    <p>Yes, you can repay your loan early without any prepayment penalties. Early repayment will reduce the total interest paid over the life of the loan. To make an early repayment:</p>
                                    <ol>
                                        <li>Contact our office or submit a request through your member portal.</li>
                                        <li>Specify whether you want to make a partial prepayment or fully settle the loan.</li>
                                        <li>For partial prepayments, indicate whether you want to reduce the monthly installment or the loan term.</li>
                                    </ol>
                                    <p>After processing your prepayment, we will provide you with an updated repayment schedule if applicable.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    How can I check the status of my loan application?
                                </button>
                            </h3>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#applicationFAQ">
                                <div class="accordion-body">
                                    <p>You can check the status of your loan application through several channels:</p>
                                    <ol>
                                        <li><strong>Member Portal:</strong> Log in to your online member portal to view your application status.</li>
                                        <li><strong>Email Notification:</strong> You will receive email updates at key stages of the application process.</li>
                                        <li><strong>SMS Alerts:</strong> Status updates will be sent to your registered mobile number.</li>
                                        <li><strong>Contact Office:</strong> Call or visit our office during working hours with your application reference number.</li>
                                    </ol>
                                    <p>The typical processing timeline is 7-14 working days, but this may vary depending on application volume and completeness of documentation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2 class="cta-title">Need Help with Your Application?</h2>
                        <p class="cta-subtitle">Our loan officers are ready to assist you with any questions or concerns.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo esc_url(home_url('contact-us')); ?>" class="btn btn-gradient btn-lg">Contact Us</a>
                        <a href="<?php echo esc_url(home_url('faqs')); ?>" class="btn btn-outline-light btn-lg ms-2">View FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Loan Application Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loan Type Selection
    const loanTypeButtons = document.querySelectorAll('.loan-type-btn');
    const loanTypeInput = document.getElementById('loanTypeInput');
    const selectedLoanType = document.getElementById('selectedLoanType');
    const loanSpecificFields = document.querySelectorAll('.loan-specific-fields');
    
    // Loan Amount and Repayment Period Help Text
    const loanAmountHelp = document.getElementById('loanAmountHelp');
    const repaymentPeriodHelp = document.getElementById('repaymentPeriodHelp');
    
    // Add Guarantor Button
    const addGuarantorBtn = document.getElementById('addGuarantorBtn');
    const guarantorsContainer = document.getElementById('guarantorsContainer');
    let guarantorCount = 2; // Starting with 2 guarantors
    
    // Form Validation
    const form = document.getElementById('loanApplicationForm');
    
    // Loan Type Selection
    loanTypeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get loan type from data attribute
            const loanType = this.getAttribute('data-loan-type');
            loanTypeInput.value = loanType;
            
            // Update selected loan type display
            updateSelectedLoanType(loanType);
            
            // Show/hide loan-specific fields
            showLoanSpecificFields(loanType);
            
            // Update loan amount and repayment period help text
            updateLoanLimits(loanType);
            
            // Smooth scroll to application form
            document.getElementById('application-form').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Update Selected Loan Type Display
    function updateSelectedLoanType(loanType) {
        let loanTypeText = '';
        let loanTypeDetails = '';
        
        switch(loanType) {
            case 'development':
                loanTypeText = 'Development Loan';
                loanTypeDetails = 'Maximum KSh 2,000,000, up to 36 months, 12% p.a. on reducing balance';
                break;
            case 'school-fees':
                loanTypeText = 'School Fees Loan';
                loanTypeDetails = 'Up to 12 months, 12% p.a. on reducing balance';
                break;
            case 'emergency':
                loanTypeText = 'Emergency Loan';
                loanTypeDetails = 'Maximum KSh 100,000, up to 12 months, 12% p.a. on reducing balance';
                break;
            case 'special':
                loanTypeText = 'Special Loan';
                loanTypeDetails = 'Maximum KSh 200,000, 4-6 months, 5% per month on reducing balance';
                break;
            case 'super-saver':
                loanTypeText = 'Super Saver Loan';
                loanTypeDetails = 'Maximum KSh 3,000,000, up to 48 months, 12% p.a. on reducing balance';
                break;
            case 'salary-advance':
                loanTypeText = 'Salary Advance';
                loanTypeDetails = 'Up to 3 months, 10% one-off charge for first month';
                break;
            default:
                loanTypeText = 'Please select a loan type';
                loanTypeDetails = '';
        }
        
        if (loanTypeDetails) {
            selectedLoanType.innerHTML = `<strong>${loanTypeText}</strong><br>${loanTypeDetails}`;
            selectedLoanType.classList.remove('alert-info');
            selectedLoanType.classList.add('alert-success');
        } else {
            selectedLoanType.innerHTML = loanTypeText;
            selectedLoanType.classList.remove('alert-success');
            selectedLoanType.classList.add('alert-info');
        }
    }
    
    // Show/Hide Loan-Specific Fields
    function showLoanSpecificFields(loanType) {
        // Hide all loan-specific fields first
        loanSpecificFields.forEach(field => {
            field.style.display = 'none';
        });
        
        // Show relevant fields based on loan type
        switch(loanType) {
            case 'school-fees':
                document.getElementById('schoolFeesFields').style.display = 'block';
                break;
            case 'emergency':
                document.getElementById('emergencyFields').style.display = 'block';
                break;
            case 'special':
                document.getElementById('specialLoanFields').style.display = 'block';
                break;
            case 'super-saver':
                document.getElementById('superSaverFields').style.display = 'block';
                break;
        }
    }
    
    // Update Loan Amount and Repayment Period Help Text
    function updateLoanLimits(loanType) {
        const loanAmount = document.getElementById('loanAmount');
        const repaymentPeriod = document.getElementById('repaymentPeriod');
        
        switch(loanType) {
            case 'development':
                loanAmount.max = 2000000;
                repaymentPeriod.max = 36;
                loanAmountHelp.textContent = 'Maximum amount: KSh 2,000,000';
                repaymentPeriodHelp.textContent = 'Maximum period: 36 months';
                break;
            case 'school-fees':
                loanAmount.max = 500000; // Assumed maximum
                repaymentPeriod.max = 12;
                loanAmountHelp.textContent = 'Amount based on fee structure';
                repaymentPeriodHelp.textContent = 'Maximum period: 12 months';
                break;
            case 'emergency':
                loanAmount.max = 100000;
                repaymentPeriod.max = 12;
                loanAmountHelp.textContent = 'Maximum amount: KSh 100,000';
                repaymentPeriodHelp.textContent = 'Maximum period: 12 months';
                break;
            case 'special':
                loanAmount.max = 200000;
                repaymentPeriod.max = 6;
                loanAmountHelp.textContent = 'Maximum amount: KSh 200,000';
                repaymentPeriodHelp.textContent = 'Period: 4-6 months based on amount';
                break;
            case 'super-saver':
                loanAmount.max = 3000000;
                repaymentPeriod.max = 48;
                loanAmountHelp.textContent = 'Maximum amount: KSh 3,000,000';
                repaymentPeriodHelp.textContent = 'Maximum period: 48 months';
                break;
            case 'salary-advance':
                loanAmount.max = 100000; // Assumed maximum
                repaymentPeriod.max = 3;
                loanAmountHelp.textContent = 'Amount based on salary';
                repaymentPeriodHelp.textContent = 'Maximum period: 3 months';
                break;
            default:
                loanAmountHelp.textContent = 'Maximum amount varies by loan type';
                repaymentPeriodHelp.textContent = 'Maximum period varies by loan type';
        }
    }
    
    // Add Guarantor
    addGuarantorBtn.addEventListener('click', function() {
        guarantorCount++;
        
        const guarantorSection = document.createElement('div');
        guarantorSection.className = 'guarantor-section mb-4';
        guarantorSection.innerHTML = `
            <h4>Guarantor ${guarantorCount}</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="guarantor${guarantorCount}MemberNumber" class="form-label">Member Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="guarantor${guarantorCount}MemberNumber" name="guarantor${guarantorCount}_member_number" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="guarantor${guarantorCount}Name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="guarantor${guarantorCount}Name" name="guarantor${guarantorCount}_name" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="guarantor${guarantorCount}Phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="guarantor${guarantorCount}Phone" name="guarantor${guarantorCount}_phone" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="guarantor${guarantorCount}Email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="guarantor${guarantorCount}Email" name="guarantor${guarantorCount}_email" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="guarantor${guarantorCount}Amount" class="form-label">Amount Guaranteed (KSh) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">KSh</span>
                    <input type="number" class="form-control" id="guarantor${guarantorCount}Amount" name="guarantor${guarantorCount}_amount" required>
                </div>
            </div>
        `;
        
        guarantorsContainer.appendChild(guarantorSection);
        
        // Hide add button if maximum guarantors reached
        if (guarantorCount >= 4) {
            addGuarantorBtn.style.display = 'none';
        }
    });
    
    // Form Validation
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                // Form is valid, show success message or submit
                event.preventDefault(); // For demo purposes
                
                // Show success message
                const successMessage = document.createElement('div');
                successMessage.className = 'alert alert-success mt-4';
                successMessage.innerHTML = `
                    <h4 class="alert-heading">Application Submitted Successfully!</h4>
                    <p>Your loan application has been received. You will receive a confirmation email shortly with your application reference number.</p>
                    <p>Please allow 7-14 working days for processing. You can check the status of your application through your member portal.</p>
                    <hr>
                    <p class="mb-0">Thank you for choosing Daystar Multi-Purpose Co-op Society Ltd.</p>
                `;
                
                form.parentNode.insertBefore(successMessage, form);
                form.style.display = 'none';
                
                // Scroll to success message
                successMessage.scrollIntoView({
                    behavior: 'smooth'
                });
            }
            
            form.classList.add('was-validated');
        });
    }
});
</script>

<?php
get_footer();
