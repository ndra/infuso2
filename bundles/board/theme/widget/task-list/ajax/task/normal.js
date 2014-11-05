mod.init(".i95bnu5fvm", function() {
     
    var $task = $(this);
    
    // id задачи
    var id = $(this).attr("data:id");
 
    // Нажатие на задачу
    $task.click(function(event) {
        
        $(this).trigger({
            type: "board/openTask",
            taskId: id
        }); 
        
    });
    
    // В начале перетаскивания добавляем в dataTransfer информацию о задача
    $task.on("dragstart", function(e) {
        e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
    });
 
    // Перетаскивание файлов в браузер
    $task.on("dragover", function(e) {
        if(window.sortProcessing) {
            return;
        }
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass("drag-enter");
    });
    
    $task.on("dragleave", function(e) {
        if(window.sortProcessing) {
            return;
        }
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
    });
    
    $task.on("drop", function(e) {
        if(window.sortProcessing) {
            return;
        }
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("drag-enter");
        var file = e.originalEvent.dataTransfer.files[0];            
        mod.call({
            cmd:"infuso/board/controller/attachment/upload",
            taskId:id
        }, function() {}, {
            files: {
                file: file
            }
        });
        
    });
    
});