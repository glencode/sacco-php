<?php
   echo "Current working directory: " . getcwd() . "\n";
   echo "Script directory: " . __DIR__ . "\n";
define('WP_USE_THEMES', false); // We don't need to load the theme
   require_once(__DIR__ . '/wp-load.php'); // Load WordPress environment

// Silence wp_redirect() as it will cause 'headers already sent' errors here
// We are not testing the redirect itself, but the actions before it.
if (!function_exists('wp_redirect')) {
    function wp_redirect($location, $status = 302) {
        // Log or echo that redirect would occur
        error_log("wp_redirect called with location: " . $location);
        echo "wp_redirect would go to: " . $location . "\n";
        return $location; // Return for testability, though original exits
    }
}

// Ensure the registration function is available
// Usually included via functions.php, but let's be sure.
require_once(get_template_directory() . '/includes/member-registration.php');

// Prepare $_POST data
$unique_suffix = time() . rand(100, 999); // For unique username/email
$_POST_DATA = array(
    'first_name' => 'TestFName',
    'last_name' => 'TestLName',
    'id_number' => '123456789',
    'date_of_birth' => '1991-02-03',
    'gender' => 'female',
    'marital_status' => 'married',
    'email' => 'testuser' . $unique_suffix . '@example.com',
    'phone' => '+254712345679',
    'alt_phone' => '+254700000001',
    'physical_address' => '456 Test Avenue',
    'city' => 'Testburg',
    'postal_code' => '00200',
    'employment_status' => 'self-employed',
    'employer' => 'Own Business', // Should be handled by job_title for self-employed
    'job_title' => 'Consultant',
    'monthly_income' => 75000.00,
    'employment_duration' => 5.0,
    'kra_pin' => 'A009876543Y',
    'username' => 'testuser' . $unique_suffix,
    'password' => 'Password123$',
    'confirm_password' => 'Password123$',
    'initial_contribution' => 3000.00,
    'monthly_contribution' => 1500.00,
    'terms_agreement' => 'on', // HTML checkbox value
    'action' => 'daystar_register_member' // Crucial for admin-post.php routing
    // Nonce will be added below
);

// WordPress needs to be fully loaded to generate a nonce correctly.
// Create the nonce. Note: In a real admin-post.php context, the nonce is generated
// on the page that displays the form and then submitted. Here we generate it just before
// simulating the POST. This might not be a perfect replication of the nonce lifecycle
// but is the best we can do in this script.
$_POST_DATA['registration_nonce'] = wp_create_nonce('daystar_registration_nonce');

// Assign to global $_POST
$_POST = $_POST_DATA;

echo "Simulating registration for user: " . $_POST['username'] . " with email " . $_POST['email'] . "\n";
echo "Nonce created: " . $_POST['registration_nonce'] . "\n";

// Call the registration processing function
// This function contains wp_redirect and exit, which will stop script execution
// and potentially output 'headers already sent' warnings if not handled.
// The wp_redirect override above attempts to mitigate this for testing.

// Capture output to check for unexpected errors before redirection attempts
ob_start();
daystar_process_registration();
$output = ob_get_clean();

if (!empty($output) && strpos($output, "wp_redirect would go to:") === false) {
    echo "Output during registration processing (before expected redirect):\n";
    echo $output . "\n";
}

// Verify user creation and meta data
$created_user = get_user_by('email', $_POST_DATA['email']);

if ($created_user) {
    echo "User CREATED successfully. User ID: " . $created_user->ID . "\n";

    $member_status = get_user_meta($created_user->ID, 'member_status', true);
    $member_number = get_user_meta($created_user->ID, 'member_number', true);
    $phone_meta = get_user_meta($created_user->ID, 'phone', true);

    echo "Member Status: " . $member_status . " (Expected: pending)\n";
    echo "Member Number: " . $member_number . " (Expected: non-empty, e.g., DSTXXXXX)\n";
    echo "Phone from meta: " . $phone_meta . " (Expected: " . $_POST_DATA['phone'] . ")\n";

    if ($member_status === 'pending') {
        echo "SUCCESS: Member status is 'pending'.\n";
    } else {
        echo "FAILURE: Member status is NOT 'pending'. Found: " . $member_status . "\n";
    }

    if (!empty($member_number)) {
        echo "SUCCESS: Member number is set: " . $member_number . ".\n";
    } else {
        echo "FAILURE: Member number is EMPTY.\n";
    }

    // Clean up: Delete the created user
    // wp_delete_user($created_user->ID);
    // echo "Test user " . $_POST_DATA['username'] . " deleted.\n";
    // For now, let's not delete, to allow manual inspection if needed. Will delete in a separate step or if tests pass.


} else {
    echo "FAILURE: User was NOT created.\n";
    echo "Review any error messages above. Check if daystar_process_registration sent a redirect due to validation errors before user creation.\n";
}

?>
