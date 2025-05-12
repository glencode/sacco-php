/**
 * Member Portal JavaScript
 * Handles interactive elements in the member dashboard, charts, and other functionality
 */

(function($) {
    'use strict';
    
    // Document Ready
    $(document).ready(function() {
        // Initialize all charts when document is ready
        initDashboardCharts();
        
        // Initialize savings goals functionality
        initSavingsGoals();
        
        // Initialize transaction filters
        initTransactionFilters();
        
        // Initialize loan application form if it exists
        if ($('#loan-application-form').length) {
            initLoanApplication();
        }
        
        // Initialize profile forms
        initProfileForms();
    });
    
    /**
     * Initialize Dashboard Charts
     */
    function initDashboardCharts() {
        // Account Summary Chart
        if ($('#account-summary-chart').length) {
            const ctx = document.getElementById('account-summary-chart').getContext('2d');
            
            const accountChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [
                        {
                            label: 'Savings',
                            data: [95000, 100000, 105000, 110000, 115000, 120000, 125000],
                            borderColor: '#5ca157',
                            backgroundColor: 'rgba(92, 161, 87, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Shares',
                            data: [60000, 62000, 65000, 68000, 70000, 72000, 75000],
                            borderColor: '#a7a843',
                            backgroundColor: 'rgba(167, 168, 67, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Loans',
                            data: [280000, 270000, 260000, 250000, 245000, 240000, 230000],
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'KSh ' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'KSh ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Savings Distribution Chart
        if ($('#savings-distribution-chart').length) {
            const ctx = document.getElementById('savings-distribution-chart').getContext('2d');
            
            const savingsChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Regular Savings', 'Holiday Savings', 'Fixed Deposit', 'Shares'],
                    datasets: [{
                        data: [85000, 40000, 0, 75000],
                        backgroundColor: ['#5ca157', '#a7a843', '#2c3624', '#17a2b8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return label + ': KSh ' + value.toLocaleString() + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Loan Repayment Chart
        if ($('#loan-repayment-chart').length) {
            const ctx = document.getElementById('loan-repayment-chart').getContext('2d');
            
            const loanChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Development Loan', 'Emergency Loan'],
                    datasets: [
                        {
                            label: 'Paid',
                            data: [70000, 0],
                            backgroundColor: '#5ca157',
                        },
                        {
                            label: 'Remaining',
                            data: [180000, 50000],
                            backgroundColor: '#dc3545',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'KSh ' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'KSh ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    }
    
    /**
     * Initialize Savings Goals
     */
    function initSavingsGoals() {
        // Add New Goal Modal
        const addGoalModal = $('#addGoalModal');
        
        if (addGoalModal.length) {
            // Create New Goal Form Submission
            $('#add-goal-form').on('submit', function(e) {
                e.preventDefault();
                
                // Get form values
                const goalName = $('#goal-name').val();
                const goalAmount = $('#goal-amount').val();
                const goalDate = $('#goal-date').val();
                const initialDeposit = $('#initial-deposit').val();
                const goalDesc = $('#goal-description').val();
                
                // In a real application, this would save the goal to the database
                // For now, we'll just show a success message
                alert('Goal successfully created!');
                
                // Clear form and close modal
                $(this)[0].reset();
                addGoalModal.modal('hide');
                
                // In a real application, this would update the goals list without page refresh
            });
        }
        
        // Goal Funding Actions
        $('.add-funds-btn').on('click', function(e) {
            e.preventDefault();
            const goalId = $(this).data('goal-id');
            
            // In a real application, this would open a modal to add funds
            alert('In a real application, this would open a modal to add funds to your goal.');
        });
    }
    
    /**
     * Initialize Transaction Filters
     */
    function initTransactionFilters() {
        if ($('#transaction-filter-form').length) {
            // Filter form handling
            const filterForm = $('#transaction-filter-form');
            filterForm.on('submit', function(e) {
                e.preventDefault();
                // In a real application, this would make an AJAX call to fetch filtered transactions
                alert('Filters applied! In a real application, this would refresh the transaction list.');
            });
            
            // Print statement button
            $('#print-statement').on('click', function() {
                window.print();
            });
            
            // Download buttons (just simulated in this demo)
            $('#download-pdf').on('click', function() {
                alert('In a real application, this would generate and download a PDF of your transactions.');
            });
            
            $('#download-csv').on('click', function() {
                alert('In a real application, this would generate and download a CSV of your transactions.');
            });
        }
    }
    
    /**
     * Initialize Loan Application
     */
    function initLoanApplication() {
        // Loan Product Selection
        $('.loan-product-option').on('click', function() {
            const productId = $(this).data('product-id');
            const productTitle = $(this).find('.product-title').text();
            const interestRate = $(this).data('interest-rate');
            const maxAmount = $(this).data('max-amount');
            const maxTerm = $(this).data('max-term');
            
            // Update selected product info
            $('#selected-loan-title').text(productTitle);
            $('#interest-rate').text(interestRate);
            $('#max-amount').text(maxAmount);
            $('#max-term').text(maxTerm);
            
            // Update form field
            $('#loan-product-id').val(productId);
            
            // Activate next step
            $('#product-selection').removeClass('active');
            $('#loan-details').addClass('active');
            
            // Update progress bar
            updateProgressBar(2);
        });
        
        // Loan Amount Range Slider
        if ($('#loan-amount-range').length) {
            const loanAmountRange = $('#loan-amount-range');
            const loanAmountInput = $('#loan-amount');
            
            loanAmountRange.on('input', function() {
                loanAmountInput.val($(this).val());
                updateLoanSummary();
            });
            
            loanAmountInput.on('input', function() {
                loanAmountRange.val($(this).val());
                updateLoanSummary();
            });
        }
        
        // Loan Term Range Slider
        if ($('#loan-term-range').length) {
            const loanTermRange = $('#loan-term-range');
            const loanTermInput = $('#loan-term');
            
            loanTermRange.on('input', function() {
                loanTermInput.val($(this).val());
                updateLoanSummary();
            });
            
            loanTermInput.on('input', function() {
                loanTermRange.val($(this).val());
                updateLoanSummary();
            });
        }
        
        // Navigate between steps
        $('.next-step').on('click', function() {
            const currentStep = $(this).closest('.application-step');
            const nextStepId = $(this).data('next-step');
            
            // Validate current step (simplified for demo)
            if (!validateStep(currentStep)) {
                return;
            }
            
            // Hide current step and show next
            currentStep.removeClass('active');
            $('#' + nextStepId).addClass('active');
            
            // Update progress bar
            const stepNumber = parseInt(nextStepId.replace('step', ''));
            updateProgressBar(stepNumber);
        });
        
        $('.prev-step').on('click', function() {
            const currentStep = $(this).closest('.application-step');
            const prevStepId = $(this).data('prev-step');
            
            // Hide current step and show previous
            currentStep.removeClass('active');
            $('#' + prevStepId).addClass('active');
            
            // Update progress bar
            const stepNumber = parseInt(prevStepId.replace('step', ''));
            updateProgressBar(stepNumber);
        });
        
        // Submit loan application
        $('#loan-application-form').on('submit', function(e) {
            e.preventDefault();
            // In a real application, this would submit the form data to the server
            
            // Show success message
            $('#application-steps').hide();
            $('#application-success').show();
        });
        
        // Helper function to update loan summary
        function updateLoanSummary() {
            const loanAmount = parseFloat($('#loan-amount').val());
            const loanTerm = parseInt($('#loan-term').val());
            const interestRate = parseFloat($('#interest-rate').text().replace('%', '')) / 100;
            
            // Calculate monthly payment (PMT formula)
            const monthlyRate = interestRate / 12;
            const monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
            
            // Calculate total interest
            const totalPayment = monthlyPayment * loanTerm;
            const totalInterest = totalPayment - loanAmount;
            
            // Update summary
            $('#monthly-payment').text('KSh ' + monthlyPayment.toFixed(2));
            $('#total-interest').text('KSh ' + totalInterest.toFixed(2));
            $('#total-repayment').text('KSh ' + totalPayment.toFixed(2));
        }
        
        // Helper function to update progress bar
        function updateProgressBar(stepNumber) {
            const percent = ((stepNumber - 1) / 4) * 100;
            $('#application-progress-bar').css('width', percent + '%');
            $('#application-progress-bar').attr('aria-valuenow', percent);
        }
        
        // Helper function to validate step (simplified for demo)
        function validateStep(step) {
            let isValid = true;
            
            // Get all required fields in this step
            const requiredFields = step.find('[required]');
            
            // Check if all required fields are filled
            requiredFields.each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                // Show validation message
                step.find('.validation-message').show();
            } else {
                step.find('.validation-message').hide();
            }
            
            return isValid;
        }
    }
    
    /**
     * Initialize Profile Forms
     */
    function initProfileForms() {
        // Profile edit functionality
        if ($('#edit-profile-btn').length) {
            const editProfileBtn = $('#edit-profile-btn');
            const cancelProfileBtn = $('#cancel-profile-btn');
            const profileForm = $('#profile-form');
            const profileActions = $('#profile-actions');
            const profileInputs = profileForm.find('input, select');
            
            editProfileBtn.on('click', function() {
                profileInputs.prop('disabled', false);
                profileActions.show();
                editProfileBtn.hide();
            });
            
            cancelProfileBtn.on('click', function() {
                profileInputs.prop('disabled', true);
                profileActions.hide();
                editProfileBtn.show();
            });
            
            profileForm.on('submit', function(e) {
                e.preventDefault();
                // In a real application, this would make an AJAX call to update user profile
                alert('Profile information updated successfully!');
                profileInputs.prop('disabled', true);
                profileActions.hide();
                editProfileBtn.show();
            });
        }
        
        // Address edit functionality
        if ($('#edit-address-btn').length) {
            const editAddressBtn = $('#edit-address-btn');
            const cancelAddressBtn = $('#cancel-address-btn');
            const addressForm = $('#address-form');
            const addressActions = $('#address-actions');
            const addressInputs = addressForm.find('input, select');
            
            editAddressBtn.on('click', function() {
                addressInputs.prop('disabled', false);
                addressActions.show();
                editAddressBtn.hide();
            });
            
            cancelAddressBtn.on('click', function() {
                addressInputs.prop('disabled', true);
                addressActions.hide();
                editAddressBtn.show();
            });
            
            addressForm.on('submit', function(e) {
                e.preventDefault();
                // In a real application, this would make an AJAX call to update address
                alert('Address information updated successfully!');
                addressInputs.prop('disabled', true);
                addressActions.hide();
                editAddressBtn.show();
            });
        }
        
        // Security form
        if ($('#security-form').length) {
            const securityForm = $('#security-form');
            securityForm.on('submit', function(e) {
                e.preventDefault();
                // In a real application, this would verify and update the password
                alert('Password updated successfully!');
                $('#current-password').val('');
                $('#new-password').val('');
                $('#confirm-password').val('');
            });
        }
        
        // Notification form
        if ($('#notification-form').length) {
            const notificationForm = $('#notification-form');
            notificationForm.on('submit', function(e) {
                e.preventDefault();
                // In a real application, this would save notification preferences
                alert('Notification preferences saved successfully!');
            });
        }
    }
    
})(jQuery); 