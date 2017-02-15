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

    $('#global-modal').on('hidden.bs.modal', function () {

    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip();

        $('body,html').animate({
            scrollTop: 0
            }, 800);
            return false;
        });

    $('#back-to-top').tooltip();
})();