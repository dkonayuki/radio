$(document).ready(function() {
  var CSRF_TOKEN = $("meta[name='csrf-token']").attr('content');

  $('.radio-delete-btn').on('click', function() {
    var r = confirm("Are you sure?");
    if (r == true) {
      $.ajax({
        type: 'POST',
        url: $(this).attr('href'),
        data: {_method: 'DELETE', _token: CSRF_TOKEN},
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
