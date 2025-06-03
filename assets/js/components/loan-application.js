/**
 * Daystar Multi-Purpose Co-op Society - Loan Application Module
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
                const nameAttr = input.getAttribute('name');
                const idAttr = input.getAttribute('id');
                
                if (nameAttr && nameAttr.match(/guarantor_\w+_\d+/)) {
                    const newName = nameAttr.replace(/\d+$/, index + 1);
                    input.setAttribute('name', newName);
                }
                
                if (idAttr && idAttr.match(/guarantor_\w+_\d+/)) {
                    const newId = idAttr.replace(/\d+$/, index + 1);
                    input.setAttribute('id', newId);
                }
            });
            
            // Update label for attributes
            const labels = field.querySelectorAll('label');
            labels.forEach(label => {
                const forAttr = label.getAttribute('for');
                
                if (forAttr && forAttr.match(/guarantor_\w+_\d+/)) {
                    const newFor = forAttr.replace(/\d+$/, index + 1);
                    label.setAttribute('for', newFor);
                }
            });
        });
    }
    
    /**
     * Update guarantor requirements based on loan type and amount
     * 
     * @param {HTMLElement} form - Loan application form element
     * @param {string} loanType - Selected loan type
     */
    static updateGuarantorRequirements(form, loanType) {
        const guarantorRequirement = form.querySelector('.guarantor-requirement');
        if (!guarantorRequirement) return;
        
        const requiredGuarantors = this.getRequiredGuarantors(loanType);
        guarantorRequirement.textContent = `This loan requires at least ${requiredGuarantors} guarantor(s).`;
        
        // Add initial guarantor fields if needed
        const guarantorSection = form.querySelector('.guarantor-section');
        if (!guarantorSection) return;
        
        const guarantorFields = guarantorSection.querySelectorAll('.guarantor-field');
        
        // Clear existing guarantor fields
        guarantorFields.forEach(field => field.remove());
        
        // Add minimum required guarantor fields
        for (let i = 0; i < requiredGuarantors; i++) {
            this.addGuarantorField(form);
        }
    }
    
    /**
     * Get required number of guarantors based on loan type and amount
     * 
     * @param {string} loanType - Type of loan
     * @param {number} loanAmount - Loan amount in KSh (optional)
     * @return {number} Required number of guarantors
     */
    static getRequiredGuarantors(loanType, loanAmount = 0) {
        switch (loanType) {
            case 'development':
                if (loanAmount > 1000000) return 4;
                if (loanAmount > 500000) return 3;
                return 2;
            case 'school-fees':
                return 2;
            case 'emergency':
                return 2;
            case 'special':
                return 2;
            case 'super-saver':
                if (loanAmount > 1500000) return 4;
                if (loanAmount > 750000) return 3;
                return 2;
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
            input.addEventListener('change', function() {
                const fileNameDisplay = this.nextElementSibling;
                if (fileNameDisplay && this.files.length > 0) {
                    fileNameDisplay.textContent = this.files[0].name;
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
        const documentsList = documentsSection.querySelector('.documents-list');
        
        if (documentsList) {
            let documentsHtml = '';
            
            requiredDocs.forEach(doc => {
                documentsHtml += `
                    <div class="mb-3">
                        <label for="${doc.fieldName}" class="form-label">${doc.label} ${doc.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="${doc.fieldName}" name="${doc.fieldName}" ${doc.required ? 'required' : ''}>
                            <span class="input-group-text file-name-display">No file chosen</span>
                        </div>
                        <div class="form-text">${doc.description}</div>
                    </div>
                `;
            });
            
            documentsList.innerHTML = documentsHtml;
            
            // Set up file upload fields
            this.setupFileUploadFields(form);
        }
    }
    
    /**
     * Get required documents based on loan type
     * 
     * @param {string} loanType - Type of loan
     * @return {Array} Required documents
     */
    static getRequiredDocuments(loanType) {
        const commonDocs = [
            {
                fieldName: 'id_copy',
                label: 'ID Copy',
                description: 'Upload a clear copy of your national ID (front and back)',
                required: true
            }
        ];
        
        const specificDocs = {
            'development': [
                {
                    fieldName: 'pay_slip',
                    label: 'Pay Slip',
                    description: 'Upload your latest pay slip (not older than 1 month)',
                    required: true
                },
                {
                    fieldName: 'bank_statements',
                    label: 'Bank Statements',
                    description: 'Upload your bank statements for the last 3 months',
                    required: true
                },
                {
                    fieldName: 'project_details',
                    label: 'Project Details/Quotations',
                    description: 'Upload project details, quotations, or invoices related to your development project',
                    required: true
                }
            ],
            'school-fees': [
                {
                    fieldName: 'pay_slip',
                    label: 'Pay Slip',
                    description: 'Upload your latest pay slip (not older than 1 month)',
                    required: true
                },
                {
                    fieldName: 'fee_structure',
                    label: 'Fee Structure/Admission Letter',
                    description: 'Upload the fee structure or admission letter from the educational institution',
                    required: true
                },
                {
                    fieldName: 'bank_statements',
                    label: 'Bank Statements',
                    description: 'Upload your bank statements for the last 3 months',
                    required: true
                }
            ],
            'emergency': [
                {
                    fieldName: 'pay_slip',
                    label: 'Pay Slip',
                    description: 'Upload your latest pay slip (not older than 1 month)',
                    required: true
                },
                {
                    fieldName: 'emergency_evidence',
                    label: 'Evidence of Emergency',
                    description: 'Upload documents supporting the emergency nature of your loan request',
                    required: true
                },
                {
                    fieldName: 'bank_statements',
                    label: 'Bank Statements',
                    description: 'Upload your bank statements for the last 3 months',
                    required: true
                }
            ],
            'special': [
                {
                    fieldName: 'post_dated_cheques',
                    label: 'Post-dated Cheques',
                    description: 'Upload images of post-dated cheques covering the loan period',
                    required: true
                },
                {
                    fieldName: 'bank_statements',
                    label: 'Bank Statements',
                    description: 'Upload your bank statements for the last 3 months',
                    required: true
                }
            ],
            'super-saver': [
                {
                    fieldName: 'pay_slip',
                    label: 'Pay Slip',
                    description: 'Upload your latest pay slip (not older than 1 month)',
                    required: true
                },
                {
                    fieldName: 'bank_statements',
                    label: 'Bank Statements',
                    description: 'Upload your bank statements for the last 3 months',
                    required: true
                }
            ],
            'salary-advance': [
                {
                    fieldName: 'pay_slip',
                    label: 'Pay Slip',
                    description: 'Upload your latest pay slip (not older than 1 month)',
                    required: true
                },
                {
                    fieldName: 'employment_confirmation',
                    label: 'Employment Confirmation',
                    description: 'Upload a letter confirming your current employment',
                    required: true
                }
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
        // In a real implementation, this would submit the form data to the server
        // For this demo, we'll show a success message
        
        // Show loading state
        const submitBtn = form.querySelector('[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
        
        // Simulate form submission
        setTimeout(() => {
            // Hide form
            form.style.display = 'none';
            
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'alert alert-success';
            successMessage.innerHTML = `
                <h4 class="alert-heading">Application Submitted Successfully!</h4>
                <p>Your loan application has been received and is being processed. You will receive a notification once it has been reviewed.</p>
                <hr>
                <p class="mb-0">Reference Number: DSL-${Date.now().toString().substring(6)}</p>
            `;
            
            form.parentNode.insertBefore(successMessage, form);
            
            // Add return to dashboard button
            const returnBtn = document.createElement('a');
            returnBtn.href = 'page-member-dashboard.php';
            returnBtn.className = 'btn btn-primary mt-3';
            returnBtn.textContent = 'Return to Dashboard';
            
            successMessage.appendChild(returnBtn);
        }, 2000);
    }
}

// Export the loan application for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DaystarLoanApplication;
}
