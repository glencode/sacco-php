<?php
/**
 * Security Configuration
 * Defines security constants and configurations for the SACCO system
 * 
 * @package Daystar_SACCO
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Security Configuration Class
 */
class Daystar_Security_Config {
    
    /**
     * Initialize security configuration
     */
    public static function init() {
        self::define_encryption_keys();
        self::configure_security_settings();
        self::setup_password_policies();
    }
    
    /**
     * Define encryption keys
     */
    private static function define_encryption_keys() {
        // Define encryption key if not already defined
        if (!defined('DAYSTAR_ENCRYPTION_KEY')) {
            // Generate a secure encryption key based on WordPress salts
            $key = hash('sha256', SECURE_AUTH_KEY . LOGGED_IN_KEY . NONCE_KEY);
            define('DAYSTAR_ENCRYPTION_KEY', $key);
        }
        
        // Define additional security keys
        if (!defined('DAYSTAR_HASH_KEY')) {
            $hash_key = hash('sha256', AUTH_KEY . SECURE_AUTH_SALT . LOGGED_IN_SALT);
            define('DAYSTAR_HASH_KEY', $hash_key);
        }
    }
    
    /**
     * Configure security settings
     */
    private static function configure_security_settings() {
        // Session security settings
        if (!defined('DAYSTAR_SESSION_TIMEOUT')) {
            define('DAYSTAR_SESSION_TIMEOUT', 3600); // 1 hour
        }
        
        if (!defined('DAYSTAR_MAX_LOGIN_ATTEMPTS')) {
            define('DAYSTAR_MAX_LOGIN_ATTEMPTS', 5);
        }
        
        if (!defined('DAYSTAR_LOGIN_LOCKOUT_TIME')) {
            define('DAYSTAR_LOGIN_LOCKOUT_TIME', 900); // 15 minutes
        }
        
        // File upload security
        if (!defined('DAYSTAR_MAX_FILE_SIZE')) {
            define('DAYSTAR_MAX_FILE_SIZE', 5242880); // 5MB
        }
        
        if (!defined('DAYSTAR_ALLOWED_FILE_TYPES')) {
            define('DAYSTAR_ALLOWED_FILE_TYPES', 'pdf,jpg,jpeg,png,doc,docx');
        }
        
        // Audit log retention
        if (!defined('DAYSTAR_AUDIT_LOG_RETENTION_DAYS')) {
            define('DAYSTAR_AUDIT_LOG_RETENTION_DAYS', 365); // 1 year
        }
    }
    
    /**
     * Setup password policies
     */
    private static function setup_password_policies() {
        // Password requirements
        if (!defined('DAYSTAR_MIN_PASSWORD_LENGTH')) {
            define('DAYSTAR_MIN_PASSWORD_LENGTH', 12);
        }
        
        if (!defined('DAYSTAR_REQUIRE_SPECIAL_CHARS')) {
            define('DAYSTAR_REQUIRE_SPECIAL_CHARS', true);
        }
        
        if (!defined('DAYSTAR_REQUIRE_NUMBERS')) {
            define('DAYSTAR_REQUIRE_NUMBERS', true);
        }
        
        if (!defined('DAYSTAR_REQUIRE_UPPERCASE')) {
            define('DAYSTAR_REQUIRE_UPPERCASE', true);
        }
        
        if (!defined('DAYSTAR_PASSWORD_EXPIRY_DAYS')) {
            define('DAYSTAR_PASSWORD_EXPIRY_DAYS', 90); // 3 months
        }
    }
    
    /**
     * Get security headers
     */
    public static function get_security_headers() {
        return array(
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => self::get_csp_header(),
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()'
        );
    }
    
    /**
     * Get Content Security Policy header
     */
    private static function get_csp_header() {
        $csp_directives = array(
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com",
            "img-src 'self' data: https:",
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        );
        
        return implode('; ', $csp_directives);
    }
    
    /**
     * Validate password strength
     */
    public static function validate_password_strength($password) {
        $errors = array();
        
        // Check minimum length
        if (strlen($password) < DAYSTAR_MIN_PASSWORD_LENGTH) {
            $errors[] = 'Password must be at least ' . DAYSTAR_MIN_PASSWORD_LENGTH . ' characters long';
        }
        
        // Check for uppercase letters
        if (DAYSTAR_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }
        
        // Check for numbers
        if (DAYSTAR_REQUIRE_NUMBERS && !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }
        
        // Check for special characters
        if (DAYSTAR_REQUIRE_SPECIAL_CHARS && !preg_match('/[^a-zA-Z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }
        
        // Check for common weak passwords
        $weak_passwords = array(
            'password', '123456', 'qwerty', 'admin', 'letmein',
            'welcome', 'monkey', '1234567890', 'password123'
        );
        
        if (in_array(strtolower($password), $weak_passwords)) {
            $errors[] = 'Password is too common and easily guessable';
        }
        
        return array(
            'valid' => empty($errors),
            'errors' => $errors,
            'strength_score' => self::calculate_password_strength($password)
        );
    }
    
    /**
     * Calculate password strength score (0-100)
     */
    private static function calculate_password_strength($password) {
        $score = 0;
        $length = strlen($password);
        
        // Length score (max 25 points)
        $score += min(25, $length * 2);
        
        // Character variety (max 75 points)
        if (preg_match('/[a-z]/', $password)) $score += 15; // lowercase
        if (preg_match('/[A-Z]/', $password)) $score += 15; // uppercase
        if (preg_match('/[0-9]/', $password)) $score += 15; // numbers
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $score += 15; // special chars
        
        // Bonus for length
        if ($length >= 12) $score += 10;
        if ($length >= 16) $score += 5;
        
        return min(100, $score);
    }
    
    /**
     * Generate secure random token
     */
    public static function generate_secure_token($length = 32) {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length / 2));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length / 2));
        } else {
            // Fallback for older PHP versions
            return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
        }
    }
    
    /**
     * Hash sensitive data
     */
    public static function hash_data($data, $salt = '') {
        if (empty($salt)) {
            $salt = DAYSTAR_HASH_KEY;
        }
        return hash_hmac('sha256', $data, $salt);
    }
    
    /**
     * Verify hashed data
     */
    public static function verify_hash($data, $hash, $salt = '') {
        if (empty($salt)) {
            $salt = DAYSTAR_HASH_KEY;
        }
        return hash_equals($hash, self::hash_data($data, $salt));
    }
    
    /**
     * Clean up old audit logs
     */
    public static function cleanup_old_audit_logs() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_audit_log';
        $retention_date = date('Y-m-d H:i:s', strtotime('-' . DAYSTAR_AUDIT_LOG_RETENTION_DAYS . ' days'));
        
        $deleted = $wpdb->query($wpdb->prepare(
            "DELETE FROM $table_name WHERE timestamp < %s",
            $retention_date
        ));
        
        if ($deleted !== false) {
            Daystar_Security_Access_Control::log_action(
                'audit_log_cleanup',
                'system',
                null,
                array(
                    'deleted_records' => $deleted,
                    'retention_date' => $retention_date
                ),
                'info'
            );
        }
        
        return $deleted;
    }
    
    /**
     * Check if IP is in allowed range
     */
    public static function is_ip_allowed($ip, $allowed_ranges = array()) {
        if (empty($allowed_ranges)) {
            return true; // No restrictions
        }
        
        foreach ($allowed_ranges as $range) {
            if (self::ip_in_range($ip, $range)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if IP is in range
     */
    private static function ip_in_range($ip, $range) {
        if (strpos($range, '/') !== false) {
            // CIDR notation
            list($subnet, $mask) = explode('/', $range);
            $ip_long = ip2long($ip);
            $subnet_long = ip2long($subnet);
            $mask_long = -1 << (32 - $mask);
            
            return ($ip_long & $mask_long) === ($subnet_long & $mask_long);
        } else {
            // Single IP
            return $ip === $range;
        }
    }
    
    /**
     * Rate limiting check
     */
    public static function check_rate_limit($action, $identifier, $limit = 10, $window = 3600) {
        $transient_key = 'daystar_rate_limit_' . $action . '_' . md5($identifier);
        $attempts = get_transient($transient_key);
        
        if ($attempts === false) {
            $attempts = 0;
        }
        
        if ($attempts >= $limit) {
            return false; // Rate limit exceeded
        }
        
        // Increment attempts
        set_transient($transient_key, $attempts + 1, $window);
        
        return true; // Within rate limit
    }
}

/**
 * Enhanced login security
 */
class Daystar_Login_Security {
    
    public static function init() {
        add_filter('authenticate', array(__CLASS__, 'check_login_attempts'), 30, 3);
        add_action('wp_login_failed', array(__CLASS__, 'record_failed_login'));
        add_action('wp_login', array(__CLASS__, 'clear_failed_attempts'), 10, 2);
        add_filter('wp_authenticate_user', array(__CLASS__, 'check_password_expiry'), 10, 2);
    }
    
    /**
     * Check login attempts
     */
    public static function check_login_attempts($user, $username, $password) {
        if (is_wp_error($user)) {
            return $user;
        }
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $attempts_key = 'daystar_login_attempts_' . md5($ip . $username);
        $attempts = get_transient($attempts_key);
        
        if ($attempts && $attempts >= DAYSTAR_MAX_LOGIN_ATTEMPTS) {
            // Log lockout
            Daystar_Security_Access_Control::log_action(
                'login_lockout_active',
                'security',
                null,
                array(
                    'username' => $username,
                    'ip_address' => $ip,
                    'attempts' => $attempts
                ),
                'warning'
            );
            
            return new WP_Error('login_locked', 
                sprintf('Too many failed login attempts. Please try again in %d minutes.', 
                    DAYSTAR_LOGIN_LOCKOUT_TIME / 60)
            );
        }
        
        return $user;
    }
    
    /**
     * Record failed login attempt
     */
    public static function record_failed_login($username) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $attempts_key = 'daystar_login_attempts_' . md5($ip . $username);
        $attempts = get_transient($attempts_key);
        
        if (!$attempts) {
            $attempts = 0;
        }
        
        $attempts++;
        set_transient($attempts_key, $attempts, DAYSTAR_LOGIN_LOCKOUT_TIME);
        
        // Log failed attempt
        Daystar_Security_Access_Control::log_action(
            'login_failed_attempt',
            'security',
            null,
            array(
                'username' => $username,
                'ip_address' => $ip,
                'attempt_number' => $attempts
            ),
            'warning'
        );
    }
    
    /**
     * Clear failed attempts on successful login
     */
    public static function clear_failed_attempts($user_login, $user) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $attempts_key = 'daystar_login_attempts_' . md5($ip . $user_login);
        delete_transient($attempts_key);
    }
    
    /**
     * Check password expiry
     */
    public static function check_password_expiry($user, $password) {
        if (is_wp_error($user)) {
            return $user;
        }
        
        $last_changed = get_user_meta($user->ID, 'password_last_changed', true);
        
        if ($last_changed) {
            $expiry_date = strtotime($last_changed . ' +' . DAYSTAR_PASSWORD_EXPIRY_DAYS . ' days');
            
            if (time() > $expiry_date) {
                // Log password expiry
                Daystar_Security_Access_Control::log_action(
                    'password_expired',
                    'user',
                    $user->ID,
                    array(
                        'last_changed' => $last_changed,
                        'expiry_date' => date('Y-m-d H:i:s', $expiry_date)
                    ),
                    'warning'
                );
                
                return new WP_Error('password_expired', 
                    'Your password has expired. Please contact an administrator to reset it.'
                );
            }
        }
        
        return $user;
    }
}

// Initialize security configuration
add_action('init', array('Daystar_Security_Config', 'init'), 1);
add_action('init', array('Daystar_Login_Security', 'init'), 1);

// Schedule audit log cleanup
if (!wp_next_scheduled('daystar_cleanup_audit_logs')) {
    wp_schedule_event(time(), 'daily', 'daystar_cleanup_audit_logs');
}

add_action('daystar_cleanup_audit_logs', array('Daystar_Security_Config', 'cleanup_old_audit_logs'));

// Hook to update password last changed date
add_action('password_reset', function($user, $new_pass) {
    update_user_meta($user->ID, 'password_last_changed', current_time('mysql'));
}, 10, 2);

add_action('user_register', function($user_id) {
    update_user_meta($user_id, 'password_last_changed', current_time('mysql'));
});

// Enhanced password validation for user registration/updates
add_action('user_profile_update_errors', function($errors, $update, $user) {
    if (!empty($user->user_pass)) {
        $validation = Daystar_Security_Config::validate_password_strength($user->user_pass);
        
        if (!$validation['valid']) {
            foreach ($validation['errors'] as $error) {
                $errors->add('password_weak', $error);
            }
        }
    }
}, 10, 3);