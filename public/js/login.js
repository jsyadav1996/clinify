document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    // Check if form exists
    if (!form) {
        console.error('Login form not found');
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
        clearError('password');
        return true;
    }

    function validateForm() {
        // Run all validations
        const emailValid = validateEmail();
        const passwordValid = validatePassword();
        
        // Return true only if all validations pass
        return emailValid && passwordValid;
    }

    // Real-time validation on blur
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);

    // Clear errors on input
    emailInput.addEventListener('input', function() {
        if (this.value.trim()) clearError('email');
    });
    
    passwordInput.addEventListener('input', function() {
        if (this.value) clearError('password');
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        // Clear all previous errors first
        clearError('email');
        clearError('password');
        
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
        return true;
    }, true); // Use capture phase to ensure our handler runs first
});

