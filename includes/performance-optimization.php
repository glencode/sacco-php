<?php
/**
 * Performance Optimization System
 * Implements comprehensive performance enhancements for the Daystar SACCO system
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Performance Optimization Manager
 */
class Daystar_Performance_Optimizer {
    
    private static $instance = null;
    private $cache_enabled = true;
    private $performance_metrics = array();
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Initialize performance optimizations
     */
    public function __construct() {
        add_action('init', array($this, 'init_performance_features'));
        add_action('wp_enqueue_scripts', array($this, 'optimize_assets'), 999);
        add_action('wp_head', array($this, 'add_performance_headers'), 1);
        add_action('wp_footer', array($this, 'add_performance_monitoring'), 999);
        
        // Database optimization hooks
        add_action('pre_get_posts', array($this, 'optimize_queries'));
        add_filter('posts_clauses', array($this, 'optimize_database_queries'), 10, 2);
        
        // Caching hooks
        add_action('save_post', array($this, 'clear_related_cache'));
        add_action('user_register', array($this, 'clear_user_cache'));
        add_action('profile_update', array($this, 'clear_user_cache'));
        
        // Performance monitoring
        add_action('shutdown', array($this, 'log_performance_metrics'));
    }
    
    /**
     * Initialize performance features
     */
    public function init_performance_features() {
        // Enable object caching if available
        if (function_exists('wp_cache_init')) {
            wp_cache_init();
        }
        
        // Set up custom cache groups
        wp_cache_add_global_groups(array(
            'daystar_loans',
            'daystar_members',
            'daystar_reports',
            'daystar_calculations'
        ));
        
        // Initialize performance monitoring
        $this->start_performance_monitoring();
    }
    
    /**
     * Optimize asset loading
     */
    public function optimize_assets() {
        // Defer non-critical JavaScript
        add_filter('script_loader_tag', array($this, 'defer_non_critical_scripts'), 10, 3);
        
        // Preload critical resources
        add_action('wp_head', array($this, 'add_resource_hints'), 2);
        
        // Optimize CSS delivery
        add_filter('style_loader_tag', array($this, 'optimize_css_delivery'), 10, 4);
    }
    
    /**
     * Add performance headers
     */
    public function add_performance_headers() {
        // Add resource hints
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">' . "\n";
        echo '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">' . "\n";
        
        // Preload critical fonts
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
        echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"></noscript>' . "\n";
    }
    
    /**
     * Add resource hints
     */
    public function add_resource_hints() {
        // Preconnect to external domains
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>' . "\n";
        
        // Prefetch next likely pages for logged-in users
        if (is_user_logged_in()) {
            if (is_page('login') || is_page('member-dashboard')) {
                echo '<link rel="prefetch" href="' . home_url('/member-dashboard/') . '">' . "\n";
            }
            if (is_page('member-dashboard')) {
                echo '<link rel="prefetch" href="' . home_url('/loan-application/') . '">' . "\n";
                echo '<link rel="prefetch" href="' . home_url('/member-profile/') . '">' . "\n";
            }
        }
    }
    
    /**
     * Defer non-critical scripts
     */
    public function defer_non_critical_scripts($tag, $handle, $src) {
        // Critical scripts that should not be deferred
        $critical_scripts = array(
            'jquery-core',
            'jquery-migrate',
            'bootstrap-js'
        );
        
        if (in_array($handle, $critical_scripts)) {
            return $tag;
        }
        
        // Add defer attribute to non-critical scripts
        if (strpos($tag, 'defer') === false) {
            $tag = str_replace(' src', ' defer src', $tag);
        }
        
        return $tag;
    }
    
    /**
     * Optimize CSS delivery
     */
    public function optimize_css_delivery($html, $handle, $href, $media) {
        // Critical CSS that should load immediately
        $critical_css = array(
            'sacco-php-modern-main',
            'bootstrap'
        );
        
        if (in_array($handle, $critical_css)) {
            return $html;
        }
        
        // Load non-critical CSS asynchronously
        $html = str_replace("media='all'", "media='print' onload=\"this.media='all'\"", $html);
        
        return $html;
    }
    
    /**
     * Optimize database queries
     */
    public function optimize_queries($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }
        
        // Limit posts per page for better performance
        if ($query->is_home() || $query->is_archive()) {
            $query->set('posts_per_page', 12);
        }
        
        // Optimize meta queries
        if ($query->get('meta_query')) {
            $meta_query = $query->get('meta_query');
            if (!isset($meta_query['relation'])) {
                $meta_query['relation'] = 'AND';
                $query->set('meta_query', $meta_query);
            }
        }
    }
    
    /**
     * Optimize database queries with proper indexing hints
     */
    public function optimize_database_queries($clauses, $query) {
        global $wpdb;
        
        // Add index hints for common queries
        if (strpos($clauses['where'], 'meta_key') !== false) {
            $clauses['join'] = str_replace(
                "INNER JOIN {$wpdb->postmeta}",
                "INNER JOIN {$wpdb->postmeta} USE INDEX (meta_key)",
                $clauses['join']
            );
        }
        
        return $clauses;
    }
    
    /**
     * Advanced caching system
     */
    public function get_cached_data($key, $group = 'default') {
        if (!$this->cache_enabled) {
            return false;
        }
        
        return wp_cache_get($key, $group);
    }
    
    /**
     * Set cached data with automatic expiration
     */
    public function set_cached_data($key, $data, $group = 'default', $expiration = 3600) {
        if (!$this->cache_enabled) {
            return false;
        }
        
        return wp_cache_set($key, $data, $group, $expiration);
    }
    
    /**
     * Clear related cache when content is updated
     */
    public function clear_related_cache($post_id) {
        $post_type = get_post_type($post_id);
        
        // Clear relevant cache groups
        switch ($post_type) {
            case 'loan':
                wp_cache_flush_group('daystar_loans');
                wp_cache_flush_group('daystar_calculations');
                break;
            case 'product':
                wp_cache_flush_group('daystar_loans');
                break;
            case 'savings':
                wp_cache_flush_group('daystar_calculations');
                break;
        }
        
        // Clear page cache if using a caching plugin
        if (function_exists('wp_cache_clear_cache')) {
            wp_cache_clear_cache();
        }
    }
    
    /**
     * Clear user-specific cache
     */
    public function clear_user_cache($user_id) {
        wp_cache_delete("user_loans_{$user_id}", 'daystar_members');
        wp_cache_delete("user_eligibility_{$user_id}", 'daystar_members');
        wp_cache_delete("user_dashboard_{$user_id}", 'daystar_members');
    }
    
    /**
     * Fragment caching for complex calculations
     */
    public function get_cached_calculation($calculation_type, $params) {
        $cache_key = $calculation_type . '_' . md5(serialize($params));
        return $this->get_cached_data($cache_key, 'daystar_calculations');
    }
    
    /**
     * Cache calculation results
     */
    public function cache_calculation($calculation_type, $params, $result, $expiration = 1800) {
        $cache_key = $calculation_type . '_' . md5(serialize($params));
        return $this->set_cached_data($cache_key, $result, 'daystar_calculations', $expiration);
    }
    
    /**
     * Start performance monitoring
     */
    private function start_performance_monitoring() {
        $this->performance_metrics['start_time'] = microtime(true);
        $this->performance_metrics['start_memory'] = memory_get_usage();
        $this->performance_metrics['queries_start'] = get_num_queries();
    }
    
    /**
     * Add performance monitoring script
     */
    public function add_performance_monitoring() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $load_time = microtime(true) - $this->performance_metrics['start_time'];
        $memory_usage = memory_get_usage() - $this->performance_metrics['start_memory'];
        $query_count = get_num_queries() - $this->performance_metrics['queries_start'];
        
        ?>
        <script>
        if (typeof console !== 'undefined' && console.log) {
            console.group('🚀 Daystar Performance Metrics');
            console.log('⏱️ Page Load Time: <?php echo round($load_time * 1000, 2); ?>ms');
            console.log('💾 Memory Usage: <?php echo round($memory_usage / 1024 / 1024, 2); ?>MB');
            console.log('🗄️ Database Queries: <?php echo $query_count; ?>');
            console.log('📊 Peak Memory: <?php echo round(memory_get_peak_usage() / 1024 / 1024, 2); ?>MB');
            console.groupEnd();
            
            // Performance API metrics
            if (window.performance && window.performance.timing) {
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        var timing = window.performance.timing;
                        var loadTime = timing.loadEventEnd - timing.navigationStart;
                        var domReady = timing.domContentLoadedEventEnd - timing.navigationStart;
                        var firstPaint = 0;
                        
                        if (window.performance.getEntriesByType) {
                            var paintEntries = window.performance.getEntriesByType('paint');
                            if (paintEntries.length > 0) {
                                firstPaint = paintEntries[0].startTime;
                            }
                        }
                        
                        console.group('🌐 Browser Performance Metrics');
                        console.log('📄 DOM Ready: ' + domReady + 'ms');
                        console.log('🎨 First Paint: ' + Math.round(firstPaint) + 'ms');
                        console.log('✅ Full Load: ' + loadTime + 'ms');
                        console.groupEnd();
                    }, 100);
                });
            }
        }
        </script>
        <?php
    }
    
    /**
     * Log performance metrics for analysis
     */
    public function log_performance_metrics() {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $metrics = array(
                'page' => $_SERVER['REQUEST_URI'] ?? '',
                'load_time' => microtime(true) - $this->performance_metrics['start_time'],
                'memory_usage' => memory_get_usage() - $this->performance_metrics['start_memory'],
                'peak_memory' => memory_get_peak_usage(),
                'query_count' => get_num_queries() - $this->performance_metrics['queries_start'],
                'timestamp' => current_time('mysql')
            );
            
            // Log to custom performance log
            error_log('DAYSTAR_PERFORMANCE: ' . json_encode($metrics));
        }
    }
    
    /**
     * Database optimization utilities
     */
    public function optimize_database_tables() {
        global $wpdb;
        
        // Get all WordPress tables
        $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
        
        foreach ($tables as $table) {
            $table_name = $table[0];
            $wpdb->query("OPTIMIZE TABLE `{$table_name}`");
        }
        
        return true;
    }
    
    /**
     * Clean up expired transients
     */
    public function cleanup_expired_transients() {
        global $wpdb;
        
        // Delete expired transients
        $wpdb->query("
            DELETE FROM {$wpdb->options} 
            WHERE option_name LIKE '_transient_timeout_%' 
            AND option_value < UNIX_TIMESTAMP()
        ");
        
        // Delete orphaned transient options
        $wpdb->query("
            DELETE FROM {$wpdb->options} 
            WHERE option_name LIKE '_transient_%' 
            AND option_name NOT LIKE '_transient_timeout_%' 
            AND NOT EXISTS (
                SELECT 1 FROM {$wpdb->options} t2 
                WHERE t2.option_name = CONCAT('_transient_timeout_', SUBSTRING({$wpdb->options}.option_name, 12))
            )
        ");
        
        return true;
    }
    
    /**
     * Image optimization
     */
    public function optimize_images() {
        // Add WebP support
        add_filter('wp_generate_attachment_metadata', array($this, 'generate_webp_images'), 10, 2);
        
        // Add responsive images
        add_filter('wp_get_attachment_image_attributes', array($this, 'add_responsive_image_attributes'), 10, 3);
    }
    
    /**
     * Generate WebP images for better performance
     */
    public function generate_webp_images($metadata, $attachment_id) {
        if (!function_exists('imagewebp')) {
            return $metadata;
        }
        
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
        
        if (file_exists($file_path)) {
            $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);
            
            $image_type = exif_imagetype($file_path);
            $image = null;
            
            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($file_path);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($file_path);
                    break;
            }
            
            if ($image) {
                imagewebp($image, $webp_path, 80);
                imagedestroy($image);
            }
        }
        
        return $metadata;
    }
    
    /**
     * Add responsive image attributes
     */
    public function add_responsive_image_attributes($attr, $attachment, $size) {
        if (!isset($attr['loading'])) {
            $attr['loading'] = 'lazy';
        }
        
        if (!isset($attr['decoding'])) {
            $attr['decoding'] = 'async';
        }
        
        return $attr;
    }
}

/**
 * Asynchronous Processing Manager
 */
class Daystar_Async_Processor {
    
    private static $instance = null;
    private $job_queue = array();
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('init', array($this, 'init_async_processing'));
        add_action('wp_ajax_process_async_job', array($this, 'process_async_job'));
        add_action('wp_ajax_nopriv_process_async_job', array($this, 'process_async_job'));
    }
    
    /**
     * Initialize async processing
     */
    public function init_async_processing() {
        // Set up cron jobs for background processing
        if (!wp_next_scheduled('daystar_process_background_jobs')) {
            wp_schedule_event(time(), 'hourly', 'daystar_process_background_jobs');
        }
        
        add_action('daystar_process_background_jobs', array($this, 'process_background_jobs'));
    }
    
    /**
     * Queue a job for asynchronous processing
     */
    public function queue_job($job_type, $data, $priority = 10) {
        $job = array(
            'id' => uniqid('job_'),
            'type' => $job_type,
            'data' => $data,
            'priority' => $priority,
            'created' => current_time('mysql'),
            'status' => 'queued'
        );
        
        // Store job in database
        global $wpdb;
        $table_name = $wpdb->prefix . 'daystar_async_jobs';
        
        $wpdb->insert(
            $table_name,
            array(
                'job_id' => $job['id'],
                'job_type' => $job['type'],
                'job_data' => json_encode($job['data']),
                'priority' => $job['priority'],
                'status' => $job['status'],
                'created_at' => $job['created']
            ),
            array('%s', '%s', '%s', '%d', '%s', '%s')
        );
        
        return $job['id'];
    }
    
    /**
     * Process background jobs
     */
    public function process_background_jobs() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'daystar_async_jobs';
        
        // Get pending jobs ordered by priority
        $jobs = $wpdb->get_results(
            "SELECT * FROM {$table_name} 
             WHERE status = 'queued' 
             ORDER BY priority DESC, created_at ASC 
             LIMIT 10"
        );
        
        foreach ($jobs as $job) {
            $this->process_job($job);
        }
    }
    
    /**
     * Process individual job
     */
    private function process_job($job) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'daystar_async_jobs';
        
        // Mark job as processing
        $wpdb->update(
            $table_name,
            array('status' => 'processing', 'started_at' => current_time('mysql')),
            array('id' => $job->id),
            array('%s', '%s'),
            array('%d')
        );
        
        try {
            $job_data = json_decode($job->job_data, true);
            $result = $this->execute_job($job->job_type, $job_data);
            
            // Mark job as completed
            $wpdb->update(
                $table_name,
                array(
                    'status' => 'completed',
                    'completed_at' => current_time('mysql'),
                    'result' => json_encode($result)
                ),
                array('id' => $job->id),
                array('%s', '%s', '%s'),
                array('%d')
            );
            
        } catch (Exception $e) {
            // Mark job as failed
            $wpdb->update(
                $table_name,
                array(
                    'status' => 'failed',
                    'completed_at' => current_time('mysql'),
                    'error_message' => $e->getMessage()
                ),
                array('id' => $job->id),
                array('%s', '%s', '%s'),
                array('%d')
            );
        }
    }
    
    /**
     * Execute specific job types
     */
    private function execute_job($job_type, $data) {
        switch ($job_type) {
            case 'generate_report':
                return $this->generate_report_async($data);
            
            case 'send_bulk_notifications':
                return $this->send_bulk_notifications_async($data);
            
            case 'calculate_interest':
                return $this->calculate_interest_async($data);
            
            case 'backup_data':
                return $this->backup_data_async($data);
            
            default:
                throw new Exception("Unknown job type: {$job_type}");
        }
    }
    
    /**
     * Generate report asynchronously
     */
    private function generate_report_async($data) {
        // Implementation for async report generation
        $report_type = $data['report_type'];
        $parameters = $data['parameters'];
        
        // Generate report based on type
        // This would integrate with the reporting system
        
        return array('status' => 'success', 'report_id' => uniqid('report_'));
    }
    
    /**
     * Send bulk notifications asynchronously
     */
    private function send_bulk_notifications_async($data) {
        $notifications = $data['notifications'];
        $sent_count = 0;
        
        foreach ($notifications as $notification) {
            // Send individual notification
            // This would integrate with the notification system
            $sent_count++;
        }
        
        return array('status' => 'success', 'sent_count' => $sent_count);
    }
    
    /**
     * Calculate interest asynchronously
     */
    private function calculate_interest_async($data) {
        // Implementation for async interest calculation
        return array('status' => 'success', 'calculations_processed' => count($data['accounts']));
    }
    
    /**
     * Backup data asynchronously
     */
    private function backup_data_async($data) {
        // Implementation for async data backup
        return array('status' => 'success', 'backup_file' => 'backup_' . date('Y-m-d_H-i-s') . '.sql');
    }
}

// Initialize performance optimization
add_action('plugins_loaded', function() {
    Daystar_Performance_Optimizer::get_instance();
    Daystar_Async_Processor::get_instance();
});

// Schedule database optimization
if (!wp_next_scheduled('daystar_optimize_database')) {
    wp_schedule_event(time(), 'weekly', 'daystar_optimize_database');
}

add_action('daystar_optimize_database', function() {
    $optimizer = Daystar_Performance_Optimizer::get_instance();
    $optimizer->optimize_database_tables();
    $optimizer->cleanup_expired_transients();
});