# 🔧 Manual Fix Instructions for SACCO Demo Issues

## Issues to Fix:
1. **Division by zero error** in sample data generator
2. **Post type name too long** (supervisory_committee)

## Fix 1: Division by Zero Error

### File: `includes/sample-data-generator.php`

**Find this code (around line 431):**
```php
$monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / 
                  (pow(1 + $monthly_interest_rate, $term_months) - 1);
```

**Replace with:**
```php
// Prevent division by zero
$denominator = pow(1 + $monthly_interest_rate, $term_months) - 1;
if ($denominator == 0 || $monthly_interest_rate == 0) {
    $monthly_payment = $amount / max(1, $term_months); // Simple division if no interest
} else {
    $monthly_payment = $amount * ($monthly_interest_rate * pow(1 + $monthly_interest_rate, $term_months)) / $denominator;
}
```

### Also add this check at the beginning of the `daystar_create_sample_loans` function:

**Find this code:**
```php
$loan_products = $wpdb->get_results("SELECT * FROM $loan_products_table WHERE status = 'active'");

$loan_statuses = array('pending', 'approved', 'active', 'completed', 'rejected', 'defaulted');
```

**Replace with:**
```php
$loan_products = $wpdb->get_results("SELECT * FROM $loan_products_table WHERE status = 'active'");

// Check if loan products exist
if (empty($loan_products)) {
    return; // No loan products available, skip loan creation
}

$loan_statuses = array('pending', 'approved', 'active', 'completed', 'rejected', 'defaulted');
```

## Fix 2: Post Type Name Too Long

### File: `functions.php`

**Find ALL instances of:**
```php
'supervisory_committee'
```

**Replace with:**
```php
'supervisory_comm'
```

**This includes:**
- `register_post_type( 'supervisory_committee', $args );`
- Meta box function names and references
- Action hooks like `add_meta_boxes_supervisory_committee`
- Any other references to the post type

## Quick Fix Option

**Alternative:** Run the quick-fix script:
1. Navigate to: `your-site.com/wp-content/themes/your-theme/quick-fix.php`
2. The script will automatically apply all fixes

## After Applying Fixes

1. Go to WordPress Admin Dashboard
2. Look for **"Demo Setup"** in the main menu
3. Click **"🎯 Setup Complete Demo System"**
4. Wait for completion and note the login credentials

## Expected Result

✅ No more PHP fatal errors  
✅ No more WordPress notices  
✅ Demo setup works smoothly  
✅ Sample data generates successfully  

## Demo Credentials (after setup)

**Admin User:**
- Username: `sacco_admin`
- Password: `admin123!`

**Sample Members:**
- All use password: `password123`
- Various roles: Chairman, Secretary, Treasurer, Members

Your SACCO demo system will be ready for client presentation!