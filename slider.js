document.addEventListener("DOMContentLoaded", function () {
  // Slider elements
  const slider = document.getElementById("slider");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  const dotsContainer = document.getElementById("sliderDots");

  // Get all slides
  const slides = slider.querySelectorAll('div[class^="w-full"]');
  const totalSlides = slides.length;

  // Calculate visible slides based on screen size
  function getVisibleSlides() {
    if (window.innerWidth >= 768) {
      return 4; // Desktop: 4 cards
    } else if (window.innerWidth >= 640) {
      return 2; // Tablet: 2 cards
    } else {
      return 1; // Mobile: 1 card
    }
  }

  let visibleSlides = getVisibleSlides();
  let currentIndex = 0;

  // Create dots for navigation
  function createDots() {
    dotsContainer.innerHTML = "";
    const totalDots = Math.ceil(totalSlides / visibleSlides);

    for (let i = 0; i < totalDots; i++) {
      const dot = document.createElement("button");
      dot.classList.add("w-3", "h-3", "rounded-full", "bg-gray-300");
      if (i === 0) {
        dot.classList.remove("bg-gray-300");
        dot.classList.add("bg-blue-900");
      }

      dot.addEventListener("click", () => {
        goToSlide(i * visibleSlides);
      });

      dotsContainer.appendChild(dot);
    }
  }

  // Update dots to reflect current position
  function updateDots() {
    const dots = dotsContainer.querySelectorAll("button");
    const activeDotIndex = Math.floor(currentIndex / visibleSlides);

    dots.forEach((dot, index) => {
      if (index === activeDotIndex) {
        dot.classList.remove("bg-gray-300");
        dot.classList.add("bg-blue-900");
      } else {
        dot.classList.remove("bg-blue-900");
        dot.classList.add("bg-gray-300");
      }
    });
  }

  // Go to specific slide
  function goToSlide(index) {
    const maxIndex = totalSlides - visibleSlides;
    currentIndex = Math.max(0, Math.min(index, maxIndex));

    // Calculate translation percentage based on current index and visible slides
    const slideWidth = 100 / visibleSlides;
    const translateValue = -currentIndex * slideWidth;

    slider.style.transform = `translateX(${translateValue}%)`;
    updateDots();

    // Update button states
    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex >= maxIndex;

    prevButton.style.opacity = currentIndex === 0 ? "0.5" : "1";
    nextButton.style.opacity = currentIndex >= maxIndex ? "0.5" : "1";
  }

  // Next slide
  function nextSlide() {
    goToSlide(currentIndex + visibleSlides);
  }

  // Previous slide
  function prevSlide() {
    goToSlide(currentIndex - visibleSlides);
  }

  // Event listeners
  prevButton.addEventListener("click", prevSlide);
  nextButton.addEventListener("click", nextSlide);

  // Handle window resize
  window.addEventListener("resize", function () {
    const newVisibleSlides = getVisibleSlides();
    if (newVisibleSlides !== visibleSlides) {
      visibleSlides = newVisibleSlides;
      createDots();
      goToSlide(0); // Reset to first slide
    }
  });

  // Initialize slider
  createDots();
  goToSlide(0);

  // Optional: Auto-slide functionality
  let autoSlideInterval;

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      if (currentIndex >= totalSlides - visibleSlides) {
        goToSlide(0);
      } else {
        nextSlide();
      }
    }, 5000); // Change slide every 5 seconds
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  // Start auto-sliding
  startAutoSlide();

  // Stop auto-sliding on hover or focus
  slider.parentElement.addEventListener("mouseenter", stopAutoSlide);
  slider.parentElement.addEventListener("mouseleave", startAutoSlide);
  slider.parentElement.addEventListener("focusin", stopAutoSlide);
  slider.parentElement.addEventListener("focusout", startAutoSlide);
});
