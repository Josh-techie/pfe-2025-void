document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  const formStatus = document.getElementById("formStatus");

  // Get all form fields
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const messageInput = document.getElementById("message");
  const termsCheckbox = document.getElementById("terms");

  // Get all error message elements
  const nameError = document.getElementById("nameError");
  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");
  const messageError = document.getElementById("messageError");
  const termsError = document.getElementById("termsError");

  // Form submission event listener
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Reset previous errors
    resetErrors();

    // Validate form fields
    let isValid = true;

    // Validate name (not empty and at least 2 characters)
    if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
      showError(
        nameInput,
        nameError,
        "Please enter your full name (at least 2 characters)"
      );
      isValid = false;
    }

    // Validate email (using regex for basic validation)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailInput.value.trim() || !emailRegex.test(emailInput.value.trim())) {
      showError(emailInput, emailError, "Please enter a valid email address");
      isValid = false;
    }

    // Validate phone (only numbers, parentheses, dashes, and spaces, at least 10 digits)
    const phoneRegex = /^[\d\s\-()]+$/;
    const digitsOnly = phoneInput.value.replace(/\D/g, "");

    if (
      !phoneInput.value.trim() ||
      !phoneRegex.test(phoneInput.value.trim()) ||
      digitsOnly.length < 10
    ) {
      showError(
        phoneInput,
        phoneError,
        "Please enter a valid phone number (at least 10 digits)"
      );
      isValid = false;
    }

    // Validate message (not empty and at least 10 characters)
    if (!messageInput.value.trim() || messageInput.value.trim().length < 10) {
      showError(
        messageInput,
        messageError,
        "Please enter a message (at least 10 characters)"
      );
      isValid = false;
    }

    // Validate terms checkbox
    if (!termsCheckbox.checked) {
      showError(null, termsError, "You must agree to the terms and conditions");
      isValid = false;
    }

    // If all validations pass, show success message
    if (isValid) {
      // Show success message
      formStatus.classList.remove("hidden", "bg-red-100");
      formStatus.classList.add("bg-green-100", "text-green-800");
      formStatus.innerHTML =
        '<div class="flex items-center"><i class="fas fa-check-circle mr-2"></i> Your message has been sent successfully! We will get back to you soon.</div>';

      // Reset form
      form.reset();

      // You would typically send the form data to a server here
      console.log("Form submitted successfully");
    } else {
      // Show general error message
      formStatus.classList.remove("hidden", "bg-green-100");
      formStatus.classList.add("bg-red-100", "text-red-800");
      formStatus.innerHTML =
        '<div class="flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> Please fix the errors in the form before submitting.</div>';
    }
  });

  // Add input event listeners to clear errors when user types
  nameInput.addEventListener("input", function () {
    clearError(nameInput, nameError);
  });

  emailInput.addEventListener("input", function () {
    clearError(emailInput, emailError);
  });

  phoneInput.addEventListener("input", function () {
    clearError(phoneInput, phoneError);
  });

  messageInput.addEventListener("input", function () {
    clearError(messageInput, messageError);
  });

  termsCheckbox.addEventListener("change", function () {
    clearError(null, termsError);
  });

  // Helper function to show an error
  function showError(inputElement, errorElement, message) {
    if (inputElement) {
      inputElement.classList.add("border-red-500");
      inputElement.classList.add("bg-red-50");
    }
    errorElement.textContent = message;
    errorElement.classList.remove("hidden");
  }

  // Helper function to clear an error
  function clearError(inputElement, errorElement) {
    if (inputElement) {
      inputElement.classList.remove("border-red-500");
      inputElement.classList.remove("bg-red-50");
    }
    errorElement.textContent = "";
    errorElement.classList.add("hidden");

    // Also hide the general error message
    formStatus.classList.add("hidden");
  }

  // Helper function to reset all errors
  function resetErrors() {
    clearError(nameInput, nameError);
    clearError(emailInput, emailError);
    clearError(phoneInput, phoneError);
    clearError(messageInput, messageError);
    clearError(null, termsError);
    formStatus.classList.add("hidden");
  }
});
