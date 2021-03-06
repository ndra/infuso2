mod.init(".hi31qru8zr", function() {

    var $container = $(this);
    
    // Загружает список фотографий
    var load = function() {
        mod.call({
            cmd:"infuso/board/controller/attachment/getAttachments",
            taskId: $container.attr("data:task")
        }, function(data) {
            $container.children(".ajax").html(data.html);
        });   
    }
    
    mod.on("board/task/attachments-changed", load, $container);
    
});