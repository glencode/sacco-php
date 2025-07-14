<?php
/**
 * Scalability Framework
 * Implements architecture and optimizations for handling growth in users and data
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Scalability Manager
 */
class Daystar_Scalability_Manager {
    
    private static $instance = null;
    private $load_balancer_config = array();
    private $database_sharding_config = array();
    private $cdn_config = array();
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('init', array($this, 'init_scalability_features'));
        add_action('wp_ajax_check_system_capacity', array($this, 'ajax_check_system_capacity'));
        add_action('wp_ajax_optimize_for_scale', array($this, 'ajax_optimize_for_scale'));
        
        // Database optimization hooks
        add_filter('posts_clauses', array($this, 'optimize_large_queries'), 10, 2);
        add_action('pre_get_posts', array($this, 'optimize_post_queries'));
        
        // Caching hooks for scalability
        add_action('save_post', array($this, 'invalidate_scaled_cache'));
        add_action('user_register', array($this, 'update_user_metrics'));
        add_action('profile_update', array($this, 'update_user_metrics'));
    }
    
    /**
     * Initialize scalability features
     */
    public function init_scalability_features() {
        $this->init_database_optimization();
        $this->init_caching_strategy();
        $this->init_load_distribution();
        $this->init_resource_monitoring();
        $this->schedule_capacity_checks();
    }
    
    /**
     * Initialize database optimization for scale
     */
    private function init_database_optimization() {
        // Set up database connection pooling if available
        if (defined('DB_CONNECTION_POOL') && DB_CONNECTION_POOL) {
            add_filter('wp_db_connection_string', array($this, 'optimize_db_connection'));
        }
        
        // Initialize read/write splitting
        $this->init_read_write_splitting();
        
        // Set up query optimization
        add_filter('query', array($this, 'optimize_database_query'));
        
        // Initialize database indexing recommendations
        add_action('admin_init', array($this, 'check_database_indexes'));
    }
    
    /**
     * Initialize advanced caching strategy
     */
    private function init_caching_strategy() {
        // Multi-tier caching setup
        $this->setup_object_cache();
        $this->setup_page_cache();
        $this->setup_fragment_cache();
        $this->setup_cdn_integration();
        
        // Cache warming
        add_action('daystar_warm_cache', array($this, 'warm_critical_cache'));
        
        if (!wp_next_scheduled('daystar_warm_cache')) {
            wp_schedule_event(time(), 'hourly', 'daystar_warm_cache');
        }
    }
    
    /**
     * Initialize load distribution
     */
    private function init_load_distribution() {
        // Set up session distribution
        $this->configure_session_handling();
        
        // Initialize request routing
        add_action('init', array($this, 'route_heavy_requests'), 1);
        
        // Set up static asset distribution
        add_filter('wp_get_attachment_url', array($this, 'distribute_static_assets'));
    }
    
    /**
     * Initialize resource monitoring
     */
    private function init_resource_monitoring() {
        // Monitor concurrent users
        add_action('wp_login', array($this, 'track_concurrent_users'));
        add_action('wp_logout', array($this, 'track_user_logout'));
        
        // Monitor resource usage
        add_action('shutdown', array($this, 'log_resource_usage'));
        
        // Monitor database performance
        add_filter('query', array($this, 'monitor_query_performance'));
    }
    
    /**
     * Set up object cache for scalability
     */
    private function setup_object_cache() {
        // Configure Redis/Memcached if available
        if (class_exists('Redis') || class_exists('Memcached')) {
            $this->configure_external_cache();
        }
        
        // Set up cache groups for different data types
        wp_cache_add_global_groups(array(
            'daystar_users',
            'daystar_loans_heavy',
            'daystar_reports_cache',
            'daystar_calculations_cache',
            'daystar_session_data'
        ));
    }
    
    /**
     * Configure external cache (Redis/Memcached)
     */
    private function configure_external_cache() {
        // Redis configuration
        if (class_exists('Redis') && defined('REDIS_HOST')) {
            try {
                $redis = new Redis();
                $redis->connect(REDIS_HOST, REDIS_PORT ?? 6379);
                
                if (defined('REDIS_PASSWORD')) {
                    $redis->auth(REDIS_PASSWORD);
                }
                
                // Set up Redis as object cache backend
                wp_cache_init();
                
            } catch (Exception $e) {
                error_log('Redis connection failed: ' . $e->getMessage());
            }
        }
        
        // Memcached configuration
        elseif (class_exists('Memcached') && defined('MEMCACHED_HOST')) {
            try {
                $memcached = new Memcached();
                $memcached->addServer(MEMCACHED_HOST, MEMCACHED_PORT ?? 11211);
                
                // Test connection
                $memcached->set('test_key', 'test_value', 60);
                
            } catch (Exception $e) {
                error_log('Memcached connection failed: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * Set up page cache
     */
    private function setup_page_cache() {
        // Implement page-level caching for high-traffic pages
        add_action('template_redirect', array($this, 'serve_cached_page'), 1);
        add_action('wp_footer', array($this, 'cache_current_page'), 999);
    }
    
    /**
     * Set up fragment cache
     */
    private function setup_fragment_cache() {
        // Cache expensive template parts
        add_action('get_template_part', array($this, 'cache_template_part'), 10, 2);
    }
    
    /**
     * Set up CDN integration
     */
    private function setup_cdn_integration() {
        if (defined('CDN_URL') && CDN_URL) {
            add_filter('wp_get_attachment_url', array($this, 'use_cdn_for_assets'));
            add_filter('stylesheet_uri', array($this, 'use_cdn_for_css'));
            add_filter('script_loader_src', array($this, 'use_cdn_for_js'));
        }
    }
    
    /**
     * Initialize read/write database splitting
     */
    private function init_read_write_splitting() {
        if (defined('DB_READ_HOST') && DB_READ_HOST) {
            add_filter('wp_db_server', array($this, 'route_database_queries'));
        }
    }
    
    /**
     * Route database queries to appropriate servers
     */
    public function route_database_queries($server, $query = '') {
        // Route read queries to read replicas
        if ($this->is_read_query($query)) {
            return array(
                'host' => DB_READ_HOST,
                'user' => DB_READ_USER ?? DB_USER,
                'password' => DB_READ_PASSWORD ?? DB_PASSWORD,
                'name' => DB_READ_NAME ?? DB_NAME
            );
        }
        
        // Route write queries to master
        return $server;
    }
    
    /**
     * Check if query is a read operation
     */
    private function is_read_query($query) {
        $read_operations = array('SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN');
        $query_type = strtoupper(trim(substr($query, 0, 10)));
        
        foreach ($read_operations as $operation) {
            if (strpos($query_type, $operation) === 0) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Optimize large queries for scalability
     */
    public function optimize_large_queries($clauses, $query) {
        global $wpdb;
        
        // Add LIMIT to potentially large queries
        if (empty($clauses['limits']) && !$query->is_singular()) {
            $post_type = $query->get('post_type');
            
            // Set reasonable limits for different post types
            $limits = array(
                'loan' => 50,
                'member' => 100,
                'transaction' => 200,
                'default' => 20
            );
            
            $limit = isset($limits[$post_type]) ? $limits[$post_type] : $limits['default'];
            $clauses['limits'] = "LIMIT {$limit}";
        }
        
        // Optimize JOIN queries
        if (!empty($clauses['join'])) {
            $clauses['join'] = $this->optimize_joins($clauses['join']);
        }
        
        return $clauses;
    }
    
    /**
     * Optimize JOIN operations
     */
    private function optimize_joins($join_clause) {
        global $wpdb;
        
        // Add index hints for common joins
        $optimized_joins = array(
            "INNER JOIN {$wpdb->postmeta}" => "INNER JOIN {$wpdb->postmeta} USE INDEX (meta_key, post_id)",
            "LEFT JOIN {$wpdb->postmeta}" => "LEFT JOIN {$wpdb->postmeta} USE INDEX (meta_key, post_id)",
            "INNER JOIN {$wpdb->usermeta}" => "INNER JOIN {$wpdb->usermeta} USE INDEX (meta_key, user_id)"
        );
        
        foreach ($optimized_joins as $original => $optimized) {
            $join_clause = str_replace($original, $optimized, $join_clause);
        }
        
        return $join_clause;
    }
    
    /**
     * Optimize post queries for large datasets
     */
    public function optimize_post_queries($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }
        
        // Implement pagination for large result sets
        if (!$query->get('posts_per_page')) {
            $query->set('posts_per_page', 20);
        }
        
        // Optimize meta queries
        $meta_query = $query->get('meta_query');
        if ($meta_query && is_array($meta_query)) {
            $meta_query = $this->optimize_meta_query($meta_query);
            $query->set('meta_query', $meta_query);
        }
        
        // Add caching for expensive queries
        if ($this->is_expensive_query($query)) {
            $this->cache_query_results($query);
        }
    }
    
    /**
     * Optimize meta queries
     */
    private function optimize_meta_query($meta_query) {
        // Ensure proper indexing hints
        foreach ($meta_query as $key => $clause) {
            if (is_array($clause) && isset($clause['key'])) {
                // Add compare optimization
                if (!isset($clause['compare'])) {
                    $clause['compare'] = '=';
                }
                
                $meta_query[$key] = $clause;
            }
        }
        
        // Set relation if not specified
        if (!isset($meta_query['relation'])) {
            $meta_query['relation'] = 'AND';
        }
        
        return $meta_query;
    }
    
    /**
     * Check if query is expensive
     */
    private function is_expensive_query($query) {
        $expensive_conditions = array(
            $query->get('meta_query') && count($query->get('meta_query')) > 3,
            $query->get('tax_query') && count($query->get('tax_query')) > 2,
            $query->get('posts_per_page') > 100,
            $query->get('orderby') === 'meta_value_num'
        );
        
        return in_array(true, $expensive_conditions);
    }
    
    /**
     * Cache query results
     */
    private function cache_query_results($query) {
        $cache_key = 'expensive_query_' . md5(serialize($query->query_vars));
        
        // Try to get from cache first
        $cached_results = wp_cache_get($cache_key, 'daystar_queries');
        
        if ($cached_results !== false) {
            // Modify query to use cached results
            add_filter('posts_pre_query', function() use ($cached_results) {
                return $cached_results;
            }, 10, 1);
        } else {
            // Cache results after query execution
            add_action('wp', function() use ($cache_key, $query) {
                if ($query->have_posts()) {
                    wp_cache_set($cache_key, $query->posts, 'daystar_queries', 3600);
                }
            });
        }
    }
    
    /**
     * Serve cached page if available
     */
    public function serve_cached_page() {
        if (is_admin() || is_user_logged_in() || $_POST) {
            return;
        }
        
        $cache_key = 'page_cache_' . md5($_SERVER['REQUEST_URI']);
        $cached_page = wp_cache_get($cache_key, 'daystar_pages');
        
        if ($cached_page !== false) {
            echo $cached_page;
            exit;
        }
    }
    
    /**
     * Cache current page
     */
    public function cache_current_page() {
        if (is_admin() || is_user_logged_in() || $_POST) {
            return;
        }
        
        $cache_key = 'page_cache_' . md5($_SERVER['REQUEST_URI']);
        
        ob_start();
        // Page content is already output, so we capture it
        $page_content = ob_get_contents();
        ob_end_clean();
        
        // Cache for 1 hour
        wp_cache_set($cache_key, $page_content, 'daystar_pages', 3600);
        
        echo $page_content;
    }
    
    /**
     * Cache template parts
     */
    public function cache_template_part($slug, $name = null) {
        $cache_key = 'template_part_' . $slug . ($name ? '_' . $name : '');
        $cached_content = wp_cache_get($cache_key, 'daystar_templates');
        
        if ($cached_content !== false) {
            echo $cached_content;
            return;
        }
        
        // If not cached, capture output and cache it
        ob_start();
    }
    
    /**
     * Use CDN for assets
     */
    public function use_cdn_for_assets($url) {
        if (defined('CDN_URL') && CDN_URL) {
            $upload_dir = wp_upload_dir();
            $base_url = $upload_dir['baseurl'];
            
            if (strpos($url, $base_url) === 0) {
                return str_replace($base_url, CDN_URL, $url);
            }
        }
        
        return $url;
    }
    
    /**
     * Use CDN for CSS files
     */
    public function use_cdn_for_css($url) {
        if (defined('CDN_URL') && CDN_URL) {
            $theme_url = get_template_directory_uri();
            
            if (strpos($url, $theme_url) === 0) {
                return str_replace($theme_url, CDN_URL . '/themes/' . get_template(), $url);
            }
        }
        
        return $url;
    }
    
    /**
     * Use CDN for JavaScript files
     */
    public function use_cdn_for_js($url) {
        if (defined('CDN_URL') && CDN_URL) {
            $theme_url = get_template_directory_uri();
            
            if (strpos($url, $theme_url) === 0) {
                return str_replace($theme_url, CDN_URL . '/themes/' . get_template(), $url);
            }
        }
        
        return $url;
    }
    
    /**
     * Configure session handling for scalability
     */
    private function configure_session_handling() {
        // Use database or external cache for sessions in scaled environment
        if (defined('SCALE_SESSIONS') && SCALE_SESSIONS) {
            ini_set('session.save_handler', 'user');
            session_set_save_handler(
                array($this, 'session_open'),
                array($this, 'session_close'),
                array($this, 'session_read'),
                array($this, 'session_write'),
                array($this, 'session_destroy'),
                array($this, 'session_gc')
            );
        }
    }
    
    /**
     * Route heavy requests to appropriate handlers
     */
    public function route_heavy_requests() {
        $heavy_operations = array(
            'generate_report',
            'bulk_export',
            'data_migration',
            'backup_creation'
        );
        
        $current_action = $_REQUEST['action'] ?? '';
        
        if (in_array($current_action, $heavy_operations)) {
            // Route to background processing
            $async_processor = Daystar_Async_Processor::get_instance();
            $job_id = $async_processor->queue_job($current_action, $_REQUEST, 5);
            
            wp_send_json_success(array(
                'message' => 'Request queued for processing',
                'job_id' => $job_id
            ));
            exit;
        }
    }
    
    /**
     * Track concurrent users
     */
    public function track_concurrent_users($user_login) {
        $user = get_user_by('login', $user_login);
        
        if ($user) {
            // Update active users count
            $active_users = get_option('daystar_active_users', array());
            $active_users[$user->ID] = time();
            
            // Clean up old sessions (older than 30 minutes)
            $cutoff = time() - 1800;
            foreach ($active_users as $user_id => $last_activity) {
                if ($last_activity < $cutoff) {
                    unset($active_users[$user_id]);
                }
            }
            
            update_option('daystar_active_users', $active_users);
            
            // Log concurrent user metrics
            $concurrent_count = count($active_users);
            
            Daystar_Security_Access_Control::log_action(
                'concurrent_users_metric',
                'scalability',
                null,
                array(
                    'concurrent_users' => $concurrent_count,
                    'user_login' => $user_login
                ),
                'info'
            );
            
            // Alert if concurrent users exceed threshold
            $threshold = get_option('daystar_concurrent_user_threshold', 100);
            if ($concurrent_count > $threshold) {
                $this->alert_high_concurrency($concurrent_count);
            }
        }
    }
    
    /**
     * Track user logout
     */
    public function track_user_logout() {
        $user_id = get_current_user_id();
        
        if ($user_id) {
            $active_users = get_option('daystar_active_users', array());
            unset($active_users[$user_id]);
            update_option('daystar_active_users', $active_users);
        }
    }
    
    /**
     * Log resource usage for scaling decisions
     */
    public function log_resource_usage() {
        $metrics = array(
            'memory_usage' => memory_get_peak_usage(true),
            'execution_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
            'query_count' => get_num_queries(),
            'concurrent_users' => count(get_option('daystar_active_users', array())),
            'timestamp' => current_time('mysql')
        );
        
        // Store metrics for analysis
        $this->store_scaling_metrics($metrics);
        
        // Check if scaling is needed
        if ($this->should_scale($metrics)) {
            $this->trigger_scaling_alert($metrics);
        }
    }
    
    /**
     * Store scaling metrics
     */
    private function store_scaling_metrics($metrics) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_scaling_metrics';
        
        $wpdb->insert(
            $table_name,
            array(
                'memory_usage' => $metrics['memory_usage'],
                'execution_time' => $metrics['execution_time'],
                'query_count' => $metrics['query_count'],
                'concurrent_users' => $metrics['concurrent_users'],
                'timestamp' => $metrics['timestamp']
            ),
            array('%d', '%f', '%d', '%d', '%s')
        );
    }
    
    /**
     * Check if scaling is needed
     */
    private function should_scale($metrics) {
        $thresholds = array(
            'memory_usage' => 128 * 1024 * 1024, // 128MB
            'execution_time' => 5.0, // 5 seconds
            'query_count' => 100,
            'concurrent_users' => 200
        );
        
        foreach ($thresholds as $metric => $threshold) {
            if (isset($metrics[$metric]) && $metrics[$metric] > $threshold) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Trigger scaling alert
     */
    private function trigger_scaling_alert($metrics) {
        Daystar_Security_Access_Control::log_action(
            'scaling_threshold_exceeded',
            'scalability',
            null,
            $metrics,
            'warning'
        );
        
        // Send alert to administrators
        $subject = 'Daystar SACCO - Scaling Alert';
        $message = "System metrics indicate scaling may be needed:\n\n";
        
        foreach ($metrics as $key => $value) {
            $message .= ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
        }
        
        $message .= "\nConsider implementing scaling measures.";
        
        wp_mail(get_option('admin_email'), $subject, $message);
    }
    
    /**
     * Alert high concurrency
     */
    private function alert_high_concurrency($count) {
        $last_alert = get_option('daystar_last_concurrency_alert', 0);
        
        // Only alert once per hour
        if (time() - $last_alert > 3600) {
            Daystar_Security_Access_Control::log_action(
                'high_concurrency_alert',
                'scalability',
                null,
                array('concurrent_users' => $count),
                'warning'
            );
            
            update_option('daystar_last_concurrency_alert', time());
        }
    }
    
    /**
     * Warm critical cache
     */
    public function warm_critical_cache() {
        $critical_pages = array(
            home_url('/'),
            home_url('/login/'),
            home_url('/member-dashboard/'),
            home_url('/loan-application/'),
            home_url('/products-services/')
        );
        
        foreach ($critical_pages as $url) {
            wp_remote_get($url, array('timeout' => 30));
        }
        
        // Warm critical data cache
        $this->warm_data_cache();
    }
    
    /**
     * Warm data cache
     */
    private function warm_data_cache() {
        // Cache loan products
        $loan_products = get_posts(array(
            'post_type' => 'loan',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'loan_status',
                    'value' => 'active'
                )
            )
        ));
        
        wp_cache_set('active_loan_products', $loan_products, 'daystar_loans_heavy', 3600);
        
        // Cache savings products
        $savings_products = get_posts(array(
            'post_type' => 'savings',
            'posts_per_page' => -1
        ));
        
        wp_cache_set('savings_products', $savings_products, 'daystar_calculations_cache', 3600);
    }
    
    /**
     * Schedule capacity checks
     */
    private function schedule_capacity_checks() {
        if (!wp_next_scheduled('daystar_capacity_check')) {
            wp_schedule_event(time(), 'hourly', 'daystar_capacity_check');
        }
        
        add_action('daystar_capacity_check', array($this, 'check_system_capacity'));
    }
    
    /**
     * Check system capacity
     */
    public function check_system_capacity() {
        $capacity_metrics = array(
            'database_size' => $this->get_database_size(),
            'file_system_usage' => $this->get_filesystem_usage(),
            'active_users' => count(get_option('daystar_active_users', array())),
            'query_performance' => $this->get_average_query_time(),
            'memory_usage' => $this->get_average_memory_usage()
        );
        
        // Store capacity metrics
        update_option('daystar_capacity_metrics', $capacity_metrics);
        
        return $capacity_metrics;
    }
    
    /**
     * Get database size
     */
    private function get_database_size() {
        global $wpdb;
        
        $result = $wpdb->get_var("
            SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) 
            FROM information_schema.tables 
            WHERE table_schema = '" . DB_NAME . "'
        ");
        
        return floatval($result);
    }
    
    /**
     * Get filesystem usage
     */
    private function get_filesystem_usage() {
        $upload_dir = wp_upload_dir();
        $total_space = disk_total_space($upload_dir['basedir']);
        $free_space = disk_free_space($upload_dir['basedir']);
        
        return array(
            'total_gb' => round($total_space / 1024 / 1024 / 1024, 2),
            'free_gb' => round($free_space / 1024 / 1024 / 1024, 2),
            'used_percent' => round((($total_space - $free_space) / $total_space) * 100, 2)
        );
    }
    
    /**
     * Get average query time
     */
    private function get_average_query_time() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_scaling_metrics';
        
        $avg_time = $wpdb->get_var("
            SELECT AVG(execution_time) 
            FROM {$table_name} 
            WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        
        return floatval($avg_time);
    }
    
    /**
     * Get average memory usage
     */
    private function get_average_memory_usage() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_scaling_metrics';
        
        $avg_memory = $wpdb->get_var("
            SELECT AVG(memory_usage) 
            FROM {$table_name} 
            WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        
        return intval($avg_memory);
    }
    
    /**
     * AJAX handler for capacity check
     */
    public function ajax_check_system_capacity() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_capacity_check')) {
            wp_die('Security check failed');
        }
        
        $capacity_metrics = $this->check_system_capacity();
        
        wp_send_json_success($capacity_metrics);
    }
    
    /**
     * AJAX handler for scaling optimization
     */
    public function ajax_optimize_for_scale() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'daystar_optimize_scale')) {
            wp_die('Security check failed');
        }
        
        $optimization_results = array();
        
        // Clear all caches
        wp_cache_flush();
        $optimization_results['cache_cleared'] = true;
        
        // Optimize database tables
        $optimizer = Daystar_Performance_Optimizer::get_instance();
        $optimizer->optimize_database_tables();
        $optimization_results['database_optimized'] = true;
        
        // Warm critical cache
        $this->warm_critical_cache();
        $optimization_results['cache_warmed'] = true;
        
        wp_send_json_success($optimization_results);
    }
    
    // Session handler methods for scalable session management
    public function session_open($save_path, $session_name) {
        return true;
    }
    
    public function session_close() {
        return true;
    }
    
    public function session_read($session_id) {
        $data = wp_cache_get("session_{$session_id}", 'daystar_session_data');
        return $data ? $data : '';
    }
    
    public function session_write($session_id, $session_data) {
        return wp_cache_set("session_{$session_id}", $session_data, 'daystar_session_data', 1800);
    }
    
    public function session_destroy($session_id) {
        return wp_cache_delete("session_{$session_id}", 'daystar_session_data');
    }
    
    public function session_gc($max_lifetime) {
        // Garbage collection is handled by cache expiration
        return true;
    }
}

// Initialize scalability framework
add_action('plugins_loaded', function() {
    Daystar_Scalability_Manager::get_instance();
});

// Create scaling metrics table
register_activation_hook(__FILE__, function() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_scaling_metrics';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        memory_usage bigint(20) NOT NULL,
        execution_time decimal(10,6) NOT NULL,
        query_count int(11) NOT NULL,
        concurrent_users int(11) NOT NULL,
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY timestamp (timestamp),
        KEY memory_usage (memory_usage),
        KEY concurrent_users (concurrent_users)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
});