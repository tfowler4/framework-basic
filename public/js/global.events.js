(function() {
    $(document).on('click', '#login-nav', function() {
        $('#global-modal').modal();

        globalServices.getLoginForm(function(data) {
            global.populateModal(data);
        });
    });

    $(document).on('click', '#logout-nav', function() {
        $('#global-modal').modal();

        globalServices.getLogoutForm(function(data) {
            global.populateModal(data);
        });
    });

    $(document).on('click', '#logout-confirm', function() {
        var returnUrl = $(this).parent().parent().attr('action');

        globalServices.logoutUser(function(data) {
            window.location.href = returnUrl;
        });
    });
})();