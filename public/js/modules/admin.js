(function() {
    console.log('yep');

   $(document).on('change', '#select-article', function() {
        var articleId = $(this).find('option:selected').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        $.ajax({
            type : "GET",
            url :'./services/getArticle/' + articleId,
            dataType : 'json',
            cache : true,
            success: function(data) {

                $('#article-edit-content').show();
                $('#input-article-edit-title').val(data.title);
                $('#select-article-edit-category').val(data.categoryId);
                $('#textarea-article-edit-content').text(data.content);
            },
            error: function(xhr, status, thrownError, error){
                // handle the error here
            },
            async : true
        });
    });
})();