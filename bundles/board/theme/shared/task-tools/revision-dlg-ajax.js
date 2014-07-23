mod.init(".BHiplt1wyh", function() {

    $container = $(this);
    $container.submit(function(event) {
        
        event.preventDefault();
        mod.call({
            cmd: "infuso/board/controller/task/revisionTask",
            comment: $container.find("textarea").val(),
            taskId: $container.attr("data:task")
        }, function() {
            $container.window("close");
        })
        
    });

});