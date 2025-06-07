/**
 * Daystar Member Dashboard Module
 * 
 * This module provides member dashboard functionality specific to Daystar Multi-Purpose Co-op Society Ltd.
 * It implements the member dashboard features as required by Daystar's operational policies.
 */

class DaystarMemberDashboard {
    /**
     * Initialize member dashboard
     * 
     * @param {string} dashboardId - ID of the dashboard container element
     */
    static initializeDashboard(dashboardId) {
        const dashboard = document.getElementById(dashboardId);
        if (!dashboard) return;
        
        // Initialize dashboard components
        this.initializeAccountSummary();
        this.initializeLoanSummary();
        this.initializeContributionChart();
        this.initializeNotifications();
        this.initializeQuickActions();
        this.initializeDocumentUploads(); // Add document upload initialization
    }
    
    /**
     * Initialize account summary section
     */
    static initializeAccountSummary() {
        const accountSummary = document.getElementById('account-summary');
        if (!accountSummary) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const accountData = {
            totalContributions: 250000,
            shareCapital: 15000,
            availableBalance: 235000,
            lastContribution: {
                amount: 12000,
                date: '2025-05-15'
            },
            memberSince: '2023-11-10',
            membershipStatus: 'Active'
        };
        
        // Update account summary with data
        const contributionsElement = accountSummary.querySelector('.total-contributions');
        if (contributionsElement) {
            contributionsElement.textContent = `KSh ${accountData.totalContributions.toLocaleString()}`;
        }
        
        const shareCapitalElement = accountSummary.querySelector('.share-capital');
        if (shareCapitalElement) {
            shareCapitalElement.textContent = `KSh ${accountData.shareCapital.toLocaleString()}`;
        }
        
        const availableBalanceElement = accountSummary.querySelector('.available-balance');
        if (availableBalanceElement) {
            availableBalanceElement.textContent = `KSh ${accountData.availableBalance.toLocaleString()}`;
        }
        
        const lastContributionElement = accountSummary.querySelector('.last-contribution');
        if (lastContributionElement) {
            const date = new Date(accountData.lastContribution.date);
            lastContributionElement.textContent = `KSh ${accountData.lastContribution.amount.toLocaleString()} on ${date.toLocaleDateString()}`;
        }
        
        const memberSinceElement = accountSummary.querySelector('.member-since');
        if (memberSinceElement) {
            const date = new Date(accountData.memberSince);
            memberSinceElement.textContent = date.toLocaleDateString();
        }
        
        const membershipStatusElement = accountSummary.querySelector('.membership-status');
        if (membershipStatusElement) {
            membershipStatusElement.textContent = accountData.membershipStatus;
            
            // Add status indicator
            if (accountData.membershipStatus === 'Active') {
                membershipStatusElement.classList.add('text-success');
            } else {
                membershipStatusElement.classList.add('text-danger');
            }
        }
    }
    
    /**
     * Initialize loan summary section
     */
    static initializeLoanSummary() {
        const loanSummary = document.getElementById('loan-summary');
        if (!loanSummary) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const loanData = {
            activeLoans: [
                {
                    id: 'DSL-20250315-001',
                    type: 'Development Loan',
                    originalAmount: 500000,
                    remainingBalance: 425000,
                    monthlyPayment: 16667,
                    nextPaymentDate: '2025-06-15',
                    status: 'Current'
                }
            ],
            loanHistory: [
                {
                    id: 'DSL-20240110-002',
                    type: 'School Fees Loan',
                    originalAmount: 150000,
                    status: 'Paid',
                    completionDate: '2025-01-10'
                },
                {
                    id: 'DSL-20230605-003',
                    type: 'Emergency Loan',
                    originalAmount: 50000,
                    status: 'Paid',
                    completionDate: '2023-12-05'
                }
            ],
            eligibility: {
                maxEligibleAmount: 1500000,
                eligibleLoanTypes: ['Development', 'School Fees', 'Emergency', 'Special', 'Salary Advance']
            }
        };
        
        // Update active loans section
        const activeLoansContainer = loanSummary.querySelector('.active-loans');
        if (activeLoansContainer) {
            if (loanData.activeLoans.length > 0) {
                let activeLoansHtml = '';
                
                loanData.activeLoans.forEach(loan => {
                    activeLoansHtml += `
                        <div class="loan-item card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${loan.type} <span class="badge ${loan.status === 'Current' ? 'bg-success' : 'bg-warning'}">${loan.status}</span></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Loan ID:</strong> ${loan.id}</p>
                                        <p class="mb-1"><strong>Original Amount:</strong> KSh ${loan.originalAmount.toLocaleString()}</p>
                                        <p class="mb-1"><strong>Remaining Balance:</strong> KSh ${loan.remainingBalance.toLocaleString()}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Monthly Payment:</strong> KSh ${loan.monthlyPayment.toLocaleString()}</p>
                                        <p class="mb-1"><strong>Next Payment:</strong> ${new Date(loan.nextPaymentDate).toLocaleDateString()}</p>
                                        <a href="#" class="btn btn-sm btn-primary mt-2">View Details</a>
                                    </div>
                                </div>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: ${Math.round((1 - loan.remainingBalance / loan.originalAmount) * 100)}%" 
                                        aria-valuenow="${Math.round((1 - loan.remainingBalance / loan.originalAmount) * 100)}" aria-valuemin="0" aria-valuemax="100">
                                        ${Math.round((1 - loan.remainingBalance / loan.originalAmount) * 100)}% Paid
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                activeLoansContainer.innerHTML = activeLoansHtml;
            } else {
                activeLoansContainer.innerHTML = `
                    <div class="alert alert-info">
                        You have no active loans at this time.
                    </div>
                `;
            }
        }
        
        // Update loan history section
        const loanHistoryContainer = loanSummary.querySelector('.loan-history');
        if (loanHistoryContainer) {
            if (loanData.loanHistory.length > 0) {
                let loanHistoryHtml = `
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Loan ID</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Completion Date</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                loanData.loanHistory.forEach(loan => {
                    loanHistoryHtml += `
                        <tr>
                            <td>${loan.id}</td>
                            <td>${loan.type}</td>
                            <td>KSh ${loan.originalAmount.toLocaleString()}</td>
                            <td><span class="badge bg-success">${loan.status}</span></td>
                            <td>${new Date(loan.completionDate).toLocaleDateString()}</td>
                        </tr>
                    `;
                });
                
                loanHistoryHtml += `
                            </tbody>
                        </table>
                    </div>
                `;
                
                loanHistoryContainer.innerHTML = loanHistoryHtml;
            } else {
                loanHistoryContainer.innerHTML = `
                    <div class="alert alert-info">
                        You have no loan history at this time.
                    </div>
                `;
            }
        }
        
        // Update loan eligibility section
        const loanEligibilityContainer = loanSummary.querySelector('.loan-eligibility');
        if (loanEligibilityContainer) {
            let eligibilityHtml = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loan Eligibility</h5>
                        <p><strong>Maximum Eligible Amount:</strong> KSh ${loanData.eligibility.maxEligibleAmount.toLocaleString()}</p>
                        <p><strong>Eligible Loan Types:</strong></p>
                        <ul>
            `;
            
            loanData.eligibility.eligibleLoanTypes.forEach(type => {
                eligibilityHtml += `<li>${type} Loan</li>`;
            });
            
            eligibilityHtml += `
                        </ul>
                        <a href="page-loan-application.php" class="btn btn-primary">Apply for a Loan</a>
                    </div>
                </div>
            `;
            
            loanEligibilityContainer.innerHTML = eligibilityHtml;
        }
    }
    
    /**
     * Initialize contribution chart
     */
    static initializeContributionChart() {
        const contributionChartContainer = document.getElementById('contribution-chart');
        if (!contributionChartContainer) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const contributionData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Monthly Contributions',
                    data: [12000, 12000, 12000, 12000, 12000, 12000],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        };
        
        // Check if Chart.js is available
        if (typeof Chart !== 'undefined') {
            // Create chart
            const ctx = contributionChartContainer.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: contributionData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KSh ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'KSh ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Fallback if Chart.js is not available
            contributionChartContainer.innerHTML = `
                <div class="alert alert-warning">
                    Chart visualization is not available. Please ensure Chart.js is loaded.
                </div>
            `;
        }
    }
    
    /**
     * Initialize notifications section
     */
    static initializeNotifications() {
        const notificationsContainer = document.getElementById('notifications');
        if (!notificationsContainer) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const notifications = [
            {
                id: 1,
                type: 'info',
                message: 'Your loan application has been received and is being processed.',
                date: '2025-05-30T10:15:00',
                read: false
            },
            {
                id: 2,
                type: 'success',
                message: 'Your monthly contribution of KSh 12,000 has been received.',
                date: '2025-05-15T09:30:00',
                read: true
            },
            {
                id: 3,
                type: 'warning',
                message: 'Your loan payment is due in 3 days.',
                date: '2025-05-12T14:45:00',
                read: true
            }
        ];
        
        // Update notifications container
        if (notifications.length > 0) {
            let notificationsHtml = '';
            
            notifications.forEach(notification => {
                const date = new Date(notification.date);
                const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                
                let iconClass = '';
                switch (notification.type) {
                    case 'info':
                        iconClass = 'bi bi-info-circle text-info';
                        break;
                    case 'success':
                        iconClass = 'bi bi-check-circle text-success';
                        break;
                    case 'warning':
                        iconClass = 'bi bi-exclamation-triangle text-warning';
                        break;
                    case 'danger':
                        iconClass = 'bi bi-x-circle text-danger';
                        break;
                    default:
                        iconClass = 'bi bi-bell';
                }
                
                notificationsHtml += `
                    <div class="notification-item ${notification.read ? '' : 'unread'}" data-id="${notification.id}">
                        <div class="notification-icon">
                            <i class="${iconClass}"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-message">${notification.message}</p>
                            <p class="notification-date">${formattedDate}</p>
                        </div>
                        ${notification.read ? '' : '<span class="unread-indicator"></span>'}
                    </div>
                `;
            });
            
            notificationsContainer.innerHTML = notificationsHtml;
            
            // Add event listeners to mark notifications as read
            const unreadNotifications = notificationsContainer.querySelectorAll('.notification-item.unread');
            unreadNotifications.forEach(item => {
                item.addEventListener('click', () => {
                    // In a real implementation, this would send a request to the server
                    item.classList.remove('unread');
                    item.querySelector('.unread-indicator').remove();
                });
            });
        } else {
            notificationsContainer.innerHTML = `
                <div class="alert alert-info">
                    You have no notifications at this time.
                </div>
            `;
        }
    }
    
    /**
     * Initialize quick actions section
     */
    static initializeQuickActions() {
        const quickActionsContainer = document.getElementById('quick-actions');
        if (!quickActionsContainer) return;
        
        // Add event listeners to quick action buttons
        const applyLoanBtn = quickActionsContainer.querySelector('.apply-loan-btn');
        if (applyLoanBtn) {
            applyLoanBtn.addEventListener('click', () => {
                window.location.href = 'page-loan-application.php';
            });
        }
        
        const checkEligibilityBtn = quickActionsContainer.querySelector('.check-eligibility-btn');
        if (checkEligibilityBtn) {
            checkEligibilityBtn.addEventListener('click', () => {
                window.location.href = 'page-loan-calculator.php';
            });
        }
        
        const updateProfileBtn = quickActionsContainer.querySelector('.update-profile-btn');
        if (updateProfileBtn) {
            updateProfileBtn.addEventListener('click', () => {
                window.location.href = 'page-profile.php';
            });
        }
        
        const contactSupportBtn = quickActionsContainer.querySelector('.contact-support-btn');
        if (contactSupportBtn) {
            contactSupportBtn.addEventListener('click', () => {
                window.location.href = 'page-contact-us.php';
            });
        }
    }
    
    /**
     * Initialize loan application status section
     */
    static initializeLoanApplicationStatus() {
        const loanApplicationStatusContainer = document.getElementById('loan-application-status');
        if (!loanApplicationStatusContainer) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const applicationData = {
            hasActiveApplication: true,
            application: {
                id: 'DSL-APP-20250525-001',
                type: 'Development Loan',
                amount: 750000,
                submissionDate: '2025-05-25',
                status: 'Under Review',
                currentStage: 'Credit Committee Review',
                nextStage: 'Final Approval',
                estimatedCompletionDate: '2025-06-05'
            }
        };
        
        // Update loan application status container
        if (applicationData.hasActiveApplication) {
            const application = applicationData.application;
            const submissionDate = new Date(application.submissionDate);
            const estimatedCompletionDate = new Date(application.estimatedCompletionDate);
            
            let statusClass = '';
            switch (application.status) {
                case 'Pending':
                    statusClass = 'bg-secondary';
                    break;
                case 'Under Review':
                    statusClass = 'bg-primary';
                    break;
                case 'Approved':
                    statusClass = 'bg-success';
                    break;
                case 'Rejected':
                    statusClass = 'bg-danger';
                    break;
                default:
                    statusClass = 'bg-info';
            }
            
            let applicationHtml = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loan Application Status</h5>
                        <div class="application-details">
                            <p><strong>Application ID:</strong> ${application.id}</p>
                            <p><strong>Loan Type:</strong> ${application.type}</p>
                            <p><strong>Amount:</strong> KSh ${application.amount.toLocaleString()}</p>
                            <p><strong>Submission Date:</strong> ${submissionDate.toLocaleDateString()}</p>
                            <p><strong>Status:</strong> <span class="badge ${statusClass}">${application.status}</span></p>
                            <p><strong>Current Stage:</strong> ${application.currentStage}</p>
                            <p><strong>Next Stage:</strong> ${application.nextStage}</p>
                            <p><strong>Estimated Completion:</strong> ${estimatedCompletionDate.toLocaleDateString()}</p>
                        </div>
                        
                        <div class="application-progress mt-4">
                            <h6>Application Progress</h6>
                            <div class="progress-steps">
                                <div class="progress-step completed">
                                    <div class="step-icon">1</div>
                                    <div class="step-label">Submission</div>
                                </div>
                                <div class="progress-step completed">
                                    <div class="step-icon">2</div>
                                    <div class="step-label">Initial Review</div>
                                </div>
                                <div class="progress-step active">
                                    <div class="step-icon">3</div>
                                    <div class="step-label">Committee Review</div>
                                </div>
                                <div class="progress-step">
                                    <div class="step-icon">4</div>
                                    <div class="step-label">Final Approval</div>
                                </div>
                                <div class="progress-step">
                                    <div class="step-icon">5</div>
                                    <div class="step-label">Disbursement</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            loanApplicationStatusContainer.innerHTML = applicationHtml;
        } else {
            loanApplicationStatusContainer.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Loan Application Status</h5>
                        <div class="alert alert-info">
                            You have no active loan applications at this time.
                        </div>
                        <a href="page-loan-application.php" class="btn btn-primary">Apply for a Loan</a>
                    </div>
                </div>
            `;
        }
    }
    
    /**
     * Initialize document uploads
     */
    static initializeDocumentUploads() {
        const uploadButtons = document.querySelectorAll('.document-upload-card button');
        
        uploadButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.document-upload-card');
                const input = card.querySelector('input[type="file"]');
                const documentType = card.querySelector('h4').textContent.trim();
                
                if (!input.files || !input.files[0]) {
                    alert('Please select a file to upload');
                    return;
                }

                const formData = new FormData();
                formData.append('action', 'daystar_upload_document');
                formData.append('security', daystarData.documentUploadNonce);
                formData.append('document', input.files[0]);
                formData.append('document_type', documentType);

                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

                fetch(daystarData.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'alert alert-success mt-2';
                        successDiv.textContent = 'Document uploaded successfully';
                        card.appendChild(successDiv);
                        
                        // Clear input
                        input.value = '';
                        
                        // Update document count if available
                        const countElement = document.querySelector('.document-count');
                        if (countElement) {
                            const [current, total] = countElement.textContent.split('/');
                            countElement.textContent = `${parseInt(current) + 1}/${total}`;
                        }

                        // Remove success message after 3 seconds
                        setTimeout(() => successDiv.remove(), 3000);
                    } else {
                        alert(data.data || 'Upload failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Upload failed. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    button.disabled = false;
                    button.textContent = 'Upload';
                });
            });
        });
    }
}

// Export the dashboard module for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarMemberDashboard;
}
