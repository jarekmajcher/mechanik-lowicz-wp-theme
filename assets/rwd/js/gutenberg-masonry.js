import Masonry from 'masonry-layout'
import GLightbox from 'glightbox'
import imagesLoaded from 'imagesloaded'

document.addEventListener("DOMContentLoaded", () => {
  let grids = document.querySelectorAll('.gMasonry');

  if(grids.length) {
    Array.prototype.slice.call(grids).forEach(function (grid, index) {

      let hasGutter = grid.classList.contains('gMasonry--gutter');

      // Mansory
      let masonryLayout = new Masonry(grid, {
        percentPosition: true,
        itemSelector: '.gMasonry__item',
        columnWidth: '.gMasonry__sizer',
        gutter: hasGutter ? 10 : 0
      });

      imagesLoaded(grid, function(instance) {
        masonryLayout.layout();
      });

      // Lioghtbox
      GLightbox({
        selector: '.gMasonry__item a',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
      });
    });
  }
});

