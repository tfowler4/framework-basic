var adminServices = (function() {
    this.getArticle = function(articleId, callBack) {
        $.ajax({
            type: 'GET',
            url: './services/getArticle/' + articleId,
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

            },
            async: true
        });
    }

    this.getCategory = function(categoryId, callBack) {
        $.ajax({
            type: 'GET',
            url: './services/getCategory/' + categoryId,
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

            },
            async: true
        });
    }

    this.runScript = function(scriptName, callBack) {
        $.ajax({
            type: 'GET',
            url: './services/runScript/' + scriptName,
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

            },
            async: true
        });
    }

    return self;
}());