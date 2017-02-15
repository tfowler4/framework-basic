var admin = (function() {
    this.populateArticleForm = function(data) {
        $('#edit-article-pane').show();
        $('#edit-article-title').val(data.title);
        $('#edit-article-category').val(data.categoryId);
        $('#edit-article-content').text(data.content);
    }

    this.populateCategoryForm = function(data) {
        $('#edit-category-pane').show();
        $('#edit-category-name').val(data.name);
        $('#edit-category-meta').val(data.meta);
        $('#edit-category-articles').val(data.numOfArticles);
        $('#edit-category-primary-color').val(data.primaryColor);
        $('#edit-category-icon').val(data.icon);
        $('#edit-category-icon-preview i').attr('class', data.icon);

        $('#edit-category-primary-color').parent().find('.color-preview').css('background-color', '#' + data.primaryColor);
    }

    this.populateRemoveConfirmForm = function(id, data, type) {
        var confirmText = '';

        if ( type == 'article' ) {
            confirmText = 'Are you sure you want to remove the "' + data.title + '" article?';
        } else if ( type == 'category' ) {
            confirmText = 'Are you sure you want to remove the "' + data.name + '" category?';
        }

        $('#admin-modal').find('.modal-title').text('Confirmation');
        $('#confirm-text').text(confirmText);
        $('#remove-id').val(id);
        $('#modal-form').find('[type="submit"]').attr('value', 'remove-' + type);

        $('#admin-modal').modal('show');
    }

    return self;
}());