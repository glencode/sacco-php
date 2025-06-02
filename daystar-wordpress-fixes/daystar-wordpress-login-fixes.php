<?php
/**
 * WordPress Login and Registration Functionality for Daystar Co-op
 * 
 * This file contains WordPress-specific login and registration functionality
 * to address authentication issues on the Daystar Co-op website.
 */

/**
 * Customize the WordPress login page
 */
function daystar_custom_login_page() {
    // Custom login page styles
    $custom_login_css = "
        body.login {
            background: linear-gradient(135deg, rgba(0, 128, 128, 0.8) 0%, rgba(0, 68, 124, 0.8) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        #login h1 a {
            background-image: url('" . get_template_directory_uri() . "/assets/images/daystar-coop-logo.png');
            background-size: contain;
            width: 320px;
            height: 80px;
            margin-bottom: 30px;
        }
        
        .login form {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 26px 24px 34px;
        }
        
        .login label {
            color: #333;
            font-size: 14px;
        }
        
        .wp-core-ui .button-primary {
            background-color: #00447c;
            border-color: #00447c;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
            border-radius: 4px;
        }
        
        .wp-core-ui .button-primary:hover,
        .wp-core-ui .button-primary:focus {
            background-color: #003366;
            border-color: #003366;
        }
        
        .login #backtoblog a, 
        .login #nav a {
            color: #ffffff;
        }
        
        .login #backtoblog a:hover, 
        .login #nav a:hover {
            color: #f0f0f0;
        }
    ";
    
    // Add the custom login styles
    echo '<style type="text/css">' . $custom_login_css . '</style>';
}
add_action('login_head', 'daystar_custom_login_page');

/**
 * Change the login logo URL to point to the site's homepage
 */
function daystar_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'daystar_login_logo_url');

/**
 * Change the login logo title
 */
function daystar_login_logo_title() {
    return 'Daystar Multi-Purpose Co-op Society Ltd.';
}
add_filter('login_headertext', 'daystar_login_logo_title');

/**
 * Redirect users after login based on role
 */
function daystar_login_redirect($redirect_to, $request, $user) {
    // If user is an admin, redirect to admin dashboard
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        } else {
            // For regular members, redirect to member dashboard
            return home_url('/member-dashboard/');
        }
    }
    
    // Default redirect
    return $redirect_to;
}
add_filter('login_redirect', 'daystar_login_redirect', 10, 3);

/**
 * Add custom fields to registration form
 */
function daystar_custom_registration_fields() {
    // Only add these fields on the registration page
    if ('wp-login.php' == $GLOBALS['pagenow'] && isset($_REQUEST['action']) && $_REQUEST['action'] == 'register') {
        ?>
        <style type="text/css">
            #registerform p {
                margin-bottom: 15px;
            }
            
            #registerform .form-field {
                margin-bottom: 15px;
            }
            
            #registerform label {
                display: block;
                margin-bottom: 5px;
            }
            
            #registerform input[type="text"],
            #registerform input[type="tel"],
            #registerform input[type="number"] {
                width: 100%;
                padding: 5px;
                font-size: 14px;
            }
            
            #registerform .description {
                font-size: 12px;
                color: #666;
                margin-top: 3px;
            }
            
            #registerform .required {
                color: red;
            }
        </style>
        
        <p class="form-field">
            <label for="first_name">First Name <span class="required">*</span></label>
            <input type="text" name="first_name" id="first_name" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="last_name">Last Name <span class="required">*</span></label>
            <input type="text" name="last_name" id="last_name" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="phone">Phone Number <span class="required">*</span></label>
            <input type="tel" name="phone" id="phone" class="input" required />
            <span class="description">Enter your phone number registered with M-Pesa</span>
        </p>
        
        <p class="form-field">
            <label for="id_number">ID Number <span class="required">*</span></label>
            <input type="text" name="id_number" id="id_number" class="input" required />
        </p>
        
        <p class="form-field">
            <label for="initial_contribution">Initial Contribution (KSh) <span class="required">*</span></label>
            <input type="number" name="initial_contribution" id="initial_contribution" class="input" min="12000" value="12000" required />
            <span class="description">Minimum contribution is KSh 12,000</span>
        </p>
        
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Add validation to the registration form
                var registerForm = document.getElementById('registerform');
                if (registerForm) {
                    registerForm.addEventListener('submit', function(e) {
                        var firstName = document.getElementById('first_name').value;
                        var lastName = document.getElementById('last_name').value;
                        var phone = document.getElementById('phone').value;
                        var idNumber = document.getElementById('id_number').value;
                        var initialContribution = document.getElementById('initial_contribution').value;
                        
                        var errors = [];
                        
                        if (!firstName) {
                            errors.push('First name is required');
                        }
                        
                        if (!lastName) {
                            errors.push('Last name is required');
                        }
                        
                        if (!phone) {
                            errors.push('Phone number is required');
                        }
                        
                        if (!idNumber) {
                            errors.push('ID number is required');
                        }
                        
                        if (!initialContribution || initialContribution < 12000) {
                            errors.push('Initial contribution must be at least KSh 12,000');
                        }
                        
                        if (errors.length > 0) {
                            e.preventDefault();
                            alert(errors.join('\\n'));
                        }
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('login_form_register', 'daystar_custom_registration_fields');

/**
 * Save custom registration fields
 */
function daystar_save_custom_registration_fields($user_id) {
    if (isset($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }
    
    if (isset($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
    
    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    
    if (isset($_POST['id_number'])) {
        update_user_meta($user_id, 'id_number', sanitize_text_field($_POST['id_number']));
    }
    
    if (isset($_POST['initial_contribution'])) {
        update_user_meta($user_id, 'initial_contribution', sanitize_text_field($_POST['initial_contribution']));
    }
    
    // Generate a unique member number
    $member_number = 'DST' . date('Y') . rand(1000, 9999);
    update_user_meta($user_id, 'member_number', $member_number);
    
    // Set user role to "member"
    $user = new WP_User($user_id);
    $user->set_role('member'); // Make sure this role exists or use 'subscriber'
}
add_action('user_register', 'daystar_save_custom_registration_fields');

/**
 * Create custom member role if it doesn't exist
 */
function daystar_create_member_role() {
    // Check if the role already exists
    if (!get_role('member')) {
        // Create the member role with same capabilities as subscriber
        add_role(
            'member',
            __('Member'),
            get_role('subscriber')->capabilities
        );
    }
}
add_action('init', 'daystar_create_member_role');

/**
 * Add shortcode to display member dashboard
 */
function daystar_member_dashboard_shortcode() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        return '<div class="alert alert-warning">Please <a href="' . wp_login_url() . '">login</a> to view your dashboard.</div>';
    }
    
    // Get current user
    $current_user = wp_get_current_user();
    $member_number = get_user_meta($current_user->ID, 'member_number', true);
    $first_name = get_user_meta($current_user->ID, 'first_name', true);
    $last_name = get_user_meta($current_user->ID, 'last_name', true);
    $phone = get_user_meta($current_user->ID, 'phone', true);
    $initial_contribution = get_user_meta($current_user->ID, 'initial_contribution', true);
    
    // Build dashboard HTML
    $output = '<div class="member-dashboard">';
    
    // Welcome section
    $output .= '<div class="dashboard-welcome">';
    $output .= '<h2>Welcome, ' . esc_html($first_name) . '!</h2>';
    $output .= '<p>Member Number: <strong>' . esc_html($member_number) . '</strong></p>';
    $output .= '</div>';
    
    // Dashboard tabs
    $output .= '<div class="dashboard-tabs">';
    $output .= '<ul class="nav nav-tabs" id="memberDashboardTabs" role="tablist">';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="savings-tab" data-bs-toggle="tab" data-bs-target="#savings" type="button" role="tab" aria-controls="savings" aria-selected="false">Savings</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab" aria-controls="loans" aria-selected="false">Loans</button></li>';
    $output .= '<li class="nav-item" role="presentation"><button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button></li>';
    $output .= '</ul>';
    
    // Tab content
    $output .= '<div class="tab-content" id="memberDashboardTabContent">';
    
    // Overview tab
    $output .= '<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">';
    $output .= '<div class="dashboard-cards">';
    $output .= '<div class="row">';
    
    // Savings card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Total Savings</h5>';
    $output .= '<h3 class="card-value">KSh ' . number_format($initial_contribution, 2) . '</h3>';
    $output .= '<a href="#savings" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#savings">View Details</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Loans card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Active Loans</h5>';
    $output .= '<h3 class="card-value">0</h3>';
    $output .= '<a href="#loans" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#loans">View Details</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Eligibility card
    $output .= '<div class="col-md-4">';
    $output .= '<div class="card">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Loan Eligibility</h5>';
    $output .= '<h3 class="card-value">KSh ' . number_format($initial_contribution * 3, 2) . '</h3>';
    $output .= '<a href="#loans" class="btn btn-sm btn-primary" data-bs-toggle="tab" data-bs-target="#loans">Apply for Loan</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End row
    $output .= '</div>'; // End dashboard-cards
    
    // Recent transactions
    $output .= '<div class="recent-transactions mt-4">';
    $output .= '<h4>Recent Transactions</h4>';
    $output .= '<div class="table-responsive">';
    $output .= '<table class="table table-striped">';
    $output .= '<thead><tr><th>Date</th><th>Description</th><th>Amount</th><th>Status</th></tr></thead>';
    $output .= '<tbody>';
    $output .= '<tr><td>' . date('Y-m-d') . '</td><td>Initial Contribution</td><td>KSh ' . number_format($initial_contribution, 2) . '</td><td><span class="badge bg-success">Completed</span></td></tr>';
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End overview tab
    
    // Savings tab
    $output .= '<div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="savings-tab">';
    $output .= '<h4>Savings Summary</h4>';
    $output .= '<div class="table-responsive">';
    $output .= '<table class="table table-striped">';
    $output .= '<thead><tr><th>Type</th><th>Amount</th><th>Last Contribution</th></tr></thead>';
    $output .= '<tbody>';
    $output .= '<tr><td>Regular Savings</td><td>KSh ' . number_format($initial_contribution, 2) . '</td><td>' . date('Y-m-d') . '</td></tr>';
    $output .= '<tr><td>Share Capital</td><td>KSh 5,000.00</td><td>' . date('Y-m-d') . '</td></tr>';
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>';
    
    // Make contribution button
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/payment/') . '" class="btn btn-primary">Make Contribution</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End savings tab
    
    // Loans tab
    $output .= '<div class="tab-pane fade" id="loans" role="tabpanel" aria-labelledby="loans-tab">';
    $output .= '<h4>Loan Products</h4>';
    $output .= '<div class="row">';
    
    // Development Loan
    $output .= '<div class="col-md-6 mb-4">';
    $output .= '<div class="card h-100">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Development Loan</h5>';
    $output .= '<ul class="list-unstyled">';
    $output .= '<li>Up to KSh 2,000,000</li>';
    $output .= '<li>36 months repayment period</li>';
    $output .= '<li>12% interest per annum</li>';
    $output .= '<li>Maximum of 3 times member\'s deposits</li>';
    $output .= '</ul>';
    $output .= '<a href="' . home_url('/loan-application/?type=development') . '" class="btn btn-primary">Apply Now</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Emergency Loan
    $output .= '<div class="col-md-6 mb-4">';
    $output .= '<div class="card h-100">';
    $output .= '<div class="card-body">';
    $output .= '<h5 class="card-title">Emergency Loan</h5>';
    $output .= '<ul class="list-unstyled">';
    $output .= '<li>Up to KSh 100,000</li>';
    $output .= '<li>12 months repayment period</li>';
    $output .= '<li>12% interest per annum</li>';
    $output .= '<li>Maximum of 1.5 times member\'s deposits</li>';
    $output .= '</ul>';
    $output .= '<a href="' . home_url('/loan-application/?type=emergency') . '" class="btn btn-primary">Apply Now</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output .= '</div>'; // End row
    
    // View all loan products link
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/products-services/') . '" class="btn btn-outline-primary">View All Loan Products</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End loans tab
    
    // Profile tab
    $output .= '<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">';
    $output .= '<h4>Personal Information</h4>';
    $output .= '<div class="row">';
    $output .= '<div class="col-md-6">';
    $output .= '<p><strong>Name:</strong> ' . esc_html($first_name . ' ' . $last_name) . '</p>';
    $output .= '<p><strong>Member Number:</strong> ' . esc_html($member_number) . '</p>';
    $output .= '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>';
    $output .= '</div>';
    $output .= '<div class="col-md-6">';
    $output .= '<p><strong>Email:</strong> ' . esc_html($current_user->user_email) . '</p>';
    $output .= '<p><strong>ID Number:</strong> ' . esc_html(get_user_meta($current_user->ID, 'id_number', true)) . '</p>';
    $output .= '<p><strong>Membership Date:</strong> ' . date('Y-m-d', strtotime($current_user->user_registered)) . '</p>';
    $output .= '</div>';
    $output .= '</div>'; // End row
    
    // Update profile button
    $output .= '<div class="mt-3">';
    $output .= '<a href="' . home_url('/edit-profile/') . '" class="btn btn-primary">Update Profile</a>';
    $output .= '</div>';
    
    $output .= '</div>'; // End profile tab
    
    $output .= '</div>'; // End tab content
    $output .= '</div>'; // End dashboard-tabs
    
    $output .= '</div>'; // End member-dashboard
    
    return $output;
}
add_shortcode('member_dashboard', 'daystar_member_dashboard_shortcode');

/**
 * Add shortcode to display login form
 */
function daystar_login_form_shortcode() {
    if (is_user_logged_in()) {
        return '<div class="alert alert-info">You are already logged in. <a href="' . home_url('/member-dashboard/') . '">Go to Dashboard</a> or <a href="' . wp_logout_url(home_url()) . '">Logout</a></div>';
    }
    
    $args = array(
        'echo'           => false,
        'remember'       => true,
        'redirect'       => home_url('/member-dashboard/'),
        'form_id'        => 'loginform',
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'label_username' => __('Username or Email Address'),
        'label_password' => __('Password'),
        'label_remember' => __('Remember Me'),
        'label_log_in'   => __('Log In'),
        'value_username' => '',
        'value_remember' => false
    );
    
    $login_form = wp_login_form($args);
    
    // Add custom styling and registration link
    $output = '<div class="custom-login-form">';
    $output .= '<h2>Member Login</h2>';
    $output .= '<p>Access your account to view your savings, loans, and more</p>';
    $output .= $login_form;
    $output .= '<div class="login-links">';
    $output .= '<p><a href="' . wp_lostpassword_url() . '">Forgot your password?</a></p>';
    $output .= '<p>Don\'t have an account? <a href="' . wp_registration_url() . '">Register Now</a></p>';
    $output .= '</div>';
    $output .= '</div>';
    
    // Add custom styling
    $output .= '<style>
        .custom-login-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .custom-login-form h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #00447c;
        }
        
        .custom-login-form p {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        
        .custom-login-form form {
            margin-bottom: 20px;
        }
        
        .custom-login-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .custom-login-form input[type="text"],
        .custom-login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .custom-login-form .button-primary {
            background-color: #00447c;
            border-color: #00447c;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        
        .custom-login-form .button-primary:hover {
            background-color: #003366;
        }
        
        .login-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-links a {
            color: #00447c;
            text-decoration: none;
        }
        
        .login-links a:hover {
            text-decoration: underline;
        }
    </style>';
    
    return $output;
}
add_shortcode('login_form', 'daystar_login_form_shortcode');

/**
 * Add shortcode to display registration form
 */
function daystar_registration_form_shortcode() {
    if (is_user_logged_in()) {
        return '<div class="alert alert-info">You are already registered and logged in. <a href="' . home_url('/member-dashboard/') . '">Go to Dashboard</a></div>';
    }
    
    if (!get_option('users_can_register')) {
        return '<div class="alert alert-warning">Registration is currently disabled. Please contact the administrator.</div>';
    }
    
    // Check if form was submitted
    if (isset($_POST['daystar_register_nonce']) && wp_verify_nonce($_POST['daystar_register_nonce'], 'daystar_register_user')) {
        $user_login = sanitize_user($_POST['user_login']);
        $user_email = sanitize_email($_POST['user_email']);
        $user_pass = $_POST['user_pass'];
        $pass_confirm = $_POST['pass_confirm'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $phone = sanitize_text_field($_POST['phone']);
        $id_number = sanitize_text_field($_POST['id_number']);
        $initial_contribution = intval($_POST['initial_contribution']);
        
        $errors = array();
        
        // Validate fields
        if (empty($user_login)) {
            $errors[] = 'Username is required';
        }
        
        if (empty($user_email)) {
            $errors[] = 'Email is required';
        } elseif (!is_email($user_email)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($user_pass)) {
            $errors[] = 'Password is required';
        }
        
        if ($user_pass !== $pass_confirm) {
            $errors[] = 'Passwords do not match';
        }
        
        if (empty($first_name)) {
            $errors[] = 'First name is required';
        }
        
        if (empty($last_name)) {
            $errors[] = 'Last name is required';
        }
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if (empty($id_number)) {
            $errors[] = 'ID number is required';
        }
        
        if ($initial_contribution < 12000) {
            $errors[] = 'Initial contribution must be at least KSh 12,000';
        }
        
        // Check if username exists
        if (username_exists($user_login)) {
            $errors[] = 'Username already exists';
        }
        
        // Check if email exists
        if (email_exists($user_email)) {
            $errors[] = 'Email already exists';
        }
        
        // If no errors, register user
        if (empty($errors)) {
            $user_id = wp_create_user($user_login, $user_pass, $user_email);
            
            if (!is_wp_error($user_id)) {
                // Update user meta
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                update_user_meta($user_id, 'phone', $phone);
                update_user_meta($user_id, 'id_number', $id_number);
                update_user_meta($user_id, 'initial_contribution', $initial_contribution);
                
                // Generate a unique member number
                $member_number = 'DST' . date('Y') . rand(1000, 9999);
                update_user_meta($user_id, 'member_number', $member_number);
                
                // Set user role to "member"
                $user = new WP_User($user_id);
                $user->set_role('member'); // Make sure this role exists or use 'subscriber'
                
                // Log the user in
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
                
                // Redirect to payment page
                wp_redirect(home_url('/payment/?type=registration&amount=' . $initial_contribution));
                exit;
            } else {
                $errors[] = $user_id->get_error_message();
            }
        }
    }
    
    // Display registration form
    $output = '<div class="custom-registration-form">';
    
    // Display errors if any
    if (!empty($errors)) {
        $output .= '<div class="alert alert-danger"><ul>';
        foreach ($errors as $error) {
            $output .= '<li>' . esc_html($error) . '</li>';
        }
        $output .= '</ul></div>';
    }
    
    $output .= '<h2>Become a Member</h2>';
    $output .= '<p>Join our cooperative society and enjoy exclusive benefits</p>';
    
    $output .= '<form id="daystar_registration_form" method="post" action="">';
    $output .= wp_nonce_field('daystar_register_user', 'daystar_register_nonce', true, false);
    
    // Account Information
    $output .= '<h4>Account Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_login">Username <span class="required">*</span></label>';
    $output .= '<input type="text" name="user_login" id="user_login" class="form-control" value="' . (isset($_POST['user_login']) ? esc_attr($_POST['user_login']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_email">Email <span class="required">*</span></label>';
    $output .= '<input type="email" name="user_email" id="user_email" class="form-control" value="' . (isset($_POST['user_email']) ? esc_attr($_POST['user_email']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="user_pass">Password <span class="required">*</span></label>';
    $output .= '<input type="password" name="user_pass" id="user_pass" class="form-control" required />';
    $output .= '<small class="form-text text-muted">Password must be at least 8 characters long</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="pass_confirm">Confirm Password <span class="required">*</span></label>';
    $output .= '<input type="password" name="pass_confirm" id="pass_confirm" class="form-control" required />';
    $output .= '</div>';
    
    // Personal Information
    $output .= '<h4 class="mt-4">Personal Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="first_name">First Name <span class="required">*</span></label>';
    $output .= '<input type="text" name="first_name" id="first_name" class="form-control" value="' . (isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="last_name">Last Name <span class="required">*</span></label>';
    $output .= '<input type="text" name="last_name" id="last_name" class="form-control" value="' . (isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : '') . '" required />';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="phone">Phone Number <span class="required">*</span></label>';
    $output .= '<input type="tel" name="phone" id="phone" class="form-control" value="' . (isset($_POST['phone']) ? esc_attr($_POST['phone']) : '') . '" required />';
    $output .= '<small class="form-text text-muted">Enter your phone number registered with M-Pesa</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="id_number">ID Number <span class="required">*</span></label>';
    $output .= '<input type="text" name="id_number" id="id_number" class="form-control" value="' . (isset($_POST['id_number']) ? esc_attr($_POST['id_number']) : '') . '" required />';
    $output .= '</div>';
    
    // Contribution Information
    $output .= '<h4 class="mt-4">Contribution Information</h4>';
    
    $output .= '<div class="form-group">';
    $output .= '<label for="initial_contribution">Initial Contribution (KSh) <span class="required">*</span></label>';
    $output .= '<input type="number" name="initial_contribution" id="initial_contribution" class="form-control" min="12000" value="' . (isset($_POST['initial_contribution']) ? esc_attr($_POST['initial_contribution']) : '12000') . '" required />';
    $output .= '<small class="form-text text-muted">Minimum contribution is KSh 12,000</small>';
    $output .= '</div>';
    
    $output .= '<div class="form-group form-check mt-4">';
    $output .= '<input type="checkbox" name="terms_agreement" id="terms_agreement" class="form-check-input" required />';
    $output .= '<label class="form-check-label" for="terms_agreement">I agree to the <a href="' . home_url('/terms-conditions/') . '" target="_blank">Terms and Conditions</a> and <a href="' . home_url('/privacy-policy/') . '" target="_blank">Privacy Policy</a></label>';
    $output .= '</div>';
    
    $output .= '<div class="form-group mt-4">';
    $output .= '<button type="submit" class="btn btn-primary btn-block">Register</button>';
    $output .= '</div>';
    
    $output .= '</form>';
    
    $output .= '<div class="login-link mt-4 text-center">';
    $output .= '<p>Already have an account? <a href="' . wp_login_url() . '">Login Now</a></p>';
    $output .= '</div>';
    
    $output .= '</div>'; // End custom-registration-form
    
    // Add custom styling
    $output .= '<style>
        .custom-registration-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .custom-registration-form h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #00447c;
        }
        
        .custom-registration-form p {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        
        .custom-registration-form h4 {
            margin-top: 20px;
            margin-bottom: 15px;
            color: #00447c;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .required {
            color: red;
        }
        
        .btn-primary {
            background-color: #00447c;
            border-color: #00447c;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        
        .btn-primary:hover {
            background-color: #003366;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .form-text {
            font-size: 12px;
            color: #666;
        }
    </style>';
    
    // Add validation script
    $output .= '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("daystar_registration_form");
            
            if (form) {
                form.addEventListener("submit", function(e) {
                    var userPass = document.getElementById("user_pass").value;
                    var passConfirm = document.getElementById("pass_confirm").value;
                    var termsAgreement = document.getElementById("terms_agreement").checked;
                    var initialContribution = document.getElementById("initial_contribution").value;
                    
                    var errors = [];
                    
                    if (userPass.length < 8) {
                        errors.push("Password must be at least 8 characters long");
                    }
                    
                    if (userPass !== passConfirm) {
                        errors.push("Passwords do not match");
                    }
                    
                    if (!termsAgreement) {
                        errors.push("You must agree to the terms and conditions");
                    }
                    
                    if (initialContribution < 12000) {
                        errors.push("Initial contribution must be at least KSh 12,000");
                    }
                    
                    if (errors.length > 0) {
                        e.preventDefault();
                        alert(errors.join("\\n"));
                    }
                });
            }
        });
    </script>';
    
    return $output;
}
add_shortcode('registration_form', 'daystar_registration_form_shortcode');

/**
 * Instructions: Add this code to your theme's functions.php file or create a new plugin with this code
 */
