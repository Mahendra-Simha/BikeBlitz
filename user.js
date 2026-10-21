document.addEventListener("DOMContentLoaded", function() {
    // Form validation for the registration form
    const accountForm = document.getElementById("accountForm");
    if (accountForm) {
        accountForm.addEventListener("submit", function(event) {
            if (!validateForm(accountForm)) {
                event.preventDefault();
            }
        });
    }

    // Form validation for the login form
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            if (!validateForm(loginForm)) {
                event.preventDefault();
            }
        });
    }

    // Function to validate form inputs
    function validateForm(form) {
        let valid = true;
        let errors = [];
        const inputs = form.querySelectorAll("input[required]");
        let firstInvalidInput = null;

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                valid = false;
                errors.push(input.name + " is required.");
                if (!firstInvalidInput) {
                    firstInvalidInput = input;
                }
            } else if (input.type === "password") {
                const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                if (!passwordPattern.test(input.value)) {
                    valid = false;
                    errors.push("Password must be at least 8 characters long and include at least one letter and one number.");
                    if (!firstInvalidInput) {
                        firstInvalidInput = input;
                    }
                }
            }
        });

        // Show all errors at once and focus on the first invalid input
        if (!valid) {
            alert(errors.join("\n"));
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }
        }

        return valid;
    }
});
