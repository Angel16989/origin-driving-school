// Real-time form verification feedback
function showVerificationMessage(element, message, type = 'info') {
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        info: '#0056b3',
        warning: '#ffc107'
    };

    const icons = {
        success: '✅',
        error: '❌',
        info: 'ℹ️',
        warning: '⚠️'
    };

    const messageDiv = document.createElement('div');
    messageDiv.className = 'verification-message';
    messageDiv.innerHTML = `
        <div style="
            background: ${colors[type]}1a;
            color: ${colors[type]};
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        ">
            <span style="margin-right: 0.5rem">${icons[type]}</span>
            ${message}
        </div>
    `;

    // Remove any existing verification message
    const existing = element.parentNode.querySelector('.verification-message');
    if (existing) existing.remove();

    // Add new message
    element.parentNode.appendChild(messageDiv);

    // Highlight input
    element.style.borderColor = colors[type];
    element.style.boxShadow = `0 0 0 0.2rem ${colors[type]}33`;
}

// Add real-time verification for username
document.getElementById('username')?.addEventListener('input', function(e) {
    const username = this.value;
    if (username.length < 3) {
        showVerificationMessage(this, 'Username must be at least 3 characters', 'warning');
    } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        showVerificationMessage(this, 'Only letters, numbers, and underscores allowed', 'error');
    } else {
        showVerificationMessage(this, 'Username format is valid', 'success');
    }
});

// Add real-time verification for email
document.getElementById('email')?.addEventListener('input', function(e) {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!email) {
        showVerificationMessage(this, 'Email is required', 'warning');
    } else if (!emailRegex.test(email)) {
        showVerificationMessage(this, 'Please enter a valid email address', 'error');
    } else {
        showVerificationMessage(this, 'Email format is valid', 'success');
    }
});

// Add real-time verification for phone
document.getElementById('phone')?.addEventListener('input', function(e) {
    const phone = this.value;
    const phoneRegex = /^[\+]?[0-9\-\(\)\s]{10,}$/;
    
    if (!phone) {
        showVerificationMessage(this, 'Phone number is required', 'warning');
    } else if (!phoneRegex.test(phone)) {
        showVerificationMessage(this, 'Please enter a valid phone number', 'error');
    } else {
        showVerificationMessage(this, 'Phone number format is valid', 'success');
    }
});

// Check password strength in real-time
document.getElementById('password')?.addEventListener('input', function(e) {
    const password = this.value;
    let strength = 0;
    let message = '';

    // Length check
    if (password.length >= 8) strength++;
    // Uppercase check
    if (/[A-Z]/.test(password)) strength++;
    // Lowercase check
    if (/[a-z]/.test(password)) strength++;
    // Number check
    if (/[0-9]/.test(password)) strength++;
    // Special character check
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    switch(strength) {
        case 0:
        case 1:
            message = 'Very weak - add more variety';
            showVerificationMessage(this, message, 'error');
            break;
        case 2:
            message = 'Weak - try adding numbers or symbols';
            showVerificationMessage(this, message, 'warning');
            break;
        case 3:
            message = 'Medium - getting better!';
            showVerificationMessage(this, message, 'info');
            break;
        case 4:
            message = 'Strong - looking good!';
            showVerificationMessage(this, message, 'success');
            break;
        case 5:
            message = 'Very strong - excellent!';
            showVerificationMessage(this, message, 'success');
            break;
    }
});

// Check password match in real-time
document.getElementById('confirm_password')?.addEventListener('input', function(e) {
    const password = document.getElementById('password').value;
    const confirm = this.value;

    if (!confirm) {
        showVerificationMessage(this, 'Please confirm your password', 'warning');
    } else if (password !== confirm) {
        showVerificationMessage(this, 'Passwords do not match', 'error');
    } else {
        showVerificationMessage(this, 'Passwords match!', 'success');
    }
});