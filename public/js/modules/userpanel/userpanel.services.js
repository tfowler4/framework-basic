var userpanelServices = (function() {
    this.getDeactivationForm = function(callBack) {
        console.log('getDeactivationForm');
        $.ajax({
            type : "GET",
            url :'./services/getDeactivationForm/',
            dataType : 'json',
            cache : true,
            success: function(data) {
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
    };

    return self;
}());