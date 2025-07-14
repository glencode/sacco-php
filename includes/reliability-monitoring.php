<?php
/**
 * Reliability and Monitoring System
 * Implements comprehensive system monitoring, error handling, and reliability features
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * System Health Monitor
 */
class Daystar_System_Monitor {
    
    private static $instance = null;
    private $health_checks = array();
    private $alert_thresholds = array();
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->init_health_checks();
        $this->init_alert_thresholds();
        
        add_action('init', array($this, 'schedule_health_checks'));
        add_action('daystar_system_health_check', array($this, 'run_health_checks'));
        add_action('wp_ajax_system_health_status', array($this, 'ajax_health_status'));
        add_action('admin_notices', array($this, 'display_health_warnings'));
    }
    
    /**
     * Initialize health check definitions
     */
    private function init_health_checks() {
        $this->health_checks = array(
            'database_connection' => array(
                'name' => 'Database Connection',
                'description' => 'Verify database connectivity and response time',
                'critical' => true,
                'interval' => 300 // 5 minutes
            ),
            'disk_space' => array(
                'name' => 'Disk Space',
                'description' => 'Monitor available disk space',
                'critical' => true,
                'interval' => 900 // 15 minutes
            ),
            'memory_usage' => array(
                'name' => 'Memory Usage',
                'description' => 'Monitor PHP memory consumption',
                'critical' => false,
                'interval' => 300
            ),
            'error_rate' => array(
                'name' => 'Error Rate',
                'description' => 'Monitor application error frequency',
                'critical' => true,
                'interval' => 600 // 10 minutes
            ),
            'response_time' => array(
                'name' => 'Response Time',
                'description' => 'Monitor average page response times',
                'critical' => false,
                'interval' => 300
            ),
            'backup_status' => array(
                'name' => 'Backup Status',
                'description' => 'Verify recent backup completion',
                'critical' => true,
                'interval' => 3600 // 1 hour
            ),
            'security_status' => array(
                'name' => 'Security Status',
                'description' => 'Monitor security-related metrics',
                'critical' => true,
                'interval' => 1800 // 30 minutes
            )
        );
    }
    
    /**
     * Initialize alert thresholds
     */
    private function init_alert_thresholds() {
        $this->alert_thresholds = array(
            'disk_space_warning' => 85, // Percentage
            'disk_space_critical' => 95,
            'memory_usage_warning' => 80,
            'memory_usage_critical' => 90,
            'error_rate_warning' => 5, // Errors per minute
            'error_rate_critical' => 10,
            'response_time_warning' => 2000, // Milliseconds
            'response_time_critical' => 5000,
            'database_response_warning' => 1000,
            'database_response_critical' => 3000
        );
    }
    
    /**
     * Schedule health checks
     */
    public function schedule_health_checks() {
        if (!wp_next_scheduled('daystar_system_health_check')) {
            wp_schedule_event(time(), 'every_minute', 'daystar_system_health_check');
        }
    }
    
    /**
     * Run all health checks
     */
    public function run_health_checks() {
        $results = array();
        
        foreach ($this->health_checks as $check_id => $check_config) {
            $last_run = get_option("daystar_health_check_last_run_{$check_id}", 0);
            
            if (time() - $last_run >= $check_config['interval']) {
                $result = $this->execute_health_check($check_id, $check_config);
                $results[$check_id] = $result;
                
                update_option("daystar_health_check_last_run_{$check_id}", time());
                update_option("daystar_health_check_result_{$check_id}", $result);
                
                // Send alerts if necessary
                if ($result['status'] !== 'healthy') {
                    $this->send_health_alert($check_id, $check_config, $result);
                }
            }
        }
        
        // Update overall system status
        $this->update_system_status($results);
        
        return $results;
    }
    
    /**
     * Execute individual health check
     */
    private function execute_health_check($check_id, $config) {
        $start_time = microtime(true);
        
        try {
            switch ($check_id) {
                case 'database_connection':
                    $result = $this->check_database_health();
                    break;
                case 'disk_space':
                    $result = $this->check_disk_space();
                    break;
                case 'memory_usage':
                    $result = $this->check_memory_usage();
                    break;
                case 'error_rate':
                    $result = $this->check_error_rate();
                    break;
                case 'response_time':
                    $result = $this->check_response_time();
                    break;
                case 'backup_status':
                    $result = $this->check_backup_status();
                    break;
                case 'security_status':
                    $result = $this->check_security_status();
                    break;
                default:
                    $result = array(
                        'status' => 'unknown',
                        'message' => 'Unknown health check type'
                    );
            }
        } catch (Exception $e) {
            $result = array(
                'status' => 'error',
                'message' => 'Health check failed: ' . $e->getMessage()
            );
        }
        
        $execution_time = (microtime(true) - $start_time) * 1000;
        $result['execution_time'] = round($execution_time, 2);
        $result['timestamp'] = current_time('mysql');
        
        return $result;
    }
    
    /**
     * Check database health
     */
    private function check_database_health() {
        global $wpdb;
        
        $start_time = microtime(true);
        
        // Test basic connectivity
        $result = $wpdb->get_var("SELECT 1");
        if ($result !== '1') {
            return array(
                'status' => 'critical',
                'message' => 'Database connection failed'
            );
        }
        
        $response_time = (microtime(true) - $start_time) * 1000;
        
        // Check response time
        if ($response_time > $this->alert_thresholds['database_response_critical']) {
            $status = 'critical';
            $message = "Database response time critical: {$response_time}ms";
        } elseif ($response_time > $this->alert_thresholds['database_response_warning']) {
            $status = 'warning';
            $message = "Database response time high: {$response_time}ms";
        } else {
            $status = 'healthy';
            $message = "Database responding normally: {$response_time}ms";
        }
        
        // Check for locked tables
        $locked_tables = $wpdb->get_var("SHOW OPEN TABLES WHERE In_use > 0");
        if ($locked_tables) {
            $status = 'warning';
            $message .= " | Locked tables detected";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'response_time' => round($response_time, 2),
                'locked_tables' => $locked_tables ? true : false
            )
        );
    }
    
    /**
     * Check disk space
     */
    private function check_disk_space() {
        $upload_dir = wp_upload_dir();
        $disk_free = disk_free_space($upload_dir['basedir']);
        $disk_total = disk_total_space($upload_dir['basedir']);
        
        if ($disk_free === false || $disk_total === false) {
            return array(
                'status' => 'error',
                'message' => 'Unable to determine disk space'
            );
        }
        
        $usage_percent = (($disk_total - $disk_free) / $disk_total) * 100;
        
        if ($usage_percent > $this->alert_thresholds['disk_space_critical']) {
            $status = 'critical';
            $message = "Disk space critical: {$usage_percent}% used";
        } elseif ($usage_percent > $this->alert_thresholds['disk_space_warning']) {
            $status = 'warning';
            $message = "Disk space warning: {$usage_percent}% used";
        } else {
            $status = 'healthy';
            $message = "Disk space normal: {$usage_percent}% used";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'usage_percent' => round($usage_percent, 2),
                'free_space_gb' => round($disk_free / 1024 / 1024 / 1024, 2),
                'total_space_gb' => round($disk_total / 1024 / 1024 / 1024, 2)
            )
        );
    }
    
    /**
     * Check memory usage
     */
    private function check_memory_usage() {
        $memory_limit = ini_get('memory_limit');
        $memory_limit_bytes = $this->convert_to_bytes($memory_limit);
        $memory_usage = memory_get_usage(true);
        $usage_percent = ($memory_usage / $memory_limit_bytes) * 100;
        
        if ($usage_percent > $this->alert_thresholds['memory_usage_critical']) {
            $status = 'critical';
            $message = "Memory usage critical: {$usage_percent}%";
        } elseif ($usage_percent > $this->alert_thresholds['memory_usage_warning']) {
            $status = 'warning';
            $message = "Memory usage high: {$usage_percent}%";
        } else {
            $status = 'healthy';
            $message = "Memory usage normal: {$usage_percent}%";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'usage_percent' => round($usage_percent, 2),
                'usage_mb' => round($memory_usage / 1024 / 1024, 2),
                'limit_mb' => round($memory_limit_bytes / 1024 / 1024, 2),
                'peak_usage_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2)
            )
        );
    }
    
    /**
     * Check error rate
     */
    private function check_error_rate() {
        global $wpdb;
        
        // Get error count from the last 10 minutes
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        $ten_minutes_ago = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        
        $error_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table_name} 
             WHERE severity IN ('error', 'critical') 
             AND timestamp >= %s",
            $ten_minutes_ago
        ));
        
        $errors_per_minute = $error_count / 10;
        
        if ($errors_per_minute > $this->alert_thresholds['error_rate_critical']) {
            $status = 'critical';
            $message = "Error rate critical: {$errors_per_minute} errors/min";
        } elseif ($errors_per_minute > $this->alert_thresholds['error_rate_warning']) {
            $status = 'warning';
            $message = "Error rate elevated: {$errors_per_minute} errors/min";
        } else {
            $status = 'healthy';
            $message = "Error rate normal: {$errors_per_minute} errors/min";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'errors_per_minute' => round($errors_per_minute, 2),
                'total_errors_10min' => intval($error_count)
            )
        );
    }
    
    /**
     * Check response time
     */
    private function check_response_time() {
        // Get average response time from performance logs
        $avg_response_time = get_option('daystar_avg_response_time', 0);
        
        if ($avg_response_time > $this->alert_thresholds['response_time_critical']) {
            $status = 'critical';
            $message = "Response time critical: {$avg_response_time}ms";
        } elseif ($avg_response_time > $this->alert_thresholds['response_time_warning']) {
            $status = 'warning';
            $message = "Response time high: {$avg_response_time}ms";
        } else {
            $status = 'healthy';
            $message = "Response time normal: {$avg_response_time}ms";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'avg_response_time' => $avg_response_time
            )
        );
    }
    
    /**
     * Check backup status
     */
    private function check_backup_status() {
        $last_backup = get_option('daystar_last_backup_time', 0);
        $backup_frequency = get_option('daystar_backup_frequency', 86400); // Default 24 hours
        
        if (!$last_backup) {
            return array(
                'status' => 'warning',
                'message' => 'No backup history found'
            );
        }
        
        $time_since_backup = time() - $last_backup;
        
        if ($time_since_backup > ($backup_frequency * 2)) {
            $status = 'critical';
            $message = "Backup overdue by " . human_time_diff($last_backup);
        } elseif ($time_since_backup > $backup_frequency) {
            $status = 'warning';
            $message = "Backup due: last backup " . human_time_diff($last_backup) . " ago";
        } else {
            $status = 'healthy';
            $message = "Backup current: last backup " . human_time_diff($last_backup) . " ago";
        }
        
        return array(
            'status' => $status,
            'message' => $message,
            'metrics' => array(
                'last_backup' => date('Y-m-d H:i:s', $last_backup),
                'hours_since_backup' => round($time_since_backup / 3600, 1)
            )
        );
    }
    
    /**
     * Check security status
     */
    private function check_security_status() {
        global $wpdb;
        
        $issues = array();
        
        // Check for recent failed login attempts
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        $one_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
        
        $failed_logins = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table_name} 
             WHERE action = 'login_failed_attempt' 
             AND timestamp >= %s",
            $one_hour_ago
        ));
        
        if ($failed_logins > 20) {
            $issues[] = "High failed login attempts: {$failed_logins} in last hour";
        }
        
        // Check for security violations
        $security_violations = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table_name} 
             WHERE action LIKE '%security%' 
             AND severity IN ('warning', 'error', 'critical')
             AND timestamp >= %s",
            $one_hour_ago
        ));
        
        if ($security_violations > 5) {
            $issues[] = "Security violations detected: {$security_violations}";
        }
        
        // Check WordPress core version
        $wp_version = get_bloginfo('version');
        $latest_version = get_option('daystar_latest_wp_version', $wp_version);
        
        if (version_compare($wp_version, $latest_version, '<')) {
            $issues[] = "WordPress core outdated: {$wp_version} (latest: {$latest_version})";
        }
        
        if (empty($issues)) {
            return array(
                'status' => 'healthy',
                'message' => 'No security issues detected',
                'metrics' => array(
                    'failed_logins_1h' => intval($failed_logins),
                    'security_violations_1h' => intval($security_violations)
                )
            );
        } else {
            return array(
                'status' => count($issues) > 2 ? 'critical' : 'warning',
                'message' => implode('; ', $issues),
                'metrics' => array(
                    'failed_logins_1h' => intval($failed_logins),
                    'security_violations_1h' => intval($security_violations),
                    'issues_count' => count($issues)
                )
            );
        }
    }
    
    /**
     * Send health alert
     */
    private function send_health_alert($check_id, $config, $result) {
        if (!$config['critical'] && $result['status'] !== 'critical') {
            return; // Only send alerts for critical checks or critical status
        }
        
        $last_alert = get_option("daystar_health_alert_last_sent_{$check_id}", 0);
        $alert_cooldown = 3600; // 1 hour cooldown between alerts
        
        if (time() - $last_alert < $alert_cooldown) {
            return; // Don't spam alerts
        }
        
        $subject = "Daystar SACCO System Alert: {$config['name']}";
        $message = "Health check '{$config['name']}' has reported a {$result['status']} status.\n\n";
        $message .= "Details: {$result['message']}\n";
        $message .= "Time: {$result['timestamp']}\n";
        
        if (isset($result['metrics'])) {
            $message .= "\nMetrics:\n";
            foreach ($result['metrics'] as $key => $value) {
                $message .= "- {$key}: {$value}\n";
            }
        }
        
        $message .= "\nPlease investigate and take appropriate action.";
        
        // Send to administrators
        $admin_email = get_option('admin_email');
        wp_mail($admin_email, $subject, $message);
        
        // Log the alert
        Daystar_Security_Access_Control::log_action(
            'system_health_alert',
            'system',
            null,
            array(
                'check_id' => $check_id,
                'status' => $result['status'],
                'message' => $result['message']
            ),
            $result['status'] === 'critical' ? 'critical' : 'warning'
        );
        
        update_option("daystar_health_alert_last_sent_{$check_id}", time());
    }
    
    /**
     * Update overall system status
     */
    private function update_system_status($results) {
        $overall_status = 'healthy';
        $critical_issues = 0;
        $warning_issues = 0;
        
        foreach ($results as $check_id => $result) {
            if ($result['status'] === 'critical') {
                $critical_issues++;
                $overall_status = 'critical';
            } elseif ($result['status'] === 'warning') {
                $warning_issues++;
                if ($overall_status === 'healthy') {
                    $overall_status = 'warning';
                }
            }
        }
        
        $system_status = array(
            'overall_status' => $overall_status,
            'critical_issues' => $critical_issues,
            'warning_issues' => $warning_issues,
            'last_check' => current_time('mysql'),
            'uptime' => $this->get_system_uptime()
        );
        
        update_option('daystar_system_status', $system_status);
    }
    
    /**
     * Get system uptime
     */
    private function get_system_uptime() {
        $uptime_file = '/proc/uptime';
        if (file_exists($uptime_file)) {
            $uptime_seconds = floatval(file_get_contents($uptime_file));
            return round($uptime_seconds);
        }
        
        // Fallback: use WordPress installation time
        $install_time = get_option('daystar_install_time', time());
        return time() - $install_time;
    }
    
    /**
     * Convert memory limit string to bytes
     */
    private function convert_to_bytes($value) {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = intval($value);
        
        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }
    
    /**
     * AJAX handler for health status
     */
    public function ajax_health_status() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $system_status = get_option('daystar_system_status', array());
        $health_results = array();
        
        foreach ($this->health_checks as $check_id => $config) {
            $result = get_option("daystar_health_check_result_{$check_id}", array());
            if (!empty($result)) {
                $health_results[$check_id] = array_merge($config, $result);
            }
        }
        
        wp_send_json_success(array(
            'system_status' => $system_status,
            'health_checks' => $health_results
        ));
    }
    
    /**
     * Display health warnings in admin
     */
    public function display_health_warnings() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $system_status = get_option('daystar_system_status', array());
        
        if (isset($system_status['overall_status']) && $system_status['overall_status'] !== 'healthy') {
            $class = $system_status['overall_status'] === 'critical' ? 'error' : 'warning';
            $message = "System Health Alert: ";
            
            if ($system_status['critical_issues'] > 0) {
                $message .= "{$system_status['critical_issues']} critical issue(s) ";
            }
            if ($system_status['warning_issues'] > 0) {
                $message .= "{$system_status['warning_issues']} warning(s) ";
            }
            
            $message .= "detected. <a href='#' onclick='checkSystemHealth()'>View Details</a>";
            
            echo "<div class='notice notice-{$class}'><p>{$message}</p></div>";
        }
    }
}

/**
 * Backup and Recovery Manager
 */
class Daystar_Backup_Manager {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('init', array($this, 'schedule_backups'));
        add_action('daystar_automated_backup', array($this, 'perform_automated_backup'));
        add_action('wp_ajax_manual_backup', array($this, 'ajax_manual_backup'));
    }
    
    /**
     * Schedule automated backups
     */
    public function schedule_backups() {
        if (!wp_next_scheduled('daystar_automated_backup')) {
            wp_schedule_event(time(), 'daily', 'daystar_automated_backup');
        }
    }
    
    /**
     * Perform automated backup
     */
    public function perform_automated_backup() {
        $backup_result = $this->create_full_backup();
        
        if ($backup_result['success']) {
            update_option('daystar_last_backup_time', time());
            update_option('daystar_last_backup_file', $backup_result['file']);
            
            // Log successful backup
            Daystar_Security_Access_Control::log_action(
                'automated_backup_completed',
                'system',
                null,
                array(
                    'backup_file' => $backup_result['file'],
                    'backup_size' => $backup_result['size']
                ),
                'info'
            );
        } else {
            // Log backup failure
            Daystar_Security_Access_Control::log_action(
                'automated_backup_failed',
                'system',
                null,
                array(
                    'error' => $backup_result['error']
                ),
                'error'
            );
        }
        
        return $backup_result;
    }
    
    /**
     * Create full system backup
     */
    public function create_full_backup() {
        try {
            $backup_dir = wp_upload_dir()['basedir'] . '/backups';
            if (!file_exists($backup_dir)) {
                wp_mkdir_p($backup_dir);
            }
            
            $timestamp = date('Y-m-d_H-i-s');
            $backup_file = $backup_dir . "/daystar_backup_{$timestamp}.sql";
            
            // Create database backup
            $db_backup = $this->backup_database($backup_file);
            
            if (!$db_backup['success']) {
                return $db_backup;
            }
            
            // Create files backup (optional - can be resource intensive)
            $files_backup_file = $backup_dir . "/daystar_files_{$timestamp}.tar.gz";
            $files_backup = $this->backup_files($files_backup_file);
            
            return array(
                'success' => true,
                'file' => $backup_file,
                'files_backup' => $files_backup['success'] ? $files_backup_file : null,
                'size' => filesize($backup_file)
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
    }
    
    /**
     * Backup database
     */
    private function backup_database($backup_file) {
        global $wpdb;
        
        try {
            $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
            $sql_dump = "-- Daystar SACCO Database Backup\n";
            $sql_dump .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $table_name = $table[0];
                
                // Get table structure
                $create_table = $wpdb->get_row("SHOW CREATE TABLE `{$table_name}`", ARRAY_N);
                $sql_dump .= "\n-- Table structure for `{$table_name}`\n";
                $sql_dump .= "DROP TABLE IF EXISTS `{$table_name}`;\n";
                $sql_dump .= $create_table[1] . ";\n\n";
                
                // Get table data
                $rows = $wpdb->get_results("SELECT * FROM `{$table_name}`", ARRAY_A);
                
                if (!empty($rows)) {
                    $sql_dump .= "-- Data for table `{$table_name}`\n";
                    $sql_dump .= "INSERT INTO `{$table_name}` VALUES\n";
                    
                    $values = array();
                    foreach ($rows as $row) {
                        $escaped_values = array();
                        foreach ($row as $value) {
                            if ($value === null) {
                                $escaped_values[] = 'NULL';
                            } else {
                                $escaped_values[] = "'" . $wpdb->_real_escape($value) . "'";
                            }
                        }
                        $values[] = '(' . implode(',', $escaped_values) . ')';
                    }
                    
                    $sql_dump .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            file_put_contents($backup_file, $sql_dump);
            
            return array(
                'success' => true,
                'file' => $backup_file
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
    }
    
    /**
     * Backup files
     */
    private function backup_files($backup_file) {
        try {
            $upload_dir = wp_upload_dir()['basedir'];
            $theme_dir = get_template_directory();
            
            // Create tar.gz archive of critical files
            $command = "tar -czf {$backup_file} -C " . dirname($upload_dir) . " " . basename($upload_dir);
            $command .= " -C " . dirname($theme_dir) . " " . basename($theme_dir);
            
            exec($command, $output, $return_code);
            
            if ($return_code === 0) {
                return array(
                    'success' => true,
                    'file' => $backup_file
                );
            } else {
                return array(
                    'success' => false,
                    'error' => 'Failed to create files backup'
                );
            }
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
    }
    
    /**
     * AJAX handler for manual backup
     */
    public function ajax_manual_backup() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_manual_backup')) {
            wp_die('Security check failed');
        }
        
        $backup_result = $this->create_full_backup();
        
        if ($backup_result['success']) {
            wp_send_json_success($backup_result);
        } else {
            wp_send_json_error($backup_result);
        }
    }
}

// Initialize monitoring systems
add_action('plugins_loaded', function() {
    Daystar_System_Monitor::get_instance();
    Daystar_Backup_Manager::get_instance();
});

// Add custom cron interval for minute-based checks
add_filter('cron_schedules', function($schedules) {
    $schedules['every_minute'] = array(
        'interval' => 60,
        'display' => 'Every Minute'
    );
    return $schedules;
});