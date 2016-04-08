mod.init(".MTm5ivlmGC", function() {
    
    var $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var time = mod($container).formData();
        mod.call({
            cmd: "infuso/board/controller/task/stopTask",
            time: time,
            taskId: $container.attr("data:task")
        }, function() {
            $container.window("close");
        });
    });
    
});