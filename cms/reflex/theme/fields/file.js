$(function() {

    $(".l83i1tvf0u").mod("init", function() {
    
        var dropzone = $(this);
        
        // Перетаскивание файла в дропзону
    
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
        
        // Окно выбора файлов
        
        dropzone.click(function() {
            $.window({
                width:600,
                height: 400,
                call: {
                    cmd:"infuso/cms/reflex/controller/storage/getWindow",
                    editor: dropzone.attr("data:editor")
                }, events: {
                    selectFile:function(event,filename) {
                        $(this).window("close");
                        dropzone.find("input").val(filename)
                    }
                }
            });
        });
    
    });

});