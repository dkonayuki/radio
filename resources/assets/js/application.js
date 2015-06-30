$(document).ready(function() {
  window.CSRF_TOKEN = $("meta[name='csrf-token']").attr('content');

  $(document).on('click', '.close-notification', function(){
    $(this).parent().fadeOut(1000); // could use .remove(), .slideUp() etc
  });

  $("#radio-search").on("submit", function() {
    window.location.href = "/radios?query=" + $(this).find("input[name=query]").val();
    return false;
  });

  var engine = new Bloodhound({
    remote: {
      url: '/search?query=%QUERY',
      wildcard: '%QUERY'
    },
    datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace
  });

  engine.initialize();

  $("#radio-search input").typeahead(null, {
    displayKey: 'name',
    source: engine,
    name: 'radio-list',
    limit: 6,
    templates: {
      suggestion: function(data) {
        return "<a href=" + data.typeahead_url + ">" +
          "<img class='typeahead-img' src=" + data.typeahead_img + "></img>" + 
          "<div class='typeahead-content'>" +
            "<div class='typeahead-name'>" + data.name + "</div>" +
            "<div class='typeahead-des'>" + data.description + "</div>" +
          "</div>" +
        "</a>"
      },
      empty: [
        '<div class="tt-empty">Radio not found.</div>'
      ]
    }
  });

});
