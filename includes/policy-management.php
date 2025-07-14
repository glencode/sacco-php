<?php
/**
 * Policy Management System
 * 
 * Handles the complete policy management process including:
 * - Policy version control and storage
 * - Automated member notifications for policy updates
 * - Policy document generation and distribution
 * - Audit trail and change tracking
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/notifications.php';

/**
 * Policy Management Handler Class
 */
class PolicyManagementHandler {
    
    /**
     * Initialize policy management hooks
     */
    public static function init() {
        add_action('wp_ajax_create_policy_version', array(__CLASS__, 'ajax_create_policy_version'));
        add_action('wp_ajax_update_policy_version', array(__CLASS__, 'ajax_update_policy_version'));
        add_action('wp_ajax_publish_policy_version', array(__CLASS__, 'ajax_publish_policy_version'));
        add_action('wp_ajax_archive_policy_version', array(__CLASS__, 'ajax_archive_policy_version'));
        add_action('wp_ajax_compare_policy_versions', array(__CLASS__, 'ajax_compare_policy_versions'));
        add_action('wp_ajax_generate_policy_pdf', array(__CLASS__, 'ajax_generate_policy_pdf'));
        add_action('wp_ajax_setup_sample_policy', array(__CLASS__, 'ajax_setup_sample_policy'));
        
        // Public AJAX for policy downloads
        add_action('wp_ajax_nopriv_download_policy_pdf', array(__CLASS__, 'ajax_download_policy_pdf'));
        add_action('wp_ajax_download_policy_pdf', array(__CLASS__, 'ajax_download_policy_pdf'));
        
        // Hook for policy publication notifications
        add_action('policy_published', array(__CLASS__, 'notify_members_of_policy_update'), 10, 2);
        
        // Create database tables on activation
        add_action('after_switch_theme', array(__CLASS__, 'create_policy_tables'));
    }
    
    /**
     * Create policy version
     */
    public static function create_policy_version($title, $content, $version_number, $effective_date = null) {
        global $wpdb;
        
        try {
            $table_name = $wpdb->prefix . 'daystar_policy_versions';
            self::create_policy_tables();
            
            // Validate inputs
            if (empty($title) || empty($content) || empty($version_number)) {
                throw new Exception('Title, content, and version number are required');
            }
            
            // Check if version number already exists
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $table_name WHERE version_number = %s",
                $version_number
            ));
            
            if ($existing) {
                throw new Exception('Version number already exists');
            }
            
            // Set effective date if not provided
            if (!$effective_date) {
                $effective_date = current_time('mysql');
            }
            
            $data = array(
                'title' => $title,
                'version_number' => $version_number,
                'content' => $content,
                'effective_date' => $effective_date,
                'status' => 'draft',
                'created_by_user_id' => get_current_user_id(),
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            );
            
            $result = $wpdb->insert($table_name, $data);
            
            if ($result === false) {
                throw new Exception('Failed to create policy version');
            }
            
            $policy_id = $wpdb->insert_id;
            
            // Log the action
            self::log_policy_action($policy_id, 'created', 'Policy version created');
            
            return array(
                'success' => true,
                'message' => 'Policy version created successfully',
                'policy_id' => $policy_id
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Update policy version
     */
    public static function update_policy_version($policy_id, $title = null, $content = null, $effective_date = null) {
        global $wpdb;
        
        try {
            $table_name = $wpdb->prefix . 'daystar_policy_versions';
            
            // Get existing policy
            $policy = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_name WHERE id = %d",
                $policy_id
            ));
            
            if (!$policy) {
                throw new Exception('Policy version not found');
            }
            
            if ($policy->status === 'published') {
                throw new Exception('Cannot edit published policy. Create a new version instead.');
            }
            
            // Prepare update data
            $update_data = array(
                'updated_by_user_id' => get_current_user_id(),
                'updated_at' => current_time('mysql')
            );
            
            if ($title !== null) {
                $update_data['title'] = $title;
            }
            
            if ($content !== null) {
                $update_data['content'] = $content;
            }
            
            if ($effective_date !== null) {
                $update_data['effective_date'] = $effective_date;
            }
            
            $result = $wpdb->update(
                $table_name,
                $update_data,
                array('id' => $policy_id),
                null,
                array('%d')
            );
            
            if ($result === false) {
                throw new Exception('Failed to update policy version');
            }
            
            // Log the action
            self::log_policy_action($policy_id, 'updated', 'Policy version updated');
            
            return array(
                'success' => true,
                'message' => 'Policy version updated successfully'
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Publish policy version
     */
    public static function publish_policy_version($policy_id) {
        global $wpdb;
        
        try {
            $table_name = $wpdb->prefix . 'daystar_policy_versions';
            
            // Get policy
            $policy = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_name WHERE id = %d",
                $policy_id
            ));
            
            if (!$policy) {
                throw new Exception('Policy version not found');
            }
            
            if ($policy->status === 'published') {
                throw new Exception('Policy version is already published');
            }
            
            // Archive current published version
            $wpdb->update(
                $table_name,
                array(
                    'status' => 'archived',
                    'updated_at' => current_time('mysql')
                ),
                array('status' => 'published'),
                array('%s', '%s'),
                array('%s')
            );
            
            // Publish new version
            $result = $wpdb->update(
                $table_name,
                array(
                    'status' => 'published',
                    'published_date' => current_time('mysql'),
                    'updated_by_user_id' => get_current_user_id(),
                    'updated_at' => current_time('mysql')
                ),
                array('id' => $policy_id),
                array('%s', '%s', '%d', '%s'),
                array('%d')
            );
            
            if ($result === false) {
                throw new Exception('Failed to publish policy version');
            }
            
            // Log the action
            self::log_policy_action($policy_id, 'published', 'Policy version published');
            
            // Trigger notification to members
            do_action('policy_published', $policy_id, $policy);
            
            return array(
                'success' => true,
                'message' => 'Policy version published successfully'
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Archive policy version
     */
    public static function archive_policy_version($policy_id) {
        global $wpdb;
        
        try {
            $table_name = $wpdb->prefix . 'daystar_policy_versions';
            
            $result = $wpdb->update(
                $table_name,
                array(
                    'status' => 'archived',
                    'updated_by_user_id' => get_current_user_id(),
                    'updated_at' => current_time('mysql')
                ),
                array('id' => $policy_id),
                array('%s', '%d', '%s'),
                array('%d')
            );
            
            if ($result === false) {
                throw new Exception('Failed to archive policy version');
            }
            
            // Log the action
            self::log_policy_action($policy_id, 'archived', 'Policy version archived');
            
            return array(
                'success' => true,
                'message' => 'Policy version archived successfully'
            );
            
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }
    }
    
    /**
     * Get policy versions
     */
    public static function get_policy_versions($status = null, $limit = null) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_policy_versions';
        
        $where_clause = '';
        $params = array();
        
        if ($status) {
            $where_clause = 'WHERE status = %s';
            $params[] = $status;
        }
        
        $limit_clause = '';
        if ($limit) {
            $limit_clause = 'LIMIT %d';
            $params[] = $limit;
        }
        
        $query = "
            SELECT pv.*, 
                   u1.display_name as created_by_name,
                   u2.display_name as updated_by_name
            FROM $table_name pv
            LEFT JOIN {$wpdb->users} u1 ON pv.created_by_user_id = u1.ID
            LEFT JOIN {$wpdb->users} u2 ON pv.updated_by_user_id = u2.ID
            $where_clause
            ORDER BY pv.created_at DESC
            $limit_clause
        ";
        
        if (!empty($params)) {
            return $wpdb->get_results($wpdb->prepare($query, $params));
        } else {
            return $wpdb->get_results($query);
        }
    }
    
    /**
     * Get current published policy
     */
    public static function get_current_policy() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_policy_versions';
        
        return $wpdb->get_row("
            SELECT * FROM $table_name 
            WHERE status = 'published' 
            ORDER BY published_date DESC 
            LIMIT 1
        ");
    }
    
    /**
     * Compare policy versions
     */
    public static function compare_policy_versions($version1_id, $version2_id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_policy_versions';
        
        $version1 = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $version1_id
        ));
        
        $version2 = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $version2_id
        ));
        
        if (!$version1 || !$version2) {
            return array(
                'success' => false,
                'message' => 'One or both policy versions not found'
            );
        }
        
        // Simple text comparison (can be enhanced with more sophisticated diff algorithms)
        $diff = self::generate_text_diff($version1->content, $version2->content);
        
        return array(
            'success' => true,
            'version1' => $version1,
            'version2' => $version2,
            'diff' => $diff
        );
    }
    
    /**
     * Generate policy PDF
     */
    public static function generate_policy_pdf($policy_id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_policy_versions';
        
        $policy = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $policy_id
        ));
        
        if (!$policy) {
            return array(
                'success' => false,
                'message' => 'Policy version not found'
            );
        }
        
        // Create uploads directory for policies
        $upload_dir = wp_upload_dir();
        $policy_dir = $upload_dir['basedir'] . '/policy-documents/';
        
        if (!file_exists($policy_dir)) {
            wp_mkdir_p($policy_dir);
        }
        
        // Generate PDF filename
        $filename = 'daystar-credit-policy-v' . $policy->version_number . '.pdf';
        $file_path = $policy_dir . $filename;
        
        // Check if PDF already exists
        if (file_exists($file_path)) {
            return array(
                'success' => true,
                'file_path' => $upload_dir['baseurl'] . '/policy-documents/' . $filename,
                'filename' => $filename
            );
        }
        
        // Generate PDF content
        $pdf_content = self::generate_pdf_content($policy);
        
        // For this implementation, we'll create a simple HTML-to-PDF conversion
        // In production, you might want to use a library like TCPDF or mPDF
        $html_content = self::convert_to_html($pdf_content);
        
        // Save as HTML file (can be converted to PDF with additional libraries)
        $html_filename = 'daystar-credit-policy-v' . $policy->version_number . '.html';
        $html_file_path = $policy_dir . $html_filename;
        
        file_put_contents($html_file_path, $html_content);
        
        return array(
            'success' => true,
            'file_path' => $upload_dir['baseurl'] . '/policy-documents/' . $html_filename,
            'filename' => $html_filename,
            'note' => 'HTML version generated. PDF conversion requires additional libraries.'
        );
    }
    
    /**
     * Notify members of policy update
     */
    public static function notify_members_of_policy_update($policy_id, $policy) {
        // Get all active members
        $members = get_users(array(
            'meta_key' => 'member_status',
            'meta_value' => 'active',
            'fields' => array('ID', 'user_email', 'display_name')
        ));
        
        foreach ($members as $member) {
            self::send_policy_update_notification($member, $policy);
        }
        
        // Create system-wide notification
        self::create_system_notification($policy);
    }
    
    /**
     * Send policy update notification to member
     */
    private static function send_policy_update_notification($member, $policy) {
        $subject = 'Important: Updated Credit Policy - Version ' . $policy->version_number;
        
        $message = '<p>Dear ' . esc_html($member->display_name) . ',</p>';
        $message .= '<p>We are writing to inform you that our Credit Policy has been updated.</p>';
        
        $message .= '<div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        $message .= '<h3 style="margin-top: 0; color: #2271b1;">Policy Update Details</h3>';
        $message .= '<ul style="list-style: none; padding: 0;">';
        $message .= '<li><strong>Policy Title:</strong> ' . esc_html($policy->title) . '</li>';
        $message .= '<li><strong>Version:</strong> ' . esc_html($policy->version_number) . '</li>';
        $message .= '<li><strong>Effective Date:</strong> ' . date('F j, Y', strtotime($policy->effective_date)) . '</li>';
        $message .= '<li><strong>Published Date:</strong> ' . date('F j, Y', strtotime($policy->published_date)) . '</li>';
        $message .= '</ul>';
        $message .= '</div>';
        
        $message .= '<div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107;">';
        $message .= '<h4 style="margin-top: 0; color: #856404;">Important Notice</h4>';
        $message .= '<p>This updated policy supersedes all previous versions and becomes effective on the date specified above. ';
        $message .= 'Please review the updated policy carefully as it may contain important changes that affect your loan applications and account management.</p>';
        $message .= '</div>';
        
        $message .= '<p>You can access the updated policy through the following options:</p>';
        $message .= '<ul>';
        $message .= '<li><strong>Online:</strong> <a href="' . home_url('/credit-policy/') . '">View Policy Online</a></li>';
        $message .= '<li><strong>Download:</strong> <a href="' . home_url('/credit-policy/?download=pdf') . '">Download PDF Copy</a></li>';
        $message .= '<li><strong>Member Portal:</strong> Access through your member dashboard</li>';
        $message .= '</ul>';
        
        $message .= '<p>If you have any questions about the updated policy or need clarification on any changes, please contact us:</p>';
        $message .= '<ul>';
        $message .= '<li>Phone: +254 123 456 789</li>';
        $message .= '<li>Email: support@daystar.co.ke</li>';
        $message .= '<li>Visit: Any Daystar SACCO branch</li>';
        $message .= '</ul>';
        
        $message .= '<p>Thank you for your continued membership with Daystar Multi-Purpose Co-op Society.</p>';
        $message .= '<p>Best regards,<br>The Daystar Team</p>';
        
        daystar_send_email($member->user_email, $subject, $message);
        
        // Also create in-app notification
        global $wpdb;
        $notifications_table = $wpdb->prefix . 'daystar_notifications';
        
        $wpdb->insert($notifications_table, array(
            'user_id' => $member->ID,
            'title' => 'Credit Policy Updated',
            'message' => 'Credit Policy has been updated to version ' . $policy->version_number . '. Please review the changes.',
            'type' => 'policy_update',
            'is_read' => 0,
            'created_at' => current_time('mysql')
        ));
    }
    
    /**
     * Create system-wide notification
     */
    private static function create_system_notification($policy) {
        // This could be used for admin notifications or system logs
        error_log("Policy updated: Version {$policy->version_number} published on " . $policy->published_date);
    }
    
    /**
     * Log policy action
     */
    private static function log_policy_action($policy_id, $action, $description) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'daystar_policy_audit_log';
        self::create_audit_log_table();
        
        $wpdb->insert($table_name, array(
            'policy_id' => $policy_id,
            'action' => $action,
            'description' => $description,
            'user_id' => get_current_user_id(),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'created_at' => current_time('mysql')
        ));
    }
    
    /**
     * Generate text diff
     */
    private static function generate_text_diff($text1, $text2) {
        // Simple line-by-line comparison
        $lines1 = explode("\n", $text1);
        $lines2 = explode("\n", $text2);
        
        $diff = array();
        $max_lines = max(count($lines1), count($lines2));
        
        for ($i = 0; $i < $max_lines; $i++) {
            $line1 = isset($lines1[$i]) ? $lines1[$i] : '';
            $line2 = isset($lines2[$i]) ? $lines2[$i] : '';
            
            if ($line1 !== $line2) {
                $diff[] = array(
                    'line' => $i + 1,
                    'old' => $line1,
                    'new' => $line2,
                    'type' => empty($line1) ? 'added' : (empty($line2) ? 'removed' : 'modified')
                );
            }
        }
        
        return $diff;
    }
    
    /**
     * Generate PDF content
     */
    private static function generate_pdf_content($policy) {
        $content = array();
        
        $content[] = "DAYSTAR MULTI-PURPOSE CO-OPERATIVE SOCIETY LTD";
        $content[] = "CREDIT POLICY";
        $content[] = "";
        $content[] = "Version: " . $policy->version_number;
        $content[] = "Effective Date: " . date('F j, Y', strtotime($policy->effective_date));
        $content[] = "Published Date: " . date('F j, Y', strtotime($policy->published_date));
        $content[] = "";
        $content[] = str_repeat("=", 80);
        $content[] = "";
        $content[] = $policy->content;
        $content[] = "";
        $content[] = str_repeat("=", 80);
        $content[] = "";
        $content[] = "This document is the official Credit Policy of Daystar Multi-Purpose Co-operative Society Ltd.";
        $content[] = "For questions or clarifications, please contact the SACCO administration.";
        $content[] = "";
        $content[] = "Generated on: " . date('F j, Y g:i A');
        
        return implode("\n", $content);
    }
    
    /**
     * Convert to HTML
     */
    private static function convert_to_html($content) {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daystar SACCO Credit Policy</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
        h1 { color: #2271b1; text-align: center; }
        h2 { color: #135e96; border-bottom: 2px solid #2271b1; padding-bottom: 5px; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 30px; font-size: 0.9em; color: #666; }
        .policy-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAYSTAR MULTI-PURPOSE CO-OPERATIVE SOCIETY LTD</h1>
        <h2>CREDIT POLICY</h2>
    </div>
    
    <div class="policy-info">
        <p><strong>Version:</strong> ' . esc_html($content) . '</p>
    </div>
    
    <div class="content">
        ' . nl2br(esc_html($content)) . '
    </div>
    
    <div class="footer">
        <p>This document is the official Credit Policy of Daystar Multi-Purpose Co-operative Society Ltd.</p>
        <p>For questions or clarifications, please contact the SACCO administration.</p>
        <p><em>Generated on: ' . date('F j, Y g:i A') . '</em></p>
    </div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * Create database tables
     */
    public static function create_policy_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Policy versions table
        $table_name = $wpdb->prefix . 'daystar_policy_versions';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            version_number varchar(20) NOT NULL,
            content longtext NOT NULL,
            published_date datetime NULL,
            effective_date datetime NOT NULL,
            status varchar(20) DEFAULT 'draft',
            created_by_user_id bigint(20) NOT NULL,
            updated_by_user_id bigint(20) NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY version_number (version_number),
            KEY status (status),
            KEY effective_date (effective_date),
            KEY created_by_user_id (created_by_user_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Create audit log table
        self::create_audit_log_table();
    }
    
    /**
     * Create audit log table
     */
    private static function create_audit_log_table() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $table_name = $wpdb->prefix . 'daystar_policy_audit_log';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            policy_id mediumint(9) NOT NULL,
            action varchar(50) NOT NULL,
            description text,
            user_id bigint(20) NOT NULL,
            ip_address varchar(45),
            user_agent text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY policy_id (policy_id),
            KEY action (action),
            KEY user_id (user_id),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * AJAX handlers
     */
    public static function ajax_create_policy_version() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $title = sanitize_text_field($_POST['title']);
        $content = wp_kses_post($_POST['content']);
        $version_number = sanitize_text_field($_POST['version_number']);
        $effective_date = sanitize_text_field($_POST['effective_date']);
        
        $result = self::create_policy_version($title, $content, $version_number, $effective_date);
        wp_send_json($result);
    }
    
    public static function ajax_update_policy_version() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $policy_id = intval($_POST['policy_id']);
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : null;
        $content = isset($_POST['content']) ? wp_kses_post($_POST['content']) : null;
        $effective_date = isset($_POST['effective_date']) ? sanitize_text_field($_POST['effective_date']) : null;
        
        $result = self::update_policy_version($policy_id, $title, $content, $effective_date);
        wp_send_json($result);
    }
    
    public static function ajax_publish_policy_version() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $policy_id = intval($_POST['policy_id']);
        $result = self::publish_policy_version($policy_id);
        wp_send_json($result);
    }
    
    public static function ajax_archive_policy_version() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $policy_id = intval($_POST['policy_id']);
        $result = self::archive_policy_version($policy_id);
        wp_send_json($result);
    }
    
    public static function ajax_compare_policy_versions() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $version1_id = intval($_POST['version1_id']);
        $version2_id = intval($_POST['version2_id']);
        
        $result = self::compare_policy_versions($version1_id, $version2_id);
        wp_send_json($result);
    }
    
    public static function ajax_generate_policy_pdf() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $policy_id = intval($_POST['policy_id']);
        $result = self::generate_policy_pdf($policy_id);
        wp_send_json($result);
    }
    
    public static function ajax_download_policy_pdf() {
        $policy_id = isset($_GET['policy_id']) ? intval($_GET['policy_id']) : null;
        
        if (!$policy_id) {
            // Get current published policy
            $current_policy = self::get_current_policy();
            if ($current_policy) {
                $policy_id = $current_policy->id;
            }
        }
        
        if (!$policy_id) {
            wp_die('No policy available for download');
        }
        
        $result = self::generate_policy_pdf($policy_id);
        
        if ($result['success']) {
            // Redirect to the file
            wp_redirect($result['file_path']);
            exit;
        } else {
            wp_die('Failed to generate policy document');
        }
    }
    
    public static function ajax_setup_sample_policy() {
        if (!wp_verify_nonce($_POST['nonce'], 'policy_management_nonce') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        try {
            // Include sample policy content
            require_once get_template_directory() . '/includes/sample-policy-content.php';
            
            // Check if a policy already exists
            $existing_policy = self::get_current_policy();
            if ($existing_policy) {
                wp_send_json(array(
                    'success' => false,
                    'message' => 'A published policy already exists. Please archive it first if you want to create a new one.'
                ));
                return;
            }
            
            // Create the sample policy
            $title = 'Daystar SACCO Credit Policy';
            $version_number = '1.0';
            $content = get_sample_policy_content();
            $effective_date = current_time('mysql');
            
            $create_result = self::create_policy_version($title, $content, $version_number, $effective_date);
            
            if (!$create_result['success']) {
                wp_send_json($create_result);
                return;
            }
            
            // Publish the policy immediately
            $publish_result = self::publish_policy_version($create_result['policy_id']);
            
            if (!$publish_result['success']) {
                wp_send_json($publish_result);
                return;
            }
            
            wp_send_json(array(
                'success' => true,
                'message' => 'Sample policy created and published successfully!',
                'policy_id' => $create_result['policy_id']
            ));
            
        } catch (Exception $e) {
            wp_send_json(array(
                'success' => false,
                'message' => 'Error setting up sample policy: ' . $e->getMessage()
            ));
        }
    }
}

// Initialize the policy management handler
PolicyManagementHandler::init();

/**
 * Helper functions
 */

/**
 * Get current policy for frontend display
 */
function get_current_credit_policy() {
    return PolicyManagementHandler::get_current_policy();
}

/**
 * Get policy versions for admin display
 */
function get_policy_versions($status = null, $limit = null) {
    return PolicyManagementHandler::get_policy_versions($status, $limit);
}

/**
 * Check if user can manage policies
 */
function can_manage_policies() {
    return current_user_can('manage_options');
}