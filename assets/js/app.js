(function($) {
  var ourRequest = new XMLHttpRequest();
  ourRequest.open('GET', 'admin/xhrGetArticles');
  ourRequest.onload = function() {
    if (ourRequest.status >= 200 && ourRequest.status < 400) {
      var ourData = JSON.parse(ourRequest.responseText);
      console.log(ourData);
    } else {
      console.log("We connected to the server, but it returned an error.");
    }

    ourRequest.onerror = function() {
      console.log("Connection error");
    };
  };



  $('#insertArticle').submit(function() {
    var url = $(this).attr('action');
    var data = $(this).serialize();

    $.post(url, data, function(e) {
      $('#getArticles').append(data);
    });
    return false;
  });
})(jQuery);
