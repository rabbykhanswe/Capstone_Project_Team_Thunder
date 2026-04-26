// OTP Input functionality
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpHidden = document.getElementById('otp_code_hidden');

    // Focus first input
    if (otpInputs.length > 0) {
        otpInputs[0].focus();
    }

    // Handle input for each OTP field
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Move to next input when current is filled
            if (this.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            
            // Update hidden field
            updateOtpHidden();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            
            // Fill inputs with pasted data
            for (let i = 0; i < pastedData.length && i < otpInputs.length; i++) {
                otpInputs[i].value = pastedData[i];
            }
            
            // Focus on appropriate input
            const nextEmptyIndex = Array.from(otpInputs).findIndex(input => input.value === '');
            if (nextEmptyIndex !== -1) {
                otpInputs[nextEmptyIndex].focus();
            } else {
                otpInputs[otpInputs.length - 1].focus();
            }
            
            updateOtpHidden();
        });
    });

    function updateOtpHidden() {
        if (otpHidden) {
            const otpValue = Array.from(otpInputs).map(input => input.value).join('');
            otpHidden.value = otpValue;
        }
    }
});
