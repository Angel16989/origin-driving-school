// scripts.js - Origin Driving School Online Management System
// Form validation and UI interactions

function validateRegistrationForm() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var license = document.getElementById('license_no').value;
    if (name === '' || email === '' || phone === '' || license === '') {
        alert('Please fill in all required fields.');
        return false;
    }
    // Simple email validation
    var re = /^\S+@\S+\.\S+$/;
    if (!re.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }
    return true;
}

// Calendar booking UI placeholder
function showCalendar() {
    alert('Calendar view coming soon!');
}
