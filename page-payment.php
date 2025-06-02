<?php
/**
 * The template for displaying the payment page with M-Pesa integration
 *
 * @package daystar-coop
 */

get_header();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Make Payment</h2>
                </div>
                <div class="card-body">
                    <!-- Error Messages Container -->
                    <?php if (isset($_SESSION['payment_errors'])): ?>
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['payment_errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['payment_errors']); ?>
                    <?php endif; ?>
                    
                    <!-- M-Pesa Payment Form -->
                    <form id="mpesaPaymentForm" method="post" action="<?php echo esc_url(home_url('process-payment')); ?>" class="needs-validation" novalidate>
                        <input type="hidden" name="action" value="mpesa_payment">
                        
                        <div class="mb-4">
                            <label for="paymentType" class="form-label">Payment Type</label>
                            <select class="form-select" id="paymentType" name="payment_type" required>
                                <option value="" selected disabled>Select payment type</option>
                                <option value="contribution">Monthly Contribution</option>
                                <option value="loan_repayment">Loan Repayment</option>
                                <option value="registration">Registration Fee</option>
                                <option value="other">Other Payment</option>
                            </select>
                            <div class="invalid-feedback">Please select a payment type</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="amount" class="form-label">Amount (KSh)</label>
                            <div class="input-group">
                                <span class="input-group-text">KSh</span>
                                <input type="number" class="form-control" id="amount" name="amount" min="1" step="1" required>
                                <div class="invalid-feedback">Please enter a valid amount</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">M-Pesa Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 0712345678" required>
                                <div class="invalid-feedback">Please enter a valid phone number</div>
                            </div>
                            <div class="form-text">Enter the phone number registered with M-Pesa</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="reference" class="form-label">Reference (Optional)</label>
                            <input type="text" class="form-control" id="reference" name="reference" placeholder="e.g., Invoice number, Member number">
                            <div class="form-text">Enter a reference for this payment if applicable</div>
                        </div>
                        
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="payButton">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="paySpinner" role="status" aria-hidden="true"></span>
                                Pay with M-Pesa
                            </button>
                        </div>
                        
                        <div class="payment-info">
                            <h5>How it works:</h5>
                            <ol>
                                <li>Enter your payment details and click "Pay with M-Pesa"</li>
                                <li>You will receive an STK push notification on your phone</li>
                                <li>Enter your M-Pesa PIN to authorize the payment</li>
                                <li>You will receive an M-Pesa confirmation message</li>
                                <li>Your payment will be processed and your account updated</li>
                            </ol>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- M-Pesa Logo and Security Info -->
            <div class="text-center mt-4">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mpesa-logo.png" alt="M-Pesa Logo" class="img-fluid mb-3" style="max-height: 60px;">
                <p class="text-muted small">
                    <i class="fas fa-lock me-1"></i> Your payment information is secure and encrypted.
                    Daystar Multi-Purpose Co-op Society Ltd. is an authorized M-Pesa partner.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Payment JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('mpesaPaymentForm');
    const payButton = document.getElementById('payButton');
    const paySpinner = document.getElementById('paySpinner');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            
            // Show loading spinner
            payButton.setAttribute('disabled', 'disabled');
            paySpinner.classList.remove('d-none');
            
            // Form is valid, allow submission
        });
    }
    
    // Format phone number
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            // Ensure it starts with 0
            if (value.length > 0 && value.charAt(0) !== '0') {
                value = '0' + value;
            }
            
            // Limit to 10 digits
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            
            this.value = value;
        });
    }
    
    // Set minimum amount based on payment type
    const paymentTypeSelect = document.getElementById('paymentType');
    const amountInput = document.getElementById('amount');
    
    if (paymentTypeSelect && amountInput) {
        paymentTypeSelect.addEventListener('change', function() {
            const paymentType = this.value;
            
            switch (paymentType) {
                case 'contribution':
                    amountInput.min = 2000;
                    amountInput.value = 2000;
                    break;
                case 'registration':
                    amountInput.min = 5000;
                    amountInput.value = 5000;
                    break;
                default:
                    amountInput.min = 1;
                    if (amountInput.value < 1) {
                        amountInput.value = '';
                    }
            }
        });
    }
});
</script>

<?php get_footer(); ?>
