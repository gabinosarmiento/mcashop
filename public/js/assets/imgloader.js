(function() {
  // Wait for DOM to be ready
  document.addEventListener('DOMContentLoaded', function() {

    // Mark image as loaded
    function markAsLoaded(img) {
      img.classList.add('loaded');
    }

    // Process existing images
    document.querySelectorAll('.img-loading').forEach(function(img) {
      if (img.complete) {
        markAsLoaded(img);
      } else {
        img.addEventListener('load', function() {
          markAsLoaded(this);
        });
      }
    });

    // Listen for future images (event delegation)
    document.body.addEventListener('load', function(e) {
      if (e.target.classList.contains('img-loading')) {
        markAsLoaded(e.target);
      }
    }, true);

  });
})();