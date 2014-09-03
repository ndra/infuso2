mod.init(".g5zzd98up9", function() {
    
    var $container = $(this);
    
    mod.on("board/taskChanged", function(data) {
        if(data.taskId == $container.attr("data:task")) {
            $container.html(data.toolbarLarge);
        }
    });
        
});
        