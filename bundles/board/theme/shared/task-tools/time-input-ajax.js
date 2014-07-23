mod.init(".w3T2t7XKGU", function() {
    
    var $container = $(this);
    $container.submit(function(event) {
        event.preventDefault();
        var time = $container.mod("formData");
        mod.call({
            cmd: "infuso/board/controller/task/doneTask",
            time: time,
            taskId: $container.attr("data:task")
        }, function() {
            $container.window("close");
        });
    });
    
});