(function ($, Drupal) {
  "use strict";

  Drupal.vactory.utility.skinnedFileInput = function () {
    function appendInputFileLabel() {
      var _input_file_wrapper = $(".form-item.form-item-global-file,.form-item.form-item-document-file,.form-item.form-item-audio-file,.form-item.form-item-image-file,.form-item.form-item-video-file,.form-item.form-type-managed-file,.form-item.custom-form-file-wrapper");
      // Render label for input file on webform
      if(_input_file_wrapper.length) {
        _input_file_wrapper.each(function (index, item) {
          var _input_file = $(item).find('.form-file-input');
          var is_multiple = _input_file.attr('multiple');

          if (_input_file.length) {
            var $form_item = _input_file.parents('.form-item');
            $form_item.addClass('custom-form-file-wrapper');

            if (typeof is_multiple !== 'undefined' && is_multiple !== false) {
              $form_item.addClass('custom-multiple-file');
            }

            if($($form_item).find('.label-input-webform').length === 0 ) {
              $($form_item).find('.form-managed-file').append('<label class="label-input-webform">' + Drupal.t("Choisir mon fichier") +'</label>');
            }

            if($($form_item).find('span.file').length >= 1) {
              $($form_item).addClass('remove-file');
            } else if ($($form_item).hasClass('remove-file')) {
              $($form_item).removeClass('remove-file');
            }
          } else {
            $(item).addClass('remove-file custom-form-file-wrapper');
          }
        });
      }

      // if($('.form-item .form-file-input').length) {
      //   $('.form-item .form-file-input').each(function(index, item) {
      //     var $form_item = $(item).parents('.form-item');
      //     $form_item.addClass('custom-form-file-wrapper');

      //     if($($form_item).find('.label-input-webform').length === 0 ) {
      //       $($form_item).find('.form-managed-file').append('<label class="label-input-webform">' + Drupal.t("Choisir mon fichier") +'</label>');
      //     }
      //     if($($form_item).find('span.file').length >= 1) {
      //       $($form_item).addClass('remove-file');
      //     }
      //     else if ($($form_item).hasClass('remove-file')) {
      //       $($form_item).removeClass('remove-file');
      //     }
      //   });
      // }
    }

    $(document).on("ajaxComplete", appendInputFileLabel);
    appendInputFileLabel();

  };

})(jQuery, Drupal);