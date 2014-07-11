$(function() {
    
    var $container = $(".layout-slpod3n5sa");

    $container.layout();
    
    // Разворачивает левую панель
    var expandLeft = function() {
        
        
    }
    
    // Сворачивает левую панель
    var collapseLeft = function() {
        
    }
    
    // Открываем задачу
    $container.on("board/openTask", function(event) {
        
        
        $(".layout-slpod3n5sa  > .left").html("");
    
        mod.call({
            cmd: "infuso/board/controller/task/getTask",
            taskId: event.taskId
        }, function(data) {
            $(".layout-slpod3n5sa > .left").html(data.html);
        });
    
    });
    
    var close = function() {
        $(".layout-slpod3n5sa  > .left").hide();
    }
    
    $(document).keydown(function(event) {
        if(event.which == 27) {
            close();
        }
    })
    
});