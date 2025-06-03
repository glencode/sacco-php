/**
 * Daystar Admin Dashboard Module
 * 
 * This module provides administrative functionality specific to Daystar Multi-Purpose Co-op Society Ltd.
 * It implements the loan approval workflow and administrative tools as specified in the Daystar credit policy.
 */

class DaystarAdminDashboard {
    /**
     * Initialize admin dashboard
     * 
     * @param {string} dashboardId - ID of the dashboard container element
     */
    static initializeDashboard(dashboardId) {
        const dashboard = document.getElementById(dashboardId);
        if (!dashboard) return;
        
        // Initialize dashboard components
        this.initializeLoanApplicationsTable();
        this.initializeLoanDelinquencyReport();
        this.initializeMembershipSummary();
        this.initializeActionItems();
    }
    
    /**
     * Initialize loan applications table
     */
    static initializeLoanApplicationsTable() {
        const loanApplicationsTable = document.getElementById('loan-applications-table');
        if (!loanApplicationsTable) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const applications = [
            {
                id: 'DSL-APP-20250530-001',
                memberName: 'John Doe',
                memberNumber: 'DSL-001',
                loanType: 'Development Loan',
                amount: 750000,
                term: 36,
                submissionDate: '2025-05-30',
                status: 'Pending Review',
                stage: 'Initial Review'
            },
            {
                id: 'DSL-APP-20250528-002',
                memberName: 'Jane Smith',
                memberNumber: 'DSL-045',
                loanType: 'School Fees Loan',
                amount: 200000,
                term: 12,
                submissionDate: '2025-05-28',
                status: 'Under Review',
                stage: 'Credit Committee'
            },
            {
                id: 'DSL-APP-20250525-003',
                memberName: 'Michael Johnson',
                memberNumber: 'DSL-078',
                loanType: 'Emergency Loan',
                amount: 50000,
                term: 6,
                submissionDate: '2025-05-25',
                status: 'Approved',
                stage: 'Disbursement'
            },
            {
                id: 'DSL-APP-20250522-004',
                memberName: 'Sarah Williams',
                memberNumber: 'DSL-112',
                loanType: 'Special Loan',
                amount: 150000,
                term: 6,
                submissionDate: '2025-05-22',
                status: 'Rejected',
                stage: 'Final Review'
            }
        ];
        
        // Create table HTML
        let tableHtml = `
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Member</th>
                            <th>Loan Type</th>
                            <th>Amount</th>
                            <th>Term</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Stage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        applications.forEach(app => {
            let statusClass = '';
            switch (app.status) {
                case 'Pending Review':
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
            
            tableHtml += `
                <tr data-id="${app.id}">
                    <td>${app.id}</td>
                    <td>${app.memberName}<br><small class="text-muted">${app.memberNumber}</small></td>
                    <td>${app.loanType}</td>
                    <td>KSh ${app.amount.toLocaleString()}</td>
                    <td>${app.term} months</td>
                    <td>${new Date(app.submissionDate).toLocaleDateString()}</td>
                    <td><span class="badge ${statusClass}">${app.status}</span></td>
                    <td>${app.stage}</td>
                    <td>
                        <button class="btn btn-sm btn-primary view-application-btn" data-id="${app.id}">View</button>
                        ${app.status === 'Pending Review' || app.status === 'Under Review' ? 
                            `<button class="btn btn-sm btn-success approve-btn" data-id="${app.id}">Approve</button>
                             <button class="btn btn-sm btn-danger reject-btn" data-id="${app.id}">Reject</button>` : 
                            ''}
                    </td>
                </tr>
            `;
        });
        
        tableHtml += `
                    </tbody>
                </table>
            </div>
        `;
        
        loanApplicationsTable.innerHTML = tableHtml;
        
        // Add event listeners to buttons
        const viewButtons = loanApplicationsTable.querySelectorAll('.view-application-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const applicationId = e.target.getAttribute('data-id');
                this.viewLoanApplication(applicationId);
            });
        });
        
        const approveButtons = loanApplicationsTable.querySelectorAll('.approve-btn');
        approveButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const applicationId = e.target.getAttribute('data-id');
                this.approveLoanApplication(applicationId);
            });
        });
        
        const rejectButtons = loanApplicationsTable.querySelectorAll('.reject-btn');
        rejectButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const applicationId = e.target.getAttribute('data-id');
                this.rejectLoanApplication(applicationId);
            });
        });
    }
    
    /**
     * View loan application details
     * 
     * @param {string} applicationId - ID of the loan application
     */
    static viewLoanApplication(applicationId) {
        // In a real implementation, this would fetch application details from the server
        // For this demo, we'll use sample data
        const applicationDetails = {
            id: applicationId,
            memberName: 'John Doe',
            memberNumber: 'DSL-001',
            idNumber: '12345678',
            phone: '+254 712 345 678',
            email: 'john.doe@example.com',
            employmentStatus: 'Employed',
            employer: 'ABC Company Ltd.',
            loanType: 'Development Loan',
            amount: 750000,
            term: 36,
            purpose: 'Home renovation',
            submissionDate: '2025-05-30',
            status: 'Pending Review',
            stage: 'Initial Review',
            guarantors: [
                {
                    name: 'Jane Smith',
                    memberNumber: 'DSL-045',
                    idNumber: '23456789',
                    phone: '+254 723 456 789'
                },
                {
                    name: 'Michael Johnson',
                    memberNumber: 'DSL-078',
                    idNumber: '34567890',
                    phone: '+254 734 567 890'
                }
            ],
            documents: [
                { name: 'ID Copy', url: '#' },
                { name: 'Pay Slip', url: '#' },
                { name: 'Bank Statements', url: '#' },
                { name: 'Project Details', url: '#' }
            ],
            membershipStatus: {
                memberSince: '2023-11-10',
                totalContributions: 250000,
                shareCapital: 15000,
                eligibilityStatus: 'Eligible',
                previousLoans: 2,
                outstandingLoans: 0
            }
        };
        
        // Create modal for application details
        const modalHtml = `
            <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applicationModalLabel">Loan Application: ${applicationDetails.id}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs" id="applicationTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Application Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="member-tab" data-bs-toggle="tab" data-bs-target="#member" type="button" role="tab" aria-controls="member" aria-selected="false">Member Information</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="guarantors-tab" data-bs-toggle="tab" data-bs-target="#guarantors" type="button" role="tab" aria-controls="guarantors" aria-selected="false">Guarantors</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">Documents</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="applicationTabsContent">
                                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Loan Type:</strong> ${applicationDetails.loanType}</p>
                                                <p><strong>Amount:</strong> KSh ${applicationDetails.amount.toLocaleString()}</p>
                                                <p><strong>Term:</strong> ${applicationDetails.term} months</p>
                                                <p><strong>Purpose:</strong> ${applicationDetails.purpose}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Submission Date:</strong> ${new Date(applicationDetails.submissionDate).toLocaleDateString()}</p>
                                                <p><strong>Status:</strong> ${applicationDetails.status}</p>
                                                <p><strong>Current Stage:</strong> ${applicationDetails.stage}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <h6>Loan Calculation</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Monthly Payment:</strong> KSh ${Math.round(applicationDetails.amount * 0.01 * (1 + 0.01) ** applicationDetails.term / ((1 + 0.01) ** applicationDetails.term - 1)).toLocaleString()}</p>
                                                    <p><strong>Total Interest:</strong> KSh ${Math.round(Math.round(applicationDetails.amount * 0.01 * (1 + 0.01) ** applicationDetails.term / ((1 + 0.01) ** applicationDetails.term - 1)) * applicationDetails.term - applicationDetails.amount).toLocaleString()}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Total Repayment:</strong> KSh ${Math.round(Math.round(applicationDetails.amount * 0.01 * (1 + 0.01) ** applicationDetails.term / ((1 + 0.01) ** applicationDetails.term - 1)) * applicationDetails.term).toLocaleString()}</p>
                                                    <p><strong>Interest Rate:</strong> 12% p.a. on reducing balance</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="member" role="tabpanel" aria-labelledby="member-tab">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Member Name:</strong> ${applicationDetails.memberName}</p>
                                                <p><strong>Member Number:</strong> ${applicationDetails.memberNumber}</p>
                                                <p><strong>ID Number:</strong> ${applicationDetails.idNumber}</p>
                                                <p><strong>Phone:</strong> ${applicationDetails.phone}</p>
                                                <p><strong>Email:</strong> ${applicationDetails.email}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Employment Status:</strong> ${applicationDetails.employmentStatus}</p>
                                                <p><strong>Employer:</strong> ${applicationDetails.employer}</p>
                                                <p><strong>Member Since:</strong> ${new Date(applicationDetails.membershipStatus.memberSince).toLocaleDateString()}</p>
                                                <p><strong>Total Contributions:</strong> KSh ${applicationDetails.membershipStatus.totalContributions.toLocaleString()}</p>
                                                <p><strong>Share Capital:</strong> KSh ${applicationDetails.membershipStatus.shareCapital.toLocaleString()}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <h6>Eligibility Status</h6>
                                            <div class="alert ${applicationDetails.membershipStatus.eligibilityStatus === 'Eligible' ? 'alert-success' : 'alert-danger'}">
                                                <strong>Status:</strong> ${applicationDetails.membershipStatus.eligibilityStatus}
                                            </div>
                                            <p><strong>Previous Loans:</strong> ${applicationDetails.membershipStatus.previousLoans}</p>
                                            <p><strong>Outstanding Loans:</strong> ${applicationDetails.membershipStatus.outstandingLoans}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="guarantors" role="tabpanel" aria-labelledby="guarantors-tab">
                                    <div class="p-3">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Member Number</th>
                                                        <th>ID Number</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${applicationDetails.guarantors.map(guarantor => `
                                                        <tr>
                                                            <td>${guarantor.name}</td>
                                                            <td>${guarantor.memberNumber}</td>
                                                            <td>${guarantor.idNumber}</td>
                                                            <td>${guarantor.phone}</td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                                    <div class="p-3">
                                        <div class="list-group">
                                            ${applicationDetails.documents.map(doc => `
                                                <a href="${doc.url}" class="list-group-item list-group-item-action" target="_blank">
                                                    <i class="bi bi-file-earmark-text me-2"></i> ${doc.name}
                                                </a>
                                            `).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            ${applicationDetails.status === 'Pending Review' || applicationDetails.status === 'Under Review' ? `
                                <button type="button" class="btn btn-success modal-approve-btn" data-id="${applicationDetails.id}">Approve</button>
                                <button type="button" class="btn btn-danger modal-reject-btn" data-id="${applicationDetails.id}">Reject</button>
                            ` : ''}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to document
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = modalHtml;
        document.body.appendChild(modalContainer);
        
        // Initialize and show modal
        const modal = new bootstrap.Modal(document.getElementById('applicationModal'));
        modal.show();
        
        // Add event listeners to modal buttons
        const modalApproveBtn = document.querySelector('.modal-approve-btn');
        if (modalApproveBtn) {
            modalApproveBtn.addEventListener('click', (e) => {
                const applicationId = e.target.getAttribute('data-id');
                modal.hide();
                this.approveLoanApplication(applicationId);
            });
        }
        
        const modalRejectBtn = document.querySelector('.modal-reject-btn');
        if (modalRejectBtn) {
            modalRejectBtn.addEventListener('click', (e) => {
                const applicationId = e.target.getAttribute('data-id');
                modal.hide();
                this.rejectLoanApplication(applicationId);
            });
        }
        
        // Clean up modal when hidden
        document.getElementById('applicationModal').addEventListener('hidden.bs.modal', function () {
            document.body.removeChild(modalContainer);
        });
    }
    
    /**
     * Approve loan application
     * 
     * @param {string} applicationId - ID of the loan application
     */
    static approveLoanApplication(applicationId) {
        // In a real implementation, this would send a request to the server
        // For this demo, we'll show a confirmation dialog
        
        const confirmationHtml = `
            <div class="modal fade" id="approveConfirmationModal" tabindex="-1" aria-labelledby="approveConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveConfirmationModalLabel">Approve Loan Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve loan application ${applicationId}?</p>
                            <div class="mb-3">
                                <label for="approvalNotes" class="form-label">Approval Notes</label>
                                <textarea class="form-control" id="approvalNotes" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="approvalStage" class="form-label">Move to Stage</label>
                                <select class="form-select" id="approvalStage">
                                    <option value="Credit Committee">Credit Committee</option>
                                    <option value="Final Approval">Final Approval</option>
                                    <option value="Disbursement">Disbursement</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success confirm-approve-btn" data-id="${applicationId}">Approve</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to document
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = confirmationHtml;
        document.body.appendChild(modalContainer);
        
        // Initialize and show modal
        const modal = new bootstrap.Modal(document.getElementById('approveConfirmationModal'));
        modal.show();
        
        // Add event listener to confirm button
        const confirmBtn = document.querySelector('.confirm-approve-btn');
        confirmBtn.addEventListener('click', (e) => {
            const applicationId = e.target.getAttribute('data-id');
            const notes = document.getElementById('approvalNotes').value;
            const stage = document.getElementById('approvalStage').value;
            
            // In a real implementation, this would send a request to the server
            // For this demo, we'll update the UI
            const row = document.querySelector(`tr[data-id="${applicationId}"]`);
            if (row) {
                const statusCell = row.querySelector('td:nth-child(7)');
                const stageCell = row.querySelector('td:nth-child(8)');
                const actionsCell = row.querySelector('td:nth-child(9)');
                
                statusCell.innerHTML = '<span class="badge bg-success">Approved</span>';
                stageCell.textContent = stage;
                actionsCell.innerHTML = '<button class="btn btn-sm btn-primary view-application-btn" data-id="' + applicationId + '">View</button>';
                
                // Re-add event listener to view button
                const viewBtn = actionsCell.querySelector('.view-application-btn');
                viewBtn.addEventListener('click', (e) => {
                    const appId = e.target.getAttribute('data-id');
                    this.viewLoanApplication(appId);
                });
            }
            
            modal.hide();
            
            // Show success message
            this.showAlert('success', `Loan application ${applicationId} has been approved and moved to ${stage} stage.`);
        });
        
        // Clean up modal when hidden
        document.getElementById('approveConfirmationModal').addEventListener('hidden.bs.modal', function () {
            document.body.removeChild(modalContainer);
        });
    }
    
    /**
     * Reject loan application
     * 
     * @param {string} applicationId - ID of the loan application
     */
    static rejectLoanApplication(applicationId) {
        // In a real implementation, this would send a request to the server
        // For this demo, we'll show a confirmation dialog
        
        const confirmationHtml = `
            <div class="modal fade" id="rejectConfirmationModal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectConfirmationModalLabel">Reject Loan Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reject loan application ${applicationId}?</p>
                            <div class="mb-3">
                                <label for="rejectionReason" class="form-label">Rejection Reason</label>
                                <select class="form-select" id="rejectionReason">
                                    <option value="Insufficient Contributions">Insufficient Contributions</option>
                                    <option value="Incomplete Documentation">Incomplete Documentation</option>
                                    <option value="Ineligible Guarantors">Ineligible Guarantors</option>
                                    <option value="Exceeds Maximum Loan Amount">Exceeds Maximum Loan Amount</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rejectionNotes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="rejectionNotes" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger confirm-reject-btn" data-id="${applicationId}">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to document
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = confirmationHtml;
        document.body.appendChild(modalContainer);
        
        // Initialize and show modal
        const modal = new bootstrap.Modal(document.getElementById('rejectConfirmationModal'));
        modal.show();
        
        // Add event listener to confirm button
        const confirmBtn = document.querySelector('.confirm-reject-btn');
        confirmBtn.addEventListener('click', (e) => {
            const applicationId = e.target.getAttribute('data-id');
            const reason = document.getElementById('rejectionReason').value;
            const notes = document.getElementById('rejectionNotes').value;
            
            // In a real implementation, this would send a request to the server
            // For this demo, we'll update the UI
            const row = document.querySelector(`tr[data-id="${applicationId}"]`);
            if (row) {
                const statusCell = row.querySelector('td:nth-child(7)');
                const stageCell = row.querySelector('td:nth-child(8)');
                const actionsCell = row.querySelector('td:nth-child(9)');
                
                statusCell.innerHTML = '<span class="badge bg-danger">Rejected</span>';
                stageCell.textContent = 'Final Review';
                actionsCell.innerHTML = '<button class="btn btn-sm btn-primary view-application-btn" data-id="' + applicationId + '">View</button>';
                
                // Re-add event listener to view button
                const viewBtn = actionsCell.querySelector('.view-application-btn');
                viewBtn.addEventListener('click', (e) => {
                    const appId = e.target.getAttribute('data-id');
                    this.viewLoanApplication(appId);
                });
            }
            
            modal.hide();
            
            // Show success message
            this.showAlert('danger', `Loan application ${applicationId} has been rejected due to: ${reason}.`);
        });
        
        // Clean up modal when hidden
        document.getElementById('rejectConfirmationModal').addEventListener('hidden.bs.modal', function () {
            document.body.removeChild(modalContainer);
        });
    }
    
    /**
     * Initialize loan delinquency report
     */
    static initializeLoanDelinquencyReport() {
        const delinquencyReport = document.getElementById('loan-delinquency-report');
        if (!delinquencyReport) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const delinquencyData = {
            summary: {
                totalLoans: 120,
                currentLoans: 105,
                delinquentLoans: 15,
                delinquencyRate: 12.5,
                totalDelinquentAmount: 1250000
            },
            delinquencyByCategory: [
                { category: '1-30 Days', count: 8, amount: 450000 },
                { category: '31-60 Days', count: 4, amount: 350000 },
                { category: '61-90 Days', count: 2, amount: 250000 },
                { category: '90+ Days', count: 1, amount: 200000 }
            ],
            delinquentLoans: [
                {
                    id: 'DSL-20250115-001',
                    memberName: 'Robert Brown',
                    memberNumber: 'DSL-023',
                    loanType: 'Development Loan',
                    originalAmount: 500000,
                    remainingBalance: 425000,
                    daysOverdue: 45,
                    amountOverdue: 33334
                },
                {
                    id: 'DSL-20250220-002',
                    memberName: 'Emily Davis',
                    memberNumber: 'DSL-056',
                    loanType: 'School Fees Loan',
                    originalAmount: 200000,
                    remainingBalance: 150000,
                    daysOverdue: 30,
                    amountOverdue: 16667
                },
                {
                    id: 'DSL-20250310-003',
                    memberName: 'David Wilson',
                    memberNumber: 'DSL-089',
                    loanType: 'Emergency Loan',
                    originalAmount: 100000,
                    remainingBalance: 75000,
                    daysOverdue: 15,
                    amountOverdue: 8333
                }
            ]
        };
        
        // Create summary cards
        let summaryHtml = `
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Loans</h5>
                            <p class="card-text display-6">${delinquencyData.summary.totalLoans}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Delinquent Loans</h5>
                            <p class="card-text display-6">${delinquencyData.summary.delinquentLoans}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Delinquency Rate</h5>
                            <p class="card-text display-6">${delinquencyData.summary.delinquencyRate}%</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Create delinquency by category chart
        let categoryChartHtml = `
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Delinquency by Category</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="delinquencyCategoryChart" height="200"></canvas>
                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Count</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${delinquencyData.delinquencyByCategory.map(category => `
                                            <tr>
                                                <td>${category.category}</td>
                                                <td>${category.count}</td>
                                                <td>KSh ${category.amount.toLocaleString()}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Create delinquent loans table
        let loansTableHtml = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delinquent Loans</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Loan ID</th>
                                    <th>Member</th>
                                    <th>Loan Type</th>
                                    <th>Remaining Balance</th>
                                    <th>Days Overdue</th>
                                    <th>Amount Overdue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${delinquencyData.delinquentLoans.map(loan => `
                                    <tr>
                                        <td>${loan.id}</td>
                                        <td>${loan.memberName}<br><small class="text-muted">${loan.memberNumber}</small></td>
                                        <td>${loan.loanType}</td>
                                        <td>KSh ${loan.remainingBalance.toLocaleString()}</td>
                                        <td>
                                            <span class="badge ${loan.daysOverdue > 60 ? 'bg-danger' : loan.daysOverdue > 30 ? 'bg-warning' : 'bg-info'}">
                                                ${loan.daysOverdue} days
                                            </span>
                                        </td>
                                        <td>KSh ${loan.amountOverdue.toLocaleString()}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary view-loan-btn" data-id="${loan.id}">View</button>
                                            <button class="btn btn-sm btn-warning send-reminder-btn" data-id="${loan.id}">Send Reminder</button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
        
        // Combine all sections
        delinquencyReport.innerHTML = summaryHtml + categoryChartHtml + loansTableHtml;
        
        // Initialize chart if Chart.js is available
        if (typeof Chart !== 'undefined') {
            const ctx = document.getElementById('delinquencyCategoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: delinquencyData.delinquencyByCategory.map(category => category.category),
                    datasets: [{
                        label: 'Amount (KSh)',
                        data: delinquencyData.delinquencyByCategory.map(category => category.amount),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
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
        }
        
        // Add event listeners to buttons
        const viewButtons = delinquencyReport.querySelectorAll('.view-loan-btn');
        viewButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const loanId = e.target.getAttribute('data-id');
                this.viewLoan(loanId);
            });
        });
        
        const reminderButtons = delinquencyReport.querySelectorAll('.send-reminder-btn');
        reminderButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const loanId = e.target.getAttribute('data-id');
                this.sendPaymentReminder(loanId);
            });
        });
    }
    
    /**
     * View loan details
     * 
     * @param {string} loanId - ID of the loan
     */
    static viewLoan(loanId) {
        // In a real implementation, this would fetch loan details from the server
        // For this demo, we'll show an alert
        this.showAlert('info', `Viewing loan ${loanId}. This would show detailed loan information.`);
    }
    
    /**
     * Send payment reminder
     * 
     * @param {string} loanId - ID of the loan
     */
    static sendPaymentReminder(loanId) {
        // In a real implementation, this would send a reminder to the member
        // For this demo, we'll show a confirmation dialog
        
        const confirmationHtml = `
            <div class="modal fade" id="reminderConfirmationModal" tabindex="-1" aria-labelledby="reminderConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reminderConfirmationModalLabel">Send Payment Reminder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Send payment reminder for loan ${loanId}?</p>
                            <div class="mb-3">
                                <label for="reminderMethod" class="form-label">Reminder Method</label>
                                <select class="form-select" id="reminderMethod">
                                    <option value="sms">SMS</option>
                                    <option value="email">Email</option>
                                    <option value="both">Both SMS and Email</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="reminderMessage" class="form-label">Additional Message</label>
                                <textarea class="form-control" id="reminderMessage" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary confirm-reminder-btn" data-id="${loanId}">Send Reminder</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to document
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = confirmationHtml;
        document.body.appendChild(modalContainer);
        
        // Initialize and show modal
        const modal = new bootstrap.Modal(document.getElementById('reminderConfirmationModal'));
        modal.show();
        
        // Add event listener to confirm button
        const confirmBtn = document.querySelector('.confirm-reminder-btn');
        confirmBtn.addEventListener('click', (e) => {
            const loanId = e.target.getAttribute('data-id');
            const method = document.getElementById('reminderMethod').value;
            const message = document.getElementById('reminderMessage').value;
            
            modal.hide();
            
            // Show success message
            this.showAlert('success', `Payment reminder for loan ${loanId} has been sent via ${method}.`);
        });
        
        // Clean up modal when hidden
        document.getElementById('reminderConfirmationModal').addEventListener('hidden.bs.modal', function () {
            document.body.removeChild(modalContainer);
        });
    }
    
    /**
     * Initialize membership summary
     */
    static initializeMembershipSummary() {
        const membershipSummary = document.getElementById('membership-summary');
        if (!membershipSummary) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const membershipData = {
            totalMembers: 250,
            activeMembers: 230,
            inactiveMembers: 20,
            newMembersThisMonth: 8,
            totalContributions: 25000000,
            averageContributionPerMember: 108695.65
        };
        
        // Create summary cards
        let summaryHtml = `
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Members</h5>
                            <p class="card-text display-6">${membershipData.totalMembers}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active Members</h5>
                            <p class="card-text display-6">${membershipData.activeMembers}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Members</h5>
                            <p class="card-text display-6">${membershipData.inactiveMembers}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New This Month</h5>
                            <p class="card-text display-6">${membershipData.newMembersThisMonth}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Contributions</h5>
                            <p class="card-text display-6">KSh ${membershipData.totalContributions.toLocaleString()}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Average Contribution Per Member</h5>
                            <p class="card-text display-6">KSh ${Math.round(membershipData.averageContributionPerMember).toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add membership summary to container
        membershipSummary.innerHTML = summaryHtml;
    }
    
    /**
     * Initialize action items
     */
    static initializeActionItems() {
        const actionItems = document.getElementById('action-items');
        if (!actionItems) return;
        
        // In a real implementation, this would fetch data from the server
        // For this demo, we'll use sample data
        const items = [
            {
                id: 1,
                type: 'loan-application',
                title: 'New Loan Applications',
                count: 3,
                priority: 'high',
                description: 'There are 3 new loan applications awaiting review.'
            },
            {
                id: 2,
                type: 'delinquent-loan',
                title: 'Delinquent Loans',
                count: 15,
                priority: 'high',
                description: 'There are 15 delinquent loans requiring attention.'
            },
            {
                id: 3,
                type: 'member-application',
                title: 'New Member Applications',
                count: 5,
                priority: 'medium',
                description: 'There are 5 new member applications awaiting approval.'
            },
            {
                id: 4,
                type: 'report',
                title: 'Monthly Reports',
                count: 2,
                priority: 'medium',
                description: 'There are 2 monthly reports due for review.'
            }
        ];
        
        // Create action items list
        let itemsHtml = `
            <div class="list-group">
                ${items.map(item => {
                    let iconClass = '';
                    let priorityClass = '';
                    
                    switch (item.type) {
                        case 'loan-application':
                            iconClass = 'bi bi-file-earmark-text';
                            break;
                        case 'delinquent-loan':
                            iconClass = 'bi bi-exclamation-triangle';
                            break;
                        case 'member-application':
                            iconClass = 'bi bi-person-plus';
                            break;
                        case 'report':
                            iconClass = 'bi bi-bar-chart';
                            break;
                        default:
                            iconClass = 'bi bi-check-circle';
                    }
                    
                    switch (item.priority) {
                        case 'high':
                            priorityClass = 'text-danger';
                            break;
                        case 'medium':
                            priorityClass = 'text-warning';
                            break;
                        case 'low':
                            priorityClass = 'text-info';
                            break;
                        default:
                            priorityClass = '';
                    }
                    
                    return `
                        <a href="#" class="list-group-item list-group-item-action action-item" data-type="${item.type}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    <i class="${iconClass} ${priorityClass} me-2"></i>
                                    ${item.title}
                                </h5>
                                <span class="badge bg-primary rounded-pill">${item.count}</span>
                            </div>
                            <p class="mb-1">${item.description}</p>
                            <small class="text-muted">Priority: <span class="${priorityClass}">${item.priority.charAt(0).toUpperCase() + item.priority.slice(1)}</span></small>
                        </a>
                    `;
                }).join('')}
            </div>
        `;
        
        // Add action items to container
        actionItems.innerHTML = itemsHtml;
        
        // Add event listeners to action items
        const actionItemLinks = actionItems.querySelectorAll('.action-item');
        actionItemLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const type = e.currentTarget.getAttribute('data-type');
                
                // Navigate to appropriate section based on action item type
                switch (type) {
                    case 'loan-application':
                        document.getElementById('loan-applications-tab').click();
                        break;
                    case 'delinquent-loan':
                        document.getElementById('delinquency-report-tab').click();
                        break;
                    case 'member-application':
                        // In a real implementation, this would navigate to member applications page
                        this.showAlert('info', 'Navigating to member applications page.');
                        break;
                    case 'report':
                        // In a real implementation, this would navigate to reports page
                        this.showAlert('info', 'Navigating to reports page.');
                        break;
                }
            });
        });
    }
    
    /**
     * Show alert message
     * 
     * @param {string} type - Alert type (success, info, warning, danger)
     * @param {string} message - Alert message
     */
    static showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        const alertContainer = document.createElement('div');
        alertContainer.className = 'alert-container';
        alertContainer.style.position = 'fixed';
        alertContainer.style.top = '20px';
        alertContainer.style.right = '20px';
        alertContainer.style.zIndex = '9999';
        alertContainer.style.maxWidth = '400px';
        
        alertContainer.innerHTML = alertHtml;
        document.body.appendChild(alertContainer);
        
        // Remove alert after 5 seconds
        setTimeout(() => {
            alertContainer.querySelector('.alert').classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(alertContainer);
            }, 150);
        }, 5000);
    }
}

// Export the admin dashboard module for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarAdminDashboard;
}
