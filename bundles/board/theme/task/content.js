mod.init(".ddksfajhjz", function() {

    var container = $(this);

    // Перетаскивание файлов в браузер
    container.on("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    container.on("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    container.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
        var file = e.originalEvent.dataTransfer.files[0];            
        mod.call({
            cmd:"infuso/board/controller/attachment/upload",
            taskId: container.attr("data:task")
        }, function() {        
            container.find(".c-attachments").triggerHandler("board/upload");        
        }, {
            files: {
                file: file
            }
        });
        
    });

});