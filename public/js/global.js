(function() {
    console.log("here");

    // for testing switching teplates and ajax calls
    $('.template-selector').click(function(e) {
        e.preventDefault();

        var layout = $(this).find('a').text().toLowerCase();
        
        console.log('clicked: ' +layout);
        
        var url = location.hostname + '/session/template/' + layout;
        alert("The URL: " + url);
        // ajax call to retrieve new encounter dropdown select html
         $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                console.log('success: ' +data);
                location.reload();
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            },
            complete: function(data) {
                console.log("completed");   
            }
        });
    });
})();
