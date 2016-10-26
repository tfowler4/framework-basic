(function() {
    console.log("here");

    $('#test-template-selector li a').click(function(e) {
        e.preventDefault();

        console.log('clicked');
    });
})();
