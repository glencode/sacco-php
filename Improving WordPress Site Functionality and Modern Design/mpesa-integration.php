<?php
/**
 * M-Pesa Payment Integration for Daystar Multi-Purpose Co-op Society Ltd.
 * 
 * This file handles the integration with M-Pesa payment gateway for processing
 * contributions, loan repayments, and other financial transactions.
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * M-Pesa API Configuration
 */
class MPesaConfig {
    // API Endpoints
    const SANDBOX_BASE_URL = 'https://sandbox.safaricom.co.ke';
    const PRODUCTION_BASE_URL = 'https://api.safaricom.co.ke';
    
    // Use sandbox for development, change to production for live environment
    const USE_SANDBOX = true;
    
    // API Credentials (replace with actual credentials in production)
    const CONSUMER_KEY = 'YOUR_CONSUMER_KEY';
    const CONSUMER_SECRET = 'YOUR_CONSUMER_SECRET';
    const SHORTCODE = '174379'; // Paybill or Till number
    const PASSKEY = 'YOUR_PASSKEY';
    const CALLBACK_URL = 'https://daystar.co.ke/mpesa-callback.php';
    
    /**
     * Get base URL based on environment
     */
    public static function getBaseUrl() {
        return self::USE_SANDBOX ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
    }
}

/**
 * M-Pesa API Handler
 */
class MPesaAPI {
    /**
     * Generate access token
     */
    public static function getAccessToken() {
        $url = MPesaConfig::getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials';
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode(MPesaConfig::CONSUMER_KEY . ':' . MPesaConfig::CONSUMER_SECRET);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($curl);
        
        if ($response === false) {
            throw new Exception('Failed to get access token: ' . curl_error($curl));
        }
        
        curl_close($curl);
        
        $result = json_decode($response);
        
        if (isset($result->access_token)) {
            return $result->access_token;
        } else {
            throw new Exception('Failed to get access token: ' . $response);
        }
    }
    
    /**
     * Initiate STK Push
     */
    public static function initiateSTKPush($phone, $amount, $reference, $description) {
        try {
            $access_token = self::getAccessToken();
            
            $url = MPesaConfig::getBaseUrl() . '/mpesa/stkpush/v1/processrequest';
            
            // Format phone number (remove leading 0 and add country code)
            if (substr($phone, 0, 1) === '0') {
                $phone = '254' . substr($phone, 1);
            }
            
            // Format timestamp
            $timestamp = date('YmdHis');
            
            // Generate password
            $password = base64_encode(MPesaConfig::SHORTCODE . MPesaConfig::PASSKEY . $timestamp);
            
            // Prepare request data
            $data = [
                'BusinessShortCode' => MPesaConfig::SHORTCODE,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => MPesaConfig::SHORTCODE,
                'PhoneNumber' => $phone,
                'CallBackURL' => MPesaConfig::CALLBACK_URL,
                'AccountReference' => $reference,
                'TransactionDesc' => $description
            ];
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            if ($response === false) {
                throw new Exception('STK push request failed: ' . curl_error($curl));
            }
            
            curl_close($curl);
            
            return json_decode($response, true);
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Check transaction status
     */
    public static function checkTransactionStatus($checkoutRequestID) {
        try {
            $access_token = self::getAccessToken();
            
            $url = MPesaConfig::getBaseUrl() . '/mpesa/stkpushquery/v1/query';
            
            // Format timestamp
            $timestamp = date('YmdHis');
            
            // Generate password
            $password = base64_encode(MPesaConfig::SHORTCODE . MPesaConfig::PASSKEY . $timestamp);
            
            // Prepare request data
            $data = [
                'BusinessShortCode' => MPesaConfig::SHORTCODE,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestID
            ];
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            if ($response === false) {
                throw new Exception('Transaction status check failed: ' . curl_error($curl));
            }
            
            curl_close($curl);
            
            return json_decode($response, true);
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}

/**
 * Process M-Pesa payment request
 */
function process_mpesa_payment() {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mpesa_payment') {
        // Get form data
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
        $payment_type = isset($_POST['payment_type']) ? trim($_POST['payment_type']) : '';
        $reference = isset($_POST['reference']) ? trim($_POST['reference']) : '';
        
        // Validate form data
        $errors = [];
        
        if (empty($phone)) {
            $errors[] = 'Phone number is required';
        }
        
        if ($amount <= 0) {
            $errors[] = 'Amount must be greater than zero';
        }
        
        if (empty($payment_type)) {
            $errors[] = 'Payment type is required';
        }
        
        // If no validation errors, initiate payment
        if (empty($errors)) {
            // Generate reference if not provided
            if (empty($reference)) {
                $reference = 'DST' . date('YmdHis') . rand(100, 999);
            }
            
            // Set description based on payment type
            $description = '';
            switch ($payment_type) {
                case 'contribution':
                    $description = 'Daystar Coop Contribution';
                    break;
                case 'loan_repayment':
                    $description = 'Daystar Coop Loan Repayment';
                    break;
                case 'registration':
                    $description = 'Daystar Coop Registration Fee';
                    break;
                default:
                    $description = 'Daystar Coop Payment';
            }
            
            // Initiate STK Push
            $result = MPesaAPI::initiateSTKPush($phone, $amount, $reference, $description);
            
            // Check if request was successful
            if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {
                // Store checkout request ID in session for status checking
                $_SESSION['mpesa_checkout_request_id'] = $result['CheckoutRequestID'];
                $_SESSION['mpesa_payment_reference'] = $reference;
                
                // Redirect to payment status page
                header('Location: payment-status.php');
                exit;
            } else {
                // Payment request failed
                $error_message = isset($result['message']) ? $result['message'] : 'Payment request failed. Please try again.';
                $errors[] = $error_message;
            }
        }
        
        // If there are errors, store them in session and redirect back to payment page
        if (!empty($errors)) {
            $_SESSION['payment_errors'] = $errors;
            header('Location: make-payment.php');
            exit;
        }
    }
}

/**
 * Handle M-Pesa callback
 */
function handle_mpesa_callback() {
    // Get callback data
    $callbackData = file_get_contents('php://input');
    $callbackData = json_decode($callbackData, true);
    
    // Log callback data for debugging
    file_put_contents('mpesa_callback.log', date('Y-m-d H:i:s') . ': ' . print_r($callbackData, true) . "\n", FILE_APPEND);
    
    // Process callback data
    if (isset($callbackData['Body']['stkCallback'])) {
        $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
        $resultDesc = $callbackData['Body']['stkCallback']['ResultDesc'];
        $merchantRequestID = $callbackData['Body']['stkCallback']['MerchantRequestID'];
        $checkoutRequestID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
        
        // Check if transaction was successful
        if ($resultCode === 0) {
            // Transaction successful
            $callbackMetadata = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];
            
            // Extract transaction details
            $amount = null;
            $mpesaReceiptNumber = null;
            $transactionDate = null;
            $phoneNumber = null;
            
            foreach ($callbackMetadata as $item) {
                switch ($item['Name']) {
                    case 'Amount':
                        $amount = $item['Value'];
                        break;
                    case 'MpesaReceiptNumber':
                        $mpesaReceiptNumber = $item['Value'];
                        break;
                    case 'TransactionDate':
                        $transactionDate = $item['Value'];
                        break;
                    case 'PhoneNumber':
                        $phoneNumber = $item['Value'];
                        break;
                }
            }
            
            // In a real application, you would store transaction details in a database
            // and update the payment status for the relevant transaction
            
            // For demonstration purposes, we'll just log the successful transaction
            file_put_contents('successful_transactions.log', date('Y-m-d H:i:s') . ': ' . 
                "Receipt: $mpesaReceiptNumber, Amount: $amount, Phone: $phoneNumber\n", FILE_APPEND);
        } else {
            // Transaction failed
            file_put_contents('failed_transactions.log', date('Y-m-d H:i:s') . ': ' . 
                "Code: $resultCode, Desc: $resultDesc, CheckoutRequestID: $checkoutRequestID\n", FILE_APPEND);
        }
    }
    
    // Return response to M-Pesa
    header('Content-Type: application/json');
    echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Success']);
}

/**
 * Check payment status
 */
function check_payment_status() {
    if (isset($_SESSION['mpesa_checkout_request_id'])) {
        $checkoutRequestID = $_SESSION['mpesa_checkout_request_id'];
        
        // Check transaction status
        $result = MPesaAPI::checkTransactionStatus($checkoutRequestID);
        
        // Return status
        return $result;
    }
    
    return null;
}

// Process requests
if (isset($_GET['callback']) && $_GET['callback'] === 'mpesa') {
    handle_mpesa_callback();
    exit;
} else {
    process_mpesa_payment();
}
