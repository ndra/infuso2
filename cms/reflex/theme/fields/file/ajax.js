mod.init(".rdwgX17MKs", function() {

    var $container = $(this);
    
    $container.find(".preview-container").click(function() {
        $(this).trigger("filebrowser");
    });
    
});