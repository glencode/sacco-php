/**
 * Daystar Multi-Purpose Co-op Society - M-Pesa Integration
 *
 * JavaScript functionality for M-Pesa payment integration
 */

/**
 * Initialize M-Pesa payment functionality
 */
function initMpesaPayment() {
  const mpesaForm = document.querySelector('.mpesa-payment-form');
  
  if (!mpesaForm) return;
  
  mpesaForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phoneNumber = mpesaForm.querySelector('#phone-number').value;
    const amount = mpesaForm.querySelector('#payment-amount').value;
    const purpose = mpesaForm.querySelector('#payment-purpose').value;
    
    // Basic validation
    if (!phoneNumber || !amount || !purpose) {
      showPaymentError('Please fill in all required fields.');
      return;
    }
    
    // Validate phone number format (Kenyan format: +254XXXXXXXXX or 07XXXXXXXX)
    const phoneRegex = /^(?:\+254|0)[17]\d{8}$/;
    if (!phoneRegex.test(phoneNumber)) {
      showPaymentError('Please enter a valid Kenyan phone number.');
      return;
    }
    
    // Validate amount
    if (isNaN(amount) || parseFloat(amount) <= 0) {
      showPaymentError('Please enter a valid amount.');
      return;
    }
    
    // Show loading state
    const submitButton = mpesaForm.querySelector('[type="submit"]');
    const originalText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Processing...';
    
    // Show payment processing modal
    showPaymentProcessingModal();
    
    // Here you would normally send an AJAX request to the server to initiate the M-Pesa payment
    // For now, we'll simulate the payment process
    setTimeout(function() {
      // Hide processing modal
      hidePaymentProcessingModal();
      
      // Reset button
      submitButton.disabled = false;
      submitButton.textContent = originalText;
      
      // Show success modal
      showPaymentSuccessModal();
      
      // Reset form
      mpesaForm.reset();
    }, 3000);
  });
  
  // Phone number formatting
  const phoneInput = mpesaForm.querySelector('#phone-number');
  if (phoneInput) {
    phoneInput.addEventListener('input', function() {
      // Remove non-numeric characters
      let value = this.value.replace(/\D/g, '');
      
      // Format as Kenyan phone number
      if (value.startsWith('254')) {
        // Keep as is if starts with country code
        this.value = '+' + value;
      } else if (value.startsWith('0')) {
        // Keep Kenyan format
        this.value = value;
      } else if (value.length > 0) {
        // Add leading zero if needed
        this.value = '0' + value;
      }
    });
  }
  
  // Initialize payment status checker
  initPaymentStatusChecker();
}

/**
 * Initialize payment status checker
 */
function initPaymentStatusChecker() {
  const statusChecker = document.querySelector('.payment-status-checker');
  
  if (!statusChecker) return;
  
  const checkButton = statusChecker.querySelector('.check-payment-status');
  const referenceInput = statusChecker.querySelector('#payment-reference');
  const statusDisplay = statusChecker.querySelector('.payment-status-display');
  
  if (checkButton && referenceInput && statusDisplay) {
    checkButton.addEventListener('click', function() {
      const reference = referenceInput.value.trim();
      
      if (!reference) {
        alert('Please enter a payment reference number.');
        return;
      }
      
      // Show loading state
      checkButton.disabled = true;
      checkButton.textContent = 'Checking...';
      statusDisplay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
      
      // Here you would normally send an AJAX request to check payment status
      // For now, we'll simulate the status check
      setTimeout(function() {
        // Reset button
        checkButton.disabled = false;
        checkButton.textContent = 'Check Status';
        
        // Show random status (for demo purposes)
        const statuses = [
          { status: 'completed', message: 'Payment completed successfully.' },
          { status: 'pending', message: 'Payment is being processed. Please check again later.' },
          { status: 'failed', message: 'Payment failed. Please try again or contact support.' }
        ];
        
        const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
        
        statusDisplay.innerHTML = `
          <div class="alert alert-${getStatusAlertClass(randomStatus.status)}">
            <strong>Status: ${randomStatus.status.toUpperCase()}</strong><br>
            ${randomStatus.message}
          </div>
        `;
      }, 2000);
    });
  }
}

/**
 * Show payment processing modal
 */
function showPaymentProcessingModal() {
  const modal = document.querySelector('#payment-processing-modal');
  
  if (!modal) {
    // Create modal if it doesn't exist
    const modalHTML = `
      <div class="modal fade" id="payment-processing-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body text-center p-4">
              <div class="spinner-border text-primary mb-3" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <h5>Processing Payment</h5>
              <p>Please wait while we process your payment request. You will receive an M-Pesa prompt on your phone shortly.</p>
              <p class="text-muted small">Do not close this window.</p>
            </div>
          </div>
        </div>
      </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
  }
  
  // Show modal
  $('#payment-processing-modal').modal({
    backdrop: 'static',
    keyboard: false
  });
}

/**
 * Hide payment processing modal
 */
function hidePaymentProcessingModal() {
  const modal = document.querySelector('#payment-processing-modal');
  
  if (modal) {
    $(modal).modal('hide');
  }
}

/**
 * Show payment success modal
 */
function showPaymentSuccessModal() {
  const modal = document.querySelector('#payment-success-modal');
  
  if (!modal) {
    // Create modal if it doesn't exist
    const modalHTML = `
      <div class="modal fade" id="payment-success-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body text-center p-4">
              <div class="success-icon mb-3">
                <i class="fas fa-check-circle text-success fa-4x"></i>
              </div>
              <h5>Payment Initiated Successfully</h5>
              <p>An M-Pesa payment request has been sent to your phone. Please check your phone and enter your PIN to complete the payment.</p>
              <p class="text-muted small">Your payment reference number: <strong>${generateRandomReference()}</strong></p>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
  }
  
  // Show modal
  $('#payment-success-modal').modal('show');
}

/**
 * Show payment error
 */
function showPaymentError(message) {
  const mpesaForm = document.querySelector('.mpesa-payment-form');
  
  if (!mpesaForm) return;
  
  let errorDiv = mpesaForm.querySelector('.payment-error');
  
  if (!errorDiv) {
    errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger payment-error';
    mpesaForm.prepend(errorDiv);
  }
  
  errorDiv.textContent = message;
  errorDiv.style.display = 'block';
  
  // Hide after 5 seconds
  setTimeout(function() {
    errorDiv.style.display = 'none';
  }, 5000);
}

/**
 * Get alert class based on payment status
 */
function getStatusAlertClass(status) {
  switch (status) {
    case 'completed':
      return 'success';
    case 'pending':
      return 'warning';
    case 'failed':
      return 'danger';
    default:
      return 'info';
  }
}

/**
 * Generate random payment reference number
 */
function generateRandomReference() {
  const prefix = 'DST';
  const timestamp = new Date().getTime().toString().slice(-6);
  const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
  
  return `${prefix}-${timestamp}-${random}`;
}

// Initialize M-Pesa payment when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  initMpesaPayment();
});
