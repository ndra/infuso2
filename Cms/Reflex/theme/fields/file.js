$(function() {

    $(".l83i1tvf0u").mod("init", function() {
    
        var dropzone = $(this);
    
        $(this).on("dragover", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).addClass("drag-enter");
        });
        
        $(this).on("dragleave", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).removeClass("drag-enter");
        });
        
        $(this).on("drop", function(e) {
            e.stopPropagation();
            e.preventDefault();
            mod.msg("drop");
        });
        
        $(this).click(function() {
            $("body").window({
                call: {
                    cmd:"infuso/cms/reflex/controller/storage/getWindow",
                    editor: dropzone.attr("data:editor")
                }, events: {
                    selectFile:function(event,filename) {
                        $(this).mod().window("close");
                        dropzone.find("input").val(filename)
                    }
                }
            });
        });
    
    });

});