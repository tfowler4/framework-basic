var global = function(siteUrl, timestamp) {
    //siteUrl += 'public/js/modules/';

    //this.loadScript = function(fileName) {
        //$.getScript(siteUrl + fileName +'.js?v=' + timestamp, function( data, textStatus, jqxhr ) {});
    //}

    $(document).on('click', '#admin-nav', function() {
        $('#global-modal').modal();

        getLoginForm(function(data) {
            populateModal(data);
        });
    });

    $(document).on('click', '#admin-nav-out', function() {
        $('#global-modal').modal();

        getLogoutForm(function(data) {
            populateModal(data);
        });
    });

    $(document).on('click', '#logout-confirm', function() {
        logoutUser(function(data) {
            window.location.href = siteUrl;
        });
    });

    function getLoginForm(callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getLoginForm/',
            dataType : 'json',
            cache : true,
            success: function(data) {
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

    function getLogoutForm(callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getLogoutForm/',
            dataType : 'json',
            cache : true,
            success: function(data) {
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

    function logoutUser(callBack) {
        $.ajax({
            type : "GET",
            url :'./services/logoutUser/',
            cache : true,
            success: function(data) {console.log('success');
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            complete: function(data) {console.log('complete');
                $('#modal-spinner').hide();
            },
            async : true
        });
    }

    function populateModal(data) {
        $('#global-title').html(data.title);
        $('#global-body').html(data.body);
    }
}();