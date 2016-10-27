(function() {
    // for testing switching teplates and ajax calls
    $('.template-selector').click(function(e) {
        e.preventDefault();

        var layout = $(this).find('a').text().toLowerCase();
        var url    = site_url + 'session/template/' + layout;

        // ajax call to retrieve new encounter dropdown select html
         $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                location.reload();
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            },
            complete: function(data) {

            }
        });
    });
})();
