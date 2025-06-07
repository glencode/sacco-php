<?php
/**
 * Daystar Admin Dashboard Functions
 *
 * Handles the main admin dashboard and overall administrative functionality
 */

// Don't allow direct access
if (!defined("ABSPATH")) {
    exit;
}

/**
 * Add main admin menu
 */
function daystar_add_main_admin_menu() {
    add_menu_page(
        "Daystar Co-op",
        "Daystar Co-op",
        "manage_options", // Capability required
        "daystar-admin-dashboard",
        "daystar_render_admin_dashboard_page",
        "dashicons-groups", // Icon
        20 // Position
    );
    
    // Add submenus (these will be defined in their respective files)
    add_submenu_page(
        "daystar-admin-dashboard",
        "Dashboard",
        "Dashboard",
        "manage_options",
        "daystar-admin-dashboard",
        "daystar_render_admin_dashboard_page"
    );
    
    // Member Management (placeholder, actual page in admin-members.php)
    add_submenu_page(
        "daystar-admin-dashboard",
        "Members",
        "Members",
        "manage_options",
        "daystar-admin-members",
        "daystar_render_admin_members_page"
    );
    
    // Loan Management
    add_submenu_page(
        "daystar-admin-dashboard",
        "Loans",
        "Loans",
        "manage_options",
        "daystar-admin-loans",
        "daystar_render_admin_loans_page"
    );
    
    // Payment Management (placeholder, actual page in admin-payments.php)
    add_submenu_page(
        "daystar-admin-dashboard",
        "Payments",
        "Payments",
        "manage_options",
        "daystar-admin-payments",
        "daystar_render_admin_payments_page"
    );
    
    // Reports (placeholder, actual page in admin-reports.php)
    add_submenu_page(
        "daystar-admin-dashboard",
        "Reports",
        "Reports",
        "manage_options",
        "daystar-admin-reports",
        "daystar_render_admin_reports_page"
    );
    
    // Settings (placeholder, actual page in admin-settings.php)
    add_submenu_page(
        "daystar-admin-dashboard",
        "Settings",
        "Settings",
        "manage_options",
        "daystar-admin-settings",
        "daystar_render_admin_settings_page"
    );
}
add_action("admin_menu", "daystar_add_main_admin_menu");

/**
 * Render the main admin dashboard page
 */
function daystar_render_admin_dashboard_page() {
    // Check user capabilities
    if (!current_user_can("manage_options")) {
        return;
    }
    
    // Get dashboard data
    $total_members = daystar_admin_get_total_members();
    $pending_members = daystar_admin_get_pending_members();
    $active_loans = daystar_admin_get_active_loans_count();
    $pending_loans = daystar_admin_get_pending_loans_count();
    $total_contributions = daystar_admin_get_total_contributions();
    $total_loan_balance = daystar_admin_get_total_loan_balance();
    
    ?>
    <div class="wrap daystar-admin-dashboard">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
                <div id="postbox-container-1" class="postbox-container">
                    <div class="meta-box-sortables">
                        <!-- Summary Widget -->
                        <div class="postbox">
                            <h2 class="hndle"><span>Co-op Summary</span></h2>
                            <div class="inside">
                                <ul class="summary-list">
                                    <li>
                                        <span class="dashicons dashicons-admin-users"></span>
                                        <strong>Total Members:</strong> <?php echo esc_html($total_members); ?>
                                        (<a href="<?php echo admin_url("admin.php?page=daystar-admin-members&status=pending"); ?>"><?php echo esc_html($pending_members); ?> pending</a>)
                                    </li>
                                    <li>
                                        <span class="dashicons dashicons-money-alt"></span>
                                        <strong>Active Loans:</strong> <?php echo esc_html($active_loans); ?>
                                        (<a href="<?php echo admin_url("admin.php?page=daystar-admin-loans&status=pending"); ?>"><?php echo esc_html($pending_loans); ?> pending applications</a>)
                                    </li>
                                    <li>
                                        <span class="dashicons dashicons-chart-area"></span>
                                        <strong>Total Contributions:</strong> KES <?php echo number_format($total_contributions, 2); ?>
                                    </li>
                                    <li>
                                        <span class="dashicons dashicons-chart-line"></span>
                                        <strong>Total Outstanding Loan Balance:</strong> KES <?php echo number_format($total_loan_balance, 2); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Quick Actions Widget -->
                        <div class="postbox">
                            <h2 class="hndle"><span>Quick Actions</span></h2>
                            <div class="inside">
                                <ul class="quick-actions">
                                    <li><a href="<?php echo admin_url("admin.php?page=daystar-admin-members&status=pending"); ?>" class="button">Review Pending Members</a></li>
                                    <li><a href="<?php echo admin_url("admin.php?page=daystar-admin-loans&status=pending"); ?>" class="button">Review Pending Loans</a></li>
                                    <li><a href="<?php echo admin_url("admin.php?page=daystar-admin-payments&status=pending"); ?>" class="button">Review Pending Payments</a></li>
                                    <li><a href="<?php echo admin_url("admin.php?page=daystar-admin-reports"); ?>" class="button">View Reports</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="postbox-container-2" class="postbox-container">
                    <div class="meta-box-sortables">
                        <!-- Recent Activity Widget -->
                        <div class="postbox">
                            <h2 class="hndle"><span>Recent Activity</span></h2>
                            <div class="inside">
                                <?php daystar_admin_display_recent_activity(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .daystar-admin-dashboard .postbox .hndle {
            cursor: default;
        }
        .daystar-admin-dashboard .summary-list li, 
        .daystar-admin-dashboard .quick-actions li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .daystar-admin-dashboard .summary-list .dashicons {
            margin-right: 8px;
            color: #777;
        }
        .daystar-admin-dashboard .quick-actions li a {
            margin-right: 10px;
        }
        .daystar-admin-dashboard .recent-activity-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .daystar-admin-dashboard .recent-activity-list li:last-child {
            border-bottom: none;
        }
        .daystar-admin-dashboard .activity-time {
            color: #999;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
    <?php
}

// Helper functions to get dashboard data (replace with actual data retrieval)
function daystar_admin_get_total_members() {
    // In a real implementation, query the database for total users with 'member' role
    $users = get_users(array("role__in" => array("member")));
    return count($users);
}

function daystar_admin_get_pending_members() {
    // In a real implementation, query the database for users with 'member' role and 'pending' status
    $users = get_users(array(
        "role__in" => array("member"),
        "meta_key" => "member_status",
        "meta_value" => "pending"
    ));
    return count($users);
}

function daystar_admin_get_active_loans_count() {
    // In a real implementation, query the custom loan table for active loans
    return 55; // Placeholder
}

function daystar_admin_get_pending_loans_count() {
    // In a real implementation, query the custom loan application table for pending applications
    return 5; // Placeholder
}

function daystar_admin_get_total_contributions() {
    // In a real implementation, query the contributions table and sum amounts
    return 1250000; // Placeholder
}

function daystar_admin_get_total_loan_balance() {
    // In a real implementation, query the loan table and sum outstanding balances
    return 850000; // Placeholder
}

/**
 * Display recent activity feed
 */
function daystar_admin_display_recent_activity() {
    // In a real implementation, query logs or specific tables for recent events
    $activities = array(
        array("time" => "2 hours ago", "description" => "Member John Doe (DST00123) applied for a Development Loan."),
        array("time" => "5 hours ago", "description" => "Payment of KES 500 received from Jane Smith (DST00456) for contribution."),
        array("time" => "1 day ago", "description" => "Admin approved membership for Robert Johnson (DST00789)."),
        array("time" => "2 days ago", "description" => "Loan LA20250529004 disbursed to Member Alice Brown (DST00555)."),
        array("time" => "3 days ago", "description" => "New member registration pending for Michael Green."),
    );
    
    echo 
    '<ul class="recent-activity-list">';
    if (!empty($activities)) {
        foreach ($activities as $activity) {
            echo 
            '<li>' . esc_html($activity["description"]) . '<span class="activity-time">' . esc_html($activity["time"]) . '</span></li>';
        }
    } else {
        echo 
        '<li>No recent activity.</li>';
    }
    echo 
    '</ul>';
}

// Include other admin files (ensure paths are correct)
require_once(get_template_directory() . 
'/includes/admin/admin-members.php');
// require_once(get_template_directory() .
// '/includes/admin/admin-loans.php');
// require_once(get_template_directory() .
// '/includes/admin/admin-payments.php');
// require_once(get_template_directory() .
// '/includes/admin/admin-reports.php');
// require_once(get_template_directory() .
// '/includes/admin/admin-settings.php');

?>
