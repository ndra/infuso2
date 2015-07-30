mod.init(".l83i1tvf0u", function() {

    var $dropzone = $(this);
	var container = $(".l83i1tvf0u"); 
    var path = "/";
	
	var onLoad = function(ret) {   
		container.find("input").val(ret);
    }

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
	   
	   $(this).removeClass("drag-enter");
       var file = e.originalEvent.dataTransfer.files[0];  	
       mod.call({
            cmd:"infuso/cms/reflex/controller/storage/upload",
            editor: $dropzone.attr("data:editor"),
            path: path,
        }, onLoad, {
            files: {
                file: file
            },
        });
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