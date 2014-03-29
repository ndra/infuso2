$(function() {

    var dropzone = $(".l83i1tvf0u");
    
    dropzone.on("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    dropzone.on("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    dropzone.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        mod.msg("drop");
    });
    
    dropzone.click(function() {
        mod.msg("open filemanager");
    });

});