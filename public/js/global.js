var global = (function() {
    var siteUrl   = 'public/';
    var jsPath    = siteUrl + 'js/';
    var cssPath   = siteUrl + 'css/';
    var timestamp = Math.floor(Math.random() * 100000) + 0;

    this.loadScript = function(fileName) {
        $.getScript(jsPath + fileName +'.js?v=' + timestamp, function( data, textStatus, jqxhr ) {});
    };

    this.loadCSS = function(filePath) {
        $("<link/>", {
            rel: "stylesheet",
            type: "text/css",
            href: cssPath + filePath
        }).appendTo("head");
    };

    this.loadColorPicker = function() {
        this.loadCSS('pick-a-color/pick-a-color-1.2.3.min.css');

        $.getScript(jsPath + 'pick-a-color/pick-a-color-1.2.3.min.js', function( data, textStatus, jqxhr ) {
            $.getScript(jsPath + 'pick-a-color/tinycolor-0.9.15.min.js', function( data, textStatus, jqxhr ) {
                $('.pick-a-color').pickAColor();
            });
        });
    };

    this.loadTinyMCE = function() {
        $.getScript('//cdn.tinymce.com/4/tinymce.min.js', function( data, textStatus, jqxhr ) {
            tinymce.init({
                selector: 'textarea',
                height: 500,
                resize: false,
                theme: 'modern',
                plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
                image_advtab: true,
                content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
                ]
            });
        });
    };

    this.populateModal = function(data) {
        $('#global-title').html(data.title);
        $('#global-body').html(data.body);
    };

    this.loadScript('global.events');
    this.loadScript('global.services');

    return self;
}());