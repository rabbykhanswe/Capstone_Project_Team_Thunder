// Admin plants edit functionality
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide season field based on checkbox
    const seasonalCheckbox = document.querySelector('input[name="is_seasonal"]');
    const seasonGroup = document.getElementById('seasonGroup');

    if (seasonalCheckbox && seasonGroup) {
        seasonalCheckbox.addEventListener('change', function() {
            seasonGroup.style.display = this.checked ? 'block' : 'none';
            const seasonSelect = seasonGroup.querySelector('select');
            if (seasonSelect) {
                seasonSelect.required = this.checked;
            }
        });
    }

    // Price formatting
    const priceInput = document.querySelector('input[name="price"]');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    }

    // Stock validation
    const stockInput = document.querySelector('input[name="stock_count"]');
    if (stockInput) {
        stockInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    }

    // Image preview
    const imageInput = document.querySelector('input[name="image"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
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
                
                console.log('New image selected:', file.name);
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                } else {
                    field.classList.remove('error');
                }
            });

            // Validate price is positive
            if (priceInput && (parseFloat(priceInput.value) < 0 || isNaN(parseFloat(priceInput.value)))) {
                isValid = false;
                priceInput.classList.add('error');
                if (!firstInvalidField) firstInvalidField = priceInput;
            }

            // Validate stock is non-negative integer
            if (stockInput && (parseInt(stockInput.value) < 0 || isNaN(parseInt(stockInput.value)))) {
                isValid = false;
                stockInput.classList.add('error');
                if (!firstInvalidField) firstInvalidField = stockInput;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly');
                
                // Focus first invalid field
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
            }
        });
    }

    // Auto-save functionality (optional)
    let autoSaveTimer;
    const formInputs = document.querySelectorAll('input, textarea, select');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                console.log('Auto-save triggered...');
                // You can implement auto-save here if needed
            }, 30000); // Auto-save after 30 seconds of inactivity
        });
    });

    // Add error styling
    const style = document.createElement('style');
    style.textContent = `
        .error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25) !important;
        }
    `;
    document.head.appendChild(style);
});
