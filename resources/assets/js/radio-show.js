$(document).ready(function() {
  $(".RadiosController.show").ready(function() {

    $('#radio-delete-btn').on('click', function() {
      var r = confirm("Are you sure?");
      if (r == true) {
        $.ajax({
          type: 'POST',
          url: $(this).attr('href'),
          data: {_method: 'DELETE', _token: window.CSRF_TOKEN},
          success: function(data) {
            document.location.href = '/home';
          },
          error: function(XHR, message, errorThrown) {
            console.log(errorThrown);
          }
        });
      }

      return false;
    });

  });

});
