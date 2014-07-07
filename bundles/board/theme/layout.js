$(function() {

    $(".layout-slpod3n5sa").layout();
    
    // Открываеи задачу
    
    $(".layout-slpod3n5sa").on("board/openTask", function(event) {
        
        $(".task-container-slpod3n5sa").show();
    
        mod.call({
            cmd: "infuso/board/controller/task/getTask",
            taskId: event.taskId
        }, function(data) {
            $(".task-container-slpod3n5sa .ajax").html(data.html);
        });
    
    });
    
    var close = function() {
        
    }
    
});