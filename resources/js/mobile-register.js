let registrationData = {};
let otpTimer = null;
let otpTimeRemaining = 120;

// Helper function to get CSRF token
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : null;
}

// Helper function to show detailed error
function showDetailedError(message, error = null) {
    console.error('Registration Error:', message, error);
    
    let errorMessage = message;
    if (error) {
        console.error('Full error details:', {
            name: error.name,
            message: error.message,
            stack: error.stack
        });
        
        if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
            errorMessage = 'Network connection failed. Please check your internet connection.';
        } else if (error.message.includes('419')) {
            errorMessage = 'CSRF token mismatch. Please refresh the page and try again.';
        } else if (error.message.includes('404')) {
            errorMessage = 'Registration endpoint not found. Please check the routes.';
        } else if (error.message.includes('500')) {
            errorMessage = 'Server error. Please try again later.';
        } else if (error.message.includes('422')) {
            errorMessage = 'Validation error. Please check your input.';
        }
    }
    
    showError(errorMessage);
}

document.getElementById('phoneRegistrationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const registerBtn = document.getElementById('registerBtn');
    const spinner = registerBtn.querySelector('.spinner');
    const originalText = registerBtn.innerHTML;
    
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value.trim();
    
    console.log('=== REGISTRATION ATTEMPT ===');
    console.log('Form data:', { firstName, lastName, phone, passwordLength: password.length });
    
    // Get CSRF token
    const csrfToken = getCsrfToken();
    console.log('CSRF Token:', csrfToken ? 'Found' : 'NOT FOUND');
    
    if (!csrfToken) {
        showDetailedError('CSRF token not found. Please refresh the page.');
        return;
    }
    
    if (phone.length !== 10) {
        showError('Please enter a valid 10-digit phone number');
        return;
    }
    
    if (password.length < 8) {
        showError('Password must be at least 8 characters');
        return;
    }
    
    hideError();
    registerBtn.disabled = true;
    spinner.style.display = 'inline-block';
    
    try {
        const requestData = {
            type: 'phone',
            phone: phone,
            password: password,
            first_name: firstName,
            last_name: lastName
        };
        
        console.log('Request data:', requestData);
        console.log('Sending to:', '/api/auth/register');
        
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        // Get response text first to see raw content
        const responseText = await response.text();
        console.log('Raw response:', responseText);
        
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('JSON Parse Error:', parseError);
            throw new Error(`Invalid JSON response: ${responseText.substring(0, 200)}`);
        }
        
        console.log('Parsed response data:', data);
        
        if (data.status === 'otp_sent') {
            registrationData = {
                type: 'phone',
                phone: phone,
                password: password,
                firstName: firstName,
                lastName: lastName
            };
            
            document.getElementById('phoneRegistrationForm').style.display = 'none';
            document.getElementById('otpSection').classList.add('show');
            
            showSuccess(data.message || 'OTP sent to your phone!');
            document.getElementById('otpCode').focus();
            
            startOtpTimer();
            
        } else {
            showDetailedError(data.message || 'Failed to send OTP');
        }
        
    } catch (error) {
        showDetailedError('Network error. Please try again.', error);
    } finally {
        registerBtn.disabled = false;
        spinner.style.display = 'none';
        registerBtn.innerHTML = originalText;
    }
});

function startOtpTimer() {
    otpTimeRemaining = 120;
    const timerDisplay = document.getElementById('otpTimer');
    const resendBtn = document.getElementById('resendOtpBtn');
    
    if (resendBtn) resendBtn.style.display = 'none';
    if (timerDisplay) {
        timerDisplay.textContent = '2:00';
        timerDisplay.classList.remove('expired');
    }
    
    if (otpTimer) clearInterval(otpTimer);
    
    otpTimer = setInterval(() => {
        otpTimeRemaining--;
        
        if (timerDisplay) {
            const minutes = Math.floor(otpTimeRemaining / 60);
            const seconds = otpTimeRemaining % 60;
            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (otpTimeRemaining <= 30) {
                timerDisplay.classList.add('expired');
            }
        }
        
        if (otpTimeRemaining <= 0) {
            clearInterval(otpTimer);
            if (timerDisplay) {
                timerDisplay.textContent = 'Expired';
                timerDisplay.classList.add('expired');
            }
            if (resendBtn) resendBtn.style.display = 'block';
        }
    }, 1000);
}

async function resendOTP() {
    const resendBtn = document.getElementById('resendOtpBtn');
    const spinner = resendBtn.querySelector('.spinner');
    const originalText = resendBtn.innerHTML;
    
    resendBtn.disabled = true;
    spinner.style.display = 'inline-block';
    hideError();
    
    try {
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            showDetailedError('CSRF token not found. Please refresh the page.');
            return;
        }
        
        const requestData = {
            type: registrationData.type,
            phone: registrationData.phone,
            password: registrationData.password,
            first_name: registrationData.firstName,
            last_name: registrationData.lastName
        };
        
        console.log('Resend OTP request:', requestData);
        
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        });
        
        const responseText = await response.text();
        console.log('Resend raw response:', responseText);
        
        const data = JSON.parse(responseText);
        console.log('Resend response:', data);
        
        if (data.status === 'otp_sent') {
            showSuccess('OTP resent successfully!');
            document.getElementById('otpCode').value = '';
            document.getElementById('otpCode').focus();
            startOtpTimer();
        } else {
            showDetailedError(data.message || 'Failed to resend OTP');
        }
        
    } catch (error) {
        showDetailedError('Network error. Please try again.', error);
    } finally {
        resendBtn.disabled = false;
        spinner.style.display = 'none';
        resendBtn.innerHTML = originalText;
    }
}

async function verifyOTP() {
    const otpInput = document.getElementById('otpCode');
    const verifyBtn = document.getElementById('verifyOtpBtn');
    const spinner = verifyBtn.querySelector('.spinner');
    const originalText = verifyBtn.innerHTML;
    const otp = otpInput.value.trim();
    
    if (otp.length !== 6) {
        showError('Please enter a valid 6-digit OTP');
        return;
    }
    
    verifyBtn.disabled = true;
    spinner.style.display = 'inline-block';
    hideError();
    
    try {
        const csrfToken = getCsrfToken();
        if (!csrfToken) {
            showDetailedError('CSRF token not found. Please refresh the page.');
            return;
        }
        
        const requestData = {
            type: registrationData.type,
            phone: registrationData.phone,
            otp: otp
        };
        
        console.log('Verify OTP request:', requestData);
        
        const response = await fetch('/api/auth/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        });
        
        const responseText = await response.text();
        console.log('Verify raw response:', responseText);
        
        const data = JSON.parse(responseText);
        console.log('Verify response:', data);
        
        if (data.status === 'success') {
            showSuccess(data.message + ' Redirecting...');
            if (otpTimer) clearInterval(otpTimer);
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showDetailedError(data.message || 'Invalid OTP. Please try again.');
        }
        
    } catch (error) {
        showDetailedError('Network error. Please try again.', error);
    } finally {
        verifyBtn.disabled = false;
        spinner.style.display = 'none';
        verifyBtn.innerHTML = originalText;
    }
}

function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.textContent = message;
    errorDiv.classList.add('show');
    setTimeout(() => hideError(), 5000);
}

function hideError() {
    document.getElementById('errorMessage').classList.remove('show');
}

function showSuccess(message) {
    const successDiv = document.getElementById('successMessage');
    successDiv.innerHTML = '<span>' + message + '</span>';
    successDiv.classList.add('show');
    setTimeout(() => {
        successDiv.classList.remove('show');
    }, 5000);
}
