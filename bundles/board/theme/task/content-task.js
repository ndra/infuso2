mod.init(".ddksfajhjz", function() {

    var $container = $(this);
    
    var taskId = $container.attr("data:task");
    
    $container.find(".add-task").click(function() {
        $(this).trigger({
            type: "board/newTask",
            cloneTask: taskId
        });
    });

    // Перетаскивание файлов в браузер
    $container.on("dragover", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    $container.on("dragleave", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    $container.on("drop", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
        var file = e.originalEvent.dataTransfer.files[0];            
        mod.call({
            cmd:"infuso/board/controller/attachment/upload",
            taskId: $container.attr("data:task")
        }, function() {        
            $container.find(".c-attachments").triggerHandler("board/upload");        
        }, {
            files: {
                file: file
            }
        });
    });
    
    // При изменении задачи, перезагружаем
    mod.on("board/taskChanged", function(data) {
        $container.find(".comments-container").show();
    }, $container);

});