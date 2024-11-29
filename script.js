// Real-time form validation
document.addEventListener("DOMContentLoaded", function () {
    // Register form validation
    const registerForm = document.getElementById('registerForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const ageInput = document.getElementById('age');
    const submitButton = document.getElementById('registerSubmit');

    // Form validation before submit
    registerForm.addEventListener('submit', function (e) {
        let valid = true;

        if (usernameInput.value.trim() === "") {
            usernameInput.style.borderColor = "#f44336";
            valid = false;
        } else {
            usernameInput.style.borderColor = "#fff";
        }

        if (passwordInput.value.length < 6) {
            passwordInput.style.borderColor = "#f44336";
            valid = false;
        } else {
            passwordInput.style.borderColor = "#fff";
        }

        if (ageInput.value < 18) {
            ageInput.style.borderColor = "#f44336";
            valid = false;
        } else {
            ageInput.style.borderColor = "#fff";
        }

        if (!valid) {
            e.preventDefault();
            return false;
        }
    });

    // Live password feedback
    passwordInput.addEventListener('input', function () {
        if (passwordInput.value.length < 6) {
            passwordInput.setCustomValidity('Password should be at least 6 characters');
        } else {
            passwordInput.setCustomValidity('');
        }
    });
});
