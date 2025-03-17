document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contactForm");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const messageInput = document.getElementById("message");
  const nameError = document.getElementById("nameError");
  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");
  const messageError = document.getElementById("messageError");

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    let isValid = true;

    // Validate Name
    if (!nameInput.value.trim() || nameInput.value.trim().length < 2) {
      nameError.textContent =
        "Please enter your full name (at least 2 characters)";
      nameError.classList.remove("hidden");
      isValid = false;
    } else {
      nameError.classList.add("hidden");
    }

    // Validate Email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailInput.value.trim() || !emailRegex.test(emailInput.value.trim())) {
      emailError.textContent = "Please enter a valid email address";
      emailError.classList.remove("hidden");
      isValid = false;
    } else {
      emailError.classList.add("hidden");
    }

    // Validate Phone Number
    const phoneRegex = /^[\d\s\-()]+$/;
    const digitsOnly = phoneInput.value.replace(/\D/g, "");
    if (
      !phoneInput.value.trim() ||
      !phoneRegex.test(phoneInput.value.trim()) ||
      digitsOnly.length < 10
    ) {
      phoneError.textContent =
        "Please enter a valid phone number (at least 10 digits)";
      phoneError.classList.remove("hidden");
      isValid = false;
    } else {
      phoneError.classList.add("hidden");
    }

    // Validate Message
    if (!messageInput.value.trim() || messageInput.value.trim().length < 10) {
      messageError.textContent =
        "Please enter a message (at least 10 characters)";
      messageError.classList.remove("hidden");
      isValid = false;
    } else {
      messageError.classList.add("hidden");
    }

    // If valid, show success message
    if (isValid) {
      alert("Your message has been sent successfully!");
      form.reset();
    }
  });

  // Clear errors on input
  nameInput.addEventListener("input", () => nameError.classList.add("hidden"));
  emailInput.addEventListener("input", () =>
    emailError.classList.add("hidden")
  );
  phoneInput.addEventListener("input", () =>
    phoneError.classList.add("hidden")
  );
  messageInput.addEventListener("input", () =>
    messageError.classList.add("hidden")
  );
});
