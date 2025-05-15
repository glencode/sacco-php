/**
 * Member Portal JavaScript
 */

(function($) {
    'use strict';
    
    // Store active charts
    let activeCharts = new Map();
    
    // Document Ready
    $(document).ready(function() {
        const section = getCurrentSection();
        initMemberPortalNavigation();
        // Just initialize the current page's functionality without trying to switch sections
        initSectionFunctionality(section);
    });
    
    /**
     * Get current section from URL
     */
    function getCurrentSection() {
        const path = window.location.pathname;
        const page = path.split('/').filter(Boolean).pop() || 'member-dashboard';
        return page.replace('member-', '').toLowerCase();
    }
    
    /**
     * Initialize member portal navigation
     */
    function initMemberPortalNavigation() {
        // Handle navigation clicks
        $('.member-sidebar .list-group-item').on('click', function(e) {
            e.preventDefault();
            
            const href = $(this).attr('href');
            if (!href) {
                return;
            }
            
            // Always navigate to the page directly
            window.location.href = href;
        });
    }
    
    /**
     * Load section content
     */
    function loadSectionContent(section) {
        // Clean up any active charts first
        cleanupCharts();
        
        // Update navigation state (highlight current tab)
        $('.member-sidebar .list-group-item').removeClass('active');
        $(`.member-sidebar .list-group-item[href*="member-${section}"]`).addClass('active');
        
        // Initialize section-specific functionality
        initSectionFunctionality(section);
    }
    
    /**
     * Clean up charts before switching sections
     */
    function cleanupCharts() {
        activeCharts.forEach((chart) => {
            if (chart) {
                chart.destroy();
            }
        });
        activeCharts.clear();
    }
    
    /**
     * Initialize section-specific functionality
     */
    function initSectionFunctionality(section) {
        switch(section) {
            case 'dashboard':
                if ($('#account-summary-chart').length) {
                    initDashboardCharts();
                }
                break;
            case 'savings':
                if ($('#savings-chart').length) {
                    initSavingsCharts();
                }
                break;
            case 'loans':
                if ($('#loans-chart').length) {
                    initLoansCharts();
                }
                initLoansForms();
                break;
            case 'transactions':
                initTransactionFilters();
                break;
            case 'profile':
                initProfileForms();
                break;
        }
    }
    
    /**
     * Initialize Dashboard Charts
     */
    function initDashboardCharts() {
        const ctx = document.getElementById('account-summary-chart').getContext('2d');
        
        const chart = new Chart(ctx, {
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
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KSh ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        activeCharts.set('dashboard', chart);
    }
    
    /**
     * Initialize Savings Charts
     */
    function initSavingsCharts() {
        const ctx = document.getElementById('savings-chart').getContext('2d');
        
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Regular Savings', 'Fixed Deposits', 'Holiday Savings', 'Education Savings'],
                datasets: [{
                    data: [50000, 30000, 10000, 15000],
                    backgroundColor: ['#5ca157', '#2196F3', '#FFC107', '#9C27B0']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
        
        activeCharts.set('savings', chart);
    }
    
    /**
     * Initialize Loans Charts
     */
    function initLoansCharts() {
        const ctx = document.getElementById('loans-chart').getContext('2d');
        
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Loan Repayment Progress',
                    data: [25000, 23000, 21000, 19000, 17000, 15000],
                    backgroundColor: '#2196F3'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        
        activeCharts.set('loans', chart);
    }
    
    /**
     * Initialize Loans Forms
     */
    function initLoansForms() {
        if ($('#loan-application-form').length) {
            $('#loan-application-form').on('submit', function(e) {
                e.preventDefault();
                // Handle loan application submission
            });
        }
    }
    
    /**
     * Initialize Transaction Filters
     */
    function initTransactionFilters() {
        if ($('#transaction-filter-form').length) {
            $('#transaction-filter-form').on('submit', function(e) {
                e.preventDefault();
                // Handle transaction filtering
            });
        }
    }
    
    /**
     * Initialize Profile Forms
     */
    function initProfileForms() {
        if ($('#profile-form').length) {
            const profileForm = $('#profile-form');
            const profileInputs = profileForm.find('input, select');
            const editProfileBtn = $('#edit-profile-btn');
            const cancelProfileBtn = $('#cancel-profile-btn');
            const profileActions = $('#profile-actions');
            
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
                // Handle profile update submission
                
                profileInputs.prop('disabled', true);
                profileActions.hide();
                editProfileBtn.show();
            });
        }
    }
})(jQuery);