mod.init(".aJU0yhVtJ6", function() {

    $container = $(this);
    $container.submit(function(event) {
        
        event.preventDefault();
        mod.call({
            cmd: "infuso/board/controller/task/problemTask",
            comment: $container.find("textarea").val(),
            taskId: $container.attr("data:task")
        }, function() {
            $container.window("close");
        })
        
    });

});