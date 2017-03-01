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

    this.populateConsoleOutput = function(scriptName, data) {
        var icon = '';

        switch ( data.status ) {
            case 'success':
                icon = 'glyphicon glyphicon-ok-sign';
                break;
            case 'fail':
                icon = 'glyphicon glyphicon-exclamation-sign';
                break;
            default:
                icon = 'glyphicon glyphicon-warning-sign';
                break;
        }

        $('#console-output').val(scriptName + ' : ' + data.response);
        $('#console-output-icon').attr('class', icon + ' form-control-feedback');
    }

    this.updateScriptDescription = function(element) {
        var value       = element.val();
        var description = '';

        if ( value.length > 0 ) {
            $('#execute-script-btn').removeAttr('disabled');
            description = element.find('option:selected').data('description');
        } else {
            $('#execute-script-btn').attr('disabled', 'disabled');
            description = 'Script Description';
        }

        $('#script-description').text(description);
    }

    return self;
}());