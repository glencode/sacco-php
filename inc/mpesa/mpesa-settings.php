<?php
/**
 * M-Pesa Admin Settings
 *
 * @package daystar-website-fixes
 */

/**
 * Register M-Pesa settings page in WordPress admin
 */
function daystar_mpesa_register_settings_page() {
    add_options_page(
        'M-Pesa Settings',
        'M-Pesa Settings',
        'manage_options',
        'daystar-mpesa-settings',
        'daystar_mpesa_settings_page_callback'
    );
}
add_action('admin_menu', 'daystar_mpesa_register_settings_page');

/**
 * Register M-Pesa settings
 */
function daystar_mpesa_register_settings() {
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_key');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_consumer_secret');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_shortcode');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_passkey');
    register_setting('daystar_mpesa_settings_group', 'daystar_mpesa_environment');
}
add_action('admin_init', 'daystar_mpesa_register_settings');

/**
 * M-Pesa settings page callback
 */
function daystar_mpesa_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>M-Pesa Integration Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('daystar_mpesa_settings_group'); ?>
            <?php do_settings_sections('daystar_mpesa_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Environment</th>
                    <td>
                        <select name="daystar_mpesa_environment">
                            <option value="sandbox" <?php selected(get_option('daystar_mpesa_environment'), 'sandbox'); ?>>Sandbox (Testing)</option>
                            <option value="production" <?php selected(get_option('daystar_mpesa_environment'), 'production'); ?>>Production (Live)</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Key</th>
                    <td><input type="text" name="daystar_mpesa_consumer_key" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_key')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Secret</th>
                    <td><input type="password" name="daystar_mpesa_consumer_secret" value="<?php echo esc_attr(get_option('daystar_mpesa_consumer_secret')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Shortcode (Paybill/Till Number)</th>
                    <td><input type="text" name="daystar_mpesa_shortcode" value="<?php echo esc_attr(get_option('daystar_mpesa_shortcode')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Passkey</th>
                    <td><input type="password" name="daystar_mpesa_passkey" value="<?php echo esc_attr(get_option('daystar_mpesa_passkey')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <div class="card">
            <h2>M-Pesa Integration Instructions</h2>
            <p>To set up M-Pesa integration:</p>
            <ol>
                <li>Register for a Safaricom Developer Account at <a href="https://developer.safaricom.co.ke/" target="_blank">https://developer.safaricom.co.ke/</a></li>
                <li>Create a new app and get your Consumer Key and Consumer Secret</li>
                <li>Set up your callback URL in the Safaricom Developer Portal to: <code><?php echo home_url('/mpesa-callback/'); ?></code></li>
                <li>Enter your credentials above and save changes</li>
                <li>Use the <code>[mpesa_payment_form]</code> shortcode on any page to display the payment form</li>
            </ol>
        </div>
    </div>
    <?php
}
