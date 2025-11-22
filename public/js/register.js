document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');

    // Check if form exists
    if (!form) {
        console.error('Register form not found');
        return;
    }

    // Validation functions
    function showError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + '_error');
        const inputElement = document.getElementById(fieldId);
        
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
        
        if (inputElement) {
            inputElement.classList.add('error');
        }
    }

    function clearError(fieldId) {
        const errorElement = document.getElementById(fieldId + '_error');
        const inputElement = document.getElementById(fieldId);
        
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.classList.remove('show');
        }
        
        if (inputElement) {
            inputElement.classList.remove('error');
        }
    }

    function validateName() {
        const name = nameInput.value.trim();
        if (!name) {
            showError('name', 'Full name is required.');
            return false;
        }
        if (name.length < 2) {
            showError('name', 'Name must be at least 2 characters.');
            return false;
        }
        if (name.length > 255) {
            showError('name', 'Name must not exceed 255 characters.');
            return false;
        }
        clearError('name');
        return true;
    }

    function validateEmail() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            showError('email', 'Email address is required.');
            return false;
        }
        if (!emailRegex.test(email)) {
            showError('email', 'Please enter a valid email address.');
            return false;
        }
        if (email.length > 255) {
            showError('email', 'Email must not exceed 255 characters.');
            return false;
        }
        clearError('email');
        return true;
    }

    function validatePassword() {
        const password = passwordInput.value;
        
        if (!password) {
            showError('password', 'Password is required.');
            return false;
        }
        if (password.length < 8) {
            showError('password', 'Password must be at least 8 characters.');
            return false;
        }
        clearError('password');
        return true;
    }

    function validatePasswordConfirmation() {
        const password = passwordInput.value;
        const passwordConfirmation = passwordConfirmationInput.value;
        
        if (!passwordConfirmation) {
            showError('password_confirmation', 'Please confirm your password.');
            return false;
        }
        if (password !== passwordConfirmation) {
            showError('password_confirmation', 'Passwords do not match.');
            return false;
        }
        clearError('password_confirmation');
        return true;
    }

    function validateForm() {
        // Run all validations
        const nameValid = validateName();
        const emailValid = validateEmail();
        const passwordValid = validatePassword();
        const passwordConfirmationValid = validatePasswordConfirmation();
        
        // Return true only if all validations pass
        return nameValid && emailValid && passwordValid && passwordConfirmationValid;
    }

    // Real-time validation on blur
    nameInput.addEventListener('blur', validateName);
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);
    passwordConfirmationInput.addEventListener('blur', validatePasswordConfirmation);

    // Clear errors on input
    nameInput.addEventListener('input', function() {
        if (this.value.trim()) clearError('name');
    });
    
    emailInput.addEventListener('input', function() {
        if (this.value.trim()) clearError('email');
    });
    
    passwordInput.addEventListener('input', function() {
        if (this.value) {
            clearError('password');
            // Re-validate confirmation if it has a value
            if (passwordConfirmationInput.value) {
                validatePasswordConfirmation();
            }
        }
    });
    
    passwordConfirmationInput.addEventListener('input', function() {
        if (this.value) clearError('password_confirmation');
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        // Clear all previous errors first
        clearError('name');
        clearError('email');
        clearError('password');
        clearError('password_confirmation');
        
        // Validate all fields
        const isValid = validateForm();
        
        if (!isValid) {
            // Prevent form submission
            e.preventDefault();
            e.stopPropagation();
            
            // Scroll to first error
            const firstError = document.querySelector('.error-message.show');
            if (firstError) {
                const fieldId = firstError.id.replace('_error', '');
                const errorInput = document.getElementById(fieldId);
                if (errorInput) {
                    errorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => errorInput.focus(), 300);
                }
            }
            return false;
        }
        
        // If validation passes, allow form to submit naturally
        // (don't prevent default, just return true)
        return true;
    }, true); // Use capture phase to ensure our handler runs first
});

