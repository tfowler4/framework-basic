var adminServices = (function() {
    this.getArticle = function(articleId, callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getArticle/' + articleId,
            cache : true,
            dataType: 'json',
            success: function(data) {
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            async : true
        });
    }

    this.getCategory = function(categoryId, callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getCategory/' + categoryId,
            dataType : 'json',
            cache : true,
            success: function(data) {
                callBack(data);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            async : true
        });
    }

    return self;
}());