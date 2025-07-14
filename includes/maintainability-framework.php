<?php
/**
 * Maintainability Framework
 * Implements code quality, documentation, and testing infrastructure
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Code Quality Manager
 */
class Daystar_Code_Quality {
    
    private static $instance = null;
    private $coding_standards = array();
    private $quality_metrics = array();
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->init_coding_standards();
        add_action('init', array($this, 'init_quality_checks'));
        add_action('wp_ajax_run_code_analysis', array($this, 'ajax_run_code_analysis'));
    }
    
    /**
     * Initialize coding standards
     */
    private function init_coding_standards() {
        $this->coding_standards = array(
            'naming_conventions' => array(
                'classes' => 'PascalCase with Daystar_ prefix',
                'functions' => 'snake_case with daystar_ prefix',
                'variables' => 'snake_case',
                'constants' => 'UPPER_SNAKE_CASE with DAYSTAR_ prefix',
                'files' => 'kebab-case.php'
            ),
            'documentation_requirements' => array(
                'file_headers' => 'Required for all PHP files',
                'class_documentation' => 'Required with @package and @version',
                'method_documentation' => 'Required with @param and @return',
                'inline_comments' => 'Required for complex logic',
                'changelog' => 'Required for version tracking'
            ),
            'security_standards' => array(
                'input_validation' => 'All user inputs must be validated',
                'output_escaping' => 'All outputs must be escaped',
                'nonce_verification' => 'Required for all forms and AJAX',
                'capability_checks' => 'Required for admin functions',
                'sql_preparation' => 'All queries must use prepared statements'
            ),
            'performance_standards' => array(
                'database_queries' => 'Minimize and optimize all queries',
                'caching' => 'Implement caching for expensive operations',
                'asset_optimization' => 'Minify and combine assets',
                'lazy_loading' => 'Implement for non-critical resources'
            )
        );
    }
    
    /**
     * Initialize quality checks
     */
    public function init_quality_checks() {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            add_action('shutdown', array($this, 'run_automated_quality_checks'));
        }
    }
    
    /**
     * Run automated quality checks
     */
    public function run_automated_quality_checks() {
        $this->check_coding_standards();
        $this->analyze_performance_metrics();
        $this->validate_security_practices();
    }
    
    /**
     * Check coding standards compliance
     */
    private function check_coding_standards() {
        $theme_dir = get_template_directory();
        $php_files = $this->get_php_files($theme_dir);
        
        $violations = array();
        
        foreach ($php_files as $file) {
            $file_violations = $this->analyze_file($file);
            if (!empty($file_violations)) {
                $violations[$file] = $file_violations;
            }
        }
        
        if (!empty($violations)) {
            $this->log_coding_violations($violations);
        }
        
        return $violations;
    }
    
    /**
     * Get all PHP files in directory
     */
    private function get_php_files($directory) {
        $files = array();
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    /**
     * Analyze individual file for violations
     */
    private function analyze_file($file_path) {
        $violations = array();
        $content = file_get_contents($file_path);
        $lines = explode("\n", $content);
        
        // Check file header
        if (!$this->has_proper_file_header($content)) {
            $violations[] = array(
                'type' => 'missing_file_header',
                'line' => 1,
                'message' => 'File missing proper header documentation'
            );
        }
        
        // Check for security violations
        $security_violations = $this->check_security_violations($content, $lines);
        $violations = array_merge($violations, $security_violations);
        
        // Check naming conventions
        $naming_violations = $this->check_naming_conventions($content, $lines);
        $violations = array_merge($violations, $naming_violations);
        
        // Check documentation
        $doc_violations = $this->check_documentation($content, $lines);
        $violations = array_merge($violations, $doc_violations);
        
        return $violations;
    }
    
    /**
     * Check if file has proper header
     */
    private function has_proper_file_header($content) {
        $required_elements = array('@package', '@version');
        
        foreach ($required_elements as $element) {
            if (strpos($content, $element) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check for security violations
     */
    private function check_security_violations($content, $lines) {
        $violations = array();
        
        // Check for unescaped output
        if (preg_match_all('/echo\s+\$[^;]+;/', $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                if (strpos($match[0], 'esc_') === false) {
                    $violations[] = array(
                        'type' => 'unescaped_output',
                        'line' => $line_number,
                        'message' => 'Potential unescaped output detected'
                    );
                }
            }
        }
        
        // Check for direct SQL queries
        if (preg_match_all('/\$wpdb->query\s*\(\s*["\'][^"\']*\$/', $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                $violations[] = array(
                    'type' => 'unsafe_sql',
                    'line' => $line_number,
                    'message' => 'Potential SQL injection vulnerability - use prepared statements'
                );
            }
        }
        
        // Check for missing nonce verification
        if (strpos($content, '$_POST') !== false && strpos($content, 'wp_verify_nonce') === false) {
            $violations[] = array(
                'type' => 'missing_nonce',
                'line' => 0,
                'message' => 'Form processing without nonce verification'
            );
        }
        
        return $violations;
    }
    
    /**
     * Check naming conventions
     */
    private function check_naming_conventions($content, $lines) {
        $violations = array();
        
        // Check class names
        if (preg_match_all('/class\s+([A-Za-z_][A-Za-z0-9_]*)/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[1] as $match) {
                $class_name = $match[0];
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                
                if (!preg_match('/^Daystar_[A-Z][A-Za-z0-9_]*$/', $class_name)) {
                    $violations[] = array(
                        'type' => 'naming_convention',
                        'line' => $line_number,
                        'message' => "Class '{$class_name}' does not follow naming convention"
                    );
                }
            }
        }
        
        // Check function names
        if (preg_match_all('/function\s+([A-Za-z_][A-Za-z0-9_]*)/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[1] as $match) {
                $function_name = $match[0];
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                
                // Skip magic methods and WordPress hooks
                if (!preg_match('/^(__[a-z]+|daystar_[a-z0-9_]+)$/', $function_name)) {
                    $violations[] = array(
                        'type' => 'naming_convention',
                        'line' => $line_number,
                        'message' => "Function '{$function_name}' does not follow naming convention"
                    );
                }
            }
        }
        
        return $violations;
    }
    
    /**
     * Check documentation requirements
     */
    private function check_documentation($content, $lines) {
        $violations = array();
        
        // Check for undocumented functions
        if (preg_match_all('/function\s+([A-Za-z_][A-Za-z0-9_]*)/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                
                // Check if function has documentation above it
                $doc_start = $line_number - 10;
                $doc_end = $line_number - 1;
                $has_doc = false;
                
                for ($i = max(0, $doc_start); $i < $doc_end; $i++) {
                    if (isset($lines[$i]) && strpos($lines[$i], '/**') !== false) {
                        $has_doc = true;
                        break;
                    }
                }
                
                if (!$has_doc) {
                    $violations[] = array(
                        'type' => 'missing_documentation',
                        'line' => $line_number,
                        'message' => 'Function missing documentation block'
                    );
                }
            }
        }
        
        return $violations;
    }
    
    /**
     * Log coding violations
     */
    private function log_coding_violations($violations) {
        foreach ($violations as $file => $file_violations) {
            foreach ($file_violations as $violation) {
                Daystar_Security_Access_Control::log_action(
                    'code_quality_violation',
                    'development',
                    null,
                    array(
                        'file' => basename($file),
                        'violation_type' => $violation['type'],
                        'line' => $violation['line'],
                        'message' => $violation['message']
                    ),
                    'warning'
                );
            }
        }
    }
    
    /**
     * Analyze performance metrics
     */
    private function analyze_performance_metrics() {
        $metrics = array(
            'memory_usage' => memory_get_peak_usage(true),
            'execution_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
            'query_count' => get_num_queries(),
            'file_count' => count(get_included_files())
        );
        
        // Check against thresholds
        $thresholds = array(
            'memory_usage' => 64 * 1024 * 1024, // 64MB
            'execution_time' => 2.0, // 2 seconds
            'query_count' => 50,
            'file_count' => 100
        );
        
        foreach ($metrics as $metric => $value) {
            if (isset($thresholds[$metric]) && $value > $thresholds[$metric]) {
                Daystar_Security_Access_Control::log_action(
                    'performance_threshold_exceeded',
                    'performance',
                    null,
                    array(
                        'metric' => $metric,
                        'value' => $value,
                        'threshold' => $thresholds[$metric]
                    ),
                    'warning'
                );
            }
        }
        
        return $metrics;
    }
    
    /**
     * Validate security practices
     */
    private function validate_security_practices() {
        $security_checks = array();
        
        // Check if security headers are set
        $headers = headers_list();
        $required_headers = array('X-Content-Type-Options', 'X-Frame-Options', 'X-XSS-Protection');
        
        foreach ($required_headers as $header) {
            $found = false;
            foreach ($headers as $set_header) {
                if (strpos($set_header, $header) === 0) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $security_checks[] = "Missing security header: {$header}";
            }
        }
        
        // Check WordPress version
        $wp_version = get_bloginfo('version');
        if (version_compare($wp_version, '6.0', '<')) {
            $security_checks[] = "WordPress version outdated: {$wp_version}";
        }
        
        if (!empty($security_checks)) {
            Daystar_Security_Access_Control::log_action(
                'security_validation_issues',
                'security',
                null,
                array('issues' => $security_checks),
                'warning'
            );
        }
        
        return $security_checks;
    }
    
    /**
     * AJAX handler for code analysis
     */
    public function ajax_run_code_analysis() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_code_analysis')) {
            wp_die('Security check failed');
        }
        
        $violations = $this->check_coding_standards();
        $performance = $this->analyze_performance_metrics();
        $security = $this->validate_security_practices();
        
        wp_send_json_success(array(
            'violations' => $violations,
            'performance' => $performance,
            'security' => $security
        ));
    }
}

/**
 * Documentation Generator
 */
class Daystar_Documentation_Generator {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('wp_ajax_generate_documentation', array($this, 'ajax_generate_documentation'));
    }
    
    /**
     * Generate comprehensive documentation
     */
    public function generate_documentation() {
        $documentation = array(
            'system_overview' => $this->generate_system_overview(),
            'api_documentation' => $this->generate_api_documentation(),
            'database_schema' => $this->generate_database_schema(),
            'security_documentation' => $this->generate_security_documentation(),
            'deployment_guide' => $this->generate_deployment_guide()
        );
        
        return $documentation;
    }
    
    /**
     * Generate system overview documentation
     */
    private function generate_system_overview() {
        return array(
            'title' => 'Daystar SACCO System Overview',
            'version' => get_option('daystar_system_version', '1.0.0'),
            'description' => 'Comprehensive SACCO management system built on WordPress',
            'architecture' => array(
                'frontend' => 'WordPress theme with custom templates',
                'backend' => 'PHP with WordPress hooks and custom classes',
                'database' => 'MySQL with custom tables for SACCO operations',
                'security' => 'Multi-layered security with audit logging',
                'performance' => 'Optimized with caching and async processing'
            ),
            'key_features' => array(
                'Member Management',
                'Loan Processing',
                'Savings Management',
                'Reporting System',
                'Security & Audit',
                'Performance Monitoring'
            )
        );
    }
    
    /**
     * Generate API documentation
     */
    private function generate_api_documentation() {
        $endpoints = array();
        
        // Scan for AJAX endpoints
        $theme_files = $this->get_php_files(get_template_directory());
        
        foreach ($theme_files as $file) {
            $content = file_get_contents($file);
            
            // Find AJAX actions
            if (preg_match_all('/add_action\s*\(\s*[\'"]wp_ajax_([^\'"]+)[\'"]/', $content, $matches)) {
                foreach ($matches[1] as $action) {
                    $endpoints[] = array(
                        'endpoint' => $action,
                        'file' => basename($file),
                        'method' => 'POST',
                        'authentication' => 'required'
                    );
                }
            }
            
            if (preg_match_all('/add_action\s*\(\s*[\'"]wp_ajax_nopriv_([^\'"]+)[\'"]/', $content, $matches)) {
                foreach ($matches[1] as $action) {
                    $endpoints[] = array(
                        'endpoint' => $action,
                        'file' => basename($file),
                        'method' => 'POST',
                        'authentication' => 'optional'
                    );
                }
            }
        }
        
        return array(
            'title' => 'API Documentation',
            'base_url' => admin_url('admin-ajax.php'),
            'endpoints' => $endpoints
        );
    }
    
    /**
     * Generate database schema documentation
     */
    private function generate_database_schema() {
        global $wpdb;
        
        $tables = array();
        
        // Get all tables with daystar prefix
        $daystar_tables = $wpdb->get_results(
            "SHOW TABLES LIKE '{$wpdb->prefix}daystar_%'",
            ARRAY_N
        );
        
        foreach ($daystar_tables as $table) {
            $table_name = $table[0];
            $columns = $wpdb->get_results("DESCRIBE {$table_name}");
            
            $tables[$table_name] = array(
                'columns' => $columns,
                'purpose' => $this->get_table_purpose($table_name)
            );
        }
        
        return array(
            'title' => 'Database Schema',
            'tables' => $tables
        );
    }
    
    /**
     * Get table purpose description
     */
    private function get_table_purpose($table_name) {
        $purposes = array(
            'daystar_audit_log' => 'Stores all system audit events and user actions',
            'daystar_loan_applications' => 'Manages loan application data and status',
            'daystar_member_profiles' => 'Extended member profile information',
            'daystar_async_jobs' => 'Queue for background processing jobs',
            'daystar_system_config' => 'System configuration and settings'
        );
        
        return isset($purposes[$table_name]) ? $purposes[$table_name] : 'Custom system table';
    }
    
    /**
     * Generate security documentation
     */
    private function generate_security_documentation() {
        return array(
            'title' => 'Security Documentation',
            'authentication' => array(
                'method' => 'WordPress user authentication',
                'session_management' => 'Custom session security validation',
                'password_policy' => 'Enforced strong password requirements'
            ),
            'authorization' => array(
                'role_based_access' => 'WordPress roles with custom capabilities',
                'permission_checks' => 'Function-level permission validation',
                'audit_logging' => 'Comprehensive action logging'
            ),
            'data_protection' => array(
                'input_validation' => 'All inputs sanitized and validated',
                'output_escaping' => 'All outputs properly escaped',
                'sql_injection_prevention' => 'Prepared statements for all queries',
                'xss_prevention' => 'Content Security Policy and output escaping'
            ),
            'monitoring' => array(
                'failed_login_tracking' => 'Automatic lockout after failed attempts',
                'security_headers' => 'Comprehensive security headers',
                'vulnerability_scanning' => 'Automated security checks'
            )
        );
    }
    
    /**
     * Generate deployment guide
     */
    private function generate_deployment_guide() {
        return array(
            'title' => 'Deployment Guide',
            'requirements' => array(
                'php_version' => '7.4 or higher',
                'wordpress_version' => '5.8 or higher',
                'mysql_version' => '5.7 or higher',
                'memory_limit' => '256MB minimum',
                'max_execution_time' => '300 seconds'
            ),
            'installation_steps' => array(
                '1. Upload theme files to wp-content/themes/',
                '2. Activate the theme in WordPress admin',
                '3. Run database setup from admin panel',
                '4. Configure system settings',
                '5. Set up automated backups',
                '6. Configure monitoring alerts'
            ),
            'configuration' => array(
                'security_settings' => 'Configure in includes/security-config.php',
                'performance_settings' => 'Configure in includes/performance-optimization.php',
                'monitoring_settings' => 'Configure in includes/reliability-monitoring.php'
            ),
            'maintenance' => array(
                'regular_backups' => 'Automated daily backups configured',
                'log_monitoring' => 'Review audit logs regularly',
                'performance_monitoring' => 'Monitor system health dashboard',
                'security_updates' => 'Keep WordPress and plugins updated'
            )
        );
    }
    
    /**
     * Get PHP files recursively
     */
    private function get_php_files($directory) {
        $files = array();
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    /**
     * AJAX handler for documentation generation
     */
    public function ajax_generate_documentation() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_generate_docs')) {
            wp_die('Security check failed');
        }
        
        $documentation = $this->generate_documentation();
        
        // Save documentation to file
        $upload_dir = wp_upload_dir();
        $docs_file = $upload_dir['basedir'] . '/daystar_documentation_' . date('Y-m-d') . '.json';
        file_put_contents($docs_file, json_encode($documentation, JSON_PRETTY_PRINT));
        
        wp_send_json_success(array(
            'documentation' => $documentation,
            'file' => $docs_file
        ));
    }
}

/**
 * Testing Framework
 */
class Daystar_Testing_Framework {
    
    private static $instance = null;
    private $test_results = array();
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('wp_ajax_run_system_tests', array($this, 'ajax_run_system_tests'));
    }
    
    /**
     * Run comprehensive system tests
     */
    public function run_system_tests() {
        $this->test_results = array();
        
        // Core functionality tests
        $this->test_database_connectivity();
        $this->test_user_authentication();
        $this->test_loan_calculations();
        $this->test_security_features();
        $this->test_performance_metrics();
        
        return $this->test_results;
    }
    
    /**
     * Test database connectivity
     */
    private function test_database_connectivity() {
        $test_name = 'Database Connectivity';
        
        try {
            global $wpdb;
            $result = $wpdb->get_var("SELECT 1");
            
            if ($result === '1') {
                $this->add_test_result($test_name, true, 'Database connection successful');
            } else {
                $this->add_test_result($test_name, false, 'Database query returned unexpected result');
            }
        } catch (Exception $e) {
            $this->add_test_result($test_name, false, 'Database connection failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test user authentication
     */
    private function test_user_authentication() {
        $test_name = 'User Authentication';
        
        try {
            // Test password validation
            $password_validation = Daystar_Security_Config::validate_password_strength('TestPassword123!');
            
            if ($password_validation['valid']) {
                $this->add_test_result($test_name, true, 'Password validation working correctly');
            } else {
                $this->add_test_result($test_name, false, 'Password validation failed');
            }
        } catch (Exception $e) {
            $this->add_test_result($test_name, false, 'Authentication test failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test loan calculations
     */
    private function test_loan_calculations() {
        $test_name = 'Loan Calculations';
        
        try {
            // Test basic loan calculation
            if (function_exists('daystar_calculate_loan_payment')) {
                $calculation = daystar_calculate_loan_payment(1, 100000, 12);
                
                if ($calculation && isset($calculation['monthly_payment'])) {
                    $this->add_test_result($test_name, true, 'Loan calculation successful');
                } else {
                    $this->add_test_result($test_name, false, 'Loan calculation returned invalid result');
                }
            } else {
                $this->add_test_result($test_name, false, 'Loan calculation function not found');
            }
        } catch (Exception $e) {
            $this->add_test_result($test_name, false, 'Loan calculation test failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test security features
     */
    private function test_security_features() {
        $test_name = 'Security Features';
        
        try {
            // Test nonce generation
            $nonce = wp_create_nonce('test_action');
            
            if ($nonce && wp_verify_nonce($nonce, 'test_action')) {
                $this->add_test_result($test_name, true, 'Nonce system working correctly');
            } else {
                $this->add_test_result($test_name, false, 'Nonce system failed');
            }
        } catch (Exception $e) {
            $this->add_test_result($test_name, false, 'Security test failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test performance metrics
     */
    private function test_performance_metrics() {
        $test_name = 'Performance Metrics';
        
        try {
            $start_time = microtime(true);
            $start_memory = memory_get_usage();
            
            // Simulate some work
            for ($i = 0; $i < 1000; $i++) {
                $dummy = md5($i);
            }
            
            $execution_time = microtime(true) - $start_time;
            $memory_used = memory_get_usage() - $start_memory;
            
            if ($execution_time < 1.0 && $memory_used < 1024 * 1024) { // 1 second, 1MB
                $this->add_test_result($test_name, true, 'Performance within acceptable limits');
            } else {
                $this->add_test_result($test_name, false, 'Performance below expectations');
            }
        } catch (Exception $e) {
            $this->add_test_result($test_name, false, 'Performance test failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Add test result
     */
    private function add_test_result($test_name, $passed, $message) {
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message,
            'timestamp' => current_time('mysql')
        );
    }
    
    /**
     * AJAX handler for running tests
     */
    public function ajax_run_system_tests() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_run_tests')) {
            wp_die('Security check failed');
        }
        
        $test_results = $this->run_system_tests();
        
        wp_send_json_success($test_results);
    }
}

// Initialize maintainability framework
add_action('plugins_loaded', function() {
    Daystar_Code_Quality::get_instance();
    Daystar_Documentation_Generator::get_instance();
    Daystar_Testing_Framework::get_instance();
});