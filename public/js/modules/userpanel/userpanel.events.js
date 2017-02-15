(function() {
    $(document).on('mouseenter', '.settings-panel', function() {
        $(this).removeClass('panel-primary');
        $(this).addClass('panel-info');
    });

    $(document).on('mouseleave', '.settings-panel', function() {
        $(this).removeClass('panel-info');
        $(this).addClass('panel-primary');
    });

    $(document).on("click", 'div[data-toggle="collapse"]', function(){
        $('.collapse.in').collapse('hide');
    });

    $(document).on('click', '#deactivate-account', function() {
        $('#userpanel-modal').modal();

        userpanelServices.getDeactivationForm(function(data) {
            userpanel.populateDeactivateForm(data);
        });
    });
})();