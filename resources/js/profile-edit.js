// Profile edit functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const fileInput = document.querySelector('input[type="file"]');
    const allInputs = document.querySelectorAll('input, textarea');

    // Focus first input on page load
    if (allInputs.length > 0) {
        allInputs[0].focus();
    }

    // Image preview
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }
                
                // Check file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    this.value = '';
                    return;
                }
                
                console.log('Profile picture selected:', file.name);
            }
        });
    }

    // Form validation
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');

            // Validate required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '#ccc';
                }
            });

            // Validate email if provided
            const emailInput = document.querySelector('input[name="email"]');
            if (emailInput && emailInput.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    isValid = false;
                    emailInput.style.borderColor = '#dc3545';
                    alert('Please enter a valid email address');
                }
            }

            // Validate phone format
            const phoneInput = document.querySelector('input[name="phone"]');
            if (phoneInput && phoneInput.value.trim()) {
                const phoneRegex = /^[\d\s\-\+\(\)]+$/;
                if (!phoneRegex.test(phoneInput.value)) {
                    isValid = false;
                    phoneInput.style.borderColor = '#dc3545';
                    alert('Please enter a valid phone number');
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly');
            }
        });
    }

    // Remove error styling on input
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.style.borderColor = '#ccc';
        });
    });

    // Auto-format phone number
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Remove any non-digit characters except +, -, (, )
            let value = this.value.replace(/[^\d\s\-\+\(\)]/g, '');
            
            // Simple phone formatting
            if (value.length > 0) {
                this.value = value;
            }
        });
    }

    // Character counter for textarea
    const textarea = document.querySelector('textarea');
    if (textarea) {
        const maxLength = 500;
        
        // Add character counter
        const counter = document.createElement('div');
        counter.className = 'small-text';
        counter.style.textAlign = 'right';
        counter.textContent = `0 / ${maxLength} characters`;
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            counter.textContent = `${currentLength} / ${maxLength} characters`;
            
            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
                counter.textContent = `${maxLength} / ${maxLength} characters`;
                counter.style.color = '#dc3545';
            } else {
                counter.style.color = '#666';
            }
        });
    }
});
