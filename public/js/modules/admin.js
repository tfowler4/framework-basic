(function() {
    $(document).on('change', '#edit-article-id', function() {
        var articleId = $(this).find('option:selected').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        getArticle(articleId, function(data) {
            populateArticleForm(data);
        });
    });

    $(document).on('change', '#edit-category-id', function() {
        var categoryId = $(this).find('option:selected').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        getCategory(categoryId, function(data) {
            populateCategoryForm(data);
        });
    });

    $(document).on('click', '.select-edit-article', function() {
        var articleId = $('#edit-article-id').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        getArticle(articleId, function(data) {
            populateArticleForm(data);
        });
    });

    $(document).on('click', '.select-edit-category', function() {
        var categoryId = $('#edit-category-id').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        getCategory(categoryId, function(data) {
            populateCategoryForm(data);
        });
    });

    $(document).on('click', '.select-remove-article, .btn-remove-article', function() {
        var articleId = $('#edit-article-id').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        getArticle(articleId, function(data) {
            populateRemoveConfirmForm(data.articleId, data, 'article');
        });
    });

    $(document).on('click', '.select-remove-category, .btn-remove-category', function() {
        var categoryId = $('#edit-category-id').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        getCategory(categoryId, function(data) {
            populateRemoveConfirmForm(data.categoryId, data, 'category');
        });
    });

    $(document).on('click', '.select-add-category', function() {
        $('#collapse-category').collapse('show');
        $('.collapse').not('#collapse-category').collapse('hide');

        $('[href="#category-add"').click();
    });

    function getArticle(articleId, callBack) {
        $.ajax({
            type : "GET",
            url :'./services/getArticle/' + articleId,
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

    function populateArticleForm(data) {
        $('#edit-article-pane').show();
        $('#edit-article-title').val(data.title);
        $('#edit-article-category').val(data.categoryId);
        $('#edit-article-content').text(data.content);
    }

    function getCategory(categoryId, callBack) {
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

    function populateCategoryForm(data) {
        $('#edit-category-pane').show();
        $('#edit-category-name').val(data.name);
        $('#edit-category-meta').val(data.meta);
        $('#edit-category-articles').val(data.numOfArticles);
    }

    function populateRemoveConfirmForm(id, data, type) {
        var confirmText = '';

        if ( type == 'article' ) {
            confirmText = 'Are you sure you want to remove the "' + data.title + '" article?';
        } else if ( type == 'category' ) {
            confirmText = 'Are you sure you want to remove the "' + data.name + '" category?';
        }

        $('#adminModal').find('.modal-title').text('Confirmation');
        $('#confirmText').text(confirmText);
        $('#modalForm').find('input[name="id"]').val(id);
        $('#modalForm').find('[type="submit"]').attr('name', 'remove-' + type);

        $('#adminModal').modal('show');
    }
})();