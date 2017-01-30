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
        globalServices.logoutUser(function(data) {
            window.location.href = global.siteUrl;
        });
    });
})();