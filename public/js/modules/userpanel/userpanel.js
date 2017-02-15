var userpanel = (function() {
    this.populateDeactivateForm = function(data) {
        $('#userpanel-modal .modal-title').html(data.title);
        $('#userpanel-modal .modal-body').html(data.body);
    }

    return self;
}());