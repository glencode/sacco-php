# Credit Policy Analysis for Daystar Multi-Purpose Co-op Society Ltd Website

## Overview
The credit policy document outlines the rules, procedures, and requirements for loan management within the Daystar Multi-Purpose Co-operative Society. This analysis extracts the key functional requirements that need to be implemented on the WordPress website.

## Membership Requirements
- Members must contribute consistently for at least six months with minimum contributions of KSh 12,000 (KSh 2,000 × 6 months)
- Members must own a minimum of KSh 5,000 as share capital (250 shares worth KSh 200 each)
- Members must have a definite productive activity or economic income to ensure loan repayment
- Members must possess satisfactory, measurable, and legal security for borrowing

## Loan Application Process
1. Members fill a loan application form (all fields must be completed)
2. Forms must be received by the Society Office by the 30th of every month (for Development/Refinance Loans)
3. Forms are verified by an authorized staff (loan officer)
4. Accepted applications are registered and applicants receive a waiting number
5. Loan officer determines eligibility and forwards applications to the credit committee
6. Credit committee reviews applications and recommends successful applicants to the CMC
7. CMC authorizes payment to successful applicants
8. Loanees must personally sign deduction forms prior to disbursement

## Loan Types and Terms
1. **Normal/Development Loans**
   - Maximum: KSh 2,000,000
   - Repayment period: 36 months
   - Interest rate: 12% reducing balance per year (1% per month)
   - Purpose: Major development projects (building, buying a car, starting a business)

2. **School Fees Loan**
   - Repayment period: 12 months
   - Documentary proof required (fees structure, report forms, fee notes)

3. **Instant Loan**
   - Maximum: KSh 50,000
   - Attracts 10% instant charge on loan value + 1% per month reducing balance
   - Repayment period: 6 months maximum
   - Processing time: Within 24 hours

4. **Refinance Loan**
   - For members already servicing development loans
   - Attracts 10% refinance charge + normal 12% p.a. interest
   - Maximum combined with old loans: KSh 2,000,000 (KSh 3,000,000 for Super Savers)
   - Must have paid development loan for 6 months
   - Repayment period: 36 months (48 months for Super Savers)

5. **Emergency Loan**
   - Maximum: KSh 100,000 (may vary for more needy cases)
   - Repayment period: 12 months
   - Purpose: Sudden hospitalization, funeral expenses, court fines, unforeseen circumstances
   - Documentary evidence required

6. **Special Loan**
   - No payslip consideration, based on character and history
   - Interest rate: 5% per month reducing balance
   - Maximum: KSh 200,000
   - Repayment periods:
     - Below KSh 100,000: 4 months
     - KSh 100,000 to 159,000: 5 months
     - KSh 160,000 to 200,000: 6 months
   - Requires post-dated cheques as guarantee
   - Penalties for deferred/bounced cheques

7. **Super Saver Loans**
   - For members with deposits over KSh 1,000,000
   - Maximum: KSh 3,000,000
   - Repayment period: 48 months for loans above KSh 1,000,000

8. **Salary Advance**
   - Repayment period: 3 months maximum
   - Interest: 10% one-off charge for first month, 5% compounded for additional months
   - Non-members charged 12.5% for one month

## Loan Approval Criteria
When funds are insufficient, the following parameters are used:
1. Nature of the need
2. Members who have never had loans
3. New members who have qualified for loans
4. Members who have cleared first loans and applied for fresh loans

## Loan Repayment
- Deductions commence within 1 month after loan issuance
- Members may repay loans in whole or part prior to maturity
- Repayment can be from any legal source besides individual salary
- External repayments require bank deposit or Paybill payment with submission of proof

## Loan Delinquency Management
- Monthly listing of all overdue loans categorized by days overdue
- Credit committee reviews and forwards to CMC
- Delinquent borrowers may be blacklisted

## Loan Disbursement
- Notice sent to borrower 3 days after approval
- Payment methods: cheque, EFT, RTGS, M-pesa, or other viable methods
- Members must sign disbursement documents before receiving payment

## Website Functional Requirements
Based on the credit policy, the website should include:

1. **Member Management**
   - Registration system with membership criteria verification
   - Member profile management with deposit/share tracking
   - Member status tracking (active, duration, eligibility for loans)

2. **Loan Application System**
   - Online loan application forms for all loan types
   - Document upload capability for required proofs
   - Application tracking system with status updates
   - Waiting number assignment

3. **Loan Management**
   - Loan eligibility calculator based on deposits and membership duration
   - Loan repayment calculator with schedules
   - Loan status tracking for members
   - Guarantor management system

4. **Payment Integration**
   - Integration with payment systems (M-pesa, bank transfers)
   - Payment verification and receipt generation
   - Loan disbursement tracking

5. **Administrative Functions**
   - Loan approval workflow for staff and committees
   - Delinquency tracking and management
   - Communication system for notices and updates
   - Reporting tools for loan performance

6. **Information Resources**
   - Loan types and terms documentation
   - FAQ section on loan processes
   - Appeal process documentation
   - Policy access and updates

These requirements should guide the development of the WordPress site to ensure it fully supports the credit policy implementation.
