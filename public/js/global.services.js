var globalServices = (function() {
    this.exampleCall = function(callBack) {
        $.ajax({
            type: 'GET',
            url: '', // url of call
            dataType: 'json',
            cache: true,
            success: function(data) {
                /*
                    handle the successful ajax call
                 */
            },
            error: function(xhr, status, thrownError, error) {
                /*
                    handle the failure ajax call
                 */

                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {
                /*
                    handle the completion of the call regardless of success/error
                 */
            },
            async: true
        });
    };

    return self;
}());