class Carousel {
  constructor(target) {
    this.carousel = target;
    this.btnPrev = this.carousel.querySelector(".button-prev");
    this.btnNext = this.carousel.querySelector(".button-next");
    this.slideContainer = this.carousel.querySelector(".slide-container");

    this.currentIndex = 0;
    this.slideCount = this.slideContainer.children.length - 1;
    this.buttonPrev.addEventListener("click", this.previousSlide.bind(this));
    this.buttonNext.addEventListener("click", this.nextSlide.bind(this));
  }

  previousSlide() {}
  nextSlide() {}
}
