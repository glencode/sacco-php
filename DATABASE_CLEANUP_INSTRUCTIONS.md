# Database Cleanup Instructions

## How to Remove Refinance Loan from Database

The system has been updated to remove Refinance Loan references from all code, but you may need to clean up existing database entries.

### Method 1: WordPress Admin Interface (Recommended)

1. Log in to your WordPress admin area
2. Go to **Tools > Database Cleanup**
3. Click the "Remove Refinance Loan" button if the Refinance Loan product is found
4. The system will automatically remove the product and report any existing loan applications

### Method 2: Function Call (For Developers)

If you have access to run PHP code in WordPress context, you can call:

```php
daystar_cleanup_refinance_loan();
```

This function will:
- Remove the Refinance Loan product from the database
- Log the results to the error log
- Check for existing Refinance Loan applications
- Return true/false based on success

### Method 3: Direct Database Query (Advanced Users)

If you have direct database access, you can run:

```sql
DELETE FROM wp_daystar_loan_products WHERE name = 'Refinance Loan';
```

**Note**: Replace `wp_` with your actual WordPress table prefix.

### Verification

After cleanup, verify that:

1. **Loan Calculator**: Only shows 6 loan products (Development, School Fees, Emergency, Special, Super Saver, Salary Advance)
2. **Application Forms**: Only allow selection of the 6 valid loan types
3. **Admin Areas**: No references to Refinance Loans in filters or options

### What's Been Fixed

✅ **Code Level Changes**:
- Removed Refinance Loan from database setup
- Updated all form validations
- Removed from application pages
- Updated admin interfaces
- Corrected Special Loan information

✅ **Special Loan Corrections**:
- Amount range: KSh 10,000 - KSh 200,000
- Term: 4-6 months
- Interest: 5% per month on reducing balance
- Character-based lending (no payslip required)
- Post-dated cheques as security

### Current Valid Loan Products

1. **Development Loan** - 12% p.a., 1-36 months, KSh 10K-2M
2. **School Fees Loan** - 12% p.a., 1-12 months, KSh 5K-500K  
3. **Emergency Loan** - 12% p.a., 1-12 months, KSh 5K-100K
4. **Special Loan** - 5% p.m., 4-6 months, KSh 10K-200K
5. **Super Saver Loan** - 12% p.a., 1-48 months, KSh 50K-3M
6. **Salary Advance** - One-off charge, 1-3 months, KSh 1K-100K

The system is now fully aligned with the SACCO's actual credit policy.