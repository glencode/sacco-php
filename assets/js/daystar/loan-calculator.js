/**
 * Daystar Loan Calculator Module
 * 
 * This module provides loan calculation functionality specific to Daystar Multi-Purpose Co-op Society Ltd.
 * It implements the loan products and calculation rules as specified in the Daystar credit policy.
 */

class DaystarLoanCalculator {
    /**
     * Calculate loan details based on loan type, amount, and term
     * 
     * @param {string} loanType - Type of loan (development, school-fees, emergency, special, super-saver, salary-advance)
     * @param {number} loanAmount - Loan amount in KSh
     * @param {number} loanTerm - Loan term in months
     * @return {object} Loan calculation details
     */
    static calculateLoan(loanType, loanAmount, loanTerm) {
        // Validate inputs
        if (!this.validateInputs(loanType, loanAmount, loanTerm)) {
            return {
                error: true,
                message: "Invalid input parameters"
            };
        }
        
        // Check loan limits
        const limitCheck = this.checkLoanLimits(loanType, loanAmount, loanTerm);
        if (limitCheck.error) {
            return limitCheck;
        }
        
        // Calculate interest rate based on loan type
        const interestRate = this.getInterestRate(loanType);
        
        // Calculate monthly payment and other loan details
        let calculation = {};
        
        if (loanType === 'salary-advance') {
            // Salary Advance has a one-off 10% charge for the first month
            calculation = this.calculateSalaryAdvance(loanAmount, loanTerm);
        } else if (loanType === 'special') {
            // Special loan has 5% per month on reducing balance
            calculation = this.calculateSpecialLoan(loanAmount, loanTerm);
        } else {
            // All other loans use reducing balance method with annual interest rate
            calculation = this.calculateReducingBalanceLoan(loanAmount, loanTerm, interestRate);
        }
        
        // Add loan type information
        calculation.loanType = loanType;
        calculation.loanTypeName = this.getLoanTypeName(loanType);
        
        return calculation;
    }
    
    /**
     * Validate input parameters
     * 
     * @param {string} loanType - Type of loan
     * @param {number} loanAmount - Loan amount in KSh
     * @param {number} loanTerm - Loan term in months
     * @return {boolean} Whether inputs are valid
     */
    static validateInputs(loanType, loanAmount, loanTerm) {
        const validLoanTypes = ['development', 'school-fees', 'emergency', 'special', 'super-saver', 'salary-advance'];
        
        if (!validLoanTypes.includes(loanType)) {
            return false;
        }
        
        if (isNaN(loanAmount) || loanAmount <= 0) {
            return false;
        }
        
        if (isNaN(loanTerm) || loanTerm <= 0 || !Number.isInteger(loanTerm)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Check loan limits based on loan type
     * 
     * @param {string} loanType - Type of loan
     * @param {number} loanAmount - Loan amount in KSh
     * @param {number} loanTerm - Loan term in months
     * @return {object} Result of limit check
     */
    static checkLoanLimits(loanType, loanAmount, loanTerm) {
        const limits = {
            'development': {
                maxAmount: 2000000,
                maxTerm: 36
            },
            'school-fees': {
                maxAmount: 500000, // Assumed maximum
                maxTerm: 12
            },
            'emergency': {
                maxAmount: 100000,
                maxTerm: 12
            },
            'special': {
                maxAmount: 200000,
                maxTerm: 6,
                minTerm: 4
            },
            'super-saver': {
                maxAmount: 3000000,
                maxTerm: 48
            },
            'salary-advance': {
                maxAmount: 100000, // Assumed maximum
                maxTerm: 3
            }
        };
        
        const limit = limits[loanType];
        
        if (loanAmount > limit.maxAmount) {
            return {
                error: true,
                message: `Maximum loan amount for ${this.getLoanTypeName(loanType)} is KSh ${limit.maxAmount.toLocaleString()}`
            };
        }
        
        if (loanTerm > limit.maxTerm) {
            return {
                error: true,
                message: `Maximum term for ${this.getLoanTypeName(loanType)} is ${limit.maxTerm} months`
            };
        }
        
        if (limit.minTerm && loanTerm < limit.minTerm) {
            return {
                error: true,
                message: `Minimum term for ${this.getLoanTypeName(loanType)} is ${limit.minTerm} months`
            };
        }
        
        return { error: false };
    }
    
    /**
     * Get interest rate based on loan type
     * 
     * @param {string} loanType - Type of loan
     * @return {number} Annual interest rate (decimal)
     */
    static getInterestRate(loanType) {
        const rates = {
            'development': 0.12, // 12% p.a.
            'school-fees': 0.12, // 12% p.a.
            'emergency': 0.12, // 12% p.a.
            'special': 0.05, // 5% per month
            'super-saver': 0.12, // 12% p.a.
            'salary-advance': 0.10 // 10% one-off
        };
        
        return rates[loanType];
    }
    
    /**
     * Calculate loan with reducing balance method (annual interest rate)
     * 
     * @param {number} principal - Loan amount
     * @param {number} term - Loan term in months
     * @param {number} annualRate - Annual interest rate (decimal)
     * @return {object} Loan calculation details
     */
    static calculateReducingBalanceLoan(principal, term, annualRate) {
        const monthlyRate = annualRate / 12;
        
        // Calculate monthly payment using the formula: P * r * (1 + r)^n / ((1 + r)^n - 1)
        const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, term) / (Math.pow(1 + monthlyRate, term) - 1);
        
        // Generate amortization schedule
        const schedule = [];
        let balance = principal;
        let totalInterest = 0;
        
        for (let month = 1; month <= term; month++) {
            const interestPayment = balance * monthlyRate;
            const principalPayment = monthlyPayment - interestPayment;
            balance -= principalPayment;
            
            totalInterest += interestPayment;
            
            schedule.push({
                month: month,
                payment: monthlyPayment,
                principal: principalPayment,
                interest: interestPayment,
                balance: Math.max(0, balance)
            });
        }
        
        return {
            principal: principal,
            term: term,
            annualInterestRate: annualRate,
            monthlyPayment: monthlyPayment,
            totalPayment: monthlyPayment * term,
            totalInterest: totalInterest,
            schedule: schedule
        };
    }
    
    /**
     * Calculate Special Loan (5% per month on reducing balance)
     * 
     * @param {number} principal - Loan amount
     * @param {number} term - Loan term in months
     * @return {object} Loan calculation details
     */
    static calculateSpecialLoan(principal, term) {
        const monthlyRate = 0.05; // 5% per month
        
        // Calculate monthly payment using the formula: P * r * (1 + r)^n / ((1 + r)^n - 1)
        const monthlyPayment = principal * monthlyRate * Math.pow(1 + monthlyRate, term) / (Math.pow(1 + monthlyRate, term) - 1);
        
        // Generate amortization schedule
        const schedule = [];
        let balance = principal;
        let totalInterest = 0;
        
        for (let month = 1; month <= term; month++) {
            const interestPayment = balance * monthlyRate;
            const principalPayment = monthlyPayment - interestPayment;
            balance -= principalPayment;
            
            totalInterest += interestPayment;
            
            schedule.push({
                month: month,
                payment: monthlyPayment,
                principal: principalPayment,
                interest: interestPayment,
                balance: Math.max(0, balance)
            });
        }
        
        return {
            principal: principal,
            term: term,
            monthlyInterestRate: monthlyRate,
            monthlyPayment: monthlyPayment,
            totalPayment: monthlyPayment * term,
            totalInterest: totalInterest,
            schedule: schedule
        };
    }
    
    /**
     * Calculate Salary Advance (10% one-off charge)
     * 
     * @param {number} principal - Loan amount
     * @param {number} term - Loan term in months
     * @return {object} Loan calculation details
     */
    static calculateSalaryAdvance(principal, term) {
        const oneOffCharge = principal * 0.10; // 10% one-off charge
        const totalPayment = principal + oneOffCharge;
        const monthlyPayment = totalPayment / term;
        
        // Generate payment schedule
        const schedule = [];
        let balance = principal;
        const principalPayment = principal / term;
        
        for (let month = 1; month <= term; month++) {
            let interestPayment = 0;
            if (month === 1) {
                interestPayment = oneOffCharge;
            }
            
            balance -= principalPayment;
            
            schedule.push({
                month: month,
                payment: monthlyPayment,
                principal: principalPayment,
                interest: interestPayment,
                balance: Math.max(0, balance)
            });
        }
        
        return {
            principal: principal,
            term: term,
            oneOffCharge: oneOffCharge,
            monthlyPayment: monthlyPayment,
            totalPayment: totalPayment,
            totalInterest: oneOffCharge,
            schedule: schedule
        };
    }
    
    /**
     * Get loan type display name
     * 
     * @param {string} loanType - Type of loan
     * @return {string} Display name for loan type
     */
    static getLoanTypeName(loanType) {
        const names = {
            'development': 'Development Loan',
            'school-fees': 'School Fees Loan',
            'emergency': 'Emergency Loan',
            'special': 'Special Loan',
            'super-saver': 'Super Saver Loan',
            'salary-advance': 'Salary Advance'
        };
        
        return names[loanType] || loanType;
    }
    
    /**
     * Get loan eligibility requirements
     * 
     * @param {string} loanType - Type of loan
     * @return {object} Eligibility requirements
     */
    static getLoanEligibilityRequirements(loanType) {
        const baseRequirements = {
            membershipPeriod: 6, // months
            minimumContributions: 12000, // KSh
            minimumShareCapital: 5000 // KSh
        };
        
        const specificRequirements = {
            'development': {
                description: 'For long-term development projects',
                maxAmount: 2000000,
                maxTerm: 36,
                interestRate: '12% p.a. on reducing balance',
                guarantors: 'Minimum 2-4 guarantors based on loan amount',
                documents: ['Pay slip', 'Bank statements (3 months)', 'ID copy', 'Project details/quotations']
            },
            'school-fees': {
                description: 'For education expenses',
                maxTerm: 12,
                interestRate: '12% p.a. on reducing balance',
                guarantors: 'Minimum 2 guarantors',
                documents: ['Pay slip', 'Fee structure/admission letter', 'ID copy', 'Bank statements (3 months)']
            },
            'emergency': {
                description: 'For unexpected urgent needs',
                maxAmount: 100000,
                maxTerm: 12,
                interestRate: '12% p.a. on reducing balance',
                guarantors: 'Minimum 2 guarantors',
                documents: ['Pay slip', 'ID copy', 'Evidence of emergency', 'Bank statements (3 months)']
            },
            'special': {
                description: 'Special short-term loan with no payslip consideration',
                maxAmount: 200000,
                termRange: '4-6 months',
                interestRate: '5% per month on reducing balance',
                guarantors: 'Minimum 2 guarantors',
                documents: ['ID copy', 'Post-dated cheques', 'Bank statements (3 months)']
            },
            'super-saver': {
                description: 'For members with deposits exceeding KSh 1,000,000',
                maxAmount: 3000000,
                maxTerm: 48,
                interestRate: '12% p.a. on reducing balance',
                minimumDeposits: 1000000,
                guarantors: 'Minimum 2-4 guarantors based on loan amount',
                documents: ['Pay slip', 'ID copy', 'Bank statements (3 months)']
            },
            'salary-advance': {
                description: 'Short-term advance on salary',
                maxTerm: 3,
                interestRate: '10% one-off charge for first month',
                guarantors: 'Minimum 1 guarantor',
                documents: ['Pay slip', 'ID copy', 'Employment confirmation']
            }
        };
        
        return {
            base: baseRequirements,
            specific: specificRequirements[loanType]
        };
    }
}

// Export the calculator for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarLoanCalculator;
}
