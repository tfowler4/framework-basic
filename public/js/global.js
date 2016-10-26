(function() {
    console.log("here");

    // for testing switching teplates and ajax calls
    $('.template-selector').click(function(e) {
        e.preventDefault();

        var layout = $(this).find('a').text().toLowerCase();
        
        console.log('clicked: ' +layout);
    });
})();
