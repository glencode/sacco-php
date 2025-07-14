<?php
/**
 * Template Name: Consolidated Loan Application
 * 
 * Unified loan application page with multiple application modes
 */

require_once get_template_directory() . '/includes/auth-helper.php';
require_once get_template_directory() . '/includes/loans/loan-core.php';
require_once get_template_directory() . '/includes/loan-products.php';

// Check if user is logged in and is a member
$current_user = daystar_check_member_access();

// Get member data
$user_id = $current_user->ID;
$member_number = get_user_meta($user_id, 'member_number', true);
$member_status = get_user_meta($user_id, 'member_status', true);

// Get application mode (basic or comprehensive)
$application_mode = $_GET['mode'] ?? 'basic';

// Check submission deadline for Development loans
$current_date = date('j');
$is_past_deadline = $current_date > 30;
$next_deadline = date('F Y', strtotime('first day of next month'));

get_header();
?>

<main id="primary" class="site-main loan-application-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="application-header text-center mb-5">
                    <h1 class="page-title">Loan Application</h1>
                    <p class="lead">Apply for a loan with our streamlined application process</p>
                    
                    <!-- Application Mode Selector -->
                    <div class="mode-selector mt-4">
                        <div class="btn-group" role="group">
                            <a href="?mode=basic" class="btn <?php echo $application_mode === 'basic' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                Basic Application
                            </a>
                            <a href="?mode=comprehensive" class="btn <?php echo $application_mode === 'comprehensive' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                Comprehensive Application
                            </a>
                        </div>
                        <div class="mode-description mt-3">
                            <?php if ($application_mode === 'basic') : ?>
                                <p class="text-muted">Quick application for standard loans with basic requirements</p>
                            <?php else : ?>
                                <p class="text-muted">Detailed application with comprehensive eligibility assessment and document upload</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($member_status !== 'active') : ?>
                    <div class="alert alert-warning">
                        <h5>Account Status: <?php echo ucfirst(esc_html($member_status)); ?></h5>
                        <p>Your account must be active to apply for a loan. Please contact the administrator for assistance.</p>
                    </div>
                <?php else : ?>
                    
                    <!-- Deadline Notice for Development Loans -->
                    <?php if ($is_past_deadline) : ?>
                        <div class="alert alert-warning mb-4">
                            <h5><i class="fas fa-exclamation-triangle"></i> Important Notice</h5>
                            <p><strong>Development Loan applications must be submitted by the 30th of each month.</strong></p>
                            <p>Today is past the deadline for this month. Applications for Development loans submitted now will be processed in the next cycle (<?php echo $next_deadline; ?>).</p>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info mb-4">
                            <h5><i class="fas fa-info-circle"></i> Submission Deadline</h5>
                            <p><strong>Development Loan applications must be submitted by the 30th of each month.</strong></p>
                            <p>Current deadline: <strong><?php echo date('F 30, Y'); ?></strong> (<?php echo (30 - $current_date); ?> days remaining)</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($application_mode === 'basic') : ?>
                        <!-- Basic Application Form -->
                        <?php include get_template_directory() . '/template-parts/loan-application-basic.php'; ?>
                    <?php else : ?>
                        <!-- Comprehensive Application Form -->
                        <?php include get_template_directory() . '/template-parts/loan-application-comprehensive.php'; ?>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
.loan-application-page {
    padding: 40px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.mode-selector .btn {
    padding: 12px 24px;
    font-weight: 600;
    border-radius: 25px;
}

.mode-selector .btn-group {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0 !important;
    padding: 20px;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.required {
    color: #dc3545;
}

.loan-summary {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
}

.summary-item {
    text-align: center;
    padding: 15px;
    background: white;
    border-radius: 8px;
    margin-bottom: 15px;
}

.summary-item label {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.summary-value {
    font-size: 1.2rem;
    font-weight: bold;
    color: #495057;
}

@media (max-width: 768px) {
    .mode-selector .btn-group {
        flex-direction: column;
    }
    
    .mode-selector .btn {
        margin-bottom: 10px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Initialize the appropriate application form based on mode
    const applicationMode = '<?php echo $application_mode; ?>';
    
    if (applicationMode === 'basic') {
        initializeBasicApplication();
    } else {
        initializeComprehensiveApplication();
    }
    
    function initializeBasicApplication() {
        // Basic application initialization
        console.log('Initializing basic loan application');
        
        // Add basic form handlers here
        $('#basic-loan-application-form').on('submit', function(e) {
            e.preventDefault();
            submitBasicApplication();
        });
    }
    
    function initializeComprehensiveApplication() {
        // Comprehensive application initialization
        console.log('Initializing comprehensive loan application');
        
        // Add comprehensive form handlers here
        $('#comprehensive-loan-application-form').on('submit', function(e) {
            e.preventDefault();
            submitComprehensiveApplication();
        });
    }
    
    function submitBasicApplication() {
        const formData = new FormData($('#basic-loan-application-form')[0]);
        formData.append('action', 'submit_loan_application');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccessMessage(response.data);
                } else {
                    showErrorMessage(response.data);
                }
            },
            error: function() {
                showErrorMessage('An error occurred. Please try again.');
            }
        });
    }
    
    function submitComprehensiveApplication() {
        const formData = new FormData($('#comprehensive-loan-application-form')[0]);
        formData.append('action', 'submit_comprehensive_loan_application');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccessMessage(response.data);
                } else {
                    showErrorMessage(response.data);
                }
            },
            error: function() {
                showErrorMessage('An error occurred. Please try again.');
            }
        });
    }
    
    function showSuccessMessage(data) {
        Swal.fire({
            title: 'Application Submitted Successfully!',
            html: `
                <p>${data.message}</p>
                <p><strong>Waiting Number: ${data.waiting_number}</strong></p>
                <p>You will receive a confirmation email shortly.</p>
            `,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        });
    }
    
    function showErrorMessage(error) {
        let errorMessage = 'An error occurred. Please try again.';
        
        if (typeof error === 'object' && error.errors) {
            errorMessage = error.errors.join('<br>');
        } else if (typeof error === 'string') {
            errorMessage = error;
        }
        
        Swal.fire({
            title: 'Application Error',
            html: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});
</script>

<?php get_footer(); ?>