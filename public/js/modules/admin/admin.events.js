(function() {
    $(document).on('change', '#edit-article-id', function() {
        var articleId = $(this).find('option:selected').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        adminServices.getArticle(articleId, function(data) {
            admin.populateArticleForm(data);
        });
    });

    $(document).on('change', '#edit-category-id', function() {
        var categoryId = $(this).find('option:selected').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        adminServices.getCategory(categoryId, function(data) {
            admin.populateCategoryForm(data);
        });
    });

    $(document).on('click', '.select-edit-article', function() {
        var articleId = $('#edit-article-id').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        adminServices.getArticle(articleId, function(data) {
            admin.populateArticleForm(data);
        });
    });

    $(document).on('click', '.select-edit-category', function() {
        var categoryId = $('#edit-category-id').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        adminServices.getCategory(categoryId, function(data) {
            admin.populateCategoryForm(data);
        });
    });

    $(document).on('click', '.select-remove-article, .btn-remove-article', function() {
        var articleId = $('#edit-article-id').val();

        if ( articleId.length == 0 ) {
            return false;
        }

        adminServices.getArticle(articleId, function(data) {
            admin.populateRemoveConfirmForm(data.articleId, data, 'article');
        });
    });

    $(document).on('click', '.select-remove-category, .btn-remove-category', function() {
        var categoryId = $('#edit-category-id').val();

        if ( categoryId.length == 0 ) {
            return false;
        }

        adminServices.getCategory(categoryId, function(data) {
            admin.populateRemoveConfirmForm(data.categoryId, data, 'category');
        });
    });

    $(document).on('click', '.select-add-category', function() {
        $('#collapse-category').collapse('show');
        $('.collapse').not('#collapse-category').collapse('hide');

        $('[href="#category-add"').click();
    });

    $(document).on('keyup', '#create-category-icon, #edit-category-icon', function() {
        var value     = $(this).val();
        var previewId = '#' + $(this).attr('id') + '-preview';
        var preview   =  $(previewId + ' i');

        preview.attr('class', value);
    });

    $(document).on('change', '#site-maintenance-script', function() {
        admin.updateScriptDescription($(this));
    });

    $(document).on('click', '#execute-script-btn', function() {
        var scriptName = $('#site-maintenance-script').val();

        if ( scriptName.length == 0 ) {
            return false;
        }

        $('#loading-modal').modal();

        adminServices.runScript(scriptName, function(data) {
            setTimeout(function() {
                $('#loading-modal').modal('hide');
                admin.populateConsoleOutput(scriptName, data);
            }, 3000);
        });
    });
})();
