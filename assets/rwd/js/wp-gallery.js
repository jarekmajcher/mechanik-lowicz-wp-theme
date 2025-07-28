import GLightbox from 'glightbox';

document.addEventListener('DOMContentLoaded', function() {

  /**
   * Lightbox
   */
  let galleryItems = document.querySelectorAll('.blocks-gallery-item');

  if(galleryItems.length > 0) {
    const lightbox = GLightbox({
      selector: '.blocks-gallery-item a',
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
    });
  }
});
