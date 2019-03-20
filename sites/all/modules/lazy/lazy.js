(function ($) {

  'use strict';

  Drupal.behaviors.lazy = {
    attach: function (context, settings) {
      var options = settings.lazy.bLazy ? settings.lazy.bLazy : {};
      new Blazy(options);
    }
  };

})(jQuery);
