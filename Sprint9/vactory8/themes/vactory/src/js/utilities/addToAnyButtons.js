(function ($, Drupal) {
  "use strict";
  Drupal.vactory.utility.addToAnyButton = function () {
    $(document).scroll(function () {
      var buttons         = $('.vf-addtoany-fixed');
      var heightBanner    = $(".vf-banner").height();
      var heightSlider    = $(".vf-slider").height();
      var offsetTop = $(".vf-footer").offset() !== undefined ? $(".vf-footer").offset().top : 0;
      var offsetFooter = offsetTop > 0 ? offsetTop-($(".vf-footer").height()+buttons.height()*2) : 0;
      if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true ))
      {
        var  top = document.documentElement.scrollTop;
      }
      else
      {
        var  top = window.scrollY;
      } 
      if((top>=heightBanner || top>=heightSlider) && top<=offsetFooter){
        buttons.addClass('buttons-fixed');
        setTimeout(function(){ buttons.addClass('fade-left'); }, 300);
      }
      else {
        buttons.removeClass('buttons-fixed fade-left');
      }
    });
  }
})(jQuery, Drupal);