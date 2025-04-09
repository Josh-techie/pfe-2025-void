(function ($, Drupal) {
  // This is an Immediately Invoked Function Expression (IIFE)
  Drupal.behaviors.helloWorld = {
    // Defining a Drupal behavior
    attach: function (context, settings) {
      // The attach function
      $("body", context)
        .once("hello-world")
        .append("<p>" + Drupal.t("Hello, world!") + "</p>"); // The main logic
    },
  };
})(jQuery, Drupal); // Passing jQuery and Drupal objects to the IIFE

alert(Drupal.t("Hello World!"));
