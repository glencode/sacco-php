/**
 * Savings Calculator JavaScript
 */

(function($) {
    'use strict';
    
    // Wait for DOM to be ready
    $(document).ready(function() {
        // Chart initialization
        const ctx = document.getElementById('savings-chart').getContext('2d');
        let savingsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Deposits',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Interest',
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Years'
                        }
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Amount (KSh)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Savings Growth Over Time'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Show/hide custom rate field
        const interestRateSelect = document.getElementById('interest-rate');
        const customRateField = document.querySelector('.custom-rate-field');
        
        interestRateSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customRateField.style.display = 'block';
            } else {
                customRateField.style.display = 'none';
            }
        });
        
        // Calculator form submission
        const calculatorForm = document.getElementById('savings-calculator-form');
        
        calculatorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get values from form
            const initialAmount = parseFloat(document.getElementById('initial-amount').value);
            const monthlyContribution = parseFloat(document.getElementById('monthly-contribution').value);
            let interestRate = interestRateSelect.value === 'custom' 
                ? parseFloat(document.getElementById('custom-rate').value)
                : parseFloat(interestRateSelect.value);
            const timePeriod = parseInt(document.getElementById('time-period').value);
            const timeUnit = document.getElementById('time-unit').value;
            const compoundFrequency = document.getElementById('compound-frequency').value;
            
            // Convert interest rate to decimal
            interestRate = interestRate / 100;
            
            // Calculate total months
            let totalMonths = timeUnit === 'years' ? timePeriod * 12 : timePeriod;
            
            // Get number of compounds per year
            let compoundsPerYear;
            switch(compoundFrequency) {
                case 'annually':
                    compoundsPerYear = 1;
                    break;
                case 'semi-annually':
                    compoundsPerYear = 2;
                    break;
                case 'quarterly':
                    compoundsPerYear = 4;
                    break;
                case 'monthly':
                    compoundsPerYear = 12;
                    break;
                case 'daily':
                    compoundsPerYear = 365;
                    break;
                default:
                    compoundsPerYear = 12;
            }
            
            // Calculate with compound interest
            let balance = initialAmount;
            let totalDeposits = initialAmount;
            let totalInterest = 0;
            
            // For chart data
            const years = timeUnit === 'years' ? timePeriod : Math.ceil(timePeriod / 12);
            const labels = Array.from({length: years}, (_, i) => `Year ${i + 1}`);
            const depositData = Array(years).fill(0);
            const interestData = Array(years).fill(0);
            
            depositData[0] = initialAmount;
            
            // Monthly calculations
            for (let month = 1; month <= totalMonths; month++) {
                // Add monthly contribution
                balance += monthlyContribution;
                totalDeposits += monthlyContribution;
                
                // If this is a compounding month
                if (month % (12 / compoundsPerYear) === 0) {
                    // Calculate interest for this period
                    const interestEarned = balance * (interestRate / compoundsPerYear);
                    balance += interestEarned;
                    totalInterest += interestEarned;
                }
                
                // Update chart data
                const yearIndex = Math.floor((month - 1) / 12);
                if (yearIndex < years) {
                    if (month % 12 === 1) {
                        // For the first month of each year, record the deposits
                        depositData[yearIndex] = totalDeposits;
                        interestData[yearIndex] = totalInterest;
                    } else if (month % 12 === 0 || month === totalMonths) {
                        // For the last month of the year or final month, update the interest
                        interestData[yearIndex] = totalInterest;
                    }
                }
            }
            
            // Format currency with KSh
            const formatCurrency = (amount) => {
                return `KSh ${amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
            };
            
            // Display results
            document.getElementById('final-balance').textContent = formatCurrency(balance);
            document.getElementById('total-deposits').textContent = formatCurrency(totalDeposits);
            document.getElementById('total-interest').textContent = formatCurrency(totalInterest);
            
            // Update chart
            savingsChart.data.labels = labels;
            savingsChart.data.datasets[0].data = depositData;
            savingsChart.data.datasets[1].data = interestData;
            savingsChart.update();
        });
        
        // Form reset functionality
        calculatorForm.addEventListener('reset', function() {
            // Allow the built-in reset to happen first
            setTimeout(function() {
                // Hide custom rate field
                customRateField.style.display = 'none';
                
                // Trigger calculation with default values
                calculatorForm.dispatchEvent(new Event('submit'));
            }, 10);
        });
        
        // Trigger initial calculation
        calculatorForm.dispatchEvent(new Event('submit'));
        
        // Add comparison functionality if it exists
        const comparisonTable = document.getElementById('savings-comparison-table');
        if (comparisonTable) {
            // Filter functionality
            const filterButtons = document.querySelectorAll('.savings-filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get filter value
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Show all rows if filter is 'all'
                    if (filterValue === 'all') {
                        comparisonTable.querySelectorAll('tbody tr').forEach(row => {
                            row.style.display = '';
                        });
                    } else {
                        // Hide rows that don't match the filter
                        comparisonTable.querySelectorAll('tbody tr').forEach(row => {
                            const category = row.getAttribute('data-category');
                            if (category === filterValue) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                });
            });
        }
    });
    
})(jQuery); 