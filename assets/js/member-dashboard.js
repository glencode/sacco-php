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
        this.initializeTabs();
        this.initializeAccountSummary();
        this.initializeLoanSummary();
        this.initializeContributionChart();
        this.initializeNotifications();
        this.initializeQuickActions();
        this.initializeDocumentUploads(); // Add document upload initialization
    }
    
    /**
     * Initialize tab functionality
     */
    static initializeTabs() {
        const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all tabs and panes
                tabLinks.forEach(l => l.classList.remove('active'));
                tabPanes.forEach(p => {
                    p.classList.remove('active', 'show');
                    p.style.display = 'none';
                });
                
                // Add active class to clicked tab
                link.classList.add('active');
                
                // Show corresponding tab pane
                const targetId = link.getAttribute('data-bs-target') || link.getAttribute('href');
                if (targetId) {
                    const targetPane = document.querySelector(targetId);
                    if (targetPane) {
                        targetPane.classList.add('active', 'show');
                        targetPane.style.display = 'block';
                    }
                }
            });
        });
        
        // Show first tab by default
        if (tabLinks.length > 0) {
            tabLinks[0].click();
        }
    }
    
    /**
     * Initialize account summary section
     */
    static async initializeAccountSummary() {
        const accountSummary = document.getElementById('account-summary');
        if (!accountSummary) return;
        
        try {
            // Fetch real account data from WordPress AJAX
            const response = await fetch(daystar_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_member_dashboard_data',
                    nonce: daystar_ajax.nonce
                })
            });

            if (!response.ok) {
                throw new Error('Failed to fetch account data');
            }

            const data = await response.json();
            
            if (data.success) {
                const accountData = data.data;
                
                // Update account summary with real data
                const contributionsElement = accountSummary.querySelector('.total-contributions');
                if (contributionsElement) {
                    contributionsElement.textContent = `KSh ${parseFloat(accountData.total_contributions || 0).toLocaleString()}`;
                }
                
                const availableBalanceElement = accountSummary.querySelector('.available-balance');
                if (availableBalanceElement) {
                    availableBalanceElement.textContent = `KSh ${parseFloat(accountData.balance || 0).toLocaleString()}`;
                }
                
                // Update other elements if they exist
                const balanceElement = document.querySelector('.account-balance .balance-amount');
                if (balanceElement) {
                    balanceElement.textContent = `KSh ${parseFloat(accountData.balance || 0).toLocaleString()}`;
                }

                const contributionElement = document.querySelector('.contribution-amount');
                if (contributionElement) {
                    contributionElement.textContent = `KSh ${parseFloat(accountData.total_contributions || 0).toLocaleString()}`;
                }

                const loanElement = document.querySelector('.loan-amount');
                if (loanElement) {
                    loanElement.textContent = `KSh ${parseFloat(accountData.total_loans || 0).toLocaleString()}`;
                }

                const savingsElement = document.querySelector('.savings-amount');
                if (savingsElement) {
                    savingsElement.textContent = `KSh ${parseFloat(accountData.balance || 0).toLocaleString()}`;
                }
            } else {
                console.error('Error fetching account data:', data.data);
                this.showFallbackAccountData();
            }
        } catch (error) {
            console.error('Error fetching account data:', error);
            this.showFallbackAccountData();
        }
    }
    
    /**
     * Show fallback data when API fails
     */
    static showFallbackAccountData() {
        const fallbackData = {
            balance: 0,
            contributions: 0,
            loans: 0
        };

        // Update with fallback data
        const contributionsElement = document.querySelector('.total-contributions');
        if (contributionsElement) {
            contributionsElement.textContent = `KSh ${fallbackData.contributions.toLocaleString()}`;
        }
        
        const availableBalanceElement = document.querySelector('.available-balance');
        if (availableBalanceElement) {
            availableBalanceElement.textContent = `KSh ${fallbackData.balance.toLocaleString()}`;
        }
        
        const balanceElement = document.querySelector('.account-balance .balance-amount');
        if (balanceElement) {
            balanceElement.textContent = `KSh ${fallbackData.balance.toLocaleString()}`;
        }

        const contributionElement = document.querySelector('.contribution-amount');
        if (contributionElement) {
            contributionElement.textContent = `KSh ${fallbackData.contributions.toLocaleString()}`;
        }

        const loanElement = document.querySelector('.loan-amount');
        if (loanElement) {
            loanElement.textContent = `KSh ${fallbackData.loans.toLocaleString()}`;
        }

        const savingsElement = document.querySelector('.savings-amount');
        if (savingsElement) {
            savingsElement.textContent = `KSh ${fallbackData.balance.toLocaleString()}`;
        }
    }
    
    /**
     * Initialize loan summary section
     */
    static async initializeLoanSummary() {
        const loanSummary = document.getElementById('loan-summary');
        if (!loanSummary) return;
        
        try {
            // Fetch real loan data from WordPress AJAX
            const response = await fetch(daystar_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_member_loan_data',
                    nonce: daystar_ajax.nonce
                })
            });

            if (!response.ok) {
                throw new Error('Failed to fetch loan data');
            }

            const data = await response.json();
            
            if (data.success) {
                const loanData = data.data;
                this.renderLoanData(loanData, loanSummary);
            } else {
                console.error('Error fetching loan data:', data.data);
                this.showFallbackLoanData(loanSummary);
            }
        } catch (error) {
            console.error('Error fetching loan data:', error);
            this.showFallbackLoanData(loanSummary);
        }
    }
    
    /**
     * Render loan data to the UI
     */
    static renderLoanData(loanData, loanSummary) {
        // Default structure if no data
        const defaultLoanData = {
            activeLoans: loanData.activeLoans || [],
            loanHistory: loanData.loanHistory || [],
            eligibility: loanData.eligibility || {
                maxEligibleAmount: 0,
                eligibleLoanTypes: []
            }
        };
        
        // Update active loans section
        const activeLoansContainer = loanSummary.querySelector('.active-loans');
        if (activeLoansContainer) {
            if (defaultLoanData.activeLoans.length > 0) {
                let activeLoansHtml = '';
                
                defaultLoanData.activeLoans.forEach(loan => {
                    const originalAmount = parseFloat(loan.amount || loan.originalAmount || 0);
                    const remainingBalance = parseFloat(loan.balance || loan.remainingBalance || originalAmount);
                    const monthlyPayment = parseFloat(loan.monthly_payment || loan.monthlyPayment || 0);
                    const progressPercent = originalAmount > 0 ? Math.round((1 - remainingBalance / originalAmount) * 100) : 0;
                    
                    activeLoansHtml += `
                        <div class="loan-item glass-card mb-3">
                        <div class="card-body">
                                <h5 class="card-title">${loan.loan_type || loan.type || 'Loan'} <span class="badge ${loan.status === 'active' || loan.status === 'Current' ? 'bg-success' : 'bg-warning'}">${loan.status || 'Active'}</span></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Loan ID:</strong> ${loan.id || 'N/A'}</p>
                                        <p class="mb-1"><strong>Original Amount:</strong> KSh ${originalAmount.toLocaleString()}</p>
                                        <p class="mb-1"><strong>Remaining Balance:</strong> KSh ${remainingBalance.toLocaleString()}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Monthly Payment:</strong> KSh ${monthlyPayment.toLocaleString()}</p>
                                        <p class="mb-1"><strong>Next Payment:</strong> ${loan.next_payment_date ? new Date(loan.next_payment_date).toLocaleDateString() : 'N/A'}</p>
                                        <a href="#" class="btn btn-sm btn-primary mt-2">View Details</a>
                                    </div>
                                </div>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: ${progressPercent}%" 
                                        aria-valuenow="${progressPercent}" aria-valuemin="0" aria-valuemax="100">
                                        ${progressPercent}% Paid
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
            if (defaultLoanData.loanHistory.length > 0) {
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
                
                defaultLoanData.loanHistory.forEach(loan => {
                    loanHistoryHtml += `
                        <tr>
                            <td>${loan.id || 'N/A'}</td>
                            <td>${loan.loan_type || loan.type || 'Loan'}</td>
                            <td>KSh ${parseFloat(loan.amount || loan.originalAmount || 0).toLocaleString()}</td>
                            <td><span class="badge bg-success">${loan.status || 'Completed'}</span></td>
                            <td>${loan.completion_date ? new Date(loan.completion_date).toLocaleDateString() : 'N/A'}</td>
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
                <div class="glass-card">
                    <div class="card-body">
                        <h5 class="card-title">Loan Eligibility</h5>
                        <p><strong>Maximum Eligible Amount:</strong> KSh ${defaultLoanData.eligibility.maxEligibleAmount.toLocaleString()}</p>
                        <p><strong>Eligible Loan Types:</strong></p>
                        <ul>
            `;
            
            if (defaultLoanData.eligibility.eligibleLoanTypes.length > 0) {
                defaultLoanData.eligibility.eligibleLoanTypes.forEach(type => {
                    eligibilityHtml += `<li>${type} Loan</li>`;
                });
            } else {
                eligibilityHtml += `<li>Contact admin for loan eligibility information</li>`;
            }
            
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
     * Show fallback loan data when API fails
     */
    static showFallbackLoanData(loanSummary) {
        const fallbackData = {
            activeLoans: [],
            loanHistory: [],
            eligibility: {
                maxEligibleAmount: 0,
                eligibleLoanTypes: []
            }
        };
        
        this.renderLoanData(fallbackData, loanSummary);
    }
    
    /**
     * Initialize contribution chart
     */
    static initializeContributionChart() {
        const contributionChartContainer = document.getElementById('contribution-chart');
        if (!contributionChartContainer) return;
        
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            contributionChartContainer.innerHTML = `
                <div class="alert alert-warning">
                    Chart visualization is not available. Please ensure Chart.js is loaded.
                </div>
            `;
            return;
        }
        
        // Show loading state
        contributionChartContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Fetch contribution data via AJAX
        jQuery.ajax({
            url: daystar_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_member_contributions_chart',
                nonce: daystar_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    this.renderContributionChart(response.data, contributionChartContainer);
                } else {
                    this.showFallbackChart(contributionChartContainer);
                }
            },
            error: () => {
                this.showFallbackChart(contributionChartContainer);
            }
        });
    }
    
    /**
     * Render contribution chart
     */
    static renderContributionChart(chartData, container) {
        // Create canvas element for chart
        container.innerHTML = '<canvas id="contribution-chart-canvas"></canvas>';
        const canvas = container.querySelector('#contribution-chart-canvas');
        const ctx = canvas.getContext('2d');
        
        // Prepare chart data
        const contributionData = {
            labels: chartData.labels || [],
            datasets: [
                {
                    label: 'Monthly Contributions',
                    data: chartData.data || [],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        };
        
        // Create chart
        new Chart(ctx, {
            type: 'bar',
            data: contributionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
    }
    
    /**
     * Show fallback chart when API fails
     */
    static showFallbackChart(container) {
        const fallbackData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            data: [0, 0, 0, 0, 0, 0]
        };
        
        this.renderContributionChart(fallbackData, container);
    }
    
    /**
     * Initialize notifications section
     */
    static initializeNotifications() {
        const notificationsContainer = document.getElementById('notifications');
        if (!notificationsContainer) return;
        
        // Show loading state
        notificationsContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Fetch notifications data via AJAX
        jQuery.ajax({
            url: daystar_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_member_notifications',
                nonce: daystar_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    this.renderNotifications(response.data, notificationsContainer);
                } else {
                    this.showFallbackNotifications(notificationsContainer);
                }
            },
            error: () => {
                this.showFallbackNotifications(notificationsContainer);
            }
        });
    }
    
    /**
     * Render notifications data
     */
    static renderNotifications(notifications, container) {
        if (notifications.length > 0) {
            let notificationsHtml = '';
            
            notifications.forEach(notification => {
                const date = new Date(notification.created_at || notification.date);
                const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                
                let iconClass = '';
                const notificationType = notification.type || 'info';
                switch (notificationType) {
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
                
                const isRead = notification.is_read == '1' || notification.read === true;
                
                notificationsHtml += `
                    <div class="notification-item ${isRead ? '' : 'unread'}" data-id="${notification.id}">
                        <div class="notification-icon">
                            <i class="${iconClass}"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-message">${notification.message}</p>
                            <p class="notification-date">${formattedDate}</p>
                        </div>
                        ${isRead ? '' : '<span class="unread-indicator"></span>'}
                    </div>
                `;
            });
            
            container.innerHTML = notificationsHtml;
            
            // Add event listeners to mark notifications as read
            const unreadNotifications = container.querySelectorAll('.notification-item.unread');
            unreadNotifications.forEach(item => {
                item.addEventListener('click', () => {
                    this.markNotificationAsRead(item.dataset.id, item);
                });
            });
        } else {
            container.innerHTML = `
                <div class="alert alert-info">
                    You have no notifications at this time.
                </div>
            `;
        }
    }
    
    /**
     * Mark notification as read
     */
    static markNotificationAsRead(notificationId, element) {
        jQuery.ajax({
            url: daystar_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mark_notification_read',
                notification_id: notificationId,
                nonce: daystar_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    element.classList.remove('unread');
                    const indicator = element.querySelector('.unread-indicator');
                    if (indicator) {
                        indicator.remove();
                    }
                }
            },
            error: () => {
                console.log('Failed to mark notification as read');
            }
        });
    }
    
    /**
     * Show fallback notifications when API fails
     */
    static showFallbackNotifications(container) {
        const fallbackNotifications = [
            {
                id: 1,
                type: 'info',
                message: 'Welcome to your member dashboard.',
                date: new Date().toISOString(),
                read: false
            }
        ];
        
        this.renderNotifications(fallbackNotifications, container);
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
                <div class="glass-card">
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
                <div class="glass-card">
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
