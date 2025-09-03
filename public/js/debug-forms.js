// Debug script to log form submissions
document.addEventListener("DOMContentLoaded", function () {
    // Find all forms on the page
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            // Log form details
            console.log("Form submission intercepted:");
            console.log("Action: " + form.action);
            console.log("Method: " + form.method);

            // If the form is for payment verification, ensure it's using POST
            if (
                form.action.includes("/payments/") &&
                form.action.includes("/verify")
            ) {
                if (form.method.toUpperCase() !== "POST") {
                    console.error(
                        "Payment verification form is using incorrect method: " +
                            form.method
                    );
                    console.log("Forcing method to POST");
                    form.method = "post";
                }
            }
        });
    });
});
