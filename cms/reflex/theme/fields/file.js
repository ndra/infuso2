mod.init(".l83i1tvf0u", function() {

    var $dropzone = $(this);
    
    // Перетаскивание файла в дропзону

    $dropzone.on("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    $dropzone.on("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    $dropzone.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        mod.msg("drop");
    });
    
    // Окно выбора файлов
    
    $dropzone.click(function() {
        
        var $wnd = $.window({
            width:800,
            height: 500,
            call: {
                cmd:"infuso/cms/reflex/controller/storage/getWindow",
                editor: $dropzone.attr("data:editor")
            }
        });
        
        $wnd.on("reflex/storage/file", function(event) {
            $wnd.window("close");
            $dropzone.find("input").val(event.filename);
            $dropzone.find("img").attr("src",event.preview150);
        });
        
    });

});