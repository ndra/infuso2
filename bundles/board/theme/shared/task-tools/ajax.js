mod(".ttbuu8389u").init(function() {
    
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
                case "pause":
                    mod.call({
                        cmd:"infuso/board/controller/task/pauseTask",
                        taskId:id
                    });
                    break;
                case "done":
                    $.window({
                        width: 800,
                        call: {
                            cmd: "infuso/board/controller/task/doneDlgContent",
                            taskId:id
                        }
                    });
                    break;
                case "resume":
                    mod.call({
                        cmd:"infuso/board/controller/task/pauseTask",
                        taskId:id
                    });
                    break;
                case "stop":
                    $.window({
                        width: 800,
                        call: {
                            cmd: "infuso/board/controller/task/stopDlgContent",
                            taskId:id
                        }
                    });
                    break;
                case "cancel":
                    mod.call({
                        cmd:"infuso/board/controller/task/cancelTask",
                        taskId:id
                    });
                    break;
                case "complete":
                    mod.call({
                        cmd:"infuso/board/controller/task/completeTask",
                        taskId:id
                    });
                    break;
                case "revision":
                    $.window({
                        call: {
                            cmd: "infuso/board/controller/task/revisionDlgContent",
                            taskId:id
                        }
                    });
                    break;
            }
            return;
        }
    
    });

});
    