jQuery(document).ready(function($) {
  var hoverIntentTimer;

  $('#wpadminbar').on({
    mouseenter: function() {
      clearTimeout(hoverIntentTimer);
      hoverIntentTimer = setTimeout(function() {
        $('#wpadminbar').addClass('active');
      }, 250);
    },
    mouseleave: function() {
      clearTimeout(hoverIntentTimer);
      hoverIntentTimer = setTimeout(function() {
        $('#wpadminbar').removeClass('active');
      }, 750);
    }
  });
});
