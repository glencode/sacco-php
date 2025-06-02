<?php
/**
 * M-Pesa Integration Loader
 * 
 * @package daystar-website-fixes
 */

// Load M-Pesa integration components
require_once get_template_directory() . '/inc/mpesa/class-mpesa-api.php';
require_once get_template_directory() . '/inc/mpesa/mpesa-settings.php';
require_once get_template_directory() . '/inc/mpesa/mpesa-post-type.php';
require_once get_template_directory() . '/inc/mpesa/mpesa-payment-form.php';
require_once get_template_directory() . '/inc/mpesa/mpesa-callback.php';
