# Database Management & Cleanup Guide

## Enhanced Database Cleanup Admin Panel

The system now includes a comprehensive database management tool accessible via **WordPress Admin → Tools → Database Cleanup**.

### Features

#### 1. Core Loan Products Status
- **Visual Status Check**: Shows which of the 6 core loan products are present/missing
- **Policy Compliance**: Compares current database against credit policy requirements
- **Product Details**: Displays amount ranges, interest rates, and terms for each product

#### 2. Automated Management Actions
- **Add Missing Products**: Automatically creates any missing core loan products
- **Reset All Products**: Completely resets all loan products to match policy standards
- **Legacy Cleanup**: Removes outdated products like Refinance Loans

#### 3. Database Statistics
- Real-time counts of loans, members, contributions, and notifications
- Visual dashboard showing system health

### The 6 Core Loan Products (Per Credit Policy)

1. **Development Loan**
   - Amount: KSh 10,000 - KSh 2,000,000
   - Term: 1-36 months
   - Rate: 12% p.a. reducing balance
   - Requirements: Payslip, guarantors, 6 months membership

2. **School Fees Loan**
   - Amount: KSh 5,000 - KSh 500,000
   - Term: 1-12 months
   - Rate: 12% p.a. reducing balance
   - Requirements: Fee structure, guarantors

3. **Emergency Loan**
   - Amount: KSh 5,000 - KSh 100,000
   - Term: 1-12 months
   - Rate: 12% p.a. reducing balance
   - Requirements: Emergency evidence, guarantors

4. **Special Loan**
   - Amount: KSh 10,000 - KSh 200,000
   - Term: 4-6 months (based on amount)
   - Rate: 5% per month reducing balance
   - Requirements: Good credit history, post-dated cheques, no payslip needed

5. **Super Saver Loan**
   - Amount: KSh 50,000 - KSh 3,000,000
   - Term: 1-48 months
   - Rate: 12% p.a. reducing balance
   - Requirements: KSh 1M+ deposits, premium member status

6. **Salary Advance**
   - Amount: KSh 1,000 - KSh 100,000
   - Term: 1-3 months
   - Rate: One-off charge (10% members, 12.5% non-members)
   - Requirements: Proof of capacity to repay

### How to Use the Database Management Tool

#### Access the Tool
1. Log in to WordPress Admin
2. Go to **Tools → Database Cleanup**
3. Review the current status

#### Common Tasks

**If Missing Products:**
- Click "Add Missing Core Products" to automatically create them

**If Database is Inconsistent:**
- Click "Reset All Products to Policy Standards" to completely rebuild

**If Legacy Products Exist:**
- Use the "Remove Refinance Loan" button to clean up outdated products

#### Status Indicators
- ✓ **Green**: Product correctly configured
- ✗ **Red**: Product missing or misconfigured
- **Yellow highlight**: Non-core products that may need review

### Technical Details

#### Product Configuration
Each loan product includes:
- Basic details (name, description, amounts, terms)
- Interest calculation method
- Eligibility rules and requirements
- Required documents
- Processing charges and fees
- Priority scoring for applications

#### Database Structure
- Products stored in `wp_daystar_loan_products` table
- JSON fields for complex configurations
- Status tracking (active/inactive)
- Audit trail with created/updated timestamps

#### Safety Features
- Permission checks (admin only)
- Confirmation dialogs for destructive actions
- Backup of existing data before reset
- Detailed logging of all changes

### Maintenance Schedule

**Weekly:**
- Review database statistics
- Check for any non-core products

**Monthly:**
- Verify all 6 core products are present
- Review any policy changes

**After Policy Updates:**
- Use "Reset All Products" to apply new standards
- Update individual products as needed

### Troubleshooting

**Problem**: Loan calculator shows wrong products
**Solution**: Use "Reset All Products" to ensure calculator gets correct data

**Problem**: Application forms missing loan types
**Solution**: Check that all 6 core products are active in database

**Problem**: Interest calculations incorrect
**Solution**: Verify product configurations match credit policy exactly

### Integration Points

The database management tool integrates with:
- **Loan Calculator**: Dynamically loads products from database
- **Application Forms**: Validates against active products
- **Eligibility System**: Uses product rules for member qualification
- **Admin Reports**: Provides data for loan management

### Security Considerations

- Only administrators can access the tool
- All actions require WordPress nonce verification
- Changes are logged for audit purposes
- No direct database manipulation exposed to users

This enhanced database management system ensures the SACCO's loan products always align with the current credit policy while providing easy maintenance and monitoring capabilities.