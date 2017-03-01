var globalServices = (function() {
    this.getLoginForm = function(callBack) {
        $.ajax({
            type: 'GET',
            url: './services/getLoginForm/',
            dataType: 'json',
            cache: true,
            success: function(data) {
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {
                $('#modal-spinner').hide();
            },
            async: true
        });
    };

    this.getLogoutForm = function(callBack) {
        $.ajax({
            type: 'GET',
            url: './services/getLogoutForm/',
            dataType: 'json',
            cache: true,
            success: function(data) {
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {
                $('#modal-spinner').hide();
            },
            async: true
        });
    };

    this.logoutUser = function(callBack) {
        $.ajax({
            type: 'GET',
            url: './services/logoutUser/',
            cache: true,
            success: function(data) {
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {
                $('#modal-spinner').hide();
            },
            async: true
        });
    };

    return self;
}());