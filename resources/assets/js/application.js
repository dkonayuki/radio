$(document).ready(function() {

  $(document).on('click', '.close-notification', function(){
    $(this).parent().fadeOut(1000); // could use .remove(), .slideUp() etc
  });

  $("#radio-search").on("submit", function() {
  });

});
