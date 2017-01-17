(function() {
    console.log('yep');

    $(document).on('change', '#select-article', function() {
        var articleId = $(this).find('option:selected').val();

        $.ajax({
            type : "GET",
            url :'./services/getArticle/' + articleId,
            dataType : 'json',
            cache : true,
            success: function(data){
                console.log(data);
                $('#article-edit-content').show();
                $('#input-article-edit-title').val(data.title);
                $('#textarea-article-edit-content').text(data.content);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            async : true
        });
    })
})();