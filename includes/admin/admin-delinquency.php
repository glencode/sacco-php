<?php
/**
 * Admin Delinquency Management Interface
 * Provides comprehensive delinquency dashboard and blacklist management
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/includes/loan-delinquency.php';

/**
 * Add delinquency management menu
 */
function daystar_add_delinquency_admin_menu() {
    add_submenu_page(
        'daystar-admin',
        'Loan Delinquency',
        'Delinquency',
        'manage_options',
        'daystar-delinquency',
        'daystar_delinquency_admin_page'
    );
    
    add_submenu_page(
        'daystar-admin',
        'Blacklist Management',
        'Blacklist',
        'manage_options',
        'daystar-blacklist',
        'daystar_blacklist_admin_page'
    );
}
add_action('admin_menu', 'daystar_add_delinquency_admin_menu');

/**
 * Main delinquency admin page
 */
function daystar_delinquency_admin_page() {
    // Handle manual delinquency check
    if (isset($_POST['run_delinquency_check']) && wp_verify_nonce($_POST['delinquency_nonce'], 'run_delinquency_check')) {
        $results = daystar_calculate_loan_delinquency();
        echo '<div class="notice notice-success"><p>Delinquency check completed. Updated ' . $results['updated_loans'] . ' loans, sent ' . $results['notifications_sent'] . ' notifications, blacklisted ' . $results['blacklisted_members'] . ' members.</p></div>';
    }
    
    // Get current tab
    $current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'overview';
    
    // Get delinquency statistics
    $stats = daystar_get_delinquency_statistics();
    
    ?>
    <div class="wrap">
        <h1>Loan Delinquency Management</h1>
        
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-delinquency&tab=overview" class="nav-tab <?php echo $current_tab === 'overview' ? 'nav-tab-active' : ''; ?>">Overview</a>
            <a href="?page=daystar-delinquency&tab=0-30-days" class="nav-tab <?php echo $current_tab === '0-30-days' ? 'nav-tab-active' : ''; ?>">0-30 Days</a>
            <a href="?page=daystar-delinquency&tab=31-60-days" class="nav-tab <?php echo $current_tab === '31-60-days' ? 'nav-tab-active' : ''; ?>">31-60 Days</a>
            <a href="?page=daystar-delinquency&tab=61-90-days" class="nav-tab <?php echo $current_tab === '61-90-days' ? 'nav-tab-active' : ''; ?>">61-90 Days</a>
            <a href="?page=daystar-delinquency&tab=90-plus-days" class="nav-tab <?php echo $current_tab === '90-plus-days' ? 'nav-tab-active' : ''; ?>">90+ Days</a>
            <a href="?page=daystar-delinquency&tab=reports" class="nav-tab <?php echo $current_tab === 'reports' ? 'nav-tab-active' : ''; ?>">Reports</a>
        </nav>
        
        <div class="tab-content">
            <?php
            switch ($current_tab) {
                case 'overview':
                    daystar_render_delinquency_overview($stats);
                    break;
                case '0-30-days':
                    daystar_render_delinquency_category(DAYSTAR_DELINQUENCY_0_30, '0-30 Days Overdue');
                    break;
                case '31-60-days':
                    daystar_render_delinquency_category(DAYSTAR_DELINQUENCY_31_60, '31-60 Days Overdue');
                    break;
                case '61-90-days':
                    daystar_render_delinquency_category(DAYSTAR_DELINQUENCY_61_90, '61-90 Days Overdue');
                    break;
                case '90-plus-days':
                    daystar_render_delinquency_category(DAYSTAR_DELINQUENCY_90_PLUS, '90+ Days Overdue');
                    break;
                case 'reports':
                    daystar_render_delinquency_reports();
                    break;
            }
            ?>
        </div>
    </div>
    
    <style>
    .delinquency-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 2em;
        font-weight: bold;
        color: #0073aa;
    }
    
    .stat-label {
        color: #666;
        margin-top: 5px;
    }
    
    .delinquency-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .delinquency-table th,
    .delinquency-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .delinquency-table th {
        background-color: #f1f1f1;
        font-weight: bold;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-0-30 { background-color: #fff3cd; color: #856404; }
    .status-31-60 { background-color: #f8d7da; color: #721c24; }
    .status-61-90 { background-color: #f5c6cb; color: #721c24; }
    .status-90-plus { background-color: #d1ecf1; color: #0c5460; }
    .status-blacklisted { background-color: #d4edda; color: #155724; }
    
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    
    .btn-small {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 3px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    
    .btn-view { background-color: #0073aa; color: white; }
    .btn-contact { background-color: #00a32a; color: white; }
    .btn-blacklist { background-color: #d63638; color: white; }
    </style>
    <?php
}

/**
 * Render delinquency overview
 */
function daystar_render_delinquency_overview($stats) {
    ?>
    <div class="delinquency-overview">
        <div style="display: flex; justify-content: between; align-items: center; margin: 20px 0;">
            <h2>Delinquency Overview</h2>
            <form method="post" style="display: inline;">
                <?php wp_nonce_field('run_delinquency_check', 'delinquency_nonce'); ?>
                <input type="submit" name="run_delinquency_check" class="button button-primary" value="Run Delinquency Check">
            </form>
        </div>
        
        <div class="delinquency-stats">
            <?php
            $categories = array(
                DAYSTAR_DELINQUENCY_CURRENT => 'Current',
                DAYSTAR_DELINQUENCY_0_30 => '0-30 Days',
                DAYSTAR_DELINQUENCY_31_60 => '31-60 Days',
                DAYSTAR_DELINQUENCY_61_90 => '61-90 Days',
                DAYSTAR_DELINQUENCY_90_PLUS => '90+ Days',
                DAYSTAR_DELINQUENCY_BLACKLISTED => 'Blacklisted'
            );
            
            foreach ($categories as $status => $label) {
                $stat = isset($stats[$status]) ? $stats[$status] : array('loan_count' => 0, 'total_balance' => 0);
                ?>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stat['loan_count']; ?></div>
                    <div class="stat-label"><?php echo $label; ?> Loans</div>
                    <div style="margin-top: 10px; font-size: 14px; color: #666;">
                        KSh <?php echo number_format($stat['total_balance'], 2); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        
        <h3>Recent Delinquent Loans</h3>
        <?php
        $recent_delinquent = daystar_get_delinquent_loans_by_category(null, 10);
        daystar_render_delinquency_table($recent_delinquent);
        ?>
    </div>
    <?php
}

/**
 * Render delinquency category page
 */
function daystar_render_delinquency_category($category, $title) {
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $loans = daystar_get_delinquent_loans_by_category($category, $per_page, $offset);
    
    ?>
    <div class="delinquency-category">
        <h2><?php echo esc_html($title); ?></h2>
        
        <?php if (empty($loans)) : ?>
            <p>No loans found in this category.</p>
        <?php else : ?>
            <?php daystar_render_delinquency_table($loans); ?>
            
            <?php
            // Simple pagination
            $total_loans = count(daystar_get_delinquent_loans_by_category($category));
            $total_pages = ceil($total_loans / $per_page);
            
            if ($total_pages > 1) {
                echo '<div class="pagination" style="margin-top: 20px;">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $class = ($i === $page) ? 'button button-primary' : 'button';
                    $url = add_query_arg('paged', $i);
                    echo '<a href="' . esc_url($url) . '" class="' . $class . '" style="margin-right: 5px;">' . $i . '</a>';
                }
                echo '</div>';
            }
            ?>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Render delinquency table
 */
function daystar_render_delinquency_table($loans) {
    if (empty($loans)) {
        echo '<p>No delinquent loans found.</p>';
        return;
    }
    
    ?>
    <table class="delinquency-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Loan ID</th>
                <th>Loan Type</th>
                <th>Amount</th>
                <th>Balance</th>
                <th>Days Overdue</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loans as $loan) : ?>
                <tr>
                    <td>
                        <strong><?php echo esc_html($loan->display_name); ?></strong><br>
                        <small>
                            Member: <?php echo esc_html($loan->member_number); ?><br>
                            <?php if ($loan->phone_number) : ?>
                                Phone: <?php echo esc_html($loan->phone_number); ?>
                            <?php endif; ?>
                        </small>
                    </td>
                    <td><?php echo esc_html($loan->id); ?></td>
                    <td><?php echo esc_html($loan->loan_type); ?></td>
                    <td>KSh <?php echo number_format($loan->amount, 2); ?></td>
                    <td>KSh <?php echo number_format($loan->balance, 2); ?></td>
                    <td><?php echo esc_html($loan->days_overdue); ?> days</td>
                    <td>
                        <span class="status-badge status-<?php echo str_replace(array('_', '+'), array('-', '-plus'), $loan->delinquency_status); ?>">
                            <?php echo esc_html(str_replace('_', ' ', $loan->delinquency_status)); ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?php echo admin_url('admin.php?page=daystar-loans&action=view&loan_id=' . $loan->id); ?>" class="btn-small btn-view">View</a>
                            <a href="mailto:<?php echo esc_attr($loan->user_email); ?>" class="btn-small btn-contact">Email</a>
                            <?php if ($loan->delinquency_status !== DAYSTAR_DELINQUENCY_BLACKLISTED && !daystar_is_member_blacklisted($loan->user_id)) : ?>
                                <button onclick="blacklistMember(<?php echo $loan->user_id; ?>, <?php echo $loan->id; ?>)" class="btn-small btn-blacklist">Blacklist</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <script>
    function blacklistMember(userId, loanId) {
        if (confirm('Are you sure you want to blacklist this member?')) {
            const reason = prompt('Please enter the reason for blacklisting:');
            if (reason) {
                // Send AJAX request to blacklist member
                jQuery.post(ajaxurl, {
                    action: 'daystar_blacklist_member',
                    user_id: userId,
                    loan_id: loanId,
                    reason: reason,
                    nonce: '<?php echo wp_create_nonce('daystar_blacklist_member'); ?>'
                }, function(response) {
                    if (response.success) {
                        alert('Member has been blacklisted successfully.');
                        location.reload();
                    } else {
                        alert('Error: ' + response.data);
                    }
                });
            }
        }
    }
    </script>
    <?php
}

/**
 * Render delinquency reports
 */
function daystar_render_delinquency_reports() {
    $stats = daystar_get_delinquency_statistics();
    
    ?>
    <div class="delinquency-reports">
        <h2>Delinquency Reports</h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
            <div>
                <h3>Delinquency Summary</h3>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Loan Count</th>
                            <th>Total Balance</th>
                            <th>Avg Days Overdue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = array(
                            DAYSTAR_DELINQUENCY_0_30 => '0-30 Days',
                            DAYSTAR_DELINQUENCY_31_60 => '31-60 Days',
                            DAYSTAR_DELINQUENCY_61_90 => '61-90 Days',
                            DAYSTAR_DELINQUENCY_90_PLUS => '90+ Days',
                            DAYSTAR_DELINQUENCY_BLACKLISTED => 'Blacklisted'
                        );
                        
                        foreach ($categories as $status => $label) {
                            $stat = isset($stats[$status]) ? $stats[$status] : array('loan_count' => 0, 'total_balance' => 0, 'avg_days_overdue' => 0);
                            ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td><?php echo $stat['loan_count']; ?></td>
                                <td>KSh <?php echo number_format($stat['total_balance'], 2); ?></td>
                                <td><?php echo round($stat['avg_days_overdue'], 1); ?> days</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div>
                <h3>Export Options</h3>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=daystar-delinquency&action=export&type=csv'); ?>" class="button">Export to CSV</a>
                    <a href="<?php echo admin_url('admin.php?page=daystar-delinquency&action=export&type=pdf'); ?>" class="button">Export to PDF</a>
                </p>
                
                <h3>Scheduled Tasks</h3>
                <p>
                    <strong>Next Delinquency Check:</strong> 
                    <?php 
                    $next_check = wp_next_scheduled('daystar_daily_delinquency_check');
                    echo $next_check ? date('Y-m-d H:i:s', $next_check) : 'Not scheduled';
                    ?>
                </p>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Blacklist management page
 */
function daystar_blacklist_admin_page() {
    // Handle unblacklist action
    if (isset($_POST['unblacklist_member']) && wp_verify_nonce($_POST['blacklist_nonce'], 'unblacklist_member')) {
        $user_id = intval($_POST['user_id']);
        $reason = sanitize_text_field($_POST['reason']);
        $current_user_id = get_current_user_id();
        
        if (daystar_unblacklist_member($user_id, $reason, $current_user_id)) {
            echo '<div class="notice notice-success"><p>Member has been removed from blacklist successfully.</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Failed to remove member from blacklist.</p></div>';
        }
    }
    
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $blacklisted_members = daystar_get_blacklisted_members($per_page, $offset);
    
    ?>
    <div class="wrap">
        <h1>Blacklist Management</h1>
        
        <?php if (empty($blacklisted_members)) : ?>
            <p>No blacklisted members found.</p>
        <?php else : ?>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Reason</th>
                        <th>Blacklisted Date</th>
                        <th>Blacklisted By</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blacklisted_members as $member) : ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html($member->display_name); ?></strong><br>
                                <small>
                                    Member: <?php echo esc_html($member->member_number); ?><br>
                                    Email: <?php echo esc_html($member->user_email); ?>
                                </small>
                            </td>
                            <td><?php echo esc_html($member->reason); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($member->blacklist_date)); ?></td>
                            <td>
                                <?php 
                                echo $member->automatic_blacklist ? 'Automatic' : esc_html($member->blacklisted_by_name);
                                ?>
                            </td>
                            <td>
                                <span class="status-badge <?php echo $member->automatic_blacklist ? 'status-auto' : 'status-manual'; ?>">
                                    <?php echo $member->automatic_blacklist ? 'Automatic' : 'Manual'; ?>
                                </span>
                            </td>
                            <td>
                                <button onclick="showUnblacklistForm(<?php echo $member->user_id; ?>, '<?php echo esc_js($member->display_name); ?>')" class="button">Remove from Blacklist</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- Unblacklist Modal -->
    <div id="unblacklist-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 5px; min-width: 400px;">
            <h3>Remove Member from Blacklist</h3>
            <form method="post">
                <?php wp_nonce_field('unblacklist_member', 'blacklist_nonce'); ?>
                <input type="hidden" id="unblacklist-user-id" name="user_id" value="">
                <p>
                    <label for="unblacklist-reason">Reason for removing from blacklist:</label><br>
                    <textarea id="unblacklist-reason" name="reason" rows="3" style="width: 100%;" required></textarea>
                </p>
                <p>
                    <input type="submit" name="unblacklist_member" class="button button-primary" value="Remove from Blacklist">
                    <button type="button" onclick="hideUnblacklistForm()" class="button">Cancel</button>
                </p>
            </form>
        </div>
    </div>
    
    <script>
    function showUnblacklistForm(userId, memberName) {
        document.getElementById('unblacklist-user-id').value = userId;
        document.getElementById('unblacklist-modal').style.display = 'block';
    }
    
    function hideUnblacklistForm() {
        document.getElementById('unblacklist-modal').style.display = 'none';
    }
    </script>
    
    <style>
    .status-auto { background-color: #f0f0f1; color: #3c434a; }
    .status-manual { background-color: #dbeafe; color: #1e40af; }
    </style>
    <?php
}

/**
 * AJAX handler for blacklisting members
 */
function daystar_ajax_blacklist_member() {
    if (!wp_verify_nonce($_POST['nonce'], 'daystar_blacklist_member')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions');
        return;
    }
    
    $user_id = intval($_POST['user_id']);
    $loan_id = intval($_POST['loan_id']);
    $reason = sanitize_text_field($_POST['reason']);
    $current_user_id = get_current_user_id();
    
    if (daystar_blacklist_member($user_id, $loan_id, $reason, $current_user_id)) {
        wp_send_json_success('Member blacklisted successfully');
    } else {
        wp_send_json_error('Failed to blacklist member');
    }
}
add_action('wp_ajax_daystar_blacklist_member', 'daystar_ajax_blacklist_member');

/**
 * Handle export requests
 */
function daystar_handle_delinquency_export() {
    if (isset($_GET['page']) && $_GET['page'] === 'daystar-delinquency' && isset($_GET['action']) && $_GET['action'] === 'export') {
        $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'csv';
        
        if ($type === 'csv') {
            daystar_export_delinquency_csv();
        } elseif ($type === 'pdf') {
            daystar_export_delinquency_pdf();
        }
    }
}
add_action('admin_init', 'daystar_handle_delinquency_export');

/**
 * Export delinquency data to CSV
 */
function daystar_export_delinquency_csv() {
    $loans = daystar_get_delinquent_loans_by_category();
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="delinquent_loans_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // CSV headers
    fputcsv($output, array(
        'Loan ID',
        'Member Name',
        'Member Number',
        'Email',
        'Phone',
        'Loan Type',
        'Amount',
        'Balance',
        'Days Overdue',
        'Delinquency Status',
        'Last Check'
    ));
    
    // CSV data
    foreach ($loans as $loan) {
        fputcsv($output, array(
            $loan->id,
            $loan->display_name,
            $loan->member_number,
            $loan->user_email,
            $loan->phone_number,
            $loan->loan_type,
            $loan->amount,
            $loan->balance,
            $loan->days_overdue,
            $loan->delinquency_status,
            $loan->last_delinquency_check
        ));
    }
    
    fclose($output);
    exit;
}

/**
 * Export delinquency data to PDF (placeholder)
 */
function daystar_export_delinquency_pdf() {
    // This would require a PDF library like TCPDF or FPDF
    // For now, redirect back with a message
    wp_redirect(admin_url('admin.php?page=daystar-delinquency&message=pdf_export_not_implemented'));
    exit;
}