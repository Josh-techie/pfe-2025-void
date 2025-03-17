document.addEventListener("DOMContentLoaded", function () {
  const sliderWrapper = document.querySelector(".slider-wrapper");
  const slides = document.querySelectorAll(".slide");
  const dotsContainer = document.querySelector(".dots");
  const dots = document.querySelectorAll(".dots span");
  const slideCount = 3; // Corrected: Use only 3 slides
  const sliderContainer = document.querySelector(".slider-container");
  let slideIndex = 0;
  let containerWidth;
  let intervalId; // Store the interval ID for autoplay

  // Function to update the slider position
  function updateSlider() {
    containerWidth = sliderContainer.offsetWidth;
    sliderWrapper.style.transform = `translateX(-${
      slideIndex * containerWidth
    }px)`;

    // Remove active class from all dots and add to the current one
    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === slideIndex);
    });
  }

  // Function to go to a specific slide
  function goToSlide(index) {
    if (index >= 0 && index < slideCount) {
      slideIndex = index;
      updateSlider();
    }
  }

  // Function for automatic sliding
  function autoSlide() {
    slideIndex++;
    if (slideIndex >= slideCount) {
      slideIndex = 0; // Go back to the first slide
    }
    goToSlide(slideIndex);
  }

  // Function to start the autoplay interval
  function startAutoplay() {
    intervalId = setInterval(autoSlide, 5000); // Change slide every 5 seconds
  }

  // Function to stop the autoplay interval
  function stopAutoplay() {
    clearInterval(intervalId);
  }

  // Add click event listeners to the dots
  dots.forEach((dot) => {
    dot.addEventListener("click", () => {
      const slideNumber = parseInt(dot.dataset.slide);
      goToSlide(slideNumber);
      stopAutoplay(); // Stop autoplay when a dot is clicked
      startAutoplay(); // Restart autoplay after a dot is clicked
    });
  });

  window.addEventListener("resize", () => {
    updateSlider();
  });

  // Initialize the slider
  updateSlider();

  // Start autoplay
  startAutoplay();

  // mobile version toggle menu
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const navMenu = document.getElementById("nav-menu");

  mobileMenuButton.addEventListener("click", function () {
    navMenu.classList.toggle("hidden");
  });
});
