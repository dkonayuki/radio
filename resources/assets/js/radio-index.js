$(document).ready(function() {
  $(".RadiosController.index").ready(function() {

    var container = document.querySelector("#radios-list");
    if (container != null) {
      var msnry = new Masonry( container, {
        // options
        "gutter": 20,
        "isFitWidth": true,
        itemSelector: ".radio-item"
      });
    }

  });

});
