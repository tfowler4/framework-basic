(function() {
    console.log("here");

    // for testing switching teplates and ajax calls
    $('#test-template-selector').parent().find('li a').click(function(e) {
        e.preventDefault();

        console.log('clicked');
    });
})();
