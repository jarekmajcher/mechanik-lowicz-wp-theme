import Swiper from 'swiper/bundle';

/**
 * Carousel
 */
document.addEventListener('DOMContentLoaded', function() {
  let carousels = document.querySelectorAll('.gLogos1__carousel');

  if(carousels.length) {
    Array.prototype.slice.call(carousels).forEach(function (carousel, index) {
      let swiper = new Swiper(carousel, {
        loop: true,
        slidesPerView: 1,
        centeredSlides: true,
        spaceBetween: 32,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        autoplay: {
          delay: 1000,
        },
        breakpoints: {
          767: {
            slidesPerView: 3,
          },
          1280: {
            slidesPerView: 6,
          },
        }
      });
    });
  }
});
