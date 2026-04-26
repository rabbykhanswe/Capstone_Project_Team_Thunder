// Forgot password functionality
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="phone"]');
    
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

        // Focus phone input on page load
        phoneInput.focus();
    }
});
