$(function() {     
     
     $(".i95bnu5fvm").mod("init", function() {
     
        // Нажатие на задачу
        $(this).click(function(event) {
        
            // id задачи
            var id = $(this).attr("data:id");
        
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
                }
                return;
            }
        
            
            mod.fire("openTask",id);
        });
        
        // В начале перетаскивания добавляем в dataTransfer информацию о задача
        $(this).on("dragstart", function(e) {
            e.originalEvent.dataTransfer.setData("task-id", $(this).attr("data:id"));
        });
     
        // При наведении мыши показываем панель функций
        $(this).mouseenter(function() {
            $(this).find(".tools").animate({
                top: 0
            }, "fast");
        });
        
        // При уводе мыши скрываем панель функций
        $(this).mouseleave(function() {
            $(this).find(".tools").animate({
                top: 45
            }, "fast");
        });
        
     });
         
});