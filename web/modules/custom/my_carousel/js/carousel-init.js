(function($, Drupal) {
  Drupal.behaviors.carouselInit = {
    attach: function(context, settings) {
      // Initialize carousels
      $('.carousel', context).each(function() {
        var carousel = new bootstrap.Carousel(this);
      });
    }
  };
})(jQuery, Drupal);