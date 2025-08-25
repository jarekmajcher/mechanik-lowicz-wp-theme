import Swiper from "swiper/bundle";

document.addEventListener("DOMContentLoaded", () => {
  let sliders = document.querySelectorAll('.gSlider--slider');

  if(sliders.length) {
    Array.prototype.slice.call(sliders).forEach(function (slider, index) {
      let slider1 = slider.querySelector('.gSlider__slider1');

      let swiper1 = new Swiper(slider1, {
        loop: true,
        slidesPerView: 1,
        speed: 1000,
        effect: 'fade',
        fadeEffect: {
          crossFade: true
        },
        autoplay: {
          delay: 3000,
          disableOnInteraction: false
        },
        pagination: {
          el: ".swiper-pagination",
          type: "bullets",
          clickable: true
        },
      });
    });
  }
});
