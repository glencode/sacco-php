jQuery(document).ready(function($) {
    const form = $('#registrationForm');
    const submitBtn = $('#registerSubmit');
    const errorsDiv = $('#registrationErrors');
    const successDiv = $('#registrationSuccess');
    
    // Form validation
    form.validate({
        rules: {
            first_name: "required",
            last_name: "required",
            id_number: {
                required: true,
                minlength: 8
            },
            date_of_birth: "required",
            gender: "required",
            marital_status: "required",
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                pattern: /^(?:\+254|0)[17]\d{8}$/
            },
            physical_address: "required",
            city: "required",
            postal_code: "required",
            employment_status: "required",
            job_title: "required",
            monthly_income: {
                required: true,
                min: 0
            },
            kra_pin: {
                required: true,
                pattern: /^[A-Z]\d{9}[A-Z]$/
            },
            bank_name: "required",
            bank_branch: "required",
            account_number: "required",
            initial_contribution: {
                required: true,
                min: 12000
            },
            monthly_contribution: {
                required: true,
                min: 2000
            },
            password: {
                required: true,
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            terms_agreement: "required"
        },
        messages: {
            terms_agreement: "You must agree to the Terms and Conditions"
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") === "checkbox") {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        
        // Debug logging
        console.log('Form submitted');
        const formData = new FormData(this);
        console.log('Terms agreement value:', formData.get('terms_agreement'));
        console.log('All form data:', Object.fromEntries(formData));
        
        // Validate terms agreement
        if (!$('#terms_agreement').is(':checked')) {
            errorsDiv.removeClass('d-none').html('You must agree to the Terms and Conditions');
            return false;
        }
        
        if (!form.valid()) {
            console.log('Form validation failed');
            return false;
        }
        
        // Reset messages
        errorsDiv.addClass('d-none').html('');
        successDiv.addClass('d-none').html('');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
        
        // Add action to form data
        formData.append('action', 'daystar_register_member');
        
        // Submit form via AJAX
        $.ajax({
            url: daystarRegistration.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Registration response:', response);
                
                if (response.success) {
                    successDiv.removeClass('d-none').html(response.data.message);
                    form.hide();
                    
                    // Redirect to success page
                    setTimeout(function() {
                        window.location.href = `${daystarRegistration.homeUrl}/registration-success/?member=${encodeURIComponent(response.data.member_number)}`;
                    }, 1500);
                } else {
                    errorsDiv.removeClass('d-none').html(response.data.message);
                    submitBtn.prop('disabled', false).html('Register');
                }
            },
            error: function(xhr, status, error) {
                console.error('Registration error:', {xhr, status, error});
                errorsDiv.removeClass('d-none').html('An error occurred. Please try again.');
                submitBtn.prop('disabled', false).html('Register');
            }
        });
    });
    
    // Show/hide employer details based on employment status
    $("#employment_status").change(function() {
        if ($(this).val() === "employed" || $(this).val() === "business-owner") {
            $("#employerDetails").slideDown();
            $("#employer, #employment_duration").prop("required", true);
        } else {
            $("#employerDetails").slideUp();
            $("#employer, #employment_duration").prop("required", false);
        }
    });

    // Password strength indicator
    $("#password").on("input", function() {
        var password = $(this).val();
        var strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        var progressBar = $("#passwordStrength");
        var feedback = $("#passwordFeedback");
        
        switch(strength) {
            case 0:
            case 1:
                progressBar.css("width", "20%").removeClass().addClass("progress-bar bg-danger");
                feedback.text("Very Weak");
                break;
            case 2:
                progressBar.css("width", "40%").removeClass().addClass("progress-bar bg-warning");
                feedback.text("Weak");
                break;
            case 3:
                progressBar.css("width", "60%").removeClass().addClass("progress-bar bg-info");
                feedback.text("Medium");
                break;
            case 4:
                progressBar.css("width", "80%").removeClass().addClass("progress-bar bg-primary");
                feedback.text("Strong");
                break;
            case 5:
                progressBar.css("width", "100%").removeClass().addClass("progress-bar bg-success");
                feedback.text("Very Strong");
                break;
        }
    });
});
