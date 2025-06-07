<?php
/**
 * Daystar Admin Settings Functions
 *
 * Handles admin settings for the Daystar SACCO theme
 */

// Don't allow direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add the settings page to the admin menu
 */
function daystar_add_settings_menu() {
    add_submenu_page(
        'daystar-admin-dashboard',
        'Settings',
        'Settings',
        'manage_options',
        'daystar-admin-settings',
        'daystar_render_admin_settings_page'
    );
}
add_action('admin_menu', 'daystar_add_settings_menu');

/**
 * Render the settings page
 */
function daystar_render_admin_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save settings if form was submitted
    if (isset($_POST['daystar_settings_nonce']) && wp_verify_nonce($_POST['daystar_settings_nonce'], 'daystar_save_settings')) {
        daystar_save_settings();
    }

    // Get current settings
    $settings = get_option('daystar_sacco_settings', array());
    $loan_settings = get_option('daystar_loan_settings', array());
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <?php
        if (isset($_GET['settings-updated'])) {
            add_settings_error(
                'daystar_messages',
                'daystar_message',
                __('Settings Saved', 'daystar'),
                'updated'
            );
        }
        settings_errors('daystar_messages');
        ?>

        <form action="" method="post">
            <?php wp_nonce_field('daystar_save_settings', 'daystar_settings_nonce'); ?>
            
            <div class="settings-container">
                <!-- General Settings -->
                <div class="settings-section">
                    <h2>General Settings</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="company_name">Company Name</label>
                            </th>
                            <td>
                                <input type="text" id="company_name" name="settings[company_name]" 
                                    value="<?php echo esc_attr($settings['company_name'] ?? 'Daystar Multi-Purpose Co-op Society Ltd'); ?>" 
                                    class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="contact_email">Contact Email</label>
                            </th>
                            <td>
                                <input type="email" id="contact_email" name="settings[contact_email]" 
                                    value="<?php echo esc_attr($settings['contact_email'] ?? get_option('admin_email')); ?>" 
                                    class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="contact_phone">Contact Phone</label>
                            </th>
                            <td>
                                <input type="text" id="contact_phone" name="settings[contact_phone]" 
                                    value="<?php echo esc_attr($settings['contact_phone'] ?? ''); ?>" 
                                    class="regular-text">
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Loan Settings -->
                <div class="settings-section">
                    <h2>Loan Settings</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="min_membership_period">Minimum Membership Period (months)</label>
                            </th>
                            <td>
                                <input type="number" id="min_membership_period" name="loan_settings[min_membership_period]" 
                                    value="<?php echo esc_attr($loan_settings['min_membership_period'] ?? '6'); ?>" 
                                    min="1" class="small-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="min_contribution">Minimum Monthly Contribution</label>
                            </th>
                            <td>
                                <input type="number" id="min_contribution" name="loan_settings[min_contribution]" 
                                    value="<?php echo esc_attr($loan_settings['min_contribution'] ?? '2000'); ?>" 
                                    min="0" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="loan_interest_rate">Default Loan Interest Rate (%)</label>
                            </th>
                            <td>
                                <input type="number" id="loan_interest_rate" name="loan_settings[loan_interest_rate]" 
                                    value="<?php echo esc_attr($loan_settings['loan_interest_rate'] ?? '12'); ?>" 
                                    min="0" step="0.1" class="small-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="max_loan_multiplier">Maximum Loan Multiplier</label>
                            </th>
                            <td>
                                <input type="number" id="max_loan_multiplier" name="loan_settings[max_loan_multiplier]" 
                                    value="<?php echo esc_attr($loan_settings['max_loan_multiplier'] ?? '3'); ?>" 
                                    min="1" step="0.5" class="small-text">
                                <p class="description">Maximum loan amount as a multiple of total contributions</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Notification Settings -->
                <div class="settings-section">
                    <h2>Notification Settings</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">Email Notifications</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="settings[notify_new_member]" 
                                        <?php checked(isset($settings['notify_new_member']) ? $settings['notify_new_member'] : true); ?>>
                                    New member registrations
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="settings[notify_loan_application]" 
                                        <?php checked(isset($settings['notify_loan_application']) ? $settings['notify_loan_application'] : true); ?>>
                                    New loan applications
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" name="settings[notify_loan_approval]" 
                                        <?php checked(isset($settings['notify_loan_approval']) ? $settings['notify_loan_approval'] : true); ?>>
                                    Loan approvals/rejections
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>

    <style>
        .settings-container {
            max-width: 1200px;
        }
        .settings-section {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccd0d4;
        }
        .settings-section h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
    <?php
}

/**
 * Save settings
 */
function daystar_save_settings() {
    // Save general settings
    if (isset($_POST['settings'])) {
        $settings = array_map('sanitize_text_field', $_POST['settings']);
        update_option('daystar_sacco_settings', $settings);
    }

    // Save loan settings
    if (isset($_POST['loan_settings'])) {
        $loan_settings = array_map('sanitize_text_field', $_POST['loan_settings']);
        update_option('daystar_loan_settings', $loan_settings);
    }

    wp_redirect(add_query_arg('settings-updated', 'true'));
    exit;
}

/**
 * Register settings
 */
function daystar_register_settings() {
    register_setting('daystar_settings', 'daystar_sacco_settings');
    register_setting('daystar_settings', 'daystar_loan_settings');
}
add_action('admin_init', 'daystar_register_settings');
