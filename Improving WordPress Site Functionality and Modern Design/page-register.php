<?php
/**
 * Template Name: Registration Page
 * 
 * This is the template for the member registration page.
 * It includes a multi-step registration form based on the credit policy requirements.
 */

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Member Registration</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Register</li>
            </ol>
        </nav>
    </div>
</div>

<section class="registration-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="card-title text-center mb-4">Become a Member</h2>
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                        </div>
                        
                        <!-- Registration Form -->
                        <form id="registration-form" class="needs-validation" novalidate>
                            <!-- Error Messages -->
                            <div class="alert alert-danger d-none error-messages" role="alert"></div>
                            
                            <!-- Success Message -->
                            <div class="alert alert-success d-none success-message" role="alert"></div>
                            
                            <!-- Step 1: Personal Information -->
                            <div class="form-step" id="step1">
                                <h3 class="mb-4">Personal Information</h3>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                        <div class="form-text">Enter your phone number in the format: 07XX XXX XXX</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_number" class="form-label">ID Number</label>
                                        <input type="text" class="form-control" id="id_number" name="id_number" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" selected disabled>Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Physical Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary btn-next-step">Next Step</button>
                                </div>
                            </div>
                            
                            <!-- Step 2: Employment & Contribution -->
                            <div class="form-step d-none" id="step2">
                                <h3 class="mb-4">Employment & Contribution</h3>
                                
                                <div class="mb-3">
                                    <label for="employment_status" class="form-label">Employment Status</label>
                                    <select class="form-select" id="employment_status" name="employment_status" required>
                                        <option value="" selected disabled>Select employment status</option>
                                        <option value="employed">Employed</option>
                                        <option value="self-employed">Self-Employed</option>
                                        <option value="business">Business Owner</option>
                                        <option value="retired">Retired</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3 employment-details">
                                    <label for="employer" class="form-label">Employer/Business Name</label>
                                    <input type="text" class="form-control" id="employer" name="employer">
                                </div>
                                
                                <div class="row employment-details">
                                    <div class="col-md-6 mb-3">
                                        <label for="job_title" class="form-label">Job Title/Position</label>
                                        <input type="text" class="form-control" id="job_title" name="job_title">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="monthly_income" class="form-label">Monthly Income (KSh)</label>
                                        <input type="number" class="form-control" id="monthly_income" name="monthly_income">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="initial_contribution" class="form-label">Initial Contribution (KSh)</label>
                                    <input type="number" class="form-control" id="initial_contribution" name="initial_contribution" min="12000" required>
                                    <div class="form-text">Minimum initial contribution is KSh 12,000 as per the credit policy.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="monthly_contribution" class="form-label">Monthly Contribution (KSh)</label>
                                    <input type="number" class="form-control" id="monthly_contribution" name="monthly_contribution" min="1000" required>
                                    <div class="form-text">Minimum monthly contribution is KSh 1,000.</div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary btn-prev-step">Previous Step</button>
                                    <button type="button" class="btn btn-primary btn-next-step">Next Step</button>
                                </div>
                            </div>
                            
                            <!-- Step 3: Account Setup -->
                            <div class="form-step d-none" id="step3">
                                <h3 class="mb-4">Account Setup</h3>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Create Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary password-toggle" type="button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Password must be at least 8 characters long.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        <button class="btn btn-outline-secondary password-toggle" type="button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="next_of_kin_name" class="form-label">Next of Kin Name</label>
                                    <input type="text" class="form-control" id="next_of_kin_name" name="next_of_kin_name" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="next_of_kin_phone" class="form-label">Next of Kin Phone</label>
                                    <input type="tel" class="form-control" id="next_of_kin_phone" name="next_of_kin_phone" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="next_of_kin_relationship" class="form-label">Relationship to Next of Kin</label>
                                    <select class="form-select" id="next_of_kin_relationship" name="next_of_kin_relationship" required>
                                        <option value="" selected disabled>Select relationship</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="parent">Parent</option>
                                        <option value="child">Child</option>
                                        <option value="sibling">Sibling</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="<?php echo home_url('terms-and-conditions'); ?>" target="_blank">Terms and Conditions</a> and <a href="<?php echo home_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a>
                                    </label>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary btn-prev-step">Previous Step</button>
                                    <button type="submit" class="btn btn-success">Complete Registration</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Registration Info -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Registration Information</h5>
                        <p>By registering, you will become a member of Daystar Multi-Purpose Co-op Society Ltd. Here's what you need to know:</p>
                        <ul>
                            <li>Minimum initial contribution is KSh 12,000</li>
                            <li>Minimum monthly contribution is KSh 1,000</li>
                            <li>You will need to provide valid identification</li>
                            <li>Your application will be reviewed within 2-3 business days</li>
                        </ul>
                        <p>If you have any questions, please contact our support team at <a href="mailto:info@daystarsacco.co.ke">info@daystarsacco.co.ke</a> or call +254 731 629 716.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize authentication module
        if (typeof DaystarAuthentication !== 'undefined') {
            DaystarAuthentication.initializeRegistrationForm('registration-form');
        }
        
        // Employment status conditional fields
        const employmentStatus = document.getElementById('employment_status');
        const employmentDetails = document.querySelectorAll('.employment-details');
        
        if (employmentStatus) {
            employmentStatus.addEventListener('change', function() {
                const showDetails = this.value !== '' && this.value !== 'other';
                
                employmentDetails.forEach(function(element) {
                    if (showDetails) {
                        element.classList.remove('d-none');
                    } else {
                        element.classList.add('d-none');
                    }
                });
            });
        }
    });
</script>

<?php get_footer(); ?>
