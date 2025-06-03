/**
 * Daystar Loan Application Module
 * 
 * This module provides loan application functionality specific to Daystar Multi-Purpose Co-op Society Ltd.
 * It implements the loan application process and validation rules as specified in the Daystar credit policy.
 */

class DaystarLoanApplication {
    /**
     * Initialize loan application form
     * 
     * @param {string} formId - ID of the loan application form
     * @param {string} loanType - Type of loan (optional, pre-selected loan type)
     */
    static initializeForm(formId, loanType = null) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        // Set up form validation
        this.setupFormValidation(form);
        
        // Pre-select loan type if provided
        if (loanType) {
            const loanTypeSelect = form.querySelector('[name="loan_type"]');
            if (loanTypeSelect) {
                loanTypeSelect.value = loanType;
                this.updateFormForLoanType(form, loanType);
            }
        }
        
        // Set up loan type change handler
        const loanTypeSelect = form.querySelector('[name="loan_type"]');
        if (loanTypeSelect) {
            loanTypeSelect.addEventListener('change', (e) => {
                this.updateFormForLoanType(form, e.target.value);
            });
        }
        
        // Set up guarantor fields
        this.setupGuarantorFields(form);
        
        // Set up file upload fields
        this.setupFileUploadFields(form);
    }
    
    /**
     * Set up form validation
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static setupFormValidation(form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Reset previous validation errors
            const errorElements = form.querySelectorAll('.error-message');
            errorElements.forEach(el => el.remove());
            
            // Validate form
            const isValid = this.validateForm(form);
            
            if (isValid) {
                // Submit form
                this.submitForm(form);
            }
        });
    }
    
    /**
     * Validate loan application form
     * 
     * @param {HTMLElement} form - Loan application form element
     * @return {boolean} Whether form is valid
     */
    static validateForm(form) {
        let isValid = true;
        
        // Validate personal information
        const personalFields = [
            { name: 'full_name', label: 'Full Name', required: true },
            { name: 'member_number', label: 'Member Number', required: true },
            { name: 'id_number', label: 'ID Number', required: true },
            { name: 'phone', label: 'Phone Number', required: true },
            { name: 'email', label: 'Email Address', required: true, type: 'email' },
            { name: 'employment_status', label: 'Employment Status', required: true }
        ];
        
        personalFields.forEach(field => {
            const input = form.querySelector(`[name="${field.name}"]`);
            if (!input) return;
            
            if (field.required && !input.value.trim()) {
                this.showValidationError(input, `${field.label} is required`);
                isValid = false;
            } else if (field.type === 'email' && !this.validateEmail(input.value)) {
                this.showValidationError(input, 'Please enter a valid email address');
                isValid = false;
            }
        });
        
        // Validate loan details
        const loanType = form.querySelector('[name="loan_type"]').value;
        const loanAmount = parseFloat(form.querySelector('[name="loan_amount"]').value);
        const loanTerm = parseInt(form.querySelector('[name="loan_term"]').value);
        
        // Check loan limits
        const limitCheck = this.checkLoanLimits(loanType, loanAmount, loanTerm);
        if (limitCheck.error) {
            this.showValidationError(form.querySelector('[name="loan_amount"]'), limitCheck.message);
            isValid = false;
        }
        
        // Validate guarantors
        const guarantorSection = form.querySelector('.guarantor-section');
        if (guarantorSection) {
            const guarantorFields = guarantorSection.querySelectorAll('.guarantor-field');
            const requiredGuarantors = this.getRequiredGuarantors(loanType, loanAmount);
            
            if (guarantorFields.length < requiredGuarantors) {
                this.showValidationError(
                    guarantorSection,
                    `This loan requires at least ${requiredGuarantors} guarantors`
                );
                isValid = false;
            }
            
            // Validate each guarantor's information
            guarantorFields.forEach((field, index) => {
                const nameInput = field.querySelector('[name^="guarantor_name"]');
                const memberNoInput = field.querySelector('[name^="guarantor_member_no"]');
                const idInput = field.querySelector('[name^="guarantor_id"]');
                const phoneInput = field.querySelector('[name^="guarantor_phone"]');
                
                if (!nameInput.value.trim()) {
                    this.showValidationError(nameInput, `Guarantor ${index + 1} name is required`);
                    isValid = false;
                }
                
                if (!memberNoInput.value.trim()) {
                    this.showValidationError(memberNoInput, `Guarantor ${index + 1} member number is required`);
                    isValid = false;
                }
                
                if (!idInput.value.trim()) {
                    this.showValidationError(idInput, `Guarantor ${index + 1} ID number is required`);
                    isValid = false;
                }
                
                if (!phoneInput.value.trim()) {
                    this.showValidationError(phoneInput, `Guarantor ${index + 1} phone number is required`);
                    isValid = false;
                }
            });
        }
        
        // Validate required documents
        const requiredDocs = this.getRequiredDocuments(loanType);
        requiredDocs.forEach(doc => {
            const fileInput = form.querySelector(`[name="${doc.fieldName}"]`);
            if (fileInput && !fileInput.files.length) {
                this.showValidationError(fileInput, `${doc.label} is required`);
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    /**
     * Show validation error message
     * 
     * @param {HTMLElement} element - Form element with error
     * @param {string} message - Error message
     */
    static showValidationError(element, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        errorElement.style.color = 'red';
        errorElement.style.fontSize = '0.875rem';
        errorElement.style.marginTop = '0.25rem';
        
        element.parentNode.appendChild(errorElement);
        element.classList.add('error');
    }
    
    /**
     * Validate email format
     * 
     * @param {string} email - Email address to validate
     * @return {boolean} Whether email is valid
     */
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    /**
     * Update form fields based on selected loan type
     * 
     * @param {HTMLElement} form - Loan application form element
     * @param {string} loanType - Selected loan type
     */
    static updateFormForLoanType(form, loanType) {
        // Update loan amount and term limits
        const limits = this.getLoanLimits(loanType);
        const loanAmountInput = form.querySelector('[name="loan_amount"]');
        const loanTermInput = form.querySelector('[name="loan_term"]');
        
        if (loanAmountInput) {
            loanAmountInput.max = limits.maxAmount;
            loanAmountInput.min = limits.minAmount || 1000;
            
            const amountHint = form.querySelector('.loan-amount-hint');
            if (amountHint) {
                amountHint.textContent = `Maximum: KSh ${limits.maxAmount.toLocaleString()}`;
            }
        }
        
        if (loanTermInput) {
            loanTermInput.max = limits.maxTerm;
            loanTermInput.min = limits.minTerm || 1;
            
            const termHint = form.querySelector('.loan-term-hint');
            if (termHint) {
                if (limits.minTerm) {
                    termHint.textContent = `Range: ${limits.minTerm}-${limits.maxTerm} months`;
                } else {
                    termHint.textContent = `Maximum: ${limits.maxTerm} months`;
                }
            }
        }
        
        // Update required guarantors
        this.updateGuarantorRequirements(form, loanType);
        
        // Update required documents
        this.updateRequiredDocuments(form, loanType);
        
        // Update loan purpose field
        const purposeField = form.querySelector('.loan-purpose-field');
        if (purposeField) {
            if (loanType === 'salary-advance') {
                purposeField.style.display = 'none';
            } else {
                purposeField.style.display = 'block';
            }
        }
        
        // Show/hide special loan fields
        const specialLoanFields = form.querySelector('.special-loan-fields');
        if (specialLoanFields) {
            if (loanType === 'special') {
                specialLoanFields.style.display = 'block';
            } else {
                specialLoanFields.style.display = 'none';
            }
        }
        
        // Show/hide super saver loan fields
        const superSaverFields = form.querySelector('.super-saver-fields');
        if (superSaverFields) {
            if (loanType === 'super-saver') {
                superSaverFields.style.display = 'block';
            } else {
                superSaverFields.style.display = 'none';
            }
        }
    }
    
    /**
     * Get loan limits based on loan type
     * 
     * @param {string} loanType - Type of loan
     * @return {object} Loan limits
     */
    static getLoanLimits(loanType) {
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
        
        return limits[loanType] || { maxAmount: 100000, maxTerm: 12 };
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
        const limits = this.getLoanLimits(loanType);
        
        if (loanAmount > limits.maxAmount) {
            return {
                error: true,
                message: `Maximum loan amount for this loan type is KSh ${limits.maxAmount.toLocaleString()}`
            };
        }
        
        if (loanTerm > limits.maxTerm) {
            return {
                error: true,
                message: `Maximum term for this loan type is ${limits.maxTerm} months`
            };
        }
        
        if (limits.minTerm && loanTerm < limits.minTerm) {
            return {
                error: true,
                message: `Minimum term for this loan type is ${limits.minTerm} months`
            };
        }
        
        return { error: false };
    }
    
    /**
     * Set up guarantor fields
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static setupGuarantorFields(form) {
        const addGuarantorBtn = form.querySelector('.add-guarantor-btn');
        if (!addGuarantorBtn) return;
        
        addGuarantorBtn.addEventListener('click', () => {
            this.addGuarantorField(form);
        });
    }
    
    /**
     * Add guarantor field to form
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static addGuarantorField(form) {
        const guarantorSection = form.querySelector('.guarantor-section');
        if (!guarantorSection) return;
        
        const guarantorFields = guarantorSection.querySelectorAll('.guarantor-field');
        const index = guarantorFields.length + 1;
        
        const guarantorField = document.createElement('div');
        guarantorField.className = 'guarantor-field mb-4 p-3 border rounded';
        
        guarantorField.innerHTML = `
            <h4 class="mb-3">Guarantor ${index}</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="guarantor_name_${index}" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="guarantor_name_${index}" name="guarantor_name_${index}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="guarantor_member_no_${index}" class="form-label">Member Number</label>
                    <input type="text" class="form-control" id="guarantor_member_no_${index}" name="guarantor_member_no_${index}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="guarantor_id_${index}" class="form-label">ID Number</label>
                    <input type="text" class="form-control" id="guarantor_id_${index}" name="guarantor_id_${index}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="guarantor_phone_${index}" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="guarantor_phone_${index}" name="guarantor_phone_${index}" required>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger remove-guarantor-btn">Remove Guarantor</button>
        `;
        
        guarantorSection.appendChild(guarantorField);
        
        // Set up remove button
        const removeBtn = guarantorField.querySelector('.remove-guarantor-btn');
        removeBtn.addEventListener('click', () => {
            guarantorField.remove();
            this.updateGuarantorLabels(form);
        });
    }
    
    /**
     * Update guarantor field labels after removal
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static updateGuarantorLabels(form) {
        const guarantorSection = form.querySelector('.guarantor-section');
        if (!guarantorSection) return;
        
        const guarantorFields = guarantorSection.querySelectorAll('.guarantor-field');
        guarantorFields.forEach((field, index) => {
            const heading = field.querySelector('h4');
            if (heading) {
                heading.textContent = `Guarantor ${index + 1}`;
            }
            
            // Update input IDs and names
            const inputs = field.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.name.replace(/\d+$/, index + 1);
                const id = input.id.replace(/\d+$/, index + 1);
                input.name = name;
                input.id = id;
                
                // Update associated label
                const label = field.querySelector(`label[for="${input.id.replace(/\d+$/, index)}"]`);
                if (label) {
                    label.setAttribute('for', id);
                }
            });
        });
    }
    
    /**
     * Update guarantor requirements based on loan type
     * 
     * @param {HTMLElement} form - Loan application form element
     * @param {string} loanType - Selected loan type
     */
    static updateGuarantorRequirements(form, loanType) {
        const guarantorSection = form.querySelector('.guarantor-section');
        if (!guarantorSection) return;
        
        const loanAmountInput = form.querySelector('[name="loan_amount"]');
        const loanAmount = loanAmountInput ? parseFloat(loanAmountInput.value) : 0;
        
        const requiredGuarantors = this.getRequiredGuarantors(loanType, loanAmount);
        const guarantorRequirement = guarantorSection.querySelector('.guarantor-requirement');
        
        if (guarantorRequirement) {
            guarantorRequirement.textContent = `This loan requires at least ${requiredGuarantors} guarantor(s).`;
        }
        
        // Add or remove guarantor fields as needed
        const guarantorFields = guarantorSection.querySelectorAll('.guarantor-field');
        const currentCount = guarantorFields.length;
        
        if (currentCount < requiredGuarantors) {
            // Add more guarantor fields
            for (let i = currentCount; i < requiredGuarantors; i++) {
                this.addGuarantorField(form);
            }
        }
    }
    
    /**
     * Get required number of guarantors based on loan type and amount
     * 
     * @param {string} loanType - Type of loan
     * @param {number} loanAmount - Loan amount in KSh
     * @return {number} Required number of guarantors
     */
    static getRequiredGuarantors(loanType, loanAmount) {
        switch (loanType) {
            case 'development':
                if (loanAmount > 1000000) {
                    return 4;
                } else if (loanAmount > 500000) {
                    return 3;
                } else {
                    return 2;
                }
            case 'super-saver':
                if (loanAmount > 1500000) {
                    return 4;
                } else if (loanAmount > 750000) {
                    return 3;
                } else {
                    return 2;
                }
            case 'salary-advance':
                return 1;
            default:
                return 2;
        }
    }
    
    /**
     * Set up file upload fields
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static setupFileUploadFields(form) {
        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                const fileName = e.target.files[0]?.name || 'No file chosen';
                const fileLabel = input.nextElementSibling;
                if (fileLabel && fileLabel.classList.contains('custom-file-label')) {
                    fileLabel.textContent = fileName;
                }
            });
        });
    }
    
    /**
     * Update required documents based on loan type
     * 
     * @param {HTMLElement} form - Loan application form element
     * @param {string} loanType - Selected loan type
     */
    static updateRequiredDocuments(form, loanType) {
        const documentsSection = form.querySelector('.documents-section');
        if (!documentsSection) return;
        
        const requiredDocs = this.getRequiredDocuments(loanType);
        
        // Hide all document fields first
        const allDocFields = documentsSection.querySelectorAll('.document-field');
        allDocFields.forEach(field => {
            field.style.display = 'none';
            const input = field.querySelector('input[type="file"]');
            if (input) {
                input.required = false;
            }
        });
        
        // Show required document fields
        requiredDocs.forEach(doc => {
            const field = documentsSection.querySelector(`.document-field[data-document="${doc.fieldName}"]`);
            if (field) {
                field.style.display = 'block';
                const input = field.querySelector('input[type="file"]');
                if (input) {
                    input.required = true;
                }
            }
        });
    }
    
    /**
     * Get required documents based on loan type
     * 
     * @param {string} loanType - Type of loan
     * @return {Array} Required documents
     */
    static getRequiredDocuments(loanType) {
        const commonDocs = [
            { fieldName: 'id_copy', label: 'ID Copy' }
        ];
        
        const specificDocs = {
            'development': [
                { fieldName: 'pay_slip', label: 'Pay Slip' },
                { fieldName: 'bank_statements', label: 'Bank Statements (3 months)' },
                { fieldName: 'project_details', label: 'Project Details/Quotations' }
            ],
            'school-fees': [
                { fieldName: 'pay_slip', label: 'Pay Slip' },
                { fieldName: 'bank_statements', label: 'Bank Statements (3 months)' },
                { fieldName: 'fee_structure', label: 'Fee Structure/Admission Letter' }
            ],
            'emergency': [
                { fieldName: 'pay_slip', label: 'Pay Slip' },
                { fieldName: 'bank_statements', label: 'Bank Statements (3 months)' },
                { fieldName: 'emergency_evidence', label: 'Evidence of Emergency' }
            ],
            'special': [
                { fieldName: 'bank_statements', label: 'Bank Statements (3 months)' },
                { fieldName: 'post_dated_cheques', label: 'Post-dated Cheques' }
            ],
            'super-saver': [
                { fieldName: 'pay_slip', label: 'Pay Slip' },
                { fieldName: 'bank_statements', label: 'Bank Statements (3 months)' }
            ],
            'salary-advance': [
                { fieldName: 'pay_slip', label: 'Pay Slip' },
                { fieldName: 'employment_confirmation', label: 'Employment Confirmation' }
            ]
        };
        
        return [...commonDocs, ...(specificDocs[loanType] || [])];
    }
    
    /**
     * Submit loan application form
     * 
     * @param {HTMLElement} form - Loan application form element
     */
    static submitForm(form) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        
        // In a real implementation, this would submit the form data to the server
        // For this demo, we'll simulate a successful submission after a delay
        setTimeout(() => {
            // Show success message
            form.innerHTML = `
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Application Submitted Successfully!</h4>
                    <p>Your loan application has been received and is being processed. You will receive a confirmation email shortly.</p>
                    <hr>
                    <p class="mb-0">Application Reference: ${this.generateReferenceNumber()}</p>
                </div>
                <div class="text-center mt-4">
                    <a href="page-member-dashboard.php" class="btn btn-primary">Return to Dashboard</a>
                </div>
            `;
        }, 2000);
    }
    
    /**
     * Generate a random reference number for the application
     * 
     * @return {string} Reference number
     */
    static generateReferenceNumber() {
        const prefix = 'DSL';
        const timestamp = new Date().getTime().toString().slice(-8);
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        return `${prefix}-${timestamp}-${random}`;
    }
}

// Export the application module for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarLoanApplication;
}
