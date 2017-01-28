var globalServices = (function() {
    this.getLoginForm = function(callBack) {
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
    };

    this.getLogoutForm = function(callBack) {
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
    };

    this.logoutUser = function(callBack) {
        $.ajax({
            type : "GET",
            url :'./services/logoutUser/',
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
    };

    return self;
}());