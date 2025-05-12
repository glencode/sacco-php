/**
 * Sacco PHP Main JavaScript
 * Contains functionality for sliders, calculators, and interactive elements
 */

(function($) {
    'use strict';
    
    // Document Ready
    $(document).ready(function() {
        // Initialize Hero Slider
        if ($('.hero-slider').length) {
            new Swiper('.hero-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
        
        // Initialize Testimonials Slider
        if ($('.testimonials-slider').length) {
            new Swiper('.testimonials-slider', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.testimonials-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    }
                }
            });
        }
        
        // Initialize Partners Slider
        if ($('.partners-slider').length) {
            new Swiper('.partners-slider', {
                slidesPerView: 2, // Start with 2 slides on smallest screens
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.partners-pagination',
                    clickable: true,
                },
                breakpoints: {
                    576: { // Small devices (sm)
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    768: { // Medium devices (md)
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                    992: { // Large devices (lg)
                        slidesPerView: 5,
                        spaceBetween: 30,
                    },
                    1200: { // Extra large devices (xl)
                        slidesPerView: 6,
                        spaceBetween: 30,
                    }
                }
            });
        }
        
        // Animate Stats Counter
        function animateCounter() {
            $('.stat-number').each(function() {
                const $this = $(this);
                const countTo = $this.attr('data-count');
                
                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
            });
        }
        
        // Trigger counter animation when in viewport
        if ($('.stats-section').length) {
            const statsSection = document.querySelector('.stats-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            observer.observe(statsSection);
        }
        
        // Product Filter
        $('.filter-btn').on('click', function() {
            const filterValue = $(this).data('filter');
            
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            if (filterValue === 'all') {
                $('.product-item').show();
            } else {
                $('.product-item').hide();
                $('.product-item.' + filterValue).show();
            }
        });
        
        // Mobile Menu Toggle
        $('.menu-toggle').on('click', function() {
            $('.main-navigation').toggleClass('active');
            $(this).toggleClass('active');
            // Toggle aria-expanded attribute
            var currentAriaExpanded = $(this).attr('aria-expanded');
            $(this).attr('aria-expanded', currentAriaExpanded === 'true' ? 'false' : 'true');
        });
        
        // Loan Calculator
        if ($('#loan-calculator-form').length) {
            // Initialize with current date
            const today = new Date();
            $('#start-date').val(today.toISOString().substr(0, 10));
            
            // Sync range inputs with number inputs
            $('#loan-amount-range').on('input', function() {
                $('#loan-amount').val($(this).val());
                calculateLoan();
            });
            
            $('#loan-amount').on('input', function() {
                $('#loan-amount-range').val($(this).val());
                calculateLoan();
            });
            
            $('#loan-term-range').on('input', function() {
                $('#loan-term').val($(this).val());
                calculateLoan();
            });
            
            $('#loan-term').on('input', function() {
                $('#loan-term-range').val($(this).val());
                calculateLoan();
            });
            
            $('#interest-rate-range').on('input', function() {
                $('#interest-rate').val($(this).val());
                calculateLoan();
            });
            
            $('#interest-rate').on('input', function() {
                $('#interest-rate-range').val($(this).val());
                calculateLoan();
            });
            
            $('#processing-fee-check').on('change', calculateLoan);
            $('#start-date').on('change', calculateLoan);
            
            // Show/hide amortization schedule
            $('#show-schedule-btn').on('click', function() {
                const $scheduleSection = $('#amortization-schedule');
                const $button = $(this);
                
                if ($scheduleSection.is(':visible')) {
                    $scheduleSection.slideUp();
                    $button.html('<i class="fas fa-table"></i> View Amortization Schedule');
                } else {
                    $scheduleSection.slideDown();
                    $button.html('<i class="fas fa-times"></i> Hide Amortization Schedule');
                }
            });
            
            // Initial calculation
            calculateLoan();
            
            // Loan comparison table
            updateComparisonTable();
        }
        
        // Savings Calculator
        if ($('#savings-calculator-form').length) {
            // Sync range inputs with number inputs
            $('#initial-deposit-range').on('input', function() {
                $('#initial-deposit').val($(this).val());
                calculateSavings();
            });
            
            $('#initial-deposit').on('input', function() {
                $('#initial-deposit-range').val($(this).val());
                calculateSavings();
            });
            
            $('#monthly-deposit-range').on('input', function() {
                $('#monthly-deposit').val($(this).val());
                calculateSavings();
            });
            
            $('#monthly-deposit').on('input', function() {
                $('#monthly-deposit-range').val($(this).val());
                calculateSavings();
            });
            
            $('#savings-term-range').on('input', function() {
                $('#savings-term').val($(this).val());
                calculateSavings();
            });
            
            $('#savings-term').on('input', function() {
                $('#savings-term-range').val($(this).val());
                calculateSavings();
            });
            
            $('#interest-rate-range').on('input', function() {
                $('#interest-rate').val($(this).val());
                calculateSavings();
            });
            
            $('#interest-rate').on('input', function() {
                $('#interest-rate-range').val($(this).val());
                calculateSavings();
            });
            
            // Initial calculation
            calculateSavings();
        }
    });
    
    // Loan Calculator Functions
    function calculateLoan() {
        // Get values from form
        const loanAmount = parseFloat($('#loan-amount').val());
        const loanTerm = parseInt($('#loan-term').val());
        const interestRate = parseFloat($('#interest-rate').val());
        const includeProcessingFee = $('#processing-fee-check').is(':checked');
        const startDate = new Date($('#start-date').val());
        
        // Calculate monthly payment (PMT formula)
        const monthlyRate = interestRate / 100 / 12;
        const monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
        
        // Calculate total interest
        const totalPayment = monthlyPayment * loanTerm;
        const totalInterest = totalPayment - loanAmount;
        
        // Calculate processing fee (if applicable)
        const processingFee = includeProcessingFee ? loanAmount * 0.02 : 0;
        
        // Update results
        $('#monthly-payment').text('KSh ' + formatNumber(monthlyPayment));
        $('#total-interest').text('KSh ' + formatNumber(totalInterest));
        $('#processing-fee').text('KSh ' + formatNumber(processingFee));
        $('#total-repayment').text('KSh ' + formatNumber(totalPayment + processingFee));
        
        // Generate amortization schedule
        generateAmortizationSchedule(loanAmount, monthlyRate, monthlyPayment, loanTerm, startDate);
        
        // Update chart
        updateLoanChart(loanAmount, totalInterest, processingFee);
    }
    
    function generateAmortizationSchedule(principal, monthlyRate, monthlyPayment, term, startDate) {
        const $tableBody = $('#amortization-table tbody');
        $tableBody.empty();
        
        let balance = principal;
        let currentDate = new Date(startDate);
        
        for (let i = 1; i <= term; i++) {
            // Calculate interest and principal for this payment
            const interest = balance * monthlyRate;
            const principalPayment = monthlyPayment - interest;
            
            // Update balance
            balance -= principalPayment;
            if (balance < 0) balance = 0;
            
            // Increment date by 1 month
            currentDate.setMonth(currentDate.getMonth() + 1);
            const paymentDate = currentDate.toISOString().substr(0, 10);
            
            // Add row to table
            const row = `
                <tr>
                    <td>${i}</td>
                    <td>${paymentDate}</td>
                    <td>KSh ${formatNumber(monthlyPayment)}</td>
                    <td>KSh ${formatNumber(principalPayment)}</td>
                    <td>KSh ${formatNumber(interest)}</td>
                    <td>KSh ${formatNumber(balance)}</td>
                </tr>
            `;
            
            $tableBody.append(row);
        }
    }
    
    function updateLoanChart(principal, interest, fee) {
        if (!$('#payment-chart').length) return;
        
        const ctx = document.getElementById('payment-chart').getContext('2d');
        
        // Destroy existing chart if it exists
        if (window.loanChart) {
            window.loanChart.destroy();
        }
        
        // Create new chart
        window.loanChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal', 'Interest', 'Processing Fee'],
                datasets: [{
                    data: [principal, interest, fee],
                    backgroundColor: [
                        '#5ca157',
                        '#a7a843',
                        '#2c3624'
                    ],
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
                                return label + ': KSh ' + formatNumber(value);
                            }
                        }
                    }
                }
            }
        });
    }
    
    function updateComparisonTable() {
        const $tableBody = $('#comparison-table-body');
        $tableBody.empty();
        
        const loanAmount = parseFloat($('#loan-amount').val());
        const interestRate = parseFloat($('#interest-rate').val());
        const monthlyRate = interestRate / 100 / 12;
        
        // Compare different terms
        const terms = [12, 24, 36, 48, 60];
        
        terms.forEach(term => {
            // Calculate monthly payment
            const monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, term) / (Math.pow(1 + monthlyRate, term) - 1);
            
            // Calculate total interest
            const totalPayment = monthlyPayment * term;
            const totalInterest = totalPayment - loanAmount;
            
            // Add row to table
            const row = `
                <tr>
                    <td>${term} months</td>
                    <td>KSh ${formatNumber(monthlyPayment)}</td>
                    <td>KSh ${formatNumber(totalInterest)}</td>
                    <td>KSh ${formatNumber(totalPayment)}</td>
                </tr>
            `;
            
            $tableBody.append(row);
        });
    }
    
    // Savings Calculator Functions
    function calculateSavings() {
        // Get values from form
        const initialDeposit = parseFloat($('#initial-deposit').val());
        const monthlyDeposit = parseFloat($('#monthly-deposit').val());
        const savingsTerm = parseInt($('#savings-term').val());
        const interestRate = parseFloat($('#interest-rate').val());
        
        // Calculate future value
        const monthlyRate = interestRate / 100 / 12;
        
        // Future value of initial deposit
        const initialDepositFV = initialDeposit * Math.pow(1 + monthlyRate, savingsTerm);
        
        // Future value of monthly deposits (annuity formula)
        const monthlyDepositFV = monthlyDeposit * ((Math.pow(1 + monthlyRate, savingsTerm) - 1) / monthlyRate);
        
        // Total future value
        const totalFutureValue = initialDepositFV + monthlyDepositFV;
        
        // Total deposits
        const totalDeposits = initialDeposit + (monthlyDeposit * savingsTerm);
        
        // Total interest earned
        const totalInterest = totalFutureValue - totalDeposits;
        
        // Update results
        $('#future-value').text('KSh ' + formatNumber(totalFutureValue));
        $('#total-deposits').text('KSh ' + formatNumber(totalDeposits));
        $('#interest-earned').text('KSh ' + formatNumber(totalInterest));
        
        // Update chart
        updateSavingsChart(initialDeposit, monthlyDeposit * savingsTerm, totalInterest);
        
        // Generate savings schedule
        generateSavingsSchedule(initialDeposit, monthlyDeposit, monthlyRate, savingsTerm);
    }
    
    function generateSavingsSchedule(initialDeposit, monthlyDeposit, monthlyRate, term) {
        const $tableBody = $('#savings-schedule-table tbody');
        $tableBody.empty();
        
        let balance = initialDeposit;
        let totalInterest = 0;
        
        for (let i = 1; i <= term; i++) {
            // Calculate interest for this month
            const interest = balance * monthlyRate;
            
            // Update balance
            balance = balance + interest + monthlyDeposit;
            totalInterest += interest;
            
            // Add row to table (every 3 months)
            if (i % 3 === 0 || i === term) {
                const row = `
                    <tr>
                        <td>Month ${i}</td>
                        <td>KSh ${formatNumber(balance)}</td>
                        <td>KSh ${formatNumber(initialDeposit + (monthlyDeposit * i))}</td>
                        <td>KSh ${formatNumber(totalInterest)}</td>
                    </tr>
                `;
                
                $tableBody.append(row);
            }
        }
    }
    
    function updateSavingsChart(initialDeposit, totalMonthlyDeposits, interest) {
        if (!$('#savings-chart').length) return;
        
        const ctx = document.getElementById('savings-chart').getContext('2d');
        
        // Destroy existing chart if it exists
        if (window.savingsChart) {
            window.savingsChart.destroy();
        }
        
        // Create new chart
        window.savingsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Initial Deposit', 'Monthly Deposits', 'Interest Earned'],
                datasets: [{
                    data: [initialDeposit, totalMonthlyDeposits, interest],
                    backgroundColor: [
                        '#5ca157',
                        '#a7a843',
                        '#2c3624'
                    ],
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
                                return label + ': KSh ' + formatNumber(value);
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Helper function to format numbers with commas
    function formatNumber(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
})(jQuery);

// Performance optimized scroll handler
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize on document ready
document.addEventListener('DOMContentLoaded', function() {
    // Progressive loading animation
    document.body.classList.add('loaded');
    
    // Initialize AOS with custom settings
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            disable: 'mobile'
        });
    }

    // Optimize scroll performance for animations
    const scrollHandler = debounce(() => {
        const scrolled = window.scrollY;
        
        // Apply parallax effect to hero section
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const translateY = scrolled * 0.4;
            heroSection.style.transform = `translateY(${translateY}px)`;
        }
        
        // Add subtle parallax to other sections
        document.querySelectorAll('.feature-card, .stat-card').forEach(el => {
            const rect = el.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isVisible) {
                const distance = window.innerHeight - rect.top;
                const parallaxOffset = Math.min(20, distance * 0.1);
                el.style.transform = `translateY(${parallaxOffset}px)`;
            }
        });
    }, 10);

    window.addEventListener('scroll', scrollHandler, { passive: true });
    
    // Enhanced smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const headerOffset = document.querySelector('.site-header').offsetHeight;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});