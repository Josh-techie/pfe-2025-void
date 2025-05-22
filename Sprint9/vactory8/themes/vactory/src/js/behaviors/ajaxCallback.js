//== reskin select picker after ajax callback
//
//##
(function ($, Drupal, once) {
    "use strict";

    Drupal.behaviors.ajaxCallback = {
      attach: function(context, settings) {

        $(once('reSkinSelect', 'select', context)).each(function(){
          Drupal.vactory.utility.selectpicker();
        });

      }
    };

})(jQuery, Drupal, once);
