/**
 * Defer image load magic that replaces the placeholder markup with the actual
 * image either on wondow load or document ready based on configuration.
 */
(function ($) {
  // Decide whether to use window load or document ready
  $(document).ready(function(){
    if (Drupal.settings.deferImage != undefined) {
      if (Drupal.settings.deferImage.deferTiming == 'load') {
        $(window).load(function() {
          loadImages();
        });
      } else {
        loadImages();
      }
    }
  });

  // Creates an image element with all attributes passed from the placeholder
  // element.
  function loadImages() {
    var defer_class = '.' + Drupal.settings.deferImage.deferClass,
        $defer_img = $(defer_class);
    if ($defer_img.length) {
      $defer_img.each(function(){
        var $this = $(this),
            src = $(this).data('defer-src'),
            attrs = 'src="' + src + '" ';
        $.each($this.data(), function(index, value) {
          if (index.indexOf('defer-') != -1) {
            attrs += index.replace('defer-', '') + '="' + value + '" ';
          }
        });
        $this.removeClass(defer_class).html('<img ' + attrs + '/>');
      });
    }
  }
})(jQuery);
