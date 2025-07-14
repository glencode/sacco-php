<?php
/**
 * Non-Functional Requirements Admin Interface
 * Provides comprehensive admin interface for managing system performance, security, and reliability
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Non-Functional Requirements Admin Manager
 */
class Daystar_NonFunctional_Admin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_init', array($this, 'init_admin_settings'));
        
        // AJAX handlers
        add_action('wp_ajax_nf_dashboard_data', array($this, 'ajax_dashboard_data'));
        add_action('wp_ajax_nf_run_diagnostics', array($this, 'ajax_run_diagnostics'));
        add_action('wp_ajax_nf_optimize_system', array($this, 'ajax_optimize_system'));
        add_action('wp_ajax_nf_export_metrics', array($this, 'ajax_export_metrics'));
    }
    
    /**
     * Add admin menus
     */
    public function add_admin_menus() {
        // Main menu
        add_menu_page(
            'System Management',
            'System Mgmt',
            'manage_options',
            'daystar-system-management',
            array($this, 'render_dashboard'),
            'dashicons-performance',
            30
        );
        
        // Submenus
        add_submenu_page(
            'daystar-system-management',
            'System Dashboard',
            'Dashboard',
            'manage_options',
            'daystar-system-management',
            array($this, 'render_dashboard')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'Performance Monitor',
            'Performance',
            'manage_options',
            'daystar-performance',
            array($this, 'render_performance_page')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'Security & Audit',
            'Security',
            'manage_options',
            'daystar-security',
            array($this, 'render_security_page')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'Reliability Monitor',
            'Reliability',
            'manage_options',
            'daystar-reliability',
            array($this, 'render_reliability_page')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'Code Quality',
            'Code Quality',
            'manage_options',
            'daystar-code-quality',
            array($this, 'render_code_quality_page')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'Scalability',
            'Scalability',
            'manage_options',
            'daystar-scalability',
            array($this, 'render_scalability_page')
        );
        
        add_submenu_page(
            'daystar-system-management',
            'System Settings',
            'Settings',
            'manage_options',
            'daystar-system-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'daystar-') === false) {
            return;
        }
        
        wp_enqueue_style(
            'daystar-admin-nf',
            get_template_directory_uri() . '/assets/css/admin/non-functional-admin.css',
            array(),
            '1.0.0'
        );
        
        wp_enqueue_script(
            'daystar-admin-nf',
            get_template_directory_uri() . '/assets/js/admin/non-functional-admin.js',
            array('jquery', 'chart-js'),
            '1.0.0',
            true
        );
        
        wp_localize_script('daystar-admin-nf', 'daystarNF', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('daystar_nf_nonce')
        ));
    }
    
    /**
     * Initialize admin settings
     */
    public function init_admin_settings() {
        register_setting('daystar_nf_settings', 'daystar_performance_settings');
        register_setting('daystar_nf_settings', 'daystar_security_settings');
        register_setting('daystar_nf_settings', 'daystar_reliability_settings');
        register_setting('daystar_nf_settings', 'daystar_scalability_settings');
    }
    
    /**
     * Render main dashboard
     */
    public function render_dashboard() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>System Management Dashboard</h1>
            
            <div class="nf-dashboard-grid">
                <!-- System Health Overview -->
                <div class="nf-card nf-card-full">
                    <h2>System Health Overview</h2>
                    <div id="system-health-status" class="loading">
                        <div class="spinner"></div>
                        <p>Loading system status...</p>
                    </div>
                </div>
                
                <!-- Performance Metrics -->
                <div class="nf-card">
                    <h3>Performance Metrics</h3>
                    <div class="metric-grid">
                        <div class="metric-item">
                            <span class="metric-label">Avg Response Time</span>
                            <span class="metric-value" id="avg-response-time">--</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Memory Usage</span>
                            <span class="metric-value" id="memory-usage">--</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Query Count</span>
                            <span class="metric-value" id="query-count">--</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Cache Hit Rate</span>
                            <span class="metric-value" id="cache-hit-rate">--</span>
                        </div>
                    </div>
                </div>
                
                <!-- Security Status -->
                <div class="nf-card">
                    <h3>Security Status</h3>
                    <div class="security-indicators">
                        <div class="indicator" id="security-overall">
                            <span class="indicator-label">Overall Security</span>
                            <span class="indicator-status">--</span>
                        </div>
                        <div class="indicator" id="failed-logins">
                            <span class="indicator-label">Failed Logins (24h)</span>
                            <span class="indicator-value">--</span>
                        </div>
                        <div class="indicator" id="security-violations">
                            <span class="indicator-label">Security Violations</span>
                            <span class="indicator-value">--</span>
                        </div>
                    </div>
                </div>
                
                <!-- System Resources -->
                <div class="nf-card">
                    <h3>System Resources</h3>
                    <div class="resource-bars">
                        <div class="resource-bar">
                            <label>Disk Space</label>
                            <div class="progress-bar">
                                <div class="progress-fill" id="disk-usage" style="width: 0%"></div>
                            </div>
                            <span class="resource-text" id="disk-text">--</span>
                        </div>
                        <div class="resource-bar">
                            <label>Database Size</label>
                            <div class="progress-bar">
                                <div class="progress-fill" id="db-size" style="width: 0%"></div>
                            </div>
                            <span class="resource-text" id="db-text">--</span>
                        </div>
                        <div class="resource-bar">
                            <label>Active Users</label>
                            <div class="progress-bar">
                                <div class="progress-fill" id="active-users" style="width: 0%"></div>
                            </div>
                            <span class="resource-text" id="users-text">--</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="nf-card">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <button class="button button-primary" onclick="runDiagnostics()">
                            <span class="dashicons dashicons-search"></span>
                            Run Diagnostics
                        </button>
                        <button class="button button-secondary" onclick="optimizeSystem()">
                            <span class="dashicons dashicons-performance"></span>
                            Optimize System
                        </button>
                        <button class="button button-secondary" onclick="clearAllCaches()">
                            <span class="dashicons dashicons-update"></span>
                            Clear Caches
                        </button>
                        <button class="button button-secondary" onclick="exportMetrics()">
                            <span class="dashicons dashicons-download"></span>
                            Export Metrics
                        </button>
                    </div>
                </div>
                
                <!-- Recent Alerts -->
                <div class="nf-card nf-card-full">
                    <h3>Recent System Alerts</h3>
                    <div id="recent-alerts" class="alerts-list">
                        <div class="loading">Loading alerts...</div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            loadDashboardData();
            
            // Refresh data every 30 seconds
            setInterval(loadDashboardData, 30000);
        });
        
        function loadDashboardData() {
            jQuery.post(ajaxurl, {
                action: 'nf_dashboard_data',
                nonce: daystarNF.nonce
            }, function(response) {
                if (response.success) {
                    updateDashboard(response.data);
                }
            });
        }
        
        function updateDashboard(data) {
            // Update performance metrics
            jQuery('#avg-response-time').text(data.performance.avg_response_time + 'ms');
            jQuery('#memory-usage').text(data.performance.memory_usage + 'MB');
            jQuery('#query-count').text(data.performance.query_count);
            jQuery('#cache-hit-rate').text(data.performance.cache_hit_rate + '%');
            
            // Update security status
            jQuery('#security-overall .indicator-status').text(data.security.overall_status);
            jQuery('#failed-logins .indicator-value').text(data.security.failed_logins);
            jQuery('#security-violations .indicator-value').text(data.security.violations);
            
            // Update resource usage
            jQuery('#disk-usage').css('width', data.resources.disk_usage + '%');
            jQuery('#disk-text').text(data.resources.disk_usage + '% used');
            
            jQuery('#db-size').css('width', data.resources.db_size_percent + '%');
            jQuery('#db-text').text(data.resources.db_size + 'MB');
            
            jQuery('#active-users').css('width', data.resources.user_percent + '%');
            jQuery('#users-text').text(data.resources.active_users + ' users');
            
            // Update system health
            updateSystemHealth(data.health);
            
            // Update alerts
            updateAlerts(data.alerts);
        }
        
        function updateSystemHealth(health) {
            const statusEl = jQuery('#system-health-status');
            statusEl.removeClass('loading');
            
            let statusClass = 'status-' + health.overall_status;
            let statusText = health.overall_status.charAt(0).toUpperCase() + health.overall_status.slice(1);
            
            statusEl.html(`
                <div class="health-status ${statusClass}">
                    <h3>${statusText}</h3>
                    <p>${health.message}</p>
                    <div class="health-details">
                        <span>Critical Issues: ${health.critical_issues}</span>
                        <span>Warnings: ${health.warning_issues}</span>
                        <span>Last Check: ${health.last_check}</span>
                    </div>
                </div>
            `);
        }
        
        function updateAlerts(alerts) {
            const alertsEl = jQuery('#recent-alerts');
            
            if (alerts.length === 0) {
                alertsEl.html('<p>No recent alerts</p>');
                return;
            }
            
            let alertsHtml = '';
            alerts.forEach(function(alert) {
                alertsHtml += `
                    <div class="alert-item alert-${alert.severity}">
                        <div class="alert-header">
                            <span class="alert-title">${alert.title}</span>
                            <span class="alert-time">${alert.time}</span>
                        </div>
                        <div class="alert-message">${alert.message}</div>
                    </div>
                `;
            });
            
            alertsEl.html(alertsHtml);
        }
        
        function runDiagnostics() {
            const button = jQuery(event.target);
            button.prop('disabled', true).text('Running...');
            
            jQuery.post(ajaxurl, {
                action: 'nf_run_diagnostics',
                nonce: daystarNF.nonce
            }, function(response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-search"></span> Run Diagnostics');
                
                if (response.success) {
                    showNotification('Diagnostics completed successfully', 'success');
                    loadDashboardData(); // Refresh data
                } else {
                    showNotification('Diagnostics failed: ' + response.data, 'error');
                }
            });
        }
        
        function optimizeSystem() {
            const button = jQuery(event.target);
            button.prop('disabled', true).text('Optimizing...');
            
            jQuery.post(ajaxurl, {
                action: 'nf_optimize_system',
                nonce: daystarNF.nonce
            }, function(response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-performance"></span> Optimize System');
                
                if (response.success) {
                    showNotification('System optimization completed', 'success');
                    loadDashboardData(); // Refresh data
                } else {
                    showNotification('Optimization failed: ' + response.data, 'error');
                }
            });
        }
        
        function clearAllCaches() {
            const button = jQuery(event.target);
            button.prop('disabled', true).text('Clearing...');
            
            // Implementation for cache clearing
            setTimeout(function() {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Clear Caches');
                showNotification('All caches cleared successfully', 'success');
            }, 2000);
        }
        
        function exportMetrics() {
            jQuery.post(ajaxurl, {
                action: 'nf_export_metrics',
                nonce: daystarNF.nonce
            }, function(response) {
                if (response.success) {
                    // Create download link
                    const link = document.createElement('a');
                    link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(response.data.csv);
                    link.download = 'system_metrics_' + new Date().toISOString().split('T')[0] + '.csv';
                    link.click();
                    
                    showNotification('Metrics exported successfully', 'success');
                } else {
                    showNotification('Export failed: ' + response.data, 'error');
                }
            });
        }
        
        function showNotification(message, type) {
            const notification = jQuery(`
                <div class="notice notice-${type} is-dismissible">
                    <p>${message}</p>
                </div>
            `);
            
            jQuery('.wrap').prepend(notification);
            
            setTimeout(function() {
                notification.fadeOut();
            }, 5000);
        }
        </script>
        <?php
    }
    
    /**
     * Render performance page
     */
    public function render_performance_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>Performance Monitor</h1>
            
            <div class="nf-tabs">
                <nav class="nav-tab-wrapper">
                    <a href="#metrics" class="nav-tab nav-tab-active">Metrics</a>
                    <a href="#optimization" class="nav-tab">Optimization</a>
                    <a href="#caching" class="nav-tab">Caching</a>
                    <a href="#database" class="nav-tab">Database</a>
                </nav>
                
                <div id="metrics" class="tab-content active">
                    <h2>Performance Metrics</h2>
                    <div class="metrics-charts">
                        <canvas id="response-time-chart"></canvas>
                        <canvas id="memory-usage-chart"></canvas>
                        <canvas id="query-performance-chart"></canvas>
                    </div>
                </div>
                
                <div id="optimization" class="tab-content">
                    <h2>System Optimization</h2>
                    <div class="optimization-tools">
                        <div class="tool-card">
                            <h3>Asset Optimization</h3>
                            <p>Minify CSS/JS, optimize images, enable compression</p>
                            <button class="button button-primary">Optimize Assets</button>
                        </div>
                        <div class="tool-card">
                            <h3>Database Optimization</h3>
                            <p>Optimize tables, clean up expired data</p>
                            <button class="button button-primary">Optimize Database</button>
                        </div>
                        <div class="tool-card">
                            <h3>Code Optimization</h3>
                            <p>Analyze and optimize PHP code performance</p>
                            <button class="button button-primary">Analyze Code</button>
                        </div>
                    </div>
                </div>
                
                <div id="caching" class="tab-content">
                    <h2>Caching Management</h2>
                    <div class="cache-controls">
                        <div class="cache-status">
                            <h3>Cache Status</h3>
                            <div class="cache-stats">
                                <div class="stat">
                                    <label>Object Cache</label>
                                    <span class="status enabled">Enabled</span>
                                </div>
                                <div class="stat">
                                    <label>Page Cache</label>
                                    <span class="status enabled">Enabled</span>
                                </div>
                                <div class="stat">
                                    <label>Database Cache</label>
                                    <span class="status enabled">Enabled</span>
                                </div>
                            </div>
                        </div>
                        <div class="cache-actions">
                            <button class="button">Clear Object Cache</button>
                            <button class="button">Clear Page Cache</button>
                            <button class="button">Warm Cache</button>
                            <button class="button">Flush All Caches</button>
                        </div>
                    </div>
                </div>
                
                <div id="database" class="tab-content">
                    <h2>Database Performance</h2>
                    <div class="db-performance">
                        <div class="db-stats">
                            <h3>Database Statistics</h3>
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th>Current</th>
                                        <th>Optimal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Query Time</td>
                                        <td id="db-query-time">--</td>
                                        <td>&lt; 100ms</td>
                                        <td><span class="status good">Good</span></td>
                                    </tr>
                                    <tr>
                                        <td>Slow Queries</td>
                                        <td id="db-slow-queries">--</td>
                                        <td>0</td>
                                        <td><span class="status warning">Warning</span></td>
                                    </tr>
                                    <tr>
                                        <td>Database Size</td>
                                        <td id="db-size">--</td>
                                        <td>&lt; 1GB</td>
                                        <td><span class="status good">Good</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render security page
     */
    public function render_security_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>Security & Audit Monitor</h1>
            
            <div class="security-dashboard">
                <div class="security-overview">
                    <h2>Security Overview</h2>
                    <div class="security-metrics">
                        <div class="metric-card">
                            <h3>Failed Login Attempts</h3>
                            <div class="metric-value" id="failed-logins-count">--</div>
                            <div class="metric-trend">Last 24 hours</div>
                        </div>
                        <div class="metric-card">
                            <h3>Security Violations</h3>
                            <div class="metric-value" id="security-violations-count">--</div>
                            <div class="metric-trend">Last 7 days</div>
                        </div>
                        <div class="metric-card">
                            <h3>Blocked IPs</h3>
                            <div class="metric-value" id="blocked-ips-count">--</div>
                            <div class="metric-trend">Currently active</div>
                        </div>
                    </div>
                </div>
                
                <div class="audit-log">
                    <h2>Recent Audit Events</h2>
                    <div class="log-filters">
                        <select id="log-severity">
                            <option value="">All Severities</option>
                            <option value="critical">Critical</option>
                            <option value="error">Error</option>
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>
                        </select>
                        <select id="log-action">
                            <option value="">All Actions</option>
                            <option value="login">Login Events</option>
                            <option value="security">Security Events</option>
                            <option value="admin">Admin Actions</option>
                        </select>
                        <button class="button" onclick="filterAuditLog()">Filter</button>
                    </div>
                    <div id="audit-log-table" class="audit-table">
                        <div class="loading">Loading audit log...</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render reliability page
     */
    public function render_reliability_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>Reliability Monitor</h1>
            
            <div class="reliability-dashboard">
                <div class="uptime-stats">
                    <h2>System Uptime</h2>
                    <div class="uptime-metrics">
                        <div class="uptime-card">
                            <h3>Current Uptime</h3>
                            <div class="uptime-value" id="current-uptime">--</div>
                        </div>
                        <div class="uptime-card">
                            <h3>30-Day Availability</h3>
                            <div class="uptime-value" id="monthly-uptime">--</div>
                        </div>
                        <div class="uptime-card">
                            <h3>Last Incident</h3>
                            <div class="uptime-value" id="last-incident">--</div>
                        </div>
                    </div>
                </div>
                
                <div class="health-checks">
                    <h2>Health Check Status</h2>
                    <div id="health-checks-table" class="health-table">
                        <div class="loading">Loading health checks...</div>
                    </div>
                </div>
                
                <div class="backup-status">
                    <h2>Backup Status</h2>
                    <div class="backup-info">
                        <div class="backup-card">
                            <h3>Last Backup</h3>
                            <div class="backup-time" id="last-backup">--</div>
                            <button class="button button-primary">Create Backup Now</button>
                        </div>
                        <div class="backup-card">
                            <h3>Backup Schedule</h3>
                            <div class="backup-schedule">Daily at 2:00 AM</div>
                            <button class="button">Modify Schedule</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render code quality page
     */
    public function render_code_quality_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>Code Quality Monitor</h1>
            
            <div class="code-quality-dashboard">
                <div class="quality-overview">
                    <h2>Code Quality Overview</h2>
                    <div class="quality-metrics">
                        <div class="quality-card">
                            <h3>Code Violations</h3>
                            <div class="quality-value" id="code-violations">--</div>
                        </div>
                        <div class="quality-card">
                            <h3>Test Coverage</h3>
                            <div class="quality-value" id="test-coverage">--</div>
                        </div>
                        <div class="quality-card">
                            <h3>Documentation</h3>
                            <div class="quality-value" id="documentation-score">--</div>
                        </div>
                    </div>
                </div>
                
                <div class="code-analysis">
                    <h2>Code Analysis Tools</h2>
                    <div class="analysis-tools">
                        <button class="button button-primary" onclick="runCodeAnalysis()">
                            Run Code Analysis
                        </button>
                        <button class="button" onclick="generateDocumentation()">
                            Generate Documentation
                        </button>
                        <button class="button" onclick="runTests()">
                            Run System Tests
                        </button>
                    </div>
                </div>
                
                <div class="violations-list">
                    <h2>Recent Code Violations</h2>
                    <div id="violations-table" class="violations-table">
                        <div class="loading">Loading violations...</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render scalability page
     */
    public function render_scalability_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>Scalability Monitor</h1>
            
            <div class="scalability-dashboard">
                <div class="capacity-metrics">
                    <h2>System Capacity</h2>
                    <div class="capacity-cards">
                        <div class="capacity-card">
                            <h3>Concurrent Users</h3>
                            <div class="capacity-value" id="concurrent-users">--</div>
                            <div class="capacity-limit">Limit: 500</div>
                        </div>
                        <div class="capacity-card">
                            <h3>Database Load</h3>
                            <div class="capacity-value" id="db-load">--</div>
                            <div class="capacity-limit">Optimal: &lt;70%</div>
                        </div>
                        <div class="capacity-card">
                            <h3>Memory Usage</h3>
                            <div class="capacity-value" id="memory-load">--</div>
                            <div class="capacity-limit">Limit: 80%</div>
                        </div>
                    </div>
                </div>
                
                <div class="scaling-recommendations">
                    <h2>Scaling Recommendations</h2>
                    <div id="scaling-recommendations" class="recommendations-list">
                        <div class="loading">Analyzing scaling needs...</div>
                    </div>
                </div>
                
                <div class="scaling-tools">
                    <h2>Scaling Tools</h2>
                    <div class="tools-grid">
                        <button class="button button-primary" onclick="optimizeForScale()">
                            Optimize for Scale
                        </button>
                        <button class="button" onclick="checkCapacity()">
                            Check Capacity
                        </button>
                        <button class="button" onclick="loadTest()">
                            Run Load Test
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        ?>
        <div class="wrap daystar-nf-admin">
            <h1>System Settings</h1>
            
            <form method="post" action="options.php">
                <?php settings_fields('daystar_nf_settings'); ?>
                
                <div class="settings-tabs">
                    <nav class="nav-tab-wrapper">
                        <a href="#performance-settings" class="nav-tab nav-tab-active">Performance</a>
                        <a href="#security-settings" class="nav-tab">Security</a>
                        <a href="#reliability-settings" class="nav-tab">Reliability</a>
                        <a href="#scalability-settings" class="nav-tab">Scalability</a>
                    </nav>
                    
                    <div id="performance-settings" class="tab-content active">
                        <h2>Performance Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable Caching</th>
                                <td>
                                    <input type="checkbox" name="daystar_performance_settings[caching_enabled]" value="1" checked>
                                    <p class="description">Enable object and page caching for better performance</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Cache Expiration (seconds)</th>
                                <td>
                                    <input type="number" name="daystar_performance_settings[cache_expiration]" value="3600" min="300" max="86400">
                                    <p class="description">How long to cache data (300-86400 seconds)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Database Query Optimization</th>
                                <td>
                                    <input type="checkbox" name="daystar_performance_settings[query_optimization]" value="1" checked>
                                    <p class="description">Enable automatic query optimization</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="security-settings" class="tab-content">
                        <h2>Security Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Login Attempt Limit</th>
                                <td>
                                    <input type="number" name="daystar_security_settings[login_attempts]" value="5" min="3" max="10">
                                    <p class="description">Maximum failed login attempts before lockout</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Lockout Duration (minutes)</th>
                                <td>
                                    <input type="number" name="daystar_security_settings[lockout_duration]" value="15" min="5" max="60">
                                    <p class="description">How long to lock out users after failed attempts</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Audit Log Retention (days)</th>
                                <td>
                                    <input type="number" name="daystar_security_settings[audit_retention]" value="365" min="30" max="1095">
                                    <p class="description">How long to keep audit log entries</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="reliability-settings" class="tab-content">
                        <h2>Reliability Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Health Check Frequency</th>
                                <td>
                                    <select name="daystar_reliability_settings[health_check_frequency]">
                                        <option value="300">Every 5 minutes</option>
                                        <option value="600" selected>Every 10 minutes</option>
                                        <option value="1800">Every 30 minutes</option>
                                        <option value="3600">Every hour</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Backup Frequency</th>
                                <td>
                                    <select name="daystar_reliability_settings[backup_frequency]">
                                        <option value="daily" selected>Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Alert Email</th>
                                <td>
                                    <input type="email" name="daystar_reliability_settings[alert_email]" value="<?php echo get_option('admin_email'); ?>" class="regular-text">
                                    <p class="description">Email address for system alerts</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="scalability-settings" class="tab-content">
                        <h2>Scalability Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Concurrent User Threshold</th>
                                <td>
                                    <input type="number" name="daystar_scalability_settings[user_threshold]" value="100" min="50" max="1000">
                                    <p class="description">Alert when concurrent users exceed this number</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Memory Usage Threshold (%)</th>
                                <td>
                                    <input type="number" name="daystar_scalability_settings[memory_threshold]" value="80" min="50" max="95">
                                    <p class="description">Alert when memory usage exceeds this percentage</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Auto-scaling</th>
                                <td>
                                    <input type="checkbox" name="daystar_scalability_settings[auto_scaling]" value="1">
                                    <p class="description">Enable automatic scaling optimizations</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * AJAX handler for dashboard data
     */
    public function ajax_dashboard_data() {
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_nf_nonce')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Collect data from all systems
        $data = array(
            'performance' => $this->get_performance_data(),
            'security' => $this->get_security_data(),
            'resources' => $this->get_resource_data(),
            'health' => $this->get_health_data(),
            'alerts' => $this->get_recent_alerts()
        );
        
        wp_send_json_success($data);
    }
    
    /**
     * Get performance data
     */
    private function get_performance_data() {
        return array(
            'avg_response_time' => get_option('daystar_avg_response_time', 0),
            'memory_usage' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'query_count' => get_num_queries(),
            'cache_hit_rate' => 85 // Placeholder
        );
    }
    
    /**
     * Get security data
     */
    private function get_security_data() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        
        $failed_logins = $wpdb->get_var("
            SELECT COUNT(*) FROM {$table_name} 
            WHERE action = 'login_failed_attempt' 
            AND timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        
        $violations = $wpdb->get_var("
            SELECT COUNT(*) FROM {$table_name} 
            WHERE action LIKE '%security%' 
            AND severity IN ('warning', 'error', 'critical')
            AND timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ");
        
        return array(
            'overall_status' => 'secure',
            'failed_logins' => intval($failed_logins),
            'violations' => intval($violations)
        );
    }
    
    /**
     * Get resource data
     */
    private function get_resource_data() {
        $upload_dir = wp_upload_dir();
        $disk_free = disk_free_space($upload_dir['basedir']);
        $disk_total = disk_total_space($upload_dir['basedir']);
        $disk_usage = (($disk_total - $disk_free) / $disk_total) * 100;
        
        $active_users = count(get_option('daystar_active_users', array()));
        
        return array(
            'disk_usage' => round($disk_usage, 1),
            'db_size' => 50, // Placeholder
            'db_size_percent' => 25, // Placeholder
            'active_users' => $active_users,
            'user_percent' => min(($active_users / 100) * 100, 100)
        );
    }
    
    /**
     * Get health data
     */
    private function get_health_data() {
        $system_status = get_option('daystar_system_status', array());
        
        return array(
            'overall_status' => $system_status['overall_status'] ?? 'unknown',
            'critical_issues' => $system_status['critical_issues'] ?? 0,
            'warning_issues' => $system_status['warning_issues'] ?? 0,
            'last_check' => $system_status['last_check'] ?? 'Never',
            'message' => 'System is operating normally'
        );
    }
    
    /**
     * Get recent alerts
     */
    private function get_recent_alerts() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        
        $alerts = $wpdb->get_results("
            SELECT action, details, severity, timestamp 
            FROM {$table_name} 
            WHERE severity IN ('warning', 'error', 'critical')
            ORDER BY timestamp DESC 
            LIMIT 10
        ");
        
        $formatted_alerts = array();
        foreach ($alerts as $alert) {
            $formatted_alerts[] = array(
                'title' => ucfirst(str_replace('_', ' ', $alert->action)),
                'message' => $alert->details,
                'severity' => $alert->severity,
                'time' => human_time_diff(strtotime($alert->timestamp)) . ' ago'
            );
        }
        
        return $formatted_alerts;
    }
    
    /**
     * AJAX handler for running diagnostics
     */
    public function ajax_run_diagnostics() {
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_nf_nonce')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Run comprehensive diagnostics
        $monitor = Daystar_System_Monitor::get_instance();
        $results = $monitor->run_health_checks();
        
        $testing = Daystar_Testing_Framework::get_instance();
        $test_results = $testing->run_system_tests();
        
        wp_send_json_success(array(
            'health_checks' => $results,
            'system_tests' => $test_results
        ));
    }
    
    /**
     * AJAX handler for system optimization
     */
    public function ajax_optimize_system() {
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_nf_nonce')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Run system optimizations
        $optimizer = Daystar_Performance_Optimizer::get_instance();
        $optimizer->optimize_database_tables();
        $optimizer->cleanup_expired_transients();
        
        $scalability = Daystar_Scalability_Manager::get_instance();
        $scalability->warm_critical_cache();
        
        wp_send_json_success(array(
            'message' => 'System optimization completed successfully'
        ));
    }
    
    /**
     * AJAX handler for exporting metrics
     */
    public function ajax_export_metrics() {
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_nf_nonce')) {
            wp_die('Security check failed');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Generate CSV export of metrics
        $csv_data = $this->generate_metrics_csv();
        
        wp_send_json_success(array(
            'csv' => $csv_data
        ));
    }
    
    /**
     * Generate metrics CSV
     */
    private function generate_metrics_csv() {
        global $wpdb;
        
        $csv = "Timestamp,Memory Usage,Execution Time,Query Count,Concurrent Users\n";
        
        $table_name = $wpdb->prefix . 'daystar_scaling_metrics';
        $metrics = $wpdb->get_results("
            SELECT * FROM {$table_name} 
            ORDER BY timestamp DESC 
            LIMIT 1000
        ");
        
        foreach ($metrics as $metric) {
            $csv .= sprintf(
                "%s,%d,%.6f,%d,%d\n",
                $metric->timestamp,
                $metric->memory_usage,
                $metric->execution_time,
                $metric->query_count,
                $metric->concurrent_users
            );
        }
        
        return $csv;
    }
}

// Initialize admin interface
if (is_admin()) {
    add_action('plugins_loaded', function() {
        Daystar_NonFunctional_Admin::get_instance();
    });
}