// Login page functionality
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const loginForm = document.querySelector('form');

    // Focus phone input on page load
    if (phoneInput) {
        phoneInput.focus();
    }

    // Auto-format phone number
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Remove any non-digit characters
            let value = this.value.replace(/\D/g, '');
            
            // Format phone number (simple format)
            if (value.length > 0) {
                this.value = value;
            }
        });
    }

    // Form validation
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Validate phone
            if (phoneInput && !phoneInput.value.trim()) {
                isValid = false;
                phoneInput.style.borderColor = '#dc3545';
            } else if (phoneInput) {
                phoneInput.style.borderColor = '#ccc';
            }

            // Validate password
            if (passwordInput && !passwordInput.value.trim()) {
                isValid = false;
                passwordInput.style.borderColor = '#dc3545';
            } else if (passwordInput) {
                passwordInput.style.borderColor = '#ccc';
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    }

    // Remove error styling on input
    [phoneInput, passwordInput].forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                this.style.borderColor = '#ccc';
            });
        }
    });
});
