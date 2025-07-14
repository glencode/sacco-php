/**
 * Admin Reports JavaScript
 * Handles chart rendering and interactive features for the reporting dashboard
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initializeReportCharts();
        initializeReportFilters();
        initializeExportButtons();
    });

    /**
     * Initialize chart rendering
     */
    function initializeReportCharts() {
        // Render delinquency breakdown chart if data exists
        if (typeof window.delinquencyData !== 'undefined') {
            renderDelinquencyChart(window.delinquencyData);
        }

        // Render monthly trends chart if data exists
        if (typeof window.monthlyTrendsData !== 'undefined') {
            renderMonthlyTrendsChart(window.monthlyTrendsData);
        }

        // Render loan status distribution chart if data exists
        if (typeof window.loanStatusData !== 'undefined') {
            renderLoanStatusChart(window.loanStatusData);
        }

        // Render contribution breakdown chart if data exists
        if (typeof window.contributionData !== 'undefined') {
            renderContributionChart(window.contributionData);
        }
    }

    /**
     * Render delinquency breakdown chart
     */
    function renderDelinquencyChart(data) {
        const ctx = document.getElementById('delinquencyChart');
        if (!ctx) return;

        const labels = Object.keys(data);
        const counts = labels.map(label => data[label].count);
        const amounts = labels.map(label => data[label].amount);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Loans',
                    data: counts,
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#fd7e14',
                        '#dc3545'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const count = context.parsed;
                                const amount = amounts[context.dataIndex];
                                return `${label}: ${count} loans (KES ${formatNumber(amount)})`;
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Render monthly trends chart
     */
    function renderMonthlyTrendsChart(data) {
        const ctx = document.getElementById('monthlyTrendsChart');
        if (!ctx) return;

        const labels = data.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        });
        const loanCounts = data.map(item => item.loans_disbursed);
        const amounts = data.map(item => item.amount_disbursed);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Loans Disbursed',
                    data: loanCounts,
                    borderColor: '#007cba',
                    backgroundColor: 'rgba(0, 124, 186, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                }, {
                    label: 'Amount Disbursed (KES)',
                    data: amounts,
                    borderColor: '#00a32a',
                    backgroundColor: 'rgba(0, 163, 42, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Number of Loans'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Amount (KES)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return 'KES ' + formatNumber(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 1) {
                                    label += 'KES ' + formatNumber(context.parsed.y);
                                } else {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Render loan status distribution chart
     */
    function renderLoanStatusChart(data) {
        const ctx = document.getElementById('loanStatusChart');
        if (!ctx) return;

        const labels = Object.keys(data);
        const values = labels.map(label => data[label]);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
                datasets: [{
                    label: 'Number of Loans',
                    data: values,
                    backgroundColor: [
                        '#007cba',
                        '#00a32a',
                        '#dba617',
                        '#d63638',
                        '#8b5cf6',
                        '#f59e0b'
                    ],
                    borderColor: [
                        '#005a87',
                        '#007a1f',
                        '#a67c00',
                        '#a02828',
                        '#7c3aed',
                        '#d97706'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Loans'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Loan Status'
                        }
                    }
                }
            }
        });
    }

    /**
     * Render contribution breakdown chart
     */
    function renderContributionChart(data) {
        const ctx = document.getElementById('contributionChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Share Capital', 'Savings'],
                datasets: [{
                    data: [data.share_capital, data.savings],
                    backgroundColor: [
                        '#007cba',
                        '#00a32a'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = data.share_capital + data.savings;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: KES ${formatNumber(value)} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Initialize report filters
     */
    function initializeReportFilters() {
        // Auto-submit form when filter values change
        $('.report-filters select, .report-filters input[type="date"]').on('change', function() {
            const $form = $(this).closest('form');
            if ($form.length) {
                $form.submit();
            }
        });

        // Date range validation
        $('input[name="date_from"], input[name="date_to"]').on('change', function() {
            const dateFrom = $('input[name="date_from"]').val();
            const dateTo = $('input[name="date_to"]').val();

            if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
                alert('Start date cannot be later than end date.');
                $(this).val('');
            }
        });

        // Clear filters button
        $('.clear-filters').on('click', function(e) {
            e.preventDefault();
            const $form = $(this).closest('form');
            $form.find('input, select').val('');
            $form.submit();
        });
    }

    /**
     * Initialize export buttons
     */
    function initializeExportButtons() {
        // Add loading state to export buttons
        $('button[name="export_report"]').on('click', function() {
            const $button = $(this);
            const originalText = $button.text();
            
            $button.prop('disabled', true)
                   .text('Exporting...')
                   .addClass('button-disabled');

            // Re-enable button after a delay (in case export fails)
            setTimeout(function() {
                $button.prop('disabled', false)
                       .text(originalText)
                       .removeClass('button-disabled');
            }, 10000);
        });

        // Print functionality
        $('.print-report').on('click', function(e) {
            e.preventDefault();
            window.print();
        });
    }

    /**
     * Format number with commas
     */
    function formatNumber(num) {
        return parseFloat(num).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /**
     * Show/hide loading overlay
     */
    function toggleLoadingOverlay(show) {
        if (show) {
            if (!$('.report-loading-overlay').length) {
                $('body').append('<div class="report-loading-overlay"><div class="loading-spinner"></div></div>');
            }
            $('.report-loading-overlay').show();
        } else {
            $('.report-loading-overlay').hide();
        }
    }

    /**
     * Initialize data tables for better sorting and pagination
     */
    function initializeDataTables() {
        if (typeof $.fn.DataTable !== 'undefined') {
            $('.wp-list-table').DataTable({
                pageLength: 25,
                responsive: true,
                order: [[0, 'desc']],
                columnDefs: [
                    {
                        targets: 'no-sort',
                        orderable: false
                    }
                ]
            });
        }
    }

    // Initialize data tables if available
    $(document).ready(function() {
        initializeDataTables();
    });

})(jQuery);

// Add CSS for loading overlay and other report styles
jQuery(document).ready(function($) {
    if (!$('#admin-reports-styles').length) {
        $('head').append(`
            <style id="admin-reports-styles">
                .report-loading-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.8);
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .loading-spinner {
                    width: 40px;
                    height: 40px;
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #0073aa;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                }
                
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                .chart-container {
                    position: relative;
                    height: 300px;
                    margin: 20px 0;
                }
                
                .report-chart-section {
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 20px;
                    margin-bottom: 20px;
                }
                
                .report-chart-section h4 {
                    margin-top: 0;
                    margin-bottom: 15px;
                    color: #333;
                    border-bottom: 2px solid #0073aa;
                    padding-bottom: 10px;
                }
                
                .button-disabled {
                    opacity: 0.6;
                    cursor: not-allowed !important;
                }
                
                .clear-filters {
                    margin-left: 10px;
                    color: #666;
                    text-decoration: none;
                }
                
                .clear-filters:hover {
                    color: #0073aa;
                }
                
                .print-report {
                    margin-left: 10px;
                }
                
                @media print {
                    .report-filters,
                    .nav-tab-wrapper,
                    .button,
                    .print-report {
                        display: none !important;
                    }
                    
                    .report-container {
                        max-width: none !important;
                    }
                    
                    .summary-card {
                        break-inside: avoid;
                    }
                }
            </style>
        `);
    }
});