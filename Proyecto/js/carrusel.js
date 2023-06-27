document.addEventListener("DOMContentLoaded", function() {
    var carousel = document.querySelector(".carousel");
    var slides = carousel.querySelectorAll(".carousel-item");
    var currentSlide = 0;
  
    function showSlide(slideIndex) {
      slides[currentSlide].classList.remove("active");
      slides[slideIndex].classList.add("active");
      currentSlide = slideIndex;
    }
  
    function goToSlide(offset) {
      var slideIndex = (currentSlide + offset + slides.length) % slides.length;
      showSlide(slideIndex);
    }
  
    function handlePrevClick() {
      goToSlide(-1);
    }
  
    function handleNextClick() {
      goToSlide(1);
    }
  
    function handleKeyDown(event) {
      if (event.key === "ArrowLeft") {
        handlePrevClick();
      } else if (event.key === "ArrowRight") {
        handleNextClick();
      }
    }
  
    var prevBtn = carousel.querySelector(".carousel-control-prev");
    var nextBtn = carousel.querySelector(".carousel-control-next");
  
    prevBtn.addEventListener("click", handlePrevClick);
    nextBtn.addEventListener("click", handleNextClick);
    document.addEventListener("keydown", handleKeyDown);
  });
  
