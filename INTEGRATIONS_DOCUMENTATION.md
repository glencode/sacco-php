# Daystar SACCO Integration System Documentation

## Overview

The Daystar SACCO integration system provides comprehensive connectivity between the SACCO management system and external services including accounting systems, M-Pesa payment gateway, and SMS/Email notification providers.

## Table of Contents

1. [Accounting System API Integration](#accounting-system-api-integration)
2. [Enhanced M-Pesa Integration](#enhanced-m-pesa-integration)
3. [SMS/Email Gateway Integration](#smsemail-gateway-integration)
4. [Admin Interface](#admin-interface)
5. [Configuration](#configuration)
6. [Security](#security)
7. [Troubleshooting](#troubleshooting)

## Accounting System API Integration

### Overview

The accounting API provides RESTful endpoints for external accounting systems to access SACCO financial data in real-time or through scheduled synchronization.

### Features

- **RESTful API Endpoints**: Standardized endpoints for loans, repayments, contributions, and members
- **Authentication & Authorization**: API key-based authentication with granular permissions
- **Data Synchronization**: Real-time webhooks and batch synchronization options
- **Financial Summaries**: Aggregated financial data for reporting
- **Audit Logging**: Complete audit trail of all API access

### API Endpoints

#### Base URL
```
https://yourdomain.com/wp-json/daystar-accounting/v1/
```

#### Authentication
Include your API key in the request header:
```
Authorization: Bearer YOUR_API_KEY
```

#### Available Endpoints

##### Loans
- `GET /loans` - Retrieve loans with filtering options
- `GET /loans/{id}` - Retrieve specific loan with repayment history

**Parameters:**
- `status`: Filter by loan status (active, completed, defaulted, pending)
- `date_from`: Filter loans from date (YYYY-MM-DD)
- `date_to`: Filter loans to date (YYYY-MM-DD)
- `page`: Page number for pagination
- `per_page`: Number of items per page (max 100)

**Example Request:**
```bash
curl -X GET "https://yourdomain.com/wp-json/daystar-accounting/v1/loans?status=active&page=1&per_page=50" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json"
```

**Example Response:**
```json
{
  "loans": [
    {
      "id": 123,
      "member_id": 456,
      "member_number": "DST001234",
      "product_id": 1,
      "amount": 50000.00,
      "interest_rate": 12.00,
      "term_months": 12,
      "monthly_payment": 4441.67,
      "total_payable": 53300.00,
      "paid_amount": 13325.00,
      "balance": 36675.00,
      "status": "active",
      "application_date": "2024-01-15",
      "approval_date": "2024-01-20",
      "disbursement_date": "2024-01-22",
      "due_date": "2025-01-22",
      "purpose": "Business expansion"
    }
  ],
  "pagination": {
    "page": 1,
    "per_page": 50,
    "total_items": 150,
    "total_pages": 3
  }
}
```

##### Repayments
- `GET /repayments` - Retrieve loan repayments

**Parameters:**
- `loan_id`: Filter by loan ID
- `member_id`: Filter by member ID
- `date_from`: Filter repayments from date
- `date_to`: Filter repayments to date

##### Contributions
- `GET /contributions` - Retrieve member contributions

##### Members
- `GET /members` - Retrieve member information

##### Financial Summary
- `GET /financial-summary` - Retrieve aggregated financial data

**Parameters:**
- `period`: Summary period (daily, weekly, monthly, quarterly, yearly)
- `date_from`: Summary from date
- `date_to`: Summary to date

##### Webhooks
- `POST /webhooks` - Register webhook for real-time notifications

**Webhook Events:**
- `loan.created` - New loan application
- `loan.approved` - Loan approved
- `loan.disbursed` - Loan disbursed
- `repayment.received` - Repayment received
- `contribution.received` - Contribution received
- `member.created` - New member registered

### API Key Management

#### Generating API Keys

1. Navigate to **Integrations > Accounting API** in WordPress admin
2. Enter a descriptive name for the API key
3. Select appropriate permissions
4. Click "Generate API Key"
5. Copy and securely store the generated key

#### Permissions

- `read_loans`: Access to loan data
- `read_repayments`: Access to repayment data
- `read_contributions`: Access to contribution data
- `read_members`: Access to member data
- `read_financial_summary`: Access to financial summaries
- `manage_webhooks`: Ability to register/manage webhooks

#### Security Best Practices

- Store API keys securely
- Use HTTPS for all API requests
- Implement rate limiting on your end
- Regularly rotate API keys
- Monitor API usage logs

## Enhanced M-Pesa Integration

### Overview

The enhanced M-Pesa integration provides full bi-directional functionality for both receiving payments (STK Push) and sending disbursements (B2C), with robust error handling, transaction tracking, and reconciliation.

### Features

- **STK Push**: Customer-initiated payments for contributions and loan repayments
- **B2C Payments**: Automated loan disbursements to member phones
- **Transaction Tracking**: Real-time status updates and reconciliation
- **Error Handling**: Comprehensive error handling with retry mechanisms
- **Webhook Support**: Real-time transaction status updates
- **Reconciliation**: Automated reconciliation with M-Pesa statements

### Configuration

#### Environment Settings

1. Navigate to **Integrations > M-Pesa Settings**
2. Choose environment (Sandbox for testing, Production for live)
3. Enter your M-Pesa app credentials:
   - Consumer Key
   - Consumer Secret
   - Shortcode (Paybill/Till number)
   - Passkey

#### B2C Configuration (for disbursements)

- Initiator Name: Username for B2C transactions
- Security Credential: Encrypted credential for B2C

### Usage Examples

#### Initiating STK Push

```php
$mpesa = new DaystarEnhancedMPesa();

$result = $mpesa->initiate_stk_push(
    '254700000000',        // Phone number
    1000,                  // Amount
    'LOAN001',             // Account reference
    'Loan repayment',      // Description
    123,                   // Member ID (optional)
    'loan_repayment'       // Payment purpose (optional)
);

if ($result['success']) {
    echo "STK push sent successfully";
    echo "Checkout Request ID: " . $result['checkout_request_id'];
} else {
    echo "Error: " . $result['message'];
}
```

#### Initiating B2C Payment

```php
$result = $mpesa->initiate_b2c_payment(
    '254700000000',        // Phone number
    50000,                 // Amount
    'Loan disbursement',   // Remarks
    null,                  // Occasion (optional)
    123,                   // Member ID (optional)
    456                    // Loan ID (optional)
);

if ($result['success']) {
    echo "B2C payment initiated successfully";
    echo "Conversation ID: " . $result['conversation_id'];
} else {
    echo "Error: " . $result['message'];
}
```

#### Checking Transaction Status

```php
$status = $mpesa->query_transaction_status('ws_CO_123456789');
print_r($status);
```

### Transaction Flow

#### STK Push Flow

1. System initiates STK push request
2. M-Pesa sends push notification to customer's phone
3. Customer enters M-Pesa PIN
4. M-Pesa processes payment
5. Callback received with transaction result
6. System updates transaction status and processes payment

#### B2C Flow

1. System initiates B2C payment request
2. M-Pesa processes disbursement
3. Result callback received
4. System updates loan status and sends notification

### Database Schema

The system creates a `daystar_mpesa_transactions` table to track all M-Pesa transactions:

```sql
CREATE TABLE daystar_mpesa_transactions (
    id bigint(20) NOT NULL AUTO_INCREMENT,
    transaction_type varchar(50) NOT NULL,
    merchant_request_id varchar(100),
    checkout_request_id varchar(100),
    conversation_id varchar(100),
    transaction_id varchar(100),
    mpesa_receipt_number varchar(100),
    phone_number varchar(20),
    amount decimal(15,2) NOT NULL,
    account_reference varchar(100),
    member_id bigint(20),
    loan_id bigint(20),
    payment_purpose varchar(50),
    status varchar(20) DEFAULT 'pending',
    result_code varchar(10),
    result_desc text,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
```

### Reconciliation

The system automatically runs reconciliation every hour to:

- Check status of pending transactions
- Update transaction records
- Identify discrepancies
- Generate reconciliation reports

## SMS/Email Gateway Integration

### Overview

The notification gateway provides a unified interface for sending SMS and email notifications through multiple providers, with automatic failover and delivery tracking.

### Supported Providers

#### SMS Providers

1. **Twilio**
   - Global coverage
   - High reliability
   - Delivery receipts

2. **Africa's Talking**
   - Africa-focused
   - Competitive pricing
   - Local presence

3. **Infobip**
   - Global coverage
   - Enterprise features
   - Advanced analytics

#### Email Providers

1. **SendGrid**
   - High deliverability
   - Advanced analytics
   - Template support

2. **Mailgun**
   - Developer-friendly
   - Powerful APIs
   - Email validation

3. **Amazon SES**
   - Cost-effective
   - AWS integration
   - High volume support

### Configuration

#### Provider Setup

1. Navigate to **Integrations > Notification Settings**
2. Configure your preferred providers:

**Twilio SMS:**
- Account SID
- Auth Token
- From Number

**SendGrid Email:**
- API Key
- From Email
- From Name

3. Set default providers for SMS and email
4. Test configuration with test messages

### Usage

#### Generic Notification Function

```php
// Send SMS
daystar_send_notification(
    123,                    // Recipient user ID
    'Your payment has been received',  // Message
    'sms',                  // Channel (sms, email, both)
    null,                   // Subject (for email)
    array(                  // Options
        'type' => 'payment_confirmation',
        'priority' => 'normal'
    )
);

// Send Email
daystar_send_notification(
    123,                    // Recipient user ID
    'Your loan has been approved',     // Message
    'email',                // Channel
    'Loan Approval',        // Subject
    array(
        'type' => 'loan_approval',
        'priority' => 'high'
    )
);

// Send Both
daystar_send_notification(
    123,                    // Recipient user ID
    'Welcome to Daystar SACCO',       // Message
    'both',                 // Channel
    'Welcome',              // Subject
    array(
        'type' => 'welcome',
        'template' => 'welcome_template'
    )
);
```

### Event-Driven Notifications

The system automatically sends notifications for various events:

#### Loan Events
- Application submission confirmation
- Loan approval/decline notifications
- Disbursement confirmations
- Repayment confirmations

#### Payment Events
- Payment received confirmations
- Overdue payment reminders
- Contribution confirmations

#### Member Events
- Welcome messages for new members
- Account updates
- Policy change notifications

#### System Events
- Anomaly alerts to administrators
- System maintenance notifications

### Scheduled Notifications

#### Repayment Reminders
- Sent daily for upcoming due dates (3 days before)
- Overdue payment notifications

#### Contribution Reminders
- Weekly reminders for members who haven't contributed

### Notification Templates

The system supports HTML email templates with:
- SACCO branding
- Responsive design
- Dynamic content insertion
- Personalization

### Database Schema

Notifications are tracked in the `daystar_notifications` table:

```sql
CREATE TABLE daystar_notifications (
    id bigint(20) NOT NULL AUTO_INCREMENT,
    recipient_id bigint(20) NOT NULL,
    notification_type varchar(50) NOT NULL,
    channel varchar(20) NOT NULL,
    provider varchar(50),
    subject varchar(255),
    message text NOT NULL,
    recipient_contact varchar(100),
    status varchar(20) DEFAULT 'pending',
    provider_response text,
    provider_message_id varchar(100),
    sent_at datetime,
    delivered_at datetime,
    failed_at datetime,
    retry_count int DEFAULT 0,
    max_retries int DEFAULT 3,
    priority varchar(10) DEFAULT 'normal',
    scheduled_for datetime,
    event_type varchar(50),
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
```

## Admin Interface

### Overview

The admin interface provides a centralized dashboard for managing all integrations, monitoring performance, and configuring settings.

### Dashboard Features

#### Integration Status Cards
- Real-time status indicators
- Key performance metrics
- Quick access to configuration

#### Recent Activity Log
- Integration events
- Error notifications
- Performance metrics

### Management Pages

#### Accounting API Management
- API key generation and management
- Permission configuration
- Usage statistics
- Webhook management

#### M-Pesa Settings
- Credential configuration
- Environment switching
- Transaction monitoring
- Connection testing

#### Notification Settings
- Provider configuration
- Default settings
- Test messaging
- Delivery statistics

#### Integration Logs
- Comprehensive logging
- Filtering and search
- Error tracking
- Performance monitoring

## Configuration

### Environment Variables

For security, sensitive configuration should be stored as environment variables:

```php
// wp-config.php
define('DAYSTAR_MPESA_CONSUMER_KEY', 'your_consumer_key');
define('DAYSTAR_MPESA_CONSUMER_SECRET', 'your_consumer_secret');
define('DAYSTAR_TWILIO_AUTH_TOKEN', 'your_auth_token');
define('DAYSTAR_SENDGRID_API_KEY', 'your_api_key');
```

### WordPress Options

Configuration is stored in WordPress options:

- `daystar_mpesa_config` - M-Pesa settings
- `daystar_accounting_api_keys` - API keys
- `daystar_twilio_config` - Twilio settings
- `daystar_sendgrid_config` - SendGrid settings
- `daystar_notification_defaults` - Default providers

### Hooks and Filters

#### Actions

```php
// Triggered when events occur
do_action('daystar_loan_approved', $loan_id);
do_action('daystar_repayment_received', $repayment_id);
do_action('daystar_contribution_received', $contribution_id);
do_action('daystar_mpesa_payment_received', $transaction, $payment_data);
```

#### Filters

```php
// Customize notification messages
add_filter('daystar_notification_message', function($message, $type, $data) {
    // Customize message based on type
    return $message;
}, 10, 3);

// Customize API response data
add_filter('daystar_api_loan_data', function($loan_data) {
    // Add custom fields
    return $loan_data;
});
```

## Security

### API Security

#### Authentication
- API key-based authentication
- Secure key generation (32 characters)
- Key rotation capabilities

#### Authorization
- Granular permissions system
- Role-based access control
- Audit logging

#### Data Protection
- HTTPS enforcement
- Input validation and sanitization
- SQL injection prevention
- XSS protection

### M-Pesa Security

#### Credential Protection
- Encrypted storage of sensitive data
- Environment variable support
- Secure callback handling

#### Transaction Verification
- Signature verification for callbacks
- Duplicate transaction prevention
- Amount validation

### Notification Security

#### Provider Authentication
- Secure API key storage
- Token-based authentication
- Rate limiting

#### Content Security
- Message sanitization
- Template injection prevention
- Spam prevention

## Troubleshooting

### Common Issues

#### API Integration Issues

**Problem**: API requests returning 401 Unauthorized
**Solution**: 
- Verify API key is correct
- Check key permissions
- Ensure key is active

**Problem**: API requests timing out
**Solution**:
- Check server connectivity
- Verify endpoint URLs
- Implement retry logic

#### M-Pesa Issues

**Problem**: STK push not received on phone
**Solution**:
- Verify phone number format
- Check M-Pesa service status
- Verify shortcode configuration

**Problem**: Callback not received
**Solution**:
- Verify callback URL accessibility
- Check firewall settings
- Review M-Pesa logs

#### Notification Issues

**Problem**: SMS not delivered
**Solution**:
- Check provider balance
- Verify phone number format
- Review provider logs

**Problem**: Email going to spam
**Solution**:
- Configure SPF/DKIM records
- Use verified sender domains
- Review email content

### Debugging

#### Enable Debug Logging

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

#### Check Log Files

- WordPress debug log: `/wp-content/debug.log`
- M-Pesa logs: Custom logging in database
- Notification logs: Database table

#### Test Endpoints

Use tools like Postman or curl to test API endpoints:

```bash
# Test API endpoint
curl -X GET "https://yourdomain.com/wp-json/daystar-accounting/v1/loans" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json"

# Test M-Pesa callback
curl -X POST "https://yourdomain.com/wp-json/daystar/v1/mpesa/callback" \
     -H "Content-Type: application/json" \
     -d '{"test": "data"}'
```

### Performance Optimization

#### Database Optimization
- Regular cleanup of old logs
- Index optimization
- Query optimization

#### Caching
- API response caching
- Configuration caching
- Rate limiting

#### Monitoring
- Set up monitoring for:
  - API response times
  - Transaction success rates
  - Notification delivery rates
  - Error rates

### Support

For technical support:

1. Check this documentation
2. Review log files
3. Test individual components
4. Contact system administrator

For provider-specific issues:
- Twilio: https://support.twilio.com
- SendGrid: https://support.sendgrid.com
- M-Pesa: Contact Safaricom support

## Conclusion

The Daystar SACCO integration system provides a comprehensive solution for connecting with external services while maintaining security, reliability, and ease of use. Regular monitoring and maintenance ensure optimal performance and member satisfaction.

For updates and additional features, refer to the system changelog and release notes.