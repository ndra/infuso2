$(function() {

    $(".ttbuu8389u").mod("init", function() {
    
        // Нажатие на задачу
        $(this).click(function(event) { 
        
            var id = $(this).attr("data:task");
        
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
        
            
            mod.fire("openTask",id);
        });
    
    });
        
});
        