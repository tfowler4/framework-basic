var global = function(siteUrl, timestamp) {
    siteUrl += 'public/js/modules/';

    this.loadScript = function(fileName) {
        $.getScript(siteUrl + fileName +'.js?v=' + timestamp, function( data, textStatus, jqxhr ) {});
    }
};