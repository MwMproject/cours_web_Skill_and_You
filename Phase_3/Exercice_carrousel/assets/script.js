class Carousel {
  constructor(target) {
    this.carousel = target;
    this.btnPrev = this.carousel.querySelector(".button-prev");
    this.btnNext = this.carousel.querySelector(".button-next");
    this.slideContainer = this.carousel.querySelector(".slide-container");

    this.currentSlide = 0;
    this.slideCount = this.slideContainer.children.length - 1;
    this.btnPrev.addEventListener("click", this.previousSlide.bind(this));
    this.btnNext.addEventListener("click", this.nextSlide.bind(this));
  }

  previousSlide() {
    this.currentSlide -= 1;
    if (this.currentSlide < 0) {
      this.currentSlide = this.slideCount;
    }
    this.moveCarousel();
  }
  nextSlide() {
    this.currentSlide += 1;
    if (this.currentSlide > this.slideCount) {
      this.currentSlide = 0;
    }
    this.moveCarousel();
  }

  moveCarousel() {
    var position = 100 * this.currentSlide;
    this.slideContainer.style.transform = "translateX(-" + position + "%)";
  }
}

window.onload = function () {
  new Carousel(document.querySelector(".carousel"));
};
