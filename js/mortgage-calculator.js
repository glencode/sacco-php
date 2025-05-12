/**
 * Mortgage Calculator
 * Handles all mortgage calculator specific functionality
 */
jQuery(document).ready(function($) {

    // Get DOM elements
    const propertyValueInput = document.getElementById('property-value');
    const downPaymentInput = document.getElementById('down-payment');
    const mortgageAmountInput = document.getElementById('mortgage-amount');
    const interestRateInput = document.getElementById('interest-rate');
    const mortgageTermSelect = document.getElementById('mortgage-term');
    const calculateBtn = document.getElementById('calculate-btn');
    const downPaymentPercentElement = document.getElementById('down-payment-percent');
    
    // Result elements
    const monthlyPaymentElement = document.getElementById('monthly-payment');
    const totalPaymentElement = document.getElementById('total-payment');
    const totalInterestElement = document.getElementById('total-interest');
    const ltvRatioElement = document.getElementById('ltv-ratio');
    const amortizationTableBody = document.getElementById('amortization-table').querySelector('tbody');
    
    // Link property value and down payment for real-time mortgage amount calculation
    propertyValueInput.addEventListener('input', updateMortgageAmount);
    downPaymentInput.addEventListener('input', updateMortgageAmount);
    
    // Initial updates and calculation
    updateMortgageAmount();
    calculateMortgage();
    
    // Set up event listeners
    calculateBtn.addEventListener('click', calculateMortgage);
    setupPrintButton('print-btn');
    
    // Link mortgage term changes to recalculation
    mortgageTermSelect.addEventListener('change', calculateMortgage);
    
    /**
     * Update mortgage amount and down payment percentage when inputs change
     */
    function updateMortgageAmount() {
        const propertyValue = parseFloat(propertyValueInput.value);
        const downPayment = parseFloat(downPaymentInput.value);
        
        if (!isNaN(propertyValue) && !isNaN(downPayment)) {
            // Calculate and update mortgage amount
            const mortgageAmount = Math.max(0, propertyValue - downPayment);
            mortgageAmountInput.value = mortgageAmount;
            
            // Update down payment percentage display
            const downPaymentPercent = (downPayment / propertyValue) * 100;
            downPaymentPercentElement.textContent = formatPercentage(downPaymentPercent) + ' of property value';
        }
    }
    
    /**
     * Main calculation function
     */
    function calculateMortgage() {
        // Get input values
        const mortgageAmount = parseFloat(mortgageAmountInput.value);
        const annualInterestRate = parseFloat(interestRateInput.value);
        const propertyValue = parseFloat(propertyValueInput.value);
        const downPayment = parseFloat(downPaymentInput.value);
        
        // Get term in years, convert to months
        const termYears = parseInt(mortgageTermSelect.value);
        const termMonths = termYears * 12;
        
        // Calculate monthly payment
        const monthlyPayment = calculateMonthlyPayment(mortgageAmount, annualInterestRate, termMonths);
        
        // Calculate totals
        const totalPayment = monthlyPayment * termMonths;
        const totalInterest = totalPayment - mortgageAmount;
        
        // Calculate loan-to-value ratio
        const ltvRatio = (mortgageAmount / propertyValue) * 100;
        
        // Update results
        monthlyPaymentElement.textContent = formatCurrency(monthlyPayment);
        totalPaymentElement.textContent = formatCurrency(totalPayment);
        totalInterestElement.textContent = formatCurrency(totalInterest);
        ltvRatioElement.textContent = formatPercentage(ltvRatio);
        
        // Generate chart
        generatePaymentChart('payment-chart', mortgageAmount, totalInterest);
        
        // Generate amortization schedule
        generateYearlyAmortizationSchedule(mortgageAmount, monthlyPayment, annualInterestRate, termYears);
    }
    
    /**
     * Generate the yearly amortization schedule table
     */
    function generateYearlyAmortizationSchedule(principal, monthlyPayment, annualRate, termYears) {
        // Clear existing table
        amortizationTableBody.innerHTML = '';
        
        let balance = principal;
        const monthlyRate = annualRate / 100 / 12;
        
        let yearlyData = [];
        
        // Calculate monthly data first, then aggregate by year
        for (let month = 1; month <= termYears * 12; month++) {
            // Calculate this month's interest and principal
            const interestPayment = balance * monthlyRate;
            let principalPayment = monthlyPayment - interestPayment;
            
            // Adjust for final payment rounding
            if (month === termYears * 12) {
                principalPayment = balance;
            }
            
            // Update remaining balance
            balance -= principalPayment;
            if (balance < 0) balance = 0;
            
            // Store monthly data in yearly aggregation
            const yearIndex = Math.floor((month - 1) / 12);
            
            if (!yearlyData[yearIndex]) {
                yearlyData[yearIndex] = {
                    principalPaid: 0,
                    interestPaid: 0,
                    endingBalance: balance
                };
            }
            
            yearlyData[yearIndex].principalPaid += principalPayment;
            yearlyData[yearIndex].interestPaid += interestPayment;
            yearlyData[yearIndex].endingBalance = balance; // Will be overwritten each month, final is correct
        }
        
        // Create yearly rows for the table
        for (let year = 0; year < yearlyData.length; year++) {
            const yearNumber = year + 1;
            const data = yearlyData[year];
            const yearlyTotalPaid = data.principalPaid + data.interestPaid;
            
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>${yearNumber}</td>
                <td>${formatCurrency(data.principalPaid)}</td>
                <td>${formatCurrency(data.interestPaid)}</td>
                <td>${formatCurrency(yearlyTotalPaid)}</td>
                <td>${formatCurrency(data.endingBalance)}</td>
            `;
            
            amortizationTableBody.appendChild(row);
        }
    }
}); 