var global = function(siteUrl, timestamp) {
    siteUrl += 'public/js/modules/';

    this.loadScript = function(fileName) {
        $.getScript(siteUrl + fileName +'.js?v=' + timestamp, function( data, textStatus, jqxhr ) {});
    }

    $(document).on('click', '#admin-nav2', function() {
        $('#global-modal').modal();

        getAdminForm(function(data) {
            populateModal(data);
        });
    });

    function getAdminForm(callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getAdminForm/',
            dataType : 'json',
            cache : true,
            success: function(data) {
                console.log('data');
                console.log(data);
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            complete: function(data) {
                $('#modal-spinner').hide();
            },
            async : true
        });
    }

    function populateModal(data) {
        $('#global-body').html(data);
    }
}();