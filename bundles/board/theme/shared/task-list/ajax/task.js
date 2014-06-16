$(function() {     
     
     $(".i95bnu5fvm").mod("init", function() {
     
        var task = $(this);
        
        // id задачи
        var id = $(this).attr("data:id");
     
        // Нажатие на задачу
        $(this).click(function(event) {
        
            var button = $(event.target).parents().andSelf().filter("input[type=button]");
            if(button.length) {
                switch(button[0].className) {
                    case "take":
                        mod.call({
                            cmd:"infuso/board/controller/task/takeTask",
                            taskId:id
                        });
                        break;
                    case "resume":
                        mod.call({
                            cmd:"infuso/board/controller/task/pauseTask",
                            taskId:id
                        });
                        break;
                    case "stop":
                        mod.call({
                            cmd:"infuso/board/controller/task/stopTask",
                            taskId:id
                        });
                        break;
                }
                return;
            }
            
            window.location.href = task.attr("data:url");
            
        });
        
        // В начале перетаскивания добавляем в dataTransfer информацию о задача
        $(this).on("dragstart", function(e) {
            e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
        });
     
        // При наведении мыши показываем панель функций
        $(this).mouseenter(function() {
            $(this).find(".tools").stop(true).animate({
                top: 0
            }, "fast");
        });
        
        // При уводе мыши скрываем панель функций
        $(this).mouseleave(function() {
            $(this).find(".tools").stop(true).animate({
                top: 45
            }, "fast");
        });
     
        // Перетаскивание файлов в браузер
    
        task.on("dragover", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).addClass("drag-enter");
        });
        
        task.on("dragleave", function(e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).removeClass("drag-enter");
        });
        
        task.on("drop", function(e) {
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
         
});