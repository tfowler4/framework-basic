var userpanelServices = (function() {
    this.getDeactivationForm = function(callBack) {
        $.ajax({
            type: 'GET',
            url: './services/getDeactivationForm/',
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

    return self;
}());