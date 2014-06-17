mod.init(".sdqg1isQGi", function() {
    $container = $(this);
    $container.on("board/project-selector/select", function(event) {
        mod.call({
            cmd:"infuso/board/controller/task/newTask",
            data: {
                projectId: event.projectId
            }
        }, function(data) {
            window.location.href = data.url;
        });
    });
    
});
