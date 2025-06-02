/**
 * Loan Calculator JavaScript
 */

(function($) {
    'use strict';
    
    // Wait for DOM to be ready
    $(document).ready(function() {
        // Get elements
        const loanTypeSelect = document.getElementById('calculator_loan_type_select');
        const loanAmountInput = document.getElementById('loan-amount');
        const loanAmountRange = document.getElementById('loan-amount-range');
        const loanTermInput = document.getElementById('loan-term');
        const loanTermRange = document.getElementById('loan-term-range');
        const interestRateInput = document.getElementById('interest-rate');
        const interestRateRange = document.getElementById('interest-rate-range');
        const startDateInput = document.getElementById('start-date');
        // const processingFeeCheck = document.getElementById('processing-fee-check'); // To be removed
        
        const monthlyPaymentOutput = document.getElementById('monthly-payment');
        const totalInterestOutput = document.getElementById('total-interest');
        const totalFeesOutput = document.getElementById('processing-fee'); // ID remains 'processing-fee', label changes
        const totalFeesOutputLabel = document.querySelector('label[for="processing-fee"], .result-title'); // Attempt to find label for "Processing Fee"
        if (totalFeesOutput && totalFeesOutput.parentElement) {
            const titleDiv = totalFeesOutput.parentElement.querySelector('.result-title');
            if (titleDiv) {
                titleDiv.textContent = 'Total Fees';
            }
        }

        const totalRepaymentOutput = document.getElementById('total-repayment');
        
        const showScheduleBtn = document.getElementById('show-schedule-btn');
        const amortizationSchedule = document.getElementById('amortization-schedule');
        const amortizationTable = document.getElementById('amortization-table').querySelector('tbody');
        const comparisonTableBody = document.getElementById('comparison-table-body');
        
        // Set today's date as default
        const today = new Date();
        if(startDateInput) startDateInput.value = today.toISOString().substr(0, 10);
        
        function clearCalculatorOutputs() {
            monthlyPaymentOutput.textContent = 'KSh 0.00';
            totalInterestOutput.textContent = 'KSh 0.00';
            totalFeesOutput.textContent = 'KSh 0.00';
            totalRepaymentOutput.textContent = 'KSh 0.00';
            amortizationTable.innerHTML = '';
            comparisonTableBody.innerHTML = '';
            if (paymentChart) {
                paymentChart.destroy();
                paymentChart = null; 
            }
        }

        function resetCalculatorToDefault() {
            clearCalculatorOutputs();
            // loanAmountInput.value = 500000; // Default or from settings
            // loanAmountRange.value = 500000;
            // loanTermInput.value = 36;
            // loanTermRange.value = 36;
            // interestRateInput.value = 14; // Default or from settings
            // interestRateRange.value = 14;

            // Make fields editable again
            interestRateInput.readOnly = false;
            interestRateRange.disabled = false;
            loanTermInput.readOnly = false;
            loanTermRange.disabled = false;
            loanAmountInput.readOnly = false;
            loanAmountRange.disabled = false;
            
            // Reset max/min attributes if they were changed
            loanAmountInput.max = "10000000"; // Original default max
            loanAmountRange.max = "10000000";
            loanTermInput.max = "84"; // Original default max
            loanTermRange.max = "84";
        }


        function updateCalculatorInputsBasedOnLoanType(selectedLoanData) {
            if (!selectedLoanData) {
                resetCalculatorToDefault();
                return;
            }

            // Interest Rate
            interestRateInput.value = selectedLoanData.base_interest_rate_pa !== null ? selectedLoanData.base_interest_rate_pa : 0;
            interestRateRange.value = interestRateInput.value;
            interestRateInput.readOnly = true;
            interestRateRange.disabled = true;

            // Loan Amount Limits
            let currentLoanAmount = parseFloat(loanAmountInput.value);
            let maxAmount = parseFloat(selectedLoanData.maximum_amount) || 10000000; // Default max if specific not found
            
            // More specific max amounts based on policy category
            if (selectedLoanData.loan_policy_category) {
                switch(selectedLoanData.loan_policy_category) {
                    case 'normal_development': maxAmount = parseFloat(selectedLoanData.max_loan_development) || maxAmount; break;
                    case 'super_saver':        maxAmount = parseFloat(selectedLoanData.max_loan_super_saver) || maxAmount; break;
                    case 'instant_loan':       maxAmount = parseFloat(selectedLoanData.max_loan_instant) || maxAmount; break;
                    case 'emergency_loan':     maxAmount = parseFloat(selectedLoanData.max_loan_emergency) || maxAmount; break;
                    case 'special_loan':       maxAmount = parseFloat(selectedLoanData.max_loan_special) || maxAmount; break;
                }
            }
            
            loanAmountInput.max = maxAmount;
            loanAmountRange.max = maxAmount;
            if (currentLoanAmount > maxAmount) {
                loanAmountInput.value = maxAmount;
                loanAmountRange.value = maxAmount;
            }
            if (parseFloat(loanAmountInput.value) < (parseFloat(selectedLoanData.minimum_amount) || 0)) {
                loanAmountInput.value = selectedLoanData.minimum_amount || 0;
                loanAmountRange.value = selectedLoanData.minimum_amount || 0;
            }
            loanAmountInput.min = selectedLoanData.minimum_amount || 0;
            loanAmountRange.min = selectedLoanData.minimum_amount || 0;

            // Loan Term Limits
            if (selectedLoanData.loan_policy_category === 'special_loan') {
                adjustTermForSpecialLoan(selectedLoanData); // Initial adjustment for special loan
            } else {
                let currentLoanTerm = parseInt(loanTermInput.value);
                let maxTerm = parseInt(selectedLoanData.loan_term) || 84; // General term first

                if (selectedLoanData.loan_policy_category) {
                     switch(selectedLoanData.loan_policy_category) {
                        case 'normal_development': 
                            maxTerm = parseInt(selectedLoanData.repayment_period_part_timers_permanent_months) || 
                                      parseInt(selectedLoanData.repayment_period_others_months) || 
                                      maxTerm; 
                            break;
                        case 'super_saver':    maxTerm = parseInt(selectedLoanData.repayment_period_supersavers_months) || maxTerm; break;
                        case 'school_fees':    maxTerm = parseInt(selectedLoanData.repayment_period_school_fees_months) || maxTerm; break;
                        case 'instant_loan':   maxTerm = parseInt(selectedLoanData.repayment_period_instant_loan_months) || maxTerm; break;
                        case 'emergency_loan': maxTerm = parseInt(selectedLoanData.repayment_period_emergency_loan_months) || maxTerm; break;
                        case 'salary_advance': maxTerm = parseInt(selectedLoanData.repayment_period_salary_advance_months) || maxTerm; break;
                        // No default case for special_loan here as it's handled by adjustTermForSpecialLoan
                     }
                }
                loanTermInput.max = maxTerm;
                loanTermRange.max = maxTerm;
                if (currentLoanTerm > maxTerm) {
                    loanTermInput.value = maxTerm;
                    loanTermRange.value = maxTerm;
                }
                loanTermInput.min = 1; 
                loanTermRange.min = 1;
            }

            // Make loan amount and term fields non-readonly if they were previously readonly
            loanAmountInput.readOnly = false;
            loanAmountRange.disabled = false;
            loanTermInput.readOnly = false;
            loanTermRange.disabled = false;
        }


        if (loanTypeSelect) {
            loanTypeSelect.addEventListener('input', function() {
                const selectedLoanId = this.value;
                if (saccoLoanProductsData && selectedLoanId && saccoLoanProductsData[selectedLoanId]) {
                    const selectedLoanData = saccoLoanProductsData[selectedLoanId];
                    updateCalculatorInputsBasedOnLoanType(selectedLoanData);
                    calculateLoan(); 
                } else {
                    resetCalculatorToDefault();
                }
            });
        }
        
        // Sync range and number inputs
        loanAmountRange.addEventListener('input', function() {
            loanAmountInput.value = this.value;
            const selectedLoanId = loanTypeSelect ? loanTypeSelect.value : null;
            if (saccoLoanProductsData && selectedLoanId && saccoLoanProductsData[selectedLoanId] && saccoLoanProductsData[selectedLoanId].loan_policy_category === 'special_loan') {
                adjustTermForSpecialLoan(saccoLoanProductsData[selectedLoanId]);
            }
            calculateLoan();
        });
        
        loanAmountInput.addEventListener('input', function() {
            loanAmountRange.value = this.value;
            const selectedLoanId = loanTypeSelect ? loanTypeSelect.value : null;
            if (saccoLoanProductsData && selectedLoanId && saccoLoanProductsData[selectedLoanId] && saccoLoanProductsData[selectedLoanId].loan_policy_category === 'special_loan') {
                adjustTermForSpecialLoan(saccoLoanProductsData[selectedLoanId]);
            }
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
            if (!interestRateInput.readOnly) { // Only allow change if not read-only
                interestRateInput.value = this.value;
                calculateLoan();
            }
        });
        
        interestRateInput.addEventListener('input', function() {
             if (!this.readOnly) { // Only allow change if not read-only
                interestRateRange.value = this.value;
                calculateLoan();
            }
        });
        
        // Other input change handlers
        if(startDateInput) startDateInput.addEventListener('change', calculateLoan);
        // processingFeeCheck.addEventListener('change', calculateLoan); // To be removed
        
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
        let paymentChart = null; // Ensure it's null initially
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
                        backgroundColor: ['#5ca157', '#ff6b6b'], // Green for principal, Red for interest
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
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    return `${label}: KSh ${formatCurrency(value)}`;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Calculate loan function
        function calculateLoan() {
            const selectedLoanId = loanTypeSelect ? loanTypeSelect.value : null;
            let selectedLoanData = null;

            if (saccoLoanProductsData && selectedLoanId && saccoLoanProductsData[selectedLoanId]) {
                selectedLoanData = saccoLoanProductsData[selectedLoanId];
            } else if (selectedLoanId) { // Loan type selected but data not found (error case)
                console.error("Selected loan data not found for ID:", selectedLoanId);
                clearCalculatorOutputs();
                return;
            }
            // If no loan type is selected, the calculator can still work with manual inputs if desired,
            // or we can force a selection. For now, let's allow manual if no type selected.

            const actualEnteredLoanAmount = parseFloat(loanAmountInput.value);
            let loanTerm = parseInt(loanTermInput.value);
            let annualInterestRate = parseFloat(interestRateInput.value); 
            
            if (isNaN(actualEnteredLoanAmount) || isNaN(loanTerm) || actualEnteredLoanAmount <= 0 || loanTerm <= 0 ) {
                 if(selectedLoanId) { 
                    clearCalculatorOutputs();
                 }
                return;
            }
             if (selectedLoanData && (selectedLoanData.base_interest_rate_pa === null || isNaN(selectedLoanData.base_interest_rate_pa))) {
                console.warn("Selected loan type has no valid base interest rate. Using manually entered rate or default.");
                 if(isNaN(annualInterestRate) || annualInterestRate <=0) {clearCalculatorOutputs(); return;}
            }

            let monthlyPayment;
            let totalInterest;
            let totalFees = 0;
            let actualAnnualInterestRate = annualInterestRate; 
            let monthlyRate;
            let effectiveLoanAmount = actualEnteredLoanAmount; // Start with the amount user entered

            if (selectedLoanData) {
                actualAnnualInterestRate = selectedLoanData.base_interest_rate_pa !== null ? selectedLoanData.base_interest_rate_pa : annualInterestRate;
                const loanPolicyCategory = selectedLoanData.loan_policy_category;

                // Refinance Loan: Adjust principal
                if (loanPolicyCategory === 'refinance_loan' && selectedLoanData.refinance_charge_percentage > 0) {
                    const refinanceChargeAmount = actualEnteredLoanAmount * (selectedLoanData.refinance_charge_percentage / 100);
                    effectiveLoanAmount = actualEnteredLoanAmount + refinanceChargeAmount;
                    // The refinance_charge_percentage is now part of principal, not a separate fee.
                }

                // Fee Calculation (based on actualEnteredLoanAmount, not effectiveLoanAmount for fees)
                if (loanPolicyCategory) {
                    switch(loanPolicyCategory) {
                        case 'normal_development':
                        case 'school_fees':
                        case 'emergency_loan':
                        case 'super_saver':
                            totalFees += (selectedLoanData.processing_fee_flat || 0);
                            totalFees += actualEnteredLoanAmount * ((selectedLoanData.sinking_fund_percentage || 0) / 100);
                            totalFees += actualEnteredLoanAmount * ((selectedLoanData.appraisal_fee_percentage || 0) / 100);
                            break;
                        case 'refinance_loan': 
                             totalFees += (selectedLoanData.processing_fee_flat || 0);
                             totalFees += actualEnteredLoanAmount * ((selectedLoanData.sinking_fund_percentage || 0) / 100);
                             totalFees += actualEnteredLoanAmount * ((selectedLoanData.appraisal_fee_percentage || 0) / 100);
                             // Refinance charge percentage was already added to principal.
                             break;
                        case 'instant_loan':
                            totalFees += actualEnteredLoanAmount * ((selectedLoanData.instant_loan_charge_percentage || 0) / 100);
                            break;
                        case 'salary_advance':
                            totalFees += actualEnteredLoanAmount * ((selectedLoanData.salary_advance_one_off_rate || 0) / 100);
                            if (loanTerm === 1) {
                                actualAnnualInterestRate = 0; 
                            } else {
                                actualAnnualInterestRate = selectedLoanData.salary_advance_compounded_rate !== null ? selectedLoanData.salary_advance_compounded_rate : 0;
                            }
                            break;
                    }
                }
            } 


            monthlyRate = actualAnnualInterestRate / 100 / 12;

            if (selectedLoanData && selectedLoanData.loan_policy_category === 'salary_advance' && loanTerm === 1) {
                monthlyPayment = effectiveLoanAmount + totalFees; 
                totalInterest = 0; 
            } else {
                if (monthlyRate === 0 && actualAnnualInterestRate === 0) { 
                    monthlyPayment = effectiveLoanAmount / loanTerm;
                } else if (monthlyRate > 0) {
                    monthlyPayment = (effectiveLoanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -loanTerm));
                } else { 
                    monthlyPayment = effectiveLoanAmount / loanTerm; 
                }
                totalInterest = (monthlyPayment * loanTerm) - effectiveLoanAmount;
            }
            
            const totalPaymentIncludingPrincipalAndInterest = monthlyPayment * loanTerm;
            const totalRepaymentWithFees = totalPaymentIncludingPrincipalAndInterest + totalFees;
            
            monthlyPaymentOutput.textContent = `KSh ${formatCurrency(monthlyPayment)}`;
            totalInterestOutput.textContent = `KSh ${formatCurrency(totalInterest)}`;
            totalFeesOutput.textContent = `KSh ${formatCurrency(totalFees)}`;
            totalRepaymentOutput.textContent = `KSh ${formatCurrency(totalRepaymentWithFees)}`;
            
            initChart(effectiveLoanAmount, totalInterest);
            
            let scheduleMonthlyRate = (selectedLoanData && selectedLoanData.loan_policy_category === 'salary_advance' && loanTerm === 1) ? 0 : monthlyRate;
            generateAmortizationSchedule(effectiveLoanAmount, scheduleMonthlyRate, monthlyPayment, loanTerm);
            
            generateLoanComparison(effectiveLoanAmount, actualAnnualInterestRate, totalFees);
        }

        function adjustTermForSpecialLoan(selectedLoanData) {
            if (!selectedLoanData || selectedLoanData.loan_policy_category !== 'special_loan') {
                // Fallback or ensure general term logic applies if not special loan
                // This might already be handled by updateCalculatorInputsBasedOnLoanType's main path
                return;
            }

            const currentLoanAmount = parseFloat(loanAmountInput.value);
            if (isNaN(currentLoanAmount)) return;

            let newMaxTerm = parseInt(selectedLoanData.loan_term) || 84; // Default max term if no tiers match
            let foundTier = false;

            for (let i = 1; i <= 3; i++) {
                const limitKey = `special_loan_config_${i}_amount_limit`;
                const periodKey = `special_loan_config_${i}_repayment_period`;
                
                const amountLimit = parseFloat(selectedLoanData[limitKey]);
                const repaymentPeriod = parseInt(selectedLoanData[periodKey]);

                if (!isNaN(amountLimit) && amountLimit > 0 && !isNaN(repaymentPeriod) && repaymentPeriod > 0) {
                    if (currentLoanAmount <= amountLimit) {
                        newMaxTerm = repaymentPeriod;
                        foundTier = true;
                        break; 
                    }
                    // If amount is greater, but this is the last valid tier defined, use its period
                    // This means if amount > tier1_limit, but tier2_limit is not defined, it should use tier1 period.
                    // This needs to be handled carefully. The current loop finds the *first* applicable tier.
                    // If amount exceeds all defined tiers, newMaxTerm will retain the value from the last valid tier checked, or initial default.
                    newMaxTerm = repaymentPeriod; // Keep updating to the latest valid tier's period as a fallback
                }
            }
             if (!foundTier && newMaxTerm === (parseInt(selectedLoanData.loan_term) || 84) ) {
                // If no tier was matched and newMaxTerm is still the generic default,
                // it implies the amount is larger than all defined tiers or no tiers are defined.
                // In this case, we might want to set to the largest period from any defined tier or a hardcoded max.
                // For now, the logic correctly uses the last valid tier's period or the default.
            }


            loanTermInput.max = newMaxTerm;
            loanTermRange.max = newMaxTerm;

            if (parseInt(loanTermInput.value) > newMaxTerm) {
                loanTermInput.value = newMaxTerm;
                loanTermRange.value = newMaxTerm;
            }
        }
        
        // Helper function to format currency
        function formatCurrency(value) {
            if (typeof value !== 'number' || isNaN(value)) {
                return '0.00'; // Or some other placeholder for invalid numbers
            }
            return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        // Generate amortization schedule
        function generateAmortizationSchedule(principal, monthlyRate, monthlyPayment, term) {
            amortizationTable.innerHTML = '';
            let balance = principal;
            const effectiveStartDate = startDateInput && startDateInput.value ? new Date(startDateInput.value) : new Date();
             if (isNaN(effectiveStartDate.getTime())) { // Check if date is valid
                effectiveStartDate = new Date(); // Fallback to today if invalid
            }

            for (let i = 1; i <= term; i++) {
                const interestComponent = (monthlyRate > 0) ? balance * monthlyRate : 0;
                const principalComponent = monthlyPayment - interestComponent;
                balance -= principalComponent;
                
                const paymentDate = new Date(effectiveStartDate);
                paymentDate.setMonth(effectiveStartDate.getMonth() + i);
                const formattedDate = paymentDate.toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                });
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>${formattedDate}</td>
                    <td>KSh ${formatCurrency(monthlyPayment)}</td>
                    <td>KSh ${formatCurrency(principalComponent)}</td>
                    <td>KSh ${formatCurrency(interestComponent)}</td>
                    <td>KSh ${formatCurrency(Math.max(0, balance))}</td>`;
                amortizationTable.appendChild(row);
            }
        }
        
        // Generate loan comparison table
        function generateLoanComparison(principal, annualInterestRate, totalFees) {
            comparisonTableBody.innerHTML = '';
            const terms = [12, 24, 36, 48, 60]; // Example terms
            const currentTerm = parseInt(loanTermInput.value);
            
            terms.forEach(term => {
                const monthlyRate = annualInterestRate / 100 / 12;
                let monthlyPayment;

                if (monthlyRate === 0 && annualInterestRate === 0) {
                     monthlyPayment = principal / term;
                } else if (monthlyRate > 0) {
                     monthlyPayment = (principal * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -term));
                } else {
                     monthlyPayment = principal / term; // Fallback
                }
                
                const totalPrincipalAndInterest = monthlyPayment * term;
                const totalInterest = totalPrincipalAndInterest - principal;
                const totalCostWithFees = totalPrincipalAndInterest + totalFees;
                
                const row = document.createElement('tr');
                if (term === currentTerm) {
                    row.classList.add('table-success');
                }
                row.innerHTML = `
                    <td>${term} months</td>
                    <td>KSh ${formatCurrency(monthlyPayment)}</td>
                    <td>KSh ${formatCurrency(totalInterest)}</td>
                    <td>KSh ${formatCurrency(totalCostWithFees)}</td>`;
                comparisonTableBody.appendChild(row);
            });
        }
        
        // Initial setup
        if (loanTypeSelect && loanTypeSelect.options.length > 1 && loanTypeSelect.value === "") {
            // If there are loan types and none is selected, perhaps select the first one by default or prompt user.
            // For now, we'll let it be, and it will run in 'manual' mode until a type is chosen.
            // Or, to force a selection:
            // loanTypeSelect.value = loanTypeSelect.options[1].value; // Select the first actual loan type
            // loanTypeSelect.dispatchEvent(new Event('input')); // Trigger the event listener
        }
        
        // Initial calculation (or reset if no loan type is pre-selected and we want to force selection)
        if (loanTypeSelect && loanTypeSelect.value !== "") {
             loanTypeSelect.dispatchEvent(new Event('input')); // Trigger for pre-selected type if any
        } else {
            resetCalculatorToDefault(); // Or calculateLoan() for manual mode
            // calculateLoan(); // Uncomment for manual mode on load
        }
    });
    
})(jQuery);