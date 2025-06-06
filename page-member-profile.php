<?php
/**
 * Template Name: Member Profile
 *
 * This is the template for the member profile page.
 *
 * @package Daystar
 */

// Ensure only logged-in members can access this page
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login?redirect_to=' . urlencode(home_url('/member-dashboard'))));
    exit;
}

$current_user = wp_get_current_user();

// Check if user is a member
if (!in_array('member', $current_user->roles)) {
    wp_redirect(home_url('/'));
    exit;
}

// Get member data
$user_id = $current_user->ID;
$member_number = get_user_meta($user_id, 'member_number', true);
$member_status = get_user_meta($user_id, 'member_status', true);
$registration_date = get_user_meta($user_id, 'registration_date', true);

get_header();
?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 dashboard-sidebar">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Daystar Logo" class="sidebar-logo">
                        <button class="sidebar-toggle d-lg-none">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <nav class="sidebar-nav">
                        <ul>
                            <li><a href="<?php echo home_url('/member-dashboard?page=dashboard'); ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="active"><a href="<?php echo home_url('/member-dashboard?page=profile'); ?>"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a href="<?php echo home_url('/member-dashboard?page=loans'); ?>"><i class="fas fa-money-bill-wave"></i> Loans</a></li>
                            <li><a href="<?php echo home_url('/member-dashboard?page=savings'); ?>"><i class="fas fa-piggy-bank"></i> Savings</a></li>
                            <li><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10 dashboard-main">
                <div class="content">
                    <div class="content-header">
                        <h1>Member Profile</h1>
                    </div>

                    <div class="content-body">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                // Display profile update form using the function from member-profile.php
                                daystar_display_member_profile_form($user_id);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
