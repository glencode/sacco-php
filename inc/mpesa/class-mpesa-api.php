<?php
/**
 * M-Pesa API Class
 *
 * @package daystar-website-fixes
 */

/**
 * Class to handle M-Pesa API integration
 */
class Daystar_MPesa_API {
    /**
     * Get base URL based on environment
     */
    public static function get_base_url() {
        $environment = get_option('daystar_mpesa_environment', 'sandbox');
        return $environment === 'production' 
            ? 'https://api.safaricom.co.ke' 
            : 'https://sandbox.safaricom.co.ke';
    }
    
    /**
     * Generate access token
     */
    public static function get_access_token() {
        $consumer_key = get_option('daystar_mpesa_consumer_key');
        $consumer_secret = get_option('daystar_mpesa_consumer_secret');
        
        if (empty($consumer_key) || empty($consumer_secret)) {
            return new WP_Error('missing_credentials', 'M-Pesa API credentials are not configured');
        }
        
        $url = self::get_base_url() . '/oauth/v1/generate?grant_type=client_credentials';
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret)
            )
        );
        
        $response = wp_remote_get($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body);
        
        if (isset($result->access_token)) {
            return $result->access_token;
        } else {
            return new WP_Error('token_error', 'Failed to get access token: ' . $body);
        }
    }
    
    /**
     * Initiate STK Push
     */
    public static function initiate_stk_push($phone, $amount, $reference, $description) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpush/v1/processrequest';
        
        // Format phone number (remove leading 0 and add country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => home_url('/mpesa-callback/'),
            'AccountReference' => $reference,
            'TransactionDesc' => $description
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    /**
     * Check transaction status
     */
    public static function check_transaction_status($checkout_request_id) {
        $access_token = self::get_access_token();
        
        if (is_wp_error($access_token)) {
            return $access_token;
        }
        
        $url = self::get_base_url() . '/mpesa/stkpushquery/v1/query';
        
        // Format timestamp
        $timestamp = date('YmdHis');
        
        // Get shortcode and passkey
        $shortcode = get_option('daystar_mpesa_shortcode');
        $passkey = get_option('daystar_mpesa_passkey');
        
        if (empty($shortcode) || empty($passkey)) {
            return new WP_Error('missing_credentials', 'M-Pesa shortcode or passkey not configured');
        }
        
        // Generate password
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        // Prepare request data
        $data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkout_request_id
        );
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        );
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}
