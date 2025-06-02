/**
 * Common Calculator Functions
 * Used by both loan and mortgage calculator
 */

// Format currency with KSh prefix
function formatCurrency(amount) {
    return 'KSh ' + amount.toLocaleString('en-KE', { maximumFractionDigits: 2, minimumFractionDigits: 0 });
}

// Format percentage
function formatPercentage(value) {
    return value.toFixed(2) + '%';
}

// Calculate monthly payment using the PMT formula
function calculateMonthlyPayment(principal, annualRate, termMonths) {
    const monthlyRate = annualRate / 100 / 12;
    
    // Handle edge case where rate is 0
    if (monthlyRate === 0) {
        return principal / termMonths;
    }
    
    return principal * monthlyRate * Math.pow(1 + monthlyRate, termMonths) / (Math.pow(1 + monthlyRate, termMonths) - 1);
}

// Generate a pie chart for payment breakdown
function generatePaymentChart(chartElementId, principal, totalInterest) {
    const ctx = document.getElementById(chartElementId).getContext('2d');
    
    // Destroy existing chart if it exists
    if (window.paymentChart instanceof Chart) {
        window.paymentChart.destroy();
    }
    
    window.paymentChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Principal', 'Interest'],
            datasets: [{
                data: [principal, totalInterest],
                backgroundColor: ['#5ca157', '#a7a843'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${formatCurrency(value)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Handle print functionality
function setupPrintButton(printBtnId) {
    document.getElementById(printBtnId).addEventListener('click', function() {
        window.print();
    });
} 