mod.init(".rcog1oiaxe", function() {
    
    var $container = $(this);
    //
    var load = function() {
        mod.call({
            cmd: "infuso/board/controller/log/content",
            taskId: $container.attr("data:task")
        }, function(html) {
            $container.find(".ajax").html(html);
        });
    }
    
    $container.layout();
    
    mod.on("board/log-changed", load);
    
});