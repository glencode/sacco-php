/**
 * Loan Calculator JavaScript
 */

(function($) {
    'use strict';
    
    // Wait for DOM to be ready
    $(document).ready(function() {
        // Get elements
        const loanAmountInput = document.getElementById('loan-amount');
        const loanAmountRange = document.getElementById('loan-amount-range');
        const loanTermInput = document.getElementById('loan-term');
        const loanTermRange = document.getElementById('loan-term-range');
        const interestRateInput = document.getElementById('interest-rate');
        const interestRateRange = document.getElementById('interest-rate-range');
        const startDateInput = document.getElementById('start-date');
        const processingFeeCheck = document.getElementById('processing-fee-check');
        
        const monthlyPaymentOutput = document.getElementById('monthly-payment');
        const totalInterestOutput = document.getElementById('total-interest');
        const processingFeeOutput = document.getElementById('processing-fee');
        const totalRepaymentOutput = document.getElementById('total-repayment');
        
        const showScheduleBtn = document.getElementById('show-schedule-btn');
        const amortizationSchedule = document.getElementById('amortization-schedule');
        const amortizationTable = document.getElementById('amortization-table').querySelector('tbody');
        const comparisonTableBody = document.getElementById('comparison-table-body');
        
        // Set today's date as default
        const today = new Date();
        startDateInput.value = today.toISOString().substr(0, 10);
        
        // Sync range and number inputs
        loanAmountRange.addEventListener('input', function() {
            loanAmountInput.value = this.value;
            calculateLoan();
        });
        
        loanAmountInput.addEventListener('input', function() {
            loanAmountRange.value = this.value;
            calculateLoan();
        });
        
        loanTermRange.addEventListener('input', function() {
            loanTermInput.value = this.value;
            calculateLoan();
        });
        
        loanTermInput.addEventListener('input', function() {
            loanTermRange.value = this.value;
            calculateLoan();
        });
        
        interestRateRange.addEventListener('input', function() {
            interestRateInput.value = this.value;
            calculateLoan();
        });
        
        interestRateInput.addEventListener('input', function() {
            interestRateRange.value = this.value;
            calculateLoan();
        });
        
        // Other input change handlers
        startDateInput.addEventListener('change', calculateLoan);
        processingFeeCheck.addEventListener('change', calculateLoan);
        
        // Toggle amortization schedule
        showScheduleBtn.addEventListener('click', function() {
            if (amortizationSchedule.style.display === 'none') {
                amortizationSchedule.style.display = 'block';
                this.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Amortization Schedule';
            } else {
                amortizationSchedule.style.display = 'none';
                this.innerHTML = '<i class="fas fa-table"></i> View Amortization Schedule';
            }
        });
        
        // Initialize chart
        let paymentChart;
        function initChart(principal, interest) {
            const ctx = document.getElementById('payment-chart').getContext('2d');
            
            if (paymentChart) {
                paymentChart.destroy();
            }
            
            paymentChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Principal', 'Interest'],
                    datasets: [{
                        data: [principal, interest],
                        backgroundColor: ['#5ca157', '#ff6b6b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label;
                                    let value = context.raw;
                                    return `${label}: KSh ${value.toLocaleString('en-US', {maximumFractionDigits: 2})}`;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Calculate loan function
        function calculateLoan() {
            // Get values
            const loanAmount = parseFloat(loanAmountInput.value);
            const loanTerm = parseInt(loanTermInput.value);
            const interestRate = parseFloat(interestRateInput.value);
            const includeProcessingFee = processingFeeCheck.checked;
            
            // Validate inputs
            if (isNaN(loanAmount) || isNaN(loanTerm) || isNaN(interestRate) || loanAmount <= 0 || loanTerm <= 0 || interestRate <= 0) {
                return;
            }
            
            // Calculate monthly payment (PMT formula)
            const monthlyRate = interestRate / 100 / 12;
            let monthlyPayment;
            
            if (monthlyRate === 0) {
                monthlyPayment = loanAmount / loanTerm;
            } else {
                monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -loanTerm));
            }
            
            // Calculate total payment, interest, and processing fee
            const totalPayment = monthlyPayment * loanTerm;
            const totalInterest = totalPayment - loanAmount;
            const processingFee = includeProcessingFee ? loanAmount * 0.02 : 0;
            const totalCost = totalPayment + processingFee;
            
            // Update output
            monthlyPaymentOutput.textContent = `KSh ${formatCurrency(monthlyPayment)}`;
            totalInterestOutput.textContent = `KSh ${formatCurrency(totalInterest)}`;
            processingFeeOutput.textContent = `KSh ${formatCurrency(processingFee)}`;
            totalRepaymentOutput.textContent = `KSh ${formatCurrency(totalCost)}`;
            
            // Update chart
            initChart(loanAmount, totalInterest);
            
            // Generate amortization schedule
            generateAmortizationSchedule(loanAmount, monthlyRate, monthlyPayment, loanTerm);
            
            // Generate loan comparison table
            generateLoanComparison(loanAmount, interestRate, processingFee);
        }
        
        // Helper function to format currency
        function formatCurrency(value) {
            return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        // Generate amortization schedule
        function generateAmortizationSchedule(principal, monthlyRate, monthlyPayment, term) {
            // Clear table
            amortizationTable.innerHTML = '';
            
            let balance = principal;
            let startDate = new Date(startDateInput.value);
            
            for (let i = 1; i <= term; i++) {
                const interest = balance * monthlyRate;
                const principalPayment = monthlyPayment - interest;
                balance -= principalPayment;
                
                // Format date
                const paymentDate = new Date(startDate);
                paymentDate.setMonth(startDate.getMonth() + i);
                const formattedDate = paymentDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                // Create row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>${formattedDate}</td>
                    <td>KSh ${formatCurrency(monthlyPayment)}</td>
                    <td>KSh ${formatCurrency(principalPayment)}</td>
                    <td>KSh ${formatCurrency(interest)}</td>
                    <td>KSh ${formatCurrency(Math.max(0, balance))}</td>
                `;
                
                amortizationTable.appendChild(row);
            }
        }
        
        // Generate loan comparison table
        function generateLoanComparison(principal, interestRate, processingFee) {
            // Clear table
            comparisonTableBody.innerHTML = '';
            
            // Generate comparison for different terms
            const terms = [12, 24, 36, 48, 60];
            const currentTerm = parseInt(loanTermInput.value);
            
            terms.forEach(term => {
                const monthlyRate = interestRate / 100 / 12;
                let monthlyPayment;
                
                if (monthlyRate === 0) {
                    monthlyPayment = principal / term;
                } else {
                    monthlyPayment = (principal * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -term));
                }
                
                const totalPayment = monthlyPayment * term;
                const totalInterest = totalPayment - principal;
                const totalCost = totalPayment + processingFee;
                
                // Create row
                const row = document.createElement('tr');
                if (term === currentTerm) {
                    row.classList.add('table-success');
                }
                
                row.innerHTML = `
                    <td>${term} months</td>
                    <td>KSh ${formatCurrency(monthlyPayment)}</td>
                    <td>KSh ${formatCurrency(totalInterest)}</td>
                    <td>KSh ${formatCurrency(totalCost)}</td>
                `;
                
                comparisonTableBody.appendChild(row);
            });
        }
        
        // Initial calculation
        calculateLoan();
    });
    
})(jQuery); 